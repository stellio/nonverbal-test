<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Model_nvTestList extends Core_Model {

	public $private;

	function getTestList() {

		$query = "SELECT * FROM " . $this->_tableTests;
		// $type = 'ARRAY_A';
		return $this->_db->get_results($query);
	}
	
}