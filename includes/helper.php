<?php
/* --------------------------------------------------- HELPER */



function til_is_mobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}





/* --------------------------------------------------- HELPER - EXPORT */


/**
 * get_convert_str_export()
 * Excel,PDF gibi verileri disari aktarirken Turkce karakter hatalarini duzeltelim
 */
function get_convert_str_export($val) {
	return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $val);
}


/**
 * export_pdf()
 * bir sayfayı pdf formatına cevir
 */
function export_pdf($filename='', $ops=array()) {
	$filename = 'tilpark_'.$filename;
	if( !isset($ops['paper']) ) { $ops['paper']='A4'; }
	if( !isset($ops['landscape']) ) { $ops['landscape']=''; }

	require_once get_root_path('includes/lib/dompdf/export_pdf.php');
}


function export_excel($filename='') {
	$filename = 'tilpark_'.$filename.'.xls';
	header('Content-Description: File Transfer');
	header('Content-Encoding: UTF-8');
	header("Content-type: application/vnd.ms-excel;charset=UTF-8");
	header("Content-Disposition: attachment; filename=$filename");
	header('Content-Transfer-Encoding: binary');
	header('Pragma: public');
} //.export_excel()







/* --------------------------------------------------- HELPER - MONEY/DECIMAL */


/**
 * get_set_money()
 * parasal degerler icin kullanilir, genel ayarlara gore doviz birimin sonuna TL, EUR, DOLLAR gibi yazilar veya iconlar ekler
 * ayrica ondalik basamak birimini ayarlar
 */
function get_set_money($val, $arr=array()) {
    $val = str_replace(',', '', $val);

    if(!is_array($arr)) {
        if($arr == 'str') { $arr = array('str'=>true); }
        elseif($arr == 'icon') { $arr = array('icon'=>true); }
        $arr['decimal_separator']   = '.';
        $arr['digit_separator']     = ',';
    }

    if(!isset($arr['decimal_separator']))   { $arr['decimal_separator']   = '.'; }
    if(!isset($arr['digit_separator']))     { $arr['digit_separator']   = ','; }


    $icon = '';
    if( isset($arr['icon']) ) { $icon = ' <i class="fa fa-try icon-money"></i>'; }
    if( isset($arr['str']) ) { $icon = ' TL'; }


    if(is_numeric($val)) {
        return number_format($val, 2, '.', $arr['digit_separator']).$icon;
    } else {
        return number_format(0, 2, '.', $arr['digit_separator']).$icon;
    }
} //.get_set_money()

/**
 * set_money()
 * ref:get_set_money()
 */
function set_money($val, $arr=array()) {
    echo get_set_money($val, $arr);
} //.set_money()







/**
 * get_set_vat()
 * KDV degerlerinin olmasi gerektigi gibi 2 karakter yapar ve hesapamalar icin basina 1. sayisini ekler
 */
function get_set_vat($vat) {
    if(substr($vat,0,1) == 0) {
        $vat = substr($vat, 1);
    }
    if(strlen($vat) == 2) {
        return '1.'.$vat;
    } else {
        return '1.0'.$vat;
    }
} //.get_set_vat()

/**
 * set_vat()
 * ref:get_set_vat()
 */
function set_vat($vat) {
    echo get_set_vat($vat);
} //.set_vat()







/**
 * til_get_addslashes()
 * dizi halinde gelen tum degerlere addslashes ekler
 */
function til_get_addslashes($arr) {
    $return = array();
    if( !is_array($arr) ) {
        $return = addslashes($arr);
    } else {
         foreach($arr as $k=>$v) {
            if(is_array($v)) {
                $return[$k] = til_get_addslashes($v);
            } else {
                $return[$k] = addslashes($v);
            }
        }
    }
    
   
    return $return;
} //.til_get_addslashes()






/**
 * til_get_substr()
 *
 */
function til_get_substr($val, $start, $end, $args='...') {
    if(!is_array($args)) {
        $dot3 = $args;
        $args = array();
        if($dot3) {
            if(empty($dot3)) {
                $args['dot3'] = '';
            } else {
                $args['dot3'] = $dot3;
            }
        } else {
            $args['dot3'] = false;
        }
    }

    $return = trim(mb_substr($val, $start, $end, 'utf-8'));
    if( strlen($val) > ($end - $start) ) {
        $return .= $args['dot3'];
    }
    return $return;
}



