<?php if(@!$product): ?>
    <h3 class="line text-danger"><i class="fa fa-warning"></i> Stok Kartı Yok!</h3>
    <ul class="sugar">
        <li>Aradığın stok kartı bulunamadı.</li>
        <li>Stok ID numarası yada stok barkod kodu yanlış yazılmış olabilir.</li>
        <li class="text-warning">Sizin için silinmiş stok kartları arasında arama yaptık fakat bulamadık. "<?php echo $this->uri->segment(3); ?>" ID veya barkod koduna ait hesap kartı bulunamadı.</li>
        <li>Daha fazla ayrıntı için <a href="http://tilpark.com" target="">Tilpark</a> web sitesini ziyaret edebilir ve Tilpark forumlarında konuyu tartışabilirsin.</li>
    </ul>
<?php else: ?>




<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#product_card" data-toggle="tab"><i class="fa fa-folder-o"></i> Ürün Kartı</a></li>
    <li><a href="#forms" data-toggle="tab"><i class="fa fa-shopping-cart"></i> Giriş-Çıkış</a></li>
    <li><a href="#history" data-toggle="tab"><i class="fa fa-keyboard-o"></i> Geçmiş</a></li>
    <li class="dropdown pull-right">
    	<a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-asterisk"></i> Seçenekler <b class="caret"></b></a>
    	<ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">   
        	<li><a href="<?php echo site_url('product/print_barcode/'.$product['id']); ?>?print"><i class="fa fa-barcode mr9"></i>Barkod yazdır</a></li>
            <li class="divider"></li>
            <?php if($product['status'] == '1'): ?>
                <li><a href="?status=<?php echo base64_encode('0'); ?>"><i class="fa fa-trash text-danger"></i>Stok kartını sil</a></li>
            <?php else: ?>
                <li><a href="?status=<?php echo base64_encode('1'); ?>"><i class="fa fa-check-square-o text-success"></i>Aktifleştir</a></li>
            <?php endif; ?>
        </ul>
    </li>
</ul>

<div id="myTabContent" class="tab-content">

