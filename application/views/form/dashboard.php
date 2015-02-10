<div class="row">
<div class="col-md-8">

    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('form/view/0?out'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat">
                    <div class="details">
                        <div class="title">Satış Formu</div>
                        <div class="desc">ürün, hizmet satışı</div>
                        <i class="fa fa-shopping-cart"></i>
                     </div>
                </div> <!-- /.dashboard-stat -->
            </a>
        </div> <!-- /.col-md-3 -->
        <div class="col-md-3">
            <a href="<?php echo site_url('form/view/0?in'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat">
                    <div class="details">
                        <div class="title">Alış Formu</div>
                        <div class="desc">ürün, hizmet alışı</div>
                        <i class="fa fa-shopping-cart"></i>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
        <div class="col-md-3">
            <a href="<?php echo site_url('form/lists'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat yellow none">
                    <div class="details">
                        <div class="title">Formlar</div>
                        <div class="desc">tüm formlar</div>
                        <i class="fa fa-list-ul"></i>
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
            <table class="table table-hover table-bordered table-condensed fs-11">
                <thead>
                    <tr>
                        <th width="60">Form ID</th>
                        <th>Hesap Kartı</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($query as $q): ?>
                   <tr>
                        <td><a href="<?php echo site_url('form/view/'.$q['id']); ?>">#<?php echo $q['id']; ?></a></td>
                        <td><a href="<?php echo site_url('account/get_account/'.$q['account_id']); ?>" target="_blank"><?php echo @$q['name']; ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <?php alertbox('alert-info', 'Form bulunamadı', '', false); ?>
            <?php endif; ?>
    	</div> <!-- /.content -->
    </div> <!-- /.widget -->
    <?php endif; // role control(2) ?> 
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->