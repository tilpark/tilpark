<?php include('../../tilpark.php'); ?>
<?php 
if(!$account = get_account($_GET['id'])) {
	add_page_info( 'title', 'Hesap Kartı');
	add_page_info( 'nav', array('name'=>'Hesap Yönetimi', 'url'=>get_site_url('admin/account/') ) );
	add_page_info( 'nav', array('name'=>'Hesap Listesi', 'url'=>get_site_url('admin/account/list.php') ) );
	add_page_info( 'nav', array('name'=>'Hesap Kartı') );
	get_header();
		print_alert();
	get_footer();
	return false;
}
include_content_page('detail', $account->type, 'account');
?>


<?php get_header(); ?>
<?php 
// hesap kartini guncelle
if(isset($_POST['update'])) {
	if(update_account($account->id, $_POST)) {
		$account = get_account($account->id, false);
	}
}

// status degisikligi
if(isset($_GET['status'])) {
	if($_GET['status'] == '0' OR $_GET['status'] == '1') {
		if(update_account($account->id, array('update'=>array('status'=>$_GET['status']), 'add_alert'=>false))) {
			$account = get_account($account->id);
		}	
	}
}

# hesap bakiyesini tekrar hesapla
calc_account($account->id);
# hesap kartini tekrar cagir
$account = get_account($_GET['id'], false);

# sayfa bilgilerini ekle
add_page_info( 'title', $account->name );
add_page_info( 'nav', array('name'=>'Hesap Yönetimi', 'url'=>get_site_url('admin/account/') ) );
add_page_info( 'nav', array('name'=>'Hesap Listesi', 'url'=>get_site_url('admin/account/list.php') ) );
add_page_info( 'nav', array('name'=>$account->name) );
?>


<?php if($account->status == '0'): ?>
	<?php echo get_alert('<i class="fa fa-trash-o"></i> <b>Dikkat!</b> hesap kartı pasif durumda.', 'warning', false); ?>
<?php else: ?>
	<?php create_modal(array('id'=>'status_account', 
		'title'=>'Hesap kartı <u>pasifleştirme</u>', 
		'content'=>_b($account->name).' hesap kartını pasifleştirmek istiyor musun? <br /> <small>Hesap kartı veritabanından <u>silinmez</u>. Pasif olursa arama ve listelemelerde görünmez. <br /> Herhangi gibi bir form hareketi var ise cari ekstre detayları ve form hareketlerinde görünür.</small>', 
		'btn'=>'<a href="?id='.$account->id.'&status=0" class="btn btn-danger">Evet, onaylıyorum</a>')); ?>
<?php endif; ?>



<ul class="nav nav-tabs" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-id-card-o"></i><span class="hidden-xs"> Hesap Kartı</span></a></li> 
	<li role="presentation" class=""><a href="#forms" role="tab" id="forms-tab" data-toggle="tab" aria-controls="forms" aria-expanded="false"><i class="fa fa-list"></i><span class="hidden-xs"> Formlar</span></a></li> 
	<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="false"><i class="fa fa-database"></i><span class="hidden-xs"> Geçmiş</span></a></li> 
	<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-cogs"></i> <span class="hidden-xs">Seçenekler</span> <span class="caret"></span></a> 
		<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
			<li><a href="<?php site_url('admin/user/message/add.php?attachment&account_id='.$account->id); ?>" target="_blank"><i class="fa fa-tasks fa-fw"></i> Görev Ekine Ekle</a></li>
			<li><a href="<?php site_url('admin/user/message/add.php?attachment&account_id='.$account->id); ?>" target="_blank"><i class="fa fa-envelope-o fa-fw"></i> Mesaj Ekine Ekle</a></li>
			<li class="divider"></li>
			<?php if($account->status == '1'): ?>
				<li><a href="#" target="_blank" data-toggle="modal" data-target="#status_account"><i class="fa fa-trash-o fa-fw text-danger"></i> Sil</a></li>
			<?php else: ?>
				<li><a href="?id=<?php echo $account->id; ?>&status=1"><i class="fa fa-undo fa-fw text-success"></i> Aktifleştir</a></li>
			<?php endif; ?>
		</ul> 
	</li>
	<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-print"></i> <span class="hidden-xs">Yazdır</span> <span class="caret"></span></a> 
		<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
			<li><a href="print-statement.php?id=<?php echo $account->id; ?>&print" target="_blank"><i class="fa fa-file-text-o fa-fw"></i> Ekstre Yazdır</a></li>
			<li class="divider"></li>
			<li><a href="print-address.php?id=<?php echo $account->id; ?>&print" target="_blank"><i class="fa fa-address-book-o fa-fw"></i> Adres Kartı Yazdır</a></li>
		</ul> 
	</li>
