<?php
/* --------------------------------------------------- ACCOUNT */


/**
 * add_account()
 * yeni bir hesap kartı oluşturur
 */
function add_account($args) {

	if(!have_log()) { // eger daha onceden eklenmemis ise log kaydi bulunmayacaktir.

		$args = _args_helper(input_check($args), 'insert');
		$insert = $args['insert'];

		@form_validation($insert['code'], 'code', 'Barkod Kodu', 'min_length[3]|max_length[32]', __FUNCTION__);
		@form_validation($insert['name'], 'name', 'Hesap Adı', 'required|min_length[3]|max_length[50]', __FUNCTION__);
		@form_validation($insert['email'], 'email', 'E-posta', 'email', __FUNCTION__);
		@form_validation($insert['gsm'], 'gsm', 'Cep Telefonu', 'required|gsm', __FUNCTION__);
		@form_validation($insert['phone'], 'phone', 'Sabit Telefon', 'number|min_length[10]|max_length[11]', __FUNCTION__);
		@form_validation($insert['address'], 'address', 'Adres', 'max_length[250]', __FUNCTION__);
		@form_validation($insert['district'], 'district', 'İlçe', 'max_length[20]', __FUNCTION__);
		@form_validation($insert['city'], 'city', 'Şehir', 'max_length[20]', __FUNCTION__);
		@form_validation($insert['tax_home'], 'tax_home', 'Vergi Dairesi', 'max_length[50]', __FUNCTION__);
		@form_validation($insert['tax_no'], 'tax_no', 'Vergi No', 'number|max_length[20]', __FUNCTION__);

		// genel degerler
		if(!isset($insert['type'])) { $insert['type'] = 'account'; } else { $insert['type'] = input_check($insert['type']); }
		if(!isset($insert['date'])) { $insert['date'] = date('Y-m-d H:i:s'); }
		if(empty($insert['code'])) { // eger code yani barkod kodu yok ise olusturalim
			$insert['code'] = get_account_code_generator(); }

		if(!is_alert(__FUNCTION__, 'danger')) { // eger herhangi bir hata yok ise

			$q_is_code = db()->query("SELECT * FROM ".dbname('accounts')." WHERE code='".$insert['code']."' ");
			if($q_is_code->num_rows) { // eger veritabanında ayni barkod var ise
				$q_is_code = $q_is_code->fetch_object();
				
				if($args['add_alert']) { add_alert('<b>'.$insert['code'].'</b> Hesap Kodu başka bir hesap kartında bulundu. Lütfen hesap kodunu değiştirin veya <a href="'.get_site_url('admin/account/detail.php?id='.$q_is_code->id).'" target="_blank"><b>buradaki</b></a> hesabı kullanın.', 'warning', 'add_account'); }
				if($q_is_code->status == '1') {
					if($args['add_alert']) { add_alert('<u>Ayrıca bu kod silinen hesap kartları arasında bulundu</u>. Hesap kartını <a href="'.get_site_url('admin/account/detail.php?id='.$q_is_code->id).'"><b>buradan</b></a> tekrar aktifleştirebilirsiniz.', 'warning', 'add_account'); } }

				return false;
			} else { // eger veritabanında aynı barkod kodu yok ise

				if(isset($insert['name'])) 		{ $insert['name'] = til_get_strtoupper($insert['name']); }
				if(isset($insert['address'])) 	{ $insert['address'] = til_get_strtoupper($insert['address']); }
				if(isset($insert['city'])) 		{ $insert['city'] = til_get_strtoupper($insert['city']); }
				if(isset($insert['district'])) 	{ $insert['district'] = til_get_strtoupper($insert['district']); }
				if(isset($insert['country'])) 	{ $insert['country'] = til_get_strtoupper($insert['country']); }
				if(isset($insert['tax_home'])) 	{ $insert['tax_home'] = til_get_strtoupper($insert['tax_home']); }
				if(isset($insert['email'])) 	{ $insert['email'] = til_get_strtolower($insert['email']); }


				if(db()->query("INSERT INTO ".dbname('accounts')." ".sql_insert_string($insert)." ")) {
					$insert_id = db()->insert_id;
					if($args['add_alert']) { add_alert('Yeni Hesap Kartı Eklendi.', 'success', 'add_account'); }
					if($args['add_log'])	{ add_log(array('uniquetime'=>@$insert['uniquetime'], 'table_id'=>'accounts:'.$insert_id, 'log_key'=>'add_account', 'log_text'=>'Hesap kartı eklendi.')); }
					return $insert_id;
				} else { add_mysqli_error_log(__FUNCTION__); }
				
				return false;
			} // $q_is_code->num_rows

			
		} else {
			return false;
		} // !is_alert()
	} else { repetitive_operation(__FUNCTION__); } // !have_log()
}





