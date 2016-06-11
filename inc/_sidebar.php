
		




<?php
$explode = explode('/content/',$_SERVER['SCRIPT_NAME']);
if(isset($explode[1])){ $explode = str_replace('.php', '', str_replace('/', '-', $explode[1])); } else { $explode = 'home-index';}
?>
<script>
$(document).ready(function() {
	$('.sidebar-menu li').removeClass('active');
	$('.sidebar-menu li.<?php echo $explode; ?> a').click();
	$('.sidebar-menu li.<?php echo $explode; ?>').addClass('active');
});
</script>






<ol class="breadcrumb">
  <li><a href="<?php site_url(); ?>"><i class="fa fa-home"></i> Yönetim Paneli</a></li>
</ol>