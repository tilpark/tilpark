<?php

/* --------------------------------------------------- FORM */


/**
 * insert_form()
 * form tablosuna kontrolsuz veri ekle
 */
function insert_form($args) {
	$args 	= _args_helper(input_check($args), 'insert');
	$insert = $args['insert'];

	if(!isset($insert['date'])) { $insert['date'] = date('Y-m-d H:i'); }

	@form_validation($insert['date'], 'date', 'Tarih', 'datetime', __FUNCTION__);

	if( !is_alert(__FUNCTION__) ) {
		if( $q_insert = db()->query("INSERT INTO ".dbname('forms')." ".sql_insert_string($insert)." ") ) {
			if( $insert_id = db()->insert_id ) {
				return $insert_id;
			}
		} else { add_mysqli_error_log(__FUNCTION__); }
	} else { return false; }
} //.insert_form()






/**
 * set_form()
 * bir form kartını oluşturur veya günceller
 */
function set_form($id, $args=array()) {

	$location = false; // eger ilk defa form olusoyor ise form ID'si ile birlikte yonlendirme yapacagiz
	$operation = ''; 
	if(empty($id)) { $operation = 'add'; } else { $operation = 'update'; }

	// input_check
	$id 	= input_check($id);
	$args 	= _args_helper(input_check($args), 'set');
	$set 	= $args['set'];




	if(!have_log()) { // eger daha onceden eklenmemis ise log kaydi bulunmayacaktir.

		
		@form_validation($set['account_code'], 'account_code', 'Hesap Kodu', 'min_length[3]|max_length[32]', __FUNCTION__);
		@form_validation($set['account_name'], 'account_name', 'Hesap Adı', 'min_length[3]|max_length[32]', __FUNCTION__);
		@form_validation($set['account_gsm'], 'account_gsm', 'Cep Telefonu', 'gsm|min_length[10]|max_length[20]', __FUNCTION__);
		@form_validation($set['account_phone'], 'account_phone', 'Sabit Telefon', 'number|min_length[10]|max_length[20]', __FUNCTION__);
		@form_validation($set['account_email'], 'account_email', 'E-posta', 'email|min_length[3]|max_length[100]', __FUNCTION__);
		@form_validation($set['account_address'], 'account_address', 'Adres', 'min_length[3]|max_length[500]', __FUNCTION__);
		@form_validation($set['account_district'], 'account_district', 'İlçe', 'min_length[3]|max_length[20]', __FUNCTION__);
		@form_validation($set['account_city'], 'account_city', 'Şehir', 'min_length[3]|max_length[20]', __FUNCTION__);
		@form_validation($set['account_country'], 'account_country', 'Ülke', 'min_length[3]|max_length[30]', __FUNCTION__);
		@form_validation($set['account_tax_home'], 'account_tax_home', 'Vergi Dairesi', 'min_length[3]|max_length[30]', __FUNCTION__);
		@form_validation($set['account_tax_no'], 'account_tax_no', 'Vergi veya T.C.', 'min_length[10]|max_length[11]', __FUNCTION__);

		if($operation == 'add') {
			if(!isset($set['date'])) { $set['date'] = date('Y-m-d H:i'); }
			@form_validation($set['date'], 'date', 'Tarih', 'required|datetime', __FUNCTION__);

			if(!isset($set['in_out'])) { $set['in_out'] = '0'; }
			if($set['in_out'] != '0' and $set['in_out'] != '1') {
				add_alert('Giriş çıkış türü yanlış', 'danger', __FUNCTION__);
				return false;
			}
		}

		if(!is_alert(__FUNCTION__)) {
			
			$_form = array();
			$_form['date']				= @$set['date'];
			$_form['in_out']			= @$set['in_out'];
			$_form['account_id']		= @$set['account_id'];
			$_form['account_code'] 		= @$set['account_code'];
			$_form['account_name'] 		= @til_get_strtoupper($set['account_name']);
			$_form['account_gsm'] 		= @$set['account_gsm'];
			$_form['account_phone'] 	= @$set['account_phone'];
			$_form['account_email'] 	= @til_get_strtolower($set['account_email']);
			$_form['account_city'] 		= @til_get_strtoupper($set['account_city']);
			$_form['account_tax_home']	= @til_get_strtoupper($set['account_tax_home']);
			$_form['account_tax_no'] 	= @$set['account_tax_no'];



			$_form_meta['account_country'] 	= @til_get_strtoupper(@$set['account_country']);
			$_form_meta['account_district'] = @til_get_strtoupper($set['account_district']);
			$_form_meta['account_address'] 	= @til_get_strtoupper($set['account_address']);
			$_form_meta['note']	 	= @til_get_strtoupper($set['note']);

			$_form['val_1'] 	= @$set['val_1'];
			$_form['val_2'] 	= @$set['val_2'];
			$_form['val_3'] 	= @$set['val_3'];
			$_form['val_int'] 	= @$set['val_int'];
			$_form['val_date'] 	= @$set['val_date'];

			// yeni bir hesap kartı olusturulsun mu?
			if(isset($set['new_account'])) {
				$_account['name'] = $_form['account_name'];
					if(empty($_form['account_gsm'])) { $_form['account_gsm'] = '5300000000'; }
				$_account['gsm'] 	= $_form['account_gsm'];
				$_account['phone'] 	= $_form['account_phone'];
				$_account['email'] 	= $_form['account_email'];
				$_account['address'] 	= $_form_meta['account_address'];
				$_account['district'] 	= $_form_meta['account_district'];
				$_account['city'] 		= $_form['account_city'];
				$_account['country'] 	= $_form_meta['account_country'];
				$_account['tax_home'] 	= $_form['account_tax_home'];
				$_account['tax_no'] 	= $_form['account_tax_no'];

				if($account_id = add_account($_account)) {
					$account = get_account($account_id);
					$_form['account_id'] = $account->id;
					$_form['account_code'] = $account->code;
					$_form['account_name'] = $account->name;
				} else { add_alert('Form için hesap kartı oluşturulurken hata meydana geldi.', 'danger', __FUNCTION__); return false; }
			}

			// serbest satis mi?
			if( empty($_form['account_code']) and empty($_form['account_name']) ) {
				$_form['account_id']	= '0';
				$_form['account_name'] = 'PERAKENDE SATIS';
			} elseif(!empty($_form['account_code'])) {
				if($account = get_account(array('code'=>$_form['account_code'])) ){
					$_form['account_id']		= $account->id;
					$_form['account_name'] 		= $account->name;
					$_form['account_gsm'] 		= $account->gsm;
					$_form['account_phone'] 	= $account->phone;
					$_form['account_email'] 	= $account->email;
					$_form['account_city'] 		= $account->city;
					$_form['account_tax_home'] 	= $account->tax_home;
					$_form['account_tax_no'] 	= $account->tax_no;
				} else { add_alert('"<b>'.$_form['account_code'].'</b>" hesap kodu bulunamadı.', 'danger', __FUNCTION__); return false; }
			}



			// eger ilk defa form oluscak ise
			if($operation == 'add' and !is_alert(__FUNCTION__)) {
				// form status
				$form_status 		= get_form_status(array('val_5'=>'default', 'val_enum'=>$_form['in_out']));
				$_form['status_id']	= $form_status->id;
				$_form['user_id']	= get_active_user('id');
				$_form['date_updated'] = date("Y-m-d H:i:s");

				if($q_insert = db()->query("INSERT INTO ".dbname('forms')." ".sql_insert_string($_form)." ")) {
					if(db()->affected_rows) {
						$insert_id = db()->insert_id;
						add_alert('Form oluşturuldu.', 'success', __FUNCTION__);
						add_log(array('uniquetime'=>@$set['uniquetime'], 'table_id'=>'forms:'.$insert_id, 'log_key'=>__FUNCTION__, 'log_text'=>'Form oluşturuldu.'));
						$form = get_form($insert_id);

					} else {
						add_alert('Bilinmeyen bir hata: Form oluşumunda herhangi bir işlem gerçekleşmedi.', 'warning', __FUNCTION__);
						return false;
					}
				} else { add_mysqli_error_log(__FUNCTION__); }
			} // if($operation == 'add')


			if(!isset($form->id)) {
				if(!$form = get_form($id)) {
					add_alert('Betik durduruldu. Form öğesi bulunamadı.', 'danger', __FUNCTION__);
					return false;
				}
			}
			

			// form meta guncele
			update_form_meta($form->id, 'district', $_form_meta['account_district']);
			update_form_meta($form->id, 'address', $_form_meta['account_address']);
			update_form_meta($form->id, 'country', $_form_meta['account_country']);
			update_form_meta($form->id, 'note', $_form_meta['note']);


			// eger form guncellenecek ise
			if($form and $operation == 'update' and !is_alert(__FUNCTION__, 'danger')) {

				$old_form = get_form($form->id, array('get_user_access'=>false) );
				print_r($_form);
				if($q_update = db()->query("UPDATE ".dbname('forms')." SET ".sql_update_string($_form)." WHERE id='".$form->id."' ")) {
					if(db()->affected_rows) {
						$new_form = get_form($form->id, array('get_user_access'=>false) );
						add_alert('Form güncellendi.', 'success', __FUNCTION__);
						add_log(array('uniquetime'=>@$set['uniquetime'], 'table_id'=>'forms:'.$id, 'log_key'=>__FUNCTION__, 'log_text'=>'Form güncellendi.', 'meta'=>log_compare($old_form, $new_form)));
						
						// tarih bilgisini tekrar guncelleyelim
						// bunu neden yapiyoruz? her form guncellemesinde set_form() fonksiyonu calismaktadir burada ise eger guncelleme olmus ise tarih bilgisini guncelleyelim
						$_form['date_updated'] = date("Y-m-d H:i:s");
						$q_update = db()->query("UPDATE ".dbname('forms')." SET ".sql_update_string($_form)." WHERE id='".$form->id."' ");

					} else { return false; }
				} else { add_mysqli_error_log(__FUNCTION__); }
			}



			



			/* 	eger set_form() form ile birlikte eklenmesi gereken form hareketleri var ise onlarida ekleyelim 
				ekleme isleminden sonra $form->id dondurelim */
			if(!empty($set['item_code']) or !empty($set['item_name'])) {
				$form_item = array();
				$form_item['uniquetime']	= $set['item_uniquetime'];
				$form_item['in_out']		= $form->in_out;
				$form_item['form_id'] 		= $form->id;
				$form_item['account_id']	= $form->account_id;
				$form_item['item_code'] 	= $set['item_code'];
				$form_item['item_name']		= til_get_strtoupper($set['item_name']);
				$form_item['quantity']		= $set['quantity'];
				$form_item['price']			= $set['price'];
				$form_item['vat']			= $set['vat'];

				if(add_form_item($form->id, $form_item)) {
					return $form->id;
				} else {
					return false;
				}
			} else { return $form->id; }


		} else { return false; } // /.is_alert()
	} else { repetitive_operation(__FUNCTION__); } // !have_log()
} //.set_form()






