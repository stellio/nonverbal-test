<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Manage test
 */
class Controller_nvTest extends Controller_TestMenuTemplate  {

	public $view;

	public function __construct() {
		parent::__construct();
    }


	/**
	 * Show list of existing tests
	 */
	public function action_index() {
		
		$view = nvView::factory('test/list');
		$test = nvModel::factory('nvTestList');

		$this->template->content = $view->bind('tests', $test->getTestList());
	}


	/**
	 * Show form to add test
	 */
    public function action_add() {

		$this->view = new View_nvTestEdit();
		$test = new Model_nvTest();

		$this->view->test = $test;
		$this->view->show();
	}

	/**
	 * Show form to edit test
	 */
	public function action_edit() {

		$view = nvView::factory('test/edit');// View_nvTestEdit();
		$test = nvModel::factory('nvTest');

		if (isset($_GET['id']) and $_GET['id'] != 0)
			$test->loadById($_GET['id']);

		// $this->view->test = $test;
		// $this->view->show();
		$this->template->content = $view->bind('test', $test);
	}

	/**
	 * Save test and show it in form
	 */
	public function action_save() {

		$this->view = new View_nvTestEdit();
		$test = new Model_nvTest();

		$paramId = $this->req('id');
		$paramName = $this->req('name');

		if ($paramId) {
			// echo $_GET['id'];
			// update
			$test->loadById($_GET['id']);

			$test->setRegOnly($this->req("onlyregistered"));
			$test->setDebug($this->req("debugmode"));

			if ($paramName)
				$test->setName($paramName);
		
			if (isset($_POST['description']))
				$test->setDescription($this->req('description'));

			// try to update
			if ($test->update($_GET['id']))
				NV_View::admin_notices('Test Updated', 'info');
			else
				NV_View::admin_notices('Cant Updated The Test!');		
			
		} else {
			//save
			$test->setRegOnly($this->req('onlyregistered'));
			$test->setDebug($this->req('debugmode'));

			if (isset($_POST['name']))
				$test->setName($_POST['name']);

			if (isset($_POST['description']))
				$test->setDescription($_POST['description']);

			
			// try to save
			if ($test->save())
				NV_View::admin_notices('Test Created', 'info');
			else
				NV_View::admin_notices('Cant crate test');
			
		}

		$this->view->test = $test;
		$this->view->show();
	}

	/**
	 * Delete test and show all existing test
	 */
	public function action_delete() {

		$this->view = new View_nvTestList();
		$test = new Model_nvTest();
		$list = new Model_nvTestList();

		if (isset($_GET['id']) && $_GET['id'] != 0) {

			if ($test->delete($_GET['id']))
				NV_View::admin_notices('The Test successfully Removed', 'info');
			else
				NV_View::admin_notices("Can't Delete Test");
		}

//		$this->view->content = $list->getTestList();
//		$this->view->show();
		$this->action_index();
	}

	public function ajax_createTest() {

		$test = nvModel::factory('nvTest');
		$response = 0;

		if ($this->req('test_name')) {

			// check if test exist 
			if ($test->isExist($this->req('test_name'))) {
				$response = $this->jsonArray('error', 'Ошибка! Тест с таким именем уже существует.');
			} else {
				$test->setName($this->req('test_name'));
				$test->save();

				$response = $this->jsonArray('success', $test->getId());
			}
		}
		wp_send_json($response); 
		exit;
	}

}
?>