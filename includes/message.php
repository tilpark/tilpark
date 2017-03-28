<?php
/*
| -----------------------------------------------------------------------------
| Message
| -----------------------------------------------------------------------------
| Mesaj işlemleri icin gerekli fonksiyonlar
|
| -----------------------------------------------------------------------------
| Fonksiyonlar
| -----------------------------------------------------------------------------
|
| * add_message()
| * get_message()
| * get_messages()
| * get_message_detail()
| * get_calc_message()
| * get_codex_list_template()
| * set_codex_page()
| * _get_query_message()
|
*/








/**
 * @func add_message()
 * @desc yeni bir mesaj olusturur
 * @param string, array()
 * @return string(insert_id)
 */
function add_message($rec_u_id, $args=array()) {
	$rec_u_id = input_check($rec_u_id);
	$args 	= _args_helper(input_check($args), 'insert');
	$insert = $args['insert'];

	$insert['message'] = editor_strip_tags($insert['message']);
	@form_validation(strip_tags($insert['message'], '<img>'), 'message', 'Mesaj', 'required|min_lenght[3]', __FUNCTION__);
	if(!$rec_user = get_user($rec_u_id)) { add_alert('Mesaj gönderilecek kullanıcı bulunamadı.', 'danger', __FUNCTION__); }


	if(!have_log()) {
		if(!is_alert(__FUNCTION__)) {
			# gerekli degerler
			$insert['type']		= 'message';
			$insert['sen_u_id'] = get_active_user('id');
			$insert['rec_u_id'] = $rec_user->id;
			$insert['date']		= date('Y-m-d H:i:s');
			$insert['date_update'] = date('Y-m-d H:i:s');

			# eger mesaj basligi yok ise otomatik olustur
			if(!isset($insert['title'])) { $insert['title'] = preg_replace("/[^\d\pL\p{Zs}]+/u", "", mb_substr(strip_tags(html_entity_decode($insert['message'])),0,50,'utf-8')); }
			if(!strlen($insert['title'])) { $insert['title'] = 'Konu yok'; }
			$insert['title'] = input_check($insert['title']); // ne olur ne olmaz diye guvenlik onelini tekrar alalim

			## eger cevap mesajı ise
			if($insert['top_id']) {
				# mesaj tipini degistirelim
				$insert['type'] = 'mess-reply';
			} else {
				$insert['inbox_u_id'] 	= $insert['rec_u_id'];
				$insert['outbox_u_id'] 	= $insert['sen_u_id'];
			}


			if($q_insert = db()->query("INSERT INTO ".dbname('messages')." ".sql_insert_string($insert)." ")) {

				if(db()->insert_id) {
					$insert_id = db()->insert_id;
					if($args['add_alert']) 	{ add_alert('<i class="fa fa-paper-plane-o"></i> Mesaj gönderildi.', 'success', __FUNCTION__); }
					if($args['add_log'])	{ add_log(array('table_id'=>'messages:'.$insert_id, 'log_key'=>__FUNCTION__, 'log_text'=>'Yeni bir mesaj gönderildi. '._b(get_user_info($rec_user->id, 'name').' '.get_user_info($rec_user->id, 'surname')))); }

					## gercek mesaji guncelle
					# eger cevap mesajı ise gercek mesajın gelen-giden kutusu ve okundu-okunmadı gibi durumlarını guncelleyelim, ayrıca mesaj cop kutusunda ise cikartalim
					if($insert['top_id']) {
						# gercek mesaji guncelleyelim
						$real_message['read_it']		= '0'; // mesajı tekrar okunmadı yapalım
						$real_message['inbox_u_id'] 	= $insert['rec_u_id'];
						$real_message['outbox_u_id'] 	= $insert['sen_u_id'];
						$real_message['date_update'] 	= date('Y-m-d H:i:s');
						$real_message['sen_trash_u_id'] = '0';
						$real_message['rec_trash_u_id'] = '0';
						if(db()->query("UPDATE ".dbname('messages')." SET ".sql_update_string($real_message)." WHERE id='".$insert['top_id']."' ")) {} else { add_mysqli_error_log(__FUNCTION__);}
					}

					return $insert_id;
				} else { return false; }
			} else { add_mysqli_error_log(__FUNCTION__); }
		} else { return false; }
	} else { repetitive_operation(__FUNCTION__); } // !have_log()
} //.add_message()








/**
 * @func get_message()
 * @desc bir mesaj bilgisini dondurur
 * @param string, array()
 * @return array
 */
function get_message($message_id, $args=array()) {
	$message_id	= input_check($message_id);
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];

	if(!empty($message_id)) { $where['id'] = $message_id; }

	if(!is_alert(__FUNCTION__)) {
		if ( !isset($where['type']) ) { $where['type'] = 'message'; }
		if($q_select = db()->query("SELECT * FROM ".dbname('messages')." ".sql_where_string($where)." ")) {
			if($q_select->num_rows) {
				return _return_helper($args['return'], $q_select);
			} else { return false; }
		} else { add_mysqli_error_log(__FUNCTION__); }
	} else { return false; }
} //.get_message()








 /**
  * @func get_messages()
  * @desc bir kullanıya ait mesajları listeler
  * @param string, array()
  * @return array => array()
  */
