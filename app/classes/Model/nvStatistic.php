<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Model_nvStatistic extends Core_Model {
	
	/**
	 * Id of Statistic record
	 * @var int
	 */
	private $_id = 0;

    /**
     * Loggined user id
     * @var int
     */
	private $_user_id = 0;

    /**
     * Current Date time stamp
     * @var string
     */
	private $_time;

    /**
     * Id of obtained result
     * @var int
     */
	private $_result_id = 0;

	private $_result_text = '';

	/**
	 * Id of passed test
	 * @var int
	 */
	private $_test_id = 0;

	/**
	 * Survey from data
	 */
	private $_type = '';
	private $_type_another = '';
	private $_type_basis = '';
	private $_age = '';
	private $_gender = '';
	private $_nickname = '';


	public function setId($id) {
		$this->_id = (int)$id;
	}

	public function getId() {
		return $this->_id;
	}

	public function setUserId($id) {
		$this->_user_id = (int)$id;
	}

	public function getUserId() {
		return $this->_user_id;
	}

	public function setTime($time) {
		$this->_time = $time;
	}

	public function getTime() {
		return $this->_time;
	}

	public function setResultId($id) {
		$this->_result_id = (int)$id;
	}

	public function getResultId() {
		return $this->_result_id;
	}

	public function setResultText($text) {
		$this->_result_text = (string)$text;
	}

	public function getResultText() {
		return $this->_result_text;
	}

	public function setTestId($id) {
		$this->_test_id = (int)$id;
	}

	public function getTestId() {
		return $this->_test_id;
	}

	public function setType($type) {
		$this->_type = (string)$type;
	}

	public function getType() {
		return $this->_type;
	}

	public function setTypeAnother($type) {
		$this->_type_another = (string)$type;
	}

	public function getTypeAnother() {
		return $this->_type_another;
	}

	public function setTypeBasis($basis) {
		$this->_type_basis = (string)$basis;
	}

	public function getTypeBasis() {
		return $this->_type_basis;
	}

	public function setAge($age) {
		$this->_age = (string)$age;
	}

	public function getAge() {
		return $this->_age;
	}

	public function setGender($gender) {
		$this->_gender = (string)$gender;
	}

	public function getGender() {
		return $this->_gender;
	}

	public function setNickname($nickname) {
		$this->_nickname = (string)$nickname;
	}

	public function getNickname() {
		return $this->_nickname;
	}

    /**
     * @param $id
     */
	public function loadById($id) {

		$id = (int)$id;
		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableStatistic . ' WHERE id=' . $id;

			$object = $this->_db->get_row($query);

			$this->_id = $object->id;
			$this->_user_id = $object->user_id;
			$this->_time = $object->time;
			$this->_result_id = $object->result_id;
			$this->_result_text = $object->result_text;
			$this->_test_id = $object->test_id;

			// survey form field
			$this->_type = $object->type;
			$this->_type_another = $object->type_another;
			$this->_type_basis = $object->type_basis;
			$this->_age = $object->age;
			$this->_gender = $object->gender;
			$this->_nickname = $object->nickname;
		}
	}

    /**
     * Return statistics list of test
     * @param  int $id      the test id
     * @return array        list of statistics
     */
	public function getListByTestId($id) {

		if ($id) {

			$query = "SELECT * FROM " . $this->_tableStatistic . ' WHERE test_id=' . $id . ' ORDER BY id DESC';
			return $this->_db->get_results($query);

		} else {
			return false;
		}
	}

    /**
     * Save current statistics
     * @return boolean
     */
	public function save() {

		$result = $this->_db->insert(
			$this->_tableStatistic,
			array(
				'user_id' => get_current_user_id(),
				'time' => $this->getDatetime(),
				'result_id' => $this->_result_id,
				'result_text' => $this->_result_text,
				'test_id' => $this->_test_id,

				// survey form data
				'type' => $this->_type,
				'type_another' => $this->_type_another,
				'type_basis' => $this->_type_basis,
				'age' => $this->_age,
				'gender' => $this->_gender,
				'nickname' => $this->_nickname
			)
		);

		if ($result) {
			$this->_id = $this->_db->insert_id;
		}
		return $result;
	}

	public function removeById($id) {

		$result = false;
		$id = (int)$id;

		if($id) {
			$result = $this->_db->delete(
				$this->_tableStatistic,
				array('id' => $id),
				array('%d')
			);
		}
		return $result;
	}

}