<?php
App::uses('AppController', 'Controller');
App::uses('UserController', 'Controller');
App::uses('Sanitize', 'Utility');



class PrioritiesController extends AppController
{
    public $layout = 'main';
    
    public function beforeFilter()
    {
        parent::beforeFilter();
    }
    
/* 	public $paginate = array(
        'limit' => 2,
        'order' => array(
            'Priority.id' => 'desc'
        )
    ); */
	
    public function index()
    {
		$params = $this->request->params;
		$data = $this->request->data; 
		$quarterId = $params['named']['Quarter'];
		$userid = $data['user_id'];
		$obj_name = $data['obj_name'];
		$cc = $this->Session->read('current_company');

		
		if(empty($quarterId)) {
			$this->loadModel('Quarter');
			$active = $this->Quarter->query('SELECT id FROM quarters WHERE current = "1"');
			$activeQtr = $active[0]['quarters']['id']; 
			$priorities = $this->Priority->find('all', array('conditions'=>array(
																'Quarter.id'=>$activeQtr,
																'Priority.company_id'=> $cc
															)));
		} else {
			$activeQtr = $quarterId;
			$priorities = $this->Priority->find('all', array('conditions'=>array(
													'Quarter.id'=>$activeQtr,
													'Priority.company_id'=> $cc
												)));
		}

		if(!empty($userid)) {
			$priorities = $this->Priority->find('all', array('conditions'=>array(
																'Quarter.id'=>$activeQtr,
																'Priority.user_id' => $userid,
																'Priority.company_id'=> $cc
															)));
		}
		
		
		if(!empty($obj_name)) {
			$priorities = $this->Priority->find('all', array('conditions'=>array(
																'Quarter.id'=>$activeQtr,
																'Priority.name LIKE' => '%'.$obj_name.'%',
																'Priority.company_id'=> $cc
															)));
		}
		
		if(!empty($userid) && !empty($obj_name)) { 
			$priorities = $this->Priority->find('all', array('conditions'=>array(
																'Quarter.id'=>$activeQtr,
																'Priority.user_id' => $userid,
																'Priority.name LIKE' => '%'.$obj_name.'%',
																'Priority.company_id'=> $cc
															)));
		}

		$this->set('priorities', $priorities);
		

		
		$this->set('activeQtr', $activeQtr);
        $pr_model      = $this->Priority;
		$this->loadModel('User');
        $user_model      = $this->User;
        $this->set(compact('pr_model'));

    }
    
