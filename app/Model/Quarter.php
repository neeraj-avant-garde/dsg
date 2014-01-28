<?php
App::uses('AppModel', 'Model');

class Quarter extends AppModel {
	
	function activeQtr($companyid = 1) {
		$sql = " SELECT * FROM `quarters` WHERE company_id = $companyid";
		$qtrs = $this->query($sql);
		foreach($qtrs as $qtr){
			$endTime = $qtr['quarters']['end_date'];
			$startTime = $qtr['quarters']['start_date'];
			$time = time();
			$endDate =  strtotime($endTime);
			$startDate =  strtotime($startTime);
			if($time >= $startDate && $time <= $endDate) {
				return $qtr['quarters']['id'];
			}	
		}
    }

}
