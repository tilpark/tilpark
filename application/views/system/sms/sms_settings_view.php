<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>"><?php lang('Dashboard'); ?></a></li>
  <li><a href="<?php echo site_url('plugins'); ?>"><?php lang('Plugins'); ?></a></li>
  <li><a href="<?php echo site_url('general/sms'); ?>">SMS</a></li>
  <li class="active">SMS Ayarları</li>
</ol>

<?php

if(isset($_POST['update_options']))
{
	$data['sms_username'] = $this->input->post('sms_username');
	$data['sms_password'] = $this->input->post('sms_password');

	$option['group'] = 'sms';
	$option['key'] = 'sms_connect';
	$option['val_1'] = $data['sms_username'];
	$option['val_2'] = $data['sms_password'];
	update_option($option);
}

// açıkta kalan işlemno'ları sorgulatıp sistemin daha düzenli çalışmasını sağlıyoruz.
sms_curl(array('all_checks'=>''));

// sms kullanıcı adı ve şifre bilgilerini çekiyoruz
$sms_connect = get_option(array('group'=>'sms', 'key'=>'sms_connect')); 

// kullanıcı adı ve şifrenin doğru olup olmadığını kontrole diyoruz.
$connect_sms = sms_connect($sms_connect['val_1'], $sms_connect['val_2']);

// bu fonkisiyon ile genel bilgileri sistemimiz ile güncelliyoruz.
update_sms_info($sms_connect['val_1'], $sms_connect['val_2']); 
?>




<div class="row">
	<div class="col-md-4">
        <div class="widget">
            <div class="header">SMS Bağlantısı</div>
            <div class="content">
				
                <?php if($connect_sms): ?>
                    <?php alertbox('alert-success', '', 'SMS kullanıcı bağlantısı doğrulandı.', false); ?>
                <?php else: ?>
                    <?php alertbox('alert-danger', '', 'Hatalı kullancı adı yada şifre'); ?>
                <?php endif; ?>
                <form name="form_sms_options" id="form_sms_options" action="" method="POST" class="validation">
                
                    <div class="form-group">
                        <label for="sms_username" class="control-label">SMS kullanıcı adı</label>
                        <input type="text" id="sms_username" name="sms_username" class="form-control required" placeholder="SMS Kullanıcı adı" maxlength="50" value="<?php echo $sms_connect['val_1']; ?>">
                    </div> <!-- /.form-group -->
                    
                    <div class="form-group">
                        <label for="sms_password" class="control-label">SMS şifre</label>
                        <input type="text" id="sms_password" name="sms_password" class="form-control required" placeholder="SMS şifre" maxlength="50" value="<?php echo $sms_connect['val_2']; ?>">
                    </div> <!-- /.form-group -->
                          
                    <div class="text-right">    
                        <input type="hidden" name="login_control" />
                        <input type="hidden" name="update_options" /> 
                        <button class="btn btn-success"><?php lang('Save'); ?></button> 
                    </div> <!-- /.text-right -->   
                                 
                </form>
        	</div> <!-- /.content -->
		</div> <!-- /.widget -->
	</div> <!-- /.col-md-4 -->
    <div class="col-md-4">
    <?php $sms_balance = get_option(array('group'=>'sms', 'key'=>'sms_balance')); ?>
    	<div class="custom_box_32">
            <div class="left">
                <h4><?php echo $sms_balance['val_1']; ?></h4>
                <p>KALAN SMS ADET</p>
            </div>
            <div class="right">
                <h4><?php echo $sms_balance['val_2']; ?></h4>
                <p class="green">GÖNDERİLEN SMS ADET</p>
            </div>
        </div>
    </div> <!-- /.col-md-4 -->
</div> <!-- /.row -->