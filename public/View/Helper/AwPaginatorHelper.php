<?php
App::uses('PaginatorHelper', 'View/Helper');

class AwPaginatorHelper extends AppHelper {

	public $helpers = array('Paginator');

	public function beforeRender() {
		$paginatorOptions = array('url' => array());

		$data = Hash::filter(Hash::flatten($this->request->data));
		if (!empty($data)) {
			$data = $this->reFormatKeys($data);
			$paginatorOptions =	array(
				'convertKeys' => array_keys($data),
				'url' => array('?' => $data)
			);
		}

		$sortKey = $this->Paginator->sortKey();
		$sortDir = $this->Paginator->sortDir();

		if (!empty($sortKey)) {
			$paginatorOptions['url'] = array_merge($paginatorOptions['url'], array('sort' => $this->camelToUnderScore($sortKey), 'direction' => $sortDir));
		}
		$this->Paginator->options($paginatorOptions);
	}

	public function sort($field, $title, $options = array()) {
		$sortKey = $this->Paginator->sortKey();
		$sortDir = strtolower($this->Paginator->sortDir());

		$default = array('escape' => false);
		$options = array_merge($default, $options);
		$class = array('asc' => 'glyphicon-sort-by-alphabet', 'desc' => 'glyphicon-sort-by-alphabet-alt');

		if ($field == $sortKey) {
			$title .= ' <span class="glyphicon '. $class[$sortDir] .'"></span>';

			if (strtolower($sortDir) == 'desc') {
				$sortDir = 'asc';
			} elseif (strtolower($sortDir) == 'asc') {
				$sortDir = 'desc';
			}

			$options['url'] = array('direction' => $sortDir);
		}

		return $this->Paginator->sort($this->camelToUnderScore($field), $title, $options);
	}

	private function reFormatKeys($data) {
		$newData = array();
		foreach ($data as $key => $value) {
			$key = $this->camelToUnderScore($key);
			$newData[$key] = $value;
			unset($data[$key]);
		}
		return $newData;
	}

	private function camelToUnderScore($calmelStr) {
		if (strpos($calmelStr, '.') === false) {
			return $calmelStr;
		}
		
		$modelField = explode('.', $calmelStr);
		$modelField[0] = Inflector::underscore($modelField[0]);
		return strtolower(implode('__', $modelField));
	}

}