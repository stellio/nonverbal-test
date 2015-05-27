<div>
    <p></p>
    <a class="btn btn-primary btn-sm ajax-call" href="admin.php?page=NV&module=nvResult&call=add&test_id=<?=$test->getId();?>">Добавить результат</a>
    <p></p>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Результаты</h3>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">№</th>
                    <th scope="col">Заголовок</th>
                    <th scope="col">ТПЭ</th>
                     <th scope="col">Функциональные профили</th>
                    <!-- <th scope="col">Действия</th> -->
                    <th scope="col">Действия</th>
                    <!-- <th scope="col">Автор</th> -->
                    <!-- <th scope="col">Статус</th> -->
                </tr>
            </thead>
            <tbody>
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
                                    'ajax-call btn btn-info btn-xs'
                                );?>
                                <?=nvHtml::link(array(
                                    'module' => 'nvResult',
                                    'call' => 'delete',
                                    'test_id' => $test->getId(),
                                    'id' => $result->id
                                ),
                                    nvHtml::imgDelete(),
                                    "Удалить",
                                    'ajax-call btn btn-danger btn-xs'
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
    </div>
    <br>
    <a class="btn btn-primary btn-sm ajax-call" href="admin.php?page=NV&module=nvResult&call=add&test_id=<?=$test->getId();?>">Добавить результат</a>
</div>