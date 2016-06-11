<?php include('functions.php'); ?>
<?php db()->query("INSERT INTO deneme (deneme) VALUES ('xxx-".@json_encode($_GET)."')"); ?>
<?php
  $columns = array('name', 'code', 'p_sale', 'p_purchase', 'tax_rate');





  $col = 'id';
  foreach($columns as $column)
  {
    $col.=','.$column;
  }
?>
{
  "data": [
    <?php
    $query = db()->query("SELECT ".$col." FROM ".dbname('products')." WHERE status='1' AND name LIKE '%".@$_GET['sSearch']."%' LIMIT 100"); ?>

    [
      "<?php echo @$_GET['sSearch']; ?>",
      "System Architect",
      "Edinburgh",
      "5421",
      "2011/04/25",
      "$320,800"
    ]
    <?php while($list = $query->fetch_assoc()): ?>
    
    ,[
      "<?php echo $list['code']; ?>",
      "Accountant",
      "Tokyo",
      "8422",
      "2011/07/25",
      "$170,750"
    ]
  <?php endwhile; ?>
    
  ]
}
