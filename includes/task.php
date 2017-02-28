<?php
/* --------------------------------------------------- TASK */


/**
 * add_task()
 * yeni bir görev olusturur
 */
function add_task($rec_u_id, $args=array()) {
	$rec_u_id = input_check($rec_u_id);
	$args 	= _args_helper(input_check($args), 'insert');
	$insert = $args['insert'];

	@form_validation($insert['message'], 'message', 'Mesaj', 'required|min_length[3]', __FUNCTION__);
	@form_validation($insert['date_start'], 'date_start', 'Başlama Tarihi', 'required|datetime', __FUNCTION__);
	@form_validation($insert['date_end'], 'date_end', 'Bitirme Tarihi', 'required|datetime', __FUNCTION__);
	if(!$rec_user = get_user($rec_u_id)) { add_alert('Görev atanacak kullanıcı bulunamadı.', 'danger', __FUNCTION__); }

	if(!have_log()) {
		if(!is_alert(__FUNCTION__)) {

			# gerekli degerler
			$insert['type']			= 'task';
			$insert['type_status']	= '0';
			$insert['sen_u_id'] 	= get_active_user('id');
			$insert['rec_u_id'] 	= $rec_user->id;
			$insert['date']			= date('Y-m-d H:i:s');
			$insert['date_update'] 	= date('Y-m-d H:i:s');
			

			# secenekler
			if(isset($insert['choice'])) {
				$choice = array();
				$i = 0;
				foreach($insert['choice'] as $text) {
					if($text) {
						$i++;
						$choice[$i] = array('is_it_done'=>0, 'text'=>$text);
					}
				}
			}
			if(empty($choice)) { $insert['choice'] 	= false; } else { $insert['choice']		= json_encode_utf8($choice); }


			# eger mesaj basligi yok ise otomatik olustur
			if(!isset($insert['title'])) { $insert['title'] = mb_substr(strip_tags($insert['message']),0,50,'utf-8'); }
			if(!strlen($insert['title'])) { $insert['title'] = 'Konu yok'; }
			$insert['title'] = input_check($insert['title']); // ne olur ne olmaz diye guvenlik onelini tekrar alalim

			# kullanicin ve giden kutulari icin deger atayalim
			$insert['inbox_u_id'] 	= $insert['rec_u_id'];
			$insert['outbox_u_id'] 	= $insert['sen_u_id'];
			


			if($q_insert = db()->query("INSERT INTO ".dbname('messages')." ".sql_insert_string($insert)." ")) {
				if(db()->insert_id) {
					$insert_id = db()->insert_id;
					if($args['add_alert']) 	{ add_alert('Mesaj gönderildi', 'success', __FUNCTION__); }
					if($args['add_log'])	{ add_log(array('table_id'=>'messages:'.$insert_id, 'log_key'=>__FUNCTION__, 'log_text'=>'Yeni bir mesaj gönderildi. '._b(get_user_info($rec_user->id, 'name').' '.get_user_info($rec_user->id, 'surname')))); }
					return $insert_id;
				} else { return false; }
			} else { add_mysqli_error_log(__FUNCTION__); }
		} else { return false; }
	} else { repetitive_operation(__FUNCTION__); } // !have_log()
} //.add_task()






/**
 * update_task()
 * gorevi gunceller
 */
function update_task($task_id, $args) {	
	$task_id 	= input_check($task_id);
	$args 		= _args_helper(input_check($args), 'update');
	$update 	= $args['update'];

	@form_validation($update['date_start'], 'date_start', 'Başlama Tarihi', 'datetime', __FUNCTION__);
	@form_validation($update['date_end'], 'date_end', 'Bitirme Tarihi', 'datetime', __FUNCTION__);

	if(!have_log(@$args['uniquetime'])) {
		if(!is_alert(__FUNCTION__, 'danger')) {
			if(!isset($update['date_update'])) { $update['date_update'] = date('Y-m-d H:i:s'); }

			if($q_update = db()->query("UPDATE ".dbname("messages")." SET ".sql_update_string($update)." WHERE id='".$task_id."' ")) {
				if(db()->affected_rows) {
					if($args['add_alert']) { add_alert('Görev bilgisi güncellendi.', 'success', __FUNCTION__); }
					return true;
				} else { return false; }
			} else { add_mysqli_error_log(__FUNCTION__); }

		} else { return false; }
	} else { repetitive_operation(__FUNCTION__); }
} //.update_task()