/**
 * update_form()
 * form gunceller
 */
function update_form($id, $args=array()) {

	$id = input_check($id);
	$args 	= _args_helper(input_check($args), 'update');
	$update = $args['update'];

	if(!isset($update['date_updated'])) { $update['date_updated'] = date("Y-m-d H:i:s"); }

	if(!have_log()) { // eger daha onceden eklenmemis ise log kaydi bulunmayacaktir.
		if($old_form = get_form($id)) {
			if($q_update = db()->query("UPDATE ".dbname('forms')." SET ".sql_update_string($update)." WHERE id='".$id."'")) {
				if(db()->affected_rows) {
					$new_form = get_form($id, array('get_user_access'=>false) );
					if($args['add_alert']) { add_alert('Form güncellendi.', 'success', __FUNCTION__); }
					if($args['add_log']) { add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'forms:'.$id, 'log_key'=>__FUNCTION__, 'log_text'=>'Form güncellendi.', 'meta'=>log_compare($old_form, $new_form))); }
					return true;
				} else { return false; }
			} else { add_mysqli_error_log(__FUNCTION__); }
		} else { return false; }
	} else { return false; }
}






/**
 * get_form()
 * form kartini dondurur
 */
function get_form($id_or_query, $args=array() ) {
	if(is_array($id_or_query)) { $where = $id_or_query; } else { $where['id'] = $id_or_query; }

	if($query = db()->query("SELECT * FROM ".dbname('forms')." ".sql_where_string($where)." ")) {
		if($query->num_rows) {
			$return = $query->fetch_object();
			return $return;
		} else {
			add_alert('Aradığınız kriterlere uygun form bulunamadı. Şu anda <b>"'.$where['id'].'"</b> ID numaralı formu sorguluyorsunuz.', 'warning', __FUNCTION__);
			return false;
		}
	} else { add_mysqli_error_log(__FUNCTION__); }
} // .get_form()






