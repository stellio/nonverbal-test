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
class Controller_nvResult extends NV_Controller {
	
	public $view;
	public $testId = '';

	function __construct() {
		parent::__construct();
	}

	/**
	 * Show all results for test
	 */
	public function action_index() {

		$test = new Model_nvTest();
		$result = new Model_nvResult();
		$this->view = new View_nvResultList();

		$results = array();
		
		$testId = $this->req('test_id');

		if ($testId) {
			$test->loadById($testId);
			$results = $result->getListByTestId($test->getId());
		}

		$this->view->test = $test;
		$this->view->results = $results;

		$this->view->show();
	}

	/**
	 * Show form to add new result
	 */
	public function action_add() {

		$test = new Model_nvTest();
		$result = new Model_nvResult();
		$this->view = new View_nvResultAdd();
		$tpe = new Model_nvTpe();
		$tpeList = array();

		$testId = $this->req('test_id');
		if ($testId) {
			$test->loadById($testId);
			$tpeList = $tpe->loadByTest($testId);
		}

		$this->view->tpe = $tpeList;
		$this->view->test = $test;
		$this->view->result = $result;

		$this->view->show();
	}

	/**
	 * Show form to edit result
	 */
	public function action_edit() {

		$tpe = new Model_nvTpe();
		$test = new Model_nvTest();
		$result = new Model_nvResult();
		$this->view = new View_nvResultAdd();

		$tpeList = array();

		$testId = $this->req('test_id');
		if ($testId) {
			$test->loadById($testId);
			$tpeList = $tpe->loadByTest($testId);


			if ($this->req('id')) {
				$result->loadById($this->req('id'));
			}
		}

		$this->view->tpe = $tpeList;
		$this->view->test = $test;
		$this->view->result = $result;

		$this->view->show();
	}

	/**
	 * Save result and show it
	 */
	public function action_save() {

		$test = new Model_nvTest();
		$result = new Model_nvResult();
		$this->view = new View_nvResultAdd();

		if ($this->req('test_id')) {
			$test->loadById($this->req('test_id'));

			// update result
			if ($this->req('id')) {

				// load question from db
				$result->loadById($this->req('id'));
				$result->setTitle($this->req('title'));
				$result->setTpe($this->req('tpe'));
				$result->setFunc($this->req('func'));
				$result->setText($this->req('description'));

				if ($result->update($this->req('id')))
					NV_View::admin_notices('Result Updated', 'info');
				else
					NV_View::admin_notices('Cant Updated The Result!');
			}
			// save result as new
			else {

				$result->setTestId($this->req('test_id'));
				$result->setTitle($this->req('title'));
				$result->setTpe($this->req('tpe'));
				$result->setFunc($this->req('func'));
				$result->setText($this->req('description'));

				if ($result->save())
					NV_View::admin_notices('Result Created', 'info');
				else
					NV_View::admin_notices('Cant Create Result');
			}
		}

//		$this->view->test = $test;
//		$this->view->result = $result;

		$this->action_index();
	}

	/**
	 * Delete custom result and show form with all results
	 */
	public function action_delete() {

		$test = new Model_nvTest();
		$result = new Model_nvResult();
		$this->view = new View_nvResultList();

		$results = array();
		
		$testId = $this->req('test_id');

		if ($this->req('test_id')) {

			if ($this->req('id')) {
				if ($result->delete($this->req('id')))
					NV_View::admin_notices('The Result successfully Removed', 'info');
				else
					NV_View::admin_notices("Can't Delete Result");
			}

		}


		if ($testId) {
			$test->loadById($testId);
			$results = $result->getListByTestId($test->getId());
		}

		$this->view->test = $test;
		$this->view->results = $results;

		$this->view->show();
	}
}
?>