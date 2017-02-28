<?php
/* --------------------------------------------------- ITEM */


/**
 * add_item()
 * yeni bir urun karti olustur
 */
function add_item($args=array()) {

	$args = _args_helper(input_check($args), 'insert');
	$insert = $args['insert'];

	if(!have_log()) { // eger daha onceden eklenmemis ise log kaydi bulunmayacaktir.

		@form_validation($insert['code'], 'code', 'Barkod Kodu', 'min_length[3]|max_length[32]', __FUNCTION__);
		@form_validation($insert['name'], 'name', 'Hesap Adı', 'required|min_length[3]|max_length[50]', __FUNCTION__);
		@form_validation($insert['vat'], 'vat', 'KDV', 'digits|min_length[1]|max_length[2]', __FUNCTION__);
		@form_validation($insert['p_purc'], 'p_purc', 'Maliyet Fiyatı', 'money', __FUNCTION__);
		@form_validation($insert['p_sale'], 'p_sale', 'Satış Fiyatı', 'money', __FUNCTION__);


		if(!is_alert('add_item', 'danger')) { // eger herhangi bir hata yok ise

			// decimal control
			$insert['p_purc'] = get_set_decimal_db($insert['p_purc']);
			$insert['p_sale'] = get_set_decimal_db($insert['p_sale']);
			

			// required
			if(!isset($insert['type'])) { $insert['type'] = 'product'; } else { $insert['type'] = input_check($insert['type']); }
			if(!isset($insert['date'])) { $insert['date'] = date('Y-m-d H:i:s'); }
			if(empty($insert['code'])) { // eger code yani barkod kodu yok ise olusturalim
				$insert['code'] = get_item_code_generator(); }

			if(!isset($insert['vat']) or @empty($insert['vat']) ) {
				$insert['vat'] = 0; }

			if(!isset($insert['p_purc_out_vat'])) {
				$insert['p_purc_out_vat'] = $insert['p_purc'] / get_set_vat($insert['vat']); }

			if(!isset($insert['p_sale_out_vat'])) {
				$insert['p_sale_out_vat'] = $insert['p_sale'] / get_set_vat($insert['vat']);
			}

			// inpuc_check
			$insert 	= input_check($insert);
			$insert['p_purc_out_vat'] 	= input_check(get_set_decimal_db($insert['p_purc_out_vat']));
			$insert['p_sale_out_vat'] 	= input_check(get_set_decimal_db($insert['p_sale_out_vat']));

			$q_is_code = db()->query("SELECT * FROM ".dbname('items')." WHERE code='".$insert['code']."' ");
			if($q_is_code->num_rows) { // eger veritabanında ayni barkod var ise
				$q_is_code = $q_is_code->fetch_object();
				
				if($args['add_alert']) { add_alert('<b>'.$insert['code'].'</b> Ürün Kodu başka bir ürün kartında bulundu. Lütfen ürün kodunu değiştirin veya <a href="'.get_site_url('admin/item/detail.php?id='.$q_is_code->id).'" target="_blank"><b>buradaki</b></a> ürün kartını kullanın.', 'warning', __FUNCTION__); }
				if($q_is_code->status == '1') {
					if($args['add_alert']) { add_alert('<u>Ayrıca bu kod silinen ürün kartları arasında bulundu</u>. Ürün kartını <a href="'.get_site_url('admin/item/detail.php?id='.$q_is_code->id).'"><b>buradan</b></a> tekrar aktifleştirebilirsiniz.', 'warning', __FUNCTION__); } }

				return false;
			} else { // eger veritabanında aynı barkod kodu yok ise


				// buyuk/kucuk harf yapalim
				if(isset($insert['name'])) 		{ $insert['name'] = til_get_strtoupper($insert['name']); }

				if(db()->query("INSERT INTO ".dbname('items')." ".sql_insert_string($insert)." ")) {
					$insert_id = db()->insert_id;
					if($args['add_alert']) { add_alert('Yeni Ürün Kartı Eklendi.', 'success', __FUNCTION__); }
					if($args['add_log']) { add_log(array('uniquetime'=>@$insert['uniquetime'], 'table_id'=>'items:'.$insert_id, 'log_key'=>__FUNCTION__, 'log_text'=>'Ürün kartı eklendi.')); }
					return $insert_id;
				} else { add_mysqli_error_log(__FUNCTION__); }
				
			} // $q_is_code->num_rows

			
		} else { return false; } // !is_alert()
	} else { repetitive_operation(__FUNCTION__); } // !have_log()
} // .add_item()







/**
 * get_item()
 * bu fonksiyon tek bir hesap kartini dataları ile birlikte dondurur
 */
