<section class="container">
    <h5 class="title"><?= $headline ?></h5>
    <?= flashdata() ?>
    <?= validation_errors() ?>
    <p>Please fill out the form below and then hit 'Submit'.</p>
    <?php
    echo form_open($form_location);

    echo form_label('Item Title');
    $attributes['placeholder'] = 'Enter item title';
    echo form_input('item_title', $item_title, $attributes);

    echo form_label('Item Price');
    $attributes['placeholder'] = 'Enter item price';
    echo form_input('item_price', $item_price, $attributes);

    echo form_label('Item Description');
    $attributes['placeholder'] = 'Enter item description';
    echo form_textarea('item_description', $item_description, $attributes);
    
	// Unset unused array variables
	unset($attributes['placeholder']);
	
    echo form_submit('submit', 'Submit');

    if (is_numeric($update_id)) {

        echo '&nbsp;';
		
        $attributes['class'] = 'button button-black';
        echo anchor($modname.'/update_image/'.$update_id, 'Update Image', $attributes);

        echo '&nbsp;';
        $attributes['class'] = 'button button-outline';
        echo anchor($modname.'/manage', 'Cancel', $attributes);

        $attributes['class'] = 'button-danger float-right';
        echo form_submit('submit', 'Delete', $attributes);
	?>

	<?php
    } else {
        echo '&nbsp;';
        $attributes['class'] = 'button button-outline';
        echo anchor($modname.'/manage', 'Cancel', $attributes);
    }

    echo form_close();
    ?>

	
</section>