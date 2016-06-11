<?php include('../../functions.php'); ?>
<?php
if(isset($_GET['select_item'])){ $select_item = @$_GET['select_item']; } else { $select_item = "*"; }

$query = db()->query("SELECT ".$select_item." FROM ".dbname('accounts')." WHERE status='1' AND (name LIKE '%".$_GET['search_text']."%' OR code LIKE '%".$_GET['search_text']."%') LIMIT 100");
$return = '';
?>
<?php if($query->num_rows > 0): ?>
<?php while($list = $query->fetch_assoc()): ?>
	<?php $list['balance'] = convert_money($list['balance']); ?>
	<?php $return[] = $list; ?>
<?php endwhile; ?>

<?php echo json_encode($return); ?>
<?php endif; ?>