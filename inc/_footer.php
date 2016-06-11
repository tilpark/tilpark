







</div>

</div>  <!-- / #wrapper -->



<footer>
	<div class="container-fluidd">
		<div class="footer-bar">
			<p class="text-muted pull-left">2016 Tilpark inc.</p>
			<p class="pull-right"><?php echo convert_bayt(memory_get_usage()); ?>	</p>
		</div> <!-- /.container -->
	</div> <!-- /.container-fluid -->
</footer>

<?php global $breadcrumb; if(!empty($breadcrumb)){ add_breadcrumb($breadcrumb); }?>


</body>
</html>



