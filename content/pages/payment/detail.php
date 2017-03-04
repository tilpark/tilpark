<?php get_header(); ?>
<?php
if(@$payment->account_id) { calc_account($payment->account_id); $account = get_account($payment->account_id); }



if(empty($payment->id)) {
	$payment->id = 0;
	$payment->date = date('Y-m-d H:i:s');

	if(isset($_GET['in'])) { $payment->in_out = '0'; } 
	elseif(isset($_GET['out'])) { $payment->in_out = '1'; }
}



// in_out control
if($payment->in_out != '0' and $payment->in_out != '1') {
	echo get_alert('Giriş çıkış türü yanlış.', 'warning', false);
	get_footer();
	exit; 
}


// kasa ve banka hesapları
$cases = get_case_all(array('where'=>array('is_bank'=>0, 'orderby'=>'name ASC')));
$banks = get_case_all(array('where'=>array('is_bank'=>1, 'orderby'=>'name ASC')));



add_page_info( 'title', 'Yeni Ödeme - '.get_in_out_label($payment->in_out) );
add_page_info( 'nav', array('name'=>'Ödemeler', 'url'=>get_site_url('admin/payment')) );
add_page_info( 'nav', array('name'=>'Yeni Ödeme - '.get_in_out_label($payment->in_out)) );
?>


<?php
if(isset($_POST['payment'])) {
	if($payment_id = set_payment($_POST)) {
		// eger ilk defa form olusyor ise yonlendirme yapalim
		if(empty($payment->id)) { header("Location:?id=".$payment_id); }
	} 
}

print_alert('set_payment');
?>



<?php if($cases or $banks): // kasa veya banka var mi? ?>



	<?php
	if(isset($_GET['account_id'])) {
		if( $account = get_account($_GET['account_id']) ) {
			$payment->account_id 	= $account->id;
			$payment->account_tax_no = $account->tax_no;
			$payment->account_tax_home = $account->tax_home;
			$payment->account_code 	= $account->code;
			$payment->account_name 	= $account->name;
			$payment->account_gsm 	= $account->gsm;
			$payment->account_phone = $account->phone;
			$payment->account_email = $account->email;
			$payment->account_district 	= $account->district;
			$payment->account_city 		= $account->city;
			$payment->account_country 	= $account->country;
		} else { add_alert('Hesap kartı bulunamadı.', 'warning'); }
	}
	?>




<ul class="nav nav-tabs" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-file-text-o"></i> Form</a></li> 
	<?php if($payment->id): ?>
		<li role="presentation" class="disabled"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false"><i class="fa fa-list"></i> Formlar</a></li> 
		<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="false"><i class="fa fa-database"></i> Geçmiş</a></li> 
		<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-cogs"></i> Seçenekler <span class="caret"></span></a> 
			<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
				<li><a href="#dropdown1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1"><i class="fa fa-tasks fa-fw"></i> Görev Ata</a></li> 
				<li><a href="<?php site_url('admin/user/message/add.php?attachment&payment_id='.$payment->id); ?>"><i class="fa fa-envelope-o fa-fw"></i> Mesaj Ekine Ekle</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="print.php?id=<?php echo $payment->id; ?>&print" target="_blank"><i class="fa fa-print fa-fw"></i> Yazdır</a></li>
				<li><a href="print.php?id=<?php echo $payment->id; ?>" target="_blank"><i class="fa fa-file-o fa-fw"></i> Baskı Önizleme</a></li>
			</ul> 
		</li>
		<?php if($payment->id): ?><li class="pull-right"><a href="print.php?id=<?php echo $payment->id; ?>&print" target="_blank"><i class="fa fa-print"></i> Yazdır</a></li><?php endif; ?>
	<?php endif; ?>
</ul>






