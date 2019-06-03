<section class="container">
    <h5 class="title">Manage Records</h5>
    <?= flashdata() ?>

	<?php if ($count > $limit){Pagination::display($data);} ?>
    <table>
        <thead>
            <tr>
                <th>Picture</th>
				<th>Title</th>
                <th>Description</th>
                <th>Item Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($rows as $row) { 
			
                $item_url = anchor('store_items/display/'.$row->url_title, true);
				//BASE_URL.'product/'.$row->url_title;
                $picture_url = BASE_URL.'item_pictures/thumbs/'.$row->picture;
            ?>
            <tr>
                
                <td><a href="<?= $item_url ?>" alt="<?= $row->item_title ?>"><img src="<?= $picture_url ?>"></a></td>
				<td><a href="<?= $item_url ?>" alt="<?= $row->item_title ?>"><?= $row->item_title ?></a></td>
                <td><a href="<?= $item_url ?>" alt="<?= $row->item_title ?>"><?= $row->item_description ?></a></td>
                <td><a href="<?= $item_url ?>" alt="<?= $row->item_title ?>"><?= $row->item_price ?></a></td>
            </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
	<?php if ($count > $limit){Pagination::display($data);} ?>
</section>