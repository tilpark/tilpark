<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>"><?php lang('Dashboard'); ?></a></li>
  <li><a href="<?php echo site_url('plugins'); ?>"><?php lang('Plugins'); ?></a></li>
  <li class="active">SMS</li>
</ol>

<div class="row">
	<div class="col-md-8">
    	<div class="row">
        	<div class="col-md-3">
                <a href="<?php echo site_url('general/sms/new_sms'); ?>" class="link-dashboard-stat">
                    <div class="dashboard-stat blue none">
                        <div class="details">
                            <div class="number">yeni sms</div>
                            <div class="desc">yeni sms gönderin</div>
                         </div>
                    </div> <!-- /.dashboard-stat -->
                </a>
            </div> <!-- /.col-md-3 -->
        	<div class="col-md-3">
                <a href="<?php echo site_url('general/sms/settings'); ?>" class="link-dashboard-stat">
                    <div class="dashboard-stat blue none">
                        <div class="details">
                            <div class="number">ayarlar</div>
                            <div class="desc">sms ayarları</div>
                         </div>
                    </div> <!-- /.dashboard-stat -->
                </a>
            </div> <!-- /.col-md-3 -->
        </div> <!-- /.row -->
    </div> <!-- /.col-md-8 -->
    <div class="col-md-4">
    
    </div> <!-- /.col-md-4 -->
</div> <!-- /.row -->