<?php
class Trongate {

    protected $modules;
    protected $module_name;
    protected $parent_module = '';
    protected $child_module = '';

    public function __construct($module_name) {
        $this->module_name = $module_name;
        $this->modules = new Modules;

        //load the helper classes
        foreach (TRONGATE_HELPERS as $trongate_helper) {
            require_once 'tg_helpers/'.$trongate_helper.'.php';
            $this->$trongate_helper = new $trongate_helper;
        }

        //load the model class
        require_once 'Model.php';
        $this->model = new Model;
    }

    public function load($helper) {
        require_once 'tg_helpers/'.$helper.'.php';
        $this->$helper = new $helper;
    }

    public function pagination($pagination_data) {
        require_once 'tg_helpers/'.$helper.'.php'; 
    }

    public function template($template_name, $data=NULL) {

        $template_file_path = '../templates/'.$template_name.'.php';

        if (!isset($data['view_file'])) {
            $data['view_file'] = DEFAULT_METHOD;
        }

        if (!isset($data['view_module'])) {

            $segments = SEGMENTS;

            if (isset($segments[1])) {
                $data['view_module'] = $segments[1];
            } else {
                $data['view_module'] = DEFAULT_MODULE;
            }
        }

        if (($data['view_module'] == 'homepage') && ($data['view_file'] == 'index')) {
            $data['is_home'] = true;
        } else {
            $data['is_home'] = false;
        }

        extract($data);

        if (file_exists($template_file_path)) {
            require_once($template_file_path);
        } else {
            die('ERROR: Unable to find template file in '.$template_file_path.'.');
        }
    }

    public function module($target_module) {
        $target_controller = ucfirst($target_module);
        $target_controller_path = '../modules/'.$target_module.'/controllers/'.$target_controller.'.php';

        if (!file_exists($target_controller_path)) {
            $child_module = $this->get_child_module($target_module);
            $target_controller_path = '../modules/'.$target_module.'/'.$child_module.'/controllers/'.ucfirst($child_module).'.php';
            $ditch = '-'.$child_module.'/'.$child_module.'/controllers';
            $replace = '/'.$child_module.'/controllers';
            $target_controller_path = str_replace($ditch, $replace, $target_controller_path);
            $target_module = $child_module;
        }

        require_once $target_controller_path;
        $this->$target_module = new $target_module($target_module);
    }

    private function get_child_module($target_module) {
        $child_module_path = false;
        $bits = explode('-', $target_module);

        if (count($bits)==2) {
            if (strlen($bits[1])>0) {
                $child_module = $bits[1];
            }
        }

        return $child_module;
    }

    public function view($view, $data = []) {

        if (($this->parent_module !== '') && ($this->child_module !== '')) {
            //load view from child module
            $this->load_child_view($view, $data);
        } else {
            //normal view loading process
            if (isset($data['view_module'])) {
                $module_name = $data['view_module'];
            } else {
                $module_name = $this->module_name;
            }

            extract($data);

            $view_path = APPPATH.'modules/'.$module_name.'/views/'.$view.'.php';

            // Check for view file
            if(file_exists($view_path)){
                // Require view file
                require_once $view_path;
            } else {
                // No view exists
                $view = str_replace('/', '/views/', $view);
                $view_path = APPPATH.'modules/'.$view.'.php';
            
                if(file_exists($view_path)){
                    // Require view file
                    require_once $view_path;
                } else {
                    throw new exception('view '.$view_path.' does not exist');
                }
            }
        }
    }

    private function load_child_view($view, $data) {
        extract($data);
        $view_path = APPPATH.'modules/'.$this->parent_module.'/'.$this->child_module.'/views/'.$view.'.php';

        // Check for view file
        if(file_exists($view_path)){
            // Require view file
            require_once $view_path;
        } else {
            // No view exists
            throw new exception('view '.$view_path.' does not exist');
        }
    }

    public function input($field_name, $clean_up=NULL) {
        if (!isset($_POST[$field_name])) {
            $value = '';
        } else {
            $value = $_POST[$field_name];

            if (isset($clean_up)) {
                $value = trim(filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH));
            }

        }

