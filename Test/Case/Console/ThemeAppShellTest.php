<?php
App::uses('ThemeAppShell', 'Theme.Console');
App::uses('ThemeShell', 'Theme.Console/Command');
App::uses('BakeShell', 'Console/Command');
App::uses('ConsoleOptionParser', 'Console');

class ThemeAppShellTest extends CakeTestCase
{
	public $theme = 'TestTheme';

	/**
	 * @dataProvider dataProviderForTestBakeView
	 */
	public function testBakeView($class, $command, $default, $defaultClass, $expectedTask, $expectedTheme) {
		Configure::write('Theme.default', $default);
		Configure::write('Theme.defaultClass', $defaultClass);

		$Shell = $this->getMockBuilder($class)
			->setMethods(array('startup', 'getOptionParser'))
			->getMock();

		$Shell->tasks[] = 'View';

		$Shell->initialize();

		$this->assertEquals($expectedTask, get_class($Shell->View));

		$Shell->View = $this->getMockBuilder($expectedTask)
			->setMethods(array('execute'))
			->getMock();

		$Shell->View->expects($this->once())
			->method('execute');
		$parser = new ConsoleOptionParser();
		$parser->addSubcommand('view', array(
			'parser' => array(
				'options' => array(
					'theme' => array(
						'short' => 't',
					),
				),
			),
		));
		$Shell->expects($this->once())
			->method('getOptionParser')
			->will($this->returnValue($parser));

		$Shell->runCommand('view', array('view'));

		$theme =& $Shell->View->params['theme'];
		$this->assertEquals($expectedTheme, $theme);
	}

	public function dataProviderForTestBakeView() {
		return array(
			array(
				'BakeShell', 'view', null, 'stdClass',
				'ThemeViewTask', null,
			),
			array(
				'BakeShell', 'view', 'Cake3', 'stdClass',
				'ThemeViewTask', 'Cake3',
			),
			array(
				'BakeShell', 'view', 'Cake3', 'ThemeAppShellTest',
				'ThemeViewTask', 'Cake3',
			),
			array(
				'BakeShell', 'view', null, 'ThemeAppShellTest',
				'ThemeViewTask', 'TestTheme',
			),
			array(
				'ThemeShell', 'install', 'Cake3', 'stdClass',
				'ThemeViewTask', 'Cake3',
			),
			array(
				'Shell', 'view', 'Cake3', 'ThemeAppShellTest',
				'ViewTask', null,
			),
		);
	}
}
