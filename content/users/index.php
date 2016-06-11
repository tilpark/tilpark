<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>


<?php
$breadcrumb[0] = array('name'=>'Hesap Yönetimi');
?>


<div class="row">
	<div class="col-md-2">
		<a href="<?php site_url('content/accounts/add.php'); ?>" class="box-item">
			<i class="fa fa-user"><i class="fa fa-plus text-success"></i></i>
			<h3>Yeni Hesap Kartı</h3>
			<small class="text-muted">hesap kartı oluşturun</small>
		</a>
	</div> <!-- /.col-md-2 -->
	<div class="col-md-2">
		<a href="<?php site_url('content/accounts/list.php'); ?>" class="box-item">
			<i class="fa fa-list-ol"></i>
			<h3>Hesap Kartları</h3>
			<small class="text-muted">hesap kartları listesi</small>
		</a>
	</div> <!-- /.col-md-2 -->
</div> <!-- /.row -->


<?php get_sidebar_end(); ?>
<?php get_footer(); ?>