/**
 * til_get_abbreviation()
 *
 */
function til_get_abbreviation($str, $max_length=2) {

    if(preg_match_all('/\b(\w)/',strtoupper($str),$m)) {
        $v = implode('',$m[1]);
         echo substr($v,0,$max_length);
    }  else {
        return false;
    }

   
}





function til_active_site_url() {
    return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
}




/* --------------------------------------------------- HELPER - STRING - CONVERTING */



/**
 * get_time_late()
 * bir tarih veririsin ne kadar zaman once oldugunu gosterir
 * ornek: "10 saniye" önce, "5 dakika" önce, "4 saat önce"
 */
function get_time_late($date)
{
	date_default_timezone_set('Europe/Istanbul');
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
} //.get_time_late()




function til_get_date_lang($val) {
    $arr1 = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $arr2 = array('Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık');
    $val = str_replace($arr1, $arr2, $val);
    return $val;
}


/**
 * til_get_date()
 * tarih formatlarini duzenler
 */
function til_get_date($date, $args=array()) {
    $return = '';
    if($date == 'true' OR $date == '1') {
        $date = date('Y-m-d H:i:s');
    }
    if(!is_array($args)) {
        if($args == 'date')         { $return = substr($date, 0, 10);    }
        elseif($args == 'datetime') { $return = substr($date, 0, 16);    }
        elseif($args == 'time')     { $return = substr($date, 11, 16);   }
        elseif($args == 'str: F Y')  { $return = date('F Y', strtotime($date));   }
        else { $return = date($args, strtotime($date));   }
    }

    return til_get_date_lang($return);
}






/**
 * til_exit()
 * betik akisini durdurur
 */
function til_exit($line_no) {
    exit('Akış durduruldu. Satir no: '.$line_no);
}








/**
 * json_encode_utf8()
 * json_encode fonksiyonu UTF8 karakterlerini eksik gostermektedir. Bu fonksiyon tum sunucularda sorunsuz calismaktadir.
 */
function json_encode_utf8($input, $flags = 0) {
    $fails = implode('|', array_filter(array(
        '\\\\',
        $flags & JSON_HEX_TAG ? 'u003[CE]' : '',
        $flags & JSON_HEX_AMP ? 'u0026' : '',
        $flags & JSON_HEX_APOS ? 'u0027' : '',
        $flags & JSON_HEX_QUOT ? 'u0022' : '',
    )));
    $pattern = "/\\\\(?:(?:$fails)(*SKIP)(*FAIL)|u([0-9a-fA-F]{4}))/";
    $callback = function ($m) {
        return html_entity_decode("&#x$m[1];", ENT_QUOTES, 'UTF-8');
    };
    return preg_replace_callback($pattern, $callback, json_encode($input, $flags));
} //.json_encode_utf8()





/**
 * is_json()
 * bir degerin json olup olmadigini kontrol eder
 */
function is_json($string){
   return is_string($string) && is_array(json_decode($string, true)) ? true : false;
} //.is_json()







/** * remove_accents()
 * bir degiskendeki boşluk nokta virgül gibi fazlaıkları siler "-" olarak değiştirir
 */
function remove_accents($fonktmp) {
    $returnstr = "";
    $turkcefrom = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
    $turkceto   = array("G","U","S","I","O","C","g","u","s","i","o","c");
    $fonktmp = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç_]/"," ",$fonktmp);
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
} //.remove_accents()






/**
 * _args_helper()
 * fonksiyonlara gonderilen $args parametlerini duzenler ve fonksiyon icin yardımcı nesneler olusturur
 */
function _args_helper($args, $default='') {

    $args2 = array();
    if(is_array($args)) {

        if(is_array($default)) {
            foreach($default as $def) {
                if(!isset($args[$def])) { add_alert('Parametre ile gelen "<b>'.$def.'</b>" dizisi/verisi eksik yada hatalı.', 'warning', __FUNCTION__); }
            }
        } else {
            if($default != '') {
                if(!isset($args[$default])) { $args2[$default] = $args; unset($args); $args = $args2; unset($args2); }
                elseif($args[$default] == '') { $args2[$default] = $args; unset($args); $args = $args2; unset($args2); }
            }

        }

        // eger hata var ise betik akisin duraruralim
        if(is_alert(__FUNCTION__)) { return false; }

        // default degerler icin $args dizisine genel parametreleri atayalim
        if(empty($args) AND !empty($default)) { $args[$default] = array(); }

        if(!isset($args['add_alert']))  { $args['add_alert'] = true; }
        if(!isset($args['add_log']))    { $args['add_log'] = true; }
        if(!isset($args['add_new']))    { $args['add_new'] = true; }
        if(!isset($args['return']))     { $args['return'] = 'default'; }
    } else {
        if(!empty($default)) {
            return $args[$default] = array();
        }
    }

    return $args;
} //._args_helper()






