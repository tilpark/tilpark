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

		<div class="list-group">
		<hr style="margin: 10px 0;">
			<?php
				if ( $q_select = db_query_list_return(db()->query("SELECT * FROM ". dbname('messages') ." WHERE top_id='0' AND type='message' AND (sen_u_id='". get_active_user('id') ."' OR rec_u_id='". get_active_user('id') ."') ") )) {
					foreach ($q_select as $key => $rows) {

						if ( $rows->inbox_u_id == get_active_user('id') ) $user_id = $rows->outbox_u_id;
						if ( $rows->outbox_u_id == get_active_user('id') ) $user_id = $rows->inbox_u_id;
						?>
						<a href="<?php echo get_site_url('admin/user/message/detail.php?id='.$rows->id) ?>">
							<div class="row space-5">
								<div class="col-md-2">
									<img src="<?php echo get_user_info($user_id, 'avatar'); ?>" class="img-responsive img-circle">
								</div>

								<div class="col-md-10">
									<div><b><?php echo get_user_info($user_id, 'name'); ?> <?php echo get_user_info($user_id, 'surname'); ?></b></div>
									<span><?php echo get_user_role_text(get_user_info($user_id, 'role')); ?></span>
								</div>
							</div>
						</a>
						<hr style="margin: 10px 0;">
						<?php
					}
				} else { add_mysqli_error_log(); }
			?>
		</div>
	</div> <!-- /.panel-body -->
</div> <!-- /.panel -->