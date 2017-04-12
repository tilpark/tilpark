<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Ürün' );
add_page_info( 'nav', array('name'=>'Ürün') );
?>



<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<div class="row space-5">
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/item/add.php'); ?>">
						<span class="icon-box"><i class="fa fa-plus-square-o"></i></span>
						<h3>Yeni</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/item/list.php'); ?>">
						<span class="icon-box"><i class="fa fa-list"></i></span>
						<h3>Ürün Kartları</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<div class="h-20 visible-xs"></div>

	</div> <!-- /.col-md-6 -->
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<?php
		$chart = array();
		$chart['type'] = 'doughnut';
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
					$chart['data']['datasets'][0]['data'][] = $list->p_purc * $list->quantity;
					$i++;
				} else {
					$_other = $list->p_purc * $list->quantity;
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
		$chart['options']['tooltips']['enabled'] = true;
		$chart['options']['tooltips']['titleFontSize'] = 11;
		$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
		$chart['options']['tooltips']['callbacks']['label'] =  "=TIL= function(tooltipItems, data) { return ''; } =TIL=";

		$args['height'] 	= '120';
		$args['chart'] 		= $chart;

		$args2 = $args;
		?>

		<small class="text-muted"><i class="fa fa-bar-chart"></i> GENEL STOK DURUMU</small>
		<div class="h-10"></div>

		<div class="row space-none">
			<div class="col-md-4">

				<div class="well text-center">
					<small class="text-muted block"><?php echo $total['item']['i']; ?> çeşit ve toplamda</small>
					<span class="ff-2 fs-18 bold <?php echo $total['item']['quantity'] > 0 ? 'text-success' : 'text-danger'; ?>"><?php echo $total['item']['quantity']; ?></span>
				</div>
				
			</div> <!-- /.col-md-4 -->
			<div class="col-xs-6 col-md-4">
				<div class="">
					<span class="ff-2 fs-17 bold"><?php echo get_set_money($total['item']['purc']); ?></span> <small class="text-muted">TL</small>
					<br>
					<small class="text-muted">maliyet fiyatı</small>
				</div>
			</div> <!-- /.col-* -->
			<div class="col-xs-6 col-md-4">
				<div class="">
					<span class="ff-2 fs-15 bold"><?php echo get_set_money($total['item']['sale']); ?></span> <small class="text-muted">TL</small>
					<br>
					<small class="text-muted">satış fiyatı</small>
				</div>
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->	





		<div class="row">
			<div class="col-md-12">
				<?php 
					$chart = array();
					$chart['type'] = 'bar';
					$chart['data']['datasets'][0]['label'] 	= 'Hareketler';
					$chart['data']['datasets'][0]['fill'] 	= true;
					$chart['data']['datasets'][0]['lineTension'] 	= 0.1;
					$chart['data']['datasets'][0]['borderWidth'] 	= 1;
					$chart['data']['datasets'][0]['pointBorderWidth'] 	= 3;
					$chart['data']['datasets'][0]['pointRadius'] 	= 1;
					$chart['data']['datasets'][0]['backgroundColor'] 	= 'rgba(253, 196, 48, 0.2)';
					$chart['data']['datasets'][0]['borderColor'] 		= 'rgba(253, 196, 48, 1)';


					$_start_date = date('Y-m-d', strtotime('-4 week', strtotime(date('Y-m-d'))) );
					$_end_date = date('Y-m-d');
					while(strtotime($_start_date) <= strtotime($_end_date) ) {
						$chart['data']['labels'][] = $_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));

						$quantity = 0;
						$item_quantity = $total['item']['quantity'];
						$q_forms = db()->query("SELECT sum(quantity) as quantity FROM ".dbname('form_items')." WHERE status='1' AND in_out='0' AND item_id > 0 AND date >= '".$_start_date." 00:00:00' ORDER BY date DESC");
						if(($quantity = $q_forms->fetch_object()->quantity) > 0) {
							// $chartt['data']['datasets'][0]['data'][] = $total;
						} else {
							// $chartt['data']['datasets'][0]['data'][] = '0.00';
						}
						$item_quantity = $item_quantity - $quantity;

						$quantity = 0;
						$q_forms = db()->query("SELECT sum(quantity) as quantity FROM ".dbname('form_items')." WHERE status='1' AND in_out='1' AND item_id > 0 AND date >= '".$_start_date." 00:00:00' ORDER BY date DESC");
						if(($quantity = $q_forms->fetch_object()->quantity) > 0) {
							// $chartt['data']['datasets'][1]['data'][] = $total;
						} else {
							// $chartt['data']['datasets'][1]['data'][] = '0.00';
						}
						$item_quantity = $item_quantity + $quantity;
						$chart['data']['datasets'][0]['data'][] = $item_quantity;


		
					}

					$chart['options']['legend']['display'] = false;
					$chart['options']['scales']['yAxes'][0]['display'] = false;
					$chart['options']['scales']['xAxes'][0]['display'] = false;
					$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
					$chart['options']['maintainAspectRatio'] = false;
					$chart['options']['tooltips']['enabled'] = true;
					$chart['options']['tooltips']['titleFontSize'] = 9;
					$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return ''; } =TIL=";
					$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) {  return  data.labels[tooltipItems.index]+':      '+ tooltipItems.yLabel; } =TIL=";
					

					$args['height'] 	= '50';
					$args['chart'] 		= $chart;
					?>

					<?php chartjs($args); ?>
			</div> <!-- /.col-md-12 -->
		</div> <!-- /.fow -->

		<div class="h-20"></div>
		<div class="h-20"></div>		


	</div> <!-- /.col-* -->
