<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller {

	public function index()
	{
		
	}
	
	public function barcode($text)
	{
		if(isset($_GET['print'])) : ?>
        	<img src="<?php echo base_url('plugins/barcode/barcode.php?text='.$text); ?>" title="<?php echo $text; ?>" />
			<script>
            window.print();
            setInterval(function(){window.close();},100);
            </script>
        <?php else: ?>
        	<?php echo base_url('plugins/barcode/barcode.php?text='.$text); ?>
        <?php endif; ?>
        <?php
	}
	
	public function save_note($text='')
	{
		echo '<meta charset="utf-8" />';
		$data['option_group'] = 'dashboard';
		$data['option_key'] = 'dashboard-note';
		$data['option_value'] = urldecode($text);
		update_option($data);
	}
	
	public function map($latitude, $longitude)
	{
		$data['latitude'] = $latitude;
		$data['longitude'] = $longitude;
		$this->load->view('system/map_view', $data);	
	}
	
	public function map_events($latitude, $longitude)
	{
		$data['latitude'] = $latitude;
		$data['longitude'] = $longitude;
		$this->load->view('system/map_events_view', $data);	
	}
	
	public function about()
	{
		$this->template->view('system/about_view'); 	
	}
	
	public function sms($page='')
	{
		if($page == 'settings')
		{
			$this->template->view('system/sms/sms_settings_view');
		}
		elseif($page == 'new_sms')
		{
			$this->template->view('system/sms/new_sms_view');
		}
		else
		{
			$this->template->view('system/sms/sms_view');
		}
			
	}
	
	
	
}