/**
 * _return_helper()
 * fonksiyon icinde donen degerlerin donus turlerini belirler
 */
function _return_helper($type, $result) {
    $return = array();
    if($result->num_rows == 1) {
        if($type=='default' or $type=='object' or $type=='single_object') {
            $return = $result->fetch_object();
        } elseif($type=='array') {
            $return = $result->fetch_assoc();
        } elseif($type=='plural_object') {

            $return[] = $result->fetch_object();
        } else { return false; }
    } elseif($result->num_rows > 1) {
        if($type=='single_object') {
            $return = $result->fetch_object();
        } elseif($type=='default' or $type=='object' or $type=='plural_object') {

            while($list = $result->fetch_object()) {
                $return[] = $list;
            }
        } elseif($type=='array') {
            while($list = $result->fetch_assoc()) {
                $return[] = $list;
            }
        } else { return false; }
    } else {
        return false;
    }
    return $return;
} //._return_helper()







/**
 * _b()
 * parametrede aldığı sonuca "<b>" ekler
 */
function _b($val, $ops='"') {
    return $ops.'<b>'.$val.'</b>'.$ops;
}






/**
 * til_get_ucfirst()
 * bir dizgenin ilk harflerini buyuk yapar
 */
function til_get_ucwords($string, $e ='utf-8') {
    if (function_exists('mb_convert_case') && !empty($string)) {
        $string = mb_convert_case($string, MB_CASE_TITLE, $e);
    } else {
        $string = ucwords($string);
    }
    return $string;
} //.til_get_ucfirst()








/**
 * til_get_strtoupper()
 * bir dizgeyi komple buyuk harf yapar
 */
function til_get_strtoupper($string, $e ='utf-8') {
    if (function_exists('mb_strtoupper') && !empty($string)) {
        $string = mb_strtoupper($string);
    } else {
        $string = strtoupper($string);
    }
    return $string;
} //.til_get_strtoupper()






/**
 * til_get_strtolower()
 * bir dizgeyi komple kucuk harf yapar
 */
function til_get_strtolower($string, $e ='utf-8') {
    if (function_exists('mb_strtolower') && !empty($string)) {
        $string = mb_strtolower($string);
    } else {
        $string = strtolower($string);
    }
    return $string;
} //.til_get_strtolower()






/**
 * til_get_money_convert_string()
 * bir rakamı yani parasal degeri string/text formatina cevirir
 */
