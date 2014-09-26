<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 */
class Category extends AppModel {

/**
 * generateCategoryList
 *
 * @param string $order - order of list
 * @return array category List
 */
	public function generateCategoryList($order = 'asc') {
		return $this->find('list', array('order' => array('name' => $order)));
	}
}
