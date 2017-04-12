<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Form Yönetimi' );
add_page_info( 'nav', array('name'=>'Form Yönetimi') );
?>



<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<div class="row space-5">
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/form/detail.php?out'); ?>">
						<span class="icon-box"><i class="fa fa-cart-plus"></i></span>
						<h3>Yeni Satış Formu</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/form/detail.php?in'); ?>">
						<span class="icon-box"><i class="fa fa-cart-arrow-down"></i></span>
						<h3>Yeni Alış Formu</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/form/list.php'); ?>">
						<span class="icon-box"><i class="fa fa-list"></i></span>
						<h3>Tüm Formlar</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<div class="h-20 visible-xs"></div>

	</div> <!-- /.col-md-6 -->
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<div class="row space-5">
			<div class="col-md-6">
				<small class="text-muted"><i class="fa fa-long-arrow-down text-black"></i> GİRİŞ FORM DURUMLARI</small>
				<div class="h-10"></div>
				<?php if($form_status_all = get_form_status_all('1')): ?>
					<div class="list-group mobile-full list-group-dashboard">
						<?php foreach($form_status_all as $status): ?>
							<a href="<?php site_url(); ?>/admin/form/list.php?status_id=<?php echo $status->id; ?>" class="list-group-item" style="border-left:1px solid <?php echo $status->bg_color; ?>;">
								<?php echo $status->name; ?>
								<span class="pull-right"><?php echo $status->count = calc_form_status($status->id); ?></span>
							</a>
						<?php endforeach; ?>
					</div>

				<?php endif; ?>
			</div>
			<div class="col-md-6">
				<div class="h-20 visible-xs"></div>
				<small class="text-muted"><i class="fa fa-long-arrow-up text-black"></i> ÇIKIŞ FORM DURUMLARI</small>
				<div class="h-10"></div>
				<?php if($form_status_all = get_form_status_all('0')): ?>
					<div class="list-group mobile-full list-group-dashboard">
						<?php foreach($form_status_all as $status): ?>
							<a href="<?php site_url(); ?>/admin/form/list.php?status_id=<?php echo $status->id; ?>" class="list-group-item" style="border-left:1px solid <?php echo $status->bg_color; ?>;">
								<?php echo $status->name; ?>
								<span class="pull-right"><?php echo $status->count = calc_form_status($status->id); ?></span>
							</a>
						<?php endforeach; ?>
					</div>

				<?php endif; ?>
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

	</div> <!-- /.col -->
</div> <!-- /.row -->




<div class="h-20"></div>

<div class="row">
	<div class="col-md-6">

		<div class="h-20 visible-xs"></div>
		<small class="text-muted module-title-small"><i class="fa fa-cart-plus"></i> EN SON ÇIKIŞ FORMLARI</small>
		<div class="h-10"></div>
		
		<div class="panel panel-warning panel-table panel-heading-0 panel-border-right panel-dashboard-list">
			<div class="panel-body">
				<div class="panel-list">
					<?php $query = db()->query("SELECT * FROM ".dbname('forms')." WHERE status='1' AND type='form' AND in_out='1' ORDER BY date DESC LIMIT 50 "); ?>
					<?php if($query->num_rows): ?>
						<table class="table table-hover table-condensed table-stripe">
							<thead>
								<tr>
									<th width="80">Tarih</th>
									<th>Form ID</th>
									<th>Hesap Kartı</th>
									<th class="text-right">Toplam</th>
								</tr>
							</thead>
							<tbody>
								<?php while($list = $query->fetch_object()): ?>
									<tr onclick="location.href='<?php site_url('form', $list->id); ?>';" class="pointer">
										<td class="text-muted"><?php echo til_get_date($list->date, 'd F'); ?></td>
										<td><a href="<?php site_url('form', $list->id); ?>" title="">#<?php echo $list->id; ?></a></td>
										<td><a href="<?php site_url('account', $list->account_id); ?>" title="<?php echo $list->account_name; ?>"><?php echo til_get_substr($list->account_name,0,30); ?></a></td>
										<td class="text-right"><?php echo get_set_money($list->total); ?> <small class="text-muted">TL</small></td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div> <!-- /.panel-list -->
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col -->
	<div class="col-md-6">

		<div class="h-20 visible-xs"></div>
		<small class="text-muted module-title-small"><i class="fa fa-cart-arrow-down"></i> EN SON GİRİŞ FORMLARI</small>
		<div class="h-10"></div>
		
		<div class="panel panel-warning panel-table panel-heading-0 panel-border-right panel-dashboard-list">
			<div class="panel-body">
				<div class="panel-list">
					<?php $query = db()->query("SELECT * FROM ".dbname('forms')." WHERE status='1' AND type='form' AND in_out='0' ORDER BY date DESC LIMIT 50 "); ?>
					<?php if($query->num_rows): ?>
						<table class="table table-hover table-condensed table-stripe">
							<thead>
								<tr>
									<th width="80">Tarih</th>
									<th>Form ID</th>
									<th>Hesap Kartı</th>
									<th class="text-right">Toplam</th>
								</tr>
							</thead>
							<tbody>
								<?php while($list = $query->fetch_object()): ?>
									<tr onclick="location.href='<?php site_url('form', $list->id); ?>';" class="pointer">
										<td class="text-muted"><?php echo til_get_date($list->date, 'd F'); ?></td>
										<td><a href="<?php site_url('form', $list->id); ?>" title="">#<?php echo $list->id; ?></a></td>
										<td><a href="<?php site_url('account', $list->account_id); ?>" title="<?php echo $list->account_name; ?>"><?php echo til_get_substr($list->account_name,0,30); ?></a></td>
										<td class="text-right"><?php echo get_set_money($list->total); ?> <small class="text-muted">TL</small></td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div> <!-- /.panel-list -->
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col -->
</div> <!-- /.row -->








<?php get_footer(); ?>