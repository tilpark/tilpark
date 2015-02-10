<?php if(@$db['default']['username'] == '' or !isset($db['default']['username'])) : ?>	


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TilPark! Açık Kaynak Kodlu Stok Takip ve Cari Otomasyonu</title>
<meta name="description" content="Bootstrap">


<!-- Included CSS Files (Compressed) -->

<link href="<?php echo base_url('theme/css/bootstrap-glyphicons.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('theme/css/bootstrap.css'); ?>">

<link rel="stylesheet" href="<?php echo base_url('theme/css/datepicker.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('theme/js/dataTable/css/TableTools.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('theme/css/app.css'); ?>">


<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('theme/js/jquery.js'); ?>"></script>
<script src="<?php echo base_url('theme/js/bootstrap.js'); ?>"></script> 
<script src="<?php echo base_url('theme/js/jquery.validation.js'); ?>"></script> 

<script src="<?php echo base_url('theme/js/bootstrap-datepicker.js'); ?>"></script> 


<script src="<?php echo base_url('theme/js/jquery.dataTables.js'); ?>"></script> 
<script src="<?php echo base_url('theme/js/dataTable/js/ZeroClipboard.js'); ?>"></script> 
<script src="<?php echo base_url('theme/js/dataTable/js/TableTools.js'); ?>"></script>

<!-- Initialize JS Plugins -->
<script src="<?php echo base_url('theme/js/app.js'); ?>"></script>


</head>
<body>

<div class="container bg" style="padding-top:10px;">

	<div class="text-center">
        <h1 class="ff-1">Kuruluma Hoşgeldiniz?</h1>
        <p class="ff-1">TilPark! kurulumu çok kolaydır. Bir kaç dakika içerisinde kurulumu tamamlayabilirsiniz.</p>
    </div>
    
    <div class="h20"></div>
    
    
    <?php
	if(isset($_POST['hostname']))
	{
		$continue 	= true;
		$hostname 	= $_POST['hostname'];
		$username 	= $_POST['username'];
		$password 	= $_POST['password'];
		$database 	= $_POST['database'];
		
		$dbprefix 	= $_POST['dbprefix'];
		
		$admin_email 	= $_POST['admin_email'];
		$admin_pass 	= $_POST['admin_pass'];
		
		
		$config_text = '<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');
