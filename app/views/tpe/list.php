<div class="wrap">
            <div id="poststuff">
                <h3 class="hndle">ТПЭ</h3>
                <table class="wp-list-table widefat" id="">
                    <thead>
                    <tr>
                        <th scope="col">Квадры</th>
                        <th scope="col">Действия</th>
                    </tr>
                    </thead>
                    <tbody id="the-list">
                    <?php if ($tpeList) { ?>
                        <?php foreach($tpeList as $tpe) { ?>
                            <tr>
                                <td>
                                    <?=$tpe->name;?>
                                    (<b><?=$tpe->code?></b> ) =
                                    <?=$tpe->sequence_of_sign?>
                                </td>
                                <td>
                                    <?=nvHtml::link(array(
                                        'module' => 'nvTpe',
                                        'action' => 'edit',
                                        'test_id' => $test->getId(),
                                        'id' => $tpe->id
                                    ),
                                        nvHtml::imgEdit(),
                                        "Редактировать", 
                                        'ajax-call'
                                    );?>
                                    <?=nvHtml::link(array(
                                        'module' => 'nvTpe',
                                        'action' => 'delete',
                                        'test_id' => $test->getId(),
                                        'id' => $tpe->id
                                    ),
                                        nvHtml::imgDelete(),
                                        "Удалить",
                                        'ajax-call'
                                    );?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6">Список пока пуст</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <p></p>
                <?php echo nvHtml::button(
                    array(
                        'module' => 'nvTpe',
                        'action' => 'edit',
                        'test_id' => $test->getId()
                    ),
                    "Добавить",
                    "ajax-call button-secondary");
                ?>
                <p></p>
            </div>
        </div>