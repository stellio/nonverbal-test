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
class Controller_nvStatistic extends Controller_WithoutMenuTemplate {

	public $view;

	function __construct() {
		parent::__construct();
	}

	/**
	 * Show full statistics for test
	 */
	public function action_index() {
		
		$test = nvModel::factory('nvTest');
		$result = nvModel::factory('nvResult');
		$statistic = nvModel::factory('nvStatistic');
		$view = nvView::factory('statistic/list');
		
		$statistics = array();

		$id = $this->req('test_id');

		if ($id) {
			$test->loadById($id);
			$statistics = $statistic->getListByTestId($id);
		}

		$this->template->content = $view->bind('test', $test)
										->bind('result', $result)
										->bind('statistics', $statistics);
	}

	public function ajax_removeResult() {

		$statistic = nvModel::factory('nvStatistic');
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