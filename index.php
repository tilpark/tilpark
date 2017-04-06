<?php include('tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Yönetim Paneli' );
?>



<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<div class="row space-5">
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/account/'); ?>">
						<span class="icon-box"><i class="fa fa-users"></i></span>
						<h3>Hesap</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/item/'); ?>">
						<span class="icon-box"><i class="fa fa-cubes"></i></span>
						<h3>Ürün</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/form/'); ?>">
						<span class="icon-box"><i class="fa fa-shopping-cart"></i></span>
						<h3>Giriş - Çıkış</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/payment/'); ?>">
						<span class="icon-box"><i class="fa fa-bank"></i></span>
						<h3>Kasa/Banka</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/user/'); ?>">
						<span class="icon-box"><i class="fa fa-user-o"></i></span>
						<h3>Personel</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/system/'); ?>">
						<span class="icon-box"><i class="fa fa-cogs"></i></span>
						<h3>Sistem</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->


		<div class="row">
			<div class="col-md-6">
				<?php if($form_status_all = get_form_status_all('1')): ?>
					<div class="list-group mobile-full list-menuu">
						<?php foreach($form_status_all as $status): ?>
							<a href="list.php?status_id=<?php echo $status->id; ?>" class="list-group-item">
								<?php echo $status->name; ?>
								<span class="badge" style="background-color:<?php echo $status->bg_color; ?>; color:<?php echo $status->color; ?>;"><?php echo $status->count = calc_form_status($status->id); ?>2324</span>
							</a>
						<?php endforeach; ?>
					</div>

				<?php endif; ?>
			</div>
			<div class="col-md-6">
				<?php if($form_status_all = get_form_status_all('0')): ?>
					<div class="list-group mobile-full">
						<?php foreach($form_status_all as $status): ?>
							<a href="list.php?status_id=<?php echo $status->id; ?>" class="list-group-item">
								<?php echo $status->name; ?>
								<span class="badge" style="background-color:<?php echo $status->bg_color; ?>; color:<?php echo $status->color; ?>;"><?php echo $status->count = calc_form_status($status->id); ?>2324</span>
							</a>
						<?php endforeach; ?>
					</div>

				<?php endif; ?>
			</div>
		</div>

		

		<div class="h-20 visible-xs"></div>

	</div> <!-- /.col-md-6 -->
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">




		<?php 
		$args['status'] = 1;
		$args['type'] 	= 'form';
		$args['in_out'] = '1';  

		$args['q'] = "date >= '".date('Y-m-d')." 00:00:00' AND date <= '".date('Y-m-d')." 23:59:59'";
		$total['day']  =  db()->query("SELECT sum(total) as total FROM ".dbname('forms')." ".sql_where_string($args)." ")->fetch_object()->total;

		$args['q'] = "date >= '".date('Y-m-d', strtotime("-1 day"))." 00:00:00' AND date <= '".date('Y-m-d', strtotime("-1 day"))." 23:59:59'";
		$total['yesterday']  =  db()->query("SELECT sum(total) as total FROM ".dbname('forms')." ".sql_where_string($args)." ")->fetch_object()->total;

		$args['q'] = "date >= '".date('Y-m-d', strtotime("-7 day"))." 00:00:00' AND date <= '".date('Y-m-d')." 23:59:59'";
		$total['last7day']  =  db()->query("SELECT sum(total) as total FROM ".dbname('forms')." ".sql_where_string($args)." ")->fetch_object()->total;

		$args['q'] = "date >= '".date('Y-m')."-01 00:00:00' AND date <= '".date('Y-m-d')." 23:59:59'";
		$total['thisMonth']  =  db()->query("SELECT sum(total) as total FROM ".dbname('forms')." ".sql_where_string($args)." ")->fetch_object()->total;


		$args['q'] = "date >= '".date('Y-m-d', strtotime("-8 day"))." 00:00:00' AND date <= '".date('Y-m-d', strtotime("-8 day"))." 23:59:59'";
		$total['last8Day']  =  db()->query("SELECT sum(total) as total FROM ".dbname('forms')." ".sql_where_string($args)." ")->fetch_object()->total;

		$args['q'] = "date >= '".date('Y-m-d', strtotime("-14 day"))." 00:00:00' AND date <= '".date('Y-m-d', strtotime("-8 day"))." 23:59:59'";
		$total['lastWeek']  =  db()->query("SELECT sum(total) as total FROM ".dbname('forms')." ".sql_where_string($args)." ")->fetch_object()->total;

		$args['q'] = "date >= '".date('Y-m', strtotime("-1 months"))."-01 00:00:00' AND date <= '".date('Y-m', strtotime("-1 months"))."-".date('d H:i:s')."' ";
		$total['lastMonth']  =  db()->query("SELECT sum(total) as total FROM ".dbname('forms')." ".sql_where_string($args)." ")->fetch_object()->total;

		

		?>

		<div class="row space-none">
			<div class="col-md-3">

				<div class="">
					<small class="text-muted">bu gün</small>
					<br />
					<span class="ff-2 fs-18 bold"><?php echo get_set_money($total['day']); ?></span> <small class="text-muted">TL</small>
				</div>
				
			</div> <!-- /.col-* -->
			<div class="col-md-3">

				<div class="">
					<small class="text-muted">dün</small>
					<br />
					<span class="ff-2 fs-18 bold"><?php echo get_set_money($total['yesterday']); ?></span> <small class="text-muted">TL</small>
					<div clas="h-20"></div>
					<small class="text-muted" style="color:#1f1d1d;">
						<?php if( $total['last8Day'] > $total['yesterday']): ?>
							<i class="fa fa-arrow-up text-success"></i>
						<?php elseif( $total['last8Day'] < $total['yesterday']): ?>
							<i class="fa fa-arrow-down text-danger"></i>
						<?php endif; ?>
						<?php echo get_set_money($total['last8Day']);?> <i class="fa fa-try"></i>
					</small>
					<br />
					<small class="text-muted">/ geçen hafta aynı gün</small>
				</div>

			</div> <!-- /.col-* -->
			<div class="col-md-3">

				<div class="">
					<small class="text-muted">son 7 gün</small>
					<br />
					<span class="ff-2 fs-18 bold"><?php echo get_set_money($total['last7day']); ?></span> <small class="text-muted">TL</small>
					<div clas="h-20"></div>
					<small class="text-muted" style="color:#1f1d1d;">
						<?php if( $total['last7day'] > $total['lastWeek']): ?>
							<i class="fa fa-arrow-up text-success"></i>
						<?php elseif( $total['last7day'] < $total['lastWeek']): ?>
							<i class="fa fa-arrow-down text-danger"></i>
						<?php endif; ?>
						<?php echo get_set_money($total['lastWeek']);?> <i class="fa fa-try"></i>
					</small>
					<br />
					<small class="text-muted">/ önceki 7 gün</small>
				</div>

			</div> <!-- /.col-* -->
			<div class="col-md-3">

				<div class="">
					<small class="text-muted">bu ay</small>
					<br />
					<span class="ff-2 fs-18 bold"><?php echo get_set_money($total['thisMonth']); ?></span> <small class="text-muted">TL</small>
					<div clas="h-20"></div>
					<small class="text-muted" style="color:#1f1d1d;">
						<?php if( $total['thisMonth'] > $total['lastMonth']): ?>
							<i class="fa fa-arrow-up text-success"></i>
						<?php elseif( $total['thisMonth'] < $total['lastMonth']): ?>
							<i class="fa fa-arrow-down text-danger"></i>
						<?php endif; ?>
						<?php echo get_set_money($total['lastMonth']);?> <i class="fa fa-try"></i>
					</small>
					<br />
					<small class="text-muted">/ geçen ay aynı gün</small>
				</div>

			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		
		<div class="h-20"></div>
		<?php 
		$chart = array();
		$chart['type'] = 'bar';
		$chart['data']['datasets'][0]['label'] 	= 'Çıkışlar';
		$chart['data']['datasets'][0]['fill'] 	= false;
		$chart['data']['datasets'][0]['lineTension'] 	= '0';
		$chart['data']['datasets'][0]['borderWidth'] 	= 1.5;
		$chart['data']['datasets'][0]['pointBorderWidth'] 	= 1;
		$chart['data']['datasets'][0]['pointRadius'] 	= 1;

		$chart['data']['datasets'][1]['label'] 	= 'Ödeme Girişi';
		$chart['data']['datasets'][1]['type'] 	= 'line';
		$chart['data']['datasets'][1]['fill'] 	= true;
		$chart['data']['datasets'][1]['lineTension'] 	= '0.3';
		$chart['data']['datasets'][1]['borderWidth'] 	= 1.5;
		$chart['data']['datasets'][1]['pointBorderWidth'] 	= 1;
		$chart['data']['datasets'][1]['pointRadius'] 	= 1.5;

		$chart['data']['datasets'][2]['label'] 	= 'Girişler';
		$chart['data']['datasets'][2]['fill'] 	= false;
		$chart['data']['datasets'][2]['lineTension'] 	= '0';
		$chart['data']['datasets'][2]['borderWidth'] 	= 1.5;
		$chart['data']['datasets'][2]['pointBorderWidth'] 	= 1;
		$chart['data']['datasets'][2]['pointRadius'] 	= 1;

		$chart['data']['datasets'][3]['label'] 	= 'Ödeme Çıkışı';
		$chart['data']['datasets'][3]['type'] 	= 'line';
		$chart['data']['datasets'][3]['fill'] 	= true;
		$chart['data']['datasets'][3]['lineTension'] 	= '0.3';
		$chart['data']['datasets'][3]['borderWidth'] 	= 1.5;
		$chart['data']['datasets'][3]['pointBorderWidth'] 	= 1;
		$chart['data']['datasets'][3]['pointRadius'] 	= 1.4;


		$_start_date = date('Y-m-d', strtotime('-2 week', strtotime(date('Y-m-d'))) );
		$_end_date = date('Y-m-d');
		while(strtotime($_start_date) <= strtotime($_end_date) ) {
			$chart['data']['labels'][] = $_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));

			$_total = 0;
			$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND type='form' AND in_out='1' AND date >= '".$_start_date." 00:00:00' AND date <= '".$_start_date." 23:59:59' ORDER BY id DESC, date DESC");
			if(($_total = $q_forms->fetch_object()->total) > 0) {
				$chart['data']['datasets'][0]['data'][] = $_total;
			} else {
				$chart['data']['datasets'][0]['data'][] = '0.00';
			}

			$_total = 0;
			$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND type='payment' AND in_out='0' AND date >= '".$_start_date." 00:00:00' AND date <= '".$_start_date." 23:59:59' ORDER BY id DESC, date DESC");
			if(($_total = $q_forms->fetch_object()->total) > 0) {
				$chart['data']['datasets'][1]['data'][] = $_total;
			} else {
				$chart['data']['datasets'][1]['data'][] = '0.00';
			}

			$_total = 0;
			$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND type='form' AND in_out='0' AND date >= '".$_start_date." 00:00:00' AND date <= '".$_start_date." 23:59:59' ORDER BY id DESC, date DESC");
			if(($_total = $q_forms->fetch_object()->total) > 0) {
				$chart['data']['datasets'][2]['data'][] = '-'.$_total;
			} else {
				$chart['data']['datasets'][2]['data'][] = '0.00';
			}

			$_total = 0;
			$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND type='payment' AND in_out='1' AND date >= '".$_start_date." 00:00:00' AND date <= '".$_start_date." 23:59:59' ORDER BY id DESC, date DESC");
			if(($_total = $q_forms->fetch_object()->total) > 0) {
				$chart['data']['datasets'][3]['data'][] = '-'.$_total;
			} else {
				$chart['data']['datasets'][3]['data'][] = '0.00';
			}

			
		}

		$chart['options']['legend']['display'] = false;
		$chart['options']['legend']['position'] = 'top';
		$chart['options']['scales']['yAxes'][0]['display'] = true;
		$chart['options']['scales']['yAxes'][0]['position'] = 'left';
		$chart['options']['scales']['yAxes'][0]['ticks']['userCallback'] = "=TIL= function(value, index, values) { return value.formatMoney(2, '.', ',') + ' TL';  } =TIL=";
		$chart['options']['scales']['xAxes'][0]['display'] = false;
		$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
		$chart['options']['maintainAspectRatio'] = false;
		$chart['options']['tooltips']['enabled'] = true;
		$chart['options']['tooltips']['yLabel'] = 'krall';
		$chart['options']['tooltips']['mode'] = 'nearest';
		$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) {  return ''; } =TIL=";
		$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) {  return  tooltipItems.yLabel.formatMoney(2, '.', ',') + ' TL'; } =TIL=";
		

		$args['height'] 	= '100';
		$args['chart'] 		= $chart;
		?>
		
		<style>
		.module-title-star {
		    font-size: 28px;
		    font-weight: 300;
		    height: 100%;
		    display: flex;
		}
		</style>

		<div class="relative"><?php chartjs($args); ?></div>

		<div class="h-20"></div>
		<hr />
		<div class="h-20"></div>

		<div class="row space-none">

			<div class="col-md-3">
				<div class="module-title-star">
					<span class=" ff-1"> Para</span>
				</div>

			</div> <!-- /.col-* -->
			<div class="col-md-3">

				<div class="">
					<small class="text-muted">GİRİŞ</small>
					<br />
					<span class="ff-2 fs-18 bold"><?php echo get_set_money($total['last7day']); ?></span> <small class="text-muted">TL</small>
					<div clas="h-20"></div>
					<small class="text-muted" style="color:#1f1d1d;">
						bu gün
					</small>
				</div>

			</div> <!-- /.col-* -->
			<div class="col-md-3">

				<div class="">
					<small class="text-muted">GİRİŞ</small>
					<br />
					<span class="ff-2 fs-18 bold"><?php echo get_set_money($total['last7day']); ?></span> <small class="text-muted">TL</small>
					<div clas="h-20"></div>
					<small class="text-muted" style="color:#1f1d1d;">
						bu gün
					</small>
				</div>

			</div> <!-- /.col-* -->
			<div class="col-md-3">

				<div class="">
					<small class="text-muted">ÇIKIŞ</small>
					<br />
					<span class="ff-2 fs-18 bold"><?php echo get_set_money($total['thisMonth']); ?></span> <small class="text-muted">TL</small>
					<div clas="h-20"></div>
					<small class="text-muted" style="color:#1f1d1d;">
						<i class="fa fa-plus text-success"></i> GİRİŞ
					</small>
				</div>

			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

	</div>
