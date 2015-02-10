<?php page_access(2); ?>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url(); ?>"><?php lang('Dashboard'); ?></a></li>
  <li><a href="<?php echo site_url('account'); ?>"><?php lang('Account'); ?></a></li>
  <li class="active"><?php lang('Options'); ?></li>
</ol>

<?php
if(isset($_POST['update_options']))
{
	$data['option_group'] 	= 'account';
	
	# who_can_see_cost_price
	$data['option_key']		= 'who_can_see_account_balance';
	$data['option_value']	= $_POST['who_can_see_account_balance'];
	update_option($data);
	
	# who_can_edit_product_card
	$data['option_key']		= 'who_can_edit_account_card';
	$data['option_value']	= $_POST['who_can_edit_account_card'];
	update_option($data);
}
?>


<?php
$options['who_can_see_account_balance'] = get_option(array('option_group'=>'account', 'option_key'=>'who_can_see_account_balance'));
$options['who_can_edit_account_card'] = get_option(array('option_group'=>'account', 'option_key'=>'who_can_edit_account_card'));
?>

<div class="row">
	<div class="col-md-4">
<form name="form_product_options" id="form_product_options" action="" method="POST" class="widget">
	<div class="header">Yetkilendirme</div>
    <div class="content">
        <div class="form-group">
            <label for="who_can_see_account_balance" class="control-label"><?php lang('Account balance, who can see it?'); ?></label>
            <select name="who_can_see_account_balance" id="who_can_see_account_balance" class="form-control">
                <option value="5" <?php if($options['who_can_see_account_balance']['option_value']==5){echo'selected';} ?>><?php lang('Staff'); ?></option>
                <option value="4" <?php if($options['who_can_see_account_balance']['option_value']==4){echo'selected';} ?>><?php lang('Authorized Personnel'); ?></option>
                <option value="3" <?php if($options['who_can_see_account_balance']['option_value']==3){echo'selected';} ?>><?php lang('Chief'); ?></option>
                <option value="2" <?php if($options['who_can_see_account_balance']['option_value']==2){echo'selected';} ?>><?php lang('Admin'); ?></option>
                <option value="1" <?php if($options['who_can_see_account_balance']['option_value']==1){echo'selected';} ?>><?php lang('Super Admin'); ?></option>                      
            </select>
        </div>
        
        
        <div class="form-group">
            <label for="who_can_edit_account_card" class="control-label"><?php lang('Who can edit the account cards?'); ?></label>
            <select name="who_can_edit_account_card" id="who_can_edit_account_card" class="form-control">
                <option value="5" <?php if($options['who_can_edit_account_card']['option_value']==5){echo'selected';} ?>><?php lang('Staff'); ?></option>
                <option value="4" <?php if($options['who_can_edit_account_card']['option_value']==4){echo'selected';} ?>><?php lang('Authorized Personnel'); ?></option>
                <option value="3" <?php if($options['who_can_edit_account_card']['option_value']==3){echo'selected';} ?>><?php lang('Chief'); ?></option>
                <option value="2" <?php if($options['who_can_edit_account_card']['option_value']==2){echo'selected';} ?>><?php lang('Admin'); ?></option>
                <option value="1" <?php if($options['who_can_edit_account_card']['option_value']==1){echo'selected';} ?>><?php lang('Super Admin'); ?></option>                      
            </select>
        </div>
              
       
        <div class="text-right">    
            <input type="hidden" name="update_options" /> 
            <button class="btn btn-default"><?php lang('Save'); ?></button> 
        </div> <!-- /.text-right -->  
	</div> <!-- /.content -->              
</form>
	</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->