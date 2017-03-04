<?php include('../../tilpark.php'); ?>

<?php if(isset($_GET['id'])): ?>
	<?php if(!$payment = get_payment($_GET['id'])) { exit('odeme formu bulunamadı.'); } ?>
<?php else: exit('odeme id gerekli'); endif; ?>

<?php
include_content_page('print', $payment->template, 'payment', array('payment'=>$payment));
?>





<?php if(isset($_GET['print'])): ?>
	<script>
		setTimeout(function () { window.print(); }, 500);
		setTimeout(function () { window.close(); }, 500);
	</script>
<?php endif; ?>









