<?php include('../../../tilpark.php'); ?>
<?php get_header(); ?>
<?php


$_taxonomy 	= 'til_fs_form';
$_name 		= 'Form';
$_in_out	= true;
$_sms_template	= true;
$_email_template = true;
$_color			= true;
$_bg_color		= true;
if(isset($_GET['taxonomy'])) {
	if(is_form_status($_GET['taxonomy'])) {
		$_taxonomy 		= til()->form_status[$_GET['taxonomy']]['taxonomy'];
		$_name			= til()->form_status[$_GET['taxonomy']]['name'];
		$_in_out		= til()->form_status[$_GET['taxonomy']]['in_out'];
		$_sms_template	= til()->form_status[$_GET['taxonomy']]['sms_template'];
		$_email_template 	= til()->form_status[$_GET['taxonomy']]['email_template'];
		$_color				= til()->form_status[$_GET['taxonomy']]['color'];
		$_bg_color			= til()->form_status[$_GET['taxonomy']]['bg_color'];
	} else { echo get_alert('Form durum türü bulunamadı.', 'danger'); exit; }
} 

add_page_info( 'title', $_name.' Durumları' );
add_page_info( 'nav', array('name'=>'Seçenekler', 'url'=>get_site_url('admin/system/') ) );
add_page_info( 'nav', array('name'=>'Form Durum Yönetimi', 'url'=>get_site_url('admin/system/form_status') ) );
?>


	<?php if(isset($_GET['detail'])): ?>
		<?php include('_detail.php'); ?>
	<?php else: ?>
		<?php include('_add.php'); ?>
	<?php endif; ?>



<?php get_footer(); ?>