        return $value;
    }

    public function upload_picture($data) {
        //check for valid image width and mime type
        $userfile = array_keys($_FILES)[0];
        $target_file = $_FILES[$userfile];

        $dimension_data = getimagesize($target_file['tmp_name']);
        $image_width = $dimension_data[0];

        if (!is_numeric($image_width)) {
            die('ERROR: non numeric image width');
        }

        $content_type = mime_content_type($target_file['tmp_name']);

        $str = substr($content_type, 0, 6);
        if ($str !== 'image/') {
            die('ERROR: not an image.');
        }

        $tmp_name = $target_file['tmp_name'];
        $data['image'] = new Image($tmp_name);
        $data['filename'] = '../public/'.$data['destination'].'/'.$target_file['name'];
        $data['tmp_file_width'] = $data['image']->getWidth();
        $data['tmp_file_height'] = $data['image']->getHeight();

        if (!isset($data['max_width'])) {
            $data['max_width'] = NULL;
        }

        if (!isset($data['max_height'])) {
            $data['max_height'] = NULL;
        }

        $this->save_that_pic($data);
       
        //rock the thumbnail
        if ((isset($data['thumbnail_max_width'])) && (isset($data['thumbnail_max_height'])) && (isset($data['thumbnail_dir']))) {
            $data['filename'] = '../public/'.$data['thumbnail_dir'].'/'.$target_file['name'];
            $data['max_width'] = $data['thumbnail_max_width'];
            $data['max_height'] = $data['thumbnail_max_height'];
            $this->save_that_pic($data);
        }
    }

    private function save_that_pic($data) {
        extract($data);
        $reduce_width = false;
        $reduce_height = false;

        if (!isset($data['compression'])) {
            $compression = 100;
        } else {
            $compression = $data['compression'];
        }

        if (!isset($data['permissions'])) {
            $permissions = 775;
        } else {
            $permissions = $data['permissions'];
        }

        //do we need to resize the picture?
        if ((isset($max_width)) && ($tmp_file_width>$max_width)) {
            $reduce_width = true;
        }

        if ((isset($max_height)) && ($tmp_file_width>$max_height)) {
            $reduce_height = true;
        }

        //resize rules figured out, let's rock...
        if (($reduce_width == true) && ($reduce_height == false)) {
            $image->resizeToWidth($max_width);
            $image->save($filename, $compression);
        }

        if (($reduce_width == false) && ($reduce_height == true)) {
            $image->resizeToHeight($max_height);
            $image->save($filename, $compression);
        }

        if (($reduce_width == false) && ($reduce_height == false)) {
            $image->save($filename, $compression);
        }

        if (($reduce_width == true) && ($reduce_height == true)) {
            $image->resizeToWidth($max_width);
            $image->resizeToHeight($max_height);
            $image->save($filename, $compression);
        }
    }

    public function upload_file($config) {
        extract($config);

        if (!isset($destination)) {
            die('ERROR: upload requires inclusion of \'destination\' property.  Check documentation for details.');
        }

        $userfile = array_keys($_FILES)[0];
        $target_file = $_FILES[$userfile];

        if (!isset($new_file_name)) {
            $new_file_name = $target_file['name'];
        } elseif ($new_file_name === true) {
            $characters = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 10; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            $new_file_name = $randomString;
        }

        $bits = explode('.', $target_file['name']);
        $file_extension = '.'.$bits[count($bits)-1];

        $new_file_name = str_replace($file_extension, '', $new_file_name);
        $new_file_name = trim(filter_var($new_file_name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH));
        $new_file_name.= $file_extension;

        //make sure the destination folder exists
        $target_destination = '../public/'.$destination;

        if (is_dir($target_destination)) {
            //upload the temp file to the destination
            $new_file_path = $target_destination.'/'.$new_file_name;
            move_uploaded_file($target_file['tmp_name'], $new_file_path);

        } else {
            die('ERROR: Unable to find target file destination: $destination');
        }
    }

    public function ip_address() {
        return $_SERVER['REMOTE_ADDR'];
    }

}