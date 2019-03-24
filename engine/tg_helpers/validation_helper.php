<?php
class validation_helper {

    public $form_submission_errors = [];

    public function set_rules($key, $label, $rules) {

        if ((!isset($_POST[$key])) && (isset($_FILES[$key]))) {
            $posted_value = $_FILES[$key];
            $tests_to_run[] = 'validate_file';

        } else {
            $posted_value = $_POST[$key];
            $tests_to_run = $this->get_tests_to_run($rules);
        }

        foreach ($tests_to_run as $test_to_run) {

            switch ($test_to_run) {
                case 'required':
                    $this->check_for_required($label, $posted_value);
                    break;
                case 'numeric':
                    $this->check_for_numeric($label, $posted_value);
                    break;
                case 'integer':
                    $this->check_for_integer($label, $posted_value);
                    break;
                case 'decimal':
                    $this->check_for_decimal($label, $posted_value);
                    break;
                case 'valid_email':
                    $this->valid_email($label, $posted_value);
                    break;
                case 'validate_file':
                    $this->validate_file($key, $label, $rules);
                    break;
                
                default:
                    $this->run_special_test($key, $label, $posted_value, $test_to_run);
                    break;
            }

        }

        $_SESSION['form_submission_errors'] = $this->form_submission_errors;

    }

    public function run() {

        if (isset($_SESSION['form_submission_errors'])) {
            unset($_SESSION['form_submission_errors']);
        }

        if (count($this->form_submission_errors)>0) {
            $_SESSION['form_submission_errors'] = $this->form_submission_errors;
            return false;
        } else {
            return true;
        }

    }

    private function get_tests_to_run($rules) {
        $tests_to_run = explode('|', $rules);
        return $tests_to_run;
    }

    private function check_for_required($label, $posted_value) {
        
        $posted_value = trim($posted_value);

        if ($posted_value == '') {
            $this->form_submission_errors[] = 'The '.$label.' field is required.';  
        }

    }

    private function check_for_numeric($label, $posted_value) {
        
        if (!is_numeric($posted_value)) {
            $this->form_submission_errors[] = 'The '.$label.' field must be numeric.';
        }

    }

    private function check_for_integer($label, $posted_value) {

        $result = ctype_digit(strval($posted_value));

        if ($result == false) {
            $this->form_submission_errors[] = 'The '.$label.' field must be an integer.';
        }

    }

    private function check_for_decimal($label, $posted_value) {

        if ((float) $posted_value == floor($posted_value)) {
            $this->form_submission_errors[] = 'The '.$label.' field must contain a number with a decimal.';
        }
    }

    private function matches($label, $posted_value, $target_field) {

        $got_error = false;

        if (!isset($_POST[$target_field])) {
            $got_error = true;
        } else {
            $target_value = $_POST[$target_field];

            if (($posted_value !== $target_value)) {
                $got_error = true;
            }

        }
        
        if ($got_error == true) {
           $this->form_submission_errors[] = 'The '.$label.' field does not match the '.$target_field.' field.'; 
        }

    }

    private function differs($label, $posted_value, $target_field) {
        //returns false if form element does not differ from the one in the parameter.
        $got_error = false;

        $target_value = $_POST[$target_field];

        if (($posted_value == $target_value)) {
            $got_error = true;
        }

        if ($got_error == true) {
           $this->form_submission_errors[] = 'The '.$label.' field must not match the '.$target_field.' field.'; 
        }

    }

    private function min_length($key, $label, $posted_value, $inner_value) {

        if(strlen($_POST[$key])<$inner_value) {
            $this->form_submission_errors[] = 'The '.$label.' field must greater than '.$inner_value.' characters in length.';
        }

    }

    private function max_length($key, $label, $posted_value, $inner_value) {

        if(strlen($_POST[$key])>$inner_value) {
            $this->form_submission_errors[] = 'The '.$label.' field must be less than '.$inner_value.' characters in length.';
        }

    }

    private function greater_than($key, $label, $posted_value, $inner_value) {

        if ((is_numeric($_POST[$key])) && ($_POST[$key]<=$inner_value)) {
            $this->form_submission_errors[] = 'The '.$label.' field must greater than '.$inner_value;
        }

    }

