<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		
	}
	
	public function login()
	{
		$this->load->view('login');	
	}
	
	public function logout()
	{
		$this->session->set_userdata('login', false);
		redirect(site_url());
	}
	
	/**
	* users()
	*
	* @author	: Mustafa TANRIVERDI
	* @email	: thetanriverdi@gmail.com
	* @website  : www.tilpark.com
	*
	* Kullanıcı listesini gösterir
	*/
	
	public function users()
	{
		$data['users'] = get_users(array('status'=>'1', 'result_array'=>true, 'order_by'=>'role ASC'));
		$this->template->view('user/list', $data);
	}




	public function profile($user_id='')
	{
		// asagideki islemlerin kontrolu ve duzeni icin bilgileri degiskenlere atayalim
		if($user_id == ''){$user_id = get_the_current_user('id'); }
		$data['user'] = get_user($user_id);
		if($data['user'])
		{
			$data['user_id'] = $user_id;
		}

		// meta title
		$data['meta_title'] = $data['user']['name'].' '.$data['user']['surname'];



		// hesabı silme yada aktif etme
		if(isset($_GET['status']) and is_admin())
		{
			if($_GET['status'] == 1){}else if($_GET['status'] == 0){}else{exit('sen neyin pesindesin');}
			update_user($user_id, array('status'=>$_GET['status']));
		}



		/* profil fotografi guncelleme */
		if(isset($_FILES['avatar']))
		{
			// klasor varmı yok mu kontrol et ve resim yukle
			if(!file_exists('./uploads/avatar'))
			{
				mkdir('./uploads/avatar');
			}



			// resim yukleme sinifi
			include_once('./plugins/verot/class.upload.php');
			
			$handle = new upload($_FILES['avatar']); 
			if ($handle->uploaded) 
			{
				$handle->file_new_name_body 	 = get_the_current_user('id');
				$handle->image_resize          = true;
				$handle->image_ratio_crop      = true;
				$handle->image_x               = 200;
				$handle->image_y               = 200;
				$handle->file_max_size 		 = (2048 * 1000); // 1KB
				$handle->image_convert = 'jpg';
				
				$handle->process('./uploads/avatar/');
				if($handle->processed) 
				{ 
					if($data['user']['avatar'] != 'avatar.png')
					{
						unlink('./uploads/avatar/'.$data['user']['avatar']);
					}	
				
					$data['messages']['avatar_upload_success'] = array('class' => 'success', 'title'=>'Resim yüklendi.');
					update_user($data['user_id'], array('avatar'=>$handle->file_dst_name));
				} 
				else 
				{
					$data['formError'] = $handle->error;
				}
			}
			
			
			
			
			$handle_thumb = new upload($_FILES['avatar']); 
			if ($handle_thumb->uploaded) 
			{
				$handle_thumb->file_new_name_body 	 = 'thumb_'.$handle->file_dst_name_body;
				$handle_thumb->image_resize          = true;
				$handle_thumb->image_ratio_crop      = true;
				$handle_thumb->image_x               = 50;
				$handle_thumb->image_y               = 50;
				$handle_thumb->file_max_size 		 = (2048 * 1000); // 1KB
				$handle_thumb->image_convert = 'jpg';
				
				$handle_thumb->process('./uploads/avatar/');
				if($handle_thumb->processed) 
				{ 
					if($data['user']['avatar'] != 'avatar.png')
					{
						unlink('./uploads/avatar/'.'thumb_'.$data['user']['avatar']);
					}	
				
					$data['messages']['thumb_upload_success'] = array('class' => 'success', 'title'=>'Mini resim oluşturuldu.');
					//update_user($data['user_id'], array('avatar'=>$handle_thumb->file_dst_name));
				} 
				else 
				{
					$data['formError'] = $handle_thumb->error;
				}
			}
			
			
			$handle_thumb = new upload($_FILES['avatar']); 
			if ($handle_thumb->uploaded) 
			{
				$handle_thumb->file_new_name_body 	 = 'thumb_height_'.$handle->file_dst_name_body;
				$handle_thumb->image_resize          = true;
				$handle_thumb->image_ratio_crop      = true;
				$handle_thumb->image_x               = 50;
				$handle_thumb->image_y               = 100;
				$handle_thumb->file_max_size 		 = (2048 * 1000); // 1KB
				$handle_thumb->image_convert = 'jpg';
				
				$handle_thumb->process('./uploads/avatar/');
				if($handle_thumb->processed) 
				{ 
					if($data['user']['avatar'] != 'avatar.png')
					{
						unlink('./uploads/avatar/'.'thumb_height_'.$data['user']['avatar']);
					}	
				
					$data['messages']['thumb_upload_success'] = array('class' => 'success', 'title'=>'Mini resim oluşturuldu.');
					//update_user($data['user_id'], array('avatar'=>$handle_thumb->file_dst_name));
				} 
				else 
				{
					$data['formError'] = $handle_thumb->error;
				}
			}
			
			
			
			$handle_thumb = new upload($_FILES['avatar']); 
			if ($handle_thumb->uploaded) 
			{
				$handle_thumb->file_new_name_body 	 = 'thumb_width_'.$handle->file_dst_name_body;
				$handle_thumb->image_resize          = true;
				$handle_thumb->image_ratio_crop      = true;
				$handle_thumb->image_x               = 100;
				$handle_thumb->image_y               = 50;
				$handle_thumb->file_max_size 		 = (2048 * 1000); // 1KB
				$handle_thumb->image_convert = 'jpg';
				
				$handle_thumb->process('./uploads/avatar/');
				if($handle_thumb->processed) 
				{ 
					if($data['user']['avatar'] != 'avatar.png')
					{
						unlink('./uploads/avatar/'.'thumb_width_'.$data['user']['avatar']);
					}	
				
					$data['messages']['thumb_upload_success'] = array('class' => 'success', 'title'=>'Mini resim oluşturuldu.');
					//update_user($data['user_id'], array('avatar'=>$handle_thumb->file_dst_name));
				} 
				else 
				{
					$data['formError'] = $handle_thumb->error;
				}
			}
		}



		/* kullanici bilgileri gunceleme */
		if(isset($_POST['update_profile']))
		{
			$continue = true;
			$this->form_validation->set_rules('name', 'Ad', 'required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('surname', 'Soyad', 'required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('role', 'Yetki', 'required|max_length[1]|integer');
			$this->form_validation->set_rules('gsm', 'Telefon', 'required|min_length[10]|max_length[11]|integer');
		
			if($this->form_validation->run() == FALSE)
			{
				$data['formError'] = validation_errors();
			}
			else
			{
				$update_profile['name'] = $this->input->post('name');
				$update_profile['surname'] = $this->input->post('surname');
				$update_profile['role'] = $this->input->post('role');
				$update_profile['gsm'] = gsm_trim($this->input->post('gsm'));

				if(update_user($data['user_id'], $update_profile))
				{
					$data['messages']['success_avatar'] = array('class' => 'success', 'title'=>'Profil bilgileri güncellendi');
				}
			}
		}



		/* kullanici bilgileri gunceleme */
		if(isset($_POST['update_login_information']))
		{
			$continue = true;
			if($this->input->post('email') == get_the_current_user('email') or $this->input->post('email') == $data['user']['email']){}
			else
			{
				$this->form_validation->set_rules('email', 'E-posta', 'required|valid_email|min_length[3]|max_length[50]|is_unique[users.email]');
			}
			if(strlen($this->input->post('new_pass')) > 0)
			{
				$this->form_validation->set_rules('new_pass', 'Yeni şifre', 'min_length[6]|max_length[32]');
			}
			$this->form_validation->set_rules('old_pass', 'Güncel şifre', 'min_length[6]|max_length[32]');
		
			if($this->form_validation->run() == FALSE)
			{
				$data['formError'] = validation_errors();
			}
			else
			{
				$update_profile['email'] = $this->input->post('email');
				$control['new_pass'] = $this->input->post('new_pass');
				$control['new_pass_repair'] = $this->input->post('new_pass_repair');
				$control['old_pass'] = $this->input->post('old_pass');

				// yeni sifre guncellemesi olacak mi?
				if(strlen($this->input->post('new_pass')) > 0)
				{
					// yeni sifre ile yeni sifrenin tekrarını kontrol et
					if($control['new_pass'] != $control['new_pass_repair'])
					{
						$data['messages']['error_pass_repair'] = array('class' => 'danger', 'title'=>'Şifreler uyuşmuyor', 'description'=>'Şifreni değiştirmek için girdiğin yeni şifre ile yeni şifre tekrarı aynı değil.');
					}
					else
					{
						$update_profile['password'] = md5($control['new_pass']);
					}
				}

				// eski sifrenin kontrolu
				if($user_id == get_the_current_user('id'))
				{
					if(md5($control['old_pass']) != $data['user']['password'])
					{
						$data['messages']['error_pass_repair'] = array('class' => 'danger', 'title'=>'Eski şifren doğru değil', 'description'=>'Eski şifren doğru değil. Lütfen eski şifreni yeniden yazın.');
					}
					else
					{
						if(update_user($data['user_id'], $update_profile))
						{
							$data['messages']['success_avatar'] = array('class' => 'success', 'title'=>'Giriş bilgileri güncellendi');
						}
					}
				}
				else if(is_admin())
				{
					if(update_user($data['user_id'], $update_profile))
					{
						$data['messages']['success_avatar'] = array('class' => 'success', 'title'=>'Giriş bilgileri güncellendi');
					}
				}
			}
		}

		$data['user'] = get_user($data['user_id']);
		$this->template->view('user/profile', $data);
	}


	
	public function user_list()
	{
		$this->template->view('user/user_list_view');
	}




/* ========================================================================
	 MESSAGEBOX
	 bu satırdan sonra mesaj kutusu gösterimleri ve yeni mesaj gibi çeşitli fonksiyonlar başlamaktadır
* ====================================================================== */


	/* ========================================================================
	 * MESSAGEBOX

		@author : Mustafa TANRIVERDI
		@E-mail : thetanriverdi@gmail.com
		@date   : 12 May, 2014

		Buradaki fonksiyonlar mesaj kutusu ile alakalıdır. Mesaj gönderebilir, alabilirsiniz.
	 * ===================================================================== */

	public function new_message($receiver_user_id='')
	{
		// meta title
		$data['meta_title'] = 'Yeni Mesaj';

		/* eger kullanici ID var ise profil sayfasindan gonderilmistir ve kullanici secimi otomatik yapilacaktir */
		if($receiver_user_id==''){}
		else{ $data['receiver_user'] = get_user($receiver_user_id);}

		/* yeni mesaj gonderme islemi burada basliyor */
		if(isset($_POST['new_message']) and is_log())
		{
			$this->form_validation->set_rules('receiver_user_id', 'Alıcı', 'required|integer');
			$this->form_validation->set_rules('title', 'Mesaj Başlığı', 'required|min_length[3]|max_length[100]');
			$this->form_validation->set_rules('content', 'Mesaj Konusu', 'required|min_length[3]');

			if($this->form_validation->run() == FALSE)
			{
				$data['formError'] = validation_errors();
			}
			else
			{
				$message['sender_user_id'] = get_the_current_user('id');
				$message['receiver_user_id'] = $this->input->post('receiver_user_id');
				$message['title'] = $this->input->post('title');
				$message['content'] = $this->input->post('content');

				$message_id = add_messagebox($message);

				if($message_id > 0)
				{
					$data['messages']['send_message'] = array('class' => 'success', 'title'=>'Yeni mesaj gönderildi.');
					redirect(site_url('user/inbox/'.$message_id));
				}
				else
				{
					$data['messages']['error_message'] = array('class' => 'danger', 'title'=>'Bilinmeyen bir hata oluştu.');
				}
			}
		}

		$this->template->view('user/messagebox/new', $data);
	}



	/* ========================================================================
		messagebox

		@author : Mustafa TANRIVERDI
		@E-mail : thetanriverdi@gmail.com
		@date	: 12 May, 2014

		Mesaj gelen kutusunu gösterir aynı zamanda mesaj kutusunun ana yönetim bölümüdür.
	* ===================================================================== */
	public function inbox($message_id='')
	{
		if($message_id == '')
		{
			// meta title
			$data['meta_title'] = 'Mesaj Kutusu';

			$this->template->view('user/messagebox/inbox', $data);
		}
		else
		{
			
			$data['message'] = get_message(array('id'=>$message_id));
			
			// meta title
			$data['meta_title'] = $data['message']['title'];
				
			if($data['message'])
			{
				# mesaj silme islemi
				if(isset($_GET['status']))
				{
					$status = $_GET['status'];
					
					if($data['message']['sender_user_id'] == get_the_current_user('id'))
					{
						$this->db->where('id', $message_id);
						$this->db->update('messagebox', array('delete_sender'=>$status));
						
						$this->db->where('messagebox_id', $message_id);
						$this->db->where('sender_user_id', get_the_current_user('id'));
						$this->db->update('messagebox', array('delete_sender'=>$status));
						
						$this->db->where('messagebox_id', $message_id);
						$this->db->where('receiver_user_id', get_the_current_user('id'));
						$this->db->update('messagebox', array('delete_receiver'=>$status));
					}
					else
					{
						$this->db->where('id', $message_id);
						$this->db->update('messagebox', array('delete_receiver'=>$status));
						
						$this->db->where('messagebox_id', $message_id);
						$this->db->where('sender_user_id', get_the_current_user('id'));
						$this->db->update('messagebox', array('delete_sender'=>$status));
						
						$this->db->where('messagebox_id', $message_id);
						$this->db->where('receiver_user_id', get_the_current_user('id'));
						$this->db->update('messagebox', array('delete_receiver'=>$status));
					}
				}
				
				


				if(isset($_POST['reply_message']))
				{
					$this->form_validation->set_rules('content', 'Mesaj', 'required|min_length[2]');

					if($this->form_validation->run() == FALSE)
					{
						$data['formError'] = validation_errors();
					}
					else
					{
						if(get_the_current_user('id') == $data['message']['sender_user_id'])
						{
							$reply_message['sender_user_id'] = get_the_current_user('id');
							$reply_message['receiver_user_id'] = $data['message']['receiver_user_id'];
						}
						else
						{
							$reply_message['sender_user_id'] = get_the_current_user('id');
							$reply_message['receiver_user_id'] = $data['message']['sender_user_id'];
						}

						$reply_message['content'] = $this->input->post('content');
						$reply_message['messagebox_id'] = $data['message']['id'];

						if(add_messagebox($reply_message))
						{
							$data['messages']['send_message'] = array('class' => 'success', 'title'=>'Yeni mesaj gönderildi.');
							redirect(site_url('user/inbox/'.$reply_message['messagebox_id']));
						}
						else
						{
							$data['messages']['error_message'] = array('class' => 'danger', 'title'=>'Bilinmeyen bir hata!', 'Mesaj gönderilemedi');
						}
					}
				}
				
				
				$data['message'] = get_message(array('id'=>$message_id));

			}
			else
			{
				// meta title
				$data['meta_title'] = 'Mesaj ID Bulunamadı';
				$data['error_404'] = 'Mesaj id bulunamadı';
			}

			
			$this->template->view('user/messagebox/inbox_view', $data);
		}
	}
	
	
	
	
	
	
	
	











/* ========================================================================
	 GÖREV YÖNETİCİSİ
	 bu satırdan sonra görev yönetici fonksiyonları başlamaktadır.
* ====================================================================== */


	 
	/**
	* new_task()
	*
	* @author	: Mustafa TANRIVERDI
	* @email	: thetanriverdi@gmail.com
	* @website  : www.tilpark.com
	*
	* Yeni görev ataması için kullanılan kontrol fonksiyonları
	*/

	public function new_task($receiver_user_id='')
	{
		// meta title
		$data['meta_title'] = 'Yeni Görev';

		/* eger kullanici ID var ise profil sayfasindan gonderilmistir ve kullanici secimi otomatik yapilacaktir */
		if($receiver_user_id==''){}
		else{ $data['receiver_user'] = get_user($receiver_user_id);}

		/* yeni mesaj gonderme islemi burada basliyor */
		if(isset($_POST['new']) and is_log())
		{
			$this->form_validation->set_rules('receiver_user_id', 'Alıcı', 'required|integer');
			$this->form_validation->set_rules('title', 'Mesaj Başlığı', 'required|min_length[3]|max_length[100]');
			$this->form_validation->set_rules('content', 'Mesaj Konusu', 'required|min_length[3]');
			$this->form_validation->set_rules('date_start', 'Başlangıç Tarihi', 'required');
			$this->form_validation->set_rules('date_end', 'Bitirme Tarihi', 'required');

			if($this->form_validation->run() == FALSE)
			{
				$data['formError'] = validation_errors();
			}
			else
			{
				$message['type'] = 'task';
				$message['sender_user_id'] = get_the_current_user('id');
				$message['receiver_user_id'] = $this->input->post('receiver_user_id');
				$message['title'] = $this->input->post('title');
				$message['content'] = $this->input->post('content');
				$message['date_start'] = $this->input->post('date_start');
				$message['date_end'] = $this->input->post('date_end');
				$message['importance'] = $this->input->post('importance');
				

				$message_id = add_messagebox($message);

				if($message_id > 0)
				{
					$data['messages']['send_message'] = array('class' => 'success', 'title'=>'Yeni mesaj gönderildi.');
					redirect(site_url('user/task/'.$message_id));
				}
				else
				{
					$data['messages']['error_message'] = array('class' => 'danger', 'title'=>'Bilinmeyen bir hata oluştu.');
				}
			}
		}

		$this->template->view('user/task/new', $data);
	}
	
	
	
	
	
	/**
	* task()
	*
	* @author	: Mustafa TANRIVERDI
	* @email	: thetanriverdi@gmail.com
	* @website  : www.tilpark.com
	*
	* Gelen/giden görevleri görüntülemek için kullanılır
	*/
	
	public function task($message_id='')
	{
		if($message_id == '')
		{
			// meta title
			$data['meta_title'] = 'Görev Yöneticisi';

			$this->template->view('user/task/inbox', $data);
		}
		else
		{
			
			# mesaj silme islemi
			if(isset($_GET['status']))
			{
				$data['message'] = get_message(array('id'=>$message_id));
				$status = $_GET['status'];
				
				if($data['message']['sender_user_id'] == get_the_current_user('id'))
				{
					$this->db->where('id', $message_id);
					$this->db->update('messagebox', array('delete_sender'=>$status));
					
					$this->db->where('messagebox_id', $message_id);
					$this->db->where('sender_user_id', get_the_current_user('id'));
					$this->db->update('messagebox', array('delete_sender'=>$status));
					
					$this->db->where('messagebox_id', $message_id);
					$this->db->where('receiver_user_id', get_the_current_user('id'));
					$this->db->update('messagebox', array('delete_receiver'=>$status));
				}
				else
				{
					$this->db->where('id', $message_id);
					$this->db->update('messagebox', array('delete_receiver'=>$status));
					
					$this->db->where('messagebox_id', $message_id);
					$this->db->where('sender_user_id', get_the_current_user('id'));
					$this->db->update('messagebox', array('delete_sender'=>$status));
					
					$this->db->where('messagebox_id', $message_id);
					$this->db->where('receiver_user_id', get_the_current_user('id'));
					$this->db->update('messagebox', array('delete_receiver'=>$status));
				}
			}
			
			$data['message'] = get_message(array('id'=>$message_id));
			
			if(isset($_GET['onoff']))
			{
				$onoff = $_GET['onoff'];
				if($onoff == '0' or $onoff == '1'){}else{exit('error: 2934834');}
				
				$this->db->where('id', $message_id);
				$this->db->update('messagebox', array('onoff'=>$onoff));
				if($this->db->affected_rows() > 0)
				{
					if(get_the_current_user('id') == $data['message']['sender_user_id'])
					{
						$reply_message['sender_user_id'] = get_the_current_user('id');
						$reply_message['receiver_user_id'] = $data['message']['receiver_user_id'];
					}
					else
					{
						$reply_message['sender_user_id'] = get_the_current_user('id');
						$reply_message['receiver_user_id'] = $data['message']['sender_user_id'];
					}
					$reply_message['messagebox_id'] = $data['message']['id'];
					$reply_message['type'] = 'task';
					$reply_message['date_start'] 	= $data['message']['date_start'];
					$reply_message['date_end'] 		= $data['message']['date_end'];
					
					if($onoff == 1)
					{
						$reply_message['content'] = 'Görev tarafımdan kapatıldı.';
						add_messagebox($reply_message);
						$data['messages']['onoff_change'] = array('class' => 'success', 'title'=>'Görev kapatıldı.');
					}
					else
					{
						$reply_message['content'] = 'Görev tarafımdan tekrar kullanıma açıldı.';
						add_messagebox($reply_message);
						$data['messages']['onoff_change'] = array('class' => 'success', 'title'=>'Görev tekrar aktif edildi.');
					}
					$data['message'] = get_message(array('id'=>$message_id));
				}
			}
			
			if($data['message'])
			{
				// meta title
				$data['meta_title'] = $data['message']['title'];


				if(isset($_POST['reply_message']))
				{
					$this->form_validation->set_rules('content', 'Mesaj', 'required|min_length[2]');

					if($this->form_validation->run() == FALSE)
					{
						$data['formError'] = validation_errors();
					}
					else
					{
						if(get_the_current_user('id') == $data['message']['sender_user_id'])
						{
							$reply_message['sender_user_id'] = get_the_current_user('id');
							$reply_message['receiver_user_id'] = $data['message']['receiver_user_id'];
						}
						else
						{
							$reply_message['sender_user_id'] = get_the_current_user('id');
							$reply_message['receiver_user_id'] = $data['message']['sender_user_id'];
						}

						$reply_message['content'] = $this->input->post('content');
						$reply_message['messagebox_id'] = $data['message']['id'];

						$reply_message['type'] = 'task';
						$reply_message['date_start'] 	= $data['message']['date_start'];
						$reply_message['date_end'] 		= $data['message']['date_end'];
						if(add_messagebox($reply_message))
						{
							$data['messages']['send_message'] = array('class' => 'success', 'title'=>'Yeni mesaj gönderildi.');
							redirect(site_url('user/task/'.$reply_message['messagebox_id']));
						}
						else
						{
							$data['messages']['error_message'] = array('class' => 'danger', 'title'=>'Bilinmeyen bir hata!', 'Mesaj gönderilemedi');
						}
					}
					$data['message'] = get_message(array('id'=>$message_id));
				}

			}
			else
			{
				// meta title
				$data['meta_title'] = 'Mesaj ID Bulunamadı';
				$data['error_404'] = 'Mesaj id bulunamadı';
			}


			$this->template->view('user/task/view', $data);
		}
	}








/* ========================================================================
	 BİLDİRİM YÖNTETİCİSİ
	 yeni gelen bildirimler buradan yönetilmektedir
* ====================================================================== */


	 
	/**
	* notification()
	*
	* @author	: Mustafa TANRIVERDI
	* @email	: thetanriverdi@gmail.com
	* @website  : www.tilpark.com
	*
	* Yeni bir bildirim okunmak istenildiği zaman buradaki kodlar çalışır :;
	*/

	public function notification($notificaiton_id='')
	{
		$this->db->where('id', $notificaiton_id);
		$query = $this->db->get('messagebox')->row_array();
		if($query)
		{
			if($query['read'] == 0)
			{
				$this->db->update('messagebox', array('read'=>'1', 'date_read'=>date('Y-m-d H:i:s')));
			}
			
			redirect(site_url($query['content']));
			
		}
		else
		{
			exit('error: id not found: 3947254');
		}
	}
	










	public function ajax_search($text='') {

		$ci =& get_instance();

		$this->db->where('status', '1');
		$this->db->like('name', urldecode($text));
		$this->db->or_like('surname', urldecode($text));
		$this->db->or_like('email', urldecode($text));
		$this->db->limit(7);
		$query = $this->db->get('users')->result_array();
		$data['users'] = $query;

		$this->load->view('user/typehead_search_user', $data);

	}











	
	
	
	public function new_user()
	{
		$this->template->view('user/new_user_view');
	}
	
	public function get_user($user_id='')
	{
		if($user_id == ''){exit('no access');}
		$data['user_id'] = $user_id;
		$this->template->view('user/user_view',$data);
	}
	
	
	function no_access($role)
	{
		$data['role'] = $role;
		$this->template->view('user/no_access', $data);
	}
	
	
	
	


	
	

	
}



