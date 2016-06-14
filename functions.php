<?php
ob_start();
session_start();



/*** GLOBAL ***/

/* root_path
 * Gerekli fonksiyon sayfalarını ic ice aktarırken isimizi kolaylastiracak fonksiyon
*/
define( 'ROOT_PATH', dirname(__FILE__));
function root_path($val)
{
	return ROOT_PATH.'/'.$val;
}
include root_path('config.php');


include root_path('inc/func_tilTable.php');




/* get_header() */
function get_header()
{
	include root_path('inc/_header.php');
}

function get_footer()
{ global $is_sidebar;

	if($is_sidebar == true)
	{
		echo '</div></div>';
	}
	include root_path('inc/_footer.php');
}


function get_sidebar()
{ global $is_sidebar;

	include root_path('inc/_sidebar.php');
	$is_sidebar = true;
}

function get_sidebar_end()
{
	echo '</div></div>';
}



// function
function get_site_url($val='')
{
	return _site_url.'/'.$val;
}
function site_url($val='')
{
	echo get_site_url($val);
}




/*** USER ***/

/* is_login
 * Uye girisi yapilmis mi? diye kontrol eder
*/
function is_login()
{
	if(isset($_SESSION['user_id']))
	{
		return $_SESSION['user_id'];
	}
	else
	{
		return false;
	}
}


// herseyden once bir uyenin giris yapip yapmadigini kontrol ediyoruz
if(!is_login())
{
	$page_url = $_SERVER['REQUEST_URI'];
	if(!strstr($page_url, "login.php"))
	{
		header("Location: ".get_site_url('login.php'));
	}
}


function user_logout()
{
	unset($_SESSION['user_id']);
	is_login();
	Header("Location: ".get_site_url('login.php'));
}






/*** THEME FUNCTIONS ***/

/* add_breadcrumb
 * temaya yönlendirme menüsü ekler
 */
function add_breadcrumb($array='')
{
	?><script>$(document).ready(function(){ <?php
	foreach($array as $arr)
	{
		if(!isset($arr['url']) or $arr['url'] == ''):
			?> $(".breadcrumb").append( '<li class="active"><?php echo $arr['name']; ?></li>' ); <?php
		else:
			?> $(".breadcrumb").append( '<li><a href="<?php echo $arr['url']; ?>"><?php echo $arr['name']; ?></a></li>' ); <?php
		endif;
	}
	?>}); </script> <?php
}



/* is_money()
	@description: /;
	@return: /; */
function is_currency($value)
{
  $r = preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $value); return $r;
}


/* is_email()
	@description: /;
	@return: /; */
function is_email($value)
{
	if (filter_var($value, FILTER_VALIDATE_EMAIL)) { return true; } else { return false; }
}



// input_control
function input_control($value)
{
	return mysqli_real_escape_string(db(), trim($value));
}


// form_validation()
function form_validation($value, $name='', $options=array())
{
	global $til;
	$value = trim(mysql_real_escape_string($value));


	if(!is_array($options))
	{
		$explode = explode('|', $options);
		foreach($explode as $exp)
		{

			/* form_validation()|required /;
				@description: değişkenin boş olup olmadığını kontrol eder /;
				@return: sonuç olarak "false" döndürür ve "$error" dizisine hata mesajını ekler. /; */
			if($exp == 'required') {
				if(empty($value)){ add_alert('"'.$name.'" yazı alanı boş bırakılamaz.', 'danger', 'form'); }
			}


			/* form_validation()|min_length[int] /;
				@description: değişkenin minimum/en az karakter sayısını kontrol eder /;
				@return: sonuç olarak "false" döndürür ve "$error" dizisine hata mesajını ekler. /; */
			else if(strstr($exp, 'min_length') AND mb_strlen($value,'utf-8') > 0) { $min_length = str_replace(']', '', str_replace('min_length[', '', $exp));
				if(mb_strlen($value,'utf-8') < $min_length){ add_alert('"'.$name.'" yazı alanı en az '.$min_length.' karekter olmalıdır.', 'danger', 'form'); }
			}


			/* form_validation()|max_length[int] /;
				@description: değişkenin maksimum/en fazla karakter sayısını kontrol eder /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if(strstr($exp, 'max_length')) { $max_length = str_replace(']', '', str_replace('max_length[', '', $exp));
				if(mb_strlen($value,'utf-8') > $max_length){ add_alert('"'.$name.'" yazı alanı en fazla '.$max_length.' karekter olabilir.'.mb_strlen($value,'utf-8'),'danger','form'); }
			}


			/* form_validation()|number /;
				@description: değişkenin sayısal bir değere sahip olup olmadığını kontrol eder /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'number' AND strlen($value) > 0) {
				if(!ctype_digit($value)){ add_alert('"'.$name.'" yazı alanı sayısal değer olmalıdır.', 'danger', 'form'); }
			}


			/* form_validation()|alpha /;
				@description: değişkenin "alfabetik" yani "sayısal olmayan" degere sahip olup olmadigini kontrol eder. Örnek: azAZ /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'alpha' AND strlen($value) > 0) {
				if(!ctype_alpha($value)){ add_alert('"'.$name.'" yazı alanı alfabetik değere sahip olmalıdır.', 'danger', 'form'); }
			}


			/* form_validation()|alnum /;
				@description: değişkenin "alfabetik ve sayısal" degere sahip olup olmadigini kontrol eder. Örnek: azAZ09 /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'alnum' AND strlen($value) > 0) {
				if(!ctype_alnum($value)){ add_alert('"'.$name.'" yazı alanı alfabetik değere sahip olmalıdır.', 'danger', 'form'); }
			}


			/* form_validation()|money /;
				@description: değişkenin parasal bir değere sahip olup olmadığını kontrol eder. ÖRNEK: "10", "10.50" /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'money' AND strlen($value) > 0) {
				if(!is_currency($value)){ add_alert('"'.$name.'" yazı alanı parasal bir değere sahip olmalıdır.', 'danger', 'form'); }
			}


			/* form_validation()|email /;
				@description: değişkenin e-posta olup olmadığını kontrol eder. /;
				@return: true/false değeri döner ve "$error" dizisine hata mesajını ekler. /; */
			else if($exp == 'email' AND strlen($value) > 0) {
				if(!is_email($value)){ add_alert('"'.$name.'" yazı alanı "e-posta" olmalıdır.', 'danger', 'form'); }
			}



		}
	}




	return $value;

}










