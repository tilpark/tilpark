<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<?php 
$form_id = 0;
if(isset($_GET['id']))  {
	$form = get_form($_GET['id']);
	if($form) 
	{
		$form_id = $form['id'];
		$in_out = $form['in_out'];
		$account = get_account($form['account_id']);
	} else {
		echo get_alert(array('title'=>'Form bulunamadı.', 'description'=>'#'.$_GET['id'].' id numarali form bulunamadı.'), 'danger', array('dismissible'=>false));
		exit;
	}
} else {
	if( isset($_GET['in_out']) or isset($_POST['in_out']) ) { if(isset($_GET['in_out'])) { $in_out=$_GET['in_out']; } else { $in_out=$_POST['in_out']; } } else { $in_out = '1'; }
}
?>


<?php
// Header Bilgisi
$breadcrumb[0] = array('name'=>'Form Yönetimi', 'url'=>get_site_url('content/forms/'));
if($in_out == 0){ $breadcrumb[1] = array('name'=>'Yeni Giriş/Alış Formu', 'url'=>'', 'active'=>true); } 
	else { $breadcrumb[1] = array('name'=>'Yeni Çıkış/Satış Formu', 'url'=>'', 'active'=>true); }





// form guncelleme
if(isset($_POST['update_form']) and !is_uniquetime())
{
	unset($_POST['update_form']);
	if(update_form($form_id, $_POST))
	{
		$form = get_form($form_id);
	}
}



// delete form item
if(isset($_GET['delete_form_item']))
{
	delete_form_item($_GET['delete_form_item'], $form['id']);
}

// o_status
	# siparis durumunu degistirir, "siparis onaylandi, siparis hazirlaniyor, siparis kargoya verildi gibi"
if(isset($_GET['o_status']))
{
	update_o_status($form['id'], $_GET['o_status']);
	$form = get_form($form['id']);
}
?>





<ul id="myTabs" class="nav nav-tabs bordered" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false"><i class="fa fa-shopping-cart"></i> Form</a></li> 
	<?php if(isset($form['id'])): ?><li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="true"><i class="fa fa-clock-o"></i> Geçmiş</a></li> <?php endif; ?>
	<?php if(isset($form['id'])): ?>
		<li role="presentation" class="dropdown"> <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">Seçenekler <span class="caret"></span></a> 
			<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
				<li><a href="#dropdown1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1">Yazdır</a></li> 
				<li><a href="#dropdown2" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2">Görev Ataması</a></li> 
			</ul> 
		</li>
	<?php endif; ?>
	<?php if(isset($form['id'])): ?>
		<li role="presentation" class="dropdown pull-right"> <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">Form Durumu <span class="caret"></span></a> 
			<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
				<li class="<?php if($form['o_status'] == 'waiting'): ?>disabled<?php endif; ?>"><a href="<?php url_form($form['id']); ?>&o_status=waiting">Onay Bekliyor</a></li> 
				<li class="<?php if($form['o_status'] == 'preparing'): ?>disabled<?php endif; ?>"><a href="<?php url_form($form['id']); ?>&o_status=preparing">Onaylandı - Hazırlanıyor</a></li> 
				<li class="<?php if($form['o_status'] == 'shipping'): ?>disabled<?php endif; ?>"><a href="<?php url_form($form['id']); ?>&o_status=shipping">Hazırlandı - Kargoya Verildi</a></li> 
				<li class="<?php if($form['o_status'] == 'completed'): ?>disabled<?php endif; ?>"><a href="<?php url_form($form['id']); ?>&o_status=completed">Teslim Edildi</a></li> 
				<li role="separator" class="divider"></li>
				<li class="<?php if($form['o_status'] == 'noapproval'): ?>disabled<?php endif; ?>"><a href="<?php url_form($form['id']); ?>&o_status=noapproval"><span class="<?php if($form['o_status'] != 'noapproval'): ?>text-danger<?php endif; ?>">Onay Verilmedi</span></a></li> 
			</ul> 
		</li> 
	<?php endif; ?>
</ul>




<div id="myTabContent" class="tab-content"> 
<!-- TAB: #HOME -->
<div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab"> 

	



<?php

