<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Ürün Yönetimi' );
add_page_info( 'nav', array('name'=>'Ürün Yönetimi') );
?>



<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<span class="fs-13 text-muted">Seçenekler</span>
		<div class="list-group mobile-full list-menu">
			<a href="<?php echo site_url('admin/system/options'); ?>" class="list-group-item">Genel Ayarlar</a>
			<a href="<?php echo site_url('admin/system/form_status'); ?>" class="list-group-item">Form Durumları</a>
			<a href="<?php echo site_url('admin/system/case'); ?>" class="list-group-item">Kasa & Banka</a>
			<a href="<?php echo site_url('admin/system/info'); ?>" class="list-group-item">Hakkımızda</a>
		</div>

		<div class="h-20 visible-xs"></div>

	</div> <!-- /.col-md-6 -->
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

	</div>
</div> <!-- /.row -->



<?php get_footer(); ?>