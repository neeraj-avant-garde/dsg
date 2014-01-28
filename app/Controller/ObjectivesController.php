<?php
App::uses('AppController', 'Controller');
App::uses('UserController', 'Controller');
App::uses('Sanitize', 'Utility');



class ObjectivesController extends AppController { 
	public $layout = 'main';
	public $action = 'objectives';
	
	
	public function beforeFilter(){
		parent::beforeFilter(); 
	}
	
	public function index(){
		
		$objectives = $this->Objective->find('all');
		$this->set(compact('objectives'));
		$this->set('objectives', $this->paginate());
		$this->view = 'objectives';
		 
	}

	
	public function add_objective(){
		$this->layout = 'ajax';
		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
			if($this->Objective->validates()) {
				if($this->Objective->save($this->request->data)){
					$this->Session->setFlash('Objective has been added', 'default', array('class'=>'success'));
					$this->redirect('/objectives');
				} 
			} 
		} else {
			$objectives = $this->Objective->find('all');
			$this->set(compact('objectives'));	
			$this->loadModel('User');
		} 
	}
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Objective.id' => 'desc'
        )
    );
   public function objectives() {

        $objectives = $this->paginate('Objectives', array('company_id' => $this->Session->read('current_company')));
        $this->set('objectives', $objectives);
    }
	
	public function editobj($id = null) {
		$this->layout = 'ajax';
		$this->Objective->id = $id;
		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
			if ($this->Objective->save($this->request->data)) {
				$this->Session->setFlash('Objective has been updated','default',array('class' => 'success'));
				$this->redirect('/objectives');
			}
		} else {
			$this->request->data = $this->Objective->read('',$id);
		}
	}
	
	
	
	
	public function deleteobj($id = null) {
		$this->Objective->id = $id;
		if ($this->Objective->delete()) {
			$this->Session->setFlash('Objective deleted', 'default', array('class' => 'success'));
			$this->redirect('/objectives');
		}
	}

}

