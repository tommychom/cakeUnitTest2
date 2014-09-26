<?php
App::uses('AppModel', 'Model');
/**
 * Group Model
 *
 */
class Group extends AppModel {

/**
 * Set ACL Behavior
 * @var array
 */
	public $actsAs = array('Acl' => array('type' => 'requester'));


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter group name.',
				'required' => false
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Group name already exist'
			)
		)
	);

/**
 * Set default parent node for ACL component
 * @return null
 */
	public function parentNode() {
        return null;
    }

/**
 * get Group list
 * @return array list of group
 */
    public function getGroupList() {
    	return $this->find('list', array('fields' => array('Group.name')));
    }
}
