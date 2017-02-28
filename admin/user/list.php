<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Tüm Kullanıcılar' );
add_page_info( 'nav', array('name'=>'Tüm Kullanıcılar') );
?>

<?php
	$users = get_users();
?>

<table class="table table-hover table-condensed dataTable">
	<thead>
		<tr>
			<th width="10"></th>
			<th>E-Posta</th>
			<th>Ad Soyad</th>
			<th>Cep Telefonu</th>
			<th>Yetki</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $list): ?>
			<tr>
				<td>
					<a href="<?php site_url('admin/user/user.php'); ?>?id=<?php echo $list->id; ?>">
						<img src="<?php echo get_user_info($list->id, 'avatar'); ?>" class="img-responsive" width="32">
					</a>
				</td>
				<td><a href="<?php site_url('admin/user/user.php'); ?>?id=<?php echo $list->id; ?>"><?php echo $list->username; ?></a></td>
				<td><?php echo $list->name; ?> <?php echo $list->surname; ?></td>
				<td><?php echo $list->gsm; ?></td>
				<td><?php echo get_user_role_text($list->role); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>






<?php get_footer(); ?>