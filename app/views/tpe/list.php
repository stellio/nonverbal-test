<div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">ТПЭ</h3>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Квадра</th>
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
                                'call' => 'edit',
                                'test_id' => $test->getId(),
                                'id' => $tpe->id
                            ),
                                nvHtml::imgEdit(),
                                "Редактировать", 
                                'ajax-call btn btn-xs btn-info'
                            );?>
                            <?=nvHtml::link(array(
                                'module' => 'nvTpe',
                                'call' => 'delete',
                                'test_id' => $test->getId(),
                                'id' => $tpe->id
                            ),
                                nvHtml::imgDelete(),
                                "Удалить",
                                'ajax-call btn btn-xs btn-danger'
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
       
    </div>
     <p></p>
        <?php echo nvHtml::button(
            array(
                'module' => 'nvTpe',
                'call' => 'edit',
                'test_id' => $test->getId()
            ),
            "Добавить",
            "ajax-call btn btn-primary btn-sm");
        ?>
        <p></p>
</div>