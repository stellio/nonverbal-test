<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvTpeAdd extends NV_View {

    public $test;
    public $tpe;

    function show() {

        ?>
        <div class="wrap">
            <?php $this->tabs($this->test, $this::TAB_TPE); ?>
            <p></p>
            <a href="admin.php?page=nvTest&module=nvTpe&test_id=<?=$this->test->getId();?>" class="button-secondary">Вернуться</a>
            <form method="post" action="admin.php?page=nvTest&module=nvTpe&action=save">
                <input type="hidden" value="<?=$this->test->getId();?>" name="test_id"/>
                <input type="hidden" value="<?=$this->tpe->getId();?>" name="id"/>
                <div id="poststuff">
                    <div class="postbox">
                        <h3 class="hndle">Квадра</h3>
                        <div class="inside">
                            Введите имя квадры, ее код (сокращенное имя) и соответствующую последовательность ее признаков-кодов, разделенных запятыми.<br>
                            Например: Суперид (PSID) = IR, IV, DN<br>
                            Для кодов используйте латинские символы (S, WR, MT, DNE).
                            <p></p>
                            <input type="text" value="<?=$this->tpe->getName();?>" name="tpeName" placeholder="имя квадры" class="regular-text" />
                            (<input type="text" value="<?=$this->tpe->getCode();?>" name="tpeCode" placeholder="код" id="treetest-tpe-value" />) =
                            <input type="text" value="<?=$this->tpe->getSequenceOfSign();?>" name="tpeSequence" placeholder="последовательность признаков" class="regular-text" />
                        </div>
                    </div>
                </div>
                <input type="submit" class="button-primary" id="treetest-sign-save" value="Сохранить">
            </form>
        </div>
    <?php
    }
}
?>