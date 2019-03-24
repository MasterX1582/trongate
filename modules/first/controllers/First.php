<?php

class First extends Trongate
{
    public function hello()
    {
        echo 'hello from First<br>';
        $this->module('second'); // bring in second module from second folder
        $this->second->rockAndRoll(); // display the rock and roll method
        $tax_due = $this->second->calcTax(); // load the calctax from second
        echo $tax_due;
    }

    public function goodbye()
    {
        echo 'Goodbye from the first module';
    }

}
