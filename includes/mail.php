<?php
/*
| -----------------------------------------------------------------------------
| Mail
| -----------------------------------------------------------------------------
| Mail işlemleri için gerekli fonsiyonlar
|
| -----------------------------------------------------------------------------
| Fonksiyonlar
| -----------------------------------------------------------------------------
|
| * send_mail()
|
*/





/**
 * @func send_mail()
 * @desc mail gönderir
 * @param array()
 * @return true / false
 */
function send_mail($args=array()) {
	$args   = _args_helper(input_check($args), 'send');
  $_send 	= $args['send'];


	form_validation($_send['receiver'], '', 'Alıcı Mail', 'required|email');
	form_validation($_send['receiver_name'], '', 'Alıcı Adı - Soyadı', 'required|min_length[3]');
	form_validation($_send['subject'], '', 'Konu', 'required|min_length[3]');
	form_validation($_send['content'], '', 'İçerik', 'required|min_length[3]');

	if ( !is_alert(__FUNCTION__) ) {
		include 'lib/phpMailer/PHPMailerAutoload.php';

		// Mail option
		$option = get_option('mail');


		// Company option
		$_company = get_option('company');
		if ( empty($_company) ) {$_company = (object) array('name' => '', 'address' => '', 'district' => '', 'city' => '', 'country' => '', 'email' => '', 'phone' => '', 'gsm' => ''); }


		// is email empty
		if ( empty($option->send_address) ) { if ( !empty($_company->email) ) { $option->send_address = $_company->email; } }

		if ( !empty($option->send_address) ) {
			$mail = new PHPMailer;

			if ( empty($option->host) AND empty($option->port) AND empty($option->password) ) {
				if ( !in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1') ) ) {
					$mail->isSendmail();
					$mail->CharSet = 'UTF-8';

					$mail->setFrom($option->send_address, $_company->name);
					$mail->addReplyTo($option->send_address, $_company->name);
					$mail->addAddress($_send['receiver'], $_send['receiver_name']);

					$mail->Subject 		= $_send['subject'];
					$mail->Body 			= $_send['content'];
					$mail->AltBody 		= 'This is a plain-text message body';
				} else { return false; }
			} else {
				$mail->isSMTP();
				$mail->CharSet = 'UTF-8';

				$mail->Host 			= $option->host;
				$mail->Port 			= $option->port;
				$mail->SMTPAuth 	= true;
				$mail->Username 	= $option->send_address;
				$mail->Password 	= $option->password;

				$mail->setFrom($option->send_address, $_company->name);
				$mail->addReplyTo($option->send_address, $_company->name);
				$mail->addAddress($_send['receiver'], $_send['receiver_name']);

				$mail->Subject 		= $_send['subject'];
				$mail->Body 			= $_send['content'];
				$mail->AltBody 		= 'This is a plain-text message body';
			} // if ( !empty($option->send_address) )


			if ( !$mail->send() ) {
		    add_alert('Mail Gönderilemedi!', 'danger', __FUNCTION__);
			} else {
			  add_alert('Mail Gönderildi!', 'success', __FUNCTION__);
			}
		} else { add_alert('Mail göndermek için gerekli bilgiler bulunmadı.', 'danger', __FUNCTION__); }
	} // is_alert()
} //.send_mail()
