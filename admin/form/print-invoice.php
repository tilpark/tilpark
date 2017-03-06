<?php include('../../tilpark.php'); ?>
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
<?php if(isset($_GET['id'])): ?>
	<?php if(!$form = get_form($_GET['id'])) { exit('form bulunamadı.'); } ?>
<?php else: exit('form id gerekli'); endif; ?>

<?php $form_meta = get_form_metas($form->id); ?>

<style>
.you-company-address {
	position: absolute;
	left: 20px;
	top: 20px;
}

.document-detail {
	position: absolute;
	top: 140px;
	width: 100%;
}

</style>



<title>Ödeme Formu - <?php echo $form->account_name; ?></title>

<div class="print-page" size="A4">

	<div class="document-info-right">
		<div class="fs-12"><strong class="col-title">Tarih</strong> : <?php echo substr($form->date,0,16); ?></div>
		<div class="h-10"></div>
		<div><img src="<?php barcode_url('TILF-'.$form->id); ?>" /></div>
		<div class="ml-15">TILF-<?php echo $form->id; ?></div>
	</div> <!-- /.document-info-right -->

	
		<div class="you-company-address">
			<div style="background-color:#e8e8e8; padding:10px; border-radius:3px;">
				<div class="fs-14 bold"><?php echo $form->account_name; ?></div>
				<div class="fs-12"><?php echo $form_meta['address']->val; ?></div>
				<div class="fs-12"><?php echo $form_meta['district']->val; ?> / <?php echo $form->account_city; ?> - <?php echo $form_meta['country']->val; ?></div>
				<div class="fs-12"><?php echo $form->account_gsm; ?> / <?php echo $form->account_phone; ?></div>
			</div>
		</div> <!-- /.i-company-address -->



	<div class="document-detail">
		

		<?php $form_items = get_form_items($form->id); ?>
		<div class="not-found"><?php print_alert('add_form_item'); ?></div>
		<div class="not-found"><?php print_alert('delete_form_item'); ?></div>
		<table >
			<thead>
				<tr class="border-none">
					<th>Ürün Kodu</th>
					<th>Ürün Adı</th>
					<th>Adet</th>
					<th>B. Fiyatı</th>
					<th>Toplam</th>
					<th>Kdv</th>
					<th>Kdv Tutarı</th>
					<th>Tutar</th>
				</tr>
			</thead>
			<tbody>
				<?php if($form_items): ?>
					<?php
					$total_vat = 0;
					?>
					<?php foreach($form_items->list as $item): ?>
						<tr>
							<td>
								<?php if(isset($_GET['barcode'])): ?>
									<img src="<?php barcode_url('TILI-'.$item->id); ?>" /><br />
								<?php endif; ?>
								<?php echo $item->item_code; ?>
							</td>
							<td><?php echo $item->item_name; ?></td>
							<td style="text-align:center;"><?php echo $item->quantity; ?></td>
							<td style="text-align:right;"><?php echo get_set_money($item->price, true); ?></td>
							<td style="text-align:right;"><?php echo get_set_money($item->total, true); ?></td>
							<td style="text-align:center;"><?php echo $item->vat; ?></td>
							<td style="text-align:right;"><?php echo get_set_money($item->vat_total, true); ?></td>
							<td style="text-align:right;"><?php echo get_set_money($item->total, true); ?></td>
						</tr>

						<?php
						$total_vat = $total_vat + $item->vat_total;
						?>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2"></th>
					<th style="text-align:center;"><?php echo @$form->item_quantity; ?></th>
					<th colspan="3"></th>
					<th style="text-align:right;"><?php echo get_set_money(@$total_vat, true); ?></th>
					<th style="text-align:right;"><?php echo get_set_money(@$form->total, true); ?></th>
				</tr>
			</tfoot>
		</table>
	</div> <!-- /.panel -->
		


	
	</div> <!-- /.document-detail -->










</div>






<?php if(isset($_GET['print'])): ?>
	<script>
		setTimeout(function () { window.print(); }, 500);
		setTimeout(function () { window.close(); }, 500);
	</script>
<?php endif; ?>









