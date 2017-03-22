<script type="text/javascript">
  window.site_url   = '<?php echo get_site_url(); ?>';
  window.session_id = '<?php echo session_id(); ?>';
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Tilpark!</title>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.css"/>


    <!-- CSS -->
    <link href="<?php echo template_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo template_url('css/font-awesome.min.css'); ?>" rel="stylesheet">


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.8.23/jquery-ui.js" integrity="sha256-lFA8dPmfmR4AQorTbla7C2W0aborhztLt0IQFLAVBTQ=" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo template_url('js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo template_url('js/jquery.validate.min.js'); ?>"></script>
    <script src="<?php echo template_url('js/jquery.number.js'); ?>"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js"></script>

     <!-- chartjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <!-- datepicker -->
    <script src="http://momentjs.com/downloads/moment.min.js"></script>
    <link href="<?php echo template_url('css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet">
    <script src="<?php echo template_url('js/bootstrap-datetimepicker.min.js'); ?>"></script>

    <!-- select style -->
    <link href="<?php echo template_url('css/bootstrap-select.min.css'); ?>" rel="stylesheet">
    <script src="<?php echo template_url('js/bootstrap-select.min.js'); ?>"></script>

    <!-- colorpicker -->
    <link href="<?php echo template_url('css/bootstrap-colorpicker.min.css'); ?>" rel="stylesheet">
    <script src="<?php echo template_url('js/bootstrap-colorpicker.min.js'); ?>"></script>


    <!-- Rich Text Editor -->
    <script src="<?php echo get_site_url('includes/lib/tinymce/tinymce.min.js'); ?>"></script>


    <link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
    <link href="<?php echo template_url('css/app.css'); ?>" rel="stylesheet">

    <script src="<?php echo template_url('js/app.js'); ?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->




  </head>


<body class="body">


