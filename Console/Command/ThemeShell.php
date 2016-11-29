<?php
App::uses('AppShell', 'Console/Command');
App::uses('Inflector', 'Utility');

class ThemeShell extends AppShell
{
	public $tasks = array('Template');

	public function getOptionParser() {
		$parser = parent::getOptionParser();

		$parser->addSubcommand('install', array(
			'help' => 'Install theme.',
			'parser' => array(
				'options' => array(
					'theme' => array(
						'short' => 't',
						'help' => 'Name of theme to be installed',
						'default' => false,
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

		foreach ($this->Template->templatePaths as $key => $path) {
			if (!is_dir($path . 'views' . DS . 'theme')) {
				unset($this->Template->templatePaths[$key]);
			}
		}

		$themePath = $this->Template->getThemePath();
		$theme = basename($themePath);
		$themePath = realpath($themePath) . DS . 'views' . DS . 'theme';

		$viewPath = $this->View->getPath();
		$viewPath = rtrim($viewPath, DS);
		$default = (basename($viewPath) !== $theme);

		$webroot = rtrim(Configure::read('App.www_root'), DS);

		$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($themePath, FilesystemIterator::SKIP_DOTS));

		$this->out(__d('theme', 'Installing theme: %s', array($theme)));
		$result = null;
		foreach ($iter as $file) {
			$source = $file->getPathname();
			$relativePath = substr($source, strlen($themePath));

			if ($default && strpos($relativePath, DS . 'webroot' . DS) === 0) {
				$dest = $webroot . substr($relativePath, strlen('webroot' . DS));
			} else {
				$dest = $viewPath . $relativePath;
			}

			$this->out(__d('theme', 'Creating file: %s', array($dest)));

			if ($result !== 'a' && file_exists($dest) && $this->interactive !== false) {
				$this->out("File `$dest` exists");
				$prompt = __d('theme', 'Do you want to overwrite?');
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
				$this->out(__d('theme', 'Wrote: %s', array($dest)));
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
