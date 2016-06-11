<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<?php $product = get_product($_GET['id']); ?>
<?php if($product): ?>

<?php
// Header Bilgisi
$til->page['title'] = 'Ürünler';
$til->page['subtitle'] = $product['name'];
$breadcrumb[] = array('name'=>'Ürün Yönetimi', 'url'=>get_site_url('content/products/'));
$breadcrumb[] = array('name'=>'Ürün Listesi', 'url'=>get_site_url('content/products/list.php'));
$breadcrumb[] = array('name'=>$product['name'], 'url'=>'', 'active'=>true);
?>





<ul id="myTabs" class="nav nav-tabs bordered" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false"><i class="fa fa-cube"></i> Ürün Yönetimi</a></li> 
	<li role="presentation" class=""><a href="#forms" role="tab" id="forms-tab" data-toggle="tab" aria-controls="forms" aria-expanded="true"><i class="fa fa-th-list"></i> Hareketler</a></li>
	<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="true"><i class="fa fa-clock-o"></i> Geçmiş</a></li>
	<li role="presentation" class="dropdown"> <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">Seçenekler <span class="caret"></span></a> 
		<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
			<li><a href="#dropdown1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1">Yazdır</a></li> 
			<li><a href="#dropdown2" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2">Görev Ataması</a></li> 
		</ul> 
	</li> 
	<li class="pull-right custom-buttons">
		<div class="btn-group btn-group pull-right" role="group" aria-label="...">
			  <button type="button" class="btn btn-default"><i class="fa fa-tasks"></i> Görev Ata</button>
			  <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Yazdır</button>
			  <button type="submit" class="btn btn-default" form="form_add"><i class="fa fa-save"></i> Kaydet</button>
			</div>
	</li>
</ul>


<div id="myTabContent" class="tab-content"> 
<!-- TAB HOME --> <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab"> 

<h3 class="row-module-title"><i class="fa fa-cube"></i> <?php echo $product['name']; ?></h3>

