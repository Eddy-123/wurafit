<table class="table table-striped">
	<thead>
		<tr>
			<th scope="col">Image</th>

			<th scope="col">Titre</th>
			<th scope="col">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($images as $key => $value) { ?>
			<tr>
				<td scope="row">
					<a href="#">
						<img src="<?= Router::webroot('img/'.$value->file) ?>" height="100">
					</a>
				</td>
				
				<td><?= $value->name ?></td>
				<td>

					<a onclick="return confirm('Voulez-vous vraiment supprimer cette image ?');" href="<?= Router::url('admin/medias/delete/'.$value->id) ?>">Supprimer</a>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<div>
	<h1>Ajouter une image</h1>
</div>

<form action="<?= Router::url('admin/medias/index/'.$post_id) ?>" method="post" enctype="multipart/form-data">
	<?= $this->Form->input('file', 'Image', array('type' => 'file')) ?>
	<?= $this->Form->input('name', 'Titre') ?>
	<button type="submit">Envoyer</button>
</form>