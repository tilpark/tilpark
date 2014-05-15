<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li class="active">Görev Yöneticisi</li>
</ol>

<?php $users = get_user_list(); ?>

<ul id="myTab" class="nav nav-tabs">
	<li class="active"><a href="#taskmanager" data-toggle="tab"><i class="fa fa-calendar"></i> Görev Yöneticisi</a></li>
	<li><a href="#inbox" data-toggle="tab"><i class="fa fa-arrow-down"></i> Gelen Görevler</a></li>
	<li><a href="#outbox" data-toggle="tab"><i class="fa fa-arrow-right"></i> Giden Görevler</a></li>
</ul>



<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade active in" id="taskmanager">
    		

        
        <div class="row">
        	<div class="col-md-6">
            	<h4 class="text-success"><i class="fa fa-arrow-down"></i> Gelen Görevler</h4>
                
               	<?php $inboxs = get_messagebox(array('type'=>'task', 'top_message'=>true, 'onoff'=>'0', 'order_by'=>'date_end ASC, date_update DESC')); ?>
				<?php $is_message = array(); ?>
               	<?php if($inboxs): ?>
                <table class="table table-hover table-condensed table-bordered">
                    <thead>
                    	<tr>
                       		<th class="hide"></th>
                           <th width="80" class="hidden-xs hidden-sm">Tarih</th>
                           <th width="140">Gönderen</th>
                    	</tr>
                    </thead>
                    <tbody>
                        <?php foreach($inboxs as $message): ?>
                           <?php
                           		if($message['messagebox_id'] > 0){ $message['id'] = $message['messagebox_id']; }
                           		if($message['title'] == ''){ $message['title'] = mb_substr(strip_tags($message['content']),0,35,'utf-8'); }
                           	?>
                           	<?php if(isset($is_message[$message['id']])): ?>
							<?php else: ?>
									<?php
									// yeni gelen mesaj var mi?
									$this->db->where('messagebox_id', $message['id']);
									$this->db->where('receiver_user_id', get_the_current_user('id'));
									$this->db->where('read', '0');
									$is_newReply = $this->db->get('messagebox')->num_rows();
									?>
                               <?php $is_message[$message['id']] = true; ?>
                               <?php $daysLeft = days_left($message['date_end'], '+'); ?>
                                <tr class="<?php if($message['read'] == 0 and $message['receiver_user_id'] == get_the_current_user('id') or $is_newReply > 0): ?>active no_read<?php endif; ?> color-3">
                                    <td class="hide"></td>
                                    <td title="<?php echo $message['date']; ?>" class="color-4 hidden-xs hidden-sm">
                                       <?php echo substr($message['date_start'],0,10); ?> | <?php echo substr($message['date_end'],0,10); ?>
                                       <br />
                                       <span class="text-<?php if($daysLeft > 0): ?>success<?php elseif($daysLeft < 0): ?>danger<?php else: ?>warning<?php endif; ?> strong"><?php if($daysLeft > 0): ?><?php echo $daysLeft; ?> gün kaldı<?php elseif($daysLeft < 0): ?><?php echo $daysLeft; ?> gün geçti<?php else: ?>bu gün<?php endif; ?></span>
                                    </td>
                                    <td class="fs-12 color-4">
                                       <?php echo mb_substr($users[$message['sender_user_id']]['name_surname'],0,18,'utf-8'); ?>
                                       <br />
                                       <a href="<?php echo site_url('user/task/'.$message['id']); ?>" class="color-3"><?php echo mb_substr(strip_tags($message['title']),0,35, 'utf-8'); ?></a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <?php alertbox('alert-muted', '<i class="fa fa-check"></i> Tebrikler', 'Gelen görev bulunamadı. Tüm görevleri başarı ile tamamladın.', false); ?>
                <?php endif; ?>
                
            </div> <!-- /.col-md-6 -->
            <div class="col-md-6">
            	<h4 class="text-warning"><i class="fa fa-arrow-right"></i> Giden Görevler</h4>
                
                <?php $inboxs = get_messagebox(array('outbox'=>true, 'type'=>'task', 'top_message'=>true, 'onoff'=>'0', 'order_by'=>'date_end ASC, date_update DESC')); ?>
				<?php $is_message = array(); ?>
                <?php if($inboxs): ?>
                <table class="table table-hover table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="hide"></th>
                            <th width="80" class="hidden-xs hidden-sm">Tarih</th>
                            <th width="140">Gönderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($inboxs as $message): ?>
                            <?php
                                if($message['messagebox_id'] > 0){ $message['id'] = $message['messagebox_id']; }
                                if($message['title'] == ''){ $message['title'] = mb_substr(strip_tags($message['content']),0,35,'utf-8'); }
                            ?>
                            <?php if(isset($is_message[$message['id']])): ?>
                            <?php else: ?>
                            		<?php
									// yeni gelen mesaj var mi?
									$this->db->where('messagebox_id', $message['id']);
									$this->db->where('receiver_user_id', get_the_current_user('id'));
									$this->db->where('read', '0');
									$is_newReply = $this->db->get('messagebox')->num_rows();
									?>
                                <?php $is_message[$message['id']] = true; ?>
                                <?php $daysLeft = days_left($message['date_end'], '+'); ?>
                                <tr class="<?php if($message['read'] == 0 and $message['receiver_user_id'] == get_the_current_user('id') or $is_newReply > 0): ?>active no_read<?php endif; ?> color-3">
                                    <td class="hide"></td>
                                    <td title="<?php echo $message['date']; ?>" class="color-4 hidden-xs hidden-sm">
										<?php echo substr($message['date_start'],0,10); ?> | <?php echo substr($message['date_end'],0,10); ?>
                                       <br />
                                       <span class="text-<?php if($daysLeft > 0): ?>success<?php elseif($daysLeft < 0): ?>danger<?php else: ?>warning<?php endif; ?> strong"><?php echo $daysLeft; ?> gün kaldı</span>
                                    </td>
                                    <td class="fs-12 color-4">
										<?php echo mb_substr($users[$message['sender_user_id']]['name_surname'],0,18,'utf-8'); ?>
                                       <br />
                                    	<a href="<?php echo site_url('user/task/'.$message['id']); ?>" class="color-3"><?php echo mb_substr(strip_tags($message['title']),0,35, 'utf-8'); ?></a>
                                    </td>
								</tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <?php alertbox('alert-muted', '<i class="fa fa-tasks"></i> Giden görev bulunamadı', 'Açıkta bekleyen giden görev bulunamadı.', false); ?>
                <?php endif; ?>
                
            </div> <!-- /.col-md-6 -->
        </div> <!-- /.row -->
        
    </div> <!-- /#taskmanager -->
    <div class="tab-pane fade " id="inbox">
    
    	<?php $inboxs = get_messagebox(array('type'=>'task', 'order_by'=>'date_update DESC')); ?>
    	<?php $is_message = array(); ?>
    	<?php if($inboxs): ?>
        <table class="table table-hover table-condensed table-bordered dataTable">
			<thead>
				<tr>
					<th class="hide"></th>
					<th width="20" class="hidden-xs hidden-sm"></th>
					<th width="100" class="hidden-xs hidden-sm">Tarih</th>
					<th width="160">Gönderen</th>
					<th>Konu</th>
					<th class="hidden-xs hidden-sm">Mesaj</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($inboxs as $message): ?>
					<?php
						if($message['messagebox_id'] > 0){ $message['id'] = $message['messagebox_id']; }
						if($message['title'] == ''){ $message['title'] = mb_substr(strip_tags($message['content']),0,35,'utf-8'); }
					?>
					<?php if(isset($is_message[$message['id']])): ?>
					<?php else: ?>
						<?php $is_message[$message['id']] = true; ?>
						<tr class="<?php if($message['read'] == 0 and $message['receiver_user_id'] == get_the_current_user('id')): ?>active no_read<?php endif; ?> color-3">
                        	<td class="hide"></td>
							<td class="hidden-sm hidden-xs"><a href="<?php echo site_url('user/task/'.$message['id']); ?>" class="color-3"><?php if($message['read'] == 0 and $message['receiver_user_id'] == get_the_current_user('id')): ?><i class="fa fa-envelope"></i><?php else: ?><i class="fa fa-envelope-o"></i><?php endif; ?></a></td>
							<td title="<?php echo $message['date']; ?>" class="color-4 hidden-xs hidden-sm"><?php echo substr($message['date'],0,10); ?></td>
							<td class="fs-12 color-4"><?php echo mb_substr($users[$message['sender_user_id']]['name_surname'],0,18,'utf-8'); ?></td>
							<td><a href="<?php echo site_url('user/task/'.$message['id']); ?>" class="color-3"><?php echo mb_substr(strip_tags($message['title']),0,35, 'utf-8'); ?></a></td>
							<td class="hidden-xs hidden-sm"><a href="<?php echo site_url('user/task/'.$message['id']); ?>" class="color-4"><?php echo mb_substr(strip_tags($message['content']),0,35); if(strlen(strip_tags($message['content'])) > 35): ?>...<?php endif; ?></a></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
			<?php alertbox('alert-muted', '<i class="fa fa-file-o"></i> Gelen görev kutusu boş', 'Sana atanmış bir görev bulunamadı.', false); ?>
		<?php endif; ?>
    </div> <!-- /.tab-pane -->
    <div class="tab-pane fade" id="outbox">
    	<?php $outboxs = get_messagebox(array('outbox'=>'outbox','type'=>'task', 'order_by'=>'date DESC')); ?>
    	<?php $is_message = array(); ?>
    	<?php if($outboxs): ?>
        <table class="table table-hover table-condensed table-bordered dataTable">
			<thead>
				<tr>
					<th class="hide"></th>
					<th width="20" class="hidden-xs hidden-sm"></th>
					<th width="100" class="hidden-xs hidden-sm">Tarih</th>
					<th width="160">Alıcı</th>
					<th>Konu</th>
					<th class="hidden-xs hidden-sm">Mesaj</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($outboxs as $message): ?>
					<?php
						if($message['messagebox_id'] > 0){ $message['id'] = $message['messagebox_id']; }
						if($message['title'] == ''){ $message['title'] = mb_substr(strip_tags($message['content']),0,35,'utf-8'); }
					?>
					<?php if(isset($is_message[$message['id']])): ?>
					<?php else: ?>
						<?php $is_message[$message['id']] = true; ?>
						<tr class="<?php if($message['read'] == 0 and $message['sender_user_id'] == get_the_current_user('id')): ?>active no_read<?php endif; ?> color-3">
							<td class="hide"></td>
							<td class="hidden-xs hidden-sm"><a href="<?php echo site_url('user/task/'.$message['id']); ?>" class="color-4"><?php if($message['read'] == 0 and $message['sender_user_id'] == get_the_current_user('id')): ?><i class="fa fa-envelope"></i><?php else: ?><i class="fa fa-envelope-o"></i><?php endif; ?></a></td>
							<td title="<?php echo $message['date']; ?>" class="color-4 hidden-xs hidden-sm"><?php echo substr($message['date'],0,10); ?></td>
							<td class="color-4"><?php echo mb_substr($users[$message['receiver_user_id']]['name_surname'],0,18,'utf-8'); ?></td>
							<td><a href="<?php echo site_url('user/task/'.$message['id']); ?>" class="color-3"><?php echo mb_substr(strip_tags($message['title']),0,35, 'utf-8'); ?></a></td>
							<td class="hidden-xs hidden-sm"><a href="<?php echo site_url('user/task/'.$message['id']); ?>" class="color-4"><?php echo mb_substr(strip_tags($message['content']),0,35); if(strlen(strip_tags($message['content'])) > 35): ?>...<?php endif; ?></a></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
			<?php alertbox('alert-muted', '<i class="fa fa-file-o"></i> Giden görev kutusu boş', 'Kimseye görev atamamışsın, bence birilerine bir kaç görev ver. Sorumluluk almayı öğren :)', false); ?>
		<?php endif; ?>
    </div> <!-- /.tab-pane -->
</div> <!-- /.tab-content -->



