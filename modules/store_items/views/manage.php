<section class="container">
    <h5 class="title">Manage Records</h5>
    <?= flashdata() ?>
    <p>
        <?php 
			$title = "Create New Record";
			$attributes['class'] = "button";
			$attributes['title'] = $title;
			echo anchor($modname.'/create', $title, $attributes);
		?>		
    </p>
	<?php if ($count > $limit){Pagination::display($data);} ?>
    <table>
        <thead>
            <tr>
                <th>Item Title</th>
                <th>Item Price</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($rows as $row) { 
                $item_url = anchor($modname.'/display/'.$row->url_title, true);
				$update_url = anchor($modname.'/create/'.$row->id, true);
            ?>
            <tr>
                <td><?= $row->item_title ?></td>
                <td><?= $row->item_price ?></td>
                <td><?= $row->item_description ?></td>
                <td>
					<?php 
						$title = "Update";
						$attributes['class'] = "button button-outline";
						$attributes['title'] = $title;
						echo anchor($update_url, $title, $attributes);
					?>				
				</td>
                <td>
					<?php 
						$title = "View";
						$attributes['class'] = "button button-outline button-black";
						$attributes['title'] = $title;
						echo anchor($update_url, $title, $attributes);
					?>
				</td>
            </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
	<?php if ($count > $limit){Pagination::display($data);} ?>
</section>