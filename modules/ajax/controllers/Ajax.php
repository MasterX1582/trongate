<?php
class Ajax extends Trongate {

	function index(){
		
		$modname =$this->_mod_name();
		$data['modname'] = $modname;
		$data['view_module'] = $this->_mod_name();
		$data['view_file'] = __FUNCTION__;
		$data['rows'] = $this->model->get('id', 'staff' );
		$data['defaultText'] = "<b>The person you select will be listed here.</b>";
		$this->template('public_milligram', $data);
	}

    function getUser() {
		$value = $this->url->segment(3);
		echo "
		<style>
		table {
			width: 100%;
			border-collapse: collapse;
		}

		table, td, th {
			border: 1px solid black;
			padding: 5px;
		}

		th {text-align: left;}
		</style>		
		<table>
		<tr>
		<th>Firstname</th>
		<th>Lastname</th>
		<th>Age</th>
		<th>Hometown</th>
		<th>Job</th>
		</tr>";
		
		$result = $this->model->get_one_where('id', $value, 'staff');
			echo "<tr>";
			echo "<td>" . $result->firstname . "</td>";
			echo "<td>" . $result->lastname . "</td>";
			echo "<td>" . $result->age . "</td>";
			echo "<td>" . $result->hometown . "</td>";
			echo "<td>" . $result->job . "</td>";
			echo "</tr>";
		
		echo "</table>";
	
	}
	
	function _mod_name(){
		$mod_name = strtolower(__CLASS__);
		return $mod_name;
	}		
}