<?php include('../../../tilpark.php'); ?>
<?php get_header(); ?>


<?php
add_page_info('title', 'Görev Yöneticisi');
add_page_info('nav', array('name'=>'Görev Yöneticisi'));



# gorev kutusu
if(isset($_GET['box'])) {
	$box = 'inbox';
	if($_GET['box'] == 'inbox') { $box = 'inbox'; }
	elseif($_GET['box'] == 'outbox') { $box = 'outbox'; }
	elseif($_GET['box'] == 'trash') { $box = 'trash'; }
} else { $box = 'inbox'; }

# durum bilgisi
if(isset($_GET['type_status'])) {
	$type_status = input_check($_GET['type_status']);
}



## gorev silme veya aktif etme
if(isset($_GET['move'])) {
	if($task = get_task($_GET['id'])) {
		$_args = array();
			
		# cop kutusuna tasi
		if($_GET['move'] == 'trash') { // cop kutusuna tasi
			if($task->sen_u_id == get_active_user('id')) {
				$_args['sen_trash_u_id'] = get_active_user('id');
			} elseif($task->rec_u_id == get_active_user('id')) {
				$_args['rec_trash_u_id'] = get_active_user('id');
			} else { til_exit(__LINE__); }
		} else { // cop kutusundan cikar
			if($task->sen_trash_u_id == get_active_user('id')) {
				$_args['sen_trash_u_id'] = '0';
			} elseif($task->rec_trash_u_id == get_active_user('id')) {
				$_args['rec_trash_u_id'] = '0';
			}
		}


		if(db()->query("UPDATE ".dbname('messages')." SET ".sql_update_string($_args)." WHERE id='".$task->id."'")) {
			if(db()->affected_rows) {
				if($_GET['move'] == 'trash') {
					add_alert(_b($task->title).' konulu görev <i class="fa fa-trash"></i> çöp kutusuna <span class="underline">taşındı</span>.', 'warning', false);
				} else {
					add_alert(_b($task->title).' konulu görev <i class="fa fa-trash"></i> çöp kutusuna <span class="underline">çıkarıldı</span>.', 'warning', false);
				}
			}
		}

	} else { add_alert('Görev ID bulunamadı.', 'warning', false); }
}



## gorevleri cagir
$_args = array();
if($box == 'inbox') {
	if(!isset($type_status)) {
		$_args['query'] = _get_query_task('inbox');
	} else {
		if($type_status == '0') { $_args['query'] = _get_query_task('inbox-open'); } elseif($type_status == '1') { $_args['query'] = _get_query_task('inbox-close'); }
	}
} elseif($box == 'outbox') {
	if(!isset($type_status)) {
		$_args['query'] = _get_query_task('outbox');
	} else {
		if($type_status == '0') { $_args['query'] = _get_query_task('outbox-open'); } elseif($type_status == '1') { $_args['query'] = _get_query_task('outbox-close'); }
	}
} elseif($box == 'trash') {
	$_args['query'] = _get_query_task('trash');
} else {
	$_args['query'] = get_query_task('inbox');
}

$tasks = get_tasks($_args);
?>


<div class="row">
	<div class="col-md-3">
		<?php include('_sidebar.php'); ?>
	</div> <!-- /.col-md-3 -->
	<div class="col-md-9">
		<?php print_alert(); ?>
		<div class="panel panel-default panel-table panel-dataTable">
			<?php if($tasks): ?>
			<table class="table table-hover table-striped table-condensed dataTable">
				<thead class="hidden">
					<tr>
						<th></th>
						<th>Durum</th>
						<th>Atayan</th>
						<th>Atanan</th>
						<th>Konu</th>
						<th>Başlama</th>
						<th>Bitirme</th>
						<th>Bar</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($tasks as $task): ?>
						<?php $task = get_task($task->id); ?>
						<tr class="<?php if(!$task->read_it and $task->inbox_u_id == get_active_user('id')): ?>bold<?php endif; ?> pointer" onclick="location.href='<?php site_url('task', $task->id); ?>';">
							<td width="10">
								<?php if($task->type_status == '1'): ?>
									<?php if($task->sen_trash_u_id == get_active_user('id') OR $task->rec_trash_u_id == get_active_user('id')): ?>
										<a href="?id=<?php echo $task->id; ?>&move=null&box=trash" class="btn btn-default btn-xs" data-toggle="tooltip" title="Çöp kutusundan çıkar"><i class="fa fa-undo text-warning"></i></a>																			
									<?php else: ?>
										<a href="?id=<?php echo $task->id; ?>&move=trash" class="btn btn-default btn-xs" data-toggle="tooltip" title="Çöp kutusuna taşı"><i class="fa fa-trash-o text-danger"></i></a>									
									<?php endif; ?>
								<?php else: ?>
									<a href="#" class="btn btn-default btn-xs disabled" title=""><i class="fa fa-trash text-muted"></i></a>
								<?php endif; ?>
							</td>
							<td width="40"><?php echo $task->type_status == '0' ? 'AÇIK' : 'KAPALI'; ?></td>
							<td width="140">
								<div class="pull-left" style="margin-right:5px;">
									<img src="<?php user_info($task->sen_u_id, 'avatar'); ?>" class="img-responsive br-2 pull-right" width="21">
								</div>
								<?php user_info($task->sen_u_id,'surname'); ?>
							</td>
							<td width="140">
								<div class="pull-left" style="margin-right:5px;">
									<img src="<?php user_info($task->rec_u_id, 'avatar'); ?>" class="img-responsive br-2 pull-right" width="21">
								</div>
								<?php user_info($task->rec_u_id,'surname'); ?>
							</td>
							<td><a href="<?php site_url('task', $task->id); ?>"><?php echo $task->title; ?></td>
							<td><?php echo til_get_date($task->date_start,'datetime'); ?></td>
							<td><?php echo til_get_date($task->date_end,'datetime'); ?></td>
							<td>
								<?php if($task->choice_count): ?>
									<?php
										$part 			= (100 / $task->choice_count);
										$part_completed = round($part * $task->choice_closed);

										# progress-bar style
										$progressbar_style = '';
										if($part_completed < 30) {
											$progressbar_style = 'progress-bar-danger';
										} elseif($part_completed < 70) {
											$progressbar_style = 'progress-bar-warning';
										} else {
											$progressbar_style = 'progress-bar-success';
										}
									?>

									<div class="progress m-0 br-2">
										<div class="progress-bar progress-bar-stripedd <?php echo $progressbar_style; ?> text-muted" role="progressbar" aria-valuenow="<?php echo $part_completed; ?>" aria-valuemin="30" aria-valuemax="100" style="width: <?php echo ($part_completed == '0' ? '25' : $part_completed); ?>%;">
											<span class="sr-only"><?php echo $part_completed; ?>% tamamlandı</span>
											%<?php echo $part_completed; ?> tamamlandı
										</div> <!-- /.progess-bar -->
									</div> <!-- /.progress -->

								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php else: ?>
				<div class="not-found">
					<?php echo get_alert('Görev ataması bulunamadı.', 'warning', false); ?>
				</div>
			<?php endif; ?>
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->




<?php get_footer(); ?>