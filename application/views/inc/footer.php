
</div>

</div> <!-- /.row -->


<div class="h20"></div>
<?php

?>
<div>
<div class="h20"></div>
<small class="pull-left">{elapsed_time} <?php lang('installed in seconds.'); ?></small>
<?php
if(isset($_POST['page_access_change']) and get_the_current_user('role') <= 2)
{
	$role = $_POST['role'];
	$page_name = $_POST['page_name'];
	
	update_option(array('option_group'=>'page_access', 'option_key'=>$page_name, 'option_value'=>$role));
	
	add_log(array('type'=>'page_access', 'title'=>get_lang('Page Access'), 'description'=>get_lang('Changed the access settings page').' ['.$page_name.'/'.$role.']'));
}
function control_page()
{
	$ci =& get_instance();
	$page_name = $ci->uri->segment(1).'/'.$ci->uri->segment(2);
	
	$data['/'] = '';
	$data['user/logout'] = '';
	$data['user/profile'] = '1';
	$data['user/new_message'] = '';
	$data['user/inbox'] = '';
	$data['user/outbox'] = '';
	$data['user/new_task'] = '';
	$data['user/task'] = '';
	$data['user/outbound_tasks'] = '';
	$data['general/about'] = '';
	
	if(isset($data[$page_name]))
	{
		?>
        <?php if(get_the_current_user('role') <= 2): ?>
		<small class="pull-right"><?php echo get_lang('access privileges for this page is fixed.'); ?></small>
        <?php endif; ?>
		<?php
    }
	else
	{
		$role = get_option(array('group'=>'yokboyle'));
		?>
          <!-- Modal -->
          <div class="modal fade" id="modal_pageAccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?php lang('Page Access'); ?></h4>
                </div>
                <div class="modal-body">
                 <form name="form_page_access" id="form_page_access" action="" method="POST">
                    <label for="role" class="control-label ff-1 fs-16"><?php lang('Role'); ?></label>
                    <select name="role" id="role" class="form-control input-lg">
                      <option value="5" <?php if($role['option_value']==5){echo'selected';} ?>>Personel</option>
                      <option value="4" <?php if($role['option_value']==4){echo'selected';} ?>>Yetikili Personel</option>
                      <option value="3" <?php if($role['option_value']==3){echo'selected';} ?>>Birim Amiri</option>
                      <option value="2" <?php if($role['option_value']==2){echo'selected';} ?>>Yönetici</option>
                      <option value="1" <?php if($role['option_value']==1){echo'selected';} ?>>Süper Yönetici</option>
                    </select>
                    <input type="hidden" name="page_name" id="page_name" value="<?php echo $page_name; ?>" />
                    <input type="hidden" name="page_access_change" id="page_access_change" />
                 </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><?php lang('Close'); ?></button>
                  <button type="button" class="btn btn-primary" onclick="document.getElementById('form_page_access').submit();"><?php lang('Save'); ?></button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
     
        <!-- Button trigger modal -->

              
        <?php
		
	}
	

}
control_page();
?>
</div>


</div> <!-- /.container -->



<!-- 404 sayfasi ayarlaması -->
<?php if(isset($error_404)): ?>
	<div class="error_404">
		<div class="fs-36 text-center"><i class="fa fa-unlink icon"></i></div>
		<h1 class="text-center">Hopss!</h1>
		<h3 class="text-center">Aradığınız sayfa bulunamadı.</h3>
		<div class="well bg-white text-danger text-center">
			<?php echo $error_404; ?>
		</div>
	</div>
	<script>$(document).ready(function(e) { $('.content-arena').html($('.error_404').html()); $('.content-arena').addClass('error_404'); });</script>
<?php endif; ?>	

<?php $users = get_user_list(); ?>



<?php $mbox_messages = get_messagebox(array('type'=>'message', 'order_by'=>'read ASC, updated_date DESC', 'limit'=>'5')); ?>
<div class="list_info_hide hide">
	<ul class="list_mbox">
	<?php foreach($mbox_messages as $message): ?>
	<li class="<?php if($message['read'] == 0): ?>new_mess<?php endif; ?>">
	  <a href="<?php echo site_url('user/inbox/'.$message['id']); ?>">
	    <div class="row no-space">
	      <div class="col-md-2">
	        <?php if($message['read_id'] == get_the_current_user('id') and $message['inbox_user_id'] == get_the_current_user('id')): ?>
	          <img src="<?php echo base_url('uploads/avatar/'.$users[$message['receiver_user_id']]['avatar']); ?>" class="img-responsive" />
	        <?php else: ?>
	          <img src="<?php echo base_url('uploads/avatar/'.$users[$message['sender_user_id']]['avatar']); ?>" class="img-responsive" />
	        <?php endif; ?>                    
	      </div> <!-- /.col-md-2 -->
	      <div class="col-md-10">
	        <div class="name"><?php echo $users[$message['sender_user_id']]['name_surname']; ?></div>
	        <div class="description"><?php echo $message['title']; ?></div>
	        <?php $time_late = time_late($message['updated_date']); ?>
	        <?php if($message['read'] == '0' and $message['read_id'] == get_the_current_user('id')): ?>
	            <span class="information label label-danger fs-11"><?php echo $time_late; ?></span>
	        <?php else: ?>
	            <span class="information label label-default fs-11">bugün</span>
	        <?php endif; ?>
	      </div> <!-- /.col-md-10 -->
	    </div> <!-- /.row -->
	  </a> <!-- /.opacity -->
	</li>
	<?php endforeach; ?>
	</ul>
