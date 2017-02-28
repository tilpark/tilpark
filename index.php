<?php include('tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Yönetim Paneli' );
?>



<div class="row">
	<div class="col-md-6">


	<div class="row space-10">
		<div class="col-md-3">
			<div class="widget-menu">
				<a href="<?php site_url('admin/form/detail.php?out'); ?>">
					<span class="count"><i class="fa fa-cart-plus"></i></span>
					<h3>Yeni Satış Formu</h3>
				</a>
			</div> <!-- /.widget-menu -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="widget-menu">
				<a href="<?php site_url('admin/form/detail.php?in'); ?>">
					<span class="count"><i class="fa fa-cart-arrow-down"></i></span>
					<h3>Yeni Alış Formu</h3>
				</a>
			</div> <!-- /.widget-menu -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="widget-menu">
				<a href="<?php site_url('admin/account/add.php'); ?>">
					<span class="count"><i class="fa fa-address-card-o"></i></span>
					<h3>Yeni Hesap Kartı</h3>
				</a>
			</div> <!-- /.widget-menu -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="widget-menu">
				<a href="<?php site_url('admin/item/add.php'); ?>">
					<span class="count"><i class="fa fa-cube"></i></span>
					<h3>Yeni Ürün Kartı</h3>
				</a>
			</div> <!-- /.widget-menu -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="widget-menu">
				<a href="<?php site_url('admin/payment'); ?>">
					<span class="count"><i class="fa fa-bank"></i></span>
					<h3>Kasa & Banka</h3>
				</a>
			</div> <!-- /.widget-menu -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="widget-menu">
				<a href="<?php site_url('admin/form/list.php'); ?>">
					<span class="count"><i class="fa fa-file-text-o"></i></span>
					<h3>Tüm Formlar</h3>
				</a>
			</div> <!-- /.widget-menu -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="widget-menu">
				<a href="<?php site_url('admin/account/list.php'); ?>">
					<span class="count"><i class="fa fa-file-text-o"></i></span>
					<h3>Hesap Kartları</h3>
				</a>
			</div> <!-- /.widget-menu -->
		</div> <!-- /.col-md-3 -->
		<div class="col-md-3">
			<div class="widget-menu">
				<a href="<?php site_url('admin/item/list.php'); ?>">
					<span class="count"><i class="fa fa-file-text-o"></i></span>
					<h3>Ürün Kartları</h3>
				</a>
			</div> <!-- /.widget-menu -->
		</div> <!-- /.col-md-3 -->
	</div> <!-- /.row -->

		

		

		


	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">
		
		
		
		
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Son 1 Hafta Grafik Özeti</h3></div>
			<div class="panel-body">
				<?php include root_path('content/themes/default/widgets/dashboard_chart_in_out.php'); ?>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->
		

	</div>
</div> <!-- /.row -->

<div class="h-20"></div>










<?php get_footer(); ?>