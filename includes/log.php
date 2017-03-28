<?php
/* --------------------------------------------------- LOG */


/**
 * uniquetime()
 * POST spamlarını onlemek amacili ile uniquetime yani essiz bir tarih degeri olusturur ve log kayitlari icin kullanılır.
 */
function get_uniquetime() {
	return microtime(true);
}
function uniquetime() {
	echo get_uniquetime();
}



/**
 * add_log()
 * veritabanına log kayiti ekler
 * güvenlik, hata kayıtları, veritabanı hataları, kullanıcı islem detayları burada kayıt edilebilir.
 * coklu kullanım amacı ile üretilmiştir.
 */
function add_log($arr=array()) {

	if( !isset($arr['date']) ) 			{ $arr['date'] = date('Y-m-d H:i:s'); }
	if( !isset($arr['uniquetime']) ) 	{ if(isset($_POST['uniquetime'])) { $arr['uniquetime'] = $_POST['uniquetime']; } elseif(isset($_GET['uniquetime'])) { $arr['uniquetime']=$_GET['uniquetime']; } else { $arr['uniquetime'] = get_uniquetime(); } }
	if( !isset($arr['table_id']) ) 		{ $arr['table_id'] = ''; }
	if( !isset($arr['user_id']) ) 		{ $arr['user_id'] = get_active_user_id(); }
	if( !isset($arr['log_url']) ) 		{ $arr['log_url'] = $_SERVER['REQUEST_URI']; }
	if( !isset($arr['log_key']) ) 		{ $arr['log_key'] = ''; }
	if( !isset($arr['log_text']) ) 		{ $arr['log_text'] = ''; }

	// input_check
	$arr = input_check($arr);


	$q_insert = db()->query("INSERT INTO ".dbname('logs')."  (date, uniquetime, table_id, user_id, log_url, log_key, log_text) VALUES 
		(
		'".input_check($arr['date'])."', 
		'".input_check($arr['uniquetime'])."', 
		'".input_check($arr['table_id'])."', 
		'".input_check($arr['user_id'])."', 
		'".input_check($arr['log_url'])."',
		'".input_check($arr['log_key'])."', 
		'".input_check($arr['log_text'])."'
		) ");

	if(isset($arr['meta'])) {
		if($arr['meta'] != false) {
			add_log_meta(db()->insert_id, $arr['meta']);
		}
	}
}




/**
 * have_log()
 * uniquetime degerine  gore bir log kaydının olup olmadigini kontrol eder
 */
function have_log($uniquetime='') {
	if(empty($uniquetime)) {
		if(isset($_POST['uniquetime'])) {
			$uniquetime = $_POST['uniquetime'];
		} elseif(isset($_GET['uniquetime'])) {
			$uniquetime = $_GET['uniquetime'];
		} else {
			return false;
		}
	}


	$query = db()->query("SELECT * FROM ".dbname('logs')." WHERE uniquetime='".$uniquetime."' AND user_id='".get_active_user_id()."' ");
	if($query->num_rows > 0) {
		return true;
	} else {
		return false;
	}

}





/**
 * get_logs()
 * log kayıtlarını dondurur
 */
function get_logs($query) {
	$query_str = "SELECT * FROM ".dbname('logs')." WHERE ".$query." ORDER BY id DESC ";
	if($query = db()->query($query_str)) {
		if($query->num_rows) {

			$users = get_users(); // butun aktif uyeleri listeyelim

			$return = array();
			while($list = $query->fetch_object()) {

				// kullanici bilgisini aliyor ve ekliyoruz
				if(isset($users[$list->user_id])) {
					$list->name_surname = trim($users[$list->user_id]->name.' '.$users[$list->user_id]->surname);
				} else {
					$list->name_surname = 'empty';
				}
				

				$return[$list->id] = $list;
				if($log_meta = get_log_meta($list->id)) {

					$return[$list->id]->meta = $log_meta;
				}
			}

			return $return = (object) $return;
		} else {
			add_alert('Log kaydı bulunamadı.', 'warning', 'get_logs');
			return false;
		}
	} else {
		add_alert('<b>Veritabanı hatası:</b> '.db()->error, 'danger', 'get_logs');
		return false;
	}
}






/**
 * add_log_meta()
 * log dosyaları icin meta yani ek bilgi ekler bu log tablosunu fazla şişirmez
 */
function add_log_meta($log_id, $meta_val) {
	if($query = db()->query("INSERT INTO ".dbname('log_meta')." (log_id, meta_val) VALUES ('$log_id', '$meta_val') ")) {
		if(db()->affected_rows) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}




/**
 * get_log_meta()
 * log kayıtlarına ait meta kaydı var ise dondurur
 */
function get_log_meta($log_id) {
	if($query = db()->query("SELECT * FROM ".dbname('log_meta')." WHERE log_id='".$log_id."' ")) {
		if($query->num_rows) {
			$return = array();
			while($list = $query->fetch_object()) {
				$return[] = $list->meta_val;
			} 
			return $return;
		} else {
			return false;
		}
	} else {
		return false;
	}
}














/**
 * log_compare()
 * 2 dizi arasındaki farklı olan değerleri karşılaştır ve farklı olan sonuçları göndürür
 */
function log_compare($arr1, $arr2) {
	$return = array();

	if(is_object($arr1)) {
		$arr1 = get_object_vars($arr1);
	}

	if(is_object($arr2)) {
		$arr2 = get_object_vars($arr2);
	}

	$unset = array();
	array_push($unset, 'status_id');
	array_push($unset, 'date_updated');

	foreach($unset as $uns) {
		unset($arr2[$uns]);
	}

	foreach($arr1 as $a_key=>$a_val) {
		if(isset($arr2[$a_key]) and $arr2[$a_key] != $a_val) {
			$return[$a_key]['old'] = $a_val;
			$return[$a_key]['new'] = @$arr2[$a_key];
		}
	}
	if(count($return) > 0) {
		return json_encode_utf8($return);
	} else {
		return false;
	}
}









function repetitive_operation($function_name, $message='', $class='warning') {
	if(empty($message)) {
		$message = 'Bu işlem daha önceden gerçekleşmiş. "<b>'.$function_name.'()</b>"';
	}
	add_alert($message, $class, $function_name);
	return false;
}







/** 
 * add_console_log()
 * tarayıcının consol loguna veri ekler
 */
/**
 * add_console_log()
 * tarayıcının soncoluna mesaj basar
 */
function add_console_log( $args, $function_name=false ) {

	if(!$function_name) { $function_name = 'Tilpark'; }
    if ( is_array( $args ) )
        $output = "<script>console.log( '".$function_name.": " . implode( ',', $args) . "' );</script>";
    else
        $output = "<script>console.log( '".$function_name.": " . $args . "' );</script>";

    echo $output;
}














?>