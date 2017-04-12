<?php include('../../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Görev Yöneticisi' );
add_page_info( 'nav', array('name'=>'Görev Yöneticisi') );
?>

<div class="row">
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
    <div class="row space-5">
    	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/task/add.php/'); ?>">
    				<span class="icon-box"><i class="fa fa-plus-square-o"></i></span>
    				<h3>Yeni Görev</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/task/list.php?box=outbox'); ?>">
    				<span class="icon-box">
              <span class="info-icon"><i class="fa fa-mail-reply fa-fw"></i></span>
              <i class="fa fa-tasks"></i>
            </span>
    				<h3>Giden Görev</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2">
    		<div class="box-menu">
    			<a href="<?php site_url('admin/user/task/list.php?box=inbox'); ?>">
    				<span class="icon-box">
              <span class="info-icon"><i class="fa fa-mail-forward fa-fw"></i></span>
              <i class="fa fa-tasks"></i>
              <span class="badge" id="box_menu_task_badge" js-onload="get_notification_count({elem: '#box_menu_task_badge', box: 'task'})"><?php echo $message_unread = get_calc_task(); ?></span>
            </span>
    				<h3>Gelen Görev</h3>
    			</a>
    		</div> <!-- /.box-menu -->
    	</div> <!-- /.col-* -->
    </div><!--/ .row /-->
  </div> <!--/ .col-* /-->


  <div class="col-md-8">
    <?php
      $tasks = get_tasks(array('rec_u_id' => get_active_user('id'), 'type_status' => '0'));

      if ( is_array($tasks) ) {
        $render_array = array();
        
        foreach ($tasks as $key => $value) {
          $row = new stdclass;
          $row->title = $value->title;
          $row->start = $value->date_start;
          $row->end   = $value->date_end;
          $row->url   = get_site_url('admin/user/task/detail.php?id='. $tasks[$key]->id);

          array_push($render_array, $row);
        }

        $json = json_encode_utf8($render_array);
      }
    ?>

    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function() {
        calendar('#calendar', '<?php if ( !empty($json) ) { echo $json; } ?>');
      });
    </script>

    <div id="calendar"></div>
  </div>
</div> <!--/ .row /-->

<?php get_footer(); ?>
