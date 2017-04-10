<?php if ( isset($_GET['session_id']) AND isset($_GET['box']) AND isset($_GET['query_type']) ) { session_id($_GET['session_id']); } else { exit; } ?>
<?php include ('../../tilpark.php'); ?>
<?php if ( !is_login() AND empty($_GET['box']) AND empty($_GET['query_type']) ) { exit; } ?>
<?php

	// get counts
	if ( $_GET['query_type'] == 'count' ) {
		if ( $_GET['box'] == 'task' ) { // count unread task
      echo get_calc_task();
    } elseif ( $_GET['box'] == 'message' ) { // count unread task
			 echo get_calc_message();
		} elseif ( $_GET['box'] == 'notification' ) { // count unread task
			echo get_calc_notification();
		}

	// get lists
	} else if ( $_GET['query_type'] == 'list' ) {



		// get message list
		if ( $_GET['box'] == 'message' ) : ?>
			<li class="message-header"><?php echo get_calc_message(); ?> okunmamış mesaj</li>

		  <?php if( $messages = get_messages(array('query'=>_get_query_message('inbox').' LIMIT 5')) ) : ?>
		    <?php foreach($messages as $message): ?>
		    <li class="message-list not-message-<?php echo $message->id; ?> <?php if(!$message->read_it and $message->inbox_u_id == get_active_user('id')): ?>bold<?php endif; ?>">
		      <a href="<?php site_url('admin/user/'. $_GET['box'] .'/detail.php?id='.$message->id); ?>">
		        <div class="row no-space">
		          <div class="col-md-2 col-xs-2">
		            <div class="message-avatar">
		              <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive center-block">
		            </div> <!-- /.message-avatar -->
		          </div> <!-- /.col-md-2 -->
		          <div class="col-md-10 col-xs-10">
		            <span class="message-name"><?php echo get_user_info($message->outbox_u_id, 'name'); ?> <?php echo get_user_info($message->outbox_u_id, 'surname'); ?></span>
		            <span class="message-time"><i class="fa fa-clock-o"></i> <?php echo get_time_late($message->date_update); ?> önce</span>
		            <?php if($q_select = db()->query("SELECT * FROM ".dbname('messages')." WHERE top_id='".$message->id."' ORDER BY date_update DESC LIMIT 1")) { if($q_select->num_rows) { $message->title = '-'.$q_select->fetch_object()->message; }}?>
		            <span class="message-title text-muted"><?php echo mb_substr(strip_tags(stripslashes($message->title)),0,40,'utf-8'); ?><?php if(strlen(strip_tags(stripslashes($message->title))) > 40) { echo '...'; } ?></span>
		          </div> <!-- /.col-md-10 -->
		        </div> <!-- /.row -->
		        </a>
		      </li>
		    <?php endforeach; ?>
		  <?php else: ?>
		    <div class="p-5">
		      <?php echo get_alert('Mesaj kutusu boş', 'warning', false); ?>
		    </div>
		  <?php endif; // if( $messages = get_messages(array('query'=>_get_query_message('inbox').' LIMIT 5')) ) ?>

			<li class="message-footer"><a href="<?php site_url('admin/user/'. $_GET['box'] .'/list.php'); ?>">Tümünü Göster</a></li>
		<?php endif; // if ( $_GET['box'] == 'message' )



		// get task list
		if ( $_GET['box'] == 'task' ) : ?>
			<li class="message-header"><?php echo get_calc_task(); ?> okunmamış görev</li>

		  <?php if( $messages = get_messages(array('query'=>_get_query_task('inbox').' LIMIT 5')) ) : ?>
		    <?php foreach($messages as $message): ?>
		    <li class="message-list not-task-<?php echo $message->id; ?> <?php if(!$message->read_it and $message->inbox_u_id == get_active_user('id')): ?>bold<?php endif; ?>">
		      <a href="<?php site_url('admin/user/'. $_GET['box'] .'/detail.php?id='.$message->id); ?>">
		        <div class="row no-space">
		          <div class="col-md-2 col-xs-2">
		            <div class="message-avatar">
		              <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive center-block">
		            </div> <!-- /.message-avatar -->
		          </div> <!-- /.col-md-2 -->
		          <div class="col-md-10 col-xs-10">
		            <span class="message-name"><?php echo get_user_info($message->outbox_u_id, 'name'); ?> <?php echo get_user_info($message->outbox_u_id, 'surname'); ?></span>
		            <span class="message-time"><i class="fa fa-clock-o"></i> <?php echo get_time_late($message->date_update); ?> önce</span>
		            <?php if($q_select = db()->query("SELECT * FROM ".dbname('messages')." WHERE top_id='".$message->id."' ORDER BY date_update DESC LIMIT 1")) { if($q_select->num_rows) { $message->title = '-'.$q_select->fetch_object()->message; }}?>
		            <span class="message-title text-muted"><?php echo mb_substr(strip_tags(stripslashes($message->title)),0,40,'utf-8'); ?><?php if(strlen(strip_tags(stripslashes($message->title))) > 40) { echo '...'; } ?></span>
		          </div> <!-- /.col-md-10 -->
		        </div> <!-- /.row -->
		        </a>
		      </li>
		    <?php endforeach; ?>
		  <?php else: ?>
		    <div class="p-5">
		      <?php echo get_alert('Görev kutusu boş', 'warning', false); ?>
		    </div>
		  <?php endif; // if( $messages = get_messages(array('query'=>_get_query_task('inbox').' LIMIT 5')) ) ?>

			<li class="message-footer"><a href="<?php site_url('admin/user/'. $_GET['box'] .'/list.php'); ?>">Tümünü Göster</a></li>
		<?php endif; // if ( $_GET['box'] == 'task' )

		// get global notification list
		if ( $_GET['box'] == 'notification' ) : ?>
			<li class="message-header">
				<?php echo get_calc_notification(); ?> okunmamış bildirim
				<span class="pull-right">
					<button onclick="notification_all_readit_button(this, parent(this, '.dropdown-message-list'))" style="border: 0; background: none; outline: none; padding-right: 15px;"><i class="fa fa-check"></i></button>
				</span>
			</li>

		  <?php if($messages = get_notifications()): ?>
		    <?php foreach($messages as $message): ?>
		    <li class="message-list notification-<?php echo $message->id; ?> <?php if(!$message->read_it): ?>bold<?php endif; ?>">
		      <a href="<?php echo $message->message; ?>" onclick="if (event.target.tagName != 'I') { set_notification(this, {'id': '<?php echo $message->id; ?>', 'read_it': '1', 'status': '1'}); } else { return false; } ">
		        <div class="row no-space">
		          <div class="col-md-2 col-xs-2">
		            <div class="message-avatar">
		              <i class="<?php if ( empty($message->writing) ) { echo 'fa fa-globe'; } else { echo $message->writing; } ?>" style="font-size: 25px;"></i>
		            </div> <!-- /.message-avatar -->
		          </div> <!-- /.col-md-2 -->
		          <div class="col-md-10 col-xs-10">
		            <span class="message-time">
									<i class="fa fa-clock-o"></i> <?php echo get_time_late($message->date_update); ?> önce

									<button
										style="border: 0; background: none !important; outline: none;"
										read-it="<?php echo $message->read_it; ?>"
										data-wenk="<?php if ( $message->read_it ) { echo 'okunmadı'; } else { echo 'okundu'; } ?>"
										data-wenk-pos="left"
										onclick="if ( this.getAttribute('read-it') == '1' ) { var read_it = '0'; } else { var read_it = '1'; } set_notification(this, {'id': '<?php echo $message->id; ?>', 'read_it': read_it, 'status': '1'}); return false;"
										onchange="notification_readit_button(this)" >

										<i class="text-muted fa fa-circle<?php if($message->read_it): ?>-o<?php endif; ?>"></i>
									</button>

									<button style="border: 0; background: none !important; outline: none;" data-wenk="Gizle" data-wenk-pos="top" onclick="set_notification(this, {'id': '<?php echo $message->id; ?>', 'read_it': '1', 'status': '0'}); return false;" onchange="notification_delete_button(this)">
										<i class="fa fa-times text-muted"></i>
									</button>
								</span>
		            <?php if($q_select = db()->query("SELECT * FROM ".dbname('messages')." WHERE top_id='".$message->id."' ORDER BY date_update DESC LIMIT 1")) { if($q_select->num_rows) { $message->title = '-'.$q_select->fetch_object()->message; }}?>
		            <span class="message-title text-muted"><?php echo mb_substr(strip_tags(stripslashes($message->title)),0,40,'utf-8'); ?><?php if(strlen(strip_tags(stripslashes($message->title))) > 40) { echo '...'; } ?></span>
		          </div> <!-- /.col-md-10 -->
		        </div> <!-- /.row -->
		        </a>
		      </li>
		    <?php endforeach; ?>
		  <?php else: ?>
		    <div class="p-5">
		      <?php echo get_alert('Bildirim Kutusu Boş', 'warning', false); ?>
		    </div>
		  <?php endif; ?>

		  <?php if ( !til_is_mobile() ): ?><li class="message-footer"><a href="<?php site_url('admin/user/'. $_GET['box'] .'/list.php'); ?>">Tümünü Göster</a></li><?php endif; ?>
		<?php endif;
	} else { exit; }
?>
