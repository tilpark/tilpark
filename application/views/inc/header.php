<?php
if($this->session->userdata('login') == false)
{
	redirect('user/login');
	exit;
}
$query = get_user(get_the_current_user('id'));
$this->session->set_userdata('user', $query);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php if(isset($meta_title)): ?><?php echo $meta_title; ?> | TilPark! <?php else: ?>TilPark! | Açık Kaynak Kodlu Web Tabanlı Otomasyon Sistemi<?php endif; ?></title>
<meta name="description" content="TilPark! Açık Kaynak Kodlu Web Tabanlı Otomasyon Sistemi">

<link rel="shortcut icon" href="<?php echo base_url('theme/img/logo/favicon.png'); ?>">

<!-- Included CSS Files (Compressed) -->
<link rel="stylesheet" href="<?php echo base_url('theme/css/bootstrap.css'); ?>">

<link rel="stylesheet" href="<?php echo base_url('theme/css/datepicker.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('theme/js/dataTable/css/TableTools.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('theme/css/lightbox.css'); ?>">



<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('theme/js/jquery.js'); ?>"></script>
<script src="<?php echo base_url('theme/js/jquery-ui-1.10.4.custom.js'); ?>"></script>
<script src="<?php echo base_url('theme/js/bootstrap.js'); ?>"></script> 
<script src="<?php echo base_url('theme/js/jquery.validation.js'); ?>"></script> 

<script src="<?php echo base_url('theme/js/bootstrap-datepicker.js'); ?>"></script> 

<script src="<?php echo base_url('theme/js/jquery.dataTables.js'); ?>"></script> 
<script src="<?php echo base_url('theme/js/dataTable/js/ZeroClipboard.js'); ?>"></script> 
<script src="<?php echo base_url('theme/js/dataTable/js/TableTools.js'); ?>"></script>

<script src="<?php echo base_url('theme/js/lightbox-2.6.min.js'); ?>"></script>
<!-- wysiwyg editor -->
<!-- include summernote css/js-->
<link rel="stylesheet" href="<?php echo base_url('plugins/wysiwyg/dist/summernote.css'); ?>" />
<script src="<?php echo base_url('plugins/wysiwyg/dist/summernote.min.js'); ?>"></script>

<!-- Initialize JS Plugins -->
<script src="<?php echo base_url('theme/js/app.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('theme/css/app.css'); ?>">



