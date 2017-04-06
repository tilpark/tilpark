<?php include('../../tilpark.php'); ?>
<?php

if(10 < 9) {
$q_forms = db()->query("SELECT * FROM ".dbname('forms')." ");
	while($list = $q_forms->fetch_assoc()) {
		unset($list['id']);
		db()->query("INSERT INTO ".dbname('forms')." ".sql_insert_string($list)." ");
		echo db()->error;

	}
	exit;
}

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



<ul class="nav nav-tabs til-nav-page" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-id-card-o"></i><span class="hidden-xs"> Hesap Kartı</span></a></li> 
	<li role="presentation" class=""><a href="#forms" role="tab" id="forms-tab" data-toggle="tab" aria-controls="forms" aria-expanded="false"><i class="fa fa-list"></i><span class="hidden-xs"> Formlar</span></a></li> 
	<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="false"><i class="fa fa-database"></i><span class="hidden-xs"> Geçmiş</span></a></li> 
	
	<li role="presentation" class="dropdown pull-right til-menu-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-cogs"></i><span class="hidden-xs"> Seçenekler</span><span class="caret"></span></a> 
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
	<li role="presentation" class="dropdown pull-right til-menu-right"> <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><i class="fa fa-print"></i><span class="hidden-xs"> Yazdır</span><span class="caret"></span></a> 
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
								<input type="text" name="name" id="name" value="<?php echo $account->name; ?>" class="form-control required" minlength="3" maxlength="32">
							</div> <!-- /.form-group -->

							<div class="form-group">
								<label for="email">E-Posta</label>
								<input type="email" name="email" id="email" value="<?php echo $account->email; ?>" class="form-control email" minlength="3" maxlength="100">
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
								<input type="text" name="address" id="address" value="<?php echo $account->address; ?>" class="form-control" minlength="3" maxlength="250">
							</div> <!-- /.form-group -->

							<div class="row">
								<div class="col-xs-6 col-md-4">
									<div class="form-group">
										<label for="district">İlçe-Bölge</label>
										<input type="text" name="district" id="district" value="<?php echo $account->district; ?>" class="form-control" minlength="3" maxlength="20">
									</div> <!-- /.form-group -->
								</div> <!-- /.col -->
								<div class="col-xs-6 col-md-4">
									<div class="form-group">
										<label for="city">Şehir-İl</label>
										<input type="text" name="city" id="city" value="<?php echo $account->city; ?>" class="form-control" minlength="3" maxlength="20">
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
										<input type="text" name="tax_home" id="tax_home" value="<?php echo $account->tax_home; ?>" class="form-control" minlength="3" maxlength="20">
									</div> <!-- /.form-group -->
								</div> <!-- /.col -->
								<div class="col-xs-6 col-md-4">
									<div class="form-group">
										<label for="tax_no">Vergi/T.C. No</label>
										<input type="tel" name="tax_no" id="tax_no" value="<?php echo $account->tax_no; ?>" class="form-control digits" minlength="10" maxlength="11">
									</div> <!-- /.form-group -->
								</div> <!-- /.col -->
							</div> <!-- /.row -->

						</div> <!-- /.col-md-4 -->

					</div> <!-- /.row -->

					<div class="text-right">
						<input type="hidden" name="update">
						<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
						<button class="btn btn-success btn-insert btn-xs-block"><i class="fa fa-floppy-o"></i> Kaydet</button>
					</div>

				</form>
			</div> <!-- /.col-md-8 -->
			<div class="col-md-4">
				<?php 
				$accountTotal = array();
				$q = db()->query("SELECT sum(total) as total FROM ".dbname("forms")." WHERE status='1' AND type='form' AND in_out='0' AND account_id='".$account->id."'");
				$accountTotal['form_in'] = $q->fetch_object()->total;
				$q = db()->query("SELECT sum(total) as total FROM ".dbname("forms")." WHERE status='1' AND type='form' AND in_out='1' AND account_id='".$account->id."'");
				$accountTotal['form_out'] = $q->fetch_object()->total;

				$q = db()->query("SELECT sum(total) as total FROM ".dbname("forms")." WHERE status='1' AND type='payment' AND in_out='0' AND account_id='".$account->id."'");
				$accountTotal['payment_in'] = $q->fetch_object()->total;
				$q = db()->query("SELECT sum(total) as total FROM ".dbname("forms")." WHERE status='1' AND type='payment' AND in_out='1' AND account_id='".$account->id."'");
				$accountTotal['payment_out'] = $q->fetch_object()->total;

				?>

					<?php 
					$chart = array();
					$chart['type'] = 'line';
					$chart['data']['datasets'][0]['label'] 	= 'Hareketler';
					$chart['data']['datasets'][0]['fill'] 	= false;
					$chart['data']['datasets'][0]['lineTension'] 	= '0';
					$chart['data']['datasets'][0]['borderWidth'] 	= 1;
					$chart['data']['datasets'][0]['pointBorderWidth'] 	= 1;
					$chart['data']['datasets'][0]['pointRadius'] 	= 1;
					$chart['data']['datasets'][0]['backgroundColor'] 	= 'rgba(253, 196, 48, 0.2)';
					$chart['data']['datasets'][0]['borderColor'] 		= 'rgba(253, 196, 48, 1)';


					$_start_date = date('Y-m-d', strtotime('-2 week', strtotime(date('Y-m-d'))) );
					$_end_date = date('Y-m-d');
					while(strtotime($_start_date) <= strtotime($_end_date) ) {
						$chart['data']['labels'][] = $_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));

						$total = 0;
						$chart_balance = $account->balance;
						$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND in_out='0' AND account_id='".$account->id."' AND date >= '".$_start_date." 00:00:00' ORDER BY id DESC, date DESC");
						if(($total = $q_forms->fetch_object()->total) > 0) {
							// $chartt['data']['datasets'][0]['data'][] = $total;
						} else {
							// $chartt['data']['datasets'][0]['data'][] = '0.00';
						}
						$chart_balance = $chart_balance + $total;

						$total = 0;
						$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND in_out='1' AND account_id='".$account->id."' AND date >= '".$_start_date." 00:00:00' ORDER BY id DESC, date DESC");
						if(($total = $q_forms->fetch_object()->total) > 0) {
							// $chartt['data']['datasets'][1]['data'][] = $total;
						} else {
							// $chartt['data']['datasets'][1]['data'][] = '0.00';
						}
						$chart_balance = $chart_balance - $total;
						$chart['data']['datasets'][0]['data'][] = $chart_balance;

		
					}

					$chart['options']['legend']['display'] = false;
					$chart['options']['scales']['yAxes'][0]['display'] = false;
					$chart['options']['scales']['xAxes'][0]['display'] = false;
					$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
					$chart['options']['maintainAspectRatio'] = false;
					$chart['options']['tooltips']['enabled'] = true;
					$chart['options']['tooltips']['yLabel'] = 'krall';
					$chart['options']['tooltips']['mode'] = 'nearest';
					$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) {  return ''; } =TIL=";
					$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) {  return  tooltipItems.yLabel.formatMoney(2, '.', ',') + ' TL'; } =TIL=";
					

					$args['height'] 	= '40';
					$args['chart'] 		= $chart;
					?>
					<div class="row space-none">
						<div class="col-md-4">

							<div class="">
								<span class="ff-2 fs-17 bold <?php echo $account->balance < 0 ? 'text-danger' : 'text-success'; ?>"><?php echo get_set_money($account->balance); ?></span> <small class="text-muted">TL</small>
								<br />
								<small class="text-muted">bakiye</small>
							</div>
							
						</div> <!-- /.col-md-4 -->
						<div class="col-md-8">
							<?php chartjs($args); ?>
						</div> <!-- /.col-md-8 -->
					</div> <!-- /.row -->

					<div class="h-20"></div>

					<div class="row space-5">
						<div class="col-md-4">

							<div class="">
								<span class="ff-2 fs-15 bold <?php echo $account->profit < 0 ? 'text-danger' : 'text-success'; ?>"><?php echo get_set_money($account->profit); ?></span> <small class="text-muted">TL</small>
								<br />
								<small class="text-muted">kar/zarar</small>
							</div>
							
						</div> <!-- /.col-md-4 -->
						<div class="col-md-8">
							<?php chartjs($args); ?>
						</div> <!-- /.col-md-8 -->
					</div> <!-- /.row -->

					<hr />

					<div class="row">
						<div class="col-md-6">
							<div class="">
								<small class="text-muted">toplam ürün girişi</small>
								<br />
								<span class="ff-2 fs-15 bold"><?php echo get_set_money($accountTotal['form_in']); ?></span> <small class="text-muted">TL</small>
							</div>
						</div> <!-- /.col-md-6 -->
						<div class="col-md-6">
							<div class="">
								<small class="text-muted">toplam ürün çıkışı</small>
								<br />
								<span class="ff-2 fs-15 bold"><?php echo get_set_money($accountTotal['form_out']); ?></span> <small class="text-muted">TL</small>
							</div>
						</div> <!-- /.col-md-6 -->
					</div> <!-- /.row -->

					<div class="h-20"></div>

					<div class="row">
						<div class="col-md-6">
							<div class="">
								<small class="text-muted">toplam ödeme girişi</small>
								<br />
								<span class="ff-2 fs-15 bold"><?php echo get_set_money($accountTotal['payment_in']); ?></span> <small class="text-muted">TL</small>
							</div>
						</div> <!-- /.col-md-6 -->
						<div class="col-md-6">
							<div class="">
								<small class="text-muted">toplam ödeme çıkışı</small>
								<br />
								<span class="ff-2 fs-15 bold"><?php echo get_set_money($accountTotal['payment_out']); ?></span> <small class="text-muted">TL</small>
							</div>
						</div> <!-- /.col-md-6 -->
					</div> <!-- /.row -->
					
	
			</div> <!-- /.col-md-4 -->
		</div> <!-- /.row -->


		<div class="h-20"></div>

		<div class="row">
			<div class="col-md-8">
				<?php 
				$chart = array();
				$chart['type'] = 'bar';
				$chart['data']['datasets'][0]['label'] 	= 'Giriş-Çıkış';
				$chart['data']['datasets'][0]['fill'] 	= true;
				$chart['data']['datasets'][0]['lineTension'] 	= 0.3;
				$chart['data']['datasets'][0]['borderWidth'] 	= 1;
				$chart['data']['datasets'][0]['pointBorderWidth'] 	= 1;
				$chart['data']['datasets'][0]['pointRadius'] 	= 1;

				$chart['data']['datasets'][1]['label'] 	= 'Ödemeler';
				$chart['data']['datasets'][1]['type'] 	= 'line';
				$chart['data']['datasets'][1]['fill'] 	= true;
				$chart['data']['datasets'][1]['lineTension'] 	= 0.3;
				$chart['data']['datasets'][1]['borderWidth'] 	= 1;
				$chart['data']['datasets'][1]['pointBorderWidth'] 	= 1;
				$chart['data']['datasets'][1]['pointRadius'] 	= 1;

				$chart['data']['datasets'][2]['label'] 	= 'Kar/Zarar';
				$chart['data']['datasets'][2]['type'] 	= 'line';
				$chart['data']['datasets'][2]['fill'] 	= true;
				$chart['data']['datasets'][2]['lineTension'] 	= 0.3;
				$chart['data']['datasets'][2]['borderWidth'] 	= 1;
				$chart['data']['datasets'][2]['pointBorderWidth'] 	= 1;
				$chart['data']['datasets'][2]['pointRadius'] 	= 1;


				$_start_date = date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-d'))) );
				$_end_date = date('Y-m-d');
				while(strtotime($_start_date) < strtotime($_end_date) ) {
					$_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));
					$chart['data']['labels'][] = til_get_date($_start_date, 'd F');



					$form_total = 0;
					$total = 0;
					$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND type='form' AND in_out='0' AND account_id='".$account->id."' AND date >= '".$_start_date." 00:00:00' AND date <= '".$_start_date." 23:59:59' ORDER BY id DESC, date DESC");
					if(($total = $q_forms->fetch_object()->total) > 0) {
						// $chart['data']['datasets'][0]['data'][] = '-'.$total;
					} else {
						// $chart['data']['datasets'][0]['data'][] = '0.00';
					}
					$form_total = $total;

					$total = 0;
					$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND type='form' AND in_out='1' AND account_id='".$account->id."' AND date >= '".$_start_date." 00:00:00' AND date <= '".$_start_date." 23:59:59' ORDER BY id DESC, date DESC");
					if(($total = $q_forms->fetch_object()->total) > 0) {
						// $chart['data']['datasets'][1]['data'][] = $total;
					} else {
						// $chart['data']['datasets'][1]['data'][] = '0.00';
					}
					$chart['data']['datasets'][0]['data'][] = $form_total = $total - $form_total;




					$payment_total = 0;
					$total = 0;
					$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND type='payment' AND in_out='1' AND account_id='".$account->id."' AND date >= '".$_start_date." 00:00:00' AND date <= '".$_start_date." 23:59:59' ORDER BY id DESC, date DESC");
					if(($total = $q_forms->fetch_object()->total) > 0) {
						// $chart['data']['datasets'][2]['data'][] = $total;
					} else {
						// $chart['data']['datasets'][2]['data'][] = '0.00';
					}
					$payment_total = $total;

					$total = 0;
					$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND type='payment' AND in_out='0' AND account_id='".$account->id."' AND date >= '".$_start_date." 00:00:00' AND date <= '".$_start_date." 23:59:59' ORDER BY id DESC, date DESC");
					if(($total = $q_forms->fetch_object()->total) > 0) {
						// $chart['data']['datasets'][3]['data'][] = $total;
					} else {
						// $chart['data']['datasets'][3]['data'][] = '0.00';
					}
					$chart['data']['datasets'][1]['data'][] =  $total - $payment_total;




					$total = 0;
					$q_forms = db()->query("SELECT sum(profit) as total FROM ".dbname('forms')." WHERE status='1' AND account_id='".$account->id."' AND date >= '".$_start_date." 00:00:00' AND date <= '".$_start_date." 23:59:59' ORDER BY id DESC, date DESC");
					if(($total = $q_forms->fetch_object()->total) > 0) {
						$chart['data']['datasets'][2]['data'][] = $total;
					} else {
						$chart['data']['datasets'][2]['data'][] = '0.00';
					}
				}



				$chart['options']['legend']['display'] = true;
				$chart['options']['scales']['yAxes'][0]['display'] = true;
				$chart['options']['scales']['yAxes'][0]['ticks']['beginAtZero'] = false;
				$chart['options']['scales']['yAxes'][0]['ticks']['userCallback'] = "=TIL= function(value, index, values) { if(value >= 1) { return value + ' TL'; } } =TIL=";
				$chart['options']['scales']['xAxes'][0]['display'] = true;
				$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
				$chart['options']['maintainAspectRatio'] = false;
				$chart['options']['tooltips']['enabled'] = true;
				$chart['options']['tooltips']['yLabel'] = 'krall';
				$chart['options']['tooltips']['mode'] = 'nearest';
				$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) {  return tooltipItems.yLabel.formatMoney(2, '.', ',') + ' TL'; } =TIL=";

				$args['height'] 	= '250';
				$args['chart'] 		= $chart;
				?>

				
				<div class="panel panel-default panel-heading-10">
					<div class="panel-heading"><h3 class="panel-title">Son 30 Günlük Grafik Özeti</h3></div>
					<div class="panel-body">
						<?php chartjs($args); ?>
					</div>
				</div>
			</div> <!-- /.col-* -->
			<div class="col-md-4">
			<div class="panel panel-default panel-heading-10">
					<div class="panel-heading"><h3 class="panel-title">Hesabın En Popüler Ürünleri</h3></div>
					<div class="panel-body">
						<?php
						$chart = array();
						$chart['type'] = 'pie';
						// $chart['data']['datasets'][0]['label'] 	= 'Giriş';
						$chart['data']['datasets'][0]['fill'] 	= true;
						$chart['data']['datasets'][0]['lineTension'] 	= 0.3;
						$chart['data']['datasets'][0]['borderWidth'] 	= 1;
						$chart['data']['datasets'][0]['pointBorderWidth'] 	= 1;
						$chart['data']['datasets'][0]['pointRadius'] 	= 1;

						$_data = array();
						$q_form_items = db()->query("SELECT * FROM ".dbname('form_items')." WHERE status='1' AND type='item' AND account_id='".$account->id."'");
						while($list = $q_form_items->fetch_object()) {
							if(!isset($_data[$list->item_id])) {
								$_data[$list->item_id] = array();
							}

							$_data[$list->item_id]['quantity'] 	= @$_data[$list->item_id]['quantity'] + $list->quantity;
							$_data[$list->item_id]['total'] 	= @$_data[$list->item_id]['total'] + $list->total;
						}
						$i = 0;
						foreach($_data as $key=>$val) {
							if($i < 10) {
								$chart['data']['labels'][] = get_item($key)->name;
								$chart['data']['datasets'][0]['data'][] = $val['total'];
								$i++;
							}
						}

						$chart['options']['legend']['display'] = false;
						$chart['options']['scales']['yAxes'][0]['display'] = false;
						$chart['options']['scales']['xAxes'][0]['display'] = false;
						$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
						$chart['options']['maintainAspectRatio'] = false;
						$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
						$chart['options']['tooltips']['callbacks']['label'] =  "=TIL= function(tooltipItems, data) { return parseFloat(data.datasets[0].data[tooltipItems.index]).formatMoney(2, '.', ',') + ' TL'; } =TIL=";

						// $args['height'] 	= '550';
						$args['chart'] 		= $chart;
						?>
						<?php chartjs($args); ?>
					</div>
				</div>
			</div> <!-- /.col-* -->
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