/**
 * get_forms()
 * tum formları listeler
 */
function get_forms($args=array()) {
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
		if(!isset($args['type'])) 		{ $args['type'] = 'form'; } else { $args['type'] = input_check($args['type']); }

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
			add_alert('Aradığınız kriterlere uygun ürün kartları bulunamadı.', 'warning', __FUNCTION__);
			return false;
		}
	} else {
		add_mysqli_error_log(__FUNCTION__);
	}
}






/**
 * calc_form()
 * formun tum hareketlerini hesaplar
 */
function calc_form($id) {
	$id = input_check($id);
	if($form = get_form($id)) {

		$count = 0;
		if($q_select_count = db()->query("SELECT id FROM ".dbname('form_items')." WHERE status='1' AND form_id='".$form->id."' ")) {
			$count = $q_select_count->num_rows;
		}

		if($q_select_sum = db()->query("SELECT sum(total) as total,sum(vat_total) as vat_total,sum(quantity) as quantity,sum(profit) as profit FROM ".dbname('form_items')." WHERE status='1' AND form_id='".$form->id."' ")) {
			if($q_select_sum->num_rows) {
				$result = $q_select_sum->fetch_object();

				if($q_update_sum = db()->query("UPDATE ".dbname('forms')." SET total='".$result->total."', 
					profit='".$result->profit."',
					item_count='".$count."',
					item_quantity='".$result->quantity."' WHERE id='".$form->id."'")) {
					return true;
				} else { add_mysqli_error_log(__FUNCTION__); }

			} else {

			}
		} else { add_mysqli_error_log(__FUNCTION__); }
	} else {
		add_console_log($id.' ID numaraları form bulunamadı.', __FUNCTION__);
		return false;
	}
} //.calc_form()






/**
 * get_in_out_label()
 * Giriş çıkış türlerinin isimlerini dondurur
 */
function get_in_out_label($in_out) {
	$label = '';
	if($in_out == '0') {
		$label = 'Giriş';
	} elseif($in_out == '1') {
		$label = 'Çıkış';
	} else {
		$label = 'Bilinmiyor';
	}

	return $label;
} //.get_in_out_label()



















/* --------------------------------------------------- FORM ITEM */


/**
 * insert_form_item()
 * bir form kaydi olustur
 */
function insert_form_item($args) {
	$args 	= _args_helper(input_check($args), 'insert');
	$insert = $args['insert'];


	if(!isset($args['uniquetime'])) { $args['uniquetime'] = ''; }
	if(!isset($insert['form_id'])) { add_alert('Parametre Hatası: Form ID bos olamaz.'); return false; }

	if(!have_log($args['uniquetime'])) { // eger daha onceden eklenmemis ise log kaydi bulunmayacaktir.

		if(!$form = get_form($insert['form_id'])) {
			add_alert(_b($insert['form_id']).' Form ID bulunamadı.', 'warning', __FUNCTION__); return false; }

		
		@form_validation($insert['date'], 'date', 'Tarih', 'datetime', __FUNCTION__);	
		@form_validation($insert['item_code'], 'item_code', 'Ürün Kodu', 'min_length[3]|max_length[32]', __FUNCTION__);	
		@form_validation($insert['quantity'], 'quantity', 'Adet', 'required|number|min_length[1]|max_length[10]', __FUNCTION__);
		@form_validation($insert['price'], 'price', 'Fiyat', 'money|min_length[1]|max_length[10]', __FUNCTION__);
		@form_validation($insert['vat'], 'vat', 'KDV', 'number|min_length[1]|max_length[10]', __FUNCTION__);
		print_alert();
		if(!is_alert(__FUNCTION__)) {

			# gerekli kontroller
			if(!isset($insert['date'])) { $insert['date'] = date('Y-m-d H:i:s'); }
			if(!isset($insert['price'])) { $insert['price'] = '0.00'; }
			if(!isset($insert['price'])) { $insert['price'] = '0.00'; }
			if(!isset($insert['vat'])) { $insert['vat'] = '0'; }

			$insert['price'] 		= get_set_decimal_db($insert['price']);
			$insert['total'] 		= $insert['price'] * $insert['quantity'];
			$insert['vat_total'] 	= $insert['total'] - ($insert['total'] / get_set_vat($insert['vat']) );


			if($q_insert = db()->query("INSERT INTO ".dbname('form_items')." ".sql_insert_string($insert)." ")) {
				if($insert_id = db()->insert_id) {
					return $insert_id;
				} else { return false; }
			} else { add_mysqli_error_log(__FUNCTION__); return false; }
		} else { return false; }
	} else { repetitive_operation(__FUNCTION__); } // !have_log()
}




/**
 * add_form_item()
 * form_item tablosuna eleman ekler
 */
function add_form_item($form_id, $args=array(), $opt=array()) {

	if(!isset($args['uniquetime'])) { $args['uniquetime'] = ''; }

	if(!have_log($args['uniquetime'])) { // eger daha onceden eklenmemis ise log kaydi bulunmayacaktir.

		if(!$form = get_form($form_id)) {
			add_alert('"<b>'.$form_id.']</b>" Form ID bulunamadı.', 'warning', __FUNCTION__);
			return false;
		}

		$args = input_check($args);

		if(empty($args['item_name']) and empty($args['item_code'])) {
			@form_validation($args['item_name'], 'item_name', 'Ürün Adı', 'required|min_length[3]|max_length[32]', __FUNCTION__);
		} else if(!empty($args['item_code'])) {
			@form_validation($args['item_name'], 'item_name', 'Ürün Adı', 'min_length[3]|max_length[32]', __FUNCTION__);
		}

		@form_validation($args['item_code'], 'item_code', 'Ürün Kodu', 'min_length[3]|max_length[32]', __FUNCTION__);	
		@form_validation($args['quantity'], 'quantity', 'Adet', 'required|number|min_length[1]|max_length[10]', __FUNCTION__);
		@form_validation($args['price'], 'price', 'Fiyat', 'money|min_length[1]|max_length[10]', __FUNCTION__);
		@form_validation($args['vat'], 'vat', 'KDV', 'number|min_length[1]|max_length[10]', __FUNCTION__);


		if(!empty($args['item_code'])) {
			if(!$item = get_item(array('code'=>$args['item_code']))) {
				add_alert('"<b>'.$args['item_code'].'</b>" ürün kodu, ürün kartları arasında bulunamadı.', 'danger', __FUNCTION__);
			} else {
				$args['item_id']		= $item->id;
				$args['item_name'] 		= $item->name;
				$args['item_p_purc'] 	= get_set_decimal_db($item->p_purc);
				$args['item_p_sale'] 	= get_set_decimal_db($item->p_sale);

				if($args['quantity'] < 0) { $args['quantity'] = 1;}
				if($args['price'] < 0.01) { if($form->in_out == '0') { $args['price'] = $item->p_purc; } else { $args['price'] = $item->p_sale; }  }
				if($args['vat'] < 1) { $args['vat'] = $item->vat; }

				$args['profit'] = ( ($args['price'] / get_set_vat($args['vat'])) * $args['quantity'] ) - ( ($args['item_p_purc'] / get_set_vat($args['vat'])) * $args['quantity'] );
			}
		}

		if(!is_alert(__FUNCTION__)) {

			$args['price'] = get_set_decimal_db($args['price']);

			$args['total'] 		= $args['price'] * $args['quantity'];
			$args['vat_total'] 	= $args['total'] - ($args['total'] / get_set_vat($args['vat']) );



			if($q_insert = db()->query("INSERT INTO ".dbname('form_items')." ".sql_insert_string($args)." ")) {
				if(db()->affected_rows) {
					$insert_id = db()->insert_id;
					add_alert('Ürün eklendi.', 'success', __FUNCTION__);
					add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'forms:'.$args['form_id'], 'log_key'=>__FUNCTION__, 'log_text'=>'Ürün hareketi eklendi. <small class="text-muted">'.$args['item_name'].'</small>'));
					
					// urun stok guncellemesi
					if(isset($args['item_id']) and $args['item_id'] > 0) { calc_item($args['item_id']); }
					
					return $insert_id;
				} else {
					add_alert('Bilinmeyen bir hata: Ürün eklenirken herhangi bir işlem gerçekleşmedi.', 'warning', __FUNCTION__);
					return false;
				}
			} else { add_mysqli_error_log(__FUNCTION__); }
		} // !is_alert()
	} else { repetitive_operation(__FUNCTION__); } // !have_log()
} //.add_form_item()






