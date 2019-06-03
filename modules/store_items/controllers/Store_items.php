<?php
class Store_items extends Trongate {

	function testing(){
		if (true !== $route = array_search("/".$this->_mod_name()."/list/", CUSTOM_ROUTES)) {
			echo $route;
		}
				
	}
	
	function index(){
		$page_url = anchor($this->_mod_name().'/list', true);
		redirect($page_url);	
	}

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
		
		$modname = $this->_mod_name();
		$data['modname'] = $modname;
        $data['update_id'] = $update_id;
        $data['form_location'] = str_replace('/create', '/submit', current_url());
        $data['view_file'] = __FUNCTION__;
		$data['view_module'] = $modname;
		
        $this->template('public_milligram', $data);
    }

	function display($url_title){
		$data['modname'] = $this->_mod_name();
		// attempt to display a nice page
		$data['item'] = $this->model->get_one_where('url_title', $url_title, 'store_items');
		
		if ($data['item'] == false){
			$this->template('error_404');
			die();
		}else{
			$data['view_module'] = $this->_mod_name();
			$data['view_file'] = __FUNCTION__;
			$this->template('public_milligram', $data);
		}
	}
	function buynow($url_title){
		$data['modname'] = $this->_mod_name();
		// attempt to display a nice page
		$data['item'] = $this->model->get_one_where('url_title', $url_title, 'store_items');
		
		if ($data['item'] == false){
			$this->template('error_404');
			die();
		}else{
			$data['view_module'] = $this->_mod_name();
			$data['view_file'] = __FUNCTION__;
			$this->template('public_milligram', $data);
		}
	}	
    function update_image($update_id) {

		
		$modname = $this->_mod_name();
		$data['modname'] = $modname;
        //does the item have a picture?
        $data = $this->_fetch_data_from_db($update_id);
        $data['cancel_url'] = anchor($modname.'/create/'.$update_id, true);


        if ($data['picture'] == '') {

            //show the user an upload form
            $data['view_file'] = 'choose_picture';
			$data['view_module'] = $modname;
            $data['form_location'] = anchor($modname.'/submit_upload_picture/'.$update_id, true);
			
        } else {
			
            //show the user the picture with a delete btn
            $data['headline'] = 'Item '.$update_id.': '.$data['item_title'];
            $data['view_file'] = 'show_picture';
			$data['view_module'] = $modname;
            $data['form_location'] = anchor($modname.'/submit_delete_picture/'.$update_id, true);

        }

        $this->template('public_milligram', $data);
    }

	function manage(){
		$data['modname'] = $this->_mod_name();
		
		// Pagination Variables
		$count = $this->model->count('store_items');
		$data['count'] = $count;
		$limit = 10;
		$data['limit'] = $limit;
		$page_number = $this->url->segment(3);
		if ($count > $limit){
			if (is_numeric($page_number)){
					$page = $page_number;
				}else{
					$page = NULL;
			}	

			if ($page != NULL){
					$offset = $limit * ($page - 1);
			}else{
					$offset = NULL;
					$limit = NULL;
			}
			// Pagination start
			$data['total_rows'] = $count;
			$data['include_css'] = false; /* includes the framwork pagination css */
			$data['include_showing_statement'] = true;
			$data['record_name_plural'] = 'items';
			$data['num_links_per_page'] = 5;
			$data['limit '] = $limit;
			$data['pagination_css'] = true;
			// Pagination end			
		}else{
			$limit = NULL;
			$offset = NULL;
		}
		
		// MySQL query
		$data['rows'] = $this->model->get('id', 'store_items', $limit, $offset );
		$data['view_file'] = __FUNCTION__;
		$data['view_module'] = $this->_mod_name();
		$this->template('public_milligram', $data);
	}
	
	function list(){
		$data['modname'] = $this->_mod_name();
		
		// Pagination Variables
		$count = $this->model->count('store_items');
		$data['count'] = $count;
		$limit = 10;
		$data['limit'] = $limit;
		$page_number = $this->url->segment(3);
		if ($count > $limit){
			if (is_numeric($page_number)){
					$page = $page_number;
				}else{
					$page = NULL;
			}	

			if ($page != NULL){
					$offset = $limit * ($page - 1);
			}else{
					$offset = NULL;
					$limit = NULL;
			}
			// Pagination start
			$data['total_rows'] = $count;
			$data['include_css'] = false; /* includes the framwork pagination css */
			$data['include_showing_statement'] = true;
			$data['record_name_plural'] = 'items';
			$data['num_links_per_page'] = 5;
			$data['limit '] = $limit;
			$data['pagination_css'] = true;
			// Pagination end			
		}else{
			$limit = NULL;
			$offset = NULL;
		}
		
		// MySQL query
		$data['rows'] = $this->model->get('id', 'store_items', $limit, $offset );
		$data['view_file'] = 'listall';
		$data['view_module'] = $this->_mod_name();
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

            $target_url = anchor($this->_mod_name().'/create/'.$update_id, true);
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


				$target_url = anchor($this->_mod_name().'/update_image/'.$update_id, true);
				redirect($target_url);				

            } else {
                $this->update_image($update_id);
            }

        }
    }

    function submit() {

        $submit = $this->input('submit', true);

		$modname = $this->_mod_name();
		$data['modname'] = $modname;
        if ($submit == 'Submit') {

            $this->validation_helper->set_rules('item_title', 'item title', 'required|min_length[4]');
            $this->validation_helper->set_rules('item_price', 'item price', 'required|numeric|greater_than[0]');
            $this->validation_helper->set_rules('item_description', 'item description', 'required');

            $result = $this->validation_helper->run();

            if ($result == true) {

                $update_id = $this->url->segment(3);
                $data = $this->_fetch_data_from_post();
				$data['url_title'] =  url_title(strtolower($data['item_title']));
				
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
                $target_url = anchor($this->_mod_name().'/manage', true);
				redirect($target_url);				

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
            $target_url = anchor($this->_mod_name().'/manage', true);
            redirect($target_url);
        }

    }
	function _mod_name(){
		$mod_name = basename(dirname(dirname(__FILE__)));
		return $mod_name;
	}	

}