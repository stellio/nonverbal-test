<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Add, update, delete question
 */
class Controller_nvRelation extends Controller_ContentTemplate {
	
	
	function __construct() {
		parent::__construct();
	}

	/**
	 * Shows all test questions
	 */
	public function action_index() {
		$test = nvModel::factory('nvTest');
		$view = nvView::factory('relation/list');

//		$test = new Model_nvTest();

		if ($this->req('test_id')) $test->loadById($this->req('test_id'));
		
		$this->template->content = $view->bind('test', $test);
    }

	/**
	 * Show form to add new question
	 */
	public function action_add() {

		$view = nvView::factory('relation/edit');

		$tpe = nvModel::factory('nvTpe');
		$sign = nvModel::factory('nvSign');
		$profile = nvModel::factory('nvProfile');

		$test_id = $this->req('test_id');

		$signs = $sign->loadByTestId($test_id);
		$tpes = $tpe->loadByTest($test_id);
		$profiles = $profile->loadByTestAndTypeId($test_id, nvModel::TYPE_FUNCTIONAL);


		$this->template->content = $view->bind('test_id', $this->req('test_id'))
										->bind('signs', $signs)
										->bind('tpes', $tpes)
										->bind('profiles', $profiles);

	}

	/**
	 * Show form to edit exist question
	 */
	public function action_edit() {

	}

	/**
	 * Save new question and show
	 */
	public function action_save() {

	}

	/**
	 * Delete custom question and show all test question
	 */
	public function action_delete() {

	}
}
?>