<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Şifre Değiştir' );
add_page_info( 'nav', array('name'=>'Profilim', 'url'=>get_site_url('admin/user/profile.php')) );
add_page_info( 'nav', array('name'=>'Şifre Değiştir') );
?>

<?php
// aktif olan kullanıcın tüm bilgilerini cekelim
$active = get_active_user();

if(isset($_POST['change_password'])) {
	$old_password 		= $_POST['old_password'];
	$new_password 		= $_POST['new_password'];
	$new_password_again = $_POST['new_password_again'];

	if($old_password != $active->password) {
		add_alert('Eski şifreniz doğru değil. Yeni şifre oluşturabilmek için eski şifrenizi yazmanız gerekiyor.', 'warning', 'change_password');
	} else {
		if($new_password != $new_password_again) {
			add_alert('Yeni şifreniz ile yeni şifrenizin tekrarı aynı değil.', 'warning', 'change_password');
		} else {
			if(db()->query("UPDATE ".dbname('users')." SET password='".$new_password."' WHERE id='".$active->id."' ")) {
				if(db()->affected_rows) {
					add_alert('Şifre değiştirme işlemi başarılı.', 'success', 'change_password');
				}
			}
		}
	}
}

print_alert('change_password');
?>



<div class="row">
	<div class="col-md-3">
		<form name="form_change_password" id="form_change_password" action="?" method="POST" class="validate">
			<div class="form-group">
				<label for="old_password">Eski Şifre</label>
				<input type="password" name="old_password" id="old_password" class="form-control required" value="">
			</div> <!-- /.form-group -->

			<div class="form-group">
				<label for="new_password">Yeni Şifre</label>
				<input type="password" name="new_password" id="new_password" class="form-control required" minlength="6" value="">
			</div> <!-- /.form-group -->

			<div class="form-group">
				<label for="new_password_again">Yeni Şifre Tekrar</label>
				<input type="password" name="new_password_again" id="new_password_again" class="form-control required" minlength="6" value="">
			</div> <!-- /.form-group -->

			<div class="text-right">
				<input type="hidden" name="change_password" id="change_password">
				<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
				<button class="btn btn-default">Şifremi değiştir</button>
			</div> <!-- /.text-right -->

		</form>
	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->




<?php get_footer(); ?>