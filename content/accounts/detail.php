<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<?php $account = get_account($_GET['id']); ?>
<?php if($account): ?>

<?php
// Header Bilgisi
$breadcrumb[] = array('name'=>'Hesap Yönetimi', 'url'=>get_site_url('content/accounts/'));
$breadcrumb[] = array('name'=>'Hesap Listesi', 'url'=>get_site_url('content/accounts/list.php'));
$breadcrumb[] = array('name'=>$account['name'], 'url'=>'', 'active'=>true);
?>






<ul id="myTabs" class="nav nav-tabs bordered" role="tablist"> 
	<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false"><i class="fa fa-user"></i> Hesap Yönetimi</a></li> 
	<li role="presentation" class=""><a href="#forms" role="tab" id="forms-tab" data-toggle="tab" aria-controls="forms" aria-expanded="true"><i class="fa fa-th-list"></i> Hareketler</a></li>
	<li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs" aria-expanded="true"><i class="fa fa-clock-o"></i> Geçmiş</a></li>
	<li role="presentation" class="dropdown"> <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">Seçenekler <span class="caret"></span></a> 
		<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
			<li><a href="#dropdown1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1">Yazdır</a></li> 
			<li><a href="#dropdown2" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2">Görev Ataması</a></li> 
		</ul> 
	</li> 
	<li class="pull-right custom-buttons">
		<div class="btn-group btn-group pull-right" role="group" aria-label="...">
			  <button type="button" class="btn btn-default"><i class="fa fa-tasks"></i> Görev Ata</button>
			  <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Yazdır</button>
			  <button type="submit" class="btn btn-default" form="form_add"><i class="fa fa-save"></i> Kaydet</button>
			</div>
	</li>
</ul>


<div id="myTabContent" class="tab-content"> 
<!-- TAB HOME --> <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab"> 




<form name="form_add" id="form_add" action="" method="POST" class="validationn">
	<div class="row">
		<div class="col-md-6">


			<?php
			if(isset($_POST['update_account']) and !is_uniquetime())
			{
				$account['id']					= $account['id'];
				$account['code'] 				= form_validation($_POST['code'], 'Hesap Kodu', 'min_length[3]|max_length[32]');
				$account['name'] 				= form_validation($_POST['name'], 'Hesap Adı', 'required|min_length[3]|max_length[32]');
				$account['personnel_name'] 		= form_validation($_POST['personnel_name'], 'Yetkili Adı', 'min_length[3]|max_length[32]');
				$account['gsm'] 				= form_validation(clean_character($_POST['gsm'],'gsm'), 'Cep Telefonu', 'number|min_length[10]|max_length[11]');
				$account['phone'] 				= form_validation(clean_character($_POST['phone'],'phone'), 'Sabit Telefon', 'number|min_length[10]|max_length[11]');
				$account['address'] 			= form_validation($_POST['address'], 'Adres', 'min_length[3]|max_length[255]');
				$account['city'] 				= form_validation($_POST['city'], 'Şehir', 'min_length[3]|max_length[20]');
				$account['district'] 			= form_validation($_POST['district'], 'İlçe', 'min_length[3]|max_length[20]');



				if(!is_alert('form')) {	update_account($account); }
			}

			alert();

			?>


			<div class="form-group">
			  	<label class="control-label" for="code">Hesap Kodu <small class="text-muted"><i>(boş bırakılırsa otomatik oluşacaktır)</i></small></label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="32" name="code" id="code" value="<?php echo $account['code']; ?>">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="form-group">
			  	<label class="control-label" for="name">Hesap/Firma Adı</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control required" minlength="3" maxlength="32" name="name" id="name" value="<?php echo $account['name']; ?>">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="form-group">
			  	<label class="control-label" for="personnel_name">Yetkili Adı Soyadı</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
			    	<input type="text" class="form-control" minlength="3" maxlength="32" name="personnel_name" id="personnel_name" value="<?php echo $account['personnel_name']; ?>">
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					  	<label class="control-label" for="gsm">Cep Telefonu</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
					    	<input type="text" class="form-control gsm" minlength="10" maxlength="11" name="gsm" id="gsm" value="<?php echo $account['gsm']; ?>">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
				<div class="col-md-6">
					<div class="form-group">
					  	<label class="control-label" for="phone">Sabit Telefon</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-phone"></i></span>
					    	<input type="text" class="form-control phone" minlength="10" maxlength="11" name="phone" id="phone" value="<?php echo $account['phone']; ?>">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
			</div> <!-- /.row -->

			<div class="form-group">
			  	<label class="control-label" for="address">Adres</label>
			  	<div class="input-group">
			    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
			    	<textarea class="form-control" name="address" id="address" minlength="3" maxlength="255"><?php echo $account['address']; ?></textarea>
			  	</div> <!-- /.input-group -->
			</div> <!-- /.form-group -->

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					  	<label class="control-label" for="city">Şehir</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
					    	<input type="text" class="form-control" minlength="3" maxlength="20" name="city" id="city" value="<?php echo $account['city']; ?>">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
				<div class="col-md-6">
					<div class="form-group">
					  	<label class="control-label" for="district">İlçe</label>
					  	<div class="input-group">
					    	<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
					    	<input type="text" class="form-control" minlength="3" maxlength="20" name="district" id="district" value="<?php echo $account['district']; ?>">
					  	</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
			</div> <!-- /.row -->


			<div class="form-group text-right">
				<input type="hidden" name="update_account">
				<?php uniquetime(); ?>
				<button class="btn btn-default"><i class="fa fa-save"></i> Kaydet</button>
			</div> <!-- /.form-group -->


		</div> <!-- /.col-md-6 -->
		<div class="col-md-6">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-question-circle"></i> Barkod Kodu</div>
				<div class="panel-body">
					<img src="<?php echo site_url('inc/plugins/barcode/?text='); ?><?php echo $account['code']; ?>">
					<br />
					<span><?php echo $account['code']; ?></span>
				</div> <!-- /.panel-body -->
			</div> <!-- /.panel panel-default -->

			

		</div> <!-- /.col-md-6 -->
	</div> <!-- /.row -->
