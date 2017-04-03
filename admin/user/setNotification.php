<?php if ( isset($_GET['session_id']) AND isset($_GET['args']) ) { session_id($_GET['session_id']); } else { exit; } ?>
<?php include ('../../tilpark.php'); ?>
<?php if ( is_login() ) {
  $args = (array) json_decode(stripcslashes($_GET['args']));

  if ( isset($args['id']) ) {
    if ( $q_select = get_notification(array('id' => $args['id'])) ) {
      if ( $q_select->rec_u_id == get_active_user('id') ) {
        $_update['status']  = $args['status'];
        $_update['read_it'] = $args['read_it'];

        if ( update_notification($args['id'], $_update) ) {
          if ( $q_select = get_notification(array('id' => $args['id'])) ) {
            $callback['read_it']  = $q_select->read_it;
            $callback['status']   = $q_select->status;

            echo json_encode_utf8($callback);
          } else { return false; }
        } else { return false; }
      } else { return false; }
    } else { return false; }
  } else { return false; }
} else { return false; }
?>
