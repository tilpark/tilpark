<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
// form bilgilerini cekelim ve form karti bulunmaz ise ekrana hata mesajini basalim
if(!$monthly = get_form(array('id'=>@$_GET['id'], 'type'=>'salary')) ) { echo get_alert('Maaş formu bulunamadı.', 'warning', false); get_footer(); return false; }

// personel bilgilerini dondurelim ve eger personel bilgileri yok ise ekrana haata mesajlarini basalim
if(!$user = get_user($monthly->user_id)) { echo get_alert('Personel bilgileri bulunamadı.', 'warning', false); get_footer(); return false; }

# form bakiyerlerini tekrar hesaplayalim
set_staff_salary($monthly->user_id);
# form kartini tekrar cagiralim
$monthly = get_form($_GET['id']);

# form ayinda kac gun oldugunu hesaplayalim
$how_days = date("t", strtotime($monthly->date));
# form ayindaki gun sayisini bulduktan sonra bir gun kac para hesaplayalim
# $monthly->val_decimal aylik toplam maas bilgisini dondurur
$price_day_wage = number_format($monthly->val_decimal / $how_days,4);
# bir personel bir gunde en fazla (x) saat calisabilir. Buna gore 1 saat kac paraya denk geliyor
$price_hours_wage = $price_day_wage/8;


# sayfa ayarlarini yapalim
add_page_info( 'title', til_get_date($monthly->date, 'str: F Y').' Maaş' );
add_page_info( 'nav', array('name'=>'Tüm Personeller', 'url'=>get_site_url('admin/user/list.php') ) );
add_page_info( 'nav', array('name'=>$user->display_name, 'url'=>get_site_url('admin/user/user.php?id='.$user->id) ) );
add_page_info( 'nav', array('name'=> til_get_date($monthly->date, 'str: F Y').' Maaş') );




// eger aylik maas miktari guncellenmek isteniyorsa
// maas birimini guncelleyelim, bu guncelleme sadece aktif olan ay icin gecerlidir
if(isset($_POST['update_monthly_salary'])) {
	if(db()->query("UPDATE ".dbname('forms')." SET val_decimal='".get_set_decimal_db($_POST['monthly_salary'])."' WHERE id='".$monthly->id."' ")) {
		set_staff_salary($monthly->user_id);
	}
}




