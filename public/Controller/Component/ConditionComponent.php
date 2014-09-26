<?php
App::uses('Component', 'Controller');
App::uses('AwPaginatorUtility', 'Lib');

class ConditionComponent extends Component {
	private $controller;
	public $components = array('Paginator');

	/**
	 * start up method run before beforeFilter
	 * @param  object $controller controller object
	 * @return none
	 */
	public function startup(&$controller) {
		$this->controller = $controller;
		$this->parseRequest();
	}

	/**
	 * convert query string to dot notation
	 * @return none
	 */
	public function parseRequest() {
		if (!empty($this->controller->request->query['sort'])) {
			$this->controller->request->query['sort'] = $this->underscoreToCamel($this->controller->request->query['sort']);
		}
	}

	/**
	 * automagic create condition with condition setting
	 * usage : array(
	 * 		'Model.field_name', // Model.field_name = $this->request->data[Model]['field_name']
	 * 		'Model.field_name' => 'LIKE', // Model.field_name LIKE '%$this->request->data[Model]['field_name']%'
	 * 		'date_format(Model.field_name, '%y%m%d') = ?' =>  array('Model.field_name') //date_format(Model.field_name, '%y%m%d') = $this->request->data['Model']['field_name']
	 * )
	 * @param  array  $cond  condition setting
	 * @return array conditon array for use with find or paginator
	 */
	public function createConditions($cond,$data = array(), $out = array(), $parse = true) {
		if ($this->controller->request->is('post')) {
			$data = $this->controller->request->data;
		} else {
			$this->controller->request->data = $data = $this->queryToData($this->controller->request->query);
		}

		if (!is_array($cond) || empty($data)) return array();

		$fdata = Set::flatten($data);
		$fdata = Hash::filter($fdata);
		foreach ($cond as $field => $operator) {
			if (in_array(strtolower($field), array('and','or','xor'))) {
				$out[$field] = $this->createConditions($operator,$data);
			} else {
				if (!is_numeric($field)) {
					$fieldArray = $this->createField($field,$operator,$data);
					if ($fieldArray != false)
						$out = array_merge($out, $fieldArray);
				} else {
					if (isset($fdata[$operator]))
						$out[$operator] = $fdata[$operator];
				}
			}
		}
		return $out;
	}

	public function createField($field,$operator,$data) {
		$fdata = Set::flatten($data);
		//check condition is string
		if ($operator === null) {
			return array($field);
		}

		//check condition is oepration perform eg. > , < , >= , <=, LIKE, != 
		if (strpos($field, '?') === false) {
			
			if (empty($fdata[$field]) && @$fdata[$field] !== 0 && @$fdata[$field] !== '0') {
				return false;
			}

			$val = $fdata[$field];
			if ($operator == 'LIKE') {
				list($key, $value) = $this->escapeLike($val);
				$out[$field . ' ' . $key] = array($value);
			} else {
				$out[$field . ' ' . $operator] = $val;
			}
			return $out;
		}

		// check condition is format type
		if (strpos($field, '?') >= 0) {
			$val = array();
			foreach ($operator as $f) {
				if (empty($fdata[$f]) && @$fdata[$field] !== 0 && @$fdata[$field] !== '0') return false;

				array_push($val, $fdata[$f]); 	
			}
			$out[$field] = $val;
			return $out;
		}

		return false;
	}

	public function queryToData($query) {
		$data = array();
		foreach ($query as $key => $value) {
			if (!in_array($key, $this->Paginator->whitelist)) {
				$key = $this->underscoreToCamel($key);
				if ($key) {
					list($model, $field) = explode('.', $key);
					$data[$model][$field] = $value;
				}
			}
		}
		return $data;
	}

	public function underscoreToCamel($underscoreStr) {
		if (strpos($underscoreStr, '__') === false) {
			return false;
		}

		list($model, $field) = explode('__', $underscoreStr);
		$model = Inflector::camelize($model);
		
		return $model . '.' . $field;
	}

	public function requestToQuery($fields) {
		if (empty($fields)) {
			return $fields;
		}

		$awUtility = new AwPaginatorUtility();
		if (!$this->isAssoc($key)) {
			return $awUtility->flattenToQuery($fields);
		}

		$data = Hash::flatten($this->request->data);
		$result = array();
		foreach ($fields as $field) {
			if (!empty($data[$field]) || $data[$field] === 0) {
				$result[$awUtility->camelToUnderScore($field)] = $data[$field];
			}
		}

		return $result;
	}

	public function isAssoc($arr) {
    	return array_keys($arr) !== range(0, count($arr) - 1);
	}

	public function escapeLike($value) {
		$escapeVal = '=';
		$key = "LIKE ? ESCAPE '" . $escapeVal . "'";
		$value = '%' . str_replace(array($escapeVal, '%', '_'), array($escapeVal . $escapeVal, $escapeVal . '%', $escapeVal . '_'), $value) . '%';
		return array($key, $value);
	}
}