// yeni urun ekleme
if(isset($_POST['form_submit']) and !is_uniquetime())
{
	// form
	// form kartini guncellemek veya yeni form olusturmak icin
	$form['date']			= $_POST['date'];
	$form['in_out']			= $in_out;
	$form['account_id'] 	= $_POST['account_id'];
	$form['account_code'] 	= $_POST['account_code'];
	$form['account_name'] 	= $_POST['account_name'];
	$form['account_gsm'] 	= $_POST['account_gsm'];
	$form['account_phone'] 	= $_POST['account_phone'];
	$form['account_address'] 	= $_POST['account_address'];
	$form['account_district'] 	= $_POST['account_district'];
	$form['account_city'] 		= $_POST['account_city'];
	$form['account_tax_home'] 	= $_POST['account_tax_home'];
	$form['account_tax_no'] 	= $_POST['account_tax_no'];
	$form['account_name'] 		= $_POST['account_name'];

	// eger hesap adi yok veya bos birakilmis ise "SERBEST SATIS" adi formu olusturalim
	if(empty($form['account_name'])){ $form['account_name'] = 'SERBEST SATIS'; }


	$location = false;
	if($form_id == 0){ if($form_id = add_form($form, array('add_account'=>false))){ $location = true;} }
	else { update_form($form_id, $form, array('add_account'=>false)); }
	$form = get_form($form_id);




	// form items
	$form_item['date'] 	= date('Y-m-d');
	$form_item['in_out']		= $form['in_out'];
	$form_item['form_id']		= $form['id'];
	$form_item['account_id']    = $form['account_id'];
	$form_item['account_name']  = $form['account_name'];
	$form_item['product_id']    = $_POST['product_id'];
	$form_item['product_code']    = $_POST['product_code'];
	$form_item['product_name']    = $_POST['product_name'];
	$form_item['p_sale']    = $_POST['p_sale'];
	$form_item['quantity']    = $_POST['quantity'];
	$form_item['tax_rate']    = $_POST['tax_rate'];
	$form_item['tax_value']    = $_POST['tax_value'];

	if(strlen($form_item['product_name']) > 3) {
		add_form_item($form_item);
	}
	
	if($location == true) {
		header("Location: ".get_url_form($form['id']));
	}
	
}







alert();


// controls
if(strlen(@$form['date']) < 1)
{
	$form['date'] = date('Y-m-d');
}
?>






