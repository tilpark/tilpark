<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>


<?php
$breadcrumb[0] = array('name'=>'Form Yönetimi');
?>


<div class="row">
	<div class="col-md-2">
		<a href="<?php site_url('content/forms/add.php?in_out=1'); ?>" class="box-item">
			<i class="fa fa-shopping-cart"><i class="fa fa-level-up text-primary"></i></i>
			<h3>Yeni Çıkış</h3>
			<small class="text-muted">yeni ürün/hizmet satışı</small>
		</a>
	</div> <!-- /.col-md-2 -->
	<div class="col-md-2">
		<a href="<?php site_url('content/forms/add.php?in_out=0'); ?>" class="box-item">
			<i class="fa fa-shopping-cart"><i class="fa fa-level-down text-primary"></i></i>
			<h3>Yeni Giriş</h3>
			<small class="text-muted">yeni ürün/hizmet alışı</small>
		</a>
	</div> <!-- /.col-md-2 -->
	<div class="col-md-2">
		<a href="<?php site_url('content/forms/list.php'); ?>" class="box-item">
			<i class="fa fa-list"></i>
			<h3>Formlar</h3>
			<small class="text-muted">form listesi</small>
		</a>
	</div> <!-- /.col-md-2 -->
</div> <!-- /.row -->


<?php get_sidebar_end(); ?>
<?php get_footer(); ?>