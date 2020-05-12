<div class="container">
	<div class="jumbotron">
		<h1>Editer un article</h1>
	</div>
</div>	
<form action="<?= Router::url('admin/pages/edit/'.$id) ?>" method="post">
  <?= $this->Form->input('name', 'Titre') ?>
  <?= $this->Form->input('slug', 'Url') ?>
  <?= $this->Form->input('id', 'hidden') ?>
  <?= $this->Form->input('created', 'Date', array('type' => 'date')) ?>
  <?= $this->Form->input('content', 'Contenu', array('type' => 'textarea', 'rows' => 6)) ?>
  <?= $this->Form->input('online', 'En ligne', array('type' => 'checkbox')) ?>
  <button type="submit" class="btn btn-primary btn-lg btn-block" value="Envoyer">Envoyer</button>
</form>
<br><br><br>