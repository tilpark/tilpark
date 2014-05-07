<?php $users = get_user_array(); ?>

<ol class="breadcrumb">
  <li class="active">Yönetim</li>
  
</ol>





<div class="row">
	<div class="col-md-8">
    

        <div class="row">
            <div class="col-md-3 col-xs-6">
                <a href="<?php echo site_url('product'); ?>" class="link-dashboard-stat">
                    <div class="dashboard-stat blue none">
                        <div class="visual">
                            <i class="fa fa-share-square-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">stok</div>
                            <div class="desc">stok yönetimi</div>
                         </div>
                    </div> <!-- /.dashboard-stat -->
                </a>
           </div> <!-- /.col-md-3 -->
           
            <div class="col-md-3 col-xs-6">
                <a href="<?php echo site_url('account'); ?>" class="link-dashboard-stat">
                    <div class="dashboard-stat blue none">
                        <div class="visual">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="details">
                            <div class="number">hesap</div>
                            <div class="desc">hesap yönetimi</div>
                         </div>
                    </div> <!-- /.dashboard-stat -->
                </a>
            </div> <!-- /.col-md-3 -->  
           
            <div class="col-md-3 col-xs-6">   
                <a href="<?php echo site_url('form'); ?>" class="link-dashboard-stat">
                    <div class="dashboard-stat blue none">
                        <div class="visual">
                            <i class="fa fa-external-link"></i>
                        </div>
                        <div class="details">
                            <div class="number">form</div>
                            <div class="desc">ürün alışı ve satışı</div>
                         </div>
                    </div> <!-- /.dashboard-stat -->  
                </a>
            </div> <!-- /.col-md-3 -->
            
            <div class="col-md-3 col-xs-6"> 
                <a href="<?php echo site_url('payment'); ?>" class="link-dashboard-stat">
                    <div class="dashboard-stat blue none">
                        <div class="visual">
                            <i class="fa fa-try"></i>
                        </div>
                        <div class="details">
                            <div class="number">kasa</div>
                            <div class="desc">ödeme hareketleri ve çek takibi</div>
                         </div>
                    </div> <!-- /.dashboard-stat -->
                </a>
             </div> <!-- /.col-md-3 -->
             
             
             <div class="col-md-3 col-xs-6">   
                <a href="<?php echo site_url('plugins'); ?>" class="link-dashboard-stat">
                <div class="dashboard-stat metro_red none">
                    <div class="visual">
                        <i class="fa fa-tags"></i>
                    </div>
                    <div class="details">
                        <div class="number">eklenti</div>
                        <div class="desc">eklenti listesi ve yönetimi</div>
                     </div>
                </div> <!-- /.dashboard-stat -->
                </a>
            </div> <!-- /.col-md-3 -->
        </div> <!-- /.row -->
        
 	
	<div class="h20"></div>
   
        
    </div> <!-- /.col-md-8 -->
    <div class="col-md-4">

        
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Hareketler</a></li>
            <li><a href="#profile" data-toggle="tab">Kullanıcılar</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="home">
            	<?php
				$this->db->where('type', 'invoice');
				$this->db->or_where('type', 'item');
				$this->db->order_by('id', 'DESC');
				$this->db->limit(10);
				$query = $this->db->get('user_logs')->result_array();
				?>
            	<ul class="logs">
                	<?php foreach($query as $log): ?>
                    <?php
					$icon = 'fa fa-globe';
					if($log['title'] == 'Silme'){$icon = 'fa fa-trash-o text-danger';}
					if($log['title'] == 'Yeni Fiş'){$icon = 'fa fa-plus text-success';}
					if($log['title'] == 'Giriş'){$icon = 'fa fa-share-square-o';}
					if($log['title'] == 'Form Güncelleme'){$icon = 'fa fa-edit text-warning';}
					?>
                    <li>
                    	<i class="<?php echo $icon; ?> fs-15"></i><?php echo $log['description']; ?> <span><?php echo time_late($log['date']); ?> önce</span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="tab-pane fade" id="profile">
            <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
            </div>
        </div>
        
        
        <div class="box13">
        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt 
            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in 
            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
            non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
        	<div class="box13_corner_lf"></div>
            <div class="box13_corner_rt"></div>
            <div class="box13_ribbon"></div>
        </div>
        
        
        
    </div> <!-- /.col-md-4 -->
</div> <!-- /.row -->