<form name="form_add" id="form_add" action="" method="POST" class="validationn">
	<div class="row">
		<div class="col-md-6">


			<?php
			if(isset($_POST['update_product']) and !is_uniquetime())
			{
				$product['id']					= $product['id'];
				$product['code'] 				= form_validation($_POST['code'], 'Ürün Kodu', 'min_length[3]|max_length[32]');
				$product['name'] 				= form_validation($_POST['name'], 'Ürün Adı', 'required|min_length[3]|max_length[32]');
				$product['p_purchase'] 			= form_validation($_POST['p_purchase'], 'Maliyet Fiyatı', 'money|max_length[10]');
				$product['p_sale']		 		= form_validation($_POST['p_sale'], 'Satış Fiyatı', 'money|max_length[10]');
				$product['tax_rate'] 			= form_validation($_POST['tax_rate'], 'Kdv Oranı', 'number|max_length[2]');
				$product['description'] 		= form_validation($_POST['description'], 'Açıklama', 'max_length[1000]');


				if(!is_alert('form')) 
				{
					if(update_product($product))
					{
						$product = get_product($product['id']);
					}
				}
			}
			alert();

			?>
			<div class="form-group">
			  	<label class="control-label" for="code">Ürün Kodu</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="32" name="code" id="code" placeholder="Ürün Kodu" value="<?php echo $product['code']; ?>">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="form-group">
			  	<label class="control-label" for="name">Ürün/Hizmet Adı</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control required" minlength="3" maxlength="32" name="name" id="name" placeholder="Ürün/hizmet adı"  value="<?php echo $product['name']; ?>">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
					  	<label class="control-label" for="p_purchase">Maliyet Fiyatı</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-try"></i></span>
					    	<input type="text" class="form-control numbersOnly number" maxlength="10" name="p_purchase" id="p_purchase" placeholder="0.00" value="<?php echo convert_money($product['p_purchase']); ?>" onkeyup="calc_tax();">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-5 -->
				<div class="col-md-5">
					<div class="form-group">
					  	<label class="control-label" for="p_sale">Satış Fiyatı</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-try"></i></span>
					    	<input type="text" class="form-control numbersOnly number" maxlength="10" name="p_sale" id="p_sale" placeholder="0.00" value="<?php echo convert_money($product['p_sale']); ?>" onkeyup="calc_tax();">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-5 -->
				<div class="col-md-2">
					<div class="form-group">
					  	<label class="control-label" for="tax_rate">KDV (%)</label>
					    <input type="text" class="form-control digits digitsOnly" name="tax_rate" id="tax_rate" placeholder="%0" onkeyup="calc_tax();" value="<?php echo $product['tax_rate']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-2 -->
			</div> <!-- /.row -->

			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
					  	<label class="control-label" for="p_purchase_out_tax">Maliyet Fiyatı <small>(KDV Hariç)</small></label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-try"></i></span>
					    	<input type="text" class="form-control numbersOnly number" name="p_purchase_out_tax" id="p_purchase_out_tax" placeholder="0.00" onkeyup="calc_tax();" readonly value="<?php echo convert_money($product['p_purchase_out_tax']); ?>">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-5 -->
				<div class="col-md-5">
					<div class="form-group">
					  	<label class="control-label" for="p_sale_out_tax">Satış Fiyatı <small>(KDV Hariç)</small></label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-try"></i></span>
					    	<input type="text" class="form-control numbersOnly number" name="p_sale_out_tax" id="p_sale_out_tax" placeholder="0.00" onkeyup="calc_tax();" readonly value="<?php echo convert_money($product['p_sale_out_tax']); ?>">
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
			    	<textarea class="form-control" name="description" id="description" maxlength="1000" placeholder="Ürün hakkında özet açıklama, detaylandırma"><?php echo $product['description']; ?></textarea>
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->


			<div class="form-group text-right">
				<input type="hidden" name="update_product">
				<?php uniquetime(); ?>
				<button class="btn btn-default"><i class="fa fa-save"></i> Kaydet</button>
			</div> <!-- /.form-group -->



			<script>
			function calc_tax()
			{
				var price_purchase = $('#price_purchase').val();
				var price_sale = $('#price_sale').val();
				var tax_rate = $('#tax_rate').val();

				// degeler numeric mi? degil mi?
				if(!$.isNumeric(price_purchase)){ price_purchase = 0.00; }
				if(!$.isNumeric(price_sale)){ price_sale = 0.00; }

				var math_tax_rate = '';
				if(tax_rate.length == 2){ math_tax_rate =  parseFloat('1.'+tax_rate); }
				else { math_tax_rate = parseFloat('1.'+'0'+tax_rate); }

				
				var p_purchase_out_tax 	= parseFloat(price_purchase / math_tax_rate).toFixed(<?php echo _fixed; ?>);
				var p_sale_out_tax		= parseFloat(price_sale / math_tax_rate).toFixed(<?php echo _fixed; ?>);

				$('#p_purchase_out_tax').val(p_purchase_out_tax);
				$('#p_sale_out_tax').val(p_sale_out_tax);
			}
			</script>


		</div> <!-- /.col-md-6 -->
		<div class="col-md-6">

			<style>
			/* stat-item */
			.stat-item {
				text-align:center;
				border-left: 1px solid #eee;
			}
			.stat-item .stat-title {
				display: block;
				font-size: 18px;
				color: #666666;
			}
			.stat-item .stat-desc {
				color: #555;
				font-size: 12px;
				font-weight: 300;
			}
			</style>
			<div class="panel panel-btn-group panel-default shadow-1">
			  <div class="panel-heading"><i class="fa fa-pie-chart"></i> Ürün Kartına Genel Bakış</div> <!-- /.panel-heading -->
			  <div class="panel-body">
			  	
			  	<div class="row">
			  		<div class="col-md-3">
						<div style="padding-top:50%; border-right:1px solid #ccc; height:200px;" class="text-center">
							<?php $profit_rate = @number_format((($product['p_sale_out_tax'] - $product['p_purchase_out_tax'])/$product['p_purchase_out_tax']) * 100, 0, '', ''); ?>
							<span class="fs-36 text-muted <?php if($profit_rate < 0) {echo 'text-danger';}elseif($profit_rate>0){echo 'text-success';} ?>">%<?php echo $profit_rate; ?></span>
							<br />
							<span class="text-muted"><?php if($profit_rate < 0) {echo 'zarar oranı';}else{echo 'kar oranı';} ?></span>
						</div>
					</div> <!-- /.col-md-3 -->
			  		<div class="col-md-9">

					  	<!-- stok raporu -->
					  	<h5><i class="fa fa-line-chart"></i> Genel stok raporu</h5>
					  	<div class="row">
					  		<div class="col-md-4">
					  			<div class="stat-item border-0">
					  				<span class="stat-title fs-26"><?php echo $product['quantity']; ?></span>
					  				<span class="stat-desc">adet stok</span>
					  			</div> <!-- /.stat-item -->
					  		</div> <!-- /.col-md-4 -->
					  		<div class="col-md-4">
					  			<div class="stat-item">
					  				<span class="stat-title fs-26"><?php echo convert_money($product['quantity'] * $product['p_purchase'], array('icon'=>true)); ?></span>
					  				<span class="stat-desc">maliyet değeri</span>
					  			</div> <!-- /.stat-item -->
					  		</div> <!-- /.col-md-4 -->
					  		<div class="col-md-4">
					  			<div class="stat-item">
					  				<span class="stat-title fs-26"><?php echo convert_money($product['quantity'] * $product['p_sale'], array('icon'=>true)); ?></span>
					  				<span class="stat-desc">satış değeri</span>
					  			</div> <!-- /.stat-item -->
					  		</div> <!-- /.col-md-4 -->
					  	</div> <!-- /.row -->

					  	<hr />

					  	<h5><i class="fa fa-line-chart"></i> Bu güne kadar raporları</h5>
					  	<?php $q_sum = db()->query("SELECT sum(p_sale), sum(p_purchase) FROM ".dbname('form_items')." WHERE product_id='".$product['id']."' AND in_out='1' AND status='1'"); ?>
					  	<?php $list = $q_sum->fetch_row(); ?>
					  	
					  	<div class="row">
					  		<div class="col-md-4">
					  			<div class="stat-item border-0">
					  				<span class="stat-title fs-20"><?php echo convert_money($list[0], array('icon'=>true)); ?></span>
					  				<span class="stat-desc">satış yapıldı</span>
					  			</div> <!-- /.stat-item -->
					  		</div> <!-- /.col-md-4 -->
					  		<div class="col-md-4">
					  			<div class="stat-item">
					  				<span class="stat-title fs-20"><?php echo convert_money($list[1], array('icon'=>true)); ?></span>
					  				<span class="stat-desc">satış için alım yapıldı</span>
					  			</div> <!-- /.stat-item -->
					  		</div> <!-- /.col-md-4 -->
					  		<div class="col-md-4">
					  			<div class="stat-item">
					  				<span class="stat-title fs-20"><?php echo convert_money($list[0]-$list[1], array('icon'=>true)); ?></span>
					  				<span class="stat-desc">kar elde edildi</span>
					  			</div> <!-- /.stat-item -->
					  		</div> <!-- /.col-md-4 -->
					  	</div> <!-- /.row -->

					</div> <!-- /.col-md-9 -->
				</div> <!-- /.row -->


			  </div> <!-- /.panel-body -->
			</div> <!-- /.panel .panel-default -->



			<div class="panel panel-btn-group panel-default">
			  <div class="panel-heading">
			  	<i class="fa fa-barcode"></i> Barkod Yazdırma Paneli
			  	
			  	<div class="btn-group btn-panel-group pull-right" role="group" aria-label="...">
				  <button type="button" class="btn btn-default"><i class="fa fa-print"></i></button>
				</div>

			  </div> <!-- /.panel-heading -->
			  <div class="panel-body text-center">
			  	<img src="<?php echo site_url('inc/plugins/barcode/?text='); ?><?php echo $product['code']; ?>">
				<br />
				<span><?php echo $product['code']; ?></span>
			  </div> <!-- /.panel-body -->
			</div> <!-- /.panel .panel-default -->

			

			

		</div> <!-- /.col-md-6 -->
	</div> <!-- /.row -->
