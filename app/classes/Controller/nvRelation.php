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

	public static function relationWalk($parent_id, $items, $structure) {

		$buttons = array();
		  		
  		foreach ($items as $item) {
  			
  			if ($item->parent_id === $parent_id) {

  				$buttons[] = $item;
  				$structure = $buttons;
  				$item->childs = array();

  				Controller_nvRelation::relationWalk($item->id, $items, &$item->childs);
  			}
  		}

	}

	/**
	 * Shows all test questions
	 */
	public function action_index() {
		$test = nvModel::factory('nvTest');
		$relation = nvModel::factory('nvRelation');
		$view = nvView::factory('relation/list');

		$test_id = $this->req('test_id');

		$structures = array();
//		$test = new Model_nvTest();

		if ($test_id) {
			$test->loadById($test_id);

			$roots = $relation->getRoots($test_id);
			$relations = $relation->getByTestId($test_id);


			// 
			// structures (
			// 		array(
			// 			array('button 0'), array('button 1', 'button 2'), array('button', 'button', 'button')
			// 		),
			// 		array(
			// 		
			// 		),
			// 		array(
			// 		
			// 		),
			// 		array(
			// 		
			// 		)
			// )

			foreach ($roots as $root) {
				
				$subElements = 0;
				$structure = array();
				$structure = $root;

				// echo "<button>" . $root->code . "</button><br>";
				$this->relationWalk($root->id, $relations, &$subElements);

				$structure->childs = $subElements;
				$structures[] = $structure;
			}
		}

		$this->template->content = $view->bind('test', $test)
										->bind('structures', $structures);
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

		$tpes = $tpe->loadByTest($test_id);
		$signs = $sign->loadByTestId($test_id);
		$profiles = $profile->loadByTestAndTypeId($test_id, nvModel::TYPE_FUNCTIONAL);


		$this->template->content = $view->bind('test_id', $this->req('test_id'))
										->bind('signs', $signs)
										->bind('tpes', $tpes)
										->bind('profiles', $profiles);

	}

	public function action_add_element() {

		$view = nvView::factory('relation/addelement');

		$test_id = $this->req('test_id');
		$parent_id = $this->req('item_id');

		$profile = nvModel::factory('nvProfile');
		$profiles = $profile->loadByTestAndTypeId($test_id, nvModel::TYPE_FUNCTIONAL);


		$this->template->content = $view->bind('parent_id', $parent_id)
										->bind('test_id', $test_id)
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

		$relation = nvModel::factory('nvRelation');

		$test_id = $this->req('test_id');

		$code = $this->req('code');
		$type = $this->req('type');

		$relation->setTestId($test_id);

		$relation->setCode($code);
		$relation->setType($type);
		$relation->save();

		$this->action_index();
	}

	/**
	 * Save sub element 
	 * @return [type] [description]
	 */
	public function action_save_element() {

		$relation = nvModel::factory('nvRelation');

		$test_id = $this->req('test_id');
		$parent_id = $this->req('parent_id');

		$code = $this->req('code');
		$type = $this->req('type');

		$relation->setTestId($test_id);

		$relation->setCode($code);
		$relation->setType($type);
		$relation->setParentId($parent_id);
		$relation->save();

		$this->action_index();

	}

	/**
	 * Delete custom question and show all test question
	 */
	public function action_delete() {

		$relation = nvModel::factory('nvRelation');

		$item_id = $this->req('item_id');

		$relation->delete($item_id);

		$this->action_index();

	}
}
?>