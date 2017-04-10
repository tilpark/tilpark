<?php include('../../../tilpark.php'); ?>
<?php get_header(); ?>

<?php if(!isset($_GET['id'])) { echo get_alert('ID parametresi gerekli.', 'danger', false); get_footer(); exit; } ?>


<?php
if(isset($_GET['id'])) {

	if($task = get_task($_GET['id'])) {
		// secenekleri degiskene atayalim
		$choice = json_decode($task->choice);




		// bu görevi okundu yapalim
		if(get_active_user('id') == $task->inbox_u_id) {
			db()->query("UPDATE ".dbname('messages')." SET read_it='1' WHERE id='".$task->id."' ");
		}
	} else { echo get_alert('Görev ID veritabanında bulunamadı.', 'danger', false); get_footer(); exit; }


	if($task->sen_u_id == get_active_user('id')) {
		$_GET['rec_u_id'] = $task->rec_u_id;
	} else {
		$_GET['rec_u_id'] = $task->sen_u_id;
	}
}

// mesaja cevap verilecek ise cevap verilecek kullanıcı bilgileri
if(isset($_GET['rec_u_id'])) {
	$rec_user = get_user($_GET['rec_u_id']);
}


# cevap mesajı yazilmis ise
if(isset($_POST['reply_message'])) {
	$_message['message'] 	= $_POST['message'];
	$_message['top_id']		= $task->id;
	if(add_task_message($task->id, $_message)) {

	}
}



## secenekleri guncelemek icin
if(isset($_POST['save_choice'])) {
	$_choice = array();
	foreach($choice as $id=>$key) {
		if(isset($_POST['choice_'.$id])) {
			$_choice[$id]['is_it_done'] = 1;
			$_choice[$id]['date'] 		= date('Y-m-d H:i:s');
			$_choice[$id]['user_id']	= get_active_user('id');

			if ( $is_choice = json_decode(get_task($_GET['id'])->choice) ) {
				if ( $is_choice->$id->is_it_done == '1' ) { $_choice[$id]['date'] = $is_choice->$id->date; }
			}


			if(!$choice->$id->is_it_done) {
				$_message['insert']['message']	= '"<small class="text-muted italic">'.$choice->$id->text.'</small>" görevini '._b('yapıldı').' olarak işaretledi.';
				$_message['add_alert']	= false;
				$_message['uniquetime'] = get_uniquetime();
				add_task_message($task->id, $_message);
			}
		} else {
			$_choice[$id]['is_it_done'] = 0;
			if($choice->$id->is_it_done) {
				$_message['insert']['message']	= '"<small class="text-muted italic">'.$choice->$id->text.'</small>" görevini '._b('yapılmadı').' olarak işaretledi.';
				$_message['add_alert']	= false;
				$_message['uniquetime'] = get_uniquetime();
				add_task_message($task->id, $_message);
			}
		}

		$_choice[$id]['text']		= $key->text;
	}
	$_choice = json_encode_utf8($_choice);




	if(db()->query("UPDATE ".dbname('messages')." SET choice='".$_choice."'  WHERE id='".$task->id."'")) {
		if(db()->affected_rows) {
			add_alert('Görev seçenekleri güncellendi.', 'success');
			$task = get_task($task->id);

			// secenekleri degiskene tekrar atayalim
			$choice = json_decode($task->choice);

			# eger gorev kapatilmis ise ve tamamlanmayan gorev secenegi var ise
			if($task->type_status == '1' and $task->choice_open) {
				$_task = array();
				$_task['update']['type_status'] = '0';
				$_task['uniquetime'] = get_uniquetime();
				$_task['add_log'] = false;
				$_task['add_alert'] = false;
				if(update_task($task->id, $_task)) {
					add_alert('Tamamlanmamış görev bulunduğundan, görev tekrar açıldı.', 'warning');
					$task = get_task($task->id);
				}
			}
		}
	} else { add_mysqli_error_log(); }
}


