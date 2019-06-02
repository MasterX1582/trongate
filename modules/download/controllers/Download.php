<?php
class Download extends Trongate {
	
	function resources(){
		$modname = $this->_mod_name();
		$data['modname'] = $modname;
		
		$download_title = "Trongate";
		$download_version = "1.2.0";
		$download_format = "zip";
		$download_host = "https://s3.eu-west-2.amazonaws.com/speedcodingacademy/module7";
		/*
		archive format example: <download_title>_<download_version>.<download_format>
		for example: trongate_1_2_0.zip
		*/
		$download_tiltle_dlstr = strtolower($download_title);		
		$download_version_dlstr = str_replace('.', '_', $download_version);
		$download_url = $download_host."/".$download_tiltle_dlstr."_".$download_version_dlstr.".".$download_format;
		
		$data['download_title'] = $download_title;
		$data['download_version'] = $download_version;
		$data['download_version_dlstr'] = $download_version_dlstr;
		$data['download_url'] = $download_url;
		
        $data['view_file'] = __FUNCTION__;	
		$data['view_module'] = $this->_mod_name();			
		$this->template('public_milligram', $data);

	}
	
	function _mod_name(){
		$mod_name = strtolower(__CLASS__);
		return $mod_name;
	}	
}