<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Helper Css Classes' );
add_page_info( 'nav', array('name'=>'Developer', 'url'=>get_site_url('admin/_developer/') ) );
add_page_info( 'nav', array('name'=>'Helper Css Classes') );
?>
<?php include('_header.php'); ?>

<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Contextual colors</h4></div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td width="50%"><code>.text-muted</code></td>
                        <td width="50%"><span class="text-muted">Example text</span></td>
                    </tr>
                    <tr>
                        <td><code>.text-success</code></td>
                        <td><span class="text-success">Example text</span></td>
                    </tr>
                    <tr>
                        <td><code>.text-warning</code></td>
                        <td><span class="text-warning">Example text</span></td>
                    </tr>
                    <tr>
                        <td><code>.text-danger</code></td>
                        <td><span class="text-danger">Example text</span></td>
                    </tr>
                    <tr>
                        <td><code>.text-primary</code></td>
                        <td><span class="text-primary">Example text</span></td>
                    </tr>
                    <tr>
                        <td><code>.text-info</code></td>
                        <td><span class="text-info">Example text</span></td>
                    </tr>
       
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
    <div class="col-md-6">

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Contextual bakcground colors</h4></div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td width="50%"><code>.bg-muted</code></td>
                        <td width="50%"><div class="bg-muted p-5">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.bg-success</code></td>
                        <td><div class="bg-success p-5">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.bg-warning</code></td>
                        <td><div class="bg-warning p-5">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.bg-danger</code></td>
                        <td><div class="bg-danger p-5">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.bg-primary</code></td>
                        <td><div class="bg-primary p-5">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.bg-info</code></td>
                        <td><div class="bg-info p-5">Example text</div></td>
                    </tr>
       
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->


