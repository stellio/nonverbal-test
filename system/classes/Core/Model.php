<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Basic model class
 */
class Core_Model extends Core_Object {

	/**
	 * Constants
	 */
	const TYPE_TPE = '1';
	const TYPE_FUNCTIONAL = '2';


	/**
	 * Pointer for wordpress db processor class
	 * @var object
	 */
	protected $_db;
	protected $_prefix;
	protected $_tableTpe;
	protected $_tableSigns;
	protected $_tableTests;
	protected $_tableAnswers;
	protected $_tableResults;
	protected $_tableProfiles;
	protected $_tableQuestions;
	protected $_tableStatistic;
	protected $_tableSignsGroups;

	/**
	 * Initialized prefix var by plugin tables names
	 */
	function __construct() {

		global $wpdb;
		$this->_db = $wpdb;
		$this->_prefix = $wpdb->prefix . 'non_verbal_';

		$this->_tableTpe = $this->_prefix . 'tpe';
		$this->_tableSigns = $this->_prefix . 'signs';
		$this->_tableTests = $this->_prefix . 'tests';
		$this->_tableAnswers = $this->_prefix . 'answers';
		$this->_tableResults = $this->_prefix . 'results';
		$this->_tableProfiles = $this->_prefix . 'profiles';
		$this->_tableQuestions = $this->_prefix . 'questions';
		$this->_tableStatistic = $this->_prefix . 'statistic';
		$this->_tableSignsGroups = $this->_prefix . 'signs_groups';

	}

	public static function factory($model = NULL) {

		$model = 'Model_'.$model;

		return new $model;
	}

	/**
	 * Return current datetime
	 * @return str 		datetime stamp 
	 */
	protected function getDatetime() {

		$date = date('Y-m-d H:i:s');
		return $date;
	}



}

?>