/**
 * delete_form_item()
 * bir form hareketini siler
 */
function delete_form_item($form_id, $id) {
	$form_id = input_check($form_id);
	$id = input_check($id);

	if(get_form($form_id)) {

		if($q_select = db()->query("SELECT * FROM ".dbname('form_items')." WHERE form_id='".$form_id."' AND id='".$id."' ")) {
			if($q_select->num_rows > 0) {
				$form_item = $q_select->fetch_object();
				if($q_update = db()->query("UPDATE ".dbname('form_items')." SET status='0' WHERE form_id='".$form_id."' AND id='".$id."' ")) {
					if(db()->affected_rows) {
						add_alert('"<b>'.$form_item->item_name.'</b>" ürün harekti silindi.', 'warning', __FUNCTION__);
						add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'forms:'.$form_id, 'log_key'=>__FUNCTION__, 'log_text'=>'Ürün hareketi silindi. <small class="text-muted">'.$form_item->item_name.'</small>'));
					} else {
						return false;
					}
				} else {
					add_mysqli_error_log(__FUNCTION__);
				}
			} else {
				add_alert('Siinecek form hareketi bulunamadı.', 'danger', __FUNCTION__);
				return false;
			}
			
		} else {
			add_mysqli_error_log(__FUNCTION__);
		}

		
	}
}






/**
 * get_form_items()
 * urun kartlarini listeler, sonucları obj olarak dondurur
 */
