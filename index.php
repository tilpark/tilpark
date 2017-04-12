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

	</div> <!-- /.col-md-6 -->

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">




		<?php 
		$total['day'] = 0;
		$total['yesterday'] = 0;
		$total['last7day'] = 0;
		$total['thisMonth'] = 0;
		$total['last8Day'] = 0;
		$total['lastWeek'] = 0;
		$total['lastMonth'] = 0;

		$args['status'] = 1;
		$args['type'] 	= 'form';
		$args['in_out'] = '1';  
		$args['q'] = "date >= '".date('Y-m', strtotime("-1 months"))."-01 00:00:000' AND date <= '".date('Y-m-d')." 23:59:59'";
		$query = db()->query("SELECT date,total FROM ".dbname('forms')." ".sql_where_string($args)." ");

		if($query->num_rows) {
			while( $list = $query->fetch_object() ) {
				$_date = til_get_date($list->date, 'Y-m-d');

				// day
				if( $_date == date('Y-m-d') ) {
					$total['day'] = $total['day'] + $list->total;
				}

				// yesterday
				if( $_date == date('Y-m-d', strtotime("-1 day")) ) {	
					$total['yesterday'] = $total['yesterday'] + $list->total;
				}

				// last7day
				if( $_date >= date('Y-m-d', strtotime("-8 day")) AND $_date <= date('Y-m-d') ) {	
					$total['last7day'] = $total['last7day'] + $list->total;
				}

				// thisMonth
				if( $_date >= date('Y-m')."-01" AND $_date <= date('Y-m-d') ) {	
					$total['thisMonth'] = $total['thisMonth'] + $list->total;
				}

				// last8Day
				if( $_date >= date('Y-m-d', strtotime("-8 day")) AND $_date <= date('Y-m-d', strtotime("-8 day")) ) {	
					$total['last8Day'] = $total['last8Day'] + $list->total;
				}

				// lastWeek
				if( $_date >= date('Y-m-d', strtotime("-14 day")) AND $_date <= date('Y-m-d', strtotime("-8 day")) ) {	
					$total['lastWeek'] = $total['lastWeek'] + $list->total;
				}

				// lastMonth
				if( $_date >= date('Y-m', strtotime("-1 months"))."-01" AND $_date <= date('Y-m', strtotime("-1 months"))."-".date('d H:i:s') ) {	
					$total['lastMonth'] = $total['lastMonth'] + $list->total;
				}
			}
		}
		?>
		<hr class="visible-xs" />
		<div class="row space-none">
			<div class="col-xs-6 col-md-3">

				<div class="">
					<small class="text-muted">bu gün</small>
					<br />
					<span class="ff-2 fs-18 bold"><?php echo get_set_money($total['day']); ?></span> <small class="text-muted">TL</small>
				</div>
				
			</div> <!-- /.col-* -->
			<div class="col-xs-6 col-md-3">

				<div class="">
					<small class="text-muted">dün</small>
					<br />
					<span class="ff-2 fs-18 bold"><?php echo get_set_money($total['yesterday']); ?></span> <small class="text-muted">TL</small>
					<div clas="h-20"></div>
					<small class="text-muted c-help" style="color:#1f1d1d;">
						<?php if( $total['last8Day'] < $total['yesterday']): ?>
							<i class="fa fa-arrow-up text-success"></i>
						<?php elseif( $total['last8Day'] > $total['yesterday']): ?>
							<i class="fa fa-arrow-down text-danger"></i>
						<?php endif; ?>
						<span class="" data-toggle="tooltip" title="geçen hafta aynı gün" data-placement="bottom"><?php echo get_set_money($total['last8Day']);?> <i class="fa fa-try"></i></span>
					</small>
				</div>

			</div> <!-- /.col-* -->
			<div class="col-xs-6 col-md-3">
				<div class="h-20 visible-xs"></div>
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
			<div class="col-xs-6 col-md-3">
				<div class="h-20 visible-xs"></div>
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
		<div class="h-20 visible-xs"></div>
		<div class="h-20"></div>
		<?php 
		$chart = array();
		$chart['type'] = 'line';
		$chart['data']['datasets'][0]['label'] 	= 'Çıkışlar';
		$chart['data']['datasets'][0]['fill'] 	= true;
		$chart['data']['datasets'][0]['lineTension'] 	= '0.3';
		$chart['data']['datasets'][0]['borderWidth'] 	= 1.5;
		$chart['data']['datasets'][0]['pointBorderWidth'] 	= 1;
		$chart['data']['datasets'][0]['pointRadius'] 	= 1;

		$chart['data']['datasets'][1]['label'] 	= 'Para Girişi';
		$chart['data']['datasets'][1]['type'] 	= 'line';
		$chart['data']['datasets'][1]['fill'] 	= true;
		$chart['data']['datasets'][1]['lineTension'] 	= '0.3';
		$chart['data']['datasets'][1]['borderWidth'] 	= 1.5;
		$chart['data']['datasets'][1]['pointBorderWidth'] 	= 1;
		$chart['data']['datasets'][1]['pointRadius'] 	= 1.5;

		$chart['data']['datasets'][2]['label'] 	= 'Girişler';
		$chart['data']['datasets'][2]['fill'] 	= true;
		$chart['data']['datasets'][2]['lineTension'] 	= '0.3';
		$chart['data']['datasets'][2]['borderWidth'] 	= 1.5;
		$chart['data']['datasets'][2]['pointBorderWidth'] 	= 1;
		$chart['data']['datasets'][2]['pointRadius'] 	= 1;

		$chart['data']['datasets'][3]['label'] 	= 'Para Çıkışı';
		$chart['data']['datasets'][3]['type'] 	= 'line';
		$chart['data']['datasets'][3]['fill'] 	= true;
		$chart['data']['datasets'][3]['lineTension'] 	= '0.3';
		$chart['data']['datasets'][3]['borderWidth'] 	= 1.5;
		$chart['data']['datasets'][3]['pointBorderWidth'] 	= 1;
		$chart['data']['datasets'][3]['pointRadius'] 	= 1.4;


		$_start_date = date('Y-m-d', strtotime('-2 week', strtotime(date('Y-m-d'))) );
		$_end_date = date('Y-m-d');
		while(strtotime($_start_date) < strtotime($_end_date) ) {
			$_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));

			$chart['data']['labels'][] = til_get_date($_start_date, 'd F');
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
		$chart['options']['legend']['position'] = 'bottom';
		$chart['options']['scales']['yAxes'][0]['display'] = false;
		$chart['options']['scales']['yAxes'][0]['position'] = 'left';
		$chart['options']['scales']['yAxes'][0]['ticks']['userCallback'] = "=TIL= function(value, index, values) { return value.formatMoney(2, '.', ',') + ' TL';  } =TIL=";
		$chart['options']['scales']['xAxes'][0]['display'] = false;
		$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
		$chart['options']['maintainAspectRatio'] = false;
		$chart['options']['tooltips']['enabled'] = true;

		$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { console.log(tooltipItems);  console.log(data); return tooltipItems[0].xLabel +' : '+ data.datasets[tooltipItems[0].datasetIndex].label; } =TIL=";
		$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) { return ' '+tooltipItems.yLabel.formatMoney(2, '.', ',') + ' TL'; } =TIL=";
		

		$args['height'] 	= '100';
		$args['chart'] 		= $chart;
		?>
		<div class="relative"><?php chartjs($args); ?></div>

		<hr />

		

	</div> <!-- /.col -->
