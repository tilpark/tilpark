<?php if ( isset($_GET['session_id']) AND isset($_GET['get_message']) AND isset($_GET['query_message']) AND isset($_GET['type']) ) { session_id($_GET['session_id']); } else { exit; } ?>
<?php include ('../../tilpark.php'); ?>
<?php if ( !is_login() AND empty($_GET['get_message']) AND empty($_GET['query_message']) AND empty($_GET['type']) ) { exit; }
if ( $_GET['get_message'] == "old" AND isset($_GET['list_old_message']) ) {
  if ( $get_message = get_message($_GET['list_old_message'], array('type' => $_GET['type'])) ) :
  if ( $_GET['type'] == 'mess-reply' ) { $or_type = 'message'; } elseif ( $_GET['type'] == 'task-reply' ) { $or_type = 'task'; }
  $get_query = " (type='". $_GET['type'] ."' OR type='". $or_type ."') AND (rec_u_id = '". get_active_user('id') ."' OR sen_u_id = '". get_active_user('id') ."' ) AND (top_id='". $_GET['query_message'] ."' OR id='". $_GET['query_message'] ."') AND (date <= '". $get_message->date ."' AND id < '". $_GET['list_old_message'] ."') ORDER BY date DESC, id DESC LIMIT 4";

  if( $messages = array_reverse(get_messages(array('query'=>$get_query))) ): ?>
    <?php foreach( $messages as $message ): ?>
      <div class="message-elem  message-<?php echo $message->id; ?> <?php if ( $message->rec_u_id == get_active_user('id') ) { echo 'get'; } else { echo 'send'; } ?>" id="<?php echo $message->id; ?>" title="<?php echo $message->title; ?>" username="<?php echo get_user_info($message->sen_u_id, 'name'); ?> <?php echo get_user_info($message->sen_u_id, 'surname'); ?>">
        <div class="message-elem-container">
          <?php if(get_active_user('id') != $message->sen_u_id): ?>
              <div class="message-elem-avatar pull-left">
                <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-right" width="48">
              </div><!--/ .message-elem-avatar /-->
          <?php endif; ?>

          <div class="message-elem-content">
            <div class="well padding-10 br-3">
              <div class="text-muted fs-11 italic">
                <span class="bold username"><?php echo get_user_info($message->sen_u_id, 'name'); ?> <?php echo get_user_info($message->sen_u_id, 'surname'); ?></span> <span class="inform-text">tarafından</span> <span class="bold date-tooltip" <?php if ( til_is_mobile() ) { echo 'data-wenk-pos="left"'; } ?> data-wenk="<?php echo substr($message->date,0,16); ?>" title="<?php echo substr($message->date,0,16); ?>"><?php echo get_time_late($message->date); ?></span> <span class="inform-text">önce gönderildi.</span>
                <span class="pull-right">#<?php echo $message->id; ?></span>
              </div><!--/ .text-muted /-->
              <?php echo $message->message; ?>
            </div><!--/ .well /-->
            <div class="h-10"></div>
          </div><!-- /.col-md-11.col-xs-9 /-->

          <?php if(get_active_user('id') == $message->sen_u_id): ?>
            <div class="message-elem-avatar pull-right">
              <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-right" width="48">
            </div><!--/ .message-elem-avatar /-->
          <?php endif; ?>
        </div><!-- /.message-elem-container /-->
      </div><!--/ .message-elem /-->
    <?php endforeach; ?>
  <?php endif; ?>
<?php endif;
} elseif ( $_GET['get_message'] == "new" AND isset($_GET['last_view_message']) AND isset($_GET['type']) ) {
  $get_query = "type='". $_GET['type'] ."' AND id > '". $_GET['last_view_message'] ."' AND top_id='". $_GET['query_message'] ."' ORDER BY date_update DESC, id DESC LIMIT 10";

  if ( $messages = get_messages(array('query'=>$get_query))): ?>
    <?php foreach($messages as $message): ?>
      <?php if ( $message->rec_u_id == get_active_user('id') ) { db()->query("UPDATE ".dbname('messages')." SET read_it='1' WHERE id='".$message->top_id."' "); } ?>
      <div class="message-elem  message-<?php echo $message->id; ?> <?php if ( $message->sen_u_id == get_active_user('id') ) { echo 'send'; } else { echo 'get'; } ?>" id="<?php echo $message->id; ?>" title="<?php echo $message->title; ?>" username="<?php echo get_user_info($message->sen_u_id, 'name'); ?> <?php echo get_user_info($message->sen_u_id, 'surname'); ?>">
        <div class="message-elem-container">
          <?php if(get_active_user('id') != $message->sen_u_id): ?>
              <div class="message-elem-avatar pull-left">
                <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-right" width="48">
              </div><!--/ .message-elem-avatar /-->
          <?php endif; ?>

          <div class="message-elem-content">
            <div class="well padding-10 br-3">
              <div class="text-muted fs-11 italic">
                <span class="bold username"><?php echo get_user_info($message->sen_u_id, 'name'); ?> <?php echo get_user_info($message->sen_u_id, 'surname'); ?></span> <span class="inform-text">tarafından</span> <span class="bold date-tooltip" <?php if ( til_is_mobile() ) { echo 'data-wenk-pos="left"'; } ?> data-wenk="<?php echo substr($message->date,0,16); ?>" title="<?php echo substr($message->date,0,16); ?>"><?php echo get_time_late($message->date); ?></span> <span class="inform-text">önce gönderildi.</span>
              </div><!--/ .text-muted /-->
              <?php echo $message->message; ?>
            </div><!--/ .well /-->
            <div class="h-10"></div>
          </div><!-- /.col-md-11.col-xs-9 /-->

          <?php if(get_active_user('id') == $message->sen_u_id): ?>
            <div class="message-elem-avatar pull-right">
              <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-right" width="48">
            </div><!--/ .message-elem-avatar /-->
          <?php endif; ?>
        </div><!-- /.message-elem-container /-->
      </div><!--/ .message-elem /-->
    <?php endforeach; ?>
  <?php endif;
 } else { return false; }
?>
