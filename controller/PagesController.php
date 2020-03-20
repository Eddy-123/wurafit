<?php 
/**
 * 
 */
class PagesController extends Controller
{
	/*
	function view($nom){
		$this->set(array(
			'phrase' => 'Salut',
			'nom' => 'Pygamoss'
		));
		$this->render('index');
	}
	*/
	function index(){
		$this->render('index');
	}
}
?>