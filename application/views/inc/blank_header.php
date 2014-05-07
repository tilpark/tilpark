<?php
if($this->session->userdata('login') == false)
{
	redirect('user/login');
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TilPark! Açık Kaynak Kodlu Stok Takip ve Cari Otomasyonu</title>
<meta name="description" content="Bootstrap">


<!-- Included CSS Files (Compressed) -->

<link href="<?php echo base_url('theme/css/bootstrap-glyphicons.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('theme/css/bootstrap.css'); ?>">

<link rel="stylesheet" href="<?php echo base_url('theme/css/datepicker.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('theme/js/dataTable/css/TableTools.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('theme/css/app.css'); ?>">


<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('theme/js/jquery.js'); ?>"></script>
<script src="<?php echo base_url('theme/js/bootstrap.js'); ?>"></script> 
<script src="<?php echo base_url('theme/js/jquery.validation.js'); ?>"></script> 

<script src="<?php echo base_url('theme/js/bootstrap-datepicker.js'); ?>"></script> 


<script src="<?php echo base_url('theme/js/jquery.dataTables.js'); ?>"></script> 
<script src="<?php echo base_url('theme/js/dataTable/js/ZeroClipboard.js'); ?>"></script> 
<script src="<?php echo base_url('theme/js/dataTable/js/TableTools.js'); ?>"></script>

<!-- Initialize JS Plugins -->
<script src="<?php echo base_url('theme/js/app.js'); ?>"></script>


</head>
<body style="background:#FFF;">

