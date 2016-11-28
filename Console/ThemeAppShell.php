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
		$auto = false;

		if ($this instanceof ThemeShell) {
			$auto = true;
		} elseif ($this instanceof BakeShell) {
			if ($argv && $this->hasTask($argv[0])) {
				$auto = true;
			}
		}

		if ($auto) {
			$theme = Configure::read('Theme.default');

			if (!$theme) {
				$vars = get_class_vars('AppController');
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
