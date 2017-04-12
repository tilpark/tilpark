<?php
/*
| -----------------------------------------------------------------------------
| Notification
| -----------------------------------------------------------------------------
| Bildirim işlemleri için gerekli fonsiyonlar
|
| -----------------------------------------------------------------------------
| Fonksiyonlar
| -----------------------------------------------------------------------------
|
| * add_notification()
| * update_notification()
| * get_notification()
| * get_notifications()
|
*/







/**
 * @func add_notification()
 * @desc  bildirim ekler
 * @param array()
 * @return string(insert_id) / false
 */
function add_notification($args=array()) {
  $args   = _args_helper(input_check($args), 'insert');
  $insert = $args['insert'];

  $insert['date']         = date('Y-m-d H:i:s');
  $insert['status']       = '1';
  $insert['type']         = 'notification';
  $insert['top_id']       = '0';
  $insert['sen_u_id']     = @$insert['sen_u_id'];
  $insert['rec_u_id']     = @$insert['rec_u_id'];
  $insert['title']        = strip_tags($insert['title']);
  $insert['message']      = strip_tags(@$insert['message']);
  $insert['read_it']      = '0';
  $insert['date_update']  = date('Y-m-d H:i:s');
  $insert['date_start']   = date('Y-m-d H:i:s');
  $insert['date_end']     = date('Y-m-d H:i:s');
  $insert['choice']       = @$insert['choice'];
  $insert['type_status']  = '';
  $insert['writing']      = @$insert['writing'];


  // input ve db kontrolleri
  if ( !filter_var($insert['message'], FILTER_VALIDATE_URL) ) {
    add_alert('Girilen değer doğru bir bağlantı değil!', 'danger', __FUNCTION__);
    return false;
  }

  if ( !get_user($insert['rec_u_id']) ) {
    add_alert('Kullanıcı bulunamadı', 'danger', __FUNCTION__);
    return false;
  }

  if ( !empty($insert['sen_u_id']) ) {
    if ( !get_user($insert['send_u_id']) ) {
      add_alert('Kullanıcı bulunamadı', 'danger', __FUNCTION__);
      return false;
    }
  }
  //. input ve db kontrolleri


  if ( !is_alert(__FUNCTION__) ) {
    if ( db()->query("INSERT INTO ". dbname('messages') ." ". sql_insert_string($insert)) ) {
      if ( $insert_id = db()->insert_id ) {

        return $insert_id;
      } else { return false; }
    } else { add_mysqli_error_log(__FUNCTION__); }
  } else { return fasle;  }
} //.add_notification()








/**
 * @func update_notification()
 * @desc bildirim satırını günceller
 * @param string(id), array()
 * @return true / false
 */
function update_notification($notification_id="", $args=array()) {
  $args     = _args_helper(input_check($args), 'update');
  $q_update = $args['update'];


  if ( $q_select = db()->query("SELECT * FROM ". dbname('messages') ." WHERE type='notification' AND id='". $notification_id ."' ") ) {
    if ( $q_select->num_rows ) {
      $query = $q_select->fetch_object();

      $update['date']         = $query->date;
      $update['status']       = @$q_update['status'];
      $update['type']         = 'notification';
      $update['read_it']      = @$q_update['read_it'];
      $update['top_id']       = '0';
      $update['sen_u_id']     = $query->sen_u_id;
      $update['rec_u_id']     = $query->rec_u_id;
      $update['title']        = $query->title;
      $update['message']      = $query->message;
      $update['date_start']   = date('Y-m-d H:i:s');
      $update['date_end']     = date('Y-m-d H:i:s');
      $update['type_status']  = '';


      // input ve db kontrolleri
      if ( empty($update['read_it']) ) {
        $update['read_it'] = '0';
      }

      if ( !in_array($update['read_it'], array('1', '0')) ) {

        add_alert('Geçersiz değer!', 'danger', __FUNCTION__);
        return false;
      }

      if ( empty($update['rec_u_id']) ) {
        $update['rec_u_id'] = $query->rec_u_id;
      } else {
        if ( !get_user($update['rec_u_id']) ) {
          add_alert('Kullanıcı Bulunamadı!', 'danger', __FUNCTION__);
          return false;
        }
      }

      if ( !is_alert(__FUNCTION__) ) {
        if ( db()->query("UPDATE ". dbname('messages') ." SET  ". sql_update_string($update) ." WHERE id='$notification_id' ") ) {
          if ( db()->affected_rows ) {
            return true;
          } else { return false; }
        } else { add_mysqli_error_log(__FUNCTION__); }
      } else { return false; }
    } else { return false; }
  } else { add_mysqli_error_log(__FUNCTION__); }
} //.update_notification()








/**
 * @func get_notification()
 * @desc gerekli bilgeri verilen son bildirimin bilgilerini verir
 * @param array()
 * @return object / false
 */
function get_notification($args=array()) {
  $args  = _args_helper(input_check($args), 'where');
  $where = $args['where'];

  $where['type'] = 'notification';

  // query
  if ( $q_select = db()->query("SELECT * FROM ". dbname('messages') ." ". sql_where_string($where) . " ORDER BY id DESC LIMIT 1") ) {
    if ( $q_select->num_rows ) {

      return $q_select->fetch_object();
    } else { return false; }
  } else { add_mysqli_error_log(__FUNCTION__); }
} //.get_notification()






/**
 * @func get_calc_notification()
 * @desc mesajlarin toplamını hesaplar
 * @param array()
 * @return string
 */
function get_calc_notification($args=array()) {
	$args = input_check($args);

	# gerekli
	$args['type']	    = 'notification';
  $args['rec_u_id'] = get_active_user('id');

	# eger okundu ve okunmadi belirtirlmemis ise sadece okunmamis mesajlari hesaplayalim
	if(!isset($args['read_it'])) { $args['read_it'] = '0'; }


	if($q_select = db()->query("SELECT * FROM ".dbname('messages')." ".sql_where_string($args)." ")) {
		return $q_select->num_rows;
	} else { add_mysqli_error_log(__FUNCTION__); }
} //.get_calc_notification()







/**
 * @func get_notifications()
 * @desc notofication listesi verir
 * @param array()
 * @return object[object]
 */
function get_notifications($args=array()) {
  $args  = _args_helper(input_check($args), 'where');
  $where = $args['where'];

  $where['rec_u_id']   = get_active_user('id');
  $permissions = array('rec_u_id', 'date', 'sen_u_id', 'date_start', 'date_end');

  foreach ($where as $key => $value) {
    if ( !in_array($key, $permissions) ) {
      add_alert('Geçersiz Değer!');
      return false;
    }
  }

  $where['type']       = 'notification';
  $where['status']     = '1';
  $args['limit']      = '9';
  if ( til_is_mobile() ) { $args['limit'] = '20'; }

  if ( !is_alert(__FUNCTION__) ) {
    if ( $q_select = db_query_list_return(db()->query("SELECT * FROM ". dbname('messages') ." ". sql_where_string($where) ." ORDER BY read_it ASC, date DESC, id DESC LIMIT ". $args['limit'] ." ")) ) {
      if ( is_array($q_select) OR is_object($q_select) ) {

        return $q_select;
      } else { return false; }
    } else { return false; }
  } else { return false; }
} //.get_notifications()
