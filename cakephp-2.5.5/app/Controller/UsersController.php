<?php
App::uses('AppController', 'Controller');
    
class UsersController extends AppController {
	public function beforeFilter() {
  parent::beforeFilter();
  $this->Auth->allow();
}

public function register() {
  if ($this->request->is('post')) {
    $this->User->create();
	 if ($this->User->save($this->request->data)) {
      $this->Session->setFlash(__('New user registered'));
      return $this->redirect(array('action' => 'login'));
    }
    $this->Session->setFlash(__('Could not register user'));
  }
}

public function login() {
  if ($this->request->is('post')) {
    if ($this->Auth->login()) {
      return $this->redirect($this->Auth->redirectUrl());
    }
    $this->Session->setFlash(__('Incorrect username or password'));
  }
}

public function logout() {
  return $this->redirect($this->Auth->logout());
}
}