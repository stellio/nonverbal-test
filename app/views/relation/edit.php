<div>
	<a class="btn btn-default btn-sm ajax-call" href="admin.php?page=NV&module=nvRelation&test_id=<?=$test_id;?>">Вернуться</a>
	</p>
	<form method="post" action="admin.php?page=NV&module=nvRelation&call=save&id=<?//$relation->getId();?>" class="ajax-call form-inline">
    <input type="hidden" value="<?=$test_id;?>" name="test_id"/>
		  <div class="panel panel-default">
  			<div class="panel-heading">Выберите корневой элемент структуры</div>
  			<div class="panel-body">
          <div class="form-group">
            <label for="">Корневой элемент:</label>
            <input type="hidden" value="<?=nvModel::TYPE_TPE;?>" name="type"/>
            <select id="filterSubActivity" name="code" class="form-control select select-primary select-block mbl">
              <?=nvHtml::options($tpes);?>
            </select>
          </div>
  			</div>
  		</div>
		<input type="submit" name="template" class="btn btn-primary btn-sm ajax-call" id="treetest-result-save" value="Сохранить">
	</form>
</div>