/**
 * get_tasks()
 * bir görev bilgisini döndürür
 */
function get_task($task_id, $args=array()) {
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];

	if($task_id) { $where['id'] = $task_id; }

	if($q_select = db()->query("SELECT * FROM ".dbname('messages')." ".sql_where_string($where)." ")) {
		if($q_select->num_rows) {
			$return =  _return_helper($args['return'], $q_select);

			# acik kapalı gorev secenek sayisini hesaplayalim ve objeye aktaralim
			$return->choice_open	= 0;
			$return->choice_closed	= 0;
			$return->choice_count	= 0;
			if($return->choice) {
				foreach(json_decode($return->choice) as $ch) { 
					if($ch->is_it_done) { $return->choice_closed++; } else { $return->choice_open++; } 
					$return->choice_count++;
				}
			}

			return $return;
		} else { return false; }
	} else { add_mysqli_error_log(__FUNCTION__); }
} //.get_task()






/**
 * get_tasks()
 * 
 */
function get_tasks($args=array()) {
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];

	if(!isset($where['status'])) { $where['status'] = '1'; }
	$where['type']		= 'task';
	$where['top_id']	= '0';
	$where['order_by']['type_status'] 	= 'ASC';
	$where['order_by']['read_it'] 		= 'ASC';
	$where['order_by']['date_update'] 	= 'DESC';
	$where['order_by']['id']			= 'ASC';

	if($q_select = db()->query("SELECT * FROM ".dbname('messages')." ".sql_where_string($where)." ")) {
		if($q_select->num_rows) {
			return db_query_list_return($q_select, 'id');
		} else { return false; }
	} else { add_mysqli_error_log(__FUNCTION__); }
} //.get_tasks()






/**
 * add_task_message()
 * bir gorev icin mesaj ekler
 */
function add_task_message($task_id, $args) {
	$task_id 	= input_check($task_id);
	$args 		= _args_helper(input_check($args), 'insert');
	$insert 	= $args['insert'];

	# form control
	@form_validation($insert['message'], 'message', 'Mesaj', 'required|min_lenght[3]', __FUNCTION__);
	# task_id var mi?
	if(!$task = get_task($task_id)) { add_alert('Görev ID bulunamadı.', 'danger', __FUNCTION__); }

	
	if(!have_log(@$args['uniquetime'])) {
		if(!is_alert(__FUNCTION__)) {

			## gerekli
			$insert['top_id'] 	= $task_id;
			$insert['type'] 	= 'task-reply';
			$insert['date']		= date('Y-m-d H:i:s');
			$insert['date_update'] = date('Y-m-d H:i:s');
			$insert['sen_u_id'] = get_active_user('id');
			if(get_active_user('id') == $task->sen_u_id) { $insert['rec_u_id'] = $task->rec_u_id; } else { $insert['rec_u_id'] = $task->sen_u_id; }
			

			if($q_insert = db()->query("INSERT INTO ".dbname('messages')." ".sql_insert_string($insert)." ")) {
				if(db()->insert_id) {
					$insert_id = db()->insert_id;
					if($args['add_alert']) 	{ add_alert('Görev için cevap mesajı ekledi.', 'success', __FUNCTION__); }
					if($args['add_log']) 	{ add_log(array('table_id'=>'messages:'.$task_id, 'log_key'=>__FUNCTION__, 'log_text'=>'Görev için cevap mesajı gönderdi. '._b('ID: '.$task->id))); }
					
					## yeni mesaj eklendigi icin gorevi tekrar okunmadi yapacagiz ve guncelleme tarihini degistirecehiz
					$_task['add_log'] 		= false;
					$_task['add_alert']		= false;
					$_task['uniquetime'] 	= get_uniquetime();
					$_task['update']['date_update'] 	= date('Y-m-d H:i:s');
					$_task['update']['read_it']			= 0;
					$_task['update']['outbox_u_id'] 	= get_active_user('id');
					if(get_active_user('id') == $task->sen_u_id) { $_task['update']['inbox_u_id'] = $task->rec_u_id; } else { $_task['update']['inbox_u_id'] = $task->sen_u_id; }
					
					update_task($task->id, $_task);
					
					return $insert_id;
				} else { return false; }
			} else { add_mysqli_error_log(__FUNCTION__); }

		} else { return false; }
	} else { repetitive_operation(__FUNCTION__); }
} //.add_task_message()