function get_form_items($form_id, $opt=array()) {
	$return = new StdClass;


	// required
	if(!isset($opt['status'])) 	{ $opt['status'] = '1'; } else { $opt['status'] = input_check($opt['status']); }

	// query string
	$query_str = "SELECT * FROM ".dbname('form_items')." WHERE status='".$opt['status']."' AND form_id='".$form_id."' ";
	

	if($query = db()->query($query_str)) { // sayfalama icin sorgu yapalim
		$return->num_rows = $query->num_rows; // toplam kayit sayisi

		if($return->num_rows > 0) {
			while($item = $query->fetch_object())
			{
				$item = get_user_access($item, '', 'form_items'); // kullanici erisim kontrolu
				$return->list[] = $item;
			}

			return $return;
		} else {
			add_alert('Bu form için herhangi bir ürün hareketi bulunamadı.', 'warning', __FUNCTION__);
			return false;
		}
	} else { add_mysqli_error_log(__FUNCTION__); }
}









/* --------------------------------------------------- FORM META */


/**
 * add_form_meta()
 * bir form tablosuna ait meta bilgisi ekler
 */
function add_form_meta($form_id, $meta_key, $meta_value) {
	$form_id 	= input_check($form_id);
	$meta_key 	= input_check($meta_key);
	$meta_value = input_check($meta_value);

	$alert_rnd = rand(1000,1000000);

	@form_validation($form_id, 'form_id', 'Form ID', 'required', __FUNCTION__.'-'.$alert_rnd);
	@form_validation($meta_key, 'meta_key', 'Meta Anahtarı', 'required', __FUNCTION__.'-'.$alert_rnd);

	if(!is_alert(__FUNCTION__.'-'.$alert_rnd)) {

		if($form = get_form($form_id)) {

			// daha onceden eklenmis mi?
			if($q_select = db()->query("SELECT * FROM ".dbname('form_meta')." WHERE form_id='".$form_id."' AND meta_key='".$meta_key."' AND meta_value='".$meta_value."'  ")) {
				if($q_select->num_rows) {
					add_console_log($insert['name'].' form ek bilgi anahtarı, daha önceden eklenmiş.', __FUNCTION__);
					return false;
				} else {

					if($q_insert = db()->query("INSERT INTO ".dbname('form_meta')." ".sql_insert_string(array('form_id'=>$form_id, 'meta_key'=>$meta_key, 'meta_value'=>$meta_value))." ")) {
						if(db()->insert_id) {
							$insert_id = db()->insert_id;
							return $insert_id;
						} else { return false; }
					} else { add_mysqli_error_log(__FUNCTION__); }

				} //.q_select->num_rows
			} else { add_mysqli_error_log(__FUNCTION__); }
		} else { add_console_log('Form bulunamadı', 'warning', __FUNCTION__); return false;  }

	} else { return false; }
} //.add_form_meta()






/**
 * update_form_meta()
 * form_meta tablosundan veri gunecller
 */
function update_form_meta($form_id, $meta_key, $meta_value) {

	$form_id 	= input_check($form_id);
	$meta_key 	= input_check($meta_key);
	$meta_value = input_check($meta_value);

	$alert_rnd = rand(1000,1000000);

	@form_validation($form_id, 'form_id', 'Form ID', 'required', __FUNCTION__.'-'.$alert_rnd);
	@form_validation($meta_key, 'meta_key', 'Meta Anahtarı', 'required', __FUNCTION__.'-'.$alert_rnd);

	if(!is_alert(__FUNCTION__.'-'.$alert_rnd)) {

		if($form = get_form($form_id)) {

			// daha onceden eklenmis mi?
			if($q_select = db()->query("SELECT * FROM ".dbname('form_meta')." WHERE form_id='".$form_id."' AND meta_key='".$meta_key."'")) {
				if($q_select->num_rows) {
					$found_meta_id = $q_select->fetch_object()->id;
					if($q_insert = db()->query("UPDATE ".dbname('form_meta')." SET ".sql_update_string(array('meta_key'=>$meta_key, 'meta_value'=>$meta_value))." WHERE id='".$found_meta_id."'  ")) {
						if(db()->affected_rows) {
							return true;
						} else { return false; }
					} else { add_mysqli_error_log(__FUNCTION__); }

				} else {

					add_form_meta($form_id, $meta_key, $meta_value);

				} //.q_select->num_rows
			} else { add_mysqli_error_log(__FUNCTION__); }
		} else { add_console_log('Form bulunamadı', 'warning', __FUNCTION__); return false;  }

	} else { return false; }
} //.update_form_meta()






/**
 * delete_form_meta()
 * form_meta tablosundan bir oge siler
 */
function delete_form_meta($form_id, $args=array()) {

	$form_id 	= input_check($form_id);

	if(empty($args)) {
		$args 		= _args_helper(input_check($args), 'where');
		$meta_id = $form_id;
		if($q_delete = db()->query("DELETE FROM ".dbname('form_meta')." WHERE id='".$meta_id."' ")) {
			if(db()->affected_rows) { if($args['add_alert']) { add_alert('Form ek bilgisi silindi.', 'warning', __FUNCTION__); } }
			return true;
		} else { add_mysqli_error_log(__FUNCTION__); }
		return true;
	} // empty($args)

	$args 		= _args_helper(input_check($args), 'where');
	$where 		= $args['where'];

	if($form = get_form($form_id)) {
		
		// required
		if(!isset($where['taxonomy'])) { $where['taxonomy'] = ''; }
		$where['form_id'] = $form_id;

		// daha onceden eklenmis mi?
		if($q_delete = db()->query("DELETE FROM ".dbname('form_meta')." ".sql_where_string($where)." ")) {
			if(db()->affected_rows) { if($args['add_alert']) { add_alert('Form ek bilgisi silindi.', 'warning', __FUNCTION__); } }
			return true;
		} else { add_mysqli_error_log(__FUNCTION__); }

	} else { if($args['add_alert']) { add_alert('Form bulunamadı', 'warning', __FUNCTION__); } return false;  }
} //.delete_form_meta()






