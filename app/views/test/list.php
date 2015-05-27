
<h5>Список тестов</h5>
<div class="wrap panel-group" id="accordion">
    <?php if (count($tests))  { ?>
        <?php foreach ($tests as $test) { ?>
             <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$test->id;?>">
                    <?=$test->name;?></a>
                  </h4>
                </div>
                <div id="collapse<?=$test->id;?>" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="admin.php?page=NV&module=nvTest&call=edit&id=<?=$test->id?>" class="btn btn-xs btn-primary">
                                            <span class="fui-new"></span>
                                            Редактировать
                                        </a>        
                                        <a href="admin.php?page=NV&module=nvStatistic&test_id=<?=$test->id;?>" class="btn btn-xs btn-info">
                                            <span class="fui-document"></span>
                                            Статистика
                                        </a>        
                                        <a href="admin.php?page=NV&call=delete&id=<?=$test->id?>" class="btn btn-xs btn-danger confirm">
                                            <span class="fui-trash"></span>
                                            Удалить
                                        </a>        
                                    </div>    
                                </div>
                                <div class="row">
                                    <br>
                                    <div class="col-md-12">
                                        <label><b>Shortcode</b>: [nonverbal <?=$test->id;?>]</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="checkbox" for="checkbox1<?=$test->id;?>">
                                           <input type="checkbox" id="checkbox1<?=$test->id;?>" class="ajax-checkbox" <?=nvHtml::isChecked($test->is_reg_only);?> data-toggle="checkbox" testid="<?=$test->id;?>" param="access" />        
                                           Доступен всем
                                        </label>
                                 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="checkbox" for="checkbox2<?=$test->id;?>">
                                            <input type="checkbox" id="checkbox2<?=$test->id;?>" class="ajax-checkbox" <?=nvHtml::isChecked($test->is_debug);?> data-toggle="checkbox" testid="<?=$test->id;?>" param="debug" />                
                                            Отладка
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div> 
                  </div>
                </div>
              </div> 
        <?php } ?>
    <?php } else { ?>
        Тестов пока нет
    <?php } ?>

 
</div>
<input type="button" id="nonverbal_add_test" class="btn btn-primary" value='Добавить Тест'>

<div>
    </p>
    <div class="nonverbal_new_test" style="display: none;">
    <div class="row">
        <div class="col-md-4">
            <input type="text" id="nonverbal_test_name" class="form-control" value="" placeholder="Название теста">    
        </div>
        <div class="col-md-2">
            <input type="button" id="nonverbal_create_test" class="btn btn-info btn-sm" value="Создать">    
        </div>
    </div>
</div>