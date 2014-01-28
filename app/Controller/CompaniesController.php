<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Companies Controller
 *
 */
class CompaniesController extends AppController {

    public $layout = 'main';

    public function index() {
        
    }

    public function dashboard() {


        $named = $this->request->named;
        if (!empty($named['Quarter'])) {
            $activeQtr = $named['Quarter'];
        } else {
            $activeQtr = $this->getActiveQtr();
        }


        $logged_user = $this->Session->read('Auth.User');
        $this->layout = 'main';
        $this->loadModel('Dailypriority');
        $this->loadModel('Planfield');
        $dailyModel = $this->Dailypriority;
        $this->set(compact('dailyModel'));

        $criticalnumbers = $this->Planfield->find('all', array(
            'fields' => array('criticalnumbers'),
            'conditions' => array(
                'company_id' => $logged_user['company_id'],
                'quarter_id' => $activeQtr
            ))
        );
        $this->loadModel('Priority');
        $Priority = $this->Priority;
        $this->set(compact('Priority'));
        $this->set(compact('activeQtr'));
        $this->set('criticalnumbers', $criticalnumbers[0]);
    }

    public function getActiveQtr() {
        $this->loadModel('Quarter');
        $sql = " SELECT id FROM `quarters` WHERE CURDATE() > DATE(`start_date`) AND CURDATE() < DATE(`end_date`)  LIMIT 1";
        $qtrs = $this->Quarter->query($sql);
        return $qtrs[0]['quarters']['id'];
    }

    public $paginate = array(
        'limit' => 15,
        'order' => array(
            'id' => 'desc'
        )
    );

    function superAdminDashboard() {

        $companies = $this->paginate('Company');
        $this->set('companies', $companies);
    }

    public function companyProfile($id = null) {
        $current_user = $this->Session->read('Auth.User');
        $id = $current_user['company_id'];
        $this->Company->id = $id;
        if (!$this->Company->exists()) {
            $this->Session->setFlash(__('Company not exists'));
            $this->redirect('/companies/dashboard');
        }
        $this->request->data = $this->Company->read('', $id);
        $this->loadModel('Quarter');
        $comp_id= $this->Session->read('current_company');
        //echo $rrr;
        $quarters = $this->Quarter->find('all', 
									array(
										'conditions'=>array('Quarter.company_id'=>$comp_id),
									
										'order' => 'id ASC'
									)
								);

			//pr($mmm);
			//pr($rrr);
			//die('dssfd');					

        $this->set(compact('quarters'));
    }

    /* Add Company */