<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Border</h4></div>
            <div class="panel-body">
                
                <div class="row">
                    <div class="col-md-6">
                        <small>
                            <code>.b-(*int)</code> border
                        </small>
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <small>
                           <code>*int</code> sayısal bir değer ifade eder.
                           <br/>
                           Bu sınıfta, <b>1</b></code>'den başlayarak <b>10</b>'a kadar bir degerlerini yazabilirsiniz.
                        </small>
                    </div> <!-- /.col-md-6 -->
                </div>
                <div class="h-20"></div>

                <table class="table">
                    <tr>
                        <td width="50%"><code>.b-0</code> </td>
                        <td width="50%"><div class="bg-info p-10 b-0" style="border-color:#fb6f6f !important;">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.b-1</code> </td>
                        <td><div class="bg-info p-10 b-1" style="border-color:#fb6f6f !important;">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.b-5</code></td>
                        <td><div class="bg-info p-10 b-5" style="border-color:#fb6f6f !important;">Example text</div></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->



         <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Border radius</h4></div>
            <div class="panel-body">
                
                <div class="row">
                    <div class="col-md-6">
                        <small>
                            <code>.br-(*int)</code> border-radius
                        </small>
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <small>
                           <code>*int</code> sayısal bir değer ifade eder.
                           <br/>
                           Bu sınıfta, <b>1</b></code>'den başlayarak <b>10</b>'a kadar ve <b>50</b> ve <b>100</b> degerlerini yazabilirsiniz.
                        </small>
                    </div> <!-- /.col-md-6 -->
                </div>
                <div class="h-20"></div>

                <table class="table">
                    <tr>
                        <td width="50%"><code>.br-0</code> </td>
                        <td width="50%"><div class="bg-success p-10 br-0">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.br-5</code> </td>
                        <td><div class="bg-success p-10 br-5">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.br-10</code></td>
                        <td><div class="bg-success p-10 br-10">Example text</div></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->



        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Padding</h4></div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-6">
                        <small>
                            <code>.p-(*int)</code> padding,<br/>
                            <code>.pt-(*int)</code> padding-top <br />
                            <code>.pr-(*int)</code> padding-right <br />
                            <code>.pb-(*int)</code> padding-bottom <br />
                            <code>.pl-(*int)</code> padding-left <br />
                        </small>
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <small>
                           <code>*int</code> sayısal bir değer ifade eder.
                           <br/>
                           <b>1</b></code>'den başlayarak <b>20</b>'ye kadar ve <b>50</b> ve <b>100</b> degerlerini yazabilirsiniz.
                        </small>
                    </div> <!-- /.col-md-6 -->
                </div>
                <div class="h-20"></div>

                <table class="table">
                    <tr>
                        <td width="50%"><code>.p-0</code> <span class="text-muted">padding:0px;</span></td>
                        <td width="50%"><div class="bg-warning p-0">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.p-5</code> <span class="text-muted">padding:5px;</span></td>
                        <td><div class="bg-warning p-5">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.p-10</code> <span class="text-muted">padding:10px;</span></td>
                        <td><div class="bg-warning p-10">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.pt-20</code> <span class="text-muted">padding-top:20px;</span></td>
                        <td><div class="bg-warning pt-20">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.pr-20</code> <span class="text-muted">padding-right:20px;</span></td>
                        <td><div class="bg-warning pr-20 text-right">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.pb-20</code> <span class="text-muted">padding-bottom:20px;</span></td>
                        <td><div class="bg-warning pb-20">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.pl-20</code> <span class="text-muted">padding-left:20px;</span></td>
                        <td><div class="bg-warning pl-20">Example text</div></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Margin</h4></div>
            <div class="panel-body">
                
                <div class="row">
                    <div class="col-md-6">
                        <small>
                            <code>.m-(*int)</code> margin,<br/>
                            <code>.mt-(*int)</code> margin-top <br />
                            <code>.mr-(*int)</code> margin-right <br />
                            <code>.mb-(*int)</code> margin-bottom <br />
                            <code>.ml-(*int)</code> margin-left <br />
                        </small>
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <small>
                           <code>*int</code> sayısal bir değer ifade eder.
                           <br/>
                           <b>1</b></code>'den başlayarak <b>20</b>'ye kadar ve <b>50</b> ve <b>100</b> degerlerini yazabilirsiniz.
                        </small>
                    </div> <!-- /.col-md-6 -->
                </div>
                <div class="h-20"></div>

                <table class="table">
                    <tr>
                        <td width="50%"><code>.m-0</code> <span class="text-muted">margin:0px;</span></td>
                        <td width="50%"><div class="bg-primary m-0">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.m-5</code> <span class="text-muted">margin:5px;</span></td>
                        <td><div class="bg-primary m-5">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.m-10</code> <span class="text-muted">margin:10px;</span></td>
                        <td><div class="bg-primary m-10">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.mt-20</code> <span class="text-muted">margin-top:20px;</span></td>
                        <td><div class="bg-primary mt-20">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.mr-20</code> <span class="text-muted">margin-right:20px;</span></td>
                        <td><div class="bg-primary mr-20 text-right">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.mb-20</code> <span class="text-muted">margin-bottom:20px;</span></td>
                        <td><div class="bg-primary mb-20">Example text</div></td>
                    </tr>
                    <tr>
                        <td><code>.ml-20</code> <span class="text-muted">margin-left:20px;</span></td>
                        <td><div class="bg-primary ml-20">Example text</div></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
    <div class="col-md-6">

        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Basic font width</h4></div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td width="50%"><code>.bold</code></td>
                        <td width="50%"><span class="bold">Example text</span></td>
                    </tr>
                    <tr>
                        <td><code>.italic</code></td>
                        <td><span class="italic">Example text</span></td>
                    </tr>
                    <tr>
                        <td><code>.underline</code></td>
                        <td><span class="underline">Example text</span></td>
                    </tr>
                    <tr>
                        <td><code>.text-uppercase</code></td>
                        <td><span class="text-uppercase">Example text</span></td>
                    </tr>
                    <tr>
                        <td><code>.text-lowercase</code></td>
                        <td><span class="text-lowercase">Example text</span></td>
                    </tr>
                    <tr>
                        <td><code>.text-capitalize</code></td>
                        <td><span class="text-capitalize">Example text</span></td>
                    </tr>
       
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->


        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Images</h4></div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td width="50%"><code>.img-32</code></td>
                        <td width="50%"><div><img src="<?php site_url(get_active_user('avatar')); ?>" class="img-32"></div></td>
                    </tr>
                    <tr>
                        <td><code>.img-64</code></td>
                        <td><div><img src="<?php site_url(get_active_user('avatar')); ?>" class="img-64"></div></td>
                    </tr>
                    <tr>
                        <td><code>.img-128</code></td>
                        <td><div><img src="<?php site_url(get_active_user('avatar')); ?>" class="img-128"></div></td>
                    </tr>
                    <tr>
                        <td><code>.img-64</code> <code>.br-10</code></td>
                        <td><div><img src="<?php site_url(get_active_user('avatar')); ?>" class="img-64 br-10"></div></td>
                    </tr>
                    <tr>
                        <td><code>.img-64</code> <code>.br-100</code></td>
                        <td><div><img src="<?php site_url(get_active_user('avatar')); ?>" class="img-64 img-circle"></div></td>
                    </tr>
                    <tr>
                        <td><code>.img-64</code> <code>.img-thumbnail</code></td>
                        <td><div><img src="<?php site_url(get_active_user('avatar')); ?>" class="img-64 img-thumbnail"></div></td>
                    </tr>
                    <tr>
                        <td><code>.img-64</code> <code>.img-thumbnail</code> <code>.img-circle</code></td>
                        <td><div><img src="<?php site_url(get_active_user('avatar')); ?>" class="img-64 img-thumbnail img-circle"></div></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->


        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Height</h4></div>
            <div class="panel-body">
                
                <div class="row">
                    <div class="col-md-6">
                        <small>
                            <code>.h-(*int)</code> height
                        </small>
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <small>
                           <code>*int</code> sayısal bir değer ifade eder.
                           <br/>
                           Bu sınıfta, <b>1</b></code>'den başlayarak <b>20</b>'ye ve <b>10</b>, <b>20</b>, <b>30</b>, <b>40</b>, <b>50</b>, <b>60</b>, <b>70</b>, <b>80</b>, <b>90</b>, <b>100</b> arasında herhangi bir degerlerini yazabilirsiniz.
                        </small>
                    </div> <!-- /.col-md-6 -->
                </div>
                <div class="h-20"></div>

                <table class="table">
                    <tr>
                        <td width="50%"><code>.h-0</code> </td>
                        <td width="50%"><div class="bg-info h-10"></div></td>
                    </tr>
                    <tr>
                        <td><code>.h-30</code> </td>
                        <td><div class="bg-info h-30"></div></td>
                    </tr>
                    <tr>
                        <td><code>.h-50</code> </td>
                        <td><div class="bg-info h-50"></div></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->


        <div class="panel panel-default panel-table">
            <div class="panel-heading"><h4 class="panel-title">Hr Line</h4></div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td width="50%"><code>&lt;hr&gt;</code></td>
                        <td width="50%"><hr /></td>
                    </tr>
                    <tr>
                        <td><code>.hr-line-dashed</code></td>
                        <td><hr class="hr-line-dashed" /></td>
                    </tr>
                    <tr>
                        <td><code>.hr-line-solid</code></td>
                        <td><hr class="hr-line-solid" /></td>
                    </tr>
                    <tr>
                        <td><code>.hr-line-groove</code></td>
                        <td><hr class="hr-line-groove" /></td>
                    </tr>
                </table>
            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->


<?php get_footer(); ?>