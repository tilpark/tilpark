

<style>
body {
	margin:0px;
	padding:0px;
}
.barcode_box_9999 {
	width: <?php echo get_setting('product_barcode_box_width'); ?>;
	height: <?php echo get_setting('product_barcode_box_height'); ?>;
	<?php if(get_setting('product_barcode_box_border_color')): ?>
		border:1px solid <?php echo get_setting('product_barcode_box_border_color'); ?>;
	<?php endif; ?>
}
.barcode_9999 {
	width: <?php echo get_setting('product_barcode_width'); ?>;
	height: <?php echo get_setting('product_barcode_height'); ?>;
	<?php if(get_setting('product_barcode_border_color')): ?>
		border:1px solid <?php echo get_setting('product_barcode_border_color'); ?>;
	<?php endif; ?>
}
.barcode_text_9999 {
	font-size:<?php echo get_setting('product_barcode_name_font_size'); ?>px;
	font-family: tahoma;
}
</style>
<div class="barcode_box_9999">

	<img src="<?php echo get_barcode($product['code']); ?>" class="barcode_9999"  />
	<br />

	<?php if(get_setting('product_barcode_name') == '1'): ?>
		<span class="barcode_text_9999"><?php echo $product['name']; ?></span>
	<?php endif; ?>
	
</div>

<?php if(isset($_GET['print'])) : ?>
	<script>
		function print_and_goback() 
		{ 
			window.print();
			setTimeout(function(){ window.history.back(); }, 100);
		}
		setTimeout(print_and_goback(), 500);
	</script>
<?php endif; ?>