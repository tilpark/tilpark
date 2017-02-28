<?php include('../../tilpark.php'); ?>

<?php 
if($items = db()->query("SELECT * FROM ".dbname('users')." WHERE name LIKE '%".@$_GET['s']."%' ORDER BY id ASC LIMIT 5 ")) {
	if($items->num_rows > 0) {
		$deneme = array();
		while($item = $items->fetch_object()) {
			$deneme[$item->id] = $item;
		}
		echo json_encode_utf8($deneme);
	} else {
		return false;
	}
} else {
	return false;
}
?>