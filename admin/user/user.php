<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>

<?php
// aktif olan kullanıcın tüm bilgilerini cekelim
$user = get_user($_GET['id']);





## hesap silme
if(isset($_GET['status']) and user_access('admin')) {
	if($_GET['status'] == '0' OR $_GET['status'] == '1') {
		$_args = array();
		$_args['add_log'] = false;
		$_args['add_alert'] = false;
		$_args['update']['status'] = $_GET['status'];
		if(update_user($user->id, $_args)) {
			if($_GET['status'] == '0') { 
				add_log(array('table_id'=>'users:'.$user->id, 'log_key'=>__FUNCTION__, 'log_text'=>_b($user->display_name).' kullanıcı hesabını <u>pasife</u> aldı.'));
				add_alert('Kullanıcı hesabı pasif edildi.', 'warning', false); }
			else { 
				add_log(array('table_id'=>'users:'.$user->id, 'log_key'=>__FUNCTION__, 'log_text'=>_b($user->display_name).' kullanıcı hesabını <u>aktife</u> aldı.'));
				add_alert('Kullanıcı hesabı aktif edildi.', 'success', false); }
		}
	}
}


### fotofraf yukleme ###

## fotoraf silme
if(isset($_GET['delete_avatar']) and user_access('admin')) {
	if($user->avatar) {
		if(delete_image($user->avatar)) {
			update_user($user->id, array('avatar'=>''));
		}
	}
}

## fotoraf yukleme
if(isset($_POST['update_profile']) and user_access('admin')) {

	$_user['username'] 	= $_POST['username'];
	$_user['name'] 		= $_POST['name'];
	$_user['surname'] 	= $_POST['surname'];
	$_user['gsm']		= get_set_gsm($_POST['gsm']);
	$_user['role']		= $_POST['role'];
	$_user['gender']	= $_POST['gender'];
	$_user['citizenship_no']		= $_POST['citizenship_no'];

	if(!isset($_POST['til_login'])) {
		$_user['til_login'] = false;
	}

	// resim yukleme
	if($_FILES['avatar']['size'] > 0) {

		$args['uniquetime'] = get_uniquetime();
		$args['sizing']['width'] 	= '150';
		$args['sizing']['height'] 	= '150';
		if($upload_image = upload_image($_FILES['avatar'], $args)) {
			$_user['avatar'] = $upload_image;

			// yeni resim yuklendigi icin eski resmi sunucudan silelim
			delete_image($user->avatar);
		}
	}

	// eger sifre kutusu bos degilse sifre guncellenmek isteniyordur.
	if(!empty($_POST['password'])) {
		if($_POST['password'] != $_POST['password_again']) {
			add_alert('Yeni oluşturduğunuz şifre ile şifre tekrarı aynı değil. Lütfen tekrar deneyin.', 'danger', 'update_profile');
		} else {
			$_user['password'] = $_POST['password'];
		}
	}

	if(!is_alert('update_profile')) {
		if(update_user($user->id, $_user)) {

		}
	}	
}




