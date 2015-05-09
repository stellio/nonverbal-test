<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvStatisticList extends NV_View {

    public $test;
    public $result;
    public $statistics;

    function show() {

?>
<div class="wrap">
    
    <h2>Статистика</h2>
    <h2></h2>

    
    <h3>Тест: <?=$this->test->getName();?></h3>
    </p>
        <a class="button-primary" href="admin.php?page=TreeTest">Вернуться</a>
    </p>
    <table class="wp-list-table widefat" id="">
        <thead>
            <tr>
                <th scope="col">Имя Пользователя</th>
                <th scope="col">Результат</th>
                <th scope="col">Дата</th>
                 <th scope="col">Действия</th>
                <!-- <th scope="col">Автор</th> -->
                <!-- <th scope="col">Статус</th> -->
            </tr>
        </thead>
        <tbody id="the-list">
        <?php 
            if (count($this->statistics)) {
                foreach ($this->statistics as $key => $statistic) { ?>
                
                    <tr id="<?=$statistic->id;?>">
                        <td>
                            <?php
                                $user_data = get_userdata($statistic->user_id);
                                echo ($user_data)? $user_data->user_login : 'Quest';
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $statistic->result_text;
                            ?>
                        </td>
                        <td><?=$statistic->time;?></td>
                        <td>
                            <a id="<?=$statistic->id;?>" class="btn_more_info" href="#">Детали</a>
                            <a id="<?=$statistic->id;?>" class="btn_romove_statistic" href="#">Удалить</a>
                        </td>
                    </tr>
                    <tr id="<?=$statistic->id;?>" class="hidden grey more_info_block" >
                        <td colspan="4">
                            <div>
                                <table>
                                    <tr>
                                        <td class="strong">Относит себя к типу: </strong></td>
                                        <td><?=$statistic->type;?></td>
                                    </tr>
                                    <tr>
                                        <td class="strong">наиболее вероятный вариант: </td>
                                        <td><?=$statistic->type_another;?></td>
                                    </tr>
                                    <tr>
                                        <td class="strong">Тип определен на основании: </td>
                                        <td><?=$statistic->type_basis;?></td>
                                    </tr>
                                    <tr>
                                        <td class="strong">Возраст: </td>
                                        <td><?=$statistic->age;?></td>
                                    </tr>
                                    <tr>
                                        <td class="strong">Пол: </td>
                                        <td><?=$statistic->gender;?></td>
                                    </tr>
                                    <tr>
                                        <td class="strong">Имя/ник: </td>
                                        <td><?=$statistic->nickname;?></td>
                                    </tr>
                                    </table>
                            </div>
                        </td>
                    </tr>
            <?php } 
            } else { ?>
                <tr>
                    <!-- <td colspan="6">Тестов пока еще нет.</td> -->
                    <td colspan="6">There are no statistic yet.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
</div>
    <?php
    }
}
?>