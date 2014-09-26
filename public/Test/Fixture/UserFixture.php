<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'role' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'group_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'verify' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4, 'unsigned' => false),
		'active' => array('type' => 'integer', 'null' => true, 'default' => '1', 'length' => 4, 'unsigned' => false),
		'last_login_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'username' => 'admin',
			'password' => '$2a$10$GDm6vNlV6nRtY9Oi4wH3fOerq3Uj2G6TYoq.lP3gRlzrBkmTBFf12',
			'role' => '',
			'created' => '2013-09-18 07:49:09',
			'modified' => '2014-09-25 08:12:29',
			'group_id' => '1',
			'verify' => '1',
			'active' => '1',
			'last_login_date' => '2014-09-25 08:12:29'
		),
		array(
			'id' => 2,
			'username' => 'tommymanager',
			'password' => '$2a$10$rVqnABPODyANNZeP1TSJB.BEkhCciOozEOzXsh3XWE3RjfErQMAey',
			'role' => '',
			'created' => '2013-09-18 08:26:25',
			'modified' => '2013-09-18 08:26:25',
			'group_id' => '2',
			'verify' => '1',
			'active' => '1',
			'last_login_date' => '2013-09-18 07:53:11'
		),
		array(
			'id' => 3,
			'username' => 'tommyusers',
			'password' => '$2a$10$R7EVT.N8qM4H1aXlxmqrt.nudPotWPfz9R7x8Ew9QbCdkkqyBLama',
			'role' => '',
			'created' => '2013-09-18 08:26:51',
			'modified' => '2013-09-18 08:26:51',
			'group_id' => '3',
			'verify' => '1',
			'active' => '1',
			'last_login_date' => '2013-09-18 07:53:11'
		),
	);

}
