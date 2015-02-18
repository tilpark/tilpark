<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
		// sayfa bilgisi
		$data['meta_title'] = 'Stok Yönetimi';
		$data['navigation'][0] = '<li class="active">Stok/Hizmet Kartları</li>';

		$this->template->view('product/dashboard', $data);
	}
	
	
	/* YENI URUN KARTI 
		bu fonksiyon ile yeni urun kartı oluşturabilirsiniz.
	*/
	public function new_product()
	{
		redirect(site_url('product/add'));
	}



	public function add()
	{
		// sayfa bilgisi
		$data['meta_title'] = 'Yeni Stok Kartı';
		$data['navigation'][0] = '<li><a href="'.site_url('product').'">Stok/Hizmet Kartları</a></li>';
		$data['navigation'][1] = '<li class="active">Yeni Stok Kartı</li>';

		/* sayfa ilk acildiğinde, herhangi bir post işlemi olmamış ise input değerlerinin boş gözükmesi için */
		$product['code'] = '';
		$product['name'] = '';
		$product['description'] = '';
		$product['cost_price'] = '';
		$product['sale_price'] = '';
		$product['tax_rate'] = '';
		$product['unit'] = '';
		
		/* yeni ürün kartı eklenmek istediğinde */
		if(isset($_POST['add_product']) and is_log())
		{
			$continue = true;
			$this->form_validation->set_rules('code', get_lang('Barcode Code'), 'min_length[33]|max_length[50]');
			$this->form_validation->set_rules('name', get_lang('Product Name'), 'required|min_length[3]|max_length[100]');
			$this->form_validation->set_rules('cost_price', get_lang('Cost Price'), 'numeric|max_length[10]');
			$this->form_validation->set_rules('sale_price', get_lang('Sale Price'), 'numeric|max_length[10]');
			$this->form_validation->set_rules('tax_rate', get_lang('Tax Rate'), 'integer|max_length[10]');
		
			if($this->form_validation->run() == FALSE)
			{
				# eger gonderilen degerlerde eksik var ise ekrana hata mesajini basmak icin hatalari fonksiyona gonder
				$data['formError'] = validation_errors();
			}
			else
			{
				$product['code'] = strtoupper(replace_text_for_utf8(replace_TR($this->input->post('code'))));
				$product['name'] = mb_strtoupper($this->input->post('name'),'utf-8');
				$product['description'] = mb_strtoupper($this->input->post('description'),'utf8');
				$product['cost_price'] = $this->input->post('cost_price');
				$product['sale_price'] = $this->input->post('sale_price');
				$product['tax_rate'] = $this->input->post('tax_rate');
				$product['unit'] = $this->input->post('unit');
				
				/* Barkod kodu var mi? eger barkod kodu yok ise yeni barkod kodu olustur 
				bu sayede her urun kartinin bir barkod kodu olmak zorunda 
					* asagidaki kod dongusunde eger barkod kodu alani bos ise otomatik barkod kodu olusacaktir fakat kullanici
					herhangi bir yazi yazmis ise sadece o degeri kontrol edecektir. Kullanicinin yazdigi barkod kodu veritabaninda var ise 
					urun karti olusmayacak ve hata mesajini ekrana basacaktir.
				*/
				if($product['code'] == '')
				{ 
					$product['code'] = substr(strtoupper(replace_text_for_utf8(replace_TR($this->input->post('name')))),0,20); 
					
					for($i = is_product_code($product['code']); $i > 0; $i++)
					{
						$product['code'] = strtoupper(replace_text_for_utf8(replace_TR($this->input->post('name')))).'-'.$i; 
						$i = is_product_code($product['code']);
					}
				}
				else
				{
					# barkod kodunun var olup olmadigini kontrol edelim - silinmis stok kartlarinda da barkod aramasi yapilir
					if(is_product_code($product['code']))
					{
						$data['haveBarcode'] = $product['code'];
						$continue = false;
					}
				}
				
				# tum islemler dogru ise $continune fonksiyonu "true" degerinde olacaktir. bu sayede stok kartini olusturabiliriz.
				if($continue)
				{
					$product_id = add_product($product);
					if($product_id > 0)
					{
						$data['add_product_success'] = 'Stok Kart Oluşturuldu';
						$log['date'] = $this->input->post('log_time');
						$log['type'] = 'product';
						$log['title']	= 'Yeni';
						$log['description'] = 'Yeni stok kartı oluşturdu.';
						$log['product_id'] = $product_id;
						add_log($log);
						
						redirect(site_url('product/view/'.$product_id));
					}
					else
					{
						$data['error'] = 'Bilinmeyen Bir Hata!';
					}
				}
				
			}
		}
		
		
		$data['product'] = $product;
		
		$this->template->view('product/add', $data);
	}
	






	public function lists()
	{
		// sayfa bilgisi
		$data['meta_title'] = 'Stok Kartları';
		$data['navigation'][0] = '<li><a href="'.site_url('product').'">Stok/Hizmet Kartları</a></li>';
		$data['navigation'][1] = '<li class="active">Stok Listesi</li>';

		$data['products'] = get_products(array('status'=>'1'));

		$this->template->view('product/lists', $data);	
	}
	
	
	
	
	
	/*
		ÜRÜN GÖSTERİM SAYFASI
		Bu panel sayesinde stok kartları gösterimi yapabilirsiniz.
	*/
		# 1 Ocak 2014 tarihi ile bu fonksiyon view fonksiyonu olarak değiştirilmiştir. Sistemdeki kullanımda olan kodlar için gecici olarak kullanıma açık
		# bırakılmış fakat view fonksiyonuna yönlendirilmiştir.
		public function get_product($product_id_or_code)
		{
			redirect(site_url('product/view/'.$product_id_or_code));	
		}
	
	
	public function view($product_id_or_code)
	{

		$product = get_product(array('id'=>$product_id_or_code));
		if($product)
		{
			$data['product_id'] = $product['id'];
		}
		else
		{
			$product = get_product(array('code'=>$product_id_or_code));	
			if($product)
			{
				$data['product_id'] = $product['id'];
			}
			else
			{
				$data['meta_title'] = 'Stok Kartı Bulunamadı';
				$data['navigation'][0] = '<li><a href="'.site_url('product').'">Stok/Hizmet Kartları</a></li>';
				$data['navigation'][1] = '<li><a href="'.site_url('product/lists').'">Stok Listesi</a></li>';
				$data['navigation'][2] = '<li class="active">Stok Kartı Bulunamadı</li>';

				$data['product_card_not_found'] = true;
				$this->template->view('product/view', $data);
				return false;
			}	
		}

		// sayfa bilgisi
		$data['meta_title'] = $product['name'];
		$data['navigation'][0] = '<li><a href="'.site_url('product').'">Stok/Hizmet Kartları</a></li>';
		$data['navigation'][1] = '<li><a href="'.site_url('product/lists').'">Stok Listesi</a></li>';
		$data['navigation'][2] = '<li class="active">'.$product['name'].'</li>';

		$data['product'] = $product;
		// gerçek stok miktarını hesaplıyoruz.
		calc_product($product['id']);
		
		


		// ürün kartının status durumu güncellenmek istenir ise
		if(isset($_GET['status']) and get_the_current_user('role') <= 3)
		{	
			$_GET['status'] = base64_decode($_GET['status']);
			if($_GET['status'] != '0' & $_GET['status'] != '1') { exit('status degeri "0" yada "1" olmalidir.'); }
			
			$this->db->where('id', $product['id']);
			$this->db->update('products', array('status'=>$_GET['status']));
			if($this->db->affected_rows() > 0)
			{
				if($_GET['status'] == '0') 
				{ 
					add_log(array('type'=>'delete', 'title'=>'Ürün Kartı', 'description'=>'Ürün kartını sildi.', 'product_id'=>$product['id'])); 
				}
				elseif($_GET['status'] == '1') 
				{ 
					add_log(array('type'=>'delete', 'title'=>'Ürün Kartı', 'description'=>'Silinen stok kartı tekrar aktif edildi.', 'product_id'=>$product['id'])); 
				}
			}
		}
		
		

		
		
		/*
			STOK KARTINI GUNCELLE
			Bu bölümden stok kartının güncellemesini gerçekleştiriyoruz.
		*/
		if(isset($_POST['update_product']) and is_log())
		{
			$continue = true;
			$this->form_validation->set_rules('code', get_lang('Barcode Code'), 'min_length[3]|max_length[20]');
			$this->form_validation->set_rules('name', get_lang('Product Name'), 'required|min_length[3]|max_length[100]');
			$this->form_validation->set_rules('cost_price', get_lang('Cost Price'), 'numeric|max_length[10]');
			$this->form_validation->set_rules('sale_price', get_lang('Sale Price'), 'numeric|max_length[10]');
			$this->form_validation->set_rules('tax_rate', get_lang('Tax Rate'), 'integer|max_length[2]');
		
			if ($this->form_validation->run() == FALSE)
			{
				$data['alerts']['form_validation_error_1'] = array('class'=>'danger', 'title'=>'Form Hatası', 'description'=>validation_errors());
			}
			else
			{
				$product['code'] = strtoupper(replace_text_for_utf8(replace_TR($this->input->post('code'))));
				$product['name'] = $this->input->post('name');
				$product['description'] = $this->input->post('description');
				$product['cost_price'] = $this->input->post('cost_price');
				$product['sale_price'] = $this->input->post('sale_price');
				$product['tax_rate'] = $this->input->post('tax_rate');
				$product['unit'] = $this->input->post('unit');
				
				/* 	Barkod kodu var mi? eger barkod kodu yok ise yeni barkod kodu olustur 
					bu sayede her urun kartinin bir barkod kodu olmak zorunda 
				*/
					if($product['code'] == '')
					{ 
						$product['code'] = replace_text_for_utf8($this->input->post('name')); 
						
						for($i = is_product_code($product['code'], $product['id']); $i > 0; $i++)
						{
							$product['code'] = replace_text_for_utf8($this->input->post('name')).'-'.$i; 
							$i = is_product_code($product['code'], $product['id']);
						}
					}
					else
					{
						if(is_product_code($product['code'], $product['id']))
						{
							// eger stok kodu baska bir stok kartinda var ise ekrana hata basalim
							$other_product = get_product(array('code'=>$product['code']));

							$data['alerts']['have_barcode'] = array('class'=>'danger', 'title'=>'Stok Kodu Kullanımda.', 'description'=>'"'.$product['code'].'" stok kodu başka bir stok kartında bulundu. Stok kodları/barkod kodları eşssiz olmalı. Bir stok kodu başka bir stok kartında kullanılamaz. <br />'.'
								Bulunan stok kartı: <a href="'.site_url('product/view/'.$other_product['code']).'" target="_blank">'.$other_product['name'].'</a>
							');
							$continue = false;
						}
					}
			
				if($continue)
				{					
					if(update_product($product['id'], $product))
					{
						$data['alerts']['update_product'] = array('class'=>'success', 'title'=>'Stok Kartı Güncellendi');
						
						$log['date'] = $this->input->post('log_time');
						$log['type'] = 'product';
						$log['title']	= 'Güncelleme';
						$log['description'] = 'Stok kartını güncelledi.';
						$log['product_id'] = $product['id'];
						add_log($log);
					}
				}
				
			}
		}
		
		
		

		/**
		 * @package RESIM YUKLEME
		 * @version 1.3
		 */
		/*
			Buradaki islemler ile resim yuklemesi yapilmaktadir.
		*/
		if(isset($_FILES['image']) and is_log())
		{
			if(!file_exists('./uploads/products')){ mkdir('./uploads/products'); }
			if(!file_exists('./uploads/products/'.$product['id'])){ mkdir('./uploads/products/'.$product['id']); }
			
			$config['upload_path'] 		= './uploads/products/'.$product['id'];
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['max_size']		= '4096';
			$config['max_width']  	= '4096';
			$config['max_height']  	= '4096';
			$config['encrypt_name'] = true;
	
			$this->load->library('upload', $config);
	
			if(!$this->upload->do_upload('image'))
			{
				$data['alerts']['no_image_upload'] = array('class'=>'danger', 'title'=>'Resim yüklenirken bir hata oluştu', 'description'=>$this->upload->display_errors());
			}
			else
			{
				$data['success_image_upload'] = $this->upload->data();
				
				if($data['success_image_upload']['file_name'])
				{
					$image['product_id'] = $product['id'];
					$image['group'] 	= 'gallery';
					$image['key']		= $data['success_image_upload']['file_name']; // dosyanin yuklendikten sonraki adi
					$image['val_1']		= $data['success_image_upload']['full_path']; // dosyanin tam yolu
					$image['val_2']		= $data['success_image_upload']['image_type']; // dosya turu
					$image['val_3']		= $data['success_image_upload']['file_size']; // dosyanin boyutu kb
					$image['val_4']		= $data['success_image_upload']['image_width']; // dosyanin genislisi
					$image['val_5']		= $data['success_image_upload']['image_height']; // dosyanin yuksekligi
					$image_id = add_product_meta($image);
					if($image_id)
					{
						$data['alerts']['image_uploaded'] = array('class'=>'success', 'title'=>'Stok görseli eklendi.');

						$log['type'] = 'product';
						$log['title'] = 'Resim Yükleme';
						$log['description'] = 'Yeni resim yüklendi. /'.$image['key'];
						$log['product_id'] = $product['id'];
						add_log($log);
						
						// varsayilan resim daha onceden var mi yok mu kontrol ediyoruz eger yok ise bu resmi varsayilan resim yapiyoruz
						if(!get_product_meta(array('product_id'=>$product['id'], 'group'=>'gallery', 'val_text'=>'default_image')))
						{
							$this->db->where('id', $image_id);
							$this->db->update('product_meta', array('val_text'=>'default_image'));
						}
					}
					else
					{
						$data['alerts']['error_image_upload'] = array('class'=>'danger', 'title'=>'Bilinmeyen bir hata.');
					}
				}
				else
				{
					$data['alerts']['no_image_file'] = array('class'=>'danger', 'title'=>'Yüklemeye çalıştığınız dosya, bir resim dosyası değil.');
				}
			}
		}
		/* /RESIM YUKLEME */
		


		/* 
		* RESIM SILME 
		* Buradaki fonksiyonlar ile resimleri silebiliriz
		*/
		if(isset($_GET['delete_product_image']))
		{
			$delete_image_id = $_GET['delete_product_image'];
			
			$this->db->where('id', $delete_image_id);
			$this->db->where('product_id', $product['id']);
			$this->db->where('group', 'gallery');	
			$query = $this->db->get('product_meta')->row_array();
			if($query)
			{
				if(unlink($query['val_1']))
				{
					$this->db->where('id', $delete_image_id);
					$this->db->delete('product_meta');
					if($this->db->affected_rows() > 0)
					{
						$data['alerts']['product_image_delete'] = array('class'=>'warning', 'title'=>'Stok görseli silindi.');

						$log['type'] = 'product';
						$log['title']	= 'Resim Silme';
						$log['description'] = 'Resim silindi. /'.$query['key'];
						$log['product_id'] = $product['id'];
						add_log($log);
						
						// eger silinen resim varsayilan resim ise baka bir resmi varsayilan resim yapiyoruz
						if($query['val_text'] == 'default_image')
						{
							$this->db->where('product_id', $product['id']);
							$this->db->where('group', 'gallery');	
							$this->db->limit('1');
							$this->db->order_by('id', 'ASC');
							$this->db->update('product_meta', array('val_text'=>'default_image'));
							if($this->db->affected_rows() > 0)
							{
								$data['alerts']['default_image_change'] = array('class'=>'success', 'title'=>'Varsayılan stok görseli değişti.');
							}
						}
					}
				}
			}
		}
		/* /RESIM SILME */
		
		


		/* 
		* VARSAYILAN RESIM YAPMA 
		* Varsayilan resimleri degistirmek icin kullanilir
		*/
		if(isset($_GET['default_image']))
		{
			$image_id = $_GET['default_image'];
			
			$this->db->where('id', $image_id);
			$this->db->where('product_id', $product['id']);
			$this->db->where('group', 'gallery');	
			$query = $this->db->get('product_meta')->row_array();
			if($query)
			{
				// varsayilan gorsel baska bir gorselde var ise gorselin varsayilan etiketini kaldiralim ki yeni gorsele varsayilan etiketi ekleyelim
				$this->db->where('product_id', $product['id']);
				$this->db->where('group', 'gallery');
				$this->db->where('val_text', 'default_image');
				$this->db->update('product_meta', array('val_text'=>''));
				
				// simdi yeni gorseli varsayilan gorsel olarak etiketlendirelim
				$this->db->where('id', $image_id);
				$this->db->update('product_meta', array('val_text'=>'default_image'));
				if($this->db->affected_rows() > 0)
				{
					$data['alerts']['default_image_change'] = array('class'=>'success', 'title'=>'Varsayılan stok görseli değişti.');
				}
			}
		}
		/* /VARSAYILAN RESIM YAPMA */
		
		
		
		
		// stok kartını çağıralım
		$data['product'] = get_product(array('id'=>$product['id']));
			// stok kartı silinmis mi?
			if($data['product']['status'] == '0'){$data['alerts']['product_deleted'] = array('class'=>'danger', 'title'=>'Stok Kartı Silinmiş', 'description'=>'Stok kartı silinmiş, fakat endişe etmeyin. Stok kartını tekrar aktif edebilirsiniz.');}		
			
		$this->template->view('product/view', $data);
	}
	
	
	
	
	


	/* BARKOD YAZDIRMA
		stok barkod yazdırma sayfası */
	function print_barcode($id)
	{
		$data['product'] = get_product($id);
		$this->load->view('product/print_barcode', $data);
	}

	
}