    public function add_priority()
    {
		
		$cc = $this->Session->read('current_company');
		$this->loadModel('Company');
		$companyData = $this->Company->find('first', array('fields'=>array('qtrrangetype'),
		 'conditions' => array('id'=>$cc)));
		$companyRangeType = $companyData['Company']['qtrrangetype'];
		
		
        $this->layout = 'ajax';
        if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
            if ($this->Priority->validates()) {
		

                if ($this->Priority->save($this->request->data)) {
		 
                    $this->Session->setFlash('Objective has been added', 'default', array(
                        'class' => 'success'
                    ));
                   
                    $this->redirect('/myteams');
                }
		
		
		else {
                    $errors = $this->User->validationErrors;
                }
            }
        } else {
            $priorities = $this->Priority->find('list', array('fields'=>array('id', 'name'), 'conditions'=>array('company_id'=>$cc)));
            $this->set(compact('priorities'));
            $this->loadModel('User');
            $this->loadModel('Objective');
			$objectives = $this->Objective->find('list', array(
                'id',
                'name'
            ));
            $this->set(compact('objectives'));
			
			$this->loadModel('Quarter');
			$quarters = $this->Quarter->find('list', array(
														'fields'		=> array('id', 'name'),
														'conditions' 	=> array('company_id'=> $cc)
													)
												);
			$this->set(compact('quarters'));
			$activeQtr = $this->Quarter->activeQtr($companyRangeType);
			$this->set('activeQtr', $activeQtr);	
        }
        
    }
    public function edit_priority($id = null)
    {
        $this->layout       = 'ajax';
        $this->Priority->id = $id;
        if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
            if ($this->Priority->save($this->request->data)) {
                $this->Session->setFlash('Prioity has been updated', 'default', array(
                    'class' => 'success'
                ));
                $this->redirect('/myteams');
            }
        } else {
            $this->request->data = $this->Priority->read('', $id);
            
            $this->loadModel('User');
            $users = $this->User->find('first', array(
                'id' => $this->request->data['Priority']['u_id']
            ));
            $this->set(compact('users'));
            $this->loadModel('Objective');
            $objectives = $this->Objective->find('list', array(
                'id',
                'name'
            ));
            $this->set(compact('objectives'));
            $priorities = $this->Priority->find('list', array(
                'id',
                'name'
            ));
            $this->set(compact('priorities'));
			
			$this->loadModel('Quarter');
			$cc = $this->Session->read('current_company');
			$this->loadModel('Company');
			$companyData = $this->Company->find('first', array('fields'=>array('qtrrangetype'), 'conditions' => array('id'=>$cc)));
			$companyRangeType = $companyData['Company']['qtrrangetype'];
			$quarters = $this->Quarter->find('list', array(
														'fields'		=> array('id', 'name'),
														'conditions' 	=> array('company_id'=> $cc)
													)
												);
			$this->set(compact('quarters'));
			// $activeQtr = $this->Quarter->activeQtr($companyRangeType);
        }
    }
    public function delete_priority($id = null)
    {
        $this->Priority->id = $id;
        if ($this->Priority->delete()) {
            $this->Session->setFlash('Priority deleted', 'default', array(
                'class' => 'success'
            ));
            $this->redirect('/priorities');
        }
    }
	
	
	public function update_objectives(){
		$cc = $this->Session->read('current_company');
		$activeQtr = $params['named']['Quarter'];
		$userId = $this->Session->read('Auth.User.id');
		$this->layout = 'ajax';
		 if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
            if ($this->Priority->saveAll($this->data['Priority'], array('deep' => true))) {
				
				foreach($this->data['Priority'] as $objective){
					$completed = $objective['completed'];
					$target = $objective['target'];
					$id = $objective['id'];
					$modifiedBy = $userId;
					$sql = "INSERT INTO objectivelogs SET 
								objective_id	= '".$id."',
								completed		= '".$completed."',
								target			= '".$target."',
								modified_by		= '".$modifiedBy."'
							";
					$this->Priority->query($sql);
				}
				
                $this->Session->setFlash('Objectives has been updated', 'default', array(
                    'class' => 'success'
                ));
                $this->redirect('/myteams');
            }
        } else {
			$this->loadModel('Quarter');
			if($this->Session->check('Auth.User')){	
				$group = $this->Session->read('Auth.User.Group.id');
				$userid = $this->Session->read('Auth.User.id');
				$logged = true;
				if($group==1) {	$admin = true; } 
				if($group==2) {	$user = true; } 
			}
			
			$params = $this->request->params;
			$quarterId = $params['named']['Quarter'];
			$user_id = $params['named']['user_id'];
			$active =  $this->Quarter->find('list', array('fields'=>array(0=>'id'),'conditions'=>array('company_id'=>$cc)));
				$active= array_keys($active);
			if(empty($quarterId)) {
				
				
				$activeQtr = $this->Quarter->activeQtr($cc);
				
			} else {
				$activeQtr = $quarterId;
			}
			$this->set('active' ,$active);
			
			$this->set('activeQtr', $activeQtr);
			
			
			if($admin) {
				if(!empty($user_id)) {
					$objectives = $this->Priority->find('all', array('fields' => array(
						'id',
						'name',
						'target',
						'completed'
					), 'conditions'=>array('Quarter.id'=>$activeQtr, 'User.id'=>$user_id, 'Priority.company_id'=>$cc)));
				} else {
					$objectives = $this->Priority->find('all', array('fields' => array(
						'id',
						'name',
						'target',
						'completed'
					), 'conditions'=>array('Quarter.id'=>$activeQtr, 'Priority.company_id'=>$cc)));
					
				}
			} else {
				  $objectives = $this->Priority->find('all', array('fields' => array(
					'id',
					'name',
					'target',
					'completed'
				), 'conditions'=>array('User.id'=>$userid, 'Quarter.id'=>$activeQtr, 'Priority.company_id'=>$cc)));
			}
            $this->set('objectives',$objectives);
			

        }
		
	}
	
	
	
	public function getobjbyname($name=null){
		$this->layout = false;
		$objs = $this->Priority->query("SELECT * FROM  priorities WHERE name LIKE '%$name%' ;");
		foreach($objs as $obj){
			echo '<li id='.$obj['priorities']['id'].' onclick="setobj(this.id)" class="user_'.$user['priorities']['id'].'">';
			echo '<span id="username">'.$obj['priorities']['name'].'</span>';
			echo '</li>';
		}
		die;
	}
    
}
