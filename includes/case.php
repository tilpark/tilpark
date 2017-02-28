<?php
/* --------------------------------------------------- PAYMENT */

/**
 * add_payment()
 * bir odeme yontemi ekler
 */
function set_payment($args=array()) {

	$args 	= _args_helper(input_check($args), 'insert');
	$insert = $args['insert'];

	@form_validation($insert['account_name'], 'account_name', 'Hesap adı', 'required|min_length[3]|max_length[32]', __FUNCTION__);
	@form_validation($insert['status_id'], 'status_id', 'Kasa veya banka', 'required|digits', __FUNCTION__);
	@form_validation($insert['payment'], 'payment', 'Ödeme tutarı', 'required|money', __FUNCTION__);
	@form_validation($insert['date'], 'date', 'Tarih', 'required|datetime', __FUNCTION__);
	
	// giris cikis turu kontrol edelim
	if($insert['in_out'] != '0' and $insert['in_out'] != '1') {
		add_alert('Giriş çıkış türü yanlış', 'danger', __FUNCTION__); return false; }

	if(!is_alert(__FUNCTION__)) {

		if(!isset($_insert['type'])) { $_insert['type'] = 'payment'; }

		
		$_insert['in_out']			= $insert['in_out'];
		$_insert['date'] 			= $insert['date'];
		$_insert['account_id'] 		= $insert['account_id'];
		$_insert['account_code'] 	= $insert['account_code'];
		$_insert['account_name'] 	= $insert['account_name'];
		$_insert['account_gsm'] 	= $insert['account_gsm'];
		$_insert['account_phone'] 	= $insert['account_phone'];
		$_insert['account_email'] 	= $insert['account_email'];
		$_insert['account_city'] 	= $insert['account_city'];
		$_insert['status_id']		= $insert['status_id'];
		$_insert['user_id']			= get_active_user('id');
		
		//$_insert['payment_type'] 	= $insert['payment_type'];
		$_insert['total'] 			= get_set_decimal_db($insert['payment']);

		if($q_insert = db()->query("INSERT INTO ".dbname('forms')." ".sql_insert_string($_insert)." ")) {
			if(db()->insert_id) {
				$insert_id = db()->insert_id;

				// hesap kartinin bakiyesini guncelle
				if(!empty($_insert['account_id'])) { if(calc_account($_insert['account_id'])); }
				// kasa guncelle
				calc_case($_insert['status_id']);
				
				return $insert_id;
			} else { return false; }
		} else { add_mysqli_error_log(__FUNCTION__); }

	} else { return false; }
}






/**
 * get_payment()
 * bir odeme formunu dondurur
 */
function get_payment($args) {
	if(!is_array($args)) { $args = array('where'=>array('id'=>$args)); }
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];


	if($q_select = db()->query("SELECT * FROM ".dbname('forms')." ".sql_where_string($where)." ")) {
		if($q_select->num_rows) {
			return $q_select->fetch_object();
		} else { return false; }
	} else { add_mysqli_error_log(__FUNCTION__); }
}





/**
 * get_payments()
 * odeme listelerini dondurur
 */
