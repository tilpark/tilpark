<?php include('../../tilpark.php'); ?>
<?php 
if($form = get_form(@$_GET['id'])) {

} else {
	$form = new StdClass;
}

// eger payment->type yok ise ve GET metodu ile type degeri gelmis ise
if(!isset($form->template)) {
	if(isset($_GET['template'])) {
		$form->template = $_GET['template'];
	}
}


include_content_page('detail', @$form->template, 'form', array('form'=>$form));
?>