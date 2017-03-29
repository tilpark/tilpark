<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Kullanıcı' );
add_page_info( 'nav', array('name'=>'Kullanıcı') );
?>



<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="row space-5">
    	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/list.php/'); ?>">
    				<span class="count"><i class="fa fa-users"></i></span>
    				<h3>Tüm Personeller</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/add.php/'); ?>">
    				<span class="count"><i class="fa fa-user-plus"></i></span>
    				<h3>Yeni Personel Ekle</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/profile.php/'); ?>">
    				<span class="count"><i class="fa fa-user-circle-o"></i></span>
    				<h3>Profilim</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    </div> <!-- /.row -->

    <div class="row space-5">
    	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/task/add.php/'); ?>">
    				<span class="count"><i class="fa fa-plus-square-o"></i></span>
    				<h3>Yeni Görev</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/task/list.php?box=outbox'); ?>">
    				<span class="count">
              <span class="info-icon"><i class="fa fa-mail-reply fa-fw"></i></span>
              <i class="fa fa-tasks"></i>
            </span>
    				<h3>Giden Görev</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
      <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/task/list.php?box=inbox'); ?>">
    				<span class="count">
              <span class="info-icon"><i class="fa fa-mail-forward fa-fw"></i></span>
              <i class="fa fa-tasks"></i>
              <span class="badge" id="box_menu_task_badge" js-onload="get_notification_count({elem: '#box_menu_task_badge', box: 'task'})"><?php echo $message_unread = get_calc_task(); ?></span>
            </span>
    				<h3>Gelen Görev</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    </div><!--/ .row /-->

    <div class="row space-5">
    	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/message/add.php/'); ?>">
    				<span class="count"><i class="fa fa-plus-square-o"></i></span>
    				<h3>Yeni Mesaj</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/message/list.php?box=outbox'); ?>">
    				<span class="count">
              <span class="info-icon"><i class="fa fa-mail-reply fa-fw"></i></span>
              <i class="fa fa-envelope-o fa-fw"></i>
            </span>
    				<h3>Giden Mesaj</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/message/list.php?box=inbox'); ?>">
    				<span class="count">
              <span class="info-icon"><i class="fa fa-mail-forward fa-fw"></i></span>
              <i class="fa fa-envelope-o fa-fw"></i>
              <span class="badge" id="box_menu_message_badge" js-onload="get_notification_count({elem: '#box_menu_message_badge', box: 'message'})"><?php echo $message_unread = get_calc_message(); ?></span>
            </span>
    				<h3>Gelen Mesaj</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    </div> <!-- /.row -->
  </div>
</div>

<div class="h-20 visible-xs"></div>


<?php get_footer(); ?>
