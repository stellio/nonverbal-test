<div>
    
    <h4>Статистика по тесту: <?=$test->getName();?></h4>
    </p>
        <a class="btn btn-default btn-sm" href="admin.php?page=NV">Вернуться</a>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Результаты
            </h3>
        </div>
            <table class="table table-hover" id="">
                <thead>
                    <tr>
                        <th scope="col">Имя Пользователя</th>
                        <th scope="col">Результат</th>
                        <th scope="col">Дата</th>
                         <th scope="col">Действия</th>
                        <!-- <th scope="col">Автор</th> -->
                        <!-- <th scope="col">Статус</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php 
                    if (count($statistics)) {
                        foreach ($statistics as $key => $statistic) { ?>
                        
                            <tr id="<?=$statistic->id;?>">
                                <td>
                                    <?php
                                        $user_data = get_userdata($statistic->user_id);
                                        echo ($user_data)? $user_data->user_login : 'Quest';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $statistic->result_text;
                                    ?>
                                </td>
                                <td><?=$statistic->time;?></td>
                                <td>
                                    <a id="<?=$statistic->id;?>" title="Детали" class="btn btn-primary btn-xs btn_non_more_info" href="#">
                                        <?=nvHtml::imgPlus();?>
                                    </a>

                                    <a id="<?=$statistic->id;?>" title="Удалить" class="btn btn-danger btn-xs btn_non_romove_statistic" href="#">
                                        <?=nvHtml::imgDelete();?>
                                    </a>
                                </td>
                            </tr>
                            <tr id="<?=$statistic->id;?>" class="grey non_more_info_block" style="display: none;" >
                                <td colspan="4">
                                    <div>
                                        <table>
                                            <tr>
                                                <td class="strong">Относит себя к типу: </strong></td>
                                                <td><?=$statistic->type;?></td>
                                            </tr>
                                            <tr>
                                                <td class="strong">наиболее вероятный вариант: </td>
                                                <td><?=$statistic->type_another;?></td>
                                            </tr>
                                            <tr>
                                                <td class="strong">Тип определен на основании: </td>
                                                <td><?=$statistic->type_basis;?></td>
                                            </tr>
                                            <tr>
                                                <td class="strong">Возраст: </td>
                                                <td><?=$statistic->age;?></td>
                                            </tr>
                                            <tr>
                                                <td class="strong">Пол: </td>
                                                <td><?=$statistic->gender;?></td>
                                            </tr>
                                            <tr>
                                                <td class="strong">Имя/ник: </td>
                                                <td><?=$statistic->nickname;?></td>
                                            </tr>
                                            </table>
                                    </div>
                                </td>
                            </tr>
                    <?php } 
                    } else { ?>
                        <tr>
                            <!-- <td colspan="6">Тестов пока еще нет.</td> -->
                            <td colspan="6">There are no statistic yet.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>    
    </div>

    
    <br>
</div>