<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php $account = get_account($_GET['id']); ?>
<?php 
if(isset($_POST['update'])) {
	if(update_account($account->id, $_POST)) {
		$account = get_account($account->id);
	}
}

if(isset($_GET['status'])) {
	if($_GET['status'] == '0' OR $_GET['status'] == '1') {
		if(update_account($account->id, array('update'=>array('status'=>$_GET['status']), 'add_alert'=>false))) {
			$account = get_account($account->id);
		}	
	}
}
?>


<?php if($account): ?>
	<?php
	calc_account($account->id);
	$account = get_account($_GET['id']);
	?>
	<?php
	add_page_info( 'title', $account->name );
	add_page_info( 'nav', array('name'=>'Hesap Yönetimi', 'url'=>get_site_url('admin/account/') ) );
	add_page_info( 'nav', array('name'=>'Hesap Kartları Listesi', 'url'=>get_site_url('admin/account/list.php') ) );
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
		<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-id-card-o"></i> Hesap Kartı</a></li> 
		<li role="presentation" class=""><a href="#forms" role="tab" id="forms-tab" data-toggle="tab" aria-controls="forms" aria-expanded="false"><i class="fa fa-list"></i> Formlar</a></li> 
		<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="false"><i class="fa fa-database"></i> Geçmiş</a></li> 
		<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-cogs"></i> Seçenekler <span class="caret"></span></a> 
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
		<li role="presentation" class="dropdown pull-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-print"></i> Yazdır <span class="caret"></span></a> 
			<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
				<li><a href="print_statement.php?id=<?php echo $account->id; ?>&print" target="_blank"><i class="fa fa-file-text-o fa-fw"></i> Ekstre Yazdır</a></li> 
				<li><a href="print_address.php?id=<?php echo $account->id; ?>&print" target="_blank"><i class="fa fa-address-book-o fa-fw"></i> Adres Kartı Yazdır</a></li>
			</ul> 
		</li>
	</ul>


	<div class="tab-content"> 
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
									<input type="text" name="email" id="email" value="<?php echo $account->email; ?>" class="form-control email" minlength="3" maxlength="50">
								</div> <!-- /.form-group -->

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="gsm">Cep Telefonu</label>
											<input type="text" name="gsm" id="gsm" value="<?php echo $account->gsm; ?>" class="form-control required digits" minlength="10" maxlength="11">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-6 -->
									<div class="col-md-6">
										<div class="form-group">
											<label for="phone">Sabit Telefon</label>
											<input type="text" name="phone" id="phone" value="<?php echo $account->phone; ?>" class="form-control digits" minlength="10" maxlength="11">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-6 -->
								</div> <!-- /.row -->

							</div> <!-- /.col-md-4 -->
							<div class="col-md-6">

								<div class="form-group">
									<label for="address">Adres</label>
									<input type="text" name="address" id="address" value="<?php echo $account->address; ?>" class="form-control" maxlength="250">
								</div> <!-- /.form-group -->

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="district">İlçe-Bölge</label>
											<input type="text" name="district" id="district" value="<?php echo $account->district; ?>" class="form-control" maxlength="20">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-4 -->
									<div class="col-md-4">
										<div class="form-group">
											<label for="city">Şehir-İl</label>
											<input type="text" name="city" id="city" value="<?php echo $account->city; ?>" class="form-control" maxlength="20">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-4 -->
									<div class="col-md-4">
										<div class="form-group country_selected">
											<label for="country">Ülke</label>
											<?php echo list_selectbox(get_country_array(), array('name'=>'country', 'selected'=>$account->country, 'class'=>'form-control select select-account input-sm')); ?>
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-4 -->
								</div> <!-- /.row -->

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="tax_home">Vergi Dairesi</label>
											<input type="text" name="tax_home" id="tax_home" value="<?php echo $account->tax_home; ?>" class="form-control" maxlength="20">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-4 -->
									<div class="col-md-4">
										<div class="form-group">
											<label for="tax_no">Vergi/T.C. No</label>
											<input type="text" name="tax_no" id="tax_no" value="<?php echo $account->tax_no; ?>" class="form-control digits" maxlength="20">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-4 -->
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



					<div class="row space-5">
						<div class="col-md-6">
							<div class="bg-muted text-center">
								<span class="fs-20 bold fs-12 ff-2"><?php echo get_set_money($account->balance); ?> <small class="fs-16"><i class="fa fa-try text-muted"></i></small></span>
								<br />
								<span class="text-success fs-12 ff-2">GÜNCEL BAKİYE</span>
							</div>
						</div> <!--/. col-md-6 -->
						<div class="col-md-6">
							<div class="bg-muted text-center">
								<span class="fs-20 bold fs-12 ff-2"><?php echo get_set_money($account->profit); ?> <small class="fs-16"><i class="fa fa-try text-muted"></i></small></span>
								<br />
								<span class="text-muted fs-12 ff-2">KAR TUTARI</span>
							</div>
						</div> <!--/. col-md-6 -->
					</div> <!-- /.row -->
					<div class="h-20"></div>


					<div class="row space-5">
						<div class="col-md-6">

							<div class="panel panel-default" style="border-radius:0px;">

								<div class="bg-blue">
									<div class="h-20"></div>
									<div class="padding-8">
										<?php

										$how_days = 15;
										$total = 0;


										$date = array();
										$charts = array();
										for($i=0; $i<=$how_days; $i++) {
											$charts['date'][] = date('Y-m-d',strtotime("-".($how_days-$i)." days"));
											$date[0][date('Y-m-d',strtotime("-".($how_days-$i)." days"))] = 0;
											$date[1][date('Y-m-d',strtotime("-".($how_days-$i)." days"))] = 0;
										}
										$start_date 	= date('Y-m-d',strtotime("-".($how_days)." days"));
										$end_date 		= date('Y-m-d',strtotime("-".($how_days-$how_days)." days"));




										$data = array();
										$in_out = 0;
										$query = db()->query("SELECT * FROM ".dbname('forms')." WHERE date >= '".$start_date."' AND date <= '".$end_date." 99:99:99' AND status='1' AND in_out='".$in_out."' ");
										while($list = $query->fetch_object()) {
											if( isset($date[$in_out][substr($list->date,0,10)]) ) {
												$date[$in_out][substr($list->date,0,10)] = $list->total;
											} else {
												$date[$in_out][substr($list->date,0,10)] = 0;
											}
										}

										$in_out = 1;
										$query = db()->query("SELECT * FROM ".dbname('forms')." WHERE date >= '".$start_date."' AND date <= '".$end_date." 99:99:99' AND status='1' AND in_out='".$in_out."' ");
										while($list = $query->fetch_object()) {
											if( isset($date[$in_out][substr($list->date,0,10)]) ) {
												$date[$in_out][substr($list->date,0,10)] = $list->total;
											} else {
												$date[$in_out][substr($list->date,0,10)] = 0;
											}
										}



										foreach($date[0] as $key=>$val) {
											$charts[0]['values'][] = number_format($val,2, '.', '');
										}
										foreach($date[1] as $key=>$val) {
											$charts[1]['values'][] = number_format($val,2, '.', '');
										}


										$args = array();
										$args['type'] = 'bar';
										$args['canvas']['height'] = '80';
										$args['labels'] = $charts['date'];
										$args['chart']['datasets'][] = array('label'=>'Girişler', 'data'=>$charts[0]['values'], 'type'=>'line', 'fill'=>true);
										$args['chart']['datasets'][] = array('label'=>'Çıkışlar', 'data'=>$charts[1]['values'], 'type'=>'bar');

										$args['tooltips']['money'] = 'true';

										$args['yAxes']['display'] = 'false';
										$args['yAxes']['money'] = 'true';

										$args['xAxes']['display'] = 'false';

										$args['legend']['display'] = 'false';

										chartjs($args);
										?>
									</div>
								</div>

								<div style="position:absolute; top:5px; left:15px;"><span class="fs-12 ff-2 text-white">ÇIKIŞLAR</span></div>

								<div class="h-10"></div>
								<div class="row no-space">

									<div class="col-md-6">
										<div class="padding-8">
											<div class="fs-13 ff-2 text-black-1"><?php echo get_set_money('0.00', true); ?></div>
											<small class="text-muted fs-10 ff-2">Bu gün</small>
										</div>
									</div> <!-- /.col-md-6 -->
									<div class="col-md-6">
										<div class="padding-8">
											<div class="fs-13 ff-2 text-black-1"><?php echo get_set_money($total, true); ?></div>
											<small class="text-muted fs-10 ff-2">Bu hafta</small>
										</div>
									</div> <!-- /.col-md-6 -->
									<div class="clearfix"></div>
									<div class="col-md-6 b-top-1 b-right-1 bc-muted">
										<div class="padding-8">
											<div class="fs-13 ff-2">1.270</div>
											<small class="text-muted fs-10 ff-2">Toplam Sipariş</small>
										</div>
									</div> <!-- /.col-md-6 -->
									<div class="col-md-6 b-top-1 bc-muted">
										<div class="padding-8">
											<div class="fs-13 ff-2"><?php echo get_set_money('240,000', true); ?></div>
											<small class="text-muted fs-10 ff-2">Toplam Satış</small>
										</div>
									</div> <!-- /.col-md-6 -->

								</div> <!-- /.quarters -->


							</div> <!-- /.panel -->
						</div> <!-- /.col-md-6 -->
						<div class="col-md-6">

							<div class="panel panel-default" style="border-radius:0px;">

								<div class="bg-red">
									<div class="h-20"></div>
									<div class="padding-8">
										<?php

										$how_days = 15;
										$total = 0;


										$date = array();
										$charts = array();
										for($i=0; $i<=$how_days; $i++) {
											$charts['date'][] = date('Y-m-d',strtotime("-".($how_days-$i)." days"));
											$date[0][date('Y-m-d',strtotime("-".($how_days-$i)." days"))] = 0;
											$date[1][date('Y-m-d',strtotime("-".($how_days-$i)." days"))] = 0;
										}
										$start_date 	= date('Y-m-d',strtotime("-".($how_days)." days"));
										$end_date 		= date('Y-m-d',strtotime("-".($how_days-$how_days)." days"));




										$data = array();
										$in_out = 0;
										$query = db()->query("SELECT * FROM ".dbname('forms')." WHERE date >= '".$start_date."' AND date <= '".$end_date." 99:99:99' AND status='1' AND in_out='".$in_out."' ");
										while($list = $query->fetch_object()) {
											if( isset($date[$in_out][substr($list->date,0,10)]) ) {
												$date[$in_out][substr($list->date,0,10)] = $list->total;
											} else {
												$date[$in_out][substr($list->date,0,10)] = 0;
											}
										}

										$in_out = 1;
										$query = db()->query("SELECT * FROM ".dbname('forms')." WHERE date >= '".$start_date."' AND date <= '".$end_date." 99:99:99' AND status='1' AND in_out='".$in_out."' ");
										while($list = $query->fetch_object()) {
											if( isset($date[$in_out][substr($list->date,0,10)]) ) {
												$date[$in_out][substr($list->date,0,10)] = $list->total;
											} else {
												$date[$in_out][substr($list->date,0,10)] = 0;
											}
										}



										foreach($date[0] as $key=>$val) {
											$charts[0]['values'][] = number_format($val,2, '.', '');
										}
										foreach($date[1] as $key=>$val) {
											$charts[1]['values'][] = number_format($val,2, '.', '');
										}


										$args = array();
										$args['type'] = 'bar';
										$args['canvas']['height'] = '80';
										$args['labels'] = $charts['date'];
										$args['chart']['datasets'][] = array('label'=>'Girişler', 'data'=>$charts[0]['values'], 'type'=>'line', 'fill'=>true);
										$args['chart']['datasets'][] = array('label'=>'Çıkışlar', 'data'=>$charts[1]['values'], 'type'=>'bar');

										$args['tooltips']['money'] = 'true';

										$args['yAxes']['display'] = 'false';
										$args['yAxes']['money'] = 'true';

										$args['xAxes']['display'] = 'false';

										$args['legend']['display'] = 'false';

										chartjs($args);
										?>
									</div>
								</div>

								<div style="position:absolute; top:5px; left:15px;"><span class="fs-12 ff-2 text-white">ÇIKIŞLAR</span></div>

								<div class="h-10"></div>
								<div class="row no-space">

									<div class="col-md-6">
										<div class="padding-8">
											<div class="fs-13 ff-2 text-black-1"><?php echo get_set_money('0.00', true); ?></div>
											<small class="text-muted fs-10 ff-2">Bu gün</small>
										</div>
									</div> <!-- /.col-md-6 -->
									<div class="col-md-6">
										<div class="padding-8">
											<div class="fs-13 ff-2 text-black-1"><?php echo get_set_money($total, true); ?></div>
											<small class="text-muted fs-10 ff-2">Bu hafta</small>
										</div>
									</div> <!-- /.col-md-6 -->
									<div class="clearfix"></div>
									<div class="col-md-6 b-top-1 b-right-1 bc-muted">
										<div class="padding-8">
											<div class="fs-13 ff-2">1.270</div>
											<small class="text-muted fs-10 ff-2">Toplam Sipariş</small>
										</div>
									</div> <!-- /.col-md-6 -->
									<div class="col-md-6 b-top-1 bc-muted">
										<div class="padding-8">
											<div class="fs-13 ff-2"><?php echo get_set_money('240,000', true); ?></div>
											<small class="text-muted fs-10 ff-2">Toplam Satış</small>
										</div>
									</div> <!-- /.col-md-6 -->

								</div> <!-- /.quarters -->
							</div> <!-- /.panel -->
						</div> <!-- /.col-md-6 -->

					</div> <!-- /.row -->





					



				</div> <!-- /.col-md-4 -->
			</div> <!-- /.row -->

		</div> 
		<div class="tab-pane fade" role="tabpanel" id="forms" aria-labelledby="forms-tab"> 
			<?php
			$args_form['where']['status'] = '1';
			$args_form['where']['account_id'] = $account->id;
			$args_form['where']['orderby'] = 'id ASC';
			if($forms = get_forms($args_form)): ?>

				<table class="table table-hover table-bordered table-condensed table-striped dataTable">
					<thead>
						<tr>
							<th width="100">Tarih</th>
							<th width="80">Form ID</th>
							<th width="80">Giriş/Çıkış</th>
							<th width="150">Form Durumu</th>
							<th>Personel</th>
							<th>Açıklama</th>
							<th width="80">Giriş</th>
							<th width="80">Çıkış</th>
							<th width="100">Bakiye</th>
						</tr>
					</thead>
					<tbody>
					<?php $balance = 0; foreach($forms->list as $form): ?>
						<?php $form_status = get_form_status($form->status_id); ?>
						<tr>
							<td><small class="text-muted"><?php echo substr($form->date,0,16); ?></small></td>
							<td><a href="../form/detail.php?id=<?php echo $form->id; ?>" target="_blank">#<?php echo $form->id; ?></a></td>
							<td><?php echo get_in_out_label($form->in_out); ?></td>
							<?php if($form->type == 'form'): ?>
								<td><?php echo get_form_status_span($form_status); ?></td>
							<?php else: ?>
								<td></td>
							<?php endif; ?>
							<td><?php echo get_user_info($form->user_id, 'display_name'); ?></td>
							<td class="text-muted">
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
					<?php endforeach; ?>
					</tbody>
				</table>

			<?php endif; ?>


		</div> 
		<div class="tab-pane fade" role="tabpanel" id="logs" aria-labelledby="logs-tab"> 
			<?php theme_get_logs(" table_id='accounts:".$account->id."' "); ?>
		</div> 
		<div class="tab-pane fade" role="tabpanel" id="dropdown1" aria-labelledby="dropdown1-tab"> 
			<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p> 
		</div> 
		<div class="tab-pane fade" role="tabpanel" id="dropdown2" aria-labelledby="dropdown2-tab"> 
			<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p> 
		</div> 
	</div> <!-- /.tab-content -->



<?php else: ?>
	<?php
	add_page_info( 'title', 'Hesap Kartı');
	add_page_info( 'nav', array('name'=>'Hesap Yönetimi', 'url'=>get_site_url('admin/account/') ) );
	add_page_info( 'nav', array('name'=>'Hesap Kartları Listesi', 'url'=>get_site_url('admin/account/list.php') ) );
	add_page_info( 'nav', array('name'=>'Hesap Kartı') );
	?>
	<?php print_alert(); ?>
<?php endif; ?>






<?php get_footer(); ?>