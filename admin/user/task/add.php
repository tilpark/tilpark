<?php include('../../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
// gerekli degiskenler
@$message->title = 'Yeni Görev :';


if(isset($_GET['rec_u_id'])) {
	$rec_user = get_user($_GET['rec_u_id']);
}

if(isset($_POST['rec_u_id'])) {
	$rec_user = get_user($_POST['rec_u_id']);
}


add_page_info( 'title', $message->title );
add_page_info( 'nav', array('name'=>'Mesaj Kutusu', 'url'=>get_site_url('admin/user/message_box.php') ) );
add_page_info( 'nav', array('name'=>@$rec_user->name.' '.@$rec_user->surname) );


/* mesaj ekleri var ise olusturalim */
$str_attachment = '';
if(isset($_GET['attachment'])) {

	// gerekli degiskenler
	$str_attachment_title 	= 'NULL';
	$str_attachment 		= '<div class="row"><div class="col-md-6"><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><i class="fa fa-paperclip fa-fw"></i> Mesaj Eki - {TITLE}</h4></div>';
	$str_attachment   		= $str_attachment.'<table class="table table-condensed table-hover table-striped"><tbody>';
	$str_attachment_end 	= '</tbody></table></div></div></div>';

	// form
	if(isset($_GET['form_id'])) {
		if($form = get_form($_GET['form_id'])) {
			$form_status = get_form_status($form->status_id);

			$str_attachment_title 	= 'Form';
			$_message['title'] 		= 'Mesaj Eki - Form ID: #'.$form->id;

			$str_attachment .= '<tr><td width="100">Form ID</td><td width="1">:</td><td><a href="'.get_site_url('form', $form->id).'" target="_blank">#'._b($form->id,false).' <i class="fa fa-external-link"></i></td></tr>';
			$str_attachment .= '<tr><td>Form Tarihi</td><td>:</td><td>'.substr($form->date,0,16).'</td></tr>';
			$str_attachment .= '<tr><td>Form Durumu</td><td>:</td><td>'.get_in_out_label($form->in_out).' Formu / '.$form_status->name.'</td></tr>';
			$str_attachment .= '<tr><td>Hesap Kartı</td><td>:</td><td>'.$form->account_name.'</td></tr>';
			$str_attachment .= '<tr><td>Ürün Sayısı</td><td>:</td><td>Ürün Çeşit '._b($form->item_count).' / Ürün Miktar '._b($form->item_quantity).'</td></tr>';
			$str_attachment .= '<tr><td>Form Tutarı</td><td>:</td><td>'.get_set_money($form->total, true).'</td></tr>';
		}
	} // isset($_GET['form_id'])

	// urun karti
	if(isset($_GET['item_id'])) {
		if($item = get_item($_GET['item_id'])) {

			$str_attachment_title 	= 'Ürün Kartı';
			$_message['title'] 		= 'Mesaj Eki - Ürün Kartı: '.$item->name;

			$str_attachment .= '<tr><td width="100">Ürün Adı</td><td width="1">:</td><td><a href="'.get_site_url('item', $item->id).'" target="_blank">'._b($item->name,false).' <i class="fa fa-external-link"></i></td></tr>';
			$str_attachment .= '<tr><td>Barkod Kodu</td><td>:</td><td>'.$item->code.'</td></tr>';
			$str_attachment .= '<tr><td>Miktar</td><td>:</td><td>'.$item->quantity.'</td></tr>';
			$str_attachment .= '<tr><td>Satış Fiyatı</td><td>:</td><td>'.get_set_money($item->p_sale, true).'</td></tr>';
		}
	} // isset($_GET['item_id'])

	// hesap karti
	if(isset($_GET['account_id'])) {
		if($account = get_account($_GET['account_id'])) {

			$str_attachment_title 	= 'Hesap Kartı';
			$_message['title'] 		= 'Mesaj Eki - Hesap Kartı: '.$account->name;

			$str_attachment .= '<tr><td width="100">Hesap Adı</td><td width="1">:</td><td><a href="'.get_site_url('account', $account->id).'" target="_blank">'._b($account->name,false).' <i class="fa fa-external-link"></i></td></tr>';
			$str_attachment .= '<tr><td>Hesap Kodu</td><td>:</td><td>'.$account->code.'</td></tr>';
			$str_attachment .= '<tr><td>Cep Telefonu</td><td>:</td><td>'.$account->gsm.'</td></tr>';
			$str_attachment .= '<tr><td>Sabit Telefon</td><td>:</td><td>'.$account->phone.'</td></tr>';
			$str_attachment .= '<tr><td>Şehir</td><td>:</td><td>'.$account->city.'</td></tr>';
			$str_attachment .= '<tr><td>Bakiye</td><td>:</td><td>'.get_set_money($account->balance,true).'</td></tr>';
		}
	} // isset($_GET['account_id'])

	// odeme formu
	if(isset($_GET['payment_id'])) {
		if($payment = get_payment($_GET['payment_id'])) {

			$str_attachment_title 	= 'Ödeme Formu';
			$_message['title'] 		= 'Mesaj Eki - Ödeme ID: #'.$payment->id;

			$str_attachment .= '<tr><td width="100">Form ID</td><td width="1">:</td><td><a href="'.get_site_url('payment', $payment->id).'" target="_blank">#'._b($payment->id,false).' <i class="fa fa-external-link"></i></td></tr>';
			$str_attachment .= '<tr><td>Form Tarihi</td><td>:</td><td>'.substr($payment->date,0,16).'</td></tr>';
			$str_attachment .= '<tr><td>Form Durumu</td><td>:</td><td>'.get_in_out_label($payment->in_out).' Formu</td></tr>';
			$str_attachment .= '<tr><td>Hesap Kartı</td><td>:</td><td>'.$payment->account_name.'</td></tr>';
			$str_attachment .= '<tr><td>Form Tutarı</td><td>:</td><td>'.get_set_money($payment->total, true).'</td></tr>';
		}
	} // isset($_GET['account_id'])

	$str_attachment .= $str_attachment_end;
	$str_attachment = str_replace('{TITLE}', $str_attachment_title, $str_attachment);

} //.isset($_GET['attachment'])


if(isset($_POST['add_task'])) {

	$_task['title']		= $_POST['title'];
	$_task['message']	= $_POST['message'];
	$_task['date_start']= $_POST['date_start'];
	$_task['date_end']	= $_POST['date_end'];
	$_task['choice']	= $_POST['choice'];

	if ( $insert_id = add_task($_POST['rec_u_id'], $_task) ) {
		header("Location: " . get_site_url('admin/user/task/detail.php?id='. $insert_id ));
	}
} //.isset($_POST)



?>
<?php print_alert(); ?>


<div class="row">
	<div class="col-md-3">

		<?php include('_sidebar.php'); ?>

	</div> <!-- /.col-md-3 -->
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-12">

				<!--/ ADD TASK /-->
				<form name="form_message" id="form_message" action="" method="POST" class="validate" autocomplete="off">
					<div class="row">
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading"><h4 class="panel-title">Görev Detayları</h4></div>
								<div class="panel-body">

									<div class="form-group">
										<input type="hidden" name="rec_u_id" id="rec_u_id" value="<?php echo @$rec_user->id; ?>" class="required">
										<label for="username">Alıcı</label>
										<input type="text" name="username" id="username" class="form-control required" value="<?php echo @$rec_user->display_name; ?>">
									</div> <!-- /.form-group -->

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="date_start"><i class="fa fa-calendar"></i> Başlama Tarihi</label>
												<input type="text" name="date_start" id="date_start" class="form-control required datetime" value="<?php echo date('Y-m-d H:i'); ?>">
											</div> <!-- /.form-group -->
										</div> <!-- /.col-md-6 -->
										<div class="col-md-6">
											<div class="form-group">
												<label for="date_end"><i class="fa fa-calendar"></i> Bitirme Tarihi</label>
												<input type="text" name="date_end" id="date_end" class="form-control required datetime" value="<?php echo date('Y-m-d H:i'); ?>">
											</div> <!-- /.form-group -->
										</div> <!-- /.col-md-6 -->
									</div> <!-- /.row -->
								</div> <!-- /.panel-body -->
							</div> <!-- /.panel -->

						</div> <!-- /.col-md-6 -->
						<div class="col-md-6">
							<div class="panel panel-primary">
								<div class="panel-heading"><h4 class="panel-title">Görev Seçenekleri</h4></div>
								<div class="panel-body">
									<div class="choice">

										<div class="form-group">
											<label for="choice-1">Seçenek 1</label>
											<input type="text" name="choice[]" id="choice-1" class="form-control" value="">
										</div> <!-- /.form-group -->
									</div> <!-- /.choice -->

									<div class="text-right"><button type="button" class="btn btn-default btn-xs" id="addChoice"><i class="fa fa-plus"></i> Seçenek Ekle</button></div>
								</div><!--/ .panel-body /-->
							</div> <!-- /.panel-default -->
						</div> <!-- /.col-md-6 -->
					</div> <!-- /.row -->

					<script>
					$(document).ready(function() {
						$('#addChoice').click(function() {
							var choice_element_count = parseInt(1+$('.choice .form-group').length);
							if(choice_element_count < 11) {
								var choice_element = '<div class="form-group"><label for="choice-'+choice_element_count+'">Seçenek '+choice_element_count+'</label><input type="text" name="choice[]" id="choice-'+choice_element_count+'" class="form-control" value=""></div>';
								$('.choice').append(choice_element);
							} else {
								alert('En fazla 10 adet seçenek ekleyebilirsiniz.');
							}
						});
					});
					</script>

					<div class="form-group">
						<label for="title">Görev Konusu</label>
						<input type="text" name="title" id="title" class="form-control required" value="<?php echo @$_POST['title']; ?>">
					</div> <!-- /.form-group -->

					<div class="row">
						<div class="col-md-12">
							<div class="form-group message-area">
								<label for="editor_message">Görev Açıklaması</label>
								<textarea name="message" id="message" class="form-control required hidden" minlength="5" placeholder="Birşeyler yazın..." style="height:100px;"><?php echo stripcslashes(@$_POST['message']); ?></textarea>

								<script>editor({selector: "#message", plugins: 'pre_html autolink nonbreaking save table textcolor colorpicker image textpattern', toolbar: 'bold italic underline forecolor backcolor image table', height: '160' });</script>
							</div> <!-- /.form-group -->

							<div class="row space-5">
								<div class="col-md-12">
									<?php if($str_attachment):?>
										<?php echo $str_attachment; ?>
									<?php endif; ?>
								</div> <!-- /.col-md-11 -->
							</div> <!-- /.row -->

							<div class="pull-right">
								<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
								<input type="hidden" name="add_task">
								<button class="btn btn-default"><i class="fa fa-send-o"></i> Gönder</button>
							</div> <!-- /.pull-right -->
						</div> <!-- /.col-md-10 -->
					</div> <!-- /.row -->
				</form>
				<!--/ ADD TASK /-->

			</div> <!-- /.col-md-12 -->
		</div> <!-- /.row -->
	</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->



<script>
$(document).ready(function() {

	var json_url = '<?php site_url("admin/user/getJSON.php"); ?>';
	var item = {
		name:'<span class="item_name">[TEXT]</span>',
		surname:' <span class="item_name">[TEXT]</span>'
	}

	input_getJSON_account('#username', 'user', item, json_url, 'name');

	$('#username').change(function() {
		$('#rec_u_id').val('');
	});
});


function user_getJSON_click(param) {
	var id 			= $(param).attr('data-id');
	var name 		= $(param).attr('data-name');
	var surname 	= $(param).attr('data-surname');

	$('#rec_u_id').val(id);
	$('#username').val(name+' '+surname);
}
</script>



<?php get_footer(); ?>
