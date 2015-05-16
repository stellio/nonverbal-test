<div class="container-fluid wrap nv-header">
	<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-inverse navbar-embossed" role="navigation">
	            <div class="collapse navbar-collapse" id="navbar-collapse-01">
	              <ul class="nav navbar-nav navbar-left">
	              	<li><a class="ajax-call" href="admin.php?page=NV&module=nvTest&call=edit&id=<?=$id;?>">Общие</a></li>
			        <li><a class="ajax-call" href="admin.php?page=NV&module=nvSign&test_id=<?=$id;?>">Признаки</a></li>
			        <li><a class="ajax-call" href="admin.php?page=NV&module=nvTpe&test_id=<?=$id;?>">ТПЭ (Квадры)</a></li>
			        <li><a class="ajax-call" href="admin.php?page=NV&module=nvProfile&test_id=<?=$id;?>">Профили</a></li>
			        <li><a class="ajax-call" href="admin.php?page=NV&module=nvRelation&test_id=<?=$id;?>">Связь</a></li>
			        <li><a class="ajax-call" href="admin.php?page=NV&module=nvQuestion&test_id=<?=$id;?>">Вопросы</a></li>
			        <li><a class="ajax-call" href="admin.php?page=NV&module=nvResult&test_id=<?=$id;?>">Результаты</a></li>
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

