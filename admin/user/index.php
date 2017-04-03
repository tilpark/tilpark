<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Kullanıcı' );
add_page_info( 'nav', array('name'=>'Kullanıcı') );
?>



<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="row space-5">
        <?php if(user_access('admin')) : ?>
        	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
        		<div class="box-menu">
        			<a href="<?php site_url('admin/user/add.php'); ?>">
        				<span class="icon-box"><i class="fa fa-plus-square-o"></i></span>
        				<h3>Ekle</h3>
        			</a>
        		</div> <!-- /.box-menu -->
        	</div> <!-- /.col-* -->
        <?php endif; ?>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <div class="box-menu">
                <a href="<?php site_url('admin/user/list.php'); ?>">
                    <span class="icon-box"><i class="fa fa-users"></i></span>
                    <h3>Personeller</h3>
                </a>
            </div> <!-- /.box-menu -->
        </div> <!-- /.col-* -->
    	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/task/'); ?>">
    				<span class="icon-box"><i class="fa fa-tasks"></i></span>
    				<h3>Görev Yöneticisi</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    	<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/message/'); ?>">
    				<span class="icon-box"><i class="fa fa-envelope-o"></i></span>
    				<h3>Mesajlar</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    </div> <!-- /.row -->
  </div> <!--/ .col-* /-->
</div> <!--/ .row /-->

<div class="h-20 visible-xs"></div>


<?php get_footer(); ?>
