<?php include('../../tilpark.php'); ?>
<meta charset="UTF-8">
<title>Form Listesi | Tilpark</title>
<?php
ini_set('max_execution_time', 300);
ini_set('memory_limit', '-1');

$export_type='';
if(isset($_GET['export'])) {
	$export_type=$_GET['export'];
}

// ilk liste acilisinde sıralama yapilmasi icin
if(!isset($_GET['orderby_name'])) {
	$_GET['orderby_name'] = 'id';
	$_GET['orderby_type'] = 'DESC'; 
}

$forms = get_forms(array('_GET'=>true))
?>

<?php if($export_type == 'print') { get_header_print(array('title'=>'Form Listesi')); } ?>

<?php if($forms): ?>
	<?php if($export_type == 'print'): ?>
		<div class="h-20"></div>
		<table class="table table-hover table-bordered table-condensed">
			<thead>
				<tr>
					<th width="100">ID</th>
					<th width="200">Form Durumu</th>
					<th width="120">Tarih</th>
					<th>Hesap Kartı</th>
					<th width="100">Telefon</th>
					<th width="80">Ürünler</th>
					<th width="100">Toplam</th>
				</tr>
			</thead>
			<?php foreach($forms->list as $form): ?>
				<?php $form_status = get_form_status($form->status_id); ?>
				<tr>
					<td>
						<?php if( isset($_GET['addBarcode']) ): ?> <img src="<?php get_barcode_url($form->id, array('position'=>'left') ); ?>" /> <br /> <?php endif; ?>
						#<?php echo $form->id; ?>
					</td>
					<td class="fs-11 text-muted"><?php echo $form_status->name; ?></td>
					<td class="fs-11 text-muted"><?php echo substr($form->date,0,16); ?></td>
					<td><?php echo $form->account_name; ?></td>
					<td><?php echo $form->account_gsm; ?></td>
					<td class="text-center"><span class="text-muted"  data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $form->item_count; ?> farklı ürün"><?php echo $form->item_quantity; ?> adet</span></td>
					<td class="text-right"><?php echo get_set_money($form->total, true); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>

	<?php else: ?>
		<table>
			<tr>
				<tr>
					<th><?php echo get_convert_str_export('ID'); ?></th>
					<th><?php echo get_convert_str_export('Form Durumu'); ?></th>
					<th><?php echo get_convert_str_export('Tarih'); ?></th>
					<th><?php echo get_convert_str_export('Hesap Kartı'); ?></th>
					<th><?php echo get_convert_str_export('Telefon'); ?></th>
					<th><?php echo get_convert_str_export('Ürünler'); ?></th>
					<th><?php echo get_convert_str_export('Toplam'); ?></th>
				</tr>
			</tr>
			<?php foreach($forms->list as $form): ?>
				<?php $form_status = get_form_status($form->status_id); ?>
				<tr>
					<td>#<?php echo $form->id; ?></td>
					<td class="fs-11 text-muted"><?php echo get_convert_str_export($form_status->name); ?></td>
					<td class="fs-11 text-muted"><?php echo substr($form->date,0,16); ?></td>
					<td><?php echo get_convert_str_export($form->account_name); ?></td>
					<td><?php echo $form->account_gsm; ?></td>
					<td class="text-center"><span class="text-muted"  data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $form->item_count; ?> farklı ürün"><?php echo $form->item_quantity; ?> adet</span></td>
					<td class="text-right"><?php echo get_set_money($form->total, true); ?></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="7" style="color:#ccc; font-size:10px;"><?php echo get_convert_str_export('tilpark.com ile oluşturulmuştur'); ?></td>
			</tr>
		</table>
	<?php endif; ?>

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
	get_footer_print();
}
?>