<form name="form_add" id="form_add" action="<?php url_form(@$form['id']); ?>" method="POST" class="dene validation">

	<h3 class="row-module-title"><i class="fa fa-shopping-cart"></i> Hesap Bilgileri</h3>

	<input type="hidden" name="account_id" id="account_id" value="">

	<div class="row">
		<div class="col-md-3">
			<div class="form-group icon-group">
			  	<label class="control-label" for="account_code">Hesap Kodu</label>
			  	<div class="icon-group">
			    	<span class="icon-group-addon"><i class="fa fa-barcode"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="32" name="account_code" id="account_code" value="<?php echo @$form['account_code']; ?>">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="form-group">
			  	<label class="control-label" for="account_name">Hesap Adı <small class="text-muted">(firma veya şahıs adı soyadı)</small></label>
			  	<div class="icon-group">
			    	<span class="icon-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="32" name="account_name" id="account_name" value="<?php echo @$form['account_name']; ?>">
			  	</div> <!-- /.input-group -->
			  	<div class="typeahead-box typeahead-account_name"></div>
			</div> <!-- /.form-group -->
			
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="form-group">
			  	<label class="control-label" for="date">Tarih</label>
			  	<div class="icon-group">
			    	<span class="icon-group-addon"><i class="fa fa-calendar"></i></span>
			    	<input type="text" class="form-control datePicker" minlength="3" maxlength="20" name="date" id="date" data-date-format="yyyy-mm-dd" value="<?php echo convert_date(@$form['date']); ?>">
			  	</div> <!-- /.icon-group -->
			</div> <!-- /.form-group -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			
		</div>
		<div class="clearfix"></div>

		<div class="col-md-3">
			<div class="form-group">
			  	<label class="control-label" for="account_gsm">Cep Telefonu</label>
			  	<div class="icon-group">
			    	<span class="icon-group-addon"><i class="fa fa-phone"></i></span>
			    	<input type="text" class="form-control gsm"  name="account_gsm" id="account_gsm" value="<?php echo @$form['account_gsm']; ?>" placeholder="(xxx) xxx-xxxx">
			  	</div> <!-- /.icon-group -->
			  	<div class="typeahead-box typeahead-account_gsm"></div>
			</div> <!-- /.form-group -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="form-group">
			  	<label class="control-label" for="account_phone">Sabit Telefon</label>
			  	<div class="icon-group">
			    	<span class="icon-group-addon"><i class="fa fa-phone"></i></span>
			    	<input type="text" class="form-control phone" name="account_phone" id="account_phone" value="<?php echo @$form['account_phone']; ?>" placeholder="(xxx) xxx-xxxx">
			  	</div> <!-- /.icon-group -->
			  	<div class="typeahead-box typeahead-account_phone"></div>
			</div> <!-- /.form-group -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="form-group">
			  	<label class="control-label" for="account_tax_home">Vergi Dairesi</label>
			  	<div class="icon-group">
			    	<span class="icon-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="20" name="account_tax_home" id="account_tax_home" value="<?php echo @$form['account_tax_home']; ?>">
			  	</div> <!-- /.icon-group -->
			</div> <!-- /.form-group -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="form-group">
			  	<label class="control-label" for="account_tax_no">Vergi No</label>
			  	<div class="icon-group">
			    	<span class="icon-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control digits digitsOnly" minlength="3" maxlength="20" name="account_tax_no" id="account_tax_no" value="<?php echo @$form['account_tax_no']; ?>">
			  	</div> <!-- /.icon-group -->
			  	<div class="typeahead-box typeahead-account_tax_no"></div>
			</div> <!-- /.form-group -->
		</div> <!-- /.col-md-3 -->

		<div class="clearfix"></div>
		<div class="col-md-6">
			<div class="form-group">
			  	<label class="control-label" for="account_address">Adres</label>
			  	<div class="icon-group">
			    	<span class="icon-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="500" name="account_address" id="account_address" value="<?php echo @$form['account_address']; ?>">
			  	</div> <!-- /.icon-group -->
			</div> <!-- /.form-group -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="form-group">
			  	<label class="control-label" for="account_district">İlçe</label>
			  	<div class="icon-group">
			    	<span class="icon-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="32" name="account_district" id="account_district" value="<?php echo @$form['account_district']; ?>">
			  	</div> <!-- /.icon-group -->
			</div> <!-- /.form-group -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="form-group">
			  	<label class="control-label" for="account_city">Şehir</label>
			  	<div class="icon-group">
			    	<span class="icon-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="32" name="account_city" id="account_city" value="<?php echo @$form['account_city']; ?>">
			  	</div> <!-- /.icon-group -->
			</div> <!-- /.form-group -->
		</div> <!-- /.col-md-3 -->
	</div> <!-- /.row -->


	<div class="clearfix"></div>
	<div class="h20"></div>


	<h3 class="row-module-title"><i class="fa fa-cubes"></i> Ürün Kartları</h3>

	<table class="table table-bordered table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th width="%7"></th>
			<th width="20%">Ürün Kodu</th>
			<th width="32%">Ürün Adı</th>
			<th width="10%">Birim Fiyatı <small class="text-muted">(kdv dahil)</small></th>
			<th width="8%">Adet</th>
			<th width="4%">Kdv %</th>
			<th width="7%">Kdv Tutarı</th>
			<th width="10%">Satır Toplamı</th>
			<th width="5%"></th>
		</tr>

		<tr>
			<td><button class="btn btn-default btn-block"><i class="fa fa-save"></i></button></td>
			<td>
				<input type="hidden" name="product_id" id="product_id" value="">
				<div class="form-group icon-group" style="margin-bottom:0px;">
				  	<div class="icon-group">
				    	<span class="icon-group-addon"><i class="fa fa-barcode"></i></span>
				    	<input type="text" class="form-control input-sm" minlength="3" maxlength="32" name="product_code" id="product_code">
				  	</div> <!-- /.input-group -->
				  	<div class="typeahead-box typeahead-product_code"></div>
				</div> <!-- /.form-group -->
			</td>
			<td>
				<div class="form-group">
					<input type="text" class="form-control input-sm text-left" minlength="3" maxlength="32" name="product_name" id="product_name">
					<div class="typeahead-box typeahead-product_name"></div>
				</div> <!-- /.form-group -->
			</td>
			<td><input type="text" class="form-control input-sm text-right numbers" maxlength="10" name="p_sale" id="p_sale"></td>
			<td><input type="text" class="form-control input-sm text-center digits" maxlength="11" name="quantity" id="quantity"></td>
			<td><input type="text" class="form-control input-sm text-center digits" maxlength="2" name="tax_rate" id="tax_rate"></td>
			<td><input type="text" class="form-control input-sm text-right numbers" maxlength="20" name="tax_value" id="tax_value" readonly></td>
			<td><input type="text" class="form-control input-sm text-right numbers" maxlength="20" name="sub_total" id="sub_total"></td>
			<td></td>
		</tr>
	</thead>
	<tbody>
	<?php if(@$form['id'] > 0): ?>
		<?php $form_items = get_form_items($form['id']); ?>
		<?php if($form_items): ?>
			<?php 
			$sub_total['sub_total'] 	= 0; 
			$sub_total['quantity'] 		= 0;
			$sub_total['tax_value'] 	= 0; 
			?>

			<?php foreach($form_items as $form_item): ?>
				<?php
				$sub_total['sub_total'] = $form_item['sub_total']+$sub_total['sub_total'];
				$sub_total['quantity'] 	= $form_item['quantity']+$sub_total['quantity'];
				$sub_total['tax_value'] = $form_item['tax_value']+$sub_total['tax_value'];
				?>
				<tr>
					<td class="text-center">
						<a href="<?php url_form($form['id']); ?>&delete_form_item=<?php echo $form_item['id']; ?>" class="btn btn-default btn-xs"><i class="fa fa-trash text-danger"></i></a>
					</td>
					<td><?php echo $form_item['product_code']; ?></td>
					<td><?php echo $form_item['product_name']; ?></td>
					<td class="text-right"><?php echo convert_money($form_item['p_sale']); ?></td>
					<td class="text-center"><?php echo $form_item['quantity']; ?></td>
					<td class="text-center"><?php if($form_item['tax_rate'] > 0): ?>% <?php echo $form_item['tax_rate']; ?><?php endif; ?></td>
					<td class="text-center"><?php if($form_item['tax_value'] > 0): ?><?php echo convert_money($form_item['tax_value']); ?><?php endif; ?></td>
					<td class="text-right"><?php echo convert_money($form_item['sub_total']); ?></td>
					<td></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4"></td>
					<td class="text-center"><?php echo $sub_total['quantity']; ?></td>
					<td class="text-center"></td>
					<td class="text-center"><?php echo convert_money($sub_total['tax_value']); ?></td>
					<th class="text-right"><?php echo convert_money($sub_total['sub_total']); ?></th>
					<td></td>
				</tr>
			</tfoot>
		<?php endif; ?>
		
	<?php endif; ?>



	</table>

	<?php calc_form(@$form['id']); ?>


	<script>
	function calc_tax(value, tax_rate)
	{
		var math_tax_rate = '';
		if(tax_rate.length == 2){ math_tax_rate =  parseFloat('1.'+tax_rate); }
		else { math_tax_rate = parseFloat('1.'+'0'+tax_rate); }

		var tax_value = parseFloat(value - (parseFloat(value) / math_tax_rate)).toFixed(<?php echo $til->fixed; ?>);
		return tax_value;
	}			

	$(document).ready(function() {


		/* eger form_id yok ise "form olusmamis ise" */
		<?php if(@$form['id'] == 1): ?>
			$( "#form_add_item" ).submit(function() {
				$('#account_id').attr('form', 'form_add_item');
				$('#account_code').attr('form', 'form_add_item');
				$('#account_name').attr('form', 'form_add_item');
				$('#date').attr('form', 'form_add_item');
				$('#account_gsm').attr('form', 'form_add_item');
				$('#account_phone').attr('form', 'form_add_item');
				$('#account_tax_home').attr('form', 'form_add_item');
				$('#account_tax_no').attr('form', 'form_add_item');
				$('#account_address').attr('form', 'form_add_item');
				$('#account_district').attr('form', 'form_add_item');
				$('#account_city').attr('form', 'form_add_item');
			});
		<?php endif; ?>
		


		$('#account_name').keyup(function(e) {
			$.get( "ajax_list_account.php?name&q="+$(this).val(), function( data ) {
				$( ".typeahead-box.typeahead-account_name" ).show();
			  	$( ".typeahead-box.typeahead-account_name" ).html( data );
			});
		});


		$('#account_gsm').keyup(function() {
			$.get( "ajax_list_account.php?gsm&q="+$(this).val(), function( data ) {
				$( ".typeahead-box.typeahead-account_gsm" ).show();
			  	$( ".typeahead-box.typeahead-account_gsm" ).html( data );
			});
		});


		$('#account_phone').keyup(function() {
			$.get( "ajax_list_account.php?phone&q="+$(this).val(), function( data ) {
				$( ".typeahead-box.typeahead-account_phone" ).show();
			  	$( ".typeahead-box.typeahead-account_phone" ).html( data );
			});
		});


		$('#account_tax_no').keyup(function() {
			$.get( "ajax_list_account.php?tax_no&q="+$(this).val(), function( data ) {
				$( ".typeahead-box.typeahead-account_tax_no" ).show();
			  	$( ".typeahead-box.typeahead-account_tax_no" ).html( data );
			});
		});


		// ajax product search
		$('#product_name').keyup(function() {
			$.get( "ajax_list_product.php?name&q="+$(this).val(), function( data ) {
				$( ".typeahead-box.typeahead-product_name" ).show();
			  	$( ".typeahead-box.typeahead-product_name" ).html( data );
			});
		});

		$('#product_code').keyup(function() {
			$.get( "ajax_list_product.php?code&q="+$(this).val(), function( data ) {
				$( ".typeahead-box.typeahead-product_code" ).show();
			  	$( ".typeahead-box.typeahead-product_code" ).html( data );
			});
		});


		$('body').click(function() {
			$( ".typeahead-box" ).hide();
		});
		
		$( ".typeahead-box" ).hide();


		

		$('#p_sale').keyup(function() {
			var p_sale 	 	 	= $('#p_sale').val();
			var quantity 		= $('#quantity').val();
			var tax_rate 		= $('#tax_rate').val();
			var tax_value 		= $('#tax_value').val();
			var sub_total 		= $('#sub_total').val();

			if(p_sale == '') { p_sale = '0'; }
			if(quantity == '') { quantity = '1'; }
			if(tax_rate == '') { tax_rate = '0'; }

			tax_value 	= quantity * calc_tax(p_sale, tax_rate);
			sub_total 	= p_sale * quantity;

			$('#tax_value').val(tax_value);
			$('#sub_total').val(parseFloat(sub_total).toFixed(<?php echo $til->fixed; ?>));
		});


		$('#quantity').keyup(function() {
			var p_sale 	 	 	= $('#p_sale').val();
			var quantity 		= $('#quantity').val();
			var tax_rate 		= $('#tax_rate').val();
			var tax_value 		= $('#tax_value').val();
			var sub_total 		= $('#sub_total').val();

			if(p_sale == '') { p_sale = '0'; }
			if(quantity == '') { quantity = '1'; }
			if(tax_rate == '') { tax_rate = '0'; }

			tax_value 	= quantity * calc_tax(p_sale, tax_rate);
			sub_total 	= p_sale * quantity;

			$('#tax_value').val(tax_value);
			$('#sub_total').val(parseFloat(sub_total).toFixed(<?php echo $til->fixed; ?>));
		});


		$('#tax_rate').keyup(function() {
			var p_sale 	 	 	= $('#p_sale').val();
			var quantity 		= $('#quantity').val();
			var tax_rate 		= $('#tax_rate').val();
			var tax_value 		= $('#tax_value').val();
			var sub_total 		= $('#sub_total').val();

			if(p_sale == '') { p_sale = '0'; }
			if(quantity == '') { quantity = '1'; }
			if(tax_rate == '') { tax_rate = '0'; }

			tax_value 	= quantity * calc_tax(p_sale, tax_rate);
			sub_total 	= p_sale * quantity;

			$('#tax_value').val(tax_value);
			$('#sub_total').val(parseFloat(sub_total).toFixed(<?php echo $til->fixed; ?>));
		});


		$('#sub_total').keyup(function() {
			var p_sale 	 	 	= $('#p_sale').val();
			var quantity 		= $('#quantity').val();
			var tax_rate 		= $('#tax_rate').val();
			var tax_value 		= $('#tax_value').val();
			var sub_total 		= $('#sub_total').val();

			if(p_sale == '') { p_sale = '0'; }
			if(quantity == '') { quantity = '1'; }
			if(tax_rate == '') { tax_rate = '0'; }

			p_sale = sub_total / quantity;
			tax_value 	= quantity * calc_tax(p_sale, tax_rate);

			$('#tax_value').val(tax_value);
			$('#p_sale').val(parseFloat(p_sale).toFixed(<?php echo $til->fixed; ?>));
		});

	});
	</script>


	<?php uniquetime(); ?>
	<input type="submit" style="display:none;">
	<input type="hidden" name="in_out" value="<?php echo $in_out; ?>">
	<input type="hidden" name="form_submit">
</form>


</div>  <!-- /.tab-pane #home -->
<!---------------------------------------------- TAB LOGS ---------------------------------------------->
<div role="tabpanel" class="tab-pane fade" id="logs" aria-labelledby="logs-tab"> 

	<h3 class="row-module-title"><i class="fa fa-clock-o"></i> Geçmiş - Log Kayıtları</h3>
	<?php get_logs(array('table_id'=>'forms:'.$form['id'])); ?>

</div> <!-- /.tab-pane #logs -->
<div role="tabpanel" class="tab-pane fade" id="dropdown1" aria-labelledby="dropdown1-tab"> 
	<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p> 
</div> 
<div role="tabpanel" class="tab-pane fade" id="dropdown2" aria-labelledby="dropdown2-tab">
	<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p> 
</div> 
</div> <!-- /#myTabContent -->


<?php get_footer(); ?>