    public function register_company() {
        $this->loadModel('User');
        $this->loadModel('Planfield');
        $this->loadModel('Quarter');
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Company->save($this->request->data)) {
                $data = $this->request->data;
                $name = $companyName = explode(' ', $data['Company']['name']);
                $user['User']['firstname'] = $companyName[0];
                $user['User']['lastname'] = $companyName[1];
                $email = $user['User']['email'] = $data['Company']['email'];
                $phone = $user['User']['phone'] = $data['Company']['phone'];
                $password = $user['User']['password'] = substr(uniqid(), 0, 7);
                $user['User']['group_id'] = 1;
                $user['User']['company_id'] = $this->Company->getInsertID();
                $company_id= $this->Company->getInsertID();
				$date = date("Y-m-d");
			
				
                $user['Quarter'][0]['name'] = 'Q1';
                $user['Quarter'][0]['start_date'] = '2013-01-01';
                $user['Quarter'][0]['end_date'] =  '2013-03-31';
                $user['Quarter'][0]['current'] = '0';
				$user['Quarter'][0]['created'] = date("Y-m-d H:i:s");
				$user['Quarter'][0]['modified'] = date("Y-m-d H:i:s");
				$user['Quarter'][0]['company_id'] =  $company_id;
				
				$user['Quarter'][1]['name'] = 'Q2';
                $user['Quarter'][1]['start_date'] = '2013-04-01';
                $user['Quarter'][1]['end_date'] =   '2013-06-31';
                $user['Quarter'][1]['current'] = '0';
				$user['Quarter'][1]['created'] = date("Y-m-d H:i:s");
				$user['Quarter'][1]['modified'] = date("Y-m-d H:i:s");
				$user['Quarter'][1]['company_id'] = $company_id;
				
				 $user['Quarter'][2]['name'] = 'Q3';
                $user['Quarter'][2]['start_date'] = '2013-07-01';
                $user['Quarter'][2]['end_date'] =  '2013-09-31';
                $user['Quarter'][2]['current'] = '0';
				$user['Quarter'][2]['created'] = date("Y-m-d H:i:s");
				$user['Quarter'][2]['modified'] = date("Y-m-d H:i:s");
				$user['Quarter'][2]['company_id'] =  $company_id;
				
				 $user['Quarter'][3]['name'] = 'Q4';
                $user['Quarter'][3]['start_date'] = '2013-10-01';
                $user['Quarter'][3]['end_date'] =   '2013-12-31';
                $user['Quarter'][3]['current'] = '0';
				$user['Quarter'][3]['created'] = date("Y-m-d H:i:s");
				$user['Quarter'][3]['modified'] = date("Y-m-d H:i:s");
				$user['Quarter'][3]['company_id'] =  $company_id;
				
				
				$this->Quarter->saveAll($user['Quarter'], array('deep' => true));
				
                /* One Page Plan Code */

                $company_id = $this->Company->getInsertID();

                $this->Planfield->company_id = $company_id;

                $this->Planfield->people = '{"title":"People","subtitle":"Relationship Drivers","employees":{"title":"Employees","names":["","",""]},"customers":{"title":"Customers","names":["","",""]},"shareholders":{"title":"Shareholders","names":["","",""]}}';
                $this->Planfield->corevalues = '{"title":"Core Values","subtitle":"Should\/shouldn\'t","values":["","","",""]}';
                $this->Planfield->purpose = '{"title":"Purpose","subtitle":"why","value":""}';
                $this->Planfield->targets = '{"title":"Targets (3-5 years)","subtitle":"Where","values":{"":"","":"","":""}}';
                $this->Planfield->goals = '{"title":"Goals (1 year)","subtitle":"What","values":{"":"","":"","":""}}';
                $this->Planfield->sandbox = '{"title":"Sandbox","value":""}';
                $this->Planfield->actions = '{"title":"Actions","subtitle":"To Live Values, Purpose, BHAG","values":["","","","",""]}';
                $this->Planfield->capabilities = '{"title":"Key Thrusts\/Capabilities","subtitle":"3-6 Priorities","values":["","","","","",""]}';
                $this->Planfield->keyinitiatives = '{"title":"Key Initiatives","subtitle":"Annual Priorities","values":["","","","","",""]}';
                $this->Planfield->corecompetencies = '{"title":"Core Competencies","values":["","","","","","","","","",""]}';
                $this->Planfield->profit = '{"title":"Profit\/X","value":""}';
                $this->Planfield->bhag = '{"title":"BHAG�","value":""}';
                $this->Planfield->brand_kpi = '{"title":"Brand Promises KPIs","value":""}';
                $this->Planfield->brand = '{"title":"Brand Promises","value":""}';
                $this->Planfield->criticalnumbers = '{"title":"Critical Numbers","subtitle":"Critical Number: Enter Name","values":["","","","","",""]}';
                $this->Planfield->swot = '{"title":"SWOT","strengths":{"title":"Strengths","values":["","","",""]},"opportunities":{"title":"Opportunities","values":["","","",""]},"weaknesses":{"title":"Weaknesses","values":["","","",""]},"threats":{"title":"Threats","values":["","","",""]}}';
                $this->Planfield->process = '{"title":"Process","subtitle":"Productivity Drivers","make":{"title":"Make\/Buy","values":["","",""]},"sell":{"title":"Sell","values":["","",""]},"recordkeeping":{"title":"Record Keeping","values":["","",""]}}';
                $this->Planfield->actionsqtr = '{"title":"Actions (QTR)","subtitle":"How","values":{"":"","":"","":""}}';
                $this->Planfield->theme = '{"title":"Themes","subtitle":"Qtr\/Annual","theme_name":"Theme","theme_value":"","deadline_title":"Deadline","deadline_value":"","measurable_title":"Measurable Target\/Critical #","measurable_value":""}';
                $this->Planfield->celebration = '{"title":"Celebration","value":""}';
                $this->Planfield->reward = '{"title":"Reward","value":""}';

                for ($i = 1; $i <= 4; $i++) {
                    $this->Planfield->quarter_id = $i;
                    $this->Planfield->saveAll(array($this->Planfield));
                    $added[] = 'true';
                }

                /* -- One Page Plan Code */

                if (!empty($added)) {
                    if ($this->User->save($user)) {
                        $Email = new CakeEmail();
                        $to = $user['User']['email'];
                        $Email->viewVars(compact('to'));
                        $Email->viewVars(compact('password'));
                        $Email->from(array('info@dsg.com' => 'DSG'));
                        $headers[] = "MIME-Version: 1.0";
                        $headers[] = "Content-type:text/html;charset=iso-8859-1";
                        $Email->addHeaders($headers);
                        $Email->emailFormat('html');
                        $Email->template('register_company');
                        $Email->to($to);
                        $Email->bcc('amit.rana@60degree.com');

                        $Email->subject('DSG: Login details for your company(' . $to . ')');

                        $Email->send($body);
                        $this->Session->setFlash('Your Company has been registerd successfully, Please check your email for your login details ', 'default', array('class' => 'success'));
                        $this->redirect('/login');
                    } else {
                        $errors = $this->User->validationErrors;
                    }
                }
            } else {
                $this->Session->setFlash(__('The Company could not be registerd. Please, check below errors.'));
            }
        }
    }

    /* Edit Company */

    public function edit_company($id = null) {
        $current_user = $this->Session->read('Auth.User');
        $id = $current_user['company_id'];
        $this->Company->id = $id;
        if (!$this->Company->exists()) {
            $this->Session->setFlash(__('Company not exists'));
            $this->redirect('/companies/dashboard');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Company->save($this->request->data)) {
                $this->Session->setFlash('The Company info has been updated', 'default', array('class' => 'success'));
                $this->redirect('/companies/companyProfile');
            } else {
                $this->Session->setFlash(__('The Company could not be updated. Please, check below errors.'));
            }
        } else {
            $this->request->data = $this->Company->read('', $id);
        }
    }   
	
	/* Update Company Qtr Type*/

    public function updateCompanyQtrType($id = null) {
        $current_user = $this->Session->read('Auth.User');
        $id = $current_user['company_id'];
        $this->Company->id = $id;
        if (!$this->Company->exists()) {
            $this->Session->setFlash(__('Company not exists'));
            $this->redirect('/companies/dashboard');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$range = $data['Company']['qtrrangetype'];
			$query = "UPDATE companies SET qtrrangetype = $range WHERE id = $id";
            if ($this->Company->query($query)) {
                $this->Session->setFlash('Financial year range has been changed', 'default', array('class' => 'success'));
                $this->redirect('/companies/companyProfile');
            } else {
				 $this->Session->setFlash('Financial year range has been changed', 'default', array('class' => 'success'));
				$this->redirect('/companies/companyProfile/');
			}
        }
    }

    /* Delete Company */

    public function delete_company($id = null) {
        $current_user = $this->Session->read('Auth.User');
        $this->Company->id = $id;
        if ($current_user['group_id'] == 3) {
            if ($this->Company->delete()) {
                $this->Session->setFlash('The Company has been deleted successfully', 'default', array('class' => 'success'));
                $this->redirect('/companies/superAdminDashboard');
            }
        } else {
            $this->Session->setFlash(__('You are not autherized to view this content'));
            $this->redirect('/dashboard');
        }
    }

    /* Login as company */

    public function loginAsCompany($id = null) {
        $this->loadModel('User');
        $current_user = $this->Session->read('Auth.User');

        $user = $this->User->find('first', array('conditions' => array('User.company_id' => $id, 'User.group_id' => 1)));

        $userArray = $user['User'];
        $userArray['Group'] = $user['Group'];
        $userArray['Company'] = $user['Company'];
        unset($userArray['password']);
        $this->Session->write('super_user_id', $current_user['id']);
        $this->Session->write('current_company', $userArray['company_id']);
        $this->Session->write('Auth.User', $userArray);

        $this->Session->setFlash('You are successfully logged in as Company', 'default', array('class' => 'success'));
        $this->redirect('/dashboard');
    }

    public function logOutAsCompany() {
        $this->loadModel('User');
        $current_user = $this->Session->read('Auth.User');

        $user = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('super_user_id'), 'group_id' => 3)));

        $userArray = $user['User'];
        $userArray['Group'] = $user['Group'];
        $userArray['Company'] = $user['Company'];
        unset($userArray['password']);

        $this->Session->write('Auth.User', $userArray);

        $this->Session->setFlash('You are successfully logged Out as Company', 'default', array('class' => 'success'));

        $this->redirect('/companies/superAdminDashboard/');
    }

}
