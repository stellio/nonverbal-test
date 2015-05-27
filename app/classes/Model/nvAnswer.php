<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Answer data model
 */
class Model_nvAnswer extends Core_Model {
	
	/**
	 * ID of answeer
	 * @var integer
	 */
	private $_id = 0;

	/**
	 * Text of answer
	 * @var string
	 */
	private $_text = '';

	/**
	 * Value of answer (any symbol)
	 * @var string
	 */
	private $_value = '';

	/**
	 * ID of question that associated with this answer
	 * @var integer
	 */
	private $_question_id = 0;

	/**
	 * ID of associated item - Question|Result
	 * @var integer
	 */
	private $_next_item_id = 0;

	/**
	 * Type of associated item
	 * @var integer
	 */
	private $_next_item_type = 0;

	private $_type = 0;

	/**
	 * Id of test
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

	public function setValue($value) {
		$this->_value = (string)$value;
	}

	public function getValue(){
		return $this->_value;
	}

	public function setQuestionId($id) {
		$this->_question_id = (int)$id;
	}

	public function getQuestionId() {
		return $this->_question_id;
	}

	public function setNextItemId($id) {
		$this->_next_item_id = (int)$id;
	}

	public function getNextItemId() {
		return $this->_next_item_id;
	}

	public function setNextItemType($type) {
		$this->_next_item_type = (int)$type;
	}

	public function getNextItemType() {
		return $this->_next_item_type;
	}

	public function setType($type) {
		$this->_type = (int)$type;
	}

	public function getType(){
		return $this->_type;
	}

	public function setTestId($id) {
		$this->_test_id = (int)$id;
	}

	public function getTestId() {
		return $this->_test_id;
	}

	/**
	 * Return associative array of answer 
	 * @param  integer 	$id		test id
	 * @return array|boolean  	array of ansers or false;
	 */
	public function getListByTestId($id) {

		if ($id) {

			$query = "SELECT * FROM " . $this->_tableAnswers . ' WHERE test_id=' . $id;
			$type = 'ARRAY_A';
			return $this->_db->get_results($query, $type);

		} else {
			return false;
		}
	}

	/**
	 * Return associative array of answers
	 * @param  integer		question id
	 * @return array|boolean	array of answer or false
	 */
	public function getListByQuestionId($id) {

		if ($id) {

			$query = "SELECT * FROM " . $this->_tableAnswers . ' WHERE question_id=' . $id;
			$type = 'ARRAY_A';
			return $this->_db->get_results($query, $type);

		} else {
			return false;
		}
	}

	public function getObjectListByQuestionId($id) {

		if ($id) {

			$query = "SELECT * FROM " . $this->_tableAnswers . ' WHERE question_id=' . $id;
			// $type = 'ARRAY_A';
			return $this->_db->get_results($query);

		} else {
			return false;
		}
	}

	public function getListByQuestionIdAndTestId($questionId, $testId) {

		if ($questionId && $testId) {

			$query = "SELECT * FROM " . $this->_tableAnswers . ' WHERE question_id=' . $questionId . ' AND test_id=' . $testId;
			$type = 'ARRAY_A';
			return $this->_db->get_results($query, $type);

		} else {
			return false;
		}
	}

	public function getObjectListByQuestionIdAndTestId($questionId, $testId) {

		if ($questionId && $testId) {

			$query = "SELECT * FROM " . $this->_tableAnswers . ' WHERE question_id=' . $questionId . ' AND test_id=' . $testId;
			return $this->_db->get_results($query);

		} else {
			return false;
		}
	}

	/**
	 * Load answer from db by id
	 * @param  integer			$id	id of answer
	 * @return TT_Model|boolean	instance of self or false
	 */
	public function loadById($id) {

		$id = (int)$id;
		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableAnswers . ' WHERE id=' . $id;

			$object = $this->_db->get_row($query);

			$this->_id = $object->id;
			$this->_text = $object->text;
			$this->_value = $object->value;
			$this->_question_id = $object->question_id;
			$this->_next_item_id = $object->next_item_id;
			$this->_next_item_type = $object->next_item_type;
			$this->_type = $object->type;
			$this->_test_id = $object->test_id;

			return $this;
		} else {
			return false;
		}


	}

	/**
	 * Update existing answer by id from db
	 * @param  integer $id 	answer id
	 * @return boolean		status of operation
	 */
	public function update($id) {

		$id = (int)$id;
		$result = false;

		if ($id) {

			$result = $this->_db->update(
				$this->_tableAnswers,
				array(                              // values
					'text' => $this->_text,
					'value' => $this->_value,
					'question_id' => $this->_question_id,
					'next_item_id' => $this->_next_item_id,
					'next_item_type' => $this->_next_item_type,
					'type' => $this->_type,
					'test_id' => $this->_test_id
				),
				array('id' => $id),				// conditions
				array('%s', '%s', '%d', '%d', '%d', '%d', '%d'),
				array('%d')
			);

			if ($result === 0)
				$result = true;
		}
		return $result;
	}

	/**
	 * Save answer
	 * @return boolean 		result of operation
	 */
	public function save() {

		$result = $this->_db->insert(
			$this->_tableAnswers,
			array(
				'text' => $this->_text,
				'value' => $this->_value,
				'question_id' => $this->_question_id,
				'next_item_id' => $this->_next_item_id,
				'next_item_type' => $this->_next_item_type,
				'type' => $this->_type,
				'test_id' => $this->_test_id
			)
		);

		if ($result) {
			$this->_id = $this->_db->insert_id;
		}

		return $result;
	}

	/**
	 * Delete answer from db by id
	 * @param  integer $id 	answer id
	 * @return boolean    	result of operation
	 */
	public function delete($id) {

		$result = false;
		$id = (int)$id;

		if($id) {
			$result = $this->_db->delete(
				$this->_tableAnswers,
				array('id' => $id),
				array('%d')
			);
		}
		return $result;
	}
}