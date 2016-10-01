<?php

App::uses('ThemeViewTask', 'Theme.Console/Command/Task');

class ThemeViewTaskTest extends CakeTestCase
{
	public function testGetPath() {
		$task = new ThemeViewTask();
		$task->initialize();

		Configure::write('Theme.name', 'Cake3');
		Configure::write('Theme.useThemePath', true);
		$task->params['theme'] = 'Cake3';
		$expected = APP . 'View' . DS . 'Themed' . DS . 'Cake3' . DS;
		$this->assertEquals($expected, $task->getPath());

		Configure::write('Theme.useThemePath', false);
		$expected = APP . 'View' . DS;
		$this->assertEquals($expected, $task->getPath());

		$task->params['theme'] = 'default';
		$this->assertEquals($expected, $task->getPath());
	}
}
