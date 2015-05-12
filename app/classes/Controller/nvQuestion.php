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
class Controller_nvQuestion extends Controller_ContentTemplate {
	
	
	public $view;
	public $testId = '';

	function __construct() {
		parent::__construct();
	}

	/**
	 * Shows all test questions
	 */
	public function action_index() {

		$test = nvModel::factory('nvTest');
		$answers = nvModel::factory('nvAnswer');
		$question = nvModel::factory('nvQuestion');
		$view = nvView::factory('question/list');
		$content = null;
		
		$id = $this->req('test_id');

		if ($id) {

			$content = $question->getListByTestId($id);
			$test->loadById($id);
			$this->testId = $id;
		}

		$this->template->content = $view->bind('testId', $this->testId)
										->bind('test', $test)
									    ->bind('answers', $answers)
									    ->bind('content', $content);
    }

	/**
	 * Show form to add new question
	 */
	public function action_add() {

		$test = nvModel::factory('nvTest');
		$question = nvModel::factory('nvQuestion');
		$view = nvView::factory('question/edit');

		if ($this->req('test_id'))
			$test->loadById($this->req('test_id'));

		$this->template->content = $view->bind('test', $test)->bind('question', $question);
	}

	/**
	 * Show form to edit exist question
	 */
	public function action_edit() {

		$test = nvModel::factory('nvTest');
		$answer = nvModel::factory('nvAnswer');
		$question = nvModel::factory('nvQuestion');
		$view = nvView::factory('question/edit');
		$answers = array();

		if ($this->req('test_id')) {
			
			$test->loadById($this->req('test_id'));
			
			if($this->req('id')) {
				$question->loadById($_GET['id']);
				$answers = $answer->getListByQuestionIdAndTestId($question->getId(), $test->getId());
			}
		}

		$this->template->content = $view->bind('test', $test)
										->bind('answers', $answers)
										->bind('question', $question);
	}

	/**
	 * Save new question and show
	 */
	public function action_save() {

		$answersList = array();
		$test = nvModel::factory('nvTest');
		$answer = nvModel::factory('nvAnswer');
		$question = nvModel::factory('nvQuestion');
		// $this->view = new View_nvQuestionAdd();
		// $view = nvView::factory()

		// first check if 'test_id' set
		if ($this->req('test_id')) {

			$test->loadById($this->req('test_id'));

			// update question
			if ($this->req('id')) {

				// load question from db
				$question->loadById($this->req('id'));
				$question->setText($this->req('text'));
				$question->setType($this->req('type'));

				// check if set as first question
				if ($this->req('treetest-first-question') == 'on') {
					$test->setFirstQuestionId($question->getId());
					$test->update($test->getId());
				} else {
					$test->setFirstQuestionId(0);
					$test->update($test->getId());
				}

				if ($question->update($this->req('id')))
					nvHtml::admin_notices('Question Updated', 'info');
				else
					nvHtml::admin_notices('Cant Updated The Question!');
			}
			// save question as new
			else {

				$question->setText($this->req('text'));
				$question->setType($this->req('type'));
				$question->setTestId($this->req('test_id'));

				if ($question->save()) {

					if ($this->req('treetest-first-question') == 'on') {
						$test->setFirstQuestionId($question->getId());
						$test->update($test->getId());
					} else {
						$test->setFirstQuestionId(0);
						$test->update($test->getId());	
					}

					nvHtml::admin_notices('Question Created', 'info');
				}
				else
					nvHtml::admin_notices('Cant Create Question');
			}

			// check set answers
			if ($this->req('answers')) {

				$profileType = $this->req('type');

				foreach ($this->req('answers') as $type => $answers) {

					// if type 'exists' -> update answer
					if ($type == nvModel::TYPE_EXISTS) {
						foreach ($answers as $id => $ans) {

							// load another answer details (test_id, question_id, next_question_id)
							$answer->loadById($id);
							$answer->setText($ans['text']);
							$answer->setValue($ans['value']);
							$answer->setType($profileType);

							// try to update
							if (!$answer->update($id))
								nvHtml::admin_notices('Cant Update Answer');
						}
					}
					// if 'new' - save
					elseif ($type == nvModel::TYPE_NEW) {
						foreach ($answers as $id => $ans) {
							// check if text not empty
							// clean veriable
							if (!empty($ans['text'])) {
								$answer = nvModel::factory('nvAnswer');
								$answer->setTestId($this->req('test_id'));
								$answer->setText($ans['text']);
								$answer->setValue($ans['value']);
								$answer->setType($profileType);
								$answer->setQuestionId($question->getId());
								if (!$answer->save())
									nvHtml::admin_notices('Can\'t Save Answer');			
							}
						}
					}
					// if 'remove' - remove
					elseif ($type == nvModel::TYPE_REMOVE) {
						foreach ($answers as $id => $text) {
							$answer->delete($id);
						}
					}
				}
			}
			// load updated or saved answers
			$answersList = $answer->getListByQuestionIdAndTestId($question->getId(), $test->getId());
		}

		$this->action_index();
	}

	/**
	 * Delete custom question and show all test question
	 */
	public function action_delete() {

		$test = nvModel::factory('nvTest');
		$answers = nvModel::factory('nvAnswer');
		$question = nvModel::factory('nvQuestion');
				
		$id = $this->req('id');
		$testId = $this->req('test_id');

		if ($id) {
			if ($question->delete($id)) 
				nvHtml::admin_notices('Question Deleted', 'info');
			else
				nvHtml::admin_notices('Cant Delete The Question!');
		}


		$this->action_index();
	}
}
?>