function get_messages($args=array()) {
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];


	# gerekli
	if(!isset($where['query'])) {
		$where['type']		= 'message';
		$where['top_id'] 	= 0;
		$where['order_by']['read_it'] 		= 'ASC';
		$where['order_by']['date_update'] 	= 'DESC';
	}

	if($q_select = db()->query("SELECT * FROM ".dbname('messages')." ".sql_where_string($where)." ")) {
		if($q_select->num_rows) {
			return db_query_list_return($q_select, 'id');
		} else { return false; }
	} else { add_mysqli_error_log(__FUNCTION__); }
} //.get_messages()








 /**
	* @func get_message_detail()
	* @desc bir mesaj listesini dondurur
	* @param string, array()
	* @return array => array()
	*/
function get_message_detail($message_id, $args=array()) {
	$message_id	= input_check($message_id);
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];


	if(!is_alert(__FUNCTION__)) {
		if(!empty($message_id)) {
			$where['id'] 		= $message_id;
			$where['top_id'] 	= $message_id;
		}

		if($q_select = db()->query("SELECT * FROM ".dbname('messages')." WHERE id='".$message_id."' OR top_id='".$message_id."' ORDER BY date DESC LIMIT ". $where['limit'] ." ")) {
			if($q_select->num_rows) {
				return db_query_list_return($q_select, 'id');
			} else { return false; }
		} else { return false; }
	} else { return false; }
} //.get_message_detail()








/**
 * @func get_calc_message()
 * @desc mesajlarin toplamını hesaplar
 * @param array()
 * @return string
 */
function get_calc_message($args=array()) {
	$args = input_check($args);

	# eger herhangi bir kutu deger yok ise gelen kutusunun sayisini hesaplayalim
	if(empty($args)) { $args['inbox_u_id'] = get_active_user('id'); }

	# gerekli
	$args['type']	= 'message';

	# eger okundu ve okunmadi belirtirlmemis ise sadece okunmamis mesajlari hesaplayalim
	if(!isset($args['read_it'])) { $args['read_it'] = '0'; }


	if($q_select = db()->query("SELECT * FROM ".dbname('messages')." ".sql_where_string($args)." ")) {
		return $q_select->num_rows;
	} else { add_mysqli_error_log(__FUNCTION__); }
} //.get_calc_message()








/**
 * @func _get_query_message()
 * @desc message tablosu icin özelikle mesajlar icin hazır QUERY/SORGU dondurur
 * @param array()
 * @return string
 */
function _get_query_message($args) {
	$return = '';

	if(!is_array($args)) { $text = $args; $args = array(); $args['type'] = $text; }

	if($args['type'] == 'inbox') {
		$return = "type='message' AND sen_trash_u_id != '".get_active_user('id')."' AND rec_trash_u_id != '".get_active_user('id')."' AND (rec_u_id='".get_active_user('id')."' OR inbox_u_id='".get_active_user('id')."') ORDER BY read_it ASC, date_update DESC, id DESC";
	} elseif($args['type'] == 'inbox-unread') {
		$return = "type='message' AND read_it='0' AND sen_trash_u_id != '".get_active_user('id')."' AND rec_trash_u_id != '".get_active_user('id')."' AND inbox_u_id='".get_active_user('id')."' ORDER BY read_it ASC, date_update DESC, id DESC";
	} elseif($args['type'] == 'inbox-read') {
		$return = "type='message' AND sen_trash_u_id != '".get_active_user('id')."' AND rec_trash_u_id != '".get_active_user('id')."' AND (rec_u_id='".get_active_user('id')."' AND read_it='1' OR rec_u_id='".get_active_user('id')."' AND outbox_u_id='".get_active_user('id')."' OR inbox_u_id='".get_active_user('id')."' AND read_it='1') ORDER BY read_it ASC, date_update DESC, id DESC";
	} elseif($args['type'] == 'outbox') {
		$return = "type='message' AND sen_trash_u_id != '".get_active_user('id')."' AND rec_trash_u_id != '".get_active_user('id')."' AND (sen_u_id='".get_active_user('id')."' OR outbox_u_id='".get_active_user('id')."') ORDER BY read_it ASC, date_update DESC, id DESC";
	} elseif($args['type'] == 'trash') {
		$return = "type='message' AND (sen_trash_u_id = '".get_active_user('id')."' OR rec_trash_u_id = '".get_active_user('id')."') ORDER BY read_it ASC, date_update DESC, id DESC";
	}

	return $return;
} //._get_query_message()
?>
