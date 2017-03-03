<?php include('../../tilpark.php'); ?>
<?php
if(isset($_GET['id'])) {
	if($payment = get_payment(@$_GET['id'])) {
		
	}
} else {
	$payment = new StdClass;
}


// eger payment->type yok ise ve GET metodu ile type degeri gelmis ise
if(!isset($payment->type)) {
	if(isset($_GET['type'])) {
		$payment->type = $_GET['type'];
	}
}

// eger detail-TYPE.php sayfasi var goster yokse "detail-payment.php" goster
if(file_exists('detail-'.$payment->type.'.php')) {
	include('detail-'.$payment->type.'.php'); 
	return false;
} else {
	include('detail-payment.php');
	return false;
}

?>