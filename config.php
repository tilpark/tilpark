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
$til = (object)[];
global $til;

$til->fixed = '2';

function dbname($val)
{ global $til;
	return _prefix.$val;
}


$til->pg = new StdClass;
$til->pg->limit_list = 6; // bir sayfada gosterilecek listeleme limiti, tablonun row limiti






?>