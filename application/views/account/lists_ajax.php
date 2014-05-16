




    <table class="table table-bordered table-hover table-condensed">
        <thead>
            <tr>
                <th>Kodu</th>
                <th>Hesap Kartı</th>
                <th>Yetkili Adı Soyadı</th>
                <th>Şehir</th>
                <th width="100">Telefon</th>
                <th width="100">Bakiye</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($accounts as $account): ?>
            <tr>
                <td class="fs-10"><a href="<?php echo site_url('account/view/'.$account['id']); ?>"><?php echo text_crop($account['code'],0,20); ?></a></td>
                <td><a href="<?php echo site_url('account/view/'.$account['id']); ?>"><?php echo text_crop($account['name'],0,40); ?></a></td>
                <td class="fs-10"><?php echo text_crop($account['name_surname'],0,20); ?></td>
                <td class="fs-10"><?php echo text_crop($account['city'],0,15); ?></td>
                <td><?php echo text_crop($account['phone'],0,11); ?></td>
                <td class="text-right"><?php echo get_money($account['balance']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    

