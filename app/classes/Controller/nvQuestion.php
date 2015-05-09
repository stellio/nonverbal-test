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
class Controller_nvQuestion extends NV_Controller {
	
	const TYPE_NEW = 'new';
	const TYPE_EXISTS = 'exists';
	const TYPE_REMOVE = 'remove';
	public $view;
	public $testId = '';

	function __construct() {
		parent::__construct();
	}

	/**
	 * Shows all test questions
	 */
	public function action_index() {

		$test = new Model_nvTest();
		$answers = new Model_nvAnswer();
		$question = new Model_nvQuestion();
		$this->view = new View_nvQuestionList();
		
		$id = $this->req('test_id');

		if ($id) {

			$this->view->content = $question->getListByTestId($id);
			$test->loadById($id);
			$this->testId = $id;
		}

		// $this->view->question = $question;
		$this->view->testId = $this->testId;
		$this->view->test = $test;
		$this->view->answers = $answers;
		$this->view->show();
	}

	/**
	 * Show form to add new question
	 */
	public function action_add() {

		$test = new Model_nvTest();
		$question = new Model_nvQuestion();
		$this->view = new View_nvQuestionAdd();

		if ($this->req('test_id'))
			$test->loadById($this->req('test_id'));

		$this->view->test = $test;
		$this->view->question = $question;
		$this->view->show();
	}

	/**
	 * Show form to edit exist question
	 */
	public function action_edit() {

		$test = new Model_nvTest();
		$answer = new Model_nvAnswer();
		$question = new Model_nvQuestion();
		$this->view = new View_nvQuestionAdd();
		$answers = array();

		if ($this->req('test_id')) {
			
			$test->loadById($this->req('test_id'));
			
			if($this->req('id')) {
				$question->loadById($_GET['id']);
				$answers = $answer->getListByQuestionIdAndTestId($question->getId(), $test->getId());
			}
		}

		$this->view->test = $test;
		$this->view->answers = $answers;
		$this->view->question = $question;

		$this->view->show();
	}

	/**
	 * Save new question and show
	 */
	public function action_save() {

		$answersList = array();
		$test = new Model_nvTest();
		$answer = new Model_nvAnswer();
		$question = new Model_nvQuestion();
		$this->view = new View_nvQuestionAdd();

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
					NV_View::admin_notices('Question Updated', 'info');
				else
					NV_View::admin_notices('Cant Updated The Question!');
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

					NV_View::admin_notices('Question Created', 'info');
				}
				else
					NV_View::admin_notices('Cant Create Question');
			}

			// check set answers
			if ($this->req('answers')) {

				$profileType = $this->req('type');

				foreach ($this->req('answers') as $type => $answers) {

					// if type 'exists' -> update answer
					if ($type == Controller_nvQuestion::TYPE_EXISTS) {
						foreach ($answers as $id => $ans) {

							// load another answer details (test_id, question_id, next_question_id)
							$answer->loadById($id);
							$answer->setText($ans['text']);
							$answer->setValue($ans['value']);
							$answer->setType($profileType);

							// try to update
							if (!$answer->update($id))
								NV_View::admin_notices('Cant Update Answer');
						}
					}
					// if 'new' - save
					elseif ($type == Controller_nvQuestion::TYPE_NEW) {
						foreach ($answers as $id => $ans) {
							// check if text not empty
							// clean veriable
							if (!empty($ans['text'])) {
								$answer = new Model_nvAnswer();
								$answer->setTestId($this->req('test_id'));
								$answer->setText($ans['text']);
								$answer->setValue($ans['value']);
								$answer->setType($profileType);
								$answer->setQuestionId($question->getId());
								if (!$answer->save())
									NV_View::admin_notices('Can\'t Save Answer');			
							}
						}
					}
					// if 'remove' - remove
					elseif ($type == Controller_nvQuestion::TYPE_REMOVE) {
						foreach ($answers as $id => $text) {
							$answer->delete($id);
						}
					}
				}
			}
			// load updated or saved answers
			$answersList = $answer->getListByQuestionIdAndTestId($question->getId(), $test->getId());
		}

//		$this->view->test = $test;
//		$this->view->question = $question;
//		$this->view->answers = $answersList;
//		$this->view->show();
		$this->action_index();
	}

	/**
	 * Delete custom question and show all test question
	 */
	public function action_delete() {

		$test = new Model_nvTest();
		$answers = new Model_nvAnswer();
		$question = new Model_nvQuestion();
		$this->view = new View_nvQuestionList();
		
		$id = $this->req('id');
		$testId = $this->req('test_id');

		if ($id) {
			if ($question->delete($id)) 
				NV_View::admin_notices('Question Deleted', 'info');
			else
				NV_View::admin_notices('Cant Delete The Question!');
		}


		if ($testId) {

			$this->view->content = $question->getListByTestId($testId);
			$test->loadById($testId);
			$this->testId = $testId;
		}

		// $this->view->question = $question;
		$this->view->testId = $this->testId;
		$this->view->answers = $answers;
		$this->view->test = $test;
		$this->view->show();
	}
}
?>