<?php 
	
	function buildTree($items, $test) {

		?>

		</p><div class='row'>
					
		<?php

		if (is_array($items)) {

		foreach ($items as $item) { ?>
							
			<div class="col-md-6 text-center">
					<!-- <div style="border: 3px solid green; display: inline;"> -->
						<div class="btn-group">
						  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
						   		<?=$item->code;?>
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu dropdown-menu-inverse" role="menu">
						    <li><a class="ajax-call" href="admin.php?page=NV&module=nvRelation&call=add_element&test_id=<?=$test->getId();?>&item_id=<?=$item->id;?>">Добавить элемент</a></li>
						    <li class="divider"></li>
						    <li><a class="ajax-call" href="admin.php?page=NV&module=nvRelation&call=delete&test_id=<?=$test->getId();?>&item_id=<?=$item->id;?>">Удалить</a></li>
						  </ul>
						</div>
						<?php buildTree($item->childs, $test); ?>
  			</div>

  		<?php }

  		}
  		 ?>

  		</div>

  		<?php
	}

?>


<div>
      <?=nvHtml::button(array(
                'module' => 'nvRelation',
                'call' => 'add',
                'test_id' => $test->getId(),
             ),
            "Добавить структуру",
            'ajax-call btn btn-primary btn-sm'
        );?>
		
		</p>
		<?php
			// echo "<pre>";
			// print_r($structures);
			// echo "</pre>";
		?>
		<?php foreach ($structures as $structure) { ?>
			<div class="panel panel-default">
	  			<div class="panel-heading">Корень структуры, ТПЭ: <b><?=$structure->code;?></b></div>
  				<div class="panel-body">
					<div class="row">
	  						<div class="col-md-12 text-center">
								<div class="btn-group">
									  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
									   		<?=$structure->code;?>
									    <span class="caret"></span>
									  </button>
									  <ul class="dropdown-menu dropdown-menu-inverse" role="menu">
									    <li><a class="ajax-call" href="admin.php?page=NV&module=nvRelation&call=add_element&test_id=<?=$test->getId();?>&item_id=<?=$structure->id;?>">Добавить элемент</a></li>
									    <li class="divider"></li>
									    <li><a class="ajax-call" href="admin.php?page=NV&module=nvRelation&call=delete&test_id=<?=$test->getId();?>&item_id=<?=$structure->id;?>">Удалить</a></li>
									  </ul>
									</div>
								
	  						</div>
	  				</div>
	  				<?php

	  					buildTree($structure->childs, $test);
					?>	
  				</div>
    		</div>	
		<?php } ?>
</div>