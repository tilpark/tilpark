<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Form Yönetimi' );
add_page_info( 'nav', array('name'=>'Form Yönetimi') );
?>



<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<div class="row space-5">
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/form/add.php'); ?>">
						<span class="icon-box"><i class="fa fa-plus-square-o"></i></span>
						<h3>Yeni</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/form/list.php'); ?>">
						<span class="icon-box"><i class="fa fa-list"></i></span>
						<h3>Hesap Kartları</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<div class="h-20 visible-xs"></div>

	</div> <!-- /.col-md-6 -->
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

	</div>
</div> <!-- /.row -->



<?php if($form_status_all = get_form_status_all('1')): ?>




	<div class="clearfix"></div>
	<div class="row space-5 box-row">
		<?php foreach($form_status_all as $status): ?>
			<div class="til-col col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu" style="border-bottom:1px solid <?php echo $status->bg_color; ?>;">
					<a href="list.php?status_id=<?php echo $status->id; ?>">
						<span class="icon-box fs-24"><?php echo $status->count = calc_form_status($status->id); ?>2324</span>
						<h3><?php echo $status->name; ?></h3>
					</a>
				</div> <!-- /.widget-menu -->
			</div>

		<?php endforeach; ?>
		<?php foreach($form_status_all as $status): ?>
			<div class="til-col col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu" style="border-bottom:1px solid <?php echo $status->bg_color; ?>;">
					<a href="list.php?status_id=<?php echo $status->id; ?>" class="">
						<span class="icon-box fs-24"><?php echo $status->count = calc_form_status($status->id); ?>2324</span>
						<h3><?php echo $status->name; ?></h3>
					</a>
				</div> <!-- /.widget-menu -->
			</div>

		<?php endforeach; ?>
	</div>

<?php endif; ?>

<?php get_footer(); ?>