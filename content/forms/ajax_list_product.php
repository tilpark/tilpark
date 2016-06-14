<?php include('../../functions.php'); ?>

<?php if(strlen($_GET['q']) > 2 ): ?>

	<?php
	$q = trim(mysql_real_escape_string($_GET['q']));
	if(isset($_GET['name']))
	{
		$query = db()->query("SELECT * FROM ".dbname('products')." WHERE name LIKE '%".$q."%' AND status='1' LIMIT 3");
	}
	elseif(isset($_GET['code']))
	{
		$query = db()->query("SELECT * FROM ".dbname('products')." WHERE code LIKE '%".$q."%' AND status='1' LIMIT 3");
	}
	?>

	<?php if($query->num_rows > 0): ?>
		<ul class="ajax-list-product">
			<?php while($list = $query->fetch_assoc()): ?>
				<?php
				$search_name 	= str_replace($q, '<strong>'.$q.'</strong>', $list['name']);
				$search_code 	= str_replace($q, '<strong>'.$q.'</strong>', $list['code']);
				$search_price 	= str_replace($q, '<strong>'.$q.'</strong>', $list['p_sale']);

				?>
				<li>
					<a href="#" class="typeahead-list-item"
						attr-id="<?php echo $list['id']; ?>"
						attr-code="<?php echo $list['code']; ?>"
						attr-name="<?php echo $list['name']; ?>"
						attr-p_purchase="<?php echo convert_money($list['p_purchase']); ?>"
						attr-p_sale="<?php echo convert_money($list['p_sale']); ?>"
						attr-tax_rate="<?php echo $list['tax_rate']; ?>"
						attr-p_sale_out_tax="<?php echo convert_money($list['p_sale_out_tax']); ?>"
						attr-p_purchase_out_tax="<?php echo convert_money($list['p_purchase_out_tax']); ?>"
						attr-description="<?php echo $list['description']; ?>"
						attr-quantity="<?php echo $list['quantity']; ?>"
						>
						<span class="typeahead-account_name fs-14"><?php echo $search_name; ?></span>
						<span class="typeahead-account_phone text-muted fs-12"><?php echo $search_code; ?></span>
						<span class="typeahead-account_city text-muted fs-12"><?php echo convert_money($search_price); ?></span>
						<div class="clearfix"></div>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>

		<script>
		$(document).ready(function(){


			$('.typeahead-list-item').click(function() {
				$('#product_id').val($(this).attr('attr-id'));
				$('#product_code').val($(this).attr('attr-code'));
				$('#product_name').val($(this).attr('attr-name'));
				$('#p_sale').val($(this).attr('attr-p_sale'));
				$('#tax_rate').val($(this).attr('attr-tax_rate'));

				if($('#quantity').val() == ''){ $('#quantity').val(1);}

				$('#p_sale').focus();
				$('#quantity').keyup();
				$('#quantity').focus();



			});






		});
		</script>
	<?php endif; ?>
<?php endif; ?>
