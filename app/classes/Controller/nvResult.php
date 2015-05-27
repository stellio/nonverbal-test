<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Version: 0.01
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Manage test results. Add, edit, save, delete
 */
class Controller_nvResult extends Controller_ContentTemplate {
	
	public $view;
	public $testId = '';

	function __construct() {
		parent::__construct();
	}

	/**
	 * Show all results for test
	 */
	public function action_index() {

		$test = nvModel::factory('nvTest');
		$result = nvModel::factory('nvResult');
		$view = nvView::factory('result/list');

		$results = array();
		
		$testId = $this->req('test_id');

		if ($testId) {
			$test->loadById($testId);
			$results = $result->getListByTestId($test->getId());
		}

		$this->template->content = $view->bind('test', $test)
										->bind('results', $results);
	}

	/**
	 * Show form to add new result
	 */
	public function action_add() {

		$test = nvModel::factory('nvTest');
		$result = nvModel::factory('nvResult');
		$tpe = nvModel::factory('nvTpe');
		$profile = nvModel::factory('nvProfile');
		$view = nvView::factory('result/edit');

		$test_id = $this->req('test_id');

		$tpeList = array();
		$profiles = $profile->loadByTestAndTypeId($test_id, nvModel::TYPE_FUNCTIONAL);
		$selected = array();

		$testId = $this->req('test_id');
		if ($testId) {
			$test->loadById($testId);
			$tpeList = $tpe->loadByTest($testId);
		}

		$this->template->content = $view->bind('tpe', $tpeList)
										->bind('test', $test)
										->bind('result', $result)
										->bind('profiles', $profiles)
										->bind('selected', $selected);
	}

	/**
	 * Show form to edit result
	 */
	public function action_edit() {

		$tpe = nvModel::factory('nvTpe');
		$test = nvModel::factory('nvTest');
		$result = nvModel::factory('nvResult');
		$profile = nvModel::factory('nvProfile');

		$view = nvView::factory('result/edit');

		$test_id = $this->req('test_id');

		$tpeList = array();
		$selected = array();
		$profiles = $profile->loadByTestAndTypeId($test_id, nvModel::TYPE_FUNCTIONAL);

		$testId = $this->req('test_id');
		if ($testId) {
			$test->loadById($testId);
			$tpeList = $tpe->loadByTest($testId);


			if ($this->req('id')) {
				$result->loadById($this->req('id'));
				$selected = split(",", $result->getFunc());
			}
		}

		$this->template->content = $view->bind('tpe', $tpeList)
										->bind('test', $test)
										->bind('result', $result)
										->bind('profiles', $profiles)
										->bind('selected', $selected)
										->bind('func', $result->getFunc());
	}

	/**
	 * Save result and show it
	 */
	public function action_save() {

		$test = nvModel::factory('nvTest');
		$result = nvModel::factory('nvResult');


		

		if ($this->req('test_id')) {
			$test->loadById($this->req('test_id'));

			// update result
			if ($this->req('id')) {

				// load question from db
				$result->loadById($this->req('id'));
				$result->setTitle($this->req('title'));
				$result->setTpe($this->req('tpe'));
				$result->setFunc($this->req('func'));
				$result->setText($this->req('text'));

				if ($result->update($this->req('id')))
					nvHtml::admin_notices('Обновлен', 'info');
				else
					nvHtml::admin_notices('Не удалось обновить', 'danger');
			}
			// save result as new
			else {

				$result->setTestId($this->req('test_id'));
				$result->setTitle($this->req('title'));
				$result->setTpe($this->req('tpe'));
				$result->setFunc($this->req('func'));
				$result->setText($this->req('text'));

				if ($result->save())
					nvHtml::admin_notices('Сохранен', 'danger');
				else
					nvHtml::admin_notices('Не удалось сохранить', 'danger');
			}
		}

		$this->action_index();
	}

	/**
	 * Delete custom result and show form with all results
	 */
	public function action_delete() {

		$test = nvModel::factory('nvTest');
		$result = nvModel::factory('nvResult');

		$results = array();
		
		$testId = $this->req('test_id');

		if ($this->req('test_id')) {

			if ($this->req('id')) {
				if ($result->delete($this->req('id')))
					nvHtml::admin_notices('The Result successfully Removed', 'info');
				else
					nvHtml::admin_notices("Can't Delete Result");
			}

		}

		$this->action_index();
	}
}
?>