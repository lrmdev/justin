<?php
App::uses('AppController', 'Controller');

class ProductsController extends AppController {

  public $helpers = array('Html', 'Form');

  public $components = array('Session', 'Paginator');

public function index() {
  $this->Product->recursive = -1;
  $this->set('products', $this->paginate());
  
public function view($id) {
  if (!($product = $this->Product->findById($id))) {
    throw new NotFoundException(__('Product not found'));
  }
  $this->set(compact('product'));
}
}

}
?>