<?php
App::uses('PostsController', 'Controller');

/**
 * PostsController Test Case
 *
 */
class PostsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.post',
		'app.user',
		'app.category'
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndexVars() {
		$this->testAction('/posts/index', array(
			'method' => 'get',
			'return' => 'vars'
		));
		$this->assertTrue(count($this->vars['posts']) > 1);
	}

	public function testIndexView() {
		$posts = $this->Generate('Posts', array('components' => array('Auth')));
		$posts->Auth->staticExpects($this->any())
		->method('user')
		->with('id')
		->will($this->returnValue(1));
		$this->testAction('/posts/index', array(
			'method' => 'GET',
			'return' => 'view'
		));
		$this->assertRegExp('/<td>/', $this->view);
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	}

}
