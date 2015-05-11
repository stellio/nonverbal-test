<div class="wrap">
    <a href="admin.php?page=NV&module=nvSign&test_id=<?=$test->getId();?>" class="button-secondary ajax-call">Вернуться</a>
    <form method="post" action="admin.php?page=NV&module=nvSign&action=save" class="ajax-call">
        <input type="hidden" value="<?=$test->getId();?>" name="test_id"/>
        <input type="hidden" value="<?=$signsGroup->getId();?>" name="id"/>
        <input type="hidden" value="<?=$signsGroup->getType();?>" name="type"/>
        <div id="poststuff">
            <div class="postbox">
                <h3 class="hndle">Новая группа признаков</h3>
                <div class="inside">
                    Введите имена признаков и коды (сокращенное имя признака). Для кода используйте латинские символы (S, WR, MT, DNE).<br>
                    Например: Динамика (DN) - Статика (ST)
                    <p></p>
                    <input type="text" value="<?=$signsGroup->firstPart->getName();?>" name="signs[1][name]" placeholder="имя признака"/>
                    (<input type="text" value="<?=$signsGroup->firstPart->getCode();?>" name="signs[1][code]" placeholder="код" id="treetest-sign-value" />)
                    <input type="text" value="<?=$signsGroup->secondPart->getName();?>" name="signs[2][name]" placeholder="имя признака"/>
                    (<input type="text" value="<?=$signsGroup->secondPart->getCode();?>" name="signs[2][code]" placeholder="код" id="treetest-sign-value"/>)
                </div>
            </div>
        </div>
        <input type="submit" class="button-primary" id="treetest-sign-save" value="Сохранить">
    </form>
</div>
