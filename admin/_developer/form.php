<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Form Elements' );
add_page_info( 'nav', array('name'=>'Developer', 'url'=>get_site_url('admin/_developer/') ) );
add_page_info( 'nav', array('name'=>'Form Elements') );
?>


<div class="row">
	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Form Elements</h3></div>
			<div class="panel-body">
				
				<p><code>.form-control</code> sınıfı ile aşağıdaki görünümleri elde edebilirsiniz.</p>

				<div class="form-group">
					<label for="text1">User name</label>
					<input type="text" name="text1" id="text1" class="form-control">
				</div> <!-- /.form-group -->

				<div class="form-group">
					<label for="text2">Password</label>
					<input type="password" name="text2" id="text2" class="form-control">
				</div> <!-- /.form-group -->

				<div class="form-group">
					<label for="select1">Selectbox</label>
					<select name="select1" id="select1" class="form-control">
						<option value="val1">item 1</option>
						<option value="val2">item 2</option>
						<option value="val3">item 3</option>
						<option value="val4">item 4</option>
					</select>
				</div> <!-- /.form-group -->

				<div class="checkbox">
				  <label>
				    <input type="checkbox" value="">
				    Option one is this and that&mdash;be sure to include why it's great
				  </label>
				</div>
				<div class="checkbox disabled">
				  <label>
				    <input type="checkbox" value="" disabled>
				    Option two is disabled
				  </label>
				</div>

				<div class="radio">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
				    Option one is this and that&mdash;be sure to include why it's great
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
				    Option two can be something else and selecting it will deselect option one
				  </label>
				</div>
				<div class="radio disabled">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled>
				    Option three is disabled
				  </label>
				</div>

				<div class="form-group">
					<label for="textarea1">Textarea</label>
					<textarea class="form-control" id="textarea1"></textarea>
				</div> <!-- /.form-group -->

				<div class="form-group">
					<label for="text1">Disabled input</label>
					<input type="text" name="text1" id="text1" class="form-control" disabled placeholder="disabled">
				</div> <!-- /.form-group -->

				<div class="form-group">
					<label for="text1">Readonly input</label>
					<input type="text" name="text1" id="text1" class="form-control" readonly placeholder="readonly">
				</div> <!-- /.form-group -->

				<div class="form-group has-success">
				  <label class="control-label" for="inputSuccess1">Input with success</label>
				  <input type="text" class="form-control" id="inputSuccess1" aria-describedby="helpBlock2">
				  <span id="helpBlock2" class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
				</div>
				<div class="form-group has-warning">
				  <label class="control-label" for="inputWarning1">Input with warning</label>
				  <input type="text" class="form-control" id="inputWarning1">
				</div>
				<div class="form-group has-error">
				  <label class="control-label" for="inputError1">Input with error</label>
				  <input type="text" class="form-control" id="inputError1">
				</div>
				<div class="has-success">
				  <div class="checkbox">
				    <label>
				      <input type="checkbox" id="checkboxSuccess" value="option1">
				      Checkbox with success
				    </label>
				  </div>
				</div>
				<div class="has-warning">
				  <div class="checkbox">
				    <label>
				      <input type="checkbox" id="checkboxWarning" value="option1">
				      Checkbox with warning
				    </label>
				  </div>
				</div>
				<div class="has-error">
				  <div class="checkbox">
				    <label>
				      <input type="checkbox" id="checkboxError" value="option1">
				      Checkbox with error
				    </label>
				  </div>
				</div>


			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Form size</h3></div>
			<div class="panel-body">

				<div class="form-group">
					<input type="text" class="input-sm form-control" placeholder=".input-xs">
				</div> <!-- /.form-group -->

				<div class="form-group">
					<input type="text" class="form-control" placeholder="Default">
				</div> <!-- /.form-group -->

				<div class="form-group">
					<input type="text" class="input-lg form-control" placeholder=".input-xs">
				</div> <!-- /.form-group -->

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->


		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Form icon</h3></div>
			<div class="panel-body">

				<div class="form-group has-success has-feedback">
				  <label class="control-label" for="inputSuccess2">Input with success</label>
				  <input type="text" class="form-control" id="inputSuccess2" aria-describedby="inputSuccess2Status">
				  <span class="fa fa-check form-control-feedback" aria-hidden="true"></span>
				  <span id="inputSuccess2Status" class="sr-only">(success)</span>
				</div>
				<div class="form-group has-warning has-feedback">
				  <label class="control-label" for="inputWarning2">Input with warning</label>
				  <input type="text" class="form-control" id="inputWarning2" aria-describedby="inputWarning2Status">
				  <span class="fa fa-warning form-control-feedback" aria-hidden="true"></span>
				  <span id="inputWarning2Status" class="sr-only">(warning)</span>
				</div>
				<div class="form-group has-error has-feedback">
				  <label class="control-label" for="inputError2">Input with error</label>
				  <input type="text" class="form-control" id="inputError2" aria-describedby="inputError2Status">
				  <span class="fa fa-trash-o form-control-feedback" aria-hidden="true"></span>
				  <span id="inputError2Status" class="sr-only">(error)</span>
				</div>
				<div class="form-group has-success has-feedback">
				  <label class="control-label" for="inputGroupSuccess1">Input group with success</label>
				  <div class="input-group">
				    <span class="input-group-addon">@</span>
				    <input type="text" class="form-control" id="inputGroupSuccess1" aria-describedby="inputGroupSuccess1Status">
				  </div>
				  <span class="fa fa-check form-control-feedback" aria-hidden="true"></span>
				  <span id="inputGroupSuccess1Status" class="sr-only">(success)</span>
				</div>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->




		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Form inline & horizontal</h3></div>
			<div class="panel-body">

				<h4 class="content-title title-line">Inline</h4>
				<form class="form-inline">
				  <div class="form-group">
				    <label for="exampleInputName2">Name</label>
				    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail2">Email</label>
				    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
				  </div>
				  <button type="submit" class="btn btn-default">Send invitation</button>
				</form>

				<div class="h-20"></div>

				<form class="form-inline">
				  <div class="form-group">
				    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
				    <div class="input-group">
				      <div class="input-group-addon">$</div>
				      <input type="text" class="form-control" id="exampleInputAmount" placeholder="Amount">
				      <div class="input-group-addon">.00</div>
				    </div>
				  </div>
				  <button type="submit" class="btn btn-primary">Transfer cash</button>
				</form>

				<div class="h-20"></div>
				<h4 class="content-title title-line">Horizontal</h4>

				<form class="form-horizontal">
				  <div class="form-group">
				    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
				    <div class="col-sm-10">
				      <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <div class="checkbox">
				        <label>
				          <input type="checkbox"> Remember me
				        </label>
				      </div>
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-default">Sign in</button>
				    </div>
				  </div>
				</form>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->



	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->



<?php get_footer(); ?>