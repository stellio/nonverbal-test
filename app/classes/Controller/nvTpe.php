<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Controller_nvTpe extends Controller_ContentTemplate {

    public $view = 0;

    function __construct() {
        parent::__construct();
    }

    /**
     * Show exist relations
     */
    public function action_index() {
        $tpeList = array();

        $test = nvModel::factory('nvTest');
        $tpe =  nvModel::factory('nvTpe');
        $view = nvView::factory('tpe/list');

        $testId = $this->req('test_id');
        if ($testId) {
            $test->loadById($testId);

            // load TPE
            foreach ($tpe->loadByTest($testId) as $item) {
                $tpeList[] = $item;
            }
        }

        $this->template->content = $view->bind('test', $test)->bind('tpeList', $tpeList);
        
    }

    /**
     * Show form to edit relations
     */
    public function action_edit() {
        $test = nvModel::factory('nvTest');
        $tpe = nvModel::factory('nvTpe');
        $view = nvView::factory('tpe/edit');

        $id = $this->req('id');
        $testId = $this->req('test_id');

        if ($testId) {
            $test->loadById($testId);
            // if set id load tpe
            if ($id) {
                $tpe->loadById($id);
            }
        }

        $this->template->content = $view->bind('test', $test)->bind('tpe', $tpe);
    }

    /**
     * Save
     */
    public function action_save() {
        $id = $this->req("id");
        $testId = $this->req("test_id");
        $tpe = nvModel::factory('nvTpe');

        if ($testId) {
            $tpe->setTestId($testId);
            // update
            if ($id) {
                $tpe->loadById($id);
                $tpe->setName($this->req('tpeName'));
                $tpe->setCode($this->cleanUpStr($this->req('tpeCode')));
                $tpe->setSequenceOfSign($this->cleanUpStr($this->req('tpeSequence')));

                if ($tpe->update($id))
                    nvHtml::admin_notices('Запись успешно обновлена', 'info');
                else
                    nvHtml::admin_notices('Не удалось обновить запись');
                // save, as new
            } else {
                $tpe->setName($this->req("tpeName"));
                $tpe->setCode($this->cleanUpStr($this->req('tpeCode')));
                $tpe->setSequenceOfSign($this->cleanUpStr($this->req('tpeSequence')));

                if ($tpe->save())
                    nvHtml::admin_notices('Запись успешно добавлена', 'info');
                else
                    nvHtml::admin_notices('Не удалось создать запись');
            }
        }

        $this->action_index();
    }

    public function action_delete() {
        $tpe = nvModel::factory('nvTpe');

        $id = $this->req('id');
        $testId = $this->req('test_id');

        if ($testId) {
            if ($id) {
                if ($tpe->delete($id))
                    nvHtml::admin_notices('Запись успешно удалена', 'info');
                else
                    nvHtml::admin_notices('Не удалось удалить запись');
            }
        }
        $this->action_index();
    }
}
?>