<ol class="breadcrumb">
	<li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
	<li><a href="<?php echo site_url('payment'); ?>">Kasa</a></li>
    <li><a href="<?php echo site_url('payment/lists'); ?>">Ödeme Listesi</a></li>
	<li class="active">
		<?php if($form['in_out'] == 'in'): ?>
            Tahsilat
        <?php else: ?>
            Ödeme
        <?php endif; ?>
        #<?php echo $form['id']; ?>
    </li>
</ol>


<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#transactions" data-toggle="tab">İşlemler</a></li>
    <li class=""><a href="#history" data-toggle="tab">Geçmiş</a></li>
    <li class="dropdown">
		<a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown">Seçenekler <b class="caret"></b></a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
			<li><a href="<?php echo site_url('user/new_message/?invoice_id='.$form['id']); ?>"><span class="glyphicon glyphicon-envelope mr9"></span><?php lang('New Message'); ?></a></li>
            <li><a href="<?php echo site_url('user/new_task/?invoice_id='.$form['id']); ?>"><span class="glyphicon glyphicon-globe mr9"></span><?php lang('New Task'); ?></a></li>
            
            <li class="divider"></li>
        	<li><a href="javascript:;" onclick="print_barcode();"><span class="glyphicon glyphicon-print mr9"></span><?php lang('Print Invoice'); ?></a></li>
            
            <?php if(get_the_current_user('role') <= 3): ?>
                <li class="divider"></li>
                <?php if($form['status'] == '1'): ?>
                    <li><a href="?status=0"><span class="glyphicon glyphicon-remove mr9"></span><?php lang('Delete'); ?></a></li>
                <?php else: ?>
                    <li><a href="?status=1"><span class="glyphicon glyphicon-remove mr9"></span><?php lang('Activate'); ?></a></li>
                <?php endif; ?>
            <?php endif; ?>
      </ul>
    </li>
</ul>


<div id="myTabContent" class="tab-content">

<div class="tab-pane fade active in" id="transactions">

<div class="row">
<div class="col-md-12">

	<div class="h20"></div>
	<div class="center-block">
    	<div class="panel-form">
        	<div class="panel-body-heading bordered">
            	<h3><?php if($form['in_out'] == 'in'): ?>Tahsilat<?php else: ?>Ödeme<?php endif; ?> Formu #<?php echo $form['id']; ?> <small><?php echo $form['name']; ?></small> <small class="pull-right fs-12"><?php echo substr($form['date'],0,10); ?></small></h3>
                
            </div>
            
            <div class="h20"></div>
            <div>
            	<address>
                  <strong><?php echo $form['name_surname']; ?></strong><br>
                  <?php echo $form['address']; ?><br>
                  <?php echo $form['county']; ?> <?php echo $form['city']; ?><br>
                  <abbr title="Phone">Tel:</abbr> <?php echo $form['gsm']; ?>
                </address>
                <div class="h20"></div>
                <table class="table table-bordered">
                	<thead>
                    	<tr>
                        	<th width="100">İŞLEM</th>
                            <th width="150">İŞLEM NO</th>
                            <th width="300">BANKA ADI</th>
                            <th>ŞUBE</th>
                            <th>VADE TARİHİ</th>
                            <th>TOPLAM</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<tr>
                        	<td><?php echo get_text_payment_type($form['val_1']); ?></td>
                            <td><?php echo $form['val_4']; ?></td>
                            <td><?php echo $form['val_2']; ?></td>
                            <td><?php echo $form['val_3']; ?></td>
                            <td><?php if($form['val_date'] > 0): ?><?php echo substr($form['val_date'],0,10); ?><?php endif; ?></td>
                            <td class="text-right"><?php echo get_money($form['grand_total']); ?> <i class="fa fa-try"></i></td>
                        </tr>
                    </tbody>
                </table>
                
                <?php if($form['description'] != ''): ?>
                    <div class="h20"></div>
                    <div>
                    	<i class="fa fa-quote-left"></i> AÇIKLAMA: <span class="text-muted"><?php echo $form['description']; ?></span>
                    </div>
                <?php endif; ?>
                
                <div class="h20"></div>
                <div class="text-right text-muted">
                	<?php $user = get_user($form['user_id']); ?>
                	Bu işlemler <?php echo $user['name']; ?> <?php echo $user['surname']; ?> tarafından yapılmıştır.
                </div>
                
            </div>
        </div> <!-- /.panel -->
    </div> <!-- /.text-center -->


</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->

<div class="h20"></div>



</div> <!-- /#transactions -->





<div class="tab-pane fade in" id="history">
	<?php get_log_table(array('form_id'=>$form['id']), 'ASC'); ?>
</div> <!-- #history -->

</div> <!-- /#myTabContent -->

<?php calc_account_balance($form['account_id']); ?>