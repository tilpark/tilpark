<ol class="breadcrumb">
  <li><a href="<?php echo site_url(); ?>"><?php lang('Dashboard'); ?></a></li>
  <li><a href="<?php echo site_url('account'); ?>"><?php lang('Account'); ?></a></li>
  <li class="active"><?php lang('Account List'); ?></li>
</ol>

<div class="row">
<div class="col-md-12">

<script>
$(document).ready(function() {
    $('#dataTable_accounts').dataTable( {
        "bProcessing": false,
        "sAjaxSource": 'ajax_account_list',
		"sDom": " <'row'<'col-md-4 hidden-xs hidden-sm'T><'col-md-4 hidden-xs hidden-sm'l><'col-md-4'f>>rt<'row'<'col-md-6 hidden-xs hidden-sm'i><'col-md-6'p>>",
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
        	$('td:eq(5)', nRow).addClass( 'text-right' );
    	}
		
		
    } );
} );
</script>

<table id="dataTable_accounts" class="table table-bordered table-hover table-condensed">
	<thead>
    	<tr>
            <th><?php lang('Account Code'); ?></th>
            <th><?php lang('Account Name'); ?></th>
            <th><?php lang('Name and Surname'); ?></th>
            <th><?php lang('City'); ?></th>
            <th width="100"><?php lang('Phone'); ?></th>
            <th width="100"><?php lang('Balance'); ?></th>
        </tr>
    </thead>
</table>

</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->

<div class="h20"></div>