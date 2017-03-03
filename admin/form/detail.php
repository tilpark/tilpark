<?php include('../../tilpark.php'); ?>
<?php 
if($form = get_form(@$_GET['id'])) {

} else {
	$form = new StdClass;
}

// eger payment->type yok ise ve GET metodu ile type degeri gelmis ise
if(!isset($payment->type)) {
	if(isset($_GET['type'])) {
		$payment->type = $_GET['type'];
	}
}

// eger detail-TYPE.php sayfasi var goster yokse "detail-payment.php" goster
if(file_exists('detail-'.$form->type.'.php')) {
	include('detail-'.$form->type.'.php'); 
	return false;
} else {
	include('detail-form.php');
	return false;
}
?>