</ul>


<div class="tab-content"> 

	<!-- tab:home -->
	<div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab"> 
		<div class="row">
			<div class="col-md-8">
				<?php print_alert('update_account'); ?>
				
				<form name="form_add_accout" id="form_add_account" action="" method="POST" class="validate">

					<div class="row">
						<div class="col-md-6">

							<div class="form-group">
								<label for="code">Barkod Kodu </label>
								<input type="text" name="code" id="code" value="<?php echo $account->code; ?>" class="form-control" minlength="3" maxlength="32">
							</div> <!-- /.form-group -->

							<div class="form-group">
								<label for="name">Hesap Adı <sup class="text-muted">şahıs adı soyadı, firma adı, şirket adı vb.</sup></label>
								<input type="text" name="name" id="name" value="<?php echo $account->name; ?>" class="form-control required" minlength="3" maxlength="50">
							</div> <!-- /.form-group -->

							<div class="form-group">
								<label for="email">E-Posta</label>
								<input type="email" name="email" id="email" value="<?php echo $account->email; ?>" class="form-control email" minlength="3" maxlength="50">
							</div> <!-- /.form-group -->

							<div class="row">
								<div class="col-xs-6 col-md-6">
									<div class="form-group">
										<label for="gsm">Cep Telefonu</label>
										<input type="tel" name="gsm" id="gsm" value="<?php echo $account->gsm; ?>" class="form-control required digits" minlength="10" maxlength="11">
									</div> <!-- /.form-group -->
								</div> <!-- /.col -->
								<div class="col-xs-6 col-md-6">
									<div class="form-group">
										<label for="phone">Sabit Telefon</label>
										<input type="tel" name="phone" id="phone" value="<?php echo $account->phone; ?>" class="form-control digits" minlength="10" maxlength="11">
									</div> <!-- /.form-group -->
								</div> <!-- /.col -->
							</div> <!-- /.row -->

						</div> <!-- /.col-md-4 -->
						<div class="col-md-6">

							<div class="form-group">
								<label for="address">Adres</label>
								<input type="text" name="address" id="address" value="<?php echo $account->address; ?>" class="form-control" maxlength="250">
							</div> <!-- /.form-group -->

							<div class="row">
								<div class="col-xs-6 col-md-4">
									<div class="form-group">
										<label for="district">İlçe-Bölge</label>
										<input type="text" name="district" id="district" value="<?php echo $account->district; ?>" class="form-control" maxlength="20">
									</div> <!-- /.form-group -->
								</div> <!-- /.col -->
								<div class="col-xs-6 col-md-4">
									<div class="form-group">
										<label for="city">Şehir-İl</label>
										<input type="text" name="city" id="city" value="<?php echo $account->city; ?>" class="form-control" maxlength="20">
									</div> <!-- /.form-group -->
								</div> <!-- /.col -->
								<div class="col-xs-6 col-md-4">
									<div class="form-group country_selected">
										<label for="country">Ülke</label>
										<?php echo list_selectbox(get_country_array(), array('name'=>'country', 'selected'=>$account->country, 'class'=>'form-control select select-account')); ?>
									</div> <!-- /.form-group -->
								</div> <!-- /.col-md-4 -->
							</div> <!-- /.row -->

							<div class="row">
								<div class="col-xs-6 col-md-4">
									<div class="form-group">
										<label for="tax_home">Vergi Dairesi</label>
										<input type="text" name="tax_home" id="tax_home" value="<?php echo $account->tax_home; ?>" class="form-control" maxlength="20">
									</div> <!-- /.form-group -->
								</div> <!-- /.col -->
								<div class="col-xs-6 col-md-4">
									<div class="form-group">
										<label for="tax_no">Vergi/T.C. No</label>
										<input type="text" name="tax_no" id="tax_no" value="<?php echo $account->tax_no; ?>" class="form-control digits" maxlength="20">
									</div> <!-- /.form-group -->
								</div> <!-- /.col -->
							</div> <!-- /.row -->

						</div> <!-- /.col-md-4 -->

					</div> <!-- /.row -->

					<div class="text-right">
						<input type="hidden" name="update">
						<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
						<button class="btn btn-default btn-insert"><i class="fa fa-floppy-o"></i> Kaydet</button>
					</div>

				</form>
			</div> <!-- /.col-md-8 -->
			<div class="col-md-4">

			</div> <!-- /.col-md-4 -->
		</div> <!-- /.row -->
	</div> 
	<!-- /tab:home -->







	<!-- tab:forms -->
	<div class="tab-pane fade" role="tabpanel" id="forms" aria-labelledby="forms-tab"> 
		<?php
		$args_form['where']['status'] = '1';
		$args_form['where']['account_id'] = $account->id;
		$args_form['where']['order_by'] = array('id'=>'ASC', 'date'=>'ASC');
		if($forms = get_forms($args_form)): ?>
			<table class="table table-hover table-bordered table-condensed table-striped dataTable">
				<thead>
					<?php if(til_is_mobile()): ?>
						<tr>
							<th width="60">ID</th>
							<th class="hidden-xs-portrait">Tarih</th>
							<th class="hidden-xs-portrait">Personel</th>
							<th width="80">Giriş</th>
							<th width="80">Çıkış</th>
							<th width="100">Bakiye</th>
						</tr>
					<?php else: ?>
						<tr>
							<th width="60">Form ID</th>
							<th width="80">Tarih</th>
							<th width="30">G/Ç</th>
							<th width="100">Form Durumu</th>
							<th width="120">Personel</th>
							<th>Açıklama</th>
							<th width="80">Giriş</th>
							<th width="80">Çıkış</th>
							<th width="80">Bakiye</th>
						</tr>
					<?php endif; ?>
				</thead>
				<tbody>
				<?php $balance = 0; foreach($forms->list as $form): ?>
					<?php $form_status = get_form_status($form->status_id); ?>
					<?php if(til_is_mobile()): ?>
						<tr>
							<td>
								<a href="../form/detail.php?id=<?php echo $form->id; ?>" target="_blank">#<?php echo $form->id; ?></a>
							</td>
							<td class="hidden-xs-portrait"><small class="text-muted"><?php echo til_get_date($form->date, 'Y-m-d'); ?></small></td>
							<td class="hidden-xs-portrait"><small class="text-muted"><?php echo get_user_info($form->user_id, 'display_name'); ?></small></td>
							<td class="text-right"><?php if($form->in_out == 0) { echo get_set_money($form->total, true); $balance = $balance - $form->total; } else { echo ''; } ?></td>
							<td class="text-right"><?php if($form->in_out == 1) { echo get_set_money($form->total, true); $balance = $balance + $form->total; } else { echo ''; } ?></td>
							<td class="text-right"><?php echo get_set_money($balance, true); ?></td>
						</tr>
					<?php else: ?>
						<tr>
							<td>
								<a href="../form/detail.php?id=<?php echo $form->id; ?>" target="_blank">#<?php echo $form->id; ?></a>								
							</td>
							<td><small class="text-muted hidden-xs"><?php echo substr($form->date,0,16); ?></small></td>
							<td class="hidden-xs"><?php echo get_in_out_label($form->in_out); ?></td>
							<?php if($form->type == 'form'): ?>
								<td class="hidden-xs"><?php echo get_form_status_span($form_status); ?></td>
							<?php else: ?>
								<td class="hidden-xs"></td>
							<?php endif; ?>
							<td class="hidden-xs"><?php echo get_user_info($form->user_id, 'display_name'); ?></td>
							<td class="text-muted hidden-xs">
								<?php
								if($form->type=='form') {
									if($form->in_out == '0') { echo 'Giriş formu: '.$form->item_quantity.' adet ürün'; } else { echo 'Çıkış formu: '.$form->item_quantity.' adet ürün'; }
								} elseif($form->type=='payment') {
									if($form->in_out == '0') { echo 'Ödeme girişi'; } else { echo 'Ödeme çıkışı'; }	
								}
								?>
							</td>
							<td class="text-right"><?php if($form->in_out == 0) { echo get_set_money($form->total, true); $balance = $balance - $form->total; } else { echo ''; } ?></td>
							<td class="text-right"><?php if($form->in_out == 1) { echo get_set_money($form->total, true); $balance = $balance + $form->total; } else { echo ''; } ?></td>
							<td class="text-right"><?php echo get_set_money($balance, true); ?></td>
						</tr>
					<?php endif; ?>
					
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo get_alert(array('title'=>'Form Hareketi Yok', 'description'=>'Bu hesap kartı için henüz bir form hareketi eklenmemiş.'), 'warning', false); ?>
		<?php endif; ?>
	</div> <!-- #forms -->
	<!-- /tab:forms -->









	<!-- tab:logs -->
	<div class="tab-pane fade" role="tabpanel" id="logs" aria-labelledby="logs-tab"> 
		<?php theme_get_logs(" table_id='accounts:".$account->id."' "); ?>
	</div> 
	<!-- /tab:logs -->

</div> <!-- /.tab-content -->









<?php get_footer(); ?>