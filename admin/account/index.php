<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Hesap Yönetimi' );
add_page_info( 'nav', array('name'=>'Hesap Yönetimi') );
?>


<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<div class="row space-5">
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/account/add.php'); ?>">
						<span class="icon-box"><i class="fa fa-plus-square-o"></i></span>
						<h3>Yeni</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/account/list.php'); ?>">
						<span class="icon-box"><i class="fa fa-list"></i></span>
						<h3>Hesap Kartları</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<div class="h-20 visible-xs"></div>

	</div> <!-- /.col-md-6 -->
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">


		<?php 
		$total = array();
		
		$q = db()->query("SELECT sum(balance) as balance FROM ".dbname('accounts')." WHERE status='1' AND balance > 0 ");
		$total['in_balance'] = $q->fetch_object()->balance; 

		$q = db()->query("SELECT sum(balance) as balance FROM ".dbname('accounts')." WHERE status='1' AND balance < 0 ");
		$total['out_balance'] = $q->fetch_object()->balance; 

		$total['status'] = $total['in_balance'] - abs($total['out_balance']);

		
		?>

		<?php 
		$chart = array();
		$chart['type'] = 'line';
		$chart['data']['datasets'][0]['label'] 	= 'Hareketler';
		$chart['data']['datasets'][0]['fill'] 	= true;
		$chart['data']['datasets'][0]['lineTension'] 	= '0';
		$chart['data']['datasets'][0]['borderWidth'] 	= 0.1;
		$chart['data']['datasets'][0]['pointBorderWidth'] 	= 0.5;
		$chart['data']['datasets'][0]['pointRadius'] 	= 1;
		$chart['data']['datasets'][0]['backgroundColor'] 	= 'rgba(253, 196, 48, 0.2)';
		$chart['data']['datasets'][0]['borderColor'] 		= 'rgba(253, 196, 48, 1)';


		$_start_date = date('Y-m-d', strtotime('-4 week', strtotime(date('Y-m-d'))) );
		$_end_date = date('Y-m-d');
		while(strtotime($_start_date) <= strtotime($_end_date) ) {
			$chart['data']['labels'][] = $_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));

			$_total = 0;
			$chart_balance = $total['status'];
			$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND in_out='0' AND date >= '".$_start_date." 00:00:00' ORDER BY id DESC, date DESC");
			if(($_total = $q_forms->fetch_object()->total) > 0) {
				// $chartt['data']['datasets'][0]['data'][] = $_total;
			} else {
				// $chartt['data']['datasets'][0]['data'][] = '0.00';
			}
			$chart_balance = $chart_balance + $_total;

			$_total = 0;
			$q_forms = db()->query("SELECT sum(total) as total FROM ".dbname('forms')." WHERE status='1' AND in_out='1' AND date >= '".$_start_date." 00:00:00' ORDER BY id DESC, date DESC");
			if(($_total = $q_forms->fetch_object()->total) > 0) {
				// $chartt['data']['datasets'][1]['data'][] = $_total;
			} else {
				// $chartt['data']['datasets'][1]['data'][] = '0.00';
			}
			$chart_balance = $chart_balance - $_total;
			$chart['data']['datasets'][0]['data'][] = $chart_balance;
		}

		$chart['options']['legend']['display'] = false;
		$chart['options']['scales']['yAxes'][0]['display'] = false;
		$chart['options']['scales']['xAxes'][0]['display'] = false;
		$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
		$chart['options']['maintainAspectRatio'] = false;
		$chart['options']['tooltips']['enabled'] = true;
		$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) {  return ''; } =TIL=";
		$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) {  return  tooltipItems.yLabel.formatMoney(2, '.', ',') + ' TL'; } =TIL=";
		

		$args['height'] 	= '60';
		$args['chart'] 		= $chart;
		?>
		<div class="row space-none">
			<div class="col-md-3">

				<div class="">
					<span class="ff-2 fs-18 bold <?php echo $total['status'] < 0 ? 'text-danger' : 'text-success'; ?>"><?php echo get_set_money($total['status']); ?></span> <small class="text-muted">TL</small>
					<br />
					<small class="text-muted">son durum</small>
				</div>
				
			</div> <!-- /.col-* -->
			<div class="col-md-9">

				<?php chartjs($args); ?>

			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<hr />

		<div class="row space-none">
			<div class="col-md-3">

				<div class="">
					<span class="ff-2 fs-16 bold"><?php echo get_set_money($total['in_balance']); ?></span> <small class="text-muted">TL</small>
					<br />
					<small class="text-muted">toplam alacak</small>
				</div>
				
			</div> <!-- /.col-* -->
			<div class="col-md-3">

				<div class="">
					<span class="ff-2 fs-16 bold"><?php echo get_set_money($total['out_balance']); ?></span> <small class="text-muted">TL</small>
					<br />
					<small class="text-muted">toplam borç</small>
				</div>

			</div> <!-- /.col-* -->
			<div class="col-md-6">
				<?php 
						$chart = array();
						$chart['type'] = 'bar';
						$chart['data']['datasets'][0]['label'] 	= 'Alacak';
						$chart['data']['datasets'][0]['type'] 	= 'bar';
						$chart['data']['datasets'][0]['fill'] 	= true;
						$chart['data']['datasets'][0]['lineTension'] 	= 0.5;
						$chart['data']['datasets'][0]['borderWidth'] 	= 1;
						$chart['data']['datasets'][0]['pointBorderWidth'] 	= 3;
						$chart['data']['datasets'][0]['pointRadius'] 	= 1;

						$chart['data']['datasets'][1]['label'] 	= 'Kar/Zarar';
						$chart['data']['datasets'][1]['type'] 	= 'line';
						$chart['data']['datasets'][1]['fill'] 	= true;
						$chart['data']['datasets'][1]['lineTension'] 	= 0.5;
						$chart['data']['datasets'][1]['borderWidth'] 	= 1;
						$chart['data']['datasets'][1]['pointBorderWidth'] 	= 3;
						$chart['data']['datasets'][1]['pointRadius'] 	= 1;

						$other[0] = 0;
						$other[1] = 0;
						$query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE status='1' AND type='account' AND balance > 0 ORDER BY balance DESC");
						if($query->num_rows) {
							$i = 0;
							while($list = $query->fetch_object()) {
								if($i < 20) {
									$chart['data']['labels'][] = $list->name;
									$chart['data']['datasets'][0]['data'][] = $list->balance;
									$chart['data']['datasets'][1]['data'][] = $list->profit;
								} else {
									$other[0] = $other[0] + $list->balance;
									$other[1] = $other[1] + $list->profit;
								}
								$i++;
							}
						}

						$chart['data']['labels'][] = 'Diğer';
						$chart['data']['datasets'][0]['data'][] = $other[0];
						$chart['data']['datasets'][1]['data'][] = $other[0];

						$chart['options']['legend']['display'] = false;
						$chart['options']['scales']['yAxes'][0]['display'] = false;
						$chart['options']['scales']['yAxes'][0]['ticks']['userCallback'] = "=TIL= function(value, index, values) { return value.formatMoney(2, '.', ',') + ' TL';  } =TIL=";
						$chart['options']['scales']['xAxes'][0]['display'] = false;
						$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
						$chart['options']['maintainAspectRatio'] = false;
						// $chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
						$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) { return data.datasets[tooltipItems.datasetIndex].label +' : '+ tooltipItems.yLabel.formatMoney(2, '.', ',') + ' TL'; } =TIL=";

						$args = array();
						$args['height'] 	= '100';
						$args['chart'] 		= $chart;
						?>
						
						<div class="relativee"><?php chartjs($args); ?></div>

		
			</div>
		</div> <!-- /.row -->


		
		
	</div> <!-- /.col-* -->
