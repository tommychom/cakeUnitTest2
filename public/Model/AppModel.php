<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	public $recursive = -1;
	public $actsAs = array('Containable');

/**
 * custom validate rule 
 * compare between two input is equal
 * @param  array $check field for check
 * @param  string fields name want to compare
 * @return boolean
 */
	public function compareInput($check, $field) {
		$value = array_shift($check);
		return $value == $this->data[$this->alias][$field];
	}

	public function toggleActive($id) {
		if (!$this->hasField('active')) {
			return false;
		}

		$this->id = (int)$id;
		if (!$this->exists()) {
			return false;
		}
		$data = $this->read();
		$data = array(
			'id' => $id,
			'active' => !$data[$this->alias]['active']
		);
		return $this->save($data, false);
	}
}
