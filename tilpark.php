<?php
ob_start();
session_start();

date_default_timezone_set('Europe/Istanbul');
error_reporting(E_ALL);


/*** GLOBAL ***/



/* --------------------------------------------------- ROOT */

/**
 * title: root_path()
 * desc: root_path() fonksiyonu, lazim olan dosyalari ice aktarirken kok dizini bulmamızı kolaylastirir.
 */
define( 'ROOT_PATH', dirname(__FILE__));

function get_root_path($val) {
	return ROOT_PATH.'/'.$val;
}
function root_path($val) {
	echo get_root_path($val);
}
include get_root_path('til-config.php');

if ( empty(_userName) AND empty(_dbName) ) {
	Header('Location: installation.php');
}

// config
define('_root_path', $_SERVER['DOCUMENT_ROOT'].'/');

// Bağlatıyı Kuralım.
$db = new mysqli(_serverName, _userName, _userPassword);
if($db->connect_errno){
  echo "Bağlantı Hatası:".$db->connect_errno;
  exit;
}

// Veritabanımızı Seçelim.
$db->select_db(_dbName);
$db->query("SET NAMES 'utf8'");



function db()
{
	global $db;
	return $db;
}


// global ön ek
$til = new stdclass;
global $til;

$til->fixed = '2';
$til->company = new stdclass();
$til->company->name = 'Tilpark!';
$til->company->address = 'HOCA ÖMER MAH. GÖLEBATMAZ CAD. NO:1 KAT:4';
$til->company->district = 'MERKEZ';
$til->company->city = 'ADIYAMAN';
$til->company->country = 'TURKEY';
$til->company->email = 'info@tilpark.com';
$til->company->phone = '2129091212';
$til->company->gsm = '2129091212';

function dbname($val)
{ global $til;
	return _prefix.$val;
}


function til($val='')
{ global $til;
	return $til;
}





$til->pg = new StdClass;
$til->pg->list_limit = 20; // bir sayfada gosterilecek listeleme limiti, tablonun row limiti




function til_include($val) {
	require_once get_root_path('includes/'.$val.'.php');
}







/* --------------------------------------------------- THEME */

/**
 * title: get_header()
 * desc: header.php dosyasını include eder.
 */
function get_header()
{
	include get_root_path('content/themes/default/header.php');
}

/**
 * title: get_footer()
 * desc: footer.php dosyasını include eder.
 */
function get_footer()
{
	include get_root_path('content/themes/default/footer.php');
}

/**
 * title: get_sidebar()
 * desc: sidebar.php dosyasını include eder.
 */
function get_sidebar()
{
	include get_root_path('content/themes/default/sidebar.php');
}



/* --------------------------------------------------- URL */
/**
 * title: get_site_url()
 * desc: site adresini dondurur
 */
function get_site_url($val='', $val_2=false)
{
	if(_helper_site_url($val)) {
		$val = _helper_site_url($val);

		if(is_numeric($val_2)) {
			$val = $val.'?id='.$val_2;
		} else {
			$val = $val.'?'.$val_2;
		}
	}

	if(substr($val, 0,1) == '/') {
		return _site_url.''.$val;
	} else {
		return _site_url.'/'.$val;
	}

}
/**
 * title: site_url()
 * desc: site adresini gosterir
 * func: get_site_url()
 */
function site_url($val='', $val_2=false)
{
	echo get_site_url($val, $val_2);
}

/*
 * _helper_site_url()
 *	get_site_url() fonksiyonu icin kisaltmalari olusturur
 */
function _helper_site_url($val) {
	if($val == 'form') {
		return 'admin/form/detail.php';
	} else if($val == 'account') {
		return 'admin/account/detail.php';
	} else if($val == 'payment') {
		return 'admin/payment/detail.php';
	} else if($val == 'item') {
		return 'admin/item/detail.php';
	} else if($val == 'message') {
		return 'admin/user/message/detail.php';
	} else if($val == 'task') {
		return 'admin/user/task/detail.php';
	} else {
		return false;
	}
}



/**
 * title: get_template_url()
 * desc: secili temanın klasör adresini url olarak döndürür
 */
function get_template_url($val='')
{
	return get_site_url().'/content/themes/default/'.$val;
}
/**
 * title: template_url()
 * func: get_template_url()
 */
function template_url($val='')
{
	echo get_template_url($val);
}





function is_home() {
	if(til_active_site_url() == get_site_url()) {
		return true;
		exit;
	} elseif(str_replace('index.php', '', til_active_site_url()) == get_site_url()) {
		return true;
		exit;
	} else { return false; }
}




/* --------------------------------------------------- INCLUDE FUNCTIONS */
til_include('db');
til_include('lang');
til_include('login');
til_include('helper');
til_include('input');
til_include('user');
til_include('log');
til_include('options');
til_include('theme');
til_include('account');
til_include('item');
til_include('form');
til_include('case');
til_include('chartjs');
til_include('message');
til_include('upload');
til_include('task');
til_include('notification');
til_include('mail');













/* --------------------------------------------------- ADDSLASHES */
if(!get_magic_quotes_gpc()) {
	if (isset($_GET) OR isset($_POST) OR isset($_COOKIE) OR isset($_REQUEST) ) {
	    $_GET 		= til_get_addslashes($_GET);
	    $_POST 		= til_get_addslashes($_POST);
	    $_COOKIE 	= til_get_addslashes($_COOKIE);
	    $_REQUEST 	= til_get_addslashes($_REQUEST);

	}
}





/* --------------------------------------------------- DEFAULT FUNCTIONS */
is_login();



$_args = array(
	'taxonomy'=>'form',
	'name'=>'Form',
	'description'=>'Genel form durumu yönetimi',
	'in_out'=>true,
	'sms_template'=>true,
	'email_template'=>true,
	'color'=>true,
	'bg_color'=>true
);
register_form_status($_args);
unset($_args);



$_args = array(
	'taxonomy'=>'teknik_servis',
	'name'=>'Teknik Servis',
	'description'=>'',
	'in_out'=>false,
	'sms_template'=>false,
	'email_template'=>false,
	'color'=>true,
	'bg_color'=>false
);
register_form_status($_args);
unset($_args);















?>
