<?php include('../../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Genel Ayarlar' );
add_page_info( 'nav', array('name'=>'Seçenekler', 'url'=>get_site_url('admin/system/')) );
add_page_info( 'nav', array('name'=>'Genel Ayarlar') );
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs til-nav-page" role="tablist">
  <li role="presentation" class="active"><a href="#general" id="general-tab" aria-controls="general" role="tab" data-toggle="tab" aria-expanded="false">Genel</a></li>
  <li role="presentation" class=""><a href="#accounts" id="accounts-tab" aria-controls="accounts" role="tab" data-toggle="tab" aria-expanded="false">Hesap</a></li>
  <li role="presentation" class=""><a href="#product" id="product-tab" aria-controls="product" role="tab" data-toggle="tab" aria-expanded="false">Ürün</a></li>
  <li role="presentation" class=""><a href="#forms" id="forms-tab" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false">Formlar</a></li>
  <li role="presentation" class=""><a href="#payments" id="payments-tab" aria-controls="payments" role="tab" data-toggle="tab" aria-expanded="false">Ödemeler</a></li>
  <li role="presentation" class=""><a href="#person" id="person-tab" aria-controls="person" role="tab" data-toggle="tab" aria-expanded="false">Personel</a></li>
  <li role="presentation" class=""><a href="#mail" id="mail-tab" aria-controls="mail" role="tab" data-toggle="tab" aria-expanded="false">Mail</a></li>
</ul>


<!-- Tab panes -->
<div class="tab-content">

	<!--/ General /-->
  <div role="tabpanel" class="tab-pane fade in active" id="general" aria-labelledby="general-tab">
  	<?php
  		if ( isset($_POST['company']) ) {
  			if ( update_option('company', json_encode_utf8($_POST['company'])) ) {
          add_alert('Firma Bilgileri Güncellendi!', 'success', 'company');
  			}
  		}

  		$_company = get_option('company');
  		if ( empty($_company) ) {$_company = (object) array('name' => '', 'address' => '', 'district' => '', 'city' => '', 'country' => '', 'email' => '', 'phone' => '', 'gsm' => ''); }
  	?>

		<form action="#general" method="post" autocomplete="off">
			<div class="form-group">
  			<div class="row">
  				<div class="col-md-7">
  					<?php print_alert('company'); ?>
  				</div><!--/ .col-md-5 /-->
  			</div><!--/ .row /-->
  		</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="company[name]">Şirket Adı</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="company[name]" id="company[name]" value="<?php echo $_company->name; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="company[email]">Şirket E-Posta</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="company[email]" id="company[email]" value="<?php echo $_company->email; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="company[phone]">Şirket Telefon</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="company[phone]" id="company[phone]" value="<?php echo $_company->phone; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="company[gsm]">Şirket GSM</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="company[gsm]" id="company[gsm]" value="<?php echo $_company->gsm; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="company[address]">Adress</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="company[address]" id="company[address]" value="<?php echo $_company->address; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="company[district]">İlçe</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="company[district]" id="company[district]" value="<?php echo $_company->district; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="company[city]">Şehir</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="company[city]" id="company[city]" value="<?php echo $_company->city; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="company[country]">Ülke</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="company[country]" id="company[country]" value="<?php echo $_company->country; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-grouo">
				<div class="row">
					<div class="col-md-7">
						<button type="submit" class="btn btn-primary pull-right">Kaydet</button>
					</div><!--/ .col-md-7 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->
		</form>

  </div><!--/ .tab-panel /-->
  <!--/ General /-->


  <div role="tabpanel" class="tab-pane" id="accounts" aria-labelledby="accounts-tab">

  		<!--/ Acoount /-->

  </div><!--/ .tab-panel /-->


  <div role="tabpanel" class="tab-pane" id="product" aria-labelledby="product-tab">

  		<!--/ Product /-->

  </div><!--/ .tab-panel /-->



  <div role="tabpanel" class="tab-pane" id="forms" aria-labelledby="forms-tab">

  		<!--/ Forms /-->

  </div><!--/ .tab-panel /-->



  <div role="tabpanel" class="tab-pane" id="payments" aria-labelledby="payments-tab">

  		<!--/ Payments /-->

  </div><!--/ .tab-panel /-->



  <div role="tabpanel" class="tab-pane" id="person" aria-labelledby="person-tab">

  		<!--/ Person /-->

  </div><!--/ .tab-panel /-->



  <div role="tabpanel" class="tab-pane" id="mail" aria-labelledby="mail-tab">
  	<?php
  		if ( isset($_POST['mail']) ) {
  			if ( update_option('mail', json_encode_utf8($_POST['mail'])) ) {
  				add_alert('Mail Ayarları Güncellendi.', 'success', 'mail');
  			}
  		}

  		$_mail = get_option('mail');
  		if ( empty($_mail) ) { $_mail = (object) array('send_address' => '', 'host' => '', 'port' => '', 'password' => ''); }
  	?>

  	<form action="#accounts" method="post" autocomplete="off">
  		<div class="form-group">
  			<div class="row">
  				<div class="col-md-7">
  					<?php print_alert('mail'); ?>
  				</div><!--/ .col-md-5 /-->
  			</div><!--/ .row /-->
  		</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
						<div class="col-md-2">
						<label for="mail[send_address]">Gönderen E-Posta</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="mail[send_address]" id="mail[send_address]" value="<?php echo $_mail->send_address; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
						<div class="col-md-2">
						<label for="mail[host]">Mail Sunucusu</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="mail[host]" id="mail[host]" value="<?php echo $_mail->host; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
						<div class="col-md-2">
						<label for="mail[port]">Port</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="mail[port]" id="mail[port]" value="<?php echo $_mail->port; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-group">
				<div class="row">
						<div class="col-md-2">
						<label for="mail[password]">Şifre</label>
					</div><!--/ .col-md-2 /-->

					<div class="col-md-5">
						<input type="text" name="mail[password]" id="mail[password]" value="<?php echo $_mail->password; ?>" class="form-control">
					</div><!--/ .col-md-5 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="form-grouo">
				<div class="row">
					<div class="col-md-7">
						<button type="submit" class="btn btn-primary pull-right">Kaydet</button>
					</div><!--/ .col-md-7 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

		</form>

  </div><!--/ .tab-panel /-->
</div><!--/ .tab-content /-->
<?php get_footer(); ?>