</div> <!-- /.list_task -->
<script>
	$(document).ready(function(e) { 
		$('div.list_info').html($('div.list_info_hide').html()); $('div.list_info').animate({'opacity':'0','top':'-300px'}, 0);
		
		$('.btn_mbox_info').click(function() {
			if($(this).attr('data-show') == 'open')
			{	
				$(this).removeClass('active');
				$(this).attr('data-show', 'close');
				$('div.list_info').animate({'opacity':'0','top':'-300px'}, 0);
			}
			else
			{
				$('.mbox').animate({'opacity':'0','top':'-300px'}, 300);
				$('.btn_mbox').removeClass('active');
				$('.btn_mbox').attr('data-show', 'close');

				$(this).addClass('active');
				$(this).attr('data-show', 'open');
				$('div.list_info').animate({'opacity':'1','top':'48px'}, 300);
			}
			
		});
	});
</script>




<?php $mbox_messages = get_messagebox(array('type'=>'message', 'order_by'=>'read ASC, updated_date DESC', 'limit'=>'5')); ?>
<div class="list_mess_hide hide">
	<ul class="list_mbox">
	<?php foreach($mbox_messages as $message): ?>
	<li class="<?php if($message['read'] == 0): ?>new_mess<?php endif; ?>">
	  <a href="<?php echo site_url('user/inbox/'.$message['id']); ?>">
	    <div class="row no-space">
	      <div class="col-md-2">
	        <?php if($message['read_id'] == get_the_current_user('id') and $message['inbox_user_id'] == get_the_current_user('id')): ?>
	          <img src="<?php echo base_url('uploads/avatar/'.$users[$message['receiver_user_id']]['avatar']); ?>" class="img-responsive" />
	        <?php else: ?>
	          <img src="<?php echo base_url('uploads/avatar/'.$users[$message['sender_user_id']]['avatar']); ?>" class="img-responsive" />
	        <?php endif; ?>                    
	      </div> <!-- /.col-md-2 -->
	      <div class="col-md-10">
	        <div class="name"><?php echo $users[$message['sender_user_id']]['name_surname']; ?></div>
	        <div class="description"><?php echo $message['title']; ?></div>
	        <?php $time_late = time_late($message['updated_date']); ?>
	        <?php if($message['read'] == '0' and $message['read_id'] == get_the_current_user('id')): ?>
	            <span class="information label label-danger fs-11"><?php echo $time_late; ?></span>
	        <?php else: ?>
	            <span class="information label label-default fs-11">bugün</span>
	        <?php endif; ?>
	      </div> <!-- /.col-md-10 -->
	    </div> <!-- /.row -->
	  </a> <!-- /.opacity -->
	</li>
	<?php endforeach; ?>
	</ul>
</div> <!-- /.list_mess -->
<script>
	$(document).ready(function(e) { 
		$('div.list_mess').html($('div.list_mess_hide').html()); $('div.list_mess').animate({'opacity':'0','top':'-300px'}, 0);
		
		$('.btn_mbox_mess').click(function() {
			if($(this).attr('data-show') == 'open')
			{	
				$(this).removeClass('active');
				$(this).attr('data-show', 'close');
				$('div.list_mess').animate({'opacity':'0','top':'-300px'}, 0);
			}
			else
			{
				$('.mbox').animate({'opacity':'0','top':'-300px'}, 300);
				$('.btn_mbox').removeClass('active');
				$('.btn_mbox').attr('data-show', 'close');

				$(this).addClass('active');
				$(this).attr('data-show', 'open');
				$('div.list_mess').animate({'opacity':'1','top':'48px'}, 300);
			}
		});
	});
</script>






