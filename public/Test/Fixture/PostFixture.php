<?php
/**
 * PostFixture
 *
 */
class PostFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'title' => 'Post 1',
			'body' => 'Body 1',
			'category_id' => 1,
			'created' => '2014-09-26 03:25:46',
			'modified' => '2014-09-26 03:25:46',
			'user_id' => 1
		),
		array(
			'id' => 2,
			'title' => 'Post 2',
			'body' => 'Body 2',
			'category_id' => 2,
			'created' => '2014-09-26 03:25:46',
			'modified' => '2014-09-26 03:25:46',
			'user_id' => 2
		),
		array(
			'id' => 3,
			'title' => 'Post 3',
			'body' => 'Body 3',
			'category_id' => 3,
			'created' => '2014-09-26 03:25:46',
			'modified' => '2014-09-26 03:25:46',
			'user_id' => 3
		),
		array(
			'id' => 4,
			'title' => 'Post 4',
			'body' => 'Body 4',
			'category_id' => 4,
			'created' => '2014-09-26 03:25:46',
			'modified' => '2014-09-26 03:25:46',
			'user_id' => 1
		),
		array(
			'id' => 5,
			'title' => 'Post 5',
			'body' => 'Body 5',
			'category_id' => 5,
			'created' => '2014-09-26 03:25:46',
			'modified' => '2014-09-26 03:25:46',
			'user_id' => 2
		),
		array(
			'id' => 6,
			'title' => 'Post 6',
			'body' => 'Body 6',
			'category_id' => 6,
			'created' => '2014-09-26 03:25:46',
			'modified' => '2014-09-26 03:25:46',
			'user_id' => 3
		),
		array(
			'id' => 7,
			'title' => 'Post 7',
			'body' => 'Body 7',
			'category_id' => 1,
			'created' => '2014-09-26 03:25:46',
			'modified' => '2014-09-26 03:25:46',
			'user_id' => 1
		),
		array(
			'id' => 8,
			'title' => 'Post 8',
			'body' => 'Body 8',
			'category_id' => 2,
			'created' => '2014-09-26 03:25:46',
			'modified' => '2014-09-26 03:25:46',
			'user_id' => 2
		),
		array(
			'id' => 9,
			'title' => 'Post 9',
			'body' => 'Body 9',
			'category_id' => 3,
			'created' => '2014-09-26 03:25:46',
			'modified' => '2014-09-26 03:25:46',
			'user_id' => 3
		),
		array(
			'id' => 10,
			'title' => 'Post 10',
			'body' => 'Body 10',
			'category_id' => 4,
			'created' => '2014-09-26 03:25:46',
			'modified' => '2014-09-26 03:25:46',
			'user_id' => 1
		),
	);

}
