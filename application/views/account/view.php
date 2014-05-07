<ol class="breadcrumb">
  <li><a href="<?php echo site_url(); ?>"><?php lang('Dashboard'); ?></a></li>
  <li><a href="<?php echo site_url('account'); ?>"><?php lang('Account'); ?></a></li>
  <li><a href="<?php echo site_url('account/lists'); ?>"><?php lang('Account List'); ?></a></li>
  <li class="active"><?php echo @$account['code']; ?></li>
</ol>




<?php if(isset($account_card_not_found)): ?>
	<div class="row">
    	<div class="col-md-3">
    		<img src="<?php echo base_url('theme/img/logo/256x256.png'); ?>" class="img-responsive" />
    	</div> <!-- /.col-md-3 -->
        <div class="col-md-9">
        	<h3 class="line">Hesap Kartı Bulunamadı!</h3>
            <ul class="sugar">
            	<li>Aradığın hesap kartı bulunamadı.</li>
            	<li>Hesap ID numarası yada hesap barkod kodu yanlış olabilir.</li>
            </ul>
        </div> <!-- /.col-md-9 -->
    </div> <!-- /.row -->
<?php else: ?>

<?php if($account['status'] == 0): ?>
	<?php alertbox('alert-warning', 'Bu hesap kartı silinmiş.', 'Hesap kartı pasif olduğundan listemelerde gözükmez.', false); ?>
<?php endif; ?>


<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#account_card" data-toggle="tab"><i class="fa fa-folder-o"></i> Hesap Kartı</a></li>
    <li class=""><a href="#invoices" data-toggle="tab"><i class="fa fa-shopping-cart"></i> Giriş-Çıkış</a></li>
    <li class=""><a href="#extracted" data-toggle="tab"><i class="fa fa-list"></i> Ekstre</a></li>
    <li class=""><a href="#history" data-toggle="tab"><i class="fa fa-keyboard-o"></i> Log</a></li>
    <li class="dropdown">
		<a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-asterisk"></i> <?php lang('Options'); ?> <b class="caret"></b></a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
			<li><a href="<?php echo site_url('user/new_message/?account_id='.$account['id']); ?>"><span class="glyphicon glyphicon-envelope mr9"></span><?php lang('New Message'); ?></a></li>
            <li><a href="<?php echo site_url('user/new_task/?account_id='.$account['id']); ?>"><span class="glyphicon glyphicon-globe mr9"></span><?php lang('New Task'); ?></a></li>
            
            <li class="divider"></li>
        	<li><a href="javascript:;" onclick="print_barcode();"><span class="glyphicon glyphicon-print mr9"></span><?php lang('Barcode Print'); ?></a></li>
            <li><a href="javascript:;" onclick="address_print();"><span class="glyphicon glyphicon-print mr9"></span><?php lang('Address Print'); ?></a></li>
            
            <?php if(get_the_current_user('role') <= 3): ?>
                <li class="divider"></li>
                <?php if($account['status'] == '1'): ?>
                    <li><a href="?status=0"><span class="glyphicon glyphicon-remove mr9"></span><?php lang('Delete'); ?></a></li>
                <?php else: ?>
                    <li><a href="?status=1"><span class="glyphicon glyphicon-remove mr9"></span><?php lang('Activate'); ?></a></li>
                <?php endif; ?>
            <?php endif; ?>
      </ul>
    </li>
</ul>



<div id="myTabContent" class="tab-content">


<!-- account_card -->
<div class="tab-pane active" id="account_card">
<div class="row">
<div class="col-md-8">


<?php
if(@$update_account_success){alertbox('alert-success', 'Hesap Kartı Güncellendi.', '"'.$account['code'].'" hesap kartı bilgileri veritabanında güncellendi.');}
if(@$formError) { alertbox('alert-danger', $formError);	 }
if(@$haveBarcode) { alertbox('alert-danger', '"'.$account['code'].'" Barkod kodu başka bir ürün kartında bulundu.', 
	'Başka bir ürün kartı "'.$account['code'].'" barkod kodunu kullanıyor. <br/> Barkod kodları eşsiz olmalı ve sadece bir ürün kartına ait olmalı.');	 }
?>


