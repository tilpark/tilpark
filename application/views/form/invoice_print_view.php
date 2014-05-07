<?php $invoice = get_invoice($invoice_id);  $i = $invoice; ?>
<?php $account = get_account($invoice['account_id']); $a = $account; ?>

<?php $css = get_option(array('option_group'=>'print_invoice_form_css', 'option_key'=>'css')); ?>
<style>
<?php echo $css['option_value']; ?>
</style>


<?php
$page = get_option(array('option_group'=>'print_invoice_form_page','option_key'=>'page'));
?>

<?php
function print_value($value, $type)
{
	if($type == 'label')
	{
		$search = "/{(.*?)}/i";
		preg_match($search, $value, $return);
		return $return[1];
	}
	if($type == 'key')
	{
		$search = "/\[(.*?)\]/i";
		preg_match($search, $value, $return);
		return $return[1];
	}
}




function print_invoice_form_data($value, $invoice, $account)
{
	$search = "/\[(.*?)\]/i";
	preg_match($search, $value, $return);
	if(!$return)
	{
		return '';
	}
	$key = $return[1];
	$html_key = $key;
	$key = strip_tags($key);
	
	
	if(strstr($key, 'INV_'))
	{
		$key = str_replace('INV_', '', $key);
		return $invoice[$key];	
	}
	
	if(strstr($key, 'ACC_'))
	{
		$key = str_replace('ACC_', '', $key);
		return $account[$key];	
	}
	
	if(strstr($key, 'ITM_'))
	{
		$key = str_replace('ITM_', '', $key);
		if($key == 'items')
		{
				
		}
	}
}
?>


<?php
$this->db->where('option_group', 'print_invoice_form');
$service_forms = $this->db->get('options')->result_array();
?> 
<?php foreach($service_forms as $form): ?>
<div style="left:<?php echo ($form['option_value']); ?>px; top:<?php echo ($form['option_value2']); ?>px; position:absolute;">
	<?php echo @stripslashes(print_value($form['option_value3'], 'label')); ?>
	<?php echo stripslashes(print_invoice_form_data($form['option_value3'], $i, $a)); ?>
    
    <?php if(strstr($form['option_value3'], 'ITM_items')): ?>
    <?php
	$this->db->where('status', 1);
	$this->db->where('invoice_id', $invoice['id']);
	$items = $this->db->get('fiche_items')->result_array();
	?>
	
    
    <?php $width_code = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_code')); ?>
    <?php $width_name = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_name')); ?>
    <?php $width_quantity = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_quantity')); ?>
    <?php $width_quantity_price = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_quantity_price')); ?>
    <?php $width_total = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_total')); ?>
    <?php $width_tax_rate = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_tax_rate')); ?>
    <?php $width_tax = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_tax')); ?>
    <?php $width_sub_total = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_sub_total')); ?>
    
	<table class="table table-hover table-bordered table-condensed" style="width:100%;">
		<?php if(!strstr($form['option_value3'], 'no_title')): ?>
        <thead>
			<tr>
				<th width="<?php echo $width_code['option_value']; ?>"><?php lang('Barcode Code'); ?></th>
				<th width="<?php echo $width_name['option_value']; ?>"><?php lang('Product Name'); ?></th>
				<th width="<?php echo $width_quantity['option_value']; ?>"><?php lang('Quantity'); ?></th>
				<th width="<?php echo $width_quantity_price['option_value']; ?>"><?php lang('Quantity Price'); ?></th>
				<th width="<?php echo $width_total['option_value']; ?>"><?php lang('Total'); ?></th>
				<th width="<?php echo $width_tax_rate['option_value']; ?>"><?php lang('Tax Rate'); ?></th>
				<th width="<?php echo $width_tax['option_value']; ?>"><?php lang('Tax'); ?></th>
				<th width="<?php echo $width_sub_total['option_value']; ?>"><?php lang('Sub Total'); ?></th>
			</tr>
		</thead>
        <?php endif; ?>
		<tbody>
		<?php foreach($items as $item): ?>
			<?php
			if($item['product_id'] > 0)
			{
				$product = get_product($item['product_id']);
			}
			else
			{
				$product['id'] = '';
				$product['code'] = $item['product_code'];	
				$product['name'] = $item['product_name'];	
			}
			// is serial number
			$item_serial['serial'] = '';
			if($item['product_serial_id'] > 0)
			{
				$this->db->where('id', $item['product_serial_id']);
				$item_serial = $this->db->get('product_serials')->row_array();	
			}
			?>
			<tr>
				<td width="<?php echo $width_code['option_value']; ?>">
					<?php echo $product['code']; ?><?php if($item_serial['serial']):?> [<?php echo $item_serial['serial']; ?>]<?php endif; ?></a>
				</td>
				<td width="<?php echo $width_name['option_value']; ?>">
					<?php echo $product['name']; ?>
				</td>
				<td class="text-center" width="<?php echo $width_quantity['option_value']; ?>"><?php echo $item['quantity']; ?></td>
				<td class="text-right" width="<?php echo $width_quantity_price['option_value']; ?>"><?php echo get_money($item['quantity_price']); ?></td>
				<td class="text-right" width="<?php echo $width_total['option_value']; ?>"><?php echo get_money($item['total']); ?></td>
				<td class="text-center" width="<?php echo $width_tax_rate['option_value']; ?>">% (<?php echo $item['tax_rate']; ?>)</td>
				<td class="text-right" width="<?php echo $width_tax['option_value']; ?>"><?php echo get_money($item['tax']); ?></td>
				<td class="text-right" width="<?php echo $width_sub_total['option_value']; ?>"><?php echo get_money($item['sub_total']); ?></td>
			</tr>	
		<?php endforeach; ?>
		</tbody>
        <?php if(!strstr($form['option_value3'], 'no_footer')): ?>
		<tfoot>
			<tr class="fs-14 no-strong">
				<th colspan="2" class="text-center no-strong"><?php lang('Grand Total'); ?></th>
				<th class="text-center no-strong text-danger"><?php echo $invoice['quantity']; ?></th>
				<th></th>
				<th colspan="1" class="text-right no-strong text-danger"><?php echo get_money($invoice['total']); ?></th>
				<th colspan="2" class="text-center no-strong text-danger"><?php echo get_money($invoice['tax']); ?></th>
				<th class="text-right fs-16 no-strong text-danger"><?php echo get_money($invoice['grand_total']); ?></th>
			</tr>
		</tfoot>
        <?php endif; ?>
	</table>
	<!-- /items -->
    <?php endif; ?>
    
</div>
<?php endforeach; ?>


<?php
$this->db->where('option_group', 'print_invoice_form_custom_text');
$service_forms = $this->db->get('options')->result_array();
?> 
<?php foreach($service_forms as $form): ?>
<div style="left:<?php echo ($form['option_value']); ?>px; top:<?php echo ($form['option_value2']); ?>px; position:absolute;">
	<?php echo $form['option_value3']; ?>
</div>
<?php endforeach; ?>


<?PHP sleep(1); ?>
<script>
function goBack()
{
window.history.back()
}
</script>
<script>window.print(goBack());</script>