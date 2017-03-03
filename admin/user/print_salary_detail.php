<?php include('../../tilpark.php'); ?>

<link href="<?php echo template_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/app.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">

<?php

// aktif olan kullanıcın tüm bilgilerini cekelim
if(!$user = get_user($_GET['id'])) { add_console_log('Kullanıcı hesabı bulunamadı.', __FUNCTION__); return false; }
@$user_meta = get_user_meta($user->id);
set_staff_salary($user->id);
if(!$account = get_account($user->account_id)) { add_console_log('Kullanıcıya ait hesap karti bulunamadı.', __FUNCTION__); }

?>


<title>Detaylı Maaş Ekstresi | <?php echo $user->display_name; ?></title>

<div class="print-page" size="A4">


	<div class="row">
		<div class="col-md-6">	
			<h4>Detaylı Maaş Ekstresi</h4>
		</div> <!-- /.col-md-6 -->
		<div class="col-md-6">

			<div class="text-right"><small class="text-muted"><?php echo til_get_date(true, 'datetime'); ?></small></div>

		</div> <!-- /.col-md-6 -->
	</div> <!-- /.row -->
	<div class="h-20"></div>

	<div class="print-tilpark-logo">
		<img src="<?php site_url('content/themes/default/img/logo_blank.png'); ?>" class="img-responsive">
	</div>

	<div class="row">
		<div class="col-xs-12">

			<div class="pull-right">
				<img src="<?php barcode_url('TILU-'.$user->id); ?>" />
				<br />
				<span class="pull-right mr-15"><?php echo 'TILU-'.$user->id; ?></span>
			</div>

			
			<img src="<?php echo $user->avatar; ?>" class="pull-left mr-5 br-3 img-32">
			<div>
				<h4 class="content-title"><?php echo $user->name; ?> <?php echo $user->surname; ?></h4>
				<small class="text-muted"> <?php echo @$user->gsm; ?> | <?php echo $user->username; ?></small>
			</div>
			<div class="h-20"></div>

			<?php
			$monthlys = false;
			if($q_select = db()->query("SELECT * FROM ".dbname('forms')." WHERE status='1' AND type IN ('salary', 'payment') AND account_id='".$user->account_id."' ORDER BY date ASC, val_1 ASC ")) {
				if($q_select->num_rows) {
					$monthlys = _return_helper('plural_object', $q_select);
				}
			}
			?>

			<?php if($monthlys): ?>
				<table class="table table-bordered table-condensed table-hover" style="font-size:12px;">
					<thead>
						<tr>
							<th width="50">ID</th>
							<th>Tarih</th>
							<th>Açıklama</th>
							<th>Sayı</th>
							<th>B. Fiyatı</th>
							<th>Toplam</th>
							<th>Hakediş</th>
							<th>Ödenen</th>
						</tr>
					</thead>
					<?php foreach($monthlys as $monthly): ?>
						<?php $q_form_items = db()->query("SELECT * FROM ".dbname('form_items')." WHERE status='1' AND form_id='".$monthly->id."' ORDER BY val_date ASC, id ASC"); ?>
						<?php if($q_form_items->num_rows): ?>
							<?php while($item = $q_form_items->fetch_object()): ?>
								<tr>
									<td></td>
									<td>
										<small class="text-muted">
											<?php if($item->item_name == 'monthly_day'): ?>
												<?php echo $item->val_2; ?> / <?php echo $item->val_3; ?>
											<?php elseif($item->item_name == 'overtime'): ?>
												<?php echo til_get_date($item->val_date,'date'); ?>
											<?php elseif($item->item_name == 'not_overtime'): ?>
												<?php echo til_get_date($item->val_date,'date'); ?>
											<?php elseif($item->item_name == 'did_not_come'): ?>
												<small class="text-muted"><?php echo $item->val_1; ?> / <?php echo $item->val_2; ?></small>
											<?php elseif($item->item_name == 'to_let'): ?>
												<small class="text-muted"><?php echo $item->val_1; ?> / <?php echo $item->val_2; ?></small>
											<?php endif; ?>
										</small>
									</td>
									<td>
										<small class="text-muted">
											<?php if($item->item_name == 'monthly_day'): ?>
												günlük yevmiye
											<?php elseif($item->item_name == 'overtime'): ?>
												Fazla mesai, +<?php echo $item->quantity; ?> saat
												<?php echo $item->val_3; ?>
											<?php elseif($item->item_name == 'not_overtime'): ?>
												Eksik mesai, -<?php echo $item->quantity; ?> saat
												<?php echo $item->val_3; ?>
											<?php elseif($item->item_name == 'did_not_come'): ?>
												Gelmedi, <?php echo $item->val_1; ?> / <?php echo $item->val_2; ?>
												<?php echo $item->val_3; ?>
											<?php elseif($item->item_name == 'to_let'): ?>
												İzin, <?php echo $item->val_1; ?> / <?php echo $item->val_2; ?>
												<?php echo $item->val_3; ?>
											<?php endif; ?>
										</small>
									</td>
									<td class="text-center">
										<small class="text-muted">
											<?php echo $item->quantity; ?>
											<?php if($item->item_name == 'monthly_day' OR $item->item_name == 'did_not_come' OR $item->item_name == 'to_let') { echo ' gün'; } else { echo ' saat'; } ?>
										</small>
									</td>
									<td class="text-right"><small class="text-muted"><?php echo get_set_money($item->price, true); ?></small></td>
									<td class="text-right"><small class="text-muted"><?php echo get_set_money($item->total, true); ?></small></td>
									<td></td>
									<td></td>
								</tr> 
							<?php endwhile; ?>
						<?php endif; ?>

						<tr>
							<td class="text-muted">#<?php echo $monthly->id; ?></td>
							<td class="fs-11"><?php echo til_get_date($monthly->date, 'datetime'); ?></td>
							<td>
								<?php if($monthly->type == 'payment'): ?>
									Ödeme
								<?php else: ?>
									<?php echo til_get_date($monthly->date, 'str: F Y'); ?> dönem hakediş
								<?php endif; ?>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td class="text-right"><?php if($monthly->type != 'payment'): ?><?php echo get_set_money($monthly->total, true); ?><?php endif; ?></td>
							<td class="text-right"><?php if($monthly->type == 'payment'): ?><?php echo get_set_money($monthly->total, true); ?><?php endif; ?></td>
						</tr>
						

					<?php endforeach; ?>
					<tfoot>
						<tr>
							<td colspan="8" class="text-right"><?php echo get_set_money($account->balance, true); ?></td>
						</tr>
					</tfoot>
				</table> <!-- /.table -->
			<?php endif; ?>





		</div> <!-- /.col-md-8 -->
	</div> <!-- /.row -->



	<div class="print-footer print-footer-right text-center">
		<small class="text-muted">Bu belge <?php echo get_active_user('display_name'); ?> tarafından, <?php echo til_get_date(true, 'datetime'); ?> tarihinde oluşturuldu.</small>
		<br /> 
	</div>


	<div class="print-footer print-footer-left">
		<small class="text-muted"><img src="<?php site_url('content/themes/default/img/logo_header.png'); ?>" class="img-responsive pull-left" width="64"> açık kaynak yazılımlar.</small>
	</div>



</div> <!-- /.print-page -->


