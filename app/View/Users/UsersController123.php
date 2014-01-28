<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    public $layout = 'main';

    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * login method
     */
    public function login() {

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $logged_user = $this->Session->read('Auth.User');
                if ($logged_user['group_id'] == 3) {
                    $this->Session->setFlash('Welcome Super administator, You are successfully logged in', 'default', array('class' => 'success'));
                    return $this->redirect('/companies/superAdminDashboard');
                }
                $this->Session->write('current_company', $this->Session->read('Auth.User.company_id'));
                $this->Session->setFlash('You are successfully logged in', 'default', array('class' => 'success'));
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
                return $this->redirect('/');
            }
        }
    }

    /**
     * logout method
     */
    public function logout() {
        $this->Session->setFlash('Thank You for using aligntoday.com', 'default', array('class' => 'success'));
        session_destroy();
		$this->redirect($this->Auth->logout());
		
    }

    /**
     * add method
     */
    public function adduser() {

        if ($this->request->is('post')) {
            $this->User->data = Sanitize::clean($this->data);
            $this->User->data['User']['activation_hash'] = $this->User->generateHash(20);
            if ($this->User->validates()) {
                if ($this->User->save($this->User->data)) {
                    $uid = $this->User->getInsertID();
		
                    //$this->addUserImage($uid);
                    $this->Session->setFlash('Thank You for registering.', 'default', array('class' => 'success'));
                    $this->redirect('/users/users');
                } else {
                    $this->data['User']['password'] = null;
                }
            } else {
                $errors = $this->User->validationErrors;
            }
        }

        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    function change_password($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash(__('User not exists'));
            $this->redirect('/users/users');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Password has been changed.', 'default', array('class' => 'success'));
                $this->redirect('/users/users');
            } else {
                $this->Session->setFlash('Password could not be changed.');
                $this->redirect(Controller::referer());
                exit;
            }
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash(__('User not exists'));
            $this->redirect('/users/users');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                if (!empty($_REQUEST['image_name'])) {
                    $this->addUserImage($id);
                }
                $this->Session->setFlash('The user has been updated', 'default', array('class' => 'success'));
                $this->redirect('/users/users');
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {

            $this->request->data = $this->User->read('', $id);
            $groups = $this->User->Group->find('list');
            $this->set(compact('groups'));
        }
    }

    public function delete($id = null) {

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash('User deleted', 'default', array('class' => 'success'));
            $this->redirect('/users/users');
        }
        $this->Session->setFlash('User was not deleted', 'default', array('class' => 'error'));
        $this->redirect('/users/users');
    }

    public $paginate = array(
        'limit' => 5,
        'order' => array(
            'User.id' => 'desc'
        )
    );

    public function users() {

        $users = $this->paginate('User', array('company_id' => $this->Session->read('current_company')));
    
        $this->set('users', $users);
    }

    public function getuserbyname($name = null) {
        $this->layout = false;
        $cc = $this->Session->read('current_company');
        $qry = "SELECT * FROM users WHERE company_id = $cc AND ( firstname LIKE '%$name%' OR lastname LIKE '%$name%' )";
        $users = $this->User->query($qry);
        foreach ($users as $user) {
            echo '<li id=' . $user['users']['id'] . ' onclick="setuser(this.id)" class="user_' . $user['users']['id'] . '">';
            echo '<img src="' . Router::url('/') . 'avtars/' . $user['users']['avtar'] . '" width=50/>';
            echo '<span id="username">' . $user['users']['firstname'] . ' ' . $user['users']['lastname'] . '</span><br>' . $user['users']['email'];
            echo '</li>';
        }
        die;
    }

    public function modify_group($id = null) {

        $this->layout = 'ajax';
        $this->User->id = $id;

        if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Group has been modified', 'default', array('class' => 'success'));
                $this->redirect('/users/users');
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {

            $this->request->data = $this->User->read('', $id);
            $groups = $this->User->Group->find('list', array('conditions' => array('Group.id IN' => array(1, 2))));
            $this->set(compact('groups'));
        }
    }

    public function uploadimage() {

        require_once('SimpleImage.php');

        $folder_path = APP . '/webroot/avtars/';
        $file_path = $folder_path . $_FILES["file"]["name"];


        $file = $_FILES['file'];
        move_uploaded_file($_FILES["file"]["tmp_name"], $file_path);

        $image = new SimpleImage();
        $image->load($file_path);

        $width = $image->getWidth();
        $height = $image->getHeight();
        if ($width > 150 || $height > 150) {
            $image->resize(150, 150);
            $image->save($file_path);
        }
        die($_FILES["file"]["name"]);
    }

    protected function addUserImage($uid) {
        if (!empty($_REQUEST)) {
            $folder_path = APP . '/webroot/avtars/';
            $targ_w = 100;
            $targ_h = 80;
            $jpeg_quality = 90;
            $img = $_REQUEST['image_name'];
            $src = $folder_path . $img;
            $src = str_replace('\\', '/', $src);
            $ext = strtolower(end(explode('.', $img)));
            $img_r = imagecreatefromstring(file_get_contents($src));
            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
            imagecopyresampled($dst_r, $img_r, 0, 0, $_REQUEST['x'], $_REQUEST['y'], $targ_w, $targ_h, $_REQUEST['w'], $_REQUEST['h']);
            if ($ext == 'png') {
                $avtar = 'avt_' . $uid . '.png';
                imagepng($dst_r, $folder_path . $avtar, 9);
            }
            if ($ext == 'gif') {
                $avtar = 'avt_' . $uid . '.gif';
                imagegif($dst_r, $folder_path . $avtar, $jpeg_quality);
            }
            if ($ext == 'jpg') {
                $avtar = 'avt_' . $uid . '.jpg';
                imagejpeg($dst_r, $folder_path . $avtar, $jpeg_quality);
            }
            imagedestroy($img_r);

            if (strpos($src, 'avt_') == false) {
                unlink($src);
            }

            $this->User->id = $uid;
            $this->User->saveField('avtar', $avtar);
        }
    }

}