</div> <!-- /.row -->










<div class="row hidden-xs">
	<div class="col-md-6">

		<div class="row space-5">
			<div class="col-md-6">
				<small class="text-muted"><i class="fa fa-long-arrow-down text-black"></i> GİRİŞ FORM DURUMLARI</small>
				<div class="h-10"></div>
				<?php if($form_status_all = get_form_status_all('1')): ?>
					<div class="list-group mobile-full list-group-dashboard">
						<?php foreach($form_status_all as $status): ?>
							<a href="admin/form/list.php?status_id=<?php echo $status->id; ?>" class="list-group-item" style="border-left:1px solid <?php echo $status->bg_color; ?>;">
								<?php echo $status->name; ?>
								<span class="pull-right"><?php echo $status->count = calc_form_status($status->id); ?></span>
							</a>
						<?php endforeach; ?>
					</div>

				<?php endif; ?>
			</div>
			<div class="col-md-6">
				<small class="text-muted"><i class="fa fa-long-arrow-up text-black"></i> ÇIKIŞ FORM DURUMLARI</small>
				<div class="h-10"></div>
				<?php if($form_status_all = get_form_status_all('0')): ?>
					<div class="list-group mobile-full list-group-dashboard">
						<?php foreach($form_status_all as $status): ?>
							<a href="admin/form/list.php?status_id=<?php echo $status->id; ?>" class="list-group-item" style="border-left:1px solid <?php echo $status->bg_color; ?>;">
								<?php echo $status->name; ?>
								<span class="pull-right"><?php echo $status->count = calc_form_status($status->id); ?></span>
							</a>
						<?php endforeach; ?>
					</div>

				<?php endif; ?>
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<div class="h-20"></div>

		<small class="text-muted"><i class="fa fa-file-o text-blackk"></i> SON 50 SİPARİŞ</small>
		<div class="h-10"></div>
		<?php $query = db()->query("SELECT * FROM ".dbname('forms')." WHERE status='1' AND type='form' AND in_out='1' ORDER BY date DESC LIMIT 50"); ?>
		<?php if($query->num_rows): ?>
			<div class="panel panel-warning panel-heading-0 panel-border-right panel-table">
				<div class="panel-body" style="height:280px; overflow: auto;">	
					<table class="table table-hover table-condensed table-striped table-striped">
						<tbody>
						<?php while($list = $query->fetch_object()): ?>
							<?php $form_status = get_form_status($list->status_id); ?>
							<tr class="pointer" onclick="location.href='<?php site_url('form', $list->id); ?>';">
								<td width="80"><a href="<?php site_url('form', $list->id); ?>">#<?php echo $list->id; ?></a></td>
								<td><?php echo til_get_substr($list->account_name,0,30); ?></td>
								<td class="text-muted"><i class="fa fa-square" style=" color:<?php echo $form_status->bg_color; ?>;"></i> <?php echo til_get_strtoupper($form_status->name); ?></td>
								<td class="text-right"><?php set_money($list->total); ?> <i class="fa fa-try text-muted"></i></td>
							</tr>
						<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php else: ?>

		<?php endif; ?>

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">
		<div class="row space-none">

			<div class="col-md-6">

				<div class="panel panel-warning panel-border-0">
					<div class="panel-heading"><h4 class="panel-title">STOK</h4></div>
					<div class="panel-body">

						<div class="row space-5">
							<div class="col-md-4">
								<?php
								$chart = array();
								$chart['type'] = 'pie';
								// $chart['data']['datasets'][0]['label'] 	= 'Giriş';
								$chart['data']['datasets'][0]['fill'] 	= true;
								$chart['data']['datasets'][0]['lineTension'] 	= 0.3;
								$chart['data']['datasets'][0]['borderWidth'] 	= 1;
								$chart['data']['datasets'][0]['pointBorderWidth'] 	= 1;
								$chart['data']['datasets'][0]['pointRadius'] 	= 1;


								$total['item']['i'] = 0;
								$total['item']['quantity'] = 0;
								$total['item']['purc'] = 0;
								$total['item']['sale'] = 0;

								$args = array();
								$args['status'] = '1';
								$args['q'] = 'quantity > 0';
								$args['ORDER_BY'] = array('quantity'=>'DESC');
								$query = db()->query("SELECT * FROM ".dbname('items')." ".sql_where_string($args)." ");
								if( $query->num_rows ) {
									$i = 0;
									$_other = 0;
									while($list = $query->fetch_object()) {
										if($i < 10) {
											$chart['data']['labels'][] = $list->name;
											$chart['data']['datasets'][0]['data'][] = $list->quantity;
											$i++;
										} else {
											$_other = $list->quantity;
										}

										$total['item']['i']++;
										$total['item']['quantity'] 	= $total['item']['quantity'] + $list->quantity;
										$total['item']['purc']	 	= $total['item']['purc'] + ( $list->p_purc * $list->quantity );
										$total['item']['sale']	 	= $total['item']['sale'] + ( $list->p_sale * $list->quantity );
									}

									if($_other > 0) {
										$chart['data']['labels'][] = 'Diğer';
										$chart['data']['datasets'][0]['data'][] = $_other;
									}
								}

								

								$chart['options']['legend']['display'] = false;
								$chart['options']['scales']['yAxes'][0]['display'] = false;
								$chart['options']['scales']['xAxes'][0]['display'] = false;
								$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
								$chart['options']['maintainAspectRatio'] = false;
								$chart['options']['tooltips']['enabled'] = false;
								$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
								$chart['options']['tooltips']['callbacks']['label'] =  "=TIL= function(tooltipItems, data) { return ''; } =TIL=";

								$args['height'] 	= '45';
								$args['chart'] 		= $chart;
								?>
								<?php chartjs($args); ?>
							</div> <!-- /.col-* -->
							<div class="col-md-8">
								<div class="">
									<small class="text-muted" style="color:#1f1d1d;"><?php echo $total['item']['i']; ?></small> <small class="text-muted">farklı çeşit</small>
									<br />
									<span class="ff-2 fs-18 bold"><?php echo $total['item']['quantity']; ?></span> <small class="text-muted">adet</small>
									<div clas="h-20"></div>
									
								</div>
								<div class="h-20"></div>
							</div> <!-- /.col-md-6 -->
							<div class="col-md-6">
								<div class="">
									<small class="text-muted">maliyet değeri</small>
									<br />
									<span class="ff-2 fs-14 bold"><?php echo get_set_money($total['item']['purc']); ?></span> <small class="text-muted">TL</small>
								</div>
							</div> <!-- /.col-md-6 -->
							<div class="col-md-6">
								<div class="">
									<small class="text-muted">satış değeri</small>
									<br />
									<span class="ff-2 fs-14 bold"><?php echo get_set_money($total['item']['sale']); ?></span> <small class="text-muted">TL</small>
								</div>
							</div> <!-- /.col-md-6 -->
						</div> <!-- /.row -->
						

						

					</div> <!-- /.panel -->
				</div> <!-- /.panel -->

			</div> <!-- /.col-* -->
			<div class="col-md-6">

				<div class="panel panel-success panel-border-0">
					<div class="panel-heading"><h4 class="panel-title">PARA</h4></div>
					<div class="panel-body">


						<div class="row space-5">
							<div class="col-md-4">
								<?php
								$chart = array();
								$chart['type'] = 'doughnut';
								// $chart['data']['datasets'][0]['label'] 	= 'Giriş';
								$chart['data']['datasets'][0]['fill'] 	= true;
								$chart['data']['datasets'][0]['lineTension'] 	= 0.3;
								$chart['data']['datasets'][0]['borderWidth'] 	= 1;
								$chart['data']['datasets'][0]['pointBorderWidth'] 	= 1;
								$chart['data']['datasets'][0]['pointRadius'] 	= 1;


								$total['case'] = 0; 
								if($cases = get_case_all(array('is_bank'=>0))) {
									foreach($cases as $case) {
										$chart['data']['labels'][] = $case->name;
										$chart['data']['datasets'][0]['data'][] = $case->total;

										$total['case'] = $total['case'] + $case->total;
									}
								}

								if($cases = get_case_all(array('is_bank'=>1))) {
									foreach($cases as $case) {
										$chart['data']['labels'][] = $case->name;
										$chart['data']['datasets'][0]['data'][] = $case->total;

										$total['case'] = $total['case'] + $case->total;
									}
								}

								$chart['options']['legend']['display'] = false;
								$chart['options']['scales']['yAxes'][0]['display'] = false;
								$chart['options']['scales']['xAxes'][0]['display'] = false;
								$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
								$chart['options']['maintainAspectRatio'] = false;
								$chart['options']['tooltips']['enabled'] = false;
								$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
								$chart['options']['tooltips']['callbacks']['label'] =  "=TIL= function(tooltipItems, data) { return ''; } =TIL=";

								$args['height'] 	= '45';
								$args['chart'] 		= $chart;
								?>
								<?php chartjs($args); ?>
							</div> <!-- /.col-* -->
							<div class="col-md-8">
								<div class="">
									<small class="text-muted" style="color:#1f1d1d;">KASA</small> <small class="text-muted">toplam</small>
									<br />
									<span class="ff-2 fs-18 bold"><?php echo get_set_money($total['case']); ?></span> <small class="text-muted">TL</small>
									<div clas="h-20"></div>
									
								</div>
								<div class="h-20"></div>
							</div> <!-- /.col-md-6 -->
							<div class="col-md-6">
								<div class="">
									<small class="text-muted">bu gün giriş</small>
									<br />
									<span class="ff-2 fs-14 bold">+ <?php echo get_set_money( db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE in_out='0' AND status='1' AND type='payment' AND date >= '".date('Y-m-d')." 00:00:00' AND date <= '".date('Y-m-d')." 23:59:59' ")->fetch_object()->total ); ?></span> <small class="text-muted">TL</small>
								</div>
							</div> <!-- /.col-md-6 -->
							<div class="col-md-6">
								<div class="">
									<small class="text-muted">bu gün çıkış</small>
									<br />
									<span class="ff-2 fs-14 bold">- <?php echo get_set_money( db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE in_out='1' AND status='1' AND type='payment' AND date >= '".date('Y-m-d')." 00:00:00' AND date <= '".date('Y-m-d')." 23:59:59' ")->fetch_object()->total ); ?></span> <small class="text-muted">TL</small>
								</div>
							</div> <!-- /.col-md-6 -->
						</div> <!-- /.row -->
						

						

					</div> <!-- /.panel -->
				</div> <!-- /.panel -->

			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<div class="h-20"></div>
		<small class="text-muted"><i class="fa fa-tasks fs-12"></i> GÖREVLER</small>
		<div class="h-10"></div>
		<?php if($tasks = get_tasks(array('query'=> _get_query_task('inbox')) )): ?>
			<div class="panel panel-warning panel-heading-0 panel-border-right panel-table">
				<div class="panel-body" style="height:280px; overflow: auto;">	
					<table class="table table-hover table-condensed table-striped">
						<tbody>
						<?php foreach($tasks as $task): ?>
							<?php $task = get_task($task->id); ?>
					<?php
						if($task->choice_count) {
								$part 			= (100 / $task->choice_count);
								$part_completed = round($part * $task->choice_closed);

								# progress-bar style
								$progressbar_style = '';
								if($part_completed < 30) { $progressbar_style = 'progress-bar-danger';
								} elseif($part_completed < 70) { $progressbar_style = 'progress-bar-warning';
								} else { $progressbar_style = 'progress-bar-success'; }
							}
						?>
						<tr mobile-progress-width="100" mobile-progress-style="<?php echo $progressbar_style; ?>" class="<?php if(!$task->read_it and $task->inbox_u_id == get_active_user('id')): ?>bold<?php endif; ?> pointer" onclick="location.href='<?php site_url('task', $task->id); ?>';">
							<td width="40">
								
									<img src="<?php user_info($task->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-right" width="32">
							
							</td>
							<td class="hidden-xs-portrait visible-xs-landscape"><a href="<?php site_url('task', $task->id); ?>">
							<span class=""><?php user_info($task->sen_u_id,'display_name'); ?></span> <br />
							<span class="text-muted"><?php echo $task->title; ?></span></td>
							<td class="visible-xs-landscape">
								<?php echo til_get_date($task->date_end, 'datetime'); ?>
								<br />
								<?php echo get_time_late(til_get_date($task->date_end, 'datetime')); ?>
							</td>
						</tr>
						<tr>
							<td class="hidden-xs" colspan="5" style="padding: 0px; border-top: 0px;">
								<?php if($task->choice_count): ?>
									<div class="progress m-0 br-2 h-3">
										<div class="progress-bar progress-bar-stripedd <?php echo $progressbar_style; ?> text-muted" role="progressbar" aria-valuenow="<?php echo $part_completed; ?>" aria-valuemin="30" aria-valuemax="100" style="width: <?php echo ($part_completed == '0' ? '25' : $part_completed); ?>%;">
											<span class="sr-only"><?php echo $part_completed; ?>% tamamlandı</span>
											%<?php echo $part_completed; ?> tamamlandı
										</div> <!-- /.progess-bar -->
									</div> <!-- /.progress -->

								<?php endif; ?>
							</td>
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php else: ?>

		<?php endif; ?>


	</div> <!-- /.col-md-6 -->
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
