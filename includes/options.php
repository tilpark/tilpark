<?php

/* --------------------------------------------------- OPTIONS */


/**
 * add_option()
 * options tablosuna oge ekler
 */
function add_option($name, $args=array(), $opt=array()) {

	if(!have_log()) { // eger daha onceden eklenmemis ise log kaydi bulunmayacaktir.
		if(!is_array($args)) { $args = array('val'=>$args); }

		@form_validation($name, '', 'Seçenek Adı', 'required|min_length[3]|max_length[64]', __FUNCTION__);

		if(!is_alert(__FUNCTION__)) {
			// input_check
			$args['name'] = $name;
			$args = input_check($args);

			// anahtar daha onceden eklenmis mi?
			if($q_is_name = db()->query("SELECT * FROM ".dbname('options')." WHERE name='".$name."' ")) {
				if($q_is_name->num_rows) {
					add_alert('"<b>'.$name.'"</b> anahtarı daha önceden eklenmiş.', 'warning', __FUNCTION__);
					return false;
				} else {
					
					$table = sql_insert_string($args);
					if($q_insert = db()->query("INSERT INTO ".dbname('options')." (".$table['table_name'].") VALUES (".$table['table_value'].") ")) {
						if(db()->affected_rows) {
							$insert_id = db()->insert_id;
							add_alert('Seçenek eklendi', 'success', __FUNCTION__);
							add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'options:'.$insert_id, 'log_key'=>__FUNCTION__, 'log_text'=>$name.' seçeneği eklendi.'));
							return $insert_id;
						} else { return false; }
					} else { add_mysqli_error_log(__FUNCTION__); }
				}

			} else { add_mysqli_error_log(__FUNCTION__); }

		} else { return false; }
		
	} else {
		add_alert('Bu işlem daha önceden gerçekleşmiş.', 'warning', __FUNCTION__);
		return false;
	}

} //.add_option()






/** 
 * get_option()
 * options tablosundan bir satir dondurur
 */
function get_option($name_or_id, $opt=array() ) {

	if(!is_array($opt)) { $opt = array('return'=>$opt); }
	if(!isset($opt['return'])) { $opt['return'] = 'string'; }


	$return = false;
	if($q_select = db()->query("SELECT * FROM ".dbname('options')." WHERE name='".$name_or_id."'")) {
		if($q_select->num_rows) {
			$return = $q_select->fetch_object();
		} elseif($q_select = db()->query("SELECT * FROM ".dbname('options')." WHERE id='".$name_or_id."'")) {
			if($q_select->num_rows) {
				$return = $q_select->fetch_object();
			}
		} else { add_mysqli_error_log(__FUNCTION__); }
	} else { add_mysqli_error_log(__FUNCTION__); }

	if($return) {
		if($opt['return'] == 'string') {
			 return $return->val;
		} elseif($opt['return'] == 'object') {
			return $return;
		}
		return false;
	} else { return false; }

} //.get_option()






/**
 * update_option()
 * options tablosuna güncelleme yapar
 */
function update_option($name, $args=array()) {

	if(!have_log()) { // eger daha onceden eklenmemis ise log kaydi bulunmayacaktir.
		if(!is_array($args)) { $args = array('val'=>$args); }

		@form_validation($name, '', 'Seçenek Adı', 'required|min_length[3]|max_length[64]', __FUNCTION__);

		if(!is_alert(__FUNCTION__)) {
			// input_check
			$args['name'] = $name;
			$args = input_check($args);

			// anahtar daha onceden eklenmis mi?
			if($q_is_name = db()->query("SELECT * FROM ".dbname('options')." WHERE name='".$name."' ")) {
				if($q_is_name->num_rows) {
					$table_update = convert_mysql_update_string($args);
					$updated_id = $q_is_name->fetch_object()->id;
					if($q_update = db()->query("UPDATE ".dbname('options')." SET ".$table_update." WHERE id='".$updated_id."' ")) {
						if(db()->affected_rows) {
							add_alert('Seçenek güncellendi', 'success', __FUNCTION__);
							add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'options:'.$updated_id, 'log_key'=>__FUNCTION__, 'log_text'=>$name.' seçeneği güncellendi.'));
							return $updated_id;
						} else { return false;}
					} else { add_mysqli_error_log(__FUNCTION__); }
				} else {
					add_option($name, $args);
				}

			} else { add_mysqli_error_log(__FUNCTION__); }

		} else { return false; }
		
	} else {
		add_alert('Bu işlem daha önceden gerçekleşmiş.', 'warning', __FUNCTION__);
		return false;
	}

} //.update_option()











/* --------------------------------------------------- EXTRA */


/**
 * add_extra()
 * extra tablosuna veri ekler
 */