## detay bilgilerini guncelleme
if(isset($_POST['update_cv'])) {

	update_user_meta($user->id, 'father_name', $_POST['father_name']);
	update_user_meta($user->id, 'mother_name', $_POST['mother_name']);
	update_user_meta($user->id, 'date_birth', $_POST['date_birth']);
	update_user_meta($user->id, 'birthplace', $_POST['birthplace']);

	update_user_meta($user->id, 'district', $_POST['district']);
	update_user_meta($user->id, 'city', $_POST['city']);
	update_user_meta($user->id, 'address', $_POST['address']);




	if($_POST['is_married'] == 'not_married') {
		$_POST['spouses_name']  	= '';
		$_POST['children_count'] 	= '';
	} elseif($_POST['is_married'] == 'married') {

	} elseif($_POST['is_married'] == 'widow') {
		$_POST['spouses_name']  	= '';
	} else {
		$_POST['spouses_name']  	= '';
		$_POST['children_count'] 	= '';
	}

	update_user_meta($user->id, 'is_married', $_POST['is_married']);
	update_user_meta($user->id, 'humble_person_count', $_POST['humble_person_count']);
	update_user_meta($user->id, 'spouses_name', $_POST['spouses_name']);
	update_user_meta($user->id, 'children_count', $_POST['children_count']);


	if($_POST['military_status'] == 'done') {
		$_POST['military_postponed']  	= '';
		$_POST['military_exempt'] 	= '';
	} elseif($_POST['military_status'] == 'postponed') {
		$_POST['military_end_date']  	= '';
		$_POST['military_exempt'] 	= '';
	} elseif($_POST['military_status'] == 'exempt') {
		$_POST['military_end_date']  	= '';
		$_POST['military_postponed'] 	= '';
	} else {
		$_POST['military_end_date']  	= '';
		$_POST['military_postponed'] 	= '';
		$_POST['military_exempt'] 	= '';
	}
	update_user_meta($user->id, 'military_status', $_POST['military_status']);
	update_user_meta($user->id, 'military_end_date', $_POST['military_end_date']);
	update_user_meta($user->id, 'military_postponed', $_POST['military_postponed']);
	update_user_meta($user->id, 'military_exempt', $_POST['military_exempt']);



	if(isset($_POST['emergency_name'])) {
		$school = array();
		for($i=0; $i<count($_POST['emergency_name']); $i++) {
			if(strlen($_POST['emergency_name'][$i]) OR strlen($_POST['emergency_relative'][$i]) OR $_POST['emergency_phone'][$i]) {
				$emergency[$i]['emergency_name'] 		= $_POST['emergency_name'][$i];
				$emergency[$i]['emergency_relative']	= $_POST['emergency_relative'][$i];
				$emergency[$i]['emergency_phone']		= $_POST['emergency_phone'][$i];
			}
		}
		update_user_meta($user->id, 'emergency', $emergency);
	}

	if(isset($_POST['school_level'])) {
		$arr = array();
		
		for($i=0; $i<count($_POST['school_level']); $i++) {

			if(strlen($_POST['school_name'][$i]) OR strlen($_POST['school_department'][$i]) OR strlen($_POST['school_graduation_year'][$i]) OR strlen($_POST['school_grade'][$i]) )  {
				$arr[$i]['school_level'] 		= $_POST['school_level'][$i];
				$arr[$i]['school_name']			= $_POST['school_name'][$i];
				$arr[$i]['school_department']	= $_POST['school_department'][$i];
				$arr[$i]['school_graduation_year'] = $_POST['school_graduation_year'][$i];
				$arr[$i]['school_grade'] 		= $_POST['school_grade'][$i];
			}
		}

		update_user_meta($user->id, 'school', $arr);
	}

	if(isset($_POST['work_level'])) {
		$arr = array();
		for($i=0; $i<count($_POST['work_level']); $i++) {
			if(strlen($_POST['work_position'][$i]) OR strlen($_POST['work_company_name'][$i]) OR strlen($_POST['work_start_date'][$i]) OR strlen($_POST['work_end_date'][$i]) OR strlen($_POST['work_description'][$i]) )  {
				$arr[$i]['work_level'] 		= $_POST['work_level'][$i];
				$arr[$i]['work_position'] 		= $_POST['work_position'][$i];
				$arr[$i]['work_company_name'] 	= $_POST['work_company_name'][$i];
				$arr[$i]['work_start_date'] 	= $_POST['work_start_date'][$i];
				$arr[$i]['work_end_date'] 		= $_POST['work_end_date'][$i];
				$arr[$i]['work_description'] 	= $_POST['work_description'][$i];
			}
		}
		update_user_meta($user->id, 'work', $arr);
	}

	# language 
	if(isset($_POST['lang_lang'])) {
		$arr = array();
		for($i=0; $i<count($_POST['lang_lang']); $i++) {
			if(strlen($_POST['lang_lang'][$i]))  {
				$arr[$i]['lang_lang'] 		= $_POST['lang_lang'][$i];
				$arr[$i]['lang_reading'] 	= $_POST['lang_reading'][$i];
				$arr[$i]['lang_writing'] 	= $_POST['lang_writing'][$i];
				$arr[$i]['lang_talk'] 		= $_POST['lang_talk'][$i];
			}
		}
		update_user_meta($user->id, 'language', $arr);
	}

	# reference 
	if(isset($_POST['ref_name_surname'])) {
		$arr = array();
		for($i=0; $i<count($_POST['ref_name_surname']); $i++) {
			if(strlen($_POST['ref_name_surname'][$i]) OR strlen($_POST['ref_company'][$i]) OR strlen($_POST['ref_phone'][$i])) {
				$arr[$i]['ref_name_surname'] 	= $_POST['ref_name_surname'][$i];
				$arr[$i]['ref_company'] 		= $_POST['ref_company'][$i];
				$arr[$i]['ref_phone'] 			= $_POST['ref_phone'][$i];
			}
		}
		update_user_meta($user->id, 'reference', $arr);
	}

	# driving license
	if(isset($_POST['driving_license'])) {
		$arr = array();

		for($i=0; $i<count($_POST['driving_license']); $i++) {

			$arr[$i] = $_POST['driving_license'][$i];
		}
		update_user_meta($user->id, 'driving_license', $arr);
	}

	# SRC
	if(isset($_POST['src'])) {
		$arr = array();

		for($i=0; $i<count($_POST['src']); $i++) {

			$arr[$i] = $_POST['src'][$i];
		}
		update_user_meta($user->id, 'src', $arr);
	}

	if(isset($_POST['smoking'])) { update_user_meta($user->id, 'smoking', 'true'); } else { update_user_meta($user->id, 'smoking', ''); }
	if(isset($_POST['travel_ban'])) { update_user_meta($user->id, 'travel_ban', 'true'); } else { update_user_meta($user->id, 'travel_ban', ''); }
	if(isset($_POST['work_overtime'])) { update_user_meta($user->id, 'work_overtime', 'true'); } else { update_user_meta($user->id, 'work_overtime', ''); }
	if(isset($_POST['work_night'])) { update_user_meta($user->id, 'work_night', 'true'); } else { update_user_meta($user->id, 'work_night', ''); }
	
	# unhealthy
	if(isset($_POST['unhealthy'])) {
		update_user_meta($user->id, 'unhealthy', true);
		update_user_meta($user->id, 'unhealthy_type', $_POST['unhealthy_type']);
		update_user_meta($user->id, 'unhealthy_degree', $_POST['unhealthy_degree']);
	} else {
		update_user_meta($user->id, 'unhealthy', false);
		update_user_meta($user->id, 'unhealthy_type', false);
		update_user_meta($user->id, 'unhealthy_degree', false);
	}

	# terror
	if(isset($_POST['terror'])) {
		update_user_meta($user->id, 'terror', true);
		update_user_meta($user->id, 'terror_type', $_POST['terror_type']);
		update_user_meta($user->id, 'terror_desc', $_POST['terror_desc']);
	} else {
		update_user_meta($user->id, 'terror', false);
		update_user_meta($user->id, 'terror_type', false);
		update_user_meta($user->id, 'terror_desc', false);
	}

	# terror
	if(isset($_POST['prison'])) {
		update_user_meta($user->id, 'prison', true);
		update_user_meta($user->id, 'prison_year', $_POST['prison_year']);
		update_user_meta($user->id, 'prison_month', $_POST['prison_month']);
		update_user_meta($user->id, 'prison_desc', $_POST['prison_desc']);
	} else {
		update_user_meta($user->id, 'prison', false);
		update_user_meta($user->id, 'prison_year', false);
		update_user_meta($user->id, 'prison_month', false);
		update_user_meta($user->id, 'prison_desc', false);
	}

	update_user_meta($user->id, 'blood_group', $_POST['blood_group']);
	update_user_meta($user->id, 'human_size', $_POST['human_size']);
	update_user_meta($user->id, 'human_weight', $_POST['human_weight']);

	# social media
	update_user_meta($user->id, 'url_website', $_POST['url_website']);
	update_user_meta($user->id, 'url_facebook', $_POST['url_facebook']);
	update_user_meta($user->id, 'url_linkedin', $_POST['url_linkedin']);
	update_user_meta($user->id, 'url_twitter', $_POST['url_twitter']);


	add_alert('Personel bilgileri güncellendi', 'success', true);
}



