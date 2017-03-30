<?php if ( isset($_GET['session_id']) AND isset($_GET['top_id']) ) { session_id($_GET['session_id']); } else { exit; } ?>
<?php include ('../../tilpark.php');

if ( is_login() ) {
  if ( isset($_GET['set_value']) AND isset($_GET['receiver']) ) {
    if ( $q_select = get_message($_GET['top_id']) ) {
      if ( $q_select->sen_u_id == get_active_user('id') OR $q_select->rec_u_id == get_active_user('id') ) {
        if ( !empty($q_select->writing) ) {
          if ( $data = json_decode($q_select->writing) ) {
            foreach ($data as $key => $value) {
              if ( $key == "user_".get_active_user('id') ) {
                $data->$key = array( 'writing_status' => $_GET['set_value'] );
              }
            } // end foreach

            if ( $data = json_encode_utf8($data) ) {
              if ( db()->query("UPDATE ". dbname('messages') ." SET writing='". $data ."'  WHERE id='". $_GET['top_id'] ."' ") ) {
                if ( db()->affected_rows ) {
                  echo 'true';
                } else { return false; }
              } else { return false; }
            } else { return false; }
          } else { return false; }
        } else {
          $data = array(
            "user_".get_active_user('id')   => array( 'writing_status' => $_GET['set_value'] ),
            "user_".$_GET['receiver']       => array( 'writing_status' => '0' )
          );

          if ( $data = json_encode_utf8($data) ) {
            if ( db()->query("UPDATE ". dbname('messages') ." SET writing='". $data ."' WHERE id='". $_GET['top_id'] ."' ") ) {
              if ( db()->affected_rows ) {
                echo 'true';
              } else { return false; }
            } else { return false; }
          } else { return false; }
        } // if ( !empty($q_select->writing) )
      } else { return false; }
    } else { return false; }
  } elseif ( isset($_GET['get']) ) {
    if ( $q_select = get_message($_GET['top_id']) ) {
      if ( $data = json_decode($q_select->writing) ) {
        foreach ($data as $key => $value) {
          if ( $key != 'user_'.get_active_user('id') ) {
            echo $value->writing_status;
          } // is receiver
        } // end foreach
      } else { return flase; }
    } else { return false; }
  } elseif ( isset($_GET['clear_writing']) AND isset($_GET['receiver']) ) {
    if ( $q_select = get_message($_GET['top_id']) ) {
      if ( $q_select->sen_u_id == get_active_user('id') OR $q_select->rec_u_id == get_active_user('id') ) {
        if ( !empty($q_select->writing) ) {
          if ( $data = json_decode($q_select->writing) ) {
            foreach ($data as $key => $value) {
              $data->$key = array( 'writing_status' => '0');
            } // end foreach

            if ( $data = json_encode_utf8($data) ) {
              if ( db()->query("UPDATE ". dbname('messages') ." SET writing='". $data ."'  WHERE id='". $_GET['top_id'] ."' ") ) {
                if ( db()->affected_rows ) {
                  echo 'true';
                } else { return false; }
              } else { return false; }
            } else { return false; }
          } else { return false; }
        }  else { return false; }
      } else { return false; }
    } else { return false; }
  } else { return false; }
} else { return false; }
