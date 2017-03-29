<?php include('../../tilpark.php'); ?>

<?php if(isset($_GET['id'])): ?>
	<?php if(!$item = get_item($_GET['id'])) { exit('urun bulunamadı.'); } ?>
<?php else: exit('urun id gerekli'); endif; ?>

<?php get_header_print( array('logo'=>false, 'footer'=>false ) ); ?>

	<img src="<?php barcode_url($item->code, array('position'=>'left')); ?>" />
	<div class="fs-10 ff-2 margin-left-15"><?php echo $item->code; ?></div>
	<div class="fs-10"><?php echo $item->name; ?></div>
	

<?php get_footer_print(array('footer'=>false)); ?>