<script>
$(document).ready( function() {
	
	/* datatable */
	var exportName = $('.dataTable').attr("exportname");
	if(exportName == null)
	{
		exportName = '<?php echo $this->uri->segment(2); ?>';
	}
	
	exportName = exportName +'_tilpark_'+'<?php echo date('YmdHis'); ?>';
	
	$('.dataTable').dataTable({<?php $this->load->view('system/import_button'); ?>});
	$('.dataTable1').dataTable({<?php $this->load->view('system/import_button'); ?>});
	$('.dataTable2').dataTable({<?php $this->load->view('system/import_button'); ?>});
	$('.dataTable3').dataTable({<?php $this->load->view('system/import_button'); ?>});
	$('.dataTable4').dataTable({<?php $this->load->view('system/import_button'); ?>});
	$('.dataTable5').dataTable({<?php $this->load->view('system/import_button'); ?>});
	
	
	$('.dataTable_noLength').dataTable({
		
		"sDom": " <'row'<'col-md-6 hidden-xs hidden-sm'T><'col-md-6'f>>rt<'row'<'col-md-6 hidden-xs hidden-sm'i><'col-md-6'p>>",
		"bJQueryUI": false,
		"sPaginationType": "full_numbers",
        "oTableTools": {
            "sSwfPath": "<?php echo base_url('theme/js/dataTable/swf/copy_csv_xls_pdf.swf'); ?>",
			"aButtons": [
				{
					"sExtends": "xls",
					"sFileName": exportName + "_excel.csv",
					"sButtonText": "Excel"
				},
				{
					"sExtends": "csv",
					"sFileName":  exportName + ".csv",
					"sButtonText": "CSV"
				},
				{
					"sExtends": "pdf",
					"sFileName": exportName + ".pdf",
					"sButtonText": "PDF"
				},
				{
					"sExtends": "copy",
					"sButtonText": "Kopyala"
				},
				{
					"sExtends": "print",
					"sButtonText": "Yazdır"
				}
			]
        }
    });
	
	
	
	$('.dataTable_noExcel').dataTable({
		"sDom": " <'row'<'col-md-6 hidden-xs hidden-sm'l><'col-md-6'f>>rt<'row'<'col-md-6 hidden-xs hidden-sm'i><'col-md-6'p>>",
		"bJQueryUI": false,
		"sPaginationType": "full_numbers"
    });
	
	$('.dataTable_noExcel_noLength').dataTable({
		"sDom": " <'row'<'col-md-12'f>>rt<'row'<'col-md-6 hidden-xs hidden-sm'i><'col-md-6'p>>",
		"bJQueryUI": false,
		"sPaginationType": "full_numbers"
    });
	
	$('.dataTable_noExcel_noLength_noInformation').dataTable({
		"sDom": " <'row'<'col-md-12'f>>rt<'row'<'col-md-12'p>>",
		"bJQueryUI": false,
		"sPaginationType": "full_numbers"
    });
	
	$('.dataTable_noExcel_noLength_noSearch').dataTable({
		"sDom": "rt<'row'<'col-md-6 hidden-xs hidden-sm'i><'col-md-6'p>>",
		"bJQueryUI": false,
		"sPaginationType": "full_numbers"
    });
	
});
</script>


</head>
<body>



<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
          	<a class="logo hidden-sm hidden-xs" href="<?php echo site_url(''); ?>">
              <img src="<?php echo base_url('theme/img/logo/logo.png'); ?>" class="img-responsive" style="height:40px;">
			      </a>

        </div>
        
        <div class="liner pull-left hidden-sm hidden-xs"></div>
        
        
        
        <div class="navbar-collapse collapse">
          	
            
            
            
            <div class="btn-group navbar-right infoBtn">
                <button type="button" class="btn hidden-xs hidden-sm"><i class="fa fa-gears"></i></button>
            
                <ul class="nav navbar-nav">
                  <li class="dropdown">
                    <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-share-square-o"></i> Seçenekler <b class="caret"></b></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('user/profile'); ?>"><i class="fa fa-user"></i> Profilim</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('user/inbox'); ?>"><i class="fa fa-envelope"></i> Mesaj Kutusu</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('user/task'); ?>"><i class="fa fa-tasks"></i> Görev Yöneticisi</a></li>
                      <li role="presentation" class="divider"></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('user/users'); ?>"><i class="fa fa-users"></i> Kullanıcı Listesi</a></li>
                      <li role="presentation" class="divider"></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('user/logout'); ?>"><i class="fa fa-times"></i> Çıkış</a></li>
                    </ul>
                  </li>
                </ul>
            </div> <!-- /.btn-group navbar-right -->
            
            <div class="liner navbar-right hidden-sm hidden-xs"></div>
            <div class="btn-group navbar-right infoBtn hidden-sm hidden-xs">
              <button type="button" class="btn btn_mbox btn_mbox_noti"><i class="fa fa-globe"></i><div class="count_noti"></div></button>
              <button type="button" class="btn btn_mbox btn_mbox_mess"><i class="fa fa-envelope"></i><div class="count_mess"></div></button>
              <button type="button" class="btn btn_mbox btn_mbox_task"><i class="fa fa-tasks"></i><div class="count_task"></div></button>
            </div>

            <div class="liner navbar-right"></div>

        </div>
        
        
        
      </div> <!-- /.container-fluid -->
    </div> <!-- /.navbar -->



