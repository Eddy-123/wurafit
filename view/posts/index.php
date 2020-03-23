<div class="page-header">
	<h1>WuraFit</h1>
</div>
<?php foreach ($posts as $key => $value) { ?>
	<h2><?= $value->name ?></h2>	
	<?= $value->content ?>
	<p><a href="<?= Router::url("posts/view/id:{$value->id}/slug:$value->slug"); ?>">Lire la suite &rarr;</a></p><!-- BASE_URL.'/posts/view/'.$value->id -->


<?php } ?>


<ul class="pagination">
  <?php for ($i=1; $i <= $page; $i++) { ?>
    <li class="page-item <?= $i==$this->request->page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
  <?php } ?>
</ul> 