function get_item($args) {
	if(!is_array($args)) { $args = array('id'=>$args); }

	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];

	if($query = db()->query("SELECT * FROM ".dbname('items')." ".sql_where_string($where)." ")) {
		if($query->num_rows) {
			return _return_helper($args['return'], $query);
		} else {
			if($args['add_alert']) { add_alert('Aradığınız kriterlere uygun ürün kartı bulunamadı.', 'warning', __FUNCTION__); }
			return false;
		}
	} else { add_mysqli_error_log(__FUNCTION__); }
} // .get_item()











/**
 * update_item()
 * bir ürün kartini gunceller
 */
function update_item($where, $args) {
	if(!is_array($where)) { $where = array('id'=>$where); }

	$args = _args_helper(input_check($args), 'update');
	$update = $args['update'];


	$old_item = get_item($where, array('get_user_access'=>false) );

	if(!isset($update['name'])) { $update['name'] = $old_item->name; }
	if(!isset($update['code'])) { $update['code'] = $old_item->code; }
	if(!isset($update['vat'])) { $update['vat'] = $old_item->vat; }
	if(!isset($update['p_purc'])) { $update['p_purc'] = $old_item->vat; }
	if(!isset($update['p_sale'])) { $update['p_sale'] = $old_item->vat; }

	if(!have_log()) { // eger daha onceden eklenmemis ise log kaydi bulunmayacaktir.

		@form_validation($update['code'], 'code', 'Ürün Kodu', 'min_length[3]|max_length[32]', __FUNCTION__);
		@form_validation($update['name'], 'name', 'Ürün Adı', 'min_length[3]|max_length[50]', __FUNCTION__);
		@form_validation($update['vat'], 'vat', 'KDV', 'digits|min_length[1]|max_length[2]', __FUNCTION__);
		@form_validation($update['p_purc'], 'p_purc', 'Maliyet Fiyatı', 'money', __FUNCTION__);
		@form_validation($update['p_sale'], 'p_sale', 'Satış Fiyatı', 'money', __FUNCTION__);

		if(!is_alert(__FUNCTION__)) {

			// genel degerler
			if(!isset($update['type'])) { $update['type'] = 'product'; } else { $update['type'] = input_check($update['type']); }
			if(empty($update['code']) and strlen($update['code']) < 1 ) { // eger code yani barkod kodu yok ise olusturalim
				$update['code'] = get_item_code_generator($old_item->id); }
			
			if(!isset($update['vat']) or @empty($update['vat']) ) {
				$update['vat'] = 0;
			}

			if(isset($update['p_purc'])) { 
				$update['p_purc'] 	= get_set_decimal_db($update['p_purc']); 
				if(!isset($update['p_purc_out_vat'])) { $update['p_purc_out_vat'] = $update['p_purc'] / get_set_vat($update['vat']); }
				$update['p_purc_out_vat'] 	= input_check(get_set_decimal_db($update['p_purc_out_vat']));
			}

			if(isset($update['p_sale'])) { 
				$update['p_sale'] 	= get_set_decimal_db($update['p_sale']); 
				if(!isset($update['p_sale_out_vat'])) { $update['p_sale_out_vat'] = $update['p_sale'] / get_set_vat($update['vat']); }
				$update['p_sale_out_vat'] 	= input_check(get_set_decimal_db($update['p_sale_out_vat']));
			}



			if(!is_alert(__FUNCTION__, 'danger')) { // eger herhangi bir hata yok ise

				$q_is_code = db()->query("SELECT * FROM ".dbname('items')." WHERE code='".$update['code']."' AND id NOT IN ('".$old_item->id."')");
				if($q_is_code->num_rows) { // eger veritabanında ayni barkod var ise
					$q_is_code = $q_is_code->fetch_object();
					
					if($args['add_alert']) { add_alert('<b>'.$update['code'].'</b> Ürün kodu başka bir ürün kartında bulundu. Lütfen ürün kodunu değiştirin veya <a href="'.get_site_url('admin/item/detail.php?id='.$q_is_code->id).'" target="_blank"><b>buradaki</b></a> hesabı kullanın.', 'warning', __FUNCTION__); }
					if($q_is_code->status == '0') {
						if($args['add_alert']) { add_alert('<u>Ayrıca bu kod silinen ürün kartları arasında bulundu</u>. Ürün kartını <a href="'.get_site_url('admin/item/detail.php?id='.$q_is_code->id).'"><b>buradan</b></a> tekrar aktifleştirebilirsiniz.', 'warning', __FUNCTION__); } }

					return false;
				} else { // eger veritabanında aynı barkod kodu yok ise


					// buyuk/kucuk harf yapalim
					if(isset($update['name'])) 		{ $update['name'] = til_get_strtoupper($update['name']); }


					if(db()->query("UPDATE ".dbname('items')." SET ".sql_update_string($update)." WHERE id='".$old_item->id."' ")) {
						if(db()->affected_rows > 0) {
							$new_item = get_item($old_item->id, array('get_user_access'=>false) );
							if($args['add_alert']) { add_alert('Ürün kartı güncellendi.', 'success', __FUNCTION__); }
							if($args['add_log']) { add_log(array('uniquetime'=>@$update['uniquetime'], 'table_id'=>'items:'.$old_item->id, 'log_key'=>__FUNCTION__, 'log_text'=>'Ürün kartı güncellendi.', 'meta'=>log_compare($old_item, $new_item))); }
							return true;
						} else {
							return false;
						}
					} else { add_mysqli_error_log(__FUNCTION__); }
				}
				return true;
			} else { return false; }

		} //.!is_alert()
	} else { repetitive_operation(__FUNCTION__); } // !have_log()
} //.update_item()







