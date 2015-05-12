<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Controller_nvSign extends Controller_ContentTemplate {
	
	public $view = 0;

	function __construct() {
		parent::__construct();
	}

	public function action_index() {
		$groupsTPE = array();
		$groupsFunc = array();

		$test = nvModel::factory('nvTest');
		$view = nvView::factory('sign/list');
		$singsGroups = nvModel::factory('nvSignsGroup');

		$testId = $this->req('test_id');
		if ($testId) {
			$test->loadById($testId);

			// load TPE Signs
			$ids = $singsGroups->getGroupsId($testId, nvModel::TYPE_TPE);
			if ($ids) {
				foreach ($ids as $id) {
					$group = nvModel::factory('nvSignsGroup');
					$group->setId($id);
					$group->setType(nvModel::TYPE_TPE);
					$group->loadGroup($testId, $id);
					$groupsTPE[] = $group;
				}
 			}
			// load Func. Signs
			$ids = $singsGroups->getGroupsId($testId, nvModel::TYPE_FUNCTIONAL);
			if ($ids) {
				foreach ($ids as $id) {
					$group = nvModel::factory('nvSignsGroup');
					$group->setId($id);
					$group->setType(nvModel::TYPE_FUNCTIONAL);
					$group->loadGroup($testId, $id);
					$groupsFunc[] = $group;
				}
			}
		}

		$this->template->content = $view->bind('test', $test)
										->bind('groupsTPE', $groupsTPE)
										->bind('groupsFunc', $groupsFunc);

	}


	public function action_edit() {

		$signsGroup = nvModel::factory('nvSignsGroup');
		$test = nvModel::factory('nvTest');
		$view = nvView::factory('sign/edit');

		$id = $this->req('id');
		$type = $this->req('type');
		$testId = $this->req('test_id');

		if ($testId) {
			$test->loadById($testId);
			$signsGroup->setType($type);

			if ($id) {
				$signsGroup->setId($id);
				$signsGroup->loadGroup($testId, $id);

			}
		}

		$this->template->content = $view->bind('test', $test)
										->bind('signsGroup', $signsGroup);
	}

	public function action_save() {

		$sign = nvModel::factory('nvSign');
		$signsGroup = nvModel::factory('nvSignsGroup');

		$testId = $this->req('test_id');
		$groupId = $this->req('id');
		$type = $this->req('type');

		if ($testId) {

			$signsGroup->setTestId($testId);

			// if (!$type) exit;

			$signsGroup->setType($type);
			// update signs 
			// 
			// if $groupId != 0
			if ($groupId) {

				$signsGroup->setId($groupId);
				$signsGroup->loadGroup($testId, $groupId);
				// check is set signs
				if ($this->req('signs')) {
					foreach ($this->req('signs') as $part => $sign) {
						// if part one
						if ($part == Model_nvSignsGroup::PART_ONE) {

							$signsGroup->firstPart->setName($sign['name']);
							$signsGroup->firstPart->setCode($this->cleanUpStr($sign['code']));
//							$signsGroup->firstPart->setType(Model_Sign::TYPE_TPE);
						} // if part two
						elseif ($part == Model_nvSignsGroup::PART_TWO) {

							$signsGroup->secondPart->setName($sign['name']);
							$signsGroup->secondPart->setCode($this->cleanUpStr($sign['code']));
//							$signsGroup->secondPart->setType(Model_Sign::TYPE_TPE);
						}
					}
					if ($signsGroup->update())
						nvHtml::admin_notices('Признаки успешно обновлены', 'info');
					else
						nvHtml::admin_notices('Не удалось обновить признаки');
				}
			// save as new
			} else {
			
				// check is set signs
				if ($this->req('signs')) {

					foreach ($this->req('signs') as $part => $sign) {
						
						// if part one 
						if ($part == Model_nvSignsGroup::PART_ONE) {

							$signsGroup->firstPart->setName($sign['name']);
							$signsGroup->firstPart->setCode($this->cleanUpStr($sign['code']));
							$signsGroup->firstPart->setType($signsGroup->getType());
						} 
						// if part two
						elseif ($part == Model_nvSignsGroup::PART_TWO) {

							$signsGroup->secondPart->setName($sign['name']);
							$signsGroup->secondPart->setCode($this->cleanUpStr($sign['code']));
							$signsGroup->secondPart->setType($signsGroup->getType());
						}
					}

					if ($signsGroup->save())
						nvHtml::admin_notices('Признаки успешно добавлены', 'info');
					else
						nvHtml::admin_notices('Не удалось создать признаки');
				}
			}
		}

		$this->action_index();
	}

	public function  action_delete(){

		$signsGroup = nvModel::factory('nvSignsGroup');
		$test = nvModel::factory('nvTest');

		$testId = $this->req('test_id');
		$id = $this->req('id');

		if ($testId) {
			$test->loadById($testId);

			if ($id) {
				$signsGroup->setId($id);
				$signsGroup->loadGroup($testId, $id);

				if ($signsGroup->delete())
					nvHtml::admin_notices('Признаки успешно удалены', 'info');
				else
					nvHtml::admin_notices('Не удалось удалить признаки');
			}
		}
		$this->action_index();
	}
}
?>