</div> <!-- /.row -->

<div class="h-20"></div>


<div class="row">
	<div class="col-md-6">

		<small class="text-muted module-title-small"><i class="fa fa-th-list"></i> SON EKLENEN HESAP KARTLARI</small>
		<div class="h-10"></div>
		<div class="panel panel-warning panel-table panel-heading-0 panel-border-right">
			<div class="panel-body" style="height:280px; overflow: auto;">
			<?php $query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE status='1' AND type='account' ORDER BY id DESC LIMIT 50 "); ?>
			<?php if($query->num_rows): ?>
				<table class="table table-hover table-condensed table-stripe">
					<tbody>
						<?php while($list = $query->fetch_object()): ?>
							<tr onclick="location.href='<?php site_url('account', $list->id); ?>';" class="pointer">
								<td><a href="<?php site_url('account', $list->id); ?>"><?php echo $list->name; ?></a></td>
								<td class="text-right"><?php echo get_set_money($list->balance, true); ?></td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			<?php endif; ?>
			</div>
		</div> <!-- /.panel -->

	</div> <!-- /.col-* -->
	<div class="col-md-6">



				<div class="row">
					<div class="col-md-12">
					
						

					</div> <!-- /.col-* -->
					<div class="col-md-6">
					
						<?php 
						$chart = array();
						$chart['type'] = 'bar';
						// $chart['data']['datasets'][0]['label'] 	= 'Giriş';
						$chart['data']['datasets'][0]['fill'] 	= true;
						$chart['data']['datasets'][0]['lineTension'] 	= 0.3;
						$chart['data']['datasets'][0]['borderWidth'] 	= 1;
						$chart['data']['datasets'][0]['pointBorderWidth'] 	= 1;
						$chart['data']['datasets'][0]['pointRadius'] 	= 1;

						$other = 0;
						$query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE status='1' AND type='account' AND balance < 0 ORDER BY balance ASC");
						if($query->num_rows) {
							$i = 0;
							while($list = $query->fetch_object()) {
								if($i < 10 ) {
									$chart['data']['labels'][] = $list->name;
									$chart['data']['datasets'][0]['data'][] = abs($list->balance);
								} else {
									$other = $other + abs($list->balance);
								}
								$i++;
							}
						}

						$chart['data']['labels'][] = 'Diğer';
						$chart['data']['datasets'][0]['data'][] = $other;

						$chart['options']['legend']['display'] = false;
						$chart['options']['scales']['yAxes'][0]['display'] = false;
						$chart['options']['scales']['xAxes'][0]['display'] = false;
						$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
						$chart['options']['maintainAspectRatio'] = false;
						$chart['options']['scales']['yAxes'][0]['ticks']['userCallback'] = "=TIL= function(value, index, values) { return value.formatMoney(2, '.', ',') + ' TL';  } =TIL=";
						$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) { return parseFloat(data.datasets[0].data[tooltipItems.index]).formatMoney(2, '.', ',') + ' TL'; } =TIL=";

						$args = array();
						$args['height'] 	= '130';
						$args['chart'] 		= $chart;
						?>


						<div class="panel panel-default panel-border-0">
							<div class="panel-heading"><h4 class="panel-title">Borç Dağılım Grafiği</h4></div>
							<div class="panel-body">
								<div class="relative"><?php chartjs($args); ?></div>
							</div>
						</div>

					</div> <!-- /.col-* -->
					<div class="col-md-6">
						
								<?php 
								$chart = array();
								$chart['type'] = 'pie';
								// $chart['data']['datasets'][0]['label'] 	= 'Giriş';
								$chart['data']['datasets'][0]['fill'] 	= true;
								$chart['data']['datasets'][0]['lineTension'] 	= 0.3;
								$chart['data']['datasets'][0]['borderWidth'] 	= 1;
								$chart['data']['datasets'][0]['pointBorderWidth'] 	= 1;
								$chart['data']['datasets'][0]['pointRadius'] 	= 1;

								$other = 0;
								$query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE status='1' AND type='account' AND profit > 0 ORDER BY profit DESC");
								if($query->num_rows) {
									$i = 0;
									while($list = $query->fetch_object()) {
										if($i < 5) {
											$chart['data']['labels'][] = $list->name;
											$chart['data']['datasets'][0]['data'][] = $list->profit;
										} else {
											$other = $other + $list->profit;
										}
										$i++;
									}
								}

								$chart['data']['labels'][] = 'Diğer';
								$chart['data']['datasets'][0]['data'][] = $other;

								$chart['options']['legend']['display'] = false;
								$chart['options']['scales']['yAxes'][0]['display'] = false;
								$chart['options']['scales']['xAxes'][0]['display'] = false;
								$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
								$chart['options']['maintainAspectRatio'] = false;
								$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
								$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) { return parseFloat(data.datasets[0].data[tooltipItems.index]).formatMoney(2, '.', ',') + ' TL'; } =TIL=";

								$args = array();
								$args['height'] 	= '130';
								$args['chart'] 		= $chart;
								?>
								<div class="panel panel-default panel-border-0">
									<div class="panel-heading"><h4 class="panel-title fs-14">Kar Dağılım Pastası</h4></div>
									<div class="panel-body">
										<div class="relative"><?php chartjs($args); ?></div>
									</div>
								</div>

					</div> <!-- /.col-* -->
				</div> <!-- /.row -->

		

	</div> <!-- /.col-* -->
</div> <!-- /.row -->


<?php get_footer(); ?>