<section class="container">
    <h5><?= $headline ?></h5>

    <?php 
    flashdata();
    echo form_open($form_location);
    $attributes['class'] = 'button-danger';
    echo form_submit('submit', 'Delete Picture', $attributes);
    echo '&nbsp;';
    $attributes['class'] = 'button button-outline';
    echo anchor($cancel_url, 'Cancel', $attributes);
    echo form_close();
    ?>

    <p>
        <img src="<?= BASE_URL ?>item_pictures/<?= $picture ?>" alt="<?= $headline ?>">
    </p>
</section>
