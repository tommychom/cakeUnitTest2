<?php
App::uses('AppHelper', 'Helper');
class AwHelper extends AppHelper {

	public $helpers = array('Html', 'Paginator');

	public function booleanToText($bool, $type = 'icon') {
		$setting = array(
			'yn' => array(
				'0' => 'No',
				'1' => 'Yes'
			),
			'active' => array(
				'0' => 'Active',
				'1' => 'Inactive'
			),
			'icon' => array(
				'0' => '<span class="glyphicon glyphicon-remove text-danger"></span>',
				'1' => '<span class="glyphicon glyphicon-ok text-success"></span>'
			)
		);
		return $setting[$type][$bool];
	}

	public function jsTree($array, $options) {
		$default = array(
			'empty' => '',
			'select_empty' => false,
			'clicked' => 0,
			'opened' => 0,
			'disabled' => 0
		);
		$options = array_merge($default, $options);
		if ($options['empty'] != '') {
			$attr = array();
			if ($options['select_empty']) {
				$attr = array('class' => 'jstree-clicked');
			}
			$link = $this->Html->link($options['empty'], 'javascript:void(0);', $attr);
			$empty = $this->Html->tag('li', $link);
		}
		return $this->Html->tag('ul', $empty . $this->treeMenu($array, $options));
	}

	public function treeMenu($array, $options) {
		$str = '';
		foreach ($array as $value) {
			$attr = array();
			$class = '';
			if ($options['clicked'] == $value['Node']['id']) {
				$attr = array('class' => 'jstree-clicked');
			}
			if ($options['disabled'] == $value['Node']['id']) {
				$attr = array_merge($attr, array('class' => 'jstree-disabled'));
			}
			$link = $this->Html->link($value['Node']['title_number'], 'javascript:void(0);', $attr);
			if (empty($value['children'])) {
				$str .= $this->Html->tag('li', $link, array('id' => $value['Node']['id']));
			} else {
				if (in_array($value['Node']['id'], $options['opened'])) {
					$class = ' jstree-open';
				}
				$str .= '<li id="' . $value['Node']['id'] .'" class="'. $class .'">' . $link . '<ul>';
				$str .= $this->treeMenu($value['children'], $options);
				$str .= '</ul></li>';
			}
		}
		return $str;
	}
}