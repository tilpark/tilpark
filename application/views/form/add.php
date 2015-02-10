<?php if(isset($_GET['sell'])){$text['in_out'] = get_lang('input');} else if(isset($_GET['buy'])){$text['in_out'] = get_lang('output');} else{exit('What is the purpose?');} ?>

<ol class="breadcrumb">
	<li><a href="<?php echo site_url(''); ?>"><?php lang('Dashboard'); ?></a></li>
	<li><a href="<?php echo site_url('form'); ?>">Form Yönetimi</a></li>
	<li class="active">
  	<?php if(isset($_GET['out'])): ?>
    	Yeni Çıkış/Satış Formu
    <?php elseif(isset($_GET['in'])): ?>
    	Yeni Giriş/Alış Formu
    <?php endif; ?>
	</li>
</ol>

<div class="row">
<div class="col-md-8">

<?php
if(@$formError) { alertbox('alert-danger', $formError);	 }
if(@$error) { alertbox('alert-danger', $error);	 }
?>

<form name="form_new_product" id="form_new_product" action="" method="POST" class="validation widget">
	<div class="header"><i class="fa fa-building-o"></i> <?php if(isset($_GET['buy'])): ?>
    	Yeni Giriş/Alış Formu
    <?php else: ?>
    	Yeni Çıkış/Satış Formu
    <?php endif; ?></div>
    <div class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date" class="control-label">Form Tarihi</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        <input type="text" id="date" name="date" class="form-control required datepicker pointer" placeholder="<?php lang('Start Date'); ?>" minlength="3" maxlength="50" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-6 -->
            <div class="col-md-8">
                <div class="form-group">
                    <input type="hidden" name="account_id" id="account_id" value="<?php echo $form['account_id']; ?>" />
                    <label for="account_name" class="control-label">Hesap Kartı</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-user"></span></span>
                        <input type="text" id="account_name" name="account_name" class="form-control required" placeholder="Hesap kartlarını arayarak seçebilirsin" maxlength="100" value="<?php echo $account['name']; ?>" autocomplete="off">
                        
                    </div>
                </div> <!-- /.form-group -->
                <div class="search_account typeHead"></div>
            </div> <!-- /.col-md-6 -->
        </div> <!-- /.content -->
    
    	<script>
		$(document).ready(function(e) {
			$('#account_name').keyup(function() {
				$('.typeHead').show();
				$.get("../search_account/"+$(this).val()+"", function( data ) {
				  $('.search_account').html(data);
				});
			});
        });
		</script>
    	
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description" class="control-label  "><?php lang('Description'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                        <input type="text" id="description" name="description" class="form-control  " placeholder="<?php lang('Description'); ?>" minlength="3" maxlength="50" value="<?php echo $form['description']; ?>">
                    </div>
                </div> <!-- /.form-group --> 
            </div> <!-- /.col-md-12 -->
        </div> <!-- /.row -->
        
        
        <div class="h20"></div>
        <div class="text-right">
            <input type="hidden" name="microtime" value="<?php echo logTime(); ?>" />
            <input type="hidden" name="add" />
            <button class="btn btn-default click_new_invoice"><?php lang('Next'); ?> &raquo;</button>
        </div> <!-- /.text-right -->
	</div> <!-- /.content -->
</form>

<?php if($form['account_id'] > 0): ?>
<script>$('.click_new_invoice').click();</script>
<?php endif; ?>
	
</div> <!-- /.col-md-8 -->
<div class="col-md-4">
	<div class="widget">
    	<div class="header"><i class="fa fa-bookmark-o"></i> Açıklama</div>
        <div class="content">
        	<p>Yeni fiş oluşturma paneline hoş geldin. Bu bölümde ürün/hizmet satabilir veya alabilirsin.</p>
            <p>Sol taraftaki panelden hesap kartını aratarak satış yada alış işlemlerine başlayabilirsin.</p>
            <p>Açıklama alanına fiş ile alakalı açıklama ekleyebilir veya boş bırakabilirsin.</p>
        </div>
    </div> <!-- /.widget -->
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->

<div class="h20"></div>


<script>
$('.openModal-account_list').click(function() {
	$('#modal-account_list').click();
});
</script>