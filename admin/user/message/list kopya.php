<?php include('../../../tilpark.php'); ?>
<?php get_header(); ?>


<?php
add_page_info('title', 'Mesaj Kutusu - Gelen');
add_page_info('nav', array('name'=>'Mesaj Kutusu'));

$messagebox = 'inbox';
if(isset($_GET['outbox'])) 	{ $messagebox = 'outbox'; add_page_info('title', 'Mesaj Kutusu - Giden');	}
if(isset($_GET['trash'])) 	{ $messagebox = 'trash'; add_page_info('title', 'Mesaj Kutusu - Çöp');	}


// mesajı çöp kutusuna taşıma
if(isset($_GET['move']) and isset($_GET['id'])) {
	if($message = get_message($_GET['id'])) {

		if($_GET['move'] == 'trash') {
			if($message->sen_u_id == get_active_user('id')) { $set = "sen_trash_u_id='".get_active_user('id')."'"; }
			if($message->rec_u_id == get_active_user('id')) { $set = "rec_trash_u_id='".get_active_user('id')."'"; }

			if($q_update = db()->query("UPDATE ".dbname('messages')." SET ".$set." WHERE id='".input_check($_GET['id'])."'")) {

			}
		} else {

			if($message->sen_trash_u_id == get_active_user('id')) { $set = "sen_trash_u_id='0'"; }
			if($message->rec_trash_u_id == get_active_user('id')) { $set = "rec_trash_u_id='0'"; }

			if($q_update = db()->query("UPDATE ".dbname('messages')." SET ".$set." WHERE id='".input_check($_GET['id'])."'")) {

			}
		}
	}
}

## mesajlari veritabanından cekme

# mesajlar okunmus veya okunmamis
if(isset($_GET['read_it'])) {
	if($_GET['read_it'] == '0' OR $_GET['read_it'] == '1') {
		$read_it = input_check($_GET['read_it']);
	} else {
		echo get_alert('"read_it" degeri "0" veya "1" olmalı.', 'warning', false);
	}
}


# mesajlari cekelim
$args = array();
$args['type'] = 'message';
if(isset($read_it)) { $args['read_it'] = $read_it; }

if($messagebox == 'inbox') {
	$args['inbox_u_id'] = get_active_user('id');
	$args['not_in']['rec_trash_u_id'] = get_active_user('id');
	$args['not_in']['sen_trash_u_id'] = get_active_user('id');

	$messages = get_message_list($args);
} elseif($messagebox == 'outbox') {
	$args['outbox_u_id'] = get_active_user('id');
	$args['not_in']['rec_trash_u_id'] = get_active_user('id');
	$args['not_in']['sen_trash_u_id'] = get_active_user('id');

	$messages = get_message_list(array('where'=>array('query'=>"type='message' AND outbox_u_id='".get_active_user('id')."' AND rec_trash_u_id NOT IN ('".get_active_user('id')."') AND sen_trash_u_id NOT IN ('".get_active_user('id')."') ORDER BY read_it ASC, date_update DESC")));
} else {
	if($q_select = db()->query("SELECT * FROM ".dbname('messages')." WHERE type='message' AND sen_trash_u_id='".get_active_user('id')."' OR rec_trash_u_id='".get_active_user('id')."' ORDER BY read_it ASC, date_update DESC")) {
		if($q_select->num_rows) {
			$messages = db_query_list_return($q_select, 'id');
		}
	}
}
?>



