<?php 
/**
 * 
 */
class PostsController extends Controller
{
	
	function index(){
		$perPage = 5;
		$this->loadModel('Post');
		$conditions = array('online' => 1, 'type' => 'post');
		$d['posts'] = $this->Post->find(array(
			'conditions' => $conditions,
			'limit' => ($perPage * ($this->request->page-1)).', '.$perPage,
			'order by' => 'created DESC, id DESC'
		));
		$d['total'] = $this->Post->findCount($conditions);
		$d['page'] = ceil($d['total'] / $perPage);
		$d['footer_relative'] = true;
		$this->set($d);
	}

	function view($id, $slug){
		$this->loadModel('Post');
		$conditions = array('online' => 1, 'id' => $id, 'type' => 'post');
		$d['post'] = $this->Post->findFirst(
			array(
				'fields' => 'id, slug, content, name',
				'conditions' => $conditions
			)
		);
		
		if (empty($d['post'])) {
			$this->e404('Page introuvable');
		}		
		if ($slug != $d['post']->slug) {
			$this->redirect("posts/view/id:$id/slug:".$d['post']->slug, 301);
		}
		$this->set($d);
	}

	/**
	 * ADMIN
	 */
	function admin_index(){		
		$perPage = 10;
		$this->loadModel('Post');
		$conditions = array('type' => 'post');
		$d['posts'] = $this->Post->find(array(
			'fields' => 'id, name, online',
			'conditions' => $conditions,
			'limit' => ($perPage * ($this->request->page-1)).', '.$perPage,
			'order by' => 'created DESC, id DESC'
		));
		$d['total'] = $this->Post->findCount($conditions);
		$d['page'] = ceil($d['total'] / $perPage);
		$this->set($d);
	}

	/**
	 * Permet d'éditer un article
	 */
	function admin_edit($id = null){
		$this->loadModel('Post');
		$d['id'] = '';
		if ($this->request->data) {
			if ($this->Post->validates($this->request->data)) {
				$this->request->data->type = 'post';
				$this->request->data->created = empty($this->request->data->created) ? date('Y-m-d h:i:s') : $this->request->data->created;
				$this->Post->save($this->request->data);
				$this->Session->setFlash('Le contenu a bien été modifié');
				//$id = $this->Post->id;
				$this->redirect('admin/posts/index');
			}else{
				$this->Session->setFlash('Merci de corriger vos informations', 'text-danger');
			}
			
		}else{
			if ($id) {			
				$this->request->data = $this->Post->findFirst(array(
					'conditions' => array('id' => $id)
				));
				$d['id'] = $id;
			}			
		}
		$this->set($d);
	}

	/**
	 * Permet de supprimer un article
	 */
	function admin_delete($id){
		$this->loadModel('Post');
		$this->Post->delete($id);
		$this->Session->setFlash('Le contenu a bien été supprimé');
		$this->redirect('admin/posts/index');
	}

	function admin_tinymce(){
		$this->loadModel('Post');
		$this->layout = 'modal';
		$d['posts'] = $this->Post->find();
		$this->set($d);
	}

}
?>
