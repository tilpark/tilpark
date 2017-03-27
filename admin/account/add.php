<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Hesap Ekle' );
add_page_info( 'nav', array('name'=>'Hesap Yönetimi', 'url'=>get_site_url('admin/account/') ) );
add_page_info( 'nav', array('name'=>'Hesap Ekle') );
?>




<?php
if(isset($_POST['add'])) {

	if($account_id = add_account($_POST)) {
		print_alert('add_account');

		if(isset($_POST['again'])) {
			unset($_POST);
			$_POST['again'] = true;
		} else {
			header("Location: detail.php?id=".$account_id);
		}
	} else {
		if(is_alert()) { // eger form_validation hata var ise ekrana basarlim
			print_alert();
			
		}
	}
}


if(@empty($_POST['code'])) {
	$_POST['code'] = get_account_code_generator();
}
?>


<form name="form_add_accout" id="form_add_account" action="" method="POST" class="validate">

<div class="row">
	<div class="col-md-6">

		<div class="form-group">
			<label for="code">Barkod Kodu </label>
			<input type="text" name="code" id="code" value="<?php echo @$_POST['code']; ?>" class="form-control" minlength="3" maxlength="32">
		</div> <!-- /.form-group -->

		<div class="form-group">
			<label for="name">Hesap Adı <sup class="text-muted">şahıs adı soyadı, firma adı, şirket adı vb.</sup></label>
			<input type="text" name="name" id="name" value="<?php echo @$_POST['name']; ?>" class="form-control required" minlength="3" maxlength="50">
		</div> <!-- /.form-group -->

		<div class="form-group">
			<label for="email">E-Posta</label>
			<input type="text" name="email" id="email" value="<?php echo @$_POST['email']; ?>" class="form-control" minlength="3" maxlength="50">
		</div> <!-- /.form-group -->

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="gsm">Cep Telefonu</label>
					<input type="text" name="gsm" id="gsm" value="<?php echo @$_POST['gsm']; ?>" class="form-control required digits" minlength="10" maxlength="11">
				</div> <!-- /.form-group -->
			</div> <!-- /.col-md-6 -->
			<div class="col-md-6">
				<div class="form-group">
					<label for="phone">Sabit Telefon</label>
					<input type="text" name="phone" id="phone" value="<?php echo @$_POST['phone']; ?>" class="form-control digits" minlength="10" maxlength="11">
				</div> <!-- /.form-group -->
			</div> <!-- /.col-md-6 -->
		</div> <!-- /.row -->

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">

		<div class="form-group">
			<label for="address">Adres</label>
			<input type="text" name="address" id="address" value="<?php echo @$_POST['address']; ?>" class="form-control" maxlength="250">
		</div> <!-- /.form-group -->

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="district">İlçe-Bölge</label>
					<input type="text" name="district" id="district" value="<?php echo @$_POST['district']; ?>" class="form-control" maxlength="20">
				</div> <!-- /.form-group -->
			</div> <!-- /.col-md-4 -->
			<div class="col-md-4">
				<div class="form-group">
					<label for="city">Şehir-İl</label>
					<input type="text" name="city" id="city" value="<?php echo @$_POST['city']; ?>" class="form-control" maxlength="20">
				</div> <!-- /.form-group -->
			</div> <!-- /.col-md-4 -->
			<div class="col-md-4">
				<div class="form-group country_selected">
					<label for="country">Ülke</label>
					<?php echo list_selectbox(get_country_array(), array('name'=>'country', 'selected'=>'TURKEY', 'class'=>'form-control select select-account input-sm')); ?>
				</div> <!-- /.form-group -->
			</div> <!-- /.col-md-4 -->
		</div> <!-- /.row -->

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="tax_home">Vergi Dairesi</label>
					<input type="text" name="tax_home" id="tax_home" value="<?php echo @$_POST['tax_home']; ?>" class="form-control" maxlength="20">
				</div> <!-- /.form-group -->
			</div> <!-- /.col-md-4 -->
			<div class="col-md-4">
				<div class="form-group">
					<label for="tax_no">Vergi No veya T.C. Kimlik No</label>
					<input type="text" name="tax_no" id="tax_no" value="<?php echo @$_POST['tax_no']; ?>" class="form-control digits" maxlength="20">
				</div> <!-- /.form-group -->
			</div> <!-- /.col-md-4 -->
		</div> <!-- /.row -->

	</div> <!-- /.col-md-6 -->

</div> <!-- /.row -->

<div class="h-20"></div>
<div class="form-group pull-left">
	<label class="veritical-center text-muted">Kayıttan sonra yeni hesap kartı ekleyecek misiniz? &nbsp; <input type="checkbox" name="again" id="again" value="true" <?php if(isset($_POST['again']) or isset($_GET['again'])): ?>checked<?php endif; ?> data-toggle="switch" switch-size="lg" on-text="Evet" off-text="Hayır"></label>
</div> <!-- /.form-group -->
<div class="clearfix"></div>

<div class="text-right">
	<input type="hidden" name="add">
	<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
	<button class="btn btn-default btn-insert"><i class="fa fa-floppy-o"></i> Kaydet</button>
</div>

</form>



<script>
$('#name').focus();
</script>


<?php get_footer(); ?>