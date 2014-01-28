<?php
App::uses('AppController', 'Controller');
App::uses('UserController', 'Controller');
App::uses('Sanitize', 'Utility');



class StucksController extends AppController { 
	public $layout = 'main';
	
	public function beforeFilter(){
		parent::beforeFilter(); 
	}
	
	public function index(){
		$cc = $this->Session->read('current_company');
		$uid = $this->Session->read('Auth.User.id');
		$stucks_holds = $this->Stuck->find('all', array('conditions'=>array('from'=>$uid,'company_id'=>$cc)));
		$stucks_on = $this->Stuck->find('all', array('conditions'=>array('user_id'=>$uid,'company_id'=>$cc)));
		
		
		$this->set(compact('stucks_holds'));
		$this->set(compact('stucks_on'));

		$this->loadModel('User');
		$userModel = $this->User;
		$this->set('userModel', $userModel);
		$this->view = 'Stucks';
	}

	
	public function add_stuck(){
		$this->layout = 'ajax';
		$this->loadModel('User');
		
		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
		

			if($this->Stuck->save($this->request->data)){
				
				/* Send Mail */
				$data = $this->request->data;
				
				$to = $this->User->field('email', array('id'=>$data['Stuck']['from']));
				$name = $this->User->field('firstname', array('id'=>$data['Stuck']['from']));
				//echo "<pre>";
				//print_r($name);
				//die();
				$from = $this->User->field('email', array('id'=>$data['Stuck']['user_id']));
				$body = "<p>".$name."$nbsp need your help.</p>".$data['Stuck']['notes'];				
				$Email = new CakeEmail();
				$Email->viewVars(compact('body'));
				$Email->viewVars(compact('to'));
				$Email->from(array($from => 'DSG'));
				$Email->emailFormat('html');
				$Email->template('stuckmail');
				$Email->to($to);
				$Email->bcc('amit.rana@60degree.com');
				$Email->subject('Someone is Stuck and Needs Your Help');
				$Email->send($body);
				
				
				$this->Session->setFlash('Stuck has been added', 'default', array('class'=>'success'));
				$this->redirect('/Stucks');
			} 
		} else {
			$Stucks = $this->Stuck->find('all');
			$this->set(compact('Stucks'));	
			
			$users = $this->User->find('list', array('fields'=>array('firstname')));
			$this->set('users', $users);
		} 
	}
	
	
	
	public function edit_stuck($id = null) {
		$this->layout = 'ajax';
		$this->Stuck->id = $id;
		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
			if ($this->Stuck->save($this->request->data)) {
				/* Send Mail */
				$data = $this->request->data;
				$to = $this->User->field('email', array('id'=>$data['Stuck']['from']));
				$from = $this->User->field('email', array('id'=>$data['Stuck']['user_id']));
				$body = $data['Stuck']['notes'];				
				$Email = new CakeEmail();
				$Email->viewVars(compact('body'));
				$Email->viewVars(compact('to'));
				$Email->from(array($from => 'DSG'));
				$Email->emailFormat('html');
				$Email->template('stuckmail');
				$Email->to($to);
				$Email->bcc('amit.rana@60degree.com');
				$Email->subject('Stuck has been changed');
				$Email->send($body);
				$this->Session->setFlash('Stuck has been updated','default',array('class' => 'success'));
				$this->redirect('/stucks');
			}
		} else {
			$this->request->data = $this->Stuck->read('',$id);
			$this->loadModel('User');
			$userModel = $this->User;
			$this->set('userModel', $userModel);
			$this->set('from', $this->request->data('Stuck.from'));
		}
	}
	
	
	
	
	public function delete_stuck($id = null) {
		$this->Stuck->id = $id;
		if ($this->Stuck->delete()) {
			$this->Session->setFlash('Stuck deleted', 'default', array('class' => 'success'));
			$this->redirect('/stucks');
		}
	}
	
	
	

}

