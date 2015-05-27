<div>
	<form method="post" class="ajax-call" action="admin.php?page=NV&module=nvTestParam&call=save&id=<?=$test->getId();?>">
			<div class="panel panel-default">
  				<div class="panel-heading">
  					<h3 class="panel-title">Название</h3>
  				</div>
  				<div class="panel-body">
    					<input name="name" id="treetest-test-name" type="text" class="form-control" value="<?=$test->getName();?>">
  				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Описание</h3>
				</div>
				<div class="panel-body">
					<?php
						wp_editor($test->getDescription(), "text", array('textarea_rows' => 5, 'quicktags' => false));
					?>
				</div>
			</div>

		<input type="submit" name="template" class="btn btn-info" id="treetest-save-test" value="Сохранить">
	</form>
</div>