function til_get_money_convert_string($money='0.00') {
    $l9 = '';
    $l8 = '';
    $l7 = '';
    $l6 = '';
    $l5 = '';
    $l4 = '';
    $l3 = '';
    $l2 = '';
    $l1 = '';
    $r1 = '';
    $r2 = '';

    $money = explode('.',$money);
    if(count($money)!=2) return false;
    $money_left = $money['0'];
    $money_right = substr($money['1'],0,2);

    //DOKUZLAR
    if(strlen($money_left)==9){
        $i = (int) floor($money_left/100000000);
        if($i==1) $l9="YÜZ";
        if($i==2) $l9="İKİ YÜZ";
        if($i==3) $l9="ÜÇ YÜZ";
        if($i==4) $l9="DÖRT YÜZ";
        if($i==5) $l9="BEŞ YÜZ";
        if($i==6) $l9="ALTI YÜZ";
        if($i==7) $l9="YEDİ YÜZ";
        if($i==8) $l9="SEKİZ YÜZ";
        if($i==9) $l9="DOKUZ YÜZ";
        if($i==0) $l9="";
        $money_left = substr($money_left,1,strlen($money_left)-1);
    }
    //SEKİZLER
    if(strlen($money_left)==8){
        $i = (int) floor($money_left/10000000);
        if($i==1) $l8="ON";
        if($i==2) $l8="YİRMİ";
        if($i==3) $l8="OTUZ";
        if($i==4) $l8="KIRK";
        if($i==5) $l8="ELLİ";
        if($i==6) $l8="ATMIŞ";
        if($i==7) $l8="YETMİŞ";
        if($i==8) $l8="SEKSEN";
        if($i==9) $l8="DOKSAN";
        if($i==0) $l8="";
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }
    //YEDİLER
    if(strlen($money_left)==7){
        $i = (int) floor($money_left/1000000);
        if($i==1){
            if($i!="NULL"){
                $l7 = "BİR MİLYON";
            }else{
                $l7 = "MİLYON";
            }
        }
        if($i==2) $l7="İKİ MİLYON";
        if($i==3) $l7="ÜÇ MİLYON";
        if($i==4) $l7="DÖRT MİLYON";
        if($i==5) $l7="BEŞ MİLYON";
        if($i==6) $l7="ALTI MİLYON";
        if($i==7) $l7="YEDİ MİLYON";
        if($i==8) $l7="SEKİZ MİLYON";
        if($i==9) $l7="DOKUZ MİLYON";
        if($i==0){
            if($i!="NULL"){
                $l7="MİLYON";
            }else{
                $l7="";
            }
        }
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }
    //ALTILAR
    if(strlen($money_left)==6){
        $i = (int) floor($money_left/100000);
        if($i==1) $l6="YÜZ";
        if($i==2) $l6="İKİ YÜZ";
        if($i==3) $l6="ÜÇ YÜZ";
        if($i==4) $l6="DÖRT YÜZ";
        if($i==5) $l6="BEŞ YÜZ";
        if($i==6) $l6="ALTI YÜZ";
        if($i==7) $l6="YEDİ YÜZ";
        if($i==8) $l6="SEKİZ YÜZ";
        if($i==9) $l6="DOKUZ YÜZ";
        if($i==0) $l6="";
        $money_left = substr($money_left,1,strlen($money_left)-1);
    }
    //BEŞLER
    if(strlen($money_left)==5){
        $i = (int) floor($money_left/10000);
        if($i==1) $l5="ON";
        if($i==2) $l5="YİRMİ";
        if($i==3) $l5="OTUZ";
        if($i==4) $l5="KIRK";
        if($i==5) $l5="ELLİ";
        if($i==6) $l5="ATMIŞ";
        if($i==7) $l5="YETMİŞ";
        if($i==8) $l5="SEKSEN";
        if($i==9) $l5="DOKSAN";
        if($i==0) $l5="";
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }
    //DÖRTLER
    if(strlen($money_left)==4){
        $i = (int) floor($money_left/1000);
        if($i==1){
            if($i!="") {
                $l4 = "BİR BİN";
            }else{
                $l4 = "BİN";
            }
        }
        if($i==2) $l4="İKİ BİN";
        if($i==3) $l4="ÜÇ BİN";
        if($i==4) $l4="DÖRT BİN";
        if($i==5) $l4="BEŞ BİN";
        if($i==6) $l4="ALTI BİN";
        if($i==7) $l4="YEDİ BİN";
        if($i==8) $l4="SEKZ BİN";
        if($i==9) $l4="DOKUZ BİN";
        if($i==0){
            if($i!=""){
                $l4="BİN";
            }else{
                $l4="";
            }
        }
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }
    //ÜÇLER
    if(strlen($money_left)==3){
        $i = (int) floor($money_left/100);
        if($i==1) $l3="YÜZ";
        if($i==2) $l3="İKİYÜZ";
        if($i==3) $l3="ÜÇYÜZ";
        if($i==4) $l3="DÖRTYÜZ";
        if($i==5) $l3="BEŞYÜZ";
        if($i==6) $l3="ALTIYÜZ";
        if($i==7) $l3="YEDİYÜZ";
        if($i==8) $l3="SEKİZYÜZ";
        if($i==9) $l3="DOKUZYÜZ";
        if($i==0) $l3="";
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }
    //İKİLER
    if(strlen($money_left)==2){
        $i = (int) floor($money_left/10);
        if($i==1) $l2="ON";
        if($i==2) $l2="YİRMİ";
        if($i==3) $l2="OTUZ";
        if($i==4) $l2="KIRK";
        if($i==5) $l2="ELLİ";
        if($i==6) $l2="ATMIŞ";
        if($i==7) $l2="YETMİŞ";
        if($i==8) $l2="SEKSEN";
        if($i==9) $l2="DOKSAN";
        if($i==0) $l2="";
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }
    //BİRLER
    if(strlen($money_left)==1){
        $i = (int) floor($money_left/1);
        if($i==1) $l1="BİR";
        if($i==2) $l1="İKİ";
        if($i==3) $l1="ÜÇ";
        if($i==4) $l1="DÖRT";
        if($i==5) $l1="BEŞ";
        if($i==6) $l1="ALTI";
        if($i==7) $l1="YEDİ";
        if($i==8) $l1="SEKİZ";
        if($i==9) $l1="DOKUZ";
        if($i==0) $l1="";
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }
    //SAĞ İKİ
    if(strlen($money_right)==2){
        $i = (int) floor($money_right/10);
        if($i==1) $r2="ON";
        if($i==2) $r2="YİRMİ";
        if($i==3) $r2="OTUZ";
        if($i==4) $r2="KIRK";
        if($i==5) $r2="ELLİ";
        if($i==6) $r2="ALTMIŞ";
        if($i==7) $r2="YETMİŞ";
        if($i==8) $r2="SEKSEN";
        if($i==9) $r2="DOKSAN";
        if($i==0) $r2="SIFIR";
        $money_right=substr($money_right,1,strlen($money_right)-1);
    }
    //SAĞ BİR
    if(strlen($money_right)==1){
        $i = (int) floor($money_right/1);
        if($i==1) $r1="BİR";
        if($i==2) $r1="İKİ";
        if($i==3) $r1="ÜÇ";
        if($i==4) $r1="DÖRT";
        if($i==5) $r1="BEŞ";
        if($i==6) $r1="ALTI";
        if($i==7) $r1="YEDİ";
        if($i==8) $r1="SEKİZ";
        if($i==9) $r1="DOKUZ";
        if($i==0) $r1="";
        $money_right=substr($money_right,1,strlen($money_right)-1);
    }


    return "$l9 $l8 $l7 $l6 $l5 $l4 $l3 $l2 $l1 TÜRK LİRASI $r2 $r1 KURUŞ";
} //.til_get_money_convert_string()















