<div class="wrap">
    <p></p>
    <a class="button-secondary ajax-call" href="admin.php?page=NV&module=nvResult&call=add&test_id=<?=$test->getId();?>">Добавить результат</a>
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
            if (count($results)) {
                $counter = 0;
                foreach ($results as $key => $result) { $counter++; ?>
                
                    <tr>
                        <td><?=$counter?></td>
                        <td><?=$result->title;?></td>
                        <td><?=$result->tpe;?></td>
                        <td><?=$result->func;?></td>
                        <td>
                            <?=nvHtml::link(array(
                                'module' => 'nvResult',
                                'call' => 'edit',
                                'test_id' => $test->getId(),
                                'id' => $result->id
                            ),
                                nvHtml::imgEdit(),
                                "Редактировать",
                                'ajax-call'
                            );?>
                            <?=nvHtml::link(array(
                                'module' => 'nvResult',
                                'call' => 'delete',
                                'test_id' => $test->getId(),
                                'id' => $result->id
                            ),
                                nvHtml::imgDelete(),
                                "Удалить",
                                'ajax-call'
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
    <a class="button-secondary ajax-call" href="admin.php?page=NV&module=nvResult&call=add&test_id=<?=$test->getId();?>">Добавить результат</a>
</div>