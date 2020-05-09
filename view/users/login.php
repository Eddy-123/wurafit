<div>
	<h1>Zone réservée</h1>
	<form method="post" action="<?= Router::url('users/login') ?>">
		<?= $this->Form->input('login', 'Identifiant') ?>
		<?= $this->Form->input('password', 'Mot de passe', array('type' => 'password')) ?>
		<button type="submit" class="btn btn-primary btn-lg btn-block" value="Se connecter">Se connecter</button>
	</form>
</div>