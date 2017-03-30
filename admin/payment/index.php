<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Kasa/Banka' );
add_page_info( 'nav', array('name'=>'Kasa/Banka') );
?>




<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<div class="row space-5">
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/payment/detail.php?in'); ?>">
						<span class="icon-box"><i class="fa fa-plus-square-o"></i></span>
						<h3>Yeni Ödeme Girişi</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/payment/detail.php?out'); ?>">
						<span class="icon-box"><i class="fa fa-minus-square-o"></i></span>
						<h3>Yeni Ödeme Çıkışı</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/payment/list.php'); ?>">
						<span class="icon-box"><i class="fa fa-list"></i></span>
						<h3>Ödemeler</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<div class="h-20 visible-xs"></div>

	</div> <!-- /.col-md-6 -->
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<?php if($cases = get_case_all(array('is_bank'=>0))): ?>
			<div class="clearfix"></div>
			<div class="list-group mobile-full list-menu">
				<?php foreach($cases as $case): ?>
					<a href="list.php?status_id=<?php echo $case->id; ?>" class="list-group-item">
						<?php echo $case->name; ?>
						<span class="badge"><?php echo get_set_money($case->total); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>


		<?php if($banks = get_case_all(array('is_bank'=>1))): ?>
			<div class="h-20"></div>
			<div class="h-20 visible-xs"></div>
			<div class="clearfix"></div>
			<div class="list-group mobile-full list-menu">
				<?php foreach($banks as $bank): ?>
					<a href="list.php?status_id=<?php echo $bank->id; ?>" class="list-group-item">
						<?php echo $bank->name; ?>
						<span class="badge"><?php echo get_set_money($bank->total); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</div> <!-- /.row -->








<?php get_footer(); ?>