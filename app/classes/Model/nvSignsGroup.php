<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Model_nvSignsGroup extends Core_Model {

	const TYPE_TPE = '1';
	const TYPE_FUNCTIONAL = '2';

	const PART_ONE = '1';
	const PART_TWO = '2';

	private $_id = 0;
	private $_test_id = 0;
	private $_short_name = '';
	private $_sign_ids = '';
	private $_type = 0;

	// group parts
	public $firstPart = 0;
	public $secondPart = 0;
	public $groups = array();

	public function __construct() {
		parent::__construct();

		$this->firstPart = new Model_nvSign();
		$this->secondPart = new Model_nvSign();
	}

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

	public function setShortName($name) {
		$this->_short_name = (string)$name;
	}
	
	public function getShortName() {
		return $this->_short_name;
	}

	public function  setSignIds($ids) {
		$this->_sign_ids = (string)$ids;
	}

	public function getSignIds() {
		return $this->_sign_ids;
	}

	public function setType($type) {
		$this->_type = (int)$type;
	}

	public function getType() {
		return $this->_type;
	}

	private function saveSigns() {

		$this->firstPart->setTestId($this->_test_id);
		$this->secondPart->setTestId($this->_test_id);

		$this->firstPart->save();
		$this->secondPart->save();
	}

	private function updateSigns() {

		if ($this->firstPart->update($this->firstPart->getId()) and	$this->secondPart->update($this->secondPart->getId()))
			return true;
		else
			return false;
	}

	private function deleteSigns() {

		if ($this->firstPart->delete() and $this->secondPart->delete())
			return true;
		else
			return false;
	}

	public function getGroupsId($testId, $type) {

		$result = false;

		if ($testId and $type) {

			$query = 'SELECT * FROM ' . $this->_tableSignsGroups . ' WHERE test_id=' . $testId . ' AND type=' . $type;
			$objs = $this->_db->get_results($query);

			if ($objs) {
				$list = array();

				foreach ($objs as $obj) {
					$list[] = $obj->id;
				}

				$result = $list;
			}
		}
		return $result;
	}

	public function loadGroup($testId, $id) {

		$result = false;
		$signIds = array();

		if ($testId and $id) {

			$query = 'SELECT short_name, sign_ids, type FROM ' . $this->_tableSignsGroups . ' WHERE test_id=' . $testId . ' AND id=' . $id;
			$obj = $this->_db->get_row($query);

			if ($obj) {
				$this->_short_name = $obj->short_name;
				$this->_sign_ids = $obj->sign_ids;
				$this->_type = $obj->type;

				$signIds = split(',', $obj->sign_ids);
			}

			if ($this->firstPart->load($signIds[0]) and $this->secondPart->load($signIds[1])) {
				$result = true;
			}
		}
		return $result;
	}

	public function getGroupsByTestId($id) {

		$id = (int)$id;
		if ($id) {

			$query = 'SELECT * FROM ' . $this->_tableSignsGroups . ' WHERE test_id=' . $id;
			return $this->_db->get_results($query);

		} else {
			return false;
		}
	}

	public function update() {

		return $this->updateSigns();
	}

	public function save() {

		$this->saveSigns();

		$ids = array();

		$ids[] = $this->firstPart->getId();
		$ids[] = $this->secondPart->getId();

		$this->setSignIds(join(',', $ids));
		$this->setShortName($this->firstPart->getCode().":".$this->secondPart->getCode());

		$result = $this->_db->insert(
			$this->_tableSignsGroups,
			array(
				'test_id' => $this->_test_id,
				'short_name' => $this->_short_name,
				'sign_ids' => $this->_sign_ids,
				'type' => $this->_type
			)
		);

		if ($result) {
			$this->_id = $this->_db->insert_id;
		}

		return $result;
	}

	public function delete() {

		$signsResult = $this->deleteSigns();

		$result = false;
		$id = (int)$this->_id;

		if($id) {
			$result = $this->_db->delete(
				$this->_tableSignsGroups,
				array('id' => $id),
				array('%d')
			);

			if ($signsResult and $result)
				$result = true;
			else
				$result = false;
		}
		return $result;
	}

}