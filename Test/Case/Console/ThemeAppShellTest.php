<?php
App::uses('ThemeAppShell', 'Theme.Console/Command');

class BakeShell extends ThemeAppShell {
	public function getOptionParser() {
		$parser = parent::getOptionParser();
		$parser->addOption('theme');
		return $parser;
	}
}

class ThemeAppShellTest extends CakeTestCase
{
	/**
	 * @dataProvider dataProviderForTestBase
	 */
	public function testBake($class, $useThemePath, $expectedArgs, $expectedTasks) {
		Configure::write('Theme.name', 'Cake3');
		Configure::write('Theme.useThemePath', $useThemePath);

		$Shell = $this->getMockBuilder($class)
			->setMethods(array('__get', 'startup'))
			->getMock();

		$Shell->tasks = array('View');

		$View = $this->getMockBuilder('Shell')
			->setMethods(array('runCommand'))
			->getMock();

		$Shell->expects($this->once())
			->method('__get')
			->with('View')
			->will($this->returnValue($View));

		$View->expects($this->once())
			->method('runCommand')
			->with('execute', $expectedArgs);

		$Shell->initialize();

		$this->assertAttributeEquals($expectedTasks, '_taskMap', $Shell);

		$Shell->runCommand('view', array('view'));
	}

	public function dataProviderForTestBase() {
		return array(
			array(
				'BakeShell',
				false,
				array('--theme', 'Cake3'),
				array(
					'View' => array(
						'class' => 'View',
						'settings' => array(),
					),
				),
			),
			array(
				'BakeShell',
				true,
				array('--theme', 'Cake3'),
				array(
					'View' => array(
						'class' => 'View',
						'settings' => array('className' => 'Theme.ThemeView'),
					),
				),
			),
			array(
				'Shell',
				true,
				array(),
				array(
					'View' => array(
						'class' => 'View',
						'settings' => array(),
					),
				),
			),
		);
	}
}