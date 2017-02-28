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
		<div>
			<div><img src="<?php barcode_url($account->code); ?>" /></div>
			<div class="fs-10 margin-left-15"><?php echo $account->code; ?></div>
			<div class="h-20"></div>

			<div class="fs-14 bold"><?php echo $account->name; ?></div>
			<div class="fs-12"><?php echo $account->address; ?></div>
			<div class="fs-12"><?php echo $account->district; ?>/<?php echo $account->city; ?> - <?php echo $account->country; ?></div>
			<div class="fs-12"><span class="text-muted">Cep Tel:</span> <?php echo $account->gsm; ?> - <span class="text-muted">Sabit Tel:</span> <?php echo $account->phone; ?></div>
			<div class="fs-12"><span class="text-muted">Vergi Dairesi:</span> <?php echo $account->tax_home; ?> - <span class="text-muted">Vergi No:</span> <?php echo $account->tax_no; ?></div>
		</div>
	</div> <!-- /.account-card -->

</div> <!-- /.print-page -->



<?php if(isset($_GET['print'])): ?>
	<script>
		setTimeout(function () { window.print(); }, 500);
		setTimeout(function () { window.close(); }, 500);
	</script>
<?php endif; ?>