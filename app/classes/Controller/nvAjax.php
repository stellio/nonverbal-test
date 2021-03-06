<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Ajax controller, usig to serve ajax requests
 */
class Controller_nvAjax extends nvController {

	public function __construct() {
		parent::__construct();

		$this->init();
	}

	/**
	 * Registered ajax action and connect with class methods
	 */
	public function init() {

		// front end
		add_action('wp_ajax_nonverbal_test_get_test_structure', array($this, 'getTestStructure'));
		add_action('wp_ajax_nopriv_nonverbal_test_get_test_structure', array($this, 'getTestStructure'));

		add_action('wp_ajax_nonverbal_test_get_result', array($this, 'getResult'));
		add_action('wp_ajax_nopriv_nonverbal_test_get_result', array($this, 'getResult'));

		add_action('wp_ajax_nonverbal_test_show_test', array($this, 'showTest'));
		add_action('wp_ajax_nopriv_nonverbal_test_show_test', array($this, 'showTest'));

		/*
			Backend part
		 */
		add_action('wp_ajax_nonverbal_test_create_test', array($this, 'createTest'));
		add_action('wp_ajax_nopriv_nonverbal_test_create_test', array($this, 'createTest'));

		add_action('wp_ajax_nonverbal_test_remove_result', array($this, 'removeResult'));
		add_action('wp_ajax_nopriv_nonverbal_test_remove_result', array($this, 'removeResult'));

		// Test menu actions
		add_action('wp_ajax_nonverbal_test_menu_action', array($this, 'testMenuAction'));
		add_action('wp_ajax_nopriv_nonverbal_test_menu_action', array($this, 'testMenuAction'));

		// Test Settings
		add_action('wp_ajax_nonverbal_test_settings', array($this, 'testSettings'));
		add_action('wp_ajax_nopriv_nonverbal_test_settings', array($this, 'testSettings'));

	}

	/**
	 * Echo json structure of test relastion with question and answers
	 */
	public function getTestStructure() {

		$front = new Controller_nvFront();
		$front->ajaxGenerateTestStructure();
	}

	/**
	 * Echo test answer
	 */
	public function getResult() {

		$front = new Controller_nvFront();
		$front->ajaxGetResult();
	}

	/**
	 * Change test settings
	 */
	public function testSettings() {

		$front = new Controller_nvTest();
		$front->ajax_settings();
	}

	/**
	 * Call From Backand
	 */
	public function createTest() {

		$test = new Controller_nvTest();
		$test->ajax_createTest();
		die();
	}

	public function removeResult() {

		$statistic = new Controller_nvStatistic();
		$statistic->ajax_removeResult();
		die();
	}


	public function showTest(){

		$controllerFront = new Controller_nvFront();
		$controllerFront->showTest();
		die();
	}

	public function testMenuAction() {

		nvRouting::execute();
		die();
	}

}