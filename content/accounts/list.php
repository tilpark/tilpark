<?php include('../../functions.php'); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<?php
// Header Bilgisi
$breadcrumb[0] = array('name'=>'Hesap Yönetimi', 'url'=>get_site_url('content/accounts/'));
$breadcrumb[1] = array('name'=>'Hesap Kartları', 'url'=>'', 'active'=>true);
?>





<div class="panel panel-default">
	<div class="panel-heading"><i class="fa fa-list"></i> Hesap Kartları</div>
	<div class="panel-body">

		<table class="table table-hover table-condensed table-striped tilTable" id="testTable">
			<thead>
				<tr>
					<th>Hesap Kodu</th>
					<th>Hesap Kartı</th>
					<th>Gsm</th>
					<th>İl/İlçe</th>
					<th>Bakiye</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>

	</div> <!-- /.panel-body -->
</div> <!-- /.panel-default -->


<?php
$array['limit'] = 20;
$array['select_item'] = 'id,name,code,gsm,city,district,balance';
tilTable($array);
?>
<script>
$(document).ready(function() {

	function table_keyup() {
		var search_text = $('#table_search').val();
		var limit = '<?php echo $array['limit']; ?>';

		$.getJSON( "_q_search.php?search_text="+ search_text +"&select_item=<?php echo $array['select_item']; ?>", function( data ) {

			$('.table tbody').html('');
			for(var i = 0; i < data.length; i++) {
				if(i < limit){

					var row = $('<tr></tr>');
						row.append($('<td><a href="detail.php?id='+data[i].id+'">'+data[i].code+'</a></td>'));
						row.append($('<td><a href="detail.php?id='+data[i].id+'">'+data[i].name+'</a></td>'));
						row.append($('<td></td>').text(data[i].gsm));
						row.append($('<td></td>').text(data[i].city));
						row.append($('<td class="text-right"></td>').text(data[i].balance));

						$('.table tbody').stop().append(row);	
				}
			}
		});
	}

	$('#table_search').keyup(function() { table_keyup(); });
	
	table_keyup();
});
</script>





<?php get_footer(); ?>