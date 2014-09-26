<?php 
class AllTestsTest extends CakeTestSuite {

/**
 * suite
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All tests');
		$suite->addTestDirectoryRecursive(TESTS . 'Case');
		return $suite;
	}
}
