<?php if(get_the_current_user('role') > 3): ?>
	<?php alertbox('alert-danger', get_lang('Not authorized to access.').''); ?>
<?php else: ?>
<?php
if(isset($_GET['status']))
{
	$this->db->where('id', $user_id);
	$this->db->update('users', array('status'=>$_GET['status']));
}
?>

<?php $user = get_user(array('id'=>$user_id)); ?>
<legend id="page_title" class="ff-1 danger"><?php echo $user['display_name']; ?></legend>

<div class="row">
<div class="col-md-8">

<?php if($user['status'] == 0): ?>
	<?php alertbox('alert-warning', get_lang('This user has been deleted.').' <a href="?status=1" class="text-success pull-right">"'.get_lang('Activate').'"</a>', '', false); ?>
<?php endif; ?>

<?php
if(isset($_POST['update']))
{
	$continue = true;
	$this->form_validation->set_rules('email', get_lang('E-mail'), 'required|min_length[3]|max_length[50]');
	$this->form_validation->set_rules('name', get_lang('Name'), 'required|min_length[2]|max_length[20]');
	$this->form_validation->set_rules('surname', get_lang('Surname'), 'required|min_length[2]|max_length[20]');
	$this->form_validation->set_rules('password', get_lang('Password'), 'min_length[4]|max_length[32]');

	if ($this->form_validation->run() == FALSE)
	{
		alertbox('alert-danger', '', validation_errors());
	}
	else
	{
		$data['email'] = $this->input->post('email');
		$data['name'] = $this->input->post('name');
		$data['surname'] = $this->input->post('surname');
		if($_POST['password'] != ''){ $data['password'] = md5($this->input->post('password')); }
		$data['role'] = $this->input->post('role');
		
		// Have barcode?
		$this->db->where('status', '1');
		$this->db->where('email', $data['email']);
		$this->db->where_not_in('id', $user['id']);
		$query = $this->db->get('users')->result_array();
		if($query)
		{
			alertbox('alert-danger', get_lang('E-mail address is registered.'));
			$continue = false;
		}
		
	
		if($continue)
		{
			if(update_user($user['id'], $data))
			{
				alertbox('alert-success', get_lang('Operation is Successful'), '');	
				$user = get_user(array('id'=>$user_id));
				?>
                <script>$(document).ready(function(){$('#page_title').html('<?php echo $user['display_name']; ?>'); });</script>
                <?php
			}
		}
	
		
		
		
	}
}
?>


<form name="form_new_product" id="form_new_product" action="" method="POST" class="validation">
    <div class="row">
        <div class="col-md-6">
               
            <div class="form-group">
                <label for="email" class="control-label ff-1 fs-16"><?php lang('E-mail'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input type="text" id="email" name="email" class="form-control input-lg ff-1 required email" placeholder="<?php lang('E-mail'); ?>" minlength="3" maxlength="50" value="<?php echo $user['email']; ?>" readonly="readonly" />
                </div>
            </div> <!-- /.form-group -->
            <div class="form-group">
                <label for="password" class="control-label ff-1 fs-16"><?php lang('Password'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-sound-7-1"></span></span>
                    <input type="password" id="password" name="password" class="form-control input-lg ff-1" placeholder="<?php lang('Password'); ?>" minlength="4" maxlength="32" value="" <?php if(strstr($_SERVER['SERVER_NAME'], 'tilpark.com')){echo 'readonly="readonly"';}; ?>>
                </div>
            </div>
            
    
                              
        </div> <!-- /.col-md-6 -->
        <div class="col-md-6">
            <div class="form-group">
            	<label for="role" class="control-label ff-1 fs-16"><?php lang('Role'); ?></label>
                <select name="role" id="role" class="form-control input-lg">
                  <option value="5" <?php if($user['role']==5){echo'selected';} ?>><?php lang('Staff'); ?></option>
                  <option value="4" <?php if($user['role']==4){echo'selected';} ?>><?php lang('Authorized Personnel'); ?></option>
                  <option value="3" <?php if($user['role']==3){echo'selected';} ?>><?php lang('Chief'); ?></option>
                  <option value="2" <?php if($user['role']==2){echo'selected';} ?>><?php lang('Admin'); ?></option>
                  <option value="1" <?php if($user['role']==1){echo'selected';} ?>><?php lang('Super Admin'); ?></option>
                </select>
            </div> <!-- /.form-group -->
            
            <div class="form-group">
                <label for="name" class="control-label ff-1 fs-16"><?php lang('Name'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                    <input type="text" id="name" name="name" class="form-control input-lg ff-1 required" placeholder="<?php lang('Name'); ?>" minlength="2" maxlength="20" value="<?php echo $user['name']; ?>">
                </div>
            </div> <!-- /.form-group -->
            
            <div class="form-group">
                <label for="surname" class="control-label ff-1 fs-16"><?php lang('Surname'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                    <input type="text" id="surname" name="surname" class="form-control input-lg ff-1 required" placeholder="<?php lang('Surname'); ?>" minlength="2" maxlength="20" value="<?php echo $user['surname']; ?>">
                </div>
            </div> <!-- /.form-group -->
           
        </div> <!-- /.col-md-6 -->
    </div> <!-- /.row -->

    <div class="text-right">
        <input type="hidden" name="update" />
        <?php if($user['status'] == 1): ?>
        	<a href="?status=0" class="btn btn-danger btn-lg"><?php lang('Delete'); ?></a>
        	<button class="btn btn-success btn-lg"><?php lang('Update'); ?> &raquo;</button>
   		<?php endif; ?>
    </div> <!-- /.text-right -->
</form>
</div> <!-- /.col-md-8 -->
<div class="col-md-4">
	<span class="help-block note">
        <h4><span class="glyphicon glyphicon-info-sign"></span> <?php lang('information'); ?></h4>
        <ul class="note">
            <li><?php lang('Please enter a valid e-mail address.'); ?></li>
            <li><?php lang('User authorization important.'); ?></li>
            <li><?php lang('Consists of automatic bar code to the user.'); ?></li>
            <li><?php lang('Super administrator access on every page.'); ?></li>
        </ul>
    </span>
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->

<div class="h20"></div>
<?php endif; ?>