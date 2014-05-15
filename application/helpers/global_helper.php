<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// veritabanini tekrar yukle
$ci =& get_instance();
$ci->load->database();

date_default_timezone_set('Europe/Istanbul');


function get_alertbox($type='alert-info', $title='', $content='', $x=true)
{
	$text = '';
	if($x==true){ $text = $text.'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'; }
	if($title != ''){ $text = $text.'<h4>'.$title.'</h4>'; }
	if($content != ''){ $text = $text.'<p>'.$content.'</p>'; }

	$alertbox = '
	<div class="alert alert-block '.$type.' fade in">
        '.$text.'
    </div>';
	return $alertbox;
}


function alertbox($type='alert-info', $title='', $content='', $x=true)
{
	echo get_alertbox($type, $title, $content, $x);
}




function gsm_trim($gsm)
{
	if(strlen($gsm) < 10)
	{
		return false;
	}
	else if(substr($gsm, 0,1) == 0)
	{
		return substr($gsm,1);
	}
	else
	{
		return $gsm;
	}
}






function update_option($data)
{
	$ci =& get_instance();
	if(isset($data['id'])){ $ci->db->where('id', $data['id']); }
	if(isset($data['group'])){ $ci->db->where('group', $data['group']); }
	if(isset($data['key'])){ $ci->db->where('key', $data['key']);  }
	$query = $ci->db->get('options')->row_array();
	
	if($query)
	{
		$ci->db->where('id', $query['id']);
		$ci->db->update('options', $data);
		if($ci->db->affected_rows() > 0)
		{
			return true;	
		}
	}
	else
	{
		$ci->db->insert('options', $data);
		return $ci->db->insert_id();
	}
	
	
}

function delete_option($data)
{
	$ci =& get_instance();
	$ci->db->where($data);
	$ci->db->delete('options');
	if($ci->db->affected_rows() > 0)
	{
		return true;	
	}
	else
	{
		return false;
	}
}

function get_option($data)
{
	$ci =& get_instance();
	
	$ci->db->where($data);
	$query = $ci->db->get('options')->row_array();	
	if($query)
	{
		return $query;
	}
	else
	{
		return false;	
	}
}

function get_options($data, $array=array())
{
	$ci =& get_instance();
	
	$ci->db->where($data);
	if(isset($array['order_by'])){ $ci->db->order_by($array['order_by']); }
	$query = $ci->db->get('options')->result_array();
		
	if($query)
	{
		$return = array();
		foreach($query as $q)
		{
			if(isset($array['default_value'])) { $return[$q[$array['default_value']]] = $q; }
			else { $return[$q['key']] = $q;  }
		}
		return $return;
	}
	else
	{
		return false;
	}
}





function error_page_message($title,$code,$message, $array=array())
{
	?>
    <div class="error-page">
		<?php echo $title; ?>
        <span class="error-code"><?php echo $code; ?></span>
		<small><?php echo $message; ?></small>
    </div>
    <?php
}





/*	selected item selected
	input[type=select] türündeki nesneler için otomatik seçici fonksiyon */
function selected($val1, $val2)
{
	if($val1 == $val2)
	{
		echo 'selected';
	}
}





/* GLOBAL DEĞİŞKENLER 
	buradaki değişkenler her sayfa yüklenişsinde 1 kereye mahsus çekilir. Çünkü buradaki değerler bazı sayfalarda birden fazla
	sorguya sebeb olabilir. Veritabanı sorgusunu küçültmek için bu değerleri GLOBAL değişkenine atıyoruz
	30.01.2014 tarihinde sistemi gülendirmek adına GLOBAL değişkenindeki verileri fonksiyonlara atadık.
	 */

#
$GLOBALS['access'] = get_options(array('group'=>'access'));
function get_access($key, $val='')
{
	if($val == '')
	{
		return $GLOBALS['access'][$key]['val_1'];
	}
	else
	{
		return $GLOBALS['access'][$key][$val];
	}
}

$GLOBALS['setting'] = get_options(array('group'=>'setting'));
function get_setting($key, $val='')
{
	if($val == '')
	{
		return $GLOBALS['setting'][$key]['val_1'];
	}
	else
	{
		return $GLOBALS['setting'][$key][$val];
	}
}



/* ITEM ACCESS */
function item_access($key, $data='')
{
	$ci =& get_instance();
	
	if(get_the_current_user('role') == 1)
	{
		return true;
	}
	else
	{
		foreach($GLOBALS['access'] as $access)
		{
			if($access['key'] == $key)
			{
				if($access['val_1'] >= get_the_current_user('role'))
				{
					return true;
				}
			}
		}

		return false;	
	}
}






function get_barcode($text)
{
	return base_url('plugins/barcode/barcode.php?text='.$text); 
}

