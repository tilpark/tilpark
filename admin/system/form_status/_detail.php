
<?php
$status = get_form_status(array('id'=>$_GET['status_id'], 'taxonomy'=>$_taxonomy));

if(isset($_POST['update'])) {
	$_form_status['taxonomy']	= $_taxonomy;
	$_form_status['name'] 	= $_POST['status_name'];
	if($_color) { $_form_status['color'] 	= $_POST['status_color']; }
	if($_bg_color) { $_form_status['bg_color'] 	= $_POST['status_bg_color']; }
	if($_sms_template) { $_form_status['sms_template']	= $_POST['sms_template']; }
	if($_email_template) { $_form_status['email_template']	= $_POST['email_template']; }
	$_form_status['in_out']	= $status->in_out;

	if(isset($_POST['auto_email'])) { $_form_status['auto_email'] = 'auto_email'; } else { $_form_status['auto_email'] = ''; }
	if(isset($_POST['auto_sms'])) { $_form_status['auto_sms'] = 'auto_sms'; } else { $_form_status['auto_sms'] = ''; }
	if(isset($_POST['default'])) { $_form_status['is_default'] = 'default'; } else { $_form_status['default'] = 'none'; }


	$where['id'] = $_GET['status_id'];
	$where['taxonomy'] = $_taxonomy;
	update_form_status($where, $_form_status );

}
print_alert();
?>

