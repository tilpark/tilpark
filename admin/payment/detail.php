<?php include('../../tilpark.php'); ?>
<?php
if(isset($_GET['id'])) {
	if($payment = get_payment(@$_GET['id'])) {
		
	}
} else {
	$payment = new StdClass;
}


// eger payment->type yok ise ve GET metodu ile type degeri gelmis ise
if(!isset($payment->template)) {
	if(isset($_GET['template'])) {
		$payment->template = $_GET['template'];
	} else { $payment->template = ''; }
}


include_content_page('detail', $payment->template, 'payment', array('payment'=>$payment));
?>