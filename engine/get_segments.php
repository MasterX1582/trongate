<?php
function get_segments() {

    //figure out how many segments needs to be ditched
    $psuedo_url = str_replace('://', '', BASE_URL);
    $psuedo_url = rtrim($psuedo_url, '/');
    $bits = explode('/', $psuedo_url);
    $num_bits = count($bits);

    if ($num_bits>1) {
        $num_segments_to_ditch = $num_bits-1;
    } else {
        $num_segments_to_ditch = 0;
    }

    $assumed_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
    $assumed_url = attempt_add_custom_routes($assumed_url);

    $data['assumed_url'] = $assumed_url;

    $assumed_url = str_replace('://', '', $assumed_url);
    $assumed_url = rtrim($assumed_url, '/');

    $segments = explode('/', $assumed_url);

    for ($i=0; $i < $num_segments_to_ditch; $i++) { 
        unset($segments[$i]);
    }

    $data['segments'] = array_values($segments); 
    return $data;
}

function attempt_add_custom_routes($assumed_url) {

    foreach (CUSTOM_ROUTES as $key => $value) {
        $pos = strpos($assumed_url, $key);

        if (is_numeric($pos)) {
            $assumed_url = str_replace($key, $value, $assumed_url);
        }

    }

    return $assumed_url;
}

$data = get_segments();

define('SEGMENTS', $data['segments']);
define('ASSUMED_URL', $data['assumed_url']);