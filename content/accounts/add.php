<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<?php
// Header Bilgisi
$breadcrumb[0] = array('name'=>'Hesap Yönetimi', 'url'=>get_site_url('content/accounts/'));
$breadcrumb[1] = array('name'=>'Yeni Hesap Kartı', 'url'=>'', 'active'=>true);
?>



<ul id="myTabs" class="nav nav-tabs bordered" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false"><i class="fa fa-cube"></i> Yeni Hesap Kartı</a></li> 
</ul>


<div id="myTabContent" class="tab-content"> 
<!--TAB HOME --> <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab"> 

<form name="form_add" id="form_add" action="" method="POST" class="validation">
	<div class="row">
		<div class="col-md-6">

			<?php
			if(isset($_POST['add_account']) and !is_uniquetime())
			{
				$account['code'] 				= form_validation($_POST['code'], 'Barkod Kodu', 'min_length[3]|max_length[32]');
				$account['name'] 				= form_validation($_POST['name'], 'Hesap Adı', 'required|min_length[3]|max_length[32]');
				$account['personnel_name'] 		= form_validation($_POST['personnel_name'], 'Yetkili Adı Soyadı', 'min_length[3]|max_length[20]');
				$account['gsm'] 				= form_validation($_POST['gsm'], 'Cep Telefonu', 'number|min_length[10]|max_length[11]');
				$account['phone'] 				= form_validation($_POST['phone'], 'Sabit Telefon', 'number|min_length[10]|max_length[11]');
				$account['address'] 			= form_validation($_POST['address'], 'Adres', 'min_length[3]|max_length[255]');
				$account['city'] 				= form_validation($_POST['city'], 'Şehir', 'min_length[3]|max_length[20]');
				$account['district'] 			= form_validation($_POST['district'], 'İlçe', 'min_length[3]|max_length[20]');


				// eger yukaridaki formlarda bir hata olusmamis ise yeni hesap kartini olustur
				if(!is_alert('form')) {	
					$account_id = add_account($account); 

					// yeni urun karti ekleme kutusu secilmemis ise urun sayfasina yonlendir.
					if(!isset($_POST['is_new_form']))
					{
						header("Location: ".get_url_account($account_id));
					}
				}
			}
			alert();
			?>

			<div class="form-group">
			  	<label class="control-label" for="code">Hesap Kodu <small class="text-muted"><i>(boş bırakılırsa otomatik oluşacaktır)</i></small></label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="32" name="code" id="code">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="form-group">
			  	<label class="control-label" for="name">Hesap/Firma Adı</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control required" minlength="3" maxlength="32" name="name" id="name">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="form-group">
			  	<label class="control-label" for="personnel_name">Yetkili Adı Soyadı</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="32" name="personnel_name" id="personnel_name" placeholder="">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					  	<label class="control-label" for="gsm">Cep Telefonu</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
					    	<input type="text" class="form-control digits digitsOnly" minlength="10" maxlength="11" name="gsm" id="gsm" placeholder="">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
				<div class="col-md-6">
					<div class="form-group">
					  	<label class="control-label" for="phone">Sabit Telefon</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-phone"></i></span>
					    	<input type="text" class="form-control digits digitsOnly" minlength="10" maxlength="11" name="phone" id="phone" placeholder="">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
			</div> <!-- /.row -->

			<div class="form-group">
			  	<label class="control-label" for="address">Adres</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
			    	<textarea class="form-control" name="address" id="address" minlength="3" maxlength="255" placeholder=""></textarea>
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					  	<label class="control-label" for="city">Şehir</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
					    	<input type="text" class="form-control" minlength="3" maxlength="20" name="city" id="city">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
				<div class="col-md-6">
					<div class="form-group">
					  	<label class="control-label" for="district">İlçe</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
					    	<input type="text" class="form-control" minlength="3" maxlength="20" name="district" id="district">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
			</div> <!-- /.row -->


			<div class="form-group text-right">
				<input type="hidden" name="add_account">
				<?php uniquetime(); ?>
				<button class="btn btn-default"><i class="fa fa-save"></i> Kaydet</button>
			</div> <!-- /.form-group -->
			


		</div> <!-- /.col-md-6 -->
		<div class="col-md-6">
			<label>&nbsp;</label>
			
			<label>
				<input type="checkbox" name="is_new_form" value="1" <?php if(isset($_POST['is_new_form'])): ?>checked<?php endif; ?>> Kaydettiken sonra yeni hesap kartı
				<br /><small class="text-muted">Bu kutuyu işaretlerseniz, hesap kartını oluşturduktan sonra, yeni bir hesap kartı oluşturma ekranı karşınıza çıkacaktır. Kutu seçili olmaz ise oluşturulan hesap kartının detay sayfasına yönlendirileceksiniz.</small>
			</label>

		</div> <!-- /.col-md-6 -->
	</div> <!-- /.row -->


</form>
<script>$('#name').focus();</script>


<!--/TAB HOME --> </div> <!-- /#home -->
</div> <!-- /.tab-content -->

<?php get_footer(); ?>