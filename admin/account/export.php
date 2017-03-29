<?php require_once('../../tilpark.php'); ?>
<meta charset="UTF8">
<title>Hesap Kartlari Listesi | Tilpark</title>
<?php
ini_set('max_execution_time', 300);
ini_set('memory_limit', '-1');

$export_type='';
if(isset($_GET['export'])) {
	$export_type=$_GET['export'];
}
$accounts = get_accounts(array('_GET'=>true));
?>

<?php if($export_type == 'print') { get_header_print(array('title'=>'Hesap Kartları Listesi')); } ?>

<?php if($accounts): ?>
	<?php if($export_type == 'print'): ?>
		<div class="h-20"></div>
		<table class="table table-hover table-bordered table-condensed">
			<tr>
				<th><?php echo get_convert_str_export('Hesap Kodu'); ?></th>
				<th><?php echo get_convert_str_export('Hesap Adı'); ?></th>
				<th><?php echo get_convert_str_export('Cep Telefonu'); ?></th>
				<th><?php echo get_convert_str_export('Sabit Telefon'); ?></th>
				<th><?php echo get_convert_str_export('Şehir'); ?></th>
				<th><?php echo get_convert_str_export('Bakiye'); ?></th>
			</tr>
			<?php foreach($accounts->list as $account): ?>
				<tr>
					<td>
						<?php if( isset($_GET['addBarcode']) ): ?> <img src="<?php get_barcode_url($account->code, array('position'=>'left') ); ?>" /> <br /> <?php endif; ?>
						<?php echo $account->code; ?>
					</td>
					<td><?php echo $account->name; ?></td>
					<td><?php echo $account->gsm; ?></td>
					<td><?php echo $account->phone; ?></td>
					<td><?php echo $account->city; ?></td>
					<td class="text-right" align="right"><?php echo get_set_money($account->balance,true); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		<table>
			<tr>
				<th><?php echo get_convert_str_export('Hesap Adı'); ?></th>
				<th><?php echo get_convert_str_export('Hesap Kodu'); ?></th>
				<th><?php echo get_convert_str_export('Cep Telefonu'); ?></th>
				<th><?php echo get_convert_str_export('Sabit Telefon'); ?></th>
				<th><?php echo get_convert_str_export('Şehir'); ?></th>
				<th><?php echo get_convert_str_export('Bakiye'); ?></th>
			</tr>
			<?php foreach($accounts->list as $account): ?>
				<tr>
					<td><?php echo get_convert_str_export($account->name); ?></td>
					<td><?php echo $account->code; ?></td>
					<td><?php echo $account->gsm; ?></td>
					<td><?php echo $account->phone; ?></td>
					<td><?php echo get_convert_str_export($account->city); ?></td>
					<td class="text-right" align="right"><?php echo get_set_money($account->balance,true); ?></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="6" style="color:#ccc; font-size:10px;"><?php echo get_convert_str_export('tilpark.com ile oluşturulmuştur'); ?></td>
			</tr>
		</table>
	<?php endif; ?>
	
<?php endif; ?>


<?php
if($export_type == 'excel') {
	export_excel('hesap_kartlari_listesi');
}
elseif($export_type == 'pdf') {
	?>
	<style>
		table tr td {
			border-bottom:1px solid #ccc;
		}
	</style>
	<?php
	export_pdf('hesap_kartlari_listesi');
}
elseif($export_type == 'print') {
	get_footer_print();
}
?>