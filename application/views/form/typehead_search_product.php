<meta charset="utf-8" />

<div class="ajax_search_box">
<?php if($products): ?>
<table class="table table-bordered table-hover table-condensed">
    <tbody>
    <?php foreach($products as $product): ?>
    	<tr>
        	<td class="">
            	<div class="pointer select_account" style="height:40px;"
                	data-id="<?php echo $product['id']; ?>"
                	data-code="<?php echo $product['code']; ?>"
                    data-name="<?php echo $product['name']; ?>"
                    data-tax_free_cost_price="<?php echo $product['tax_free_cost_price']; ?>"
                    data-sale_price="<?php echo $product['sale_price']; ?>"
                    data-tax_free_sale_price="<?php echo $product['tax_free_sale_price']; ?>"
                    data-sale_price="<?php echo $product['sale_price']; ?>"
                    data-tax_rate="<?php echo $product['tax_rate']; ?>"
                >
                	<h4 style="margin:5px 0px; padding:0px;">
						<small class="pull-left"><?php echo mb_substr($product['code'],0,30, 'utf-8'); ?></small>
                        <?php if(isset($_GET['cost_price'])): ?>
                            <small class="pull-right"><?php echo get_money($product['cost_price']); ?> TL</small>
                        <?php else: ?>
                            <small class="pull-right"><?php echo get_money($product['sale_price']); ?> TL</small>
                        <?php endif; ?>
                    </h4>
                    <br />
                    <small class="pull-left" style="width:80%;"><?php echo mb_substr($product['name'],0,100, 'utf-8'); ?></small>
                    <small class="pull-right <?php if($product['amount'] <= 0):?>text-danger<?php else: ?>text-success<?php endif; ?>">stok: <span class="fs-12"><?php echo get_quantity($product['amount']); ?></span></small>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="h10"></div>
    <?php alertbox('alert-danger', 'Stok Kartı Bulunamadı', '<strong>'.$text.'</strong> stok kartları aramasında bulunamadı.', false); ?>
<?php endif; ?>
</div>

<script>
alert('merhaba');
$('.select_account').click(function(){
	$('#code').val($(this).attr('data-code'));
    $('#product_name').val($(this).attr('data-name'));
	$('#tax_rate').val($(this).attr('data-tax_rate'));
	<?php if(isset($_GET['cost_price'])): ?>
		$('#quantity_price').val($(this).attr('data-tax_free_cost_price'));
	<?php else: ?>
		$('#quantity_price').val($(this).attr('data-tax_free_sale_price'));
	<?php endif; ?>
    $('#amount').focus();
	calc();
});
</script>