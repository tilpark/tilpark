<?php
ob_start();
session_start();
?>
<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Tilpark!</title>

    <!-- CSS -->
    <link href="<?php echo _site_url.'/content/themes/default/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo _site_url.'/content/themes/default/css/font-awesome.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo _site_url.'/content/themes/default/css/tilpark.css'; ?>" rel="stylesheet">
    <link href="<?php echo _site_url.'/content/themes/default/css/app.css'; ?>" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo _site_url.'/content/themes/default/js/bootstrap.min.js'; ?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


<style>

</style>

</head>
<body class="body">

	<?php $bg_number = rand(1,5); ?>

<style>

body {
  background: url('<?php echo _site_url; ?>/content/themes/default/img/login/bg-<?php echo $bg_number; ?>.jpg') no-repeat center fixed;
}
div.h20 {height: 20px;}
.bg_opacity {
  background-color: rgba(0, 0, 0, 0.5);
  height: 100%;
  width: 100%;
  z-index: -1;
  position: absolute;
  top: 0;
  left: 0;
}

.loginbox {
  border-radius: 4px;
  background-color: rgba(250, 250, 250, 0.8);
  padding: 30px;
  margin-top:20%;
}
.loginbox form input {
  font-size: 16px;
  padding: 10px 14px !important;
  border-radius: 3px;
}
.loginbox .btn {
  border-radius: 3px;
}

.loginbox .social_box {
  text-align: right;
  background-color: rgba(241, 242, 242, 0.7);
  margin: 0 -30px -30px -30px;
  padding: 30px;
  border-bottom-left-radius: 4px;
  border-bottom-right-radius: 4px;
}
.loginbox .social_box a i.fa {
  font-size: 22px;
}

.loginbox .social_box a {
  display: inline-block;
  width: 40px;
  height: 40px;
  padding-top: 10px;
  text-align: center;
  border-radius: 360px;
  color: #fff;
  background-color: #3b5998;
  border-color: rgba(0,0,0,0.2);
}
.loginbox .social_box a:hover {
  opacity: 0.9;
}

.loginbox .social_box a.sbox-facebook {background-color: #3b5998;}
.loginbox .social_box a.sbox-twitter {background-color: #55acee;}
.loginbox .social_box a.sbox-instagram {background-color: #3f729b;}
.loginbox .social_box a.sbox-google-plus {background-color: #dd4b39;}
.loginbox .social_box a.sbox-github {background-color: #444;}


/* validation icin error style */
input.error {
    border-color: #843534;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #ce8483;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #ce8483;
}
label.error {
    font-weight: normal;
    font-size: 11px;
    background-color: #FDD8D8;
    padding: 4px 6px;
    margin-top: 5px;
    border-radius: 2px;
}
#terms-error { /* bunu sadece checkbox icin yazdik, terms(kurallar) */
    position: absolute;
    margin-top: 20px;
    margin-left: -20px;
}

</style>

<?php

$login_form_error = false;
if(isset($_POST['username']))
{
  $username = trim(addslashes($_POST['username']));
  $password = trim(addslashes($_POST['password']));

  $q_login = db()->query("SELECT * FROM ".dbname('users')." WHERE username='$username' AND password='$password'");

  if($q_login->num_rows > 0)
  {
    $login = $q_login->fetch_assoc();
    $_SESSION['login_id'] = $login['id'];
    header("Location:"._site_url);

  }
  else
  {
    $login_form_error = true;
  }
} else {
  $username = "mustafa@tilpark.com";
  $password = "909090";
}
?>





<div class="container-fluid">
  <div class="row">
    <div class="col-md-7"></div>
    <div class="col-xs-16 col-md-5">
      <div class="loginbox">

        <div>
          <img src="<?php echo _site_url; ?>/content/themes/default/img/logo_header.png" class="img-responsive" style="width: 150px;">
        </div>
        <div class="h20"></div>

        <?php if($login_form_error): ?>
          <div class="alert alert-danger alert-loginError" role="alert"> <strong><i class="fa fa-exclamation-triangle"></i> Giriş başarısız!</strong> Kullanıcı adı veya şifre hatalı. </div>
          <script>
          setTimeout(ChangeBorder1, 100);
          setTimeout(ChangeBorder2, 200);
          setTimeout(ChangeBorder1, 300);
          setTimeout(ChangeBorder2, 400);
          setTimeout(ChangeBorder1, 500);
          setTimeout(ChangeBorder2, 600);
          setTimeout(ChangeBorder1, 700);
          setTimeout(ChangeBorder2, 800);
          setTimeout(ChangeBorder1, 900);
          setTimeout(ChangeBorder2, 1000);
          setTimeout(ChangeBorder1, 1100);
          setTimeout(ChangeBorder2, 1200);


          function ChangeBorder1() {$(".alert-loginError").css({"border-color":"a94442"});}
          function ChangeBorder2() {$(".alert-loginError").css({"border-color":"ebccd1"});}
          </script>

        <?php endif; ?>

        <form name="form_login" id="form_login" action="" method="POST" class="validation">
          <div class="form-group">
            <input type="email" name="username" id="username" class="form-control input-lg required email" value="<?php echo @$username; ?>" placeholder="E-posta">
          </div> <!-- /.form-group -->
          <div class="form-group">
            <input type="password" name="password" id="password" class="form-control input-lg required" value="<?php echo @$password; ?>" placeholder="Şifre">
          </div> <!-- /.form-group -->

          <div class="row">
            <div class="col-md-6">
              <div class="checkbox">
                <label>
                  <input type="checkbox"> <span class="text-muted">Beni hatırla</span>
                </label>
              </div> <!-- /.checkbox -->
            </div> <!-- /.col-md-6 -->
            <div class="col-md-6">
            </div> <!-- /.col-md-6 -->
          </div> <!-- /.row -->

          <div class="text-right">
            <button class="btn btn-success btn-block btn-lg">Giriş Yap</button>
          </div> <!-- /.text-right -->
          <div class="h20"></div>

        </form>

        <div class="social_box">
          <span class="text-muted" style="font-style:italic;">Bizi takip edin: &nbsp; &nbsp;</span>
          <a href="#" class="sbox-facebook"><i class="fa fa-facebook"></i></a>
          <a href="#" class="sbox-twitter"><i class="fa fa-twitter"></i></a>
          <a href="#" class="sbox-instagram"><i class="fa fa-instagram"></i></a>
          <a href="#" class="sbox-google-plus"><i class="fa fa-google-plus"></i></a>
          <a href="#" class="sbox-github"><i class="fa fa-github"></i></a>
        </div> <!-- /.social_box -->


      </div>

      <div>

      </div>

    </div> <!-- /.col-md-4 -->
  </div> <!-- /.row -->
</div> <!-- /.container -->

<style>
footer {
  position: absolute;
  bottom:50px;
}
.footer_links a {
  color: rgba(255,255,255,0.5);
  margin-left: 13px;
  font-size: 13px;
  text-decoration: underline;
}
.footer_links a:hover {
  text-decoration: none;
}
</style>

<footer>
  <div class="footer_links">
    <a href="#">Hakkımızda</a>
    <a href="#">Geliştici ekip</a>
    <a href="#">Telif haklarımız</a>
    <a href="#">Kullanım koşulları</a>
    <a href="#">fotoğraf @PhoneDune</a>
  </div> <!-- /.footer_links -->
</footer>

<div class="bg_opacity"></div>



</body>
</script>