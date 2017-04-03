<?php
/* --------------------------------------------------- USER */


/**
 * add_user()
 * yeni bir kullanici olusturur
 */
function add_user($args) {
	$args 	= _args_helper(input_check($args), 'insert');
	$insert = $args['insert'];

	if(!have_log()) {

		@form_validation($insert['username'], 'username', 'E-posta', 'required|email', __FUNCTION__);
		@form_validation($insert['name'], 'name', 'Ad', 'required|min_length[3]|max_length[20]', __FUNCTION__);
		@form_validation($insert['surname'], 'surname', 'Soyad', 'required|min_length[3]|max_length[20]', __FUNCTION__);
		@form_validation($insert['gsm'], 'gsm', 'Cep Telefonu', 'required|gsm', __FUNCTION__);

		// e-posta adresi daha onceden eklenmis mi?
		if($q_is_email = db()->query("SELECT * FROM ".dbname('users')." WHERE username='".$insert['username']."' ")) {
			if($q_is_email->num_rows) {
				add_alert(_b($insert['username']).' e-posta adresi baska bir personel tarafından kullanılmaktadır.', 'warning', __FUNCTION__);
			}
		}

		// e-posta adresi daha onceden eklenmis mi?
		if($q_is_email = db()->query("SELECT * FROM ".dbname('users')." WHERE gsm='".$insert['gsm']."' ")) {
			if($q_is_email->num_rows) {
				add_alert(_b($insert['gsm']).' cep telefonu numarası başka bir personel tarafından kullanılmaktadır.', 'warning', __FUNCTION__);
			}
		}

		if(!empty($insert['citizenship_no'])) {
			if($q_is_email = db()->query("SELECT * FROM ".dbname('users')." WHERE citizenship_no='".$insert['citizenship_no']."' ")) {
				if($q_is_email->num_rows) {
					add_alert(_b($insert['citizenship_no']).' vatandaşlık numarası başka bir personel tarafından kullanılmaktadır.', 'warning', __FUNCTION__);
				}
			}
		}

		// yetki guncellemesi yapilirken superadmin korumasi
		// eger superadmin'den kucuk bir yetkilinin superadmin atamasi yapmasi saglaniyorsa engelleyelim
		if(isset($update['role'])) {
			if(get_active_user('role') > $insert['role']) {
				add_alert('Bir üst seviye yetki atamaya yetkiniz yok.', 'danger', __FUNCTION__);
			}
		}

		if(!is_alert(__FUNCTION__)) { // eger herhangi bir hata yok ise

			// string transactions
			$insert['username']		= til_get_strtolower($insert['username']);
			$insert['name']			= til_get_strtoupper($insert['name']);
			$insert['surname']		= til_get_strtoupper($insert['surname']);

			if(db()->query("INSERT INTO ".dbname('users')." ".sql_insert_string($insert)." ")) {
				if($insert_id = db()->insert_id) {
					if($args['add_alert']) { add_alert('Kullanıcı hesabı oluşturuldu.', 'success', __FUNCTION__); }
					if($args['add_log']) { add_log(array('table_id'=>'users:'.get_active_user_id(), 'log_key'=>'add_user', 'log_text'=>'Yeni bir kullanıcı hesabı oluşturdu.'._b($insert['username']).'')); }
					return $insert_id;
				} else { return false; }
			} else { add_mysqli_error_log(__FUNCTION__); }
		} else { return false; }
	} else { repetitive_operation(__FUNCTION__); } // !have_log()
} //.add_user()






/**
 * update_user()
 * kullanici bilgisini gunceller
 */
