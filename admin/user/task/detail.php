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



add_page_info( 'title', $task->title );
add_page_info( 'nav', array('name'=>'Görev Kutusu', 'url'=>get_site_url('admin/user/task/list.php') ) );
add_page_info( 'nav', array('name'=>$rec_user->name.' '.$rec_user->surname) );


## tum mesajlari cevaplari ile birlikte cekelim
if(isset($_GET['id'])) {
	$messages = get_task_detail($_GET['id']);
}


# secili olan mesaj icin $box degiskenine deger atayalim
if($task->rec_u_id == get_active_user('id')) { $box = 'inbox'; }
if($task->sen_u_id == get_active_user('id')) { $box = 'outbox'; }
if($task->sen_trash_u_id == get_active_user_id('id') or $task->rec_trash_u_id == get_active_user_id('id')) { $box = 'trash'; }

# secili olan mesaj icin $type_status degiskenine deger atayalim
if($task->type_status == '0') { $type_status = '0'; } else { $type_status = '1'; }
?>





<div class="row">
	<div class="col-md-3">

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
										<input type="text" name="date_start" id="date_start" class="form-control datetime" value="<?php echo til_get_date($task->date_start, 'datetime'); ?>" <?php if($task->sen_u_id != get_active_user('id')): ?> disabled <?php endif; ?> >
									</div> <!-- /.form-group -->
								</div> <!-- /.col-md-6 -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="date_end">Bitirme Tarihi</label>
										<input type="text" name="date_end" id="date_end" class="form-control datetime" value="<?php echo til_get_date($task->date_end, 'datetime'); ?>" <?php if($task->sen_u_id != get_active_user('id')): ?> disabled <?php endif; ?> >
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
										<li class="list-group-item">

											<?php echo $arr->text; ?>
											<div class="h-10"></div>

											<div class="text-right">
												<?php if($arr->is_it_done): ?>
													<i class="fa fa-check text-warning"></i> <small class="text-muted italic"><span data-toggle="tooltip" title="<?php echo substr($arr->date,0,16); ?>"><?php echo get_time_late($arr->date); ?> önce</span> <?php user_info($arr->user_id, 'display_name'); ?> tarafından tamamlandı.</small>
												<?php endif; ?>
												<input type="checkbox" name="choice_<?php echo $id; ?>" id="choice_<?php echo $id; ?>" <?php if($arr->is_it_done): ?>checked<?php endif; ?> class="toogle" data-size="mini" data-on-text="Evet" data-off-text="Hayır">
											</div>

										</li>
									<?php endforeach; ?>
								</ul> <!-- /.list-group -->

								<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
								<input type="hidden" name="save_choice">
								<div class="text-right"><button class="btn btn-default"><i class="fa fa-save"></i> Kaydet</button></div>
							</form>
						<?php else: ?>
							<?php echo get_alert('Bu görev için seçenek bulunamadı. <br /> Görevi tamamlamak için lütfen gelen mesaj metnini okuyunuz.', 'info', false); ?>
						<?php endif; ?>
					</div> <!-- /.panel-body -->
				</div> <!-- /.panel -->
			</div> <!-- /.col-md-8 -->
		</div> <!-- /.row -->


		<div class="panel">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<?php if(@$messages): ?>
							<?php foreach($messages as $message): ?>
								<div class="row space-5">
									<?php if(get_active_user('id') != $message->sen_u_id): ?>
										<div class="col-md-1">
											<img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-right" width="48">
										</div> <!-- /.col-md-1 -->
									<?php endif; ?>
									<div class="col-md-11">

										<div class="well padding-10 br-3">
											<div class="text-muted fs-11 italic">
												<span class="bold"><?php echo get_user_info($message->sen_u_id, 'name'); ?> <?php echo get_user_info($message->sen_u_id, 'surname'); ?></span> tarafından <span class="bold"><?php echo get_time_late($message->date); ?></span> önce gönderildi.
											</div>
											<?php echo stripslashes($message->message); ?>
										</div>
										<div class="h-10"></div>
									</div> <!-- /.col-md-11 -->
									<?php if(get_active_user('id') == $message->sen_u_id): ?>
										<div class="col-md-1">
											<img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-left" width="48">
										</div> <!-- /.col-md-1 -->
									<?php endif; ?>
								</div> <!-- /.row -->
							<?php endforeach; ?>
						<?php endif; ?>

						<!--/ TASK REPLY /-->
						<form name="form_message" id="form_message" action="" method="POST">
							<div class="row space-5">
								<div class="col-md-1">
									<label>&nbsp;</label>
									<div class="clearfix"></div>
									<?php if(get_active_user('avatar')): ?>
										<img src="<?php echo get_active_user('avatar'); ?>" class="img-responsive br-3 pull-right" width="64">
									<?php else: ?>
										<img src="<?php template_url('img/no-avatar.jpg'); ?>" class="img-responsive br-3 pull-right" width="64">
									<?php endif; ?>
								</div> <!-- /.col-md-1 -->
								<div class="col-md-11">

									<div class="form-group">
										<label for="message" class="text-muted"><?php echo _b($rec_user->name.' '.$rec_user->surname); ?> gönderilmek üzere bir mesaj yazın...</label>
										<textarea name="message" id="message" class="form-control required" minlength="5" placeholder="Birşeyler yazın..." style="height:100px;"></textarea>
										<script>editor({selector: "#message", plugins: 'pre_html autolink nonbreaking save table textcolor colorpicker image textpattern', toolbar: 'bold italic underline forecolor backcolor image table', height: '160' });</script>
									</div> <!-- /.form-group -->

									<div class="pull-right">
										<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
										<input type="hidden" name="reply_message">
										<button class="btn btn-default"><i class="fa fa-send-o"></i> Gönder</button>
									</div> <!-- /.pull-right -->
								</div> <!-- /.col-md-11 -->
							</div> <!-- /.row -->
						</form>
						<!--/ TASK REPLY /-->

					</div> <!-- /.col-md-12 -->
				</div> <!-- /.row -->
			</div><!--/ .panel-body /-->
		</div><!--/ .panel /-->
	</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php get_footer(); ?>