/**
 * get_account()
 * bu fonksiyon tek bir hesap kartini dataları ile birlikte dondurur
 */
function get_account($args) {

	if(!is_array($args)) { $args = array('where'=>array('id'=>$args)); }	
	$args = _args_helper(input_check($args), 'where');
	$where = $args['where'];


	if($query = db()->query("SELECT * FROM ".dbname('accounts')." ".sql_where_string($where)." ")) {
		if($query->num_rows) {
			return _return_helper($args['return'], $query);
		} else {
			if($args['add_alert']) { add_alert('Aradığınız kriterlere uygun hesap kartı bulunamadı.', 'warning', __FUNCTION__); }
			return false;
		}
	} else { add_mysqli_error_log(__FUNCTION__); }
} //.get_account()





/**
 * update_account()g
 * bir hesap kartini gunceller
 */
function update_account($where, $args) {

	$where 	= input_check($where);
	$args 	= _args_helper(input_check($args), 'update');
	$update = $args['update'];

	if(isset($update['id'])) { unset($update['id']); } // guvenlik icin eger hesap ID guncellenmek isteniyorsa guncellenmesin
	


	if(!have_log()) { // eger daha onceden eklenmemis ise log kaydi bulunmayacaktir.
		if($old_account = get_account($where)) {

			if(!isset($update['code'])) { $update['code'] = $old_account->code; }
			if(!isset($update['name'])) { $update['name'] = $old_account->name; }
			if(!isset($update['gsm'])) { $update['gsm'] = $old_account->gsm; }

			@form_validation($update['code'], 'code', 'Ürün Kodu', 'min_length[3]|max_length[32]', 'update_account');
			@form_validation($update['name'], 'name', 'Hesap Adı', 'required|min_length[3]|max_length[50]', 'update_account');
			@form_validation($update['email'], 'email', 'E-posta', 'email', 'update_account');
			@form_validation($update['gsm'], 'gsm', 'Cep Telefonu', 'required|gsm', 'update_account');
			@form_validation($update['phone'], 'phone', 'Sabit Telefon', 'number|min_length[10]|max_length[11]', 'update_account');
			@form_validation($update['address'], 'address', 'Adres', 'max_length[250]', 'update_account');
			@form_validation($update['district'], 'district', 'İlçe', 'max_length[20]', 'update_account');
			@form_validation($update['city'], 'city', 'Şehir', 'max_length[20]', 'update_account');
			@form_validation($update['tax_home'], 'tax_home', 'Vergi Dairesi', 'max_length[50]', 'update_account');
			@form_validation($update['tax_no'], 'tax_no', 'Vergi No', 'number|max_length[20]', 'update_account');


			if(!is_alert(__FUNCTION__, 'danger')) { // eger herhangi bir hata yok ise

				// genel degerler
				if(!isset($update['type'])) { $update['type'] = 'account'; } else { $update['type'] = $update['type']; }
			
				if(empty($update['code']) and strlen($old_account->code) < 1) { // eger code yani barkod kodu yok ise olusturalim
					$update['code'] = get_account_code_generator($old_account->id); }


				$q_is_code = db()->query("SELECT * FROM ".dbname('accounts')." WHERE code='".$update['code']."' AND id NOT IN ('".$old_account->id."')");
				if($q_is_code->num_rows) { // eger veritabanında ayni barkod var ise
					$q_is_code = $q_is_code->fetch_object();
					
					if($args['add_alert']) { add_alert('<b>'.$update['code'].'</b> Hesap Kodu başka bir hesap kartında bulundu. Lütfen hesap kodunu değiştirin veya <a href="'.get_site_url('admin/account/detail.php?id='.$q_is_code->id).'" target="_blank"><b>buradaki</b></a> hesabı kullanın.', 'warning', 'update_account'); }
					if($q_is_code->status == '0') {
						if($args['add_alert']) { add_alert('<u>Ayrıca bu kod silinen hesap kartları arasında bulundu</u>. Hesap kartını <a href="'.get_site_url('admin/account/detail.php?id='.$q_is_code->id).'"><b>buradan</b></a> tekrar aktifleştirebilirsiniz.', 'warning', 'update_account'); } }
					return false;
				} else { // eger veritabanında aynı barkod kodu yok ise


					if(isset($update['name'])) 		{ $update['name'] = til_get_strtoupper($update['name']); }
					if(isset($update['address'])) 	{ $update['address'] = til_get_strtoupper($update['address']); }
					if(isset($update['city'])) 		{ $update['city'] = til_get_strtoupper($update['city']); }
					if(isset($update['district'])) 	{ $update['district'] = til_get_strtoupper($update['district']); }
					if(isset($update['country'])) 	{ $update['country'] = til_get_strtoupper($update['country']); }
					if(isset($update['tax_home'])) 	{ $update['tax_home'] = til_get_strtoupper($update['tax_home']); }
					if(isset($update['email'])) 	{ $update['email'] = til_get_strtolower($update['email']); }
					
					if(db()->query("UPDATE ".dbname('accounts')." SET ".sql_update_string($update)." WHERE id='".$old_account->id."' ")) {
						if(db()->affected_rows > 0) {
							$new_account = get_account($old_account->id);
							if($args['add_alert']) { add_alert('Hesap kartı güncellendi.', 'success', 'update_account'); }
							if($args['add_log']) { add_log(array('table_id'=>'accounts:'.$old_account->id, 'log_key'=>'update_account', 'log_text'=>'Hesap kartı güncellendi.', 'meta'=>log_compare($old_account, $new_account))); }
							return true;
						} else { return false; }
					} else { add_mysqli_error_log(__FUNCTION__); }
				}
				

				return true;
			} else {
				return false;
			}
		}
	} else { repetitive_operation(__FUNCTION__); } // !have_log()
} //.update_account()





