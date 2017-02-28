<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Typography' );
add_page_info( 'nav', array('name'=>'Developer', 'url'=>get_site_url('admin/_developer/') ) );
add_page_info( 'nav', array('name'=>'Typography') );
?>





<div class="row">
	<div class="col-md-6">
		
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Headings</h3></div>
			<div class="panel-body">
				
				<h1>h1. Heading Text</h1>
				<h2>h2. Heading Text</h2>
				<h3>h3. Heading Text</h3>
				<h4>h4. Heading Text</h4>
				<h5>h5. Heading Text</h5>
				<h6>h6. Heading Text</h6>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">
		
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Headings width secondary text</h3></div>
			<div class="panel-body">
				
				<h1>h1. Heading Text <small>Secondary text</small></h1>
				<h2>h2. Heading Text <small>Secondary text</small></h2>
				<h3>h3. Heading Text <small>Secondary text</small></h3>
				<h4>h4. Heading Text <small>Secondary text</small></h4>
				<h5>h5. Heading Text <small>Secondary text</small></h5>
				<h6>h6. Heading Text <small>Secondary text</small></h6>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->



<div class="row">
	<div class="col-md-6">
		
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Text</h3></div>
			<div class="panel-body">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<p>Duis aute irure dolor in reprehenderit in voluptate velit esse varint cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit verty anim id westwod est laborum.</p>
				<hr />
				<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-6 -->
	<div class="col-md-3">
		
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Text with color</h3></div>
			<div class="panel-body">
				
				<p class="text-success">Lorem ipsum dolar sit amet.</p>
				<p class="text-danger">Lorem ipsum dolar sit amet.</p>
				<p class="text-primary">Lorem ipsum dolar sit amet.</p>
				<p class="text-info">Lorem ipsum dolar sit amet.</p>
				<p class="text-muted">Lorem ipsum dolar sit amet.</p>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-3 -->
	<div class="col-md-3">
		
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Inline text element</h3></div>
			<div class="panel-body">
				
				<p class="italic">Lorem ipsum dolar sit amet. (italic)</p>
				<p class="underline">Lorem ipsum dolar sit amet. (underline)</p>
				<p class="bold">Lorem ipsum dolar sit amet. (bold)</p>
				<p class=""><s>Lorem ipsum dolar sit amet. (lined)</s></p>
				<p class="">Lorem ipsum <mark>dolar</mark> sit amet. (highlight)</p>
				<p><small>Lorem ipsum dolar sit amet. (small)</small></p>
				<p>Lorem ipsum dolar sit <abbr title="this is a attribute">attr</abbr> amet. (attr)</p>
				<p class="text-lowercase">Lowercased text. (lowercase)</p>
				<p class="text-uppercase">Uppercased text. (uppercase)</p>
				<p class="text-capitalize">Capitalized text. (capitalize)</p>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-3 -->
</div> <!-- /.row -->






<div class="row">
	<div class="col-md-6">
		
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Blockquotes</h3></div>
			<div class="panel-body">
				
                <blockquote class="blockquote">
                    <p>Akan su asla kokmaz, kapı menteşesi paslanmaz.</p>
                    <footer>Bir çin ata sözü</footer>
                </blockquote>

                <blockquote class="blockquote-reverse">
                    <p>Söz bilirsen konuş, senden ibret alsınlar; söz bilmezsen sükut et, seni insan saysınlar!</p>
                    <footer>Bir türk ata sözü</footer>
                </blockquote>

                <hr />
                <span class="text-muted">* &lt;code&gt;</span>
                <p>Lorem imsum <code>dolar</code> sit amet.</p>

                <span class="text-muted">* &lt;kbd&gt;</span>
                <p>Lorem imsum <kbd>dolar</kbd> sit amet.</p>

                <span class="text-muted">* &lt;pre&gt;</span>
                <p><pre>Lorem imsum dolar sit amet.</pre></p>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">
		
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Description list</h3></div>
			<div class="panel-body">

				<span class="text-muted">* Standart</span>
				<dl>
				  	<dt>This is a description</dt>
				  	<dd>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</dd>

				  	<dt>This is a description</dt>
				  	<dd>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</dd>

				  	<dt>This is a description</dt>
				  	<dd>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</dd>
				</dl>

				<span class="text-muted">* Horizontal</span>
				<dl class="dl-horizontal">
				  	<dt>This is a description</dt>
				  	<dd>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</dd>

				  	<dt>This is a description</dt>
				  	<dd>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</dd>

				  	<dt>This is a description</dt>
				  	<dd>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</dd>
				</dl>
				

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->




<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Unstyled list</h3></div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li>Lorem ipsum dolor sit amet</li>
					<li>Consectetur adipiscing elit</li>
					<li>Integer molestie lorem at massa</li>
					<li>Facilisis in pretium nisl aliquet</li>
					<li>Nulla volutpat aliquam velit</li>
					<li>Faucibus porta lacus fringilla vel
						<ul class="">
							<li>Lorem ipsum dolor sit amet</li>
							<li>Consectetur adipiscing elit</li>
							<li>Integer molestie lorem at massa</li>
						</ul>
					</li>
					<li>Aenean sit amet erat nunc</li>
					<li>Eget porttitor lorem</li>
				</ul>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->
	</div> <!-- /.col-md-4 -->
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Standart list</h3></div>
			<div class="panel-body">
				<ul class="">
					<li>Lorem ipsum dolor sit amet</li>
					<li>Consectetur adipiscing elit</li>
					<li>Integer molestie lorem at massa</li>
					<li>Facilisis in pretium nisl aliquet</li>
					<li>Nulla volutpat aliquam velit</li>
					<li>Faucibus porta lacus fringilla vel
						<ul class="">
							<li>Lorem ipsum dolor sit amet</li>
							<li>Consectetur adipiscing elit</li>
							<li>Integer molestie lorem at massa</li>
						</ul>
					</li>
					<li>Aenean sit amet erat nunc</li>
					<li>Eget porttitor lorem</li>
				</ul>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->
	</div> <!-- /.col-md-4 -->
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Ordered list</h3></div>
			<div class="panel-body">
				<ol class="">
					<li>Lorem ipsum dolor sit amet</li>
					<li>Consectetur adipiscing elit</li>
					<li>Integer molestie lorem at massa</li>
					<li>Facilisis in pretium nisl aliquet</li>
					<li>Nulla volutpat aliquam velit</li>
					<li>Faucibus porta lacus fringilla vel
						<ol class="">
							<li>Lorem ipsum dolor sit amet</li>
							<li>Consectetur adipiscing elit</li>
							<li>Integer molestie lorem at massa</li>
						</ol>
					</li>
					<li>Aenean sit amet erat nunc</li>
					<li>Eget porttitor lorem</li>
				</ol>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->
	</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->



<?php get_footer(); ?>