/* --- GENERAL FUNCTIONS
	@descripiton: tilpark sisteminin çalışması için genel fonksiyonları içermektedir. /;
*/



/** add_alert()
	@description: GLOBAL $til degiskenine mesaj,bilgi,metin ekler /; */
function add_alert($message, $type='warning', $alert_name='global')
{ global $til;

	$til->alert[$alert_name][$type][] = $message;
}



/** unset_alert()
	@description: GLOBAL $til degiskenindeki mesal,bilgi,metin siler /; */
function unset_alert($alert_name='')
{ global $til;

	if($alert_name == ''){ unset($til->alert); $til->alert; }
	else { unset($til->alert[$alert_name]); }
}



/** is_alert()
	@description: GLOBAL $til degiskeninde parametrede belirtilen dizinin/degiskenin var olup olmadıgını kontrol eder /; */
function is_alert($alert_name='')
{ global $til;

	if($alert_name == ''){$alert = @$til->alert; }
	else {$alert = @$til->alert[$alert_name]; }
	if(isset($alert)) {
		return true;
	} else {
		return false;
	}
}


/** alert()
	@description: GLOBAL $til degiskeninde hata mesajlarını ekrana basar /; */
function alert($alert_name='', $options=array())
{ global $til;
	if(@$til->alert)
	{
		if($alert_name == ''){ $alert = $til->alert; } else { if(isset($til->alert[$alert_name])) { $alert = $til->alert[$alert_name]; $alert = array('0'=>$alert); } else { $alert=false; } }

		if($alert) {
			foreach($alert as $sub_alert)
			{

				foreach($sub_alert as $type=>$array_messages)
				{
					if(is_array($array_messages))
					{
						foreach($array_messages as $message)
						{
							echo get_alert($message, $type, $options);
						}
					}
					else
					{
						echo get_alert($array_messages, $type, $options);
					}
				}

			}
		}
	}
}


/* get_alert() /;
	@description: parametrede aldığı değerleri ekrana alert stili ile gösterir /; */
function get_alert($message, $class='danger', $options=array())
{
	if(is_array($message))
	{
		@$r['title'] = $message['title'];
		@$r['description'] = $message['description'];
		if(isset($message['dismissible'])){ $r['dismissible'] = $message['dismissible']; } else { $r['dismissible'] = true; }
	} else {
		$r['description'] = $message;
	}

	# uyarı kutusundaki "x" butonunu durumunu belirtiyoruz. eger $options dizisinde bir deger girilmemis ise, otomatik "true" yaptırıyoruz
	if(!isset($options['dismissible'])){ $options['dismissible'] = true; }
	if(empty($options['dismissible']) and @$options['dismissible'] == false) { $options['dismissible'] = ''; } else { $options['dismissible'] = 'alert-dismissible'; }

	# yukarıdaki bilgiler dogrultusunda uyarı kutusunu olustur
	$alert = '<div class="alert alert-'.$class.' '.$options['dismissible'].' fade in" role="alert">';
	if(@$options['dismissible'] == true) { $alert = $alert.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'; }
	if(@$r['title']) { $alert = $alert.'<h4>'.$r['title'].'</h4>'; }
	if(@$r['description']) {$alert = $alert.'<p>'.$r['description'].'</p>'; }
	$alert = $alert.'</div>';

	return $alert;
}


/* print_alert() /;
	@description: $error degiskenindeki hata mesajlarını print_alert() fonksiyonu ile ekrana basar /; */
function print_alert($error=array(), $class, $options=array())
{
	foreach($error as $err)
	{
		echo get_alert($err, $class, $options);
	}
}





/* get_sef_url()
	@description: parametrede blirtilen degeri SEF url formatina cevirir /; */
function get_sef_url($fonktmp) {
    $returnstr = "";
    $turkcefrom = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
    $turkceto   = array("G","U","S","I","O","C","g","u","s","i","o","c");
    $fonktmp = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$fonktmp);
    // Türkçe harfleri ingilizceye çevir
    $fonktmp = preg_replace($turkcefrom,$turkceto,$fonktmp);
    // Birden fazla olan boşlukları tek boşluk yap
    $fonktmp = preg_replace("/ +/"," ",$fonktmp);
    // Boşukları - işaretine çevir
    $fonktmp = preg_replace("/ /","-",$fonktmp);
    // Tüm beyaz karekterleri sil
    $fonktmp = preg_replace("/\s/","",$fonktmp);
    // Karekterleri küçült
    $fonktmp = strtolower($fonktmp);
    // Başta ve sonda - işareti kaldıysa yoket
    $fonktmp = preg_replace("/^-/","",$fonktmp);
    $fonktmp = preg_replace("/-$/","",$fonktmp);
    return $fonktmp;
}




/* clean_charecter()
	@description: sistemin hatasiz calismasi icin input/form verilerinden gelen fazla karakterleri temizliyoruz /; */
function clean_character($value, $options='')
{
	if($options == 'gsm'){
		$value = str_replace(array('(', ')', '-', ' ', '_'), '', $value);
	}

	if($options == 'phone'){
		$value = str_replace(array('(', ')', '-', ' ', '_'), '', $value);
	}

	return $value;
}


/* convert_bayt()
	@description: parametrede aldıgı degeri bayt cinsinden katmanlarina cevirir /; */
function convert_bayt($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}




/* convert_mysql_insert_string() /;
	@description: parametrede aldığı diziyi, mysql_query() formatına uygun olarak 2'ye böler. bu sadece bir dizinde elemanları tablo adı ve tablo değeri olarak ayırır ve veritabanına eklenmesini kolaylaştırır.
	@return: $array['table_name'] ve $array['table_value'] olarak 2 dizi elamanı döndürür. */
function convert_mysql_insert_string($array=array(), $options=array())
{
	if(!isset($options['uniquetime'])) { unset($array['uniquetime']); }
	$return['table_name'] = 'this_value_replace';
	$return['table_value'] = 'this_value_replace';
	foreach($array as $name=>$value)
	{
		$return['table_name'] = $return['table_name'].', '.mysqli_real_escape_string(db(), $name);
		$return['table_value'] = $return['table_value'].", '".mysqli_real_escape_string(db(), $value)."'";
	}
	$return['table_name'] = str_replace('this_value_replace, ', '', $return['table_name']);
	$return['table_value'] = str_replace('this_value_replace, ', '', $return['table_value']);
	return $return;
}



