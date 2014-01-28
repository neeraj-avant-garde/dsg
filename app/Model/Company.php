<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Company extends AppModel {

	public $validate = array(
		'name'=>array(
			'name'	=>	array(
				'rule'    => array('minLength', '4'),
				'allowEmpty'	=>	false,
				'required'	=>	true,
				'message' => 'Name is required and it must be minimum 4 characters long'
			),
			'unique'	=>	array(
				'rule'	=> 	'isUnique',
				'message'	=>	'Name is already used.'			
			)
		),	
		'email'=>array(
			'email'	=>	array(
				'rule'    => 'email',
				'allowEmpty'	=>	false,
				'required'	=>	'create',
				'message' => 'Valid email is required'
			),
			'unique'	=>	array(
				'rule'	=> 	'isUnique',
				'message'	=>	'Email is already used'			
			)
		),
		
		'phone' => array(
			'rule' => 'numeric',
			'allowEmpty'	=>	false,
			'required'	=>	true,
			'message' => 'Please enter a valid phone number'
		),
		
		'website' => array(
			'rule' => 'url',
			'allowEmpty'	=>	false,
			'required'	=>	true,
			'message' => 'Please enter a valid website url'
		),
		
		'bus_type' => array(
			'rule'    => array('minLength', '4'),
			'allowEmpty'	=>	false,
			'required'	=>	true,
			'message' => 'Bussiness type is required and it must be minimum 4 characters long'
		)
	);
	
	
	

		
	
	
}
