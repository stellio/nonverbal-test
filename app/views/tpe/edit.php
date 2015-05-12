<div class="wrap">
    <p></p>
    <a href="admin.php?page=NV&module=nvTpe&test_id=<?=$test->getId();?>" class="button-secondary ajax-call">Вернуться</a>
    <form method="post" action="admin.php?page=NV&module=nvTpe&call=save" class="ajax-call">
        <input type="hidden" value="<?=$test->getId();?>" name="test_id"/>
        <input type="hidden" value="<?=$tpe->getId();?>" name="id"/>
        <div id="poststuff">
            <div class="postbox">
                <h3 class="hndle">Квадра</h3>
                <div class="inside">
                    Введите имя квадры, ее код (сокращенное имя) и соответствующую последовательность ее признаков-кодов, разделенных запятыми.<br>
                    Например: Суперид (PSID) = IR, IV, DN<br>
                    Для кодов используйте латинские символы (S, WR, MT, DNE).
                    <p></p>
                    <input type="text" value="<?=$tpe->getName();?>" name="tpeName" placeholder="имя квадры" class="regular-text" />
                    (<input type="text" value="<?=$tpe->getCode();?>" name="tpeCode" placeholder="код" id="treetest-tpe-value" />) =
                    <input type="text" value="<?=$tpe->getSequenceOfSign();?>" name="tpeSequence" placeholder="последовательность признаков" class="regular-text" />
                </div>
            </div>
        </div>
        <input type="submit" class="button-primary" id="treetest-sign-save" value="Сохранить">
    </form>
</div>