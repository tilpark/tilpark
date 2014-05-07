<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template {

	public function index()
	{
	}
	
	public function view($view, $data='')
	{
		$ci = & get_instance();
		
		$ci->load->view('inc/header', $data);
		$ci->load->view($view, $data);
		$ci->load->view('inc/footer', $data);	
	}
	
	public function blank_view($view, $data='')
	{
		$ci = & get_instance();
		
		$ci->load->view('inc/blank_header', $data);
		$ci->load->view($view, $data);
		$ci->load->view('inc/blank_footer', $data);	
	}
}
?>