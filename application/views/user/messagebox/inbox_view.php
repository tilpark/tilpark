<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('user/messagebox'); ?>">Mesaj Kutusu</a></li>
  <li class="active"><?php echo $message['title']; ?></li>
</ol>





<?php
$sender_user = get_user($message['sender_user_id']);
$receiver_user = get_user($message['receiver_user_id']);
$user[$sender_user['id']] = $sender_user;
$user[$receiver_user['id']] = $receiver_user;
?>

<div class="messagebox single">

	<div class="row">
		<div class="col-md-1">
			<a href="<?php echo site_url('user/profile/'.$sender_user['id']); ?>" class="img-thumbnail">
				<img src="<?php echo base_url('uploads/avatar/'.$sender_user['avatar']); ?>" class="img-responsive" />
			</a>
		</div> <!-- /.col-md-1 -->
		<div class="col-md-11">
			<h3><?php echo $message['title']; ?></h3>

			<p class="sub">
				<small class="text-muted pull-right"><?php echo $message['date']; ?></small>
				<a href="<?php echo site_url('user/profile/'.$sender_user['id']); ?>" class="text-muted"><small class="pull-left"><?php echo $sender_user['name_surname']; ?></small></a>
				<div class="clearfix"></div>
			</p>
			
			<p class="messagebox-content">
				<?php echo $message['content']; ?>
			</p>
			
			<div class="bodyLine"></div>
			<div class="h20"></div>
		</div> <!-- /.col-md-11 -->
	</div> <!-- /.row -->

	<?php
	// mesajı okundu olarak işaretle
	if($message['read_id'] == get_the_current_user('id'))
	{
		$this->db->where('id', $message['id']);
		$this->db->update('messagebox', array('read'=>'1'));
	}
	?>


	<?php
	$this->db->where('messagebox_id', $message['id']);
	$this->db->order_by('id', 'ASC');
	$query = $this->db->get('messagebox')->result_array();
	?>

	<div class="relply_message">
		<?php foreach($query as $reply_message): ?>

		<div class="row">
			<div class="col-md-1">
				<a href="<?php echo site_url('user/profile/'.$reply_message['sender_user_id']); ?>" class="img-thumbnail">
					<img src="<?php echo base_url('uploads/avatar/'.$user[$reply_message['sender_user_id']]['avatar']); ?>" class="img-responsive" />
				</a>
			</div> <!-- /.col-md-2 -->
			<div class="col-md-11">
				<p class="sub">
					<small class="text-muted pull-right"><?php echo $reply_message['date']; ?></small>
					<a href="<?php echo site_url('user/profile/'.$sender_user['id']); ?>" class="text-muted"><small class="pull-left"><?php echo $user[$reply_message['sender_user_id']]['name_surname']; ?></small></a>
					<div class="clearfix"></div>
				</p>
				<p class="messagebox-content">
					<?php echo $reply_message['content']; ?>
				</p>
				
				<div class="bodyLine"></div>
				<div class="h20"></div>
			</div> <!-- /.col-md-11 -->
		</div> <!-- /.row -->
		<?php
		// mesajı okundu olarak işaretle
		if($reply_message['receiver_user_id'] == get_the_current_user('id'))
		{
			$this->db->where('id', $reply_message['id']);
			$this->db->update('messagebox', array('read'=>'1'));
		}
		?>
		<?php endforeach; ?>
	</div> <!-- /.relpy_message -->

</div> <!-- /.messagebox -->

<div class="h40"></div>
<div class="widget-blank"><h4>Mesajı cevapla</h4></div>
<div class="widget-body">
	<form name="form_reply" id="form_reply" action="" method="POST">
		<p class="text-danger"><?php echo get_the_current_user('name'); ?> <?php echo get_the_current_user('surname'); ?> olarak bu mesajı cevapla</p>
	    <textarea id="summernote" name="content"></textarea>
	    <script>
			  $(document).ready(function() {
				  $('#summernote').summernote({
				  	height: 200, 
				  	theme: 'monokai',
				});
				
				$('.denenbuton').click(function() {
					var content = $('textarea[name="content"]').html($('#summernote').code());
				});
			});
	    </script>

		<div class="h20"></div>
		<input type="hidden" name="microtime" value="<?php echo logTime(); ?>" />
	    <input type="hidden" name="reply_message">
		<button type="submit" class="btn btn-default"><i class="fa fa-envelope-o"></i> Gönder</button>
	</form>
</div> <!-- /.widget-body -->



