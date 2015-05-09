<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Result data model
 */
class Model_nvResult extends Core_Model {

	/**
	 * Id of result
	 * @var integer
	 */
	private $_id = 0;

	/**
	 * Title of result
	 * @var string
	 */
	private $_title = '';

	/**
	 * Text of result
	 * @var string
	 */
	private $_text = '';

	/**
	 * The sequence of necessary answers to display this result as correct
	 * @var string
	 */
	private $_sequence_of_anwers = '';

	/**
	 * Associated id of answer
	 * @var integer
	 */
	private $_answer_id = 0;


	private $_tpe = "";

	private $_func = "";

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

	public function setTitle($title) {
		$this->_title = (string)$title;
	}

	public function getTitle() {
		return $this->_title;
	}

	public function setText($text) {
		$this->_text = (string)$text;
	}

	public function getText() {
		return $this->_text;
	}

	public function setSequenceOfAnswers($sequence) {
		$this->_sequence_of_anwers = (string)$sequence;
	}

	public function getSequenceOfAnswers() {
		return $this->_sequence_of_anwers;
	}

	public function setAnswerId($id) {
		$this->_answer_id = (int)$id;
	}

	public function getAnswerId() {
		return $this->_answer_id;
	}

	public function setTpe($tpe) {
		$this->_tpe = (string)$tpe;
	}

	public function getTpe() {
		return $this->_tpe;
	}

	public function setFunc($item) {
		$this->_func = (string)$item;
	}

	public function getFunc() {
		return $this->_func;
	}

	public function setTestId($id) {
		$this->_test_id = (int)$id;
	}

	public function getTestId() {
		return $this->_test_id;
	}

	/**
	 * Return title of result
	 * @param  int $id 			result id
	 * @return string|bool     	title text or false
	 */
	public function getTitleById($id) {

		$result = false;

		if ($id) {

			$query = 'SELECT title FROM ' . $this->_tableResults . ' WHERE id=' . $id;
			$request = $this->_db->get_row($query);

			if ($request)
				$result = $request->title;

			return $result;
		} else {
			return $result;
		}
	}

	/**
	 * Return results list of test
	 * @param  integer $id 	the test id
	 * @return array     	list of resutls
	 */
	public function getListByTestId($id) {

		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableResults . ' WHERE test_id=' . $id;
			return $this->_db->get_results($query);

		} else {
			return false;
		}
	}

	public function getListByTestIdAndTpe($id, $tpe) {

		if ($id) {

			$query = "SELECT * FROM " . $this->_tableResults . " WHERE test_id=" . $id . " AND tpe LIKE '". $tpe ."'";

			return $this->_db->get_results($query);

		} else {
			return false;
		}
	}

	/**
	 * Return results list of test
	 * @param  integer $id 	the test id
	 * @return array     	list of results
	 */
	public function getByAnswerId($id) {

		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableResults . ' WHERE answer_id=' . $id;
			return $this->_db->get_results($query);

		} else {
			return false;
		}
	}


	/**
	 * Load result values from db
	 * @param  integer $id 			the result id
	 * @return object|boolean     	$this or false if nothing find
	 */
	public function loadById($id) {

		$id = (int)$id;
		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableResults . ' WHERE id=' . $id;

			$object = $this->_db->get_row($query);

			$this->_id = $object->id;
			$this->_text = $object->text;
			$this->_sequence_of_anwers = $object->sequence_of_anwers;
			$this->_title = $object->title;
			$this->_test_id = $object->test_id;
			$this->_tpe = $object->tpe;
			$this->_func = $object->func;
			$this->_answer_id = $object->answer_id;

			return $this;
		} else {
			return false;
		}
	}

	/**
	 * Update custom result
	 * @param  integer $id the result id
	 * @return boolean     operation status
	 */
	public function update($id) {

		$id = (int)$id;
		$result = false;

		if ($id) {

			$result = $this->_db->update(
				$this->_tableResults,
				array(                              // values
					'text' => $this->_text,
					'sequence_of_anwers' => $this->_sequence_of_anwers,
					'title' => $this->_title,
					'answer_id' => $this->_answer_id,
					'tpe' => $this->_tpe,
					'func' => $this->_func,
					'test_id' => $this->_test_id
				),
				array('id' => $id),				// conditions
				array('%s', '%s', '%s', '%d', '%s', '%s', '%d'),
				array('%d')
			);

			if ($result === 0)
				$result = true;
		}
		return $result;
	}

	/**
	 * Save current result
	 * @return boolean operation status
	 */
	public function save() {

		$result = $this->_db->insert(
			$this->_tableResults,
			array(
				'text' => $this->_text,
				'sequence_of_anwers' => $this->_sequence_of_anwers,
				'title' => $this->_title,
				'answer_id' => $this->_answer_id,
				'tpe' => $this->_tpe,
				'func' => $this->_func,
				'test_id' => $this->_test_id
			)
		);

		if ($result) {
			$this->_id = $this->_db->insert_id;
		}

		return $result;
	}

	/**
	 * Delete custom result from db
	 * @param  integer $id the result id
	 * @return boolean     operations status
	 */
	public function delete($id) {

		$result = false;
		$id = (int)$id;

		if($id) {
			$result = $this->_db->delete(
				$this->_tableResults,
				array('id' => $id),
				array('%d')
			);
		}
		return $result;
	}	
}