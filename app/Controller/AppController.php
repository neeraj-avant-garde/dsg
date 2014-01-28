<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Auth' => array( 
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'authError' => 'You are not authorized to view this content!',
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email'),
                    'scope' => array('User.is_active' => 1, 'is_banned' => 0)
                )
            ),
            'loginRedirect' => array('controller' => 'companies', 'action' => 'dashboard'),
            'logoutRedirect' => array('controller' => 'pages', 'action' => 'index')
        ),
        'Session'
    );
    public $helpers = array('Html', 'Session', 'Form');

    function beforeFilter() {
        $this->Auth->allow(array('login', 'logout', 'display', 'register_company'));
        $this->Auth->authorize = 'Controller';
        Configure::write('debug', 1);
    }

    function isAuthorized($user) {
        $allowedActions = array(
            'add_priority',
            'index',
            'edit_priority',
            'update_objectives',
            'dashboard',
            'edit_dailypriority',
            'getuserbyname',
            'add_stuck',
            'edit_stuck',
            'dailyHuddle',
			'getrecord',	
            'onePage',
            'edit_team',
			'viewobjectivelog'
        );
        if (isset($user['group_id']) && ($user['group_id'] === '1' || $user['group_id'] === '3')) {
            return true;
        }
        if (in_array($this->params['action'], $allowedActions)) {
            return true;
        }
        return false;
    }

}

