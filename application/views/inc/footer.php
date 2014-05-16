
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






<?php $count_noti = calc_message('noti'); if($count_noti > 0): ?>
	<script>
	$(document).ready(function() {
		$('.count_noti').html('<div class="mess_count"><?php echo $count_noti; ?></div>');
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





<?php $mbox_messages = get_messagebox(array('type'=>'message', 'order_by'=>'read ASC, date_update DESC', 'limit'=>'1000')); ?>
<div class="list_mess_hide hide">
	<?php if($mbox_messages): ?>
	<div style="padding:10px 10px 0 10px;">
    	<?php
		if($count_mess > 0){ $mbox_sub_text = '<span class="text-muted">Okunmamış '.$count_mess.' adet mesaj var.</span>'; }else { $mbox_sub_text = '<span class="text-muted">Tebrikler! tüm mesajları okudun.</span>'; }
		?>
		<?php alertbox('alert-blank', '<i class="fa fa-envelope-o text-muted"></i> <span class="text-muted">Mesaj Kutusu</span>', $mbox_sub_text, false); ?>
    </div>
	<ul class="list_mbox">
	<?php $is_message = array(); ?>
	<?php $i = 0; ?>
	<?php foreach($mbox_messages as $message): ?>
		<?php if($i < 10): ?>
			<?php
				if($message['messagebox_id'] > 0){ $message['id'] = $message['messagebox_id']; }
				if($message['title'] == ''){ $message['title'] = mb_substr(strip_tags($message['content']),0,30,'utf-8'); }
			?>
			<?php if(isset($is_message[$message['id']])): ?>
			<?php else: ?>
				<?php $is_message[$message['id']] = true; ?>
				<li class="<?php if($message['read'] == 0): ?>new_mess<?php endif; ?>">
					<a href="<?php echo site_url('user/inbox/'.$message['id']); ?>">
					    <div class="row no-space">
					      <div class="col-md-2">
					          <img src="<?php echo base_url('uploads/avatar/thumb_'.$users[$message['sender_user_id']]['avatar']); ?>" class="img-responsive img-thumbnail" />                  
					      </div> <!-- /.col-md-2 -->
					      <div class="col-md-10">
					        <div class="name"><?php echo $users[$message['sender_user_id']]['name_surname']; ?></div>
					        <div class="description"><?php echo mb_substr($message['title'],0,30,'utf-8'); ?><?php if(strlen($message['title']) > 30):?>...<?php endif; ?></div>
					        <?php $time_late = time_late($message['date_update']); ?>
					        <?php if($message['read'] == '0' and $message['read_id'] == get_the_current_user('id')): ?>
					            <span class="information label label-danger fs-11"><?php echo $time_late; ?></span>
					        <?php else: ?>
					            <span class="information label label-default fs-11"><?php echo $time_late; ?></span>
					        <?php endif; ?>
					      </div> <!-- /.col-md-10 -->
					    </div> <!-- /.row -->
					</a> <!-- /.opacity -->
				</li>
				<?php $i++; ?>
			<?php endif; ?>
		<?php else: ?>

		<?php endif; ?>
	<?php endforeach; ?>
    <?php else: ?>
    	<div style="padding:10px;">
    		<?php alertbox('alert-danger', '<i class="fa fa-envelope-o"></i> Gelen kutusu boş!', 'Gelen kutusunda mesaj bulunamadı.', false); ?>
        </div>
    <?php endif; ?>
	</ul>
</div> <!-- /.list_mess -->
<script>
	$(document).ready(function(e) { 
		$('div.list_mess').html($('div.list_mess_hide').html()); $('div.mbox').animate({'opacity':'1', 'right':'-348px'}, 0);
		
		$('.btn_mbox_mess').click(function() {
			if($(this).attr('data-show') == 'open')
			{	
				$(this).removeClass('active');
				$(this).attr('data-show', 'close');
				$('div.list_mess').animate({'opacity':'1', 'right':'-348px'}, 100);
			}
			else
			{
				$('.mbox').animate({'opacity':'1', 'right':'-348px'}, 100);
				$('.btn_mbox').removeClass('active');
				$('.btn_mbox').attr('data-show', 'close');

				$(this).addClass('active');
				$(this).attr('data-show', 'open');
				$('div.list_mess').animate({'opacity':'1', 'right':'0px'}, 100);
			}
		});
	});
</script>











<?php $mbox_task = get_messagebox(array('type'=>'task', 'order_by'=>'read ASC, date_update DESC', 'limit'=>'1000')); ?>
<div class="list_task_hide hide">
	<?php if($mbox_task): ?>
	<div style="padding:10px 10px 0 10px;">
    	<?php
		if($count_task > 0){ $mbox_sub_text = '<span class="text-muted">Yeni '.$count_task.' adet görev var.</span>'; }else { $mbox_sub_text = '<span class="text-muted">Tebrikler! tüm görevleri okudun.</span>'; }
		?>
		<?php alertbox('alert-blank', '<i class="fa fa-tasks text-muted"></i> <span class="text-muted">Görev Kutusu</span>', $mbox_sub_text, false); ?>
    </div>
	<ul class="list_mbox">
	<?php $is_message = array(); ?>
	<?php $i = 0; ?>
	<?php foreach($mbox_task as $message): ?>
		<?php if($i < 10): ?>
			<?php
				if($message['messagebox_id'] > 0){ $message['id'] = $message['messagebox_id']; }
				if($message['title'] == ''){ $message['title'] = mb_substr(strip_tags($message['content']),0,30,'utf-8'); }
			?>
			<?php if(isset($is_message[$message['id']])): ?>
			<?php else: ?>
				<?php $is_message[$message['id']] = true; ?>
				<li class="<?php if($message['read'] == 0): ?>new_mess<?php endif; ?>">
					<a href="<?php echo site_url('user/task/'.$message['id']); ?>">
					    <div class="row no-space">
					      <div class="col-md-2">
					          <img src="<?php echo base_url('uploads/avatar/thumb_'.$users[$message['sender_user_id']]['avatar']); ?>" class="img-responsive img-thumbnail" />                  
					      </div> <!-- /.col-md-2 -->
					      <div class="col-md-10">
					        <div class="name"><?php echo $users[$message['sender_user_id']]['name_surname']; ?></div>
					        <div class="description"><?php echo mb_substr($message['title'],0,30,'utf-8'); ?><?php if(strlen($message['title']) > 30):?>...<?php endif; ?></div>
					        <?php $time_late = time_late($message['date_update']); ?>
					        <?php if($message['read'] == '0' and $message['read_id'] == get_the_current_user('id')): ?>
					            <span class="information label label-danger fs-11"><?php echo $time_late; ?></span>
					        <?php else: ?>
					            <span class="information label label-default fs-11"><?php echo $time_late; ?></span>
					        <?php endif; ?>
					      </div> <!-- /.col-md-10 -->
					    </div> <!-- /.row -->
					</a> <!-- /.opacity -->
				</li>
				<?php $i++; ?>
			<?php endif; ?>
		<?php else: ?>

		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
    <?php else: ?>
    	<div style="padding:10px;">
    		<?php alertbox('alert-danger', '<i class="fa fa-tasks"></i> Görev kutusu boş!', 'Gelen görev kutusunda görev bulunamadı.', false); ?>
        </div>
    <?php endif; ?>
</div> <!-- /.list_mess -->
<script>
	$(document).ready(function(e) { 
		$('div.list_task').html($('div.list_task_hide').html()); $('div.mbox').animate({'opacity':'1', 'right':'-348px'}, 0);
		
		$('.btn_mbox_task').click(function() {
			if($(this).attr('data-show') == 'open')
			{	
				$(this).removeClass('active');
				$(this).attr('data-show', 'close');
				$('div.list_task').animate({'opacity':'1', 'right':'-348px'}, 100);
			}
			else
			{
				$('.mbox').animate({'opacity':'1', 'right':'-348px'}, 100);
				$('.btn_mbox').removeClass('active');
				$('.btn_mbox').attr('data-show', 'close');

				$(this).addClass('active');
				$(this).attr('data-show', 'open');
				$('div.list_task').animate({'opacity':'1', 'right':'0px'}, 100);
			}
		});
	});
</script>









<?php $mbox_task = get_messagebox(array('type'=>'noti', 'order_by'=>'read ASC, date_update DESC', 'limit'=>'1000')); ?>
<div class="list_noti_hide hide">
	<?php if($mbox_task): ?>
	<div style="padding:10px 10px 0 10px;">
    	<?php
		if($count_task > 0){ $mbox_sub_text = '<span class="text-muted">Yeni '.$count_task.' adet görev var.</span>'; }else { $mbox_sub_text = '<span class="text-muted">Tebrikler! tüm görevleri okudun.</span>'; }
		?>
		<?php alertbox('alert-blank', '<i class="fa fa-globe text-muted"></i> <span class="text-muted">Görev Kutusu</span>', $mbox_sub_text, false); ?>
    </div>
	<ul class="list_mbox">
	<?php $is_message = array(); ?>
	<?php $i = 0; ?>
	<?php foreach($mbox_task as $message): ?>
		<?php if($i < 10): ?>
			<?php
				if($message['messagebox_id'] > 0){ $message['id'] = $message['messagebox_id']; }
				if($message['title'] == ''){ $message['title'] = mb_substr(strip_tags($message['content']),0,30,'utf-8'); }
			?>
			<?php if(isset($is_message[$message['id']])): ?>
			<?php else: ?>
				<?php $is_message[$message['id']] = true; ?>
				<li class="<?php if($message['read'] == 0): ?>new_mess<?php endif; ?>">
					<a href="<?php echo site_url('user/notification/'.$message['id']); ?>">
					    <div class="row no-space">
					      <div class="col-md-12">
					        <div class="description"><?php echo mb_substr($message['title'],0,30,'utf-8'); ?><?php if(strlen($message['title']) > 30):?>...<?php endif; ?></div>
					        <?php $time_late = time_late($message['date_update']); ?>
					        <?php if($message['read'] == '0' and $message['read_id'] == get_the_current_user('id')): ?>
					            <span class="information label label-danger fs-11">yeni</span>
					        <?php else: ?>
					            <span class="information label label-default fs-11"><?php echo $time_late; ?></span>
					        <?php endif; ?>
					      </div> <!-- /.col-md-10 -->
					    </div> <!-- /.row -->
					</a> <!-- /.opacity -->
				</li>
				<?php $i++; ?>
			<?php endif; ?>
		<?php else: ?>

		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
    <?php else: ?>
    	<div style="padding:10px;">
    		<?php alertbox('alert-danger', '<i class="fa fa-globe"></i> Gelen bildirim bulunamadı!', 'Gelen görev kutusunda görev bulunamadı.', false); ?>
        </div>
    <?php endif; ?>
</div> <!-- /.list_mess -->
<script>
	$(document).ready(function(e) { 
		$('div.list_noti').html($('div.list_noti_hide').html()); $('div.mbox').animate({'opacity':'1', 'right':'-348px'}, 0);
		
		$('.btn_mbox_noti').click(function() {
			if($(this).attr('data-show') == 'open')
			{	
				$(this).removeClass('active');
				$(this).attr('data-show', 'close');
				$('div.list_noti').animate({'opacity':'1', 'right':'-348px'}, 100);
			}
			else
			{
				$('.mbox').animate({'opacity':'1', 'right':'-348px'}, 100);
				$('.btn_mbox').removeClass('active');
				$('.btn_mbox').attr('data-show', 'close');

				$(this).addClass('active');
				$(this).attr('data-show', 'open');
				$('div.list_noti').animate({'opacity':'1', 'right':'0px'}, 100);
			}
		});
	});
</script>













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