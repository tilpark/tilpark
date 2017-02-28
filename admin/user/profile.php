<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Profilim' );
add_page_info( 'nav', array('name'=>'Profilim') );
?>

<?php
// aktif olan kullanıcın tüm bilgilerini cekelim
$active = get_active_user();


if(isset($_GET['delete_avatar'])) {
	if($active->avatar) {
		if(delete_image($active->avatar)) {
			update_user($active->id, array('avatar'=>''));
		}
	}
}

if(isset($_POST['update_profile'])) {
	
	$_profile['username'] 	= $_POST['username'];
	$_profile['name'] 		= $_POST['name'];
	$_profile['surname'] 	= $_POST['surname'];
	$_profile['gsm']		= get_set_gsm($_POST['gsm']);

	// resim yukleme
	if($_FILES['avatar']['size'] > 0) {

		$args['uniquetime'] = $_POST['img_uniquetime'];
		$args['sizing']['width'] 	= '150';
		$args['sizing']['height'] 	= '150';
		$args['add_log'] = false;
		if($upload_image = upload_image($_FILES['avatar'], $args)) {
			$_profile['avatar'] = $upload_image;

			// yeni resim yuklendigi icin eski resmi sunucudan silelim
			delete_image($active->avatar);
		}
	}

	update_user($active->id, $_profile);
}

// eger yukarıdai guncelle yapilmis ise bilgileri tekrar alalim
$active = get_user(get_active_user('id'));


?>



<ul class="nav nav-tabs" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-id-card-o"></i> Profilim</a></li> 
	<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="false"><i class="fa fa-database"></i> Geçmişim</a></li> 
</ul>


<div class="tab-content"> 

	<!-- tab:home -->
	<div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab"> 

		<?php print_alert(); ?>

		<form name="form-profile" id="form-profile" method="POST" action="?" class="validate" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-6">

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="username">E-posta</label>
							<input type="text" name="username" id="username" value="<?php echo $active->username; ?>" class="form-control email">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-6 -->
					<div class="col-md-6">
						<div class="form-group">
							<label for="gsm">Cep Telefonu</label>
							<input type="text" name="gsm" id="gsm" value="<?php echo $active->gsm; ?>" class="form-control digits" minlength="10" maxlength="11">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Ad</label>
							<input type="text" name="name" id="name" value="<?php echo $active->name; ?>" class="form-control" minlength="3" maxlength="20">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-6 -->
					<div class="col-md-6">
						<div class="form-group">
							<label for="surname">Soyad</label>
							<input type="text" name="surname" id="surname" value="<?php echo $active->surname; ?>" class="form-control" minlength="3" maxlength="20">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="role">Yetki</label>
							<select name="role" id="role" class="select" disabled="">
								<option value="5" <?php selected($active->role, '5'); ?>><?php echo get_user_role_text(5); ?></option>
								<option value="4" <?php selected($active->role, '4'); ?>><?php echo get_user_role_text(4); ?></option>
								<option value="3" <?php selected($active->role, '3'); ?>><?php echo get_user_role_text(3); ?></option>
								<option value="2" <?php selected($active->role, '2'); ?>><?php echo get_user_role_text(2); ?></option>
								<option value="1" <?php selected($active->role, '1'); ?>><?php echo get_user_role_text(1); ?></option>
							</select>
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->


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
					<img src="<?php echo $active->avatar; ?>" class="img-responsive" style="width:180px; height:180px;">

					<div class="h-10"></div>
					<a href="?id=<?php echo $active->id; ?>&delete_avatar" class="pull-right text-danger fs-12"><i class="fa fa-trash"></i> Bu fotoğrafı sil</a>
				</div> <!-- /img-thumbnail -->
				

				<div class="h-20"></div>
				<div class="form-group">
					<label for="avatar">Yeni bir fotoğraf yükle.</label>
					<input type="hidden" name="img_uniquetime" value="<?php usleep(1000); uniquetime(); ?>">
					<input type="file" name="avatar" id="avatar">
				</div> <!-- /.form-group -->



			</div> <!-- /.col-md-2 -->
		</div> <!-- /.row -->
		</form>
	</div> <!-- /#home -->
	<!-- /tab:home -->

	<!-- tab:home -->
	<div class="tab-pane" role="tabpanel" id="logs" aria-labelledby="logs-tab"> 
		<?php theme_get_logs(" user_id='".$active->id."' "); ?>
	</div>
	<!-- tab:logs -->

</div> <!-- /.tab-content -->


<?php get_footer(); ?>