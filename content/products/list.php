<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<?php
// Header Bilgisi
$breadcrumb[0] = array('name'=>'Ürün Yönetimi', 'url'=>get_site_url('content/products/'));
$breadcrumb[1] = array('name'=>'Ürün Kartları', 'url'=>'', 'active'=>true);
?>




<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-list"></i> Formlar 
		<div class="pull-right" style="width:200px; margin-top:-5px;">
			<?php til_table_search_box(); ?>
		</div> <!-- /.pull-right -->
	</div> <!-- /.panel-heading -->
	<div class="panel-body">
		
		<div id="til-table"></div>
		<?php til_table(array('url'=>get_site_url('content/products/_q_search.php'))); ?>

	</div> <!-- /.panel-body -->
</div> <!-- /.panel-default -->











<?php get_footer(); ?>