function add_extra($args=array()) {
	
	$args = _args_helper(input_check($args), 'insert');
	$insert = $args['insert'];


	if(!have_log()) {
		@form_validation($insert['taxonomy'], '', 'Sınıflandırma adı (taxonomy)', 'required|min_length[3]|max_length[64]', __FUNCTION__);

		if(!is_alert(__FUNCTION__)) {
			if($q_insert = db()->query("INSERT INTO ".dbname('extra')." ".sql_insert_string($insert)." ")) {
				if(db()->insert_id) {
					$insert_id = db()->insert_id;
					if($args['add_alert']) { add_alert('Ekstra eklendi.', 'success', __FUNCTION__); }
					if($args['add_log']) { add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'extra:'.$insert_id, 'log_key'=>__FUNCTION__, 'log_text'=>$insert['name'].' ekstra eklendi.')); }
					return $insert_id;
				} else {
					return false;
				}
			} else { add_mysqli_error_log(__FUNCTION__); }

		} else { return false; }
	} else { repetitive_operation(__FUNCTION__); }
} //.add_extra()






/**
 * update_extra()
 * extra tablosundaki verilerini gunceller
 */
function update_extra($where, $args=array()) {

	if(!have_log(@$args['uniquetime'])) {

		// default variable
		if(!is_array($where)) { if(is_numeric($where)) { $where = array('id'=>$where);  } else { $where = array('name'=>$where); }  }

		$args 	= _args_helper(input_check($args), 'update' );
		$update = $args['update'];

		@form_validation($update['taxonomy'], '', 'Ekstra adı', 'required|min_length[3]|max_length[64]', __FUNCTION__);

		if(!is_alert(__FUNCTION__)) {
			if($extra = get_extra($where)) {
				if($q_update = db()->query("UPDATE ".dbname('extra')." SET ".sql_update_string($update)." ".sql_where_string($where)." ")) {
					$new_extra = get_extra($extra->id);
					if($args['add_alert']) { add_alert('Ekstra güncellendi.', 'success', __FUNCTION__); }
					if($args['add_log']) { add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'extra:'.$extra->id, 'log_key'=>__FUNCTION__, 'log_text'=>'Eksra güncellendi.', 'meta'=>log_compare($extra, $new_extra))); }
					return $extra->id;
				} else { add_mysqli_error_log(__FUNCTION__); }
			} else {
				if($args['add_new']) {
					if($extra_id = add_extra($args)) {
						return $extra_id;
					} else { return false; }
				} //.$args['add_new']
			} //.$extra = get_extra($where)
		} else { return false; }

	} else { repetitive_operation(__FUNCTION__); }
} //.update_extra()
















/** 
 * get_extra()
 * extra tablosundaki sonucu dondurur
 */
function get_extra($args=array()) {

	// default variable
	if(!is_array($args)) { if(is_numeric($args)) { $args = array('where'=>array('id'=>$args));  } else { $args = array('where'=>array('taxonomy'=>$args)); }  }
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];

	if($q_select = db()->query("SELECT * FROM ".dbname('extra')." ".sql_where_string($where)." ")) {
		if($q_select->num_rows) {
			return _return_helper('single_object', $q_select);
		} else { return false; }
	} else { add_mysqli_error_log(__FUNCTION__); }
} //.get_extra()







/** 
 * get_extras()
 * extra tablosundaki sonuclari dondurur
 */
function get_extras($args=array()) {

	// default variable
	if(!is_array($args)) { if(is_numeric($args)) { $args = array('where'=>array('id'=>$args));  } else { $args = array('where'=>array('taxonomy'=>$args)); }  }
	$args 	= _args_helper(input_check($args), 'where');
	$where 	= $args['where'];



	if($q_select = db()->query("SELECT * FROM ".dbname('extra')." ".sql_where_string($where)." ")) {
		if($q_select->num_rows) {
			return _return_helper($args['return'], $q_select);
		} else { return false; }
	} else { add_mysqli_error_log(__FUNCTION__); }
} //.get_extras()






/**
 * delete_extra()
 * bir extra ogesini siler
 */
function delete_extra($args=array()) {

	// default variable
	if(!is_array($args)) { if(is_numeric($args)) { $args = array('where'=>array('id'=>$args));  } else { $args = array('where'=>array('name'=>$args)); }  }

	$args = _args_helper($args);

	if($extra = get_extra($args)) {
		if($q_delete = db()->query("DELETE FROM ".dbname('extra')." ".sql_where_string($args)." ")) {
			if(db()->affected_rows) {
				if($args['add_alert']) { add_alert('Ekstra bilgisi silindi', 'warning', __FUNCTION__); }
				if($args['add_log']) { add_log(array('table_id'=>'extra:'.$extra->id, 'log_key'=>__FUNCTION__, 'log_text'=>_b($extra->name).' Ekstra silindi.')); }
				return true;
			} else { return false; }
		} else { add_mysqli_error_log(__FUNCTION__); }
	} else { if($args['add_alert']) { add_alert('Silinecek ekstra bilgisi bulunamadı.', 'warning', __FUNCTION__); } return false; }

}




















?>