/* --------------------------------------------------- HELPER - COUNTRY-CITY-DISTRICT LIST */

/**
 * get_country_array()
 * ülke listelerini dizi halinde dondurur
 */
function get_country_array() {
    include get_root_path('includes/lib/countries/country.php');
    return $countries;
} //.get_country_array()






/**
 * list_selectbox_array()
 *
 */
function list_selectbox($array=array(), $opt=array()) {
    ob_start();

    // options
    if(!isset($opt['name'])) { $opt['name'] = 'selectbox'; }
    if(!isset($opt['id']))      { $opt['id'] = $opt['name']; }
    if(!isset($opt['class']))      { $opt['class'] = 'form-control select'; }
    if(!isset($opt['option_val_none'])) { $opt['option_val_none'] = false; }
    if(!isset($opt['selected'])) { $opt['selected'] = ''; }

    ?><select name="<?php echo $opt['name']; ?>" id="<?php echo $opt['id']; ?>" class="<?php echo $opt['class']; ?>" data-live-search="true"> <?php
        foreach($array as $key=>$val) {

            if($opt['option_val_none'] == true) {
                $key = $$key;
            } else {
                $key = $val;
            }

            $selected = '';
            if($opt['selected'] == $key) { $selected = 'selected'; }


            echo '<option val="'.$key.'" '.$selected.'>'.$val.'</option>';



        }

    ?></select> <?php

    $select = ob_get_contents();
    ob_end_clean();
    return $select;
}




/**
 * @func editor_strip_tags()
 * @desc içerikte istenilmeyen html'leri siler $strip ile gelen değerler hariç
 * @param string, string
 * @return string
 */
function editor_strip_tags($val, $strip="") {
  if ( empty($strip) ) { $strip = '<h1><h2><h3><h4><h5><a><div><span><p><b><br><li><ol><ul><strong><img><blockquote><em><s><u><i><table><thead><body><tr><td><th>'; }
	$val = strip_tags($val, $strip);

	return $val;
} //.editor_strin_tags()






















?>