/**
 * get_form_meta()
 * form meta bilgisini dondurur
 */
function get_form_meta($form_id, $meta_key=false) {
	$form_id 	= input_check($form_id);
	$meta_key 	= input_check($meta_key);
	
	// required
	$where['form_id'] 	= $form_id;
	if($meta_key) {
		$where['meta_key']	= $meta_key;
	}

	if($q_select =  db()->query("SELECT * FROM ".dbname('form_meta')." ".sql_where_string($where)." ")) {
		if($q_select->num_rows) {
			if($q_select->num_rows == 1) {
				$return = $q_select->fetch_object();
			} else {
				$return = new stdclass;
				while( $list = $q_select->fetch_object() ) {
					$return->{$list->meta_key} = $list->meta_value;
				}
			}
			
			return $return;
		} else { return false; }
	} else { add_mysqli_error_log(__FUNCTION__); }


} //.get_form_meta()






/**
 * get_form_metas()
 * form meta bilgilerinin hepsini dondurur
 */
function get_form_metas($form_id) {
	$form_id 	= input_check($form_id);
	$args 		= _args_helper(input_check($args), 'where');
	$where 		= $args['where'];


	$where['form_id'] = $form_id;
	if($q_select = db()->query("SELECT * FROM ".dbname('form_meta')." ".sql_where_string($where)." ")) {
		if($q_select->num_rows) {
			$return = array();
			while($list = $q_select->fetch_object()) {
				if(empty($list->taxonomy)) {
					$return[$list->name] = $list;
				} else {
					$return[$list->taxonomy][$list->name] = $list;
				}
				
			}
			return $return;
		} else { return false; }
	} else { add_mysqli_error_log(__FUNCTION__); }
}










/* --------------------------------------------------- FORM STATUS */


/**
 * add_form_status()
 * form statusu ekler
 */
function add_form_status($args=array()) {
	if(!have_log(@$args['uniquetime'])) {
		$args = _args_helper(input_check($args), 'insert');
		$insert = $args['insert'];

		@form_validation($insert['taxonomy'], 'taxonomy', 'Sınıflandırma (taxonomy)', 'required|min_length[3]|max_length[64]', __FUNCTION__);
		if(!is_alert(__FUNCTION__)) {

			$_insert = _set_form_status_args($insert);

			$_insert = array('insert'=>$_insert);
			$_insert['add_alert'] 	= false;
			$_insert['add_log'] 	= false;
			$_insert['uniquetime']  = @$args['uniquetime'];

			if($extra_id = add_extra($_insert)) {
				$fs_cat_name = til()->form_status[$insert['taxonomy']]['name'];
				if($args['add_alert']) { add_alert(_b($fs_cat_name).' için '._b($_insert['insert']['name']).' form durumu eklendi.', "success", __FUNCTION__); }
				if($args['add_log']) { add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'extra:'.$extra_id, 'log_key'=>__FUNCTION__, 'log_text'=>_b($fs_cat_name).' için '._b($_insert['insert']['name']).' form durumu eklendi.')); }
				return $extra_id;
			} else { return false;}
		}
	} else { repetitive_operation(__FUNCTION__); }
} //.add_form_status()






/** 
 * get_form_status()
 * form durmunu dondurur
 */
function get_form_status($args=array()) {


	if( !is_array($args) ) { $args = array('id'=>$args); }
	$args 	= _args_helper(input_check($args), 'where');
	$_where 	= $args['where'];
	// gelen degeleri veritabanı tablo isimlerine gore eslestirelim
	$_where 	= _set_form_status_args($_where);
	// $args dizisi ile birlestirelim ki get_extra aynı $args verisini gonderelim
	$_where 	= array_merge($_where, _set_form_status_args($args['where'],true));
	
	if(isset($where['id'])) { unset($where['taxonomy']); }


	$return = new stdClass;
	if($form_status = get_extra($_where)) {
		$return->id 	= $form_status->id;
		$return->taxonomy 	= $form_status->taxonomy;
		$return->name 		= $form_status->name;
		$return->color 		= $form_status->val_1;
		$return->bg_color 	= $form_status->val_2;
		$return->auto_mail 	= $form_status->val_3;
		$return->auto_sms 	= $form_status->val_4;
		$return->is_default 	= $form_status->val_5;
		$return->sms_template 	= $form_status->val_9;
		$return->mail_template 	= $form_status->val_text;
		$return->count 			= $form_status->val_int;
		$return->total 			= $form_status->val_decimal;
		$return->in_out 		= $form_status->val_enum;
		return $return;
	} else { return false; }
} //.get_form_status()






/** 
 * update_form_status()
 * bir form durumunu gunceller
 */
