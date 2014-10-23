<?php
App::uses('AppController', 'Controller');

class CustomersController extends AppController {

  public $helpers = array('Html', 'Form');

  public $components = array('Session', 'Paginator');

public function index() {
  $this->Customer->recursive = -1;
  $this->set('customers', $this->paginate());
}
  public function view($id) {
  if (!($customer = $this->Customer->findById($id))) {
    throw new NotFoundException(__('Product not found'));
  }
  $this->set(compact('customer'));
}
}


?>