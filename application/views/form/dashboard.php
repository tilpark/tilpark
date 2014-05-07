<?php $accounts = get_account_list_for_array(); ?>


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>"><?php lang('Dashboard'); ?></a></li>
  <li class="active">Form Yönetimi</li>
</ol>



<div class="row">
<div class="col-md-8">

    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('form/view/0?out'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat metro_green none">
                    <div class="details">
                        <div class="number">satış formu</div>
                        <div class="desc">ürün, hizmet satışı</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
            </a>
        </div> <!-- /.col-md-3 -->
        <div class="col-md-3">
            <a href="<?php echo site_url('form/view/0?in'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat metro_green none">
                    <div class="details">
                        <div class="number">alış formu</div>
                        <div class="desc">ürün, hizmet alışı</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
        <div class="col-md-3">
            <a href="<?php echo site_url('form/lists'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat yellow none">
                    <div class="details">
                        <div class="number">formlar</div>
                        <div class="desc">tüm formlar</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
    </div> <!-- /.row -->
          

</div> <!-- /.col-md-8 -->
<div class="col-md-4">
	<?php if(get_the_current_user('role') < 3): ?>
        <div class="widget">
            <div class="header">Son Eklenen Formlar</div>
            <div class="content">
            <?php
            $this->db->where('status', 1);
            $this->db->where('type','invoice');
            $this->db->order_by('date', 'DESC');
            $this->db->limit(10);
            $query = $this->db->get('forms')->result_array();
            ?>
            <?php if($query) : ?>
            <table class="table table-hover table-bordered table-condensed">
                <thead>
                    <tr>
                        <th width="60"><?php lang('ID'); ?></th>
                        <th><?php lang('Account'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($query as $q): ?>
                   <tr>
                        <td><a href="<?php echo site_url('form/view/'.$q['id']); ?>">#<?php echo $q['id']; ?></a></td>
                        <td><a href="<?php echo site_url('account/get_account/'.$q['account_id']); ?>" target="_blank"><?php echo @$accounts[$q['account_id']]['name']; ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <?php alertbox('alert-info', get_lang('Value not found.'), '', false); ?>
            <?php endif; ?>
    	</div> <!-- /.content -->
    </div> <!-- /.widget -->
    <?php endif; // role control(2) ?> 
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->