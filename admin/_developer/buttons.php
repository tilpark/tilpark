<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Buttons' );
add_page_info( 'nav', array('name'=>'Developer', 'url'=>get_site_url('admin/_developer/') ) );
add_page_info( 'nav', array('name'=>'Buttons') );
?>
<?php include('_header.php'); ?>



<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default ">
			<div class="panel-heading"><h3 class="panel-title">Default buttons</h3></div>
			<div class="panel-body _get_example">

				
				<!--del-->
				<p><code>&lt;a&gt;</code>, <code>&lt;input&gt;</code>, <code>&lt;button&gt;</code> elementlerinden herhangi birinde kullanabilirsiniz.</p>
				<!--/del-->
				

				<a href="#" class="btn btn-default">default</a>
				<a href="#" class="btn btn-primary">primary</a>
				<a href="#" class="btn btn-success">success</a>
				<a href="#" class="btn btn-warning">warning</a>
				<a href="#" class="btn btn-danger">danger</a>
				<a href="#" class="btn btn-info">info</a>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel-default -->
	</div> <!-- /.col-md-6 -->

	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Rounded buttons</h3></div>
			<div class="panel-body _get_example">

				<!--del-->
				<p><code>.btn-rounded</code> sınıfını ekleyerek bu görünüme ulaşabilirsiniz.</p>
				<!--/del-->

				<a href="#" class="btn btn-default btn-rounded">default</a>
				<a href="#" class="btn btn-primary btn-rounded">primary</a>
				<a href="#" class="btn btn-success btn-rounded">success</a>
				<a href="#" class="btn btn-warning btn-rounded">warning</a>
				<a href="#" class="btn btn-danger btn-rounded">danger</a>
				<a href="#" class="btn btn-info btn-rounded">info</a>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel-default -->
	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->


<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Outline buttons</h3></div>
			<div class="panel-body _get_example">

				<!--del-->
				<p><code>.btn-outline</code> sınıfını ekleyerek bu görünüme ulaşabilirsiniz.</p>
				<!--/del-->

				<a href="#" class="btn btn-default btn-outline">default</a>
				<a href="#" class="btn btn-primary btn-outline">primary</a>
				<a href="#" class="btn btn-success btn-outline">success</a>
				<a href="#" class="btn btn-warning btn-outline">warning</a>
				<a href="#" class="btn btn-danger btn-outline">danger</a>
				<a href="#" class="btn btn-info btn-outline">info</a>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel-default -->
	</div> <!-- /.col-md-6 -->

	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Outline & rounded buttons</h3></div>
			<div class="panel-body _get_example">
				
				<!--del-->
				<p><code>.btn-outline</code> ile birlikte <code>.btn-rounded</code> sınıfını ekleyerek bu görünüme ulaşabilirsiniz.</p>
				<!--/del-->

				<a href="#" class="btn btn-default btn-rounded btn-outline">default</a>
				<a href="#" class="btn btn-primary btn-rounded btn-outline">primary</a>
				<a href="#" class="btn btn-success btn-rounded btn-outline">success</a>
				<a href="#" class="btn btn-warning btn-rounded btn-outline">warning</a>
				<a href="#" class="btn btn-danger btn-rounded btn-outline">danger</a>
				<a href="#" class="btn btn-info btn-rounded btn-outline">info</a>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel-default -->
	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->


<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Flat buttons</h3></div>
			<div class="panel-body _get_example">
				
				<!--del-->
				<p><code>.btn-flat</code> sınıfını ekleyerek bu görünüme ulaşabilirsiniz.</p>
				<!--/del-->

				<a href="#" class="btn btn-default btn-flat">default</a>
				<a href="#" class="btn btn-primary btn-flat">primary</a>
				<a href="#" class="btn btn-success btn-flat">success</a>
				<a href="#" class="btn btn-warning btn-flat">warning</a>
				<a href="#" class="btn btn-danger btn-flat">danger</a>
				<a href="#" class="btn btn-info btn-flat">info</a>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel-default -->

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Button width icon</h3></div>
			<div class="panel-body">
				
				<!--del--><p><code>&lt;i class="fa"&gt;</code> nesnesini ekleyerek istediğiniz icon görünümlerini ekleyebilrisiniz. Tüm icon listesini görmek için "<a href="#" class="bold">buraya</a>" tıklayınız.</p><!--/del-->

				<div class="_get_example _get_example_div">
					<a href="#" class="btn btn-default"><i class="fa fa-save fa-btn"></i> default</a>
					<a href="#" class="btn btn-primary"><i class="fa fa-motorcycle fa-btn"></i> primary</a>
					<a href="#" class="btn btn-success"><i class="fa fa-check-square-o fa-btn"></i> success</a>
					<a href="#" class="btn btn-warning"><i class="fa fa-exclamation-triangle fa-btn"></i> warning</a>
					<a href="#" class="btn btn-danger"><i class="fa fa-trash-o fa-btn"></i> danger</a>
					<a href="#" class="btn btn-info"><i class="fa fa-rocket fa-btn"></i> info</a>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p>Yukarıdaki örnek ile birlikte <code>.btn-icon</code> sınıfını ekleyek bu görünüme ulaşabilirsiniz.</p><!--/del-->

				<div class="_get_example _get_example_div">
					<a href="#" class="btn btn-default btn-icon"><i class="fa fa-save"></i> default</a>
					<a href="#" class="btn btn-primary btn-icon"><i class="fa fa-motorcycle"></i> primary</a>
					<a href="#" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> success</a>
					<a href="#" class="btn btn-warning btn-icon"><i class="fa fa-exclamation-triangle"></i> warning</a>
					<a href="#" class="btn btn-danger btn-icon"><i class="fa fa-trash-o"></i> danger</a>
					<a href="#" class="btn btn-info btn-icon"><i class="fa fa-rocket"></i> info</a>
				</div>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel-default -->
	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->



