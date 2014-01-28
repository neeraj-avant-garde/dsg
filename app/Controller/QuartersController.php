<?php

App::uses('AppController', 'Controller');
App::uses('UserController', 'Controller');
App::uses('Sanitize', 'Utility');

class QuartersController extends AppController {

    public $layout = 'main';

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index_() {
        $quarters = $this->Quarter->find('all');
        $this->set(compact('quarters'));
        $this->view = 'quarters';
    }

    public function update_quarters() {

        if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
            if ($this->Quarter->saveAll($this->data['Quarter'], array('deep' => true))) {
                $this->Session->setFlash('Quarters has been updated', 'default', array('class' => 'success'));
                $this->redirect('/companies/companyProfile/');
            } 
        }
    }

    public function set_qtrs($start_date) {
		$effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($start_date)));
		
		//~ echo $effectiveDate; die;
        //~ $this->layout = false;
        //~ $end_date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($start_date)) . " + 365 days"));
         //~ $interval = 7.889e+6;
         //~ $chunks = array();
         //~ for ($time = strtotime($start_date); $time <= strtotime($end_date); $time+=$interval) {
            //~ $chunks[] = date('Y-m-d', $time);
         //~ }
        //~ $chunks[] = $end_date;
        //~ 
       // echo $date = strtotime("+3 months", date("Y-m-d", strtotime($start_date)));
       //echo $date = strtotime(date("Y-m-d", strtotime($start_date))."+3 months");
       
       
       $qtrs[1]['start_date'] = $start_date;
       $qtrs[2]['start_date'] = date('Y-m-d', strtotime("+3 months", strtotime($qtrs[1]['start_date'])));
       $qtrs[3]['start_date'] = date('Y-m-d', strtotime("+3 months", strtotime($qtrs[2]['start_date'])));
       $qtrs[4]['start_date'] = date('Y-m-d', strtotime("+3 months", strtotime($qtrs[3]['start_date'])));
       $qtrs[5]['start_date'] = date('Y-m-d', strtotime("+3 months", strtotime($qtrs[4]['start_date'])));
       
       $qtrs[1]['end_date'] = date('Y-m-d', strtotime("-1 day", strtotime($qtrs[2]['start_date'])));
       $qtrs[2]['end_date'] = date('Y-m-d', strtotime("-1 day", strtotime($qtrs[3]['start_date'])));
       $qtrs[3]['end_date'] = date('Y-m-d', strtotime("-1 day", strtotime($qtrs[4]['start_date'])));
       $qtrs[4]['end_date'] = date('Y-m-d', strtotime("-1 day", strtotime($qtrs[5]['start_date'])));
     
     
       
       
       //~ $qtrs[2]['start_date'] = date('Y-m-d', strtotime("+1 day", strtotime($qtrs[1]['start_date'])));
       //~ $qtrs[2]['end_date'] = date('Y-m-d', strtotime("+3 months", strtotime($qtrs[2]['start_date'])));
       //~ 
       //~ 
       //~ $qtrs[3]['start_date'] = date('Y-m-d', strtotime("+1 day", strtotime($qtrs[2]['start_date'])));
       //~ $qtrs[3]['end_date'] = date('Y-m-d', strtotime("+3 months", strtotime($qtrs[3]['start_date'])));
       //~ 
       //~ 
       //~ $qtrs[4]['start_date'] = date('Y-m-d', strtotime("+1 day", strtotime($qtrs[3]['start_date'])));
       //~ $qtrs[4]['end_date'] = date('Y-m-d', strtotime("+3 months", strtotime($qtrs[4]['start_date'])));
       
        echo json_encode($qtrs);

        die;
    }

}

