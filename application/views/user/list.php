<?php if(strstr($_SERVER['SERVER_NAME'], 'tilpark.com')){exit('demo hesabindan bu sayfaya erisim yoktur.');}; ?>
<?php if(strstr($_SERVER['SERVER_NAME'], 'demo.tilteknik.com')){exit('demo hesabindan bu sayfaya erisim yoktur.');}; ?>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li class="active">Kullanıcı Listesi</li>
</ol>

<table class="table table-bordered table-condensed table-hover dataTable">
    <thead>
        <tr>
        	<th class="hide"></th>
            <th width="40"></th>
            <th>E-mail</th>
            <th>Ad Soyad</th>
            <th>Yetki</th>
            <th>Gsm</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($users as $user) : ?>
        <tr>
        	<td class="hide"></td>
            <td>
               <a href="<?php echo site_url('user/profile/'.$user['id']); ?>" class="img-thumbna2il radius-0"><img src="<?php echo base_url('uploads/avatar/thumb_width_'.$user['avatar']); ?>" style="height:25px;" /></a>
            </td>
            <td><a href="<?php echo site_url('user/profile/'.$user['id']); ?>"><?php echo $user['email']; ?></a></td>
            <td><?php echo $user['name']; ?> <?php echo $user['surname']; ?></td>
            <td><?php echo get_role_name($user['role']); ?></td>
            <td><?php echo $user['gsm']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>