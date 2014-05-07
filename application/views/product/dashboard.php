<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li class="active">Stok Yönetimi</li>
</ol>

<?php $products = get_products(); ?>

<div class="row">
<div class="col-md-8">

	
            <div class="row">
                <div class="col-md-3">
                    <a href="<?php echo site_url('product/add'); ?>" class="link-dashboard-stat">
                        <div class="dashboard-stat none">
                        	<div class="visual">
                                <i class="fa fa-plus fs-20 gray"></i>
                            </div>
                            <div class="details">
                                <div class="number fs-18">yeni</div>
                                <div class="desc">yeni stok kartı</div>
                             </div>
                        </div> <!-- /.dashboard-stat -->
                    </a>
                </div> <!-- /.col-md-6 -->
                <div class="col-md-3">
                    <a href="<?php echo site_url('product/lists'); ?>" class="link-dashboard-stat">
                        <div class="dashboard-stat none">
                        	<div class="visual">
                                <i class="fa fa-bars fs-20 gray"></i>
                            </div>
                            <div class="details">
                                <div class="number fs-18">stok kartları</div>
                                <div class="desc">stok kartları listesi</div>
                             </div>
                        </div> <!-- /.dashboard-stat -->
                     </a>
                </div> <!-- /.col-md-3 -->
                <?php if(get_the_current_user('role') < 3): ?>
                <div class="col-md-3">
                    <a href="<?php echo site_url('product/options'); ?>" class="link-dashboard-stat">
                        <div class="dashboard-stat none">
                        	<div class="visual">
                                <i class="fa fa-gear fs-20 gray"></i>
                            </div>
                            <div class="details">
                                <div class="number fs-18">seçenekler</div>
                                <div class="desc">stok yönetimi</div>
                             </div>
                        </div> <!-- /.dashboard-stat -->
                     </a>
                </div> <!-- /.col-md-3 -->
                <?php endif; ?>
            </div> <!-- /.row -->
            
            
            <div class="row">
            	<div class="col-md-6">
                	<div class="widget">
                    	<div class="header"><i class="fa fa-folder-open"></i> Son hareket gören stok kartları</div>
                        <div class="content">
                        	<table class="table table-hover table-condensed table-bordered fs-11">
                            	<thead>
                                	<tr>
                                    	<th width="80">Tarih</th>
                                        <th>Stok Kodu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php
									$this->db->where('product_id >', '0');
									$this->db->order_by('date', 'DESC');
									$this->db->limit(10);
									$query = $this->db->get('user_logs')->result_array();
									?>
                                    <?php foreach($query as $log_product): ?>
                                    <tr>
                                    	<td><?php echo hours_late($log_product['date'], array('text'=>true)); ?> saat önce</td>
                                        <td><a href="<?php echo site_url('product/view/'.$log_product['product_id']); ?>"><?php echo $products[$log_product['product_id']]['code']; ?></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div> <!-- /.content -->
                    </div> <!-- /.widget -->
                </div> <!-- /.col-md-6 -->
                <div class="col-md-6">
                	<div class="widget">
                    	<div class="header"><i class="fa fa-bar-chart-o"></i> En popüler 10 stok kartı</div>
                        <div class="content">
                        	<div class="note">
                            	<i class="fa fa-quote-left"></i>
                        		<small>Şu anda en popüler 10 stok kartının raporunu görmektesiniz. Stok kartları satış adetlerine göre hesaplanmaktadır.</small>
                            </div>
                            <div style="height:10px;"></div>
                        	<?php
							$this->db->where('status', 1);
							$this->db->where('product_id >', 0);
							$query = $this->db->get('form_items')->result_array();
							$popularProductsArray = array();
							
							// populer urunleri bir diziye aktariyoruz
							foreach($query as $items)
							{
								
								$popularProductsArray[$items['product_id']]['quantity'] = @$popularProductsArray[$items['product_id']]['quantity'] + $items['quantity'];
								$popularProductsArray[$items['product_id']]['id'] = $items['product_id'];
							}
							// arsort() fonksiyonu ile en populer urunleri buyukten kucuge siraliyoruz
							arsort($popularProductsArray);
							?>
                        	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
							<script type="text/javascript">
                              google.load("visualization", "1", {packages:["corechart"]});
                              google.setOnLoadCallback(drawChart);
                              function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                  ['Stok Adı', 'Satış Adet']
								  <?php $i = 0; ?>
								  <?php foreach($popularProductsArray as $product): ?>
								  <?php if($i < 10): $i++; ?>
								  	,['<?php echo $products[$product['id']]['name']; ?>', <?php echo $product['quantity']; ?>]
								  <?php endif; ?>
								  <?php endforeach; ?>
                                ]);
                        
                                var options = {
								  chartArea:{left:0,top:0,width:"100%",height:"100%"},
								  legend: {position: 'none'},
                                  is3D: true
                                };
                        
                                var chart = new google.visualization.PieChart(document.getElementById('popular_products'));
                                chart.draw(data, options);
                              }
                            </script>
                            <div id="popular_products" style="width: 100%; height: 100%;"></div>
                        </div> <!-- /.content -->
                    </div> <!-- /.widget -->
                </div> <!-- /.col-md-6 -->
            </div> <!-- /.row -->
		