<!-- start: product card -->
<div class="tab-pane fade active in" id="product_card">
<div class="row">
<div class="col-md-8">

    <form name="form_new_product" id="form_new_product" action="?" method="POST" class="validation"> 
        <h3><i class="fa fa-puzzle-piece"></i> Stok Kartı Yönetimi</h3>
        
        <div class="row">
            <div class="col-md-6">
                
                <div class="form-group">
                    <label for="code" class="control-label ff-1 fss-16">Stok Kodu</label>
                    <div class="input-prepend input-group">
                        <i class="input-group-addon"><i class="fa fa-barcode"></i></i>
                        <input type="text" id="code" name="code" class="form-control  ff-1" placeholder="stok kodu" minlength="3" maxlength="32" value="<?php echo $product['code']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label ff-1 fss-16">Stok Adı</label>
                    <div class="input-prepend input-group">
                        <i class="input-group-addon"><i class="fa fa-text-width"></i></i>
                        <input type="text" id="name" name="name" class="form-control  ff-1 required" placeholder="stok/ürün adı" minlength="3" maxlength="100" value="<?php echo $product['name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="control-label ff-1 fss-16">Stok Açıklaması</label>
                    <div class="input-prepend input-group">
                        <i class="input-group-addon"><i class="fa fa-comment"></i></i>
                        <textarea id="description" name="description" class="form-control  ff-1" placeholder="ürün kartına ait bir açıklama" style="height:91px;"><?php echo $product['description']; ?></textarea>
                    </div>
                </div>
        
                                  
            </div> <!-- /.col-md-4 -->
            <div class="col-md-6">
                

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tax_free_cost_price" class="control-label ff-1 fs-12">Maliyet Fiyatı Kdv Hrç.</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-try"></span></span>
                                <input type="text" id="tax_free_cost_price" name="tax_free_cost_price" class="form-control number text-right" placeholder="0.00" value="<?php echo get_money($product['tax_free_cost_price']); ?>" disabled="disabled">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cost_price" class="control-label ff-1 fs-12">Maliyet Fiyatı Kdv Dhl.</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-try fs-16"></span></span>
                                <input type="text" id="cost_price" name="cost_price" class="form-control ff-1 number text-right" placeholder="0.00" value="<?php echo get_money($product['cost_price'], array('virgule'=>false)); ?>">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tax_free_sale_price" class="control-label ff-1 fs-12">Satış Fiyatı Kdv Hariç</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-try"></span></span>
                                <input type="text" id="tax_free_sale_price" name="tax_free_sale_price" class="form-control number text-right" placeholder="0.00" value="<?php echo get_money($product['tax_free_sale_price']); ?>" disabled="disabled">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="form-group has-success">
                            <label for="sale_price" class="control-label ff-1 fs-12">Satış Fiyatı Kdv Dahil</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-try fs-16"></span></span>
                                <input type="text" id="sale_price" name="sale_price" class="form-control ff-1 number text-right fs-16" placeholder="0.00" value="<?php echo get_money($product['sale_price'], array('virgule'=>false)); ?>">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->
                
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tax" class="control-label ff-1 fs-12">Kdv Tutarı</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-try"></span></span>
                                <input type="text" id="tax" name="tax" class="form-control number text-right" placeholder="0.00" value="<?php echo get_money($product['tax']); ?>" disabled="disabled">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tax_rate" class="control-label ff-1 fs-12">Kdv Oranı</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><i class="fa">%</i></span>
                                <input type="text" id="tax_rate" name="tax_rate" class="form-control ff-1 number text-right" placeholder="0.00" value="<?php echo $product['tax_rate']; ?>">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->

                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tax" class="control-label ff-1 fs-12">Karlılık Oranı</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><i class="fa">%</i></span>
                                <input type="text" id="tax" name="tax" class="form-control number text-right" placeholder="0.00" value="<?php echo @number_format((($product['tax_free_sale_price'] - $product['tax_free_cost_price'])/$product['tax_free_cost_price']) * 100, 0, '', ''); ?>" disabled="disabled">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="form-group <?php if(($product['tax_free_sale_price'] - $product['tax_free_cost_price']) < 0): ?>has-error<?php endif; ?>">
                            <label for="tax_rate" class="control-label ff-1 fs-12">Kar Tutarı</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-try"></span></span>
                                <input type="text" id="tax_rate" name="tax_rate" class="form-control ff-1 number text-right" placeholder="0.00" value="<?php echo get_money($product['tax_free_sale_price'] - $product['tax_free_cost_price']); ?>" disabled="disabled">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->

                
                

                <label for="unit">Birim</label>
                <select name="unit" id="unit" class="form-control">
                    <option value="number" <?php selected($product['unit'], 'number'); ?>>ADET</option>
                    <option value="gram" <?php selected($product['unit'], 'gram'); ?>>GRAM</option>
                    <option value="kilogram" <?php selected($product['unit'], 'kilogram'); ?>>KILOGRAM</option>
                    <option value="ton" <?php selected($product['unit'], 'ton'); ?>>TON</option>
                    <option value="millimeter" <?php selected($product['unit'], 'millimeter'); ?>>MILIMETRE</option>
                    <option value="centimeter" <?php selected($product['unit'], 'centimeter'); ?>>SANTIMETRE</option>
                    <option value="meter" <?php selected($product['unit'], 'meter'); ?>>METRE</option>
                    <option value="parcel" <?php selected($product['unit'], 'parcel'); ?>>KOLI</option>
                </select>
             
            </div> <!-- /.col-md- -->
        </div> <!-- /.row -->


        	
        <div class="h20"></div>
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <?php if($product['status'] == 1): ?>
                    <input type="hidden" name="log_time" value="<?php echo logTime(); ?>" />
                    <input type="hidden" name="update_product" />
                    <button class="btn btn-default btn-block"><i class="fa fa-save"></i> Güncelle</button>
                <?php endif; ?>
            </div> <!-- /.col-md-3 -->
        </div> <!-- /.row -->

	</form>
    
    
    
    <div class="h20"></div>
    <div class="bodyLine"></div>
    <div class="h20"></div>
    
    <!-- start: fotograf galerisi -->
    <form name="form_gallery" id="form_gallery" action="?" method="POST" enctype="multipart/form-data" class="validation_2">
    	<h3><i class="fa fa-puzzle-piece"></i> Ürün Görseli - Fotoğraf Galerisi</h3>
    	<div class="content">
            
            <div class="row">
                <div class="col-md-9">
                    <input type="file" name="image" id="image" class="form-control required" />
                </div> <!-- /.col-md-8 -->
                <div class="col-md-3">
                    <input type="hidden" name="log_time" value="<?php echo logTime(); ?>" />
                    <button class="btn btn-default btn-block"><i class="fa fa-upload"></i> Resim Yükle</button>
                </div> <!-- /.col-md-4 -->
            </div> <!-- /.row -->
            
            <div class="h20"></div>
            
            
            <?php
			// urun gorsellerini buradaki fonksiyon ile cekiyoruz
			$this->db->where('product_id', $product['id']);
			$this->db->where('group', 'gallery');
			$this->db->order_by('id', 'ASC');
			$product_gallery = $this->db->get('product_meta')->result_array();
            if($product_gallery)
            {
				?><div class="row"> <?php
                foreach($product_gallery as $image): ?>
                <div class="col-md-3 product_image_gallery" style="margin-bottom:10px;">
                    <a href="<?php echo base_url('uploads/products/'.$product['id'].'/'.$image['key']); ?>" class="img-thumbnail image_zoom<?php echo $image['id']; ?>" data-lightbox="image-1" <?php if($image['val_text'] == 'default_image'): ?>style="border:1px solid #999;"<?php endif; ?>>
                        <img class="img-responsive product_image" src="<?php echo base_url('uploads/products/'.$product['id'].'/'.$image['key']); ?>" />
                    </a>
                    
                    <div class="image_hover">
                        <a href="javascript:;" onclick="$('.image_zoom<?php echo $image['id']; ?>').click();" class="fs-18 btn btn-success btn-xs" title="Görseli büyüt"><i class="fa fa-picture-o"></i></a>
                        <a href="?default_image=<?php echo $image['id']; ?>" class="fs-18 btn btn-warning btn-xs" title="Varsayılan görsel yap"><i class="fa fa-check-square-o"></i></a>
                        <a href="?delete_product_image=<?php echo $image['id']; ?>" class="fs-18 btn btn-danger btn-xs" title="Görseli sil"><i class="fa fa-trash-o"></i></a>
                    </div> <!-- /.image_hover -->
                </div> <!-- /.col-md-3 -->
                <?php endforeach; ?>
                </div> <!-- /.row -->
                <style>
				.product_image_gallery .image_hover {
					display:none;
					position:absolute;
					margin-top:-46px;
					margin-left:10px;
				}
				.product_image_gallery:hover > a {
					background-color:#333;
				}
				.product_image_gallery:hover > a .product_image {
					opacity:0.3;
				}
				.product_image_gallery:hover > .image_hover {
					display:block;
				}
				</style>
                 <?php
            }
            else
            {
                ?>
                <i class="fa fa-file-image-o text-muted fs-36 pull-left"></i>
                <h3 style="font-weight:normal;" class="text-muted">ürün görseli bulunamadı! <br /><small>yukarıdaki menüden ürün görseli ekleyebilirsin.</small></h3>
                <?php
            }
            ?>
            
        </div> <!-- /.content -->
    </form> <!-- /#form_gallery .widget-->
    <!-- /finish: fotograf galerisi -->

	