<?php $mbox_messages = get_messagebox(array('type'=>'message', 'order_by'=>'read ASC, updated_date DESC', 'limit'=>'5')); ?>
<div class="list_task_hide hide">
	<ul class="list_mbox">
	<?php foreach($mbox_messages as $message): ?>
	<li class="<?php if($message['read'] == 0): ?>new_mess<?php endif; ?>">
	  <a href="<?php echo site_url('user/inbox/'.$message['id']); ?>">
	    <div class="row no-space">
	      <div class="col-md-2">
	        <?php if($message['read_id'] == get_the_current_user('id') and $message['inbox_user_id'] == get_the_current_user('id')): ?>
	          <img src="<?php echo base_url('uploads/avatar/'.$users[$message['receiver_user_id']]['avatar']); ?>" class="img-responsive" />
	        <?php else: ?>
	          <img src="<?php echo base_url('uploads/avatar/'.$users[$message['sender_user_id']]['avatar']); ?>" class="img-responsive" />
	        <?php endif; ?>                    
	      </div> <!-- /.col-md-2 -->
	      <div class="col-md-10">
	        <div class="name"><?php echo $users[$message['sender_user_id']]['name_surname']; ?></div>
	        <div class="description"><?php echo $message['title']; ?></div>
	        <?php $time_late = time_late($message['updated_date']); ?>
	        <?php if($message['read'] == '0' and $message['read_id'] == get_the_current_user('id')): ?>
	            <span class="information label label-danger fs-11"><?php echo $time_late; ?></span>
	        <?php else: ?>
	            <span class="information label label-default fs-11">bugün</span>
	        <?php endif; ?>
	      </div> <!-- /.col-md-10 -->
	    </div> <!-- /.row -->
	  </a> <!-- /.opacity -->
	</li>
	<?php endforeach; ?>
	</ul>
</div> <!-- /.list_task -->
<script>
	$(document).ready(function(e) { 
		$('div.list_task').html($('div.list_task_hide').html()); $('div.list_task').animate({'opacity':'0','top':'-300px'}, 0);
		
		$('.btn_mbox_task').click(function() {
			if($(this).attr('data-show') == 'open')
			{	
				$(this).removeClass('active');
				$(this).attr('data-show', 'close');
				$('div.list_task').animate({'opacity':'0','top':'-300px'}, 0);
			}
			else
			{
				$('.mbox').animate({'opacity':'0','top':'-300px'}, 300);
				$('.btn_mbox').removeClass('active');
				$('.btn_mbox').attr('data-show', 'close');

				$(this).addClass('active');
				$(this).attr('data-show', 'open');
				$('div.list_task').animate({'opacity':'1','top':'48px'}, 300);
			}
			
		});
	});
</script>




<?php $count_info = calc_message('info'); if($count_info > 0): ?>
	<script>
	$(document).ready(function() {
		$('.count_info').html('<div class="mess_count"><?php echo $count_info; ?></div>');
	});
	</script>
<?php endif; ?>
<?php $count_mess = calc_message('message'); if($count_mess > 0): ?>
	<script>
	$(document).ready(function() {
		$('.count_mess').html('<div class="mess_count"><?php echo $count_mess; ?></div>');
	});
	</script>
<?php endif; ?>
<?php $count_task = calc_message('task'); if($count_task > 0): ?>
	<script>
	$(document).ready(function() {
		$('.count_task').html('<div class="mess_count"><?php echo $count_task; ?></div>');
	});
	</script>
<?php endif; ?>

<script>
$(document).ready(function(e) {
    $('.breadcrumb').append('<li class="date"><i class="fa fa-calendar"></i> &nbsp; <?php echo mb_strtoupper(date_replace_TR(date('d F Y, l')), 'utf-8'); ?></li>');
});
</script>

</body>
</html>
<?php
function rasgeleharf($kackarakter)
{
	$s="";
	$char="abcdefghijklmnoprstuwvyzqxABCDEFGHIJKLMNOPRSTUVWYZQX1234567890"; /// İzin verilen karakterler ?
	for ($k=1;$k<=$kackarakter;$k++)
	{
	$h=substr($char,mt_rand(0,strlen($char)-1),1);
	$s.=$h;
	}
	return $s;
}
for($i=2; $i<1; $i++)
{
	$data['code'] = rasgeleharf(50);
	$data['name'] = rasgeleharf(50);
	$data['name_surname'] = rasgeleharf(50);
	$data['phone'] = rasgeleharf(20);
	$data['gsm'] = rasgeleharf(20);
	$data['address'] = rasgeleharf(250);
	$data['county'] = rasgeleharf(20);
	$data['city'] = rasgeleharf(20);
	$data['description'] = rasgeleharf(500);
	
	$this->db->insert('accounts', $data);
}
?>
<?php $birkisi = round(memory_get_usage() / 1024 ); ?>

<script>
$('.1kisi').html('<?php echo $birkisi; ?>');
$('.10kisi').html('<?php echo round($birkisi * 10 / 1024); ?>');
$('.100kisi').html('<?php echo round($birkisi * 100 / 1024); ?>');
$('.1000kisi').html('<?php echo round($birkisi * 1000 / 1024 / 1024); ?>');
</script>