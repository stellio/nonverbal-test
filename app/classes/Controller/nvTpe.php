<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Controller_nvTpe extends nvController {

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
        $test = new Model_nvTest();
        $tpe = new Model_nvTpe();
        $this->view = new View_nvTpeAdd();

        $id = $this->req('id');
        $testId = $this->req('test_id');

        if ($testId) {
            $test->loadById($testId);
            // if set id load tpe
            if ($id) {
                $tpe->loadById($id);
            }
        }

        $this->view->test = $test;
        $this->view->tpe = $tpe;
        $this->view->show();
    }

    /**
     * Save
     */
    public function action_save() {
        $id = $this->req("id");
        $testId = $this->req("test_id");
        $tpe = new Model_nvTpe();

        if ($testId) {
            $tpe->setTestId($testId);
            // update
            if ($id) {
                $tpe->loadById($id);
                $tpe->setName($this->req('tpeName'));
                $tpe->setCode($this->cleanUpStr($this->req('tpeCode')));
                $tpe->setSequenceOfSign($this->cleanUpStr($this->req('tpeSequence')));

                if ($tpe->update($id))
                    NV_View::admin_notices('Запись успешно обновлена', 'info');
                else
                    NV_View::admin_notices('Не удалось обновить запись');
                // save, as new
            } else {
                $tpe->setName($this->req("tpeName"));
                $tpe->setCode($this->cleanUpStr($this->req('tpeCode')));
                $tpe->setSequenceOfSign($this->cleanUpStr($this->req('tpeSequence')));

                if ($tpe->save())
                    NV_View::admin_notices('Запись успешно добавлена', 'info');
                else
                    NV_View::admin_notices('Не удалось создать запись');
            }
        }

        $this->action_index();
    }

    public function action_delete() {
        $tpe = new Model_nvTpe();

        $id = $this->req('id');
        $testId = $this->req('test_id');

        if ($testId) {
            if ($id) {
                if ($tpe->delete($id))
                    NV_View::admin_notices('Запись успешно удалены', 'info');
                else
                    NV_View::admin_notices('Не удалось удалить запись');
            }
        }
        $this->action_index();
    }
}
?>