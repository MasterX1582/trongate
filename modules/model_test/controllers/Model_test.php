<?php 
class Model_test extends Trongate {
    // function index() {

        // for ($i=1; $i <= 400; $i++) { 
            // $row_data['id'] = '';
            // $row_data['title'] = 'Record '.$i;
            // $row_data['date_created'] = time();
            // $data[] = $row_data;
        // }

        // $this->model->insert_batch('test', $data);
        // echo 'Finished';

    // }
    // function index() {

        // $rows = $this->model->get('item_title desc','store_items');
		// foreach ($rows as $row){
			// echo $row->id.'<br>';
			// echo $row->item_title.'<hr>';
		// }

    // }
    // function index() {
    //     $rows = $this->model->get('item_title desc');
    //     foreach ($rows as $row) {
    //         echo $row->id.'<br>';
    //         echo $row->item_title.'<hr>';
    //     }
    // }

    // function index() {
        // $rows = $this->model->get_where_custom('id', 17, '>', 'item_title', 'store_items');
        // foreach ($rows as $row) {
            // echo $row->id.'<br>';
            // echo $row->item_title.'<hr>';
        // }
    // }

    // function index() {
        // $item = $this->model->get_where(1);
        // echo $item->item_title;
    // }

    // function index() {
        // $item = $this->model->get_one_where('item_title', 'First Item', 'store_items');

        // if ($item == false) {
            // echo 'not found';
        // }

        // echo $item->item_title;
    // }

    // function index() {
        // echo $this->model->count_where('id', 7, '>', 'NULL', 'store_items');
    // }

    function index() {
        echo $this->model->count('store_items');
    }
    // function index() {

        // echo $this->model->get_max('store_items');
    // }


    // function index() {
    //     $sql = "select * from store_items where item_title = 'First Item'";
    //     $rows = $this->model->query($sql);
    //     foreach ($rows as $row) {
    //         echo $row->id.'<br>';
    //         echo $row->item_title.'<hr>';
    //     }
    // }

    // function index() {
        //unnamed params
        // $sql = "select * from store_items where id = ? and item_title = ?";
        // $data[] = 1;
        // $data[] = 'First Item';

        // $rows = $this->model->query_bind($sql, $data);
        // foreach ($rows as $row) {
            // echo $row->id.'<br>';
            // echo $row->item_title.'<hr>';
        // }

        //named params
        // $sql = "select * from store_items where id = :id and item_title = :item_title";
        // $data['item_title'] = 'First Item';
        // $data['id'] = 1;

        // $rows = $this->model->query_bind($sql, $data);
        // foreach ($rows as $row) {
            // echo $row->id.'<br>';
            // echo $row->item_title.'<hr>';
        // }

    }

    // function index() {

        // for ($i=1; $i <= 400; $i++) { 
            // $row_data['id'] = '';
            // $row_data['title'] = 'Record '.$i;
            // $row_data['date_created'] = time();
            // $data[] = $row_data;
        // }

        // $this->model->insert_batch('test', $data);
        // echo 'Finished';

    // }