<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Button block</h3></div>
			<div class="panel-body _get_example">

				<!--del-->
				<p><code>.btn-block</code> sınıfını ekleyerek bu görünüme ulaşabilirsiniz.</p>
				<!--/del-->

				<div class="well">
					<a href="#" class="btn btn-success btn-block">success</a>
					<a href="#" class="btn btn-primary btn-block">primary</a>
				</div> <!-- /.well -->

				<div class="row">
					<div class="col-md-6">
						<div class="well">
							<a href="#" class="btn btn-default btn-block">default</a>
							<a href="#" class="btn btn-primary btn-block">primary</a>
							<a href="#" class="btn btn-success btn-block">success</a>
							<a href="#" class="btn btn-warning btn-block">warning</a>
							<a href="#" class="btn btn-danger btn-block">danger</a>
							<a href="#" class="btn btn-info btn-block">info</a>
						</div> <!-- /.well -->
					</div> <!-- /.col-md-6 -->
					<div class="col-md-6">
						<div class="well">
							<a href="#" class="btn btn-default btn-outline btn-rounded btn-block">default</a>
							<a href="#" class="btn btn-primary btn-outline btn-rounded btn-block">primary</a>
							<a href="#" class="btn btn-success btn-outline btn-block">success</a>
							<a href="#" class="btn btn-warning btn-outline btn-block">warning</a>
							<a href="#" class="btn btn-danger btn-rounded btn-block">danger</a>
							<a href="#" class="btn btn-info btn-rounded btn-block">info</a>
						</div> <!-- /.well -->
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->
				
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel-default -->
	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Button sizes</h3></div>
			<div class="panel-body">

				<!--del--><p><code>.btn-xs</code> sınıfını ekleyerek bu görünüme ulaşabilirsiniz.</p><!--/del-->
				<div class="_get_example _get_example_div">
					<a href="#" class="btn btn-default btn-xs">default</a>
					<a href="#" class="btn btn-primary btn-rounded btn-xs">primary</a>
					<a href="#" class="btn btn-success btn-outline btn-xs">success</a>
					<a href="#" class="btn btn-warning btn-outline btn-rounded btn-xs">warning</a>
					<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> danger</a>
					<a href="#" class="btn btn-primary btn-icon btn-xs"><i class="fa fa-rocket"></i> primary</a>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p><code>.btn-sm</code> sınıfını ekleyerek bu görünüme ulaşabilirsiniz.</p><!--/del-->

				<div class="_get_example _get_example_div">
					<a href="#" class="btn btn-default btn-sm">default</a>
					<a href="#" class="btn btn-primary btn-rounded btn-sm">primary</a>
					<a href="#" class="btn btn-success btn-outline btn-sm">success</a>
					<a href="#" class="btn btn-warning btn-outline btn-rounded btn-sm">warning</a>
					<a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> danger</a>
					<a href="#" class="btn btn-primary btn-icon btn-sm"><i class="fa fa-rocket"></i> primary</a>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p>boyut sınıfı eklemez iseniz bu görünmü elde edersiniz.</p><!--/del-->

				<div class="_get_example _get_example_div">
					<a href="#" class="btn btn-default">default</a>
					<a href="#" class="btn btn-primary btn-rounded">primary</a>
					<a href="#" class="btn btn-success btn-outline">success</a>
					<a href="#" class="btn btn-warning btn-outline btn-rounded">warning</a>
					<a href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i> danger</a>
					<a href="#" class="btn btn-primary btn-icon"><i class="fa fa-rocket"></i> primary</a>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p><code>.btn-lg</code> sınıfını ekleyerek bu görünüme ulaşabilirsiniz.</p><!--/del-->

				<div class="_get_example _get_example_div">
					<a href="#" class="btn btn-default btn-lg">default</a>
					<a href="#" class="btn btn-primary btn-rounded btn-lg">primary</a>
					<a href="#" class="btn btn-success btn-outline btn-lg">success</a>
					<a href="#" class="btn btn-warning btn-outline btn-rounded btn-lg">warning</a>
					<a href="#" class="btn btn-danger btn-lg"><i class="fa fa-trash-o"></i> danger</a>
					<a href="#" class="btn btn-primary btn-icon btn-lg"><i class="fa fa-rocket"></i> primary</a>
				</div>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel panel-default -->
	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->