$user_meta = get_user_meta($user->id);



## eger yukarıdai guncelle yapilmis ise bilgileri tekrar alalim diye bilgileri tekrar aliyoruz
$user = get_user($_GET['id']);

add_page_info( 'title', $user->name.' '.$user->surname );
add_page_info( 'nav', array('name'=>'Tüm Personeller', 'url'=>get_site_url('admin/user/list.php')) );
add_page_info( 'nav', array('name'=>$user->name.' '.$user->surname) );
?>



<ul class="nav nav-tabs" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-user-o"></i> Profil</a></li> 
	<?php if(user_access('admin')): ?><li role="presentation"><a href="#cv" id="cv-tab" role="tab" data-toggle="tab" aria-controls="cv" aria-expanded="true"><i class="fa fa-address-book-o"></i> CV</a></li><?php endif; ?>
	<?php if(user_access('admin')): ?><li role="presentation"><a href="#salary" id="salary-tab" role="tab" data-toggle="tab" aria-controls="salary" aria-expanded="true"><i class="fa fa-money"></i> Maaş</a></li><?php endif; ?>
	<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="false"><i class="fa fa-database"></i> Geçmiş</a></li> 

	<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-cogs"></i> Seçenekler <span class="caret"></span></a> 
		<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
			<li><a href="#dropdown1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1">Görev Ata</a></li> 
			<li><a href="<?php site_url('admin/user/message/add.php?rec_u_id='.$user->id); ?>">Mesaj Gönder</a></li> 
		</ul> 
	</li>
	<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-print"></i> Yazdır <span class="caret"></span></a> 
		<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
			<li><a href="print_cv.php?id=<?php echo $user->id; ?>" target="_blank">Özgeçmiş (CV) Yazdır</a></li> 
		</ul> 
	</li>
