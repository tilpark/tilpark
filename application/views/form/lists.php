<ol class="breadcrumb">
	<li><a href="<?php echo site_url(''); ?>"><?php lang('Dashboard'); ?></a></li>
	<li><a href="<?php echo site_url('form'); ?>">Form Yönetimi</a></li>
	<li class="active">Formlar</li>
</ol>


<?php $accounts = get_account_list_for_array(); ?>

<table class="table table-bordered table-hover table-condensed dataTable">
	<thead>
    	<tr>
        	<th class="hide"></th>
        	<th width="80">İşlem ID</th>
            <th width="120">Tarih</th>
            <th width="50">G/Ç</th>
            <th><?php lang('Account Card'); ?></th>
            <th width="50"><?php lang('Products'); ?></th>
            <th width="100"><?php lang('Grand Total'); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php 
	$this->db->where('status', 1);
	$this->db->where('type', 'invoice');
	$this->db->order_by('ID', 'DESC');
	$invoices = $this->db->get('forms')->result_array();
	?>
    
    <?php foreach($invoices as $invoice): ?>
    	<tr>
        	<td class="hide"></td>
        	<td><a href="<?php echo site_url('form/view/'.$invoice['id']); ?>">#<?php echo $invoice['id']; ?></a></td>
            <td><?php echo substr($invoice['date'],0,16); ?></td>
            <td><?php echo get_text_in_out($invoice['in_out']); ?></td>
            <td><a href="<?php echo site_url('account/get_account/'.$invoice['account_id']); ?>" target="_blank"><?php echo @$accounts[$invoice['account_id']]['name']; ?></a></td>
            <td class="text-center"><?php echo $invoice['quantity']; ?></td>
            <td class="text-right"><?php echo get_money($invoice['grand_total']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table> <!-- /.table -->
