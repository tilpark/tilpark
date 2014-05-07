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




	public function profile($user_id='')
	{
		// asagideki islemlerin kontrolu ve duzeni icin bilgileri degiskenlere atayalim
		if($user_id == ''){$user_id = get_the_current_user('id'); }
		$data['user'] = get_user($user_id);
		if($data['user'])
		{
			$data['user_id'] = $user_id;
		}



		// hesabı silme yada aktif etme
		if(isset($_GET['status']) and get_the_current_user('role') < 3)
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

			$avatar = $_FILES['avatar'];
			$config['upload_path'] = './uploads/avatar';
			$config['allowed_types'] = 'gif|jpg|png|PNG|GIF|JPG|JPEG';
			$config['max_size']	= '500';
			$config['max_width']  = '2048';
			$config['max_height']  = '2048';
			$config['file_name']  = $data['user_id'];
			$config['overwrite']  = TRUE;

			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('avatar'))
			{
				$data['formError'] =$this->upload->display_errors();
			}
			else
			{
				$data['messages']['avatar_upload_success'] = array('class' => 'success', 'title'=>'Resim yüklendi.');
				
				$upload_avatar = $this->upload->data();

				update_user($data['user_id'], array('avatar'=>$upload_avatar['file_name']));

				// avatar kucultme
				$config['source_image']	= './uploads/avatar/'.$upload_avatar['file_name'];
				$config['width']	 = 200;
				$config['height']	= 200;
				$this->load->library('image_lib', $config); 
				if (!$this->image_lib->resize())
				{
				    echo $this->image_lib->display_errors();
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
				$update_profile['email'] = $this->input->post('email');
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
				else if(get_the_current_user('role') < 3)
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






	public function new_message($receiver_user_id)
	{
		$data['receiver_user'] = get_user($receiver_user_id);

		$this->template->view('user/messagebox/new', $data);
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
	
	
	
	function inbox($message_id='')
	{
		$data['message_id'] = $message_id;
		$this->template->view('user/messagebox/inbox_view',$data);
	}
	
	function outbox()
	{
		$this->template->view('user/messagebox/outbox_view');
	}
	
	function bulk_message()
	{
		$this->template->view('user/messagebox/bulk_view');	
	}
	
	
	function new_task()
	{
		$this->template->view('user/task/new_task_view');	
	}
	
	function task($task_id='')
	{
		$data['task_id'] = $task_id;
		$this->template->view('user/task/task_view',$data);	
	}
	
	function outbound_tasks()
	{
		$this->template->view('user/task/outbound_task_view');	
	}
	
	

	
}



