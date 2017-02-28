<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Form Yönetimi' );
add_page_info( 'nav', array('name'=>'Form Yönetimi') );
?>



<?php if($form_status_all = get_form_status_all('1')): ?>
<div class="clearfix">
	<?php foreach($form_status_all as $status): ?>

			<div class="widget-menu right" style="border-bottom:1px solid <?php echo $status->bg_color; ?>;">
				<a href="list.php?status_id=<?php echo $status->id; ?>" class="">
					<span class="count"><?php echo $status->count = calc_form_status($status->id); ?></span>
					<h3><?php echo $status->name; ?></h3>
				</a>
			</div> <!-- /.widget-menu -->

	<?php endforeach; ?>
</div>
<?php endif; ?>

<?php get_footer(); ?>