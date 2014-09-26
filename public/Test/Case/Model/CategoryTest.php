<?php
App::uses('Category', 'Model');

/**
 * Category Test Case
 *
 */
class CategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Category = ClassRegistry::init('Category');
	}

	public function testGenerateCategoryList() {
		$categories = $this->Category->generateCategoryList();
		$this->assertEquals(6, count($categories));
		$this->assertTrue(empty($categories[0]));
		$this->assertEquals('Fast food', $categories[1]);
	}

	public function testGenrateCategoryListOrderASC() {
		$order = 'asc';
		$categories = $this->Category->generateCategoryList();
		$sortCat = $orgCat = array_values($categories);
		sort($sortCat);
		$this->assertEquals($sortCat, $orgCat);
	}

	public function testGenrateCategoryListOrderDESC() {
		$order = 'desc';
		$categories = $this->Category->generateCategoryList($order);
		$sortCat = $orgCat = array_values($categories);
		rsort($sortCat);
		$this->assertEquals($sortCat, $orgCat);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Category);

		parent::tearDown();
	}

}
