<div class="wrap">
	<a class="btn btn-default btn-sm ajax-call" href="admin.php?page=NV&module=nvRelation&test_id=<?=$test_id;?>">Вернуться</a>
	</p>
	<form method="post" action="admin.php?page=NV&module=nvRelation&call=save_element" class="ajax-call form-inline">
		<input type="hidden" value="<?=$test_id;?>" name="test_id"/>
    <input type="hidden" value="<?=$parent_id;?>" name="parent_id"/>
    <input type="hidden" value="<?=nvModel::TYPE_FUNCTIONAL?>" name="type"/>
		<div class="panel panel-default">
  			<div class="panel-heading">Выберите элемент:</div>
  			<div class="panel-body">
          <div class="form-group">
    				<select name="code" class="form-control select select-primary select-block mbl">
  						<optgroup label="Профили">
  							<?=nvHtml::options($profiles);?>
  						</optgroup>
            </select>
  				</div>
  			</div>
  	</div>
		<input type="submit" name="template" class="btn btn-primary btn-sm ajax-call" id="treetest-result-save" value="Сохранить">
	</form>
</div>