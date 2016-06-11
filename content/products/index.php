<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>


<?php
$breadcrumb[0] = array('name'=>'Ürün Yönetimi');
?>


<div class="panel panel-default"><div class="panel-body">
<div class="row">
	<div class="col-md-2">
		<a href="<?php site_url('content/products/add.php'); ?>" class="box-item">
			<i class="fa fa-cubes"><i class="fa fa-plus text-success"></i></i>
			<h3>Yeni Ürün Kartı</h3>
			<small class="text-muted">ürün/hizmet kartı oluşturun</small>
		</a>
	</div> <!-- /.col-md-2 -->
	<div class="col-md-2">
		<a href="<?php site_url('content/products/list.php'); ?>" class="box-item">
			<i class="fa fa-list-ol"></i>
			<h3>Ürün Kartları</h3>
			<small class="text-muted">ürün/hizmet kartları listesi</small>
		</a>
	</div> <!-- /.col-md-2 -->
</div> <!-- /.row -->
</div></div> <!-- /.panel -->


<?php get_sidebar_end(); ?>
<?php get_footer(); ?>