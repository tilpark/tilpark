<?php if(@$accounts): ?>
    <table class="table table-bordered table-hover table-condensed">
        <thead>
            <tr>
                <th width="140" class="hidden-xs hidden-sm">Kodu</th>
                <th width="200">Hesap Kartı</th>
                <th width="160" class="hidden-xs">Yetkili Adı Soyadı</th>
                <th width="80" class="hidden-xs hidden-sm">Şehir</th>
                <th width="80" class="hidden-xs hidden-sm" width="100">Telefon</th>
                <th width="80">Bakiye</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($accounts as $account): ?>
            <tr>
                <td class="fs-10 hidden-xs hidden-sm"><a href="<?php echo site_url('account/view/'.$account['id']); ?>"><?php echo text_crop($account['code'],0,20); ?></a></td>
                <td title="<?php echo $account['name']; ?>"><a href="<?php echo site_url('account/view/'.$account['id']); ?>"><?php echo text_crop($account['name'],0,30); ?></a></td>
                <td class="fs-10 hidden-xs"><?php echo text_crop($account['name_surname'],0,20); ?></td>
                <td class="fs-10 hidden-xs hidden-sm"><?php echo text_crop($account['city'],0,15); ?></td>
                <td class="hidden-xs hidden-sm"><?php echo text_crop($account['phone'],0,11); ?></td>
                <td class="text-right"><?php echo get_money($account['balance']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 <?php else: ?>
 
    <?php if(isset($error_404)): ?>
         <div class="error_404 not_found">
            <div class="fs-28 text-center"><i class="fa fa-search icon color-5"></i></div>
            <h3 class="text-center">Listelenecek kayıt bulunamadı</h3>
            <div class="well bg-white text-danger text-center">
                <?php echo $error_404; ?>
            </div>
        </div>
    <?php endif; ?>	
    
 <?php endif; ?>
 
 <small class="pull-right color-4">bu arama sorgusu {elapsed_time} saniyede gerçekleşti.</small>
 