// form hareketi ekler, mesai, eksik mesai, ise gelmedi veya izin aldı gibi vb...
if(isset($_POST['wage_type']) and !have_log()) {
	// gerekli
	$wage['type'] 		= 'wage';
	$wage['form_id']	= $monthly->id;

	
	if($_POST['wage_type'] == 'overtime') {
		## fazla mesai ##

		@form_validation($_POST['overtime_date'], 'overtime_date', 'Tarih', 'required|date', 'overtime');
		@form_validation($_POST['overtime_hours'], 'overtime_hours', 'Saat', 'required|number', 'overtime');
		@form_validation($_POST['overtime_price'], 'overtime_price', 'B. Fiyatı', 'required|money', 'overtime');
		@form_validation($_POST['overtime_desc'], 'overtime_desc', 'Açıklama', 'max_length[64]', 'overtime');


		if(!is_alert('overtime')) {
			$wage['quantity'] 	= $_POST['overtime_hours'];
			$wage['price']		= $_POST['overtime_price'];
			$wage['val_date'] 	= $_POST['overtime_date'];
			$wage['item_name']	= 'overtime';
			$wage['val_1']		= substr($monthly->date,0,7);
			$wage['val_3']  	= $_POST['overtime_desc'];

			if(insert_form_item($wage)) {
				add_log(array('table_id'=>'users:'.$monthly->user_id, 'log_key'=>'user_wage', 'log_text'=>'Fazla mesai eklendi. '._b($wage['quantity']).' saat'));
			}
		}
		
	} else if($_POST['wage_type'] == 'not_overtime') {
		## eksik mesai ##

		@form_validation($_POST['not_overtime_date'], 'not_overtime_date', 'Tarih', 'required|date', 'not_overtime');
		@form_validation($_POST['not_overtime_hours'], 'not_overtime_hours', 'Saat', 'required|number', 'not_overtime');
		@form_validation($_POST['not_overtime_price'], 'not_overtime_price', 'B. Fiyatı', 'required|money', 'not_overtime');
		@form_validation($_POST['not_overtime_desc'], 'not_overtime_desc', 'Açıklama', 'max_length[64]', 'not_overtime');

		if(!is_alert('not_overtime')) {
			$wage['in_out']		= '0';
			$wage['quantity'] 	= $_POST['not_overtime_hours'];
			$wage['price']		= '-'.get_set_decimal_db($price_hours_wage);
			$wage['val_date'] 	= $_POST['not_overtime_date'];
			$wage['item_name']		= 'not_overtime';
			$wage['val_1']		= substr($monthly->date,0,7);
			$wage['val_3']  	= $_POST['not_overtime_desc'];

			if(insert_form_item($wage)) {
				add_log(array('table_id'=>'users:'.$monthly->user_id, 'log_key'=>'user_wage', 'log_text'=>'Eksik mesai eklendi. '._b($wage['quantity']).' saat'));
			}
		}
		
	} else if($_POST['wage_type'] == 'did_not_come') {
		## ise gelmedi ##

		@form_validation($_POST['dnc_start_date'], 'dnc_start_date', 'Gelmediği Tarih', 'required|date', 'did_not_come');
		@form_validation($_POST['dnc_end_date'], 'dnc_end_date', 'Tekrar Geldiği Tarih', 'required|date', 'did_not_come');

		if(!is_alert('did_not_come')) {
			$dnc_how_day = round( (strtotime($_POST['dnc_end_date']) - strtotime($_POST['dnc_start_date'])) / 86400);
			if($dnc_how_day < 1) {
				add_alert('İşe gelmediği tarih ile tekrar geldiği tarih arasında en az 1 gün olmalı.', 'warning');
			} else {
				$wage['in_out']		= '0';
				$wage['quantity'] 	= $dnc_how_day;
				if(isset($_POST['dnc_wage_cut'])) { $wage['price'] = '-'.get_set_decimal_db($price_day_wage); } else { $wage['price'] = 0.00; }
				$wage['item_name']	= 'did_not_come';
				$wage['val_1']  	= $_POST['dnc_start_date'];
				$wage['val_2']  	= $_POST['dnc_end_date'];
				$wage['val_3'] 		= $_POST['dnc_description'];
				$wage['val_date']   = $_POST['dnc_start_date'];

				if(insert_form_item($wage)) {
					add_log(array('table_id'=>'users:'.$monthly->user_id, 'log_key'=>'user_wage', 'log_text'=>'İşe gelmedi. '._b($wage['quantity']).' gün'));
				}
			}
			
		}
	} else if($_POST['wage_type'] == 'to_let') {
		## izin ##

		@form_validation($_POST['let_start_date'], 'let_start_date', 'İzin Başlama Tarih', 'required|date', 'to_let');
		@form_validation($_POST['let_end_date'], 'let_end_date', 'İzin Bitiş Tarihi', 'required|date', 'to_let');

		if(!is_alert('to_let')) {
			$let_how_day = round( (strtotime($_POST['let_end_date']) - strtotime($_POST['let_start_date'])) / 86400);
			if($let_how_day < 1) {
				add_alert('İzin tarihi ile izin bitiş tarihi arasında en az 1 gün olmalı.', 'warning');
			} else {
				$wage['in_out']		= '0';
				$wage['quantity'] 	= $let_how_day;
				if(isset($_POST['let_wage_cut'])) { $wage['price'] = '-'.get_set_decimal_db($price_day_wage); } else { $wage['price'] = 0.00; }
				$wage['item_name']	= 'to_let';
				$wage['val_1']  	= $_POST['let_start_date'];
				$wage['val_2']  	= $_POST['let_end_date'];
				$wage['val_3'] 		= $_POST['let_description'];
				$wage['val_date']   = $_POST['let_start_date'];


				if(insert_form_item($wage)) {
					add_log(array('table_id'=>'users:'.$monthly->user_id, 'log_key'=>'user_wage', 'log_text'=>'İzin kullandı. '._b($wage['quantity']).' gün'));
				}
			}
			
		}
	}

} //. isset($_POST['wage'])




