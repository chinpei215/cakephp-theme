<?php

App::uses('Shell', 'Console');
App::uses('Inflector', 'Utility');
App::uses('Folder', 'Utility');

class ThemeShell extends Shell
{
	public function getOptionParser() {
		$parser = parent::getOptionParser();

		$parser->addSubcommand('install', array(
				'help' => 'Install theme',
				'parser' => array(
					'arguments' => array(
						'name' => array(
							'help' => 'Name of theme to be installed',
							'required' => true,
						),
					),
				),
		));

		return $parser;
	}

	public function install() {
		list($name) = $this->args;

		$name = Inflector::camelize($name);

		$theme = dirname(__DIR__) . DS . 'Templates' . DS . $name . DS .'theme';
		if (!file_exists($theme)) {
			$this->err(__d('theme', 'No such theme: %s', $name));
			return;
		}

		$paths = App::path('View');
		$path = $paths[0] . 'Themed';

		$dest = $path . DS . $name;
		if (file_exists($dest)) {
			$prompt = __d('cake_console', "File already exists. Overwrite? [Y]es, [N]o");
			$result = strtolower($this->in($prompt, array('y', 'n'), 'y'));
			if ($result === 'n') {
				return;
			}
		}

		$folder = new Folder($theme);
		if ($folder->copy($dest)) {
			$this->out(__d('theme', "Installed %s theme in %s", $name, $path));
		} else {
			$this->err(__d('theme', "<error>Could not install theme: %s</error>", $name));
		}
	}
}
