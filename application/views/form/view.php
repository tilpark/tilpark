
<?php if($form['status'] == 0): ?>
	<?php alertbox('alert-danger', get_lang('Deleted Invoice.'), '', false); ?>
<?php endif; ?>


<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#transactions" data-toggle="tab"><i class="fa fa-shopping-cart"></i> İşlemler</a></li>
    <li class=""><a href="#history" data-toggle="tab"><i class="fa fa-comments"></i> Geçmiş</a></li>
    <li class="dropdown pull-right">
		<a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-asterisk"></i> Seçenekler <b class="caret"></b></a>
		<ul class="dropdown-menu options" role="menu" aria-labelledby="myTabDrop1">
			<li><a href="<?php echo site_url('user/new_message/?invoice_id='.$form['id']); ?>"><i class="fa fa-envelope w16"></i>Yeni Mesaj</a></li>
            <li><a href="<?php echo site_url('user/new_task/?invoice_id='.$form['id']); ?>"><i class="fa fa-globe w16"></i>Yeni Görev</a></li>
            
            <li class="divider"></li>
            <li><a href="<?php echo site_url('invoice/invoice_print/'.$form['id']); ?>"><i class="fa fa-print w16"></i>Fatura Yazdır</a></li>
            
            <li class="divider"></li>
            <li><a href="#"><i class="fa fa-envelope w16"></i>E-posta Gönder</a></li>
            <li><a href="#"><i class="fa fa-tablet w16"></i>SMS Gönder</a></li>
            

            <?php if(get_the_current_user('role') <= 3): ?>
                <li class="divider"></li>
                <?php if($form['status'] == '1'): ?>
                    <li><a href="?status=0"><i class="fa fa-trash w16"></i>Sil</a></li>
                <?php else: ?>
                    <li><a href="?status=1"><i class="fa fa-check-square-o w16"></i>Aktifleştir</a></li>
                <?php endif; ?>
            <?php endif; ?>
      </ul>
    </li>
</ul> <!-- /.nav nav-tabs -->





<div id="myTabContent" class="tab-content">



<div class="tab-pane fade active in" id="transactions">



<div class="row">
    <div class="col-md-6">	
        <h3><i class="fa fa-puzzle-piece"></i> Form Bilgileri</h3>
    </div>
    <div class="col-md-6">
        <div class="text-right">
            
            
            <div class="btn-group">
            	<input type="hidden" name="update_form_info" form="form" />  
                <input type="hidden" name="microtime" form="form" value="<?php echo logTime(); ?>" />
                <button class="btn btn-default" form="form" id="btn_information_save"><i class="fa fa-save"></i>  Kaydet</button>
            </div> <!-- /.btn-group -->
       
           
        </div> <!-- /.text-right -->
    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->
    

