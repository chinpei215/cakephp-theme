<?php
App::uses('CakeEventManager', 'Event');

if (Configure::read('Theme.name') === null) {
	Configure::write('Theme.name', 'Cake3');
}

if (Configure::read('Theme.useThemePath') === null) {
	Configure::write('Theme.useThemePath', true);
}

CakeEventManager::instance()->attach(function($event) {
	$controller = $event->subject;
	if ($controller->theme === null && Configure::read('Theme.useThemePath')) {
		$controller->theme = Configure::read('Theme.name');
	}
}, 'Controller.beforeRender');
