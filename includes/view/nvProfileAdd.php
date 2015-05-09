<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvProfileAdd extends NV_View {

    public $test;
    public $profile;

    function show() {

        ?>
        <div class="wrap">
            <?php $this->tabs($this->test, $this::TAB_PROFILES); ?>
            <p></p>
            <a href="admin.php?page=nvTest&module=nvProfile&test_id=<?=$this->test->getId();?>" class="button-secondary">Вернуться</a>
            <form method="post" action="admin.php?page=nvTest&module=nvProfile&action=save">
                <input type="hidden" value="<?=$this->test->getId();?>" name="test_id"/>
                <input type="hidden" value="<?=$this->profile->getId();?>" name="id"/>
                <input type="hidden" value="<?=$this->profile->getType();?>" name="type"/>
                <div id="poststuff">
                    <div class="postbox">
                        <h3 class="hndle">Новый профиль</h3>
                        <div class="inside">
                            Введите имя профиля, его код (сокращенное имя) и соответствующую последовательность его признаков-кодов или ТПЭ разделенных запятыми.<br>
                            Например: Экстравертный (PEK) = TEG, TID<br>
                            Например: Экстравертная логика (FEL ) = PEG, PID, LG<br>
                            Для кодов используйте латинские символы (S, WR, MT, DNE).
                            <p></p>
                            <input type="text" value="<?=$this->profile->getName();?>" name="profileName" placeholder="имя профиля" class="regular-text" />
                            (<input type="text" value="<?=$this->profile->getCode();?>" name="profileCode" placeholder="код" id="treetest-profile-value" />) =
                            <input type="text" value="<?=$this->profile->getSequenceOfSign();?>" name="profileSequence" placeholder="последовательность признаков" class="regular-text" />
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