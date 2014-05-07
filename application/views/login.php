<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TilPark! Açık Kaynak Kodlu Stok Takip ve Cari Otomasyonu</title>
<meta name="description" content="Bootstrap">

<!-- Included CSS Files (Compressed) -->
<link rel="stylesheet" href="<?php echo base_url('theme/css/bootstrap-glyphicons.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('theme/css/bootstrap.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('theme/css/app.css'); ?>">

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('theme/js/jquery.js'); ?>"></script>
<script src="<?php echo base_url('theme/js/bootstrap.js'); ?>"></script> 
<script src="<?php echo base_url('theme/js/jquery.validation.js'); ?>"></script> 

<!-- Initialize JS Plugins -->
<script src="<?php echo base_url('theme/js/app.js'); ?>"></script>
</head>
<body>
<div class="container bg">
	<div class="h20"></div>
	
    <legend class="ff-1"><?php lang('Login'); ?></legend>

    <div class="row">
    	<div class="col-md-8">
   
    	<?php
		if(isset($_POST['login']))
		{
			$data['email'] = $this->input->post('email');
			$data['password'] = $this->input->post('password');
			
			$query = get_user($data);
			if($query)
			{
				if($query['password'] == md5($data['password']) and $query['status'] == '1')
				{
					$this->session->set_userdata('login', true);
					$this->session->set_userdata('user', $query);
					
					$log['type'] = 'login';
					$log['title'] = get_lang('Login');
					$log['description'] = get_lang('Debuted in the system');
					add_log($log);
					
					redirect(site_url());
				}
				else
				{
					alertbox('alert-danger', get_lang('Login failed.'));	
				}
			}
			else
			{
				alertbox('alert-danger', get_lang('User not found.'));	
			}
		}
		?>
        
        
        <form name="form_new_product" id="form_new_product" action="" method="POST" class="validation">
        	
            <div class="row">
            	<div class="col-md-12">
                	<?php
					$user['mail'] = '';
					$user['pass'] = '';
					if(strstr($_SERVER['SERVER_NAME'], 'tilpark.com'))
					{
						alertbox('alert-info', 'kullanıcı adı: <span style="color:#000;">admin@tilpark.com</span> / şifre: <span style="color:#000;">123456</span>', '', false);	
						$user['mail'] = 'admin@tilpark.com';
						$user['pass'] = '123456';
					}
					else if(strstr($_SERVER['SERVER_NAME'], 'demo.tilteknik.com'))
					{
						alertbox('alert-info', 'kullanıcı adı: <span style="color:#000;">admin@tilteknik.com</span> / şifre: <span style="color:#000;">123456</span>', '', false);	
						$user['mail'] = 'admin@tilteknik.com';
						$user['pass'] = '123456';
					}
					?>
                </div> <!-- /.col-md-12 -->
            </div> <!-- /.row -->
            
            <div class="row">
            	<div class="col-md-3"></div>
                <div class="col-md-6">
                       
                    <div class="form-group">
                        <label for="email" class="control-label ff-1 fs-16"><?php lang('E-mail'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                            <input type="text" id="email" name="email" class="form-control input-lg ff-1 required email" placeholder="<?php lang('E-mail'); ?>" minlength="3" maxlength="50" value="<?php echo $user['mail']; ?>">
                        </div>
                    </div> <!-- /.form-group -->
                    <div class="form-group">
                        <label for="password" class="control-label ff-1 fs-16"><?php lang('Password'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-sound-7-1"></span></span>
                            <input type="password" id="password" name="password" class="form-control input-lg ff-1 required" placeholder="<?php lang('Password'); ?>" minlength="4" maxlength="32" value="<?php echo $user['pass']; ?>">
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <input type="hidden" name="login" />
                        <button class="btn btn-default btn-lg"><?php lang('Login'); ?> &raquo;</button>
                    </div> <!-- /.text-right -->
                                  
            </div> <!-- /.col-md-6 -->
            <div class="col-md-3">
               
            </div> <!-- /.col-md-3 -->
        </div> <!-- /.row -->
    
        
    </form>
    </div> <!-- /.col-md-8 -->
    <div class="col-md-4">
        <span class="help-block note">
            <h4><span class="glyphicon glyphicon-info-sign"></span> <?php lang('information'); ?></h4>
            <ul class="note">
                <li><?php lang('You can product sales.'); ?></li>
                <li><?php lang('You can see the amount of product.'); ?></li>
                <li><?php lang('You can follow clients.'); ?></li>
                <li><?php lang('If you see an instant money.'); ?></li>
                <li><?php lang('You can follow the salaries of the staff.'); ?></li>
            </ul>
        </span>
    </div> <!-- /.col-md-4 -->
    </div> <!-- /.row -->

<div class="h20"></div>
    
</div> <!-- container -->
</body>
</html>

