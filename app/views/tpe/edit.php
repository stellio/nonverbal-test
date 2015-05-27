<div>
    <p></p>
    <a href="admin.php?page=NV&module=nvTpe&test_id=<?=$test->getId();?>" class="btn btn-default btn-sm ajax-call">Вернуться</a>
    </p>
    <form method="post" action="admin.php?page=NV&module=nvTpe&call=save" class="ajax-call">
        <input type="hidden" value="<?=$test->getId();?>" name="test_id"/>
        <input type="hidden" value="<?=$tpe->getId();?>" name="id"/>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Квадра</h3>
            </div>
            <div class="panel-body">
                Введите имя квадры, ее код (сокращенное имя) и соответствующую последовательность ее признаков-кодов, разделенных запятыми.<br>
                Например: Суперид (PSID) = IR, IV, DN<br>
                Для кодов используйте латинские символы (S, WR, MT, DNE).
                <p></p>
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" value="<?=$tpe->getName();?>" name="tpeName" placeholder="имя квадры" />        
                    </div>
                    <div class="col-md-1">
                        <input type="text" class="form-control" value="<?=$tpe->getCode();?>" name="tpeCode" placeholder="код" />      
                    </div>
                    <div class="col-md-8">
                         <select name="tpeSequence[]" multiple="multiple" class="form-control multiselect multiselect-info">
                            <?=nvHtml::options($signs, $selected);?>
                        </select>

                        <!-- <input type="text" class="form-control" value="<?//=$tpe->getSequenceOfSign();?>" name="tpeSequence" placeholder="последовательность признаков" />         -->
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary btn-sm" id="treetest-sign-save" value="Сохранить">
    </form>
</div>