</form>
<script>$('#code').focus();</script>


</div> <!-- /.tab-pane #home -->
<!-- /TAB HOME -->
<!-- TAB FORMS -->
<div role="tabpanel" class="tab-pane fade" id="forms" aria-labelledby="forms-tab"> 

	<h3 class="row-module-title"><i class="fa fa-th-list"></i> Formlar/Hareketler Listesi</h3>
	<?php $q_form_items = db()->query("SELECT * FROM ".dbname('forms')." WHERE account_id='".$account['id']."' AND status='1' ORDER BY date ASC"); ?>
	<?php if($q_form_items->num_rows > 0): ?>
		<table class="table table-hover table-bordered table-condensed dataTable">
			<thead>
				<tr>
					<th>Tarih</th>
					<th>Giriş/Çıkış</th>
					<th>Personel</th>
					<th>Form ID</th>
					<th>Hesap Kartı</th>
					<th>Tutar</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$quantity = 0;
			while($list = $q_form_items->fetch_assoc())
			{
				?>
				<tr>
					<td><?php echo $list['date']; ?></td>
					<td><?php echo get_text_inout($list['in_out']); ?></td>
					<td><?php echo $list['user_id']; ?></td>
					<td><a href="<?php url_form($list['id']); ?>" target="_blank">#<?php echo $list['id']; ?></a></td>
					<td>
						<?php if($list['account_id'] > 0): ?><a href="<?php url_account($list['account_id']); ?>" target="_blank"><?php echo $list['account_name']; ?></a><?php else: ?><?php echo $list['account_name']; ?><?php endif; ?></td>
					<td class="text-right"><?php echo convert_money($list['total'], array('icon'=>true)); ?></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
	<?php endif; ?>
	
	
</div> <!-- /.tab-pane #forms -->
<!-- /TAB FORMS -->
<!-- TAB LOGS -->
<div role="tabpanel" class="tab-pane fade" id="logs" aria-labelledby="logs-tab"> 

	<h3 class="row-module-title"><i class="fa fa-clock-o"></i> Geçmiş - Log Kayıtları</h3>
	<?php get_logs(array('table_id'=>'accounts:'.$account['id'])); ?>
	
</div> <!-- /.tab-pane #logs -->
<!-- /TAB LOGS -->

</div> <!-- /.tab-content -->

<?php else: ?>
	<?php echo get_alert(array('title'=>'Hesap Kartı Bulunamadı.'), 'danger', array('dismissible'=>false) ); ?>
<?php endif; ?>


<?php get_footer(); ?>