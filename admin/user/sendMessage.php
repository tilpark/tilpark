<?php if ( isset($_GET['session_id']) ) { session_id($_GET['session_id']); } else { exit; } ?>
<?php include ('../../tilpark.php'); ?>
<?php if ( !is_login() ) { exit; } ?>
<?php
  if ( isset($_POST['message']) ) {
    if ( strlen(trim(preg_replace("/[^ \w]+/", "", strip_tags(html_entity_decode($_POST['message']))))) >= 3 ) {
      $_message['message']    = $_POST['message'];
      $_message['top_id']     = $_POST['top_id'];

      if ( $insert_id = add_message($_POST['receiver'], $_message) ) {
        if ( $message = get_message($insert_id, array('type' => 'mess-reply')) ) {
          ?> 
          <div class="row space-5 message-<?php echo $message->id; ?>" id="<?php echo $message->id; ?>">
            <?php if(get_active_user('id') != $message->sen_u_id): ?>
              <div class="col-md-1">
                <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-right" width="48">
              </div> <!-- /.col-md-1 -->
            <?php endif; ?>

            <div class="col-md-11">
              <div class="well padding-10 br-3">
                <div class="text-muted fs-11 italic">
                  <span class="bold"><?php echo get_user_info($message->sen_u_id, 'name'); ?> <?php echo get_user_info($message->sen_u_id, 'surname'); ?></span> tarafından <span class="bold" data-toggle="tooltip" title="<?php echo substr($message->date,0,16); ?>"><?php echo get_time_late($message->date); ?></span> önce gönderildi.
                </div>
                <?php echo $message->message; ?>
              </div><!--/ .well /-->
              <div class="h-10"></div>
            </div> <!-- /.col-md-11 -->

            <?php if(get_active_user('id') == $message->sen_u_id): ?>
              <div class="col-md-1">
                <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-left" width="48">
              </div> <!-- /.col-md-1 -->
            <?php endif; ?>
          </div> <!-- /.row -->
          <?php
        } else { return false; }
      } else { return false; }
    } else { return false; }
  } else { return false; }
?>
