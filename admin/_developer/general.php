<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'General Elements' );
add_page_info( 'nav', array('name'=>'Developer', 'url'=>get_site_url('admin/_developer/') ) );
add_page_info( 'nav', array('name'=>'General Elements') );
?>
<?php include('_header.php'); ?>



<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Labels</h4></div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td width="50%"><code>.label-default</code></td>
                        <td width="50%"><span class="label label-default">Default</span></td>
                    </tr>
                    <tr>
                        <td><code>.label-primary</code></td>
                        <td><span class="label label-primary">Primary</span></td>
                    </tr>
                    <tr>
                        <td><code>.label-success</code></td>
                        <td><span class="label label-success">Success</span></td>
                    </tr>
                    <tr>
                        <td><code>.label-warning</code></td>
                        <td><span class="label label-warning">Warning</span></td>
                    </tr>
                    <tr>
                        <td><code>.label-danger</code></td>
                        <td><span class="label label-danger">Danger</span></td>
                    </tr>
                    <tr>
                        <td><code>.label-info</code></td>
                        <td><span class="label label-info">Info</span></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
    <div class="col-md-6">

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Badges</h4></div>
            <div class="panel-body">
                <table class="table">
                   <tr>
                        <td width="50%"><code>.badge</code></td>
                        <td width="50%"><span class="badge">10</span></td>
                    </tr>
                    <tr>
                        <td><code>.badge</code> <code>.bg-primary</code></td>
                        <td><span class="badge bg-primary">5</span></td>
                    </tr>
                    <tr>
                        <td><code>.badge</code> <code>.bg-success</code></td>
                        <td><span class="badge bg-success">19</span></td>
                    </tr>
                    <tr>
                        <td><code>.badge</code> <code>.bg-warning</code></td>
                        <td><span class="badge bg-warning">5</span></td>
                    </tr>
                    <tr>
                        <td><code>.badge</code> <code>.bg-danger</code></td>
                        <td><span class="badge bg-danger">999</span></td>
                    </tr>
                    <tr>
                        <td><code>.badge</code> <code>.bg-info</code></td>
                        <td><span class="badge bg-info">6</span></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->




<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Tooltips</h4></div>
            <div class="panel-body">
                <table class="table">
                   <tr>
                        <td width="50%"><code>data-toggle="tooltip" title="Tooltip title"</code></td>
                        <td width="50%"><button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Tooltip title">Tooltip</button></td>
                    </tr>
                    <tr>
                        <td><code>data-placement="left"</code></td>
                        <td><button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="left" title="Tooltip on left"><i class="fa fa-arrow-left"></i> Tooltip on left</button></td>
                    </tr>
                    <tr>
                        <td><code>data-placement="right"</code></td>
                        <td><button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="right" title="Tooltip on right"><i class="fa fa-arrow-right"></i> Tooltip on right</button></td>
                    </tr>
                    <tr>
                        <td><code>data-placement="top"</code></td>
                        <td><button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class="fa fa-arrow-up"></i> Tooltip on top</button></td>
                    </tr>
                    <tr>
                        <td><code>data-placement="bottom"</code></td>
                        <td><button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"><i class="fa fa-arrow-down"></i> Tooltip on bottom</button></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
    <div class="col-md-6">

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Tooltips</h4></div>
            <div class="panel-body">
                <table class="table">
                   <tr>
                        <td width="50%"><code>data-toggle="popover"</code></td>
                        <td width="50%"><button type="button" class="btn btn-default btn-xs" data-container="body" data-toggle="popover" data-trigger="focus" title="This is a title" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">Popover</button></td>
                    </tr>
                    <tr>
                        <td><code>data-placement="left"</code></td>
                        <td><button type="button" class="btn btn-default btn-xs" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="fa fa-arrow-left"></i> Popover on left</button></td>
                    </tr>
                    <tr>
                        <td><code>data-placement="right"</code></td>
                        <td><button type="button" class="btn btn-default btn-xs" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="right" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="fa fa-arrow-right"></i> Popover on right</button></td>
                    </tr>
                    <tr>
                        <td><code>data-placement="top"</code></td>
                        <td><button type="button" class="btn btn-default btn-xs" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="fa fa-arrow-up"></i> Popover on top</button></td>
                    </tr>
                    <tr>
                        <td><code>data-placement="bottom"</code></td>
                        <td><button type="button" class="btn btn-default btn-xs" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="fa fa-arrow-down"></i> Popover on bottom</button></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->




<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Progress bars</h4></div>
            <div class="panel-body _get_example">
               
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
    <span class="sr-only">60% Complete</span>
  </div>
</div>

<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
    <span class="sr-only">40% Complete (success)</span>
  </div>
</div>
<div class="progress">
  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
    <span class="sr-only">20% Complete</span>
  </div>
</div>
<div class="progress">
  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
    <span class="sr-only">60% Complete (warning)</span>
  </div>
</div>
<div class="progress">
  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
    <span class="sr-only">80% Complete (danger)</span>
  </div>
</div>

<h4>Striped</h4>
<!-- striped -->
<div class="progress">
  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
    <span class="sr-only">40% Complete (success)</span>
  </div>
</div>
<div class="progress">
  <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
    <span class="sr-only">20% Complete</span>
  </div>
</div>

<h4>Animated</h4>
<!-- striped -->
<div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
    <span class="sr-only">45% Complete</span>
  </div>
</div>


            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
    <div class="col-md-6">

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Paginations</h4></div>
            <div class="panel-body">
                
            <div class="text-center">
                <ul class="pagination pagination-lg">
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-chevron-left"></i></a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);">1</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">2</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">3</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">4</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">5</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-chevron-right"></i></a>
                    </li>
                </ul>
                &nbsp; &nbsp;
                <ul class="pagination pagination-alt pagination-lg">
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-angle-left"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">1</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">2</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">3</a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);">4</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">5</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </div>
            <div class="text-center">
                <ul class="pagination">
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-arrow-left"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">1</a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);">2</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">3</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">4</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">5</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-arrow-right"></i></a>
                    </li>
                </ul>
                &nbsp; &nbsp;
                <ul class="pagination pagination-alt">
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-angle-left"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">1</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">2</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">3</a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);">4</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">5</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </div>
            <div class="text-center">
                <ul class="pagination pagination-sm">
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-angle-left"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">1</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">2</a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);">3</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">4</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">5</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
                &nbsp; &nbsp;
                <ul class="pagination pagination-sm pagination-alt">
                    <li>
                        <a href="javascript:void(0);">«</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">1</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">2</a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);">3</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">4</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">5</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">»</a>
                    </li>
                </ul>
            </div>
            <div style="width:180px; margin:0 auto">
                <ul class="pager">
                    <li class="previous disabled">
                        <a href="javascript:void(0);">Back</a>
                    </li>
                    <li class="next">
                        <a href="javascript:void(0);">Next</a>
                    </li>
                </ul>
            </div>

     
                
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->


<?php get_footer(); ?>