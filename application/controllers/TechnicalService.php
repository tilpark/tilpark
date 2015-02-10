<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TechnicalService extends CI_Controller {
	
	public function index()
	{
		$this->template->view('TechnicalService/dashboard_view');
	}
	
	public function new_service()
	{
		$this->template->view('TechnicalService/new_service_view');	
	}
	
	public function list_services()
	{
		$this->template->view('TechnicalService/list_services_view');	
	}
	
	public function view($service_id)
	{
		$data['service_id'] = $service_id;
		
		$this->template->view('TechnicalService/view_view', $data);	
	}
	
	public function service_status_management()
	{
		$this->template->view('TechnicalService/service_status_management_view');	
	}
	
	public function service_type_management()
	{
		$this->template->view('TechnicalService/service_type_management_view');	
	}
	
	public function brand_type_management()
	{
		$this->template->view('TechnicalService/brand_type_management_view');	
	}
	
	public function options_print_service_form_1()
	{
		$this->template->view('TechnicalService/options_print_service_form_1_view');	
	}
	
	public function options_print_service_form_2()
	{
		$this->template->view('TechnicalService/options_print_service_form_2_view');	
	}
	
	public function print1($service_id)
	{
		$data['service_id'] = $service_id;
		
		$this->template->blank_view('TechnicalService/print1_view', $data);	
	}
	
	public function print2($service_id)
	{
		$data['service_id'] = $service_id;
		
		$this->template->blank_view('TechnicalService/print2_view', $data);	
	}
	
	
	public function settings()
	{
		$this->template->view('TechnicalService/settings_view');	
	}
	
	public function chart()
	{
		$this->template->view('TechnicalService/chart_view');	
	}
	
	public function graphic_report()
	{
		$this->template->view('TechnicalService/graphic_report_view');	
	}
	
	public function day_summary()
	{
		$this->template->view('TechnicalService/r_day_summary_view');	
	}
	
	public function hourly_summary()
	{
		$this->template->view('TechnicalService/r_hourly_summary_view');	
	}
	
	
	public function chart_profit_or_loss()
	{
		$this->template->view('TechnicalService/chart_profit_or_loss_view');
	}
	
	public function chart_profit_or_loss_for_day()
	{
		$this->template->view('TechnicalService/chart_profit_or_loss_for_day_view');
	}
	
	public function chart_density_map()
	{
		$this->template->view('TechnicalService/chart_density_map_view');
	}
	
	public function list_guarantee()
	{
		$this->template->view('TechnicalService/list_guarantee_view');	
	}
	
	
	
	public function sms_settings()
	{
		$this->template->view('TechnicalService/sms_settings_view');	
	}
	
	public function service_status_query()
	{
		$this->load->view('TechnicalService/service_status_query_view');	
	}
	
	public function ajax_account_search()
	{
		if(strlen($_GET['search']) > 2)
		{
			$this->load->view('TechnicalService/ajax_account_search_view');
		}
	}
	
	public function mail_settings()
	{
		$this->template->view('TechnicalService/mail_settings_view');	
	}
	
}