// bir form hareketini siler
if( isset($_GET['delete_form_item']) and user_access('admin') ) {
	if(db()->query("UPDATE ".dbname('form_items')." SET status='0' WHERE id='".input_check($_GET['delete_form_item'])."' AND form_id='".$monthly->id."' AND item_name != 'monthly_day'")) {
		if(db()->affected_rows) {
			add_alert('Çalışma durumu hareketi silindi', 'warning');
		}
	}
} //.isset($_GET[delete_form_item])




# aylık personel bakiyesini kontrol edelim
calc_form($monthly->id);
# aylık formunu tekar cagiralim
$monthly = get_form($monthly->id);
?>

<?php print_alert(); ?>

<div class="row">

	<div class="col-lg-3 col-md-6">
		<div class="panel panel-warning panel-heading-0">
			<div class="panel-body">
				<small class="text-muted"><?php echo til_get_date($monthly->date, 'F Y'); ?> ayına ait maaş tutarını değistir.</small>
				<div class="h-10"></div>
				<form name="form_monthly_salary" id="form_montlhy_salary" action="?id=<?php echo $monthly->id; ?>" method="POST">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" name="monthly_salary" id="monthly_salary" class="form-control money" value="<?php echo $monthly->val_decimal; ?>">
							</div> <!-- /.form-group -->
						</div> <!-- /.col-md-6 -->
						<div class="col-md-6">
							<div class="form-group">
								<input type="hidden" name="update_monthly_salary">
								<button class="btn btn-default"><i class="fa fa-save"></i> Değistir</button>
							</div> <!-- /.form-group -->
						</div> <!-- /.col-md-6 -->
					</div> <!-- /.row -->
				</form>
				
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel-default -->
		
	</div> <!-- /.col-md-6 -->

	<div class="col-lg-9 col-md-12">

		<?php $q_form_items = db()->query("SELECT * FROM ".dbname('form_items')." WHERE status='1' AND form_id='".$monthly->id."' ORDER BY val_date ASC, id ASC"); ?>

		<div class="panel panel-default panel-table">
			<div class="panel-heading"><h3 class="panel-title"><?php echo til_get_date($monthly->date, 'F Y'); ?> Maaş Detayları</h3></div>

			<div class="panel-body">
				<form name="form_wage" id="form_wage" action="?id=<?php echo $monthly->id; ?>" method="POST">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="wage_type">Durum</label>
								<select name="wage_type" id="wage_type" class="form-control js_til_select_div" data-div=".div_wage_status">
									<option value="">Seçiniz...</option>
									<option value="overtime" selected>Fazla Mesai</option>
									<option value="not_overtime">Eksik Mesai</option>
									<option value="did_not_come">İşe Gelmedi</option>
									<option value="to_let">İzin Vermek</option>
								</select>
							</div> <!-- /.form-group -->
						</div> <!-- /.col-md-* -->
						<div class="col-md-8">

							<div class="div_wage_status" data-div_selected="overtime">
								<div class="row space-5">
									<div class="col-md-3">
										<label for="dnc_start_date">Tarihi</label>
										<input type="text" name="overtime_date" id="overtime_date" class="form-control date" value="<?php echo date('Y-m-d'); ?>">
									</div> <!-- /.col-md-* -->
									<div class="col-md-2">
										<label for="overtime_hours">Saat</label>
										<input type="text" name="overtime_hours" id="overtime_hours" class="form-control digits" maxlength="2" value="">
									</div> <!-- /.col-md-* -->
									<div class="col-md-2">
										<label for="overtime_price">B. Fiyatı</label>
										<input type="text" name="overtime_price" id="overtime_price" class="form-control" maxlength="5" value="<?php echo get_set_money($price_hours_wage); ?>">
									</div> <!-- /.col-md-* -->
									<div class="col-md-5">
										<label for="overtime_desc">Açıklama</label>
										<input type="text" name="overtime_desc" id="overtime_desc" class="form-control" maxlength="64" value="">
									</div> <!-- /.col-md-* -->
								</div> <!-- /.row -->
							</div> <!-- /.div_wage_status -->

							<div class="div_wage_status" data-div_selected="not_overtime">
								<div class="row space-5">
									<div class="col-md-3">
										<label for="not_overtime_date">Tarihi</label>
										<input type="text" name="not_overtime_date" id="not_overtime_date" class="form-control date" value="<?php echo date('Y-m-d'); ?>">
									</div> <!-- /.col-md-* -->
									<div class="col-md-2">
										<label for="not_overtime_hours">Saat</label>
										<input type="text" name="not_overtime_hours" id="not_overtime_hours" class="form-control digits" maxlength="5" value="">
									</div> <!-- /.col-md-* -->
									<div class="col-md-2">
										<label for="not_overtime_price">B. Fiyatı</label>
										<input type="text" name="not_overtime_price" id="not_overtime_price" class="form-control" maxlength="5" value="<?php echo get_set_money($price_hours_wage); ?>">
									</div> <!-- /.col-md-* -->
									<div class="col-md-5">
										<label for="not_overtime_desc">Açıklama</label>
										<input type="text" name="not_overtime_desc" id="not_overtime_desc" class="form-control" maxlength="64" value="">
									</div> <!-- /.col-md-* -->
								</div> <!-- /.row -->
							</div> <!-- /.div_wage_status -->


							<div class="div_wage_status" data-div_selected="did_not_come">
								<div class="row space-5">
									<div class="col-md-6">
										<div class="form-group">
											<label for="dnc_start_date">Gelmediği Tarihi</label>
											<input type="text" name="dnc_start_date" id="dnc_start_date" class="form-control date" value="<?php echo date('Y-m-d'); ?>">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-* -->
									<div class="col-md-6">
										<div class="form-group">
											<label for="dnc_start_date">Tekrar Geldiği Tarihi</label>
											<input type="text" name="dnc_end_date" id="dnc_end_date" class="form-control date" value="<?php echo date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d')))); ?>">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-* -->
								</div> <!-- /.row -->

							
								<div class="form-group">
									<label><input type="checkbox" name="dnc_wage_cut" id="dnc_wage_cut" value="1"> Gelmediği günlerin ücreti kesilsin mi?</label>
								</div> <!-- /.form-group -->
									

								<div class="form-group">
									<label for="dnc_description">Açıklama</label>
									<input type="text" name="dnc_description" id="dnc_description" class="form-control" maxlength="64">
								</div> <!-- /.form-group -->

							</div> <!-- /.div_wage_status -->


							<div class="div_wage_status" data-div_selected="to_let">
								<div class="row space-5">
									<div class="col-md-6">
										<div class="form-group">
											<label for="let_start_date">İzin Başlangıç Tarihi</label>
											<input type="text" name="let_start_date" id="let_start_date" class="form-control date" value="<?php echo date('Y-m-d'); ?>">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-* -->
									<div class="col-md-6">
										<div class="form-group">
											<label for="let_end_date">İzin Bitiş Tarihi</label>
											<input type="text" name="let_end_date" id="let_end_date" class="form-control date" value="<?php echo date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d')))); ?>">
										</div> <!-- /.form-group -->
									</div> <!-- /.col-md-* -->
								</div> <!-- /.row -->

							
								<div class="form-group">
									<label><input type="checkbox" name="let_wage_cut" id="let_wage_cut" value="1"> İzin günlerinde ücreti kesilsin mi?</label>
								</div> <!-- /.form-group -->
									

								<div class="form-group">
									<label for="let_description">Açıklama</label>
									<input type="text" name="let_description" id="let_description" class="form-control" maxlength="64">
								</div> <!-- /.form-group -->

							</div> <!-- /.div_wage_status -->


						</div> <!-- /.col-md-* -->
						<div class="col-md-1 text-right">
							<div class="form-group">
								<label>&nbsp;</label> <br />
								<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
								<button class="btn btn-default btn-block"><i class="fa fa-save"></i></button>
							</div>
						</div> <!-- /.col-md-* -->
					</div> <!-- /.row -->
				</form>
			</div> <!-- ./panel-body -->

			<?php if($q_form_items->num_rows): ?>
				<table class="table table-hover table-condensed">
					<tr>
						<th width="1"></th>
						<th width="100">Tarih</th>
						<th>Açıklama</th>
						<th class="text-center">Sayı</th>
						<th class="text-right">B. Fiyatı</th>
						<th class="text-right">Toplam</th>
					</tr>
					<tbody>
						<?php while($item = $q_form_items->fetch_object() ): ?>
							<tr>
								<td>
									<?php if($item->item_name != 'monthly_day'): ?>
										<a href="?id=<?php echo $monthly->id; ?>&delete_form_item=<?php echo $item->id; ?>" class="btn btn-default btn-xs btn-danger btn-outline"><i class="fa fa-trash"></i></a>
									<?php endif; ?>
								</td>
								<td class="fs-11 text-muted"><?php echo til_get_date($item->date, 'datetime'); ?></td>
								<td>
									<?php if($item->item_name == 'monthly_day'): ?>
										<?php echo til_get_date($item->val_1, 'str: F Y'); ?>, günlük yevmiye
										<br />
										<small class="text-muted"><?php echo $item->val_2; ?> / <?php echo $item->val_3; ?></small>
									<?php elseif($item->item_name == 'overtime'): ?>
										Fazla mesai, <small class="text-muted">+<?php echo $item->quantity; ?> saat, <?php echo til_get_date($item->val_date,'date'); ?></small>
										<br />
										<small class="text-muted"><?php echo $item->val_3; ?></small>
									<?php elseif($item->item_name == 'not_overtime'): ?>
										Eksik mesai, <small class="text-muted">-<?php echo $item->quantity; ?> saat, <?php echo til_get_date($item->val_date,'date'); ?></small>
										<br />
										<small class="text-muted"><?php echo $item->val_3; ?></small>
									<?php elseif($item->item_name == 'did_not_come'): ?>
										Gelmedi, <small class="text-muted"><?php echo $item->val_1; ?> / <?php echo $item->val_2; ?></small>
										<br />
										<small class="text-muted"><?php echo $item->val_3; ?></small>
									<?php elseif($item->item_name == 'to_let'): ?>
										İzin, <small class="text-muted"><?php echo $item->val_1; ?> / <?php echo $item->val_2; ?></small>
										<br />
										<small class="text-muted"><?php echo $item->val_3; ?></small>
									<?php endif; ?>
	
								</td>
								<td class="text-center">
									<?php echo $item->quantity; ?>
									<?php if($item->item_name == 'monthly_day' OR $item->item_name == 'did_not_come' OR $item->item_name == 'to_let') { echo ' gün'; } else { echo ' saat'; } ?>
								</td>
								<td class="text-right"><?php echo get_set_money($item->price, true); ?></td>
								<td class="text-right"><?php echo get_set_money($item->total, true); ?></td>
							</tr>
						<?php endwhile; ?>
					</tbody>
					<tfooter>
						<tr>
							<th colspan="6" class="text-right"><?php echo get_set_money($monthly->total,true); ?></th>
						</tr>
					</tfooter>
				</table> <!-- /.table -->
			<?php else: ?>
				<div class="not-found">
					<?php echo get_alert('form_items kayıtları bulunamadı. Sistem yöneticiniz veya yazılım departmanı ile görüşün.'); ?>
				</div> <!-- /.not-found -->
			<?php endif; ?>
		</div> <!-- /.panel -->
		



	</div> <!-- /.col-md-6 -->
	
</div> <!-- /.row -->









<?php get_footer(); ?>