<?php

/* --------------------------------------------------- INPUT */




/**
 * is_currency()
 * degerin parasl oluo olmadigini kontrol eder
 */
function is_currency($val)
{
  $r = preg_match("/^-?([0-9]{1,3}+,?)?([0-9]{1,3}+,?)?([0-9]{1,3}+,?)?[0-9]{1,3}+(?:\.[0-9]{1,19})?$/", $val); return $r;
} //.is_currency()



/**
 * is_email()
 * bir string degerinin e-posta olup olmadigini kontrol eder
 */
function is_email($val)
{
	if (filter_var($val, FILTER_VALIDATE_EMAIL)) { return true; } else { return false; }
} //.is_email()





/**
 * get_set_decimal_db()
 * parasal olan bir degerin icindeki (vigrül ",") işaretlerini siler
 */
function get_set_decimal_db($val)
{
	return str_replace(',', '', $val);
} //.get_set_decimal_db()

/**
 * set_decimal_db()
 * ref:get_set_decimal_db()
 */
function set_decimal_db($val)
{
	echo get_set_decimal_db($val);
} //.set_decimal_db()






/**
 * get_set_gsm()
 * bir telefon numarasının cep telefonu numarası oldugunu dorular ve degerinin basindaki sifiri kaldirir
 */
function get_set_gsm($val) {
	if(strlen($val) > 11) { return false; }
	if(strlen($val) < 10) { return false; }

	if(strlen($val) == 11) {
		if(substr($val, 0,1) == 0) {
			$val = substr($val, 1);
		}
	}
	return $val;
}


function get_set_show_phone($val) {
	if(strlen($val) > 11) { return $val; }
	if(strlen($val) < 10) { return $val; }

	if(strlen($val) == 11) {
		if(substr($val, 0,1) == 0) {
			$val = substr($val, 1);
		}
	}


	return '0 ('.substr($val, 0, 3).') '.substr($val,3,3).' '.substr($val,6);
}






/**
 * form_validation()
 * form ile gelen verileri kontrol eder ve istenilen türde olup olamdığını kontrol eder.
 */
