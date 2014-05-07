<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function add_form($data)
{
	$ci =& get_instance();
	
	if(!isset($data['date'])){$data['date'] = date('Y-m-d H:i:s'); }
	if(!isset($data['type'])){$data['type'] = 'invoice'; }
	$data['user_id'] = get_the_current_user('id');
	
	$ci->db->insert('forms', $data);
	$insert_id = $ci->db->insert_id();
	
	return $insert_id;
}

function update_form($form_id, $data)
{
	$ci=& get_instance();
	
	$ci->db->where('id', $form_id);
	$ci->db->update('forms', $data);
	
	if($ci->db->affected_rows() > 0)
	{
		return 1;
	}
	else
	{
		return 0;	
	}
}


function get_form($data)
{
	$ci =& get_instance();
	if(is_array($data))
	{
		$this->db->where($data);
	}
	else
	{
		$ci->db->where('id', $data);
	}
	$query = $ci->db->get('forms')->row_array();
	return $query;
}

function get_invoice_item($item_id, $data='')
{	
	$ci =& get_instance();
	
	$ci->db->where('id', $item_id);
	if(is_array($data))
	{
		$ci->db->where($data);
	}
	$query = $ci->db->get('form_items')->row_array();

	if($query)
	{
		return $query;
	}
	else
	{
		return 0;
	}
}


function add_item($data)
{
	$ci =& get_instance();
	
	$invoice = get_form($data['form_id']);
	
	if(!isset($data['type'])) { $data['type'] = 'invoice'; }
	
	$data['date'] = date('Y-m-d H:i:s');
	$data['account_id'] = $invoice['account_id'];
	$data['user_id'] 	= get_the_current_user('id');
	$data['in_out']		= $invoice['in_out'];
	
	if(!isset($data['total'])){ $data['total'] = $data['quantity'] * $data['quantity_price'];}
	
	$ci->db->insert('form_items', $data);
	$insert_id = $ci->db->insert_id();
	
	return $insert_id;	
}

function update_form_item($data)
{
	$ci =& get_instance();
	
	$form = get_form($data['form_id']);
	
	$data['account_id'] = $form['account_id'];
	$data['in_out']		= $form['in_out'];
	
	$ci->db->where('id', $data['id']);
	$ci->db->update('form_items', $data);
	if($ci->db->affected_rows() >0)
	{
		return 1;
	}
	else
	{
		return 0;	
	}
}


function calc_invoice_items($form_id)
{
	$form = get_form($form_id);
	$ci =& get_instance();
	
	$ci->db->where('status', 1);
	$ci->db->where('form_id', $form_id);
	$ci->db->select_sum('total');
	$ci->db->select_sum('tax');
	$ci->db->select_sum('sub_total');
	$ci->db->select_sum('quantity');
	$ci->db->select_sum('profit');
	$total = $ci->db->get('form_items')->row_array();
	
	$ci->db->where('id', $form_id);
	$ci->db->update('forms', array(
	'total'=>$total['total'],
	'tax'=>$total['tax'],
	'grand_total'=>$total['sub_total'],
	'quantity'=>$total['quantity'],
	'profit'=>$total['profit']
	));
}





function get_text_in_out($in_out)
{
	if($in_out == 'in')
	{
		return 'GİRİŞ';
	}
	elseif($in_out == 'out')
	{
		return 'ÇIKIŞ';
	}
	else
	{
		return get_lang('Error!');
	}
}


function change_status_invoice($form_id, $data)
{
	$ci =& get_instance();
	$continue = true;
	
	if($data['status'] == 0){}
	else if($data['status'] == 1){}
	else{$continue = false;}
	
	if($continue == true)
	{
		$ci->db->where('id', $form_id);
		$ci->db->update('forms', array('status'=>$_GET['status']));
		if($ci->db->affected_rows() > 0)
		{
			$return = true;
		}
		else
		{
			$return = false;
		}
		
		$ci->db->where('form_id', $form_id);
		$ci->db->update('form_items', array('status'=>$_GET['status']));
	}
	
	$ci->db->where('form_id', $form_id);
	$items = $ci->db->get('form_items')->result_array();
	foreach($items as $item)
	{
		calc_product($item['product_id']);
	}

	return $return;
}


function get_text_form_type($text)
{
	if($text == 'invoice'){return 'FATURA';}
	elseif($text == 'payment'){return 'ÖDEME';}
	else{return $text;}
}

?>