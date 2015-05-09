<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvTestList extends NV_View {

    public $content;

    function show() {

?>
<div class="wrap">
    
    <h2>TreeTest - Управление тестами</h2>
    <h2></h2>

    
    
    <h3>Список тестов</h3>
    <input type="button" id="but_add_test" class="button-primary" value='Добавить Тест'>
    <p></p>
    <div class="new_test_block" style="display: none;">
        <input type="text" id="text_new_test_name" class="regular-text" value="" placeholder="Название теста">
        <input type="button" id="but_create_test" class="button-secondary" value="Создать">
    </div>
    <p></p>
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
            if (count($this->content)) {
                foreach ($this->content as $key => $value) { ?>
                
                    <tr>
                        <td><?=$value['name'];?></td>
                        <td>[treetest <?=$value['id'];?>]</td>
                        <td>
                            <?=$this->link(array(
                                    'action' => 'edit',
                                    'id' => $value['id']
                                ),
                                $this->imgEdit(), "Редактировать")
                            ?>

                            <?=$this->link(array(
                                'module' => 'Statistic',
                                'test_id' => $value['id']
                            ),
                                $this->imgChart(), "Статистика")
                            ?>

                            <?=$this->link(array(
                                'action' => 'delete',
                                'id' => $value['id']
                            ),
                                $this->imgDelete(), "Удалить")
                            ?>
                        </td>
                        <td>
                            <?=($value['is_debug'])? "Отладочный режим":"Опубликован"?>
                        </td>
                        <td>
                            <?=($value['is_reg_only'])? "Только для зарегистрированых":"Для всех"?>
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
    <?php
    }
}
?>