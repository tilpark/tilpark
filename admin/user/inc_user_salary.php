


<?php
if(isset($_POST['update_staff_salary'])) {
	update_user_meta($user->id, 'date_start_work', $_POST['date_start_work']);
	update_user_meta($user->id, 'date_end_work', $_POST['date_end_work']);
	update_user_meta($user->id, 'net_salary', get_set_decimal_db($_POST['net_salary']));
}
$user_meta = get_user_meta($user->id);



if(isset($_POST['add_payment'])) {

}



set_staff_salary($user->id);


?>


<div class="row">
	<div class="col-md-6">

		<form name="form_staff_salary" id="form_staff_salary" action="" method="POST">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="date_start_work">İşe Başlama Tarihi</label>
						<input type="text" name="date_start_work" id="date_start_work" class="form-control date" value="<?php echo @$user_meta['date_start_work']; ?>" readonly="">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-* -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="date_end_work">İşten Ayrılma Tarihi</label>
						<input type="text" name="date_end_work" id="date_end_work" class="form-control date" value="<?php echo @$user_meta['date_end_work']; ?>" readonly="">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-* -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="net_salary">Net Maaş <small class="text-muted">(Aylık)</small></label>
						<input type="text" name="net_salary" id="net_salary" class="form-control money" value="<?php echo @$user_meta['net_salary']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-* -->
				<div class="col-md-3"> 
					<br />
					<input type="hidden" name="update_staff_salary">
					<button class="btn btn-default"><i class="fa fa-save"></i></button>
				</div> <!-- /.col-md-1 -->
			</div> <!-- /.row -->
		</form>

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading"><h4 class="panel-title">Ödeme & Avans</h4></div>
			<div class="panel-body">
				<form name="form_pay" id="form_pay" action="" method="POST">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="payment_date">Ödeme Tarihi</label>
								<input type="text" name="payment_date" id="payment_date" class="form-control date" value="<?php echo til_get_date(true, 'date'); ?>" readonly="">
							</div> <!-- /.form-group -->
						</div> <!-- /.col-md-* -->
						<div class="col-md-3">
							<div class="form-group">
								<label for="payment">Ödeme <small class="text-muted">(Aylık)</small></label>
								<input type="text" name="payment" id="payment" class="form-control money" value="">
							</div> <!-- /.form-group -->
						</div> <!-- /.col-md-* -->
						<div class="col-md-1"> 
							<br />
							<input type="hidden" name="add_payment">
							<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
							<button class="btn btn-default"><i class="fa fa-save"></i></button>
						</div> <!-- /.col-md-1 -->
					</div> <!-- /.row -->
				</form>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->


<div class="panel panel-default panel-table">
	<div class="panel-heading"><h3 class="panel-title">Aylık Maaşlar</h3></div>
	<div class="panel-body">
	<?php
	$monthlys = false;
	if($q_select = db()->query("SELECT * FROM ".dbname('forms')." WHERE type='salary' AND account_id='".$user->account_id."' ORDER BY date DESC ")) {
		if($q_select->num_rows) {
			$monthlys = _return_helper('plural_object', $q_select);
		}
	}
	?>

	<?php if($monthlys): ?>
		<table class="table table-bordered table-condensed dataTable">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th>Tarih</th>
					<th>Net Maaş</th>
					<th>Kesintiler</th>
					<th>Hakediş</th>
					<th>Ödenen</th>
					<th>Kalan</th>
				</tr>
			</thead>
			<?php foreach($monthlys as $monthly): ?>
				<tr>
					<td><a href="salary.php?id=<?php echo $monthly->id; ?>" target="_blank">#<?php echo $monthly->id; ?></a></td>
					<td><?php echo til_get_date($monthly->date, 'str: F Y'); ?></td>
					<td class="text-right"><?php echo get_set_money($monthly->val_1, true); ?></td>
					<td class="text-right"><?php echo get_set_money($monthly->profit, true); ?></td>
					<td class="text-right"><?php echo get_set_money($monthly->total, true); ?></td>
					<td class="text-right"><?php echo get_set_money($monthly->payment, true); ?></td>
					<td class="text-right"><?php echo get_set_money($monthly->val_decimal, true); ?></td>
				</tr>
			<?php endforeach; ?>
		</table> <!-- /.table -->
	<?php endif; ?>
	</div> <!-- /.panel-body -->
</div> <!-- /.panel -->

