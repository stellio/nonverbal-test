<div>
	</p>
		<a class="btn btn-default btn-sm ajax-call" href="admin.php?page=NV&module=nvResult&test_id=<?=$test->getId();?>">Вернуться</a>
	</p>
	<form method="post" action="admin.php?page=NV&module=nvResult&call=save&id=<?php echo $result->getId(); ?>" class="ajax-call">
<!--	<input type="submit" name="template" class="button-primary" id="treetest-result-save" value="Сохранить">-->
	<input type="hidden" value="<?=$test->getId();?>" name="test_id"/>

		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Заголовок</h3>
            </div>
            <div class="panel-body">
				<input name="title" id="treetest-result-title" type="text" class="form-control" value="<?=$result->getTitle(); ?>">
            </div>
        </div>

		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">ТПЭ</h3>
            </div>
            <div class="panel-body">
            	Квадра:
				<select name="tpe" class="form-control select select-primary">
					<?php foreach($tpe as $quadra) { ?>
						<option value="<?=$quadra->code?>" <?=nvHtml::isSelected($result->getTpe(), $quadra->code)?>><?=$quadra->name?></option>
					<?php } ?>
				</select>
            </div>
        </div>

		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Функциональные профили</h3>
            </div>
            <div class="panel-body">
            	<input name="func" type="hidden" id="func_input" value="<?=$func?>">
            	<select id="func_profile" multiple="multiple" class="form-control multiselect multiselect-primary">
                    <?=nvHtml::options($profiles, $selected);?>
                </select>
            </div>
        </div>

		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Описание</h3>
            </div>
            <div class="panel-body">
            	<?php
					wp_editor($result->getText(), "text", array('textarea_rows' => 5, 'quicktags' => false));
				?>
            </div>
        </div>
		<input type="submit" name="template" class="btn btn-primary btn-sm ajax-call" id="treetest-result-save" value="Сохранить">
	</form>
</div>