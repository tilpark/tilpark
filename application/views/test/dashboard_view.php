<?php
$this->db->where('option_group', 'plugins');
$this->db->where('option_key', $this->uri->segment(1));
$plugin = $this->db->get('options')->row_array();
?>


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>"><?php lang('Dashboard'); ?></a></li>
  <li><a href="<?php echo site_url('plugins'); ?>"><?php lang('Plugins'); ?></a></li>
  <li class="active"><?php echo $plugin['option_value3']; ?></li>
</ol>



<div class="row">
<div class="col-md-12">
	<h3>this is a plug-in.</h3>
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->