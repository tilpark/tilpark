<?php include('../../tilpark.php'); ?>
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
<?php if(isset($_GET['id'])): ?>
	<?php if(!$item = get_item($_GET['id'])) { exit('urun bulunamadı.'); } ?>
<?php else: exit('urun id gerekli'); endif; ?>




<div class="print-page" size="A4">

	<div>
		<img src="<?php barcode_url($item->code); ?>" />
		<div class="fs-10 margin-left-15"><?php echo $item->code; ?></div>
		<div style="border-bottom:1px solid #ccc;"></div>
		<div class="fs-10"><?php echo $item->name; ?></div>
	</div>

</div> <!-- /.print-page -->




<?php if(isset($_GET['print'])): ?>
	<script>
		setTimeout(function () { window.print(); }, 500);
		setTimeout(function () { window.close(); }, 500);
	</script>
<?php endif; ?>