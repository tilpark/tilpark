<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<?php
// Header Bilgisi
$breadcrumb[0] = array('name'=>'Ürün Yönetimi', 'url'=>get_site_url('content/products/'));
$breadcrumb[1] = array('name'=>'Yeni Ürün Kartı', 'url'=>'', 'active'=>true);
?>



<ul id="myTabs" class="nav nav-tabs bordered" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false"><i class="fa fa-cube"></i> Yeni Ürün Kartı</a></li> 
</ul>


<div id="myTabContent" class="tab-content"> 
<!--TAB HOME --> <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab"> 

<form name="form_add" id="form_add" action="" method="POST" class="validation">
	<div class="row">
		<div class="col-md-6">


			<?php
			if(isset($_POST['add_product']) and !is_uniquetime())
			{
				$product['code'] 				= form_validation($_POST['code'], 'Stok Kodu', 'min_length[3]|max_length[32]');
				$product['name'] 				= form_validation($_POST['name'], 'Stok Adı', 'required|min_length[3]|max_length[32]');
				$product['p_purchase'] 			= form_validation($_POST['p_purchase'], 'Maliyet Fiyatı', 'money|max_length[10]');
				$product['p_sale']		 		= form_validation($_POST['p_sale'], 'Satış Fiyatı', 'money|max_length[10]');
				$product['tax_rate'] 			= form_validation($_POST['tax_rate'], 'Kdv Oranı', 'number|max_length[2]');
				$product['description'] 		= form_validation($_POST['description'], 'Açıklama', 'max_length[1000]');


				if(!is_alert('form')){ 
					$insert_id = add_product($product); 

					// yeni urun karti ekleme kutusu secilmemis ise urun sayfasina yonlendir.
					if(!isset($_POST['is_new_form']))
					{
						header("Location: ".get_url_product($insert_id));
					}

				}
			}
			alert();
			?>

			<div class="form-group">
			  	<label class="control-label" for="code">Stok Kodu</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="32" name="code" id="code" placeholder="Stok Kodu">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="form-group">
			  	<label class="control-label" for="name">Ürün/Hizmet Adı</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control required" minlength="3" maxlength="32" name="name" id="name" placeholder="Ürün/hizmet adı">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
					  	<label class="control-label" for="p_purchase">Maliyet Fiyatı</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-try"></i></span>
					    	<input type="text" class="form-control numbersOnly number" maxlength="10" name="p_purchase" id="p_purchase" placeholder="0.00" value="" onkeyup="calc_tax();">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-5 -->
				<div class="col-md-5">
					<div class="form-group">
					  	<label class="control-label" for="p_sale">Satış Fiyatı</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-try"></i></span>
					    	<input type="text" class="form-control numbersOnly number" maxlength="10" name="p_sale" id="p_sale" placeholder="0.00" value="" onkeyup="calc_tax();">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-5 -->
				<div class="col-md-2">
					<div class="form-group">
					  	<label class="control-label" for="tax_rate">KDV (%)</label>
					    <input type="text" class="form-control digits digitsOnly" name="tax_rate" id="tax_rate" placeholder="%0" onkeyup="calc_tax();">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-2 -->
			</div> <!-- /.row -->

			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
					  	<label class="control-label" for="p_purchase_out_tax">Maliyet Fiyatı <small>(KDV Hariç)</small></label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-try"></i></span>
					    	<input type="text" class="form-control numbersOnly number" name="p_purchase_out_tax" id="p_purchase_out_tax" placeholder="0.00" onkeyup="calc_tax();" readonly>
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-5 -->
				<div class="col-md-5">
					<div class="form-group">
					  	<label class="control-label" for="p_sale_out_tax">Satış Fiyatı <small>(KDV Hariç)</small></label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-try"></i></span>
					    	<input type="text" class="form-control numbersOnly number" name="p_sale_out_tax" id="p_sale_out_tax" placeholder="0.00" onkeyup="calc_tax();" readonly>
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-5 -->
				<div class="col-md-2">
					
				</div> 
			</div> <!-- /.row -->

			<div class="form-group">
			  	<label class="control-label" for="description">Açıklama</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
			    	<textarea class="form-control" name="description" id="description" maxlength="1000" placeholder="Ürün hakkında özet açıklama, detaylandırma"></textarea>
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->


			<div class="form-group text-right">
				<input type="hidden" name="add_product">
				<?php uniquetime(); ?>
				<button class="btn btn-default"><i class="fa fa-save"></i> Kaydet</button>
			</div> <!-- /.form-group -->



			<script>
			function calc_tax()
			{
				var price_purchase = $('#p_purchase').val();
				var price_sale = $('#p_sale').val();
				var tax_rate = $('#tax_rate').val();

				// degeler numeric mi? degil mi?
				if(!$.isNumeric(price_purchase)){ price_purchase = 0.00; }
				if(!$.isNumeric(price_sale)){ price_sale = 0.00; }

				var math_tax_rate = '';
				if(tax_rate.length == 2){ math_tax_rate =  parseFloat('0.'+tax_rate); }
				else { math_tax_rate = parseFloat('0.'+'0'+tax_rate); }

				var tax_purchase = parseFloat(price_purchase) * math_tax_rate;
				var tax_sale = parseFloat(price_sale) * math_tax_rate;
				
				var p_purchase_out_tax 	= parseFloat(price_purchase - tax_purchase).toFixed(<?php echo _fixed; ?>);
				var p_sale_out_tax		= parseFloat(price_sale - tax_sale).toFixed(<?php echo _fixed; ?>);

				$('#p_purchase_out_tax').val(p_purchase_out_tax);
				$('#p_sale_out_tax').val(p_sale_out_tax);
			}
			</script>


		</div> <!-- /.col-md-6 -->
		<div class="col-md-6">
			<label>&nbsp;</label>

			<label>
				<input type="checkbox" name="is_new_form" value="1" <?php if(isset($_POST['is_new_form'])): ?>checked<?php endif; ?>> Kaydettiken sonra yeni ürün kartı
				<br /><small class="text-muted">Bu kutuyu işaretlerseniz, ürün kartını oluşturduktan sonra, yeni bir ürün kartı oluşturma ekranı karşınıza çıkacaktır. Kutu seçili olmaz ise oluşturulan ürün kartının detay sayfasına yönlendirileceksiniz.</small>
			</label>

			<div class="h20"></div>

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-question-circle"></i> Yeni stok kartı oluştururken</div>
				<div class="panel-body">
					<ul class="text-muted fs-12">
						<li>Sol taraftaki menüden yeni stok kartı oluşurabilirsiniz.</li>
						<li>Stok kartı ürün/hizmet elle tutulur veya elle tutulmaz bir ürün olabilir.	<ul>Örnek: (ayakkabı, gömlek, klavye, mouse, web tasarım hizmeti, teknik servis hizmeti, tasarım hizmeti vb...)</ul></li>
						<li>Stok adet kutusunu görmemeniz normaldir. Çünkü stok oluşması için stok girişi yapmalısınız.</li>
					</ul>
				</div> <!-- /.panel-body -->
			</div> <!-- /.panel .panel-default -->

		</div> <!-- /.col-md-6 -->
	</div> <!-- /.row -->
</form>


<script>$('#name').focus();</script>


<!--/TAB HOME --> </div> <!-- /#home -->
</div> <!-- /.tab-content -->


<?php get_footer(); ?>