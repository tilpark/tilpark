<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Alerts' );
add_page_info( 'nav', array('name'=>'Developer', 'url'=>get_site_url('admin/_developer/') ) );
add_page_info( 'nav', array('name'=>'Alerts') );
?>
<?php include('_header.php'); ?>



<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Alerts</h3></div>
            <div class="panel-body _get_example">

<div class="alert alert-success">
    <strong>Success!</strong> Indicates a successful or positive action.
</div>

<div class="alert alert-info">
    <strong>Info!</strong> Indicates a neutral informative change or action.
</div>

<div class="alert alert-warning">
    <strong>Warning!</strong> Indicates a warning that might need attention.
</div>

<div class="alert alert-danger">
    <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
    <div class="col-md-6">

    <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Alert with title</h3></div>
            <div class="panel-body _get_example">

<div class="alert alert-success">
    <h4>This is a title</h4>
    <strong>Success!</strong> Indicates a successful or positive action.
</div>

<div class="alert alert-info">
    <h4>This is a title</h4>
    <strong>Info!</strong> Indicates a neutral informative change or action.
</div>

<div class="alert alert-warning">
    <h4>This is a title</h4>
    <strong>Warning!</strong> Indicates a warning that might need attention.
</div>

<div class="alert alert-danger">
    <h4>This is a title</h4>
    <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->





<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Alert with dismissible</h3></div>
            <div class="panel-body _get_example">

<div class="alert alert-success alert-dismissible ">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> Indicates a successful or positive action.
</div>

<div class="alert alert-info alert-dismissible ">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Info!</strong> Indicates a neutral informative change or action.
</div>

<div class="alert alert-warning alert-dismissible ">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Warning!</strong> Indicates a warning that might need attention.
</div>

<div class="alert alert-danger alert-dismissible ">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4>This is a title</h4>
    <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
    <div class="col-md-6">

    <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Alert with button</h3></div>
            <div class="panel-body _get_example">

<div class="alert alert-success">
    <h4>This is a title</h4>
    <p><strong>Success!</strong> Indicates a successful or positive action.</p>
    <p> <button type="button" class="btn btn-success">Take this action</button> <button type="button" class="btn btn-default">Or do this</button> </p>
</div>

<div class="alert alert-info">
    <p><strong>Info!</strong> Indicates a neutral informative change or action.</p>
    <p class="text-right"> <button type="button" class="btn btn-warning">Take this action</button> <button type="button" class="btn btn-default o">Or do this</button> </p>
</div>

<div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <p><strong>Info!</strong> Indicates a neutral informative change or action.</p>
    <p> <button type="button" class="btn btn-danger btn-outline btn-rounded">Take this action</button> </p>
</div>


            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->



<style>
.alert.alert-icon {
    min-height: 40px;
    padding-left: 50px;
    position: relative;
    overflow: hidden;
}
.alert.alert-icon .alert-icon {
    position: absolute;
    display: table;
    height: 100%;
    left: 5px;
    top: 5px;
    width: 44px;
    text-align: center;
    margin: auto;
    top: 0; 
    bottom: 0; 
}
.alert.alert-icon .alert-icon i.fa {
    font-size: 200%;
    opacity: 0.7;
}
</style>

<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default panel-heading-0">
            <div class="panel-heading"><h3 class="panel-title">Alert with icon</h3></div>
            <div class="panel-body _get_example">

<div class="alert alert-success alert-icon">
    <div class="alert-icon"><i class="fa fa-check"></i></div>
    <strong>Success!</strong> Indicates a successful or positive action.
</div>

<div class="alert alert-info alert-icon">
    <div class="alert-icon"><i class="fa fa-file-o"></i></div>
    <h4>This is a title</h4>
    <strong>Info!</strong> Indicates a neutral informative change or action.
</div>

<div class="alert alert-warning alert-icon">
    <div class="alert-icon"><i class="fa fa-edit"></i></div>
    <h4>This is a title</h4>
    <strong>Info!</strong> Indicates a neutral informative change or action.
</div>

<div class="alert alert-danger alert-icon">
    <div class="alert-icon"><i class="fa fa-trash-o"></i></div>
    <h4>This is a title</h4>
    <strong>Info!</strong> Indicates a neutral informative change or action.
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
    <div class="col-md-6">

    <div class="panel panel-default panel-heading-0">
            <div class="panel-heading"><h3 class="panel-title">Alert with title icon</h3></div>
            <div class="panel-body _get_example">

<div class="alert alert-success">
    <h4><i class="fa fa-check fa-fw"></i> This is a title</h4>
    <strong>Success!</strong> Indicates a successful or positive action.
</div>

<div class="alert alert-info">
    <h4><i class="fa fa-rocket fa-fw"></i> This is a title</h4>
    <strong>Info!</strong> Indicates a neutral informative change or action.
</div>

<div class="alert alert-warning">
    <h4><i class="fa fa-bath fa-fw"></i> This is a title</h4>
    <strong>Warning!</strong> Indicates a warning that might need attention.
</div>

<div class="alert alert-danger">
    <h4><i class="fa fa-battery-1 fa-fw"></i> This is a title</h4>
    <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->



<?php get_footer(); ?>