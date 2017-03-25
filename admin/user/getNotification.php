<?php if ( isset($_GET['session_id']) AND isset($_GET['box']) AND isset($_GET['query_type']) ) { session_id($_GET['session_id']); } else { exit; } ?>
<?php include ('../../tilpark.php'); ?>
<?php if ( !is_login() AND empty($_GET['box']) AND empty($_GET['query_type']) ) { exit; } ?>
<?php  
	if ( $_GET['query_type'] == 'count' ) {
		if ( $_GET['box'] == 'task' ) {
      echo get_calc_task();
    } else { echo get_calc_message(); }

	} else if ( $_GET['query_type'] == 'list' ) {
		if ( $_GET['box'] == 'message' ) {
		 $get_query = _get_query_message('inbox').' LIMIT 5'; 
		 $calc = get_calc_message();
     $alert = "Mesaj kutusu boş";
		}

		if ( $_GET['box'] == 'task' ) {
			$get_query = _get_query_task('inbox').' LIMIT 5';
			$calc = get_calc_task();
      $alert = "Görev Kutusu Boş";
		}
		?>
		<li class="message-header"><?php echo $calc; ?> okunmamış mesaj</li>
    <?php if($messages = get_messages(array('query'=>$get_query))): ?>
      <?php foreach($messages as $message): ?>
      <li class="message-list <?php if(!$message->read_it and $message->inbox_u_id == get_active_user('id')): ?>bold<?php endif; ?>">
        <a href="<?php site_url('admin/user/'. $_GET['box'] .'/detail.php?id='.$message->id); ?>">
          <div class="row no-space">
            <div class="col-md-2">
              <div class="message-avatar">
                <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive center-block">
              </div> <!-- /.message-avatar -->
            </div> <!-- /.col-md-2 -->
            <div class="col-md-10">
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
        <?php echo get_alert($alert, 'warning', false); ?>
      </div>
    <?php endif; ?>

    <li class="message-footer"><a href="<?php site_url('admin/user/'. $_GET['box'] .'/list.php'); ?>">Tüm mesajlar</a></li>
    <?php
	} else { exit; }
?>
