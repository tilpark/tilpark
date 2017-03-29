<?php include('../../tilpark.php'); ?>
<?php include_content_page('list', false, 'item'); ?>	
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Ürün Kartları Listesi' );
add_page_info( 'nav', array('name'=>'Ürün Yönetimi', 'url'=>get_site_url('admin/item/') ) );
add_page_info( 'nav', array('name'=>'Ürün Kartları Listesi') );

// ilk liste acilisinde sıralama yapilmasi icin
if(!isset($_GET['orderby_name'])) {
	$_GET['orderby_name'] = 'name';
	$_GET['orderby_type'] = 'ASC'; 
}

$items = get_items(array('_GET'=>true)); ?>


<?php
if( til_is_mobile() ) {
	// panel arama
	$arr_s = array();
	$arr_s['s_name'] = 'items';
	$arr_s['db-s-where'][] = array('name'=>'Ürün Adı', 'val'=>'name');
	$arr_s['db-s-where'][] = array('name'=>'Ürün Kodu', 'val'=>'code');
	search_form_for_panel($arr_s); 
}
?>


<div class="panel panel-default panel-table">
	<?php if( !til_is_mobile() ): ?>
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title">Ürün Kartları</h3>
			</div> <!-- /.col-md-6 -->
			<div class="col-md-6">
				<div class="pull-right">
					
					<?php
						// panel arama
						$arr_s = array();
						$arr_s['s_name'] = 'items';
						$arr_s['db-s-where'][] = array('name'=>'Ürün Adı', 'val'=>'name');
						$arr_s['db-s-where'][] = array('name'=>'Ürün Kodu', 'val'=>'code');
						search_form_for_panel($arr_s); 
					?>
				

					<!-- Single button -->
					<div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Pdf">
					  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-file-pdf-o"></i>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-right">
					  	<li class="dropdown-header"><i class="fa fa-download"></i> PDF AKTAR</li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'pdf')))); ?>">Aktif Listeyi Aktar</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'pdf', 'limit'=>'false')))); ?>">Hepsini Aktar <sup class="text-muted">(<?php echo $items->num_rows; ?>)</sup></a></li>
					  </ul>
					</div>


					<!-- Single button -->
					<div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Excel">
					  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-file-excel-o"></i>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-right">
					  	<li class="dropdown-header"><i class="fa fa-download"></i> EXCEL AKTAR</li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'excel')))); ?>">Aktif Listeyi Aktar</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'excel', 'limit'=>'false')))); ?>">Hepsini Aktar <sup class="text-muted">(<?php echo $items->num_rows; ?>)</sup></a></li>
					  </ul>
					</div>


					<!-- Single button -->
					<div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Yazdır">
					  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-print"></i>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-right">
					  	<li class="dropdown-header"><i class="fa fa-file-o"></i> YAZDIR</li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'print')))); ?>" target="_blank">Aktif Listeyi Yazdır</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'print', 'limit'=>'false')))); ?>" target="_blank">Hepsini Yazdır <sup class="text-muted">(<?php echo $items->num_rows; ?>)</sup></a></li>
					    <li class="divider"></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters( array('add'=> array('export'=>'print', 'addBarcode'=>true)) )); ?>" target="_blank">Barkodlu Aktif Listeyi Yazır</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters( array('add'=> array('export'=>'print', 'limit'=>'false', 'addBarcode'=>true)) )); ?>" target="_blank">Barkodlu Hepsini Yazdır <sup class="text-muted">(<?php echo $items->num_rows; ?>)</sup></a></li>
					  </ul>
					</div>

				</div>
			</div> <!-- /.col-md-6 -->
		</div> <!-- /.row -->
	</div> <!-- /.panel-heading -->
	<?php endif; ?>

	<?php if($items): ?>
		<table class="table table-hover table-bordered table-condensed table-striped">
			<thead>
				<?php if( til_is_mobile() ): ?>
					<tr>
						<th>Ürün Adı <?php echo get_table_order_by('name', 'ASC'); ?></th>
						<th>Maliyet <?php echo get_table_order_by('p_purc', 'ASC'); ?></th>
						<th>Şatış <?php echo get_table_order_by('p_sale', 'ASC'); ?></th>
						<th>&nbsp; <?php echo get_table_order_by('quantity', 'ASC'); ?></th>
					</tr>
				<?php else : ?>
					<tr>
						<th width="200">Ürün Kodu <?php echo get_table_order_by('code', 'ASC'); ?></th>
						<th>Ürün Adı <?php echo get_table_order_by('name', 'ASC'); ?></th>
						<th width="100">Maliyet Fiyatı <?php echo get_table_order_by('p_purc', 'ASC'); ?></th>
						<th width="100">Satış Fiyatı <?php echo get_table_order_by('p_sale', 'ASC'); ?></th>
						<th width="100">Miktar <?php echo get_table_order_by('quantity', 'ASC'); ?></th>
					</tr>
				<?php endif; ?>
			</thead>
			<tbody>
			<?php foreach($items->list as $item): ?>
				<?php if( til_is_mobile() ): ?>
					<tr>
						<td><a href="detail.php?id=<?php echo $item->id; ?>" class="fs-11"><?php echo til_get_substr($item->name,0,20); ?></a></td>
						<td class="text-right"><?php set_money($item->p_purc, true); ?></td>
						<td class="text-right"><?php set_money($item->p_sale, true); ?></td>
						<td class="text-center"><?php echo $item->quantity; ?></td>
					</tr>
				<?php else : ?>
					<tr>
						<td><a href="detail.php?id=<?php echo $item->id; ?>"><?php echo $item->code; ?></a></td>
						<td><a href="detail.php?id=<?php echo $item->id; ?>"><?php echo $item->name; ?></a></td>
						<td class="text-right"><?php set_money($item->p_purc, true); ?></td>
						<td class="text-right"><?php set_money($item->p_sale, true); ?></td>
						<td class="text-center"><?php echo $item->quantity; ?></td>
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php pagination($items->num_rows); ?>

	<?php else: ?>
		<div class="not-found">
			<?php print_alert(); ?>
		</div> <!-- /.not-found -->
	<?php endif; ?>

</div> <!-- /.panel -->



<?php get_footer(); ?>