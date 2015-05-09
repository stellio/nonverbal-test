<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Controller_nvProfile extends NV_Controller {
	
	public $view = 0;

	function __construct() {
		parent::__construct();
	}

	/**
	 * Show exist relations
	 */
	public function action_index() {
		$profilesTPE = array();
		$profilesFunc = array();

		$test = new Model_nvTest();
		$profiles = new Model_nvProfile();
		$this->view = new View_nvProfilesList();

		$testId = $this->req('test_id');
		if ($testId) {
			$test->loadById($testId);

			// load TPE Profiles
			foreach ($profiles->loadByTestAndTypeId($testId, Model_nvProfile::TYPE_TPE) as $profile) {
				$profilesTPE[] = $profile;
			}
			// load Func. Profiles
			foreach ($profiles->loadByTestAndTypeId($testId, Model_nvProfile::TYPE_FUNCTIONAL) as $profile) {
				$profilesFunc[] = $profile;

			}
		}

		$this->view->test = $test;
		$this->view->profilesTPE = $profilesTPE;
		$this->view->profilesFunc = $profilesFunc;
		$this->view->show();
	}

	/**
	 * Show form to edit relations
	 */
	public function action_edit() {
		$test = new Model_nvTest();
		$profile = new Model_nvProfile();
		$this->view = new View_nvProfileAdd();

		$id = $this->req('id');
		$type = $this->req('type');
		$testId = $this->req('test_id');

		if ($testId) {
			$test->loadById($testId);
			$profile->setType($type);
			// load profile
			if ($id) {
				$profile->loadById($id);
			}
		}

		$this->view->test = $test;
		$this->view->profile = $profile;

		$this->view->show();
	}

	/**
	 * Save profiles
	 */
	public function action_save() {
		$id = $this->req("id");
		$type = $this->req("type");
		$testId = $this->req("test_id");
		$profile = new Model_nvProfile();

		if ($testId) {
			$profile->setTestId($testId);
			// update
			if ($id) {
				$profile->loadById($id);
				$profile->setName($this->req('profileName'));
				$profile->setCode($this->cleanUpStr($this->req('profileCode')));
				$profile->setSequenceOfSign($this->cleanUpStr($this->req('profileSequence')));

				if ($profile->update($id))
					NV_View::admin_notices('Профиль успешно обновлен', 'info');
				else
					NV_View::admin_notices('Не удалось обновить профиль');
			// save, as new
			} else {
				$profile->setType($type);
				$profile->setName($this->req("profileName"));
				$profile->setCode($this->cleanUpStr($this->req('profileCode')));
				$profile->setSequenceOfSign($this->cleanUpStr($this->req('profileSequence')));

				if ($profile->save())
					NV_View::admin_notices('Профиль успешно добавлен', 'info');
				else
					NV_View::admin_notices('Не удалось создать профиль');
			}
 		}

		$this->action_index();
	}

	public function action_delete() {
		$signsGroup = new Model_nvProfile();

		$id = $this->req('id');
		$testId = $this->req('test_id');

		if ($testId) {
			if ($id) {
				if ($signsGroup->delete($id))
					NV_View::admin_notices('Профиль успешно удалены', 'info');
				else
					NV_View::admin_notices('Не удалось удалить профиль');
			}
		}
		$this->action_index();
	}
}
?>