<?php
App::uses('AppShell', 'Console/Command');
App::uses('Inflector', 'Utility');

class ThemeShell extends AppShell
{
	public $tasks = array('Template');

	public function getOptionParser() {
		$parser = parent::getOptionParser();

		$parser->addSubcommand('install', array(
				'help' => 'Install theme',
				'parser' => array(
					'options' => array(
						'theme' => array(
							'help' => 'Name of theme to be installed',
						),
					),
				),
		));

		return $parser;
	}

	public function install() {
		if (!$this instanceof ThemeAppShell) {
			$this->err('<warning>AppShell must extend ThemeAppShell</warning>');
			return;
		}

		$default = Configure::read('Theme.default');
		if ($default) {
			$this->Template->params['theme'] = $default;
		}

		foreach ($this->Template->templatePaths as $key => $path) {
			if (!is_dir($path . 'views' . DS . 'theme')) {
				unset($this->Template->templatePaths[$key]);
			}
		}

		$path = $this->Template->getThemePath();
		$theme = basename($path);
		$themePath = realpath($path) . DS . 'views' . DS . 'theme';

		$paths = App::path('View');
		$viewPath = rtrim($paths[0], DS);
		
		if (!$default) {
			$viewPath .= DS . 'Themed' . DS . $theme;
		}

		$webroot = rtrim(Configure::read('App.www_root'), DS);

		$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($themePath, FilesystemIterator::SKIP_DOTS));

		$result = null;
		foreach ($iter as $file) {
			$source = $file->getPathname();
			$relativePath = substr($source, strlen($themePath));

			if ($default && strpos($relativePath, DS . 'webroot' . DS) === 0) {
				$dest = $webroot . substr($relativePath, strlen('webroot' . DS));
			} else {
				$dest = $viewPath . $relativePath;
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
