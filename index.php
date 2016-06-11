<?php include('functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>










          	
    











<style>
.box {
	padding: 15px;
	color: #fff;
}
.box.box-success {
	background-color: #2ecc71;
}
.box.box-info {
	background-color: #3498db;
}
.box.box-danger {
	background-color: #f22613;
}
.box.box-muted {
	background-color: #303641;
}

/* box-index */
.box-index {
	height: 137px;
	position: relative;
}
.box-index .box-name {
	font-size: 11px;
}
.box-index .box-value {
	font-size: 30px;
}
.box-index .box-mini-value {
	    font-size: 18px;
}
.box-index .border-right {
	border-right: 1px solid #fff!important;
}
.box-index .box-link {
	display: block;
	color: #fff;
    background-color: #111;
    border-color: #111;
    font-weight: 300;
    font-size: 13px;
    padding: 5px 10px;
    -webkit-transition: all .25s ease-out;
    -moz-transition: all .25s ease-out;
    -o-transition: all .25s ease-out;
    transition: all .25s ease-out;
    position: absolute;
    bottom: 0px;
    left: 0px;
    border: 1px solid transparent;
    width: 100%;
    text-align: right;
}
.box-index .box-link:hover {
	text-decoration: none;
	background-color: #fff;
    border: 1px solid #111;
    color: #111;
    border-left-color:transparent;
    border-right-color:transparent;
}
.box-index.box-muted .box-link {
	background-color: #f22613;
    border-color: #f22613;
}
.box-index.box-muted .box-link:hover {
	    background-color: #fff;
    border: 1px solid #f22613;
    color: #f22613;
    border-left-color:transparent;
    border-right-color:transparent;
}
</style>
<div class="row hidden">
	<div class="col-md-3">
		<div class="box box-info box-index">

			<div class="row">
	 			<div class="col-md-4">
	 				<i class="fa fa-money fa-fw fa-4x"></i>
	 			</div>
	 			<div class="col-md-8">
	 				<div class="box-name">BUGÜN SATIŞLAR TOPLAMI</div>
	 				<div class="box-value"><?php echo number_format(1290); ?> <i class="fa fa-try"></i> </div>
	 			</div>
	 		</div> <!-- /.row -->
	 		
	 		<div class="h10"></div>

	 		<div class="row">
	 			<div class="col-md-6 border-right">
	 				<div class="box-name">BU HAFTA</div>
	 				<div class="box-mini-value"><?php echo number_format(1290); ?> <i class="fa fa-try"></i> </div>
	 			</div>
	 			<div class="col-md-6">
	 				<div class="box-name">BU AY</div>
	 				<div class="box-mini-value"><?php echo number_format(1290); ?> <i class="fa fa-try"></i> </div>
	 			</div>
	 		</div> <!-- /.row -->

		</div> <!-- /.box -->
	</div> <!-- /.col-md-3 -->
	<div class="col-md-3">
		<div class="box box-success box-index">

			<div class="row">
	 			<div class="col-md-4">
	 				<i class="fa fa-money fa-fw fa-4x"></i>
	 			</div>
	 			<div class="col-md-8">
	 				<div class="box-name">BUGÜN SATIŞLAR TOPLAMI</div>
	 				<div class="box-value"><?php echo number_format(1290); ?> <i class="fa fa-try"></i> </div>
	 			</div>
	 		</div> <!-- /.row -->
	 		
	 		<div class="h10"></div>

	 		<div class="row">
	 			<div class="col-md-6 border-right">
	 				<div class="box-name">BU HAFTA</div>
	 				<div class="box-mini-value"><?php echo number_format(1290); ?> <i class="fa fa-try"></i> </div>
	 			</div>
	 			<div class="col-md-6">
	 				<div class="box-name">BU AY</div>
	 				<div class="box-mini-value"><?php echo number_format(1290); ?> <i class="fa fa-try"></i> </div>
	 			</div>
	 		</div> <!-- /.row -->

		</div> <!-- /.box -->
	</div> <!-- /.col-md-3 -->
	<div class="col-md-3">
		<div class="box box-danger box-index">

			<div class="row">
	 			<div class="col-md-4">
	 				<i class="fa fa-shopping-cart fa-fw fa-4x"></i>
	 			</div>
	 			<div class="col-md-8 text-right">
	 				<div class="box-name">YENİ SİPARİŞLER TOPLAMI</div>
	 				<div class="box-value">79 </div>
	 			</div>
	 		</div> <!-- /.row -->

	 		<a href="#" class="box-link">yeni siparişler <i class="fa fa-angle-double-right"></i></a>	 			

		</div> <!-- /.box -->
	</div> <!-- /.col-md-3 -->
	<div class="col-md-3">
		<div class="box box-muted box-index">

			<div class="row">
	 			<div class="col-md-4">
	 				<i class="fa fa-shopping-cart fa-fw fa-4x"></i>
	 			</div>
	 			<div class="col-md-8 text-right">
	 				<div class="box-name">TÜM SİPARİŞLER TOPLAMI</div>
	 				<div class="box-value">5678 </div>
	 			</div>
	 		</div> <!-- /.row -->
	 		
	 		<a href="#" class="box-link">tüm siparişler <i class="fa fa-angle-double-right"></i></a>	 

		</div> <!-- /.box -->
	</div> <!-- /.col-md-3 -->
</div> <!-- /.row -->



<?php
function chart_forms($array=array())
{ global $til;

	$where = "status='1'";

	if(isset($array['date_start'])){ $where = $where." AND date >='".$array['date_start']." 00:00:00' ";}
	if(isset($array['date_finish'])){ $where = $where."AND date <='".$array['date_finish']." 99:99:99'";}
	if(isset($array['in_out'])){ $where = $where."AND in_out='".$array['in_out']."'";}


	if(isset($array['sum'])) 
	{ 
		if(is_array($array['sum'])) 
		{
			foreach($array['sum'] as $sum_list)
			{ 
				if(!empty($sum)){$sum=$sum.', ';} else{ $sum='';}
				$sum=$sum.'sum('.$sum_list.')';
			}
		}else { $sum = 'sum('.$array['sum'].')'; }
	}
	else {$sum = '*';}



	$query = db()->query("SELECT ".$sum." FROM ".dbname('forms')." WHERE $where");


	$q_return = $query->fetch_row();

	if(isset($array['sum']))
	{
		if(is_array($array['sum'])) 
		{
			$i=0;
			foreach($array['sum'] as $sum_list)
			{ 
				$return[$sum_list] = $q_return[$i];
				$i++;
			}
		}
		else {}
	}
	return $return;
}





$i=7;
$charts = array();
while($i>0)
{ $i = $i-1;
	
	$day = date("Y-m-d",strtotime("-$i day"));

	$charts[$day] = chart_forms(array('date_start'=>$day,'date_finish'=>$day,'in_out'=>'1','sum'=>array('total', 'profit')));
	//$chart_7_days[1][$day] = chart_forms(array('date_start'=>$day,'date_finish'=>$day,'in_out'=>'0','sum'=>array('total', 'protit')));
}



function generateRandomString($length = 100) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generateRandomInt($length = 100) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


for($i=0; $i<50000; $i++)
{
	$product['code'] 				= '';
	$product['name'] 				= generateRandomString(20);
	$product['p_purchase'] 			= 10;
	$product['p_sale'] 				= 10;
	$product['tax_rate'] 			= 18;
	$product['description'] 		= generateRandomString(250);


	add_product($product);
}

?>



<div class="row">
	<div class="col-md-6">




  <!-- tabs left -->
      <div class="tabbable tabs-left">
      	<div class="row no-space">
      		<div class="col-md-2">
		        <ul class="nav nav-tabs">
		          <li class="active"><a href="#a" data-toggle="tab">Satışlar</a></li>
		          <li><a href="#b" data-toggle="tab">Kar/Zarar</a></li>
		          <li><a href="#c" data-toggle="tab">Maliyetler</a></li>
		        </ul>
		    </div> <!-- /.col-md-2 -->
		    <div class="col-md-10">
		        <div class="tab-content">
		        	<div class="tab-pane active" id="a" >
		         	
		         		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
					    <script type="text/javascript">
					      google.charts.load('current', {'packages':['corechart']});
					      google.charts.setOnLoadCallback(drawChart);

					      function drawChart() {
					        var dataTable = new google.visualization.DataTable();
					        dataTable.addColumn('string', 'Year');
					        dataTable.addColumn('number', 'Sales');
					        // A column for custom tooltip content
					        dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
					        dataTable.addColumn('number', 'Sales');
					        // B column for custom tooltip content
					        dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});

					        dataTable.addRows([
					        	<?php $i=0; foreach($charts as $day=>$value): ?>
					          		[
					          			'<?php if($i==0): $i=0; ?><?php echo substr($day,5,5); ?><?php else: $i=0;?><?php endif; ?>', 
					          			<?php echo $value['total']; ?>,
					          			'<?php echo $value['total']; ?> ₺', 
					          			<?php echo $value['profit']; ?>, 
					          			'<div class="bg-success" style="width:100px; padding:2px 5px; border:0px;"><h4><?php echo $value['profit']; ?> ₺</h4></div>'
					          		],
					          	<?php endforeach; ?>
					        ]);

					        var options = {
					          	tooltip: {isHtml: true},
					          	legend: {position: 'none'},
			                  	vAxis: {minValue: 0},
			                  	vAxis: {format:'###,###,###.00 ₺'},
			                  	backgroundColor : 'transparent',
			                  	chartArea: {'width': '100%', 'height': '80%', left:60,top:20,},
			                  	curveType: 'function',
		          				pointSize: 3,
			                  	backgroundColor: {
				                stroke: 'transparent',
				                strokeWidth: 1,
				                fill:'transparent'
				              }
					        };
					        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
					        chart.draw(dataTable, options);
					      }
					    </script>
						<div id="chart_div" style="width: 100%; height: 300px;"></div>

		        	 </div> <!-- /.tab-pane -->
			         <div class="tab-pane" id="b">Secondo sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan. 
			         Aliquam in felis sit amet augue.</div>
			         <div class="tab-pane" id="c">Thirdamuno, ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
			         Quisque mauris augue, molestie tincidunt condimentum vitae. </div>
		        </div> <!-- /.tab-content -->

		    </div> <!-- /.col-md-10 -->
		</div> <!-- /.row -->
    </div>
    <!-- /tabs -->
    




			

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-shopping-cart"></i> Son Siparişler</div>
			<div class="panel-body">

				<style>
				ul.panel-on.nav-tabs {
					margin-top: -50px;
					border:0px;
				}
				ul.panel-on.nav-tabs>li.active>a, .panel-on.nav-tabs>li.active>a:focus, .panel-on.nav-tabs>li.active>a:hover {
				    color: #555;
				    cursor: default;
				    background-color: #fff;
				    border: 0px;
				}
				ul.panel-on.nav-tabs>li>a, .panel-on.nav-tabs>li>a:focus, .panel-on.nav-tabs>li>a:hover {
					border:0px !important;
					background-color: none !important;
					padding: 7px 15px 8px 15px;
					color: #0d638f;
				}
				div.panel-on-div {
					border:0px;
					padding: 0px;
				}
				</style>
				<ul id="myTabs" class="nav nav-tabs bordered panel-on pull-right" role="tablist"> 
					<li role="presentation" class="active"><a href="#lastOrders" id="lastOrders-tab" role="tab" data-toggle="tab" aria-controls="lastOrders" aria-expanded="false"><i class="fa fa-shopping-cart"></i> Son Formlar</a></li> 
					<li role="presentation" class=""><a href="#approvalOrders" role="tab" id="approvalOrders-tab" data-toggle="tab" aria-controls="approvalOrders" aria-expanded="true"><i class="fa fa-clock-o"></i> Bekleyenler</a></li> 
					<li role="presentation" class=""><a href="#preparingOrders" role="tab" id="preparingOrders-tab" data-toggle="tab" aria-controls="preparingOrders" aria-expanded="true"><i class="fa fa-clock-o"></i> Hazırlanıyor</a></li> 
				</ul>


				<div id="myTabContent" class="tab-content panel-on-div"> 
				<!-- TAB: #HOME -->
				<div role="tabpanel" class="tab-pane fade in active" id="lastOrders" aria-labelledby="lastOrders-tab"> 

					<?php $q_lastOrders = db()->query("SELECT * FROM ".dbname('forms')." WHERE status='1' ORDER BY date DESC LIMIT 10"); ?>
					<?php if($q_lastOrders->num_rows > 0): ?>
						<table id="table_lastOrders" class="table table-condensed table-hover">
					        <thead>
					            <tr>
					            	<th></th>
					                <th>Form ID</th>
					                <th>Hesap</th>
					                <th class="text-center">Sipariş Adet</th>
					                <th class="text-right">Tutar</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php while($list = $q_lastOrders->fetch_assoc()): ?>
					        		<tr>
					        			<td><span class="label label-<?php echo o_status($list['o_status'], 'style'); ?> block"><?php echo o_status($list['o_status']); ?></span></td>
					        			<td>#<a href="<?php url_form($list['id']); ?>" taget="_blank"><?php echo $list['id']; ?></a></td>
					        			<td><?php echo $list['account_name']; ?></td>
					        			<td class="text-center"><?php echo $list['quantity']; ?></td>
					        			<td class="text-right"><?php echo convert_money($list['total'], array('icon'=>true)); ?></td>
					        		</tr>
					        	<?php endwhile; ?>
					        </tbody>
				    	</table>
				    <?php else: ?>
				    	<?php echo get_alert(array('description'=>'Veritabanında kayıt bulunamadı.'), 'info', array('dismissible'=>false)); ?>
				    <?php endif; ?>

				</div> <!-- /#home -->
				<!-- TAB: approvalOrders -->
				<div role="tabpanel" class="tab-pane" id="approvalOrders" aria-labelledby="approvalOrders-tab"> 
					<?php $q_lastOrders = db()->query("SELECT * FROM ".dbname('forms')." WHERE status='1' AND o_status='waiting' ORDER BY date DESC LIMIT 10"); ?>
					<?php if($q_lastOrders->num_rows > 0): ?>
						<table id="table_lastOrders" class="table table-condensed table-hover">
					        <thead>
					            <tr>
					            	<th></th>
					                <th>Form ID</th>
					                <th>Hesap</th>
					                <th class="text-center">Sipariş Adet</th>
					                <th class="text-right">Tutar</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php while($list = $q_lastOrders->fetch_assoc()): ?>
					        		<tr>
					        			<td><span class="label label-<?php echo o_status($list['o_status'], 'style'); ?> block"><?php echo o_status($list['o_status']); ?></span></td>
					        			<td>#<a href="<?php url_form($list['id']); ?>" taget="_blank"><?php echo $list['id']; ?></a></td>
					        			<td><?php echo $list['account_name']; ?></td>
					        			<td class="text-center"><?php echo $list['quantity']; ?></td>
					        			<td class="text-right"><?php echo convert_money($list['total'], array('icon'=>true)); ?></td>
					        		</tr>
					        	<?php endwhile; ?>
					        </tbody>
				    	</table>
				    <?php else: ?>
				    	<?php echo get_alert(array('description'=>'Veritabanında kayıt bulunamadı.'), 'info', array('dismissible'=>false)); ?>
				    <?php endif; ?>
				</div> <!-- /#approvalOrders -->
				<!-- TAB: preparingOrders -->
				<div role="tabpanel" class="tab-pane" id="preparingOrders" aria-labelledby="preparingOrders-tab"> 
					<?php $q_lastOrders = db()->query("SELECT * FROM ".dbname('forms')." WHERE status='1' AND o_status='preparing' ORDER BY date DESC LIMIT 10"); ?>
					<?php if($q_lastOrders->num_rows > 0): ?>
						<table id="table_lastOrders" class="table table-condensed table-hover">
					        <thead>
					            <tr>
					            	<th></th>
					                <th>Form ID</th>
					                <th>Hesap</th>
					                <th class="text-center">Sipariş Adet</th>
					                <th class="text-right">Tutar</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php while($list = $q_lastOrders->fetch_assoc()): ?>
					        		<tr>
					        			<td><span class="label label-<?php echo o_status($list['o_status'], 'style'); ?> block"><?php echo o_status($list['o_status']); ?></span></td>
					        			<td>#<a href="<?php url_form($list['id']); ?>" taget="_blank"><?php echo $list['id']; ?></a></td>
					        			<td><?php echo $list['account_name']; ?></td>
					        			<td class="text-center"><?php echo $list['quantity']; ?></td>
					        			<td class="text-right"><?php echo convert_money($list['total'], array('icon'=>true)); ?></td>
					        		</tr>
					        	<?php endwhile; ?>
					        </tbody>
				    	</table>
				    <?php else: ?>
				    	<?php echo get_alert(array('description'=>'Veritabanında kayıt bulunamadı.'), 'info', array('dismissible'=>false)); ?>
				    <?php endif; ?>
				</div> <!-- /#approvalOrders -->
				</div> <!-- /.tab-content -->
			</div>
		</div> <!-- /.panel -->
	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->
	


