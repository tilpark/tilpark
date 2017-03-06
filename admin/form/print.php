<?php require_once('../../tilpark.php'); ?>
<?php 
if(isset($_GET['id'])) {
	if(!$form = get_form($_GET['id'])) {

	}
}
?>
<?php include_content_page('print', @$form->template, 'form', array('form'=>@$form)); ?>	