</ul>

<div class="tab-content"> 

	<!-- tab:home -->
	<div class="tab-pane active fade in" role="tabpanel" id="home" aria-labelledby="home-tab"> 

		<?php print_alert(); ?>

		<form name="form-profile" id="form-profile" method="POST" action="?id=<?php echo $user->id; ?>" class="validate" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-6">

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="username">E-posta</label>
							<input type="text" name="username" id="username" value="<?php echo $user->username; ?>" class="form-control email">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-6 -->
					<div class="col-md-6">
						<div class="form-group">
							<label for="gsm">Cep Telefonu</label>
							<input type="text" name="gsm" id="gsm" value="<?php echo $user->gsm; ?>" class="form-control digits" minlength="10" maxlength="11">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->


				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Ad</label>
							<input type="text" name="name" id="name" value="<?php echo $user->name; ?>" class="form-control" minlength="3" maxlength="20">
						</div> <!-- /.form-group -->
					</div> <!--- /.col-md-6 -->
					<div class="col-md-6">
						<div class="form-group">
							<label for="surname">Soyad</label>
							<input type="text" name="surname" id="surname" value="<?php echo $user->surname; ?>" class="form-control" minlength="3" maxlength="20">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->

				<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="username">Cinsiyet</label>
						<select name="gender" id="gender" class="form-control">
							<option value="1" <?php selected('1', $user->gender); ?>>Bay</option>
							<option value="0" <?php selected('0', $user->gender); ?>>Bayan</option>
						</select>
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
				<div class="col-md-6">
					<div class="form-group">
						<label for="citizenship_no">T.C. Kimlik No</label>
						<input type="text" name="citizenship_no" id="citizenship_no" class="form-control digits" minlength="11" maxlength="11" value="<?php echo $user->citizenship_no; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
			</div> <!-- /.row -->


				<?php if(user_access('admin')): ?>
					<div class="form-group">
						<label for="til_login" id="label_til_login">
							<input type="checkbox" name="til_login" id="til_login" value="1" <?php echo $user->til_login ? 'checked' : ''; ?>>
							Bu personel <b>Tilpark!</b> sistemine giriş yapabilir mi?
						</label>
					</div> <!-- /.form-group -->

					<script>
					$(document).ready(function() {
			
						$('#til_login').change(function() {
							if($('#til_login').is(':checked')) {
								$('#is_til_login_div').removeClass('hidden');
							} else {
								$('#is_til_login_div').addClass('hidden');
							}
						});

						<?php if($user->til_login): ?>
							$('#is_til_login_div').removeClass('hidden');
						<?php endif; ?>
					});
					</script>
				<?php endif; ?>


				<div id="is_til_login_div" class="hidden">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="role">Yetki</label>
								<select name="role" id="role" class="select form-control" <?php if(!user_access('admin')): echo 'disabled'; endif; ?>>
									<option value="5" <?php selected($user->role, '5'); ?>>Personel</option>
									<option value="4" <?php selected($user->role, '4'); ?>>Kıdemli Personel</option>
									<option value="3" <?php selected($user->role, '3'); ?>>Birim Amiri</option>
									<option value="2" <?php selected($user->role, '2'); ?>>Yönetici</option>
									<?php if(user_access('superadmin')): ?><option value="1" <?php selected($user->role, '1'); ?>>Süper Yönetici</option><?php endif; ?>
								</select>
							</div> <!-- /.form-group -->
						</div> <!-- /.col-md-6 -->
					</div> <!-- /.row -->




					<?php if(user_access('admin')): ?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="password">Şifre</label>
									<input type="password" name="password" id="password" class="form-control">
								</div> <!-- /.form-group -->
							</div> <!-- /.col-md-6 -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="password_again">Şifre Tekrar</label>
									<input type="password" name="password_again" id="password_again" class="form-control">
								</div> <!-- /.form-group -->
							</div> <!-- /.col-md-6 -->
						</div> <!-- /.row -->

						
					<?php endif; ?>
				</div> <!-- /#is_til_login_div -->

				<div class="pull-right">
					<input type="hidden" name="update_profile">
					<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
					<button class="btn btn-default">Kaydet</button>
				</div> <!-- /.pull-right -->

			</div> <!-- /.col-md-6 -->
			<div class="col-md-2">

				<label>&nbsp;</label>
				<br />

				<div class="img-thumbnail">
					<img src="<?php echo $user->avatar; ?>" class="img-responsive" style="width:180px; height:180px;">
					<?php if(user_access('admin')): ?>
						<div class="h-10"></div>
						<a href="?id=<?php echo $user->id; ?>&delete_avatar" class="pull-right text-danger fs-12"><i class="fa fa-trash"></i> Bu fotoğrafı sil</a>
					<?php endif; ?>
				</div>
				
				<?php if(user_access('admin')): ?>
					<div class="h-20"></div>
					<div class="form-group">
						<label for="avatar">Yeni bir fotoğraf yükle.</label>
						<input type="hidden" name="img_uniquetime" value="<?php usleep(1000); uniquetime(); ?>">
						<input type="file" name="avatar" id="avatar">
					</div> <!-- /.form-group -->
				<?php endif; ?>

			</div> <!-- /.col-md-2 -->
		</div> <!-- /.row -->

		</form>





		<?php if(user_access('admin')): ?>
			<hr />
			<?php if($user->status == 1): ?>
				<span class="">Bu kullanıcı hesabını silmek istiyor musunuz?</span>
				<a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#userDelete"><i class="fa fa-trash-o"></i> Evet, Sil</a>

				<!-- Modal -->
				<div class="modal fade" id="userDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">Kullanıcı Hesabı Silme</h4>
				      </div>
				      <div class="modal-body">
				        <p><strong><?php echo $user->display_name; ?></strong> kullanıcı hesabını silmek istiyor musun?</p>

				        <small class="text-muted">Kullanıcı hesabı veritabanından silinmez, sadece hesabın sisteme girişini engeller. Ayrıca "Tüm Kullanıcılar" gibi sayfalar bu kullanıcı hesabına erişemezsiniz. </small>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Hayır</button>
				        <a href="?id=<?php echo $user->id; ?>&status=0" class="btn btn-danger">Evet, onaylıyorum</a>
				      </div>
				    </div>
				  </div>
				</div>
			<?php else: ?>
				<span class="">Bu kullanıcı hesabını tekrar aktifleştir.</span>
				<a href="?id=<?php echo $user->id; ?>&status=1" class="btn btn-success btn-xs"><i class="fa fa-undo"></i> Evet, aktifleştir</a>
			<?php endif; ?>
		<?php endif; ?>


	</div> <!-- /#home -->
	<!-- /tab:home -->

	<!-- tab:cv -->
	<div class="tab-pane" role="tabpanel" id="cv" aria-labelledy="cv-tab">
		<?php print_alert(); ?>

		<?php include('inc_user_cv.php'); ?>

	</div>
	<!-- /tab:cv -->


	<!-- tab:cv -->
	<div class="tab-pane" role="tabpanel" id="salary" aria-labelledy="salary-tab">
		<?php print_alert(); ?>

		<?php include('inc_user_salary.php'); ?>
	</div>
	<!-- /tab:cv -->


	<!-- tab:home -->
	<div class="tab-pane" role="tabpanel" id="logs" aria-labelledby="logs-tab"> 
		<?php theme_get_logs(" user_id='".$user->id."' "); ?>
	</div>
	<!-- tab:logs -->

</div> <!-- /.tab-content -->


<?php get_footer(); ?>