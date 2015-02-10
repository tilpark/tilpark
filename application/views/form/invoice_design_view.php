<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>"><?php lang('Dashboard'); ?></a></li>
  <li><a href="<?php echo site_url('invoice'); ?>"><?php lang('Buying-Selling'); ?></a></li>
  <li class="active"><?php lang('Invoice Design'); ?></li>
</ol>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<style>
.page {
	background-color:#F3F3F3;
	border:1px solid #ccc;
	width:100%;
	height:1000px;
}
.print_option {
	background-color:#E6E6E6;
	width:250px;
	padding:0px 10px 3px 10px;
	cursor:all-scroll;
	position:absolute;
	border:1px solid #5B5B5B;
}
.print_option:hover {
	border:1px solid #5B5B5B;
	background-color:#CCC;
}
.print_option input{
	border:0px;
	padding:0px 10px;
	font-size:12px;
	margin-left:10px;
}
.print_option textarea{
	border:0px;
	padding:0px 10px;
	font-size:12px;
	margin-left:10px;
	margin-top:3px;
}
.print_option .glyphicon {
	font-size:16px;
}
.print_option .glyphicon-remove {
	color:#f00;
	cursor:pointer;
}
.print_menu_box {
	background-color:#E4C79A;
	padding:10px;
}
.startbox {
	background-color:#F3EBCA;
	padding:10px;
	height:60px;
}

.zindex {
	z-index:99999;
}
</style>


<?php

/* OTOMATİK BOYUTLANDIRMA */
if(isset($_GET['position_left']))
{
	$page = get_option(array('option_group'=>'print_invoice_form_page','option_key'=>'page'));
	$page['option_group'] = 'print_invoice_form_page';
	$page['option_key'] = 'page';
	$page['option_value2'] = $_GET['position_left'];
	$page['option_value3'] = $page['option_value3'];
	update_option($page);
	
	redirect(site_url('invoice/invoice_design'));
}

if(isset($_GET['position_top']))
{
	$page = get_option(array('option_group'=>'print_invoice_form_page','option_key'=>'page'));
	$page['option_group'] = 'print_invoice_form_page';
	$page['option_key'] = 'page';
	$page['option_value2'] = $page['option_value2'];
	$page['option_value3'] = $_GET['position_top'];
	update_option($page);
	
	redirect(site_url('invoice/invoice_design'));
}


/* ÖRNEK VERİ YÜKLEMESİ */
if(isset($_GET['example']))
{
	$_DENEME['print_value'] = '';
	$_DENEME['print_value'][0] = '{Tarih:}[INV_date]';
	$_DENEME['print_value'][1] = '{Açıklama:}[INV_description]';
	$_DENEME['print_value'][2] = '{İlçe:}[ACC_county]';
	$_DENEME['print_value'][3] = '{Adres:}[ACC_address]';
	$_DENEME['print_value'][4] = '[ITM_items]';
	$_DENEME['print_value'][5] = '{Fiş NO:}[INV_id]';
	$_DENEME['print_value'][6] = '{Hesap Kartı:}[ACC_name]';
	$_DENEME['print_value'][7] = '{Şehir:}[ACC_city]';

	$_DENEME['hidden_print_value'] = '';
	$_DENEME['hidden_print_value'][0] = '155.5:275';
	$_DENEME['hidden_print_value'][1] = '156.5:306';
	$_DENEME['hidden_print_value'][2] = '469.5:307';
	$_DENEME['hidden_print_value'][3] = '470.5:276';
	$_DENEME['hidden_print_value'][4] = '158.5:447';
	$_DENEME['hidden_print_value'][5] = '157:242';
	$_DENEME['hidden_print_value'][6] = '469.5:244';
	$_DENEME['hidden_print_value'][7] = '471.5:340';

    $_DENEME['width_code'] = '150';
    $_DENEME['width_name'] = '150';
    $_DENEME['width_quantity'] = '20';
    $_DENEME['width_quantity_price'] = '60';
    $_DENEME['width_total'] = '60';
    $_DENEME['width_tax_rate'] = '60';
    $_DENEME['width_tax'] = '60';
    $_DENEME['width_sub_total'] = '80';
    $_DENEME['custom_css'] = '.kirmiziYap {color:#f00;}';
	
	$_POST = $_DENEME;
}


