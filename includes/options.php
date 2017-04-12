<?php

/* --------------------------------------------------- OPTIONS */

/**
 * @func add_option()
 * @desc option tablosuna veri ekler
 * @param string, array
 * @return string / false
 */
function add_option($option_name, $args=array()) {
	if ( !is_array($args) ) { $args = array('option_value' => $args); }

  $args    = _args_helper(input_check($args), 'insert');
  $insert  = $args['insert'];

  if ( !empty($option_name) ) {
  	if ( $q_select = db()->query("SELECT * FROM ". dbname('options') ." WHERE option_name='". $option_name ."'") ) {
	    if ( $q_select->num_rows ) {
	      if ( update_option($_option) ) {
	          return true;
	      } else { return false; }
	    } else {
	    	$insert['option_name'] = $option_name;
	    	
	      if ( db()->query("INSERT INTO ". dbname('options') ." ". sql_insert_string($insert) ." ") ) {
	        if ( $insert_id = db()->insert_id ) {

	            return $insert_id;
	        } else { return false; }
	      } else { add_mysqli_error_log(__FUNCTION__); }
	    }
	  } else { add_mysqli_error_log(__FUNCTION__); }
  } else { add_alert('Option name Bulunamadı!'); }
} //.add_option()






/**
 * @func update_option()
 * @desc options tablosundaki satırı günceller
 * @param string, array
 * @return true / false
 */
function update_option($option_name, $args) {
	if ( !is_array($args) ) { $args = array('option_value' => $args); }

  $args    = _args_helper(input_check($args), 'update');
  $update  = $args['update'];

  if ( $q_select = db()->query("SELECT * FROM ". dbname('options') ." WHERE option_name='". $option_name ."' ") ) {
    if ( $q_select->num_rows ) {
      if ( $q_select->fetch_object()->option_value != $update['option_value'] ) {
        if ( db()->query("UPDATE ". dbname('options') ." SET ". sql_update_string($update) ." WHERE option_name='". $option_name ."' ") ) {
          if ( db()->affected_rows ) {

             return true;
          } else { return false; }
        } else { add_mysqli_error_log(__FUNCTION__); }
      } else {
         return false;
      }
    } else {
      if ( add_option($option_name, stripcslashes($update['option_value'])) ) {

          return true;
      } else { return false; }
    }
  } else { add_mysqli_error_log(__FUNCTION__); }
} //.update_option()







/**
 * @func get_option()
 * @desc options tablosundaki seçilen satırın verilerini veriir
 * @param array
 * @return object / false
 */
 function get_option($option_name="") {
  if ( !empty($option_name) ) {
    if ( $q_select = db()->query("SELECT * FROM ". dbname('options') ." WHERE option_name='". $option_name ."' ") ) {
      if ( $q_select->num_rows ) {
      	$return = stripcslashes($q_select->fetch_object()->option_value);

      	if ( is_json($return) ) {
      		return json_decode($return);
      	} else {
      		return $return;
      	}
      } else { return false; }
    } else { add_mysqli_error_log(__FUNCTION__); }
  } else { return false; }
} //.get_option()



















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

	if($q_select = db()->query("SELECT * FROM ".dbname('extra')." ".sql_where_string($where))) {
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