function get_payments($args=array()) {
	$return = new StdClass;

	$query_str = '';
	$query_str_real = '';

	$args = input_check($args);
	
	if(isset($args['where'])) {
		$query_str = "SELECT * FROM ".dbname('forms')." ".sql_where_string($args['where'])." ";
		$query_str_real = $query_str;
	} else {
		// required
		$args = input_check(get_ARR_helper_limit_AND_orderby($args));

		if(!isset($args['status'])) 	{ $args['status'] = '1'; } else { $args['status'] = input_check($args['status']); }
		if(!isset($args['type'])) 		{ $args['type'] = 'payment'; } else { $args['type'] = input_check($args['type']); }

		// query string
		$query_str = "SELECT * FROM ".dbname('forms')." WHERE status='".$args['status']."' AND type='".$args['type']."' ";

		// %s% antarı var ise arama yapalim
		if(isset($args['s'])) {
			if($args['db-s-where'] == 'all') {
				$query_str .= "AND ( account_name LIKE '%".$args['s']."%' ";
				$query_str .= "OR id LIKE '%".$args['s']."%' ";
				$query_str .= ' )';
			} else {
				$query_str .= "AND ( ".$args['db-s-where']." LIKE '%".$args['s']."%' ) ";
			}
		}

		if(isset($args['status_id'])) {
			$query_str .= "AND status_id='".$args['status_id']."' ";
		}

		// query string real
		$query_str_real = $query_str;

		if(isset($args['orderby_name']) and isset($args['orderby_type'])) {
			$query_str_real .= "ORDER BY ".$args['orderby_name']." ".$args['orderby_type'];
		}

		// limti var ise yapalim
		if($args['limit'] > 1) {
			$query_str_real .= " LIMIT ".$args['page'].",".$args['limit']." "; 
		}
	}


	if($query = db()->query($query_str)) { // sayfalama icin sorgu yapalim
		$return->num_rows = $query->num_rows; // toplam kayit sayisi
		if($return->num_rows > 0) {
			
			$query = db()->query($query_str_real); // listeleme icin sorgu yapalim
			$return->display_num_rows = $query->num_rows; // gosterilen kayit sayisi
			
			while($item = $query->fetch_object())
			{
				$return->list[] = $item;
			}


			return $return;
		} else {
			add_alert('Aradığınız kriterlere uygun ödeme formları bulunamadı.', 'warning', __FUNCTION__);
			return false;
		}
	} else {
		add_mysqli_error_log(__FUNCTION__);
	}
}









/* --------------------------------------------------- CASE */


/**
 * add_case()
 * bir kasa veya banka hesabı ekler 
 */
function add_case($args=array()) {

	$args = _args_helper(input_check($args), 'insert');
	$_insert['insert'] = _set_case_args($args['insert']);
	$_insert['add_log'] = false;
	$_insert['add_alert'] = false;

	@form_validation($_insert['insert']['name'], '', 'Kasa veya Banka Adı', 'required|min_length[3]|max_length[64]', __FUNCTION__);

	if(!is_alert(__FUNCTION__)) {
		if($case_id = add_extra($_insert)) {
			if(@$_insert['insert']['val_enum']) { // is_bank
				if($args['add_alert']) { add_alert(_b($_insert['insert']['name']).' banka hesabı oluşturuldu.', 'success', __FUNCTION__); }
				if($args['add_log']) { add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'extra:'.$case_id, 'log_key'=>__FUNCTION__, 'log_text'=>_b($_insert['insert']['name']).' banka hesabı oluşturuldu.')); }
			} else {
				if($args['add_alert']) { add_alert(_b($_insert['insert']['name']).' kasası oluşturuldu.', 'success', __FUNCTION__); }
				if($args['add_log']) { add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'extra:'.$case_id, 'log_key'=>__FUNCTION__, 'log_text'=>_b($_insert['insert']['name']).' kasası oluşturuldu.')); }
			}
		} else { return false; }
	}

	
}






/**
 * get_case()
 * kasa ve banka kartini dondurur
 */
function get_case($args=array()) {
	if(!is_array($args)) { $args = array('id'=>$args); }
	$args = _args_helper(input_check($args), 'where');
	$_where = _set_case_args($args['where']);
	
	if($case = get_extra($_where)) {
		$return = new stdClass;
		$return->id 	= $case->id;
		$return->taxonomy 	= $case->taxonomy;
		$return->name 		= $case->name;
		$return->color 		= $case->val_1;
		$return->bg_color 	= $case->val_2;
		$return->auto_email = $case->val_3;
		$return->auto_sms 	= $case->val_4;
		$return->is_default 	= $case->val_5;
		$return->sms_template 	= $case->val_9;
		$return->mail_template 	= $case->val_text;
		$return->count 			= $case->val_int;
		$return->total 			= $case->val_decimal;
		$return->is_bank 		= $case->val_enum;
		if($return->is_bank == 1) {
			$return->bank_name 			= $case->val_6;
			$return->bank_admin_name 	= $case->val_7;
			if($bank_detail = json_decode($case->val_8)) {
				$return->bank_branch_code 	= $bank_detail->branch_code;
				$return->bank_account_no 	= $bank_detail->account_no;
				$return->bank_iban 			= $bank_detail->iban;
			} else{
				$return->bank_branch_code 	= '';
				$return->bank_account_no 	= '';
				$return->bank_iban 			= '';
			}
		}

		return $return;

	} else { return false; }
}