function update_user($user_id, $args) {
	$args 	= _args_helper(input_check($args), 'update');
	$update = $args['update'];

	# kullanıcı hesabı var mi
	if(!$old_user = get_user($user_id)) {
		add_console_log($user_id.' ID kullanıcı hesabı bulunamadı.', __FUNCTION__);
		return false;
	}

	if(!have_log()) { // bu islem daha onceden gercekles mi?

		@form_validation($update['username'], 'username', 'E-posta', 'email', __FUNCTION__);
		@form_validation($update['name'], 'name', 'Ad', 'min_length[3]|max_length[20]', __FUNCTION__);
		@form_validation($update['surname'], 'surname', 'Soyad', 'min_length[3]|max_length[20]', __FUNCTION__);
		@form_validation($update['gsm'], 'gsm', 'Cep Telefonu', 'gsm', __FUNCTION__);


		// e-posta adresi daha onceden eklenmis mi?
		if(isset($update['username'])) {
			if($q_is_email = db()->query("SELECT * FROM ".dbname('users')." WHERE username='".$update['username']."' AND id NOT IN ('".$user_id."')  ")) {
				if($q_is_email->num_rows) {
					add_alert(_b($update['username']).' e-posta adresi baska bir kullanıcı tarafından kullanılmaktadır.', 'warning', __FUNCTION__);
				}
			}
		}

		// yetki guncellemesi yapilirken superadmin korumasi
		// eger superadmin'den kucuk bir yetkilinin superadmin atamasi yapmasi saglaniyorsa engelleyelim
		if(isset($update['role'])) {
			if(get_active_user('role') > $update['role']) {
				add_alert('Bir üst seviye yetki atamaya yetkiniz yok.', 'danger', __FUNCTION__);
			}
		}

		if(!is_alert(__FUNCTION__)) { // eger herhangi bir hata yok ise

			// string transactions
			if(isset($update['username'])) 	{ $update['username']		= til_get_strtolower($update['username']); 	}
			if(isset($update['name'])) 		{ $update['name']			= til_get_strtoupper($update['name']); 	}
			if(isset($update['surname'])) 	{ $update['surname']		= til_get_strtoupper($update['surname']); 	}

			if(db()->query("UPDATE ".dbname('users')." SET ".sql_update_string($update)." WHERE id='".$user_id."' ")) {
				if(db()->affected_rows > 0) {
					$new_user = get_user($user_id);

					if($args['add_alert']) { add_alert('Kullanıcı hesabı güncellendi.', 'success', __FUNCTION__); }
					if($args['add_log']) { add_log(array('table_id'=>'users:'.$user_id, 'log_key'=>'update_user', 'log_text'=>_b($old_user->display_name).' Kullanıcı hesabı güncellendi.', 'meta'=>log_compare($old_user, $new_user))); }
					return true;
				} else { return false; }
			} else { add_mysqli_error_log(__FUNCTION__); }
		} else { return false; }

	} else { repetitive_operation(__FUNCTION__); } // !have_log()
} //.update_user()






/**
 * get_user()
 * bir kulanici bilgisini dondurur
 */
function get_user($args, $_til=true) {
	if(!is_array($args)) { $args = array('where'=>array('id'=>$args)); }
	$args = _args_helper(input_check($args), 'where');
	$where = $args['where'];

	if ( isset(til()->user[$where['id']]) AND $_til ) {
		return til()->user[$where['id']];
	} else {
		if($query = db()->query("SELECT * FROM ".dbname('users')." ".sql_where_string($where)." ")) {
			if($query->num_rows) {
				$return = _return_helper($args['return'], $query);
				if(!$return->avatar) { $return->avatar = get_template_url('img/no-avatar-'.$return->gender.'.jpg'); } else { $return->avatar = get_site_url($return->avatar); }
				if(!isset($return->display_name)) { $return->display_name = $return->name.' '.$return->surname; }
				til()->user[$return->id] = $return;
				return $return;
			} else {
				if($args['add_alert']) { add_alert('Aradığınız kriterlere uygun kullanıcı hesabı bulunamadı.', 'warning', __FUNCTION__); }
				return false;
			}
		} else { add_mysqli_error_log(__FUNCTION__); }
	}
}





/**
 * get_users()
 * tum uyelerinin sonuclarini dondurur
 */
function get_users($args=array()) {
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];



	if(empty($where)) {
		$where['status'] = '1';
	}

	if($query = db()->query("SELECT * FROM ".dbname('users')." ".sql_where_string($where)." ")) {
		if($query->num_rows) {
			return db_query_list_return_user($query, 'id' );
		} else {
			add_alert('Herhangi bir üye kaydı listesi bulunamadı.', 'warning', __FUNCTION__);
			return false;
		}
	} else {
		db_query_error('get_users');
	}
}
til()->user = get_users();






/**
 * get_user_info()
 * bir uyenin bilgilerini dondurur
 */
function get_user_info($id, $return) {
	if(isset(til()->user[$id])) {
		$user = til()->user[$id];

		if(isset($user->$return)) {
			return $user->$return;
		}
	} else { return false; }
}
/**
 * user_info()
 * ref: get_user_info()
 */
