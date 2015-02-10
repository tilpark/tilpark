<ol class="breadcrumb">
	<li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
	<li><a href="<?php echo site_url('payment'); ?>">Kasa</a></li>
	<li class="active">
  	<?php if(isset($_GET['in'])): ?>
    	Tahsilat
    <?php else: ?>
    	Ödeme
    <?php endif; ?>
	</li>
</ol>

<?php if(!$cashboxs): ?>
	<?php alertbox('alert-warning', 'Kasa bulunamadı!', 'Ödeme hareketleri ekleyebilmen için kasaya ihtiyacın var. Lütfen yeni bir kasa ekleyin.', false); ?>
	<?php return false; ?>
<?php endif; ?>

<div class="row">
<div class="col-md-8">


    <form name="form_new_product" id="form_new_product" action="" method="POST" class="validation">
        <h3><i class="fa fa-puzzle-piece"></i> Yeni Kasa Hareketi - <?php if(isset($_GET['in'])): ?>
            Tahsilat
        <?php else: ?>
            Ödeme
        <?php endif; ?></h3>
        <div class="row">
            <div class="col-md-3">
            
                <div class="form-group">
                    <label for="date" class="control-label">Tarih</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        <input type="text" id="date" name="date" class="form-control required datepicker pointer" placeholder="<?php lang('Start Date'); ?>" minlength="3" maxlength="50" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                	<label for="transaction_type" class="control-label">İşlem Türü</label>
                    <select name="transaction_type" id="transaction_type" class="form-control">
                    	<option value="account">Cari Hesap</option>
                        <option value="manual">Manuel</option>
                    </select>
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                    <label for="payment_type" class="control-label">Ödeme Türü</label>
                    <select name="payment_type" id="payment_type" class="form-control  ">
                        <option value="cash">Nakit</option>
                        <option value="bank_transfer">Havale/EFT</option>
                    </select>
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                    <label for="payment_type" class="control-label">Kasa veya Banka</label>
                    <select name="cahsbox" id="cahsbox" class="form-control required">
                        <?php $cahsboxs = get_options(array('group'=>'cashbox', 'val_5'=>''), array('order_by'=>'key ASC')); ?>
                        <?php if($cahsboxs): ?>
                        	<optgroup label="Kasalar" id="optgroup_cashbox">
								<?php foreach($cahsboxs as $cahsbox): ?>
                                    <option value="<?php echo $cahsbox['id']; ?>" <?php selected($cahsbox['val_1'],'default'); ?>><?php echo $cahsbox['key']; ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                        
                        <?php $banks = get_options(array('group'=>'bank', 'val_5'=>''), array('order_by'=>'key ASC')); ?>
                        <?php if($banks): ?>
                            <optgroup label="Bankalar" id="optgroup_bank">
                                <?php foreach($banks as $bank): ?>
                                    <option value="<?php echo $bank['id']; ?>"><?php echo $bank['key']; ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                    </select>
                </div> <!-- /.form-group -->
                
            </div> <!-- /.col-md-3 -->
            <div class="col-md-9">
            
            	<div id="transaction_type_account">
                    <div class="form-group">
                        <input type="hidden" name="account_id" id="account_id" value="" />
                        <label for="account_name" class="control-label">Hesap Kartı</label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon pointer"><span class="fa fa-user"></span></span>
                            <input type="text" id="account_name" name="account_name" class="form-control required" placeholder="hesap kartı..." value="" autocomplete="off">
                        </div>
                    </div> <!-- /.form-group -->
                    <div class="search_account typeHead"></div>
                </div> <!-- /#transaction_type_account -->
                
                <div id="transaction_type_manual">
                	<div class="note"><i class="fa fa-quote-left"></i> manuel işlem yapıyorsun, cari hesap bakiyeleri etkilenmez. sadece kasa hareketleri etkilenir.</div>
                	<div class="row">
                    	<div class="col-md-6">
                        	<div class="form-group">
                            	<label for="name" class="control-label">Firma/Kurum Adı</label>
                                <div class="input-prepend input-group">
                                	<span class="input-group-addon pointer"><i class="fa fa-text-width"></i></span>
                                	<input type="text" name="name" id="name" class="form-control" value="" autocomplete="off" />
                                </div>
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-6 -->
                        <div class="col-md-6">
                        	<div class="form-group">
                            	<label for="name_surname" class="control-label">Ad Soyad</label>
                                <div class="input-prepend input-group">
                                	<span class="input-group-addon pointer"><i class="fa fa-text-width"></i></span>
                                	<input type="text" name="name_surname" id="name_surname" class="form-control" value="" autocomplete="off" />
                                </div>
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-6 -->
                    </div> <!-- /.row -->
                </div> <!-- /#transaction_type_manual -->
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="old_balance" class="control-label">Eski Bakiye</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-try"></span></span>
                                <input type="text" id="old_balance" name="old_balance" class="form-control number" placeholder="0.00" value="" readonly="readonly">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="payment" class="control-label">Ödeme Tutarı</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-try"></span></span>
                                <input type="text" id="payment" name="payment" class="form-control required number" required="required" placeholder="0.00" maxlength="10" value="" onkeypress="calc_payment();" onkeyup="calc_payment();">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="new_balance" class="control-label">Yeni Bakiye</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon pointer"><span class="fa fa-try"></span></span>
                                <input type="text" id="new_balance" name="new_balance" class="form-control number" placeholder="0.00" value="" readonly="readonly">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-4 -->
                </div> <!-- /.row -->
                
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cashbox_old_balance" class="control-label">Kasa'nın Eski Bakiyesi</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon pointer"><span class="fa fa-archive"></span></span>
                                <input type="text" id="cashbox_old_balance" name="cashbox_old_balance" class="form-control number" placeholder="0.00" value="" readonly="readonly">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cashbox_new_balance" class="control-label">Kasa'nın Yeni Bakiyesi</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon pointer"><span class="fa fa-archive"></span></span>
                                <input type="text" id="cashbox_new_balance" name="cashbox_new_balance" class="form-control   number" placeholder="0.00" value="" readonly="readonly">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-4 -->
                </div> <!-- /.row -->
                
                
                <div id="bank_info">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bank_name" class="control-label">Banka Adı</label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-font"></span></span>
                                    <input type="text" id="bank_name" name="bank_name" class="form-control" minlength="2" maxlength="50" value="">
                                </div>
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-4 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="branch_code" class="control-label">Şube Adı veya Kodu</label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-font"></span></span>
                                    <input type="text" id="branch_code" name="branch_code" class="form-control">
                                </div>
                            </div> <!-- /.form-group --> 
                        </div> <!-- /.col-md-4 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="serial_no" class="control-label">Seri/Fiş/İşlem No</label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                    <input type="text" id="serial_no" name="serial_no" class="form-control">
                                </div>
                            </div> <!-- /.form-group --> 
                        </div> <!-- /.col-md-4 -->
                    </div> <!-- /.row -->
                </div> <!-- /#bank_info --> 
                
                
                <div class="form-group">
                    <label for="description" class="control-label">Açıklama</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                        <input type="text" id="description" name="description" class="form-control" minlength="3" maxlength="50" value="">
                    </div>
                </div> <!-- /.form-group --> 
                
            </div> <!-- /.col-md-9 -->
        </div> <!-- /.row -->
        
        <div class="h20"></div>
        <div class="text-right">
            <input type="hidden" name="log_time" value="<?php echo logTime(); ?>" />
            <input type="hidden" name="add" />
            <button type="submit" class="btn btn-default fs-2"><i class="fa fa-save"></i> Kaydet</button>
        </div> <!-- /.text-right -->
    </form>
    