/**
 * update_case()
 * bir kasayı gunceller
 */
function update_case($where, $args) {
	if(!is_array($where)) { $where = array('id'=>$where); }
	$where 	= _set_case_args(input_check($where));
	$args 	= _args_helper(input_check($args), 'update');
	$_update['update']		= _set_case_args($args['update']);
	$_update['add_log'] 	= false;
	$_update['add_alert'] 	= false;
	$_update['add_new'] 	= false;

	if(isset($_update['update']['name'])) {
		@form_validation($_update['update']['name'], '', 'Kasa veya Banka Adı', 'required|min_length[3]|max_length[64]', __FUNCTION__);
	}
	

	if(!is_alert(__FUNCTION__)) {

		
		
		if(isset($_update['update']['val_5']) and isset($_update['update']['val_enum'])) {
			db()->query("UPDATE ".dbname('extra')." SET val_5='' WHERE taxonomy='til_case' AND val_enum='".$_update['update']['val_enum']."' ");
		}

		if($case_id = update_extra($where, $_update)) {

			if(@$_update['update']['val_enum']) { // is_bank
				if($args['add_alert']) { add_alert(_b($_update['update']['name']).' banka hesabı güncellendi.', 'success', __FUNCTION__); }
				if($args['add_log']) { add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'extra:'.$case_id, 'log_key'=>__FUNCTION__, 'log_text'=>_b($_update['update']['name']).' banka hesabı güncellendi.')); }
			} else {
				if($args['add_alert']) { add_alert(_b($_update['update']['name']).' kasası güncellendi.', 'success', __FUNCTION__); }
				if($args['add_log']) { add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'extra:'.$case_id, 'log_key'=>__FUNCTION__, 'log_text'=>_b($_update['update']['name']).' kasası güncellendi.')); }
			}
			return $case_id;
		} else { return false; }
	} else { return false; }

}







/**
 * get_case_all()
 * kasa ve bankaların hepsini dondurur
 */
function get_case_all($args=array()) {
	$args = _args_helper(input_check($args), 'where');
	$args['where'] = _set_case_args($args['where']);	
	$_where['where'] = $args['where'];
	$_where['return'] = 'plural_object';



	if($get_case_all = get_extras($_where)) {
		$_return = array();

		foreach($get_case_all as $case) {
			$return = new stdClass;
			$return->id 	= $case->id;
			$return->taxonomy 	= $case->taxonomy;
			$return->name 		= $case->name;
			$return->color 		= $case->val_1;
			$return->bg_color 	= $case->val_2;
			$return->auto_email = $case->val_3;
			$return->auto_sms 	= $case->val_4;
			$return->is_default 	= $case->val_5;
			$return->sms_template 	= $case->val_9;
			$return->mail_template 	= $case->val_text;
			$return->count 			= $case->val_int;
			$return->total 			= $case->val_decimal;
			$return->is_bank 		= $case->val_enum;
			if($return->is_bank == 1) {
				$return->bank_name 			= $case->val_6;
				$return->bank_admin_name 	= $case->val_7;
				if($bank_detail = json_decode($case->val_8)) {
					$return->bank_branch_code 	= $bank_detail->branch_code;
					$return->bank_account_no 	= $bank_detail->account_no;
					$return->bank_iban 			= $bank_detail->iban;
				} else{
					$return->bank_branch_code 	= '';
					$return->bank_account_no 	= '';
					$return->bank_iban 			= '';
				}
			}
			
			$_return[] = $return;
		}
		if(count($_return)) {
			return $_return;
		} else { return false; }
	} else { return false; }
}






/** 
 * _set_case_args()
 * form_status fonksiyonlari gelen parametlerine veritabanı tabolarına uygun hale dönüştürür
 */
