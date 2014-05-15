<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('user/inbox'); ?>">Mesaj Kutusu</a></li>
  <li class="active">Mesaj Kutusu</li>
</ol>

<?php $users = get_user_list(); ?>

<ul id="myTab" class="nav nav-tabs">
	<li class="active"><a href="#inbox" data-toggle="tab"><i class="fa fa-arrow-down"></i> Gelen Kutusu</a></li>
	<li><a href="#outbox" data-toggle="tab"><i class="fa fa-arrow-right"></i> Giden Kutusu</a></li>
</ul>



<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade active in" id="inbox">
    	<?php $inboxs = get_messagebox(array('type'=>'message', 'order_by'=>'date_update DESC')); ?>
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
							<td class="hidden-sm hidden-xs"><a href="<?php echo site_url('user/inbox/'.$message['id']); ?>" class="color-3"><?php if($message['read'] == 0 and $message['receiver_user_id'] == get_the_current_user('id')): ?><i class="fa fa-envelope"></i><?php else: ?><i class="fa fa-envelope-o"></i><?php endif; ?></a></td>
							<td title="<?php echo $message['date']; ?>" class="color-4 hidden-xs hidden-sm"><?php echo substr($message['date'],0,10); ?></td>
							<td class="fs-12 color-4"><?php echo mb_substr($users[$message['sender_user_id']]['name_surname'],0,18,'utf-8'); ?></td>
							<td><a href="<?php echo site_url('user/inbox/'.$message['id']); ?>" class="color-3"><?php echo mb_substr(strip_tags($message['title']),0,35, 'utf-8'); ?></a></td>
							<td class="hidden-xs hidden-sm"><a href="<?php echo site_url('user/inbox/'.$message['id']); ?>" class="color-4"><?php echo mb_substr(strip_tags($message['content']),0,35); if(strlen(strip_tags($message['content'])) > 35): ?>...<?php endif; ?></a></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
			<?php alertbox('alert-muted', '<i class="fa fa-file-o"></i> Gelen kutusu boş', 'Mesaj kutusunda gösterilecek bir mesaj bulunamadı.', false); ?>
		<?php endif; ?>
    </div> <!-- /.tab-pane -->
    <div class="tab-pane fade" id="outbox">
    	<?php $outboxs = get_messagebox(array('outbox'=>'outbox','type'=>'message', 'order_by'=>'date DESC')); ?>
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
							<td class="hidden-xs hidden-sm"><a href="<?php echo site_url('user/inbox/'.$message['id']); ?>" class="color-4"><?php if($message['read'] == 0 and $message['sender_user_id'] == get_the_current_user('id')): ?><i class="fa fa-envelope"></i><?php else: ?><i class="fa fa-envelope-o"></i><?php endif; ?></a></td>
							<td title="<?php echo $message['date']; ?>" class="color-4 hidden-xs hidden-sm"><?php echo substr($message['date'],0,10); ?></td>
							<td class="color-4"><?php echo mb_substr($users[$message['receiver_user_id']]['name_surname'],0,18,'utf-8'); ?></td>
							<td><a href="<?php echo site_url('user/inbox/'.$message['id']); ?>" class="color-3"><?php echo mb_substr(strip_tags($message['title']),0,35, 'utf-8'); ?></a></td>
							<td class="hidden-xs hidden-sm"><a href="<?php echo site_url('user/inbox/'.$message['id']); ?>" class="color-4"><?php echo mb_substr(strip_tags($message['content']),0,35); if(strlen(strip_tags($message['content'])) > 35): ?>...<?php endif; ?></a></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
			<?php alertbox('alert-muted', '<i class="fa fa-file-o"></i> Giden kutusu boş', 'Mesaj kutusunda gösterilecek bir mesaj bulunamadı.', false); ?>
		<?php endif; ?>
    </div> <!-- /.tab-pane -->
</div> <!-- /.tab-content -->