</div> <!-- /.col-md-8 -->
<div class="col-md-4">
	
    <div class="widget">
    	<div class="header"><i class="fa fa-question-circle"></i> Açıklama</div>
        <div class="content">
       	
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse-1">
                                Para alma ve verme işlemlerinde hesap kartları...
                            </a>
                        </h4>
                    </div> <!-- /.panel-heading -->
                    <div id="collapse-1" class="panel-collapse collaps in">
                        <div class="panel-body">
                            Buradaki panel ile kasa/banka giriş ve çıkışlarını ekleyebilirsin. Para alabilir veya para verebilirsin. 
                            <br />
                            Kasa/banka hareketlerinde hesap kartlarında seçim yapabilirsin. Bu sayede hesap kartlarının <strong>bakiyeleri</strong> artacak veya azalacaktır.
                        </div>
                    </div> <!-- /.panel-collapse -->
                </div> <!-- /.panel -->
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse-2">
                                Masraf ödemeleri nasıl eklenir?
                            </a>
                        </h4>
                    </div> <!-- /.panel-heading -->
                    <div id="collapse-2" class="panel-collapse collapse">
                        <div class="panel-body">
                            <strong>İşlem türü</strong> bölümünden <strong>Manuel</strong> ödeme seçildiğinde, hesap kartları etkilenmez. Fakat kasa/banka hareketleri etklenir. Yani kasanızdan para girişi ve çıkışı olur. Manuel işlemler genellikle Gider harcamaları, elektrik, su, doğalgaz, internet vb. gibi ödemeler için kullanılır. 
                    <br />
                    Ayrıca hesap kartı açmadan, para girişi ve çıkışı yaptığınız işlemlerde Manuel ödemeler sekmesini seçebilirsiniz.
                        </div>
                    </div> <!-- /.panel-collapse -->
                </div> <!-- /.panel -->
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse-3">
                                Şirket sahibi kasadaki tüm parayı aldı?
                            </a>
                        </h4>
                    </div> <!-- /.panel-heading -->
                    <div id="collapse-3" class="panel-collapse collapse">
                        <div class="panel-body">
                            Kasada/bankada para birikti ve <strong>şirket sahibi</strong> tüm parayı almak istedi, bu durumda <strong>şirket sahibi</strong> için hesap kart açamazsın. Çünkü para verdiğin zaman hesap kartı bakiyesi borçlu gözükecektir. Bu gibi durumlarda manuel işlem türünü seçmen önerilir. Açıklama kısmına uygun bir açıklama yazman yeterli olacaktır.
                        </div>
                    </div> <!-- /.panel-collapse -->
                </div> <!-- /.panel -->
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse-4">
                                Kasa/banka hareketlerini değiştirebilir miyim?
                            </a>
                        </h4>
                    </div> <!-- /.panel-heading -->
                    <div id="collapse-4" class="panel-collapse collapse">
                        <div class="panel-body">
                           Kasa/banka hareketleri bir kere eklendikten sonra değişmez. Fakat silinebilir.
                        </div>
                    </div> <!-- /.panel-collapse -->
                </div> <!-- /.panel -->
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse-5">
                                Personel maaşlarını nasıl ödeyebilirim?
                            </a>
                        </h4>
                    </div> <!-- /.panel-heading -->
                    <div id="collapse-5" class="panel-collapse collapse">
                        <div class="panel-body">
                           Personel maaşlarını ödemek için işlem türü bölümünden manuel işlem sekmesine tıklayın ve menuel ödeme çıkışı yapın.
                        </div>
                    </div> <!-- /.panel-collapse -->
                </div> <!-- /.panel -->        
        	</div> <!-- /.panel-group -->   
        </div> <!-- /.content -->
    </div> <!-- /.widget -->
    
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->

