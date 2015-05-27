<div class="wrap">
	<p></p>
    <!-- <h3>Test List</h3> -->
    <a class="btn btn-default btn-sm ajax-call" href="admin.php?page=NV&module=nvQuestion&test_id=<?=$test->getId();?>">Вернуться</a>

    <!-- cloneable block -->
    <div id='cloneable' class="inside" style="display: none;">
		<div class="row">
			<div class="col-md-4">
				<select name="answers[new][1][value]" id="treetest-answer-value" class="form-control select select-primary select-block mbl">
					<optgroup label="ТПЭ">
						<?=nvHtml::options($tpes);?>
					</optgroup>
					<optgroup label="Профили">
						<?=nvHtml::options($profiles);?>
					</optgroup>
            	</select>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control"  id="treetest-answer" name="answers[new][1][text]"/>		
			</div>
			<div class="col-md-2">
				<input type="button" class="btn btn-danger" value="Удалить" id="treetest-answer-remove">		
			</div>
		</div>
	</div>
	<!-- end of cloneable block -->

	<form method="post" action="admin.php?page=NV&module=nvQuestion&call=save&id=<?=$question->getId();?>" class="ajax-call">
		<input type="hidden" value="<?=$test->getId();?>" name="test_id"/>
		<div id="poststuff">
			<div class="postbox">
				<h3 class="hndle">Что определяет вопрос</h3>
				<div class="inside">
					<select id="type" name="type" class="form-control select select-primary">
						<option <?=nvHtml::isSelected(1, $question->getType())?> value="1">ТПЭ</option>
						<option <?=nvHtml::isSelected(2, $question->getType())?> value="2">Функциональный профиль</option>
					</select>
					<div class="cycle" style="display: inline;">
						Цикл:
						<select name="cycle" class="form-control select select-primary">
							<option <?=nvHtml::isSelected(0, $question->getCycle());?> value="0">0</option>
							<option <?=nvHtml::isSelected(1, $question->getCycle());?>value="1">1</option>
							<option <?=nvHtml::isSelected(2, $question->getCycle());?>value="2">2</option>
							<option <?=nvHtml::isSelected(3, $question->getCycle());?>value="3">3</option>
							<option <?=nvHtml::isSelected(4, $question->getCycle());?>value="4">4</option>
							<option <?=nvHtml::isSelected(5, $question->getCycle());?>value="5">5</option>
							<option <?=nvHtml::isSelected(6, $question->getCycle());?>value="6">6</option>
							<option <?=nvHtml::isSelected(7, $question->getCycle());?>value="7">7</option>
						</select>
					</div>

				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Содержимое вопроса</h3>
				<div class="inside">
					<?php
						wp_editor($question->getText(), "text", array('textarea_rows' => 5, 'quicktags' => false));
					?>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle">Ответы (код : текст)</h3>
				<div class="answer_rows">
				<?php 
					if (!empty($answers)) {
						foreach ($answers as $key => $answer)
				{ ?>
					<div class="inside">
						<div class="row">
							<div id="first" class="col-md-4">
								<select name="answers[exists][<?=$answer['id'];?>][value]" class="form-control select select-primary select-block mbl">
									<optgroup label="ТПЭ">
										<?=nvHtml::options($tpes, array($answer['value']));?>
									</optgroup>
									<optgroup label="Профили">
										<?=nvHtml::options($profiles, array($answer['value']));?>
									</optgroup>
		                    	</select>
							</div>
							<div id="second" class="col-md-6">
								<input type="text" class="form-control" id="treetest-answer" value="<?=$answer['text'];?>" name="answers[exists][<?=$answer['id'];?>][text]"/>		
							</div>
							<div class="col-md-2">
								<input type="button" class="btn btn-danger" value="Удалить" id="treetest-answer-remove">		
							</div>
						</div>
					</div>
				<?php }} else { ?>
					<div class="inside">
						<div class="row">
							<div class="col-md-4">
								<select name="answers[new][1][value]" class="form-control select select-primary select-block mbl">
									<optgroup label="ТПЭ">
										<?=nvHtml::options($tpes);?>
									</optgroup>
									<optgroup label="Профили">
										<?=nvHtml::options($profiles);?>
									</optgroup>
		                    	</select>
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control" id="treetest-answer" name="answers[new][1][text]"/>		
							</div>
							<div class="col-md-2">
								<input type="button" class="btn btn-danger" value="Удалить" id="treetest-answer-remove">		
							</div>
						</div>
					</div>
					<div class="inside">
						<div class="row">
							<div class="col-md-4">
								<select name="answers[new][2][value]" class="form-control select select-primary select-block mbl">
									<optgroup label="ТПЭ">
										<?=nvHtml::options($tpes);?>
									</optgroup>
									<optgroup label="Профили">
										<?=nvHtml::options($profiles);?>
									</optgroup>
		                    	</select>
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control" id="treetest-answer" name="answers[new][2][text]"/>		
							</div>
							<div class="col-md-2">
								<input type="button" class="btn btn-danger" value="Удалить" id="treetest-answer-remove">		
							</div>
						</div>
					</div>
				
				<?php } ?>
				</div>
				<div class="inside">
					<input class="btn btn-default btn-sm" id="treetest-answer-add" type="button" value="Добавить ответ"/>
				</div>
			</div>
		</div>
		<input type="submit" name="template" class="btn btn-sm btn-info" id="treetest-question-save" value="Сохранить">
	</form>
</div>