<div class="container-fluid wrap nv-header">
	<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-inverse navbar-embossed" role="navigation">
	            <div class="collapse navbar-collapse" id="navbar-collapse-01">
	              <ul class="nav navbar-nav navbar-left">
	              	<li>
	              		<div class="btn-group btn">
	              			<button class="ajax-call btn btn-primary" href="admin.php?page=NV&module=nvTestParam&call=edit&id=<?=$id;?>">Общие</button>	
	              		</div>
	              	</li>
			        <li>
						<div class="btn-group btn">
		                    <button href="admin.php?page=NV&module=nvSign&test_id=<?=$id;?>" class="btn btn-primary ajax-call">Признаки</button>
		                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>	
		                    <ul class="dropdown-menu">
		                      <li><a class="ajax-call" href="admin.php?page=NV&module=nvSign&call=edit&test_id=<?=$id;?>&type=1">Добавить ТПЭ приз.</a></li>
		                      <li><a class="ajax-call" href="admin.php?page=NV&module=nvSign&call=edit&test_id=<?=$id;?>&type=2">Добавить Функц. приз.</a></li>
		                    </ul>
		                 </div>
			        </li>
			        <li>
						<div class="btn-group btn">
		                    <button href="admin.php?page=NV&module=nvTpe&test_id=<?=$id;?>" class="btn btn-primary ajax-call">ТПЭ (Квадры)</button>
		                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>	
		                    <ul class="dropdown-menu">
		                      <li><a class="ajax-call" href="admin.php?page=NV&module=nvTpe&call=edit&test_id=<?=$id;?>">Добавить</a></li>
		                    </ul>
		                 </div>
			        </li>
			        <li>
						<div class="btn-group btn">
		                    <button href="admin.php?page=NV&module=nvTpe&test_id=<?=$id;?>" class="btn btn-primary ajax-call">Профили</button>
		                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>	
		                    <ul class="dropdown-menu">
		                      <li><a class="ajax-call" href="admin.php?page=NV&module=nvProfile&call=edit&test_id=<?=$id;?>&type=1">Добавить ТПЭ проф.</a></li>
		                      <li><a class="ajax-call" href="admin.php?page=NV&module=nvProfile&call=edit&test_id=<?=$id;?>&type=2">Добавить Функц. проф.</a></li>
		                    </ul>
		                 </div>
			        </li>
			        <li>
						<div class="btn-group btn">
		                    <button href="admin.php?page=NV&module=nvRelation&test_id=<?=$id;?>" class="btn btn-primary ajax-call">Связь</button>
		                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>	
		                    <ul class="dropdown-menu">
		                      <li><a class="ajax-call" href="admin.php?page=NV&module=nvRelation&call=add&test_id=<?=$id;?>">Добавить структуру</a></li>
		                    </ul>
		                 </div>
			        </li>
			        <li>
						<div class="btn-group btn">
		                    <button href="admin.php?page=NV&module=nvQuestion&test_id=<?=$id;?>" class="btn btn-primary ajax-call">Вопросы</button>
		                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>	
		                    <ul class="dropdown-menu">
		                      <li><a class="ajax-call" href="admin.php?page=NV&module=nvQuestion&call=add&test_id=<?=$id;?>">Добавить</a></li>
		                    </ul>
		                 </div>
			        </li>
			        <li>
						<div class="btn-group btn">
		                    <button href="admin.php?page=NV&module=nvResult&test_id=<?=$id;?>" class="btn btn-primary ajax-call">Результаты</button>
		                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>	
		                    <ul class="dropdown-menu">
		                      <li><a class="ajax-call" href="admin.php?page=NV&module=nvResult&call=add&test_id=<?=$id;?>">Добавить</a></li>
		                    </ul>
	                 	</div>
			        </li>
			        <!--
			        <li>
			        	<div class="btn-group btn">
	              			<button class="ajax-call btn btn-primary" href="admin.php?page=NV&module=nvStatistic&test_id=<?//=$id;?>">Статистика</button>	
	              		</div>
			        </li>
			        -->
	               </ul>
	            </div><!-- /.navbar-collapse -->
	        </nav><!-- /navbar -->
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="nv-content">
				<?=$content;?>
			</div>
		</div>
	</div>	
</div>