</form>


<script>$('#code').focus();</script>


</div>  <!-- /.tab-pane #home -->
<!--TAB: FORMS -->
<div role="tabpanel" class="tab-pane fade" id="forms" aria-labelledby="forms-tab"> 

	<h3 class="row-module-title"><i class="fa fa-th-list"></i> Formlar/Hareketler Listesi</h3>
	<?php $q_form_items = db()->query("SELECT * FROM ".dbname('form_items')." WHERE product_id='".$product['id']."' AND status='1' ORDER BY date ASC"); ?>
	<?php if($q_form_items->num_rows > 0): ?>
		<table class="table table-hover table-bordered table-condensed dataTable">
			<thead>
				<tr>
					<th>Tarih</th>
					<th>Giriş/Çıkış</th>
					<th>Personel</th>
					<th>Form ID</th>
					<th>Hesap Kartı</th>
					<th>Birim Fiyatı</th>
					<th>Adet</th>
					<th>Satır Toplamı</th>
					<th>Stok Durumu</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$quantity = 0;
			while($list = $q_form_items->fetch_assoc())
			{
				?>
				<tr>
					<td><?php echo $list['date']; ?></td>
					<td><?php echo get_text_inout($list['in_out']); ?></td>
					<td><?php echo $list['user_id']; ?></td>
					<td><a href="<?php url_form($list['form_id']); ?>" target="_blank">#<?php echo $list['form_id']; ?></a></td>
					<td>
						<?php if($list['account_id'] > 0): ?><a href="<?php url_account($list['account_id']); ?>" target="_blank"><?php echo $list['account_name']; ?></a><?php else: ?><?php echo $list['account_name']; ?><?php endif; ?></td>
					<td class="text-right"><?php echo convert_money($list['p_sale'], array('icon'=>true)); ?></td>
					<td class="text-center"><?php echo $list['quantity']; ?></td>
					<td class="text-right"><?php echo convert_money($list['sub_total'], array('icon'=>true)); ?></td>
					<td class="text-center">
						<?php 
						if($list['in_out'] == 0)
						{
							$quantity = $quantity+$list['quantity'];
						}
						else
						{
							$quantity = $quantity-$list['quantity'];
						}
						?>
						<?php echo $quantity; ?>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
	<?php endif; ?>

	
	
</div> <!-- /.tab-pane #forms -->
<!-- TAB: LOGS -->
<div role="tabpanel" class="tab-pane fade" id="logs" aria-labelledby="logs-tab"> 

	<h3 class="row-module-title"><i class="fa fa-clock-o"></i> Geçmiş - Log Kayıtları</h3>
	<?php get_logs(array('table_id'=>'products:'.$product['id'])); ?>
	
</div> <!-- /.tab-pane #logs -->
</div> <!-- /.tab-content -->

<?php else: ?>
	<?php echo get_alert(array('title'=>'Ürün Kartı Bulunamadı.'), 'danger', array('dismissible'=>false) ); ?>
<?php endif; ?>


<?php get_footer(); ?>