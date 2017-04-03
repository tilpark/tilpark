<?php include('../../../tilpark.php'); ?>
<?php get_header(); ?>

<?php if(!isset($_GET['id'])) { echo get_alert('ID parametresi gerekli.', 'danger', false); get_footer(); exit; } ?>
<?php if(empty($_GET['id'])) { echo get_alert('ID parametresi boş olamaz.', 'danger', false); get_footer(); exit; } ?>


<?php
if(isset($_GET['id'])) {
	if($message = get_message($_GET['id'])) {

		$_message['top_id'] = $message->id;

		// mesajlari okundu yapalim
		if(get_active_user('id') == $message->inbox_u_id) {
			db()->query("UPDATE ".dbname('messages')." SET read_it='1' WHERE id='".$message->id."' ");
		}
	} else {
		echo get_alert(_b($_GET['id']).' Mesaj ID veritabanında <u>bulunamadı</u>.', 'danger', false); get_footer(); exit;
	}


	if($message->sen_u_id == get_active_user('id')) {
		$_GET['rec_u_id'] = $message->rec_u_id;
	} else {
		$_GET['rec_u_id'] = $message->sen_u_id;
	}
}

// mesaja cevap verilecek ise cevap verilecek kullanıcı bilgileri
if(isset($_GET['rec_u_id'])) {
	$rec_user = get_user($_GET['rec_u_id']);
}


// cevap mesajı yazilmis ise
if(isset($_POST['reply_message'])) {
	$_message['message'] 		= $_POST['message'];
	$_message['top_id']			= $message->id;
	if(add_message($rec_user->id, $_message)) {

	}
}



// tum mesajlari cevaplari ile birlikte cekelim
if(isset($_GET['id'])) {
	if(!empty($_GET['id'])) {
		$messages = array_reverse(get_message_detail($_GET['id'], array('limit' => 10)));
	}
}



// secili olan mesaj kutusu icin kontrolleri yapalim
if($message->inbox_u_id == get_active_user('id')) { $box = 'inbox'; }
if($message->outbox_u_id == get_active_user('id')) { $box = 'outbox'; }
if($message->sen_trash_u_id == get_active_user_id('id') or $message->rec_trash_u_id == get_active_user_id('id')) { $box = 'trash'; }

add_page_info( 'title', $message->title );
add_page_info( 'nav', array('name'=>'Mesaj Kutusu', 'url'=>get_site_url('admin/user/message/list.php?box='.$box) ) );
add_page_info( 'nav', array('name'=>$rec_user->name.' '.$rec_user->surname) );

// add_notification(array('rec_u_id' => '1', 'title' => 'icon', 'message' => 'http://tilpark.org', 'writing' => 'fa fa-facebook'));




?>





<div class="row">
	<div class="col-md-3 hidden-xs">

		<?php include('_sidebar.php'); ?>

	</div> <!-- /.col-md-3 -->

	<div class="col-md-9 col-xs-12 pull-right">
		<?php print_alert(); ?>

		<div class="panel">
			<div class="panel-body" style="paddig-bottom: 0;">
				<div class="row">
					<div class="col-md-12">
						<div class="chat-container">
							<div class="chat-list" id="<?php echo @$_GET['id'] ?>" js-onload="chat_list('message')">
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
											</div><!-- /.message-elem-container /-->
										</div><!--/ .message-elem /-->
									<?php endforeach; ?>
								<?php endif; ?>
							</div><!--/ .chat-list /-->
						</div><!--/ .chat-container /-->


						<!--/ ADD MESSAGE REPLY /-->
						<form name="form_message" id="form_message" onsubmit="return send_message(this, 'message')" js-onload="window.set_writing.top_id = '<?php echo $_GET['id'] ; ?>';" autocomplete="off" action="" method="POST">
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
											<button type="submit" class="send-message-submit" onclick="document.getElementById('message').focus(); set_writing({'set_value': '0'});"><i class="fa fa-send"></i></button>
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
											<script>editor({selector: "#message", plugins: 'pre_html autolink nonbreaking save table textcolor colorpicker image textpattern', toolbar: 'bold italic underline forecolor backcolor image table', height: '100', onfocus: true, onfocusout: true, onkeypress: true });</script>
											<script type="text/javascript"></script>
										</div><!--/ .form-group.message-area /-->
									<?php endif; ?>

									<div class="form-group hidden-xs">
										<button type="submit" class="btn btn-default pull-right hidden-xs"><i class="fa fa-send-o"></i> Gönder</button>
										<input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
										<input type="hidden" name="reply_message">
										<input type="hidden" name="receiver" id="receiver" value="<?php echo $rec_user->id; ?>">
										<input type="hidden" name="top_id" id="top_id" value="<?php echo @$_GET['id']; ?>">
									</div><!--/ .from-group/-->
								</div> <!-- /.col-md-11 -->
							</div> <!-- /.row -->
						</form>
						<!--/ ADD MESSAGE REPLY /-->
					</div> <!-- /.col-md-12 /-->
				</div> <!-- /.row /-->
			</div> <!--/ .panel-body /-->
		</div><!--/ .panel /-->
	</div> <!-- /.col-md-9 /-->
</div> <!-- /.row /-->


<?php get_footer(); ?>