function _set_case_args($args, $return_args=false) {

	$_arr = array();
	if(isset($args['id'])) { $_arr['id'] = $args['id']; }
	if(!isset($args['taxonomy'])) { $_arr['taxonomy'] = 'til_case'; }
	if(isset($args['taxonomy'])) { $_arr['taxonomy'] = $args['taxonomy']; }
	if(isset($args['name'])) { $_arr['name'] = $args['name']; }
	if(isset($args['color'])) { $_arr['val_1'] = $args['color']; }
	if(isset($args['bg_color'])) { $_arr['val_2'] = $args['bg_color']; }
	if(isset($args['auto_email'])) { $_arr['val_3'] = $args['auto_email']; }
	if(isset($args['auto_sms'])) { $_arr['val_4'] = $args['auto_sms']; }
	if(isset($args['is_default'])) { $_arr['val_5'] = $args['is_default']; }
	if(isset($args['sms_template'])) { $_arr['val_9'] = $args['sms_template']; }
	if(isset($args['mail_template'])) { $_arr['val_text'] = $args['mail_template']; }
	if(isset($args['count'])) { $_arr['val_int'] = $args['count']; }
	if(isset($args['total'])) { $_arr['val_decimal'] = $args['total']; }
	if(isset($args['is_bank'])) { $_arr['val_enum'] = $args['is_bank']; }
	if(isset($args['bank_name'])) { $_arr['val_6'] = $args['bank_name']; }
	if(isset($args['bank_admin_name'])) { $_arr['val_7'] = $args['bank_admin_name']; }
	if(isset($args['bank_detail'])) { $_arr['val_8'] = $args['bank_detail']; }
	if(isset($args['is_bank'])) { $_arr['val_enum'] = $args['is_bank']; }
	if(substr($_arr['taxonomy'], 0,4) != 'til_') { $_arr['taxonomy'] = 'til_'.$_arr['taxonomy'];}

	foreach(array('taxonomy', 'name', 'color', 'bg_color', 'auto_email', 'auto_sms', 'is_default', 'sms_template', 'mail_template', 'count', 'total', 'in_out') as $a) {
		if(isset($args[$a])) { unset($args[$a]); }
	}

	if($return_args) {
		return $args;
	} else { return $_arr; }
} //._set_case_args();







/** 
 * _set_case_default()
 * form status verileri icin eger yok ise default/varsayilan ogeyi secer
 */
function _set_case_default() {

	// eger varsayılan form durumu yok ise ilk degeri varsayilan yapalim
	$where = array('taxonomy'=>'til_case', 'is_default'=>'default', 'is_bank'=>0);

	if($query = db()->query("SELECT * FROM ".dbname('extra')." WHERE taxonomy='til_case' AND val_5='default' AND val_enum='0' ")) {
		if(!$query->num_rows) {
			db()->query("UPDATE ".dbname('extra')." SET val_5='default' WHERE taxonomy='til_case' AND val_5='' AND val_enum='0' ORDER BY id ASC LIMIT 1");
		}
	}

	if($query = db()->query("SELECT * FROM ".dbname('extra')." WHERE taxonomy='til_case' AND val_5='default' AND val_enum='1' ")) {
		if(!$query->num_rows) {
			db()->query("UPDATE ".dbname('extra')." SET val_5='default' WHERE taxonomy='til_case' AND val_5='' AND val_enum='1' ORDER BY id ASC LIMIT 1");
		}
	}

} //._set_form_status_default()






/**
 * calc_case()
 * kasanin icindeki tum paralari hesaplar
 */
function calc_case($case_id) {

	if($case = get_case($case_id)) {
		$q_total_in = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE type='payment' AND in_out='0' AND status_id='".$case->id."' ");
		$in_total = $q_total_in->fetch_assoc();

		$q_total_out = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE type='payment' AND in_out='1' AND status_id='".$case->id."' ");
		$out_total = $q_total_out->fetch_assoc();

		$total = $in_total['total'] - $out_total['total'];

		$args['update']['total'] = $total;
		$args['add_log'] = false;
		$args['add_alert'] = false;
		if(update_case($case_id, $args)) {
			return $total;
		} else { return false; }



	} else { return false; }
}



















