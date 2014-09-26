<?php
class AwPaginatorUtility
{
	public function camelToUnderScore($calmelStr) {
		if (strpos($calmelStr, '.') === false) {
			return $calmelStr;
		}
		
		$modelField = explode('.', $calmelStr);
		$modelField[0] = Inflector::underscore($modelField[0]);
		return strtolower(implode('__', $modelField));
	}

	public function flattenToQuery($flatArray) {
		$query = array();
		foreach ($flatArray as $key => $value) {
			$query[$this->camelToUnderScore($key)] = $value;
		}
		return $query;
	}

	public function underscoreToCamel($underscoreStr) {
		if (strpos($underscoreStr, '__') === false) {
			return false;
		}

		list($model, $field) = explode('__', $underscoreStr);
		$model = Inflector::camelize($model);
		
		return $model . '.' . $field;
	}
}