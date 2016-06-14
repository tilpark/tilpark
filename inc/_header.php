<html>
<head>
  <title>Tilpark!</title>
  <meta name="description" content="Tilpark! Açık kaynak kodlu şirket yönetim otomasyonu">
  <link rel="shortcut icon" href="<?php site_url('theme/img/favicon.ico'); ?>">

  <!-- other lib -->
  <script src="<?php site_url('theme/js/jquery.min.js'); ?>"></script>
  <script src="<?php site_url('theme/js/jquery.validation.js'); ?>"></script>


  <!-- bootstrap -->
  <link rel="stylesheet" href="<?php site_url('theme/css/bootstrap.min.css'); ?>">
  <script src="<?php site_url('theme/js/bootstrap.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?php site_url('theme/css/font-awesome.min.css'); ?>">

   <!-- dataTables -->
  <link rel="stylesheet" href="<?php site_url('theme/css/datatables.min.css'); ?>">
  <script src="<?php site_url('theme/js/datatables.min.js'); ?>"></script>

  <!-- dataTables -->
  <link rel="stylesheet" href="<?php site_url('theme/css/datepicker.css'); ?>">
  <script src="<?php site_url('theme/js/bootstrap-datepicker.js'); ?>"></script>


  <!-- custom css -->
  <link rel="stylesheet" href="<?php site_url('theme/css/app.css'); ?>">
  <script src="<?php site_url('theme/js/app.js'); ?>"></script>

  <script src="<?php site_url('theme/js/jquery.table2excel.js'); ?>"></script>

</head>
<body>




<style>
/*!
 * Start Bootstrap - Simple Sidebar HTML Template (http://startbootstrap.com)
 * Code licensed under the Apache License v2.0.
 * For details, see http://www.apache.org/licenses/LICENSE-2.0.
 */

/* Toggle Styles */

#wrapper {
    padding-left: 0px;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#wrapper.toggled {
    padding-left: 250px;
}

#sidebar-wrapper {
    z-index: 1000;
    position: fixed;
    left: 250px;
    width: 0px;
    height: 100%;
    margin-left: -250px;
    overflow-y: auto;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#wrapper.toggled #sidebar-wrapper {
    width: 250px;
}
#wrapper.toggled #sidebar-wrapper .sidebar-menu li a span.menu-label {
	display: none;
}

/* custom style */
#wrapper.toggled #sidebar-wrapper .sidebar-user .row .col-md-9 {
	display: none;
}
#wrapper.toggled #sidebar-wrapper .sidebar-user .row .col-md-3 {
	width: 100%;
	-webkit-transition: all 0.6s ease;
    -moz-transition: all 0.6s ease;
    -o-transition: all 0.6s ease;
    transition: all 0.6s ease;
}
#wrapper.toggled #sidebar-wrapper .sidebar-title {
	display: none;
}





#page-content-wrapper {
    width: 100%;
    position: absolute;
}

#wrapper.toggled #page-content-wrapper {
    position: absolute;
    margin-right: -250px;
}

/* Sidebar Styles */

.sidebar-nav {
    position: absolute;
    top: 0;
    width: 250px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.sidebar-nav li {
    text-indent: 20px;
    line-height: 40px;
}

.sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: #999999;
}

.sidebar-nav li a:hover {
    text-decoration: none;
    color: #fff;
    background: rgba(255,255,255,0.2);
}

.sidebar-nav li a:active,
.sidebar-nav li a:focus {
    text-decoration: none;
}

.sidebar-nav > .sidebar-brand {
    height: 65px;
    font-size: 18px;
    line-height: 60px;
}

.sidebar-nav > .sidebar-brand a {
    color: #999999;
}

.sidebar-nav > .sidebar-brand a:hover {
    color: #fff;
    background: none;
}

@media(min-width:768px) {
    #wrapper {
        padding-left: 250px;
    }

    #wrapper.toggled {
        padding-left: 75px;
    }

    #sidebar-wrapper {
        width: 250px;
    }

    #wrapper.toggled #sidebar-wrapper {
        width: 75px;
    }

    #page-content-wrapper {
        position: relative;
    }

    #wrapper.toggled #page-content-wrapper {
        position: relative;
        margin-right: 0;
    }
}
	</style>

	<script>
$(document).ready(function() {

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

});
	</script>

