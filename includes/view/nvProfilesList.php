<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvProfilesList extends NV_View {
	
    public $test;
    public $profilesTPE;
    public $profilesFunc;

    function show() {

?>
<div class="wrap">
    <?php $this->tabs($this->test, $this::TAB_PROFILES); ?>
    <div id="poststuff">
        <h3 class="hndle">ТПЭ</h3>
        <table class="wp-list-table widefat" id="">
            <thead>
            <tr>
                <th scope="col">Профили</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody id="the-list">
            <?php if ($this->profilesTPE) { ?>
                <?php foreach($this->profilesTPE as $profile) { ?>
                    <tr>
                        <td>
                            <?=$profile->name;?>
                            (<b><?=$profile->code?></b> ) =
                            <?=$profile->sequence_of_sign?>
                        </td>
                        <td>
                            <?=$this->link(array(
                                'module' => 'nvProfile',
                                'action' => 'edit',
                                'test_id' => $this->test->getId(),
                                'id' => $profile->id,
                                'type' => $profile->type
                            ),
                                $this->imgEdit(),
                                "Редактировать"
                            );?>
                            <?=$this->link(array(
                                'module' => 'nvProfile',
                                'action' => 'delete',
                                'test_id' => $this->test->getId(),
                                'id' => $profile->id,
                                'type' => $profile->type
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
                'module' => 'nvProfile',
                'action' => 'edit',
                'test_id' => $this->test->getId(),
                'type' => Model_nvProfile::TYPE_TPE
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
                <th scope="col">Профили</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody id="the-list">
            <?php if ($this->profilesFunc) { ?>
                <?php foreach($this->profilesFunc as $profile) { ?>
                    <tr>
                        <td>
                            <?=$profile->name;?>
                            (<b><?=$profile->code?></b> ) =
                            <?=$profile->sequence_of_sign?>
                        </td>
                        <td>
                            <?=$this->link(array(
                                'module' => 'nvProfile',
                                'action' => 'edit',
                                'test_id' => $this->test->getId(),
                                'id' => $profile->id,
                                'type' => $profile->type
                            ),
                                $this->imgEdit(),
                                "Редактировать"
                            );?>
                            <?=$this->link(array(
                                'module' => 'nvProfile',
                                'action' => 'delete',
                                'test_id' => $this->test->getId(),
                                'id' => $profile->id,
                                'type' => $profile->type
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
                'module' => 'nvProfile',
                'action' => 'edit',
                'test_id' => $this->test->getId(),
                'type' => Model_nvProfile::TYPE_FUNCTIONAL
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