<?php
App::uses('ThemeShell', 'Theme.Console/Command');

class ThemeShellTest extends CakeTestCase
{
	public $theme = 'Test1';

	public function setUp() {
		App::build(array(
			'Console' => array(App::pluginPath('Theme') . DS . 'Test' . DS . 'test_app' . DS . 'Console' . DS),
		));
	}

	/**
	 * @dataProvider dataProviderForTestInstall
	 */
	public function testInstall($argv, $default, $defaultClass, $expectedFiles) {
		Configure::write('Theme.default', $default);
		Configure::write('Theme.defaultClass', $defaultClass);

		$base = realpath(App::pluginPath('Theme')) . '/Test/test_app/Console/Templates/';

		$expected = array();
		foreach ($expectedFiles as $source => $dist) {
			$source = str_replace('/', DS, $base . $source);
			$dist = str_replace('/', DS, $dist);
			$expected[$source] = $dist;
		}

		$actual = array();

		$Shell = $this->getMockBuilder('ThemeShell')
			->setMethods(array('copyFile', 'out', 'in'))
			->getMock();
		$Shell->expects($this->any())
			->method('copyFile')
			->will($this->returnCallback(function($source, $dest) use(&$actual){
				$actual[$source] = $dest;
			}));
		$Shell->interactive = false;
		$Shell->initialize();
		$Shell->runCommand('install', array_merge(array('install'), $argv));

		$this->assertEquals($expected, $actual);
	}

	public function dataProviderForTestInstall() {
		return array(
			array(
				array('--theme', 'Test1'), null, 'stdClass',
				array(
					'Test1/views/theme/Tests/test1.ctp' => APP . 'View/Themed/Test1/Tests/test1.ctp',
					'Test1/views/theme/webroot/test1.css' => APP . 'View/Themed/Test1/webroot/test1.css',
				),
			),
			array(
				array(), null, 'ThemeShellTest',
				array(
					'Test1/views/theme/Tests/test1.ctp' => APP . 'View/Themed/Test1/Tests/test1.ctp',
					'Test1/views/theme/webroot/test1.css' => APP . 'View/Themed/Test1/webroot/test1.css',
				),
			),
			array(
				array(), 'Test1', 'stdClass',
				array(
					'Test1/views/theme/Tests/test1.ctp' => APP . 'View/Tests/test1.ctp',
					'Test1/views/theme/webroot/test1.css' => APP . 'webroot/test1.css',
				),
			),
			array(
				array(), 'Test2', 'ThemeShellTest',
				array(
					'Test2/views/theme/Tests/test2.ctp' => APP . 'View/Tests/test2.ctp',
					'Test2/views/theme/webroot/test2.css' => APP . 'webroot/test2.css',
				),
			),
			array(
				array('--theme', 'Test2'), 'Test2', 'stdClass',
				array(
					'Test2/views/theme/Tests/test2.ctp' => APP . 'View/Tests/test2.ctp',
					'Test2/views/theme/webroot/test2.css' => APP . 'webroot/test2.css',
				),
			),
			array(
				array('--theme', 'Test2'), 'Test1', 'stdClass',
				array(
					'Test2/views/theme/Tests/test2.ctp' => APP . 'View/Themed/Test2/Tests/test2.ctp',
					'Test2/views/theme/webroot/test2.css' => APP . 'View/Themed/Test2/webroot/test2.css',
				),
			),
		);
	}
}