## gorev detaylarini guncelle
if(isset($_POST['update_detail']) and $task->sen_u_id == get_active_user('id')) {
	$_task = array();
	$_task['date_start'] 	= $_POST['date_start'];
	$_task['date_end']		= $_POST['date_end'];

	# guncelleme islemine baslayalim
	if(update_task($task->id, $_task)) {

		if($_task['date_end'].':00' != $task->date_end) {
			$_message = array();
			$_message['insert']['message'] = 'Görev bitirme tarihini '._b($_task['date_end']).' olarak değiştirdi.';
			$_message['add_log'] 	= false;
			$_message['add_alert'] 	= false;
			$_message['uniquetime'] = get_uniquetime();
			add_task_message($task->id, $_message);
		}

		$task = get_task($task->id);
	}
}



## gorev kapat veya tekrar ac
if(isset($_GET['type_status'])) {
	if($_GET['type_status'] == '0' or $_GET['type_status'] == '1') {

		if($_GET['type_status'] == '1' and $task->choice_open)	{ // gorev kapatiliyor ve acikta gorev secenegi var ise
 			add_alert('Kapatılmamış görev seçenekleri olduğundan, bu görevi kapatılamaz.', 'warning', 'type_status');
		} else {
			$_task = array();
			$_task['type_status'] = $_GET['type_status'];
			if(update_task($task->id, $_task)) {
				$task = get_task($task->id);

				# mesaj kutusuna mesaj ekleyelim
				$_message = array();
				if($_GET['type_status'] == '0') {
					$_message['insert']['message'] = 'Bu görev tarafımdan tekrar aktif edildi.';
				} elseif($_GET['type_status'] == '1') {
					$_message['insert']['message'] = 'Bu görev tarafımdan kapatıldı.'; }

				$_message['add_alert']	= false;
				$_message['uniquetime'] = get_uniquetime();

				if ( add_task_message($task->id, $_message) ) {
					header('Location: '. get_set_url_parameters(array('remove' => array('type_status' => ''))));
				}
			}
		}
	} else { add_alert('Görev durumu sadece "0" veya "1" değerlerine sahip olabilir.', 'warning', 'type_status'); }
}


# secili olan mesaj icin $box degiskenine deger atayalim
if($task->rec_u_id == get_active_user('id')) { $box = 'inbox'; }
if($task->sen_u_id == get_active_user('id')) { $box = 'outbox'; }
if($task->sen_trash_u_id == get_active_user_id('id') or $task->rec_trash_u_id == get_active_user_id('id')) { $box = 'trash'; }

add_page_info( 'title', $task->title );
add_page_info( 'nav', array('name'=>'Görev Kutusu', 'url'=>get_site_url('admin/user/task/list.php?box='.$box) ) );
add_page_info( 'nav', array('name'=>$rec_user->name.' '.$rec_user->surname) );


## tum mesajlari cevaplari ile birlikte cekelim
if(isset($_GET['id'])) {


	$messages = array_reverse(get_message_detail($_GET['id'], array('limit' => 10)));
}




# secili olan mesaj icin $type_status degiskenine deger atayalim
if($task->type_status == '0') { $type_status = '0'; } else { $type_status = '1'; }


?>





