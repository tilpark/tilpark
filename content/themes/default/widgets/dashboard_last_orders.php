<?php $q_last_10_orders = db()->query("SELECT * FROM ".dbname('forms')." WHERE in_out='1' ORDER BY date DESC LIMIT 10"); ?>
<?php if($q_last_10_orders->num_rows): ?>


		<table class="table table-hover table-condensed table-striped">
			<thead>
				<tr>
					<th>Form ID</th>
					<th>Tarih</th>
					<th>Durum</th>
					<th>Hesap Kartı</th>
					<th>Tutar</th>
				</tr>
			</thead>
			<tbody>
			<?php while($list = $q_last_10_orders->fetch_object()): ?>
				<?php $form_status = get_form_status($list->status_id); ?>
				<tr>
					<td><a href="<?php site_url('admin/form/detail.php?id='.$list->id); ?>">#<?php echo $list->id; ?></a></td>
					<td><small class="text-muted"><?php echo get_time_late($list->date); ?> önce</small></td>
					<td><?php echo get_form_status_span($form_status, array('short'=>true)); ?></td>
					<td><?php echo $list->account_name; ?></td>
					<td class="text-right"><?php echo get_set_money($list->total,true); ?></td>
				</tr>
			<?php endwhile; ?>
			</tbody>
		</table>

<?php endif; ?>