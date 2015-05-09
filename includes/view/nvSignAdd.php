<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvSignAdd extends NV_View {
	
    public $test;
    public $signsGroup;

    function show() {

?>
<div class="wrap">
    <?php $this->tabs($this->test, $this::TAB_SIGN); ?>
    <p></p>
    <a href="admin.php?page=nvTest&module=nvSign&test_id=<?=$this->test->getId();?>" class="button-secondary">Вернуться</a>
    <form method="post" action="admin.php?page=nvTest&module=nvSign&action=save">
        <input type="hidden" value="<?=$this->test->getId();?>" name="test_id"/>
        <input type="hidden" value="<?=$this->signsGroup->getId();?>" name="id"/>
        <input type="hidden" value="<?=$this->signsGroup->getType();?>" name="type"/>
        <div id="poststuff">
            <div class="postbox">
                <h3 class="hndle">Новая группа признаков</h3>
                <div class="inside">
                    Введите имена признаков и коды (сокращенное имя признака). Для кода используйте латинские символы (S, WR, MT, DNE).<br>
                    Например: Динамика (DN) - Статика (ST)
                    <p></p>
                    <input type="text" value="<?=$this->signsGroup->firstPart->getName();?>" name="signs[1][name]" placeholder="имя признака"/>
                    (<input type="text" value="<?=$this->signsGroup->firstPart->getCode();?>" name="signs[1][code]" placeholder="код" id="treetest-sign-value" />)
                    <input type="text" value="<?=$this->signsGroup->secondPart->getName();?>" name="signs[2][name]" placeholder="имя признака"/>
                    (<input type="text" value="<?=$this->signsGroup->secondPart->getCode();?>" name="signs[2][code]" placeholder="код" id="treetest-sign-value"/>)
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