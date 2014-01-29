<?php

App::uses('AppController', 'Controller');
App::uses('UserController', 'Controller');
App::uses('Sanitize', 'Utility');

class TeamsController extends AppController {

    public $layout = 'main';
    public $action = 'teams';

    public function beforeFilter() {
        parent::beforeFilter();
    }


	        	
	public $paginate = array(
			'limit' => 5,
			'order' => array(
				'Team.id' => 'desc'
			)
		);
    public function index() {
	error_reporting(0);
	$this->Paginator->settings = $this->paginate;
        // $this->set(compact('teams'));
        $this->loadModel('User');
        $users = $this->User->find('list', array('fields' => array('id', 'firstname')));
        $this->set(compact('users'));
        $this->set('teams', $this->paginate('Team', array('company_id' => $this->Session->read('current_company'))));
        $this->view = 'teams';
    }

    public function add_team() {
        $this->layout = 'ajax';
        if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
            if ($this->Team->validates()) {
                if ($this->Team->saveAll($this->request->data)) {
                    $this->Session->setFlash('Team has been added', 'default', array('class' => 'success'));
                    $this->redirect('/teams');
                }
            }
        } else {
            $teams = $this->Team->find('all');
            $this->set(compact('teams'));
            $this->loadModel('User');
            $users = $this->User->find('list', array('fields' => array('id', 'firstname')));
            $this->set(compact('users'));
        }
    }


    public function team() {

        $team = $this->paginate('Team', array('company_id' => $this->Session->read('current_company')));
        $this->set('teams', $objectives);
    }

    public function edit_team($id = null) {
        $this->layout = 'ajax';
        $this->Team->id = $id;
        if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
            if ($this->Team->save($this->request->data)) {
                $this->Session->setFlash('Team has been updated', 'default', array('class' => 'success'));
                $this->redirect('/Teams');
            }
        } else {
            $user_id = $this->Session->read('Auth.User.id');
            $group_id = $this->Session->read('Auth.User.Group.id');
            $this->request->data = $this->Team->read('', $id);
            $this->set(compact('teams'));
            $this->loadModel('User');
            if ($group_id == 2) {
                $users = $this->User->find('list', array('fields' => array('User.id', 'User.firstname', 'User.lastname'), 'conditions' => array('User.id' => $user_id)));
            } else {
                $users = $this->User->find('list', array('fields' => array('User.id', 'User.firstname', 'User.lastname')));
            }
            $this->set('users', $users);
        }
    }

    public function delete_team($id = null) {
        $this->Team->id = $id;
        if ($this->Team->delete()) {
            $this->Session->setFlash('Team deleted', 'default', array('class' => 'success'));
            $this->redirect('/Teams');
        }
    }

    public function dailyHuddle() {
		
		
        $params = $this->request->params;
        $data = $this->request->data;
        $quarterId = $params['named']['Quarter'];
        $userid = $data['user_id'];
        $obj_name = $data['obj_name'];
        $cc = $this->Session->read('current_company');
        $activeQtr = $quarterId;
        $pr_model = $this->loadModel('Priority');
        $this->loadModel('Team');
        $this->loadModel('User');
        $this->loadModel('Objective');
        $this->loadModel('Quarter');


        //pr($ro);
		
        $dailyHuddle = $this->Team->find('list', array('conditions' => array('company_id'=>$cc)));
        
//		$dailyHuddle[0] = "Select Team";
		
		ksort($dailyHuddle);

        $this->set(compact('dailyHuddle'));
		
		//$quarterid = $this->Quarter->activeQtr($cc);
		$quarters = $this->Quarter->find('list', array(
														'fields'		=> array('id'),
														'conditions' 	=> array('company_id'=> $cc)
													)
												);
		$active = $this->Quarter->query('SELECT id FROM quarters WHERE company_id = "'.$cc.'"');
		//pr($active);
			$activeQtr = $active[0]['quarters']['id'];										
											
												
		//pr($quarters['id']);
		$this->set(compact('active'));
	
		$this->set(compact('quarters'));

        //$this->set(compact('ro'));
        $activeQuarter = $this->Quarter->activeQtr($cc);
        $this->set(compact('activeQuarter'));
    }

    function getrecord() {
        $cc = $this->Session->read('current_company');
        $id = $_REQUEST['id'];
        $quarterid = $_REQUEST['quarterid'];
        $activeQtr = $quarterId;
        $this->loadModel('Team');
        /* $dailyHuddle = $this->Team->find('list', array(
          'conditions' => array('Team.id' => $id )
          )); */
        $ro = $this->Team->team_users($id, $quarterid);
        $this->set(compact('ro'));

        $this->set(compact('quarterid'));
    }

    function editteam() {
        $this->layout = 'ajax';
        $id = $_REQUEST['id'];
        $teamid = $_REQUEST['team_id'];
        $redit = $this->Team->team_edit($id, $teamid);
        $this->set(compact('redit'));
        //pr($redit);			
    }

    function teamupdate() {
        $objective = $_POST['objective'];
        $assigned = $_POST['assigned'];
        $completed = $_POST['completed'];
        $updated = $_POST['updated'];
        $priority = $_POST['priorityid'];
        $team = $_POST['teamid'];

        $this->Team->team_set($objective, $assigned, $completed, $updated, $priority, $team);
        $this->redirect('dailyHuddle');
    }

    function deleteteam() {
        //pr($_REQUEST);
        $id = $_REQUEST['id'];
        $teamid = $_REQUEST['team_id'];
        //echo "here";
        $this->Team->team_delete($id, $teamid);
        $this->redirect('dailyHuddle');
    }

    function incrementDate($val) {
        $this->layout = false;
        $date = date("Y-m-d", strtotime("+1 day", strtotime($val)));
        echo $date;
        die;
    }
	
	function viewobjectivelog($id){
		$this->loadModel('User');
		$userModel = $this->User;
		$this->layout = 'ajax';
		$sql = "SELECT * FROM objectivelogs WHERE objective_id = $id";
		$logs = $this->Team->query($sql);
		$this->set(compact('logs'));
		$this->set('userModel', $userModel);
	}

}
