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
                                    <?=$this->link(array(
                                        'module' => 'nvTpe',
                                        'action' => 'edit',
                                        'test_id' => $this->test->getId(),
                                        'id' => $tpe->id
                                    ),
                                        $this->imgEdit(),
                                        "Редактировать"
                                    );?>
                                    <?=$this->link(array(
                                        'module' => 'nvTpe',
                                        'action' => 'delete',
                                        'test_id' => $this->test->getId(),
                                        'id' => $tpe->id
                                    ),
                                        $this->imgDelete(),
                                        "Удалить"
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
                <?php echo $this->button(
                    array(
                        'module' => 'nvTpe',
                        'action' => 'edit',
                        'test_id' => $this->test->getId()
                    ),
                    "Добавить",
                    "button-secondary");
                ?>
                <p></p>
            </div>
        </div>