<?php 
/**
 * 
 */
class PostsController extends Controller
{
	
	function index(){
		$perPage = 1;
		$this->loadModel('Post');
		$conditions = array('online' => 1, 'type' => 'post');
		$d['posts'] = $this->Post->find(array(
			'conditions' => $conditions,
			'limit' => ($perPage * ($this->request->page-1)).', '.$perPage
		));
		$d['total'] = $this->Post->findCount($conditions);
		$d['page'] = ceil($d['total'] / $perPage);
		$this->set($d);
	}

	function view($id){
		$this->loadModel('Post');
		$conditions = array('online' => 1, 'id' => $id, 'type' => 'post');
		$d['page'] = $this->Post->findFirst(
			array(
				'conditions' => $conditions
			)
		);
		if (empty($d['page'])) {
			$this->e404('Page introuvable');
		}		
		$this->set($d);
	}

}
?>
