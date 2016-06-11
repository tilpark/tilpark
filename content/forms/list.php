<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<?php
// Header Bilgisi
$breadcrumb[0] = array('name'=>'Form Yönetimi', 'url'=>get_site_url('content/forms/'));
$breadcrumb[1] = array('name'=>'Form Listesi', 'url'=>'', 'active'=>true);
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

	</div> <!-- /.panel-body -->
</div> <!-- /.panel-default -->





<?php til_table(array('url'=>get_site_url('content/forms/_q_search.php'))); ?>




<?php get_footer(); ?>