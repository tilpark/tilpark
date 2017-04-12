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
  <li role="presentation" class=""><a href="#items" id="items-tab" aria-controls="items" role="tab" data-toggle="tab" aria-expanded="false">Ürün</a></li>
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
  		<?php
	  		if ( isset($_POST['account_print_barcode']) ) {
	  			if ( update_option('account_print_barcode', json_encode_utf8($_POST['account_print_barcode'])) ) {
	          		add_alert('Ayarlar kayıt edildi.', 'success', 'company');
	  			}

	  			update_option('account_print_address', json_encode_utf8($_POST['account_print_address']));
	  			update_option('account_print_cargo', json_encode_utf8($_POST['account_print_cargo']));
	  		}

	  		$account_print_barcode 	= get_option('account_print_barcode');
	  		$account_print_address 	= get_option('account_print_address');
	  		$account_print_cargo 	= get_option('account_print_cargo');
	  	?>

		<form action="#accounts" method="post" autocomplete="off">
			<div class="form-group">
	  			<div class="row">
	  				<div class="col-md-7">
	  					<?php print_alert('company'); ?>
	  				</div><!--/ .col-md-5 /-->
	  			</div><!--/ .row /-->
	  		</div><!--/ .form-group /-->

	  		<h4 class="module-title">Barkod <small class="text-muted block fs-12 mt-5">hesap kartları için sadece barkod yazdırma boyutları, genellikle barkod yazıcıları tercih edilir. <br /> Ölçüleri Milimetre (mm) biriminde giriniz.</small></h4>
			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="account_print_barcode-width">Genişlik ve Uzunlık <small>(mm)</small></label>
						<input type="hidden" name="account_print_address[unit]" value="mm">
					</div><!--/ .col-md-2 /-->

					<div class="col-md-2">
						<input type="number" name="account_print_barcode[width]" id="account_print_barcode-width" value="<?php echo $account_print_barcode->width; ?>" class="form-control digits">
					</div><!--/ .col-* /-->

					<div class="col-md-2">
						<input type="number" name="account_print_barcode[height]" id="account_print_barcode-height" value="<?php echo $account_print_barcode->height; ?>" class="form-control digits">
					</div><!--/ .col-* /-->

				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="h-20"></div>
			<h4 class="module-title">Adres Kartı <small class="text-muted block fs-12 mt-5">hesap kartları için adres kartı yazdırma boyutları, genellikle barkod yazıcıları tercih edilir. <br /> Ölçüleri Milimetre (mm) biriminde giriniz.</small></h4>
			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="account_print_address-width">Genişlik ve Uzunlık <small>(mm)</small></label>
						<input type="hidden" name="account_print_address[unit]" value="mm">
					</div><!--/ .col-md-2 /-->

					<div class="col-md-2">
						<input type="number" name="account_print_address[width]" id="account_print_address-width" value="<?php echo $account_print_address->width; ?>" class="form-control digits">
					</div><!--/ .col-* /-->

					<div class="col-md-2">
						<input type="number" name="account_print_address[height]" id="account_print_address-height" value="<?php echo $account_print_address->height; ?>" class="form-control digits">
					</div><!--/ .col-* /-->

				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="h-20"></div>
			<h4 class="module-title">Kargo Barkodu <small class="text-muted block fs-12 mt-5">hesap kartları için kargo barkodu yazdırma boyutları, genellikle barkod yazıcıları tercih edilir. <br /> Ölçüleri Milimetre (mm) biriminde giriniz.</small></h4>
			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="account_address_print_width">Genişlik ve Uzunlık <small>(mm)</small></label>
						<input type="hidden" name="account_print_cargo[unit]" value="mm">
					</div><!--/ .col-md-2 /-->

					<div class="col-md-2">
						<input type="number" name="account_print_cargo[width]" id="account_print_cargo-width" value="<?php echo $account_print_cargo->width; ?>" class="form-control digits">
					</div><!--/ .col-* /-->

					<div class="col-md-2">
						<input type="number" name="account_print_cargo[height]" id="account_print_cargo-height" value="<?php echo $account_print_cargo->height; ?>" class="form-control digits">
					</div><!--/ .col-* /-->

				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="h-20"></div>
			<div class="form-grouo">
				<div class="row">
					<div class="col-md-7">
						<input type="hidden" name="update_setting_account">
						<button type="submit" class="btn btn-success pull-left"><i class="fa fa-save"></i> Kaydet</button>
					</div><!--/ .col-md-7 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->
		</form>
  		<!--/ Acoount /-->

  </div><!--/ .tab-panel /-->


  <div role="tabpanel" class="tab-pane" id="items" aria-labelledby="items-tab">

  		<?php
	  		if ( isset($_POST['update_setting_item']) ) {
	  			if ( update_option('item_print_barcode', json_encode_utf8($_POST['item_print_barcode'])) ) {
	          		add_alert('Ayarlar kayıt edildi.', 'success', 'company');
	  			}

	  			update_option('item_print_barcode_price', json_encode_utf8($_POST['item_print_barcode_price']));
	  		}

	  		$item_print_barcode 	= get_option('item_print_barcode');
	  		$item_print_barcode_price 	= get_option('item_print_barcode_price');
	  	?>

		<form action="#items" method="post" autocomplete="off">
			<div class="form-group">
	  			<div class="row">
	  				<div class="col-md-7">
	  					<?php print_alert('company'); ?>
	  				</div><!--/ .col-md-5 /-->
	  			</div><!--/ .row /-->
	  		</div><!--/ .form-group /-->

	  		<h4 class="module-title">Barkod <small class="text-muted block fs-12 mt-5">ürün kartları için sadece barkod yazdırma boyutları, genellikle barkod yazıcıları tercih edilir. <br /> Ölçüleri Milimetre (mm) biriminde giriniz.</small></h4>
			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="item_print_barcode-width">Genişlik ve Uzunlık <small>(mm)</small></label>
						<input type="hidden" name="item_print_barcode[unit]" value="mm">
					</div><!--/ .col-md-2 /-->

					<div class="col-md-2">
						<input type="number" name="item_print_barcode[width]" id="item_print_barcode-width" value="<?php echo $item_print_barcode->width; ?>" class="form-control digits">
					</div><!--/ .col-* /-->

					<div class="col-md-2">
						<input type="number" name="item_print_barcode[height]" id="item_print_barcode-height" value="<?php echo $item_print_barcode->height; ?>" class="form-control digits">
					</div><!--/ .col-* /-->

				</div><!--/ .row /-->
			</div><!--/ .form-group /-->

			<div class="h-20"></div>
			<h4 class="module-title">Fiyatlı Barkod <small class="text-muted block fs-12 mt-5">ürün kartları için fiyatı ile birlikte barkod yazdırma boyutları, genellikle barkod yazıcıları tercih edilir. <br /> Ölçüleri Milimetre (mm) biriminde giriniz.</small></h4>
			<div class="form-group">
				<div class="row">
					<div class="col-md-2">
						<label for="item_print_barcode_price-width">Genişlik ve Uzunlık <small>(mm)</small></label>
						<input type="hidden" name="item_print_barcode_price[unit]" value="mm">
					</div><!--/ .col-md-2 /-->

					<div class="col-md-2">
						<input type="number" name="item_print_barcode_price[width]" id="item_print_barcode_price-width" value="<?php echo $item_print_barcode_price->width; ?>" class="form-control digits">
					</div><!--/ .col-* /-->

					<div class="col-md-2">
						<input type="number" name="item_print_barcode_price[height]" id="item_print_barcode_price-height" value="<?php echo $item_print_barcode_price->height; ?>" class="form-control digits">
					</div><!--/ .col-* /-->

				</div><!--/ .row /-->
			</div><!--/ .form-group /-->


			<div class="h-20"></div>
			<div class="form-grouo">
				<div class="row">
					<div class="col-md-7">
						<input type="hidden" name="update_setting_item">
						<button type="submit" class="btn btn-success pull-left"><i class="fa fa-save"></i> Kaydet</button>
					</div><!--/ .col-md-7 /-->
				</div><!--/ .row /-->
			</div><!--/ .form-group /-->
		</form>
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
