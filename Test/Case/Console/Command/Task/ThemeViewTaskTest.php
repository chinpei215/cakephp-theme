<?php

App::uses('ThemeViewTask', 'Theme.Console/Command/Task');

class ThemeViewTaskTest extends CakeTestCase
{
	public function testGetPath() {
		$task = new ThemeViewTask();
		$task->initialize();

		Configure::delete('Theme.default');
		$task->params['theme'] = 'Cake3';
		$expected = APP . 'View' . DS . 'Themed' . DS . 'Cake3' . DS;
		$this->assertEquals($expected, $task->getPath());

		$task->params['theme'] = 'default';
		$expected = APP . 'View' . DS;
		$this->assertEquals($expected, $task->getPath());

		Configure::write('Theme.default', 'Cake3');
		$task->params['theme'] = 'Cake3';
		$expected = APP . 'View' . DS;
		$this->assertEquals($expected, $task->getPath());
	}
}
