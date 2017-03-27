<?php include('tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Yönetim Paneli' );
?>





<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

		<div class="row space-5">
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/account/'); ?>">
						<span class="count"><i class="fa fa-users"></i></span>
						<h3>Hesap</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/item/'); ?>">
						<span class="count"><i class="fa fa-cubes"></i></span>
						<h3>Ürün</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/form/'); ?>">
						<span class="count"><i class="fa fa-shopping-cart"></i></span>
						<h3>Giriş - Çıkış</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/payment/'); ?>">
						<span class="count"><i class="fa fa-bank"></i></span>
						<h3>Kasa</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/user/'); ?>">
						<span class="count"><i class="fa fa-user-o"></i></span>
						<h3>Personel</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
			<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
				<div class="box-menu">
					<a href="<?php site_url('admin/user/'); ?>">
						<span class="count"><i class="fa fa-cogs"></i></span>
						<h3>Sistem</h3>
					</a>
				</div> <!-- /.box-menu -->
			</div> <!-- /.col-* -->
		</div> <!-- /.row -->

		<div class="h-20 visible-xs"></div>

	</div> <!-- /.col-md-6 -->
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

	</div>
</div> <!-- /.row -->















<?php get_footer(); ?>





<?php 
function rastgeleYazi($uzunluk = 10) {
    $karakterler = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $karakterlerUzunlugu = strlen($karakterler);
    $rastgele = '';
    for ($i = 0; $i < $uzunluk; $i++) {
        $rastgele .= $karakterler[mt_rand(0, $karakterlerUzunlugu - 1)];
    }
    return $rastgele;
}




if(isset($_GET['add_account'])) {


	for($i=0; $i<=100000; $i++) {
		$array=array();
		$array['type'] = 'account';
		$array['name'] = rastgeleYazi(20);
		$array['code'] = rastgeleYazi(20);
		$array['email'] = til_get_strtolower($array['name']).'@tilpark.com';
		$array['gsm'] = '535'.rand(1111111,9999999);
		$array['phone'] = rand(1111111111,9999999999);
		$array['address'] = rastgeleYazi(250);
		$array['tax_home'] = rastgeleYazi(20);
		$array['tax_no'] = rand(1111111111,9999999999);
		add_account($array);
	}

}
?>
