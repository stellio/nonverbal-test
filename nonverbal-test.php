<?php
/*
Plugin Name: Non-Verbal Socionic Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Short prefix for class - NV (Non-verbal)
 */

/**
 * Paths
 */
$app = 'app';
$system = 'system';

define('NV_EXT', '.php');
define('NV_DIR', plugin_dir_path(__FILE__));
define('NV_URL', plugin_dir_url(__FILE__));
define('NV_BASEDIR', dirname(plugin_basename(__FILE__)));
define('NV_APPPATH', NV_DIR . $app . DIRECTORY_SEPARATOR);
define('NV_SYSPATH', NV_DIR . $system . DIRECTORY_SEPARATOR);

// load core
require NV_SYSPATH . 'classes/Core/Test' . NV_EXT;
require NV_SYSPATH . 'classes/nvTest' . NV_EXT;
// throw new Exception("Error Processing Request", 1);



spl_autoload_register(array('Core_Test', 'auto_load'));

// require_once(NV_DIR . 'includes/Loader.php');
// require_once(NV_DIR . 'includes/helper/nvDbUpdate.php');

// register_activation_hook(__FILE__, 'nv_activation');
// add_action('plugins_loaded', 'nv_plugins_loaded');

function nv_autoload($class) {

	$nameParts = explode('_', $class);

	if (count($nameParts) < 2)
		return;

	$dir = '';
	$prefix = '';
	$className = '';

	$prefix = $nameParts[0];
	$className = $nameParts[1];


	

	switch ($prefix) {
		case 'Controller':
			$dir = 'controller/';
			break;
		case 'Model':
			$dir = 'model/';
			break;
		case 'Helper':
			$dir = 'helper/';
			break;
		case 'View':
			$dir = 'view/';
			break;
		default:
			return;
	}
	echo "AutoLoad: file name: [" . $className . "]<br>";

	if (file_exists(NV_DIR . 'includes/' .$dir . $className . '.php'))
		include_once (NV_DIR . 'includes/' .$dir . $className . '.php');
	else {
		echo "Can't find file: " . NV_DIR .  'includes/' . $dir . $className . '.php';
	}
}

function nv_activation() {
	// new Helper_nvDbUpdate();
}

function nv_plugins_loaded() {
	// load_plugin_textdomain('nonverbal-test', false, NV_BASEDIR.'/languages');
}


function nv_init() {

	if(is_admin())
		new nvTest();
	// else
		// new Controller_nvFront();
		// new TreeTest();
		// new TreeTestSettings();
	// TT_Routing::execute();
	// new Controller_nvAjax();

}

nv_init();













