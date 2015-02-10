<ol class="breadcrumb">
	<li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
	<li><a href="<?php echo site_url('payment'); ?>">Kasa</a></li>
	<li class="active">Ödeme Listesi</li>
</ol>

<?php $accounts = get_account_list_for_array(); ?>

<table class="table table-bordered table-hover table-condensed dataTable">
	<thead>
    	<tr>
        	<th class="hide"></th>
        	<th width="10"><?php lang('ID'); ?></th>
            <th width="100"><?php lang('Date'); ?></th>
            <th width="50">G/Ç</th>
            <th>Hesap Kartı</th>
            <th width="100">Ödeme Türü</th>
            <th width="100">Banka</th>
            <th width="80">Tahsilat</th>
            <th width="80">Ödeme</th>
        </tr>
    </thead>
    <tbody>    
    <?php foreach($forms as $form): ?>
    	<tr>
        	<td class="hide"></td>
        	<td class="fs-11"><a href="<?php echo site_url('payment/view/'.$form['id']); ?>">#<?php echo $form['id']; ?></a></td>
            <td class="fs-11"><?php echo substr($form['date'],0,16); ?></td>
            <td class="fs-11"><?php echo get_text_in_out($form['in_out']); ?></td>
            <td>
            	<?php if($form['account_id'] > 0): ?>
                	<a href="<?php echo site_url('account/view/'.$form['account_id']); ?>" target="_blank"><?php echo $form['name']; ?></a>
            	<?php else: ?>
                	<?php echo $form['name']; ?>
                <?php endif; ?>
            </td>
            <td><?php echo get_text_payment_type($form['val_1']); ?></td>
            <td><?php echo $form['val_2']; ?></td>
            <?php if($form['in_out'] == 'in'): ?>
            <td class="text-right"><?php echo get_money($form['grand_total']); ?></td>
            <td></td>
            <?php else: ?>
            <td></td>
            <td class="text-right"><?php echo get_money($form['grand_total']); ?></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table> <!-- /.table -->
