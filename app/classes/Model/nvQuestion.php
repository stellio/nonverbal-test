<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Question data model
 */
class Model_nvQuestion extends Core_Model {


	const TYPE_TPE = '1';
	const TYPE_FUNCTIONAL = '2';
	/**
	 * ID of question
	 * @var integer
	 */
	private $_id = 0;

	/**
	 * Question text
	 * @var string
	 */
	private $_text = '';

	/**
	 * List of answers
	 * @var string
	 */
	private $_answers_id = '';

	private $_type = 0;

	private $_cycle = 0;
	/**
	 * Test id
	 * @var integer
	 */
	private $_test_id = 0;



	public function setId($id) {
		$this->_id = (int)$id;
	}

	public function getId() {
		return $this->_id;
	}

	public function setText($text) {
		$this->_text = (string)$text;
	}
	
	public function getText() {
		return $this->_text;
	}

	public function setAnswersId($answers) {
		$this->_answers_id = (string)$answers;
	}

	public function getAnswersId() {
		return $this->_answers_id;
	}

	public function setType($type) {
		$this->_type = (int)$type;
	}

	public function getType() {
		return $this->_type;
	}

	public function setCycle($cycle) {
		$this->_cycle = (int)$cycle;
	}

	public function getCycle() {
		return $this->_cycle;
	}

	public function setTestId($id) {
		$this->_test_id = (int)$id;
	}

	public function getTestId() {
		return $this->_test_id;
	}

	/**
	 * Check if this question starts testing
	 * @param  integer  $id		test id
	 * @return boolean     		
	 */
	public function isFirst($id) {

		$result = false;

		if ($id) {

			$query = "SELECT first_question_id FROM " . $this->_tableTests . ' WHERE id=' . $id;
			$request = $this->_db->get_row($query);

			if ($request->first_question_id == $this->_id) {
				$result = true;
			}
		}
		return $result;
	}

	/**
	 * Return associative array list of question
	 * @param  integer $id		test id
	 * @return array|boolean    array or false
	 */
	public function getListByTestId($id) {

		if ($id) {

			$query = "SELECT * FROM " . $this->_tableQuestions . ' WHERE test_id=' . $id . ' ORDER BY type ASC';
			$type = 'ARRAY_A';
			return $this->_db->get_results($query, $type);

		} else {
			return false;
		}
	}

	public function getObjectListByTestId($id) {

		if ($id) {

			$query = "SELECT * FROM " . $this->_tableQuestions . ' WHERE test_id=' . $id . " ORDER BY type ASC";
			return $this->_db->get_results($query);

		} else {
			return false;
		}
	}

	public function getObjectListByTestIdAndType($id, $type) {

		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableQuestions . ' WHERE test_id=' . $id . ' AND type=' . $type;
			return $this->_db->get_results($query);

		} else {
			return false;
		}
	}

	/**
	 * Load question by id
	 * @param  integer 	$id	 		question id	
	 * @return TT_Model|boolean     self instance or false
	 */
	public function loadById($id) {

		$id = (int)$id;
		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableQuestions . ' WHERE id=' . $id;
			$object = $this->_db->get_row($query);

			$this->_id = $object->id;
			$this->_text = $object->text;
			$this->_answers_id = $object->answers_id;
			$this->_type = $object->type;
			$this->_cycle = $object->cycle;
			$this->_test_id = $object->test_id;

			return $this;
		} else {
			return false;
		}
	}

	public function update($id) {

		$id = (int)$id;
		$result = false;

		if ($id) {

			$result = $this->_db->update(
				$this->_tableQuestions,
				array(                              // values
					'text' => $this->_text,
					'answers_id' => $this->_answers_id,
					'type' => $this->_type,
					'cycle' => $this->_cycle,
					'test_id' => $this->_test_id
				),
				array('id' => $id),				// where condition
				array('%s', '%s', '%d', '%d', '%d'),		// value types
				array('%d')						// condition type
			);

			if ($result === 0)
				$result = true;
		}
		return $result;
	}

	public function save() {

		$result = $this->_db->insert(
			$this->_tableQuestions,
			array(
				'text' => $this->_text,
				'answers_id' => $this->_answers_id,
				'type' => $this->_type,
				'cycle' => $this->_cycle,
				'test_id' => $this->_test_id
			)
		);

		if ($result) {
			$this->_id = $this->_db->insert_id;
		}
		return $result;
	}

	public function delete($id) {

		$result = false;
		$id = (int)$id;

		if($id) {
			$result = $this->_db->delete(
				$this->_tableQuestions,
				array('id' => $id),
				array('%d')
			);
		}
		return $result;
	}
}