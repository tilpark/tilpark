<?php require_once('../../tilpark.php'); ?>
<?php 
if(!$account = get_account($_GET['id'])) {
	add_console_log('Hesap karti bulunamadi.', 'print-address.php');
	exit;
}

if(!$print = get_option('account_print_barcode')) {
	@$print->width = 90;
	@$print->height = 90;
}
?>

<?php include_content_page('print', 'barcode', 'account', array('account'=>@$account)); ?>	

<title>Kargo Barkodu Yazdır | <?php echo $account->name;?></title>
<?php
$args['logo'] = false;
$args['footer'] = false;
?>
<?php get_header_print($args); ?>

	<style>
	.print-page {
		height: <?php echo $print->height; ?>mm !important;
		width: <?php echo $print->width; ?>mm !important;
	}
	</style>


	<div class="row space-none">
		<div class="col-xs-12">


			<div class="p-10 br-3">

				<img src="<?php barcode_url( $account->code, array('position'=>'left') ); ?>" />
				<br />
				<span class="ff-2"><?php echo $account->code; ?></span>
				<div class="h-10"></div>
				<div class="fs-14 bold"><?php echo $account->name; ?></div>
				
		

			</div>
		</div> <!-- /.col -->
	</div> <!-- /.row -->
	<div class="clearfix"></div>



<?php get_footer_print($args); ?>