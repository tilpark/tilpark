<div class="panel panel-default panel-sidebar">
	<div class="panel-body">
		<div class="text-left">
			<a href="add.php" class="btn btn-default btn-block"><i class="fa fa-pencil-square-o"></i> Yeni Mesaj</a>
		</div>
		<div class="clearfix"></div>
		<div class="h-20"></div>
		<div class="list-group list-group-messagebox">
			<!-- inbox -->
		  	<a href="list.php?box=inbox" class="list-group-item <?php echo $box == 'inbox' ? 'active' : ''; ?>"><i class="fa fa-mail-forward fa-fw"></i> Gelen Kutusu</a>
		  		<a href="list.php?box=inbox&read_it=0" class="list-group-item list-group-item-sub <?php echo @$read_it == '0' ? 'active' : ''; ?>"><i class="fa fa-angle-double-right"></i> Okunmamış <span class="badge"><?php echo get_calc_message(array('query'=>_get_query_message('inbox-unread'))); ?></span></a>
		  		<a href="list.php?box=inbox&read_it=1" class="list-group-item list-group-item-sub <?php echo @$read_it == '1' ? 'active' : ''; ?>"><i class="fa fa-angle-double-right"></i> Okunmuş <span class="badge"><?php echo get_calc_message(array('query'=>_get_query_message('inbox-read'))); ?></span></a>
		  	<!-- outbox -->
		  	<a href="list.php?box=outbox" class="list-group-item <?php echo $box == 'outbox' ? 'active' : ''; ?>"><i class="fa fa-mail-reply fa-fw"></i> Giden Kutusu <span class="badge"><?php echo get_calc_message(array('query'=>_get_query_message('outbox'))); ?></span></a>
		  	<!-- trash -->
		  	<a href="list.php?box=trash" class="list-group-item <?php echo $box == 'trash' ? 'active' : ''; ?>"><i class="fa fa-trash-o fa-fw"></i> Çöp Kutusu <span class="badge"><?php echo get_calc_message(array('query'=>_get_query_message('trash'))); ?></span></a>
		</div>
	</div> <!-- /.panel-body -->
</div> <!-- /.panel -->