<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller {

	public function index()
	{
		// sayfa bilgisi
		$data['meta_title'] = 'Form Yönetimi';
		$data['navigation'][0] = '<li class="active">Form Yönetimi</a>';

		$this->template->view('form/dashboard', $data);
	}
	
	public function new_invoice()
	{
		redirect(site_url('invoice/add'));
	}
	
	
	public function add()
	{
		// sayfa bilgisi
		if(isset($_GET['sell'])){ $data['meta_title'] = 'Yeni Çıkış/Satış Formu';} else if(isset($_GET['buy'])){$data['meta_title'] = 'Yeni Giriş/Alış Formu';} 
		

		$form['account_id'] = '';
		$account['name'] = '';
		$form['description'] = '';
		
		if(isset($_POST['add']) and is_log())
		{
			$continue = true;
			$this->form_validation->set_rules('account_id', get_lang('Account Card'), 'required|digits');
		
			if($this->form_validation->run() == FALSE)
			{
				$data['formError'] =  validation_errors();
			}
			else
			{
				$form['date'] = $this->input->post('date').' '.date('H:i:s');;
				$form['account_id'] = $this->input->post('account_id');
				$form['description'] = $this->input->post('description');
				
				$form['type'] = 'invoice';
				if(isset($_GET['in'])){$form['in_out'] = 'in';} else if(isset($_GET['out'])){$form['in_out'] = 'out';} else {exit('8468382 eksik bilgi.');}
					
				$form_id = add_form($form);
				
				if($form_id > 0)
				{
					$data['type'] = 'invoice';
					$data['form_id'] = $form_id;
					$data['account_id'] = $form['account_id'];
					$data['title'] = 'Yeni Fiş';
					if(isset($_GET['sell']))
					{ $data['description'] = 'Satış formu oluşturdu.'; }
					else { $data['description'] = 'Alış formu oluşturdu.'; } 
					add_log($data);
					
					redirect(site_url('form/view/'.$form_id));
				}
				else { $data['error'] = 'Bilinmeyen Bir Hata!'; }
			}
		}
		
		/* eger hesap kartından deger gonderilmis ise */
		if(isset($_GET['account_id']))
		{
			$account = get_account($_GET['account_id']);
			$form['account_id'] = $account['id'];
		}
		
		redirect(site_url('form/view'));

		$data['account'] = $account;
		$data['form'] = $form;
		$this->template->view('form/add', $data);
	}
	
	
	


	public function view($form_id='')
	{
		$new_form = false;
		$data['form_id'] = $form_id;
		$form = get_form($form_id);


		// eger form tipi odeme ise yonlendir
		if($form['type'] == 'payment'){redirect(site_url('payment/view/'.$form['id']));	}
		
		
		// sayfa bilgisi
		$data['navigation'][0] = '<li><a href="'.site_url('form').'">Form Yönetimi</a></li>';
		$data['navigation'][1] = '<li><a href="'.site_url('form/lists').'">Form Listesi</a></li>';

		if($form_id > 0)
		{
			$data['meta_title'] = '#'.$form_id.' '.$form['name'];
			if($form['in_out'] == 'in'){$form_in_out_text = 'Giriş';}else if($form['in_out'] == 'out'){$form_in_out_text = 'Çıkış';}else{$form_in_out_text = 'Bilinmiyor';}
			$data['navigation'][2] = '<li class="active">'.$form_in_out_text.' '.$form['name'].'</li>';
		}
		else
		{
			if(isset($_GET['out'])){ $data['meta_title'] = 'Yeni Çıkış/Satış Formu'; $data['navigation'][2] = '<li class="active">Yeni Çıkış/Satış Formu</li>';} 
			else if(isset($_GET['in'])){$data['meta_title'] = 'Yeni Giriş/Alış Formu'; $data['navigation'][2] = '<li class="active">Yeni Giriş/Alış Formu</li>';} 

		}
		
		

		if(!$form)
		{
			$form['id'] = 0;
			$form['account_id'] = 0;

			$account['name'] = 'PERAKENDE';
		}
		// eger yeni olusmus ise formda yapilan son degisiklikler
		if(@$_GET['success'] == 'formUpdate' and @$_GET['date'] == date('YmdHis'))
		{
			$data['success']['formUpdate'] = get_alertbox('alert-success', 'Form Bilgileri Güncellendi.');
		}
		if(@$_GET['success_item'] == 'add_item' and @$_GET['date'] == date('YmdHis'))
		{
			$data['success_item']['add_item'] = get_alertbox('alert-success', '"'.$_GET['product_code'].'" stok hareketi eklendi.');
		}

		



		/* form bilgileri guncelle */
		if(isset($_POST['update_form_info']) and is_log())
		{
			// eger form daha onceden olusmamis ise olustur
			if($form_id == 0)
			{
				$form['date'] = date('Y-m-d H:i:s');
				$form['account_id'] = $form['account_id'];
				$form['type'] = 'invoice';

				if(isset($_GET['in'])){$form['in_out'] = 'in';} else if(isset($_GET['out'])){$form['in_out'] = 'out';} else {exit('37563726 eksik bilgi');} 
					
				$form_id = add_form($form);
				
				if($form_id > 0)
				{
					$log['type'] = 'invoice';
					$log['form_id'] = $form_id;
					$log['account_id'] = $form['account_id'];
					$log['title'] = 'Yeni Fiş';
					if(isset($_GET['sell'])){ $log['description'] = 'Çıkış formu oluşturdu.'; } else { $log['description'] = 'Giriş formu oluşturdu.'; } 
					add_log($log);
				
					$form = get_form($form_id);
					$new_form = true;

					$data['alert']['new_form'] = get_alertbox('alert-success', 'Form eklendi.', '"<strong>#'.$form['id'].'</strong>" ID numaralı form eklendi.');
				}
			}



			$this->form_validation->set_rules('account_id', 'Hesap Kartı', 'required');
			$this->form_validation->set_rules('date', 'Tarih', 'required');
			if($this->form_validation->run() == FALSE)
			{
				$data['alert']['validations_form_update'] = validation_errors();
			}
			else
			{
				$update_form['date'] = $this->input->post('date');
				$update_form['account_id'] = $this->input->post('account_id');
				$update_form['code'] = $this->input->post('code');
				$update_form['invoice_no'] = $this->input->post('invoice_no');
				$update_form['waybill_no'] = $this->input->post('waybill_no');
				$update_form['name'] = mb_strtoupper($this->input->post('name'),'utf-8');
				$update_form['name_surname'] = mb_strtoupper($this->input->post('name_surname'),'utf-8');
				$update_form['phone'] = $this->input->post('phone');
				$update_form['gsm'] = $this->input->post('gsm');
				$update_form['email'] = strtolower($this->input->post('email'));
				$update_form['address'] = mb_strtoupper($this->input->post('address'),'utf-8');
				$update_form['county'] = mb_strtoupper($this->input->post('county'),'utf-8');
				$update_form['city'] = mb_strtoupper($this->input->post('city'),'utf-8');
				$update_form['description'] = mb_strtoupper($this->input->post('description'),'utf-8');


				/* hesap kartı secilmis ise $_POST['account_id'] > 0 olacaktır. 
				asagidaki kontrolrde stok kartının var olup olmadgini kontrol ediyoruz. 
				Eger gonderilen ID' degerinde stok karti yok ise $cont=false oluyor. */
				$account = get_account($update_form['account_id']); 
				$cont = true;
				if(!$account and $update_form['account_id'] > 0)
				{
					$cont = false;
					$data['alert']['not_found_account'] = get_alert('alert-warning', 'Hesap kartı bulunamadı.');
				}
				

				/* Yeni form olusunda $_POST['account_id'] == '0' degerinde ve $_POST['name_surname'] degiskeni bos degilse 
				bu yeni bir hesap karti olusturmamiz gerektigi anlamina geliyor. */
				if($update_form['account_id'] == 0 and strlen($update_form['name_surname']) > 0)
				{
					$new_account['name'] = $update_form['name'];
					$new_account['name_surname'] = $update_form['name_surname'];
					$new_account['phone'] = $update_form['phone'];
					$new_account['gsm'] = $update_form['gsm'];
					$new_account['email'] = $update_form['email'];
					$new_account['address'] = $update_form['address'];
					$new_account['county'] = $update_form['county'];
					$new_account['city'] = $update_form['city'];
					
					$account_id = add_account($new_account);
					
					if($account_id)
					{
						$account = get_account($account_id);
						
						$update_form['account_id'] = $account['id'];
						$update_form['code'] = $account['code'];
						$update_form['name'] = $account['name'];
						$update_form['name_surname'] = $account['name_surname'];
						$update_form['phone'] = $account['phone'];
						$update_form['gsm'] = $account['gsm'];
						$update_form['email'] = $account['email'];
						$update_form['address'] = $account['address'];
						$update_form['county'] = $account['county'];
						$update_form['city'] = $account['city'];
						
						$data['alert']['new_account'] = get_alertbox('alert-success', 'Yeni hesap kartı oluştu.', $account['name']. ' hesap kartı oluştu. Hesap kartına erişmek için <a href="'.site_url('account/view/'.$account['id']).'" target="_blank">tıklayınız</a>.');
					}
					else
					{
						$cont = false;
						$data['alert']['new_account'] = get_alertbox('alert-danger', 'Hesap kartı eklenmedi.');
					}
				}


				if($cont)
				{
					if(update_form($form['id'], $update_form))
					{
						if(!$new_form)
						{
							add_log(array('type'=>'invoice', 'form_id'=>$form['id'], 'title'=>'Form Güncelleme', 'description'=>'Form bilgileri güncellendi.'));
							
							
							// log kayıtlarını güncelle
							if($form['id'] != 0 and $form['account_id'] != $update_form['account_id'])
							{
								add_log(array('type'=>'invoice', 'form_id'=>$form['id'], 'title'=>'Form Güncelleme', 'description'=>'Hesap kartı değiştirildi.'));
							}

							//form_item tablosunu guncelle
							$this->db->where('form_id', $form['id']);
							$this->db->update('form_items', array('account_id'=>$update_form['account_id']));
						}
					}	
				}
			}
		}

		/* form hareketleri */
		if(isset($_POST['item']) and is_log())
		{
			// eger form daha onceden olusmamis ise otomatik olustur
			if($form_id == 0)
			{
				$form['date'] = date('Y-m-d H:i:s');
				$form['account_id'] = $form['account_id'];
				$form['type'] = 'invoice';

				if(isset($_GET['in'])){$form['in_out'] = 'in';} else if(isset($_GET['out'])){$form['in_out'] = 'out';} else {exit('376646453 eksik bilgi.');} 
					
				$form_id = add_form($form);
				
				if($form_id > 0)
				{
					$log['type'] = 'invoice';
					$log['form_id'] = $form_id;
					$log['account_id'] = $form['account_id'];
					$log['title'] = 'Yeni Fiş';
					if(isset($_GET['sell']))
					{ $log['description'] = 'Satış formu oluşturdu.'; }
					else { $log['description'] = 'Alış formu oluşturdu.'; } 
					add_log($log);
				}

				$form = get_form($form_id);
				$new_form = true;

				$data['alert']['new_form'] = get_alertbox('alert-success', 'Form eklendi.', '"<strong>#'.$form['id'].'</strong>" ID numaralı form eklendi.');
			}

			$continue = true;
			$this->form_validation->set_rules('code', get_lang('Barcode Code'), 'required');
			$this->form_validation->set_rules('amount', get_lang('Amount'), 'required|digits');
			$this->form_validation->set_rules('quantity_price', get_lang('Quantity Price'), 'number');
			$this->form_validation->set_rules('tax_rate', get_lang('Tax Rate'), 'digits');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['formError'] = validation_errors();
			}
			else
			{
				$item['form_id'] = $form['id'];
				
				$product['code'] 	= $this->input->post('code');
				$item['quantity'] = $this->input->post('amount');
				$item['quantity_price'] = $this->input->post('quantity_price');
				$item['total'] = '';
				$item['tax_rate'] 	= $this->input->post('tax_rate');
				
				$product = get_product(array('status'=>'1', 'code'=>$product['code']));
				
				if(!$product) { $data['barcode_code_unknown'] = 'Stok kartı bulunamadı.'; }
				else
				{
					$item['product_id'] = $product['id'];
					if($item['quantity'] <= 0)				{ $item['quantity'] = 1; }
					if($item['quantity_price'] == '')	{ $item['quantity_price'] = $product['tax_free_sale_price']; }
					if($item['tax_rate'] == '')			{ $item['tax_rate'] = $product['tax_rate']; }
					
					$item['total'] 		= $item['quantity'] * $item['quantity_price'];
					$item['tax']		= ($item['total'] / 100) * $item['tax_rate'];
					$item['sub_total'] 	= ($item['total'] + $item['tax']);
					$item['in_out'] 	= $form['in_out'];
					
					$item['tax_free_cost_price'] = $product['tax_free_cost_price'];
					$item['cost_price'] = $product['cost_price'];
					$item['tax_free_sale_price'] = $item['quantity_price'];
					$item['sale_price'] = $item['sub_total'] / $item['quantity'];
					$item['profit'] = ($item['tax_free_sale_price'] - $item['tax_free_cost_price']) * $item['quantity'];
					
					$item['product_code'] = $product['code'];
					$item['product_name'] = $product['name'];
					unset($item['quantity_price']);
					
					$item_id = add_item($item);
					if($item_id > 0)
					{
						$log['type'] = 'invoice';
						$log['form_id'] = $form['id'];
						$log['product_id'] = $product['id'];
						$log['account_id'] = $form['account_id'];
						if($form['in_out'] == 0){$log['title'] = 'Giriş';}else{$log['title'] = 'Çıkış';}
						if($form['in_out'] == 0){$log['description'] = $item['quantity']. ' birim stok alışı ekledi.';}else{$log['description'] = $item['quantity']. ' birim adet stok çıkışı ekledi.';;}
						add_log($log);
						calc_invoice_items($form['id']);	
						calc_product($product['id']);
						$data['success_item']['add_item'] = get_alertbox('alert-success', '"'.$product['code'].'" stok hareketi eklendi.');
					}
				}
			}
		}
		


		/* FORM DURUMU DEGISTIRME - SILME/AKTIFLESTIRME 
			form status değiştirerek formu silebilir yada güncelleyebilirsiniz.
		*/
		if(isset($_GET['status'])) 
		{ 
			if(change_status_invoice($form_id, array('status'=>$_GET['status'])))
			{
				$log['type'] = 'invoice';
				$log['form_id'] = $form['id'];
				$log['account_id'] = $form['account_id'];
				$log['title'] = 'Form Durumu';
				if($_GET['status'] == 0){$log['description'] = 'Form silindi';}else{$log['description'] = 'Form aktifleşti.';}
				add_log($log);
				$form = get_form($form_id);

				$data['success']['status'] = get_alertbox('alert-warning', 'Form Durumu Değişti', $log['description']);
			}
		} 
		
		
		/* 	STOK HAREKETI SILMEK
			silinmesi gereken stok hareketleri
		*/
		if(isset($_GET['delete_item']))
		{
			$item = get_invoice_item($_GET['item_id']);
			if($item['product_id'] > 0){ $product = get_product($item['product_id']);} else {$product['id'] = '0';}
			
			$this->db->where('id', $_GET['item_id']);
			$this->db->update('form_items', array('status'=>'0'));
			if($this->db->affected_rows() > 0)
			{
				$log['type']='item'; $log['form_id']=$form['id'];$log['product_id']=$product['id'];$log['account_id']=$form['account_id'];
				$log['title'] 		= 'Silme';
				$log['description']	= get_quantity($item['quantity']).' birim stok hareketi silindi.';
				add_log($log);
				
				calc_invoice_items($form['id']);	
				calc_product($item['product_id']);
				
				
				$data['success_item']['delete_item'] = get_alertbox('alert-danger', '"'.$product['code'].'" stok hareketi silindi.');
			}
		}

		
		calc_invoice_items($form['id']);
		calc_account_balance($form['account_id']);
		if($form['id'])
		{
			$data['form_id'] = $form['id']; 

			if($new_form)
			{
				$data['url_change_for_form_ID'] = true; // yeni form olustugundan formun URLsini ve sayfa basligini degitirmemiz gerekiyor.
			}
		}


		// form bilgilerini view dosyasina gonderelim
		$data['form'] = get_form($form['id']);

		if($form['id'] == 0)
		{
		    $form_id = 0;
		    $form['id'] = 0;
		    $form['type'] = 'invoice';
		    if(isset($_GET['in'])){ $form['in_out'] = 'in'; } else { $form['in_out'] = 'out'; }
		    $form['status'] = '1';
		    $form['date'] = date('Y-m-d H:i:s');

		    $form['account_id'] = 0;
		    $form['invoice_no'] = '';
		    $form['waybill_no'] = '';

		    $form['grand_total'] = 0;
		    $form['profit'] = 0;
		    $form['tax'] = 0;
		    $form['total'] = 0;

		    $form['code'] = '';
			$form['name'] = '';
		    $form['name_surname'] = '';
		    $form['phone'] = '';
		    $form['email'] = '';
			$form['gsm'] = '';
			$form['address'] = '';
			$form['county'] = '';
			$form['city'] = '';
		    $form['description'] = '';
		    $data['form'] = $form;
		}
		$account = get_account($form['account_id']); 

		$this->template->view('form/view', $data);
	}



	
	public function lists()
	{
		// sayfa bilgisi
		$data['meta_title'] = 'Form Listesi';
		$data['navigation'][0] = '<li><a href="'.site_url('form').'">Form Yönetimi</a></li>';
		$data['navigation'][1] = '<li class="active">Form Listesi</li>';

		$this->template->view('form/lists', $data);
	}
	
	public function invoice_design()
	{
		$this->template->view('invoice/invoice_design_view');
	}
	
	public function invoice_print($form_id)
	{
		$data['form_id'] = $form_id;
		$this->template->blank_view('invoice/invoice_print_view', $data);
	}
	
	public function search_account($text='')
	{
		$this->db->where('status', '1');
		$this->db->like('code', urldecode($text));
		$this->db->or_like('name', urldecode($text));
		$this->db->or_like('gsm', urldecode($text));
		$this->db->limit(7);
		$query = $this->db->get('accounts')->result_array();
		$data['accounts'] = $query;
		$this->load->view('form/typehead_search_account', $data);
	}
	
	public function search_product_for_invoice($text='')
	{
		$this->db->where('status', '1');
		$this->db->like('code', urldecode($text));
		$this->db->or_like('name', urldecode($text));
		$this->db->limit(7);
		$query = $this->db->get('products')->result_array();

		$data['text'] = urldecode($text);

		$query = $this->db->query('SELECT * FROM til_products WHERE status="1" AND code LIKE "%'.urldecode($text).'%" AND status="1" AND name LIKE "%'.urldecode($text).'%"');
		$data['products'] = $query->result_array();
		$this->load->view('form/typehead_search_product', $data);
	}
	
	
}