/**
 * get_items()
 * urun kartlarini listeler, sonucları obj olarak dondurur
 */
function get_items($args=array()) {
	$return = new StdClass;

	$query_str = '';
	$query_str_real = '';
	
	// required
	$args = get_ARR_helper_limit_AND_orderby($args);
	if(!isset($args['status'])) 	{ $args['status'] = '1'; } else { $args['status'] = input_check($args['status']); }

	// query string
	$query_str = "SELECT * FROM ".dbname('items')." WHERE status='".$args['status']."' ";
	
		// %s% antarı var ise arama yapalim
		if(isset($args['s'])) {
			if($args['db-s-where'] == 'all') {
				$query_str .= "AND ( name LIKE '%".$args['s']."%' ";
				$query_str .= "OR code LIKE '%".$args['s']."%' ";
				$query_str .= ' )';
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
			
			while($item = $query->fetch_object())
			{
				$item->p_purc = get_set_money($item->p_purc, array('digit_separator'=>false) );
				$item->p_sale = get_set_money($item->p_sale, array('digit_separator'=>false) );
				$item->p_purc_out_vat = get_set_money($item->p_purc_out_vat, array('digit_separator'=>false) );
				$item->p_sale_out_vat = get_set_money($item->p_sale_out_vat, array('digit_separator'=>false) );

				$item = get_user_access($item, '', 'items'); // kullanici erisim kontrolu
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
 * calc_item()
 * item kartlarinin stok "col:quantity" hesaplamasını yapar
 */
function calc_item($id) {
	if($item = get_item($id)) {
		$in = 0;
		$out = 0;

		// giris hareketlerini toplayalim
		if($q_select_sum = db()->query("SELECT sum(quantity) as quantity,sum(total) as total,sum(profit) as profit FROM ".dbname('form_items')." WHERE in_out='0' AND item_id='".$item->id."' ")) {
			if($q_select_sum->num_rows) {
				$in = $q_select_sum->fetch_object();
			}
		} else { add_mysqli_error_log(__FUNCTION__); }

		// cikis hareketlerini toplayalim
		if($q_select_sum = db()->query("SELECT sum(quantity) as quantity,sum(total) as total,sum(profit) as profit FROM ".dbname('form_items')." WHERE in_out='1' AND item_id='".$item->id."' ")) {
			if($q_select_sum->num_rows) {
				$out = $q_select_sum->fetch_object();
			}
		} else { add_mysqli_error_log(__FUNCTION__); }


		// net stok sayisi
		$total = $in->quantity - $out->quantity;

		// stok kartini guncelleyelim
		if($q_update = db()->query("UPDATE ".dbname('items')." SET 
			quantity='".$total."',
			total_sale='".$out->total."',
			total_purc='".$in->total."',
			profit='".$out->profit."'
			WHERE id='".$item->id."' ")) {
			return true;
		} else {
			return false;
		}

	} else {
		add_alert($id.' ID numaralı ürün kartı bulunamadı.', 'warning', __FUNCTION__);
		return false;
	}
} //.calc_item()










/**
 * get_item_code_generator()
 * veritabanına son eklenen hesap kartının ID numarasını alır ve +1 ekler
 */
function get_item_code_generator($item_id='') {
	$generator = true;
	if($item_id > 0) {
		$code = 'TILI-'.$item_id;
		$query = db()->query("SELECT id FROM ".dbname('items')." WHERE code='".$code."' AND id NOT IN ('".$item_id."') ");
		if($query->num_rows) {
			$generator = true;
		} else {
			$generator = false;
			return $code;
		}
	} 
	if($generator == true) {
		$query = db()->query("SELECT id FROM ".dbname('items')." ORDER BY id DESC LIMIT 1 ");
		$query = $query->fetch_object();
		return 'TILI-'.(@$query->id + 1);
	}
	
}





?>