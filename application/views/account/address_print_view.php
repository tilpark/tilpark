<meta charset="utf-8" />
<?php $account = get_account(array('id'=>$account_id)); ?>
<a href="javascript:;" class="img-thumbnail" onclick="print_barcode();">
    <img src="<?php echo get_barcode($account['code']); ?>" class="img-responsive" />
</a>
<p></p>
<table width="100%">
	<tr>
    	<th style="border:1px solid #000;"><?php lang('Name'); ?></th>
        <td style="border:1px solid #000;"><?php echo $account['name']; ?></td>
    </tr>
    <tr>
    	<th style="border:1px solid #000;"><?php lang('Phone'); ?></th>
        <td style="border:1px solid #000;"><?php echo $account['phone']; ?></td>
    </tr>
    <tr>
    	<th style="border:1px solid #000;"><?php lang('Gsm'); ?></th>
        <td style="border:1px solid #000;"><?php echo $account['gsm']; ?></td>
    </tr>
    <tr>
    	<th style="border:1px solid #000;"><?php lang('E-mail'); ?></th>
        <td style="border:1px solid #000;"><?php echo $account['email']; ?></td>
    </tr>
    <tr>
    	<th style="border:1px solid #000;"><?php lang('Address'); ?></th>
        <td style="border:1px solid #000;"><?php echo $account['address']; ?></td>
    </tr>
    <tr>
    	<th style="border:1px solid #000;"><?php lang('County'); ?></th>
        <td style="border:1px solid #000;"><?php echo $account['county']; ?></td>
    </tr>
    <tr>
    	<th style="border:1px solid #000;"><?php lang('City'); ?></th>
        <td style="border:1px solid #000;"><?php echo $account['city']; ?></td>
    </tr>
</table>


<?php if(isset($_GET['print'])): ?>
<script>
window.print();
</script>
<?php endif; ?>