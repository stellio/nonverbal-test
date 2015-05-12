<div class="wrap">
	<form method="post" action="admin.php?page=NV&module=nvTest&call=save&id=<?=$test->getId();?>">
		<div id="poststuff">
			<div class="panel panel-success">
  				<div class="panel-heading">Название</div>
  				<div class="panel-body">
    					<input name="name" id="treetest-test-name" type="text" class="regular-text" value="<?=$test->getName();?>">
  				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Опции</h3>
				<div class="inside">
					<input type="checkbox" id="title_hidden" value="1" name="onlyregistered" <?=$test->isRegOnly() ? 'checked="checked"' : '' ?> >Тест могу прохожить только зарегистрированые
					<p></p>
					<input type="checkbox" id="title_hidden" value="1" name="debugmode" <?=$test->isDebug() ? 'checked="checked"' : '' ?> >Режим отладки (показывает график доминации признаков во время прохождения теста)
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Описание</h3>
				<div class="inside">
					<?php
						wp_editor($test->getDescription(), "description");
					?>
				</div>
			</div>

		</div>
		<input type="submit" name="template" class="button-primary" id="treetest-save-test" value="Save">
	</form>
</div>