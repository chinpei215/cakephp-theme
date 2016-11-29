<?php
App::uses('AppShell', 'Console/Command');
App::uses('AppController', 'Controller');

class ThemeAppShell extends Shell
{
	public function initialize() {
		if ($this instanceof BakeShell || $this instanceof ThemeShell) {
			$this->tasks['View'] = array(
				'className' => 'Theme.ThemeView',
			);
		}
		parent::initialize();
	}

	public function runCommand($command, $argv) {
		if ($this instanceof BakeShell || $this instanceof ThemeShell) {
			$theme = Configure::read('Theme.default');

			if (!$theme) {
				$class = Configure::read('Theme.defaultClass') ?: 'AppController';
				$vars = get_class_vars($class);
				if (isset($vars['theme'])) {
					$theme = $vars['theme'];
				}
			}

			if ($theme) {
				array_splice($argv, 1, 0, array('--theme', $theme));
			}
		}
		return parent::runCommand($command, $argv);
	}
}