<div class="container-fluid">
<header>
		<nav class="navbar navbar-default navbar-top">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">




		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="<?php site_url('index.php'); ?>"><img src="<?php site_url('theme/img/logo.png'); ?>" alt="TilPark!" class="img-responsive" style="width: 80px; margin-top: -5px;"></a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

		    	<style>
		    	#menu-toggle {
		    		display: inline-block;
		    		float: left;
		    		font-size: 20px;
		    		margin-top: 10px;
		    		margin-right: 20px;
		    		padding: 5px;
		    		border-radius: 3px;
		    		color:#fff;
		    	}
		    	#menu-toggle:hover {
		    		color:#D0D0D0;
		    	}
		    	</style>
		        <a href="#" id="menu-toggle"><i class="fa fa-bars"></i></a>


		        <ul class="nav navbar-nav navbar-right">
		        <li class="dropdown dropdown-user">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		          	<div class="row no-space">
		          		<div class="col-md-4">
		          			<img src="<?php site_url('theme/img/avatar.jpg'); ?>" alt="avatar" class="img-avatar">
		          		</div> <!-- /.col-md-4 -->
		          		<div class="col-md-8">
				          	<span class="user-name">Mustafa <span class="caret"></span></span>
				        </div>
				    </div>
		          </a>
		          <ul class="dropdown-menu">
		            <li><a href="<?php site_url('content/users/profile.php'); ?>">Profilim</a></li>
		            <li><a href="#">Mesaj Kutusu</a></li>
		            <li><a href="#">Ayarlar</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="<?php site_url('logout.php'); ?>">Çıkış Yap</a></li>
		          </ul>
		        </li>
		      </ul>

		      <ul class="nav navbar-nav navbar-notifications navbar-right">
		        <li><a href="#"><i class="fa fa-envelope"></i></a></li>
		        <li><a href="#"><i class="fa fa-tasks"></i></a></li>
		        <li><a href="#"><i class="fa fa-globe"></i></a></li>
		       </ul>




		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	</header>
</div>


<div id="wrapper">




			<div class="sidebar" id="sidebar-wrapper">

				<div class="sidebar-user">
					<div class="row no-space">
						<div class="col-md-3">
							<div class="profile-img">
								<img src="<?php site_url('theme/img/avatar.jpg'); ?>" alt="avatar" class="img-responsive">
							</div> <!-- /.profile-img -->
						</div> <!-- /.col-md-3 -->
						<div class="col-md-9">
							<div class="profile-info">
								<span class="profile-hi-title">Selam</span>, <span class="profile-user_name">Mustafa</span>
							</div>
						</div> <!-- /.col-md-9 -->
					</div> <!-- /.row -->
				</div> <!-- /.sidebar-user -->


				<form class="navbar-form form-search" role="search">
				    <input type="text" class="form-control ff-2" id="inputGroupSuccess1" aria-describedby="inputGroupSuccess1Status">
		      	</form>

		      	<div class="clearfix"></div>
		      	<div class="h20"></div>

		      	<div class="sidebar-title">ANA MENÜ</div>

				<ul class="sidebar-menu">
					<li class="active home-index"><a href="#"><i class="fa fa-dashboard"></i> <span class="menu-label">Yönetim Paneli</span></a></li>
					<li class="has_submenu products-index">
						<a href="#"><i class="fa fa-cubes"></i> <span class="menu-label">Ürünler</span> <span class="caret"></span></a>
						<ul class="submenu">
							<li class="products-add"><a href="#">Ürün Ekle</a>
							<li><a href="#">Ürün Listesi</a>
							<li><a href="#">Ürün Raporları</a>
						</ul> <!-- /.submenu -->
					</li>
					<li class="has_submenu">
						<a href="#"><i class="fa fa-users"></i> <span class="menu-label">Hesaplar</span> <span class="caret"></span></a>
						<ul class="submenu">
							<li><a href="#">Ürün Ekle</a>
							<li><a href="#">Ürün Listesi</a>
							<li><a href="#">Ürün Raporları</a>
						</ul> <!-- /.submenu -->

					</li>
					<li><a href="#"><i class="fa fa-shopping-cart"></i> <span class="menu-label">Giriş-Çıkış</span></a></li>
					<li><a href="#"><i class="fa fa-money"></i> <span class="menu-label">Kasa & Ödeme</span></a></li>
					<li><a href="#"><i class="fa fa-plug"></i> <span class="menu-label">Eklentiler</span></a></li>
					<li class="has_submenu">
						<a href="#"><i class="fa fa-hand-peace-o"></i> <span class="menu-label">Tema</span> <span class="caret"></span></a>
						<ul class="submenu">
							<li><a href="#">UI Features</a>
							<li><a href="#">Typography</a>
							<li><a href="#">Buttons & İcons</a>
							<li><a href="#">Charts</a>
							<li><a href="<?php echo site_url('theme/til-panels.php'); ?>">Panels & Widget</a>
							<li><a href="#">Modals</a>
							<li><a href="#">Tabs</a>
							<li><a href="#">Helper Classes</a>
						</ul> <!-- /.submenu -->
					</li>
				</ul>

			</div> <!-- /.sidebar -->


<div id="page-content-wrapper">
<div class="container-fluid">
