<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Model_nvRelation extends Core_Model
{

	private $_id = 0;
	private $_test_id = 0;

	private $_code = '';
	private $_type = 0;
	private $_parent_id = 0;
	
	public function setId($id)
	{
		$this->_id = (int)$id;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function setTestId($id)
	{
		$this->_test_id = (int)$id;
	}

	public function getTestId()
	{
		return $this->_test_id;
	}


	public function setCode($code)
	{
		$this->_code = (string)$code;
	}

	public function getCode()
	{
		return $this->_code;
	}

	public function setType($type)
	{
		$this->_type = (string)$type;
	}

	public function getType()
	{
		return $this->_type;
	}

	public function setParentId($id)
	{
		$this->_parent_id = (int)$id;
	}

	public function getParentCode()
	{
		return $this->_parent_id;
	}

	public function getByTestId($id) {

		$id = (int)$id;
		$result = false;

		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableRelations . ' WHERE test_id=' . $id;

			$result = $this->_db->get_results($query);
		}
		return $result;
	}

	public function getRoots($test_id) {

		$id = (int)$test_id;
		$result = false;

		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableRelations . ' WHERE test_id=' . $id . ' AND parent_id = 0';

			$result = $this->_db->get_results($query);
		}
		return $result;
	}


	public function loadById($id)
	{

		$id = (int)$id;
		
		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableRelations . ' WHERE id=' . $id;

			$obj = $this->_db->get_row($query);

			$this->_id = $obj->id;
			$this->_test_id = $obj->test_id;
			$this->_code = $obj->code;
			$this->_type = $obj->type;
			$this->_parent_id = $obj->parent_id;

			return $this;
		} else {
			return false;
		}
	}

	public function update($id)
	{

		$id = (int)$id;
		$result = false;

		if ($id) {

			$result = $this->_db->update(
				$this->_tableRelations,
				array(                              // values
					'test_id' => $this->_test_id,
					'code' => $this->_code,
					'type' => $this->_type,
					'parent_id' => $this->_parent_id
				),
				array('id' => $id),                // conditions
				array('%d', '%s', '%d', '%d'),
				array('%d')
			);

			if ($result === 0)
				$result = true;
		}
		return $result;
	}


	public function save()
	{

		$result = $this->_db->insert(
			$this->_tableRelations,
			array(
				'test_id' => $this->_test_id,
				'code' => $this->_code,
				'type' => $this->_type,
				'parent_id' => $this->_parent_id
			)
		);

		if ($result) {
			$this->_id = $this->_db->insert_id;
		}

		return $result;
	}

	public function delete($id)
	{

		$result = false;
		$id = (int)$id;

		if ($id) {
			$result = $this->_db->delete(
				$this->_tableRelations,
				array('id' => $id),
				array('%d')
			);
		}
		return $result;
	}
}
?>