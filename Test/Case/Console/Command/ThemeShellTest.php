<?php
App::uses('ThemeShell', 'Theme.Console/Command');

class ThemeShellTest extends CakeTestCase
{
	public function testInstallToThemed() {
		Configure::delete('Theme.default');

		$source = realpath(App::pluginPath('Theme')) . DS . 'Console' . DS . 'Templates' . DS . 'Cake3' . DS . 'views' . DS . 'theme';
		$dest = APP . 'View' . DS . 'Themed' . DS . 'Cake3';

		$files = array(
			'Elements' . DS . 'exception_stack_trace.ctp',
			'Elements' . DS . 'exception_stack_trace_nav.ctp',
			'Elements' . DS . 'Flash' . DS . 'default.ctp',
			'Elements' . DS . 'Flash' . DS . 'error.ctp',
			'Elements' . DS . 'Flash' . DS . 'success.ctp',
			'Errors' . DS . 'error400.ctp',
			'Errors' . DS . 'error500.ctp',
			'Errors' . DS . 'fatal_error.ctp',
			'Errors' . DS . 'missing_action.ctp',
			'Errors' . DS . 'missing_behavior.ctp',
			'Errors' . DS . 'missing_component.ctp',
			'Errors' . DS . 'missing_connection.ctp',
			'Errors' . DS . 'missing_controller.ctp',
			'Errors' . DS . 'missing_database.ctp',
			'Errors' . DS . 'missing_datasource.ctp',
			'Errors' . DS . 'missing_datasource_config.ctp',
			'Errors' . DS . 'missing_helper.ctp',
			'Errors' . DS . 'missing_layout.ctp',
			'Errors' . DS . 'missing_plugin.ctp',
			'Errors' . DS . 'missing_table.ctp',
			'Errors' . DS . 'missing_view.ctp',
			'Errors' . DS . 'pdo_error.ctp',
			'Errors' . DS . 'private_action.ctp',
			'Layouts' .  DS . 'default.ctp',
			'Layouts' .  DS . 'dev_error.ctp',
			'Pages' . DS . 'home.ctp',
			'Scaffolds' . DS . 'form.ctp',
			'Scaffolds' . DS . 'index.ctp',
			'Scaffolds' . DS . 'view.ctp',
			'webroot' . DS . 'css' . DS . 'base.css',
			'webroot' . DS . 'css' . DS . 'cake.css',
			'webroot' . DS . 'img' . DS . 'cake-logo.png',
		);

		$expected = array();
		foreach ($files as $file) {
			$expected[ $source . DS . $file ] = $dest . DS . $file;
		}

		$actual = array();

		$Shell = $this->getMockBuilder('ThemeShell')
			->setMethods(array('copyFile', 'out'))
			->getMock();
		$Shell->expects($this->any())
			->method('copyFile')
			->will($this->returnCallback(function($source, $dest) use(&$actual){
				$actual[$source] = $dest;
			}));
		$Shell->interactive = false;
		$Shell->params['theme'] = 'Cake3';
		$Shell->initialize();
		$Shell->install();

		$this->assertEquals($expected, $actual);
	}

	public function testInstallToView() {
		Configure::write('Theme.default', 'Cake3');

		$source = realpath(App::pluginPath('Theme')) . DS . 'Console' . DS . 'Templates' . DS . 'Cake3' . DS . 'views' . DS . 'theme';
		$dest = APP . 'View';

		$expected = array();

		$files = array(
			'Elements' . DS . 'exception_stack_trace.ctp',
			'Elements' . DS . 'exception_stack_trace_nav.ctp',
			'Elements' . DS . 'Flash' . DS . 'default.ctp',
			'Elements' . DS . 'Flash' . DS . 'error.ctp',
			'Elements' . DS . 'Flash' . DS . 'success.ctp',
			'Errors' . DS . 'error400.ctp',
			'Errors' . DS . 'error500.ctp',
			'Errors' . DS . 'fatal_error.ctp',
			'Errors' . DS . 'missing_action.ctp',
			'Errors' . DS . 'missing_behavior.ctp',
			'Errors' . DS . 'missing_component.ctp',
			'Errors' . DS . 'missing_connection.ctp',
			'Errors' . DS . 'missing_controller.ctp',
			'Errors' . DS . 'missing_database.ctp',
			'Errors' . DS . 'missing_datasource.ctp',
			'Errors' . DS . 'missing_datasource_config.ctp',
			'Errors' . DS . 'missing_helper.ctp',
			'Errors' . DS . 'missing_layout.ctp',
			'Errors' . DS . 'missing_plugin.ctp',
			'Errors' . DS . 'missing_table.ctp',
			'Errors' . DS . 'missing_view.ctp',
			'Errors' . DS . 'pdo_error.ctp',
			'Errors' . DS . 'private_action.ctp',
			'Layouts' .  DS . 'default.ctp',
			'Layouts' .  DS . 'dev_error.ctp',
			'Pages' . DS . 'home.ctp',
			'Scaffolds' . DS . 'form.ctp',
			'Scaffolds' . DS . 'index.ctp',
			'Scaffolds' . DS . 'view.ctp',
		);

		foreach ($files as $file) {
			$expected[ $source . DS . $file ] = $dest . DS . $file;
		}

		$files = array(
			'webroot' . DS . 'css' . DS . 'base.css',
			'webroot' . DS . 'css' . DS . 'cake.css',
			'webroot' . DS . 'img' . DS . 'cake-logo.png',
		);

		foreach ($files as $file) {
			$expected[ $source . DS . $file ] = APP . $file;
		}

		$actual = array();

		$Shell = $this->getMockBuilder('ThemeShell')
			->setMethods(array('copyFile', 'out'))
			->getMock();
		$Shell->expects($this->any())
			->method('copyFile')
			->will($this->returnCallback(function($source, $dest) use(&$actual){
				$actual[$source] = $dest;
			}));

		$Shell->interactive = false;
		$Shell->initialize();
		$Shell->install();

		$this->assertEquals($expected, $actual);
	}
}
