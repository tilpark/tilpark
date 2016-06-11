<?php include('../../functions.php'); ?>

<?php if(strlen($_GET['q']) > 2 ): ?>

	<?php
	$q = trim(mysql_real_escape_string($_GET['q']));
	if(isset($_GET['name']))
	{
		$query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE name LIKE '%".$q."%' AND status='1' LIMIT 3");
	}
	elseif(isset($_GET['gsm']))
	{
		$q = clean_character($q, 'gsm');
		$query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE gsm LIKE '%".$q."%' AND status='1' LIMIT 3");
	}
	elseif(isset($_GET['phone']))
	{
		$q = clean_character($q, 'phone');
		$query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE phone LIKE '%".$q."%' AND status='1' LIMIT 3");
	}
	elseif(isset($_GET['tax_no']))
	{
		$query = db()->query("SELECT * FROM ".dbname('accounts')." WHERE tax_no LIKE '%".$q."%' AND status='1' LIMIT 3");
	}
	
	?>

	<?php if($query->num_rows > 0): ?>
		<table class="table table-hover table-bordered table-condensed table-striped">
			<?php while($list = $query->fetch_assoc()): ?>
				<?php
				$search_name 	= str_replace($q, '<strong>'.$q.'</strong>', $list['name']);
				if(isset($_GET['phone'])) { $search_gsm 	= str_replace($q, '<strong>'.$q.'</strong>', $list['phone']); }
					else { $search_gsm 	= str_replace($q, '<strong>'.$q.'</strong>', $list['gsm']);  }
				
				$search_city 	= str_replace($q, '<strong>'.$q.'</strong>', $list['city']);
				
				?>
				<tr>
					<td>
						<a href="#" class="typeahead-list-item"
							attr-id="<?php echo $list['id']; ?>"
							attr-code="<?php echo $list['code']; ?>"
							attr-name="<?php echo $list['name']; ?>"
							attr-personnel_name="<?php echo $list['personnel_name']; ?>"
							attr-gsm="<?php echo $list['gsm']; ?>"
							attr-phone="<?php echo $list['phone']; ?>"
							attr-address="<?php echo $list['address']; ?>"
							attr-city="<?php echo $list['city']; ?>"
							attr-district="<?php echo $list['district']; ?>"
							attr-balance="<?php echo $list['balance']; ?>"
							attr-tax_home="<?php echo $list['tax_home']; ?>"
							attr-tax_no="<?php echo $list['tax_no']; ?>"
							title="<?php echo $list['address']; ?> <?php echo $list['district']; ?>/<?php echo $list['city']; ?>"
							>
							<span class="typeahead-account_name fs-14"><?php echo $search_name; ?></span>
							<span class="typeahead-account_phone text-muted fs-12"><?php echo $search_gsm; ?></span>
							<span class="typeahead-account_city text-muted fs-12"><?php echo $search_city; ?></span>
							<div class="clearfix"></div>
						</a>
					</td>
				</tr>
			<?php endwhile; ?>
		</table>

		<script>
		$(document).ready(function(){
			$('.typeahead-list-item').click(function() {
				$('#account_id').val($(this).attr('attr-id'));
				$('#account_code').val($(this).attr('attr-code'));
				$('#account_name').val($(this).attr('attr-name'));
				$('#account_gsm').val($(this).attr('attr-gsm'));
				$('#account_phone').val($(this).attr('attr-phone'));
				$('#account_address').val($(this).attr('attr-address'));
				$('#account_city').val($(this).attr('attr-city'));
				$('#account_district').val($(this).attr('attr-district'));
				$('#account_tax_home').val($(this).attr('attr-tax_home'));
				$('#account_tax_no').val($(this).attr('attr-tax_no'));

				$('#account_gsm').focus();
				$('#account_phone').focus();
				$('#product_code').focus();


			});
		});
		</script>
	<?php endif; ?>
<?php endif; ?>