<form name="form_new_product" id="form_new_product" action="" method="POST" class="validation">
	<h3><i class="fa fa fa-puzzle-piece"></i> Hesap Kartı</h3>

        <div class="row">
            <div class="col-md-6">
                   
                <div class="form-group">
                    <label for="code" class="control-label ff-1"><?php lang('Account Code'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-barcode"></span></span>
                        <input type="text" id="code" name="code" class="form-control ff-1" placeholder="<?php lang('Barcode Code'); ?>" minlength="3" maxlength="100" value="<?php echo $account['code']; ?>">
                    </div>
                    
                </div>
                <div class="form-group">
                    <label for="name" class="control-label ff-1"><?php lang('Account Name'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="name" name="name" class="form-control ff-1 required" placeholder="<?php lang('Account Name'); ?>" minlength="3" maxlength="100" value="<?php echo $account['name']; ?>">
                    </div>
                </div>     
            </div> <!-- /.col-md-6 -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name_surname" class="control-label ff-1"><?php lang('Name and Surname'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="name_surname" name="name_surname" class="form-control ff-1" placeholder="<?php lang('Name Surname'); ?>" value="<?php echo $account['name_surname']; ?>" minlengt="3" maxlength="30">
                    </div>
                </div> <!-- /.form-group -->
                <div class="form-group">
                    <label for="balance" class="control-label ff-1"><?php lang('Balance'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                        <input type="text" id="balance" name="balance" class="form-control ff-1 number" placeholder="0.00" value="<?php echo get_money($account['balance'], array('virgule'=>false)); ?>" readonly="readonly">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-6 -->
        </div> <!-- /.row -->
        
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="phone" class="control-label ff-1"><?php lang('Phone'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
                        <input type="text" id="phone" name="phone" class="form-control ff-1 digits" minlength="7" maxlength="16" value="<?php echo $account['phone']; ?>">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="gsm" class="control-label ff-1"><?php lang('Gsm'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
                        <input type="text" id="gsm" name="gsm" class="form-control ff-1 digits" minlength="7" maxlength="16" value="<?php echo $account['gsm']; ?>">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="email" class="control-label ff-1"><?php lang('E-mail'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                        <input type="text" id="email" name="email" class="form-control ff-1 email" minlength="6" maxlength="50" value="<?php echo $account['email']; ?>">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
        </div> <!-- /.row -->
        
        
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="address" class="control-label ff-1"><?php lang('Address'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                       <textarea class="form-control" name="address" id="address" style="height:85px;" minlength="3" maxlength="250"><?php echo $account['address']; ?></textarea>
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- col-md-8 -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="county" class="control-label ff-1"><?php lang('County'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="county" name="county" class="form-control ff-1" minlength="2" maxlength="20" value="<?php echo $account['county']; ?>">
                    </div>
                </div> <!-- /.form-group -->
                <div class="form-group">
                    <label for="city" class="control-label ff-1"><?php lang('City'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="city" name="city" class="form-control ff-1" minlength="2" maxlength="20" value="<?php echo $account['city']; ?>">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
        </div> <!-- /.row -->
        
        <div class="form-group">
            <label for="description" class="control-label ff-1"><?php lang('Description'); ?></label>
            <div class="input-prepend input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
               <textarea class="form-control" name="description" id="description" maxlength="500"><?php echo $account['description']; ?></textarea>
            </div>
        </div> <!-- /.form-group -->
    
        
        <?php if($account['status'] == 1): ?>
           
            <div class="h20"></div>
            <div class="text-right">
                <input type="hidden" name="log_time" value="<?php echo logTime(); ?>" />
                <input type="hidden" name="update" />
                <button class="btn btn-default">Güncelle &raquo;</button>
            </div> <!-- /.text-right -->
      
        <?php endif; ?>

</form>
</div> <!-- /.col-md-8 -->
<div class="col-md-4">
    
    <div class="widget">
    	<div class="header dark_gray">Hesap Kartına Genel Bakış</div>
        <div class="content">
        	
            <div class="custom_box_32 for_sidebar">
                <div class="left">
                    <h4><?php echo get_money($account['balance']); ?> <small>TL</small></h4>
                    <p>BAKİYE</p>
                </div>
                <div class="right">
                    <h4>bos</h4>
                    <p class="green">bu alan kiraliktir</p>
                </div>
            </div> <!-- /.custom_box_32 -->
            
            <div class="custom_box_32 for_sidebar">
                <div class="left">
                	<?php
					$this->db->where('status', 1);
					$this->db->where('account_id', $account['id']);
					$this->db->where('in_out', '1');
					$this->db->select_sum('quantity');
					$sale_quantity = $this->db->get('form_items')->row_array();
					if($sale_quantity['quantity'] < 1){$sale_quantity['quantity'] = 0;}
					?>
                    <h4><?php echo $sale_quantity['quantity']; ?></h4>
                    <p>ADET ÜRÜN SATTIK</p>
                </div>
                <div class="right">
                    <h4><?php echo get_money($account['profit']); ?> <small>TL</small></h4>
                    <p class="green">PARA KAZANDIK</p>
                </div>
            </div> <!-- /.custom_box_32 -->
            
        </div> <!-- /.content -->
    </div> <!-- /.widget -->
    <div class="h20"></div>
    
    
    <div class="widget">
    	<div class="header">Hızlı Menü</div>
        <div class="content">
            <ul class="nav nav-pills nav-stacked">
              <li><a href="<?php echo site_url('invoice/add/?sell&account_id='.$account['id']); ?>" target="_blank"><i class="fa fa-sign-out fs-18 mr5"></i><i class="fa fa-shopping-cart fs-18 mr9"></i> Yeni Satış Fişi</a></li>
              <li><a href="<?php echo site_url('invoice/add/?buy&account_id='.$account['id']); ?>" target="_blank"><i class="fa fa-sign-in fs-18 mr5"></i><i class="fa fa-shopping-cart fs-18 mr9"></i> Yeni Alış Fişi</a></li>
              <li><a href="#"><i class="fa fa-sign-in fs-18 mr5"></i><i class="fa fa-try fs-18 mr9"></i> Yeni Ödeme Almak</a></li>
              <li><a href="#"><i class="fa fa-sign-out fs-18 mr5"></i><i class="fa fa-try fs-18 mr9"></i> Yeni Ödeme Vermek</a></li>
            </ul>
    	</div> <!-- /.content -->
    </div> <!-- /.widget -->
    <div class="h20"></div>
    
    
    <div class="widget">
    	<div class="header">Barkod Kodu</div>
        <div class="content">
        	<a href="javascript:;" class="img-thumbnail" onclick="print_barcode();">
                <img src="<?php echo get_barcode($account['code']); ?>" class="img-responsive" />
            </a>
        </div> <!-- /.content -->
    </div> <!-- /.widget -->
	
    
    
    <script>
	function print_barcode() 
	{ 
		new_window = window.open("<?php echo get_print_barcode($account['code']); ?>?print", "<?php echo $account['code']; ?>","location=0,status=0,scrollbars=0,width=300,height=200"); 
		new_window.moveTo(0,0); 
	}
	
	function address_print() 
	{ 
		new_window = window.open("<?php echo site_url('account/address_print/'.$account['id']); ?>?print", "<?php echo $account['code']; ?>","location=0,status=0,scrollbars=0,width=300,height=200"); 
		new_window.moveTo(0,0); 
	}
	</script>
    
    
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->
</div> <!-- /#account_card --> 




<!-- invoices -->
<div class="tab-pane active" id="invoices">

<table class="table table-bordered table-hover table-condensed dataTable" exportname="cari_ekstre">
	<thead>
    	<tr>
        	<th class="hide"></th>
        	<th width="60">Fiş ID</th>
            <th width="80">Tarih</th>
            <th width="80">Fiş Türü</th>
            <th>Açıklama</th>
            <th width="70">Borç</th>
            <th width="70">Alacak</th>
            <th width="70">Bakiye</th>
        </tr>
    </thead>
    <tbody class="fs-11">
    <?php 
	$this->db->where('status', 1);
	$this->db->where('quantity >', '0');
	$this->db->order_by('date', 'ASC');
	$this->db->where('account_id', $account['id']);
	$invoices = $this->db->get('forms')->result_array();
	$balance = 0;
	?>
    <?php foreach($invoices as $invoice): ?>
    	<tr>
        	<td class="hide"></td>
        	<td><a href="<?php echo site_url('form/view/'.$invoice['id']); ?>">#<?php echo $invoice['id']; ?></a></td>
            <td><?php echo substr($invoice['date'],0,10); ?></td>
            <td><?php echo get_text_form_type($invoice['type']); ?></td>
            <td><?php echo $invoice['description']; ?></td>
            <?php if($invoice['in_out'] == 1): ?>
            	 <td class="text-right"><?php echo get_money($invoice['grand_total']); ?></td>
                 <td></td>
            <?php else: ?>
            	<td></td>
                 <td class="text-right"><?php echo get_money($invoice['grand_total']); ?></td>
            <?php endif; ?>
           
            <?php if($invoice['in_out'] == '1') { $balance = $balance + $invoice['grand_total']; } else { $balance = $balance - $invoice['grand_total'];  } ?>
            <td class="text-right"><?php echo get_money($balance); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
        	<th colspan="4"></th>
            <th colspan="3" class="text-right fs-12 text-danger"><?php echo get_money($balance); ?> <small>TL</small></th>
        </tr>
    </tfoot>
</table> <!-- /.table -->
</div> <!-- /#invoices -->





<!-- extracted -->
<div class="tab-pane active" id="extracted">

<table class="table table-bordered table-hover table-condensed dataTable2" exportName="cari_detayli_ekstre">
	<thead>
    	<tr>
        	<th class="hide"></th>
            <th width="60">Fiş ID</th>
            <th width="80">Tarih</th>
            <th width="80">Tür</th>
            <th>Stok Kodu</th>
            <th>Stok Adı</th>
            <th width="50">Adet</th>
            <th width="60">B.Fiyatı</th>
            <th width="70">Borç</th>
            <th width="70">Alacak</th>
            <th width="70">Bakiye</th>
        </tr>
    </thead>
    <tbody class="fs-11">
    <?php 
	$this->db->where('status', 1);
	$this->db->order_by('date', 'ASC');
	$this->db->where('account_id', $account['id']);
	$invoice_items = $this->db->get('form_items')->result_array();
	$balance = 0;
	?>
    <?php foreach($invoice_items as $item): ?>
    	<tr>
        	<td><a href="<?php echo site_url('form/view/'.$item['form_id']); ?>" target="_blank">#<?php echo $item['form_id']; ?></a></td>
        	<td class="hide"></td>
            <td class="fs-11" title="<?php echo $item['date']; ?>"><?php echo substr($item['date'],0,10); ?></td>
            <td class="fs-10"><?php echo get_text_form_type($item['type']); ?></td>
            <td><a href="<?php echo site_url('product/view/'.$item['product_code']); ?>" target="_blank"><?php echo $item['product_code']; ?></a></td>
            <td title="<?php echo $item['product_name']; ?>"><?php echo substr($item['product_name'],0,35); ?></td>
            <td class="text-center fs-11"><?php echo the_quantity($item['quantity']); ?></td>
            <td class="text-right fs-11 fs-11" title="Kdv'siz satış fiyat: <?php echo $item['tax_free_cost_price']; ?> TL"><?php echo get_money($item['sale_price']); ?></td>
            <?php if($item['in_out'] == '1'): ?>
            	<td class="text-right fs-11" title="Kdv: <?php echo $item['tax']; ?> (%<?php echo $item['tax_rate']; ?>)"><?php echo get_money($item['sub_total']); ?></td>
                <td></td>
            <?php else: ?>
            	<td></td>
            	<td class="text-right fs-11" title="Kdv: (%<?php echo $item['tax_rate']; ?>) <?php echo $item['tax']; ?> TL"><?php echo get_money($item['sub_total']); ?></td>
            <?php endif; ?>
            <?php if($item['in_out'] == '1') { $balance = $balance + $item['sub_total']; } else { $balance = $balance - $item['sub_total'];  } ?>
            <td class="text-right fs-11"><?php echo get_money($balance); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    	<?php
		$this->db->where('status', 1);
		$this->db->order_by('ID', 'ASC');
		$this->db->where('account_id', $account['id']);
		$this->db->select_sum('grand_total');
		$grand_total = $this->db->get('forms')->row_array();
		?>
        <tr>
        	<th colspan="5"></th>
            <th colspan="5" class="text-right fs-12 text-danger"><?php echo get_money($balance); ?> <small>TL</small></th>
        </tr>
    </tfoot>
</table> <!-- /.table -->
</div> <!-- /#invoices -->








<!-- history -->
<div class="tab-pane active" id="history">
	<?php get_log_table(array('account_id'=>$account['id']), 'DESC'); ?>
</div> <!-- /#history -->


<script>
$(document).ready(function(e) {
	function removeTabActiveClass() {
		$('.tab-pane').removeClass('active');
		$('.tab-pane:first').addClass('active');
	}
  setTimeout(removeTabActiveClass, 100);  
});
</script>
<?php endif; ?>