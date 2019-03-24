<?php
class form_helper {
}

function form_open($location, $attributes=NULL, $additional_code=NULL) {
    $extra = '';
    if (isset($attributes)) {
        foreach ($attributes as $key => $value) {
            $extra.= ' '.$key.'="'.$value.'"';
        }
    }

    if (filter_var($location, FILTER_VALIDATE_URL) === FALSE) {
        $location = BASE_URL.$location;
    }

    if (isset($additional_code)) {
        $extra.= ' '.$additional_code;
    }

    $html = '<form action="'.$location.'" method="post"'.$extra.'>';
    return $html;
}

function form_open_upload($location, $attributes=NULL, $additional_code=NULL) {
    $html = form_open($location, $attributes, $additional_code);
    $html = str_replace('>', ' enctype="multipart/form-data">', $html);
    return $html;
}

function form_close() {
    $html = '</form>';
    return $html;
}

function get_attributes_str($attributes) {
    $attributes_str = '';
    if (!isset($value)) {
        $value = '';
    }

    if (isset($attributes)) {
        foreach ($attributes as $a_key => $a_value) {
            $attributes_str.= ' '.$a_key.'="'.$a_value.'"';
        }
    }

    return $attributes_str;  
}

function form_label($label_text, $attributes=NULL, $additional_code=NULL) {
    $extra = '';

    if (isset($attributes)) {
        $extra = get_attributes_str($attributes);
    }

    if (isset($additional_code)) {
        $extra.= ' '.$additional_code;
    }

    return '<label'.$extra.'>'.$label_text.'</label>';
}

function form_input($name, $value=NULL, $attributes=NULL, $additional_code=NULL) {
    $extra = '';
    if (!isset($value)) {
        $value = '';
    }

    if (isset($attributes)) {
        $extra = get_attributes_str($attributes);
    }

    if (isset($additional_code)) {
        $extra.= ' '.$additional_code;
    }

    return '<input type="text" name="'.$name.'" value="'.$value.'"'.$extra.'>';
}

function form_password($name, $value=NULL, $attributes=NULL, $additional_code=NULL) {
    $html = form_input($name, $value, $attributes, $additional_code);
    $html = str_replace(' type="text" ', ' type="password" ', $html);
    return $html;
}

function form_email($name, $value=NULL, $attributes=NULL, $additional_code=NULL) {
    $html = form_input($name, $value, $attributes, $additional_code);
    $html = str_replace(' type="text" ', ' type="email" ', $html);
    return $html;
}

function form_hidden($name, $value=NULL, $additional_code=NULL) {
    $html = form_input($name, $value, $additional_code);
    $html = str_replace(' type="text" ', ' type="hidden" ', $html);
    return $html;
}

function form_textarea($name, $value=NULL, $attributes=NULL, $additional_code=NULL) {

    $extra = '';
    if (!isset($value)) {
        $value = '';
    }

    if (isset($attributes)) {
        $extra = get_attributes_str($attributes);
    }

    if (isset($additional_code)) {
        $extra.= ' '.$additional_code;
    }

    return '<textarea name="'.$name.'"'.$extra.'>'.$value.'</textarea>';
}

function form_submit($name, $value=NULL, $attributes=NULL, $additional_code=NULL) {

    $extra = '';
    if (!isset($value)) {
        $value = $name;
    }

    if (isset($attributes)) {
        $extra = get_attributes_str($attributes);
    }

    if (isset($additional_code)) {
        $extra.= ' '.$additional_code;
    }

    return '<button type="submit" name="'.$name.'" value="'.$value.'"'.$extra.'>'.$value.'</button>';

}

function form_button($name, $value=NULL, $attributes=NULL, $additional_code=NULL) {
    $html = form_submit($name, $value, $attributes, $additional_code);
    $html = str_replace(' type="submit" ', ' type="button" ', $html);
    return $html;
}

function radio($name, $value=NULL, $checked=NULL, $attributes=NULL, $additional_code=NULL) {

    $extra = '';

    if (!isset($value)) {
        $value = '1';
    }

    if (!isset($checked)) {
        $checked = false;
    }

    if (isset($attributes)) {
        $extra = get_attributes_str($attributes);
    }

    if ($checked == true) {
        $extra.= ' checked';
    }

    if (isset($additional_code)) {
        $extra.= ' '.$additional_code;
    }

    $html = '<input type="radio" name="'.$name.'" value="'.$value.'"'.$extra.'>';
    return $html;
}

function checked($name, $value=NULL, $checked=NULL, $attributes=NULL, $additional_code=NULL) {
    $html = $this->radio($name, $value, $checked, $attributes, $additional_code);
    $html = str_replace(' type="radio" ', ' type="checkbox" ', $html);
}

function form_dropdown($name, $options, $selected_key=NULL, $selected_value=NULL, $attributes=NULL, $additional_code=NULL) {

    $extra = '';
    if (isset($attributes)) {
        $extra = get_attributes_str($attributes);
    }

    if (isset($additional_code)) {
        $extra.= ' '.$additional_code;
    }

    $html = '<select name="'.$name.'"'.$extra.'>
';


    if (!isset($selected_key)) {
        $selected_key = '';
        $selected_value = 'Select...';
    }

    $html.= '<option value="'.$selected_key.'" selected>'.$selected_value.'</option>
';

    if (isset($options[$selected_key])) {
        unset($options[$selected_key]);
    }

    foreach ($options as $option_key => $option_value) {
        $html.= '<option value="'.$option_key.'">'.$option_value.'</option>
';
    }

    $html.= '</select>';
    return $html;
}

function form_file_select($name, $attributes=NULL, $additional_code=NULL) {
    $value = NULL;
    $html = form_input($name, $value, $attributes, $additional_code);
    $html = str_replace(' type="text" ', ' type="file" ', $html);
    return $html;
}