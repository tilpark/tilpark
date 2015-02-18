<table class="table table-bordered table-hover table-condensed dataTable">
  <thead>
    <tr>
      <th class="hidden"></th>
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
      <td class="hidden"></td>
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