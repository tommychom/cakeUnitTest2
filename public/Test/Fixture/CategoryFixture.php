<?php
/**
 * CategoryFixture
 *
 */
class CategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Fast food',
			'created' => '2014-09-25 09:18:32',
			'modified' => '2014-09-25 09:18:32'
		),
		array(
			'id' => 2,
			'name' => 'Thai food',
			'created' => '2014-09-25 09:18:32',
			'modified' => '2014-09-25 09:18:32'
		),
		array(
			'id' => 3,
			'name' => 'Veterian food',
			'created' => '2014-09-25 09:18:32',
			'modified' => '2014-09-25 09:18:32'
		),
		array(
			'id' => 4,
			'name' => 'Japanese food',
			'created' => '2014-09-25 09:18:32',
			'modified' => '2014-09-25 09:18:32'
		),
		array(
			'id' => 5,
			'name' => 'Italian food',
			'created' => '2014-09-25 09:18:32',
			'modified' => '2014-09-25 09:18:32'
		),
		array(
			'id' => 6,
			'name' => 'Indian food',
			'created' => '2014-09-25 09:18:32',
			'modified' => '2014-09-25 09:18:32'
		),
	);

}
