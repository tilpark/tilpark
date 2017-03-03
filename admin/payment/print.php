<?php include('../../tilpark.php'); ?>

<?php if(isset($_GET['id'])): ?>
	<?php if(!$payment = get_payment($_GET['id'])) { exit('odeme formu bulunamadı.'); } ?>
<?php else: exit('odeme id gerekli'); endif; ?>

<?php
// eger teması var ise temayı goster yok ise devam et
if(include_content_page('print', $payment->type, 'payment')) { return false; }
?>


<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
<style>
.i-company-address {
	position: absolute;
	left: 40px;
	top: 20px;
}
.you-company-address {
	position: absolute;
	left: 40px;
	top: 120px;
}

.document-detail {
	position: absolute;
	top: 240px;
	left: 40px;
	right: 40px;
}




.i-personel-signature {
	position: absolute;
	bottom: 80px;
	left: 40px;
}

.you-personel-signature {
	position: absolute;
	bottom: 80px;
	right: 40px;
}
</style>



<title>Ödeme Formu - <?php echo $payment->account_name; ?></title>

<div class="print-page" size="A4">

	<div class="i-company-address">
		<div class="fs-14 bold">TİLPARK</div>
		<div class="fs-12">Hoca Ömer Mah. Kemal Paşa Cad. No:1 Kat:4</div>
		<div class="fs-12">Merkez/ADIYAMAN</div>
		<div class="fs-12">0212 909 90 90</div>
	</div> <!-- /.i-company-address -->


	<div class="document-info-right">
		<div class="fs-18 bold" style="border-bottom:1px solid #ccc;">TAHSİLAT MAKBUZU</div>
		<div class="h-10"></div>
		<div class="fs-12"><strong class="col-title">Form No</strong> : #TILF-<?php echo $payment->id; ?></div>
		<div class="fs-12"><strong class="col-title">Tarih</strong> : <?php echo substr($payment->date,0,10); ?></div>
		<div class="fs-12"><strong class="col-title">Zaman</strong> : <?php echo substr($payment->date,11,5); ?></div>
		<div class="h-10"></div>
		<div><img src="<?php barcode_url('TILF-'.$payment->id); ?>" /></div>
	</div> <!-- /.document-info-right -->

	
		<div class="you-company-address">
			<div style="background-color:#e8e8e8; padding:10px; border-radius:3px;">
				<div class="fs-14 bold"><?php echo $payment->account_name; ?></div>
				<div class="fs-12">Hoca Ömer Mah. Kemal Paşa Cad. No:1 Kat:4</div>
				<div class="fs-12">Merkez/<?php echo $payment->account_city; ?></div>
				<div class="fs-12"><?php echo $payment->account_gsm; ?></div>
			</div>
		</div> <!-- /.i-company-address -->



	<div class="document-detail">
		<table>
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
					<td style="text-align:right;"><?php echo get_set_money($payment->total); ?></td>
				</tr>
			</tbody>
		</table>

		<div class="h-20"></div>
		

		<b>Yalnız;</b> <?php echo til_get_money_convert_string($payment->total); ?>
	
	</div> <!-- /.document-detail -->






	<div class="i-personel-signature">
		<div class="fs-10">TAHSİLAT YAPAN - <small>AD/SOYAD/İMZA</small></div>
		<div class="h-10"></div>
		<div><?php echo get_active_user('name'); ?> <?php echo get_active_user('surname'); ?></div>
		<div style="color:#ccc;">____________________________</div>
	</div> <!-- /.i-personel-signature -->


	<div class="you-personel-signature">
		<div class="fs-10">ÖDEME YAPAN - <small>AD/SOYAD/İMZA</small></div>
		<div class="h-10"></div>
		<div>&nbsp;</div>
		<div style="color:#ccc;">____________________________</div>
	</div> <!-- /.i-personel-signature -->





</div>






<?php if(isset($_GET['print'])): ?>
	<script>
		setTimeout(function () { window.print(); }, 500);
		setTimeout(function () { window.close(); }, 500);
	</script>
<?php endif; ?>









