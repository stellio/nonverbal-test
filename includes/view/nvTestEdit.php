<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvTestEdit extends NV_View {

	public $test;

	function show() {

	?>
<div class="wrap">
	<?php $this->tabs($this->test, $this::TAB_TEST); ?>
	<form method="post" action="admin.php?page=nvTest&action=save&id=<?php echo $this->test->getId(); ?>">
		<div id="poststuff">
			<div class="postbox">
				<h3 class="hndle">Название</h3>
				<div class="inside">
					<input name="name" id="treetest-test-name" type="text" class="regular-text" value="<?php echo $this->test->getName(); ?>">
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Опции</h3>
				<div class="inside">
					<input type="checkbox" id="title_hidden" value="1" name="onlyregistered" <?php echo $this->test->isRegOnly() ? 'checked="checked"' : '' ?> >Тест могу прохожить только зарегистрированые
					<p></p>
					<input type="checkbox" id="title_hidden" value="1" name="debugmode" <?php echo $this->test->isDebug() ? 'checked="checked"' : '' ?> >Режим отладки (показывает график доминации признаков во время прохождения теста)
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Описание</h3>
				<div class="inside">
					<?php
						wp_editor($this->test->getDescription(), "description");
					?>
				</div>
			</div>

		</div>
		<input type="submit" name="template" class="button-primary" id="treetest-save-test" value="Save">
	</form>
</div>
	<?php 
	}
}
?>