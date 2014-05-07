<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function is_product_code($code, $product_id='0')
{
	$ci =& get_instance();
	$ci->db->where('code', $code);
	if($product_id > 0){ $ci->db->where_not_in('id', $product_id); }
	$query = $ci->db->get('products')->row_array();
	
	if($query)
	{
		return $query['id'];
	}
	else
	{
		return false;	
	}
}


function add_product($data)
{
	$ci =& get_instance();
	
	if(strlen($data['tax_rate']) > 1)
	{
		$tax = '1.'.$data['tax_rate'];
	}
	else
	{
		$tax = '1.0'.$data['tax_rate'];
	}
	
	$data['tax'] = $data['sale_price'] - ($data['sale_price'] / ($tax));
	
	$data['tax_free_sale_price'] = $data['sale_price'] - $data['tax'];
	$data['tax_free_cost_price'] = $data['cost_price'] / ($tax);
	
	// Have barcode?
	if(is_product_code($data['code']))
	{
		return 'There barcode code';
		return false;
	}
	
	// add product card
	$ci->db->insert('products', $data);
	return $ci->db->insert_id();
}




function update_product($id, $data)
{
	$ci =& get_instance();
	
	if(strlen($data['tax_rate']) > 1){ $tax = '1.'.$data['tax_rate']; } else { $tax = '1.0'.$data['tax_rate']; }
	
	$data['tax'] = $data['sale_price'] - ($data['sale_price'] / ($tax));
	$data['tax_free_sale_price'] = $data['sale_price'] - $data['tax'];
	$data['tax_free_cost_price'] = $data['cost_price'] / ($tax);
	
	$ci->db->where('id', $id);
	$ci->db->update('products', $data);
	if($ci->db->affected_rows() > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}






	



function get_product($data)
{
	$ci =& get_instance();
	
	if(is_array($data))
	{
		# eger gonderilen deger ID degil bir dizi ise veritabani sorgusu yapalim
		$ci->db->where($data);
		$ci->db->order_by('id', 'DESC');
		return $query = $ci->db->get('products')->row_array();
	}
	else
	{
		# fakat $data degiskeni ID bu sebebler cok fazla veritabanı sorgusu yapmak yerine $GLOBALS['products'] degiskeninden veri cekelim
		$ci->db->where('id', $data);
		return $query = $ci->db->get('products')->row_array();
	}
}


function get_products($data='')
{
	$ci =& get_instance();
	
	if(is_array($data)){$ci->db->where($data);}
	$query = $ci->db->get('products')->result_array();
	$products = array();
	foreach($query as $product)
	{
		$products[$product['id']] = $product;	
	}
	return $products;
}




/* PRODUCT META 
	product_meta fonksiyonlari stok kartlari ile ilgili cesitli degerler kaydetmenizi saglar. 
*/


function add_product_meta($data)
{
	$ci =& get_instance();
	// eger 'product_id' yok ise false dondur
	if(!isset($data['product_id'])){return false;}
	$ci->db->insert('product_meta', $data);
	return $ci->db->insert_id();
}



function get_product_meta($data)
{
	$ci =& get_instance();
	
	if(isset($data['id'])) 			{ $ci->db->where('id', $data['id']); }
	if(isset($data['product_id'])) 	{ $ci->db->where('product_id', $data['product_id']); }
	if(isset($data['group'])) 		{ $ci->db->where('group', $data['group']); }
	if(isset($data['key'])) 		{ $ci->db->where('key', $data['key']); }
	if(isset($data['val_1'])) 		{ $ci->db->where('val_1', $data['val_1']); }
	if(isset($data['val_2'])) 		{ $ci->db->where('val_2', $data['val_2']); }
	if(isset($data['val_3'])) 		{ $ci->db->where('val_3', $data['val_3']); }
	if(isset($data['val_4'])) 		{ $ci->db->where('val_4', $data['val_4']); }
	if(isset($data['val_5'])) 		{ $ci->db->where('val_5', $data['val_5']); }
	if(isset($data['val_int'])) 	{ $ci->db->where('val_int', $data['val_int']); }
	if(isset($data['val_text'])) 	{ $ci->db->where('val_text', $data['val_text']); }
	$num_rows = $ci->db->get('product_meta')->num_rows();
	
	/* 	eger sorgudan donen kayit sayisi "0" ise harhangi bir sonuc bulunamdi
		sorgudan donen kayit sayisi "1" ise row_array ile sadece kayiti dondur
		fakat sorgudan donen kayit sayisi "1>" buyuk ise result_array ile hepsini bir dizide dondur */
	if($num_rows == 1)
	{
		if(isset($data['id'])) 			{ $ci->db->where('id', $data['id']); }
		if(isset($data['product_id'])) 	{ $ci->db->where('product_id', $data['product_id']); }
		if(isset($data['group'])) 		{ $ci->db->where('group', $data['group']); }
		if(isset($data['key'])) 		{ $ci->db->where('key', $data['key']); }
		if(isset($data['val_1'])) 		{ $ci->db->where('val_1', $data['val_1']); }
		if(isset($data['val_2'])) 		{ $ci->db->where('val_2', $data['val_2']); }
		if(isset($data['val_3'])) 		{ $ci->db->where('val_3', $data['val_3']); }
		if(isset($data['val_4'])) 		{ $ci->db->where('val_4', $data['val_4']); }
		if(isset($data['val_5'])) 		{ $ci->db->where('val_5', $data['val_5']); }
		if(isset($data['val_int'])) 	{ $ci->db->where('val_int', $data['val_int']); }
		if(isset($data['val_text'])) 	{ $ci->db->where('val_text', $data['val_text']); }
		return $ci->db->get('product_meta')->row_array();	
	}
	else if($num_rows > 1)
	{
		if(isset($data['id'])) 			{ $ci->db->where('id', $data['id']); }
		if(isset($data['product_id'])) 	{ $ci->db->where('product_id', $data['product_id']); }
		if(isset($data['group'])) 		{ $ci->db->where('group', $data['group']); }
		if(isset($data['key'])) 		{ $ci->db->where('key', $data['key']); }
		if(isset($data['val_1'])) 		{ $ci->db->where('val_1', $data['val_1']); }
		if(isset($data['val_2'])) 		{ $ci->db->where('val_2', $data['val_2']); }
		if(isset($data['val_3'])) 		{ $ci->db->where('val_3', $data['val_3']); }
		if(isset($data['val_4'])) 		{ $ci->db->where('val_4', $data['val_4']); }
		if(isset($data['val_5'])) 		{ $ci->db->where('val_5', $data['val_5']); }
		if(isset($data['val_int'])) 	{ $ci->db->where('val_int', $data['val_int']); }
		if(isset($data['val_text'])) 	{ $ci->db->where('val_text', $data['val_text']); }
		return $ci->db->get('product_meta')->result_array();	
	}
	else
	{
		return false;
	}
}




/* get_quantity()
	bu fonksiyon stok adetleri için yazılmıştır. Stok adet tutarları veritabanında 2 ondalık sayı olarak tutulmaktadır.
	Cunku satislar adet,koli,duzune,gram,kilo,ton,santimetre,metre birimlerinde olabilir. Fakat cogu satis sistemi adet uzerinde calismaktadir.
	Adetli satislari duzgun gostermek icin yani '1.00' yerine '1' olarak gostermek icin bu fonksiyon ise yarar. */
function get_quantity($quantity)
{
	if(is_numeric($quantity))
	{
		$explode = explode('.', $quantity);
		if(isset($explode[1]))
		{
			if($explode[1] == 0)
			{
				return number_format($quantity, 0);	
			}
			else
			{
				return number_format($quantity,2);
			}
		}
		else
		{
			return number_format($quantity, 0);	
		}
	}
	else
	{
		return false;	
	}
}
function the_quantity($quantity)
{
	echo get_quantity($quantity);
}



/* birim isimleri
	stok kartları için birim isimleri veritabanında ingilize formatında tutulmaktadır. number,millimeter, meter gibi.
	fonksiyon birim isimlerini dilimize görer döndürür */
function get_unit_name($val)
{
	if($val == 'number'){return 'Adet';}
	else if($val == 'number'){return 'Adet';}
	else if($val == 'gram'){return 'Gram';}
	else if($val == 'kilogram'){return 'Kilogram';}
	else if($val == 'ton'){return 'Ton';}
	else if($val == 'millimeter'){return 'Milimetre';}
	else if($val == 'centimeter'){return 'Santimetre';}
	else if($val == 'meter'){return 'Metre';}
	else if($val == 'parcel'){return 'Koli';}
	else {return '';}
}
function unit_name($val)
{
	echo get_unit_name($val);
}




function get_cost_price($cost_price)
{
	$options['who_can_see_cost_price'] = get_option(array('option_group'=>'product', 'option_key'=>'who_can_see_cost_price'));
	if(get_the_current_user('role') > $options['who_can_see_cost_price']['option_value'])
	{
		return get_money('0');
	}
	else
	{
		return get_money($cost_price);	
	}
}



function calc_product($product_id)
{
	$ci =& get_instance();
	
	$ci->db->where('product_id', $product_id);
	$ci->db->where('status', 1);
	$ci->db->where('in_out', '1');
	$ci->db->select_sum('quantity');
	$ci->db->select_sum('profit');
	$sales = $ci->db->get('form_items')->row_array();
	
	$ci->db->where('product_id', $product_id);
	$ci->db->where('status', 1);
	$ci->db->where('in_out', '0');
	$ci->db->select_sum('quantity');
	$buying = $ci->db->get('form_items')->row_array();
	
	$amount = $buying['quantity'] - $sales['quantity'];
	
	$ci->db->where('id', $product_id);
	$ci->db->update('products', array('amount'=>$amount, 'profit'=>$sales['profit']));
}


function get_product_amount($amount)
{
	return number_format($amount, 0);	
}




function taxFree_amount($amount, $tax_rate)
{
	// satış fiyatına kdv dahil degildir
	// maliyet fiyatına kdv dahildir bu sebebten dolayi asagi maliyet fiyatinnden kdvyi cikartiyoruz.
	if(strlen($tax_rate) > 1)
	{
		$tax = '1.'.$tax_rate;
	}
	else
	{
		$tax = '1.0'.$tax_rate;
	}
	
	return $amount =  ($amount / $tax);
}

?>