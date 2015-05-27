<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

// include for dbDelta function
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

/**
 * Install or update plugins database tables
 */
class Helper_nvDbUpdate {


	private $table_prefix = 'non_verbal_';

	private $TABLE_NAME_TPE = 'tpe';
	private $TABLE_NAME_SIGNS = 'signs';
	private $TABLE_NAME_TESTS = 'tests';
	private $TABLE_NAME_ANSWERS = 'answers';
	private $TABLE_NAME_RESULTS = 'results';
	private $TABLE_NAME_PROFILES = 'profiles';
	private $TABLE_NAME_QUESTIONS = 'questions';
	private $TABLE_NAME_RELATIONS = 'relations';
	private $TABLE_NAME_STATISTIC = 'statistic';
	private $TABLE_NAME_SIGNS_GROUPS = 'signs_groups';
	private $_wpdb;

	/**
	 * Get pointer to wordpress db processor and install plugin tables
	 */
	public function __construct() {

		// make $wpdb visible in methods;
		global $wpdb;
		$this->_wpdb = $wpdb;

		// install db
		$this->install();
	}
	
	public function install() {

		// add to table names var, wp tables prefix
		$this->addTablePrefix();

		// create tables
		$this->databaseDelta();
		
	}

	private function addTablePrefix() {

		global $wpdb;
		$pfx = $wpdb->prefix . $this->table_prefix;

		$this->TABLE_NAME_TPE = $pfx . $this->TABLE_NAME_TPE;
		$this->TABLE_NAME_SIGNS = $pfx . $this->TABLE_NAME_SIGNS;
		$this->TABLE_NAME_TESTS = $pfx . $this->TABLE_NAME_TESTS;
		$this->TABLE_NAME_ANSWERS = $pfx . $this->TABLE_NAME_ANSWERS;
		$this->TABLE_NAME_RESULTS = $pfx . $this->TABLE_NAME_RESULTS;
		$this->TABLE_NAME_PROFILES = $pfx . $this->TABLE_NAME_PROFILES;
		$this->TABLE_NAME_QUESTIONS = $pfx . $this->TABLE_NAME_QUESTIONS;
		$this->TABLE_NAME_RELATIONS = $pfx . $this->TABLE_NAME_RELATIONS;
		$this->TABLE_NAME_STATISTIC = $pfx . $this->TABLE_NAME_STATISTIC;
		$this->TABLE_NAME_SIGNS_GROUPS = $pfx . $this->TABLE_NAME_SIGNS_GROUPS;

	}

	private function databaseDelta() {

		$this->createTableTpe();
		$this->createTableSigns();
		$this->createTableTests();
		$this->createTableAnswers();
		$this->createTableResults();
		$this->createTableProfiles();
		$this->createTableQuestions();
		$this->createTableRelations();
		$this->createTableStatistic();
		$this->createTableSignsGroups();

	}

