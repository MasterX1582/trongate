<?php 

Class Guitars extends Trongate {

	function create() {
		$data = $this->_fetch_data_from_post();
		$data['view_file'] = 'create';
		$this->template('public_milligram', $data);
	}

	function _fetch_data_from_post() {
		$data['item_title'] = $this->input('item_title', true);
		$data['item_price'] = $this->input('item_price', true);
		$data['item_description'] = $this->input('item_description', true);
		return $data;

	}

	function manage(){
		$data['rows'] = $this->model->get('id', 'store_items');
		$data['view_file'] = 'manage';
		$this->template('public_milligram', $data);
	}


	function submit(){
		// sending the form to guitars/submit
		$submit = $this->input('submit', true); // true trims the var thats been subitted, makes it safe

		// validation rules for the form
		if ($submit == 'Submit') {
			$this->validation_helper->set_rules('item_title', 'item title', 'required|min_length[4]');
			$this->validation_helper->set_rules('item_price', 'item price', 'required|numeric|greater_than[0]'); 
			$this->validation_helper->set_rules('item_description', 'item description', 'required'); 

			$result = $this->validation_helper->run();

			if ($result == true) {
				// insert the new sql record
				$data = $this->_fetch_data_from_post();
				$this->model->insert($data, 'store_items');
				// shows a message in green text when a record is created 
				$flash_msg = 'The record was successfully created';
				set_flashdata($flash_msg);
				redirect('guitars/manage');


			} else {
				// form submission error
				$this->create();
			}

		}
	}
}

 ?>