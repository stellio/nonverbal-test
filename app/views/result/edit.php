<div class="wrap">
	<p></p>
	<a class="button-secondary ajax-call" href="admin.php?page=NV&module=nvResult&test_id=<?=$test->getId();?>">Вернуться</a>
	<form method="post" action="admin.php?page=NV&module=nvResult&call=save&id=<?php echo $result->getId(); ?>" class="ajax-call">
<!--	<input type="submit" name="template" class="button-primary" id="treetest-result-save" value="Сохранить">-->
	<input type="hidden" value="<?=$test->getId();?>" name="test_id"/>
		<div id="poststuff">
			<div class="postbox">
				<h3 class="hndle">Заголовок</h3>
				<div class="inside">
					<input name="title" id="treetest-result-title" type="text" class="regular-text" value="<?=$result->getTitle(); ?>">
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">ТПЭ</h3>
				<div class="inside">
					Квадра:
					<select name="tpe">
						<?php foreach($tpe as $quadra) { ?>
							<option value="<?=$quadra->code?>" <?=nvHtml::isSelected($result->getTpe(), $quadra->code)?>><?=$quadra->name?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Функциональные признаки</h3>
				<div class="inside">
					Признаки:
					<p></p>
					<input value="<?=$result->getFunc();?>" name="func" id="treetest-result-sequence" type="text"> (перечислите через запятую: LG, IN)
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Описание</h3>
				<div class="inside">
					<?php
						wp_editor($result->getText(), "description");
					?>
				</div>
			</div>
		</div>
		<input type="submit" name="template" class="button-primary ajax-call" id="treetest-result-save" value="Сохранить">
	</form>
</div>