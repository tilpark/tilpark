<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plugins extends CI_Controller {

	public function index()
	{
		$this->template->view('plugins/dashboard_view');
	}
	
}
