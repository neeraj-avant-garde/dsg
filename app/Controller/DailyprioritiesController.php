<?php
App::uses('AppController', 'Controller');
App::uses('UserController', 'Controller');
App::uses('Sanitize', 'Utility');



class  DailyprioritiesController extends AppController { 



	
	public function edit_dailypriority(){
		$this->layout = 'ajax';
		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
			$data = $this->request->data;
			if(!empty($data['Dailypriority']['id'])){
				$this->Dailypriority->id = $data['Dailypriority']['id'];
			}
			if($this->Dailypriority->save($this->request->data)){
				$this->Session->setFlash('Dailypriority has been saved', 'default', array('class'=>'success'));
				$this->redirect('/dashboard');
			}  
		}
		die;	
	}
	
	


}

