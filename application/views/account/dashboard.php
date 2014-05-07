<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li class="active">Hesap Yönetimi</li>
</ol>



<div class="row">
<div class="col-md-8">

    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('account/add'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat metro_green none">
                	<div class="visual">
                        <i class="fa fa-plus fs-20"></i>
                    </div>
                    <div class="details">
                        <div class="number">yeni</div>
                        <div class="desc">yeni hesap kartı</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
            </a>
        </div> <!-- /.col-md-3 -->
        <div class="col-md-3">
            <a href="<?php echo site_url('account/lists'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat yellow none">
                	<div class="visual">
                        <i class="fa fa-list fs-20"></i>
                    </div>
                    <div class="details">
                        <div class="number">hesaplar</div>
                        <div class="desc">hesap kartlar listesi</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
        <div class="col-md-3">
            <a href="<?php echo site_url('account/telephone_directory'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat yellow none">
                    <div class="details">
                        <div class="number">rehber</div>
                        <div class="desc">telefon rehberi</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
        <?php if(get_the_current_user('role') < 3): ?>
        <div class="col-md-3">
            <a href="<?php echo site_url('account/options'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat metro_brown none">
                    <div class="details">
                        <div class="number">seçenekler</div>
                        <div class="desc">yönetim seçenekleri</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
             </a>
        </div> <!-- /.col-md-3 -->
        <?php endif; ?>
    </div> <!-- /.row -->

		
</div> <!-- /.col-md-8 -->
<div class="col-md-4">

</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->