function get_print_barcode($text)
{
	return site_url('general/barcode/'.replace_text_for_utf8(strtolower($text)));
}



function replace_text_for_utf8($text) {
	$text = trim($text);
	$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
	$replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
	$new_text = str_replace($search,$replace,$text);
	return $new_text;
}  


function get_money($value, $data='')
{
	if(!isset($data['virgule'])){ $data['virgule'] = ','; }
	
	return number_format($value,2, '.', $data['virgule']);
	
	
}




function add_date_time($date, $number, $type)
{
	$date = explode('-', $date);
	
	if($type=='d')
	{
		return date("Y-m-d", mktime(0, 0, 0, $date[1], $date[2]+$number, $date[0]));
	}
	else if($type=='m')
	{
		return date("Y-m-d", mktime(0, 0, 0, $date[1]+$number, $date[2], $date[0]));
	}
	else if($type=='Y')
	{
		return date("Y-m-d", mktime(0, 0, 0, $date[1], $date[2], $date[0]+$number));
	}
}




function days_left($date, $eksi='')
{
	$date1 = strtotime(date('Y-m-d')); 
	$date2 = strtotime(substr($date,0,10)); 
	$day = ($date1-$date2)/86400 ;
	if($eksi == '')
	{ 
		return str_replace('-', '', round($day)); 
	}
	else if($eksi == '+')
	{
		$day = ($date2-$date1)/86400 ;
		return str_replace('', '', round($day)); 
	}
	else
	{
		return str_replace('', '', round($day)); 
	}
}



function hours_left($date)
{
	$date1 = strtotime(date('Y-m-d H:i:s'));
	$date2 = strtotime($date); 
	$day = ($date2-$date1)/3600 ; 
	return str_replace('', '', round($day)); 
}

function hours_late($date, $data)
{
	$date1 = strtotime(date('Y-m-d H:i:s'));
	$date2 = strtotime($date); 
	$day = ($date1-$date2)/3600 ; 
	
	$day = str_replace('', '', round($day));
	
	return $day; 
}



function days_late($date)
{
	$date1 = strtotime(date('Y-m-d H:i:s'));
	$date2 = strtotime($date); 
	$day = (($date1-$date2)/3600)/24 ; 
	return str_replace('', '', round($day)); 
}


function time_late($date)
{
	$date1 = strtotime(date('Y-m-d H:i:s'));
	$date2 = strtotime($date); 
	$day = (($date1-$date2)/3600)/24 ;
	
	if($day < 1)
	{
		$hours = $day * 24;
		if($hours < 1)
		{
			$second = $hours * 3600;
			if($second < 60)
			{
				return str_replace('', '', $second). ' saniye'; 
			}
			else
			{
				return str_replace('', '', round($second / 60)). ' dakika'; 
			}
		}
		else
		{
			return str_replace('', '', round($hours)). ' saat'; 	
		}
	}
	else
	{
		return str_replace('', '', round($day)). ' gün'; 
	}
	
}



function excel_reader($inputFileName)
{
	/** PHPExcel_IOFactory */
	include 'plugins/excel_reader/Classes/PHPExcel/IOFactory.php';
	
	
	//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
	try {
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	} catch(Exception $e) {
		die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	}
	
	return $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
}





