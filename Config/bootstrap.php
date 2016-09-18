<?php
App::uses('CakeEventManager', 'Event');

CakeEventManager::instance()->attach(function($event) {
	$controller = $event->subject;
	if ($controller->theme === null) {
		$controller->theme = 'Cake3';
	}
}, 'Controller.beforeRender');
