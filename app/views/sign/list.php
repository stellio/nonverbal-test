<div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">ТПЭ</h3>
        </div>
        <table class="table borderless">
            <thead>
                <tr>
                    <th>Признаки</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($groupsTPE) { ?>
                <?php foreach($groupsTPE as $group) { ?>
                <tr>
                    <td>
                        <?=$group->firstPart->getName();?> (<b><?=$group->firstPart->getCode()?></b> ) -
                        <?=$group->secondPart->getName();?> (<b> <?=$group->secondPart->getCode()?></b> )
                    </td>
                    <td>
                        <?=nvHtml::link(array(
                                'module' => 'nvSign',
                                'call' => 'edit',
                                'test_id' => $test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                            ),
                            nvHtml::imgEdit(),
                            "Редактировать",
                            'ajax-call'
                        );?>
                        <?=nvHtml::link(array(
                                'module' => 'nvSign',
                                'call' => 'delete',
                                'test_id' => $test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
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
                    <td colspan="6">Признаков пока нет</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
            
    <p></p>
    <?=nvHtml::button(
        array(
            'module' => 'nvSign',
            'call' => 'edit',
            'test_id' => $test->getId(),
            'type' => nvModel::TYPE_TPE
        ),
        "Добавить",
        "btn btn-primary btn-sm ajax-call");
    ?>
    

    
    <p></p>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Функциональные</h3>
        </div>
        <table class="table">
            <thead>
                <tr class="filters">
                    <th>Признаки</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody id="the-list">
            <?php if ($groupsFunc) { ?>
                <?php foreach($groupsFunc as $group) { ?>
                    <tr>
                        <td>
                            <?=$group->firstPart->getName();?> (<b><?=$group->firstPart->getCode()?></b> ) -
                            <?=$group->secondPart->getName();?> (<b> <?=$group->secondPart->getCode()?></b> )
                        </td>
                        <td>
                            <?=nvHtml::link(array(
                                'module' => 'nvSign',
                                'call' => 'edit',
                                'test_id' => $test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                            ),
                                nvHtml::imgEdit(),
                                "Редактировать",
                                'ajax-call btn btn-xs btn-info'
                            );?>
                            <?=nvHtml::link(array(
                                'module' => 'nvSign',
                                'call' => 'delete',
                                'test_id' => $test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                            ),
                                nvHtml::imgDelete(),
                                "Удалить",
                                "ajax-call btn btn-xs btn-danger"
                            );?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6">Признаков пока нет</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <p></p>
    <?=nvHtml::button(
        array(
            'module' => 'nvSign',
            'call' => 'edit',
            'test_id' => $test->getId(),
            'type' => nvModel::TYPE_FUNCTIONAL
        ),
        "Добавить",
        "btn btn-primary btn-sm ajax-call");
    ?>
</div>