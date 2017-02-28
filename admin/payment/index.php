<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Kasa/Banka' );
add_page_info( 'nav', array('name'=>'Kasa/Banka') );
?>


<div class="row">
	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading">Kasalar</div>
			<div class="panel-body">
				<?php if($cases = get_case_all(array('is_bank'=>0))): ?>
					<div class="row space-5">
						<?php foreach($cases as $case): ?>

								<div class="col-md-3">
									<div class="widget-menu">
										<a href="case.php?status_id=<?php echo $case->id; ?>">
											<span class="count fs-16"><?php echo $case->name; ?></span>
											<h3><?php echo get_set_money($case->total,true); ?></h3>
										</a>
									</div> <!-- /.widget-menu -->
								</div> <!-- /.col-md-3 -->

						<?php endforeach; ?>
					</div> <!-- /.row -->
				<?php else: ?>
					<?php echo get_alert('Kasa hesabı bulunamadı.', 'warning', false); ?>
				<?php endif; ?>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->
		
	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading">Bankalar</div>
			<div class="panel-body">
				<?php if($banks = get_case_all(array('is_bank'=>1))): ?>
					<div class="row space-5">
						<?php foreach($banks as $bank): ?>

								<div class="col-md-3">
									<div class="widget-menu">
										<a href="case.php?status_id=<?php echo $bank->id; ?>">
											<span class="count fs-16"><?php echo $bank->name; ?></span>
											<h3><?php echo get_set_money($bank->total,true); ?></h3>
										</a>
									</div> <!-- /.widget-menu -->
								</div> <!-- /.col-md-3 -->

						<?php endforeach; ?>
					</div> <!-- /.row -->
				<?php else: ?>
					<?php echo get_alert('Banka hesabı bulunamadı.', 'warning', false); ?>
				<?php endif; ?>
			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->
		
	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->




<?php get_footer(); ?>