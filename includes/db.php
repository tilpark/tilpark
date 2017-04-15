<?php
/* --------------------------------------------------- DB */


/**
 * input_check()
 * veritabanına eklenecek verilerin guvenligini saglar
 * gunvelik derken: mysqli_real_escape_string bundan bahsediyoruz.
 */
function input_check($arr) {
	return $arr;

}





/**
 * sql_insert_string()
 * @description: parametrede aldığı diziyi, mysql_query() formatına uygun olarak 2'ye böler. bu sadece bir dizinde elemanları tablo adı ve tablo değeri olarak ayırır ve veritabanına eklenmesini kolaylaştırır.
 * @return: $array['table_name'] ve $array['table_value'] olarak 2 dizi elamanı döndürür.
 */
function sql_insert_string($arr=array(), $opt=array())
{
	if(!isset($arr['insert'])) { @$arr['insert'] = $arr; }

	if(!is_array($opt)) { $opt = array('return'=>'string'); }
	if(!isset($opt['uniquetime'])) { unset($arr['insert']['uniquetime']); }
	if(!isset($opt['add'])) 	{ unset($arr['insert']['add']); }
	if(!isset($opt['update'])) 	{ unset($arr['insert']['update']); }
	if(!isset($opt['delete'])) 	{ unset($arr['insert']['delete']); }
	if(!isset($opt['again'])) 	{ unset($arr['insert']['again']); }
	if(!isset($opt['id'])) 		{ unset($arr['insert']['id']); }
	if(!isset($opt['return'])) { $opt['return'] = 'string'; }




	if(count($arr['insert']) > 0) {
		$return['table_name'] = 't_i_l_p_a_r_k_this_value_replace';
		$return['table_value'] = 't_i_l_p_a_r_k_this_value_replace';
		foreach($arr['insert'] as $name=>$value)
		{
			$return['table_name'] = $return['table_name'].', '.input_check($name);
			$return['table_value'] = $return['table_value'].", '".input_check($value)."'";
		}
		$return['table_name'] = str_replace('t_i_l_p_a_r_k_this_value_replace, ', '', $return['table_name']);
		$return['table_value'] = str_replace('t_i_l_p_a_r_k_this_value_replace, ', '', $return['table_value']);

		$return['table_name'] = str_replace('t_i_l_p_a_r_k_this_value_replace', '', $return['table_name']);
		$return['table_value'] = str_replace('t_i_l_p_a_r_k_this_value_replace', '', $return['table_value']);

		if($opt['return'] == 'string') {
			return '('.$return['table_name'].') VALUES ('.$return['table_value'].')';
		} else { return $return; }
	} else { return false; }

} //.sql_insert_string()



/**
 * sql_update_string()
 * @description: parametrede aldığı diziyi, mysql_query() formatına uygun olarak 2'ye böler. bu sadece bir dizinde elemanları tablo adı ve tablo değeri olarak ayırır ve veritabanına eklenmesini kolaylaştırır.
 * @return: $array['table_name'] ve $array['table_value'] olarak 2 dizi elamanı döndürür.
 */
function sql_update_string($arr=array(), $opt=array())
{
	if(!isset($opt['uniquetime'])) { unset($arr['uniquetime']); }
	if(!isset($opt['add'])) 	{ unset($arr['add']); }
	if(!isset($opt['update'])) 	{ unset($arr['update']); }
	if(!isset($opt['delete'])) 	{ unset($arr['delete']); }
	if(!isset($opt['again'])) 	{ unset($arr['again']); }
	if(!isset($opt['id'])) 		{ unset($arr['id']); }

	$return = 't_i_l_p_a_r_k_this_value_replace'; // bu deger silinecek
	foreach($arr as $name=>$value)
	{
		$return = $return.', '.$name."='".$value."'";
	}

	return str_replace('t_i_l_p_a_r_k_this_value_replace, ', '', $return);
} //.sql_update_string()






/**
 * sql_where_string()
 * bir sorgu için WHERE, ORDERBY, LIMIT gibi stringler olusturur
 */
function sql_where_string($arr) {

  	$r = false;

  	## eger "query" dizisi var ise sorgu el ile yazılmıştır.
  	if(isset($arr['query'])) {
    	return 'WHERE '.$arr['query'];
  	} else {

  		$order_by 	= false;
  		$limit 		= false;

    	foreach($arr as $key=>$val) {
      		if(is_numeric($key) and is_array($val)) {
        		foreach($val as $key1=>$val1) {
        			if(til_get_strtoupper($key1) == 'ORDER_BY') { $order_by = $val1; }
        			elseif(til_get_strtoupper($key1) == 'LIMIT') { $limit = $val1; }
        			else { $r .= _where_string($key1, $val1, $arr); }
        		}
      		} else {
      			if(til_get_strtoupper($key) == 'ORDER_BY') { $order_by = $val; }
      			elseif(til_get_strtoupper($key) == 'LIMIT') { $limit = $val; }
      			else { $r .= _where_string($key, $val, $arr); }
      		}
    	}
  	}

  	if($order_by) { $r .= _where_string('order_by', $order_by); }
  	if($limit) 	{ $r .= _where_string('limit', $limit); }


    # en bastaki deger "AND" ise silelim
    if(substr(trim($r), 0, 3) == 'AND') {
      	$r = trim(substr(trim($r), 3)); }

    $r = str_replace('OR AND', 'OR', $r);
    $r = str_replace('OR  AND', 'OR', $r);

    return 'WHERE '.trim($r);
} //.sql_where_string()