if(isset($_POST['print_value']) or isset($_POST['textarea']))
{
	
	// eski verileri siliyoruz
	$this->db->where('option_group', 'print_invoice_form');
	$this->db->delete('options');
	$this->db->where('option_group', 'print_invoice_form_custom_text');
	$this->db->delete('options');
	
	
	/* OTOMATİK BOYUTLANDIRMA 
		#ürünler malzemeler tablosunun öğrelerinin genişliklerini ayarlıyoruz.
	*/
	$data['option_group'] = 'print_invoice_form_item_width';
	
	$data['option_key'] = 'width_code';
	$data['option_value'] = $_POST['width_code'];
	update_option($data);
	
	$data['option_key'] = 'width_name';
	$data['option_value'] = $_POST['width_name'];
	update_option($data);
	
	$data['option_key'] = 'width_quantity';
	$data['option_value'] = $_POST['width_quantity'];
	update_option($data);
	
	$data['option_key'] = 'width_quantity_price';
	$data['option_value'] = $_POST['width_quantity_price'];
	update_option($data);
	
	$data['option_key'] = 'width_total';
	$data['option_value'] = $_POST['width_total'];
	update_option($data);
	
	$data['option_key'] = 'width_tax_rate';
	$data['option_value'] = $_POST['width_tax_rate'];
	update_option($data);
	
	$data['option_key'] = 'width_tax';
	$data['option_value'] = $_POST['width_tax'];
	update_option($data);
    
    $data['option_key'] = 'width_sub_total';
	$data['option_value'] = $_POST['width_sub_total'];
	update_option($data);
	
	
	# gerekli verileri değişkene atıyoruz.
	$page = get_option(array('option_group'=>'print_invoice_form_page','option_key'=>'page'));
	$page_position_left = $page['option_value2'];
	$page_position_top = $page['option_value3'];
		
	
	/* değer kutuları
		# değer kutularını veritabanına ekliyoruz.
	*/
	if(isset($_POST['print_value']))
	{
		$i = 0;
		foreach($_POST['print_value'] as $print_value)
		{
			$positions = explode(':', $_POST['hidden_print_value'][$i]);
			if(strlen($print_value) > 0)
			{
				$data['option_group'] = 'print_invoice_form';
				$data['option_key'] = 'print_value_'+$i;
				$data['option_value'] = $positions[0] - $page_position_left; if($data['option_value'] < 0){$data['option_value'] = '10'; }
				$data['option_value2'] = $positions[1] - $page_position_top; if($data['option_value2'] < 0){$data['option_value2'] = '10'; }
				$data['option_value3'] = str_replace('\"', '\'', addslashes($print_value));
				update_option($data);
			}
			$i++;
		}
	}
	
	
	/* metin kutuları
		# metin kutularını veritabanına ekliyoruz.
	*/
	if(isset($_POST['textarea']))
	{
		$i = 0;
		foreach($_POST['textarea'] as $print_value)
		{
			$positions = explode(':', $_POST['hidden_print_value_textarea'][$i]);
			if(strlen($print_value) > 0)
			{
				$data['option_group'] = 'print_invoice_form_custom_text';
				$data['option_key'] = 'print_value_'+$i;
				$data['option_value'] = $positions[0] - $page_position_left;
				$data['option_value2'] = $positions[1] - $page_position_top;
				$data['option_value3'] = $print_value;
				update_option($data);
			}
			$i++;
		}
	}
	
	
	// css güncellemesi yapıyoruz
	$css['option_group'] = 'print_invoice_form_css';
	$css['option_key'] = 'css';
	$css['option_value'] = $_POST['custom_css'];
	update_option($css);
}

# gerekli değerleri değişkene atıyoruz
$page = get_option(array('option_group'=>'print_invoice_form_page','option_key'=>'page'));
?>






<script>

