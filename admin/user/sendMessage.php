<?php if ( isset($_GET['session_id']) AND isset($_GET['type']) ) { session_id($_GET['session_id']); } else { exit; } ?>
<?php include ('../../tilpark.php'); ?>
<?php if ( !is_login() ) { exit; } ?>
<?php
  if ( isset($_POST['message']) ) {
    if ( strlen(trim(preg_replace("/[^ \w]+/", "", strip_tags(html_entity_decode($_POST['message']), '<img>')))) >= 1 ) {
      $_message['message']    = $_POST['message'];
      $_message['top_id']     = $_POST['top_id'];

      if ( $_GET['type'] == 'task' ) {
      	if ( add_task_message($_POST['task_id'], $_message) ) {
	        echo 'true';
	      } else { return false; }
      } elseif ( $_GET['type'] == 'message' ) {
      	if ( add_message($_POST['receiver'], $_message) ) {
	        echo 'true';
	      } else { return false; }
      } else { return false; }
    } else { return false; }
  } else { return false; }
?>