</div> <!-- /.col-md-8 -->
<div class="col-md-4">
	<div class="widget">
        <div class="header"><i class="fa fa-folder-open"></i> Kritik stok uyarısı</div>
        <div class="content">
        	<div class="note">
                <i class="fa fa-quote-left"></i>
                <small>Tükenmekte olan ve en çok satılan 10 stok kartına bakmaktasın. Detaylı raporlama için satın alma raporu sayfasına bakmanı öneririz. </small>
            </div>
            <div class="h10"></div>
            <table class="table table-hover table-condensed table-bordered fs-11">
                <thead>
                    <tr>
                        <th>Stok Kodu</th>
                        <th>Satın Alma</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					// 7 gunluk kritik stok uyarisi icin once satis hareketlerini cekiyoruz
					$this->db->where('date >=', add_date_time(date('Y-m-d'), -7, 'd').' 00:00:00');
					$this->db->where('date <=', date('Y-m-d').' 99:99:99');
					$this->db->where('status', 1);
					$this->db->where('in_out', 1); // satis yani cikis olan hareketler
					$this->db->where('product_id >', 0);
					$query = $this->db->get('form_items')->result_array();
					
					// simdi urunlerin satis adetlerini diziye aktaralim
					$criticalProductsArray = array();
					foreach($query as $items)
					{
						$criticalProductsArray[$items['product_id']]['quantity'] = @$criticalProductsArray[$items['product_id']]['quantity'] + $items['quantity'];
						$criticalProductsArray[$items['product_id']]['product_id'] = $items['product_id'];
					}
					
					// yukarida satis adetlerini diziye aktardik, simdi ise guncel stok adeti ile guncel satis adetlerini eslestirik 7 gunluk satin alma raporunu cikartalim
					$criticalProducts = array();
					foreach($criticalProductsArray as $cProduct)
					{
						if($products[$cProduct['product_id']]['amount'] < $cProduct['quantity'])
						{
							$criticalProducts[$cProduct['product_id']]['total_required'] = $cProduct['quantity'] - $products[$cProduct['product_id']]['amount'];
							$criticalProducts[$cProduct['product_id']]['now_amount'] = $products[$cProduct['product_id']]['amount'];
							$criticalProducts[$cProduct['product_id']]['sale_amount'] = $cProduct['quantity'];
							$criticalProducts[$cProduct['product_id']]['product_id'] = $cProduct['product_id'];
						}
					}
					
                    ?>
                    <?php foreach($criticalProducts as $cProduct): ?>
                    <tr>
                        <td title="<?php echo $products[$cProduct['product_id']]['name']; ?>">
                        	<a href="<?php echo site_url('product/view/'.$cProduct['product_id']); ?>" target="_blank">
								<?php echo $products[$cProduct['product_id']]['code']; ?>
                            </a>
                        </td>
                        <td class="text-center"><?php echo get_amount($cProduct['total_required']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> <!-- /.content -->
    </div> <!-- /.widget -->
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->