/**
 * get_accounts()
 * hesap kartlarini listeler, sonucları obj olarak dondurur
 */
function get_accounts($args=array()) {
	$return = new StdClass;

	$query_str = '';
	$query_str_real = '';
	
	// required
	$args = get_ARR_helper_limit_AND_orderby($args);
	if(!isset($args['status'])) 	{ $args['status'] = '1'; } else { $args['status'] = input_check($args['status']); }

	/// query string
	$query_str = "SELECT * FROM ".dbname('accounts')." WHERE status='".$args['status']."' ";
	
		// %s% antarı var ise arama yapalim
		if(isset($args['s'])) {
			if($args['db-s-where'] == 'all') {
				$query_str .= "AND ( name LIKE '%".$args['s']."%' ";
				$query_str .= "OR code LIKE '%".$args['s']."%' ";
				$query_str .= "OR gsm LIKE '%".$args['s']."%' ";
				$query_str .= "OR phone LIKE '%".$args['s']."%' ";
				$query_str .= " ) ";
			} else {
				$query_str .= "AND ( ".$args['db-s-where']." LIKE '%".$args['s']."%' )";
			}
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
	


	if($query = db()->query($query_str)) { // sayfalama icin sorgu yapalim
		$return->num_rows = $query->num_rows; // toplam kayit sayisi

		if($return->num_rows > 0) {
			$query = db()->query($query_str_real); // listeleme icin sorgu yapalim
			$return->display_num_rows = $query->num_rows; // gosterilen kayit sayisi
			
			while($account = $query->fetch_assoc())
			{
				$return->list[] = $account;
			}

			return $return;
		} else {
			add_alert('Aradığınız kriterlere uygun hesap kartları bulunamadı.', 'warning', 'get_accounts');
			return false;
		}
	} else {
		$error_msg = db()->error;
		add_alert('<b>Veritabanı hatası:</b> '.$error_msg, 'danger', 'get_accounts');
		add_log( array('log_key'=>'mysqli_error', 'log_text'=>$error_msg) );
		return false;
	}

}






/**
 * calc_account()
 * hesap kartlarinin bakiyelerini hesaplar
 */
function calc_account($id) {
	if($account = get_account($id)) {
		$in = 0;
		$out = 0;

		// giris hareketlerini toplayalim
		if($q_select_sum = db()->query("SELECT sum(total) as total,sum(profit) as profit FROM ".dbname('forms')." WHERE type IN ('form', 'salary') AND in_out='0' AND account_id='".$account->id."' ")) {
			if($q_select_sum->num_rows) {
				$in = $q_select_sum->fetch_object();
			}
		} else { add_mysqli_error_log(__FUNCTION__); }
		

		// cikis hareketlerini toplayalim
		if($q_select_sum = db()->query("SELECT sum(total) as total,sum(profit) as profit FROM ".dbname('forms')." WHERE type IN ('form', 'salary') AND in_out='1' AND account_id='".$account->id."' ")) {
			if($q_select_sum->num_rows) {
				$out = $q_select_sum->fetch_object();
			}
		} else { add_mysqli_error_log(__FUNCTION__); }




		// net bakiye
		$balance = $out->total - $in->total;


		// odemeler icin giris cikis
		if($q_select_sum = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE type='payment' AND in_out='0' AND account_id='".$account->id."' ")) {
			if($q_select_sum->num_rows) {
				$in_payment = $q_select_sum->fetch_object();
				$balance = $balance - $in_payment->total;
			}
		} else { add_mysqli_error_log(__FUNCTION__); }

		// odemeler icin
		if($q_select_sum = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE type='payment' AND in_out='1' AND account_id='".$account->id."' ")) {
			if($q_select_sum->num_rows) {
				$out_payment = $q_select_sum->fetch_object();
				$balance = $balance + $out_payment->total;
			}
		} else { add_mysqli_error_log(__FUNCTION__); }


		

		// stok kartini guncelleyelim
		if($q_update = db()->query("UPDATE ".dbname('accounts')." SET 
			balance='".$balance."',
			profit='".$out->profit."'
			WHERE id='".$account->id."' ")) {
			return true;
		} else {
			return false;
		}

	} else {
		add_alert($id.' ID numaraları hesap kartı bulunamadı.', 'warning', __FUNCTION__);
		return false;
	}
} //.calc_account()





/**
 * get_account_code_generator()
 * veritabanına son eklenen hesap kartının ID numarasını alır ve +1 ekler
 */
function get_account_code_generator($account_id='') {
	$generator = true;
	if($account_id > 0) {
		$code = 'TILA-'.$account_id;
		$query = db()->query("SELECT id FROM ".dbname('accounts')." WHERE code='".$code."' AND id NOT IN ('".$account_id."') ");
		if($query->num_rows) {
			$generator = true;
		} else {
			$generator = false;
			return $code;
		}
	} 
	if($generator == true) {
		$query = db()->query("SELECT id FROM ".dbname('accounts')." ORDER BY id DESC LIMIT 1 ");
		$query = $query->fetch_object();
		return 'TILA-'.(@$query->id + 1);
	}
	
}







?>