$(document).ready(function(e) {
	
	$('.newinput').click(function() 
	{
		if($('#input_type').val() == 'text')
		{
			$('.startbox').append('<div class="print_option"><span class="glyphicon glyphicon-move"></span> <span class="glyphicon glyphicon-remove"></span> <input type="text" name="print_value[]" class="required" /><input type="hidden" name="hidden_print_value[]" class="hidden_print_type_value" /></div>');
		}
		else
		{
			$('.startbox').append('<div class="print_option"><span class="glyphicon glyphicon-move"></span> <span class="glyphicon glyphicon-remove"></span> <textarea name="textarea[]" class="required"></textarea><input type="hidden" name="hidden_print_value_textarea[]" class="hidden_print_type_value" /></div>');	
		}
		$( ".print_option" ).draggable();
		
		$('.glyphicon-remove').click(function(){
			$(this).parent().remove();
		});
		
		$(function() {
			$( ".print_option" ).draggable({
				drag: function () {
					$(this).children('.hidden_print_type_value').val( $(this).position().left + ':' + $(this).position().top );
				}
			});
		}); 
	});
	
	
	$('#page').val( $('.page').position().left + ':' + $('.page').position().top);
	
	$('.save').click(function(){
		$('#page').val( $('.page').position().left + ':' + $('.page').position().top);
	});
	
	$('.glyphicon-remove').click(function() {
		$(this).parent().remove();
	});
	
	if($('.page').position().left != '<?php echo $page['option_value2']; ?>')
	{
		window.location.replace("<?php echo site_url('invoice/invoice_design/?position_left='); ?>" + $('.page').position().left);	
	}
	else if($('.page').position().top != '<?php echo $page['option_value3']; ?>')
	{
		window.location.replace("<?php echo site_url('invoice/invoice_design/?position_top='); ?>" + $('.page').position().top);
	}
	
	
	
});
</script>





<div class="print_menu_box">
	<div class="row">
    	<div class="col-md-4">
        	<select name="input_type" id="input_type" class="form-control input-lg">
            	<option value="text">DEĞER KUTUSU</option>
                <option value="textarea">METİN KUTUSU</option>
            </select>
        </div> <!-- /.col-md-4 -->
    	<div class="col-md-4">
        	<button class="btn btn-default btn-lg newinput">Alan Ekle</button>
        </div> <!-- /.col-md-4 -->
        <div class="col-md-4">
        	<div class="text-right"><a href="?example" class="btn btn-default btn-sm">örnek veriyi yükle</a></div>
        </div>
    </div>
</div>
 



 
<form name="form_print_option" id="form_print_option" action="" method="POST" class="validation">
    
<div class="startbox">
 
<?php
$page = get_option(array('option_group'=>'print_invoice_form_page','option_key'=>'page'));

$this->db->where('option_group', 'print_invoice_form');
$service_forms = $this->db->get('options')->result_array();
?> 
<?php foreach($service_forms as $form): ?>
	<div class="print_option" style="left: <?php echo ($page['option_value2'] + $form['option_value']); ?>px; top: <?php echo ($page['option_value3'] + $form['option_value2']); ?>px;"><span class="glyphicon glyphicon-move"></span> <span class="glyphicon glyphicon-remove"></span> <input type="text" name="print_value[]" class="required" value="<?php echo stripslashes($form['option_value3']); ?>" /><input type="hidden" name="hidden_print_value[]" class="hidden_print_type_value" value="<?php echo ($page['option_value2'] + $form['option_value']); ?>:<?php echo ($page['option_value3'] + $form['option_value2']); ?>" /></div>
<?php endforeach; ?>

 
<?php
$this->db->where('option_group', 'print_invoice_form_custom_text');
$service_forms = $this->db->get('options')->result_array();
?> 
<?php foreach($service_forms as $form): ?>
	<div class="print_option" style="left: <?php echo ($page['option_value2'] + $form['option_value']); ?>px; top: <?php echo ($page['option_value3'] + $form['option_value2']); ?>px;"><span class="glyphicon glyphicon-move"></span> <span class="glyphicon glyphicon-remove"></span> <textarea name="textarea[]" class="required"><?php echo $form['option_value3']; ?></textarea><input type="hidden" name="hidden_print_value_textarea[]" class="hidden_print_type_value" value="<?php echo ($page['option_value2'] + $form['option_value']); ?>:<?php echo ($page['option_value3'] + $form['option_value2']); ?>" /></div>