function user_info($id, $return) {
	echo get_user_info($id, $return);
}
















/* --------------------------------------------------- ACTIVE USER */




/**
 * get_active_user()
 * su anda aktif olan, uye girisi yapmis kullanici bilgisini dondurur
 * eger parametre bos birakilirsa tablodaki tum degerleri dondurur
 * sadece kullanıcının gerçek adının almak icin get_active_user('name') veya get_active_user()->name seklinde kullanabilirsiniz.
 */
function get_active_user($val='') {
	if($user = get_user($_SESSION['login_id'])) {
		if(isset($user->$val)) {
			return $user->$val;
		} else {
			return $user;
		}
	} else {
		exit('giris yapmis uye bulunamadi.');
	}
}
function active_user($val='') {
	echo get_active_user($val);
}



/**
 * get_active_user_id()
 * su anda aktif olan uyenin ID'sini dondurur
 * $_SESSION['login_id'] degerini dondurur
 */
function get_active_user_id() {
	return $_SESSION['login_id'];
} //.get_active_user_id()






/**
 * is_active_user_role()
 * aktif olan kullanıcının yetkisi olup olmadigini kontrol eder
 */
function is_active_user_role($val) {

	if(get_user_role_no($val)) {
		if(get_active_user('role') <= get_user_role_no($val)) {
			return true;
		} else { return false; }
	} else { return false; }
} //.is_active_user_role()
































/* --------------------------------------------------- USER META */





/**
 * add_user_meta()
 * bir kullanıcıya ait meta verisi ekler
 */
function add_user_meta($user_id, $meta_key, $meta_value, $args=array()) {
	$args 	= _args_helper(input_check($args));
	$user_id 		= input_check($user_id);
	$meta_key 		= input_check($meta_key);
	$meta_value 	= input_check($meta_value);

	# kullanıcı kontrol
	if(!$user = get_user($user_id)) { add_console_log('#'.$user_id.' kullanıcı bulunamadı.', __FUNCTION__); return false; }
	if(empty($meta_key)) { add_console_log('Meta anahtar boş olamaz.', __FUNCTION__); return false; }


	if(is_array($meta_value) or is_object($meta_value)) { $meta_value = json_encode_utf8($meta_value); }

	$insert['user_id']		= $user_id;
	$insert['meta_key'] 	= $meta_key;
	$insert['meta_value'] 	= $meta_value;
	if($q_insert = db()->query("INSERT INTO ".dbname('user_meta')." ".sql_insert_string($insert)." ")) {
		if($insert_id = db()->insert_id) {
		} else { return false; }
	} else { add_mysqli_error_log(__FUNCTION__); }

} //.add_user_meta()










/**
 * update_user_meta()
 * bir kulanıcı ek bilgisini gunceler yok ise yenisini olusturur
 */
function update_user_meta($user_id, $meta_key, $meta_value, $args=array()) {
	$args 			= _args_helper(input_check($args));
	$user_id 		= input_check($user_id);
	$meta_key 		= input_check($meta_key);
	$meta_value 	= input_check($meta_value);

	# kullanıcı kontrol
	if(!$user = get_user($user_id)) { add_console_log('#'.$user_id.' kullanıcı bulunamadı.', __FUNCTION__); return false; }
	if(empty($meta_key)) { add_console_log('Meta anahtar boş olamaz.', __FUNCTION__); return false; }


	if(is_array($meta_value) or is_object($meta_value)) { $meta_value = json_encode_utf8($meta_value); }



	$where['user_id'] 	= $user_id;
	$where['meta_key'] 	= $meta_key;
	if($q_select = db()->query("SELECT * FROM ".dbname('user_meta')." ".sql_where_string($where))) {
		if($q_select->num_rows) {
			$update['meta_value'] = $meta_value;
			if($q_update = db()->query("UPDATE ".dbname('user_meta')." SET ".sql_update_string($update)." ".sql_where_string($where)." ")) {
				if(db()->affected_rows) {
					return true;
				} else { return false; }
			} else { add_mysqli_error_log(__FUNCTION__); }
		} else {
			add_user_meta($user_id, $meta_key, $meta_value);
		}
	} else { add_mysqli_error_log(__FUNCTION__); }

} //.update_user_meta()