<form name="form" id="form" action="?<?php if($form['id'] == 0): ?><?php if(isset($_GET['out'])): echo 'out'; else : echo 'in'; endif; ?><?php endif; ?>" method="POST" class="validation">
    
    <div class="row">
        <div class="col-md-4">
            <div class="widget2">
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date" class="control-label ff-1">Tarih</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" id="date" name="date" class="form-control datepicker" value="<?php echo substr($form['date'],0,10); ?>" readonly="readonly">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-12 -->
                    
                    
                    <div class="clearfix"></div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="invoice_no" class="control-label ff-1">Fatura No</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-building-o"></span></span>
                                <input type="text" id="invoice_no" name="invoice_no" class="form-control" value="<?php echo $form['invoice_no']; ?>">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="waybill_no" class="control-label ff-1">İrsaliye No</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-building-o"></span></span>
                                <input type="text" id="waybill_no" name="waybill_no" class="form-control" value="<?php echo $form['waybill_no']; ?>" autocomplete="off">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->
                
                <div class="form-group">
                    <label for="description">Açıklama</label> 
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span> 
                        <input type="text" name="description" id="description" value="<?php echo $form['description']; ?>" autocomplete="off">
                    </div>
                </div> <!-- /.form-group -->

            </div> <!-- /.widget2 -->
        </div> <!-- /.col-md-4 -->
        <div class="col-md-8">
            <div class="widget2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" name="account_id" id="account_id" value="<?php echo $form['account_id']; ?>" />
                            <label for="name" class="control-label ff-1">Hesap Kartı (<span class="text-warning account_change">degiştir</span>) (<span class="text-warning account_clear pointer">temizle</span>)</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo $form['name']; ?>" autocomplete="off" readonly="readonly" maxlength="50">
                            </div>
                        </div> <!-- /.form-group -->
                        <div class="search_account typeHead"></div>
                        <style>
                        .account_change {
                            cursor: pointer;
                            padding: 0px 3px;
                        }
                        .account_change:hover {
                            background-color: #000;
                        }
                        .account_clear {
                            padding: 0px 3px;
                        }
                        .account_clear:hover {
                            background-color: #000;
                        }
                        </style>
                        <script>
                        $(document).ready(function() {
                            $('.account_change').click(function() {
                                if($('#name').attr('readonly') == 'readonly')
                                {
                                    $('#name').removeAttr('readonly');
                                }
                                else
                                {
                                    $('#name').attr('readonly', 'readonly');
                                }
                            });

                            <?php if($form['id'] == 0): ?>
                                $('#name').removeAttr('readonly');
                            <?php endif; ?>

                            $('.account_clear').click(function() {
                                
                                $('#account_id').val('0');
                                $('#name').val('');
                                $('#name').attr('readonly', 'readonly');
                                
                                
                                $('#name_surname').val('');
                                $('#phone').val('');
                                $('#gsm').val('');
                                $('#email').val('');
                                $('#address').val('');
                                $('#county').val('');
                                $('#city').val('');
                                
                            });
                            
                            $('#name').dblclick(function() {
                                 $('.account_change').click();
                            });
                            
                        });
                        </script>
                        <script>
                            // hesap karti arama ajax
                            $(document).ready(function(e) {
                                $('#name').keyup(function() {
                                    $('.typeHead').show();
                                    $.get("../search_account/"+$(this).val()+"", function( data ) {
                                      $('.search_account').html(data);
                                    });
                                });
                            });
                        </script>

                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="account_code" class="control-label ff-1">Hesap Kodu</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                                <input type="text" id="account_code" name="code" class="form-control" value="<?php echo $form['code']; ?>" readonly="readonly">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">E-posta</label> 
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                                <input type="text" name="email" id="email" class="email" value="<?php echo $form['email']; ?>" maxlength="50">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-3 -->
                </div> <!-- /.row -->
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_surname">Ad Soyad</label> 
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                <input type="text" name="name_surname" id="name_surname" value="<?php echo $form['name_surname']; ?>" autocomplete="off" class="required" minlength="3" maxlength="50">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="phone">Telefon</label> 
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                                <input type="text" name="phone" id="phone" value="<?php echo $form['phone']; ?>" autocomplete="off" class="digits" minlength="10" maxlength="11">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!--/.col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="gsm">Cep Telefon</label> 
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-mobile-phone"></span></span>
                                <input type="text" name="gsm" id="gsm" value="<?php echo $form['gsm']; ?>" autocomplete="off" class="required digits" minlength="10" maxlength="11">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!--/.col-md-3 -->
                </div> <!-- /.row -->
                
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Adres</label> 
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                <input type="text" name="address" id="address" value="<?php echo $form['address']; ?>" autocomplete="off">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!--/.col-md-6 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="county">İlçe</label> 
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                <input type="text" name="county" id="county" value="<?php echo $form['county']; ?>" autocomplete="off">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!--/.col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city">Şehir</label> 
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                <input type="text" name="city" id="city" value="<?php echo $form['city']; ?>" autocomplete="off">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!--/.col-md-3 -->
                </div> <!-- /.row -->
            </div> <!-- /.widget2 -->
        </div> <!-- /.col-md-8 -->       
    </div> <!-- /.row -->
           
</form>


<div class="h20"></div>


<h3><i class="fa fa-puzzle-piece"></i> Form Hareketleri</h3>


<?php if(@$item_alerts): ?>
  <?php foreach($item_alerts as $alert): ?>
        <div class="alert alert-block alert-<?php echo $alert['class']; ?> fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php if(isset($alert['title'])): ?><h4><?php echo $alert['title']; ?></h4><?php endif; ?>
            <?php if(isset($alert['description'])): ?><p><?php echo $alert['description']; ?></p><?php endif; ?>
        </div>        
    <?php endforeach; ?>
<?php endif; ?>