/* 	SMS 
	fonksiyonlar TilPark! sistemine 27 Kasım 2013 Çarşamba günü eklenmiştir.
	SMS fonksiyonları ile tilpark sisteminden sms gönderimi yapabilirsiniz.
*/
function sms_curl($post='')
{
	if(is_array($post))
	{
		$_POST = $post;
	}
	
	$ch = curl_init(); // oturum baslat
	// POST adresi
	curl_setopt($ch, CURLOPT_URL,"http://www.tilpark.com/sms/index.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt ($ch, CURLOPT_REFERER, 'http://www.google.com.tr');
	curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
	$html = curl_exec($ch);
	curl_close ($ch);
	
	return $html;
}

/* SMS gönderme fonksiyon */
function send_sms($username, $password, $sms)
{
	$xml = '';
	$quantity = 0;
	$i = 0;
	while($i < 100000)
	{
		if(isset($sms[$i]))
		{
			if($sms[$i]['gsm'] == ''){}
			else
			{
				$sms_quantity = ceil(strlen($sms[$i]['sms']) / 160);
				$quantity = $quantity + $sms_quantity;
				
				$xml = $xml.'
				<YOLLA>
					<MESAJ>'.$sms[$i]['sms'].'</MESAJ>
					<NO>'.$sms[$i]['gsm'].'</NO>
				</YOLLA>';
			}
		}
		else
		{
			$i = 9000000;	
		}
		$i++;
	}
	
	
	// sms kullanıcı adı ve şifre bilgilerini çekiyoruz
	$sms_balance = get_option(array('group'=>'sms', 'key'=>'sms_balance'));
	if($sms_balance > $quantity)
	{
		$html = sms_curl(array('send_sms'=>'', 'sms_username'=>$username, 'sms_password'=>$password, 'quantity'=>$quantity, 'xml'=>$xml));
		if($html == 'ERR_USERNAME_PASSWORD'){ alertbox('alert-danger', 'SMS sunucusuna bağlantı kurulamadı, Hatalı kullanıcı adı ve şifre');	return false;}
		else if($html == 'sms_bakiyesi_yok'){ alertbox('alert-danger', 'Yeterli SMS paketi yok.', 'SMS gönderebilmeniz için SMS paketi satın almalısınız.');	return false;}
		else
		{
			return true;
		}
	}
	else
	{
		alertbox('alert-danger', 'Yeterli SMS bakiyeniz yok.');	 return false;
	}
}

/* SMS bilgilerini günceller
	kaç tane sms gönderildiğini
	kaç tane sms hakkının kaldığını "options" veritabanına ekler
 */
function update_sms_info($username, $password)
{		
	$data = array('get_sms_info'=>'', 'sms_username'=>$username, 'sms_password'=>$password);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, "http://tilpark.com/sms/index.php");   
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$get_xml = curl_exec($ch);
	curl_close($ch);

	$xml = simplexml_load_string($get_xml);

	if($xml->balance_sms == ''){$xml->balance_sms = 0;}
	if($xml->send_sms == ''){$xml->send_sms = 0;}
	
	$option['group'] = 'sms';
	$option['key'] = 'sms_balance';
	$option['val_1'] = $xml->balance_sms;
	$option['val_2'] = $xml->send_sms;
	update_option($option);
	
}

/* SMS sistemine bağlanır, kullanıcı adı ve şifre doğrumudur diye kontrol eder */
function sms_connect($username, $password)
{
	return sms_curl(array('login_control'=>'', 'sms_username'=>$username, 'sms_password'=>$password));
}





/* 	bu fonksiyon türkçe karekterleri temizler 
	dikkat etmeniz gereken üye girişi gibi alanlarda kullanılmaz. 
	sadece türkçede bulunan 8 noktalı karekteri temizler */
function replace_turkish_letters($text) {
	$text = trim($text);
	$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
	$replace = array('C','c','G','G','i','I','O','o','S','s','U','u');
	$new_text = str_replace($search,$replace,$text);
	return $new_text;
}

/* 	bu fonksiyon türkçe karekterleri temizler 
	dikkat etmeniz gereken üye girişi gibi alanlarda kullanılmaz. 
	sadece türkçede bulunan 8 noktalı karekteri temizler */
function replace_TR($text) {
	$text = trim($text);
	$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
	$replace = array('C','c','G','G','i','I','O','o','S','s','U','u');
	$new_text = str_replace($search,$replace,$text);
	return $new_text;
}

function logTime()
{
	return str_replace('.', '', str_replace(' ', '', microtime()));
}


function date_replace_TR($date)
{
	$month_engs = array( 
    "January", "February", "March", "April", "May", "June",  
    "July", "August", "September", "October", "November", "December" 
    ); 
	$day_engs = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"); 
	$months = array( 
		"Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",  
		"Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" 
		); 
	$days = array("Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi", "Pazar"); 
	$date = str_replace($month_engs, $months, $date); 
	$date = str_replace($day_engs, $days, $date); 
	return $date;
}
?>
<?php
function calc_cahsbox($cahsbox_id='')
{
	if($cahsbox_id == ''){ return false; }
	$ci =& get_instance();
	
	$ci->db->where('status', 1);
	$ci->db->where('val_int', $cahsbox_id);
	$ci->db->where('type', 'payment');
	$ci->db->where('in_out', 'out');
	$ci->db->select_sum('grand_total');	
	$out = $ci->db->get('forms')->row_array();
	
	$ci->db->where('status', 1);
	$ci->db->where('val_int', $cahsbox_id);
	$ci->db->where('type', 'payment');
	$ci->db->where('in_out', 'in');
	$ci->db->select_sum('grand_total');	
	$in = $ci->db->get('forms')->row_array();
	
	$balance = $in['grand_total'] - $out['grand_total'];
	
	update_option(array('id'=>$cahsbox_id, 'val_decimal'=>$balance));
}



function get_text_payment_type($text)
{
	if($text == 'cash'){return 'NAKİT';}
	if($text == 'cheque'){return 'BANKA ÇEKİ';}
	if($text == 'bank_transfer'){return 'HAVALE/EFT';}
}
?>