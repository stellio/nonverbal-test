<div class="wrap">
    <p></p>
    <a href="admin.php?page=NV&module=nvProfile&test_id=<?=$test->getId();?>" class="btn btn-default btn-sm ajax-call">Вернуться</a>
    </p>
    <form method="post" action="admin.php?page=NV&module=nvProfile&call=save" class="ajax-call">
        <input type="hidden" value="<?=$test->getId();?>" name="test_id"/>
        <input type="hidden" value="<?=$profile->getId();?>" name="id"/>
        <input type="hidden" value="<?=$profile->getType();?>" name="type"/>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Новый профиль</h3>
            </div>
            <div class="panel-body">
                Введите имя профиля, его код (сокращенное имя) и соответствующую последовательность его признаков-кодов или ТПЭ разделенных запятыми.<br>
                Например: Экстравертный (PEK) = TEG, TID<br>
                Например: Экстравертная логика (FEL ) = PEG, PID, LG<br>
                <p></p>

                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" value="<?=$profile->getName();?>" name="profileName" placeholder="имя профиля" />        
                    </div>
                    <div class="col-md-1">
                        <input type="text" class="form-control" value="<?=$profile->getCode();?>" name="profileCode" placeholder="код" />
                    </div>
                    <div class="col-md-8">
                        <select name="profileSequence[]" multiple="multiple" class="form-control multiselect multiselect-info">
                            <?=nvHtml::options($signs, $selected);?>
                        </select>        
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary btn-sm" id="treetest-sign-save" value="Сохранить">
    </form>
</div>