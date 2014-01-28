<?php
App::uses('AppModel', 'Model');

class Priority extends AppModel {
	public $belongsTo = array('Quarter','User', 'Company');
}