<form name="add_item" id="add_item" action="<?php echo site_url('form/view/'.$form['id']); ?><?php if($form['id'] == 0): ?><?php if(isset($_GET['out'])): echo '?out'; else : echo '?in'; endif; ?><?php endif;?>" method="POST" class="validation_2">
    <table class="table table-hover table-bordered table-condensed">
    	<thead>
        	<tr class="fs-12">
            	<th width="1"></th>
            	<th width="150" style="font-weight:bold;">Stok Kodu</th>
                <th style="font-weight:bold;">Stok Adı</th>
                <th width="60" style="font-weight:bold;">Adet</th>
                <th width="80" style="font-weight:bold;">Birim Fiyatı</th>
                <th width="80" style="font-weight:bold;">Toplam</th>
                <th width="80" style="font-weight:bold;">Kdv Oranı</th>
                <th width="80" style="font-weight:bold;">Kdv Tutarı</th>
                <th width="100" style="font-weight:bold;">Satır Toplamı</th>
            </tr>
        </thead>
        <tbody>
        <tr class="active">
            <td width="1">
                <button form="add_item" class="btn btn-default btn-xs"><i class="fa fa-plus fs-14 text-success"></i></button>
                <input type="hidden" name="item" form="add_item">
                <input type="hidden" name="log_time" value="<?php echo logTime(); ?>" form="add_item">
            </td>
            <td width="150">
                <input type="text" id="code" name="code" class="fiche-input-text invoice_input barcodeCode" placeholder="BARKOD KODU" maxlength="100" value="" autocomplete="off" form="add_item" width="150">
                <div class="search_product typeHead" style="width:400px; margin-top:6px;"></div>
            </td>
            <td width="280"><input type="text" id="product_name" name="product_name" class="fiche-input-text required" placeholder="" maxlength="100" value="" form="add_item" autocomplete="off"></td>
            <td width="60"><input type="text" id="amount" name="amount" class="fiche-input-text" placeholder="1" maxlength="11" value="1" onkeyup="calc();" form="add_item"></td>
            <td width="80"><input type="text" id="quantity_price" name="quantity_price" class="fiche-input-text" placeholder="0.00" maxlength="11" value="" onkeyup="calc();" form="add_item"></td>
            <td width="80"><input type="text" id="total" name="total" class="fiche-input-text" placeholder="0.00" maxlength="11" value="" onkeyup="calc();" form="add_item" readonly></td>
            <td width="80"><input type="text" id="tax_rate" name="tax_rate" class="fiche-input-text" placeholder="0" maxlength="2" value="" onkeyup="calc();" form="add_item"></td>
            <td width="80"><input type="text" id="tax" name="tax" class="fiche-input-text" placeholder="0" maxlength="11" value="" onkeyup="calc();" form="add_item" readonly></td>
            <td width="80"><input type="text" id="sub_total" name="sub_total" class="fiche-input-text" placeholder="0" maxlength="11" value="" onkeyup="calc_subtotal();" form="add_item"></td>
        </tr>
        <?php foreach($items as $item): ?>
        	<?php
    		if($item['product_id'] > 0)
    		{
    			$product = get_product($item['product_id']);
    		}
    		else
    		{
    			$product['id'] = '';
    			$product['code'] = $item['product_code'];	
    			$product['name'] = $item['product_name'];	
    		}
    		?>
        	<tr>
            	<td>
                	<a href="<?php echo site_url('form/view/'.$form['id'].'?item_id='.$item['id'].'&delete_item=✓'); ?>" title="Sil" class="btn btn-default btn-xs"><span class="fa fa-trash-o fs-14 text-danger"></span></a>
                </td>
            	<td class="fs-12">
                	<?php if($product['id'] > 0): ?>
                    	<a href="<?php echo site_url('product/view/'.$product['id']); ?>" target="_blank"><?php echo $product['code']; ?></a>
                	<?php else: ?>
                    	<?php echo $product['name']; ?>
                    <?php endif; ?>
                </td>
                <td class="fs-12"><?php echo $product['name']; ?></td>
                <td class="text-center"><?php echo get_quantity($item['quantity']); ?></td>
                <td class="text-right"><?php echo get_money($item['tax_free_sale_price']); ?> <small>TL</small></td>
                <td class="text-right"><?php echo get_money($item['total']); ?> <small>TL</small></td>
                <td class="text-center">% (<?php echo $item['tax_rate']; ?>)</td>
                <td class="text-right"><?php echo get_money($item['tax']); ?> <small>TL</small></td>
                <td class="text-right"><?php echo get_money($item['sub_total']); ?> <small>TL</small></td>
            </tr>	
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        	<tr>
                <th colspan="7" class="text-right">TOPLAM :</th>
                <th colspan="2" class="text-right no-strong text-danger fs-16"><?php echo get_money($form['total']); ?> <i class="fa fa-try"></i></th>
            </tr>
            <tr class="no-strong">
                <th colspan="7" class="text-right">KDV :</th>
                <th colspan="2" class="text-right no-strong text-danger fs-16"><?php echo get_money($form['tax']); ?> <i class="fa fa-try"></i></th>
            </tr>
            <tr class="no-strong">
                <th colspan="7" class="text-right">GENEL TOPLAM :</th>
                <th colspan="2" class="text-right no-strong text-danger fs-16"><?php echo get_money($form['grand_total']); ?> <i class="fa fa-try"></i></th>
            </tr>
        </tfoot>
    </table>
