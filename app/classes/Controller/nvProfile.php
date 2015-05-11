<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Controller_nvProfile extends Controller_ContentTemplate {
	
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

		$test = nvModel::factory('nvTest');
		$profiles = nvModel::factory('nvProfile');
		$view = nvView::factory('profile/list');

		$testId = $this->req('test_id');
		if ($testId) {
			$test->loadById($testId);

			// load TPE Profiles
			foreach ($profiles->loadByTestAndTypeId($testId, nvModel::TYPE_TPE) as $profile) {
				$profilesTPE[] = $profile;
			}
			// load Func. Profiles
			foreach ($profiles->loadByTestAndTypeId($testId, nvModel::TYPE_FUNCTIONAL) as $profile) {
				$profilesFunc[] = $profile;

			}
		}

		$this->template->content = $view
									->bind('test', $test)
									->bind('profilesTPE', $profilesTPE)
									->bind('profilesFunc', $profilesFunc);
	}

	/**
	 * Show form to edit relations
	 */
	public function action_edit() {
		$test = nvModel::factory('nvTest');
		$profile = nvModel::factory('nvProfile');
		$view = nvView::factory('profile/edit');

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

		$this->template->content = $view->bind('test', $test)->bind('profile', $profile);
	}

	/**
	 * Save profiles
	 */
	public function action_save() {
		$id = $this->req("id");
		$type = $this->req("type");
		$testId = $this->req("test_id");
		$profile = nvModel::factory('nvProfile');

		if ($testId) {
			$profile->setTestId($testId);
			// update
			if ($id) {
				$profile->loadById($id);
				$profile->setName($this->req('profileName'));
				$profile->setCode($this->cleanUpStr($this->req('profileCode')));
				$profile->setSequenceOfSign($this->cleanUpStr($this->req('profileSequence')));

				if ($profile->update($id))
					nvHtml::admin_notices('Профиль успешно обновлен', 'info');
				else
					nvHtml::admin_notices('Не удалось обновить профиль');
			// save, as new
			} else {
				$profile->setType($type);
				$profile->setName($this->req("profileName"));
				$profile->setCode($this->cleanUpStr($this->req('profileCode')));
				$profile->setSequenceOfSign($this->cleanUpStr($this->req('profileSequence')));

				if ($profile->save())
					nvHtml::admin_notices('Профиль успешно добавлен', 'info');
				else
					nvHtml::admin_notices('Не удалось создать профиль');
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
					nvHtml::admin_notices('Профиль успешно удален', 'info');
				else
					nvHtml::admin_notices('Не удалось удалить профиль');
			}
		}
		$this->action_index();
	}
}
?>