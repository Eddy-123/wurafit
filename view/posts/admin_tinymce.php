<ul>
	<?php foreach ($posts as $key => $value) : ?>
		<li><a href="#"><?= ucfirst($value->type) ?> : <?= $value->name ?></a></li>
	<?php endforeach; ?>	
</ul>