<?php require_once('../../tilpark.php'); ?>
<?php 
if(!$item = get_item($_GET['id'])) {
	add_console_log('Ürün kartı bulunamadı.', 'print-statement.php');
}
?>
<?php include_content_page('print', 'statement', 'item', array('item'=>@$item)); ?>


<title>Ürün Ekstre | <?php echo $item->name; ?></title>

<?php 
	$print['title'] = 'ÜRÜN EKSTRE';
	$print['sub-title'] = $item->name;
	$print['date']	= til_get_date(date('Y-m-d H:i'), 'd F Y H:i');
	$print['barcode'] = $item->code;
?>
<?php get_header_print($print); ?>

<?php $q_form_items = db()->query("SELECT * FROM ".dbname('form_items')." WHERE status='1' AND item_id='".$item->id."' ORDER BY date DESC"); ?>
<?php if($q_form_items->num_rows): ?>
	<table class="table table-striped table-hover table-condensed table-bordered dataTable">
		<thead>
			<tr>
				<th width="100">Tarih</th>
				<th width="80">Form ID</th>
				<th width="30">G/Ç</th>
				<th>Hesap Kartı</th>
				<th width="60" class="text-center">Adet</th>
				<th width="80" class="text-center">B. Fiyatı</th>
				<th width="80" class="text-center">Giriş</th>
				<th width="80" class="text-center">Çıkış</th>
			</tr>
		</thead>
		<tbody>
			<?php while($list = $q_form_items->fetch_object()): ?>
				<tr id="<?php echo $list->id; ?>">
					<td class="text-muted fs-11"><?php echo til_get_date($list->date, 'Y-m-d H:i'); ?></td>
					<td>#<?php echo $list->form_id; ?></td>
					<td><?php echo get_in_out_label($list->in_out); ?></td>
					<td>
						<?php if($list->account_id): ?>
							<?php echo get_account($list->account_id)->name; ?>
						<?php endif; ?>
					</td>
					<td class="text-center"><?php echo $list->quantity; ?></td>
					<td class="text-right"><?php echo get_set_money($list->price, true); ?></td>
					<td class="text-right"><?php echo $list->in_out == '0' ? get_set_money($list->total, true) : ''; ?></td>
					<td class="text-right"><?php echo $list->in_out == '1' ? get_set_money($list->total, true) : ''; ?></td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
<?php else: ?>
<?php endif; ?>

<?php get_footer_print(); ?>