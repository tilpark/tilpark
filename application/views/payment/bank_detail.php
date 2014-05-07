<ol class="breadcrumb">
	<li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
	<li><a href="<?php echo site_url('payment'); ?>">Kasa</a></li>
    <li><a href="<?php echo site_url('payment/cashbox'); ?>">Kasa Yönetimi</a></li>
	<li class="active"><?php echo $bank['key']; ?> Detayları</li>
</ol>

<h3 class="title"><i class="fa fa-puzzle-piece"></i> <?php echo $bank['key']; ?></h3>

<table class="table table-bordered table-hover table-condensed dataTable fs-12">
	<thead>
    	<tr>
        	<th class="hide"></th>
        	<th width="20"><?php lang('ID'); ?></th>
            <th width="100"><?php lang('Date'); ?></th>
            <th width="50">G/Ç</th>
            <th>Hesap Kartı</th>
            <th width="100">Ödeme Türü</th>
            <th width="50">Kullanıcı</th>
            <th>Açıklama</th>
            <th>Diğer</th>
            <th width="80">Giriş</th>
            <th width="80">Çıkış</th>
            <th width="80">Ara Toplam</th>
        </tr>
    </thead>
    <tbody>   
    <?php $sub_total = 0; ?> 
    <?php foreach($forms as $form): ?>
    	<?php $user = get_user($form['user_id']); ?>
    	<tr>
        	<td class="hide"></td>
        	<td><a href="<?php echo site_url('payment/view/'.$form['id']); ?>">#<?php echo $form['id']; ?></a></td>
            <td class="fs-11"><?php echo substr($form['date'],0,16); ?></td>
            <td class="fs-11"><?php echo get_text_in_out($form['in_out']); ?></td>
            <td title="<?php echo $form['name']; ?>">
            	<?php if($form['account_id'] > 0): ?>
            		<a href="<?php echo site_url('account/view/'.$form['account_id']); ?>" target="_blank">
						<?php echo mb_substr($form['name'],0,20,'utf-8'); ?>
                    </a>
                <?php else: ?>
                	<?php echo mb_substr($form['name'],0,20,'utf-8'); ?>
                <?php endif; ?>
            </td>
            <td><?php echo get_text_payment_type($form['val_1']); ?></td>
            <td class="fs-11" title="<?php echo $user['name']; ?> <?php echo $user['surname']; ?>"><?php echo $user['surname']; ?></td>
            <td title="<?php echo $form['description']; ?>"><?php echo mb_substr($form['description'],0,20,'utf-8'); ?></td>
            <td><?php echo $form['val_2']; ?> <?php if($form['val_4'] != ''): ?> &raquo; <?php echo $form['val_4']; ?><?php endif; ?></td>
            <?php if($form['in_out'] == 'in'): ?>
            	<?php $sub_total = $sub_total + $form['grand_total']; ?>
            	<td class="text-right"><?php echo get_money($form['grand_total']); ?></td>
                <td></td>
            <?php elseif($form['in_out'] == 'out'): ?>
            	<?php $sub_total = $sub_total - $form['grand_total']; ?>
            	<td></td>
            	<td class="text-right"><?php echo get_money($form['grand_total']); ?></td>
            <?php endif; ?>
            <td class="text-right"><?php echo get_money($sub_total); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    	<tr>
        	<td colspan="9" class="text-right fs-20">BANKA BAKİYESİ:</td>
        	<td colspan="2" class="text-right"><span class="text-danger fs-20"><?php echo get_money($sub_total); ?> <i class="fa fa-try"></i></span></td>
        </tr>
    </tfoot>
</table> <!-- /.table -->
