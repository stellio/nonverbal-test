<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvResultList extends NV_View {
    
    public $results;
    public $test;

    function show() {

?>
<div class="wrap">
    <?php $this->tabs($this->test, $this::TAB_RESULTS); ?>
    <p></p>
    <a class="button-secondary" href="admin.php?page=nvTest&module=nvResult&action=add&test_id=<?=$this->test->getId();?>">Добавить результат</a>
    <p></p>
    <table class="wp-list-table widefat" id="">
        <thead>
            <tr>
                <th scope="col">№</th>
                <th scope="col">Заголовок</th>
                <th scope="col">ТПЭ</th>
                 <th scope="col">Функциональные признаки</th>
                <!-- <th scope="col">Действия</th> -->
                <th scope="col">Действия</th>
                <!-- <th scope="col">Автор</th> -->
                <!-- <th scope="col">Статус</th> -->
            </tr>
        </thead>
        <tbody id="the-list">
        <?php 
            if (count($this->results)) {
                $counter = 0;
                foreach ($this->results as $key => $result) { $counter++; ?>
                
                    <tr>
                        <td><?=$counter?></td>
                        <td><?=$result->title;?></td>
                        <td><?=$result->tpe;?></td>
                        <td><?=$result->func;?></td>
                        <td>
                            <?=$this->link(array(
                                'module' => 'nvResult',
                                'action' => 'edit',
                                'test_id' => $this->test->getId(),
                                'id' => $result->id
                            ),
                                $this->imgEdit(),
                                "Редактировать"
                            );?>
                            <?=$this->link(array(
                                'module' => 'nvResult',
                                'action' => 'delete',
                                'test_id' => $this->test->getId(),
                                'id' => $result->id
                            ),
                                $this->imgDelete(),
                                "Удалить"
                            );?>
                        </td>
                    </tr>
            <?php } 
            } else { ?>
                <tr>
                     <td colspan="6">Вопросов пока еще нет.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <a class="button-secondary" href="admin.php?page=nvTest&module=nvResult&action=add&test_id=<?=$this->test->getId();?>">Добавить результат</a>
</div>
    <?php
    }
}
?>