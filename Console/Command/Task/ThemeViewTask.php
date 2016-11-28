<?php
App::uses('ViewTask', 'Console/Command/Task');

class ThemeViewTask extends ViewTask
{
	public function getPath() {
		$path = parent::getPath();

		$theme = false;
		if (isset($this->params['theme'])) {
			$theme = $this->params['theme'];
		}

		if ($theme && $theme !== 'default' && $theme !== Configure::read('Theme.default')) {
			return $path . 'Themed' . DS . $theme . DS;
		}

		return $path;
	}
}