function update_form_status($where, $args) {
	
	if( !is_array($where) ) { $where = array('id'=>$where); }
	$where 	= input_check($where);
	$args 	= _args_helper(input_check($args), 'update');


	if(!have_log(@$args['uniquetime'])) {

		$_where 	= _set_form_status_args($where);
		$_where 	= array_merge($_where, _set_form_status_args($where, true));
		$_update 	= _set_form_status_args($args['update']);

		if($old_status = get_form_status($_where)) {
			

			if(isset($_update['val_5'])) {
				db()->query("UPDATE ".dbname('extra')." SET val_5='' WHERE taxonomy='".$old_status->taxonomy."' AND val_enum='".$old_status->in_out."' ");
			}

			// update extra parameters
			$_args = $args;
			$_args['update']	= $_update;
			$_args['add_alert'] = false;
			$_args['add_log'] 	= false;

			
			
			if($extra_id = update_extra($_where, $_args)) {
				if($extra = get_form_status($extra_id)) {
					$fs_cat_name = til()->form_status[$extra->taxonomy]['name'];
					if($args['add_alert']) { add_alert(_b($fs_cat_name).' için '._b($extra->name).'</b>" form durumu güncellendi.', "success", __FUNCTION__); }
					if($args['add_log']) { add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'extra:'.$extra->id, 'log_key'=>__FUNCTION__, 'log_text'=> _b($fs_cat_name).' için '._b($extra->name).' form durumu güncellendi.')); }
					return $extra->id;
				}
			} else { return false; }
		} else { if($args['add_alert']) { add_alert('Güncellenecek form status öğesi bulunamadı.', "warning", __FUNCTION__); } return false; }

	} else { repetitive_operation(__FUNCTION__); }
}






/** 
 * get_form_status_all()
 * form durumlarını listeler
 */
function get_form_status_all($args=array()) {
	
	if(!is_array($args)) { if($args=='in' or $args=='0') { $args = array('in_out'=>'0'); } elseif($args=='out' or $args=='1') { $args = array('in_out'=>'1'); }  }

	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];

	if(!isset($where['taxonomy'])) { $where['taxonomy'] = 'til_fs_form'; }
	_set_form_status_default($where['taxonomy']);


	$where 	= _set_form_status_args($where);
	$where 	= array_merge($where, _set_form_status_args($where, true));

	$where = array('where'=>$where);
	$where['return'] = 'plural_object';

	if($form_status_all = get_extras($where)) {
		$_return = array();
		foreach($form_status_all as $status) {
			$return = new stdClass;
			$return->id 	= $status->id;
			$return->taxonomy 	= $status->taxonomy;
			$return->name 		= $status->name;
			$return->color 		= $status->val_1;
			$return->bg_color 	= $status->val_2;
			$return->auto_email = $status->val_3;
			$return->auto_sms 	= $status->val_4;
			$return->is_default 	= $status->val_5;
			$return->sms_template 	= $status->val_9;
			$return->mail_template 	= $status->val_text;
			$return->count 			= $status->val_int;
			$return->total 			= $status->val_decimal;
			$return->in_out 		= $status->val_enum;

			$_return[] = $return;
		}
		if(count($_return)) {
			return $_return;
		} else { return false; }
	} else { return false; }
} //.get_form_status_all()






/**
 * delete_form_status()
 * bir form status siler
 */
function delete_form_status($delete_status_id, $new_status_id, $args=array()) {


	$args = _args_helper(input_check($args));

	$new_status_id 	= input_check($new_status_id);
	$_args['where']['id'] = input_check($delete_status_id);
	$_args['add_log'] 	= false;
	$_args['add_alert'] = false;


	$delete_status = get_form_status($delete_status_id);
	$fs_cat_name = til()->form_status[$delete_status->taxonomy]['name'];

	if($new_status_id < 1 and calc_form_status($delete_status->id) > 0) {
		return false;
	}

	if(delete_extra($_args)) {

		_set_form_status_default($delete_status->taxonomy);

		if($new_status = get_form_status($new_status_id)) {
			if(db()->query("UPDATE ".dbname('forms')." SET status_id='".$new_status_id."' WHERE status_id='".$delete_status_id."' ")) {
 				if(db()->affected_rows) {
 					$fs_cat_name = til()->form_status[$delete_status->taxonomy]['name'];
					if($args['add_alert']) { add_alert(_b($fs_cat_name).' için '._b($delete_status->name).'</b>" form durumuna ait bütün formlar '.$new_status->name.' ile  değiştirildi.', "success", __FUNCTION__); }
					if($args['add_log']) { add_log(array('table_id'=>'extra:'.$extra->id, 'log_key'=>__FUNCTION__, 'log_text'=> _b($fs_cat_name).' için '._b($delete_status->name).'</b>" form durumuna ait bütün formlar '.$new_status->name.' ile  değiştirildi.')); }
 					return true;
 				} else { return false; }
			} else { add_mysqli_error_log(__FUNCTION__); }
		}

		
		if($args['add_alert']) { add_alert(_b($fs_cat_name).' için '._b($delete_status->name).'</b>" form durumu silindi.', "success", __FUNCTION__); }
		if($args['add_log']) { add_log(array('table_id'=>'extra:'.$delete_status->id, 'log_key'=>__FUNCTION__, 'log_text'=> _b($fs_cat_name).' için '._b($delete_status->name).' form durumu silindi.')); }
		return true;
	} else { return false; }
}






/** 
 * change_form_status()
 * form durumunu degistirir
 */
function change_form_status($form_id, $args) {

	$form_id = input_check($form_id);
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where']; 

	if(!isset($where['taxonomy'])) { $where['taxonomy'] = 'til_fs_form'; }

	if($form_status = get_form_status($where)) {

		$_args['update']['status_id'] = $form_status->id;
		$_args['add_log'] = false;
		if(update_form($form_id, $_args)) {
			add_alert('Form durumu "<b>'.$form_status->name.'</b>" olarak değiştirildi.', 'success', __FUNCTION__);
			add_log(array('table_id'=>'forms:'.$form_id, 'log_key'=>__FUNCTION__, 'log_text'=>'Form durumu "<b>'.$form_status->name.'</b>" olarak değiştirildi.'));
			return true;
		} else { return false; }
	} else { return false; }
}






/** 
 * calc_form_status()
 * form durumlarına ait formların sayısını alır
 */
