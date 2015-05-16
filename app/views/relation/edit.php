<div class="wrap">
	<a class="button-secondary ajax-call" href="admin.php?page=NV&module=nvRelation&test_id=<?=$test_id;?>">Вернуться</a>
	</p>
	<form method="post" action="admin.php?page=NV&module=nvRelation&call=save&id=<?//$relation->getId();?>" class="ajax-call form-inline">
		<input type="hidden" value="<?=$test_id;?>" name="test_id"/>
		<div class="panel panel-default">
  			<div class="panel-heading">Panel heading without title</div>
  			<div class="panel-body">
  				<div class="form-group">
    				<label for="exampleInputName2">Тип:</label>
    				<select name="what" class="form-control select select-primary select-block mbl">
    					<option value="<?=nvModel::TYPE_TPE;?>">ТПЭ</option>
    					<option value="<?=nvModel::TYPE_FUNCTIONAL?>">Профиль</option>
                    </select>
  				</div>
				<div class="form-group">
    				<label for="exampleInputName2">Что:</label>
    				<select name="what" class="form-control select select-primary select-block mbl">
						<optgroup label="ТПЭ">
							<?=nvHtml::options($tpes);?>
						</optgroup>
						<optgroup label="Профили">
							<?=nvHtml::options($profiles);?>
						</optgroup>
                    </select>
  				</div>
  				</p>
  				<div class="form-group">
    				<label for="exampleInputName2">Тип:</label>
    				<select name="what" class="form-control select select-primary select-block mbl">
						<option value="<?=nvModel::TYPE_TPE;?>">ТПЭ</option>
    					<option value="<?=nvModel::TYPE_FUNCTIONAL?>">Профиль</option>	                    </select>
  				</div>
  				<div class="form-group">
    				<label for="exampleInputPassword1">С чем:</label>
    				<select name="with" class="form-control select select-primary select-block mbl">
						<optgroup label="ТПЭ">
							<?=nvHtml::options($tpes);?>
						</optgroup>
						<optgroup label="Профили">
							<?=nvHtml::options($profiles);?>
						</optgroup>
                    </select>
  				</div>
  			</div>
  		</div>
		
		<input type="submit" name="template" class="button-primary ajax-call" id="treetest-result-save" value="Сохранить">
	</form>
</div>