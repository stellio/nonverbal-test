<div class="wrap">
    <p></p>
    <a href="admin.php?page=NV&module=nvProfile&test_id=<?=$test->getId();?>" class="button-secondary ajax-call">Вернуться</a>
    <form method="post" action="admin.php?page=NV&module=nvProfile&call=save" class="ajax-call">
        <input type="hidden" value="<?=$test->getId();?>" name="test_id"/>
        <input type="hidden" value="<?=$profile->getId();?>" name="id"/>
        <input type="hidden" value="<?=$profile->getType();?>" name="type"/>
        <div id="poststuff">
            <div class="postbox">
                <h3 class="hndle">Новый профиль</h3>
                <div class="inside">
                    Введите имя профиля, его код (сокращенное имя) и соответствующую последовательность его признаков-кодов или ТПЭ разделенных запятыми.<br>
                    Например: Экстравертный (PEK) = TEG, TID<br>
                    Например: Экстравертная логика (FEL ) = PEG, PID, LG<br>
                    Для кодов используйте латинские символы (S, WR, MT, DNE).
                    <p></p>
                    <input type="text" value="<?=$profile->getName();?>" name="profileName" placeholder="имя профиля" class="regular-text" />
                    (<input type="text" value="<?=$profile->getCode();?>" name="profileCode" placeholder="код" id="treetest-profile-value" />) =
                    <!-- <input type="text" value="<?//$profile->getSequenceOfSign();?>" name="profileSequence" placeholder="последовательность признаков" class="regular-text" /> -->
                    </p>
                    Последовательности признаков:
                    </p>
                    <select name="profileSequence[]" multiple="multiple" class="form-control multiselect multiselect-info">
                        <?=nvHtml::options($signs, $selected);?>
                    </select>
                </div>
            </div>

          
        </div>
        <input type="submit" class="button-primary" id="treetest-sign-save" value="Сохранить">
    </form>
</div>