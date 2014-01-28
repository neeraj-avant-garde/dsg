<?php
App::uses('AppController', 'Controller');
App::uses('UserController', 'Controller');
App::uses('Sanitize', 'Utility');



class PlanfieldsController extends AppController { 
	public $layout = 'main';

	
	
	public function beforeFilter(){
		parent::beforeFilter(); 
	}
	
	
	public function onePage(){
		
		$loggedUser = $this->Session->read('Auth.User');
		$company_id = $loggedUser['company_id'];
		$named = $this->request->named; 
		
		if(!empty($named)) {
			$planfields = $this->Planfield->find('all', array('conditions'=>array('company_id'=>$company_id, 'quarter_id'=>$named['Quarter'])));
		} else {
			$planfields = $this->Planfield->find('all', array('conditions'=>array('company_id'=>$company_id)));
		}

		
		$this->set('planfields', $planfields);
	}
	
	public function editOnePage(){
		$loggedUser = $this->Session->read('Auth.User');
		$group_id = $loggedUser['group_id'];
		if($group_id==1) {
			if ($this->request->is('post') || $this->request->is('put')) {
				$data = $this->request->data;
				$this->Planfield->people = json_encode($data['people']);
				$this->Planfield->corevalues = json_encode($data['corevalues']);
				$this->Planfield->purpose = json_encode($data['purpose']);
				$this->Planfield->targets = json_encode($data['targets']);
				$this->Planfield->goals = json_encode($data['goals']);
				$this->Planfield->sandbox = json_encode($data['sandbox']);
				$this->Planfield->actions = json_encode($data['actions']);
				$this->Planfield->capabilities = json_encode($data['capabilities']);
				$this->Planfield->keyinitiatives = json_encode($data['keyinitiatives']);
				$this->Planfield->corecompetencies = json_encode($data['corecompetencies']);
				$this->Planfield->profit = json_encode($data['profit']);
				$this->Planfield->bhag = json_encode($data['bhag']);
				$this->Planfield->brand_kpi = json_encode($data['brand_kpi']);
				$this->Planfield->brand = json_encode($data['brand']);
				$this->Planfield->criticalnumbers = json_encode($data['criticalnumbers']);
				$this->Planfield->swot = json_encode($data['swot']);
				$this->Planfield->process = json_encode($data['process']);
				$this->Planfield->actionsqtr = json_encode($data['actionsqtr']);
				$this->Planfield->theme = json_encode($data['theme']);
				$this->Planfield->celebration = json_encode($data['celebration']);
				$this->Planfield->reward = json_encode($data['reward']);
				$this->Planfield->id = $data['id'];

				$datatosave = $this->Planfield;
				if($this->Planfield->save($datatosave)){
					$this->Session->setFlash('One page plan has been updated successfully', 'default', array('class'=>'success'));
					$this->redirect('/planfields/onePage');
				} else { 
					$this->Session->setFlash('One page plan is not updated successfully', 'default', array('class'=>'message'));
					$this->redirect('/planfields/onePage');
				}
			} else {
				$named = $this->request->named;
				$company_id = $loggedUser['company_id'];
				if(!empty($named)) {
					$planfields = $this->Planfield->find('first', array('conditions'=>array('company_id'=>$company_id,'quarter_id'=>$named['Quarter'])));
				} else {
					$planfields = $this->Planfield->find('first', array('conditions'=>array('company_id'=>$company_id)));
				}	
				if(!empty($planfields)) {
					$this->set('planfields', $planfields);
				} else {
					$this->Session->setFlash('There is no one page plan found for this company', 'default', array('class'=>'message'));
					$this->redirect('/planfields/onePage');
				}
			}
		} else {
			$this->Session->setFlash('You are not authorized to view this content.', 'default', array('class'=>'message'));
			$this->redirect('/planfields/onePage');
		}		
	}
	
}

