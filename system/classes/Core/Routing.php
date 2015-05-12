<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Basic routing class. Load class and invoke class methods
 */
class Core_Routing extends Core_Object
{
	/**
	 * Main method
	 */
	static function execute() {

		// defaults
		$controllerName = 'NV';
		$actionName = 'action_index';

		// get controller name
		$request = $_GET['module'];

		if (!empty($request))
			$controllerName = $request;


		// get controller method name
		$request = $_GET['call'];

		if (!empty($request))
			$actionName = 'action_' . $request;
		

		$controllerClassName = Core_Controller::classPrefix . $controllerName;
		$controllerPath = NV_APPPATH . 'classes/Controller/' . $controllerName . NV_EXT;

		/**
		 * Load file if exisit
		 */
		if (file_exists($controllerPath)) {
			if (!class_exists($controllerClassName))
				include $controllerPath;
		} else {
			die("Error to find Controller by path: " . $controllerPath . '<br>');
		}

		$controllerObj = new $controllerClassName;

		/**
		 * Execute before action
		 */
		if (method_exists($controllerObj, 'before')) {
			call_user_func(array($controllerObj, 'before'));
		} else {
			die("Error to find method: " . 'before' . " in controller: " . $controller);
		}

		/**
		 * Execute the action
		 */
		if (method_exists($controllerObj, $actionName)) {
			call_user_func(array($controllerObj, $actionName));
		} else {
			die("Error to find method: " . $actionName . " in controller: " . $controller);
		}

		/**
		 * Execute the after action
		 */
		if (method_exists($controllerObj, 'after')) {
			call_user_func(array($controllerObj, 'after'));
		} else {
			die("Error to find method: " . 'after' . " in controller: " . $controller);
		}
	}
}