<?php
$til = new stdclass;
global $til;

function til($val = '')
{
    global $til;
    return $til;
}

if (empty($_POST)) {
    @file_get_contents('http://api.tilpark.org/log.php?type=installation&step=0&url=' . str_replace('installation.php', '', $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']) . '&user_ip=' . $_SERVER['SERVER_ADDR']);
}


include('includes/input.php');

// DATEBASE CONTROL
if (isset($_POST['step_1'])) {
    $_database = array(
        'database' => trim($_POST['database']),
        'username' => trim($_POST['username']),
        'password' => trim($_POST['password']),
        'host' => trim($_POST['host'])
    );

    @file_get_contents('http://api.tilpark.org/log.php?type=installation&step=1&url=' . str_replace('installation.php', '', $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']) . '&user_ip=' . $_SERVER['SERVER_ADDR']);

    $db = @mysqli_connect($_database['host'], $_database['username'], $_database['password'], $_database['database']);

    if (mysqli_connect_errno()) {
        add_alert('Sunucu veya Veritabanı Bağlantısı Kurulamadı!');
        unset($_POST['step_1']);
    }
}
// DATEBASE CONTROL


// User control AND Insert tables
if (isset($_POST['step_2'])) {
    $_database = array(
        'database' => $_POST['database'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'host' => $_POST['host'],
        'prefix' => @$_POST['table_prefix']
    );


    $_user = array(
        'username' => $_POST['user_username'],
        'password' => $_POST['user_password'],
        'email' => $_POST['user_email'],
        'name' => strtoupper($_POST['user_name']),
        'surname' => strtoupper($_POST['user_surname']),
        'gsm' => $_POST['user_gsm']
    );


    form_validation($_user['username'], 'user_username', 'Kullanıcı Adı', 'required|min_length[3|maxlength[32]');
    form_validation($_user['password'], 'user_password', 'Şifre', 'required|min_length[6]max_length[32]');
    form_validation($_user['email'], 'user_email', 'E-Posta', 'required|min_length[3]|email');
    form_validation($_user['name'], 'user_name', 'Ad', 'required|min_length[3]|max_length[32]');
    form_validation($_user['surname'], 'user_surname', 'Soyad', 'required|min_length[3]|max_length[32]');
    form_validation($_user['gsm'], 'user_gsm', 'GSM', 'required|gsm|min_length[10]|max_length[11]');


    if (!is_alert()) {
        foreach ($_user as $key => $value) {
            $_send_user[$key] = urlencode($value);
        }

        @file_get_contents('http://api.tilpark.org/log.php?type=installation&step=2&url=' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '&user_ip=' . $_SERVER['SERVER_ADDR'] . '&username=' . $_send_user['username'] . '&email=' . $_send_user['email'] . '&name=' . $_send_user['name'] . '&surname=' . $_send_user['surname'] . '&gsm=' . $_send_user['gsm']);

        $db = @mysqli_connect($_database['host'], $_database['username'], $_database['password'], $_database['database']);

        if (mysqli_connect_errno()) {
            add_alert('Sunucu veya Veritabanı Bağlantısı Kurulamadı!');
            unset($_POST['step_2']);
        } else {

            //Veritabanı klasöründe ki sorgular aranıyor.
            $dir = 'install/database';
            $files = scandir($dir);

            //Dosyalar foreach döngüsüne alınıyor.
            foreach ($files as $file) {

                if (strpos($file, '.sql') !== false) { // Sadece .sql uzantılı dosyalar için kısıt veriliyor.

                    $dbfile = fopen("{$dir}/{$file}", "r") or die("SQL dosyası açılamadı!");
                    $sqlquery = fread($dbfile, filesize("{$dir}/{$file}")); // Dosya okunuyor
                    $sqlquery = str_replace("{prefix}", $_database['prefix'], $sqlquery); // Tablo önekleri değiştiriliyor

                    if (!$db->query($sqlquery)) {
                        echo $sqlquery;
                        unset($_POST['step_2']);
                    }

                }

            }
            if (isset($_POST['step_2'])) {
                if ($q_select = $db->query("SELECT * FROM " . $_database['prefix'] . "users WHERE username='" . $_user['username'] . "' ")) {
                    if ($q_select->num_rows) {

                        add_alert($_user['username'] . " kullanıcı adı zaten mevcut.", 'info');
                        $_POST['step_3'] = true;

                    } else {
                        if ($db->query("INSERT INTO " . $_database['prefix'] . "users (username, password, email, name, surname, gsm, gender, role) VALUES ('" . $_user['username'] . "', '" . $_user['password'] . "', '" . $_user['email'] . "', '" . $_user['name'] . "', '" . $_user['surname'] . "', '" . $_user['gsm'] . "', '1', '1')")) {
                            if ($db->insert_id) {
                                if (is_writable('til-config.php')) {
                                    $config_writing = "<?php \ndefine('_serverName', '" . $_database['host'] . "'); \ndefine('_userName', '" . $_database['username'] . "'); \ndefine('_userPassword', '" . $_database['password'] . "'); \ndefine('_dbName', '" . $_database['database'] . "'); \ndefine('_prefix', '" . $_database['prefix'] . "'); \ndefine('_site_url', 'http://" . rtrim(str_replace('/installation.php', '', $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']), '/') . "');";

                                    $til_config = fopen('til-config.php', 'w');
                                    fwrite($til_config, $config_writing);
                                    fclose($til_config);
                                } else {
                                    add_alert('til-config.php Dosyası yazılabilir değil!');
                                }

                                $_POST['step_3'] = true;
                            } else {
                                add_alert('Kullanıcı Hesabı Eklenemedi.');
                            }
                        } else {
                            add_alert('Kullanıcı Hesabı eklenirken veritabanı hatası oluştu.');
                        }
                    }
                } else {
                    add_alert('MYSQL Hatası!');
                }
            } else {
                add_alert('Yolunda gitmeyen bir şeyler var. Kurulumu Tekrardan Yapmayı Deneyebilirsiniz.');
            }
        }
    } else {
        unset($_POST['step_2']);
        $_POST['step_1'] = true;
    }
}
// User control AND Insert tables
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>

    <title>Tilpark Kurulum!</title>

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="content/themes/default/css/tilpark.css">
    <link rel="stylesheet" type="text/css" href="content/themes/default/css/app.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript"> $(document).ready(function () {
            $('.validate').validate();
        });</script>
</head>
<body>
<div class="container">
    <div class="h-40"></div>
    <div class="form-group text-center">
        <a href=""><img src="content/themes/default/img/logo_blank.png" width="80px"></a>
    </div><!--/ .text-center /-->
    <div class="h-20"></div>


    <style type="text/css">
        @media (max-width: 767px) {
            .container {
                width: 100%;
                margin: 0 -15px;
            }
        }

        ul {
            -webkit-padding-start: 0;
            list-style: none;
        }

        .h-20 {
            height: 20px;
        }

        .h-40 {
            height: 40px;
        }

        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 375px;
            position: relative;
            margin: 0 auto;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;
        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }

        .form-container {
            width: 375px;
            margin: 0 auto;
        }

        .form-group.border-bottom {
            border-bottom: 1px solid #ddd;
        }

        .btn-theme {
            background: #ffc50c;
            color: #333;
        }

        .btn-theme:hover,
        .btn-theme:focus {
            background: #ffc50c !important;
            color: #333;
        }
    </style>


    <?php if (!is_writable('til-config.php')) : ?>
        <div class="form-container">
            <?php add_alert('<b>"til-config.php"</b> dosyasının yazılabilir değil.') ?>
            <?php print_alert(); ?>
            <small class="text-center block">Desktek almak için <a href="http://tilpark.org/forum" class="bold">"tilpark"</a>
                forumlarını ziyaret ediniz.
            </small>
            <?php exit; ?>
        </div>
    <?php endif; ?>

    <!--/ Step tab /-->
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <button type="button" class="btn btn-<?php if (!isset($_POST['step_1']) AND !isset($_POST['step_2'])) {
                    echo 'theme';
                } else {
                    echo 'default';
                } ?> btn-circle">1
                </button>
                <p>1. Adım</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-<?php if (isset($_POST['step_1'])) {
                    echo 'theme';
                } else {
                    echo 'default';
                } ?> btn-circle" disabled="disabled">2
                </button>
                <p>2. Adım</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-<?php if (isset($_POST['step_2'])) {
                    echo 'theme';
                } else {
                    echo 'default';
                } ?> btn-circle" disabled="disabled">3
                </button>
                <p>3. Adım</p>
            </div>
        </div>
    </div>
    <!--/ Step tab /-->

    <!--/ Setup Form /-->
    <form class="validate" id="installation" method="POST" autocomplete="off">
        <div class="form-container">
            <div class="panel panel-default">
                <div class="panel-body">

                    <?php if (!isset($_POST['step_1']) AND !isset($_POST['step_2'])): ?>
                        <div class="setup-content">
                            <?php print_alert(); ?>
                            <h4 class="text-center">Veritabanı Bilgileri</h4>

                            <div class="h-20"></div>

                            <div class="form-group">
                                <label for="host">Veritabanı Sunucusu
                                    <small class="text-muted italic ml-10">( genellikle "localhost" )</small>
                                </label>
                                <input type="text" name="host" id="host" dynamic-input required class="form-control"
                                       placeohlder="" value="localhost">
                            </div><!--/ .form-group /-->

                            <div class="form-group">
                                <label for="database">Veritabanı Adı</label>
                                <input type="text" autofocus name="database" id="database" dynamic-input required
                                       class="form-control" placeohlder="">
                            </div><!--/ .form-group /-->

                            <div class="form-group">
                                <label for="username">Kullanıcı Adı</label>
                                <input type="text" name="username" id="username" dynamic-input required
                                       class="form-control" placeohlder="">
                            </div><!--/ .form-group /-->

                            <div class="form-group">
                                <label for="password">Şifre</label>
                                <input type="passwrod" name="password" id="password" class="form-control"
                                       placeohlder="">
                            </div><!--/ .form-group /-->

                            <div class="form-group">
                                <label for="table_prefix">Tablo ön eki
                                    <small class="text-muted italic ml-10">( önerilen "_til" )</small>
                                </label>
                                <input type="text" name="table_prefix" id="table_prefix" dynamic-input
                                       class="form-control" placeohlder="" value="til_">
                            </div><!--/ .form-group /-->

                            <div class="form-group">
                                <input type="hidden" name="step_1">
                                <button class="btn btn-theme pull-right" type="submit">Sonraki</button>
                            </div><!--/ .form-group /-->
                        </div><!--/ .setup-content #step-1 /-->
                    <?php endif; ?>

                    <?php if (isset($_POST['step_1']) OR isset($_POST['step_3'])) : ?>
                        <?php if (!isset($_POST['step_2'])) : ?>
                            <div class="setup-content" id="step-2">
                                <?php print_alert(); ?>
                                <h4>Kullanıcı Bilgileri</h4>

                                <div class="form-group">
                                    <label for="user_username">Kullanıcı Adı</label>
                                    <input type="text" autofocus name="user_username" id="user_username" dynamic-input
                                           required class="form-control" placeohlder="">
                                </div><!--/ .form-group /-->

                                <div class="form-group">
                                    <label for="user_password">Parola</label>
                                    <input type="password" name="user_password" id="user_password" required
                                           class="form-control" placeohlder="">
                                </div><!--/ .form-group /-->

                                <div class="row space-5">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_name">Ad </label>
                                            <input type="text" name="user_name" id="user_name" dynamic-input required
                                                   class="form-control" placeohlder="">
                                        </div><!--/ .form-group /-->
                                    </div><!--/ .col-md-6 /-->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_surname">Soyad</label>
                                            <input type="text" name="user_surname" id="user_surname" dynamic-input
                                                   required class="form-control" placeohlder="">
                                        </div><!--/ .form-group /-->
                                    </div><!--/ .col-md-6 /-->
                                </div><!--/ .row.space-5 /-->

                                <div class="row space-5">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_email">Email</label>
                                            <input type="email" name="user_email" id="user_email" dynamic-input required
                                                   class="form-control" placeohlder="">
                                        </div><!--/ .form-group /-->
                                    </div><!--/ .col-md-6 /-->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_gsm">GSM</label>
                                            <input type="text" name="user_gsm" id="user_gsm" minlength="10"
                                                   maxlength="12" dynamic-input required class="form-control number"
                                                   placeohlder="">
                                        </div><!--/ .form-group /-->
                                    </div><!--/ .col-md-6 /-->
                                </div><!--/ .row.space-5 /-->

                                <div class="form-group">
                                    <input type="hidden" name="step_2" value="step_2">
                                    <input type="hidden" name="database" value="<?php echo @$_POST['database']; ?>">
                                    <input type="hidden" name="username" value="<?php echo @$_POST['username']; ?>">
                                    <input type="hidden" name="password" value="<?php echo @$_POST['password']; ?>">
                                    <input type="hidden" name="table_prefix"
                                           value="<?php echo @$_POST['table_prefix']; ?>">
                                    <input type="hidden" name="host" value="<?php echo @$_POST['host']; ?>">

                                    <button class="btn btn-theme pull-right" type="submit" onclick="">Sonraki</button>
                                </div><!--/ .form-group /-->
                            </div><!--/ .setup-content #step-1 /-->
                        <?php else: ?>
                            <?php if ($_POST['step_3']) : ?>
                                <?php print_alert(); ?>
                                <h4>Kurulum Başarılı</h4>
                                <p> Kurulum işlemi başarılı bir şekilde gerçekleşti. </p>

                                <div class="row">
                                    <div class="col-md-4 col-xs-4">
                                        Kullanıcı adı :
                                        <br>
                                        Şifre :
                                    </div>

                                    <div class="col-md-8 col-xs-8">
                                        <?php echo @$_POST['user_username']; ?>
                                        <br>
                                        <i>Seçmiş olduğunuz şifre</i>
                                    </div>
                                </div>

                                <div class="h-40"></div>

                                <a href="login.php" class="btn btn-theme pull-right">Giriş Yap</a>
                            <?php endif; // if ( $db->query("SELECT * FROM ") ) ?>
                        <?php endif; // if ( !isset($_POST['step_2']) ) ?>
                    <?php endif; // if ( isset($_POST['step_1']) ) ?>
                </div><!--/ .panel-body /-->
            </div><!--/ .panel /-->
        </div><!--/ .form-container /-->
    </form>
    <!--/ Setup Form /-->
</div><!--/ .container /-->
</body>
</html>
