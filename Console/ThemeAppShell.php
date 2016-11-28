<?php
App::uses('AppShell', 'Console/Command');
App::uses('AppController', 'Controller');

class ThemeAppShell extends Shell
{
	public function initialize() {
		if ($this instanceof BakeShell) {
			$this->tasks['View'] = array(
				'className' => 'Theme.ThemeView',
			);
		}
		parent::initialize();
	}

	public function runCommand($command, $argv) {
		if ($this instanceof BakeShell) {
			if ($argv) {
				$task = $argv[0];
				if ($this->hasTask($task)) {
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
			}
		}
		return parent::runCommand($command, $argv);
	}
}