<div class="container bg">
<div class="mbox list_noti"></div>
<div class="mbox list_mess"></div>
<div class="mbox list_task"></div>
	<div class="row" style="margin-right:0px;">
    	<div class="col-md-2 hidden-xs hidden-sm" style="padding-right:0px; padding-left:0px;">
        	<div class="sidebar">
            	<div class="h10"></div>
                <div class="clearfix"></div>
                
                <div class="profile">
					         <a href="<?php echo site_url(); ?>" class="avatar"><img src="<?php echo base_url('uploads/avatar/thumb_'.get_the_current_user('avatar')); ?>" class="avatar" /></a>
                    <div class="text">
                    	merhaba, <br />
                        <a href=""><?php echo get_the_current_user('name'); ?></a>
                    </div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default"><i class="fa fa-globe"></i><div class="count_info"><?php $info = calc_message('info'); if($info > 0): ?><div class="mess_count"><?php echo $info; ?></div><?php endif; ?></div></button>
                      <button type="button" class="btn btn-default"><i class="fa fa-envelope"></i><div class="count_mess"></div></button>
                      <button type="button" class="btn btn-default"><i class="fa fa-tasks"></i><div class="count_task"><?php $info = calc_message('task'); if($info > 0): ?><div class="mess_count"><?php echo $info; ?></div><?php endif; ?></div></button>
                      <button type="button" class="btn btn-default"><i class="fa fa-unlock-alt"></i></button>
                      <button type="button" class="btn btn-default"><i class="fa fa-times"></i></button>
                    </div>
           
                </div> <!-- /.profile -->
                <div class="clearfix"></div>
                <div class="h10"></div>
                
                <div class="liner"></div>
                
                <div class="searchbox">
                	<div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-search"></i></span>
                      <input type="text" class="form-control" placeholder="arama kutusu...">
                    </div>
                </div> <!-- /.searchbox -->
                
                <div class="liner"></div>
                
                <ul class="nav nav-pills nav-stacked nav-bracket">
                    <li class="active_"><a href="<?php echo site_url(''); ?>"><i class="fa fa-home"></i> <span>Yönetim Paneli</span></a></li>
                    <li class="nav-parent active_product"><a href="" class="menu-parent"><i class="fa fa-share-square-o"></i> <span>Stok Yönetimi</span> <span class="naviicon"><i class="fa fa-plus"></i></span></a>
                      <ul style="display: none;" class="children">
                        <li><a href="<?php echo site_url('product'); ?>"><i class="fa fa-caret-right"></i> Stok Yönetimi</a></li>
                        <li><a href="<?php echo site_url('product/add'); ?>"><i class="fa fa-caret-right"></i> Yeni Stok Kartı</a></li>
                        <li><a href="<?php echo site_url('product/lists'); ?>"><i class="fa fa-caret-right"></i> Stok Kartları</a></li>
                        <li><a href="<?php echo site_url('product/options'); ?>"><i class="fa fa-caret-right"></i> Seçenekler</a></li>
                      </ul>
                    </li>
                    <li class="nav-parent active_account"><a href="" class="menu-parent"><i class="fa fa-users"></i> <span>Hesap Yönetimi</span> <span class="naviicon"><i class="fa fa-plus"></i></span></a>
                      <ul style="display: none;" class="children">
                        <li><a href="<?php echo site_url('account'); ?>"><i class="fa fa-caret-right"></i> Hesap Yönetimi</a></li>
                        <li><a href="<?php echo site_url('account/add'); ?>"><i class="fa fa-caret-right"></i> Yeni Hesap Kartı</a></li>
                        <li><a href="<?php echo site_url('account/lists'); ?>"><i class="fa fa-caret-right"></i> Hesap Kartları</a></li>
                        <li><a href="<?php echo site_url('account/options'); ?>"><i class="fa fa-caret-right"></i> Seçenekler</a></li>
                      </ul>
                    </li>
                    <li class="nav-parent active_form"><a href="" class="menu-parent"><i class="fa fa-external-link"></i> <span>Formlar &amp; Satış</span> <span class="naviicon"><i class="fa fa-plus"></i></span></a>
                      <ul style="display: none;" class="children">
                        <li><a href="<?php echo site_url('form'); ?>"><i class="fa fa-caret-right"></i> Form Yönetimi</a></li>
                        <li><a href="<?php echo site_url('form/view/0?out'); ?>"><i class="fa fa-caret-right"></i> Yeni Satış Formu</a></li>
                        <li><a href="<?php echo site_url('form/view/0?in'); ?>"><i class="fa fa-caret-right"></i> Yeni Alış Formu</a></li>
                        <li><a href="<?php echo site_url('form/lists'); ?>"><i class="fa fa-caret-right"></i> Form Listesi</a></li>
                      </ul>
                    </li>
                    <li class="nav-parent active_payment"><a href="" class="menu-parent"><i class="fa fa-archive"></i> <span>Kasa &amp; Nakit</span> <span class="naviicon"><i class="fa fa-plus"></i></span></a>
                      <ul style="display: none;" class="children">
                        <li><a href="<?php echo site_url('payment'); ?>"><i class="fa fa-caret-right"></i> Kasa Yönetimi</a></li>
                        <li><a href="<?php echo site_url('payment/add/?in'); ?>"><i class="fa fa-caret-right"></i> Tahsilat</a></li>
                        <li><a href="<?php echo site_url('payment/add/?out'); ?>"><i class="fa fa-caret-right"></i> Ödeme</a></li>
                        <li><a href="<?php echo site_url('payment/lists'); ?>"><i class="fa fa-caret-right"></i> Ödeme & Tahsilat</a></li>
                      </ul>
                    </li>
                    <li class=""><a href="tables.html"><i class="fa fa-th-list"></i> <span>Kasa &amp; Nakit</span></a></li>
                    <li><a href="maps.html"><i class="fa fa-map-marker"></i> <span>Eklentiler</span></a></li>
                    <li class="nav-parent"><a href="" class="menu-parent"><i class="fa fa-file-text"></i> <span>Ayarlar</span></a>
                      <ul style="display: none;" class="children">
                        <li><a href="calendar.html"><i class="fa fa-caret-right"></i> Calendar</a></li>
                        <li><a href="media-manager.html"><i class="fa fa-caret-right"></i> Media Manager</a></li>
                        <li><a href="timeline.html"><i class="fa fa-caret-right"></i> Timeline</a></li>
                        <li><a href="blog-list.html"><i class="fa fa-caret-right"></i> Blog List</a></li>
                        <li><a href="blog-single.html"><i class="fa fa-caret-right"></i> Blog Single</a></li>
                        <li><a href="people-directory.html"><i class="fa fa-caret-right"></i> People Directory</a></li>
                        <li><a href="profile.html"><i class="fa fa-caret-right"></i> Profile</a></li>
                        <li><a href="invoice.html"><i class="fa fa-caret-right"></i> Invoice</a></li>
                        <li><a href="search-results.html"><i class="fa fa-caret-right"></i> Search Results</a></li>
                        <li><a href="blank.html"><i class="fa fa-caret-right"></i> Blank Page</a></li>
                        <li><a href="notfound.html"><i class="fa fa-caret-right"></i> 404 Page</a></li>
                        <li><a href="locked.html"><i class="fa fa-caret-right"></i> Locked Screen</a></li>
                        <li><a href="signin.html"><i class="fa fa-caret-right"></i> Sign In</a></li>
                        <li><a href="signup.html"><i class="fa fa-caret-right"></i> Sign Up</a></li>
                      </ul>
                    </li>
                    
                  </ul>
                  
                  <script>
                  $('.children').hide();
                  
                  $('.nav-parent a.menu-parent').click(function() {
                      
                      if($(this).parent().hasClass('nav-active')) 
                      {
                          $(this).parent().removeClass('nav-active');
                          $(this).parent().find('.children').hide('blonde');
                          $(this).find('.naviicon .fa').removeClass('fa-minus');
                          $(this).find('.naviicon .fa').addClass('fa-plus');
                          return false;
                      }
                      else
                      {
                          $('.children').hide('blonde');
                          $('.naviicon .fa').removeClass('fa-minus');
                          $('.naviicon .fa').addClass('fa-plus');
                          $('.nav-parent').removeClass('nav-active');
                          
                          $(this).parent().addClass('nav-active');
                          $(this).parent().find('.children').show('blonde');
                          $(this).find('.naviicon .fa').removeClass('fa-plus');
                          $(this).find('.naviicon .fa').addClass('fa-minus');
                          return false;
                      }
                  });
                  </script>
        		
                
                
                <div class="h10"></div>
                <div class="liner"></div>
				        <div class="h10"></div>
                
                <div class="row no-space">
                  <div class="col-md-6">
                    <div>
                        <div class="exchange">
                            <i class="fa fa-usd text-success"></i><div class="value"><span class="text-danger">1,890<small>.49 </small></span></div>
                            <div class="title">USD KURU</div>
                        </div>
                    </div>
                  </div> <!-- /.col-md-6 -->
                  <div class="col-md-6">
                    <div>
                        <div class="exchange">
                            <i class="fa fa-euro text-primary"></i><div class="value"><span class="text-danger">2,369<small>.20 </small></span></div>
                            <div class="title">EURO KURU</div>
                        </div>
                    </div>
                  </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->


                <div class="row no-space">
                  <div class="col-md-6">
                    <div class="exchange">
                        <i class="fa fa-flash text-warning"></i><div class="value"><span class="text-danger"><span class="1kisi">0</span><small>KB</small></span></div>
                        <div class="title">1 KİŞİ BAĞLANDI</div>
                    </div>
                  </div> <!-- /.col-md-6 -->
                  <div class="col-md-6">
                    <div class="exchange">
                        <i class="fa fa-flash text-warning"></i><div class="value"><span class="text-danger"><span class="10kisi">0</span><small>MB</small></span></div>
                        <div class="title">10 KİŞİ BAĞLANDI</div>
                    </div>
                  </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->


                <div class="row no-space">
                  <div class="col-md-6">
                    <div class="exchange">
                        <i class="fa fa-flash text-warning"></i><div class="value"><span class="text-danger"><span class="100kisi">0</span><small>MB</small></span></div>
                        <div class="title">100 KİŞİ BAĞLAN</div>
                    </div>
                  </div> <!-- /.col-md-6 -->
                  <div class="col-md-6">
                    <div class="exchange">
                        <i class="fa fa-flash text-warning"></i><div class="value"><span class="text-danger"><span class="1000kisi">0</span><small>GB</small></span></div>
                        <div class="title">1000 KİŞİ BAĞLAN</div>
                    </div>
                  </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->


                

                
            </div> <!-- /.sidebar -->
        </div> 
        <div class="col-md-10 content-arena">
    
    
    
<script>
$(document).ready(function(e) {
  $('.active_<?php echo $this->uri->segment(1); ?>').addClass('active');
	$('.active_<?php echo $this->uri->segment(1); ?> a').click();
});
</script>










<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <?php if(@$navigation): ?>
    <?php foreach($navigation as $nav): ?>
          <?php echo $nav; ?>  
      <?php endforeach; ?>
  <?php else: ?>
    <li class="active">Menü Yolu Bulunamadı</li>
  <?php endif; ?>
</ol>



<?php if(@$messages): ?>
  <?php foreach($messages as $message): ?>
        


        <div class="alert alert-block alert-<?php echo $message['class']; ?> fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php if(isset($message['title'])): ?><h4><?php echo $message['title']; ?></h4><?php endif; ?>
            <?php if(isset($message['description'])): ?><p><?php echo $message['description']; ?></p><?php endif; ?>
        </div>
              
        
    <?php endforeach; ?>
<?php endif; ?>