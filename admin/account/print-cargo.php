<?php require_once('../../tilpark.php'); ?>
<?php 
if(!$account = get_account($_GET['id'])) {
	add_console_log('Hesap karti bulunamadi.', 'print-address.php');
	exit;
}

if(!$print = get_option('account_print_cargo')) {
	@$print->width = 90;
	@$print->height = 90;
}
?>

<?php include_content_page('print', 'address', 'account', array('account'=>@$account)); ?>	

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
	.rotate90 {
		 -webkit-transform: rotate(-90deg);
	    -moz-transform: rotate(-90deg);
	    -o-transform: rotate(-90deg);
	    -ms-transform: rotate(-90deg);
	    transform: rotate(-90deg);
	}
	</style>


	<div class="row space-none">
		<div class="col-xs-2 pr-1">
			<div class="fs-18 text-muted rotate90" style="margin-top: 80px;">GÖNDEREN</div>
		</div>
		<div class="col-xs-10 pl-1">

			<div class="p-10 br-3">
				
				<br />
				<div class="fs-14 bold"><?php echo til()->company->name; ?></div>
				<div class="fs-11"><?php echo til()->company->address; ?></div>
				<div class="fs-11"><?php echo til()->company->district; ?><?php echo til()->company->city ? '/' : ''; ?><?php echo til()->company->city; ?><?php echo til()->company->country ? ' - ' : ''; ?><?php echo til()->company->country; ?></div>
				<div class="fs-11"><?php echo get_set_show_phone(til()->company->phone); ?></div>
				<div class="fs-11"><?php echo til()->company->email; ?></div>
			</div>
			
		</div> <!-- /.col -->
	</div> <!-- /.row -->

	<hr / style="margin-top:10px; margin-bottom: 10px;">

	<div class="row space-none">
		
		<div class="col-xs-2 pr-1">
			<div class="fs-18 text-muted rotate90" style="margin-top: 90px;">ALICI</div>
		</div>
		<div class="col-xs-10 pl-1">


			<div class="p-10 br-3">

				<img src="<?php barcode_url( $account->code, array('position'=>'left') ); ?>" />
				<br />
				<span class="ff-2"><?php echo $account->code; ?></span>
				<div class="h-20"></div>


				<div class="fs-14 bold"><?php echo $account->name; ?></div>
				<div class="fs-11"><?php echo $account->address; ?></div>
				<div class="fs-11"><?php echo $account->district; ?><?php echo ($account->city && $account->district) ? '/' : ''; ?><?php echo $account->city; ?><?php echo $account->country ? ' - ' : ''; ?><?php echo $account->country; ?></div>
				<div class="fs-11"><?php echo get_set_show_phone($account->gsm); ?><?php echo $account->gsm && $account->phone ? ' - ' : ''; ?><?php echo get_set_show_phone($account->phone); ?></div>
				<div class="fs-11"><?php echo $account->tax_home ? 'V. Dairesi: '.$account->tax_home : ''; ?> <?php echo ($account->tax_home and $account->tax_no) ? ' - ': ''; ?> <?php echo $account->tax_no ? 'V. No: '.$account->tax_no : ''; ?></div>
				<?php if($account->email): ?><div class="fs-11"><?php echo $account->email; ?></div><?php endif; ?>
		

			</div>
		</div> <!-- /.col -->
	</div> <!-- /.row -->
	<div class="clearfix"></div>



<?php get_footer_print($args); ?>