<div class="row">
	<div class="col-md-3">
		
		<?php include('_sidebar.php'); ?>

	</div> <!-- /.col-md-3 -->
	<div class="col-md-9">
		<div class="panel panel-default panel-table panel-dataTable">

			<?php if($messagebox == 'trash'): ?>
				<?php if(isset($messages)): ?>
					<table class="table table-hover table-condensed table-striped dataTable">
						<thead class="none">
							<tr>
								<th width="10"></th>
								<th width="100">Gönderen</th>
								<th width="100">Alıcı</th>
								<th>Konu</th>
								<th width="120">Tarih</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($messages as $list): ?>
							<tr>
								<td width="10">
									<a href="?id=<?php echo $list->id; ?>&move=null&<?php if($list->inbox_u_id==get_active_user('id')){ echo 'inbox'; } else { echo 'outbox'; } ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Çöp kutusundan çıkar"><i class="fa fa-reply text-warning"></i></a>
								</td>
								<td width="140"><?php echo mb_substr(get_user_info($list->sen_u_id, 'name'),0,1); ?>. <?php echo get_user_info($list->sen_u_id, 'surname'); ?></td>
								<td width="140"><?php echo mb_substr(get_user_info($list->rec_u_id, 'name'),0,1); ?>. <?php echo get_user_info($list->rec_u_id, 'surname'); ?></td>
								<td>
									<a href="detail.php?id=<?php echo $list->id; ?>" class="<?php if(!$list->read_it and $list->inbox_u_id == get_active_user('id')): ?>bold<?php endif; ?>">
										<span class="text-black"><?php echo $list->title; ?></span>
										<?php
										if($q_select = db()->query("SELECT * FROM ".dbname('messages')." WHERE top_id='".$list->id."' ORDER BY date_update DESC LIMIT 1")) {
											if($q_select->num_rows) {
												$sub_message = $q_select->fetch_object();
												?>
												<span class="text-muted"><b>-</b> <?php echo mb_substr($sub_message->message,0,80,'utf-8'); ?><?php if(strlen($sub_message->message) > 80): ?>...<?php endif; ?></span>
												<?php
											}
										}
										?>
									</a>
								</td>
								<td width="100"><?php echo get_time_late($list->date); ?> önce</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="not-found">
						<?php echo get_alert('Çöp kutusu boş.', 'warning', false); ?>
					</div>
				<?php endif; ?>

			<?php else: ?>
				<?php if($messages): ?>
					<table class="table table-hover table-condensed table-striped dataTable">
						<thead class="none">
							<tr>
								<th width="10"></th>
								<th width="180"><?php echo $messagebox == 'inbox' ? 'Gönderen' : 'Alıcı'; ?></th>
								<th>Konu</th>
								<th width="100">Tarih</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($messages as $list): ?>
							<tr class="<?php if(!$list->read_it and $list->inbox_u_id == get_active_user('id')): ?>bold<?php endif; ?>" onclick="location.href='<?php site_url('message', $list->id); ?>';">
								<td width="10">
									<a href="?id=<?php echo $list->id; ?>&move=trash" class="btn btn-default btn-xs" data-toggle="tooltip" title="Çöp kutusuna taşı"><i class="fa fa-trash text-danger"></i></a>
								</td>
								<td width="220">
									<?php if($messagebox == 'inbox'): ?>
										<div class="pull-left" style="margin-right:5px;">
											<img src="<?php echo get_user_info($list->outbox_u_id, 'avatar'); ?>" class="img-responsive br-2 pull-right" width="21">
										</div>
										<?php echo get_user_info($list->outbox_u_id, 'display_name'); ?>
									<?php else: ?>
										<div class="pull-left" style="margin-right:5px;">
											<img src="<?php echo get_user_info($list->inbox_u_id, 'avatar'); ?>" class="img-responsive br-2 pull-right" width="21">
										</div>
										<?php echo get_user_info($list->inbox_u_id, 'display_name'); ?>
									<?php endif; ?>
								</td>
								<td>
									<?php if(!$list->read_it and $list->inbox_u_id == get_active_user('id')): ?>
										<i class="fa fa-envelope-o mr-3"></i>
									<?php else: ?>
										<i class="fa fa-envelope-open-o mr-3 text-muted"></i>
									<?php endif; ?>

									<a href="detail.php?id=<?php echo $list->id; ?>">
										<span class="text-black"><?php echo $list->title; ?> <?php if(!strlen($list->title)): ?>#<?php echo $list->id; ?><?php endif; ?></span>
										<?php
										if($q_select = db()->query("SELECT * FROM ".dbname('messages')." WHERE top_id='".$list->id."' ORDER BY date_update DESC LIMIT 1")) {
											if($q_select->num_rows) {
												$sub_message = $q_select->fetch_object();
												?>
												<span class="text-muted"><b>-</b> <?php echo mb_substr($sub_message->message,0,80,'utf-8'); ?><?php if(strlen($sub_message->message) > 80): ?>...<?php endif; ?></span>
												<?php
											}
										}
										?>
									</a>
								</td>
								<td width="100"><?php echo get_time_late($list->date); ?> önce</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="not-found">
						<?php echo get_alert('Mesaj kutusu boş.', 'warning', false); ?>
					</div>
				<?php endif; ?>

			<?php endif; ?>

		</div> <!-- /.panel -->
	</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->










<?php get_footer(); ?>