</div> <!-- /.col-md-8 -->
<div class="col-md-4">    
    
    <!-- start: sidebar -->
	<div class="widget">
    	<div class="header dark_gray"><i class="fa fa-puzzle-piece"></i> Stok Kartına Genel Bakış</div>
        <div class="content">


            <?php if($product['amount'] < 0): ?>
                <div class="row stat">
                    <div class="col-md-2">
                        <i class="fa fa-sort-numeric-desc text-danger"></i>
                    </div>
                    <div class="col-md-10">
                        <div class="value"><span class="<?php if($product['amount'] < 0): ?>text-danger<?php else: ?>text-success<?php endif; ?>"><?php echo get_quantity($product['amount']); ?></span></div>
                        <div class="title"><?php unit_name($product['unit']); ?>  stok lazım</div>
                        <small class="text-danger">stok miktarı (-)eksi değere düşmüş</small>
                    </div>
                </div> <!-- /.row stat -->


                <div class="row stat">
                    <div class="col-md-2">
                        <i class="fa fa-try text-warning"></i>
                    </div>
                    <div class="col-md-10">
                        <div class="value"><span class="text-warning"><?php echo get_money($product['amount'] * $product['cost_price']); ?> <i class="fa fa-try fs-16"></i></span></div>
                        <div class="title">satın alma değeri</div>
                        <small class="text-warning">alış değerinde stok alman gerekiyor</small>
                    </div>
                </div> <!-- /.row stat -->

            <?php else: ?>
                <div class="row stat">
                    <div class="col-md-2">
                        <i class="fa fa-sort-numeric-asc text-success"></i>
                    </div>
                    <div class="col-md-10">
                        <div class="value"><span class="<?php if($product['amount'] < 0): ?>text-danger<?php else: ?>text-success<?php endif; ?>"><?php echo get_quantity($product['amount']); ?></span></div>
                        <div class="title"><?php unit_name($product['unit']); ?>  stok var</div>
                        <small class="text-muted">stok bulunmakta</small>
                    </div>
                </div> <!-- /.row stat -->
                <div class="row stat">
                    <div class="col-md-2">
                        <i class="fa fa-try "></i>
                    </div>
                    <div class="col-md-10">
                        <div class="value"><?php echo get_money($product['amount'] * $product['sale_price']); ?></div>
                        <div class="title">satış değeri</div>
                        <small class="text-muted">satış değerinde stok bulunmakta, ayrıca <?php echo get_money($product['amount'] * $product['cost_price']); ?> maliyet değeri</small>
                    </div>
                </div> <!-- /.row stat -->
            <?php endif; ?>

            <!-- bu urunden bu gune kadar kac tane satildi -->
            <div class="row stat">
                <div class="col-md-2">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="col-md-10">
                    <?php
                        $this->db->where('status', 1);
                        $this->db->where('product_id', $product['id']);
                        $this->db->where('in_out', 'out');
                        $this->db->select_sum('quantity');
                        $sale_quantity = $this->db->get('form_items')->row_array();
                        if($sale_quantity['quantity'] < 1){$sale_quantity['quantity'] = 0;}
                    ?>
                    <div class="value"><?php echo get_quantity($sale_quantity['quantity']); ?></div>
                    <div class="title"><?php unit_name($product['unit']); ?> satıldı</div>
                    <small class="text-muted">bu güne kadar satılan ürün sayısı</small>
                </div>
            </div> <!-- /.row stat -->

            <!-- bu urunden bu gune kadar kac tane satildi -->
            <div class="row stat">
                <div class="col-md-2">
                    <i class="fa fa-money"></i>
                </div>
                <div class="col-md-10">
                    <div class="value"><?php echo get_money($product['profit']); ?></div>
                    <div class="title">net kazanç</div>
                    <small class="text-muted">bu ürün satışından bu güne kadar kazanılan para</small>
                </div>
            </div> <!-- /.row stat -->
            
        </div> <!-- /.content -->
    </div> <!-- /.widget -->
    <div class="h20"></div>



    <div class="widget">
        <div class="header"><i class="fa fa-picture-o mr5"></i> Varsayılan Ürün Görseli</div>
        <div class="content">
            <?php $default_image = get_product_meta(array('product_id'=>$product['id'], 'group'=>'gallery', 'val_text'=>'default_image')); ?>
            <?php if($default_image): ?>
                <img src="<?php echo base_url('uploads/products/'.$product['id'].'/'.$default_image['key']); ?>" class="img-responsive" />
            <?php else: ?>
                <div class="row">
                    <div class="col-md-2">
                        <i class="fa fa-file-image-o text-muted fs-36 pull-left"></i>
                    </div> <!-- /.ol-md-4 -->
                    <div class="col-md-10">
                        <h4 style="font-weight:normal;" class="text-muted">varsayılan ürün görseli bulunamadı!</h4>
                    </div> <!-- /.col-md-8 -->
                </div> <!-- /.row -->
            <?php endif; ?>
            
        </div> <!-- /.content -->
    </div> <!-- /.widget -->
    <div class="h20"></div>
    
	<div class="widget">
    	<div class="header dark_gray"><span class="glyphicon glyphicon-barcode mr5"></span> Barkod</div>
        <div class="content padding-4">
            <a href="<?php echo site_url('product/print_barcode/'.$product['id']); ?>?print" class="img-thumbnail text-center" style="width:100%;">
                <div style="height:4px;"></div>
                <img src="<?php echo get_barcode($product['code']); ?>" class="img-responsive" />
            </a>
        </div> <!-- /.content -->
   </div> <!-- /.widget -->

   <!-- finish: sidebar -->
    
    
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->


