<link href="<?php echo template_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/app.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">

<?php 
if(!isset($print['size'])) { $print['size'] = 'A4'; } 
if(!isset($print['logo'])) { $print['logo'] = true; } 
if(!isset($print['footer'])) { $print['footer'] = true; } 

?>
<div class="print-page" size="<?php echo $print['size']; ?>">

	<?php if($print['logo']): ?>
		<div class="print-tilpark-logo">
			<img src="<?php site_url('content/themes/default/img/logo_blank.png'); ?>" class="img-responsive">
		</div>
	<?php endif; ?>

	<?php if(@$print['title']): ?>
		<div class="text-center absolute full-width">
			<h3 class="content-title text-center m-0"><?php echo @$print['title']; ?></h3>
			<h4 class="content-title text-center m-0"><?php echo @$print['sub-title']; ?></h4>
		</div> <!-- /.text-center -->
	<?php endif; ?>


	<div class="pull-right">
		<div class="text-right">
			<?php if(@$print['date']): ?><h4 class="content-title"><small class="text-muted"><?php echo $print['date']; ?></small></h4><?php endif; ?>
			<?php if(@$print['barcode']): ?><div><img src="<?php barcode_url($print['barcode'], array('position'=>'right') ); ?>" /></div><?php endif; ?>
			<?php if(@$print['barcode']): ?><div class="text-right"><?php echo $print['barcode']; ?></div><?php endif; ?>
		</div>
	</div> <!-- /.text-right -->

	<?php if(@$print['title']) : ?>
		<div class="clearfix"></div>	
		<div class="h-20"></div>
	<?php endif; ?>