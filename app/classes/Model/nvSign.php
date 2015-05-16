<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Model_nvSign extends Core_Model {

	const TYPE_TPE = '1';
	const TYPE_FUNCTIONAL = '2';

	private $_id = 0;
	private $_test_id = 0;
	private $_name = '';
	private $_code = '';
	private $_group_id = 0;
	private $_type = 0;


	public function setId($id) {
		$this->_id = (int)$id;
	}

	public function getId() {
		return $this->_id;
	}

	public function setTestId($id) {
		$this->_test_id = (int)$id;
	}

	public function getTestId() {
		return $this->_test_id;
	}

	public function setName($name) {
		$this->_name = (string)$name;
	}
	
	public function getName() {
		return $this->_name;
	}

	public function setCode($code) {
		$this->_code = (string)$code;
	}

	public function getCode() {
		return $this->_code;
	}

	public function setGroupId($id) {
		$this->_group_id = (int)$id;
	}

	public function getGroupId() {
		return $this->_group_id;
	}

	public function setType($type) {
		$this->_type = (int)$type;
	}

	public function getType() {
		return $this->_type;
	}

	public function load($id) {

		$id = (int)$id;
		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableSigns . ' WHERE id=' . $id;
			$object = $this->_db->get_row($query);

			$this->_id = $object->id;
			$this->_test_id = $object->test_id;
			$this->_name = $object->name;
			$this->_code = $object->code;
			$this->_group_id = $object->group_id;
			$this->_type = $object->type;

			return $this;
		} else {
			return false;
		}
	}

	public function loadByTestId($testId) {

		$result = array();

		if ($testId) {

			$query = 'SELECT * FROM ' . $this->_tableSigns . ' WHERE test_id=' . $testId;
			$result = $this->_db->get_results($query);

		}
		return $result;

	}

	public function update($id) {

		$id = (int)$id;
		$result = false;

		if ($id) {

			$result = $this->_db->update(
				$this->_tableSigns,
				array(                              // values
					'name' => $this->_name,
					'code' => $this->_code
				),
				array('id' => $id),				// where condition
				array('%s', '%s'),				// value types
				array('%d')						// condition type
			);

			if ($result === 0)
				$result = true;
		}
		return $result;
	}

	public function save() {

		$result = $this->_db->insert(
		$this->_tableSigns,
			array(
				'test_id' => $this->_test_id,
				'name' => $this->_name,
				'code' => $this->_code,
				'group_id' => $this->_group_id,
				'type' => $this->_type
			)
		);

		if ($result) {
			$this->_id = $this->_db->insert_id;
		}

		return $result;
	}

	public function delete() {

		$result = false;
		$id = (int)$this->_id;

		if($id) {
			$result = $this->_db->delete(
				$this->_tableSigns,
				array('id' => $id),
				array('%d')
			);
		}
		return $result;
	}



}