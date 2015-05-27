<div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">ТПЭ</h3>
        </div>
        <table class="table" id="">
            <thead>
            <tr>
                <th scope="col">Профили</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody id="the-list">
            <?php if ($profilesTPE) { ?>
                <?php foreach($profilesTPE as $profile) { ?>
                    <tr>
                        <td>
                            <?=$profile->name;?>
                            (<b><?=$profile->code?></b> ) =
                            <?=$profile->sequence_of_sign?>
                        </td>
                        <td>
                            <?=nvHtml::link(array(
                                'module' => 'nvProfile',
                                'call' => 'edit',
                                'test_id' => $test->getId(),
                                'id' => $profile->id,
                                'type' => $profile->type
                            ),
                                nvHtml::imgEdit(),
                                "Редактировать",
                                'ajax-call btn btn-info btn-xs'
                            );?>
                            <?=nvHtml::link(array(
                                'module' => 'nvProfile',
                                'call' => 'delete',
                                'test_id' => $test->getId(),
                                'id' => $profile->id,
                                'type' => $profile->type
                            ),
                                nvHtml::imgDelete(),
                                "Удалить",
                                'ajax-call btn btn-danger btn-xs'
                            );?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6">Профилей пока нет</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
        <p></p>
        <?php echo nvHtml::button(
            array(
                'module' => 'nvProfile',
                'call' => 'edit',
                'test_id' => $test->getId(),
                'type' => nvModel::TYPE_TPE
            ),
            "Добавить",
            "btn btn-primary btn-sm ajax-call");
        ?>

        <p></p>
        <p></p>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Функциональные</h3>    
        </div>
        <table class="wp-list-table widefat" id="">
            <thead>
            <tr>
                <th scope="col">Профили</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody id="the-list">
            <?php if ($profilesFunc) { ?>
                <?php foreach($profilesFunc as $profile) { ?>
                    <tr>
                        <td>
                            <?=$profile->name;?>
                            (<b><?=$profile->code?></b> ) =
                            <?=$profile->sequence_of_sign?>
                        </td>
                        <td>
                            <?=nvHtml::link(array(
                                'module' => 'nvProfile',
                                'call' => 'edit',
                                'test_id' => $test->getId(),
                                'id' => $profile->id,
                                'type' => $profile->type
                            ),
                                nvHtml::imgEdit(),
                                "Редактировать",
                                'ajax-call btn btn-xs btn-info'
                            );?>
                            <?=nvHtml::link(array(
                                'module' => 'nvProfile',
                                'call' => 'delete',
                                'test_id' => $test->getId(),
                                'id' => $profile->id,
                                'type' => $profile->type
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
                    <td colspan="6">Профилей пока нет</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
        <p></p>
        <?php echo nvHtml::button(
            array(
                'module' => 'nvProfile',
                'call' => 'edit',
                'test_id' => $test->getId(),
                'type' => nvModel::TYPE_FUNCTIONAL
            ),
            "Добавить",
            "btn btn-primary btn-sm ajax-call");
        ?>
</div>