	private function createTableSigns() {

		$table_name = $this->TABLE_NAME_SIGNS;

		if ($this->_wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$sql = "CREATE TABLE " . $table_name . " (
				id int(10) NOT NULL AUTO_INCREMENT,
				test_id int(10) NOT NULL,
				name text NOT NULL, 	
				code VARCHAR(255) NOT NULL,
				group_id int(10) NOT NULL,
				type int(10) NOT NULL,
				UNIQUE KEY id (id)
			) DEFAULT CHARSET=utf8;";

			// make query
			dbDelta($sql);
		}
	}

	private function createTableTests() {

		$table_name = $this->TABLE_NAME_TESTS;

		if ($this->_wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$sql = "CREATE TABLE " . $table_name . " (
				id int(10) NOT NULL AUTO_INCREMENT,
				name VARCHAR(255) NOT NULL,
				description text NOT NULL,
				first_question_id int(10) NOT NULL,
				status int(10) NOT NULL,
				create_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				is_reg_only int(10) NOT NULL,
				is_debug int(10) NOT NULL,
				user_id int(10) NOT NULL,
				UNIQUE KEY id (id)
			) DEFAULT CHARSET=utf8;";

			// make query
			dbDelta($sql);
		}
	}

	private function createTableAnswers() {

		$table_name = $this->TABLE_NAME_ANSWERS;

		if ($this->_wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$sql = "CREATE TABLE " . $table_name . " (
				id int(10) NOT NULL AUTO_INCREMENT,
				text text NOT NULL,
				value text NOT NULL,
				question_id int(10) NOT NULL,
				next_item_id int(10) NOT NULL,
				next_item_type int(10) NOT NULL,
				type int(10) NOT NULL,
				test_id int(10) NOT NULL,
				UNIQUE KEY id (id)
			) DEFAULT CHARSET=utf8;";

			// make query
			dbDelta($sql);
		}
	}

	private function createTableResults() {

		$table_name = $this->TABLE_NAME_RESULTS;

		if ($this->_wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$sql = "CREATE TABLE " . $table_name . " (
				id int(10) NOT NULL AUTO_INCREMENT,
				title VARCHAR(255) NOT NULL,
				text text NOT NULL,
				sequence_of_anwers text NOT NULL,
				answer_id int(10) NOT NULL,
				tpe text NOT NULL,
				func text NOT NULL,
				test_id int(10) NOT NULL,
				UNIQUE KEY id (id)
			) DEFAULT CHARSET=utf8;";

			// make query
			dbDelta($sql);
		}
	}

	private function createTableProfiles() {

		$table_name = $this->TABLE_NAME_PROFILES;

		if ($this->_wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$sql = "CREATE TABLE " . $table_name . " (
				id int(10) NOT NULL AUTO_INCREMENT,
				test_id int(10) NOT NULL,
				name text NOT NULL,
				code VARCHAR(255) NOT NULL,
				sequence_of_sign text NOT NULL,
				type int(10) NOT NULL,
				UNIQUE KEY id (id)
			) DEFAULT CHARSET=utf8;";

			// make query
			dbDelta($sql);
		}
	}

	private function createTableTpe() {

		$table_name = $this->TABLE_NAME_TPE;

		if ($this->_wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$sql = "CREATE TABLE " . $table_name . " (
				id int(10) NOT NULL AUTO_INCREMENT,
				test_id int(10) NOT NULL,
				name text NOT NULL,
				code VARCHAR(255) NOT NULL,
				sequence_of_sign text NOT NULL,
				type int(10) NOT NULL,
				UNIQUE KEY id (id)
			) DEFAULT CHARSET=utf8;";

			// make query
			dbDelta($sql);
		}
	}

	private function createTableQuestions() {

		$table_name = $this->TABLE_NAME_QUESTIONS;

		if ($this->_wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$sql = "CREATE TABLE " . $table_name . " (
				id int(10) NOT NULL AUTO_INCREMENT,
				text text NOT NULL,
				answers_id VARCHAR(255) NOT NULL,
				type int(10) NOT NULL,
				cycle int(10) NOT NULL,
				test_id int(10) NOT NULL,
				UNIQUE KEY id (id)
			) DEFAULT CHARSET=utf8;";

			// make query
			dbDelta($sql);
		}
	}

	private function createTableRelations() {

		$table_name = $this->TABLE_NAME_RELATIONS;

		if ($this->_wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$sql = "CREATE TABLE " . $table_name . " (
				id int(10) NOT NULL AUTO_INCREMENT,
				test_id int(10) NOT NULL,
				code VARCHAR(255) NOT NULL,
				type int(10) NOT NULL,
				parent_id int(10) NOT NULL,
				UNIQUE KEY id (id)
			) DEFAULT CHARSET=utf8;";

			// make query
			dbDelta($sql);
		}	
	}

	private function createTableStatistic() {

		$table_name = $this->TABLE_NAME_STATISTIC;

		if ($this->_wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$sql = "CREATE TABLE " . $table_name . " (
				id int(10) NOT NULL AUTO_INCREMENT,
				user_id bigint(20) NOT NULL,
				time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				result_id int(10) NOT NULL,
				test_id int(10) NOT NULL,
				result_text text NOT NULL,
				type text NOT NULL,
				type_another text NOT NULL,
				type_basis text NOT NULL,
				age text NOT NULL,
				gender text NOT NULL,
				nickname text NOT NULL,
				UNIQUE KEY id (id)
			) DEFAULT CHARSET=utf8;";

			// make query
			dbDelta($sql);
		}
	}

	private function createTableSignsGroups() {

		$table_name = $this->TABLE_NAME_SIGNS_GROUPS;

		if ($this->_wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$sql = "CREATE TABLE " . $table_name . " (
				id int(10) NOT NULL AUTO_INCREMENT,
				test_id int(10) NOT NULL,
				short_name text NOT NULL,
				sign_ids text NOT NULL,
				type int(10) NOT NULL,
				UNIQUE KEY id (id)
			) DEFAULT CHARSET=utf8;";

			// make query
			dbDelta($sql);
		}	
	}


}
?>