<?php add_page_info( 'nav', array('name'=>$_name.' Durumları' ) ); ?>
<?php

if(isset($_GET['delete_status_id'])) {
	if($delete_status = get_form_status(array('id'=>$_GET['delete_status_id'], 'taxonomy'=>$_taxonomy) )) {
		$change_status_id = 0;
		if(isset($_GET['change_status_id'])) {
			if($change_status = get_form_status(array('id'=>$_GET['change_status_id'], 'in_out'=>$delete_status->in_out, 'taxonomy'=>$_taxonomy) ) and $delete_status) {
			}
		}
		
		if($change_status_id > 0) {
			if($delete_status->in_out == $change_status->in_out) {
				delete_form_status($delete_status->id, $change_status->id);
			}
		} else {
			delete_form_status($delete_status->id, '0');
		}
		
	}
}

if(isset($_POST['add'])) {

	@form_validation($_POST['status_name'], 'status_name', 'Durum adı', 'required|min_length[3]|max_length[64]', 'input_control_');
	if($_color) { @form_validation($_POST['status_color'], 'status_color', 'Renk kodu', 'required|min_length[3]|max_length[64]', 'input_control_'); }

	if(!is_alert('input_control_')) {
		$args['insert']['taxonomy'] 	= $_taxonomy;
		$args['insert']['name'] 		= $_POST['status_name'];
		if($_color) { $args['insert']['color'] 		= $_POST['status_color']; }
		if($_bg_color) { $args['insert']['bg_color'] 	= $_POST['status_bg_color']; }
		if($_sms_template) { $args['insert']['sms_template']	= $_POST['sms_template']; }
		if($_email_template) { $args['insert']['email_template']	= $_POST['email_template']; }
		$args['insert']['in_out']			= $_POST['val_enum'];

		if(empty($args['insert']['sms_template'])) {
			$args['insert']['sms_template'] = "[form_id] no'lu siparişinizin durumu [form_status] olarak değiştirildi.";
		}

		if(isset($_POST['auto_sms'])) { $args['insert']['auto_sms'] = 'auto_sms'; } else { $args['insert']['auto_sms'] = ''; }
		if(isset($_POST['auto_email'])) { $args['insert']['auto_email'] = 'auto_email'; } else { $args['insert']['auto_email'] = ''; }

		if(add_form_status($args)) { _set_form_status_default($_taxonomy); }
	}
}





print_alert();
?>