    private function less_than($key, $label, $posted_value, $inner_value) {

        if ((is_numeric($_POST[$key])) && ($_POST[$key]>=$inner_value)) {
            $this->form_submission_errors[] = 'The '.$label.' field must less than '.$inner_value;
        }
        
    }

    private function valid_email($label, $posted_value) {

        if (!filter_var($posted_value, FILTER_VALIDATE_EMAIL)) {
            $this->form_submission_errors[] = 'The '.$label.' field must contain a valid email address.';
        }

    }

    private function exact_length($key, $label, $posted_value, $inner_value) {

        if(strlen($_POST[$key])!=$inner_value) {

            $error_msg = 'The '.$label.' field must be '.$inner_value.' characters in length.';

            if ($inner_value == 1) {
                $error_msg = str_replace('characters in length.', 'character in length.', $error_msg);
            }

            $this->form_submission_errors[] = $error_msg;
        }

    }

    private function run_special_test($key, $label, $posted_value, $test_to_run) {


        $pos = strpos($test_to_run, '[');

        if (is_numeric($pos)) {
            //get the value between the square brackets
            $inner_value = $this->_extract_content($test_to_run, '[', ']');

            $test_name = $this->_get_test_name($test_to_run);

            switch ($test_name) {
                case 'matches':
                    $this->matches($label, $posted_value, $inner_value);
                    break;
                case 'differs':
                    $this->differs($label, $posted_value, $inner_value);
                    break;
                case 'min_length':
                    $this->min_length($key, $label, $posted_value, $inner_value);
                    break;
                case 'max_length':
                    $this->max_length($key, $label, $posted_value, $inner_value);
                    break;
                case 'greater_than':
                    $this->greater_than($key, $label, $posted_value, $inner_value);
                    break;
                case 'less_than':
                    $this->less_than($key, $label, $posted_value, $inner_value);
                    break;
                case 'exact_length':
                    $this->exact_length($key, $label, $posted_value, $inner_value);
                    break;
            }

        } else {
            $this->attempt_invoke_callback($key, $label, $posted_value, $test_to_run);
        }

    }

    private function _extract_content($string, $start, $end) {
        $pos = stripos($string, $start);
        $str = substr($string, $pos);
        $str_two = substr($str, strlen($start));
        $second_pos = stripos($str_two, $end);
        $str_three = substr($str_two, 0, $second_pos);
        $content = trim($str_three); // remove whitespaces
        return $content;
    }

    private function _get_test_name($test_to_run) {
        $pos = stripos($test_to_run, '[');
        $test_name = substr($test_to_run, 0, $pos);
        return $test_name;
    }

    private function validate_file($key, $label, $rules) {

        require_once('file_validation_helper.php');

    }

    private function attempt_invoke_callback($key, $label, $posted_value, $test_to_run) {

        $chars = substr($test_to_run, 0, 9);
        if ($chars == 'callback_') {
            $target_module = ucfirst($this->url_segment(1));
            $target_method = str_replace('callback_', '', $test_to_run);

            if (class_exists($target_module)) {  
                $outcome = $target_module::$target_method($posted_value);

                if (gettype($outcome) == 'string') {
                    $this->form_submission_errors[] = $outcome;
                }

            }

        }

    }

    public function url_segment($num) {
        $segments = SEGMENTS;
        
        if (isset($segments[$num])) {
            $value = $segments[$num];
        } else {
            $value = '';
        }

        return $value;
    }

}

function validation_errors($opening_html=NULL, $closing_html=NULL) {

    if (isset($_SESSION['form_submission_errors'])) {
        $form_submission_errors = $_SESSION['form_submission_errors'];

        foreach($form_submission_errors as $form_submission_error) {

            if (!isset($opening_html)) {
                $opening_html = '<p style="color: red;">';
                $closing_html = '</p>';
            }

            echo $opening_html.$form_submission_error.$closing_html;
            
        }

        unset($_SESSION['form_submission_errors']);

    }

}