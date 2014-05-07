<?php if(strstr($_SERVER['SERVER_NAME'], 'tilpark.com')){exit('demo hesabindan bu sayfaya erisim yoktur.');}; ?>
<?php if(strstr($_SERVER['SERVER_NAME'], 'demo.tilteknik.com')){exit('demo hesabindan bu sayfaya erisim yoktur.');}; ?>
<?php
$this->db->where('status', 1);
$query = $this->db->get('users')->result_array();
?>

<div class="row">
	<div class="col-md-8">
    
    	<legend><?php lang('User List'); ?></legend>
        <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="1"></th>
                    <th><?php lang('E-mail'); ?></th>
                    <th><?php lang('Name'); ?></th>
                    <th><?php lang('Surname'); ?></th>
                    <th><?php lang('Role'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($query as $user) : ?>

                <tr>
                    <td>
                 
                    	<?php if(get_the_current_user('role') < 3): ?>
                            <div class="btn-group">
                              <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
                                <?php lang('Options'); ?> <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo site_url('user/get_user/'.$user['id']); ?>"><span class="glyphicon glyphicon-edit"></span> <?php lang('Edit'); ?></a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-list-alt"></span> Log Kayıtları</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url('user/get_user/'.$user['id'].'/?status=0'); ?>"><span class="glyphicon glyphicon-remove-circle"> <?php lang('Delete'); ?></a></li>
                              </ul>
                            </div>
                            
                        <?php endif; ?>
                    </td>
                    <td><a href="<?php echo site_url('user/profile/'.$user['id']); ?>"><?php echo $user['email']; ?></a></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['surname']; ?></td>
                    <td><?php echo get_role_name($user['role']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div> <!-- /.tavle-responsive -->
	</div>
    <div class="col-md-4">
    	
    </div> <!-- /.col-md-4 -->
</div> <!-- /.row -->