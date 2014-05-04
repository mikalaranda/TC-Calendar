<?php

class UsersController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Js' => array('Jquery'));
    public $components = array('Session', 'RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('submit', 'logout', 'login');
    }

    public function index() {
        $this->set('users', $this->User->find('all'));
    }

    public function login() {
        if ($this->request->is('ajax')) {
            if ($this->Auth->login()) {
                return "Success";
            }
            return "fail";
        }
    }
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function submit(){
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $this->User->create();

            if($this->User->findByUsername($this->request->data['User']['username'])){
                echo "Sorry, that username is taken. Please try again.";
            } else {
                if ($this->User->save($this->request->data)) {
                    $u = $this->User->findById($this->User->id)['User'];
                    echo "Success";
                }else{
                    $this->response->statusCode(400);
                }
            }

            
        }
    }
}
?>