<!-- /items -->
<style>
.fiche-input-text {
    height: 24px !important;
    padding: 0px 5px !important;
}
</style>
</form>



</div> <!-- /#transactions -->





<div class="tab-pane fade in" id="history">
	<?php get_log_table(array('form_id'=>$form['id']), 'ASC'); ?>
</div> <!-- #history -->


</div> <!-- /#myTabContent -->




<script>


    $('#code').keyup(function() {
        $('.typeHead').show();
        $.get("../search_product_for_invoice/"+$(this).val()+"?<?php if($form['in_out']=='in'){echo'cost_price';} ?>", function( data ) {
            $('.search_product').html(data);
        });
    });
    $('#product_name').keyup(function() {
        $('.typeHead').show();
        $.get("../search_product_for_invoice/"+$(this).val()+"?<?php if($form['in_out']=='in'){echo'cost_price';} ?>", function( data ) {
          $('.search_product').html(data);
        });
    });


    <?php if($form['id']): ?>
        $('.barcodeCode').focus();
    <?php else: ?>
        $('#name').focus();
    <?php endif; ?>



    // adet/birim fiyati degistiginde hesapla
    function calc()
    {
    	if($('#quantity_price').val() == 'NaN'){ $('#quantity_price').val('0'); }
    	
    	var amount 		= $('#amount').val();	
    	var quantity_price = $('#quantity_price').val();	
    	var total 		= $('#total').val();
    	var tax_rate 	= $('#tax_rate').val();
    	var tax 		= $('#tax').val();
    	var sub_total 	= $('#sub_total').val();
    	
    	$('#total').val(parseFloat(amount * quantity_price).toFixed(2));
    	
    	
    	tax_rate = $('#tax_rate').val();
    	   if(tax_rate == ''){tax_rate = 0;}
        $('#tax').val( parseFloat(parseFloat( $('#total').val() / 100 ) * tax_rate).toFixed(2));
    	
    	$('#sub_total').val(parseFloat(parseFloat($('#total').val()) + parseFloat($('#tax').val())).toFixed(2));
    	$('#sub_total').val(parseFloat($('#sub_total').val()).toFixed(2));
    }


    // satir toplami degistiginde hesapla
    function calc_subtotal()
    {
    	if($('#quantity_price').val() == 'NaN'){ $('#quantity_price').val('0'); }
    	if($('#sub_total').val() == ''){ return false; }
    	
    	var amount 		= $('#amount').val();	
    	var quantity_price = $('#quantity_price').val();	
    	var total 		= $('#total').val();
    	var tax_rate 	= $('#tax_rate').val();
    	var tax 		= $('#tax').val();
    	var sub_total 	= $('#sub_total').val();
    	
    	
    	total = parseFloat(parseFloat(sub_total) / parseFloat('1.'+tax_rate)).toFixed(2);
    	tax = sub_total - total;

        $('#tax').val(parseFloat(tax).toFixed(2));
    	$('#total').val(parseFloat(total).toFixed(2));
    	$('#quantity_price').val(parseFloat(parseFloat($('#total').val()) / parseFloat($('#amount').val())).toFixed(2)).toFixed(2);
    	$('#sub_total').val(parseFloat($('#sub_total').val()).toFixed(2));
        calc();
    }

    // yeni form olusmus ise URl ve tarayıcı gecmisini duzenle
    <?php if(@$url_change_for_form_ID): ?> window.history.pushState("object or string", "Title", "<?php echo $form['id']; ?>"); <?php endif; ?>


</script>