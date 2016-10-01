<?php
App::uses('AppShell', 'Console/Command');
App::uses('Inflector', 'Utility');

class ThemeShell extends AppShell
{
	public function getOptionParser() {
		$parser = parent::getOptionParser();

		$parser->addSubcommand('install', array(
				'help' => 'Install theme',
				'parser' => array(
					'arguments' => array(
						'name' => array(
							'help' => 'Name of theme to be installed',
						),
					),
				),
		));

		return $parser;
	}

	public function install() {
		if ($this->args) {
			list($name) = $this->args;
		} else {
			$name = Configure::read('Theme.name');
		}

		$name = Inflector::camelize($name);

		$themePath = dirname(__DIR__) . DS . 'Templates' . DS . $name . DS .'theme';
		if (!is_dir($themePath)) {
			$this->err(__d('theme', 'No such theme: %s', $name));
			return;
		}
		$themePath = realpath($themePath);

		$paths = App::path('View');
		$path = rtrim($paths[0], DS);
		
		$useThemePath = Configure::read('Theme.useThemePath');
		if ($useThemePath) {
			$path .= DS . 'Themed' . DS . $name;
		}

		$webroot = rtrim(Configure::read('App.www_root'), DS);

		$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($themePath, FilesystemIterator::SKIP_DOTS));

		$result = null;
		foreach ($iter as $file) {
			$source = $file->getPathname();
			$relativePath = substr($source, strlen($themePath));

			if (!$useThemePath && strpos($relativePath, DS . 'webroot' . DS) === 0) {
				$dest = $webroot . substr($relativePath, strlen('webroot' . DS));
			} else {
				$dest = $path . $relativePath;
			}

			$this->out("Creating file $dest");

			if ($result !== 'a' && file_exists($dest) && $this->interactive !== false) {
				$this->out("File `$dest` exists");
				$prompt = __d('cake_console', 'Do you want to overwrite?');
				$result = strtolower($this->in($prompt, array('y', 'n', 'a', 'q'), 'y'));
				if ($result === 'q') {
					break;
				}
				if ($result === 'n') {
					$this->out('');
					continue;
				}
			}

			if ($this->copyFile($source, $dest)) {
				$this->out("Wrote `$dest`");
				$this->out('');
			}
		}
	}

	protected function copyFile($source, $dest) {
			$dir = dirname($dest);
			if (!is_dir($dir)) {
				mkdir($dir, 0755, true);
			}
			return copy($source, $dest);
	}
}
