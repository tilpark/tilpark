<?php $accounts = get_account_list_for_array(); ?>


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>"><?php lang('Dashboard'); ?></a></li>
  <li class="active"><?php lang('Plugins'); ?></li>
</ol>

<?php
$this->db->where('option_group', 'plugins');
$this->db->order_by('val_3', 'DESC');
$plugins = $this->db->get('options')->result_array();
?>


<div class="row">
<div class="col-md-8">

    <div class="row">
        <?php foreach($plugins as $plugin): ?>
        <div class="col-md-3">
            <a href="<?php echo site_url($plugin['option_key']); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat metro_green none">
                    <div class="details">
                        <div class="number"><?php echo $plugin['option_value']; ?></div>
                        <div class="desc"><?php echo $plugin['option_value2']; ?></div>
                     </div>
                </div> <!-- /.dashboard-stat -->
            </a>
        </div> <!-- /.col-md-3 -->
        <?php endforeach; ?>
    </div> <!-- /.row -->
  
    
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->