<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Manage test statistics
 */
class Controller_Statistic extends Controller_ContentTemplate {

	public $view;

	function __construct() {
		parent::__construct();
	}

	/**
	 * Show full statistics for test
	 */
	public function action_index() {

		$statistics = array();
		$test = new Model_Test();
		$result = new Model_Result();
		$statistic = new Model_Statistic();
		$this->view = new View_StatisticList();

		$id = $this->req('test_id');

		if ($id) {
			$test->loadById($id);
			$statistics = $statistic->getListByTestId($id);
		}

		$this->view->test = $test;
		$this->view->result = $result;
		$this->view->statistics = $statistics;

		$this->view->show();
	}

	public function ajax_removeResult() {

		$statistic = new Model_Statistic();
		$response = 0;
		$id = $this->req('id');

		if ($statistic->removeById($id)) {
			$response = $this->jsonArray('success', $id);
		}

		wp_send_json($response);
		exit;
	}
}

?>