<?php if($status = get_form_status(array('id'=>$_GET['status_id'], 'taxonomy'=>$_taxonomy))):?>
	<?php $status->count = calc_form_status(array('id'=>$status->id, 'taxonomy'=>$_taxonomy) ); ?>
	<?php add_page_info( 'title', $_name.' Durumu - '.$status->name ); ?>
	<?php add_page_info( 'nav', array('name'=>$_name.' Durumları', 'url'=>get_site_url('admin/system/form_status/form_status.php?taxonomy='.$_taxonomy) ) ); ?>
	<?php add_page_info( 'nav', array('name'=>$status->name) ); ?>

	<div class="row">
		<div class="col-md-4">
			<form name="form_status" id="form_status" action="<?php set_url_parameters(array('add'=>array('taxonomy'=>$_taxonomy) )); ?>" method="POST" class="validate">
				<div class="form-group">
					<label for="status_name">Durum Adı</label>
					<input type="text" name="status_name" id="status_name" class="form-control" value="<?php echo $status->name; ?>">
				</div> <!-- /.form-group -->


				<!-- color -->
				<?php if($_bg_color or $_color): ?>
					<div class="form-group text-center">
						<span class="label label-success label-fs-example long" style="background-color:<?php echo $status->bg_color; ?>; color:<?php echo $status->color; ?>;"><?php echo $status->name; ?></span>
						|
						<span class="label label-success label-fs-example abbreviation" style="background-color:<?php echo $status->bg_color; ?>; color:<?php echo $status->color; ?>;">ÖG</span>
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
								<label for="status_bg_color"><i class="fa fa-square color-bg-status" style="color:<?php echo $status->bg_color; ?>;"></i> Arkaplan Renk Kodu</label>
								<input type="text" name="status_bg_color" id="status_bg_color" class="form-control required colorpicker_bg_status" readonly maxlength="32" value="#<?php echo $status->bg_color; ?>">
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
								<label for="status_color"><i class="fa fa-square color-status" style="color:<?php echo $status->color; ?>;"></i> Yazı Renk Kodu</label>
								<input type="text" name="status_color" id="status_color" class="form-control required colorpicker_status" readonly maxlength="32" value="#<?php echo $status->color; ?>">
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



				<?php if($_sms_template): ?>
					<div class="form-group">
						<label for="sms_template">SMS Şablonu <small>(<span id="sms_count">0</span> karakter)</small></label>
						<label class="veritical-center pull-right"><small class="text-muted">Otomatik SMS gönderilsin mi?</small> &nbsp; <input type="checkbox" name="auto_sms" id="auto_sms" value="true" class="toogle" <?php checked($status->auto_sms, 'auto_sms'); ?> data-size="extramini" data-on-text="Evet" data-off-text="Hayır"></label>
						<textarea name="sms_template" id="sms_template" class="form-control fs-12 h-100"><?php echo $status->sms_template; ?></textarea>
					
						<script>
						$(document).ready(function() {
							calc_val_length('#sms_template', '#sms_count');
						});
						</script>

					</div> <!-- /.form-group -->
				<?php endif; ?>


				<?php if($_email_template): ?>
					<div class="form-group">
						<label for="email_template">E-posta Şablonu</label>
						<label class="veritical-center pull-right"><small class="text-muted">Otomatik E-posta gönderilsin mi?</small> &nbsp; <input type="checkbox" name="auto_email" id="auto_email" value="true" class="toogle" <?php checked($status->auto_mail, 'auto_email'); ?> data-size="extramini" data-on-text="Evet" data-off-text="Hayır"></label>
						<textarea name="email_template" id="email_template" class="form-control h-100"><?php echo $status->mail_template; ?></textarea>
					</div> <!-- /.form-group -->
				<?php endif; ?>

				
				<div class="form-group">
					<label class="veritical-center"><input type="checkbox" name="default" id="default" value="true" class="toogle" <?php checked($status->is_default, 'default'); ?> data-size="mini" data-on-text="Evet" data-off-text="Hayır"> &nbsp; Varsayılan yani ilk form oluştuduğunda seçilsin mi?</label>
				</div> <!-- /.form-group -->



				<div class="text-right">
					<input type="hidden" name="update">
					<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
					<button class="btn btn-default">Kaydet</button>
				</div>

			</form>

			<hr />

			<label>Bu form durumuna ait, <b><?php echo $status->count; ?></b> adet form bulundu.</label>
			<br />
			<label>Form durumunu silmek istiyor musunuz? <a href="#" class="text-danger" data-toggle="modal" data-target="#form_status_delete"><i class="fa fa-trash"></i> Evet, form durumunu sil</a></label>


			<!-- Modal -->
			<div class="modal fade" id="form_status_delete" tabindex="-1" >
			  <form name="status_delete" id="status_delete" action="" method="GET" class="modal-dialog modal-md" role="document">
			    <div class="modal-content panel-danger">
			      <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title"><?php echo $status->name; ?> Form Durumunu Sil</h4>
			      </div>
			      <div class="modal-body">
			        
			       
			        <div class="alert <?php echo ($status->count > 0)? 'alert-danger' : 'alert-warning'; ?>"><?php echo $status->name; ?> form durumuna ait, <?php echo _b($status->count); ?> adet form bulundu.</div>
			        <?php $form_status_all = get_form_status_all(array('taxonomy'=>$_taxonomy, 'in_out'=>$status->in_out, 'not_in'=>array('id'=>$status->id) ) ); ?>

			        
			        <?php if($status->count > 0): ?>
			        	<?php if($form_status_all): ?>
				        	<p><small class="text-muted">Lütfen, aşağıdaki listeden farklı bir form durumu seçiniz. <b><?php echo $status->name; ?></b> form durumuna ait <?php echo _b($status->count); ?> adet form, aşağıda yeni seçeceğiniz form durumu ile değişecektir.</small></p>
				        	<select name="change_status_id" id="change_status_id" class="form-control select">
				        		<?php foreach($form_status_all as $_status): ?>
				        			<option value="<?php echo $_status->id; ?>"><?php echo $_status->name; ?></option>
				        		<?php endforeach; ?>
				        	</select>
				        	<div class="h-10"></div>
				        	<p class="text-danger"><b><?php echo $status->name; ?></b> form durumunu silmek ve bu form durumuna ait <?php echo _b($status->count); ?> adet formu yukarıda yeni seçtiğiniz form durumuna aktarmak istiyor musunuz?</p>
					    <?php else: ?>
				        		<p><small class="text-muted"><b><?php echo $status->name; ?></b> form durumunu silemezsiniz. <br /> Çünkü bu form durumuna ait <?php echo _b($status->count); ?> adet formu aktarabileceğim başka bir form durumu bulunamadı. </small></p>
						<?php endif; ?>
					<?php else: ?>
						<?php if($form_status_all): ?>
							<p><small class="text-muted"><b><?php echo $status->name; ?></b> form durumunu silmek istiyor musunuz? </small></p>
						<?php else: ?>
							<div class="alert alert-danger">Form durumu varsayılan olarak işaretlenmiş. Form durumunu silemezsiniz.</div>
						<?php endif; ?>
					<?php endif; ?>
			        	
			        

					 
			      </div> <!-- /.modal-body -->
			      <div class="modal-footer">
			      	<input type="hidden" name="taxonomy" value="<?php echo $_taxonomy; ?>">
			      	<input type="hidden" name="delete_status_id" id="delete_status_id" value="<?php echo $status->id; ?>">
			        <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
			        <?php if($form_status_all): ?><button type="submit" class="btn btn-primary">Evet, onaylıyorum</button><?php endif; ?>
			      </div> <!-- /.modal-footer -->
			    </div> <!-- /.modal-content -->
			  </form>
			</div> <!-- /.modal -->


		</div> <!-- /.col-md-4 -->
		<?php if($_sms_template or $_email_template): ?>
			<div class="col-md-4">
				<?php include('_template.php'); ?>
			</div> <!-- /.col-md-4 -->
		<?php endif; ?>
	</div> <!-- /.row -->

<?php else: ?>
	<?php echo get_alert('Form durumu bulunamadı.', 'warning', ''); ?>
<?php endif ?>


