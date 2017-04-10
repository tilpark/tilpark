<div class="sidebar">
  <h3 class="sidebar-title ff-1">MENÜ</h3>

  <ul class="sidebar-menu ff-1">
    <li><a href="<?php site_url(); ?>"><i class="fa fa-home"></i> Yönetim Paneli</a></li>
    <li class=""><a href="#"><i class="fa fa-users"></i> Hesap Kartları <span class="fa fa-caret-down caret-opt"></span></a>
      <ul class="submenu">
        <li><a href="<?php site_url('admin/account'); ?>">Hesap Yönetimi</a></li>
        <li><a href="<?php site_url('admin/account/add.php'); ?>">Hesap Ekle</a></li>
        <li><a href="<?php site_url('admin/account/list.php'); ?>">Hesap Listesi</a></li>
      </ul>
    </li>
    <li class=""><a href="#"><i class="fa fa-cubes"></i> Ürün/Hizmet <span class="fa fa-caret-down caret-opt"></span></a>
      <ul class="submenu">
        <li><a href="<?php site_url('admin/item/'); ?>">Ürün Yönetimi</a></li>
        <li><a href="<?php site_url('admin/item/add.php'); ?>">Ürün Ekle</a></li>
        <li><a href="<?php site_url('admin/item/list.php'); ?>">Ürün Listesi</a></li>
      </ul>
    </li>
    <li class="admin-form"><a href="#"><i class="fa fa-shopping-cart"></i> Giriş/Çıkış <span class="fa fa-caret-down caret-opt"></span></a>
      <ul class="submenu">
        <li><a href="<?php site_url('admin/form/'); ?>">Form Yönetimi</a></li>
        <li><a href="<?php site_url('admin/form/detail.php?out'); ?>"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Yeni Satış Formu</a></li>
        <li><a href="<?php site_url('admin/form/detail.php?in'); ?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Yeni Alış Formu</a></li>
        <li><a href="<?php site_url('admin/form/list.php'); ?>">Form Listesi</a></li>
        <li><a href="<?php site_url('admin/form/options/index.php'); ?>">Seçenekler</a></li>
      </ul>
    </li>
     <li class="admin-payment"><a href="#"><i class="fa fa-money"></i> Ödemeler <span class="fa fa-caret-down caret-opt"></span></a>
      <ul class="submenu">
        <li><a href="<?php site_url('admin/payment/'); ?>">Kasa/Banka</a></li>
        <li><a href="<?php site_url('admin/payment/detail.php?out'); ?>"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Yeni Ödeme Çıkışı</a></li>
        <li><a href="<?php site_url('admin/payment/detail.php?in'); ?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Yeni Ödeme Girişi</a></li>
        <li><a href="<?php site_url('admin/payment/list.php'); ?>">Ödeme Listesi</a></li>
      </ul>
    </li>
    <li class="admin-user"><a href="#"><i class="fa fa-user-o"></i> Personeller <span class="fa fa-caret-down caret-opt"></span></a>
      <ul class="submenu">
        <li class="list"><a href="<?php site_url('admin/user/list.php'); ?>"><i class="fa fa-th-list fa-fw"></i>  Tüm Personeller</a></li>
        <?php if(user_access('admin')): ?><li><a href="<?php site_url('admin/user/add.php'); ?>"><i class="fa fa-plus fa-fw"></i> Yeni Personel Ekle</a></li><?php endif; ?>
        <li class="profile"><a href="<?php site_url('admin/user/profile.php'); ?>"><i class="fa fa-user-circle-o fa-fw"></i> Profilim</a></li>
        <li class="profile"><a href="<?php site_url('admin/user/message/list.php?box=inbox'); ?>"><i class="fa fa-envelope-o fa-fw"></i> Mesaj Kutusu</a></li>
        <li class="profile"><a href="<?php site_url('admin/user/task/list.php?box=inbox'); ?>"><i class="fa fa-tasks fa-fw"></i> Görev Yöneticisi</a></li>
      </ul>
    </li>
    <li class=""><a href="#"><i class="fa fa-gears"></i> Sistem <span class="fa fa-caret-down caret-opt"></span></a>
      <ul class="submenu">
        <li><a href="<?php site_url('admin/system/form_status'); ?>">Form Durum Yönetimi</a></li>
        <li><a href="<?php site_url('admin/system/case'); ?>">Kasa & Banka Yönetimi</a></li>
        <li><a href="<?php site_url('admin/system/options'); ?>">Genel Ayarlar</a></li>
        <li><a href="<?php site_url('admin/system/info'); ?>">Hakkımızda</a></li>
      </ul>
    </li>
    <?php if(user_access('superadmin')): ?>
      <li class=""><a href="#"><i class="fa fa-code"></i> Tasarım & Geliştirme <span class="fa fa-caret-down caret-opt"></span></a>
        <ul class="submenu">
          <li><a href="<?php site_url('admin/_developer/colors.php'); ?>">Color Palettes</a></li>
          <li><a href="<?php site_url('admin/_developer/grid.php'); ?>">Grid System</a></li>
          <li><a href="<?php site_url('admin/_developer/typography.php'); ?>">Typography</a></li>
          <li><a href="<?php site_url('admin/_developer/general.php'); ?>">General Elements</a></li>
          <li><a href="<?php site_url('admin/_developer/form.php'); ?>">Form Elements</a></li>
          <li><a href="<?php site_url('admin/_developer/buttons.php'); ?>">Buttons</a></li>
          <li><a href="<?php site_url('admin/_developer/panels.php'); ?>">Panels</a></li>
          <li><a href="<?php site_url('admin/_developer/icons.php'); ?>">Icons</a></li>
          <li><a href="<?php site_url('admin/_developer/alerts.php'); ?>">Alerts</a></li>
          <li><a href="<?php site_url('admin/_developer/tabs.php'); ?>">Tabs</a></li>
          <li><a href="<?php site_url('admin/_developer/helper.php'); ?>">Helper Css Classes</a></li>
        </ul>
      </li>
    <?php endif; ?>
  </ul> <!-- /.sidebar-menu -->

</div> <!-- /.sidebar -->



<script>
$(document).ready(function() {
  $('ul.sidebar-menu li a').click(function() {
    if($(this).parent('li').hasClass('active')) {
      $(this).parent('li').removeClass('active');
      $(this).find('span.fa').removeClass('fa-caret-up');
      $(this).find('span.fa').addClass('fa-caret-down');
    } else {
      $(this).parent('li').addClass('active');
      $(this).find('span.fa').removeClass('fa-caret-down');
      $(this).find('span.fa').addClass('fa-caret-up');
    }
  });
});
</script>

<style>
main {
  margin-left:250px;
}
</style>





<?php

if($explode = explode('/admin/', $_SERVER['SCRIPT_NAME'])) {
  if($exp = explode('/', @$explode[1])) {

    if(isset($exp[1])) {
      $exp[1] = str_replace('.php', '', @$exp[1]);
      ?>
      <script>
        $(document).ready(function() {
          $('ul.sidebar-menu li.admin-<?php echo $exp[0]; ?>').addClass('active');
          $('ul.sidebar-menu li.admin-<?php echo $exp[0]; ?> ul li.<?php echo $exp[1]; ?>').addClass('active');
        });
      </script>
      <?php
    }
  }
}

?>
