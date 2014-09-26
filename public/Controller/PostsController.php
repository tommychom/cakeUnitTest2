<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property PaginatorComponent $Paginator
 */
class PostsController extends AppController
{
/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator', 'Acl');
    public $uses = array();
/**
 * Helper
 *
 * @var array
 */
    public $helpers = array('Summernote.Summernote', 'Time');

    public function beforeFilter()
    {
        parent::beforeFilter();
        //$this->Auth->allow('index');
       
    }

    public function index(){
		debug($this->Auth->user('id'));
		$posts = $this->Post->getPost();
		$this->set(compact('posts'));
    }

/**
 * index method
 *
 * @return void
 */
    public function admin_index()
    {
        $this->Paginator->settings = array('limit' => 10, 'order' => array('updated' => 'DESC'));
         try {
            $this->set('posts', $this->Paginator->paginate('Post'));
        } catch (NotFoundException $e) {
            $this->redirect(array('action' => 'admin_index', 'admin' => true));
        }
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function view($id = null)
    {
        if (!$this->Post->exists($id)) {
            throw new NotFoundException(__('Invalid post'));
        }
        $options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
        $this->set('post', $this->Post->find('first', $options));
    }

/**
 * add method
 *
 * @return void
 */
    public function admin_add()
    {
        if ($this->request->is('post')) {
            $this->log($this->request->data);
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('The post has been saved.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));

                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The post could not be saved. Please, try again.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-error'
                ));
            }
        }
        $this->set('categories', $this->Post->Category->find('list'));
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null)
    {
        if (!$this->Post->exists($id)) {
            throw new NotFoundException(__('Invalid post'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('The post has been saved.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));

                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The post could not be saved. Please, try again.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-error'
                ));
            }
        } else {
            $options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
            $this->request->data = $this->Post->find('first', $options);
        }
        $this->set('categories', $this->Post->Category->find('list'));
    }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null)
    {
        $this->Post->id = $id;
        if (!$this->Post->exists()) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Post->delete()) {
            $this->Session->setFlash(__('The post has been deleted.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
        } else {
            $this->Session->setFlash(__('The post could not be deleted. Please, try again.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-error'
                ));
        }

        return $this->redirect(array('action' => 'index'));
    }}
