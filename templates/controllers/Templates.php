<?php
class Templates extends Trongate {

    function error_404($data) {
        load('error_404', $data);
    }
    function public_milligram($data) {
        load('public_milligram', $data);
    }
}