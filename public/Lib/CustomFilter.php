<?php
class CustomFilter {
	private $path;

	public function __construct($path) {
		$this->path = $path;
	}

	public function filter($arr) {
		return Hash::check($arr, $this->path);
	}
}