

<div class="jumbotron jumbotron-fluid" id="hero">
  <div class="container">
    <h1>WuraFit, le bien-être en or</h1>
  </div>
</div>

<div class="">
<div class="">
	<?php foreach ($posts as $key => $value) : ?>
	<div class="card posts_index"><!-- card posts_index -->
		  <div class="card-body"><!-- card-body -->
		    <h5 class="card-title"><a href="<?= Router::url("posts/view/id:{$value->id}/slug:$value->slug"); ?>" class=""><?= $value->name ?></a></h5><!-- card-title -->
		    <p><?= truncate($value->content, 30)?><a href="<?= Router::url("posts/view/id:{$value->id}/slug:$value->slug") ?>">&rarr;</a></p>
		    <div class="text-center">
		    	<h6>Publié le <?= date_format(date_create($value->created), 'd/m/Y') ?></h6>
		    </div>
		  </div>
		</div>
		
	<?php endforeach; ?>
	</div>
</div>
<hr>
<ul class="pagination justify-content-center">
  <?php for ($i=1; $i <= $page; $i++) { ?>
    <li class="page-item <?= $i==$this->request->page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
  <?php } ?>
</ul> 

<hr>