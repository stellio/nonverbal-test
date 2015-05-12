<div class="wrap">
    <p></p>
    <a class="button-secondary ajax-call" href="admin.php?page=NV&module=nvQuestion&call=add&test_id=<?=$testId;?>">Добавить</a>
    <p></p>
    <table class="wp-list-table widefat" id="">
        <thead>
            <tr>
                <th scope="col">№</th>
                <th scope="col">Текст вопроса</th>
                <th scope="col">Что определяет</th>
                <th scope="col">Ответы (код : текст)</th>
                <th scope="col">Действия</th>
                <!-- <th scope="col">Статус</th> -->
            </tr>
        </thead>
        <tbody id="the-list">
        <?php
            if (count($content)) {
                $counter = 0;
                foreach ($content as $key => $value) { $counter++; ?>

                    <tr>
                        <td><?=$counter?></td>
                        <td> <?=nvHtml::shorten($value['text']);?></td>
                        <td>
                            <?php
                                if ($value['type'] == nvModel::TYPE_TPE)
                                    echo "ТПЭ";
                                else if ($value['type'] == nvModel::TYPE_FUNCTIONAL)
                                    echo "Функциональность";
                                else
                                    echo "-";
                            ?>
                        </td>
                        <td>
                            <?php foreach ($answers->getListByQuestionIdAndTestId($value['id'], $testId) as $key => $answr) {
                                echo $answr['value'] . " : " . $answr['text'] . "<br>";
                            } ?>
                        </td>                        
                        <td>
                            <?=nvHtml::link(array(
                                'module' => 'nvQuestion',
                                'call' => 'edit',
                                'test_id' => $testId,
                                'id' => $value['id']
                            ),
                                nvHtml::imgEdit(),
                                "Редактировать",
                                'ajax-call'
                            );
                            ?>
                            <?=nvHtml::link(array(
                                'module' => 'nvQuestion',
                                'call' => 'delete',
                                'test_id' => $testId,
                                'id' => $value['id']
                            ),
                                nvHtml::imgDelete(),
                                "Удалить",
                                'ajax-call'
                            );
                            ?>
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
    <a class="button-secondary ajax-call" href="admin.php?page=NV&module=nvQuestion&call=add&test_id=<?=$testId;?>">Добавить</a>
</div>