<div class="row">
	<div class="col-md-3 hidden-xs">

		<?php include('_sidebar.php'); ?>

	</div> <!-- /.col-md-3 -->
	<div class="col-md-9">

		<?php print_alert(); ?>

		<div class="row">
			<div class="col-md-4">
				<form name="form_detail" id="form_detail" action="?id=<?php echo $task->id; ?>" method="POST">
					<div class="panel panel-default">
						<div class="panel-heading"><h4 class="panel-title">Görev Detayları</h4></div>
						<div class="panel-body">

							<div class="form-group">
								<label for="sen_user_display_name">Görevi Atayan</label>
								<input type="text" name="sen_user_display_name" id="sen_user_display_name" class="form-control" value="<?php user_info($task->sen_u_id, 'display_name'); ?>" readonly>
							</div> <!-- /.form-group -->

							<div class="form-group">
								<label for="rec_user_display_name">Görevi Atanan</label>
								<input type="text" name="rec_user_display_name" id="rec_user_display_name" class="form-control" value="<?php user_info($task->rec_u_id, 'display_name'); ?>" readonly>
							</div> <!-- /.form-group -->

							<div class="row space-5">
								<div class="col-md-6">
									<div class="form-group">
										<label for="date_start">Başlama Tarihi</label>
										<input type="text" name="date_start" id="date_start" class="form-control datetime" value="<?php echo til_get_date($task->date_start, 'datetime'); ?>" <?php if($task->sen_u_id != get_active_user('id')): ?>  <?php endif; ?> >
									</div> <!-- /.form-group -->
								</div> <!-- /.col-md-6 -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="date_end">Bitirme Tarihi</label>
										<input type="text" name="date_end" id="date_end" class="form-control datetime" value="<?php echo til_get_date($task->date_end, 'datetime'); ?>" <?php if($task->sen_u_id != get_active_user('id')): ?>  <?php endif; ?> >
									</div> <!-- /.form-group -->
								</div> <!-- /.col-md-6 -->
							</div> <!-- /.row -->

							<?php if(get_active_user('id') == $task->sen_u_id): ?>
								<input type="hidden" name="update_detail">
								<input type="hidden" name="uniquetime" id="uniquetime_detail" value="<?php uniquetime(); ?>">
								<div class="text-right"><button class="btn btn-default"><i class="fa fa-save"></i> Kaydet</button></div>
							<?php endif; ?>


							<hr />
							<div class="text-right">
								<?php if($task->type_status == '0'): ?>
									<a href="?id=<?php echo $task->id; ?>&type_status=1" class="btn btn-default"><i class="fa fa-check-square-o"></i> Görevi Kapat</a>
								<?php else: ?>
									<a href="?id=<?php echo $task->id; ?>&type_status=0" class="btn btn-default"><i class="fa fa-check-square-o"></i> Görevi Tekrar Aç</a>
								<?php endif; ?>
							</div> <!-- /.text-right -->
						</div> <!-- /.panel-body -->
					</div> <!-- /.panel -->
				</form>
			</div> <!-- /.col-md-4 -->
			<div class="col-md-8">

				<div class="panel panel-default">
					<div class="panel-heading"><h4 class="panel-title">Görev Seçenekleri</h4></div>

					<div class="panel-body">
						<?php if(!empty($choice) and is_object($choice)): ?>
							<?php
								/* progress-bar */
								$choice_completed = 0;
								foreach($choice as $id=>$arr) {
									if($arr->is_it_done) {
										$choice_completed++;
									}
								} // foreach

								$choice_count 	= count((array)$choice);
								$part 			= (100 / $choice_count);
								$part_completed = round($part * $choice_completed);

								# progress-bar style
								$progressbar_style = '';
								if($part_completed < 30) {
									$progressbar_style = 'progress-bar-danger';
								} elseif($part_completed < 70) {
									$progressbar_style = 'progress-bar-warning';
								} else {
									$progressbar_style = 'progress-bar-success';
								}
							?>

							<div class="progress">
								<div class="progress-bar progress-bar-stripedd <?php echo $progressbar_style; ?>" role="progressbar" aria-valuenow="<?php echo $part_completed; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $part_completed; ?>%;">
									<span class="sr-only"><?php echo $part_completed; ?>% tamamlandı</span>
									%<?php echo $part_completed; ?> tamamlandı
								</div> <!-- /.progess-bar -->
							</div> <!-- /.progress -->

							<form name="form" id="form" action="?id=<?php echo $task->id; ?>" method="POST">
								<ul class="list-group">
									<?php foreach($choice as $id=>$arr): ?>
										<label class="list-group-item">
											<?php echo $arr->text; ?>
											<div class="h-10"></div>

											<div class="text-right">
												<?php if($arr->is_it_done): ?>
													<i class="fa fa-check text-warning"></i> <small class="text-muted italic"><span data-wenk="<?php echo substr($arr->date,0,16); ?>"><?php echo get_time_late($arr->date); ?> önce</span> <?php user_info($arr->user_id, 'display_name'); ?> tarafından tamamlandı.</small>
												<?php endif; ?>

												<input type="checkbox" name="choice_<?php echo $id; ?>" id="choice_<?php echo $id; ?>" <?php if($arr->is_it_done): ?>checked<?php endif; ?> class="toogle" data-size="mini" data-on-text="Evet" data-off-text="Hayır">
											</div><!--/ .text-right /-->
										</label><!--/ .list-group-item /-->
									<?php endforeach; ?>
								</ul> <!-- /.list-group -->
								<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
								<input type="hidden" name="save_choice">
								<div class="text-right"><button class="btn btn-default"><i class="fa fa-save"></i> Kaydet</button></div>
							</form>

						<?php else: ?>
							<?php echo get_alert('Bu görev için seçenek bulunamadı. <br /> Görevi tamamlamak için lütfen gelen mesaj metnini okuyunuz.', 'info', false); ?>
						<?php endif; ?>
					</div> <!-- /.panel-body /-->
				</div> <!-- /.panel /-->
			</div> <!-- /.col-md-8 /-->
		</div> <!-- /.row /-->

		<div class="panel">
			<div class="panel-body" style="paddig-bottom: 0;">
				<div class="row">
					<div class="col-md-12">
						<div class="chat-container">
							<div class="chat-list" id="<?php echo @$_GET['id'] ?>" js-onload="chat_list('task')">
								<?php if(@$messages): ?>
									<?php foreach($messages as $message): ?>
										<div class="message-elem  message-<?php echo $message->id; ?>" id="<?php echo $message->id; ?>" title="<?php echo $message->title; ?>" username="<?php echo get_user_info($message->sen_u_id, 'name'); ?> <?php echo get_user_info($message->sen_u_id, 'surname'); ?>">
											<div class="message-elem-container">
												<?php if(get_active_user('id') != $message->sen_u_id): ?>
														<div class="message-elem-avatar pull-left">
															<img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-right" width="48">
														</div><!--/ .message-elem-avatar /-->
												<?php endif; ?>

												<div class="message-elem-content">
													<div class="well padding-10 br-3">
														<div class="text-muted fs-11 italic">
															<span class="bold username"><?php echo get_user_info($message->sen_u_id, 'name'); ?> <?php echo get_user_info($message->sen_u_id, 'surname'); ?></span> <span class="inform-text">tarafından</span> <span class="bold date-tooltip" <?php if ( til_is_mobile() ) { echo 'data-wenk-pos="left"'; } ?> data-wenk="<?php echo substr($message->date,0,16); ?>" title="<?php echo substr($message->date,0,16); ?>"><?php echo get_time_late($message->date); ?></span> <span class="inform-text">önce gönderildi.</span>
														</div><!--/ .text-muted /-->

														<?php echo $message->message; ?>
													</div><!--/ .well /-->
													<div class="h-10"></div>
												</div><!-- /.col-md-11.col-xs-9 /-->

												<?php if(get_active_user('id') == $message->sen_u_id): ?>
													<div class="message-elem-avatar pull-right">
														<img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-right" width="48">
													</div><!--/ .message-elem-avatar /-->
												<?php endif; ?>
											</div><!-- /.row.space-5 /-->
										</div><!--/ .message-elem /-->
									<?php endforeach; ?>
								<?php endif; ?>
							</div><!--/ .chat-list /-->
						</div><!--/ .chat-container /-->

						<!--/ TASK REPLY /-->
						<form name="form_message" id="form_message" onsubmit="return send_message(this, 'task')" js-onload="window.set_writing.top_id = '<?php echo $_GET['id'] ; ?>';" action="" autocomplete="off" method="POST">
							<div class="row space-5">
								<div class="col-md-1 hidden-xs">
									<label>&nbsp;&nbsp;</label>
									<div class="clearfix"></div>
									<?php if(get_active_user('avatar')): ?>
										<img src="<?php echo get_active_user('avatar'); ?>" class="img-responsive br-3 pull-right" width="64">
									<?php else: ?>
										<img src="<?php template_url('img/no-avatar.jpg'); ?>" class="img-responsive br-3 pull-right" width="64">
									<?php endif; ?>
								</div> <!-- /.col-md-1 -->

								<div class="col-md-11 col-xs-12">
									<?php if ( til_is_mobile() ) : ?>
										<div class="form-group message-area chat-input">
											<div class="user-input-control" js-onload="get_writing('.user-input-control')">
												<div class="user-input-control-animate-container">
													<div class="circle"></div>
													<div class="circle"></div>
													<div class="circle"></div>
												</div>
											</div><!--/ .user-input-control /-->

											<input autofocus type="text" onkeypress="if ( this.value.length > 0 ) { set_writing({'set_value': '1'}); } if ( event.keyCode == 13 ) { set_writing({'set_value': '0'}); } if ( event.keyCode == 8 ) { set_writing({'set_value': '2'}); } if ( this.value.length == 0 ) { set_writing({'set_value': '0'}); }" onfocusout="set_writing({'set_value': '0'})" onfocus="set_writing({'set_value': '1'})" name="message" id="message" required class="form-control send-message-input" value="" placeholder="Birşeyler yazın...">
											<button type="button" class="send-message-image" onclick="document.getElementById('send-message-file').click()"><i class="fa fa-image"></i></button>
											<button type="submit" class="send-message-submit" onclick="document.getElementById('message').focus(); set_writing({'set_value': '1'});"><i class="fa fa-send"></i></button>
											<input type="file" name="" id="send-message-file" onchange="var chat_list = document.querySelector('.chat-container'); chat_list.classList.add('loader'); imageHandler(this.files[0], function(data) { if ( data == false ) { chat_list.classList.remove('loader'); } else { if ( document.getElementById('message').value = '<img src='+ data +' class=img-responsive>' ) { chat_list.classList.remove('loader'); document.querySelector('.send-message-submit').click(); } } });" value="" class="hidden">
										</div><!--/ .form-group.message-area.chat-input /-->
									<?php else: ?>
										<div class="form-group message-area">
											<div class="user-input-control" js-onload="get_writing('.user-input-control')">
												<div class="user-input-control-animate-container">
													<div class="circle"></div>
													<div class="circle"></div>
													<div class="circle"></div>
												</div><!--/ .user-input-control-animate-container /-->
											</div><!--/ .user-input-control /-->

											<label for="message" class="text-muted"><?php echo _b($rec_user->name.' '.$rec_user->surname); ?> gönderilmek üzere bir mesaj yazın...</label>
											<textarea autofocus onkeypress="set_writing({'set_value': '1'});" onfocusout="set_writing({'set_value': '0'})" onfocus="set_writing({'set_value': '1'})" onkeydown="set_writing({'set_value': '0'}); parent(this, 'form').dispatchEvent(new Event('submit', { 'bubbles' : true, 'cancelable' : true}));" name="message" id="message" class="form-control required" minlength="5" placeholder="Birşeyler yazın..." style="height:20px;"></textarea>
											<script>editor({selector: "#message", plugins: 'autolink nonbreaking table textcolor colorpicker image textpattern link', toolbar: 'bold italic underline forecolor backcolor image table link', height: '100', onfocus: true, onfocusout: true, onkeypress: true });</script>
											<script type="text/javascript"></script>
										</div><!--/ .form-group.message-area /-->
									<?php endif; ?>

									<div class="pull-right">
									<button type="submit" class="btn btn-default pull-right hidden-xs"><i class="fa fa-send-o"></i> Gönder</button>
										<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
										<input type="hidden" name="reply_message">
										<input type="hidden" name="task_id" id="task_id" value="<?php echo @$_GET['id']; ?>">
										<input type="hidden" name="top_id" id="top_id" value="<?php echo @$_GET['id']; ?>">
									</div> <!-- /.pull-right /-->
								</div> <!-- /.col-md-11 /-->
							</div> <!-- /.row /-->
						</form>
						<!--/ TASK REPLY /-->
					</div> <!-- /.col-md-12 /-->
				</div> <!-- /.row /-->
			</div><!--/ .panel-body /-->
		</div><!--/ .panel /-->
	</div> <!-- /.col-md-9 /-->
</div> <!-- /.row /-->

<?php get_footer(); ?>