<div class="row">
	<div class="col-md-6">

		<div class="panel panel-default panel-heading-0">
			<div class="panel-heading"><h3 class="panel-title">Button groups</h3></div>
			<div class="panel-body">

				<!--del--><p><code>.btn-group</code> örnekleri ile gruplandırılmış butonlar elde edebilirsiniz.</p><!--/del-->
				<div class="_get_example _get_example_div">
					<div class="btn-group" role="group" aria-label="...">
					 	<button type="button" class="btn btn-default">Left</button>
					  	<button type="button" class="btn btn-default">Middle</button>
					  	<button type="button" class="btn btn-default">Right</button>
					</div>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p>Ayrıca bu gruptaki butonların, renk ve stillerini kullanabilirsiniz.</p><!--/del-->
				<div class="_get_example _get_example_div">
					<div class="btn-group" role="group" aria-label="...">
					 	<button type="button" class="btn btn-danger">Danger</button>
					  	<button type="button" class="btn btn-warning">Warning</button>
					  	<button type="button" class="btn btn-success">Success</button>
					  	<button type="button" class="btn btn-primary">Primary</button>
					  	<button type="button" class="btn btn-info">Info</button>
					</div>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p><code>.btn-icon</code> ve <code>.btn-outline</code> gibi sınıflarıda kullanabilirsiniz.</p><!--/del-->
				<div class="_get_example _get_example_div">
					<div class="btn-group" role="group" aria-label="...">
					 	<button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Danger</button>
					  	<button type="button" class="btn btn-warning btn-icon"><i class="fa fa-warning"></i> Warning</button>
					  	<button type="button" class="btn btn-success btn-outline">Success</button>
					  	<button type="button" class="btn btn-primary btn-outline"><i class="fa fa-rocket"></i> Primary</button>
					  	<button type="button" class="btn btn-info">Info</button>
					</div>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p><code>.btn-group-lg</code> sınıfı ile büyük bir görünüm elde edin.</p><!--/del-->
				<div class="_get_example _get_example_div">
					<div class="btn-group btn-group-lg" role="group" aria-label="...">
					 	<button type="button" class="btn btn-default">Left</button>
					  	<button type="button" class="btn btn-default">Middle</button>
					  	<button type="button" class="btn btn-default">Right</button>
					</div>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p>Standart görünüm elde edin. Boyut sınıfı eklemenize gerek yok.</p><!--/del-->
				<div class="_get_example _get_example_div">
					<div class="btn-group" role="group" aria-label="...">
					 	<button type="button" class="btn btn-default">Left</button>
					  	<button type="button" class="btn btn-default">Middle</button>
					  	<button type="button" class="btn btn-default">Right</button>
					</div>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p><code>.btn-group-sm</code> sınıfı ile küçük bir görünüm elde edin.</p><!--/del-->
				<div class="_get_example _get_example_div">
					<div class="btn-group btn-group-sm" role="group" aria-label="...">
					 	<button type="button" class="btn btn-default">Left</button>
					  	<button type="button" class="btn btn-default">Middle</button>
					  	<button type="button" class="btn btn-default">Right</button>
					</div>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p><code>.btn-group-xs</code> sınıfı ile çok küçük bir görünüm elde edin.</p><!--/del-->
				<div class="_get_example _get_example_div">
					<div class="btn-group btn-group-xs" role="group" aria-label="...">
					 	<button type="button" class="btn btn-default">Left</button>
					  	<button type="button" class="btn btn-default">Middle</button>
					  	<button type="button" class="btn btn-default">Right</button>
					</div>
				</div>

				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p>Grubun içerisine bir menü ekleyin.</p><!--/del-->
				<div class="_get_example _get_example_div">
					<div class="btn-group" role="group" aria-label="...">
					  <button type="button" class="btn btn-default">1</button>
					  <button type="button" class="btn btn-default">2</button>

					  <div class="btn-group" role="group">
					    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					      Dropdown
					      <span class="caret"></span>
					    </button>
					    <ul class="dropdown-menu">
					      <li><a href="#">Dropdown link</a></li>
					      <li><a href="#">Dropdown link</a></li>
					    </ul>
					  </div>
					</div>
				</div>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">

		<div class="panel panel-default panel-heading-o">
			<div class="panel-heading"><h3 class="panel-title">Button dropdowns</h3></div>
			<div class="panel-body">

				<!--del--><p>Grubun içerisine bir menü ekleyin.</p><!--/del-->
				<div class="_get_example _get_example_div">
