<?php include('../../tilpark.php'); ?>
<?php
ini_set('max_execution_time', 300);
ini_set('memory_limit', '-1');

$export_type='';
if(isset($_GET['export'])) {
	$export_type=$_GET['export'];
}

$accounts = get_items(array('_GET'=>true));
?>
<?php if($accounts): ?>
	<table>
			<tr>
				<th><?php echo get_convert_str_export('Ürün Adı'); ?></th>
				<th><?php echo get_convert_str_export('Ürün Kodu'); ?></th>
				<th><?php echo get_convert_str_export('Maliyet Fiyatı'); ?></th>
				<th><?php echo get_convert_str_export('Satış Fiyatı'); ?></th>
				<th><?php echo get_convert_str_export('Adet'); ?></th>
			</tr>
		<?php foreach($accounts->list as $account): ?>
			<tr>
				<td><?php echo $account['name']; ?></td>
				<td><?php echo $account['code']; ?></td>
				<td><?php echo $account['p_purc']; ?></td>
				<td><?php echo $account['p_sale']; ?></td>
				<td><?php echo $account['quantity']; ?></td>
			</tr>
		<?php endforeach; ?>
			<tr>
				<td colspan="6" style="color:#ccc; font-size:10px;"><?php echo get_convert_str_export('tilpark.com ile oluşturulmuştur'); ?></td>
			</tr>
	</table>
<?php endif; ?>


<?php
if($export_type == 'excel') {
	export_excel('urun_kartlari_listesi');
}
elseif($export_type == 'pdf') {
	?>
	<style>
		table tr td {
			border-bottom:1px solid #ccc;
		}
	</style>
	<?php
	export_pdf('urun_kartlari_listesi');
}
elseif($export_type == 'print') {
	?>
	<style>
		table {
			border-collapse: collapse;
		}
		table tr td, table tr th {
			border:1px solid #ccc;

		}
	</style>
	<script>
		window.print();
	</script>	
	<?php
}
?>