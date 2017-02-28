<?php
/* --------------------------------------------------- LOGIN */

/**
 * is_login()
 * Tarayicidaki uyenin giris yapip yapmadigini kontrol eder.
 */
function is_login() {
	if($_SESSION['login_id']) {
		return true;
	} else {
		header("Location: ".get_site_url('login.php'));
	}
}


