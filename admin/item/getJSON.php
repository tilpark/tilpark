<?php include('../../tilpark.php'); ?>

<?php 
if($items = get_items(array('_GET'=>true,'limit'=>5))) {
	if($items->display_num_rows > 0) {
		unset($items->num_rows);
		unset($items->display_num_rows);

		echo json_encode_utf8($items->list);
	} else {
		return false;
	}
} else {
	return false;
}
?>