/**
 * get_user_meta()
 * bir kullanıcı bilgisini dondurur
 */
function get_user_meta($user_id, $meta_key=false, $args=array()) {
	$args 		= input_check($args);
	$user_id 	= input_check($user_id);
	if($meta_key) { $meta_key 	= input_check($meta_key); }

	if(empty($args)) { $args = array(); $args['return_meta_value'] = true; }
	if(!is_array($args)) { if($args == true) { $args = array(); $args['return_meta_value'] = true; } }
	if(!$meta_key) { $args['return_meta_value'] = false; }

	$where['user_id'] 	= $user_id;
	if($meta_key) { $where['meta_key'] = $meta_key; }


	if($q_select = db()->query("SELECT * FROM ".dbname('user_meta')." ".sql_where_string($where)." ")) {
		if($q_select->num_rows) {
			if($args['return_meta_value']) {
				$return = stripcslashes($q_select->fetch_object()->meta_value);
				if(is_json($return)) {
					return json_decode($return);
				} else {
					return $return;
				}
			} else {
				$return = '';
				while($list = $q_select->fetch_object()) {
					$list->meta_value = stripcslashes($list->meta_value);
					if(is_json($list->meta_value)) {
						$list->meta_value =  json_decode($list->meta_value);
					}

					$return[$list->meta_key] = $list->meta_value;
				}
				return $return;
			}

		} else {
			return false;
		}
	} else { add_mysqli_error_log(__FUNCTION__); }
} //.get_user_meta()
























/*
| -------------------------------------------------------------------
| STAFF SALARY
| -------------------------------------------------------------------
| Üye olan kullanılarn maaş durumlaını hesaplatır
|
|
| -------------------------------------------------------------------
| Fonksiyonlar
| -------------------------------------------------------------------
|
| * set_staff_salary()
|
*/



/**
 * @func set_staff_salary()
 * @desc personellerin maaslarını hesaplar ve duzenler
 */
