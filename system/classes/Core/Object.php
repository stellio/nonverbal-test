<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Basic class of TreeTest
 */
class Core_Object {

	/**
	 * Return class name of object
	 * @return string	class name
	 */
	const ext = '.php';

	function toString() {

		return get_class($this);
	}	
}

?>