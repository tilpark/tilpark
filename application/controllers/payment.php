<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function index()
	{
		$this->template->view('payment/dashboard');
	}
	
	
	public function add()
	{
		$data['cashboxs']	= get_options(array('group'=>'cashbox'), array('default_value'=>'id'));
		$data['banks'] 		= get_options(array('group'=>'bank'), array('default_value'=>'id'));
		
		
		if(isset($_GET['in'])) {$data['form']['in_out'] = 'in';}else if(isset($_GET['out'])) {$data['form']['in_out'] = 'out';}else{exit('error! 3934833');}

		if(isset($_POST['add']) and is_log())
		{
				if($_POST['transaction_type'] == 'account') // eger islem turu hesap kartlarina bagli ise 
				{ 
					$this->form_validation->set_rules('account_id', 'Hesap Kartı', 'required|digits');
					$this->form_validation->set_rules('account_name', 'Hesap Kartı', 'required|min_length[3]|max_length[30]');
				}
				else if($_POST['transaction_type'] == 'manual') // eger islem turu manuel giris yada cikis ise
				{
					$this->form_validation->set_rules('name', 'Firma/Kurum', 'required|min_length[3]|max_length[30]');
				}
			$this->form_validation->set_rules('payment', get_lang('Payment'), 'required|number|max_length[12]');
		
			if($this->form_validation->run() == FALSE)
			{
				$data['formError'] = validation_errors();
			}
			else
			{
				$form['type'] = 'payment';
				if(isset($_GET['in'])){$form['in_out'] = 'in';} else if(isset($_GET['out'])){$form['in_out'] = 'out';}else{exit('93832485 error!');} 
				
				$form['date'] = $this->input->post('date').' '.date('H:i:s');;
				$form['account_id'] = $this->input->post('account_id');
				$form['description'] = mb_strtoupper($this->input->post('description'), 'utf-8');
				$form['grand_total'] = $this->input->post('payment');
				$form['val_1'] = $this->input->post('payment_type');
				$form['val_2'] = $this->input->post('bank_name');
				$form['val_3'] = $this->input->post('branch_code');
				$form['val_4'] = $this->input->post('serial_no');
				$form['val_int'] = $this->input->post('cahsbox');
					
							
				# hesap secenekleri
				if($_POST['transaction_type'] == 'account')
				{
					$account = get_account($form['account_id']);
						$form['name'] 			= $account['name'];
						$form['name_surname'] 	= $account['name_surname'];
						$form['phone'] 			= $account['phone'];
						$form['gsm'] 			= $account['gsm'];
						$form['email'] 			= $account['email'];
						$form['address'] 		= $account['address'];
						$form['county'] 		= $account['county'];
						$form['city'] 			= $account['city'];
				}
				else
				{
					$form['account_id'] 	= 0;
					$form['name'] 			= mb_strtoupper($this->input->post('name'),'utf-8');
					$form['name_surname'] 	= mb_strtoupper($this->input->post('name_surname'),'utf-8');
					if($form['name_surname'] == ''){$form['name_surname'] = $form['name'];}
				}
				
				# odeme hareketi ekle	
				$form_id = add_form($form);
				if($form_id > 0)
				{
					calc_cahsbox($form['val_int']); // kasa bakiyesini tekrar hesapla
					calc_account_balance($form['account_id']); // hesap kartinin bakiyesini tekrar hesapla
					
					$log['type'] = 'payment';
					$log['form_id'] = $form_id;
					$log['account_id'] = $form['account_id'];
					$log['title'] = 'Yeni Ödeme';
					$log['description'] = 'Ödeme hareketi';
					add_log($log);
					
					// message
					$data['messages']['addPayment'] = array('class'=>'success', 'title'=>'Ödeme Eklendi', 'description'=>'Yeni ödeme eklendi.');
					redirect(site_url('payment/view/'.$form_id));
				}
				else { $data['messages']['addPayment'] = array('class'=>'error', 'title'=>'Hata!', 'description'=>'Bilinmeyen bir hata oluştu.'); }
			}
		}
		$this->template->view('payment/add', @$data);	
	}
	
	
	
	public function lists()
	{
		$data['meta_title'] = 'Kasa & Banka Hareketleri';
		$this->db->where('status', 1);
		$this->db->where('type', 'payment');
		$this->db->order_by('ID', 'DESC');
		$data['forms'] = $this->db->get('forms')->result_array();
	
		$this->template->view('payment/lists', $data);	
	}
	
	
	
	public function view($form_id)
	{
		$data['payment_id'] = $form_id;
		$data['form'] = get_form($form_id);
		$data['account'] = get_account($data['form']['account_id']);
		
		// meta title
		$data['meta_title'] = '#'.$form_id.' Kasa Hareketi';
		
		
		if(isset($_POST['update']) and is_log())
		{
			$continue = true;
			$this->form_validation->set_rules('account_id', get_lang('Account Card'), 'required|digits');
			$this->form_validation->set_rules('account_name', get_lang('Account Name'), 'required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('payment', get_lang('Payment'), 'required|number|max_length[12]');
		
			if ($this->form_validation->run() == FALSE)
			{
				$data['formError'] =  validation_errors();
			}
			else
			{
				$form['date'] = $this->input->post('date');
				$form['account_id'] = $this->input->post('account_id');
				$form['description'] = mb_strtoupper($this->input->post('description'), 'utf-8');
				$form['grand_total'] = $this->input->post('payment');
				$form['val_1'] = $this->input->post('payment_type');
				$form['val_2'] = mb_strtoupper($this->input->post('bank_name'), 'utf-8');
				$form['val_3'] = mb_strtoupper($this->input->post('branch_code'), 'utf-8');
				if($form['val_1'] == 'cheque'){$form['val_4'] = $this->input->post('fall_due_on');}
				if($form['val_1'] == 'cheque'){$form['val_5'] = $this->input->post('cheque_serial_no');}
				$form['val_int'] = $this->input->post('cahsbox'); 
				
				
				// hesap secenekleri
				$account = get_account($form['account_id']);
					$form['name'] 			= $account['name'];
					$form['name_surname'] 	= $account['name_surname'];
					$form['phone'] 			= $account['phone'];
					$form['gsm'] 			= $account['gsm'];
					$form['email'] 			= $account['email'];
					$form['address'] 		= $account['address'];
					$form['county'] 		= $account['county'];
					$form['city'] 			= $account['city'];
				
				if(update_form($form_id, $form)) // odeme hareketi guncelle
				{
					calc_cahsbox($form['val_int']); // kasa bakiyesini tekrar hesapla
					calc_account_balance($form['account_id']); // hesap kartinin bakiyesini tekrar hesapla
					
					$log['type'] = 'payment';
					$log['form_id'] = $form_id;
					$log['account_id'] = $form['account_id'];
					$log['title'] = 'Güncelleme';
					$log['description'] = 'Ödeme hareketi güncellendi.';
					add_log($log);
					
					$data['alert']['success'] = get_alertbox('alert-success', 'İşlemler başarılı', 'Kasa hareketi güncellendi.');	
					
					# eger guncelle olduysa, verileri tekrar yukleyelim
					$data['old_form'] = $data['form'];
					$data['form'] = get_form($form_id);
					$data['account'] = get_account($data['form']['account_id']);
					
					calc_account_balance($data['old_form']['account_id']); // hesap karti degismis ise eski hesap kartinin bakiyesini guncelleyelim
				}
			}
		}
		$this->template->view('payment/view',$data);	
	}
	
	
	/* KASA 
		kasa işlemleri */
	public function cashbox($cashbox_id='')
	{
		$cashbox = get_option(array('id'=>$cashbox_id, 'group'=>'cashbox'));
		if($cashbox)
		{
			$data['cashbox'] = $cashbox;
			
			$data['meta_title'] = $cashbox['key'].' Detayları';
			$this->db->where('status', 1);
			$this->db->where('type', 'payment');
			$this->db->where('val_int', $cashbox['id']);
			$this->db->order_by('ID', 'ASC');
			$data['forms'] = $this->db->get('forms')->result_array();
			
			$this->template->view('payment/cashbox_detail', @$data);
			return false;
		}
		
		
		
		$bank = get_option(array('id'=>$cashbox_id, 'group'=>'bank'));
		if($bank)
		{
			$data['bank'] = $bank;
			
			$data['meta_title'] = $bank['key'].' Detayları';
			$this->db->where('status', 1);
			$this->db->where('type', 'payment');
			$this->db->where('val_int', $bank['id']);
			$this->db->order_by('ID', 'ASC');
			$data['forms'] = $this->db->get('forms')->result_array();
			
			$this->template->view('payment/bank_detail', @$data);
			return false;
		}
		
		if(isset($_POST['add']) and is_log())
		{
			$cash['name'] = $this->input->post('name');	
			
			$option['key'] 			= mb_strtoupper($cash['name'],'utf-8');
			$option['group'] 		= $this->input->post('type');	
			$option['val_2'] 		= $this->input->post('branch_code');
			$option['val_3'] 		= $this->input->post('account_no');
			$option['val_4'] 		= $this->input->post('iban');
			$option['val_5']		= '';
			update_option($option);
			
			// log
			$log['type'] = $option['group'];
			$log['title'] = 'Yeni Kasa';
			$log['description'] = 'Yeni kasa oluşturdu. ['.$option['key'].']';
			add_log($log);
			
			// messagebox
			$data['messages']['addCashbox'] = array(
				'class'=>'success', 
				'title'=>'Yeni Kasa Eklendi', 
				'description'=>'Yeni kasa/banka veritabanına eklendi ve kulanıma hazır durumda.');
				
			// eger varsayılan kasa yok ise, bu kasayı varsayılan kasa yap
			if($option['group'] == 'cashbox' and !get_options(array('group'=>'cashbox', 'val_1'=>'default')))
			{
				$data['messages']['updateDefaultCashbox'] = array(
					'class'=>'note', 
					'title'=>'Varsayılan Kasa Oluştu', 
					'description'=>'Varsayılan kasaya ihtiyacınız vardı. Sistem varsayılan kasayı '.$option['key'].' olarak atadı.');
				
				$option['val_1'] = 'default';
				update_option($option);
			}
		}
		
		
		
		if(isset($_GET['set']))
		{
			$cashbox_id = $this->input->get('cashbox_id');	
			$cashbox = get_option(array('id'=>$cashbox_id));
			
			// bu bir kasamı yoksa banka mı? 
			if($cashbox['group'] != 'cashbox' & $cashbox['group'] != 'bank'){ exit('error:340349'); }
			
			
			if($cashbox)
			{
				/* varsayilan kasa
					varsayilan kasayi degistirmek icin */
				if(isset($_GET['default']))
				{
					$this->db->where('group', 'cashbox');
					$this->db->where('val_1', 'default');
					$this->db->update('options', array('val_1'=>''));
					
					if(update_option(array('id'=>$cashbox_id, 'group'=>'cashbox', 'val_1'=>'default')))
					{
						$data['messages']['defaultCashboxChange'] = array('class'=>'success', 'title'=>'Varsayılan Kasa Değişti', 'description'=>'Varsayılan kasa <strong>'.$cashbox['key'].'</strong> olarak atandı.');
					}
				}
				
				/* kasa silmek
					kasa silmek icin */
				if(isset($_GET['delete']))
				{	
					if($cashbox['val_1'] == 'default' and $cashbox['group'] == 'cashbox')
					{
						$data['messages']['defaultCashboxChange'] = array('class'=>'danger', 'title'=>'Varsayılan Kasa Silinemez', 
							'description'=>'Varsayılan kasa <strong>'.$cashbox['key'].'</strong> olduğundan, bu kasa silinemiyor.');
					}
					else if($cashbox['val_decimal'] > 0 and $cashbox['group'] == 'cashbox')
					{
						$data['messages']['defaultCashboxChange'] = array('class'=>'danger', 'title'=>'Bu Kasada Para Var', 
							'description'=>'<strong>'.$cashbox['key'].'</strong> kasasında para olduğundan, bu kasa silinemiyor.');
					}
					else
					{
						if(update_option(array('id'=>$cashbox['id'], 'val_5'=>'delete')))
						{
							if($cashbox['group'] == 'cashbox')
							{
								$data['messages']['defaultCashboxChange'] = array('class'=>'danger', 'title'=>'Kasa Silindi', 
									'description'=>'<strong>'.$cashbox['key'].'</strong> kasası silindi.');
							}
							else
							{
								$data['messages']['defaultCashboxChange'] = array('class'=>'danger', 'title'=>'Banka Hesabı Silindi', 
									'description'=>'<strong>'.$cashbox['key'].'</strong> banka hesabı silindi.');
							}
						}	
					}
				}
			}
		}
		
		
		$this->template->view('payment/cashbox', @$data);	
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
		
		$this->load->view('payment/typehead_search_account', $data);
	}
	
	
}
