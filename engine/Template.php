<?php
class Template {

    public function load($template_name, $data=NULL) {
        $view_path = APPPATH.'templates/'.$template_name.'.php';

        if (!isset($data['view_file'])) {
            $data['view_file'] = DEFAULT_METHOD;
        }

        if (!isset($data['view_module'])) {
            $data['view_module'] = $this->get_view_module();
        }

        $this->attempt_include($view_path, $data);
    }

    static public function get_view_module() {
        //attempt to get view_module from URL
        $url = rtrim($_SERVER['REQUEST_URI'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        if (isset($url[2])) {
            $view_module = $url[2];
        } else {
            $view_module = DEFAULT_MODULE;
        }

        return $view_module;
    }

    static public function display($data=NULL) {

        if (!isset($data['view_module'])) {
            $data['view_module'] = self::get_view_module();
        }

        if (!isset($data['view_file'])) {
            $data['view_file'] = 'index';
        }

        $file_path = APPPATH.'modules/'.$data['view_module'].'/views/'.$data['view_file'].'.php';
        self::attempt_include($file_path, $data);
    }

    static public function partial($file_name, $data=NULL) {
        $file_path = APPPATH.'templates/'.$file_name.'.php';
        self::attempt_include($file_path, $data);
    }

    static private function attempt_include($file_path, $data=NULL) {

        if (file_exists($file_path)) {

            if (isset($data)) {
                extract($data);
            }

            require_once($file_path);

        } else {
            die('<br><b>ERROR:</b> View file does not exist at: '.$file_path);
        }

    }

}