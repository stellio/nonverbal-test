 <?php $lEn = ($lang == 'en_US')? True : False; ?>

<div class="treetest-results"></div>
    <div class="panel panel-primary">
        <div class="panel-heading"><?=($lEn)? 'Result': 'Результат'?></div>
        <div class="panel-body">
            <div><b><?=($lEn)? 'Type' : 'Тип'?>: </b><?=$results['lead']['typeName']?>, <?=$results['lead']['tpeName']?></div>
            <div><b><?=($lEn)? 'Subtype' : 'Подтип'?>: </b><?=$results['sub']['typeName']?>, <?=$results['sub']['tpeName']?></div>
            <div><b><?=($lEn)? 'TPE Profile' : 'ТПЭ Профиль'?>: </b><?=$results['profile']?></div>
            <p></p>
            <div>
                <?php foreach($results['moreTypeInfo'] as $result) { ?>
                    <div><b><?=$result->title?></b></div>
                    <p></p>
                    <div>
                        <?=$result->text?>
                    </div>
                <p></p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>