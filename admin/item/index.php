<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Ürün Yönetimi' );
add_page_info( 'nav', array('name'=>'Ürün Yönetimi') );
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

		<div class="row space-5">
							<div class="col-md-6">
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
								$chart['options']['tooltips']['enabled'] = true;
								$chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
								$chart['options']['tooltips']['callbacks']['label'] =  "=TIL= function(tooltipItems, data) { return ''; } =TIL=";

								$args['height'] 	= '200';
								$args['chart'] 		= $chart;
								?>
								<?php chartjs($args); ?>
							</div> <!-- /.col-* -->
							<div class="col-md-6">
								<div class="">
									<small class="text-muted" style="color:#1f1d1d;"><?php echo $total['item']['i']; ?></small> <small class="text-muted">farklı çeşit</small>
									<br />
									<span class="ff-2 fs-18 bold"><?php echo $total['item']['quantity']; ?></span> <small class="text-muted">adet</small>
									<div clas="h-20"></div>
									
								</div>
								<div class="h-20"></div>

								<div class="row">
									<div class="col-md-6">
										<div class="">
											<small class="text-muted">maliyet değeri</small>
											<br />
											<span class="ff-2 fs-16 bold"><?php echo get_set_money($total['item']['purc']); ?></span> <small class="text-muted">TL</small>
										</div>
									</div> <!-- /.col-md-6 -->
									<div class="col-md-6">
										<div class="">
											<small class="text-muted">satış değeri</small>
											<br />
											<span class="ff-2 fs-16 bold"><?php echo get_set_money($total['item']['sale']); ?></span> <small class="text-muted">TL</small>
										</div>
									</div> <!-- /.col-md-6 -->
								</div> <!-- /.row -->

							</div> <!-- /.col-md-6 -->
							
						</div> <!-- /.row -->





		<div class="h-20"></div>

		


		


	</div> <!-- /.col-* -->
</div> <!-- /.row -->

<div class="h-20"></div>


<div class="row">
	<div class="col-md-4">

		<small class="text-muted module-title-small"><i class="fa fa-trophy"></i> EN ÇOK KAZANDIRAN ÜRÜNLER</small>
		<div class="h-10"></div>
		<div class="panel panel-success panel-heading-0 panel-border-right panel-table">	
			<div class="panel-body" style="height:280px; overflow: auto;">	
				<?php $query = db()->query("SELECT * FROM ".dbname('items')." WHERE status='1' AND profit > 0 ORDER BY profit DESC LIMIT 50"); ?>
				<?php if($query->num_rows): ?>
					
					<table class="table table-hover table-condensed">
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
		</div> <!-- /.panel -->

	</div> <!-- /.col-* -->
	<div class="col-md-8">

		<small class="text-muted module-title-small"><i class="fa fa-th-list text-blackk"></i> <?php echo til_get_strtoupper('Son işlem gören hareketler'); ?></small>
		<div class="h-10"></div>

		<div class="panel panel-warning panel-heading-0 panel-border-right panel-table">
			<div class="panel-body" style="height:280px; overflow: auto;">
				<?php $query = db()->query("SELECT * FROM ".dbname('form_items')." WHERE status='1' AND type='item' AND item_id > 0 ORDER BY date DESC LIMIT 50"); ?>
					<?php if($query->num_rows): ?>
					
						<table class="table table-hover table-condensed table-striped">
							<tbody>
								<?php while($list = $query->fetch_object()): ?>
									<?php $item = get_item($list->item_id); ?>
									<tr onclick="location.href='<?php site_url('form', $list->form_id); ?>';" class="pointer">
										<td width="80"><a href="<?php site_url('form', $list->form_id); ?>" class="text-muted">#<?php echo $list->form_id; ?></a></td>
										<td><a href="<?php site_url('admin/item/detail.php?id='.$item->id); ?>" title="<?php echo $item->name; ?>"><?php echo til_get_substr($item->name, 0, 40); ?></a></td>
										<?php if($list->in_out == '1'): ?>
											<td class="text-muted">Çıkış</td>
										<?php else: ?> 
											<td class="text-muted">Giriş</td>
										<?php endif; ?>
										<td class="text-center"><?php echo $list->quantity; ?></td>
										<td class="text-right" width="100"><?php echo get_set_money($list->price); ?> <i class="fa fa-try text-muted"></i></td>
										<td class="text-right" width="100"><?php echo get_set_money($list->total); ?> <i class="fa fa-try text-muted"></i></td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>

				<?php endif; ?>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-* -->
	
</div> <!-- /.row -->



<?php get_footer(); ?>