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
		<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-id-card-o"></i><span class="hidden-xs"> Ürün Kartı</span></a></li> 
		<li role="presentation" class=""><a href="#forms" role="tab" id="forms-tab" data-toggle="tab" aria-controls="forms" aria-expanded="false"><i class="fa fa-list"></i><span class="hidden-xs"> Formlar</span></a></li> 
		<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="false"><i class="fa fa-database"></i><span class="hidden-xs"> Geçmiş</span></a></li> 
		
		<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-cogs"></i><span class="hidden-xs"> Seçenekler </span><span class="caret"></span></a> 
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

		<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-print"></i><span class="hidden-xs"> Yazdır </span><span class="caret"></span></a> 
			<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
				<li><a href="print_barcode.php?id=<?php echo $item->id; ?>&print" target="_blank"><i class="fa fa-fw fa-barcode"></i> Barkod Yazdır</a></li> 
			</ul> 
		</li>
	</ul>


	<div class="tab-content"> 

		<!-- tab:home -->
		<div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab"> 
			
			<div class="row">
				<div class="col-md-6">
					<?php print_alert('update_item'); ?>
					
					<form name="form_add_accout" id="form_add_account" action="" method="POST" class="validate">
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
							<div class="col-xs-6 col-md-5">
								<div class="form-group">
									<label for="p_purc_out_vat">Maliyet Fiyatı <sup class="text-muted"><u>KDV Hariç</u></sup></label>
									<input type="text" name="p_purc_out_vat" id="p_purc_out_vat" value="<?php echo get_set_money($item->p_purc_out_vat); ?>" class="form-control money" maxlength="15" disabled>
								</div> <!-- /.form-group -->
							</div> <!-- /.col -->
							<div class="col-xs-6 col-md-5">
								<div class="form-group">
									<label for="p_sale_out_vat">Satış Fiyatı <sup class="text-muted"><u>KDV Hariç</u></sup></label>
									<input type="text" name="p_sale_out_vat" id="p_sale_out_vat" value="<?php echo get_set_money($item->p_sale_out_vat); ?>" class="form-control money" maxlength="11" disabled>
								</div> <!-- /.form-group -->
							</div> <!-- /.col-md-5 -->
						</div> <!-- /.row -->


						<div class="row">
							<div class="col-xs-6 col-md-2">
								<div class="form-group">
									<label for="vat">KDV <sup class="text-muted">(%)</sup></label>
									<input type="text" name="vat" id="vat" value="<?php echo $item->vat; ?>" class="form-control digits" maxlength="2" onkeyup="calc_vat();">
								</div> <!-- /.form-group -->
							</div> <!-- /.col -->
							<div class="clearfix visible-xs"></div>
							<div class="col-xs-6 col-md-5">
								<div class="form-group">
									<label for="p_purc">Maliyet Fiyatı</label>
									<input type="text" name="p_purc" id="p_purc" value="<?php echo get_set_money($item->p_purc); ?>" class="form-control money" maxlength="15" onkeyup="calc_vat();">
								</div> <!-- /.form-group -->
							</div> <!-- /.col -->
							<div class="col-xs-6 col-md-5">
								<div class="form-group">
									<label for="p_sale">Satış Fiyatı</label>
									<input type="text" name="p_sale" id="p_sale" value="<?php echo get_set_money($item->p_sale); ?>" class="form-control money" maxlength="15" onkeyup="calc_vat();">
								</div> <!-- /.form-group -->
							</div> <!-- /.col -->
						</div> <!-- /.row -->


						<div class="text-right">
							<input type="hidden" name="update">
							<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">

							<button class="btn btn-default btn-insert"><i class="fa fa-floppy-o"></i> Kaydet</button>
						</div>
					</form>
				</div> <!-- /.col -->
			</div> <!-- /.row -->

		</div>
		<!-- /tab:home -->



<script>
$(window).on("orientationchange",function(){
  if(window.orientation == 0) // Portrait
  {
    $("p").css({"background-color":"yellow","font-size":"300%"});
  }
  else // Landscape
  {
    $("p").css({"background-color":"pink","font-size":"200%"});
  }
});
</script>






		<!-- tab:forms -->
		<div class="tab-pane fade" role="tabpanel" id="forms" aria-labelledby="forms-tab"> 
			<?php $q_form_items = db()->query("SELECT * FROM ".dbname('form_items')." WHERE status='1' AND item_id='".$item->id."' ORDER BY date DESC"); ?>
			<?php if($q_form_items->num_rows): ?>
				<table class="table table-striped table-hover table-condensed table-bordered dataTable">
					<thead>
						<tr>
							<th width="120" class="hidden-portrait">Tarih</th>
							<th width="100">Form ID</th>
							<th class="hidden-portrait">Hesap Kartı</th>
							<th width="60" class="text-center">Adet</th>
							<th width="100" class="text-center">B. Fiyatı</th>
							<th width="100" class="text-center">Giriş</th>
							<th width="100" class="text-center">Çıkış</th>
						</tr>
					</thead>
					<tbody>
						<?php while($item = $q_form_items->fetch_object()): ?>
							<tr>
								<td class="hidden-portrait"><?php echo til_get_date($item->date, 'Y-m-d H:i'); ?></td>
								<td><a href="<?php site_url('form', $item->form_id); ?>" target="_blank">#<?php echo $item->form_id; ?></a></td>
								<td class="hidden-portrait">
									<?php if($item->account_id): ?>
										<?php echo get_account($item->account_id)->name; ?> <a href="<?php site_url('account', $item->account_id); ?>" target="_blank" class="fs-12"><i class="fa fa-external-link"></i></a>
									<?php endif; ?>
								</td>
								<td class="text-center"><?php echo $item->quantity; ?></td>
								<td class="text-right"><?php echo get_set_money($item->price, true); ?></td>
								<td class="text-right"><?php echo $item->in_out == '0' ? get_set_money($item->total, true) : ''; ?></td>
								<td class="text-right"><?php echo $item->in_out == '1' ? get_set_money($item->total, true) : ''; ?></td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			<?php else: ?>
				<?php echo get_alert(array('title'=>'Form Hareketi Yok', 'description'=>'Bu ürün kartı için henüz bir form hareketi eklenmemiş.'), 'warning', false); ?>
			<?php endif; ?>
		</div>
		<!-- /tab:forms -->







		<!-- tab:logs -->
		<div class="tab-pane fade" role="tabpanel" id="logs" aria-labelledby="logs-tab"> 
			<?php theme_get_logs(" table_id='items:".$item->id."' "); ?>
		</div> 
		<!-- /tab:logs -->

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