</div> <!-- /.row -->















<?php get_footer(); ?>





<?php 
function rastgeleYazi($uzunluk = 10) {
    $karakterler = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $karakterlerUzunlugu = strlen($karakterler);
    $rastgele = '';
    for ($i = 0; $i < $uzunluk; $i++) {
        $rastgele .= $karakterler[mt_rand(0, $karakterlerUzunlugu - 1)];
    }
    return $rastgele;
}




if(isset($_GET['add_account'])) {

	for($i=0; $i<=100000; $i++) {
		$array=array();
		$array['type'] = 'account';
		$array['name'] = rastgeleYazi(20);
		$array['code'] = rastgeleYazi(20);
		$array['email'] = til_get_strtolower($array['name']).'@tilpark.com';
		$array['gsm'] = '535'.rand(1111111,9999999);
		$array['phone'] = rand(1111111111,9999999999);
		$array['address'] = rastgeleYazi(250);
		$array['tax_home'] = rastgeleYazi(20);
		$array['tax_no'] = rand(1111111111,9999999999);
		add_account($array);
	}
}


if( isset($_GET['add_item'])) {

	for($i=0; $i<=100000; $i++) {
		$array=array();
		$array['type'] = 'product';
		$array['name'] = rastgeleYazi(20);
		$array['vat'] = '18';
		$array['p_purc'] = rand(1,9999);
		$array['p_sale'] = rand($array['p_purc'],99999);
			
		add_item($array);
	}
}
?>
