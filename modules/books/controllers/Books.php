<?php

class Books extends Trongate
{

    public function index()
    {
        $data['view_module'] = 'welcome';
        $data['view_file'] = 'test';
        $this->template('public_skeleton', $data); //pass data into template
        //$this->view('index'); referencing the index.php file in the views folder
    }

    public function bye_now() {
       $data['view_module'] = 'cart';
       $data['view_file'] = 'checkout';	
       $this->template('public_skeleton', $data);
    }

}
