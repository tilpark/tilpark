<ol class="breadcrumb">
  <li><a href="<?php echo site_url(); ?>"><?php lang('Dashboard'); ?></a></li>
  <li><a href="<?php echo site_url('account'); ?>"><?php lang('Account'); ?></a></li>
  <li class="active"><?php lang('Guide'); ?></li>
</ol>

<div class="row">
<div class="col-md-12">

<table class="table table-bordered table-hover table-condensed dataTable">
	<thead>
    	<tr>
        	<th class="hide"></th>
            <th ><?php lang('Account Name'); ?></th>
            <th><?php lang('Name and Surname'); ?></th>
            <th><?php lang('Address'); ?></th>
            <th><?php lang('County'); ?></th>
            <th><?php lang('City'); ?></th>
            <th><?php lang('Phone'); ?></th>
            <th><?php lang('Gsm'); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
	$this->db->where('status', '1');
	$accounts = $this->db->get('accounts')->result_array();
	?>
    <?php foreach($accounts as $account): ?>
    	<tr>
        	<td class="hide"></td>
            <td><a href="<?php echo site_url('account/get_account/'.$account['id']); ?>" target="_blank"><?php echo $account['name']; ?></a></td>
            <td><?php echo $account['name_surname']; ?></td>
            <td><small><?php echo $account['address']; ?></small></td>
            <td><small><?php echo $account['county']; ?></small></td>
            <td><small><?php echo $account['city']; ?></small></td>
            <td><small><?php echo $account['phone']; ?></small></td>
            <td><small><?php echo $account['gsm']; ?></small></td>
        </tr>
    <?php endforeach; ?>
    
    </tbody>
</table>

</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->

<div class="h20"></div>