<?php endforeach; ?>
</div> <!-- /.startbox -->


	<script>
		$(function() {
			$( ".print_option" ).click(function() {
				$('.zindex').removeClass('zindex');
				$(this).addClass('zindex');
				
			});
			
			$( ".print_option" ).draggable({
				drag: function () {
					$(this).children('.hidden_print_type_value').val( $(this).position().left + ':' + $(this).position().top );
				}
			});
		}); 
    </script>
    
    <div style="height:5px;"></div>

    <div class="page"></div>
    
    <hr />
    <?php $width_code = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_code')); ?>
    <?php $width_name = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_name')); ?>
    <?php $width_quantity = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_quantity')); ?>
    <?php $width_quantity_price = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_quantity_price')); ?>
    <?php $width_total = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_total')); ?>
    <?php $width_tax_rate = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_tax_rate')); ?>
    <?php $width_tax = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_tax')); ?>
    <?php $width_sub_total = get_option(array('option_group'=>'print_invoice_form_item_width', 'option_key'=>'width_sub_total')); ?>
    
    
    <table class="table">
    	<tr class="active">
        	<th colspan="8">Ürünler/Malzemeler genişlik ayarlaması</th>
        </tr>
    	<tr class="success">
        	<td width="12%"><label>Ürün Kodu:</label><input type="text" name="width_code" value="<?php echo $width_code['option_value']; ?>" style="width:80px;" />px</td>
            <td width="12%"><label>Ürün Adı:</label><input type="text" name="width_name" value="<?php echo $width_name['option_value']; ?>" style="width:80px;" />px</td>
            <td width="12%"><label>Adet:</label><input type="text" name="width_quantity" value="<?php echo $width_quantity['option_value']; ?>" style="width:80px;" />px</td>
            <td width="12%"><label>Satış Fiyat:</label><input type="text" name="width_quantity_price" value="<?php echo $width_quantity_price['option_value']; ?>" style="width:80px;" />px</td>
            <td width="12%"><label>Toplam:</label><input type="text" name="width_total" value="<?php echo $width_total['option_value']; ?>" style="width:80px;" />px</td>
            <td width="12%"><label>Kdv Oranı:</label><input type="text" name="width_tax_rate" value="<?php echo $width_tax_rate['option_value']; ?>" style="width:80px;" />px</td>
            <td width="12%"><label>Kdv Tutarı:</label><input type="text" name="width_tax" value="<?php echo $width_tax['option_value']; ?>" style="width:80px;" />px</td>
            <td width="12%"><label>Satır Toplamı:</label><input type="text" name="width_sub_total" value="<?php echo $width_sub_total['option_value']; ?>" style="width:80px;" />px</td>
        </tr>
    </table>
    
    <hr />
    <div class="row">
    	<div class="col-md-10">
        	<?php $css = get_option(array('option_group'=>'print_service_form_css', 'option_key'=>'css')); ?>
        	<textarea style="width:100%;" name="custom_css" id="custom_css" class="form-control" placeholder="<?php lang('Custom CSS Area'); ?>"><?php echo $css['option_value']; ?></textarea>
        </div> <!-- /.col-md-8 -->
        <div class="col-md-2">
        	<div class="text-right">
                <input type="hidden" name="page" id="page" />
                <button class="save btn btn-success btn-lg"><span class="glyphicon glyphicon-floppy-disk"></span> <?php lang('Save'); ?></button>
            </div>
        </div> <!-- /.col-md-4 -->
    </div> <!-- /.row -->
    
    <hr />
</form>


<div class="row">
	<div class="col-md-12">
    	<code>Form tasarlama alanını aşağıdaki değerlere göre form hazırlamanızı sağlar.</code>
        <br />
        Aşağıdaki alanları eklemeniz için "Değer Kutusu" eklemeniz gerekiyor. Değer kutusu alanı ekledikten sonra [<strong>KOD BURAYA YAZILACAK</strong>] yani köşeli parantezler içerisine aşağıdaki değerleri yazıyoruz. Şimdi bir örnek yapalım.
        <ul>
        	<li>Yeni bir tane "Değer Kutusu" alanı ekleyelim.</li>
            <li>Yeni eklenen kutunun içerisine <strong>[INV_date]</strong> metnini ekleyelim.</li>
            <li>Daha sonra kaydet butonuna basalım.</li>
        </ul>
    </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->

