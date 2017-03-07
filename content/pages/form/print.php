<link href="<?php echo template_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/app.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">


<?php $form_meta = get_form_meta($form->id); ?>


<?php if($form->in_out == '0'): ?>
	<title>Giriş Formu - <?php echo $form->account_name; ?> | Tilpark</title>
<?php else: ?>
	<title>Çıkış Formu - <?php echo $form->account_name; ?> | Tilpark</title>
<?php endif; ?>

<div class="print-page" size="A4">

	<div class="print-tilpark-logo">
		<img src="<?php site_url('content/themes/default/img/logo_blank.png'); ?>" class="img-responsive">
	</div>


	
		<div class="text-center absolute full-width">
			<?php if($form->in_out == 0): ?>
				<h3 class="content-title ff-2 text-center">GİRİŞ FORMU <small><?php echo til_get_date($form->date, 'datetime'); ?></small></h3>
			<?php else: ?>
				<h3 class="content-title ff-2 text-center">ÇIKIŞ FORMU</h3>
			<?php endif; ?>
		</div> <!-- /.text-center -->
	



	<div class="pull-right">
		<div class="text-right">
			<h4 class="content-title"><small class="text-muted"><?php echo til_get_date_lang(date('d F Y - H:i', strtotime($form->date))); ?></small></h4>
			<div><img src="<?php barcode_url('TILP-'.$form->id, array('position'=>'right') ); ?>" /></div>
			<div class="text-right"><?php echo 'TILP-'.$form->id; ?></div>
			<div class="h-20"></div>
		</div>
	</div> <!-- /.text-right -->

	<div class="clearfix"></div>	
	<div class="h-20"></div>

	<div class="row">
		<div class="col-xs-6">

			<div class="p-10 br-3">
				<div class="fs-14 bold"><?php echo til()->company['name']; ?></div>
				<div class="fs-12"><?php echo til()->company['address']; ?></div>
				<div class="fs-12"><?php echo til()->company['district']; ?> <?php echo til()->company['city']; ?> <?php echo til()->company['country']; ?></div>
				<div class="fs-12"><?php echo til()->company['phone']; ?> <?php echo til()->company['email']; ?></div>
			</div>
		
		</div> <!-- /.col-md-* -->
		<div class="col-xs-6">

			<div class="bg-gray p-10 br-3">
				<div class="fs-14 bold"><?php echo $form->account_name; ?></div>
				<div class="fs-12">T.C. No : <?php echo $form_meta->address; ?></div>
				<div class="fs-12"><?php echo $form_meta->city; ?></div>
				<div class="fs-12"><?php echo $form_meta->address; ?></div>
			</div>

		</div> <!-- /.ol-md-* -->
	</div> <!-- /.row -->

</div> <!-- page-print -->