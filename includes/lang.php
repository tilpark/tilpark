<?php
/* --------------------------------------------------- ITEM */
global $lang;
$lang['Üye Girişi'] = 'User Login';
$lang['Üye Çıkışı'] = 'User Logout';
function language() {
	global $lang;
	return $lang;
}



/**
 * get_lang()
 * gecerli dil seçeneğini dondurur
 */
function get_lang($text, $arr=array()) {
	$lang = language();
	if(isset($lang[$text])) {
		return $lang[$text];
	} else {
		return $text;
	}
}




?>