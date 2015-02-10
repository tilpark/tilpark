<?php
$sender_user = get_user($message['sender_user_id']);
$receiver_user = get_user($message['receiver_user_id']);
$user[$sender_user['id']] = $sender_user;
$user[$receiver_user['id']] = $receiver_user;
?>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('user/messagebox'); ?>">Mesaj Kutusu</a></li>
  <li class="active"><?php echo $message['title']; ?></li>
</ol>



<?php if($message['delete_sender'] == '0' and $message['sender_user_id'] == get_the_current_user('id')): ?>
	<?php alertbox('alert-danger', 'Bu mesaj silinmiş.', 'Bu mesaj çöp kutusuna taşınmış. Mesajı geri yükleyebilirsin.', false); ?>
<?php endif; ?>
<?php if($message['delete_receiver'] == '0' and $message['receiver_user_id'] == get_the_current_user('id')): ?>
	<?php alertbox('alert-danger', 'Bu mesaj silinmiş.', 'Bu mesaj çöp kutusuna taşınmış. Mesajı geri yükleyebilirsin.', false); ?>
<?php endif; ?>



<div class="messagebox single">
	<h3><?php echo $message['title']; ?> | <small><?php echo $sender_user['name_surname']; ?>:<?php echo $receiver_user['name_surname']; ?></small></h3>
	<div class="row">
		<div class="col-md-1 col-xs-2">
			<a href="<?php echo site_url('user/profile/'.$sender_user['id']); ?>" class="img-thumbnail">
				<img src="<?php echo base_url('uploads/avatar/thumb_height_'.$sender_user['avatar']); ?>" class="img-responsive" />
			</a>
		</div> <!-- /.col-md-1 -->
		<div class="col-md-11 col-xs-10">
			<div class="widget-body white radius-0">
                <div class="sub">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <a href="<?php echo site_url('user/profile/'.$message['sender_user_id']); ?>" class="color-3"><small><i class="fa fa-user"></i> <?php echo $user[$message['sender_user_id']]['name_surname']; ?></small></a> <small class="text-muted">diyor ki</small>
                        </div> <!-- /.col-md-6 -->
                        <div class="col-md-6 col-xs-12 text-right hidden-xs hidden-sm">
                            <span class="text-muted">mesaj tarihi:</span> <small><?php echo $message['date']; ?></small> | <?php if($message['date_read'] == '0000-00-00 00:00:00'): ?><span class="text-danger">henüz okunmadı</span><?php else: ?><span class="text-muted">okunma tarihi:</span> <small><?php echo $message['date_read']; ?></small><?php endif; ?>
                        </div> <!-- /.col-md-6 -->
                    </div> <!-- /.row -->
                </div> <!-- /.sub -->
                <div class="messagebox-content">
                    <?php echo $message['content']; ?>
                </div>
			</div> <!-- /.widget-body.white -->
			<div class="h20"></div>
		</div> <!-- /.col-md-11 -->
	</div> <!-- /.row -->

	<?php
	// mesajı okundu olarak işaretle
	if($message['read_id'] == get_the_current_user('id') and $message['read'] == '0')
	{
		$this->db->where('id', $message['id']);
		$this->db->update('messagebox', array('read'=>'1', 'date_read'=>date('Y-m-d H:i:s')));
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
			<div class="col-md-1 col-xs-2">
				<a href="<?php echo site_url('user/profile/'.$reply_message['sender_user_id']); ?>" class="img-thumbnail">
					<img src="<?php echo base_url('uploads/avatar/thumb_height_'.$user[$reply_message['sender_user_id']]['avatar']); ?>" class="img-responsive" />
				</a>
			</div> <!-- /.col-md-2 -->
			<div class="col-md-11 col-xs-10">
            <div class="widget-body white radius-0">
                    <div class="sub">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <a href="<?php echo site_url('user/profile/'.$reply_message['sender_user_id']); ?>" class="color-3"><small><i class="fa fa-user"></i> <?php echo $user[$reply_message['sender_user_id']]['name_surname']; ?></small></a> <small class="text-muted">diyor ki</small>
                            </div> <!-- /.col-md-6 -->
                            <div class="col-md-6 text-right hidden-xs hidden-sm">
                                <span class="text-muted">mesaj tarihi:</span> <small><?php echo $reply_message['date']; ?></small> | <?php if($reply_message['date_read'] == '0000-00-00 00:00:00'): ?><span class="text-danger">henüz okunmadı</span><?php else: ?><span class="text-muted">okunma tarihi:</span> <small><?php echo $reply_message['date_read']; ?></small><?php endif; ?>
                            </div> <!-- /.col-md-6 -->
                        </div> <!-- /.row -->
                    </div> <!-- /.sub -->
                    
                    <div class="messagebox-content">
                        <p><?php echo $reply_message['content']; ?></p>
                    </div>
                </div> <!-- /.widget-body.white -->
				<div class="h20"></div>
			</div> <!-- /.col-md-11 -->
		</div> <!-- /.row -->
		<?php
		// mesajı okundu olarak işaretle
		if($reply_message['read_id'] == get_the_current_user('id') and $reply_message['read'] == '0')
		{
			$this->db->where('id', $reply_message['id']);
			$this->db->update('messagebox', array('read'=>'1', 'date_read'=>date('Y-m-d H:i:s')));
		}
		?>
		<?php endforeach; ?>
	</div> <!-- /.relpy_message -->
    
    
    

    

</div> <!-- /.messagebox -->
	
    <?php if($message['delete_sender'] == '0' and get_the_current_user('id') == $message['sender_user_id'] or $message['delete_receiver'] == '0' and get_the_current_user('id') == $message['receiver_user_id']): ?>
    	<div class="text-right">
            <a href="?status=1" class="btn btn-success"><i class="fa fa-times"></i> Tüm mesajları aktifleştir</a>
        </div> <!-- /.text-right -->
    <?php else: ?>
        <div class="text-right">
            <a href="?status=0" class="btn btn-danger"><i class="fa fa-times"></i> Tüm mesajları sil</a>
        </div> <!-- /.text-right -->
    <?php endif; ?>
    

<div class="h40"></div>
<div class="widget-blank"><h4>Mesajı cevapla</h4></div>
<div class="widget-body radius-0">
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



