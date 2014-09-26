<?php
App::uses('Post', 'Model');

/**
 * Post Test Case
 *
 */
class PostTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.post',
		'app.category',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Post = ClassRegistry::init('Post');
	}

	//create function that get post that contain category name, user name
	//it can filter by category id

	public function testGetPost() {
		$posts = $this->Post->getPost();
		$this->assertTrue(count($posts) > 0);
		$this->assertTrue(!empty($posts[0]['Category']['name']));
		$this->assertTrue(!empty($posts[0]['User']['username']));
	}
	
	public function testGetPostByCategory() {
		$posts = $this->Post->getPost(1);
		$categoryId = Hash::extract($posts, '{n}.Post.category_id');
		$categoryId = array_unique($categoryId);
		$this->assertEquals(1, count($categoryId));
		$this->assertEquals($categoryId[0], 1);
	}

	public function testGetPostByEmptyCategory() {
		
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Post);

		parent::tearDown();
	}

}
