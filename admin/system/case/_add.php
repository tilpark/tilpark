<?php add_page_info( 'nav', array('name'=>'Kasa & Banka' ) ); ?>
<?php




/* kasa veya banka ekle */
if(isset($_POST['add'])) {

	@form_validation($_POST['name'], 'status_name', 'Kasa adı', 'required|min_length[3]|max_length[64]', 'input_control_');

	if(!is_alert('input_control_')) {
		$args['insert']['taxonomy'] 	= $_taxonomy;
		$args['insert']['name'] 		= $_POST['name'];
		$args['insert']['is_bank']			= $_POST['is_bank'];
		if($args['insert']['is_bank'] == 1) {
			$args['insert']['bank_name'] 		= $_POST['bank_name'];
			$args['insert']['bank_admin_name'] 	= $_POST['bank_admin_name'];
			$args['insert']['bank_detail'] 		= json_encode(array('branch_code'=>$_POST['branch_code'], 'account_no'=>$_POST['account_no'], 'iban'=>$_POST['iban']));
		}

		if(add_case($args)) {}
	}
}



print_alert();
?>

<div class="row">
	<div class="col-lg-6 col-md-6">
		<form name="form_status" id="form_status" action="<?php set_url_parameters(array('add'=>array('taxonomy'=>$_taxonomy) )); ?>" method="POST" class="validate">
			
			<div class="form-group">
				<label for="name">Kasa veya Banka Adı</label>
				<input type="text" name="name" id="name" class="form-control required" minlength="3" maxlength="32">
			</div> <!-- /.form-group -->



			<div class="form-group">
				<label for="status_name">Kasa mı? Banka mı?</label>
				<select name="is_bank" id="is_bank" class="form-control select">
					<option value="0">Kasa</option>
					<option value="1">Banka</option>
				</select>
			</div> <!-- /.form-group -->


			<div class="bank_detail bg-info padding-5 margin-bottom-15">
				
				<div class="form-group">
					<label for="bank_name">Banka Adı</label>
					<input type="text" name="bank_name" id="bank_name" class="form-control" minlength="3" maxlength="32">
				</div> <!-- /.form-group -->

				<div class="form-group">
					<label for="bank_admin_name">Banka Hesap Sahibi Adı</label>
					<input type="text" name="bank_admin_name" id="bank_admin_name" class="form-control" minlength="3" maxlength="32">
				</div> <!-- /.form-group -->

				<div class="row space-5">
					<div class="col-md-3">
						<div class="form-group">
							<label for="branch_code">Şube Kodu</label>
							<input type="text" name="branch_code" id="branch_code" class="form-control" minlength="3" maxlength="32">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-3 -->
					<div class="col-md-3">
						<div class="form-group">
							<label for="account_no">Hesap No</label>
							<input type="text" name="account_no" id="account_no" class="form-control" minlength="3" maxlength="32">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-3 -->
					<div class="col-md-6">
						<div class="form-group">
							<label for="iban">Iban</label>
							<input type="text" name="iban" id="iban" class="form-control" minlength="3" maxlength="32">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-3 -->
				</div> <!-- /.row -->
			</div> <!-- /.bank_detail -->

			<script>
			$(document).ready(function() {
				$('.bank_detail').hide();
				$('#is_bank').change(function() {
					if($(this).val() == 1) {
						$('.bank_detail').show();
					} else {
						$('.bank_detail').hide();
					}
				});
			});
			</script>






		



			<div class="text-right">
				<input type="hidden" name="add">
				<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
				<button class="btn btn-default">Kaydet</button>
			</div>
		</form>
	</div> <!-- /.col-lg-6 -->
	<div class="col-lg-6 col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Kasalar</h3></div>
			<div class="panel-body">
				<?php $cases = get_case_all(array('is_bank'=>0) ); ?>
				<?php if($cases): ?>
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Kasa Adı</th>
								<th>Tutar</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($cases as $case):  $case->total = calc_case($case->id); ?>
							<tr>
								<td><a href="?detail&status_id=<?php echo $case->id; ?>"><span><?php echo $case->name; ?></span></a> <?php if($case->is_default == 'default'): ?><small class="text-muted">(varsayılan)</small><?php endif; ?></td>
								<td class="text-right"><?php set_money($case->total, true); ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<?php echo get_alert('Kasa bulunamadı.', 'warning', false); ?>
				<?php endif; ?>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->


		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Bankalar</h3></div>
			<div class="panel-body">
				<?php $banks = get_case_all(array('is_bank'=>1) ); ?>
				<?php if($banks): ?>
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Banka Adı</th>
								<th>Tutar</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($banks as $bank): $bank->total = calc_case($bank->id); ?>
							<tr>
								<td><a href="?detail&status_id=<?php echo $bank->id; ?>"><span><?php echo $bank->name; ?></span></a> <?php if($bank->is_default == 'default'): ?><small class="text-muted">(varsayılan)</small><?php endif; ?></td>
								<td class="text-right"><?php set_money($bank->total, true); ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<?php echo get_alert('Banka bulunamadı.', 'warning', false); ?>
				<?php endif; ?>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-lg-4 -->
</div> <!-- /.row -->

