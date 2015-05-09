<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Model_nvTest extends Core_Model {

	public $_id = 0;
	public $_name = '';
	public $_description = '';
	public $_first_question_id = 0;
	public $_status = 0;
	public $_create_date;
	public $_is_reg_only = 0;
	public $_is_debug = 0;
	public $_user_id = 0;

	public function setId($id) {
		$this->_id = (int)$id;
	}

	public function getId() {
		return $this->_id;
	}

	public function setName($name) {
		$this->_name = (string)$name;
	}

	public function getName() {
		return $this->_name;
	}

	public function setDescription($description) {
		$this->_description = (string)$description;
	}

	public function getDescription() {
		return $this->_description;
	}

	public function setFirstQuestionId($id) {
		$this->_first_question_id = (int)$id;
	}

	public function getFirstQuestionId() {
		return $this->_first_question_id;
	}

	public function setDebug($action) {
		$this->_is_debug = (int)$action;
	}

	public function setRegOnly($is_reg_only) {
		$this->_is_reg_only = (int)$is_reg_only;
	}

	public function isRegOnly() {
		return $this->_is_reg_only;
	}

	public function isDebug() {
		return $this->_is_debug;
	}

	public function loadById($id) {

		$id = (int)$id;
		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableTests . ' WHERE id=' . $id;

			$object = $this->_db->get_row($query);

			$this->_id = $object->id;
			$this->_name = $object->name;
			$this->_description = $object->description;
			$this->_first_question_id = $object->first_question_id;
			$this->_status = $object->status;
			$this->_create_date = $object->create_date;
			$this->_is_reg_only = $object->is_reg_only;
			$this->_is_debug = $object->is_debug;
			$this->_user_id = $object->user_id;
		}
	}

	public function isExist($name) {

		$name = (string)$name;
		$result = false;

		if ($name) {

			$query = "SELECT COUNT(*) FROM " . $this->_tableTests . " WHERE name LIKE '" . $name . "'";
			// $query = 'SELECT COUNT(*) FROM ' . $this->_tableTests;

			if(intval($this->_db->get_var($query)) > 0) {
				$result = true;
			}
		}
		return $result;
	}

	public function update($id) {

		$id = (int)$id;
		$result = false;

		if ($id) {

			$result = $this->_db->update(
				$this->_tableTests,
				array(                              // values
					'name' => $this->_name,
					'description' => $this->_description,
					'first_question_id' => $this->_first_question_id,
					'status' => $this->_status,
					'create_date' => $this->_create_date,
					'is_reg_only' => $this->_is_reg_only,
					'is_debug' => $this->_is_debug,
					'user_id' => $this->_user_id
				),
				array('id' => $id),				// conditions
				array('%s', '%s', '%d', '%d', '%s', '%d', '%d', '%d'),
				array('%d')
			);

			if ($result === 0)
				$result = true;
		}
		return $result;
	}

	public function save() {

		$result = false;
		$result = $this->_db->insert(
			$this->_tableTests,
			array(
				'name' => $this->_name,
				'description' => $this->_description,
				'first_question_id' => $this->_first_question_id,
				// 'status' => $val,
				'create_date' => $this->getDatetime(),
				'is_reg_only' => $this->_is_reg_only,
				'is_debug' => $this->_is_debug,
				'user_id' => get_current_user_id()
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
				$this->_tableTests,
				array('id' => $id),
				array('%d')
			);
		}
		return $result;
	}

}