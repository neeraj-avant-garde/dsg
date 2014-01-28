<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Album $Album
 * @property Audio $Audio
 * @property UserfieldValue $UserfieldValue
 * @property Video $Video
 */
class User extends AppModel {

	public $name = 'User';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
 public $hasAndBelongsToMany = array(
    'Team' => array(
      'className' => 'Team',
      'joinTable' => 'team_users',
      'foreignKey' => 'user_id',
      'associationForeignKey' => 'team_id',
    )
  );
	public $validate = array(
		'email'=>array(
			'email'	=>	array(
				'rule'	=>	'email',
				'allowEmpty'	=>	false,
				'required'	=>	'create'
			),
			'unique'	=>	array(
				'rule'	=> 	'isUnique',
				'message'	=>	'Email is already registered.'			
			)
		),
		'password'=>array(
			'rule'    => array('minLength', '6'),
			'required'	=>	'create',
			'allowEmpty'	=>	false,
            'message' => 'Minimum 6 characters long.'
		)
		);
		
	public function cPasswords($field = null){
        return (Security::hash($field['confirm_password'], null, true) === $this->data['User']['password']);
    }	
	public $belongsTo = array('Group','Company');

	public function beforeSave($options = array()) {
	
		//hash the password only in case of create
		if(isset($this->data[$this->alias]['password']) && !isset($this->data[$this->alias]['id'])) {
		$hash = AuthComponent::password($this->data[$this->alias]['password']);
		
		$this->data[$this->alias]['password'] = $hash;
		}

		return true;
	}	
	
	public function generateHash($length = 10) {
                return substr(Security::hash(Configure::read('Security.salt') . time() ), 0, $length);
    }	
	
}
