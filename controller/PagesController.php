<?php 
/**
 * 
 */
class PagesController extends Controller
{
	
	function view($id){
		$this->loadModel('Post');
		$d['page'] = $this->Post->findFirst(
			array(
				'conditions' => array('online' => 1, 'id' => $id, 'type' => 'page')
			)
		);
		if (empty($d['page'])) {
			$this->e404('Page introuvable');
		}		
		$this->set($d);
	}

	function admin_index(){		
		$perPage = 10;

		//CHARGER LE MODELE
		$this->loadModel('Post');
		
		//RÉCUPERER LES PAGES
		$d['pages'] = $this->Post->find(array(
			'fields' => 'id, name, online',
			'conditions' => array('type' => 'page'),
			'limit' => ($perPage * ($this->request->page-1)).', '.$perPage
		));


		$d['total'] = $this->Post->findCount(array('type' => 'page'));
		$d['page'] = ceil($d['total'] / $perPage);
		
		$this->set($d);
	}

	function admin_delete($id){
		$this->loadModel('Post');
		$this->Post->delete($id);
		$this->Session->setFlash('Le contenu a bien été supprimé');
		$this->redirect('admin/pages/index');
	}

	function admin_edit($id = null){
		//CHARGER LE MODELE
		$this->loadModel('Post');
		
		$d['id'] = '';

		if ($this->request->data) {
			if ($this->Post->validates($this->request->data)) {
				$this->request->data->type = 'page';
				$this->request->data->created = empty($this->request->data->created) ? date('Y-m-d h:i:s') : $this->request->data->created;
				$this->Post->save($this->request->data);
				$this->Session->setFlash('Le contenu a bien été modifié');
				//$id = $this->Post->id;
				$this->redirect('admin/pages/index');
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
	 * Permet de récupérer les pages pour le menu
	 */
	function getMenu(){
		$this->loadModel('Post');
		return $this->Post->find(array(
			'conditions' => array('online' => 1, 'type' => 'page')
		));
	}
}
?>