function set_staff_salary($user_id) {

	if(!$user = get_user($user_id)) { add_console_log('üye id bulunamadı', __FUNCTION__); return false; }
	$user_meta = get_user_meta($user->id);



	// eger hesap karti yok ise olusturalim
	if($user->account_id == 0) {
		$_account['insert']['type'] = 'user';
		$_account['insert']['code'] = 'TILUA-'.$user->id;
		$_account['insert']['name'] = $user->display_name;
		$_account['insert']['gsm']  = $user->gsm;
		$_account['insert']['email'] 	= $user->username;
		$_account['insert']['tax_no'] 	= $user->citizenship_no;
		$_account['insert']['val_int'] 	= $user->id;

		$_account['add_log'] = false;
		$_account['add_alert'] = false;

		if( $account_id = add_account($_account) ) {
			if( update_user($user->id, array('account_id'=>$account_id)) ) {
				$user->account_id = $user->id;
			}
		}
	} //. hesap karti yok ise olustur


	// hesap kartini cagiralim
	if(!$account = get_account($user->account_id)) { add_console_log('Hesap kartı bulunamadı.', __FUNCTION__); return false; }

	// ise baslama tarihini bulalim
	if(!@$user_meta['date_start_work']) { add_console_log('işe başlama tarihi bulunamadı.', __FUNCTION__); return false; }


		// ise baslama ve isi bırakma tarihlerı degısmıs olabılecegınden eskı kayıtların hepsını status "0" yapalım
		// cunku asagı tarafta kontroller ve hesaplamalar yapıldıktan sonra tekrar aktıf olacaklar
		db()->query("UPDATE ".dbname('forms')." SET status='0' WHERE type='salary' AND account_id='".$user->account_id."'");
		db()->query("UPDATE ".dbname('form_items')." SET status='0' WHERE type='salary' AND item_name='monthly_day' AND account_id='".$user->account_id."'");

	
	// eger maas hesaplamasi yapilmayacka ise betigi fonksiyonu buradan sonlandiralim
	if(!$user_meta['is_salary']) { 
		// hesap kartini pasif edelim
		db()->query("UPDATE ".dbname('accounts')." SET status='0' WHERE type='user' AND id='".$user->account_id."' ");
		return false; 
	} else {
		// hesap kartinin aktif olma olasiligina karsin tekrar aktif edelim
		db()->query("UPDATE ".dbname('accounts')." SET status='1', val_int='".$user->id."' WHERE type='user' AND id='".$user->account_id."' ");
	}


	$str_start_date = strtotime($user_meta['date_start_work']);

	// hesaplama yapilacak tarihler en fazla hangi zamana kadar olabilir
	if( $user_meta['date_end_work'] ) { $calc_end_date = $user_meta['date_end_work']; } else { $calc_end_date = date('Y-m-d'); }
		if( strtotime($calc_end_date) > time() ) { $calc_end_date = date('Y-m-d'); }

	while($str_start_date <= strtotime($calc_end_date))
	{
	    $current_date 		= date('Y-m', $str_start_date);
     	$str_start_date 	= strtotime(date('Y-m', strtotime("+1 month", $str_start_date)).'-01'); // bir sonraki ayi hesaplamak icin 1 ay ileri atıyor ve  ay basini aliyoruz.

     	// ise baslama tarihinin ay basi olmama ihtimali yuksek. Bu sebeble ise baslama tarihinin gun degerini ekleyelim
		if( date('Y-m', strtotime($user_meta['date_start_work'])) == date('Y-m', strtotime($current_date)) ) {
			$current_date 	.= '-'.date('d', strtotime($user_meta['date_start_work'])).' 00:00';
		} else {
			$current_date 	.= '-01 00:00';
		}


		# ay baslangic tarihi Y-m-d
		$monthly_start_date = date('Y-m-d', strtotime($current_date));

		# ay tarihi Y-m
		$monthly_Ym 	= date('Y-m', strtotime($current_date));

		# bir ay kac gun
		$monthly_how_days = date("t", strtotime($current_date));

		# bu ay kac gun calisti
		$monthly_active_days = '0';
			$starting_work_day = date("d", strtotime($current_date)) - 1;
			$monthly_active_days = ( $monthly_how_days - $starting_work_day );

			if($monthly_Ym == date('Y-m')) {
				$monthly_active_days = $monthly_active_days - (date('t') - date('d'));
			}


		// eger isi birakma tarihi var ise onuda hesaba katalim ki fazla para yazilmasin
		if( date('Y-m', strtotime($user_meta['date_end_work'])) == date('Y-m', strtotime($current_date)) ) {
			if( strtotime(date('Y-m', strtotime($current_date)).'-'.date('d')) > strtotime($user_meta['date_end_work'])) {
				$monthly_active_days = date('d', strtotime($user_meta['date_end_work'])) - $starting_work_day;
			}
		}


		# bu ayki bitis tarihi
		$monthly_end_date = date('Y-m-t', strtotime($current_date));


		// test icin
		if(10 < 9) {
			echo $monthly_start_date;
			echo '<br />';
			echo $monthly_Ym;
			echo '<br />';
			echo $monthly_how_days;
			echo '<br />';
			echo $monthly_active_days;
			echo '<br />';
			echo '<br />';
		}



     	if($q_select = db()->query("SELECT * FROM ".dbname('forms')." WHERE type='salary' AND val_1='".$monthly_Ym."' AND account_id='".$user->account_id."'")) {
			if($q_select->num_rows) {
				while($monthly = $q_select->fetch_object()) {

					// status guncellemsi silinenleri tekrar aktif edelim
					db()->query("UPDATE ".dbname('forms')." SET status='1' WHERE id='".$monthly->id."'");

					# bir gun kac para
					$monthly_day_wage = number_format($monthly->val_decimal / $monthly_how_days,4); // gunluk kac para

					if($q_select_item = db()->query("SELECT * FROM ".dbname('form_items')." WHERE type='salary' AND form_id='".$monthly->id."' AND item_name='monthly_day' AND val_1='".$monthly_Ym."' ")) {
						if($q_select_item->num_rows) {

							// eger form'a ait gunluk yevmiye hesaplamasi var olasi bir degisiklige karsi guncelleyelim
							$_form_item = array();
							$_form_item['status'] 	= 1;
							$_form_item['in_out']   = '0';
							$_form_item['account_id'] = $user->account_id;
							$_form_item['val_2']	= $monthly_start_date;
							$_form_item['quantity'] = $monthly_active_days;
							$_form_item['price'] 	= $monthly_day_wage;
							$_form_item['total']	= $_form_item['quantity'] * $_form_item['price'];

							db()->query("UPDATE ".dbname('form_items')." SET ".sql_update_string($_form_item)." WHERE id='".$q_select_item->fetch_object()->id."' ");

						} else {
							// eger form'a ait gunluk yevmiye hesaplamasi yapilmamis ise form_items tablosuna ekleyelim
							$_form_item = array();
							$_form_item['type'] 	= 'salary';
							$_form_item['in_out']   = '0';
							$_form_item['status'] 	= 1;
							$_form_item['form_id'] 	= $monthly->id;
							$_form_item['account_id'] = $user->account_id;
							$_form_item['item_name']= 'monthly_day';
							$_form_item['val_1'] 	= $monthly_Ym;
							$_form_item['val_2'] 	= $monthly_start_date;
							$_form_item['val_3'] 	= $monthly_end_date;
							$_form_item['quantity'] = $monthly_active_days;
							$_form_item['price'] 	= $monthly_day_wage;

							insert_form_item($_form_item);
						}
					}

					# form kartinin bakiyesini guncelleyelim
					calc_form($monthly->id);

				} //.while

			} else {
				// eger herhangi bir form yok ise olusturalim
				// her ay icin bir form kaydi olmalidir
				$_form['in_out'] = '0';
				$_form['type'] = 'salary';
				$_form['date'] = $current_date;
				$_form['account_id'] 		= $user->account_id;
				$_form['account_code']   	= $account->code;
				$_form['account_name'] 		= $account->name;
				$_form['user_id'] 			= $user->id;
				$_form['val_1']				= $monthly_Ym;
				$_form['val_decimal']    	= $user_meta['net_salary'];

				if($salary_id = insert_form($_form)) {
					$salary_id;
				}

				set_staff_salary($user_id);
			}
		} //.query
	} //.while strtotime

	# personelin hesap karti bakiyesini guncelleyelim
	calc_account($user->account_id);
} //.set_staff_salary()






