function _where_string($name, $val='', $arr=array()) {
  $r = false;

  if($name == 'unset') { return ''; }
  if(isset($arr['unset'][$name])) { return ''; }

  # OR
  if(til_get_strtoupper($name) == 'OR') { // eger OR degeri var ise
    $r = ' OR ';
  }
  # IN
  elseif(til_get_strtoupper($name) == 'IN') {

    foreach($val as $name=>$val) { // sadece bir tane deger ise
      if(!is_array($val)) {
        $r .= ' AND '.$name." IN ('".$val."')";
      } else { // NOT IN degeri dizi halinde gonderilmis ise
        $r .= ' AND '.$name." IN ('".implode("','", $val)."')";
      }
    }
  }
  # NOT IN
  elseif(til_get_strtoupper($name) == 'NOT_IN') {

    foreach($val as $name=>$val) { // sadece bir tane deger ise
      if(!is_array($val)) {
        $r .= ' AND '.$name." NOT IN ('".$val."')";
      } else { // NOT IN degeri dizi halinde gonderilmis ise
        $r .= ' AND '.$name." NOT IN ('".implode("','", $val)."')";
      }
    }
  }
  # LIKE
  elseif(til_get_strtoupper($name) == 'LIKE') {

    foreach($val as $name=>$val) { // sadece bir tane deger ise
      if(strstr($val, "%")) { $val = ''.$val.''; } else { $val = '%'.$val.'%'; }
      $r .= ' AND '.$name." LIKE '".$val."'";
    }
  }
  # NOT LIKE
  elseif(til_get_strtoupper($name) == 'NOT_LIKE') {

    foreach($val as $name=>$val) { // sadece bir tane deger ise

      if(strstr($val, "%")) { $val = ''.$val.''; } else { $val = '%'.$val.'%'; }
      $r .= ' AND '.$name." NOT LIKE '".$val."'";
    }
  }
  # ORDER BY
  elseif(til_get_strtoupper($name) == 'ORDER_BY') {
    $r .= ' ORDER BY ';
    foreach($val as $name=>$val) { // sadece bir tane deger ise
      $r .= ''.$name." ".$val.", ";
    }
    // fazlaliklari silelim
    if(substr($r, -2) == ', ') { $r = substr($r, 0, -2); }
  }
  # LIMIT
  elseif(til_get_strtoupper($name) == 'LIMIT') {
    $r .= ' LIMIT '.$val;
    // fazlaliklari silelim
    if(substr($r, -2) == ', ') { $r = substr($r, 0, -2); }
  }
  # ------
  else {
    if($name == 'q') {
      $r = ' AND '.$val;
    } else {
      if(!isset($arr['unset'][$name])) {
        $r = ' AND '.$name."='".$val."'";
      }
    }

  }


  return $r;
} //._where_string()






function old_sql_where_string($arr=array(), $opt=array() ) {

	$return = '';
	if(!isset($arr['where'])) { @$arr['where'] = $arr; }

	/* eger query olarak gonderilmis ise */
	if(isset($arr['where']['query'])) {
		return 'WHERE '.$arr['where']['query'];
	}



	// input_check
	$arr['where'] = input_check($arr['where']);


	foreach($arr['where'] as $key=>$val) {
		if($key != 'orderby' && $key != 'limit' && $key != 'unset') {
			if(is_array($val)) {
				if($key == 'not_in') {
					foreach($val as $_key=>$_val) {
						if(is_array($_val)) {
							$return .= " ".$_key." NOT IN (";
							foreach($_val as $__val) { $return .= "'".$__val."',";}
							$return .= ") AND";
							$return = str_replace(',)', ')', $return);
						} else {
							$return .= " ".$_key." NOT IN ('".$_val."') AND";
						}
					}
				}
			} else {
				// eger unset degeri icinde yok ise ekleme yap
				if(!isset($arr['where']['unset'][$key])) {
					$return .= " ".$key."='".$val."' AND";
				}
			}
		}
	}

	// en sonda olusan "AND" yazısını silelim
	if(substr($return,-3) == 'AND') { $return = substr($return,0,-3); }
	if(strlen($return) > 0) {
		$return = 'WHERE '.$return;
	}

	if(isset($arr['orderby'])) { $return .= ' ORDER BY '.$arr['orderby'];}
	if(isset($arr['limit'])) { $return .= ' LIMIT '.$arr['limit'];}

	return $return;
} //.sql_where_string()