<div class="row">
	<div class="col-lg-4 col-md-6">
		<form name="form_status" id="form_status" action="<?php set_url_parameters(array('add'=>array('taxonomy'=>$_taxonomy) )); ?>" method="POST" class="validate">
			<div class="form-group">
				<label for="status_name">Durum Adı</label>
				<input type="text" name="status_name" id="status_name" class="form-control required" minlength="3" maxlength="20">
			</div> <!-- /.form-group -->


			<!-- color -->

			<?php if($_bg_color or $_color): ?>
				<div class="form-group text-center">
					<span class="label label-success label-fs-example long" style="background-color:#fdc430; color:#000000;">Örnek Görünüm</span>
					|
					<span class="label label-success label-fs-example abbreviation" style="background-color:#fdc430; color:#000000;">ÖG</span>
				</div> <!-- /.form-group -->
				<script>
				function toTitleCase_firstCharAt(str)
				{
				    str =  str.replace(/\w\S*/g, function(txt){ return txt.charAt(0).toUpperCase(); }).replace(' ', '');
				    return str.charAt(0) + str.charAt(1);
				}
				$(document).ready(function() {
					$('#status_name').keyup(function() {
						var text = $('#status_name').val();
						if(text.length > 0) {
							$('.label-fs-example.long').html(text);
							$('.label-fs-example.abbreviation').html(toTitleCase_firstCharAt(text));
						} else {
							$('.label-fs-example.long').html('Örnek Görünüm');
							$('.label-fs-example.abbreviation').html('ÖG');
						}
					});
					
					var text = $('#status_name').val();
					if(text.length > 0) {
						$('.label-fs-example.long').html(text);
						$('.label-fs-example.abbreviation').html(toTitleCase_firstCharAt(text));
					} else {
						$('.label-fs-example.long').html('Örnek Görünüm');
						$('.label-fs-example.abbreviation').html('ÖG');
					}
				});
				</script>
			<?php endif; ?>

			<div class="row">
				<?php if($_bg_color): ?>
					<div class="col-md-6">
						<div class="form-group">
							<label for="status_bg_color"><i class="fa fa-square color-bg-status" style="color:#fdc430;"></i> Arkaplan Renk Kodu</label>
							<input type="text" name="status_bg_color" id="status_bg_color" class="form-control required colorpicker_bg_status" readonly maxlength="32" value="#fdc430">
							<script>
							$(document).ready(function() {
								$('.colorpicker_bg_status').colorpicker().on('changeColor', function(e) {
						            $('.color-bg-status')[0].style.color = e.color.toHex();
						            $('.label-fs-example')[0].style.backgroundColor = e.color.toHex();
						            $('.label-fs-example')[1].style.backgroundColor = e.color.toHex();
						        });
							});
							</script>
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-6 -->
				<?php endif; ?>
				<?php if($_color): ?>
					<div class="col-md-6">
						<div class="form-group">
							<label for="status_color"><i class="fa fa-square color-status" style="color:#000;"></i> Yazı Renk Kodu</label>
							<input type="text" name="status_color" id="status_color" class="form-control required colorpicker_status" readonly maxlength="32" value="#000">
							<script>
							$(document).ready(function() {
								$('.colorpicker_status').colorpicker().on('changeColor', function(e) {
						            $('.color-status')[0].style.color = e.color.toHex();
						            $('.label-fs-example')[0].style.color = e.color.toHex();
						            $('.label-fs-example')[1].style.color = e.color.toHex();
						        });
							});
							</script>
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md-6 -->
				<?php endif; ?>
			</div> <!-- /.row -->
			<!-- /color -->


			<?php if($_in_out): ?>
				<div class="form-group">
					<label for="status_name">Giriş mi? Çıkış mı?</label>
					<select name="val_enum" id="val_enum" class="form-control select">
						<option value="0">Giriş</option>
						<option value="1">Çıkış</option>
					</select>
				</div> <!-- /.form-group -->
			<?php else: ?>
				<input type="hidden" name="val_enum" id="val_enum" value="0">
			<?php endif; ?>


			<?php if($_sms_template): ?>
				<div class="form-group">
					<label for="sms_template">SMS Şablonu <small>(<span id="sms_count">0</span> karakter)</small></label>
					<label class="veritical-center pull-right"><small class="text-muted">Otomatik SMS gönderilsin mi?</small> &nbsp; <input type="checkbox" name="auto_sms" id="auto_sms" value="true" class="toogle" data-size="mini" data-on-text="Evet" data-off-text="Hayır"></label>
					<textarea name="sms_template" id="sms_template" class="form-control fs-12 h-100">[form_id] no'lu siparişinizin durumu [form_status] olarak değiştirildi.</textarea>
				</div> <!-- /.form-group -->
				<script>
				$(document).ready(function() {
					calc_val_length('#sms_template', '#sms_count');
				});
				</script>
			<?php endif; ?>

			<?php if($_email_template): ?>
				<div class="form-group">
					<label for="email_template">E-posta Şablonu</label>
					<label class="veritical-center pull-right"><small class="text-muted">Otomatik E-posta gönderilsin mi?</small> &nbsp; <input type="checkbox" name="auto_email" id="auto_email" value="true" class="toogle" data-size="mini" data-on-text="Evet" data-off-text="Hayır"></label>
					<textarea name="email_template" id="email_template" class="form-control" style="height:100px;"></textarea>
				</div> <!-- /.form-group -->
			<?php endif; ?>



			<div class="text-right">
				<input type="hidden" name="add">
				<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
				<button class="btn btn-default">Kaydet</button>
			</div>
		</form>
	</div> <!-- /.col-lg-4 -->
	<?php if($_sms_template or $_email_template): ?>
		<div class="col-lg-4 col-md-6">
			<?php include('_template.php'); ?>
		</div> <!-- /.col-lg-4 -->
	<?php endif; ?>
	<div class="col-lg-4 col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Giriş Form Durumları</h3></div>
			<div class="panel-body">
				<?php $form_status = get_form_status_all(array('taxonomy'=>$_taxonomy, 'in_out'=>0) ); ?>
				<?php if($form_status): ?>
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Durum Adı</th>
								<?php if($_email_template): ?><th width="100">Oto Mail</th><?php endif; ?>
								<?php if($_sms_template): ?><th width="100">Oto SMS</th><?php endif; ?>
							</tr>
						</thead>
						<tbody>
						<?php foreach($form_status as $status): ?>
							<tr>
								<td><a href="?taxonomy=<?php echo $_taxonomy; ?>&detail&status_id=<?php echo $status->id; ?>"><span class="<?php if($status->bg_color): ?>label label-success<?php endif; ?>" style="background-color:<?php echo $status->bg_color; ?>; color:<?php echo $status->color; ?>;"><?php echo $status->name; ?></span></a> <?php if($status->is_default == 'default'): ?><small class="text-muted">(varsayılan)</small><?php endif; ?></td>
								<?php if($_email_template): ?><td class="text-center"><?php if($status->auto_email == 'auto_email'): ?>evet<?php else: ?> hayır <?php endif; ?></td><?php endif; ?>
								<?php if($_sms_template): ?><td class="text-center"><?php if($status->auto_sms == 'auto_sms'): ?>evet<?php else: ?> hayır <?php endif; ?></td><?php endif; ?>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

		<?php if($_in_out): ?>
			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title">Çıkış Form Durumları</h3></div>
				<div class="panel-body">
					<?php $form_status = get_form_status_all(array('taxonomy'=>$_taxonomy, 'in_out'=>1) ); ?>
					<?php if($form_status): ?>
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>Durum Adı</th>
									<?php if($_email_template): ?><th width="100">Oto Mail</th><?php endif; ?>
									<?php if($_sms_template): ?><th width="100">Oto SMS</th><?php endif; ?>
								</tr>
							</thead>
							<tbody>
							<?php foreach($form_status as $status): ?>
								<tr>
									<td><a href="?taxonomy=<?php echo $_taxonomy; ?>&detail&status_id=<?php echo $status->id; ?>"><span class="<?php if($status->bg_color): ?>label label-success<?php endif; ?>" style="background-color:<?php echo $status->bg_color; ?>; color:<?php echo $status->color; ?>;"><?php echo $status->name; ?></span></a> <?php if($status->is_default == 'default'): ?><small class="text-muted">(varsayılan)</small><?php endif; ?></td>
									<?php if($_email_template): ?><td class="text-center"><?php if($status->auto_email == 'auto_email'): ?>evet<?php else: ?> hayır <?php endif; ?></td><?php endif; ?>
									<?php if($_sms_template): ?><td class="text-center"><?php if($status->auto_sms == 'auto_sms'): ?>evet<?php else: ?> hayır <?php endif; ?></td><?php endif; ?>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div> <!-- /.panel-body -->
			</div> <!-- /.panel -->
		<?php endif; ?>
	</div> <!-- /.col-lg-4 -->
</div> <!-- /.row -->