function form_validation($val, $input_name='', $name='', $options=array(), $alert_name='form')
{
	global $til;


	if(!is_array($options))
	{
		$explode = explode('|', $options);

		foreach($explode as $exp)
		{

			/* form_validation()|required /;
				@description: değişkenin boş olup olmadığını kontrol eder /;
				@return: sonuç olarak "false" döndürür ve "$error" dizisine hata mesajını ekler. /; */
			if($exp == 'required') {
				if(empty($val)){ add_alert('<b>'.$name.'</b> yazı alanı boş bırakılamaz.', 'danger', $alert_name, $input_name); }
			}


			/* form_validation()|min_length[int] /;
				@description: değişkenin minimum/en az karakter sayısını kontrol eder /;
				@return: sonuç olarak "false" döndürür ve "$error" dizisine hata mesajını ekler. /; */
			else if(strstr($exp, 'min_length') AND mb_strlen($val,'utf-8') > 0) { $min_length = str_replace(']', '', str_replace('min_length[', '', $exp));
				if(mb_strlen($val,'utf-8') < $min_length){ add_alert('<b>'.$name.'</b> yazı alanı en az '.$min_length.' karekter olmalıdır.', 'danger', $alert_name, $input_name); }
			}


			/* form_validation()|max_length[int] /;
				@description: değişkenin maksimum/en fazla karakter sayısını kontrol eder /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if(strstr($exp, 'max_length')) { $max_length = str_replace(']', '', str_replace('max_length[', '', $exp));
				if(mb_strlen($val,'utf-8') > $max_length){ add_alert('<b>'.$name.'</b> yazı alanı en fazla '.$max_length.' karekter olabilir.','danger', $alert_name, $input_name); }
			}


			/* form_validation()|number /;
				@description: değişkenin sayısal bir değere sahip olup olmadığını kontrol eder /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'number' AND strlen($val) > 0) {
				if(!ctype_digit($val)){ add_alert('<b>'.$name.'</b> yazı alanı sayısal değer olmalıdır.', 'danger', $alert_name, $input_name); }
			}


			/* form_validation()|alpha /;
				@description: değişkenin "alfabetik" yani "sayısal olmayan" degere sahip olup olmadigini kontrol eder. Örnek: azAZ /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'alpha' AND strlen($val) > 0) {
				if(!ctype_alpha($val)){ add_alert('<b>'.$name.'</b> yazı alanı alfabetik değere sahip olmalıdır.', 'danger', $alert_name, $input_name); }
			}


			/* form_validation()|alnum /;
				@description: değişkenin "alfabetik ve sayısal" degere sahip olup olmadigini kontrol eder. Örnek: azAZ09 /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'alnum' AND strlen($val) > 0) {
				if(!ctype_alnum($val)){ add_alert('<b>'.$name.'</b> yazı alanı alfabetik değere sahip olmalıdır.', 'danger', $alert_name, $input_name); }
			}


			/* form_validation()|money /;
				@description: değişkenin parasal bir değere sahip olup olmadığını kontrol eder. ÖRNEK: "10", "10.50" /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'money' AND strlen($val) > 0) {
				if(!is_currency($val)){ add_alert('<b>'.$name.'</b> yazı alanı parasal bir değere sahip olmalıdır.', 'danger', $alert_name, $input_name); }
			}


			/* form_validation()|email /;
				@description: değişkenin e-posta olup olmadığını kontrol eder. /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'email' AND strlen($val) > 0) {
				if(!is_email($val)){ add_alert('<b>'.$name.'</b> yazı alanı "e-posta" formatına uygun olmalıdır.', 'danger', $alert_name, $input_name); }
			}


			/* form_validation()|gsm /;
				@description: değişkenin cep telefonu formatında olup olmadıgını kontrol eder /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'gsm' AND strlen($val) > 0) {
				if(!preg_match('/0?(5(0|3|4|5)[0-9])[0-9]{7}/isU', $val, $match)){ add_alert('<b>'.$name.'</b> yazı alanı cep telefonu formatına uygun olmalıdır. <small>Örnek: "5351234567" veya "05341234567"</small>', 'danger', $alert_name, $input_name); }
				if(substr($val,0,1) != '0' AND strlen($val) > 10 ) { add_alert('<b>'.$name.'</b> yazı alanı cep telefonu formatına uygun olmalıdır. <small>Örnek: "5351234567" veya "05341234567"</small>', 'danger', $alert_name, $input_name); }
			}


			/* form_validation()|date /;
				@description: değişkenin tarih formatında olup olmadıgını kontrol eder /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'date' AND strlen($val) > 0) {
				if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $val, $match)){ add_alert('<b>'.$name.'</b> yazı alanı tarih formatına uygun olmalıdır. <small>Örnek: "2010-05-25"</small>', 'danger', $alert_name, $input_name); }
			}


			/* form_validation()|datetime /;
				@description: değişkenin tarih formatında olup olmadıgını kontrol eder /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'datetime' AND strlen($val) > 0) {
				if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}$/', $val, $match)){ add_alert('<b>'.$name.'</b> yazı alanı tarih ve saat formatına uygun olmalıdır. <small>Örnek: "2010-05-25 16:00"</small>', 'danger', $alert_name, $input_name); }
			}


			/* form_validation()|boolean /;
				@description: değişkenin formatının boolean olup olmadigini kontrol eder /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'boolean' AND strlen($val) > 0) {
				if($val != 1 && $val != true && $val != 0 && $val != false) { add_alert('<b>'.$name.'</b> alanı doğru/yanlış veri tipine sahip olmalıdır. <small>Örnek: "0/1 veya true/false"</small>', 'danger', $alert_name, $input_name); }			}


		}
	}

	return $val;
}








/**
 * add_alert()
 * $til->alert[] dizisine hata mesajı ekler
 */
function add_alert($message, $class='danger', $group='global', $input_name='') {
	if(empty($input_name)) {
		$input_name = 'null';
	}

	til()->alert[$group][$class][$input_name][] = $message;
}



/**
 * is_alert()
 * bir hata mesajının var olup olmadigini kontrol eder
 */
function is_alert($group='', $class='')
{
	if(!empty($group)) {

		if(isset(til()->alert[$group])) {
			if(!empty($class)) {
				if(isset(til()->alert[$group][$class])) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		} else {
		 	return false;
		}
	} else {
		if(isset(til()->alert)) {
			return true;
		} else {
			return false;
		}
	}

}



/**
 * print_alert()
 * butun hata mesajlarını ekrana basar
 */
function print_alert($alert_name='', $options=array())
{ global $til;
	if(@$til->alert)
	{
		if($alert_name == ''){ $alert = $til->alert; } else { if(isset($til->alert[$alert_name])) { $alert = $til->alert[$alert_name]; $alert = array('0'=>$alert); } else { $alert=false; } }
		if($alert) {
			foreach($alert as $func_name=>$sub_alert)
			{
				foreach($sub_alert as $class=>$array_messages)
				{
					if(count($array_messages, COUNT_RECURSIVE) > 2)
					{	$one_message = '<ul>';
						foreach($array_messages as $message)
						{
							foreach($message as $msg) {
								$one_message .= '<li>'.$msg.'</li>';
							}
						}
						$one_message .= '</ul>';
						echo get_alert($one_message, $class.' FUNC_NAME_'.$func_name, $options);
					}
					else
					{
						foreach($array_messages as $message)
						{
							echo get_alert($message[0], $class.' FUNC_NAME_'.$func_name, $options);
						}

					}
				}
			}
		}
	}
}










/**
 * get_alert()
 * ozel bir hata mesajı olusturabilirsiniz.
 */
function get_alert($message, $class='danger', $options=array())
{

	if(!is_array($options)) { $options = array('x'=>$options); }

	if(is_array($message))
	{
		@$r['title'] = $message['title'];
		@$r['description'] = $message['description'];
		if(isset($message['x'])){ $r['x'] = $message['x']; } else { $r['x'] = true; }
	} else {
		$r['description'] = $message;
	}

	# uyarı kutusundaki "x" butonunu durumunu belirtiyoruz. eger $options dizisinde bir deger girilmemis ise, otomatik "true" yaptırıyoruz
	if(!isset($options['x'])){ $options['x'] = true; }
	if(empty($options['x']) and @$options['x'] == false) { $options['x'] = ''; } else { $options['x'] = 'alert-dismissible'; }

	# yukarıdaki bilgiler dogrultusunda uyarı kutusunu olustur
	$alert = '<div class="alert alert-'.$class.' '.$options['x'].' fade in" role="alert">';
	if(@$options['x'] == true) { $alert = $alert.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'; }
	if(@$r['title']) { $alert = $alert.'<h4>'.$r['title'].'</h4>'; }
	if(@$r['description']) {$alert = $alert.'<p>'.$r['description'].'</p>'; }
	$alert = $alert.'</div>';

	return $alert;
}



/**
 * alert_form_element()
 * bu fonksiyon form metotu ile gelen hata mesajlarını alır ve form elemenlerine has-error, has-warning tarzında stil ekler
 * bu sayede son kullanıcı hangi input verisinden hata geldigini gorebilecektir
 */
function alert_form_element($group='form') {
	if(isset(til()->alert)) {
		foreach(til()->alert as $group) {
			foreach($group as $form_class=>$form_alert) {
				if($form_class == 'danger') {
					$class='has-error';
				} elseif($form_class == 'warning') {
					$class='has-warning';
				} else {
					$class='';
				}
				foreach($form_alert as $name=>$message) {
					?>
					<script>
					$(document).ready(function() {
						$("input[name='<?php echo $name; ?>']").parent('.form-group').addClass('<?php echo $class; ?>');
					})
					</script>
					<?php
				}
			}
		}
	}
}













/**
 * get_checked()
 * input[checked] ve input[radio] formlari icin checked="checked" ekler
 */
function get_checked($val_1, $val_2 = 'deneme') {
	if(is_array($val_2)) {
		if(in_array($val_1, $val_2)) {
			return 'checked';
		} else {
			return '';
		}
	} else {
		if(empty($val_2)) {
			if($val_1) {
				return 'checked';
			} else {
				return '';
			}
		} else {
			if($val_1 == $val_2) {
				return 'checked';
			} else {
				return '';
			}
		}
		
	}

} //.get_checked()

/**
 * checked()
 * ref:get_checked()
 */
function checked($val_1, $val_2) {
	echo get_checked($val_1, $val_2);
} //.checked()






/**
 * get_selected()
 * input[checked] ve input[radio] formlari icin checked="checked" ekler
 */
function get_selected($val_1, $val_2) {
	if($val_1 == $val_2) {
		return 'selected';
	} else {
		return '';
	}
} //.get_checked()

/**
 * selected()
 * ref:get_selected()
 */
function selected($val_1, $val_2) {
	echo get_selected($val_1, $val_2);
} //.checked()







/* --------------------------------------------------- URL */

/**
 * get_current_url()
 * aktif olan sayfanın URL adresini dondurur
 */
function get_current_url($type='request_uri') {
	if($type == 'request_uri') {
		return $_SERVER['REQUEST_URI'];
	} elseif($type == 'script_name') {
		return $_SERVER['SCRIPT_NAME'];
	} else {
		return $_SERVER['SERVER_NAME'];
	}

}



/**
 * get_set_url_parameters()
 * aktif olan sayfada bulunan GET parametrelerini alır, yeni GET parametresi ekler ve siler
 */
function get_set_url_parameters($arr=array()) {
	$url = get_current_url('script_name');
	$parameters = '?';

	if(isset($arr['add']) and is_array(@$arr['add'])) {
		foreach($arr['add'] as $key=>$val) {
			$parameters .= '&'.$key.'='.$val;
		}
	}

	foreach($_GET as $key=>$val) {
		if(!isset($arr['add'][$key]) AND !isset($arr['remove'][$key])) {
			$parameters .= '&'.$key.'='.$val;
		}
	}

	$parameters = str_replace('?&', '?', $parameters);
	return $url.$parameters;
} //.get_set_url_parameters()

/**
 * set_url_parameters()
 * ref:get_set_url_parameters()
 */
function set_url_parameters($arr=array()) {
	echo get_set_url_parameters($arr);
}

/**
 * get_url_parameters_for_form()
 * GET ile deger gonderilen formlara aktif olan GET parametrelerinide ekler ve siler
 */
function get_url_parameters_for_form($arr=array()) {

	$url = get_current_url('script_name');
	$parameters = '';

	if(isset($arr['add']) and is_array(@$arr['add'])) {
		foreach($arr['add'] as $key=>$val) {
			$parameters .= '<input type="text" name="'.$key.'" id="func_'.$key.'" value="'.$val.'">';
		}
	}

	foreach($_GET as $key=>$val) {
		if(!isset($arr['add'][$key]) && !isset($arr['del'][$key]) ) {
			$parameters .= '<input type="hidden" name="'.$key.'" id="func_'.$key.'" value="'.$val.'">';
		}
	}

	return $parameters;
}

?>
