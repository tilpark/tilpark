<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('user/messagebox'); ?>">Mesaj Kutusu</a></li>
  <li class="active">Gelen Kutusu</li>
</ol>

<?php $users = get_user_list(); ?>

<ul id="myTab" class="nav nav-tabs">
	<li class="active"><a href="#inbox" data-toggle="tab"><i class="fa fa-arrow-down"></i> Gelen Kutusu</a></li>
	<li><a href="#outbox" data-toggle="tab"><i class="fa fa-arrow-right"></i> Giden Kutusu</a></li>
</ul>



<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade active in" id="inbox">
    	<?php $inboxs = get_messagebox(array('type'=>'message', 'order_by'=>'read ASC, updated_date DESC')); ?>
    	<?php if($inboxs): ?>
        <table class="table table-hover table-condensed table-bordered dataTable">
			<thead>
				<tr>
					<th class="hide"></th>
					<th width="100">Tarih</th>
					<th width="160">Gönderen</th>
					<th>Konu</th>
					<th>Mesaj</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($inboxs as $inbox): ?>
					<tr class="<?php if($inbox['read'] == 0 and $inbox['read_id'] == get_the_current_user('id')): ?>active no_read<?php endif; ?>">
						<td class="hide"></td>
						<td><?php echo substr($inbox['date'],0,10); ?></td>
						<td><a href="<?php echo site_url('user/profile'); ?>/<?php echo $inbox['sender_user_id']; ?>" target="blank"><?php echo $users[$inbox['sender_user_id']]['name_surname']; ?></a></td>
						<td><a href="<?php echo site_url('user/inbox/'.$inbox['id']); ?>"><?php echo $inbox['title']; ?></a></td>
						<td><?php echo mb_substr(strip_tags($inbox['content']),0,60); if(strlen(strip_tags($inbox['content'])) > 60): ?>...<?php endif; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
			<?php alertbox('alert-muted', '<i class="fa fa-file-o"></i> Gelen Kutunuz Boş', 'Henüz mesaj almadığınızdan dolayı gelen kutunuz boş gözükmektedir.', false); ?>
		<?php endif; ?>
    </div> <!-- /.tab-pane -->
    <div class="tab-pane fade" id="outbox">
    	<?php $outboxs = get_messagebox(array('outbox'=>'outbox','type'=>'message', 'order_by'=>'date DESC')); ?>
    	<?php if($outboxs): ?>
        <table class="table table-hover table-condensed table-bordered dataTable">
			<thead>
				<tr>
					<th class="hide"></th>
					<th width="90">Tarih</th>
					<th width="160">Alıcı</th>
					<th>Konu</th>
					<th>Mesaj</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($outboxs as $outbox): ?>
					<tr class="<?php if($outbox['read'] == 0 and $outbox['read_id'] == get_the_current_user('id')): ?>active no_read<?php endif; ?>">
						<td class="hide"></td>
						<td><?php echo substr($outbox['date'],0,10); ?></td>
						<td><a href="<?php echo site_url('user/profile'); ?>/<?php echo $outbox['sender_user_id']; ?>" target="blank"><?php echo $users[$outbox['receiver_user_id']]['name_surname']; ?></a></td>
						<td><a href="<?php echo site_url('user/inbox/'.$outbox['id']); ?>"><?php echo $outbox['title']; ?></a></td>
						<td><?php echo mb_substr(strip_tags($outbox['content']),0,60); if(strlen(strip_tags($outbox['content'])) > 60): ?>...<?php endif; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
			<?php alertbox('alert-muted', '<i class="fa fa-file-o"></i> Giden Kutunuz Boş', 'Henüz mesaj göndermediğinizden dolayı giden kutunuz boş gözükmektedir.', false); ?>
		<?php endif; ?>
    </div> <!-- /.tab-pane -->
</div> <!-- /.tab-content -->