/* convert_mysql_update_string() /;
	@description: parametrede aldığı diziyi, mysql_query() formatına uygun olarak 2'ye böler. bu sadece bir dizinde elemanları tablo adı ve tablo değeri olarak ayırır ve veritabanına eklenmesini kolaylaştırır.
	@return: $array['table_name'] ve $array['table_value'] olarak 2 dizi elamanı döndürür. */
function convert_mysql_update_string($array=array(), $options=array())
{
	if(!isset($options['uniquetime'])) { unset($array['uniquetime']); }
	$return = 'this_value_replace';
	foreach($array as $name=>$value)
	{
		$return = $return.', '.mysqli_real_escape_string(db(), $name)."='".mysqli_real_escape_string(db(), $value)."'";
	}
	return str_replace('this_value_replace, ', '', $return);
}



/* add_log() /;
	@description: log kaydı tutar ;/
	@return: true/false döner /; */
function add_log($array=array())
{
	$array['date'] = date('Y-m-d H:i:s');
	$array['user_id'] = '1';

	# unique_time
	if(isset($_POST['uniquetime'])){ $array['uniquetime'] = trim($_POST['uniquetime']); } elseif(isset($_GET['uniquetime'])){ $array['uniquetime'] = trim($_GET['uniquetime']); }

	# $array dizisindeki degeleri mysql_query formatına bölelim
	$convert = convert_mysql_insert_string($array, array('uniquetime'=>true));

	# hersey basarili ise veritabanina ekleyelim
	db()->query("INSERT INTO ".dbname('logs')." (".$convert['table_name'].") VALUES (".$convert['table_value'].") ");
		$insert_id = db()->insert_id;
		echo db()->error;
	return $insert_id;
}



/* alteration_array()
	@description: parametrede belirtilen 2 dizi icerisinde hangilerinin degisik oldugunu karsilastirir ;/
	@return: degisen degerleri sıra duzeni ile bir diziye atar ;/ */
function alteration_array($array1, $array2)
{
	$alteration = array();
	foreach($array1 as $name=>$value)
	{
		if(isset($array2[$name]))
		{
			if($array1[$name] != $array2[$name])
			{
				$alteration[$name]['old'] = $array1[$name];
				$alteration[$name]['new'] = $array2[$name];
			}
		}
		else
		{
			$alteration[$name]['old'] = $array1[$name];
		}
	}

	foreach($array2 as $name=>$value)
	{
		if(isset($array1[$name]))
		{
			if($array2[$name] != $array1[$name])
			{
				$alteration[$name]['old'] = $array1[$name];
				$alteration[$name]['new'] = $array2[$name];
			}
		}
		else
		{
			$alteration[$name]['new'] = $array2[$name];
		}
	}

	return $alteration;
}


/* uniquetime()
	@description: formlar icin essiz zaman olusturur ;/
	@return: input="hidden" olarak essiz zaman uretir ;/ */
