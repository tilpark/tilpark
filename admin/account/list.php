<?php include('../../tilpark.php'); ?>
<?php include_content_page('list', '', 'account'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Liste' );
add_page_info( 'nav', array('name'=>'Hesap', 'url'=>get_site_url('admin/account/') ) );
add_page_info( 'nav', array('name'=>'Liste') );

// iste acilisinde sıralama yapilmasi icin
if(!isset($_GET['orderby_name'])) {
	$_GET['orderby_name'] = 'name';
	$_GET['orderby_type'] = 'ASC'; 
}
$accounts = get_accounts(array('_GET'=>true)); ?>

<?php
if(til_is_mobile()) :
	// panel arama
	$arr_s = array();
	$arr_s['s_name'] = 'accounts';
	$arr_s['db-s-where'][] = array('name'=>'Hesap Adı', 'val'=>'name');
	$arr_s['db-s-where'][] = array('name'=>'Hesap Kodu', 'val'=>'code');
	$arr_s['db-s-where'][] = array('name'=>'Cep Telefonu', 'val'=>'gsm');
	$arr_s['db-s-where'][] = array('name'=>'Sabit Telefon', 'val'=>'phone');
	$arr_s['db-s-where'][] = array('name'=>'Şehir - İl', 'val'=>'city');
	$arr_s['db-s-where'][] = array('name'=>'Vergi veya T.C. No', 'val'=>'tax_no');
	search_form_for_panel($arr_s); 
endif;
?>

<div class="panel panel-default panel-table">
	<div class="panel-heading hidden-xs">
		<div class="row">
			<div class="col-xs-6 col-md-6">
				<h3 class="panel-title">Hesap Kartları</h3>
			</div> <!-- /.col-md-6 -->
			<div class="col-xs-6 col-md-6">
				<div class="pull-right">
					
					<?php
					if(!til_is_mobile()) :
						// panel arama
						$arr_s = array();
						$arr_s['s_name'] = 'accounts';
						$arr_s['db-s-where'][] = array('name'=>'Hesap Adı', 'val'=>'name');
						$arr_s['db-s-where'][] = array('name'=>'Hesap Kodu', 'val'=>'code');
						$arr_s['db-s-where'][] = array('name'=>'Cep Telefonu', 'val'=>'gsm');
						$arr_s['db-s-where'][] = array('name'=>'Sabit Telefon', 'val'=>'phone');
						$arr_s['db-s-where'][] = array('name'=>'Şehir - İl', 'val'=>'city');
						$arr_s['db-s-where'][] = array('name'=>'Vergi veya T.C. No', 'val'=>'tax_no');
						search_form_for_panel($arr_s); 
					endif;
					?>
				

					<!-- Single button -->
					<div class="btn-group btn-icon hidden-xs" data-toggle="tooltip" data-placement="top" title="Pdf">
					  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-file-pdf-o"></i>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-right">
					  	<li class="dropdown-header"><i class="fa fa-download"></i> PDF AKTAR</li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'pdf')))); ?>">Aktif Listeyi Aktar</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'pdf', 'limit'=>'false')))); ?>">Hepsini Aktar <sup class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
					  </ul>
					</div>


					<!-- Single button -->
					<div class="btn-group btn-icon hidden-xs" data-toggle="tooltip" data-placement="top" title="Excel">
					  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-file-excel-o"></i>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-right">
					  	<li class="dropdown-header"><i class="fa fa-download"></i> EXCEL AKTAR</li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'excel')))); ?>">Aktif Listeyi Aktar</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'excel', 'limit'=>'false')))); ?>">Hepsini Aktar <sup class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
					  </ul>
					</div>


					<!-- Single button -->
					<div class="btn-group btn-icon hidden-xs" data-toggle="tooltip" data-placement="top" title="Yazdır">
					  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-print"></i>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-right">
					  	<li class="dropdown-header"><i class="fa fa-file-o"></i> YAZDIR</li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'print')))); ?>" target="_blank">Aktif Listeyi Yazdır</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'print', 'limit'=>'false')))); ?>" target="_blank">Hepsini Yazdır <sup class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
					    <li class="divider"></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters( array('add'=> array('export'=>'print', 'addBarcode'=>true )) )); ?>" target="_blank">Barkodlu Aktif Listeyi Yazdır</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters( array('add'=> array('export'=>'print', 'limit'=>'false', 'addBarcode'=>true)) )); ?>" target="_blank">Barkodlu Hepsini Yazdır <sup class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
					  </ul>
					</div>

				</div>
			</div> <!-- /.col-md-6 -->
		</div> <!-- /.row -->
	</div> <!-- /.panel-heading -->

	<?php if($accounts): ?>
		<table class="table table-hover table-bordered table-condensed table-striped">
			<thead>
				<tr>
					<th class="hidden-xs" width="200">Hesap Kodu <?php echo get_table_order_by('code', 'ASC'); ?></th>
					<th>Hesap Adı <?php echo get_table_order_by('name', 'ASC'); ?></th>
					<th  width="100"><span class="hidden-xs">Cep Telefonu</span><span class="visible-xs-inline">Gsm</span> <?php echo get_table_order_by('gsm', 'ASC'); ?></th>
					<th class="hidden-xs" width="100">Sabit Telefon <?php echo get_table_order_by('phone', 'ASC'); ?></th>
					<th class="hidden-xs" width="100">Şehir <?php echo get_table_order_by('city', 'ASC'); ?></th>
					<th width="100">Bakiye <?php echo get_table_order_by('balance', 'ASC'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($accounts->list as $account): ?>
				<tr>
					<td class="hidden-xs"><a href="detail.php?id=<?php echo $account->id; ?>"><?php echo $account->code; ?></a></td>
					<td><a href="detail.php?id=<?php echo $account->id; ?>"><?php echo $account->name; ?></a></td>
					<td><?php echo $account->gsm; ?></td>
					<td class="hidden-xs"><?php echo $account->phone; ?></td>
					<td class="hidden-xs"><?php echo $account->city; ?></td>
					<td class="text-right"><?php echo get_set_money($account->balance, true); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php pagination($accounts->num_rows); ?>

	<?php else: ?>
		<div class="not-found">
			<?php print_alert(); ?>
		</div> <!-- /.not-found -->
	<?php endif; ?>

</div> <!-- /.panel -->



<?php get_footer(); ?>