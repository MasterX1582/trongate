<section class="container">
    <h5 class="title">Upload Picture</h5>
    <?= validation_errors() ?>
    <p>Please choose a picture and then hit 'Upload'.</p>
    <?php
    echo form_open_upload($form_location);
    echo form_file_select('picture');
    echo form_submit('submit', 'Upload');
    echo '&nbsp;';
    $attributes['class'] = 'button button-outline';
    echo anchor($cancel_url, 'Cancel', $attributes);
    echo form_close();
    ?>
</section>