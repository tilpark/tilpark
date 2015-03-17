<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	public function index()
	{
		// sayfa bilgisi
		$data['meta_title'] = 'Hesap Yönetimi';
		$data['navigation'][0] = '<li class="active">Hesap Yönetimi</li>';

		$this->template->view('account/dashboard', $data);
	}
	
	/*	YENI HESAP KARTI
		yeni hesap kartı açmak için kullanılacak fonksiyon
	*/
	public function add()
	{
		// sayfa bilgisi
		$data['meta_title'] = 'Yeni Hesap Kartı';
		$data['navigation'][0] = '<li><a href="'.site_url('account').'">Hesap Yönetimi</a></li>';
		$data['navigation'][1] = '<li class="active">Yeni Hesap Kartı</li>';


		$account['code'] = '';
		$account['name'] = '';
		$account['name_surname'] = '';
		$account['balance'] = '';
		$account['phone'] = '';
		$account['gsm'] = '';
		$account['email'] = '';
		$account['address'] = '';
		$account['county'] = '';
		$account['city'] = '';
		$account['description'] = '';
		
		
		if(isset($_POST['add']) and is_log())
		{
			$continue = true;
			$this->form_validation->set_rules('code', 'Hesap Kodu', 'min_length[3]|max_length[30]');
			$this->form_validation->set_rules('name', 'Hesap Adı', 'min_length[3]|max_length[50]');
			$this->form_validation->set_rules('name_surname', 'Ad Soyad', 'required|min_length[3]|max_length[30]');
			$this->form_validation->set_rules('balance', 'Bakiye', 'numeric|max_length[10]');
			$this->form_validation->set_rules('phone', 'Telefon', 'integer|max_length[20]');
			$this->form_validation->set_rules('gsm', 'Cep', 'integer|max_length[20]');
			$this->form_validation->set_rules('email', 'E-Posta', 'email|max_length[50]');
		
			if($this->form_validation->run() == FALSE)
			{
				$data['alerts']['form_validation_error_1'] = array('class'=>'danger', 'title'=>'Form Hatası', 'description'=>validation_errors());
			}
			else
			{
				$account['code'] = strtoupper(replace_text_for_utf8(replace_TR($this->input->post('code'))));
				$account['name'] = strtoupper(replace_TR($this->input->post('name')));
				$account['name_surname'] = strtoupper(replace_TR($this->input->post('name_surname')));
				$account['balance'] = $this->input->post('balance');
				$account['phone'] = $this->input->post('phone');
				$account['gsm'] = $this->input->post('gsm');
				$account['email'] = strtolower(replace_TR($this->input->post('email')));
				$account['address'] = strtoupper(replace_TR($this->input->post('address')));
				$account['county'] = strtoupper(replace_TR($this->input->post('county')));
				$account['city'] = strtoupper(replace_TR($this->input->post('city')));
				$account['description'] = strtoupper(replace_TR($this->input->post('description')));
				
				// if the barcode is empty, auto-create
				if($account['code'] == '')
				{ 
					$account['code'] = strtoupper(replace_text_for_utf8(replace_TR($this->input->post('name')))); 
					
					// Have barcode?
					for($i = is_account_code($account['code']); $i > 0; $i++)
					{
						$account['code'] = replace_text_for_utf8($this->input->post('name')).'-'.($i); 
						$i = is_account_code($account['code']);
					}
				}
				else
				{
					// Have barcode?
					if(is_account_code($account['code']))
					{
						$data['alerts']['have_barcode'] = array('class'=>'danger', 'title'=>'Hesap Barkod Kodu Zaten Kayıtlı', 'description'=>'"'.$account['code'].'" barkod kodu başka bir hesap kartında bulunduğundan, yeni hesap kartı oluşturulamadı.');
						$continue = false;
					}
				}
				
			
				if($continue)
				{
					$account_id = add_account($account);
					if($account_id > 0)
					{
						$data['success']['account_card'] = true;
						$data['alerts']['add_account_card'] = array('class'=>'success', 'title'=>'Hesap Kartı Eklendi', 'description'=>'"'.$account['code'].'" barkod kodu hesap kartı eklendi.');

						$log['type'] = 'account';
						$log['title']	= 'Yeni';
						$log['description'] = 'Yeni hesap kartı oluşturdu.';
						$log['account_id'] = $account_id;
						add_log($log);
						
						redirect(site_url('account/view/'.$account_id));
					}
					else
					{
						alertbox('alert-danger', 'Hata');
					}
				}
			}
		}

		$data['account'] = $account;
		$this->template->view('account/add', $data);
	}
	




	/*
		HESAP KARTI LISTELEME
		Hesap kartlarının listelendigi sayfayı temsil eder
	*/
	public function lists($row=1)
	{
		// meta title
		$data['meta_title'] = 'Hesap Kartları';
		$data['navigation'][0] = '<li><a href="'.site_url('account').'">Hesap Yönetimi</a></li>';
		$data['navigation'][1] = '<li class="active">Hesap Kartları</li>';
		
		
		/* hesap kartlarını degiskene aktaralim */
		$this->db->where('status', '1'); #status "1" olanlar aktif "0" olanlar silinmis
		$data['accounts'] = $this->db->get('accounts')->result_array();

		$this->template->view('account/lists',$data);	
	}
	
	


	


	/*	HESAP KARTI
		hesap kartlarını görmek ve güncellemek etmek için kullanılacak fonksiyon
	*/
		public function get_account($account_id)
		{
			# 1 Ocak 2014 tarihi ile bu fonksiyon kaldırılmıştır. Bu fonksiyon yerine view() fonksiyonu kullanılacaktır.
			redirect(site_url('account/view/'.$account_id));
		}
	
	public function view($account_id_or_code)
	{
 		$account = get_account($account_id_or_code);
		if(!$account)
		{	
			$account = get_account(array('code'=>$account_id_or_code));
			if(!$account)
			{
				$data['account_card_not_found'] = $account_id_or_code;
				$data['meta_title'] = 'Hesap Kartı Bulunamadı';
				$data['navigation'][0] = '<li><a href="'.site_url('account').'">Hesap Yönetimi</a></li>';
				$data['navigation'][1] = '<li><a href="'.site_url('account/lists').'">Hesap Kartları</a></li>';
				$data['navigation'][2] = '<li class="active">Hesap Kartı Bulunamadı</li>';

				$this->template->view('account/view', $data);	
				return false;
			}
		}
		
		if(isset($_GET['status']))
		{
			$log['type'] = 'account';
			$log['title']	= 'Hesap Kartı';
			if($_GET['status'] == 0) {$log['description'] = 'Hesap kartı silindi.';}
			else if($_GET['status'] == 1) {$log['description'] = 'Silinen hesap kartı tekrar aktif edildi.';}
			else {exit('status degeri "0" yada "1" olmalı.');}
			$log['account_id'] = $account['id'];
			
			$this->db->where('id', $account['id']);
			$this->db->update('accounts', array('status'=>$_GET['status']));
			if($this->db->affected_rows() > 0)
			{
				add_log($log);
			}
		}
		
		/*
			Hesap kartının güncellemek
		*/
		if(isset($_POST['update']) and is_log())
		{
			$continue = true;
			$this->form_validation->set_rules('code', 'Hesap Kodu', 'min_length[3]|max_length[100]');
			$this->form_validation->set_rules('name', 'Hesap Adı', 'required|min_length[3]|max_length[100]');
			$this->form_validation->set_rules('balance', 'Bakiye', 'numeric|max_length[10]');
			$this->form_validation->set_rules('phone', 'Telefon', 'integer|max_length[20]');
			$this->form_validation->set_rules('gsm', 'Gsm', 'integer|max_length[20]');
			$this->form_validation->set_rules('email', 'E-posta', 'email|max_length[50]');
		
			if($this->form_validation->run() == FALSE)
			{
				$data['formError'] = validation_errors();
			}
			else
			{
				$account['code'] = strtoupper(replace_text_for_utf8(replace_TR($this->input->post('code'))));
				$account['name'] = strtoupper(replace_TR($this->input->post('name')));
				$account['name_surname'] = strtoupper(replace_TR($this->input->post('name_surname')));
				$account['balance'] = $account['balance'];
				$account['phone'] = $this->input->post('phone');
				$account['gsm'] = $this->input->post('gsm');
				$account['email'] = strtolower(replace_TR($this->input->post('email')));
				$account['address'] = strtoupper(replace_TR($this->input->post('address')));
				$account['county'] = strtoupper(replace_TR($this->input->post('county')));
				$account['city'] = strtoupper(replace_TR($this->input->post('city')));
				$account['description'] = strtoupper(replace_TR($this->input->post('description')));
				
				// if the barcode is empty, auto-create
				if($account['code'] == '')
				{ 
					$account['code'] = strtoupper(replace_text_for_utf8(replace_TR($this->input->post('name')))); 
					
					// Have barcode?
					for($i = is_account_code($account['code']); $i > 0; $i++)
					{
						$account['code'] = replace_text_for_utf8($this->input->post('name')).'-'.$i; 
						$i = is_account_code($account['code'], $account['id']);
					}
				}
				else
				{
					// Have barcode?
					if(is_account_code($account['code'], $account['id']))
					{
						$data['haveBarcode'] = 'Hesap barkod kodu başka bir ürün kartında bulundu.';
						$continue = false;
					}
				}
				
			
				if($continue)
				{
					if(update_account($account['id'], $account))
					{
						$data['update_account_success'] = true;
						$log['microtime'] = $this->input->post('log_time');
						$log['type'] = 'account';
						$log['title']	= 'Hesap';
						$log['description'] = 'Hesap kartı güncellendi.';
						$log['account_id'] = $account['id'];
						add_log($log);
					}
				}
			
			}
		}
		
		// sayfa bilgisi
		$data['meta_title'] = $account['name'];
		$data['navigation'][0] = '<li><a href="'.site_url('account').'">Hesap Yönetimi</a></li>';
		$data['navigation'][1] = '<li><a href="'.site_url('account/lists').'">Hesap Kartları</a></li>';
		$data['navigation'][2] = '<li class="active">'.$account['name'].'</li>';

		calc_account_balance($account['id']);
		$data['account_id'] = $account['id'];
		$data['account'] = get_account($account['id']);
		$this->template->view('account/view', $data);	
	}
	
	
	public function telephone_directory()
	{
		$this->template->view('account/telephone_directory_view');	
	}
	
	public function options()
	{
		$this->template->view('account/options_view');	
	}
	
	public function address_print($account_id)
	{
		$data['account_id'] = $account_id;
		$this->load->view('account/address_print_view', $data);	
	}
	
	
}
