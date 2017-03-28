<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Ürün Yönetimi' );
add_page_info( 'nav', array('name'=>'Ürün Yönetimi') );
?>



<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<div class="row space-5">
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/item/add.php'); ?>">
						<span class="count"><i class="fa fa-plus-square-o"></i></span>
						<h3>Yeni</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/item/list.php'); ?>">
						<span class="count"><i class="fa fa-list"></i></span>
						<h3>Ürün Kartları</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<div class="h-20 visible-xs"></div>

	</div> <!-- /.col-md-6 -->
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

	</div>
</div> <!-- /.row -->



<?php get_footer(); ?>