<div class="tab-content"> 
	<div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab"> 
		
		<form name="form_payment" id="form_payment" action="" method="POST">

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="blank">Blank </label>
						<input type="text" name="blank" id="blank" value="<?php echo @$payment->account_code; ?>" class="form-control input-sm" minlength="3" maxlength="32">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="date"><i class="fa fa-calendar"></i> Tarih </label>
						<input type="text" name="date" id="date" value="<?php echo @substr($payment->date,0,16); ?>" class="form-control input-sm datetime" >
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-2"></div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="account_tax_home">Vergi Dairesi </label>
						<input type="text" name="account_tax_home" id="account_tax_home" value="<?php echo @$payment->account_tax_home; ?>" class="form-control input-sm" minlength="3" maxlength="32">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-2 -->
				<div class="col-md-2">
					<div class="form-group">
						<label for="account_tax_no">Vergi No veya T.C. </label>
						<input type="text" name="account_tax_no" id="account_tax_no" value="<?php echo @$payment->account_tax_no; ?>" class="form-control input-sm" minlength="3" maxlength="32">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-2 -->
			</div> <!-- /.row -->

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="account_code"><i class="fa fa-barcode"></i> Hesap Kodu </label>
						<input type="text" name="account_code" id="account_code" value="<?php echo @$payment->account_code; ?>" class="form-control input-sm focus" minlength="3" maxlength="32">
						
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="account_name">Hesap Adı <?php if(@$payment->account_id):?><a href="../account/detail.php?id=<?php echo $payment->account_id; ?>" target="_blank"><i class="fa fa-external-link"></i></a><?php endif; ?> </label>
						
							<!-- yeni hesap karti olusturulsun mu? -->
							<label id="new_account" class="pull-right" data-toggle="tooltip" data-placement="top" title="" data-original-title="Yeni bir hesap kartı oluşturulsun mu?"><input type="checkbox" name="new_account" id="new_account" value="true" class="toogle" data-size="extramini" data-on-text="Evet" data-off-text="Hayır" tabindex="-1"></label>

						<input type="text" name="account_name" id="account_name" value="<?php echo @$payment->account_name; ?>" class="form-control input-sm" minlength="3" maxlength="32">
						
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-2">
					<div class="form-group">
						<label for="account_gsm">Cep Telefonu </label>
						<input type="text" name="account_gsm" id="account_gsm" value="<?php echo @$payment->account_gsm; ?>" class="form-control input-sm" minlength="3" maxlength="32">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-2 -->
				<div class="col-md-2">
					<div class="form-group">
						<label for="account_phone">Sabit Telefonu </label>
						<input type="text" name="account_phone" id="account_phone" value="<?php echo @$payment->account_phone; ?>" class="form-control input-sm" minlength="3" maxlength="32">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-2">
					<div class="form-group">
						<label for="account_email">E-Posta </label>
						<input type="text" name="account_email" id="account_email" value="<?php echo @$payment->account_email; ?>" class="form-control input-sm email">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->

				<div class="clearfix"></div>


				<div class="col-md-6">
					<div class="form-group">
						<label for="account_address">Adres </label>
						<input type="text" name="account_address" id="account_address" value="<?php echo @$payment->account_address; ?>" class="form-control input-sm">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
				<div class="col-md-2">
					<div class="form-group">
						<label for="account_district">İlçe </label>
						<input type="text" name="account_district" id="account_district" value="<?php echo @$payment->account_district; ?>" class="form-control input-sm">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-2 -->
				<div class="col-md-2">
					<div class="form-group">
						<label for="account_city">Şehir </label>
						<input type="text" name="account_city" id="account_city" value="<?php echo @$payment->account_city; ?>" class="form-control input-sm">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-2 -->
				<div class="col-md-2">
					<div class="form-group country_selected">
						<label for="account_country">Ülke </label>
						<?php echo list_selectbox(get_country_array(), array('name'=>'account_country', 'selected'=>'Turkey', 'class'=>'form-control select select-account input-sm')); ?>
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-2 -->	
				
			</div> <!-- /.row -->


			<script>
			$(document).ready(function() {

				var json_url = '<?php site_url("admin/account/getJSON.php"); ?>';
				var item = { 
					name:'<span class="account_name">[TEXT]</span>', 
					gsm:'<span class="pull-right text-muted">[TEXT]</span>',
					"br":"<br />", 
					tax_no:'<span class="text-muted">[TEXT]</span>', 
					city:'<span class="account_city pull-right">[TEXT]</span>'}

				input_getJSON_account('#account_code', 'account', item, json_url, 'code');	
				input_getJSON_account('#account_name', 'account', item, json_url, 'name');

				var item = { "name":'<span class="account_name">[TEXT]</span>', "br":"<br /> &nbsp;", "gsm":'<span class="pull-right text-muted">[TEXT]</span>'}	
				input_getJSON_account('#account_gsm', 'account', item, json_url, 'gsm');	

				var item = { "name":'<span class="account_name">[TEXT]</span>', "br":"<br /> &nbsp;", "phone":'<span class="pull-right text-muted">[TEXT]</span>'}	
				input_getJSON_account('#account_phone', 'account', item, json_url, 'phone');	

				var item = { "name":'<span class="account_name">[TEXT]</span>', "br":"<br /> &nbsp;", "email":'<span class="pull-right text-muted">[TEXT]</span>'}	
				input_getJSON_account('#account_email', 'account', item, json_url, 'email');	

				var item = { "name":'<span class="account_name">[TEXT]</span>', "br":"<br /> &nbsp;", "tax_no":'<span class="pull-right text-muted">[TEXT]</span>'}	
				input_getJSON_account('#account_tax_no', 'account', item, json_url, 'tax_no');	

				
				// eger hesap kodu degisiyor ise gizli inputta kalan account_id sıfırlayalim
				$('#account_code').change(function() {
					$('#account_id').val('');
					account_id_change($('#account_id').val());
				});

				// account_id degistiginde
				$('#account_id').change(function() {
					account_id_change($(this).val());
				});

				<?php if(@$payment->account_id): ?>
					account_id_change('x'); // eger form kayit edilmis ve form account_id var ise yeni hesap olusturma butonuna gizle
				<?php endif; ?>

			});



			function account_getJSON_click(param) {
				var id 		= $(param).attr('data-id');
				var code 	= $(param).attr('data-code');
				var name 	= $(param).attr('data-name');
				var gsm 	= $(param).attr('data-gsm');
				var phone 	= $(param).attr('data-phone');
				var email 	= $(param).attr('data-email');
				var tax_home 	= $(param).attr('data-tax_home');
				var tax_no 		= $(param).attr('data-tax_no');
				var address 	= $(param).attr('data-address');
				var district 	= $(param).attr('data-district');
				var city 		= $(param).attr('data-city');
				var country 	= $(param).attr('data-country');
				var balance 	= $(param).attr('data-balance');
				
				$('#account_id').val(id);
				$('#account_code').val(code);
				$('#account_name').val(name);
				$('#account_gsm').val(gsm);
				$('#account_phone').val(phone);
				$('#account_email').val(email);
				$('#account_tax_home').val(tax_home);
				$('#account_tax_no').val(tax_no);
				$('#account_address').val(address);
				$('#account_district').val(district);
				$('#account_city').val(city);
				$('#account_gsm').val(gsm);
				$('#account_country').val(country);
				$('#old_balance').val(balance);
				$('#old_balance_hidden').val(balance);

				// country
				$('.select-account').val(country);
				$('.select-account').change();

				account_id_change($('#account_id').val());

				$('#payment').focus();


			}

			function account_id_change(val) {
				if(val == '') {
					$('#new_account').show();
				} else {
					$('#new_account').hide();
				}
			}


			</script>


			<div class="clearfix"></div>

			<hr />


			<?php
			if(@$account) {
				if($account->balance < 0) {
					if($payment->in_out == 1) {
						$old_balance = $account->balance - @$payment->total;
					} else {
						$old_balance = $account->balance + @$payment->total;
					}
					
				} else {
					if($payment->in_out == 1) {
						$old_balance = $account->balance - @$payment->total;
					} else {
						$old_balance = $account->balance + @$payment->total;
					}
				}
				
			} else {
				$old_balance = 0;
			}
			?>

			

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="status_id">Kasa veya Banka</label>
						<?php if($cases or $banks): ?>
							<select name="status_id" id="status_id" class="form-control select">
								<optgroup label="Kasalar">
									<?php foreach($cases as $case): ?>
								    	<option value="<?php echo $case->id; ?>" <?php selected($case->id, @$payment->status_id); ?>><?php echo $case->name; ?></option>
								    <?php endforeach; ?>
								</optgroup>
								<optgroup label="Bankalar">
									<?php foreach($banks as $bank): ?>
								    	<option value="<?php echo $bank->id; ?>" <?php selected($bank->id, @$payment->status_id); ?>><?php echo $bank->name; ?></option>
								    <?php endforeach; ?>
								</optgroup>
							</select>

						<?php else: ?>
							<?php echo get_alert('Kasa veya Banka bulunamadı.', 'warning', false); ?>
						<?php endif; ?>
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="payment_type">Ödeme Türü</label>
						<select name="payment_type" id="payment_type" class="form-control select">
							<option value="nakit">Nakit</option>
							<option value="kk">Kredi Kartı</option>
							<option value="cek">Banka Çeki</option>
							<option value="senet">Senet</option>
						</select>
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-2">
					<div class="form-group">
						<label for="old_balance">Eski Bakiye</label>
						<input type="text" name="old_balance" id="old_balance" class="form-control text-right money" value="<?php echo get_set_money($old_balance); ?>" readonly>
						<!-- javascript ile hesaplama yapılırken negatif sayılarda hatalıyoruz, cunku .money fonksiyonu degerleri bozuyor, bunun icin gizli bir oge ekledik -->
						<input type="hidden" name="old_balance_hidden" id="old_balance_hidden" value="<?php echo @$old_balance; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-2">
					<div class="form-group">
						<label for="payment">Ödeme Tutarı</label>
						<input type="text" name="payment" id="payment" class="form-control text-right money" value="<?php echo @$payment->total; ?>" onkeyup="calc_payment();">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-2">
					<div class="form-group">
						<label for="new_balance">Yeni Bakiye</label>
						<input type="text" name="new_balance" id="new_balance" class="form-control text-right money">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
			</div> <!-- /.row -->


			<script>


			function calc_payment() {

				var old_balance = parseFloat($('#old_balance_hidden').val());
				var payment 	= parseFloat($('#payment').val());
				var new_balance = 0;

				<?php if($payment->in_out == 1): ?> 

					if(old_balance < 0) {
						new_balance = old_balance + payment;
					} else {
						new_balance = old_balance + payment;
					}

				<?php else: ?> 

					if(old_balance < 0) {
						new_balance = old_balance - payment;
					} else {
						new_balance = old_balance - payment;
					}
					
				<?php endif; ?>
				$('#new_balance').val(new_balance);
			}
			$(document).ready(function() {
				calc_payment();
			});
			

			</script>


			<div class="text-right">
				<input type="hidden" name="in_out" value="<?php echo @$payment->in_out; ?>">
				<input type="hidden" name="account_id" id="account_id" value="<?php echo @$payment->account_id; ?>">
				<input type="hidden" name="form">
				<input type="hidden" name="uniquetime" value="<?php echo uniquetime(); ?>">
				<button class="btn btn-default">Kaydet</button>
			</div>

		</form>
	</div> <!-- /#home -->
					
	<div class="tab-pane fade" role="tabpanel" id="profile" aria-labelledby="profile-tab"> 
		<p>Food <a href="#" onclick="getJSON_click();">truck</a> fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p> 
	</div> 
	<div class="tab-pane fade" role="tabpanel" id="logs" aria-labelledby="logs-tab"> 
		<?php theme_get_logs(" table_id='forms:".$payment->id."' "); ?>
	</div> 
	<div class="tab-pane fade" role="tabpanel" id="dropdown1" aria-labelledby="dropdown1-tab"> 
		<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p> 
	</div> 
	<div class="tab-pane fade" role="tabpanel" id="dropdown2" aria-labelledby="dropdown2-tab"> 
		<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p> 
	</div> 
</div> <!-- /.tab-content -->




<?php else: ?>
	<?php echo get_alert('<b>Kasa/Banka hesabı bulunamadı. Ödeme alıp verebilmeniz için bir kasa/banka oluşturmanız gerekiyor. Kasa veya Banka hesabı oluşturmak için <a href="'.get_site_url('admin/system/case/index.php').'" class="bold" title="Kasa veya banka hesabı oluşturabilir veya eski hesapları düzenleyebilirsiniz.">buraya</a> tıklayınız.', 'warning', false); ?>
<?php endif; ?>

<? get_footer(); ?>

