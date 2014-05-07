<?php page_access(2); ?>

<legend class="ff-1"><?php lang('New User'); ?></legend>



<div class="row">
<div class="col-md-8">
<?php
$user['email'] = '';
$user['password'] = '';
$user['password_again'] = '';
$user['name'] = '';
$user['surname'] = '';
$user['role'] = '';


if(isset($_POST['add_product']))
{
	$continue = true;
	$this->form_validation->set_rules('email', get_lang('E-mail'), 'required|min_length[3]|max_length[50]');
	$this->form_validation->set_rules('name', get_lang('Name'), 'required|min_length[2]|max_length[20]');
	$this->form_validation->set_rules('surname', get_lang('Surname'), 'required|min_length[2]|max_length[20]');
	$this->form_validation->set_rules('password', get_lang('Password'), 'required|min_length[4]|max_length[32]');

	if ($this->form_validation->run() == FALSE)
	{
		alertbox('alert-danger', '', validation_errors());
	}
	else
	{
		$user['email'] = $this->input->post('email');
		$user['name'] = $this->input->post('name');
		$user['surname'] = $this->input->post('surname');
		$user['password'] = $this->input->post('password');
		$user['password_again'] = $this->input->post('password_again');
		$user['role'] = $this->input->post('role');
		
		// Have user email?
		$this->db->where('status', '1');
		$this->db->where('email', $user['email']);
		$query = $this->db->get('users')->result_array();
		if($query)
		{
			alertbox('alert-danger', get_lang('E-mail address is registered.'));
			$continue = false;
		}
		
		if($user['password'] != $user['password_again'])
		{
			alertbox('alert-danger', get_lang('Passwords are not the same.'));
			$continue = false;
		}
	
		if($continue)
		{
			$user_id = add_user($user);
			if($user_id > 0)
			{
				$log['type'] = 'user';
				$log['other_id'] = 'user_id:'.$user_id;
				$log['title'] = get_lang('New User');
				$log['description'] = get_lang('New user created.').'['.$user_id.']' ;
				add_log($log);
				alertbox('alert-success', get_lang('Operation is Successful'), '');	
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
                    <input type="text" id="email" name="email" class="form-control input-lg ff-1 required email" placeholder="<?php lang('E-mail'); ?>" minlength="3" maxlength="50" value="<?php echo $user['email']; ?>">
                </div>
            </div> <!-- /.form-group -->
            <div class="form-group">
                <label for="password" class="control-label ff-1 fs-16"><?php lang('Password'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-sound-7-1"></span></span>
                    <input type="password" id="password" name="password" class="form-control input-lg ff-1 required" placeholder="<?php lang('Password'); ?>" minlength="4" maxlength="32" value="<?php echo $user['password']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="password_again" class="control-label ff-1 fs-16"><?php lang('Password Again'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-sound-7-1"></span></span>
                    <input type="password" id="password_again" name="password_again" class="form-control input-lg ff-1 required" placeholder="<?php lang('Password Again'); ?>" minlength="4" maxlength="32" value="<?php echo $user['password_again']; ?>">
                </div>
            </div>
            
    
                              
        </div> <!-- /.col-md-6 -->
        <div class="col-md-6">
            <div class="form-group">
            	<label for="role" class="control-label ff-1 fs-16"><?php lang('Role'); ?></label>
                <select name="role" id="role" class="form-control input-lg">
                  <option value="5" <?php if($user['role']==5){echo'selected';} ?>>Personel</option>
                  <option value="4" <?php if($user['role']==4){echo'selected';} ?>>Yetikili Personel</option>
                  <option value="3" <?php if($user['role']==3){echo'selected';} ?>>Birim Amiri</option>
                  <option value="2" <?php if($user['role']==2){echo'selected';} ?>>Yönetici</option>
                  <option value="1" <?php if($user['role']==1){echo'selected';} ?>>Süper Yönetici</option>
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
        <input type="hidden" name="add_product" />
        <button class="btn btn-default btn-lg"><?php lang('Save'); ?> &raquo;</button>
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