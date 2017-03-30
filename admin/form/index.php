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
					<a href="<?php site_url('admin/form/detail.php?in'); ?>">
						<span class="icon-box"><i class="fa fa-cart-arrow-down"></i></span>
						<h3>Yeni Giriş Formu</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/form/detail.php?out'); ?>">
						<span class="icon-box"><i class="fa fa-cart-plus"></i></span>
						<h3>Yeni Çıkış Formu</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/form/list.php'); ?>">
						<span class="icon-box"><i class="fa fa-list"></i></span>
						<h3>Tüm Formlar</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<div class="h-20 visible-xs"></div>

	</div> <!-- /.col-md-6 -->
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<?php if($form_status_all = get_form_status_all('1')): ?>

			<div class="clearfix"></div>
			<div class="list-group mobile-full list-menu">
				<?php foreach($form_status_all as $status): ?>
					<a href="list.php?status_id=<?php echo $status->id; ?>" class="list-group-item">
						<?php echo $status->name; ?>
						<span class="badge" style="background-color:<?php echo $status->bg_color; ?>; color:<?php echo $status->color; ?>;"><?php echo $status->count = calc_form_status($status->id); ?>2324</span>
					</a>
				<?php endforeach; ?>
			</div>

		<?php endif; ?>


		<?php if($form_status_all = get_form_status_all('0')): ?>
			<div class="h-20"></div>
			<div class="h-20 visible-xs"></div>
			<div class="clearfix"></div>
			<div class="list-group mobile-full list-menu">
				<?php foreach($form_status_all as $status): ?>
					<a href="list.php?status_id=<?php echo $status->id; ?>" class="list-group-item">
						<?php echo $status->name; ?>
						<span class="badge" style="background-color:<?php echo $status->bg_color; ?>; color:<?php echo $status->color; ?>;"><?php echo $status->count = calc_form_status($status->id); ?>2324</span>
					</a>
				<?php endforeach; ?>
			</div>

		<?php endif; ?>
	</div>
</div> <!-- /.row -->





<?php get_footer(); ?>