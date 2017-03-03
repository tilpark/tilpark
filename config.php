<?php
// config
define('_site_url', 'http://localhost/github/tilpark');
define('_prefix', 'til_');
define('_root_path', $_SERVER['DOCUMENT_ROOT'].'/');
define('_fixed', '2');


// Bağlatıyı Kuralım.
$db = new mysqli("localhost", "root", "");
if($db->connect_errno){
    echo "Bağlantı Hatası:".$db->connect_errno;
    exit;
}

// Veritabanımızı Seçelim.
$db->select_db('tilpark');
$db->query("SET NAMES 'utf8'");



function db()
{
	global $db;
	return $db;
}


// global ön ek
$til = (object) array();
global $til;

$til->fixed = '2';
$til->company = array();
$til->company['name'] = 'Tilpark!';
$til->company['address'] = 'Hocaömer Mah. 206. SK. No:1 Kat:4';
$til->company['district'] = 'Merkez';
$til->company['city'] = 'Adıyaman';
$til->company['country'] = 'TURKEY';
$til->company['email'] = 'info@tilpark.com';
$til->company['phone'] = '2129091212';
$til->company['gsm'] = '2129091212';

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




?>