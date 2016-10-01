<?php
App::uses('AppShell', 'Console/Command');

class ThemeAppShell extends Shell
{
	public function initialize() {
		if ($this instanceof BakeShell && Configure::read('Theme.useThemePath')) {
			$this->tasks['View'] = array(
				'className' => 'Theme.ThemeView',
			);
		}
		parent::initialize();
	}

	public function runCommand($command, $argv) {
		if ($this instanceof BakeShell) {
			$theme = Configure::read('Theme.name');
			if (!$theme) {
				$theme = 'default';
			}
			array_splice($argv, 1, 0, array('--theme', $theme));
		}
		return parent::runCommand($command, $argv);
	}
}