</div><!-- /#product card -->












<!-- start: stok kartına ait giriş çıkış fişleri buradan listelenmekte -->
<div class="tab-pane fade" id="forms">
    
    <?php $accounts = get_accounts(); ?>
    <table class="table table-bordered table-hover table-condensed dataTable">
    	<thead>
        	<tr>
            	<th class="hide"></th>
            	<th width="60">Fiş ID</th>
                <th width="120">Tarih</th>
                <th width="60">G/Ç</th>
                <th>Hesap Kartı</th>
                <th width="60">Adet</th>
                <th width="80">B.Fiyatı</th>
                <th width="80">Toplam</th>
                <th width="100">Kdv</th>
                <th width="100">Giriş</th>
                <th width="100">Çıkış</th>
            </tr>
        </thead>
        <tbody>
        <?php $form_items = get_form_items(array('status'=>1, 'product_id'=>$product['id'], 'order_by'=>'ID ASC')); ?>
        <?php
    	$total['input'] = 0;
    	$total['output'] = 0;
    	?>
        <?php foreach($form_items as $item): ?>
        	<tr>
            	<td class="hide"></td>
            	<td class="fs-11"><a href="<?php echo site_url('form/view/'.$item['form_id']); ?>">#<?php echo $item['form_id']; ?></a></td>
                <td class="fs-11"><?php echo substr($item['date'],0,16); ?></td>
                <td class="text-muted"><small><?php echo strtoupper(replace_TR(get_text_in_out($item['in_out']))); ?></small></td>
                <td class="fs-11"><a href="<?php echo site_url('account/get_account/'.$item['account_id']); ?>" target="_blank"><?php echo $accounts[$item['account_id']]['name']; ?></a></td>
                <td class="text-center"><?php echo get_quantity($item['quantity']); ?></td>
                <td class="text-right fs-11"><?php echo get_money($item['tax_free_sale_price']); ?></td>
                <td class="text-right fs-11"><?php echo get_money($item['total']); ?></td>
                <td class="text-right fs-11"><small class="text-muted">%<?php echo $item['tax_rate']; ?></small> <?php echo get_money($item['tax']); ?></td>
                <?php if($item['in_out'] == 'out'): ?>
                	<td class="text-right"><?php echo get_money($item['sub_total']); ?></td>
                    <td></td>
                    	<?php $total['output'] = $total['output'] + $item['sub_total']; ?>
                <?php else: ?>
                	<td></td>
                	<td class="text-right"><?php echo get_money($item['sub_total']); ?></td>
                    	<?php $total['input'] = $total['input'] + $item['sub_total']; ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        	<tr>
            	<th colspan="8"></th>
                <th class="text-right"><?php echo get_money($total['output']); ?></th>
                <th class="text-right"><?php echo get_money($total['input']); ?></th>
            </tr>
        </tfoot>
    </table> <!-- /.table -->
</div> <!-- /#forms -->
<!-- finish: stok kartına ait giriş çıkış fişleri buradan listelenmekte -->





<!-- start: log -->
<div class="tab-pane fade in" id="history">
	<?php get_log_table(array('product_id'=>$product['id']), 'DESC'); ?>
</div> <!-- /#history -->
<!-- finish: log -->




</div> <!-- /#myTabContent -->

<?php endif; ?>