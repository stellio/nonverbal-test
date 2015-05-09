<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvResultAdd extends NV_View {

	public $test;
	public $result;
	public $tpe;

	function show() {

		?>
<div class="wrap">
	<?php $this->tabs($this->test, $this::TAB_RESULTS, "Новий Результат"); ?>
	<p></p>
	<a class="button-secondary" href="admin.php?page=nvTest&module=nvResult&test_id=<?=$this->test->getId();?>">Вернуться</a>
	<form method="post" action="admin.php?page=nvTest&module=nvResult&action=save&id=<?php echo $this->result->getId(); ?>">
<!--	<input type="submit" name="template" class="button-primary" id="treetest-result-save" value="Сохранить">-->
	<input type="hidden" value="<?=$this->test->getId();?>" name="test_id"/>
		<div id="poststuff">
			<div class="postbox">
				<h3 class="hndle">Заголовок</h3>
				<div class="inside">
					<input name="title" id="treetest-result-title" type="text" class="regular-text" value="<?php echo $this->result->getTitle(); ?>">
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">ТПЭ</h3>
				<div class="inside">
					Квадра:
					<select name="tpe">
						<?php foreach($this->tpe as $quadra) { ?>
							<option value="<?=$quadra->code?>" <?=$this->isSelected($this->result->getTpe(), $quadra->code)?>><?=$quadra->name?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Функциональные признаки</h3>
				<div class="inside">
					Признаки:
					<p></p>
					<input value="<?=$this->result->getFunc();?>" name="func" id="treetest-result-sequence" type="text"> (перечислите через запятую: LG, IN)
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Описание</h3>
				<div class="inside">
					<?php
						wp_editor($this->result->getText(), "description");
					?>
				</div>
			</div>
		</div>
		<input type="submit" name="template" class="button-primary" id="treetest-result-save" value="Сохранить">
	</form>
</div>
	<?php 
	}

}
?>