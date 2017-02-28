<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Color Palettes' );
add_page_info( 'nav', array('name'=>'Developer', 'url'=>get_site_url('admin/_developer/') ) );
add_page_info( 'nav', array('name'=>'Color Palettes') );
?>
<?php include('_header.php'); ?>



<style>
.color-boxes {
    width: 500px;
    height: 80px;
    border:0px solid #ccc;
    margin-bottom: 20px;
}
.color-boxes .color-box-1 {
    width: 100px;
    height: 80px;
    display: inline-block;
    border:0px solid #ccc;
    margin: 0px;
    background-color: rgba(255, 255, 255, 0.4);
}
.color-boxes .color-box-2 {
    width: 100px;
    height: 80px;
    display: inline-block;
    border:0px solid #ccc;
    margin: 0px;
    background-color: rgba(255, 255, 255, 0.2);
}
.color-boxes .color-box-3 {
    width: 100px;
    height: 80px;
    display: inline-block;
    border:0px solid #ccc;
    background-color: rgba(0, 0, 0, 0.0);
}
.color-boxes .color-box-4 {
    width: 100px;
    height: 80px;
    display: inline-block;
    border:0px solid #ccc;
    opacity: 0.9;
    background-color: rgba(0, 0, 0, 0.2);
}
.color-boxes .color-box-5 {
    width: 100px;
    height: 80px;
    display: inline-block;
    border:0px solid #ccc;
    opacity: 0.9;
    background-color: rgba(0, 0, 0, 0.4);
}
</style>

<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Color Bootstrap</h3></div>
            <div class="panel-body">
                
                <?php $bg_color = 'ddd'; ?>
                <h4>Default</h4>
                <div class="color-boxes" style="background-color:#<?php echo $bg_color; ?>">
                    <div class="color-box-1"></div><div class="color-box-2"></div><div class="color-box-3"></div><div class="color-box-4"></div><div class="color-box-5"></div>
                </div>

                <?php $bg_color = '4285f4'; ?>
                <h4>Primary</h4>
                <div class="color-boxes" style="background-color:#<?php echo $bg_color; ?>">
                    <div class="color-box-1"></div><div class="color-box-2"></div><div class="color-box-3"></div><div class="color-box-4"></div><div class="color-box-5"></div>
                </div>

                <?php $bg_color = '34a853'; ?>
                <h4>Success</h4>
                <div class="color-boxes" style="background-color:#<?php echo $bg_color; ?>">
                    <div class="color-box-1"></div><div class="color-box-2"></div><div class="color-box-3"></div><div class="color-box-4"></div><div class="color-box-5"></div>
                </div>

                <?php $bg_color = 'fbbc05'; ?>
                <h4>Warning</h4>
                <div class="color-boxes" style="background-color:#<?php echo $bg_color; ?>">
                    <div class="color-box-1"></div><div class="color-box-2"></div><div class="color-box-3"></div><div class="color-box-4"></div><div class="color-box-5"></div>
                </div>

                <?php $bg_color = 'ea4335'; ?>
                <h4>Danger</h4>
                <div class="color-boxes" style="background-color:#<?php echo $bg_color; ?>">
                    <div class="color-box-1"></div><div class="color-box-2"></div><div class="color-box-3"></div><div class="color-box-4"></div><div class="color-box-5"></div>
                </div>

                <?php $bg_color = '42b0db'; ?>
                <h4>Info</h4>
                <div class="color-boxes" style="background-color:#<?php echo $bg_color; ?>">
                    <div class="color-box-1"></div><div class="color-box-2"></div><div class="color-box-3"></div><div class="color-box-4"></div><div class="color-box-5"></div>
                </div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Color other</h3></div>
            <div class="panel-body">
                
                <?php $bg_color = '555299'; ?>
                <h4>Purble</h4>
                <div class="color-boxes" style="background-color:#<?php echo $bg_color; ?>">
                    <div class="color-box-1"></div><div class="color-box-2"></div><div class="color-box-3"></div><div class="color-box-4"></div><div class="color-box-5"></div>
                </div>

                <?php $bg_color = 'ff9bc0'; ?>
                <h4>Pink</h4>
                <div class="color-boxes" style="background-color:#<?php echo $bg_color; ?>">
                    <div class="color-box-1"></div><div class="color-box-2"></div><div class="color-box-3"></div><div class="color-box-4"></div><div class="color-box-5"></div>
                </div>

                <?php $bg_color = '656565'; ?>
                <h4>Dark</h4>
                <div class="color-boxes" style="background-color:#<?php echo $bg_color; ?>">
                    <div class="color-box-1"></div><div class="color-box-2"></div><div class="color-box-3"></div><div class="color-box-4"></div><div class="color-box-5"></div>
                </div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->




<?php get_footer(); ?>