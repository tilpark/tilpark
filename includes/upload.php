<?php
/* --------------------------------------------------- IMAGE UPLOAD */

if ( isset($_FILES['image']) AND isset($_GET['session_id']) ) {
	include '../tilpark.php';

	session_id($_GET['session_id']);
	if ( is_login() ) {
		if ( $image_url = upload_image($_FILES['image']) ) {
			echo get_site_url($image_url);
		} else { return false; }
	} else { return false; }
}


/**
 * upload_image()
 * bir resim dosyasına sunucuya yukler
 */
function upload_image($file, $args=array()) {

	$args = _args_helper($args);

	$path = ROOT_PATH.'/content/upload';
	if(!file_exists($path)) { mkdir($path); touch($path.'/index.php'); }
	$path .= '/'.date('Y');
	if(!file_exists($path)) { mkdir($path); touch($path.'/index.php'); }
	$path .= '/'.date('m');
	if(!file_exists($path)) { mkdir($path); touch($path.'/index.php'); }
	$path .= '/'.date('d');
	if(!file_exists($path)) { mkdir($path); touch($path.'/index.php'); }



	// file size control
	if ($file["size"] > 5000000) {
	    add_alert('Yüklenen resim dosyası çok büyük.', 'warning', __FUNCTION__);
	}

	// file type control
	$extension = pathinfo($file['name'],PATHINFO_EXTENSION);
	if($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif" ) {
	    add_alert('Yüklenecek resim dosyası sadece "PNG, JPG, JPEG ve GIF" formatında olabilir.', 'warning', __FUNCTION__);
	}

	// file type control 2
	if (!in_array($file["type"], array("image/gif", "image/png", "image/jpeg", "image/pjpeg"))) {
		add_alert("Yüklenecek dosya resim dosyası formatında olmalıdır.", 'warning', __FUNCTION__);
	}


	if(!is_alert(__FUNCTION__) and !have_log(@$args['uniquetime'])) {

		// yuklenecek dosyanin yeni adi ve yolu
		$file_to_upload = $path.'/til-uid-'.get_active_user('id').'-dt-'.date('YmdHis').'.'.$extension;

		if(move_uploaded_file($file['tmp_name'], $file_to_upload))
		{
			if(isset($args['sizing'])) {

				// eger herhangi bir boyut girilmesmis ise standart degerleri ayarlayalim
				if(!isset($args['sizing']['width'])) { $args['sizing']['width'] = '150'; }
				if(!isset($args['sizing']['height'])) { $args['sizing']['height'] = '150'; }

				$old_img_			= imagecreatefromjpeg($file_to_upload); 	// Yüklenen resimden oluşacak yeni bir JPEG resmi oluşturuyoruz..
				$old_img_size		= getimagesize($file_to_upload); 		// bir onceki resmimizin boyutlarini ogrenelim
				$new_img_blank		= imagecreatetruecolor($args['sizing']['width'], $args['sizing']['height']); // Oluşturulan boş resmi istediğimiz boyutlara getiriyoruz..

				imagecopyresampled($new_img_blank, $old_img_, 0, 0, 0, 0, $args['sizing']['width'], $args['sizing']['height'], $old_img_size[0], $old_img_size[1]);
				imagejpeg($new_img_blank, $file_to_upload, 100); // boyutlandirilan resmi kayit edelim
 			}



		    if($args['add_alert']) 	{ add_alert('Resim dosyası başarı ile yüklendi.', 'success', __FUNCTION__); }
			if($args['add_log']) 	{ add_log(array('uniquetime'=>@$args['uniquetime'], 'table_id'=>'users:'.get_active_user('id'), 'log_key'=>'image_upload', 'log_text'=>'Bir resim dosyası yükledi.')); }

		    return str_replace(ROOT_PATH, '', $file_to_upload);
		} else {
		    add_alert('Resim dosyası yüklenirken bilinmeyen bir hata oluştu.', 'danger', __FUNCTION__);
		    return false;
		}
	} else { return false; }
} //.upload_image();






/**
 * delete_image()
 * bir resim dosyasını sunucudan siler
 */
function delete_image($file) {
	$path = ROOT_PATH.'/'.str_replace(get_site_url(), '', $file);

	// eger resim yok ise ve silinmeye calisiliyorsa no-avatar silinmesin
	if(strstr($path, 'no-avatar.jpg')) { return false; }


	if(file_exists($path)) { // dosya var mi?
		if(is_file($path)) { // dosya bir dosya mi?
			if(unlink($path)) { // dosyayi sil
				return true;
			} else {
				add_console_log('Resim silinemedi', __FUNCTION__);
				return false;
			} //.unlink()
		} else { add_console_log('Silinecek öğe bir dosya değil.', __FUNCTION__); return false; }
	} else { add_console_log('Resim dosyası bulunamadı', __FUNCTION__); return false; }
} //.delete_image()









?>
