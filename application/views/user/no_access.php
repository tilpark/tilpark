<div class="alert alert-danger alert-success fade in">     
	<h2><?php lang('No Access'); ?></h2> 
    <p></p>
    <p><?php lang('You are not authorized to access this page.'); ?></p>
    <p><?php lang('Minimum access'); ?>: <strong><?php echo get_role_name($role); ?></strong></p>           
</div>