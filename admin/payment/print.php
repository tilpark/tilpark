<?php include('../../tilpark.php'); ?>

<?php if(isset($_GET['id'])): ?>
	<?php if(!$payment = get_payment($_GET['id'])) { exit('odeme formu bulunamadı.'); } ?>
<?php else: exit('odeme id gerekli'); endif; ?>

<?php
include_content_page('print', $payment->template, 'payment', array('payment'=>$payment));
?>




<link href="<?php echo template_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/app.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">



<?php if($payment->in_out == 0): ?>
	<title>Tahsilat Formu : <?php echo $payment->account_name; ?></title>
<?php else: ?>
	<title>Tediye Formu : <?php echo $payment->account_name; ?></title>
<?php endif; ?>


<?php $form_meta = get_form_meta($payment->id); ?>

	<?php
	if($payment->in_out == '0') { $print['title'] = 'TAHSILAT FORMU'; } else { $print['title'] = 'ÖDEME FORMU'; }
	$print['date']		= $payment->date;
	$print['barcode']	= 'TILP-'.$payment->id;
	?>
	<?php get_header_print($print); ?>




	<div class="row">
		<div class="col-xs-6">

		</div> <!-- /.col-md-6 -->
		<div class="col-xs-6">
			
		</div> <!-- /.col-md-6 -->
	</div> <!-- /.row -->

	<div class="h-20"></div>

	<div class="row">
		<div class="col-xs-6">

			<div class="p-10 br-3">
				<div class="fs-14 bold"><?php echo til()->company->name; ?></div>
				<div class="fs-12"><?php echo til()->company->address; ?></div>
				<div class="fs-12"><?php echo til()->company->district; ?> <?php echo til()->company->city; ?> <?php echo til()->company->country; ?></div>
				<div class="fs-12"><?php echo til()->company->phone; ?> <?php echo til()->company->email; ?></div>
			</div>
		
		</div> <!-- /.col-md-* -->
		<div class="col-xs-6">

			<div class="bg-gray p-10 br-3">
				<div class="fs-14 bold"><?php echo $payment->account_name; ?></div>
				<div class="fs-11"><?php echo $form_meta->address; ?></div>
				<div class="fs-11"><?php echo $form_meta->district; ?><?php echo $payment->account_city ? '/' : ''; ?><?php echo $payment->account_city; ?><?php echo $form_meta->country ? ' - ' : ''; ?><?php echo $form_meta->country; ?></div>
				<div class="fs-11"><?php echo get_set_show_phone($payment->account_gsm); ?><?php echo $payment->account_phone ? ' - ' : ''; ?><?php echo get_set_show_phone($payment->account_phone); ?></div>
				<div class="fs-11"><?php echo $payment->account_tax_home ? 'V. Dairesi: '.$payment->account_tax_home : ''; ?> <?php echo ($payment->account_tax_home and $payment->account_tax_no) ? ' - ': ''; ?> <?php echo $payment->account_tax_no ? 'V. No: '.$payment->account_tax_no : ''; ?></div>
				<?php if($payment->account_email): ?><div class="fs-11"><?php echo $payment->account_email; ?></div><?php endif; ?>
			</div>

		</div> <!-- /.ol-md-* -->
	</div> <!-- /.row -->


	<div class="h-20"></div>
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>Ödeme Türü</th>
				<th>Banka Adı</th>
				<th>Çek/Senet No</th>
				<th>Vade Tarihi</th>
				<th>Tutar</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td class="text-right"><?php echo get_set_money($payment->total, 'str'); ?></td>
			</tr>
		</tbody>
	</table>

	<b>Yalnız;</b> <?php echo til_get_money_convert_string($payment->total); ?>

	<div class="h-50"></div>


	<div class="row">
		<div class="col-xs-6">
			
			<?php if($payment->in_out == 1): ?>
				<div class="fs-10 text-muted">ÖDEMEYİ YAPAN - <small>AD/SOYAD/İMZA</small></div>
			<?php else: ?>
				<div class="fs-10 text-muted">TAHSİLATI YAPAN - <small>AD/SOYAD/İMZA</small></div>
			<?php endif; ?>
			<div class="h-10"></div>
			<div><?php echo get_user_info($payment->user_id, 'name'); ?> <?php echo get_user_info($payment->user_id, 'surname'); ?></div>
			
			<div class="text-muted h-10" style="border-bottom: 1px dotted #ccc; width:150px"></div>

		</div> <!-- /.col-xs-* -->
		<div class="col-xs-6">
			
			<div class="pull-right">
				<?php if($payment->in_out == 1): ?>
					<div class="fs-10 text-muted">ÖDEMEYİ ALAN - <small>AD/SOYAD/İMZA</small></div>
				<?php else: ?>
					<div class="fs-10 text-muted">ÖDEMEYİ YAPAN - <small>AD/SOYAD/İMZA</small></div>
				<?php endif; ?>

				<div class="h-10"></div>
				<div><?php echo $payment->account_name; ?></div>
				
				<div class="text-muted h-10" style="border-bottom: 1px dotted #ccc; width:150px"></div>
			</div> <!-- /.pull-right -->

		</div> <!-- /.col-xs-* -->
	</div> <!-- /.row -->





<?php get_footer_print(); ?>







