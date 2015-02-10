
<ol class="breadcrumb">
	<li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
	<li><a href="<?php echo site_url('payment'); ?>">Kasa</a></li>
	<li class="active">Kasa Yönetimi</li>
</ol>

<h3 class="title"><i class="fa fa-puzzle-piece"></i> Kasa & Banka Yönetimi</h3>

<div class="row">
<div class="col-md-6">
	
    
	<?php if(@$success) { foreach($success as $alert ) { echo $alert; } } ?>
    <?php if(@$alerts) { foreach($alerts as $alert ) { echo $alert; } } ?>
    
    <form name="form" id="form" action="" method="POST" class="control-form validation">
    
    	<div class="row">
        	<div class="col-md-8">
                <div class="form-group">
                    <label for="name" class="control-label">Kasa veya Banka Adı</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-font"></span></span>
                        <input type="text" id="name" name="name" class="form-control required" autocomplete="off">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="type" class="control-label">Kasa Türü</label>
                    <select name="type" id="type" class="form-control">
                    	<option value="cashbox">Kasa</option>
                        <option value="bank">Banka</option>
                    </select>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
   		</div> <!-- /.row -->
        
        <div class="row bank_detail">
        	<div class="col-md-3">
            	<label for="branch_code" class="control-label">Şube Kodu</label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="fa fa-terminal"></span></span>
                    <input type="text" id="branch_code" name="branch_code" class="form-control digits" autocomplete="off">
                </div>
            </div> <!-- /.col-md-3 -->
            <div class="col-md-4">
            	<label for="account_no" class="control-label">Hesap No</label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="fa fa-terminal"></span></span>
                    <input type="text" id="account_no" name="account_no" class="form-control digits" autocomplete="off">
                </div>
            </div> <!-- /.col-md-4 -->
            <div class="col-md-5">
            	<label for="iban" class="control-label">IBAN</label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="fa fa-terminal"></span></span>
                    <input type="text" id="iban" name="iban" class="form-control digits" autocomplete="off">
                </div>
            </div> <!-- /.col-md-4 -->
        </div> <!-- /.row -->
        
        <div class="text-right">
            <label>&nbsp;</label>
            <br />
            <input type="hidden" name="add" />
            <input type="hidden" name="log_time" value="<?php echo logTime(); ?>" />
            <button class="btn btn-default btn-sm button_grid1">Yeni Kasa Ekle</button>
        </div>
        
        <script>
		$(document).ready(function(e) {
            $('.bank_detail').hide();
        });
		$('#type').change(function() {
			if($('#type').val() == 'bank')
			{ 
				$('.bank_detail').show('blonde'); 
				$('#branch_code').addClass('required');
				$('#account_no').addClass('required');
			}
			else
			{ 
				$('.bank_detail').hide('blonde'); 
				$('#branch_code').removeClass('required');
				$('#account_no').removeClass('required');
			}
		});
		</script>
        
    </form>
    
    <div class="h20"></div>
    
    <h4 class="title"><i class="fa fa-puzzle-piece"></i> Kasa Listesi</h4>
    <table class="table table-hover table-bordered table-condensed">
    	<thead>
        	<tr>
            	<th width="1"></th>
            	<th>Kasa Adı</th>
                <th>Toplam</th>
            </tr>
        </thead>
        <tbody>
        	<?php $cashboxs = get_options(array('group'=>'cashbox', 'val_5'=>''), array('order_by'=>'key ASC')); ?>
            <?php if($cashboxs): ?>
        	<?php foreach($cashboxs as $cashbox): ?>
            	<?php
					calc_cahsbox($cashbox['id']);
				?>
            	<tr>
                	<td width="64">
                    	<a href="?set&default=true&cashbox_id=<?php echo $cashbox['id']; ?>" class="btn btn-default btn-xs" title="Varsayılan kasa"><i class="fa fa-check-square-o"></i></a>
                    	<a href="?set&delete=true&cashbox_id=<?php echo $cashbox['id']; ?>" class="btn btn-default btn-xs" title="Sil"><i class="fa fa-trash-o text-danger"></i></a>
                    </td>
                    <td>
                    	<a href="<?php echo site_url('payment/cashbox/'.$cashbox['id']); ?>" title="Kasa Detayları"><?php echo $cashbox['key']; ?></a>
                        <?php if($cashbox['val_1']): ?><small class="text-muted">(varsayılan)</small><?php endif; ?></td>
                    <td class="text-right"><?php echo get_money($cashbox['val_decimal']); ?> <small>TL</small></td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            	<?php alertbox('alert-warning', 'Kasa bulunamadı', 'Tahsilat ve ödeme işlemleriniz için bir kasa oluşturmalısın.'); ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    
    
    <h4 class="title"><i class="fa fa-puzzle-piece"></i> Banka Listesi</h4>
    <table class="table table-hover table-bordered table-condensed">
    	<thead>
        	<tr>
            	<th width="1"></th>
            	<th>Banka Adı</th>
                <th>Şube Kodu</th>
                <th>Hesap No</th>
                <th>Toplam</th>
            </tr>
        </thead>
        <tbody>
        	<?php $cashboxs = get_options(array('group'=>'bank', 'val_5'=>''), array('order_by'=>'key ASC')); ?>
            <?php if($cashboxs): ?>
        	<?php foreach($cashboxs as $cashbox): ?>
            	<?php
					calc_cahsbox($cashbox['id']);
				?>
            	<tr>
                	<td width="34">
                    	<a href="?set&delete=true&cashbox_id=<?php echo $cashbox['id']; ?>" class="btn btn-default btn-xs" title="Sil"><i class="fa fa-trash-o text-danger"></i></a>
                    </td>
                    <td title="<?php echo $cashbox['val_4']; ?>"><a href="<?php echo site_url('payment/cashbox/'.$cashbox['id']); ?>"><?php echo $cashbox['key']; ?></a></td>
                    <td><?php echo $cashbox['val_2']; ?></td>
                    <td><?php echo $cashbox['val_3']; ?></td>
                    <td class="text-right"><?php echo get_money($cashbox['val_decimal']); ?> <small>TL</small></td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            	<?php alertbox('alert-warning', 'Banka bulunamadı', 'Tahsilat ve ödeme işlemlerin için bir banka hesabı oluşturmalısın.'); ?>
            <?php endif; ?>
        </tbody>
    </table>
    
</div> <!-- /.col-md-8 -->
<div class="col-md-4">

</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->