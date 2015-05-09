<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvQuestionAdd extends NV_View {

	public $question;
	public $answers;
	public $test;

	public function show() {
?>
<div class="wrap">
	<?php $this->tabs($this->test, $this::TAB_QUESTIONS); ?>
	<p></p>
    <!-- <h3>Test List</h3> -->
    <a class="button-secondary" href="admin.php?page=nvTest&module=nvQuestion&test_id=<?=$this->test->getId();?>">Вернуться</a>

    <!-- cloneable block -->
    <div id='cloneable' class="inside" style="display: none;">
		<input type="text" class= "" id="treetest-answer-value" name=""/> :    
		<input type="text" class="regular-text" id="treetest-answer" name=""/>
		<input type="button" class="button-secondary" value="Удалить" id="treetest-answer-remove">
	</div>
	<!-- end of cloneable block -->

	<form method="post" action="admin.php?page=nvTest&module=nvQuestion&action=save&id=<?=$this->question->getId();?>">
		<input type="hidden" value="<?=$this->test->getId();?>" name="test_id"/>
		<div id="poststuff">
			<div class="postbox">
				<h3 class="hndle">Тип вопроса</h3>
				<div class="inside">
					Что определяет -
					<select name="type">
						<option selected="selected" value="0"></option>
						<option <?=$this->isSelected(1, $this->question->getType())?> value="1">ТПЭ</option>
						<option <?=$this->isSelected(2, $this->question->getType())?> value="2">Функционального</option>
					</select>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Содержимое вопроса</h3>
				<div class="inside">
					<?php
						wp_editor($this->question->getText(), "text", array('textarea_rows' => 5));
					?>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Ответы (код : текст)</h3>
				<div class="answer_rows">
				<?php 
					if (!empty($this->answers)) {
						foreach ($this->answers as $key => $answer)
				{ ?>
					<div class="inside">
						<input type="text" class="" id="treetest-answer-value" value="<?=$answer['value'];?>" name="answers[exists][<?=$answer['id'];?>][value]"/> :
						<input type="text" class="regular-text" id="treetest-answer" value="<?=$answer['text'];?>" name="answers[exists][<?=$answer['id'];?>][text]"/>
						<input type="button" class="button-secondary" value="Удалить" id="treetest-answer-remove">
					</div>
				<?php }} else { ?>
					<div class="inside">
						<input type="text" class="" id="treetest-answer-value" name="answers[new][1][value]"/> :
						<input type="text" class="regular-text" id="treetest-answer" name="answers[new][1][text]"/>
						<input type="button" class="button-secondary" value="Удалить" id="treetest-answer-remove">
					</div>
					<div class="inside">
						<input type="text" class="" id="treetest-answer-value" name="answers[new][2][value]"/> :
						<input type="text" class="regular-text" id="treetest-answer" name="answers[new][2][text]"/>
						<input type="button" class="button-secondary" value="Удалить" id="treetest-answer-remove">
					</div>
				<?php } ?>
				</div>
				<div class="inside">
					<input class="button-secondary" id="treetest-answer-add" type="button" value="Добавить ответ"/>
				</div>
			</div>
		</div>
		<input type="submit" name="template" class="button-primary" id="treetest-question-save" value="Сохранить">
	</form>
</div>
    <?php
	}
}
?>