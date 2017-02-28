<?php include('../../tilpark.php'); ?>

<?php 
if($accounts = get_accounts(array('_GET'=>true,'limit'=>5))) {
	if($accounts->display_num_rows > 0) {
		unset($accounts->num_rows);
		unset($accounts->display_num_rows);

		echo json_encode_utf8($accounts->list);
	} else {
		return false;
	}
} else {
	return false;
}
?>