<?php $accounts = get_account_list_for_array(); ?>


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li class="active">Kasa</li>
</ol>


<div class="row">
<div class="col-md-8">


    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('payment/add/?in'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat metro_green none">
                    <div class="details">
                        <div class="number">tahsilat</div>
                        <div class="desc">nakit para ve çek almak</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
            </a>
        </div> <!-- /.col-md-3 -->
        <div class="col-md-3">
            <a href="<?php echo site_url('payment/add/?out'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat metro_green none">
                    <div class="details">
                        <div class="number">ödeme</div>
                        <div class="desc">nakit para ve çek vermek</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
        <div class="col-md-3">
            <a href="<?php echo site_url('payment/lists'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat yellow none">
                    <div class="details">
                        <div class="number">ödemeler</div>
                        <div class="desc">ödeme ve tahsilat listesi</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
        <div class="col-md-3">
            <a href="<?php echo site_url('payment/payment_list/?val_1=checks'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat yellow none">
                    <div class="details">
                        <div class="number"><?php lang('Checks'); ?></div>
                        <div class="desc"><?php lang('checks list'); ?></div>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
        <div class="col-md-3">
            <a href="<?php echo site_url('payment/cashbox'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat none">
                	<div class="visual">
                    	<i class="fa fa-inbox gray"></i>
                    </div>
                    <div class="details">
                        <div class="number">kasa</div>
                        <div class="desc">kasa & banka yönetimi</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
        <?php if(get_the_current_user('role') < 3): ?>
        <div class="col-md-3">
            <a href="<?php echo site_url('payment/options'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat metro_brown none">
                    <div class="details">
                        <div class="number"><?php lang('options'); ?></div>
                        <div class="desc"><?php lang('management settings'); ?></div>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
        <?php endif; ?>
        
        
    </div> <!-- /.row -->
   
    

</div> <!-- /.col-md-8 -->
<div class="col-md-4">
	<?php if(get_the_current_user('role') < 3): ?>
	<div class="widget">
    	<div class="header">Gelen Çekler</div>
    	<div class="content">
			<?php
            $this->db->where('status', 1);
            $this->db->where('type','payment');
            $this->db->where('val_1', 'checks');
            $this->db->where('in_out', '0');	
            $this->db->where('val_2 >', date('Y-m-d'));	
            $this->db->order_by('val_2', 'ASC');
            $this->db->limit(10);
            $query = $this->db->get('forms')->result_array();
            ?>
            <?php if($query) : ?>
            <table class="table table-hover table-bordered table-condensed">
                <thead>
                    <tr>
                        <th width="100"><?php lang('Fall Due On'); ?></th>
                        <th><?php lang('Account'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($query as $q): ?>
                   <tr>
                        <td><?php echo $q['val_2']; ?></td>
                        <td><a href="<?php echo site_url('account/get_account/'.$q['account_id']); ?>" target="_blank"><?php echo $accounts[$q['account_id']]['name']; ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <?php alertbox('alert-info', 'Ödeme kayıtları içerisinde "çek/senet" bulunamadı.', '', false); ?>
            <?php endif; ?>
    	</div> <!-- /.content -->
    </div> <!-- /.widget -->
    
    <div class="h20"></div>
    
    <div class="widget">
    	<div class="header">Giden Çekler</div>
    	<div class="content">
			<?php
            $this->db->where('status', 1);
            $this->db->where('type','payment');
            $this->db->where('val_1', 'checks');
            $this->db->where('in_out', '1');	
            $this->db->where('val_2 >', date('Y-m-d'));	
            $this->db->order_by('val_2', 'ASC');
            $this->db->limit(10);
            $query = $this->db->get('forms')->result_array();
            ?>
            <?php if($query) : ?>
            <table class="table table-hover table-bordered table-condensed">
                <thead>
                    <tr>
                        <th width="100"><?php lang('Fall Due On'); ?></th>
                        <th><?php lang('Account'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($query as $q): ?>
                   <tr>
                        <td><?php echo $q['val_2']; ?></td>
                        <td><a href="<?php echo site_url('account/get_account/'.$q['account_id']); ?>" target="_blank"><?php echo $accounts[$q['account_id']]['name']; ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <?php alertbox('alert-info', 'Ödeme kayıtları içerisinde "çek/senet" bulunamadı.', '', false); ?>
            <?php endif; ?>
    	</div> <!-- /.content -->
    </div> <!-- /.widget -->
    <?php endif; // role control(2) ?> 
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->