<div class="h20"></div>

<div class="row">
	<div class="col-md-6">
        <table class="table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    <th><?php lang('KEY'); ?></th>
                    <th><?php lang('VALUE'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>INV_id</td>
                    <td><?php lang('ID'); ?></td>
                </tr>
                <tr>
                    <td>INV_status</td>
                    <td>Fatura Durumu</td>
                </tr>
                <tr>
                    <td>INV_date</td>
                    <td>Tarih</td>
                </tr>
                <tr>
                    <td>INV_type</td>
                    <td>Tür</td>
                </tr>
                <tr>
                    <td>INV_in_out</td>
                    <td>Giriş-Çıkış</td>
                </tr>
                <tr>
                    <td>INV_account_id</td>
                    <td>Hesap ID</td>
                </tr>
                <tr>
                    <td>INV_description</td>
                    <td>Açıklama</td>
                </tr>
                <tr>
                    <td>INV_quantity</td>
                    <td>Ürün Adet</td>
                </tr>
                <tr>
                    <td>INV_total</td>
                    <td>Toplam</td>
                </tr>
                <tr>
                    <td>INV_tax</td>
                    <td>KDV</td>
                </tr>
                <tr>
                    <td>INV_discount</td>
                    <td>İskonto</td>
                </tr>
                <tr>
                    <td>INV_grand_total</td>
                    <td>Genel Toplam</td>
                </tr>
                <tr>
                    <td>INV_user_id</td>
                    <td>Kullanıcı ID</td>
                </tr>
                <tr>
                    <td>INV_val_1</td>
                    <td>Özel Alan 1</td>
                </tr>
                <tr>
                    <td>INV_val_2</td>
                    <td>Özel Alan 2</td>
                </tr>
                <tr>
                    <td>INV_val_3</td>
                    <td>Özel Alan 3</td>
                </tr>
            </tbody>
        </table>
	</div> <!-- /.col-md-6 -->
    <div class="col-md-6">
        <table class="table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    <th><?php lang('KEY'); ?></th>
                    <th><?php lang('VALUE'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ACC_id</td>
                    <td>Hesap ID</td>
                </tr>
                <tr>
                    <td>ACC_status</td>
                    <td>Hesap Durumu</td>
                </tr>
                <tr>
                    <td>ACC_code</td>
                    <td>Hesap Kodu</td>
                </tr>
                <tr>
                    <td>ACC_name</td>
                    <td>Hesap Adı</td>
                </tr>
                <tr>
                    <td>ACC_name_surname</td>
                    <td>Yetkili Adı, Soyadı</td>
                </tr>
                <tr>
                    <td>ACC_balance</td>
                    <td>Hesap Bakiyesi</td>
                </tr>
                <tr>
                    <td>ACC_phone</td>
                    <td>Sabit Telefon</td>
                </tr>
                <tr>
                    <td>ACC_gsm</td>
                    <td>Cep Telefonu</td>
                </tr>
                <tr>
                    <td>ACC_email</td>
                    <td>E-posta</td>
                </tr>
                <tr>
                    <td>ACC_address</td>
                    <td>Adres</td>
                </tr>
                <tr>
                    <td>ACC_county</td>
                    <td>İlçe</td>
                </tr>
                <tr>
                    <td>ACC_city</td>
                    <td>Şehir</td>
                </tr>
                <tr>
                    <td>ACC_description</td>
                    <td>Açıklama</td>
                </tr>
            </tbody>
        </table>
        
        <table class="table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    <th><?php lang('KEY'); ?></th>
                    <th><?php lang('VALUE'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ITM_items</td>
                    <td>Ürünler/Malzemeler Tablosu</td>
                </tr>
                <tr>
                    <td>+ no_title</td>
                    <td>tablonun başlıkları yok</td>
                </tr>
                <tr>
                    <td>+ no_footer</td>
                    <td>tablonun alt toplam alanları yok</td>
                </tr>
            </tbody>
		</table>
            
	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->



