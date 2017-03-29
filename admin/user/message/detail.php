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



add_page_info( 'title', $message->title );
add_page_info( 'nav', array('name'=>'Mesaj Kutusu', 'url'=>get_site_url('admin/user/message_box.php') ) );
add_page_info( 'nav', array('name'=>$rec_user->name.' '.$rec_user->surname) );


// tum mesajlari cevaplari ile birlikte cekelim
if(isset($_GET['id'])) {
	if(!empty($_GET['id'])) {
		$messages = array_reverse(get_message_detail($_GET['id'], array('limit' => 4)));
	}
}


// secili olan mesaj kutusu icin kontrolleri yapalim
if($message->inbox_u_id == get_active_user('id')) { $box = 'inbox'; }
if($message->outbox_u_id == get_active_user('id')) { $box = 'outbox'; }
if($message->sen_trash_u_id == get_active_user_id('id') or $message->rec_trash_u_id == get_active_user_id('id')) { $box = 'trash'; }

?>





<div class="row">
	<div class="col-md-3 hidden-xs">

		<?php include('_sidebar.php'); ?>

	</div> <!-- /.col-md-3 -->

	<div class="col-md-9 col-xs-12 pull-right">
		<?php print_alert(); ?>

		<div class="panel">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="chat-container">
							<div class="chat-list" id="<?php echo @$_GET['id'] ?>" js-onload="chat_list('message')">
								<?php if(@$messages): ?>
									<?php foreach($messages as $message): ?>
										<div class="message-elem  message-<?php echo $message->id; ?>" id="<?php echo $message->id; ?>" title="<?php echo $message->title; ?>" username="<?php echo get_user_info($message->sen_u_id, 'name'); ?> <?php echo get_user_info($message->sen_u_id, 'surname'); ?>">
											<div class="row space-5">
												<?php if(get_active_user('id') != $message->sen_u_id): ?>
													<div class="col-md-1 col-xs-3">
														<img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-right" width="48">
													</div> <!-- /.col-md-1.col-xs-3 /-->
												<?php endif; ?>

												<div class="col-md-11 col-xs-9">
													<div class="well padding-10 br-3">
														<div class="text-muted fs-11 italic">
															<span class="bold username"><?php echo get_user_info($message->sen_u_id, 'name'); ?> <?php echo get_user_info($message->sen_u_id, 'surname'); ?></span> <span class="inform-text">tarafından</span> <span class="bold date" data-wenk="<?php echo substr($message->date,0,16); ?>" title="<?php echo substr($message->date,0,16); ?>"><?php echo get_time_late($message->date); ?></span> <span class="inform-text">önce gönderildi.</span>
														</div><!--/ .text-muted /-->

														<?php echo $message->message; ?>
													</div><!--/ .well /-->
													<div class="h-10"></div>
												</div><!-- /.col-md-11.col-xs-9 /-->

												<?php if(get_active_user('id') == $message->sen_u_id): ?>
													<div class="col-md-1 col-xs-3">
														<img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive br-3 pull-left" width="48">
													</div><!-- /.col-md-1 /-->
												<?php endif; ?>
											</div><!-- /.row.space-5 /-->
										</div><!--/ .message-elem /-->
									<?php endforeach; ?>
								<?php endif; ?>
							</div><!--/ .chat-list /-->
						</div><!--/ .chat-container /-->


						<!--/ ADD MESSAGE REPLY /-->
						<form name="form_message" id="form_message" onsubmit="return send_message(this, 'message')" action="" method="POST">
							<div class="h-20"></div>
							<div class="row space-5">
								<div class="col-md-1 hidden">
									<label>&nbsp;</label>
									<div class="clearfix"></div>
									<?php if(get_active_user('avatar')): ?>
										<img src="<?php echo get_active_user('avatar'); ?>" class="img-responsive br-3 pull-right" width="64">
									<?php else: ?>
										<img src="<?php template_url('img/no-avatar.jpg'); ?>" class="img-responsive br-3 pull-right" width="64">
									<?php endif; ?>
								</div> <!-- /.col-md-1 -->
								<div class="col-md-11 col-xs-12">
									<div class="form-group message-area">
										<label for="message" class="text-muted hidden-xs"><?php echo _b($rec_user->name.' '.$rec_user->surname); ?> gönderilmek üzere bir mesaj yazın...</label>
										<textarea autofocus onkeydown="parent(this, 'form').dispatchEvent(new Event('submit', { 'bubbles' : true, 'cancelable' : true}));" name="message" id="message" class="form-control required" minlength="5" placeholder="Birşeyler yazın..." style="height:20px;"></textarea>
										<script>editor({selector: "#message", plugins: 'pre_html autolink nonbreaking save table textcolor colorpicker image textpattern', toolbar: 'bold italic underline forecolor backcolor image table', height: '100' });</script>
									</div> <!-- /.form-group -->

									<div class="form-group">
										<button type="submit" class="btn btn-default pull-right"><i class="fa fa-send-o"></i> Gönder</button>
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
			</div><!--/ .panel-body /-->
		</div><!--/ .panel /-->
	</div> <!-- /.col-md-9 /-->
</div> <!-- /.row /-->


<?php get_footer(); ?>