$db[\'default\'][\'hostname\'] = \''.$hostname.'\';
$db[\'default\'][\'username\'] = \''.$username.'\';
$db[\'default\'][\'password\'] = \''.$password.'\';
$db[\'default\'][\'database\'] = \''.$database.'\';
$db[\'default\'][\'dbdriver\'] = \'mysql\';
$db[\'default\'][\'dbprefix\'] = \''.$dbprefix.'\';
?>';

		
		$con = @mysql_connect($hostname, $username, $password);
		if(!$con) 
		{
			alertbox('alert-danger', mysql_error());
			$continue 	= false;
		}
		
		$db_select = mysql_select_db($database);
		if(!$db_select) 
		{
			alertbox('alert-danger',mysql_error());
			$continue 	= false;
		}
		
		$write = true;
		# veritabanı tablo isimleri
		$t_accounts 		= $dbprefix.'accounts';
		$t_files 			= $dbprefix.'files';
		$t_invoices 		= $dbprefix.'fiches';
		$t_invoice_items 	= $dbprefix.'fiche_items';
		$t_options		 	= $dbprefix.'options';
		$t_products		 	= $dbprefix.'products';
		$t_product_serials 	= $dbprefix.'product_serials';
		$t_users		 	= $dbprefix.'users';
		$t_user_logs	 	= $dbprefix.'user_logs';
		$t_user_mess	 	= $dbprefix.'user_mess';
		
		
		
		/* -- ACCOUNTS -- */
		mysql_query("DROP TABLE $t_accounts");
		mysql_query("CREATE TABLE IF NOT EXISTS `$t_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT '1',
  `code` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `name_surname` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `balance` decimal(10,4) NOT NULL,
  `phone` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `gsm` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `address` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `county` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `city` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=25 ;
		");
		if(mysql_error()) { alert_box(mysql_error(), 'alert'); $write = false; }
		
		
		/* -- FILES -- */
		mysql_query("DROP TABLE $t_files");
		mysql_query("CREATE TABLE IF NOT EXISTS `$t_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  `key` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `other_id` int(11) NOT NULL,
  `file` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=9 ;
		");
		if(mysql_error()) { alert_box(mysql_error(), 'alert'); $write = false; }
		
		
		/* -- FILES -- */
		mysql_query("DROP TABLE $t_invoices");
		mysql_query("CREATE TABLE IF NOT EXISTS `$t_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  `type` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `in_out` int(1) NOT NULL,
  `account_id` int(11) NOT NULL,
  `description` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,4) NOT NULL,
  `tax` decimal(10,4) NOT NULL,
  `discount` decimal(10,4) NOT NULL,
  `grand_total` decimal(10,4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `val_1` text COLLATE utf8_turkish_ci NOT NULL,
  `val_2` text COLLATE utf8_turkish_ci NOT NULL,
  `val_3` text COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=128 ;
		");
		if(mysql_error()) { alert_box(mysql_error(), 'alert'); $write = false; }
		
		
		/* -- FILES -- */
		mysql_query("DROP TABLE $t_invoice_items");
		mysql_query("CREATE TABLE IF NOT EXISTS `$t_invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  `type` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `in_out` int(1) NOT NULL DEFAULT '1',
  `invoice_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_serial_id` int(50) NOT NULL,
  `cost_price` decimal(10,4) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_price` decimal(10,4) NOT NULL,
  `total` decimal(10,4) NOT NULL,
  `tax_rate` int(11) NOT NULL,
  `tax` decimal(10,4) NOT NULL,
  `sub_total` decimal(10,4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_code` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `product_name` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=149 ;
		");
		if(mysql_error()) { alert_box(mysql_error(), 'alert'); $write = false; }
		
		
		
		/* -- FILES -- */
		mysql_query("DROP TABLE $t_options");
		mysql_query("CREATE TABLE IF NOT EXISTS `$t_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_group` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `option_key` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `option_value` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `option_value2` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `option_value3` text COLLATE utf8_turkish_ci NOT NULL,
  `group` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `key` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `val_1` varchar(1000) COLLATE utf8_turkish_ci NOT NULL,
  `val_2` varchar(1000) COLLATE utf8_turkish_ci NOT NULL,
  `val_3` varchar(1000) COLLATE utf8_turkish_ci NOT NULL,
  `val_text` text COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=713 ;
		");
		if(mysql_error()) { alert_box(mysql_error(), 'alert'); $write = false; }
		
		
		/* -- FILES -- */
		mysql_query("DROP TABLE $t_products");
		mysql_query("CREATE TABLE IF NOT EXISTS `$t_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `description` varchar(200) CHARACTER SET utf8 NOT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `tax_rate` int(11) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `serial` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=58 ;
		");
		if(mysql_error()) { alert_box(mysql_error(), 'alert'); $write = false; }
		
		
		/* -- FILES -- */
		mysql_query("DROP TABLE $t_product_serials");
		mysql_query("CREATE TABLE IF NOT EXISTS `$t_product_serials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `product_id` int(11) NOT NULL,
  `serial` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `invoice_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=37 ;
		");
		if(mysql_error()) { alert_box(mysql_error(), 'alert'); $write = false; }
		
		
		/* -- FILES -- */
		mysql_query("DROP TABLE $t_users");
		mysql_query("CREATE TABLE IF NOT EXISTS `$t_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `email` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `surname` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `role` int(1) NOT NULL,
  `avatar` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=8 ;
		");
		if(mysql_error()) { alert_box(mysql_error(), 'alert'); $write = false; }
		
		
		/* -- FILES -- */
		mysql_query("DROP TABLE $t_user_logs");
		mysql_query("CREATE TABLE IF NOT EXISTS `$t_user_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `type` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `other_id` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `ip` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `browser` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `platform` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1321 ;
		");
		if(mysql_error()) { alert_box(mysql_error(), 'alert'); $write = false; }
		
		
		
		/* -- FILES -- */
		mysql_query("DROP TABLE $t_user_mess");
		mysql_query("CREATE TABLE IF NOT EXISTS `$t_user_mess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  `type` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `top_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `content` text COLLATE utf8_turkish_ci NOT NULL,
  `read` varchar(20) COLLATE utf8_turkish_ci NOT NULL DEFAULT '0',
  `read_date` datetime NOT NULL,
  `inbox_view` int(1) NOT NULL DEFAULT '1',
  `recent_activity` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `finish_date` datetime NOT NULL,
  `task_status` varchar(20) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'open',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=239 ;
		");
		if(mysql_error()) { alert_box(mysql_error(), 'alert'); $write = false; }
		
		
		
		$admin_pass 	= md5($admin_pass);
		mysql_query("INSERT INTO $t_users (email, name, surname, password, role) VALUES ('$admin_email', 'ADMIN', 'ADMIN', '$admin_pass', '1')");
		
		
		if($write)
		{
			$file_config	=	"config.php";
			if (!file_exists ("$file_config") ) 
			{
				touch ($file_config);
			}
			
			$file_conntect = @fopen ("$file_config",'w');
			if(!$file_conntect) 
			{
				alertbox('alert-danger','config.php dosyası açılmadı.');   
			}
			
			
			
			if (@fputs ($file_conntect, $config_text)) 
			{
				echo '<script>document.location.reload(true);</script>';
			}
			else 
			{
				alertbox('alert-danger','config.php dosyası açıldı fakat veri yazılamadı. [lütfen CMHOD değerlerini 777 yapın]');
			}
			@fclose($file_conntect);	
		}
		
		
	}
	?>
    
   
	<form name="setup" id="setup" action="" method="POST" class="validation">
         <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="hostname" class="control-label ff-1 fs-16"> Sunucu adresi</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="hostname" name="hostname" class="form-control ff-1 required valid" placeholder="localhost" maxlength="50" value="localhost">
                    </div>
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                    <label for="username" class="control-label ff-1 fs-16">Kullanıcı adı</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="username" name="username" class="form-control ff-1 required" placeholder="" maxlength="50" value="">
                    </div>
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                    <label for="password" class="control-label ff-1 fs-16">Şifresi</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="password" name="password" class="form-control ff-1" placeholder="" maxlength="50" value="">
                    </div>
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                    <label for="database" class="control-label ff-1 fs-16">Veritabanı adı</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="database" name="database" class="form-control ff-1 required valid" placeholder="" maxlength="50" value="">
                    </div>
                </div> <!-- /.form-group -->
                
            	<div class="form-group">
                    <label for="dbprefix" class="control-label ff-1 fs-16">Veritabanı ön eki</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="dbprefix" name="dbprefix" class="form-control ff-1" placeholder="til_" maxlength="50" value="til_">
                    </div>
                </div> <!-- /.form-group -->
                
                
            </div> <!-- /.col-md-6 -->
            <div class="col-md-4">
            	<div class="form-group">
                    <label for="admin_email" class="control-label ff-1 fs-16">Yöneti e-posta</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="admin_email" name="admin_email" class="form-control required email ff-1" placeholder="example@example.com" maxlength="100" value="">
                    </div>
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                    <label for="admin_pass" class="control-label ff-1 fs-16">Yöneti şifre</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="password" id="admin_pass" name="admin_pass" class="form-control required ff-1" placeholder="" maxlength="50" value="">
                    </div>
                </div> <!-- /.form-group -->
                
                
            </div>
            <div class="col-md-3"></div>
		</div> <!-- /.row -->
        
        <div class="h20"></div>
        
        <div class="row">
        	<div class="col-md-10">
                <div class="text-right">
                	<button class="btn btn-lg btn-success">Kurulumu Tamamla</button>
                </div>
        	</div>
        </div> <!-- /.row -->
        <div class="h20"></div>
	</form>
    	
</div>

</body>
</html>




<?php exit; ?>
<?php else: ?>
<?php endif; ?>