</div> <!-- /.row -->

<div class="h-20"></div>


<div class="row">
	<div class="col-md-4">

		<small class="text-muted module-title-small"><i class="fa fa-trophy"></i> EN ÇOK KAZANDIRAN ÜRÜNLER</small>
		<div class="h-10"></div>

		<div class="panel panel-info panel-heading-0 panel-border-right panel-table panel-dashboard-list">	
			<div class="panel-body">
				<div class="panel-list">
					<?php $query = db()->query("SELECT * FROM ".dbname('items')." WHERE status='1' AND profit > 0 ORDER BY profit DESC LIMIT 50"); ?>
					<?php if($query->num_rows): ?>
						
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>Ürün Adı</th>
									<th class="text-right">Kar/Zarar</th>
								</tr>
							</thead>
							<tbody>
								<?php while($list = $query->fetch_object()): ?>
									<tr onclick="location.href='<?php site_url('admin/item/detail.php?id='.$list->id); ?>';" class="pointer">
										<td><a href="<?php site_url('admin/item/detail.php?id='.$list->id); ?>"><?php echo til_get_substr($list->name, 0, 26); ?></a></td>
										<td class="text-right"><?php echo get_set_money($list->profit); ?> <small class="text-muted">TL</small></td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>

					<?php endif; ?>
				</div> <!-- /.panel-body -->
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-* -->
	<div class="col-md-4">

		<small class="text-muted module-title-small"><i class="fa fa-th-list"></i> SON EKLENEN ÜRÜN KARTLARI</small>
		<div class="h-10"></div>
		
		<div class="panel panel-warning panel-heading-0 panel-border-right panel-table panel-dashboard-list">	
			<div class="panel-body">
				<div class="panel-list">
					<?php $query = db()->query("SELECT * FROM ".dbname('items')." WHERE status='1' ORDER BY date DESC LIMIT 50"); ?>
					<?php if($query->num_rows): ?>
						
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>Ürün Adı</th>
									<th class="text-center">Adet</th>
								</tr>
							</thead>
							<tbody>
								<?php while($list = $query->fetch_object()): ?>
									<tr onclick="location.href='<?php site_url('admin/item/detail.php?id='.$list->id); ?>';" class="pointer">
										<td><a href="<?php site_url('admin/item/detail.php?id='.$list->id); ?>"><?php echo til_get_substr($list->name, 0, 26); ?></a></td>
										<td class="text-center"><?php echo ($list->quantity); ?></td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>

					<?php endif; ?>
				</div> <!-- /.panel-body -->
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-* -->
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

		$other = 0;
		$query = db()->query("SELECT * FROM ".dbname('items')." WHERE status='1' AND type='product' AND profit > 0 ORDER BY profit DESC");
		if($query->num_rows) {
			$i = 0;
			while($list = $query->fetch_object()) {
				if($i < 7) {
					$chart['data']['labels'][] = til_get_substr($list->name,0,10);
					$chart['data']['datasets'][0]['data'][] = $list->profit;
				} else {
					$other = $other + $list->profit;
				}
				$i++;
			}
		}

		$chart['data']['labels'][] = 'DİĞER';
		$chart['data']['datasets'][0]['data'][] = $other;

		$chart['options']['legend']['display'] = true;
		$chart['options']['scales']['yAxes'][0]['display'] = true;
		$chart['options']['scales']['xAxes'][0]['display'] = false;
		$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
		$chart['options']['maintainAspectRatio'] = false;
		$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
		$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) { return parseFloat(data.datasets[0].data[tooltipItems.index]).formatMoney(2, '.', ',') + ' TL'; } =TIL=";

		$args = array();
		$args['height'] 	= '280';
		$args['chart'] 		= $chart;
		?>

		<div class="h-20 visible-xs"></div>
		<small class="text-muted module-title-small"><i class="fa fa-pie-chart"></i> KAR DAĞILIM PASTASI</small>
		<div class="h-10"></div>
			
		<div class="relative"><?php chartjs($args); ?></div>

	</div> <!-- /.col-* -->

