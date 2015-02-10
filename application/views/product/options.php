<?php page_access(2); ?>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('product'); ?>">Stok Yönetimi</a></li>
  <li class="active">Seçenekler</li>
</ol>





<div class="row">
	<div class="col-md-6">
    
        <form name="form_product_options" id="form_product_options" action="" method="POST" class="">
        	<h3>Stok yönetimi ve yetkilendirme</h3>
        	<div class="content">
            	<div class="orange1">
        			<small>
                    <i class="fa fa-quote-left"></i> Eğer bir grup seçili ise bir üst grup o yetki seviyesine sahiptir. Örneğin: <br />
                        <ul class="square">
                            <li>
                                <strong>Kıdemli Personel</strong>'in erişim sağladığı bir bölüme, <strong>Bölüm Amiri</strong> ve üst seviye kullanıcılar erişebilir. Fakat <strong>Personel</strong> yetkisine sahip kullanıcı <span style="text-decoration:underline;">erişemez</span>.
                            </li>
                            <li>
                                <strong>Yönetici</strong> yetkisine sahip kullanıcı'nın erişim sağladığı alana, <strong>Süper Yönetici</strong> erişebilir. Fakat <strong>Yönetici</strong> yetkisinin altındaki kullanıcılar, Personel, Kıdemli Personel ve Bölüm Amiri <span style="text-decoration:underline;">erişemez</span>.
                            </li>
                        </ul>
                    </small>
        		</div>
                <div class="h10"></div>
                
                <div class="form-group">
                    <label for="product_cost_price" class="control-label">Maliyet fiyatlarını kimler görebilir?</label>
                    <select name="product_cost_price" id="product_cost_price" class="form-control valid custom">
                        <option value="5" <?php if(@$GLOBALS['access']['product_cost_price']['val_1']==5){echo'selected';} ?>>Herkes</option>
                        <option value="4" <?php if(@$GLOBALS['access']['product_cost_price']['val_1']==4){echo'selected';} ?>>Kıdemli personel ve üstü</option>
                        <option value="3" <?php if(@$GLOBALS['access']['product_cost_price']['val_1']==3){echo'selected';} ?>>Bölüm amiri ve üstü</option>
                        <option value="2" <?php if(@$GLOBALS['access']['product_cost_price']['val_1']==2){echo'selected';} ?>>Yönetici ve süper yönetici</option>
                        <option value="1" <?php if(@$GLOBALS['access']['product_cost_price']['val_1']==1){echo'selected';} ?>>Sadece süper yönetici</option>                      
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="product_profit_rate" class="control-label">Kar oranı ve tutarını görebilir mi?</label>
                    <select name="product_profit_rate" id="product_profit_rate" class="form-control valid">
                        <option value="5" <?php if(@$GLOBALS['access']['product_profit_rate']['val_1']==5){echo'selected';} ?>>Herkes</option>
                        <option value="4" <?php if(@$GLOBALS['access']['product_profit_rate']['val_1']==4){echo'selected';} ?>>Kıdemli personel ve üstü</option>
                        <option value="3" <?php if(@$GLOBALS['access']['product_profit_rate']['val_1']==3){echo'selected';} ?>>Bölüm amiri ve üstü</option>
                        <option value="2" <?php if(@$GLOBALS['access']['product_profit_rate']['val_1']==2){echo'selected';} ?>>Yönetici ve süper yönetici</option>
                        <option value="1" <?php if(@$GLOBALS['access']['product_profit_rate']['val_1']==1){echo'selected';} ?>>Sadece süper yönetici</option>     
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="product_edit_button" class="control-label">Stok kartlarını kimler düzenleyebilir?</label>
                    <select name="product_edit_button" id="product_edit_button" class="form-control valid">
                        <option value="5" <?php if(@$GLOBALS['access']['product_edit_button']['val_1']==5){echo'selected';} ?>>Herkes</option>
                        <option value="4" <?php if(@$GLOBALS['access']['product_edit_button']['val_1']==4){echo'selected';} ?>>Kıdemli personel ve üstü</option>
                        <option value="3" <?php if(@$GLOBALS['access']['product_edit_button']['val_1']==3){echo'selected';} ?>>Bölüm amiri ve üstü</option>
                        <option value="2" <?php if(@$GLOBALS['access']['product_edit_button']['val_1']==2){echo'selected';} ?>>Yönetici ve süper yönetici</option>
                        <option value="1" <?php if(@$GLOBALS['access']['product_edit_button']['val_1']==1){echo'selected';} ?>>Sadece süper yönetici</option>     
                    </select>
                </div>
                      
               <div class="h10"></div>
                <div class="text-right">    
                    <input type="hidden" name="update_options" /> 
                    <button class="btn btn-default"><?php lang('Save'); ?></button> 
                </div> <!-- /.text-right -->
        	</div> <!-- /.content -->      
        </form>
	</div> <!-- /.col-md-6 -->
    <div class="col-md-6">
        <form name="form_settings" id="form_settings" action="?" method="POST" class="validation_2">

                <h3>Barkod yazdırma ayarları</h3>
                <div class="orange1">

                    <small>Örnek renk kodları: <strong>beyaz</strong>[#FFF], <strong>siyah</strong>[#000], <strong>kırmızı</strong>[#F00], <strong>gri</strong>[#CCC]</small>
                </div>
                <div class="h10"></div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="product_barcode_box_width" class="control-label">Kutu genişliği (mm)</label>
                        <input type="text" name="product_barcode_box_width" id="product_barcode_box_width" class="required digits" value="<?php echo get_setting('product_barcode_box_width'); ?>" />
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-4">
                        <label for="product_barcode_box_height" class="control-label">Kutu yüksekliği (mm)</label>
                        <input type="text" name="product_barcode_box_height" id="product_barcode_box_height" class="required digits" value="<?php echo get_setting('product_barcode_box_height'); ?>" />
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-4">
                        <label for="product_barcode_box_border_color" class="control-label">Çerçeve rengi</label>
                        <input type="text" name="product_barcode_box_border_color" id="product_barcode_box_border_color" class="" value="<?php echo get_setting('product_barcode_box_border_color'); ?>" />
                    </div> <!-- /.col-md-4 -->
                </div> <!-- /.row -->

                <div class="row">
                    <div class="col-md-4">
                        <label for="product_barcode_width" class="control-label">Barkod genişliği (mm)</label>
                        <input type="text" name="product_barcode_width" id="product_barcode_width" class="required digits" value="<?php echo get_setting('product_barcode_width'); ?>" />
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-4">
                        <label for="product_barcode_height" class="control-label fs-12">Barkod yüksekliği (mm)</label>
                        <input type="text" name="product_barcode_height" id="product_barcode_height" class="required digits" value="<?php echo get_setting('product_barcode_height'); ?>" />
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-4">
                        <label for="product_barcode_border_color" class="control-label">Çerçeve rengi</label>
                        <input type="text" name="product_barcode_border_color" id="product_barcode_border_color" class="" value="<?php echo get_setting('product_barcode_border_color'); ?>" />
                    </div> <!-- /.col-md-4 -->
                </div> <!-- /.row -->


                <div class="row">
                    <div class="col-md-8">
                        <label for="product_barcode_name" class="control-label">Stok adını göster</label>
                        <select name="product_barcode_name" id="product_barcode_name" class="form-control">
                            <option value="0" <?php if(get_setting('product_barcode_name') == '0'): ?>selected<?php endif; ?>>Stok adını gizle</option>
                            <option value="1" <?php if(get_setting('product_barcode_name') == '1'): ?>selected<?php endif; ?>>Stok adını göster</option>
                        </select>
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-4">
                        <label for="product_barcode_name_font_size" class="control-label">Yazı boyutu (px)</label>
                        <input type="text" name="product_barcode_name_font_size" id="product_barcode_name_font_size" class="col-md-2" value="<?php echo get_setting('product_barcode_name_font_size'); ?>" />
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->

                <div class="h20"></div>
                <div class="text-right">
                    <input type="hidden" name="update_product_options">
                    <button class="btn btn-default">Kaydet</button>
                </div>
            </div> <!-- /.content -->
        </form>
    </div>
</div> <!-- /.row -->