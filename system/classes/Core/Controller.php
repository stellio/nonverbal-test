<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Main Controller class 
 */
class Core_Controller extends Core_Object {

	public $view;
	public $model;

	const classPrefix = 'Controller_';

	/**
	 * initialized base view class
	 */
	public function __construct() {

		// $this->view = new Core_View();
		
	}

	/**
	 * Automatically executed before the controller action. Can be used to set
	 * class properties, do authorization checks, and execute other custom code.
	 *
	 * @return  void
	 */
	public function before() {

		// Nothing by default
	}

	/**
	 * Automatically executed after the controller action. Can be used to apply
	 * transformation to the response, add extra output, and execute
	 * other custom code.
	 * 
	 * @return  void
	 */
	public function after() {

		// Nothing by default
	}

	/**
	 * Defalut, empty class method. Using as default action for routing
	 */
	public function action_index() {}

	/**
	 * Create and return model instance
	 * @param  string $modelName the model name without prefix 'Model_'
	 * @return object          instance of class
	 */
	public function getModel($modelName = '') {

		$prefix = 'Model_';
		$modelName = $prefix . $modelName;

		if (!class_exists($modelName)) {
			die('Error. Cant get model: ' . $modelName);
		}

		$this->model = new $modelName();
		return $this->model;
	}
	
	/**
	 * Short realization of $_GET, $_POST methods
	 * @param  string $request	request string key
	 * @return string           value from $_GET or $_POST array
	 */
	public function req($request) {

		$result = false;

		// Attention! If get value zero int (0) - it empty value for empty() function
		if (isset($_GET[$request]) && !empty($_GET[$request])) {
			$result = stripslashes_deep($_GET[$request]);
		}
		if (isset($_POST[$request]) && !empty($_POST[$request])) {
			$result = stripslashes_deep($_POST[$request]);
		}

		return $result;
	}

	public function jsonArray($status, $value) {

		return array('status' => $status, 'value' => $value);

	}

	public function cleanUpStr($string) {
		return strtoupper(trim($string));
	}

}
?>