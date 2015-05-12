<div class="wrap">
    <div id="poststuff">
        <h3 class="hndle">ТПЭ</h3>
        <table class="wp-list-table widefat" id="">
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
                                'ajax-call'
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
        <p></p>
        <?php echo nvHtml::button(
            array(
                'module' => 'nvProfile',
                'call' => 'edit',
                'test_id' => $test->getId(),
                'type' => nvModel::TYPE_TPE
            ),
            "Добавить",
            "button-secondary ajax-call");
        ?>

        <p></p>
        <p></p>
        <!-- <div class="postbox"> -->
        <h3 class="hndle">Функциональные</h3>
        <!-- </div> -->
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
                                'ajax-call'
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
        <p></p>
        <?php echo nvHtml::button(
            array(
                'module' => 'nvProfile',
                'call' => 'edit',
                'test_id' => $test->getId(),
                'type' => nvModel::TYPE_FUNCTIONAL
            ),
            "Добавить",
            "button-secondary ajax-call");
        ?>
        </div>
</div>