<?php
App::uses('ViewTask', 'Console/Command/Task');

class ThemeViewTask extends ViewTask
{
	public function getPath() {
		$path = parent::getPath();

		$theme = $this->params['theme'];
		if ($theme !== 'default' && Configure::read('Theme.useThemePath')) {
			return $path . 'Themed' . DS . $theme . DS;
		}
		return $path;
	}
}
