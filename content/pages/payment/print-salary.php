<link href="<?php echo template_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/app.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">


<title>Maaş/Avans Makbuzu</title>
<div class="print-page" size="A4">

	<div class="print-tilpark-logo">
		<img src="<?php site_url('content/themes/default/img/logo_blank.png'); ?>" class="img-responsive">
	</div>

	<div class="row">
		<div class="col-xs-6">
			<h4 class="content-title">Maaş/Avans Makbuzu</h4>
		</div> <!-- /.col-md-* -->
		<div class="col-xs-6">

		</div> <!-- /.col-md-* -->
	</div> <!-- /.row -->




	<div class="row">
		<div class="col-xs-6">

		</div> <!-- /.col-md-6 -->
		<div class="col-xs-6">
			<div class="pull-right">
				<img src="<?php barcode_url('TILP-'.$payment->id); ?>" />
				<br />
				<div class="text-right mr-15"><?php echo 'TILP-'.$payment->id; ?></div>
				<div class="h-20"></div>
				<div class="text-right mr-15"><?php echo til_get_date($payment->date, 'datetime'); ?></div>
			</div>
		</div> <!-- /.col-md-6 -->
	</div> <!-- /.row -->

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
				<div class="fs-14 bold"><?php echo $payment->account_name; ?></div>
				<div class="fs-12">T.C. No : <?php echo $payment->account_tax_no; ?></div>
				<div class="fs-12"><?php echo $payment->account_email; ?></div>
				<div class="fs-12"><?php echo $payment->account_gsm; ?></div>
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
			
			<div class="fs-10 text-muted">ÖDEMEYİ YAPAN - <small>AD/SOYAD/İMZA</small></div>
			<div class="h-10"></div>
			<div><?php echo get_user_info($payment->user_id, 'name'); ?> <?php echo get_user_info($payment->user_id, 'surname'); ?></div>
			
			<div class="text-muted h-10" style="border-bottom: 1px dotted #ccc; width:150px"></div>

		</div> <!-- /.col-xs-* -->
		<div class="col-xs-6">
			
			<div class="pull-right">
				<div class="fs-10 text-muted">ÖDEMEYİ ALAN - <small>AD/SOYAD/İMZA</small></div>
				<div class="h-10"></div>
				<div><?php echo $payment->account_name; ?></div>
				
				<div class="text-muted h-10" style="border-bottom: 1px dotted #ccc; width:150px"></div>
			</div> <!-- /.pull-right -->

		</div> <!-- /.col-xs-* -->
	</div> <!-- /.row -->





	<div class="print-footer print-footer-left">
		<small class="text-muted"><img src="<?php site_url('content/themes/default/img/logo_header.png'); ?>" class="img-responsive pull-left" width="64"> açık kaynak yazılımlar.</small>
	</div>
</div>


