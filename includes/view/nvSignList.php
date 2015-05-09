<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvSignList extends NV_View {
	
    public $test;
    public $groupsTPE;
    public $groupsFunc;

    function show() {
?>
<div class="wrap">
    <?php $this->tabs($this->test, $this::TAB_SIGN); ?>
    <div id="poststuff">
        <h3 class="hndle">ТПЭ</h3>
        <table class="wp-list-table widefat" id="">
            <thead>
                <tr>
                    <th scope="col">Признаки</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody id="the-list">
            <?php if ($this->groupsTPE) { ?>
                <?php foreach($this->groupsTPE as $group) { ?>
                <tr>
                    <td>
                        <?=$group->firstPart->getName();?> (<b><?=$group->firstPart->getCode()?></b> ) -
                        <?=$group->secondPart->getName();?> (<b> <?=$group->secondPart->getCode()?></b> )
                    </td>
                    <td>
                        <?=$this->link(array(
                                'module' => 'nvSign',
                                'action' => 'edit',
                                'test_id' => $this->test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                            ),
                            $this->imgEdit(),
                            "Редактировать"
                        );?>
                        <?=$this->link(array(
                                'module' => 'nvSign',
                                'action' => 'delete',
                                'test_id' => $this->test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                             ),
                            $this->imgDelete(),
                            "Удалить"
                        );?>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6">Признаков пока нет</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <p></p>
        <?php echo $this->button(
            array(
                'module' => 'nvSign',
                'action' => 'edit',
                'test_id' => $this->test->getId(),
                'type' => Model_nvSign::TYPE_TPE
            ),
            "Добавить",
            "button-secondary");
        ?>

        <p></p>
        <p></p>
        <!-- <div class="postbox"> -->
            <h3 class="hndle">Функциональные</h3>
        <!-- </div> -->
        <table class="wp-list-table widefat" id="">
            <thead>
                <tr>
                    <th scope="col">Признаки</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody id="the-list">
            <?php if ($this->groupsFunc) { ?>
                <?php foreach($this->groupsFunc as $group) { ?>
                    <tr>
                        <td>
                            <?=$group->firstPart->getName();?> (<b><?=$group->firstPart->getCode()?></b> ) -
                            <?=$group->secondPart->getName();?> (<b> <?=$group->secondPart->getCode()?></b> )
                        </td>
                        <td>
                            <?=$this->link(array(
                                'module' => 'nvSign',
                                'action' => 'edit',
                                'test_id' => $this->test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                            ),
                                $this->imgEdit(),
                                "Редактировать"
                            );?>
                            <?=$this->link(array(
                                'module' => 'nvSign',
                                'action' => 'delete',
                                'test_id' => $this->test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                            ),
                                $this->imgDelete(),
                                "Удалить"
                            );?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6">Признаков пока нет</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <p></p>
        <?php echo $this->button(
            array(
                'module' => 'nvSign',
                'action' => 'edit',
                'test_id' => $this->test->getId(),
                'type' => Model_nvSign::TYPE_FUNCTIONAL
            ),
            "Добавить",
            "button-secondary");
        ?>
    </div>
</div>
    <?php
    }
}
?>