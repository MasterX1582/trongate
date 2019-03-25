<section class="container">
	<h5 class="title">Create New Record</h5>
	<?=validation_errors('<p style="background: red; color: white;">', '</p>');?>
	<p>Please fill out the form below and then hit submit</p>
	<?php

echo form_open('guitars/submit');

// this adds placeholder text in the form
$item_title_attribute = array("placeholder" => "Enter Item Title");
$item_price_attribute = array("placeholder" => "Enter Item Price");
$item_description_attribute = array("placeholder" => "Enter Item Description");

echo form_input('item_title', $item_title, $item_title_attribute);
echo form_input('item_price', $item_price, $item_price_attribute);
echo form_textarea('item_description', $item_description, $item_description_attribute);
echo form_submit('submit', 'Submit');
?>
</section>