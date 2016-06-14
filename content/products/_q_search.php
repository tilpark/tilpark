<?php include('../../functions.php'); ?>
<?php


$where['query'] = "status='1'";
if(isset($_GET['search_text']))
{
	$where['search_text'] = $_GET['search_text'];
	$where['query'].=" AND name LIKE '%".$where['search_text']."%' ";
}


# pagination icin tum verilerin sayisini hesapliyoruz, "->num_rows"
$query_count = db()->query("SELECT id FROM ".dbname('products')." WHERE ".$where['query']." ORDER BY date DESC");
# veritabani sorgusu
$query = db()->query("SELECT * FROM ".dbname('products')." WHERE ".$where['query']." ORDER BY id ASC LIMIT ".(($til->pg->page-1)*$til->pg->limit_list).",".$til->pg->limit_list."");
?>

<?php if($query->num_rows > 0): ?>

	<table class="table table-hover table-bordered table-condensed">
		<thead>
			<tr>
				<th width="80">Ürün ID</th>
				<th width="100">Tarih</th>
				<th width="500">Ürün Kodu</th>
				<th width="500">Ürün Adı</th>
				<th class="text-right">Satış Fiyatı</th>
			</tr>
		</thead>
		<tbody>
			<?php while($list = $query->fetch_object()): ?>
			<tr>
				<td>#<a href="detail.php?id=<?php echo $list->id; ?>"><?php echo $list->id; ?></a></td>	
				<td><?php echo substr($list->date,0,16); ?></td>
				<td><?php echo $list->code; ?></td>
				<td><?php echo $list->name; ?></td>
				<td class="text-right"><?php echo convert_money($list->p_sale, array('icon'=>true)); ?>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>


	<div class="text-center"><?php til_pagination($query_count->num_rows); ?></div>			

<?php else: ?>
	<?php echo get_alert('Listelenecek sipariş bulunamadı.'); ?>
<?php endif; ?>