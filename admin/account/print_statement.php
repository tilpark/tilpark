<?php include('../../tilpark.php'); ?>
<meta charset="UTF-8">
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
<?php if(isset($_GET['id'])): ?>
	<?php if(!$account = get_account($_GET['id'])) { exit('hesap kartı bulunamadı'); } ?>
<?php else: exit('hesap karti ID gereklidir.'); endif; ?>
<title>Cari Ekstre - <?php echo $account->name; ?></title>

<style>
.account-card {
	position: absolute;
	left: 20px;
	top: 20px;
}
.account-form-list {
	position: absolute;
	width: 100%;
	top: 130px;
}

</style>

<div class="print-page" size="A4">


<div class="account-card">
	<div style="background-color:#e8e8e8; padding:10px; border-radius:3px;">
		<div class="fs-14 bold"><?php echo $account->name; ?></div>
		<div class="fs-12"><?php echo $account->address; ?></div>
		<div class="fs-12"><?php echo $account->district; ?>/<?php echo $account->city; ?></div>
		<div class="fs-12"><span class="text-muted">Cep Tel:</span> <?php echo $account->gsm; ?> - <span class="text-muted">Sabit Tel:</span> <?php echo $account->phone; ?></div>
	</div>
</div> <!-- /.account-card -->


<div class="document-info-right">
<div class="fs-18 bold" style="border-bottom:1px solid #ccc;">CARİ HESAP EKSTRESİ</div>
	<div class="h-10"></div>
	<div class="fs-12"><strong class="col-title">Hesap Kodu</strong> : #TILA-<?php echo $account->id; ?></div>
	<div class="fs-12"><strong class="col-title">Tarihi</strong> : <?php echo date("Y-m-d"); ?></div>
	<div class="fs-12"><strong class="col-title">Zamanı</strong> : <?php echo date("H:i"); ?></div>
</div> <!-- /.document-info -->

<div class="h-20"></div>

	<div class="account-form-list">
		<?php
		$args_form['where']['status'] = '1';
		$args_form['where']['account_id'] = $account->id;
		$args_form['where']['orderby'] = 'id ASC';
		if($forms = get_forms($args_form)): ?>

			<table>
				<thead>
					<tr>
						<th>Tarih</th>
						<th>Form ID</th>
						<th>Açıklama</th>
						<th>Giriş</th>
						<th>Çıkış</th>
						<th>Bakiye</th>
					</tr>
				</thead>
				<tbody>
				<?php $balance = 0; foreach($forms->list as $form): ?>
					<tr>
						<td><small class="text-muted"><?php echo substr($form->date,0,16); ?></small></td>
						<td>#<?php echo $form->id; ?></td>
						<td class="text-muted">
							<?php
							if($form->type=='form') {
								if($form->in_out == '0') { echo 'Giriş formu: '.$form->item_quantity.' adet ürün'; } else { echo 'Çıkış formu: '.$form->item_quantity.' adet ürün'; }
							} elseif($form->type=='payment') {
								if($form->in_out == '0') { echo 'Ödeme girişi'; } else { echo 'Ödeme çıkışı'; }	
							}
							?>
						</td>
						<td style="text-align:right;"><?php if($form->in_out == 0) { echo get_set_money($form->total, true); $balance = $balance - $form->total; } else { echo ''; } ?></td>
						<td style="text-align:right;"><?php if($form->in_out == 1) { echo get_set_money($form->total, true); $balance = $balance + $form->total; } else { echo ''; } ?></td>
						<td style="text-align:right;"><?php echo get_set_money($balance, true); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

		<?php endif; ?>
	</div> <!-- /.account-form-list -->

</div> <!-- /.print-page -->



<?php if(isset($_GET['print'])): ?>
	<script>
		setTimeout(function () { window.print(); }, 500);
		setTimeout(function () { window.close(); }, 500);
	</script>
<?php endif; ?>