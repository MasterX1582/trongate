<section class="container">
	<h5 class="title">Manage Records</h5>
	<?= flashdata() ?>
	<a class="button" href="<?= BASE_URL ?>guitars/create">Create New Record</a>
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
			<!-- read the database tables -->
			<?php
			foreach($rows as $row){
				$update_url = BASE_URL.'guitars/create/'.$row->id;
			?>
			<tr>
				<td><?= $row->item_title ?></td>
				<td><?= $row->item_price ?></td>
				<td><?= $row->item_description ?></td>
				<td><a class="button button-outline" href="<?= $update_url ?>">Update</a></td>
			</tr>
			<?php
			}
			?>
		</table>
		
	</section>