<header>
  <nav class="navbar navbar-masthead navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-example-masthead-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php site_url(); ?>"><img src="<?php template_url('img/logo_header.png'); ?>" class="img-responsive"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse bs-example-masthead-collapse-1">



        <ul class="nav navbar-nav navbar-right">
          <!-- task -->
          <li class="icon-badge dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-tasks"></i> <span class="badge"><?php echo $task_unread = get_calc_task(); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-message-list effect-1">
              <li class="message-header"><?php echo $task_unread; ?> okunmamış görev</li>
              <?php if($messages = get_messages(array('query'=>_get_query_task('inbox').' LIMIT 5'))): ?>
                <?php foreach($messages as $message): ?>
                <li class="message-list <?php if(!$message->read_it and $message->inbox_u_id == get_active_user('id')): ?>bold<?php endif; ?>">
                  <a href="<?php site_url('admin/user/task/detail.php?id='.$message->id); ?>">
                    <div class="row no-space">
                      <div class="col-md-2">
                        <div class="message-avatar">
                          <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive center-block">
                        </div> <!-- /.message-avatar -->
                      </div> <!-- /.col-md-2 -->
                      <div class="col-md-10">
                        <span class="message-name"><?php echo get_user_info($message->outbox_u_id, 'name'); ?> <?php echo get_user_info($message->outbox_u_id, 'surname'); ?></span>
                        <span class="message-time"><i class="fa fa-clock-o"></i> <?php echo get_time_late($message->date_update); ?> önce</span>
                        <?php
                        // eger cevap mesaji ise cevap mesajini bulalim
                        if($q_select = db()->query("SELECT * FROM ".dbname('messages')." WHERE top_id='".$message->id."' ORDER BY date_update DESC LIMIT 1")) {
                          if($q_select->num_rows) {
                            $sub_message    = $q_select->fetch_object();
                            $message->title = '-'.$sub_message->message;
                          }
                        }
                        ?>
                        <span class="message-title text-muted"><?php echo mb_substr(strip_tags(stripslashes($message->title)),0,40,'utf-8'); ?><?php if(strlen(strip_tags(stripslashes($message->title))) > 40) { echo '...'; } ?></span>
                      </div> <!-- /.col-md-10 -->
                    </div> <!-- /.row -->
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="p-5">
                  <?php echo get_alert('Mesaj kutusu boş.', 'warning', false); ?>
                </div>
              <?php endif; ?>
              <li class="message-footer"><a href="<?php site_url('admin/user/task/list.php'); ?>">Tüm görevler</a></li>
            </ul>
          </li>
          <!-- /task -->

          <!-- message -->
          <li class="icon-badge dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-envelope-o"></i> <span class="badge"><?php echo $message_unread = get_calc_message(); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-message-list effect-1">
              <li class="message-header"><?php echo $message_unread; ?> okunmamış mesaj</li>
              <?php if($messages = get_messages(array('query'=>_get_query_message('inbox').' LIMIT 5'))): ?>
                <?php foreach($messages as $message): ?>
                <li class="message-list <?php if(!$message->read_it and $message->inbox_u_id == get_active_user('id')): ?>bold<?php endif; ?>">
                  <a href="<?php site_url('admin/user/message/detail.php?id='.$message->id); ?>">
                    <div class="row no-space">
                      <div class="col-md-2">
                        <div class="message-avatar">
                          <img src="<?php echo get_user_info($message->sen_u_id, 'avatar'); ?>" class="img-responsive center-block">
                        </div> <!-- /.message-avatar -->
                      </div> <!-- /.col-md-2 -->
                      <div class="col-md-10">
                        <span class="message-name"><?php echo get_user_info($message->outbox_u_id, 'name'); ?> <?php echo get_user_info($message->outbox_u_id, 'surname'); ?></span>
                        <span class="message-time"><i class="fa fa-clock-o"></i> <?php echo get_time_late($message->date_update); ?> önce</span>
                        <?php
                        // eger cevap mesaji ise cevap mesajini bulalim
                        if($q_select = db()->query("SELECT * FROM ".dbname('messages')." WHERE top_id='".$message->id."' ORDER BY date_update DESC LIMIT 1")) {
                          if($q_select->num_rows) {
                            $sub_message    = $q_select->fetch_object();
                            $message->title = '-'.$sub_message->message;
                          }
                        }
                        ?>
                        <span class="message-title text-muted"><?php echo mb_substr(strip_tags(stripslashes($message->title)),0,40,'utf-8'); ?><?php if(strlen(strip_tags(stripslashes($message->title))) > 40) { echo '...'; } ?></span>
                      </div> <!-- /.col-md-10 -->
                    </div> <!-- /.row -->
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="p-5">
                  <?php echo get_alert('Mesaj kutusu boş.', 'warning', false); ?>
                </div>
              <?php endif; ?>
              <li class="message-footer"><a href="<?php site_url('admin/user/message/list.php'); ?>">Tüm mesajlar</a></li>
            </ul>
          </li>
          <!-- /message -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle profile-avatar" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                <img src="<?php active_user('avatar'); ?>" class="img-repsonsive img-avatar">

              <span class="user-name"><?php active_user('name'); ?> <span class="user-role"><?php echo get_user_role_text(get_active_user('role')); ?></span></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="<?php site_url('admin/user/profile.php'); ?>"><i class="fa fa-meh-o"></i> Profilim</a></li>
              <li><a href="#"><i class="fa fa-cog"></i> Ayarlar</a></li>
              <li><a href="<?php site_url('admin/user/change_password.php'); ?>"><i class="fa fa-key"></i> Şifre Değiştir</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#"><i class="fa fa-power-off"></i> Çıkış</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</header>

<main>

<div class="breadcrumb-header">
  <h3 class="page-title"></h3>

  <ol class="breadcrumb">
    <li><a href="<?php site_url(); ?>"><i class="fa fa-home"></i> Yönetim Paneli</a></li>
  </ol>
</div>

<div class="clearfix"></div>



<?php get_sidebar(); ?>
