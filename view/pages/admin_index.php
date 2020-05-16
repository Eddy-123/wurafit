<div class="page-header">
	<h1><?= $total ?> Pages modulables</h1>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th scope="col">ID</th>
			<th>En ligne ?</th>
			<th scope="col">Titre</th>
			<th scope="col">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($pages as $key => $value) { ?>
			<tr>
				<td scope="row"><?= $value->id ?></td>
				<td><span class="<?= $value->online == 1 ? 'text-success' : 'text-danger' ?>"><?= $value->online == 1 ? 'En ligne' : 'Hors ligne' ?></span></td>
				<td><?= $value->name ?></td>
				<td>
					<p><button><a href="<?= Router::url('admin/pages/edit/'.$value->id) ?>">Editer</a></button></p>
					<p><button><a onclick="return confirm('Voulez-vous vraiment supprimer ce contenu ?');" href="<?= Router::url('admin/pages/delete/'.$value->id) ?>">Supprimer</a></button></p>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<a class="btn btn-primary" href="<?= Router::url('admin/pages/edit') ?>">Ajouter une page</a>