/**
 * get_task_detail()
 * bir mesaj listesini dondurur
 */
function get_task_detail($message_id, $args=array()) {
	$message_id	= input_check($message_id);
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];


	if(!is_alert(__FUNCTION__)) {

		$where['id'] 		= $message_id;
		$where['top_id'] 	= $message_id;

		if($q_select = db()->query("SELECT * FROM ".dbname('messages')." WHERE id='".$message_id."' OR top_id='".$message_id."' ORDER BY date ASC ")) {
			if($q_select->num_rows) {
				return db_query_list_return($q_select, 'id');
			} else { return false; }
		} else { return false; }
	} else { return false; }
} //.get_message_detail()






/**
 * get_calc_task()
 * görevlerin toplamını hesaplar
 */
function get_calc_task($args=array()) {
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];


	// eger herhangi bir deger yok ise gelen kutusunun sayisini hesaplayalim
	if(empty($where)) {
		$where['inbox_u_id'] = get_active_user('id');
	}

	// gerekli
	$where['type'] = 'task';

	// eger okundu ve okunmadi belirtirlmemis ise sadece okunmamis mesajlari hesaplayalim
	if(!isset($where['read_it'])) {
		$where['read_it'] = '0';
	}

	// eger okunmus ve okunmais mesajlari hesaplayacak ise "all" parametresini arayalim ve fazlaliklari silelim
	if(isset($where['all'])) {
		unset($where['read_it']);
		unset($where['all']);
	}


	if($q_select = db()->query("SELECT * FROM ".dbname('messages')." ".sql_where_string($where)." ")) {
		return $q_select->num_rows;
	} else { add_mysqli_error_log(__FUNCTION__); }
} //.get_calc_task()







/**
 * _get_query_task()
 * hazır task sorguları
 */
function _get_query_task($args) {
	$return = "type='task' AND top_id='0' AND ";

	if(!is_array($args)) { $text = $args; $args = array(); $args['type'] = $text; }

	if($args['type'] == 'inbox' OR $args['type'] == 'inbox-open' OR $args['type'] == 'inbox-close') {
		$return .= "rec_u_id='".get_active_user('id')."' AND sen_trash_u_id != '".get_active_user('id')."' AND rec_trash_u_id != '".get_active_user('id')."'";
		
		if($args['type'] == 'inbox-open') {
			$return .= " AND type_status='0'";
		} elseif($args['type'] == 'inbox-close') {
			$return .= " AND type_status='1'";
		}
	}

	if($args['type'] == 'outbox' OR $args['type'] == 'outbox-open' OR $args['type'] == 'outbox-close') {
		$return .= "sen_u_id='".get_active_user('id')."' AND sen_trash_u_id != '".get_active_user('id')."' AND rec_trash_u_id != '".get_active_user('id')."'";
		
		if($args['type'] == 'outbox-open') {
			$return .= " AND type_status='0'";
		} elseif($args['type'] == 'outbox-close') {
			$return .= " AND type_status='1'";
		}
	}

	if($args['type'] == 'trash') {
		$return .= "(sen_trash_u_id = '".get_active_user('id')."' OR rec_trash_u_id = '".get_active_user('id')."')";
	}

	return $return." ORDER BY type_status ASC, read_it ASC, date_update DESC, id DESC";
}






?>