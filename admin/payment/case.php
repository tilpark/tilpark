<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
// sayfa bilgileri
add_page_info( 'title', 'Kasa/Banka' );
add_page_info( 'nav', array('name'=>'Kasa/Banka', 'url'=>get_site_url('admin/payment/') ) );
?>

<?php if($case = get_case($_GET['status_id'])): ?>

<?php
// eger kasa/banka var ise sayfa bilgilerini gunceleyelim
add_page_info( 'title', $case->name );
add_page_info( 'nav', array('name'=>$case->name ) );

// ilk liste acilisinde sıralama yapilmasi icin
if(!isset($_GET['orderby_name'])) {
	$_GET['orderby_name'] = 'id';
	$_GET['orderby_type'] = 'DESC'; 
}

// odeme formlarini alalim
$forms = get_payments(array('_GET'=>true)); 

?>


<ul class="nav nav-tabs" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-id-card-o"></i> Kasa/Banka</a></li> 
	<li role="presentation" class=""><a href="#forms" role="tab" id="forms-tab" data-toggle="tab" aria-controls="forms" aria-expanded="false"><i class="fa fa-list"></i> Hareketler</a></li> 
	<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="false"><i class="fa fa-database"></i> Geçmiş</a></li> 
	<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-cogs"></i> Seçenekler <span class="caret"></span></a> 
		<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
			<li><a href="#dropdown1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1">Görev Ata</a></li> 
			<li><a href="#dropdown2" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2">E-posta Gönder</a></li>
		</ul> 
	</li>
	<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-print"></i> Yazdır <span class="caret"></span></a> 
		<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
			<li><a href="print_statement.php?id=<?php echo $account->id; ?>&print" target="_blank"><i class="fa fa-file-text-o fa-fw"></i> Ekstre Yazdır</a></li> 
			<li><a href="print_address.php?id=<?php echo $account->id; ?>&print" target="_blank"><i class="fa fa-address-book-o fa-fw"></i> Adres Kartı Yazdır</a></li>
		</ul> 
	</li>
</ul>






<div class="tab-content"> 
	<!-- tab:home -->
	<div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab"> 
		<?php print_r($case); ?>
	</div> 
	<!-- /tab:home -->

	<!-- tab:forms -->
	<div class="tab-pane fade" role="tabpanel" id="forms" aria-labelledby="forms-tab"> 

		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<h3 class="panel-title">Formlar</h3>
					</div> <!-- /.col-md-6 -->
					<div class="col-md-6">
						<div class="pull-right">
							
							<?php
								// panel arama
								$arr_s = array();
								$arr_s['s_name'] = 'forms';
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
							    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'pdf')))); ?>">Aktif Listeyi Aktar</a></li>
							    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'pdf', 'limit'=>'false')))); ?>">Hepsini Aktar <sup class="text-muted">(<?php echo $forms->num_rows; ?>)</sup></a></li>
							  </ul>
							</div>


							<!-- Single button -->
							<div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Excel">
							  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    <i class="fa fa-file-excel-o"></i>
							  </button>
							  <ul class="dropdown-menu dropdown-menu-right">
							  	<li class="dropdown-header"><i class="fa fa-download"></i> EXCEL AKTAR</li>
							    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'excel')))); ?>">Aktif Listeyi Aktar</a></li>
							    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'excel', 'limit'=>'false')))); ?>">Hepsini Aktar <sup class="text-muted">(<?php echo $forms->num_rows; ?>)</sup></a></li>
							  </ul>
							</div>


							<!-- Single button -->
							<div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Yazdır">
							  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    <i class="fa fa-print"></i>
							  </button>
							  <ul class="dropdown-menu dropdown-menu-right">
							  	<li class="dropdown-header"><i class="fa fa-file-o"></i> YAZDIR</li>
							    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'print')))); ?>" target="_blank">Aktif Listeyi Yazır</a></li>
							    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'print', 'limit'=>'false')))); ?>" target="_blank">Hepsini Yazdır <sup class="text-muted">(<?php echo $forms->num_rows; ?>)</sup></a></li>
							  </ul>
							</div>

						</div>
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->
			</div> <!-- /.panel-heading -->

			<?php if($forms): ?>
				<table class="table table-hover table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th width="100">Ödeme ID <?php echo get_table_order_by('id', 'ASC'); ?></th>
							<th width="100">Giriş/Çıkış</th>
							<th width="100">Tarih <?php echo get_table_order_by('date', 'ASC'); ?></th>
							<th>Hesap Kartı <?php echo get_table_order_by('account_name', 'ASC'); ?></th>
							<th width="100">Telefon <?php echo get_table_order_by('account_gsm', 'ASC'); ?></th>
							<th width="100">Şehir  <?php echo get_table_order_by('account_city', 'ASC'); ?></th>
							<th width="100">Ödeme <?php echo get_table_order_by('total', 'ASC'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($forms->list as $form): ?>
						<tr>
							<td><a href="detail.php?id=<?php echo $form->id; ?>">#<?php echo $form->id; ?></a></td>
							<td><?php echo get_in_out_label($form->in_out); ?></td>
							<td><small class="text-muted"><?php echo substr($form->date,0,16); ?></small></td>
							<td><?php if($form->account_id): ?><a href="../account/detail.php?id=<?php echo $form->account_id; ?>" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> <?php echo $form->account_name; ?></a> <?php else: ?><?php echo $form->account_name; ?><?php endif; ?></td>
							<td><?php echo $form->account_gsm; ?></td>
							<td><?php echo $form->account_city; ?></td>
							<td class="text-right"><?php echo get_set_money($form->total, true); ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				
				<?php pagination($forms->num_rows); ?>

			<?php else: ?>
				<div class="not-found">
					<?php print_alert(); ?>
				</div> <!-- /.not-found -->
			<?php endif; ?>

		</div> <!-- /.panel -->

	</div>
	<!-- /tab:forms -->

	<div class="tab-pane fade" role="tabpanel" id="logs" aria-labelledby="logs-tab"> 
		
	</div> 
	<div class="tab-pane fade" role="tabpanel" id="dropdown1" aria-labelledby="dropdown1-tab"> 
		<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p> 
	</div> 
	<div class="tab-pane fade" role="tabpanel" id="dropdown2" aria-labelledby="dropdown2-tab"> 
		<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p> 
	</div> 
</div> <!-- /.tab-content -->







<?php else: ?>
	<?php echo get_alert(_b($_GET['status_id']).' ID numarali kasa veya banka bulunamadı.'); ?>
<?php endif; ?>

<?php get_footer(); ?>