/**
 * db_query_error();
 * db()->query() olusan hatalar icin log kaydı olusturur ve alert kutusuna "Veritabanı hatası: " basligi ile hata mesajini ekler
 */
function db_query_error($arr=array()) {
	if(is_array($arr)) {
		if(!isset($arr['name'])) { $arr['name'] = 'null'; }
		if(!isset($arr['class'])) { $arr['class'] = 'danger'; }
		if(!isset($arr['error_msg'])) { $arr['error_msg'] = db()->error; }
	} else {

		$arr = array('name'=>$arr);
		$arr['class'] = 'danger';
		$arr['error_msg'] = db()->error;
	}

	add_alert('Veritabanı hatası: '.$arr['error_msg'], $arr['class'], $arr['name']);
	add_log( array('log_key'=>'mysqli_error', 'log_text'=>$arr['error_msg']) );
	return false;
}





/**
 * db_query_list_return()
 * db()->query() ile donen sonuclari bir dizi icine alir ve dondurur
 */
function db_query_list_return($query, $arr=array()) {

	if(is_array($arr)) {

	} else {
		if(!empty($arr)) {
			$arr = array('prefix'=>$arr);
		}
	}

	$return = array();
	while($list = $query->fetch_object()) {
		if(isset($arr['prefix'])) {
			$return[$list->$arr['prefix']] = $list;
		} else {
			$return[] = $list;
		}

	}
	return $return;
} //.db_query_list_return()






/*
 *
 *
 */
/**
 * db_query_list_return_user()
 * db()->query() ile donen user tablosundaki sonuclari diziye ekler ve dondurur
 */
function db_query_list_return_user($query, $arr=array()) {

	if(is_array($arr)) {

	} else {
		if(!empty($arr)) {
			$arr = array('prefix'=>$arr);
		}
	}

	$return = array();
	while($list = $query->fetch_object()) {
		if(isset($arr['prefix'])) {
			if(!$list->avatar) { $list->avatar = get_template_url('img/no-avatar-'.$list->gender.'.jpg'); } else { $list->avatar = get_site_url($list->avatar); }
			if(!isset($list->display_name)) { $list->display_name = $list->name.' '.$list->surname; }

			$return[$arr['prefix']] = $list;
		} else {
			$return[] = $list;
		}

	}
	return $return;
} //.db_query_list_return_user()







/**
 * get_ARR_helper_limit_AND_orderby()
 *	listeleme yapildiginda limti ve page degerenin kontrol eder ve duzeltir
 */
function get_ARR_helper_limit_AND_orderby($arr) {

	if(@$arr['_GET'] == true) { // eger GET ile gelecek parametreler aktif ise GET parametlerine gore sorgu yapılabilir
		if(isset($_GET['page']) ) { $arr['page'] = input_check($_GET['page']); }
		if(isset($_GET['limit'])) { if($_GET['limit'] == 'false') { $arr['limit'] = false; } }
	}


	if(!isset($arr['limit'])) 	{ $arr['limit'] = til()->pg->list_limit; }
		else { $arr['limit'] = input_check($arr['limit']); }
	if(!isset($arr['page'])) 	{ $arr['page'] = 0; }
		else { $arr['page'] = input_check($arr['page']); }
		if($arr['page'] > 0) { $arr['page'] = ( $arr['page'] * $arr['limit'] ) - $arr['limit']; }


	// eger order by var ise yapalim
	if(!isset($arr['orderby_name']) and !isset($arr['orderby_type'])) {
		if(isset($_GET['orderby_name']) and isset($_GET['orderby_type'])) {
			$arr['orderby_name'] = input_check($_GET['orderby_name']);
			$arr['orderby_type'] = input_check($_GET['orderby_type']);
		}
	}

	if(@$arr['_GET'] == true) { // eger GET ile gelecek parametreler aktif ise GET parametlerine gore sorgu yapılabilir
		if(isset($_GET['s'])) { $arr['s'] = input_check($_GET['s']); }
		if(isset($_GET['db-s-where'])) { $arr['db-s-where'] = input_check($_GET['db-s-where']); } else { $arr['db-s-where'] = 'all'; }

		// status id
		if(isset($_GET['status_id'])) { $arr['status_id'] = $_GET['status_id']; }
	}

	// input check
	if(isset($arr['s'])) { $arr['s'] = input_check($arr['s']); }
	if(isset($arr['db-s-where'])) { $arr['db-s-where'] = input_check($arr['db-s-where']); }


	return $arr;
} //.get_ARR_helper_limit_AND_orderby()




/**
 * add_mysqli_error_log()
 * mysqli hatasi olustugunda veritabanina ekler
 */
function add_mysqli_error_log($function_name=__FUNCTION__) {
	$error_msg = db()->error;
	add_alert('<b>Veritabanı hatası:</b> '.$error_msg, 'danger', $function_name);
	add_log( array('log_key'=>'mysqli_error', 'log_text'=>$error_msg) );
	return false;
}



?>
