<?php
class Guitars extends Trongate {

    function create() {

        $update_id = $this->url->segment(3);

        if ((is_numeric($update_id)) && (REQUEST_TYPE == 'GET')) {
            $data = $this->_fetch_data_from_db($update_id);
        } else {
            $data = $this->_fetch_data_from_post();
        }

        if (is_numeric($update_id)) {
            $data['headline'] = 'Update Record';
        } else {
            $data['headline'] = 'Create New Record';
        }

        $data['update_id'] = $update_id;
        $data['form_location'] = str_replace('/create', '/submit', current_url());
        $data['view_file'] = 'create';
        $this->template('public_milligram', $data);
    }

    function update_image($update_id) {

        //does the item have a picture?
        $data = $this->_fetch_data_from_db($update_id);
        $data['cancel_url'] = str_replace('/update_image', '/create', current_url());

        if ($data['picture'] == '') {
            //show the user an upload form
            $data['view_file'] = 'choose_picture';
            $data['form_location'] = 'guitars/submit_upload_picture/'.$update_id;
        } else {
            //show the user the picture with a delete btn
            $data['headline'] = 'Item '.$update_id.': '.$data['item_title'];
            $data['view_file'] = 'show_picture';
            $data['form_location'] = 'guitars/submit_delete_picture/'.$update_id;
        }

        $this->template('public_milligram', $data);
    }

    function manage() {
        $data['rows'] = $this->model->get('id', 'store_items');
        $data['view_file'] = 'manage';
        $data['total_rows'] = 888;
        $data['include_css'] = true;
        $data['include_showing_statment'] = true;
        $data['record_name_plural'] = 'guitars';
        $this->template('public_milligram', $data);
    }

    function _fetch_data_from_db($update_id) {
        $result = $this->model->get_where($update_id, 'store_items');

        if ($result == false) {
            $this->template('error_404');
            die();
        } else {
            $data['item_title'] = $result->item_title;
            $data['item_price'] = $result->item_price;
            $data['item_description'] = $result->item_description;
            $data['picture'] = $result->picture;
            return $data;     
        }
    }

    function _fetch_data_from_post() {
        $data['item_title'] = $this->input('item_title', true);
        $data['item_price'] = $this->input('item_price', true);
        $data['item_description'] = $this->input('item_description', true);
        return $data;
    }

    function submit_delete_picture($update_id) {

        $submit = $this->input('submit', true);

        if ($submit == 'Delete Picture') {

            $data = $this->_fetch_data_from_db($update_id);
            $pictures_to_delete[] = './item_pictures/'.$data['picture'];
            $pictures_to_delete[] = './item_pictures/thumbs/'.$data['picture'];

            //attempt to delete main picture and thumbnail
            foreach ($pictures_to_delete as $picture_to_delete) {
                if (file_exists($picture_to_delete)) {
                    unlink($picture_to_delete);
                }
            }

            //update the database and redirect
            $data['picture'] = '';
            $this->model->update($update_id, $data, 'store_items');

            $flash_msg = 'The picture was successfully deleted';
            set_flashdata($flash_msg);

            $target_url = str_replace('/submit_delete_picture', '/create', current_url());
            redirect($target_url);
        }

    }

    function submit_upload_picture($update_id) {

        $submit = $this->input('submit', true);

        if ($submit == 'Upload') {

            $this->validation_helper->set_rules('picture', 'item picture', 'allowed_types[gif,jpg,jpeg,png]|max_size[2000]|max_width[900]|max_height[1200]');

            $result = $this->validation_helper->run(); //returns true or false

            if ($result == true) {
                
                $config['destination'] = 'item_pictures';
                $config['max_width'] = 300;
                $config['max_height'] = 350;

                $config['thumbnail_dir'] = 'item_pictures/thumbs';
                $config['thumbnail_max_width'] = 120;
                $config['thumbnail_max_height'] = 120;

                $this->upload_picture($config);

                $data['picture'] = $_FILES['picture']['name'];
                $this->model->update($update_id, $data, 'store_items');

                $flash_msg = 'The picture was successfully uploaded';
                set_flashdata($flash_msg);

                $target_url = str_replace('/submit_upload_picture', '/update_image', current_url());
                redirect($target_url);

            } else {
                $this->update_image($update_id);
            }

        }
    }

    function submit() {

        $submit = $this->input('submit', true);

        if ($submit == 'Submit') {

            $this->validation_helper->set_rules('item_title', 'item title', 'required|min_length[4]');
            $this->validation_helper->set_rules('item_price', 'item price', 'required|numeric|greater_than[0]');
            $this->validation_helper->set_rules('item_description', 'item description', 'required');

            $result = $this->validation_helper->run();

            if ($result == true) {

                $update_id = $this->url->segment(3);
                $data = $this->_fetch_data_from_post();

                if (is_numeric($update_id)) {
                    //update an existing record
                    $this->model->update($update_id, $data, 'store_items');
                    $flash_msg = 'The record was successfully updated';
                } else {
                    //insert the new record
                    $this->model->insert($data, 'store_items');
                    $flash_msg = 'The record was successfully created';
                }
    
                set_flashdata($flash_msg);
                redirect('guitars/manage');

            } else {
                //form submission error
                $this->create();
            }

        } elseif ($submit == 'Delete') {
            //delete the record and send back to manage page
            $update_id = $this->url->segment(3);
            $this->model->delete($update_id, 'store_items');
            $flash_msg = 'The record was successfully deleted';

            set_flashdata($flash_msg);
            redirect('guitars/manage');
        }

    }

}