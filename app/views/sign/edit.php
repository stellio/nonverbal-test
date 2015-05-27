<div>
    <a href="admin.php?page=NV&module=nvSign&test_id=<?=$test->getId();?>" class="btn btn-default btn-sm ajax-call">Вернуться</a>
    </p>
    <form method="get" action="admin.php?page=NV&module=nvSign&call=save" class="ajax-call">
        <input type="hidden" value="<?=$test->getId();?>" name="test_id"/>
        <input type="hidden" value="<?=$signsGroup->getId();?>" name="id"/>
        <input type="hidden" value="<?=$signsGroup->getType();?>" name="type"/>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Новая группа признаков</h3>
            </div>
            <div class="panel-body">

                Введите имена признаков и коды (сокращенное имя признака). Для кода используйте латинские символы (S, WR, MT, DNE).<br>
                Например: Динамика (DN) - Статика (ST)
                <p></p>

                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" value="<?=$signsGroup->firstPart->getName();?>" name="signs[1][name]" placeholder="имя признака"/>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" value="<?=$signsGroup->firstPart->getCode();?>" name="signs[1][code]" placeholder="код" id="" />
                    </div>
                    <div class="col-md-1 text-center" style="padding-top: 10px">
                       <span class="fui-plus"></span> 
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" value="<?=$signsGroup->secondPart->getName();?>" name="signs[2][name]" placeholder="имя признака"/>  
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" value="<?=$signsGroup->secondPart->getCode();?>" name="signs[2][code]" placeholder="код" id=""/>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-info btn-sm" id="treetest-sign-save" value="Сохранить">
    </form>
</div>