/* --------------------------------------------------- USER ACCESS */


/**
 * page_access()
 * bir kullanicin sayfaya komple erisimi olup olmadigini kontrol eder
 */
function page_access($role) {
	if(is_active_user_role($role)) {
		return true;
	} else {
		echo get_alert(array('title'=>'Erişim engellendi', 'description'=>'Bu sayfaya erişim yetkiniz yok. Bir sorun olduğunu düşünüyorsanız yöneticiniz ile iletişime geçebilirsiniz.'), 'warning', array('x'=>false));
		return false;
	}
} //.page_access()






/**
 * user_access()
 * bir kullanicin sayfaya komple erisimi olup olmadigini kontrol eder
 */
function user_access($role) {
	if(is_active_user_role($role)) {
		return true;
	} else {
		return false;
	}
} //.page_access()






/**
 * get_user_role_text()
 * bir yetkinin text formatını döndürür
 */
function get_user_role_text($val) {
	$text = '';
	if($val == '1') { $text = 'Süper Admin'; }
	if($val == '2') { $text = 'Admin'; }
	if($val == '3') { $text = 'Birim Amiri'; }
	if($val == '4') { $text = 'Yetkili Personel'; }
	if($val == '5') { $text = 'Personel'; }

	return $text;
} //.get_user_role_text()







/**
 * get_user_role_no()
 * bir yetkinin numara formatını dondurur
 */
function get_user_role_no($val) {

	// 1
	$arr['superadmin'] = '1';
	$arr['Süper Admin'] = '1';
	$arr['Super Admin'] = '1';
	// 2
	$arr['admin'] = '2';
	$arr['Admin'] = '2';
	$arr['yonetici'] = '2';
	$arr['Yönetici'] = '2';
	// 3
	$arr['unitmanager'] = '3';
	$arr['Unit Manager'] = '3';
	$arr['birimamiri'] = '3';
	$arr['Birim Amiri'] = '3';
	// 4
	$arr['authorizedpersonnel'] = '4';
	$arr['Authorized Personnel'] = '4';
	$arr['yetkilipersonel'] = '4';
	$arr['Yetkili Personel'] = '4';
	// 5
	$arr['staff'] = '5';
	$arr['Staff'] = '5';
	$arr['Personel'] = '5';


	if(isset($arr[$val])) {
		return $arr[$val];
	}

} //.get_user_role_no()







