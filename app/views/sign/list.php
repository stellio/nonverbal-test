<div class="wrap">
    <div id="poststuff">
        <h3 class="hndle">ТПЭ</h3>
        <table class="wp-list-table widefat" id="">
            <thead>
                <tr>
                    <th scope="col">Признаки</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody id="the-list">
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
                                'action' => 'edit',
                                'test_id' => $test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                            ),
                            nvHtml::imgEdit(),
                            "Редактировать"
                        );?>
                        <?=nvHtml::link(array(
                                'module' => 'nvSign',
                                'action' => 'delete',
                                'test_id' => $test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                             ),
                            nvHtml::imgDelete(),
                            "Удалить"
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
        <p></p>
        <?=nvHtml::button(
            array(
                'module' => 'nvSign',
                'action' => 'edit',
                'test_id' => $test->getId(),
                'type' => nvModel::TYPE_TPE
            ),
            "Добавить",
            "button-secondary");
        ?>

        <p></p>
        <p></p>
        <!-- <div class="postbox"> -->
            <h3 class="hndle">Функциональные</h3>
        <!-- </div> -->
        <table class="wp-list-table widefat" id="">
            <thead>
                <tr>
                    <th scope="col">Признаки</th>
                    <th scope="col">Действия</th>
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
                                'action' => 'edit',
                                'test_id' => $test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                            ),
                                nvHtml::imgEdit(),
                                "Редактировать"
                            );?>
                            <?=nvHtml::link(array(
                                'module' => 'nvSign',
                                'action' => 'delete',
                                'test_id' => $test->getId(),
                                'id' => $group->getId(),
                                'type' => $group->getType()
                            ),
                                nvHtml::imgDelete(),
                                "Удалить"
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
        <p></p>
        <?=nvHtml::button(
            array(
                'module' => 'nvSign',
                'action' => 'edit',
                'test_id' => $test->getId(),
                'type' => nvModel::TYPE_FUNCTIONAL
            ),
            "Добавить",
            "button-secondary");
        ?>
    </div>
</div>