<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Action</a></li>
    <li><a href="#">Another action</a></li>
    <li><a href="#">Something else here</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">Separated link</a></li>
  </ul>
</div>
					
					<!--del-->
					<div class="btn-group">
					  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
					<!--/del-->

					<!--del-->
					<div class="btn-group">
					  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-save"></i> Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
					<!--/del-->

					<!--del-->
					<div class="btn-group">
					  <button type="button" class="btn btn-warning btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
					<!--/del-->

					<!--del-->
					<div class="btn-group">
					  <button type="button" class="btn btn-danger btn-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					   <i class="fa fa-trash-o"></i> Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
					<!--/del-->

					<!--del-->
					<div class="btn-group">
					  <button type="button" class="btn btn-info btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
					<!--/del-->


				</div> <!-- /._get_example -->


				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p>Aşağı doğru açılan menülerde sadece ok işaretine tıklanırsa menü açılsın.</p><!--/del-->
				<div class="_get_example _get_example_div">
					
<div class="btn-group">
  <button type="button" class="btn btn-default">Action</button>
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Action</a></li>
    <li><a href="#">Another action</a></li>
    <li><a href="#">Something else here</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">Separated link</a></li>
  </ul>
</div>

					<!--del-->
					<div class="btn-group">
					  <button type="button" class="btn btn-primary">Action</button>
					  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
					<!--/del-->

					<!--del-->
					<div class="btn-group">
					  <button type="button" class="btn btn-success"><i class="fa fa-save"></i> Action</button>
					  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
					<!--/del-->

					<!--del-->
					<div class="btn-group">
					  <button type="button" class="btn btn-warning btn-outline">Action</button>
					  <button type="button" class="btn btn-warning btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
					<!--/del-->

					<!--del-->
					<div class="btn-group">
					  <button type="button" class="btn btn-danger btn-icon"><i class="fa fa-trash-o"></i> Action</button>
					  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
					<!--/del-->

					<!--del-->
					<div class="btn-group">
					  <button type="button" class="btn btn-info btn-rounded">Action</button>
					  <button type="button" class="btn btn-info btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
					<!--/del-->

				</div> <!-- /._get_example -->




				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p>Üstelik buton ve menüleri 4 farklı boyutta gösterebilirsiniz.</p><!--/del-->
				<div class="_get_example _get_example_div">
					
<!-- Large button group -->
<div class="btn-group">
  <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Large button <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Action</a></li>
    <li><a href="#">Another action</a></li>
    <li><a href="#">Something else here</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">Separated link</a></li>
  </ul>
</div>
<!--del--><div class="h-10"></div><!--/del-->
<!-- Default button group -->
<div class="btn-group">
  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Default button <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Action</a></li>
    <li><a href="#">Another action</a></li>
    <li><a href="#">Something else here</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">Separated link</a></li>
  </ul>
</div>
<!--del--><div class="h-10"></div><!--/del-->
<!-- Small button group -->
<div class="btn-group">
  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Small button <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Action</a></li>
    <li><a href="#">Another action</a></li>
    <li><a href="#">Something else here</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">Separated link</a></li>
  </ul>
</div>
<!--del--><div class="h-10"></div><!--/del-->
<!-- Extra small button group -->
<div class="btn-group">
  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Extra small button <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Action</a></li>
    <li><a href="#">Another action</a></li>
    <li><a href="#">Something else here</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">Separated link</a></li>
  </ul>
</div>

				</div> <!-- /._get_example -->


				<!--del--><div class="h-20"></div><!--/del-->
				<!--del--><p>Menülerin yukarı doğru açılabildiğini biliyor musunuz?</p><!--/del-->
				<div class="_get_example _get_example_div">
					
<div class="btn-group dropup">
  <button type="button" class="btn btn-default">Dropup</button>
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Action</a></li>
    <li><a href="#">Another action</a></li>
    <li><a href="#">Something else here</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">Separated link</a></li>
  </ul>
</div>

<!--del--><div class="h-10"></div><!--/del-->


				</div> <!-- /._get_example -->

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->


<?php get_footer(); ?>