</div> <!-- /.row -->

<div class="h-20"></div>

<div class="row">
	<div class="col-md-8">

		<div class="h-20 visible-xs"></div>
		<small class="text-muted module-title-small"><i class="fa fa-th-list"></i> SON İŞLEM GÖREN HAREKETLER</small>
		<div class="h-10"></div>

		<div class="panel panel-warning panel-heading-0 panel-border-right panel-table panel-dashboard-list">
			<div class="panel-body">
				<div class="panel-list">
					<?php $query = db()->query("SELECT * FROM ".dbname('form_items')." WHERE status='1' AND type='item' AND item_id > 0 ORDER BY date DESC LIMIT 50"); ?>
					<?php if($query->num_rows): ?>
					
						<table class="table table-hover table-condensed table-stripedd">
							<thead>
								<tr>
									<th>Tarih</th>
									<th>Form ID</th>
									<th>Hesap Kartı</th>
									<th>G/Ç</th>
									<th class="text-center">Adet</th>
									<th class="text-right hidden-xs">B.Fiyatı</th>
									<th class="text-right hidden-xs">Toplam</th>
								</tr>
							</thead>
							<tbody>
								<?php while($list = $query->fetch_object()): ?>
									<?php $item = get_item($list->item_id); ?>
									<tr class="">
										<td class="text-muted">
											<?php 
												echo til_get_date($list->date, 'd F'); 
											?>
										</td>
										<td width="80"><a href="<?php site_url('form', $list->form_id); ?>&flashItemID=<?php echo $list->item_id; ?>">#<?php echo $list->form_id; ?></a></td>
										<td><a href="<?php site_url('admin/item/detail.php?id='.$item->id); ?>" title="<?php echo $item->name; ?>"><?php echo !til_is_mobile() ? til_get_substr($item->name, 0, 40) : til_get_substr($item->name, 0, 16); ?></a></td>
										<?php if($list->in_out == '1'): ?>
											<td class="text-muted">Çıkış</td>
										<?php else: ?> 
											<td class="text-muted">Giriş</td>
										<?php endif; ?>
										<td class="text-center"><?php echo $list->quantity; ?></td>
										<td class="text-right hidden-xs" width="100"><?php echo get_set_money($list->price); ?> <i class="fa fa-try text-muted"></i></td>
										<td class="text-right hidden-xs" width="100"><?php echo get_set_money($list->total); ?> <i class="fa fa-try text-muted"></i></td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>

					<?php endif; ?>
				</div> <!-- /.panel-list -->
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-* -->
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

		$other = 0;
		$query = db()->query("SELECT * FROM ".dbname('items')." WHERE status='1' AND type='product' AND quantity > 0 ORDER BY quantity DESC");
		if($query->num_rows) {
			$i = 0;
			while($list = $query->fetch_object()) {
				if($i < 7) {
					$chart['data']['labels'][] = til_get_substr($list->name,0,10);
					$chart['data']['datasets'][0]['data'][] = $list->quantity;
				} else {
					$other = $other + $list->quantity;
				}
				$i++;
			}
		}

		$chart['data']['labels'][] = 'DİĞER';
		$chart['data']['datasets'][0]['data'][] = $other;

		$chart['options']['legend']['display'] = true;
		$chart['options']['scales']['yAxes'][0]['display'] = true;
		$chart['options']['scales']['xAxes'][0]['display'] = false;
		$chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
		$chart['options']['maintainAspectRatio'] = false;
		$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
		$chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) { return parseFloat(data.datasets[0].data[tooltipItems.index]) + ' ADET'; } =TIL=";

		$args = array();
		$args['height'] 	= '280';
		$args['chart'] 		= $chart;
		?>

		<div class="h-20 visible-xs"></div>
		<small class="text-muted module-title-small"><i class="fa fa-pie-chart"></i> STOK ADET DAĞILIM PASTASI</small>
		<div class="h-10"></div>
			
		<div class="relative"><?php chartjs($args); ?></div>

	</div> <!-- /.col-* -->
	
</div> <!-- /.row -->



<?php get_footer(); ?>