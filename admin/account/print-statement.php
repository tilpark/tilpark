<?php require_once('../../tilpark.php'); ?>
<?php 
if(!$account = get_account($_GET['id'])) {
	add_console_log('Hesap karti bulunamadi.', 'print-address.php');
}
?>
<?php include_content_page('print', 'statement', 'account', array('account'=>@$account)); ?>


<title>Cari Ekstre | <?php echo $account->name; ?></title>

<?php 
	$print['title'] = 'Cari Ekstre';
	$print['date']	= til_get_date(date('Y-m-d H:i'), 'd F Y H:i');
	$print['barcode'] = $account->code;
?>
<?php get_header_print($print); ?>


<div class="row">
	<div class="col-xs-6">

		<div class="p-10 br-3">
			<div class="fs-14 bold"><?php echo til()->company->name; ?></div>
			<div class="fs-11"><?php echo til()->company->address; ?></div>
			<div class="fs-11"><?php echo til()->company->district; ?><?php echo til()->company->city ? '/' : ''; ?><?php echo til()->company->city; ?><?php echo til()->company->country ? ' - ' : ''; ?><?php echo til()->company->country; ?></div>
			<div class="fs-11"><?php echo get_set_show_phone(til()->company->phone); ?></div>
			<div class="fs-11"><?php echo til()->company->email; ?></div>
		</div>
	
	</div> <!-- /.col -->
	<div class="col-xs-6">

		<div class="bg-gray p-10 br-3">
			<div class="fs-14 bold"><?php echo $account->name; ?></div>
			<div class="fs-11"><?php echo $account->address; ?></div>
			<div class="fs-11"><?php echo $account->district; ?><?php echo ($account->city && $account->district) ? '/' : ''; ?><?php echo $account->city; ?><?php echo $account->country ? ' - ' : ''; ?><?php echo $account->country; ?></div>
			<div class="fs-11"><?php echo get_set_show_phone($account->gsm); ?><?php echo $account->phone ? ' - ' : ''; ?><?php echo get_set_show_phone($account->phone); ?></div>
			<div class="fs-11"><?php echo $account->tax_home ? 'V. Dairesi: '.$account->tax_home : ''; ?> <?php echo ($account->tax_home and $account->tax_no) ? ' - ': ''; ?> <?php echo $account->tax_no ? 'V. No: '.$account->tax_no : ''; ?></div>
			<?php if($account->email): ?><div class="fs-11"><?php echo $account->email; ?></div><?php endif; ?>
		</div>

	</div> <!-- /.col -->
</div> <!-- /.row -->



<?php
$args_form['where']['status'] = '1';
$args_form['where']['account_id'] = $account->id;
$args_form['where']['order_by'] = array('id'=>'ASC', 'date'=>'ASC');
if($forms = get_forms($args_form)): ?>
	<div class="h-20"></div>
	<table class="table table-hover table-bordered table-condensed table-striped">
		<thead>
			<tr>
				<th width="80">Form ID</th>
				<th width="100">Tarih</th>
				<th width="100">Form Durumu</th>
				<th>Açıklama</th>
				<th width="80">Giriş</th>
				<th width="80">Çıkış</th>
				<th width="80">Bakiye</th>
			</tr>
		</thead>
		<tbody>
		<?php $balance = 0; foreach($forms->list as $form): ?>
			<?php $form_status = get_form_status($form->status_id); ?>
			<tr>
				<td>#<?php echo $form->id; ?></td>
				<td><small class="text-muted"><?php echo substr($form->date,0,16); ?></small></td>
				<?php if($form->type == 'form'): ?>
					<td><?php echo $form_status->name; ?></td>
				<?php else: ?>
					<td></td>
				<?php endif; ?>
				<td class="text-muted fs-11">
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

<?php get_footer_print(); ?>