<div class="h20"></div>

<script>
/* odeme turu yani "nakit,çek,banka havalesi" gibi değerler değiştiğinde gösterilecek kutular */
$('#payment_type').change(function() {
	$('#serial_no').removeClass('required');
	
	if($('#payment_type').val() == 'bank_transfer')
	{ 
		$('#bank_info').show('blonde'); 
		
		$('#optgroup_cashbox').attr('disabled', 'disabled'); 
		$('#optgroup_cashbox option').removeAttr('selected'); 
		$('#optgroup_bank').find('option:first').attr("selected",true);
		$.changeCashbox();
	}
	else
	{ 
		$('#bank_info').hide('blonde'); 
		
		$('#optgroup_cashbox').removeAttr('disabled'); 
		$('#optgroup_bank option').removeAttr('selected'); 
		$('#optgroup_cashbox').find('option:first').attr("selected",true);
		$.changeCashbox();
	}
	
});



/* kasa değiştiğinde çalışacak fonksiyon 
	kasa değiştiği zaman eski kasa bakiyesi güncellenmelidir.
*/
$.changeCashbox = function() {
	var cashbox_id = $('#cahsbox').val();
	var cashboxArray = [];
	<?php foreach($cashboxs as $cashbox): ?>
		cashboxArray[<?php echo $cashbox['id']; ?>] = "<?php echo $cashbox['val_decimal']; ?>";
	<?php endforeach; ?>
	<?php foreach($banks as $bank): ?>
		cashboxArray[<?php echo $bank['id']; ?>] = "<?php echo $bank['val_decimal']; ?>";
	<?php endforeach; ?>
	$('#cashbox_old_balance').val(parseFloat(cashboxArray[cashbox_id]).toFixed(2));
	calc_payment();
}
$('#cahsbox').change(function() { $.changeCashbox(); });



