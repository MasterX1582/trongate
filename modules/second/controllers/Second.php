<?php

class Second extends Trongate
{
    public function rockAndRoll()
    {
        echo 'Let us rock<br>';
    }

    public function calcTax()
    {
        $tax_due = 8888;
        return $tax_due;
    }
}
