<?php

class Cart extends Trongate
{

    public function _draw_checkout()
    {
    	$this->view('checkout');
    }
}