/* odeme kutularinin hesaplanmasi icin kullanilmaktadir
	odeme tutarına gore hesaplama yapilmaktadir. 
	bu hesaplamalarda kasada kalan parada hesaplanmaktadır.
 */
function calc_payment()
{
	var old_balance = $('#old_balance').val(); old_balance = old_balance.replace(',','');
	var cashbox_old_balance = $('#cashbox_old_balance').val(); old_balance = old_balance.replace(',','');
	var payment = $('#payment').val();
	
	if(old_balance == ''){old_balance = 0;}
	if(payment == ''){payment = 0;}
	
	<?php if(isset($_GET['in'])): ?>
		var new_balance = parseFloat(old_balance) - parseFloat(payment);
		var new_cashbox_balance = parseFloat(cashbox_old_balance) + parseFloat(payment);
		$('#new_balance').val(parseFloat(new_balance).toFixed(2));
		$('#cashbox_new_balance').val(parseFloat(new_cashbox_balance).toFixed(2));
	<?php else: ?>
		var new_balance = parseInt(old_balance) + parseFloat(payment);
		var new_cashbox_balance = parseFloat(cashbox_old_balance) - parseFloat(payment);
		$('#new_balance').val(parseFloat(new_balance).toFixed(2));
		$('#cashbox_new_balance').val(parseFloat(new_cashbox_balance).toFixed(2));
	<?php endif; ?>
}

/* islem turu secimi 
	islem turu secimi degistinde eger manuel odeme ise hesap karti secimi yapilmayacaktir.
*/
$.transaction_type_change = function() {
	$('#transaction_type_manual').hide();
	$('#transaction_type_account').hide();
	if($('#transaction_type').val() == 'account')
	{
		$('#transaction_type_manual').hide('');
		$('#transaction_type_account').show('slide');
		
		$('#account_id').addClass('required');	
		$('#account_name').addClass('required');	
		
		$('#name').removeClass('required');	
	}
	else if($('#transaction_type').val() == 'manual')
	{
		$('#transaction_type_account').hide('');
		$('#transaction_type_manual').show('slide');
		
		$('#account_id').removeClass('required');	
		$('#account_name').removeClass('required');	
		
		$('#name').addClass('required');	
	}
	else
	{
		return false;
	}	
}
$('#transaction_type').change(function() { $.transaction_type_change(); });


function account_click(click_item)
{
	$('#account_id').val($(click_item).find('.select_account').attr('data-id'));
    $('#account_name').val($(click_item).find('.select_account').attr('data-name'));
	$('#old_balance').val($(click_item).find('.select_account').attr('data-balance'));
}

$(document).ready(function(e) {
	
	/* hesap kartlarinin ajax aranmasi için kullanıacak fonksiyon */
	$('#account_name').keyup(function() {
		$('.typeHead').show();
		$.get("../search_account/"+$(this).val()+"", function( data ) {
		  $('.search_account').html(data);
		});
	});
	
	/* sayfa ilk yuklendiğinde kapanacak bölümler ve yapılacak işlemler */
	$('#bank_info').hide();
	$.transaction_type_change();
	$.changeCashbox();
});
</script>