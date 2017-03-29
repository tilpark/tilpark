	<div class="print-footer print-footer-left">
		<small class="text-muted"><img src="<?php site_url('content/themes/default/img/logo_header.png'); ?>" class="img-responsive pull-left" width="64"> açık kaynak yazılımlar.</small>
	</div>

</div> <!-- page-print -->


<?php if(isset($_GET['print'])): ?>
	<script>
		// setTimeout(function () { window.print(); }, 500);
		// setTimeout(function () { window.close(); }, 500);
	</script>
<?php endif; ?>