function calc_form_status($id_or_arr) {
	if($status = get_form_status($id_or_arr)) {
		if($q_sum = db()->query("SELECT * FROM ".dbname('forms')." WHERE status_id='".$status->id."' ")) {
			if($q_sum->num_rows) {
				$count = $q_sum->num_rows;
			} else { $count = 0; }

			if($status->count != $count) {
				$args['update']['taxonomy'] = $status->taxonomy;
				$args['update']['count'] 	= $count;
				$args['add_new'] = false;
				$args['add_alert'] = false;
				$args['add_log'] = false;
				update_form_status($id_or_arr, $args);
			}

			return $count;
		} else { add_mysqli_error_log(__FUNCTION__); }
	}
}






/**
 * get_form_status_span()
 * bir form status ogesini css stili ile birlikte dondurur
 */
function get_form_status_span($form_status, $args=array()) {

	if(@$args['short']) {
		$explode = explode(' ', $form_status->name);
		$title = '';
		foreach($explode as $exp) {
			$title .= substr($exp,0,1);
		}
		$return = '<span class="label label-primary" style="display:inline-block; background-color:'.$form_status->bg_color.'; color:'.$form_status->color.'; width:30px; height:16px; font-size:11px;" title="'.$form_status->name.'">'.$title.'</span>';
	} else {
		$return = '<span class="label label-primary" style="display:inline-block; background-color:'.$form_status->bg_color.'; color:'.$form_status->color.';">'.$form_status->name.'</span>';
	}

	
	return $return;
}





/** 
 * _set_form_status_default()
 * form status verileri icin eger yok ise default/varsayilan ogeyi secer
 */
function _set_form_status_default($_taxonomy) {

	if(substr($_taxonomy, 0,7) != 'til_fs_') { $_taxonomy = 'til_fs_'.$_taxonomy; }

	// eger varsayılan form durumu yok ise ilk degeri varsayilan yapalim
	$where = array('taxonomy'=>$_taxonomy, 'is_default'=>'default', 'in_out'=>0);

	if( !get_form_status($where) ) {
		
		$where['is_default'] = '';
		$where['orderby'] 	= 'id ASC';
		$where['limit']		= 1;
		$update = array('taxonomy'=>$_taxonomy, 'in_out'=>0, 'is_default'=>'default');
		usleep(100);
		$args = array('update'=>$update, 'add_log'=>false, 'add_alert'=>false, 'uniquetime'=>get_uniquetime(), 'add_new'=>false);
		update_form_status($where, $args);
	}

	if(til()->form_status[$_taxonomy]['in_out']) {
		$where = array('taxonomy'=>$_taxonomy, 'is_default'=>'default', 'in_out'=>1);
		if( !get_form_status($where) ) {
			
			$where['is_default'] = '';
			$where['orderby'] 	= 'id ASC';
			$where['limit']		= 1;
			$update = array('taxonomy'=>$_taxonomy, 'in_out'=>1, 'is_default'=>'default');
			usleep(100);
			$args = array('update'=>$update, 'add_log'=>false, 'add_alert'=>false, 'uniquetime'=>get_uniquetime(), 'add_new'=>false);
			update_form_status($where, $args);
		}
	}
	
} //._set_form_status_default()





/** 
 * _set_form_status_args()
 * form_status fonksiyonlari gelen parametlerine veritabanı tabolarına uygun hale dönüştürür
 */
function _set_form_status_args($args, $return_args=false) {

	$_arr = array();
	if(isset($args['id'])) { $_arr['id'] = $args['id']; }
	if(!isset($args['taxonomy'])) { $_arr['taxonomy'] = 'form'; }
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
	if(isset($args['in_out'])) { $_arr['val_enum'] = $args['in_out']; }
	if(substr($_arr['taxonomy'], 0,7) != 'til_fs_') { $_arr['taxonomy'] = 'til_fs_'.$_arr['taxonomy']; }


	if(isset($_arr['name'])) { $_arr['name'] = til_get_ucwords($_arr['name']); }

	foreach(array('taxonomy', 'name', 'color', 'bg_color', 'auto_email', 'auto_sms', 'is_default', 'sms_template', 'mail_template', 'count', 'total', 'in_out') as $a) {
		unset($args[$a]);
	}

	if($return_args) {
		return $args;
	} else { return $_arr; }
} //._set_form_status_args();














/**
 * register_form_status()
 * bir form turunu kayit eder
 */
function register_form_status($args) {

	$_args = array();
	if(isset($args['taxonomy'])) { $_args['taxonomy'] = 'til_fs_'.remove_accents($args['taxonomy']); } else { return false;}
	if(isset($args['name'])) { $_args['name'] = $args['name']; } else { return false;}
	if(isset($args['description']) and !empty($args['description'])) { $_args['description'] = $args['description']; } else { $_args['description'] = $_args['name'].' form durumu yönetimi'; }
	if(isset($args['in_out'])) { $_args['in_out'] = $args['in_out']; } else { $_args['in_out'] = true; }
	if(isset($args['sms_template'])) { $_args['sms_template'] = $args['sms_template']; } else { $_args['sms_template'] = true; }
	if(isset($args['email_template'])) { $_args['email_template'] = $args['email_template']; } else { $_args['email_template'] = true; }
	if(isset($args['color'])) { $_args['color'] = $args['color']; } else { $_args['color'] = true; }
	if(isset($args['bg_color'])) { $_args['bg_color'] = $args['bg_color']; } else { $_args['bg_color'] = true; }



	til()->form_status[$_args['taxonomy']] = $_args;
}






/**
 * is_form_status()
 * register_form_status ile kayıtlı olan form_status var mı yok mu?
 */
function is_form_status($taxonomy) {
	if(isset(til()->form_status[$taxonomy])) {
		return true;
	} else {
		return false;
	}
}































