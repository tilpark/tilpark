<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php $item = get_item($_GET['id']); ?>
<?php 
if(isset($_POST['update'])) {
	if(update_item($item->id, $_POST)) {
		$item = get_item($item->id);
	}
}

if(isset($_GET['status'])) {
	if($_GET['status'] == '0' OR $_GET['status'] == '1') {
		if(update_item($item->id, array('update'=>array('status'=>$_GET['status']), 'add_alert'=>false))) {
			$item = get_item($item->id);
		}	
	}
}
?>



<?php if($item): ?>
	<?php
	add_page_info( 'title', $item->name );
	add_page_info( 'nav', array('name'=>'Ürün Yönetimi', 'url'=>get_site_url('admin/item/') ) );
	add_page_info( 'nav', array('name'=>'Ürün Kartları Listesi', 'url'=>get_site_url('admin/item/list.php') ) );
	add_page_info( 'nav', array('name'=>$item->name ) );
	?>



	<?php if($item->status == '0'): ?>
		<?php echo get_alert('<i class="fa fa-trash-o"></i> <b>Dikkat!</b> ürün kartı pasif durumda.', 'warning', false); ?>
	<?php else: ?>
		<?php create_modal(array('id'=>'status_item', 
			'title'=>'Ürün kartı <u>pasifleştirme</u>', 
			'content'=>_b($item->name).' ürün kartını pasifleştirmek istiyor musun? <br /> <small>Ürün kartı veritabanından <u>silinmez</u>. Fakat arama ve listelemelerde bulunamaz. <br /> Herhangi gibi bir form hareketi var ise cari ekstre detayları ve form hareketlerinde görünür.</small>', 
			'btn'=>'<a href="?id='.$item->id.'&status=0" class="btn btn-danger">Evet, onaylıyorum</a>')); ?>
	<?php endif; ?>
	



	<ul class="nav nav-tabs" role="tablist"> 
		<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-id-card-o"></i> Ürün Kartı</a></li> 
		<li role="presentation" class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false"><i class="fa fa-list"></i> Formlar</a></li> 
		<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="false"><i class="fa fa-database"></i> Geçmiş</a></li> 
		
		<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-cogs"></i> Seçenekler <span class="caret"></span></a> 
			<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
				<li><a href="<?php site_url('admin/user/task/add.php?attachment&item_id='.$item->id); ?>" target="_blank"><i class="fa fa-tasks fa-fw"></i> Görev Ekine Ekle</a></li> 
				<li><a href="<?php site_url('admin/user/message/add.php?attachment&item_id='.$item->id); ?>" target="_blank"><i class="fa fa-envelope-o fa-fw"></i> Mesaj Ekine Ekle</a></li> 
				<li role="separator" class="divider"></li>
				<?php if($item->status == '1'): ?>
					<li><a href="#"  data-toggle="modal" data-target="#status_item"><i class="fa fa-trash-o fa-fw text-danger"></i> Sil</a></li>
				<?php else: ?>
					<li><a href="?id=<?php echo $item->id; ?>&status=1"><i class="fa fa-undo fa-fw text-success"></i> Aktifleştir</a></li>
				<?php endif; ?>
			</ul> 
		</li>

		<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-print"></i> Yazdır <span class="caret"></span></a> 
			<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
				<li><a href="print_barcode.php?id=<?php echo $item->id; ?>&print" target="_blank"><i class="fa fa-fw fa-barcode"></i> Barkod Yazdır</a></li> 
			</ul> 
		</li>
	</ul>


	<div class="tab-content"> 
		<div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab"> 
			<div class="row">
				<div class="col-md-8">
					<?php print_alert('update_item'); ?>
					
					<form name="form_add_accout" id="form_add_account" action="" method="POST" class="validate">

						<div class="row">
							<div class="col-md-6">

								<div class="form-group">
									<label for="code">Ürün Kodu <sup><i class="fa fa-barcode"></i> barkod kodu</sup> </label>
									<input type="text" name="code" id="code" value="<?php echo $item->code; ?>" class="form-control" minlength="3" maxlength="32">
								</div> <!-- /.form-group -->

								<div class="form-group">
									<label for="name">Ürün Adı <sup class="text-muted">ürün-hizmet-stok adı</sup></label>
									<input type="text" name="name" id="name" value="<?php echo $item->name; ?>" class="form-control required focus" minlength="3" maxlength="50">
								</div> <!-- /.form-group -->


								<div class="row">
									<div class="col-md-2">
										
									</div> <!-- /.col-md-2 -->
									<div class="col-md-5">
										<div class="form-group">
											<label for="p_purc_out_vat">Maliyet Fiyatı <sup class="text-muted"><u>KDV Hariç</u></sup></label>
											<input type="text" name="p_purc_out_vat" id="p_purc_out_vat" value="<?php echo get_set_money($item->p_purc_out_vat); ?>" class="form-control money" maxlength="15" disabled>
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-5 -->
									<div class="col-md-5">
										<div class="form-group">
											<label for="p_sale_out_vat">Satış Fiyatı <sup class="text-muted"><u>KDV Hariç</u></sup></label>
											<input type="text" name="p_sale_out_vat" id="p_sale_out_vat" value="<?php echo get_set_money($item->p_sale_out_vat); ?>" class="form-control money" maxlength="11" disabled>
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-5 -->
								</div> <!-- /.row -->


								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label for="vat">KDV <small class="text-muted">%</small>
											<input type="text" name="vat" id="vat" value="<?php echo $item->vat; ?>" class="form-control digits" maxlength="2" onkeyup="calc_vat();">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-2 -->
									<div class="col-md-5">
										<div class="form-group">
											<label for="p_purc">Maliyet Fiyatı</label>
											<input type="text" name="p_purc" id="p_purc" value="<?php echo get_set_money($item->p_purc); ?>" class="form-control money" maxlength="15" onkeyup="calc_vat();">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-5 -->
									<div class="col-md-5">
										<div class="form-group">
											<label for="p_sale">Satış Fiyatı</label>
											<input type="text" name="p_sale" id="p_sale" value="<?php echo get_set_money($item->p_sale); ?>" class="form-control money" maxlength="15" onkeyup="calc_vat();">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-5 -->
								</div> <!-- /.row -->


								<div class="text-right">
									<input type="hidden" name="update">
									<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">

									<button class="btn btn-default btn-insert"><i class="fa fa-floppy-o"></i> Kaydet</button>
								</div>

							</div> <!-- /.col-md-6 -->
							<div class="col-md-6">

								
							</div> <!-- /.col-md-6 -->
						</div> <!-- /.row -->
					</form>
				</div> <!-- /.col-md-8 -->
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Deneme</h3>
						</div> <!-- /.panel-heading -->
						<div class="panel-body">
							<img alt="testing" src="<?php barcode_url($item->code); ?>" />
						</div> <!-- /.panel-body -->
					</div> <!-- /.panel-default -->
				</div> <!-- /.col-md-4 -->
			</div> <!-- /.row -->

		</div> 
		<div class="tab-pane fade" role="tabpanel" id="profile" aria-labelledby="profile-tab"> 
			<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p> 
		</div> 
		<div class="tab-pane fade" role="tabpanel" id="logs" aria-labelledby="logs-tab"> 
			<?php theme_get_logs(" table_id='items:".$item->id."' "); ?>
		</div> 
		<div class="tab-pane fade" role="tabpanel" id="dropdown1" aria-labelledby="dropdown1-tab"> 
			<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p> 
		</div> 
		<div class="tab-pane fade" role="tabpanel" id="dropdown2" aria-labelledby="dropdown2-tab"> 
			<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p> 
		</div> 
	</div> <!-- /.tab-content -->




	<script>
	/**
	 * math_vat_rate()
	 * KDV tutarindaki degeleri alip basina "1." veya "1.0" gibi degerler ekler.
	 */
	function math_vat_rate(vat) {
		var math_tax_rate = '';
		if(vat.length == 2){ math_tax_rate =  parseFloat('1.'+vat); }
		else { math_tax_rate = parseFloat('1.'+'0'+vat); }
		return math_tax_rate;
	}


	/**
	 * cal_vat()
	 * Ürün ekleme ve ürün detay görünmünde maliyet ve satış fiyatlarının KDV'siz tutarlarını hesaplar
	 */
	function calc_vat() {
		var p_purc 	= $('#p_purc').val();
		var p_sale 	= $('#p_sale').val();
		var p_vat 	= math_vat_rate($('#vat').val());

		// degeler numeric mi? degil mi?
		if(!$.isNumeric(p_purc))	{ p_purc 	= 0.00; 	}
		if(!$.isNumeric(p_sale))	{ p_sale 	= 0.00; 	}
		if(!$.isNumeric(p_vat))		{ p_vat 	= 0; 		}

		var p_purc_out_vat = p_purc / p_vat;
		var p_sale_out_vat = p_sale / p_vat;
		$('#p_purc_out_vat').val( p_purc_out_vat );
		$('#p_sale_out_vat').val( p_sale_out_vat );
	}
	</script>



<?php else: ?>
	<?php
	add_page_info( 'title', 'Ürün Kartı Bulunamadı' );
	add_page_info( 'nav', array('name'=>'Ürün Yönetimi', 'url'=>get_site_url('admin/item/') ) );
	add_page_info( 'nav', array('name'=>'Ürün Kartları Listesi', 'url'=>get_site_url('admin/item/list.php') ) );
	add_page_info( 'nav', array('name'=>'Ürün Kartı') );
	?>
	<?php print_alert(); ?>
<?php endif; ?>


<?php get_footer(); ?>