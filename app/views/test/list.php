<div>
    <h4>Список тестов</h4>
    <!-- <input type="button" id="but_add_test" class="button-primary" value='Добавить Тест'> -->
    <p></p>
    <div class="new_test_block" style="display: none;">
        <input type="text" id="text_new_test_name" class="regular-text" value="" placeholder="Название теста">
        <input type="button" id="but_create_test" class="button-secondary" value="Создать">
    </div>
    <p></p>

    <!-- <input type="checkbox" checked="checked" data-toggle="switch" id="custom-switch-01" /> -->
    <!-- <input type="checkbox" data-toggle="switch" id="custom-switch-02" /> -->

    <div class="panel panel-default">
  <div class="panel-heading"><strong>Невербальный тест</strong></div>
  <div class="panel-body">
    <div class="row">
        <div class="col-md-6">
            <a href="#fakelink" class="btn btn-xs btn-primary">
                <span class="fui-new"></span>
            </a>
            <a href="#fakelink" class="btn btn-xs btn-info">
                <span class="fui-document"></span>
            </a>
            <!-- <br> -->
            <a href="#fakelink" class="btn btn-xs btn-danger">
                <span class="fui-trash"></span>
            </a>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <input type="checkbox" checked="checked" data-toggle="switch" id="custom-switch-01" />
                        Доступен всем
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="checkbox" data-toggle="switch" id="custom-switch-02" />                
                </div>
            </div>
        </div>
    </div>
    <dir class="row">
        
    </dir>
  </div>
</div>
    <table  class="wp-list-table widefat" id="">
        <thead>
            <tr>
                <th scope="col">Название теста</th>
                <th scope="col">Shortcode</th>
                <th scope="col">Действия</th>
                <!-- <th scope="col">Автор</th> -->
                <th scope="col">Cтатус</th>
                <th scope="col">Доступ</th>
            </tr>
        </thead>
        <tbody id="the-list">
        <?php 
            if (count($tests)) {
                foreach ($tests as $test) { ?>
                
                    <tr>
                        <td><?=$test->name;?></td>
                        <td>[treetest <?=$test->id;?>]</td>
                        <td>
                            <?=//nvHtml::link(array(
                                 //   'action' => 'edit',
                                   // 'id' => $test->id
                                //),
                                FlatUi::button('admin.php?page=nvTest&action=edit&id'.$test->id, "Редактировать", array('class' => 'btn-xs'));
                            ?>
                            <a href="admin.php?page=NV&module=nvTest&action=edit&id=<?=$test->id?>" class="btn btn-xs btn-default"><?=FlatUi::glyph('new')?></a>
                          
                        </td>
                        <td>
                            <?=($test->is_debug)? "Отладочный режим":"Опубликован"?>
                        </td>
                        <td>
                            <?=($test->is_reg_only)? "Только для зарегистрированых":"Для всех"?>
                        </td>
                    </tr>
            <?php } 
            } else { ?>
                <tr>
                    <!-- <td colspan="6">Тестов пока еще нет.</td> -->
                    <td colspan="6">There are no tests yet.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>