/**
 * get_user_access()
 * bir kullanıcının bir ogeye erisim yetkisi olup olmadigini kontrol eder
 * eger olumlsuz ise sonuc false doner
 * array halinde gelen dizileri kontrol eder ve olumsuz olan nesneleri false olarak donusturur
 */
function get_user_access($val, $key, $prefix='', $opt=array() ) {

	// options required
	if(!is_array($opt)) { $opt = array('get_user_access'=>$opt); }
	if(!isset($opt['get_user_access'])) { $opt['get_user_access'] = true; } // get_user_access() fonksiyonu calissin


	if($opt['get_user_access']) {
		$array['items-p_purc_out_vat'] = false;
		$array['items-p_sale_out_vat'] = true;
		$array['items-p_purc'] = true;
		$array['items-p_sale'] = true;

		if(strlen($prefix) > 0) {
			$prefix .= '-';
		}

		if(is_array($val)) {
			$return = array();
			foreach($val as $_key=>$_val) {
				if(isset($array[$prefix.$_key])) {
					if($array[$prefix.$_key] == false) {
						if(is_numeric($_val)) {
							$return[$_key] = 0;
						} else {
							$return[$_key] = '';
						}
					} else {
						$return[$_key] = $_val;
					}
				} else {
					$return[$_key] = $_val;
				}
			}
			return $return;
		} elseif(is_object($val)) {
			$return = new stdClass();
			foreach($val as $_key=>$_val) {
				if(isset($array[$prefix.$_key])) {
					if($array[$prefix.$_key] == false) {
						if(is_numeric($_val)) {
							$return->$_key = 0;
						} else {
							$return->$_key = '';
						}
					} else {
						$return->$_key = $_val;
					}
				} else {
					$return->$_key = $_val;
				}
			}
			return $return;
		} else {
			if(isset($array[$prefix.$key])) {
				if($array[$prefix.$key] == false) {
					if(is_numeric($val)) {
						return 0;
					} else {
						return '';
					}
				} else {
					return $val;
				}
			} else {
				return $val;
			}
		}
	} else {
		return $val;
	}
}









/**
 * _get_school_text()
 * CV bilgilerinde okul level bilgisini dondurur
 */
function _get_usermeta_school_text($text) {
	if($text == 'primary_education') {
		return 'İlköğretim';
	} elseif($text == 'high_school') {
		return 'Lise';
	} elseif($text == 'college') {
		return 'Yüksekokul';
	} elseif($text == 'university') {
		return 'Üniversite';
	} elseif($text == 'other') {
		return 'Diğer';
	}
	return false;
} //._get_usermeta_school_text()


/**
 * _get_school_text()
 * CV bilgilerinde okul level bilgisini dondurur
 */
function _get_usermeta_lang_text($text) {
	if($text == '1') {
		return 'Az';
	} elseif($text == '2') {
		return 'Orta';
	} elseif($text == '3') {
		return 'İyi';
	} elseif($text == '4') {
		return 'Çok İyi';
	}
	return false;
} //._get_usermeta_lang_text()


/**
 * _get_usermeta_work_level_text()
 * CV bilgilerinde okul level bilgisini dondurur
 */
function _get_usermeta_work_level_text($text) {
	if($text == 'full_time') {
		return 'Tam zamanlı';
	} elseif($text == 'part_time') {
		return 'Yarı zamanlı';
	} elseif($text == 'seasonal') {
		return 'Dönemsel';
	} elseif($text == 'contractual') {
		return 'Sözleşmeli';
	} elseif($text == 'student') {
		return 'Stajyer';
	}
	return false;
} //._get_usermeta_work_level_text()


/**
 * _get_usermeta_is_married()
 * CV bilgilerinde okul level bilgisini dondurur
 */
function _get_usermeta_is_married($text) {
	if($text == 'not_married') {
		return 'Bekar';
	} elseif($text == 'married') {
		return 'Evli';
	} elseif($text == 'widow') {
		return 'Dul';
	}
	return false;
} //._get_usermeta_is_married()


/**
 * _get_usermeta_is_married()
 * CV bilgilerinde okul level bilgisini dondurur
 */
function _get_usermeta_military_status($text) {
	if($text == 'done') {
		return 'Yapıldı';
	} elseif($text == 'postponed') {
		return 'Tecilli';
	} elseif($text == 'exempt') {
		return 'Muaf';
	}
	return false;
} //._get_usermeta_is_married()









?>
