<?php
App::uses('ViewTask', 'Console/Command/Task');

class ThemeViewTask extends ViewTask
{
	public function getPath() {
		$path = parent::getPath();

		$default = Configure::read('Theme.default');

		$theme = $this->params['theme'];
		if ($theme !== 'default' && $theme !== $default) {
			return $path . 'Themed' . DS . $theme . DS;
		}

		return $path;
	}
}
