<?php
/**
 * All Theme plugin tests
 */
class AllThemeTest extends PHPUnit_Framework_TestSuite {

/**
 * Assemble Test Suite
 * 
 * @return PHPUnit_Framework_TestSuite
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Tests');
		$suite->addTestDirectoryRecursive(App::pluginPath('Theme') . 'Test' . DS . 'Case' . DS);
		return $suite;
	}

}
