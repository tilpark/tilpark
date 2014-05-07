<ol class="breadcrumb">
  <li><a href="<?php echo site_url(); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('account'); ?>">Hesap Yönetimi</a></li>
  <li class="active">Yeni Hesap Kartı</li>
</ol>



<div class="row">
<div class="col-md-8">


<?php
if(isset($success['add_account'])){alertbox('alert-success', 'Hesap Kartı Eklendi', '"'.$account['code'].'" yeni bir hesap kartı eklendi.');}
if(@$formError) { alertbox('alert-danger', $formError);	 }
if(@$haveBarcode) { alertbox('alert-danger', '"'.$account['code'].'" Barkod kodu başka bir ürün kartında bulundu.', 
	'Başka bir ürün kartı "'.$account['code'].'" barkod kodunu kullanıyor. <br/> Barkod kodları eşsiz olmalı ve sadece bir ürün kartına ait olmalı.');	 }
?>
	
    <form name="form_new_product" id="form_new_product" action="" method="POST" class="validation">
    	<h3><i class="fa fa fa-puzzle-piece"></i> Yeni Hesap Kartı</h3>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="code" class="control-label">Hesap Kodu <small class="text-muted">barkod kodu</small></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                        <input type="text" id="code" name="code" class="form-control" minlength="3" maxlength="30" value="<?php echo $account['code']; ?>" autocomplete="off">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-6 -->
            <div class="col-md-6">
            	<div class="form-group">
                    <label for="name" class="control-label">Hesap Kartı <small class="text-muted">firma adı</small></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                        <input type="text" id="name" name="name" class="form-control required" minlength="3" maxlength="50" value="<?php echo $account['name']; ?>" autocomplete="off">
                    </div>
                </div>  
                <div class="form-group">
                    <label for="name_surname" class="control-label">Ad ve Soyad</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                        <input type="text" id="name_surname" name="name_surname" class="form-control" value="<?php echo $account['name_surname']; ?>" minlengt="3" maxlength="30" autocomplete="off">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-6 -->
        </div> <!-- /.row -->
    
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="phone" class="control-label">Telefon</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                        <input type="text" id="phone" name="phone" class="form-control digits" minlength="7" maxlength="11" value="<?php echo $account['phone']; ?>">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="gsm" class="control-label">Gsm</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-mobile-phone"></span></span>
                        <input type="text" id="gsm" name="gsm" class="form-control digits" minlength="7" maxlength="11" value="<?php echo $account['gsm']; ?>">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="email" class="control-label">E-Posta</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                        <input type="text" id="email" name="email" class="form-control email" minlength="6" maxlength="50" value="<?php echo $account['email']; ?>">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
        </div> <!-- /.row -->
    
    
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="address" class="control-label">Adres</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                       <textarea class="form-control" name="address" id="address" style="height:94px;" minlength="3" maxlength="250"><?php echo $account['address']; ?></textarea>
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- col-md-8 -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="county" class="control-label">İlçe</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                        <input type="text" id="county" name="county" class="form-control  " minlength="2" maxlength="20" value="<?php echo $account['county']; ?>">
                    </div>
                </div> <!-- /.form-group -->
                <div class="form-group">
                    <label for="city" class="control-label">İl</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                        <input type="text" id="city" name="city" class="form-control  " minlength="2" maxlength="20" value="<?php echo $account['city']; ?>">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
        </div> <!-- /.row -->
    
    
        <div class="form-group">
            <label for="description" class="control-label">Açıklama</label>
            <div class="input-prepend input-group">
                <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
               <textarea class="form-control" name="description" id="description" maxlength="500"><?php echo $account['description']; ?></textarea>
            </div>
        </div> <!-- /.form-group -->
        
        <div class="h20"></div>
        
        <div class="text-right">
            <input type="hidden" name="microtime" value="<?php echo logTime(); ?>" />
            <input type="hidden" name="add" />
            <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Temizle</button>
            <button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Kaydet</button>
        </div> <!-- /.text-right -->
    </form>

    
	
</div> <!-- /.col-md-8 -->
<div class="col-md-4">
<div class="widget">
	<div class="header">Açıklama</div>
	<div class="content padding-5">
        <p>Yeni hesap kartı açma alanında, müşteriler, bayiler, toptancılar, tedarikci firmalar ve imalatçıları ekleyebilirsin.</p>
        <p>Daha sonra bu hesaplara ödeme/çek verebilir ve alabilirsin. Ürün satabilir ve satın alabilirsin.</p>
        <p>Hesap Kodu kutusu boş bırakılır ise otomatik oluşacaktır.</p>
	</div> <!-- /.content -->
</div> <!-- /.widget -->
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->

<div class="h20"></div>