<div class="h20"></div>





<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-4">
				<a href="<?php site_url('content/forms/add.php?in_out=1'); ?>" class="box-item">
					<i class="fa fa-shopping-cart"><i class="fa fa-level-up text-primary"></i></i>
					<h3>Yeni Çıkış</h3>
					<small class="text-muted">yeni ürün/hizmet satışı</small>
				</a>
			</div> <!-- /.col-md-2 -->
			<div class="col-md-4">
				<a href="<?php site_url('content/forms/add.php?in_out=0'); ?>" class="box-item">
					<i class="fa fa-shopping-cart"><i class="fa fa-level-down text-primary"></i></i>
					<h3>Yeni Giriş</h3>
					<small class="text-muted">yeni ürün/hizmet alışı</small>
				</a>
			</div> <!-- /.col-md-2 -->
			<div class="col-md-4">
				<a href="<?php site_url('content/forms/index.php'); ?>" class="box-item">
					<i class="fa fa-shopping-cart"></i>
					<h3>Giriş-Çıkış</h3>
					<small class="text-muted">giriş ve çıkış form yönetimi</small>
				</a>
			</div> <!-- /.col-md-2 -->
			<div class="col-md-4">
				<a href="<?php site_url('content/accounts/index.php'); ?>" class="box-item">
					<i class="fa fa-users"></i>
					<h3>Hesaplar</h3>
					<small class="text-muted">alacak/verecek takibi</small>
				</a>
			</div> <!-- /.col-md-2 -->
			<div class="col-md-4">
				<a href="<?php echo site_url('content/products/index.php'); ?>" class="box-item">
					<i class="fa fa-cubes"></i>
					<h3>Ürünler</h3>
					<small class="text-muted">stok/hizmet yönetimi</small>
				</a>
			</div> <!-- /.col-md-2 -->
			<div class="col-md-4">
				<a href="#" class="box-item">
					<i class="fa fa-money"></i>
					<h3>Kasa & Ödeme</h3>
					<small class="text-muted">kasa/banka ve ödemeler</small>
				</a>
			</div> <!-- /.col-md-2 -->
		</div> <!-- /.row -->
	</div>
	<div class="col-md-6">
		<div class="panel panel-default in-table">
			<div class="panel-heading"><i class="fa fa-shopping-cart"></i> Son Eklenen 10 Sipariş</div>
			<div class="panel-body">

				<?php $forms = get_forms(array('query'=>'status=1 ORDER BY date DESC LIMIT 10')); ?>
				<?php if($forms): ?>
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th width="60">Form ID</th>
								<th>Hesap Adı</th>
								<th>Şehir</th>
								<th width="100" class="text-center">Tutar</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($forms as $form): ?>
							<tr>
								<td><a href="<?php url_form($form['id']); ?>" target="_blank">#<?php echo $form['id']; ?></a></td>
								<td><?php echo $form['account_name']; ?></td>
								<td><?php echo $form['account_city']; ?></td>
								<td class="text-right"><?php echo convert_money($form['total'], array('icon'=>true)); ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<?php echo get_alert('Kayıt bulunamadı.', 'warning', array('dismissible'=>false)); ?>
				<?php endif; ?>

			</div> <!-- /.panel -->
		</div> <!-- /.panel-primary -->
	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->


		


<?php get_footer(); ?>