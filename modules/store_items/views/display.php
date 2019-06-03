<section class="container">
    <h5 class="title"><?= $item->item_title ?></h5>
	<h3>&euro;<?= $item->item_price ?></h3>
	<p>
		<img src="<?= BASE_URL ?>item_pictures/<?= $item->picture ?>" alt="<?= $item->item_title ?>">
	</p>
	<p>
	<?php 
	$attributes['class'] = 'button button-outline';
        echo anchor($modname.'/addtocart', 'Add To Cart', $attributes);		
		echo '&nbsp;';
        $attributes['class'] = 'button button-outline';
        echo anchor($modname.'/buynow/'.$item->url_title, 'Buy Now', $attributes);	
	?>
	</p>
</section>