function get_uniquetime($options=array())
{
	$time = mktime();
	return '<input type="hidden" name="uniquetime" value="'.$time.'">';
}
function uniquetime($options=array())
{
	echo get_uniquetime($options);
}
function is_uniquetime()
{ global $til;

	if(isset($_POST['uniquetime'])){ $uniquetime = trim($_POST['uniquetime']); } elseif(isset($_GET['uniquetime'])){ $uniquetime = trim($_GET['uniquetime']); }

	$query = db()->query("SELECT * FROM ".dbname('logs')." WHERE uniquetime='".$uniquetime."'");
	if($query->num_rows > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}


/* convert_tax_rate()
	@description: kdv oranının başına "1." veya "0.0" gibi matematiksel işlemleri kolaylaştıracak rakamlar ekler /; */
function convert_tax_rate($tax_rate='')
{
	$new_tax_rate = '1.';
	if(strlen($tax_rate) == 2){ $new_tax_rate = $new_tax_rate."$tax_rate"; }
	elseif(strlen($tax_rate) == 1){ $new_tax_rate = $new_tax_rate."0".$tax_rate; }
	return $new_tax_rate;
}



function convert_money($val, $options=array())
{ global $til;

	if(!isset($options['icon'])){ $options['icon'] = false; }

	$money = number_format($val, $til->fixed);

	# options
	if($options['icon'] == true){ $money = $money.' <i class="fa fa-try"></i>'; }

	return $money;
}






/* til_pagination()
	@description: tablo listemelerindein en anltında bulunan sayfalama  ;/
	@return: sonuc olarak html ciktisini ekrana basar ;/ */

		// sayfalama icin class entegre edelim
		require_once  root_path('inc/class/Pagination.class.php');
		$til->pg->page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;
		$til->pg->search_text = isset($_GET['search_text']) ? ($_GET['search_text']) : '';

function til_pagination($num_rows, $ops=array())
{ global $til;
    // instantiate; set current page; set number of records
    $pagination = (new Pagination());
    $pagination->setCurrent($til->pg->page);
    $pagination->setTotal($num_rows);

    // grab rendered/parsed pagination markup
   	echo $markup = $pagination->parse();
}
















/* til_table()
	@description: ajax ile tablolari listeler ;/
	@return: sonuc olarak html ciktisini ekrana basar ;/ */
function til_table($array=array())
{ global $til;

	if(!isset($array['div_html'])){ $array['div_html'] = '#til-table'; }


	?>
	<script>
	function table_search()
	{
		var search_text = $('#table-search').val();

	
		


		$.ajax({
		  url: "<?php echo $array['url']; ?>?search_text="+search_text+"&page="+<?php echo $til->pg->page; ?>+"",
		  global: false, 
		  type: "GET", 
		  cache: false,
		  beforeSend: function() {
		    $("<?php echo $array['div_html']; ?>").html("<div class='text-center'><img src='<?php site_url('theme/img/ajax-loader.gif'); ?>'' /></div>");
		  },
		  success: function(data) {
		    $("<?php echo $array['div_html']; ?>").html(data);
		  }
		});
	}


	$(document).ready(function() {
		table_search();
		$('#table-search').keyup(function (){
			table_search().delay(500);
		});
	});

	</script>

	<?php
}


/* til_table_search_box()
	@description: tablo araması için input=text ekler ;/
	@return: sonuc olarak html ciktisini ekrana basar ;/ */
function til_table_search_box()
{ global $til;
	?>
	<div class="form-group">
		<div class="input-group">
			<div class="input-group-addon"><i class="fa fa-search"></i></div>
			<input type="text" name="search" id="table-search" class="form-control" value="<?php echo $til->pg->search_text; ?>">
		</div> <!-- /.input-group -->
	</div> <!-- /.form-group -->
	<?php
}




/* convert_date() */
function convert_date($val)
{
	return substr($val,0,10);
}

/* --------------------------------------------------------------------------------- */

































/* ----- PRODUCTS -----
	@description: /;
	@author: name=mustafa tanrıverdi, email=thetanriverdi@gmail.com, website=http://tilpark.com /;
*/




/** add_product() /;
	@description: yeni bir urun/hizmet/kart ekler /;
	@return: */
function add_product($array=array())
{ global $til;

	# gerekli degiskenler
	$array['date'] = date("Y-m-d H:i:s");

	# eger stok kodu bos ise otomatik dolduralim
	if(empty($array['code'])) { @$array['code'] = $array['name']; }
	$array['code'] = get_sef_url($array['code']);


	# kdv oranını guncelle ve kdvsiz fiyatlari guncelle
	if($array['tax_rate'] > 0)
	{
		$array['p_sale_out_tax'] = $array['p_sale'] / convert_tax_rate("".$array['tax_rate']."");
		$array['p_purchase_out_tax'] = $array['p_purchase'] / convert_tax_rate("".$array['tax_rate']."");
	}


	// required
	if(empty($array['code'])){ add_alert('Ürün Kodu değeri boş olamaz.', 'danger', 'add_product'); return false; }
	if(empty($array['name'])){ add_alert('Ürün Adı değeri boş olamaz.', 'danger', 'add_product'); return false; }

	# $array dizisindeki degeleri mysql_query formatına bölelim
	$convert = convert_mysql_insert_string($array);





	# hersey basarili ise stok kartini veritabanina ekleyelim
	db()->query("INSERT INTO ".dbname('products')." (".$convert['table_name'].") VALUES (".$convert['table_value'].") ");
	if(db()->affected_rows > 0)
	{
		$insert_id = db()->insert_id;

		# stok kartı ekleme ise basarili ve basarisiz ise log kayitlarina ekleyelim
		if(db()->affected_rows > 0) {
			add_log(array('table_id'=>'products:'.$insert_id, '_key'=>'add_product', 'message'=>'Yeni stok kartı oluşturuldu.'));
		} else {
			add_alert(db()->error, 'danger', 'add_product');
			add_log(array('table_id'=>'products:', '_key'=>'add_product', 'message'=>'Stok kartı veritabanına eklenemedi.', '_event'=>db()->error ));
		}

		# eger stok kodu daha onceden eklenmis ise benzersiz olmasi icin stok kodunu guncelleyelim
		$q_is_code = db()->query("SELECT * FROM ".dbname('products')." WHERE code='".$array['code']."' AND id NOT IN ('".$insert_id."')");
			if($q_is_code->num_rows > 0) {
				db()->query("UPDATE ".dbname('products')." SET code='".$insert_id.'-'.$array['code']."' WHERE id='".$insert_id."'");
			}


		add_alert('Stok kartı başarı ile oluşturuldu.', 'success', 'add_product');
		return $insert_id;
	} else {
		add_alert(array('title'=>'Hata', 'description'=>'Hata Kodu: '.db()->error), 'danger', 'add_product');
		add_log(array('table_id'=>'products:', '_key'=>'add_product', 'message'=>'error', '_event'=>db()->error ));
		return false;
	}
}




/* get_all_products() /;
	@description: veritabanındaki tüm ürünleri listeler /;
	@return: "products" tablosundaki degeleri dizi halinde döndürür */
function get_all_products()
{ global $til;

	$return = '';
	$query = db()->query("SELECT * FROM ".dbname('products')." WHERE status='1'");
	while($list = $query->fetch_assoc())
	{
		$return[] = $list;
	}
	return $return;
}




/** get_product() /;
	@description: parametrede belirtilen ID veya query sorgusuna gore "product" tablosundaki urun bilgisini verir /;
	@return: deger[]/false doner /; */
function get_product($id_or_array)
{ global $til;
	$return = '';

	if(is_array($id_or_array))
	{

	}
	else
	{
		$query = db()->query("SELECT * FROM ".dbname('products')." WHERE id='$id_or_array'");
		$return = $query->fetch_assoc();
	}

	return $return;
}






/** update_product() /;
	@description: bir urun kartını gunceller/degistir /;
	@return: true/false doner /; */
function update_product($array=array())
{ global $til;

	# eger stok kodu bos ise otomatik dolduralim
	if(empty($array['code'])) { @$array['code'] = $array['name']; }
	$array['code'] = get_sef_url($array['code']);


	# kdv oranını guncelle ve kdvsiz fiyatlari guncelle
	if($array['tax_rate'] > 0)
	{
		$array['p_sale_out_tax'] = $array['p_sale'] / convert_tax_rate("".$array['tax_rate']."");
		$array['p_purchase_out_tax'] = $array['p_purchase'] / convert_tax_rate("".$array['tax_rate']."");
	}

	# $array dizisindeki degeleri mysql_query formatına bölelim
	$convert = convert_mysql_update_string($array);

	// required
	if(empty($array['code'])){ add_alert('Ürün Kodu değeri boş olamaz.'); }
	if(empty($array['name'])){ add_alert('Ürün Adı değeri boş olamaz.'); return false; }


	# barkod kodunun veritabanın baska bir urune ait olup olmadigini kontrol edelim
	$is_code = db()->query("SELECT * FROM ".dbname('products')." WHERE code='".$array['code']."' AND id NOT IN ('".$array['id']."')");
	if($is_code->num_rows > 0)
	{
		add_alert($array['code'].' barkod kodu başka bir ürün kartında bulundu.', 'warning', 'update_product');
		return false;
	}


	#herysey basarili ise urun kartini guncelleyelim
	$old_product = get_product($array['id']);
	$update = db()->query("UPDATE ".dbname('products')." SET $convert WHERE id=".$array['id']."");
	if(db()->affected_rows > 0)
	{
		$new_product = get_product($array['id']);
		add_alert('İşlem başarılı, stok kartı güncellendi.', 'success');
		add_log(array('table_id'=>'products:'.$array['id'], '_key'=>'update_product', 'message'=>'Ürün kartı güncellendi.', '_event'=>json_encode(alteration_array($old_product, $new_product)) ));
		return true;
	}
	elseif(db()->affected_rows == 0)
	{
		return true;
	}
	else
	{
		add_alert(array('title'=>'Hata', 'description'=>'Hata Kodu: '.db()->error), 'danger', 'update_product');
		add_log(array('table_id'=>'products:'.$array['id'], '_key'=>'update_product', 'message'=>'Ürün kartı güncellenirken hata oluştu.', '_event'=>db()->error ));
		return false;
	}
}



/** calc_product_quantity() /;
	@description: urun kartinin stok durumunu / guncel stok durumunu hesaplar /;
	@return: true/false doner /; */
function calc_product_quantity($product_id)
{ global $til;

	$query = db()->query("SELECT sum(quantity) FROM ".dbname('form_items')." WHERE product_id='".$product_id."' AND in_out='1' AND status='1'");
	$quantity_out = $query->fetch_row();
	$quantity_out = $quantity_out[0];

	$query = db()->query("SELECT sum(quantity) FROM ".dbname('form_items')." WHERE product_id='".$product_id."' AND in_out='0' AND status='1'");
	$quantity_in = $query->fetch_row();
	$quantity_in = $quantity_in[0];

	$quantity = $quantity_in - $quantity_out;

	db()->query("UPDATE ".dbname('products')." SET quantity='".$quantity."' WHERE id='".$product_id."'");
}



/* product_url() /;
	@description: formlara ait url adresini dondurur /;
	@return: parametrede belirtilen ID ile birlikte form detail.php sayfasının URL adresini yonlendirir */
function get_url_product($product_id)
{
	return get_site_url('content/products/detail.php?id='.$product_id);
}
function url_product($product_id)
{
	echo get_url_product($product_id);
}



/* --------------------------------------------------------------------------------- */

































/* ----- ACCOUNTS -----
	@description: /;
	@author: name=mustafa tanrıverdi, email=thetanriverdi@gmail.com, website=http://tilpark.com /;
*/


/** add_account /;
	@description: yeni bir hesap karti olusturur ;/
	@return: true/false doner ;/ */
function add_account($array, $options=array())
{ global $til;

	# gerekli degiskenler
	$array['date'] = date("Y-m-d H:i:s");

	# eger barkod kodu bos ise otomatik dolduralim
	if(empty($array['code'])) { @$array['code'] = $array['name']; }
	$array['code'] = get_sef_url($array['code']);

	// required
	if(empty($array['code'])){ add_alert('Barkod Kodu değeri boş olamaz.', 'danger', 'add_account'); return false; }
	if(empty($array['name'])){ add_alert('Hesap Adı değeri boş olamaz.', 'danger', 'add_account'); return false; }

	# $array dizisindeki degeleri mysql_query formatına bölelim
	$convert = convert_mysql_insert_string($array);

	# hersey basarili ise veritabanina ekleyelim
	db()->query("INSERT INTO ".dbname('accounts')." (".$convert['table_name'].") VALUES (".$convert['table_value'].")");
		$insert_id = db()->insert_id;

		# hesap kartı ekleme ise basarili ve basarisiz ise log kayitlarina ekleyelim
		if(db()->affected_rows > 0) {
			add_log(array('table_id'=>'accounts:'.$insert_id, '_key'=>'add_account', 'message'=>'Yeni hesap kartı oluşturuldu.'));
		} else {
			add_alert(db()->error, 'danger', 'add_account');
			add_log(array('table_id'=>'accounts:', '_key'=>'add_account', 'message'=>'Hesap kartı veritabanına eklenemedi.', '_event'=>db()->error ));
		}

		# eger barkod kodu daha onceden eklenmis ise benzersiz olmasi icin stok kodunu guncelleyelim
		$q_is_code = db()->query("SELECT code FROM ".dbname('accounts')." WHERE code='".$array['code']."' AND id NOT IN ('".$insert_id."')");
			if($q_is_code->num_rows > 0) {
				db()->query("UPDATE ".dbname('accounts')." SET code='".$insert_id.'-'.$array['code']."' WHERE id='".$insert_id."'");
			}





	if($insert_id > 0) {
		add_alert('Hesap kartı başarı ile oluşturuldu.', 'success', 'add_account');
		/* options:unset_alert */
		return $insert_id;
	} else {
		return false;
	}
}




/* get_all_accounts() /;
	@description: veritabanındaki tüm hesaplari listeler /;
	@return: "accounts" tablosundaki degeleri dizi halinde döndürür */
function get_all_accounts()
{ global $til;

	$return = '';
	$query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE status='1'");
	while($list = $query->fetch_assoc())
	{
		$return[] = $list;
	}
	return $return;
}



/** get_account() /;
	@description: parametrede belirtilen ID veya query sorgusuna gore "accounts" tablosundaki urun bilgisini verir /;
	@return: deger[]/false doner /; */
function get_account($id_or_array)
{ global $til;
	$return = '';

	if(is_array($id_or_array))
	{
		$query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE ".$id_or_array['query']." LIMIT 1");
		$return = $query->fetch_assoc();
	}
	else
	{
		$query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE id='$id_or_array'");
		$return = $query->fetch_assoc();
	}

	return $return;
}



/** update_account() /;
	@description: bir urun kartını gunceller/degistir /;
	@return: true/false doner /; */
function update_account($array=array())
{ global $til;

	# eger stok kodu bos ise otomatik dolduralim
	if(empty($array['code'])) { @$array['code'] = $array['name']; }
	$array['code'] = get_sef_url($array['code']);

	// required
	if(empty($array['code'])){ add_alert('Hesap Kodu değeri boş olamaz.'); }
	if(empty($array['name'])){ add_alert('Hesap Adı değeri boş olamaz.'); }


	# $array dizisindeki degeleri mysql_query formatına bölelim
	$convert = convert_mysql_update_string($array);



	# barkod kodunun veritabanın baska bir urune ait olup olmadigini kontrol edelim
	$is_code = db()->query("SELECT * FROM ".dbname('accounts')." WHERE code='".$array['code']."' AND id NOT IN ('".$array['id']."')");
	if($is_code->num_rows > 0)
	{
		add_alert($array['code'].' barkod kodu başka bir hesap kartında bulundu.', 'warning', 'update_account');
		return false;
	}


	#herysey basarili ise urun kartini guncelleyelim
	$old_account = get_account($array['id']);
	$update = db()->query("UPDATE ".dbname('accounts')." SET $convert WHERE id=".$array['id']."");
	if(db()->affected_rows > 0)
	{
		$new_account = get_account($array['id']);
		add_alert('İşlem başarılı, hesap kartı güncellendi.', 'success');
		add_log(array('table_id'=>'accounts:'.$array['id'], '_key'=>'update_account', 'message'=>'Hesap kartı güncellendi.', '_event'=>json_encode(alteration_array($old_account, $new_account)) ));
		return true;
	}
	elseif(db()->affected_rows == 0)
	{
		return true;
	}
	else
	{
		add_alert(array('title'=>'Hata', 'description'=>'Hata Kodu: '.db()->error), 'danger', 'update_account');
		add_log(array('table_id'=>'accounts:'.$array['id'], '_key'=>'update_account', 'message'=>'Hesap kartı güncellenirken hata oluştu.', '_event'=>db()->error ));
		return false;
	}
}



/* form_url() /;
	@description: formlara ait url adresini dondurur /;
	@return: parametrede belirtilen ID ile birlikte form detail.php sayfasının URL adresini yonlendirir */
function get_url_account($account_id)
{
	return get_site_url('content/accounts/detail.php?id='.$account_id);
}
function url_account($account_id)
{
	echo get_url_account($account_id);
}



/* --------------------------------------------------------------------------------- */

































/* ----- FORMS -----
	@description: /;
	@author: name=mustafa tanrıverdi, email=thetanriverdi@gmail.com, website=http://tilpark.com /;
*/



/** add_form /;
	@description: yeni bir alis-satis formu olusturur ;/
	@return: true/false doner ;/ */
function add_form($array, $options=array())
{ global $til;

	# required

	# input control
	form_validation($array['account_name'], 'Hesap Adı', 'required|min_length[3]|max_length[32]');
	//form_validation($array['account_gsm'], 'Cep Telefonu', 'required|number|min_length[10]|max_length[11]');

	if(is_alert('form')) { return false; }

	// clean_character
	$array['account_gsm'] 	= clean_character($array['account_gsm'], 'gsm');
	$array['account_phone'] = clean_character($array['account_phone'], 'phone');
	$array['date']			= $array['date'].' '.date('H:i:s');

		if(!isset($options['add_account'])) { $options['add_account'] = true; }
		/* account_id yok ise yeni bir account olusturalim */
		if(empty($array['account_id']) and $options['add_account']==true)
		{
			$is_account = false;
			if(strlen($array['account_code']) > 3 ) { $is_account = get_account(array('query'=>" code='".$array['account_code']."'")); }
				if(!$is_account and strlen($array['account_gsm']) > 8) { $is_account = get_account(array('query'=>" gsm='".$array['account_gsm']."'")); }
					if(!$is_account and strlen($array['account_phone']) > 8) { $is_account = get_account(array('query'=>" phone='".$array['account_phone']."'")); }
						if(!$is_account and strlen($array['account_tax_no']) > 3) { $is_account = get_account(array('query'=>" tax_no='".$array['account_tax_no']."'")); }

			if($is_account)
			{
				$array['account_id'] = $is_account['id'];
			}
			else
			{
				$add_account['code'] = date("Y-m-d H:i:s");
				$add_account['code'] = $array['account_code'];
				$add_account['name'] = $array['account_name'];
				$add_account['gsm'] = @$array['account_gsm'];
				$add_account['phone'] = @$array['account_phone'];
				$add_account['address'] = @$array['account_address'];
				$add_account['city'] = @$array['account_city'];
				$add_account['district'] = @$array['account_district'];
				$add_account['tax_home'] = @$array['account_tax_home'];
				$add_account['tax_no'] = @$array['account_tax_no'];
				$array['account_id'] = add_account($add_account);
					unset_alert('add_account'); // hata mesaji var ise silelim, sayfada goruntu kirlili oluyor
			}
		}

	# $array dizisindeki degeleri mysql_query formatına bölelim
	$convert = convert_mysql_insert_string($array);


	# hersey basarili ise veritabanina ekleyelim
	db()->query("INSERT INTO ".dbname('forms')." (".$convert['table_name'].") VALUES (".$convert['table_value'].")");
	$insert_id = db()->insert_id;

	if($insert_id > 0)
	{
		return $insert_id;
	}
	else
	{
		return false;
	}
}



/** update_form /;
	@description: yeni bir alis-satis formu olusturur ;/
	@return: true/false doner ;/ */
function update_form($form_id, $array, $options=array())
{ global $til;

	$old_form = get_form($form_id);

	# input control
	form_validation($array['account_name'], 'Hesap Adı', 'required|min_length[3]|max_length[32]');
	//form_validation($array['account_gsm'], 'Cep Telefonu', 'required|number|min_length[10]|max_length[11]');
	if(is_alert('form')) { return false; }

	// clean_character
	$array['account_gsm'] 	= clean_character($array['account_gsm'], 'gsm');
	$array['account_phone'] = clean_character($array['account_phone'], 'phone');
	$array['date']			= $array['date'].' '.substr($old_form['date'],11,5);



		if(!isset($options['add_account'])) { $options['add_account'] = true; }
		/* account_id yok ise yeni bir account olusturalim */
		if(empty($array['account_id']) and $options['add_account']==true)
		{
			$is_account = false;
			if(strlen($array['account_code']) > 3 ) { $is_account = get_account(array('query'=>" code='".$array['account_code']."'")); }
				if(!$is_account and strlen($array['account_gsm']) > 8) { $is_account = get_account(array('query'=>" gsm='".$array['account_gsm']."'")); }
					if(!$is_account and strlen($array['account_phone']) > 8) { $is_account = get_account(array('query'=>" phone='".$array['account_phone']."'")); }
						if(!$is_account and strlen($array['account_tax_no']) > 3) { $is_account = get_account(array('query'=>" tax_no='".$array['account_tax_no']."'")); }

			if($is_account)
			{
				$array['account_id'] = $is_account['id'];
			}
			else
			{
				$add_account['code'] = $array['account_code'];
				$add_account['name'] = $array['account_name'];
				$add_account['gsm'] = @$array['account_gsm'];
				$add_account['phone'] = @$array['account_phone'];
				$add_account['address'] = @$array['account_address'];
				$add_account['city'] = @$array['account_city'];
				$add_account['district'] = @$array['account_district'];
				$add_account['tax_home'] = @$array['account_tax_home'];
				$add_account['tax_no'] = @$array['account_tax_no'];
				$array['account_id'] = add_account($add_account);
					unset_alert('add_account'); // hata mesaji var ise silelim, sayfada goruntu kirlili oluyor
			}
		}

	# $array dizisindeki degeleri mysql_query formatına bölelim
	$convert = convert_mysql_update_string($array);


	# hersey basarili ise veritabanina ekleyelim
	db()->query("UPDATE ".dbname('forms')." SET ".$convert." WHERE id='".$form_id."'");
	if(db()->affected_rows > 0)
	{
		$new_form = get_form($form_id);
		add_alert('İşlem başarılı, form güncellendi.', 'success', 'update_form');
		add_log(array('table_id'=>'forms:'.$form_id, '_key'=>'update_form', 'message'=>'Form güncellendi.', '_event'=>json_encode(alteration_array($old_form, $new_form)) ));
		return true;
	}
	elseif(db()->affected_rows == 0)
	{
		return true;
	}
	else
	{
		add_alert(array('title'=>'Hata', 'description'=>'Hata Kodu: '.db()->error), 'danger', 'update_form');
		add_log(array('table_id'=>'forms:'.$form_id, '_key'=>'update_form', 'message'=>'Form güncellenirken hata oluştu.', '_event'=>db()->error ));
		return false;
	}
}



/** get_form() /;
	@description: parametrede belirtilen ID veya query sorgusuna gore "accounts" tablosundaki urun bilgisini verir /;
	@return: deger[]/false doner /; */
function get_form($id_or_array)
{ global $til;
	$return = '';

	if(is_array($id_or_array))
	{
		$query = db()->query("SELECT * FROM ".dbname('forms')." WHERE ".$id_or_array['query']." LIMIT 1");
		$return = $query->fetch_assoc();
	}
	else
	{
		$query = db()->query("SELECT * FROM ".dbname('forms')." WHERE id='$id_or_array'");
		$return = $query->fetch_assoc();
	}

	return $return;
}



/** get_forms() /;
	@description: parametrede belirtilen ID veya query sorgusuna gore "accounts" tablosundaki urun bilgisini verir /;
	@return: deger[]/false doner /; */
function get_forms($array='')
{ global $til;
	$return = false;

	if(is_array($array))
	{
		$query = db()->query("SELECT * FROM ".dbname('forms')." WHERE ".$array['query']."");
		while($list = $query->fetch_assoc())
		{
			$return[] = $list;
		}
	}
	else
	{
		$query = db()->query("SELECT * FROM ".dbname('forms')." WHERE id='$id_or_array'");
		$return = $query->fetch_assoc();
	}

	return $return;
}



/** update_o_status() /;
	@description: parametrede belirtilen degerlere gore form tablosundaki "o_status" durumlarını gunceller
	@return: deger[]/false doner /; */
function update_o_status($form_id, $o_status)
{
	if($o_status=='new'){ }
	elseif($o_status=='waiting'){ }
	elseif($o_status=='preparing'){ }
	elseif($o_status=='shipping'){ }
	elseif($o_status=='completed'){ }
		elseif($o_status=='noapproval'){ }
	else{ return false; }

	db()->query("UPDATE ".dbname('forms')." SET o_status='".$o_status."' WHERE id='".$form_id."' ");
	if(db()->affected_rows > 0)
	{
		add_alert('Form durumu "'.o_status($o_status).'" olarak güncellendi.', 'success', 'update_o_status');
		add_log(array('table_id'=>'forms:'.$form_id, '_key'=>'update_form', 'message'=>'Form durumu "'.o_status($o_status).'" olarak güncellendi.' ));
		return true;
	}
	elseif(db()->affected_rows == 0)
	{
		return true;
	}
	else
	{
		add_alert(array('title'=>'Hata', 'description'=>'Hata Kodu: '.db()->error), 'danger', 'update_form');
		add_log(array('table_id'=>'forms:'.$form_id, '_key'=>'update_form', 'message'=>'Form durumu güncellenirken hata oluştu.', '_event'=>db()->error ));
		return false;
	}
}

		/* o_status() */
		function o_status($val, $return='')
		{
			if($return == '')
			{
				if($val=='new'){ return 'yeni'; }
				elseif($val=='waiting'){ return 'bekliyor'; }
				elseif($val=='preparing'){ return 'hazırlanıyor'; }
				elseif($val=='shipping'){ return 'kargoda'; }
				elseif($val=='completed'){ return 'tamamlandı'; }
				else{ return $val; }
			}

			if($return == 'style')
			{
				if($val=='new'){ return 'default'; }
				elseif($val=='waiting'){ return 'danger'; }
				elseif($val=='preparing'){ return 'warning'; }
				elseif($val=='shipping'){ return 'primary'; }
				elseif($val=='completed'){ return 'success'; }
				else{return 'default'; }
			}
		}



/** calc_form() /;
	@description: parametrede belirtilen #ID'deki form bilgilerini, satir toplamlarini hesaplar ve form['total'] tablosua sonucu ekler /;
	@return: deger[]/false doner /; */
function calc_form($form_id)
{ global $til;
	if(@$form_id == ''){return false;}
	$query = db()->query("SELECT sum(sub_total), sum(quantity), sum(tax_value), sum(p_sale_out_tax * quantity), sum(p_purchase_out_tax * quantity) FROM ".dbname('form_items')." WHERE status='1' AND form_id='".$form_id."'");
	$query = $query->fetch_row();

	$sub_total 		= $query[0];
	$quantity 		= $query[1];
	$tax_value 		= $query[2];
	$p_sale_out_tax = $query[3];
	$p_purchase_out_tax = $query[4];
	$profit			= $p_sale_out_tax - $p_purchase_out_tax;

	db()->query("UPDATE ".dbname('forms')." SET tax_value='".$tax_value."', profit='".$profit."', quantity='".$quantity."', total='".$sub_total."' WHERE id='".$form_id."'");
}



/** add_form_item() /;
	@description: parametrede belirtilen ID veya query sorgusuna gore "accounts" tablosundaki urun bilgisini verir /;
	@return: deger[]/false doner /; */
function add_form_item($array)
{ global $til;

	# input control
	form_validation($array['product_name'], 'Ürün Adı', 'required|min_length[3]|max_length[32]');
	if(is_alert('form')) { return false; }

	// form
	if($array['form_id'] > 0){ $form = get_form($array['form_id']); }
	$array['in_out'] 		= $form['in_out'];
	$array['account_id'] 	= $form['account_id'];
	$array['account_name'] 	= $form['account_name'];
	$array['date']			= $array['date'].' '.date('H:i:s');

	// Hesaplamalar
		# satir toplami
		$array['sub_total'] = $array['quantity'] * $array['p_sale'];
		# kdv / vergi
		$array['tax_value'] = $array['quantity'] * ($array['p_sale'] - ($array['p_sale'] / convert_tax_rate($array['tax_rate'])));
		$array['p_sale_out_tax'] = $array['p_sale'] - ($array['p_sale'] - ($array['p_sale'] / convert_tax_rate($array['tax_rate'])));

		if($array['product_id'] > 0) {
			$product = get_product($array['product_id']);

			# maliyet fiyati
			$array['p_purchase'] = $product['p_purchase'];
			$array['p_purchase_out_tax'] = $product['p_purchase_out_tax'];
		}




	# $array dizisindeki degeleri mysql_query formatına bölelim
	$convert = convert_mysql_insert_string($array);


	# hersey basarili ise veritabanina ekleyelim
	$add_form_item = db()->query("INSERT INTO ".dbname('form_items')." (".$convert['table_name'].") VALUES (".$convert['table_value'].")");
	if(db()->affected_rows > 0)
	{ $insert_id = db()->insert_id;
		add_alert(array('title'=>'İşlam Başarılı', 'description'=>$array['product_name'].' ürünü eklendi.'), 'success', 'add_form_item');
		add_log(array('table_id'=>'forms:'.$array['form_id'], '_key'=>'add_form_item', 'message'=>$array['product_name'].' ürünü eklendi.' ));

		if($array['product_id'] > 0) { calc_product_quantity($array['product_id']); }
		return $insert_id;
	}
	else
	{
		add_alert(array('title'=>'Hata', 'description'=>'Hata Kodu: '.db()->error), 'danger', 'add_form_item');
		add_log(array('table_id'=>'forms:'.$array['form_id'], '_key'=>'add_form_item', 'message'=>'error', '_event'=>db()->error ));
		return false;
	}
}



/** get_form_item() /;
	@description: parametrede belirtilen ID veya query sorgusuna gore *_form_items tablosundaki satiri dondurur /;
	@return: deger[]/false doner /; */
function get_form_item($id_or_array)
{ global $til;
	$return = '';

	if(is_array($id_or_array))
	{

	}
	else
	{
		$query = db()->query("SELECT * FROM ".dbname('form_items')." WHERE id='$id_or_array'");
		$return = $query->fetch_assoc();
	}

	return $return;
}



/* get_form_items() /;
	@description: veritabanındaki tüm hesaplari listeler /;
	@return: "accounts" tablosundaki degeleri dizi halinde döndürür */
function get_form_items($id_or_array)
{ global $til;

	$return = '';
	$query = db()->query("SELECT * FROM ".dbname('form_items')." WHERE form_id='".$id_or_array."' AND status='1'");
	while($list = $query->fetch_assoc())
	{
		$return[] = $list;
	}
	return $return;
}



/** delete_form_item() /;
	@description: parametrede belirtilen ID ve Form ID'sindeki urunu siler /;
	@return: deger[]/false doner /; */
function delete_form_item($item_id, $form_id)
{ global $til;

	$item_id = input_control($item_id);
	$form_item = get_form_item($item_id);

	db()->query("UPDATE ".dbname('form_items')." SET status='0' WHERE id='".$item_id."' ");
	if(db()->affected_rows > 0)
	{
		add_log(array('table_id'=>'forms:'.$form_id, '_key'=>'delete_form_item', 'message'=>$form_item['product_name'].' ürün kartına ait ürün hareketi silindi.' ));
		add_alert('Ürün hareketi silindi.', 'warning', 'delete_form_item');
		return true;
	}
	else
	{
		return false;
	}
}



/* form_url() /;
	@description: formlara ait url adresini dondurur /;
	@return: parametrede belirtilen ID ile birlikte form detail.php sayfasının URL adresini yonlendirir */
function get_url_form($form_id)
{
	if($form_id > 0) { return get_site_url('content/forms/add.php?id='.$form_id); } else { return get_site_url('content/forms/add.php'); }

}
function url_form($form_id)
{
	echo get_url_form($form_id);
}

/** get_text_inout() /;
	@description: 0 veya 1 degerine gore "Giriş" veya "Çıkış" metnini dondurur /;
	@return: /; */
function get_text_inout($val)
{
	if($val == 0){ return 'Giriş'; }
	elseif($val == 1){ return 'Çıkış'; }
}



/* --------------------------------------------------------------------------------- */

































/* ----- LOGS -----
	@description: /;
	@author: name=mustafa tanrıverdi, email=thetanriverdi@gmail.com, website=http://tilpark.com /;
*/



/** get_logs() /;
	@description: log kayitlarini listeler ;/
	@return: true/false doner ;/ */
function get_logs($array=array())
{ global $til;

	$return = '';
	$where = '';
	if(isset($array['table_id'])){ $where = "table_id='".$array['table_id']."'"; }

	$query = db()->query("SELECT * FROM ".dbname('logs')." WHERE ".$where." ORDER BY date ASC");
	if($query->num_rows > 0)
	{
		?>
		<table class="table table-hover table-condensed dataTable">
			<thead>
				<tr>
					<th>Tarih</th>
					<th>Personel</th>
					<th>Açıklama</th>
					<th>Olay</th>
				</tr>
			</thead>
			<tbody>
		<?php
		while($list = $query->fetch_assoc())
		{
			if(is_object(json_decode($list['_event'])))
			{
				$text = '';
				$_events = get_object_vars(json_decode($list['_event']));
				foreach($_events as $_e_name=>$_e_value)
				{
					$_e_value = get_object_vars($_e_value);
					$text = $text.' <strong>'.$_e_name.'</strong>: <small class="text-muted"><s>'.$_e_value['old'].'</s></small> / '.$_e_value['new'].'<br />';
				}
				$list['_event'] = $text;
			}
			$return[] = $list;
		}


		foreach($return as $list) { ?>
			<tr>
				<td><?php echo $list['date']; ?></td>
				<td><?php echo $list['user_id']; ?></td>
				<td><?php echo $list['message']; ?></td>
				<td><?php print_r($list['_event']); ?></td>
			</tr>
		<?php
		}
		?>
			</tbody>
		</table>
		<?php
	}
	else
	{
		return false;
	}
}


















?>
