<legend class="ff-1"><span class="glyphicon glyphicon-plus-sign mr9"></span><?php lang('New Task'); ?></legend>
<?php $users = get_user_array(); ?>

<!-- Button trigger modal -->
  <a data-toggle="modal" href="#myModal" id="modal-user_list"></a>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php lang('User List'); ?></h4>
        </div>
        <div class="modal-body">
			<?php get_user_list(array('display_name'=>'display_name',
			'user_id'=>'receiver_id')); ?>
        </div>
        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  

<div class="row">
	<div class="col-md-8">
    
    
    
    	<?php
		$custom_title = '';
		$plus_content = '';
		
		if(isset($_GET['product_id']))
		{
			$product = get_product(array('id'=>$_GET['product_id']));
            $plus_content = '
			<div class="bs-callout bs-callout-danger">
      			<h4>'.get_lang('Product Card').': <a href="'.site_url('product/get_product/'.$product['id']).'" target="_blank">'.$product['name'].'</a></h4>
				
				<small>'.$product['description'].'</small>
				<br />
      			<ul>
	  				<li>'.get_lang('Barcode Code').': <code>'.$product['code'].'</code></li>
					<li>'.get_lang('the current amount of product').': <code>'.round($product['amount']).'</code></li>
				</ul>
			</div>
			<br />';
			
			$custom_title = get_lang('Product Card').': '.$product['name'];
		}
		
		if(isset($_GET['account_id']))
		{
			$account = get_account(array('id'=>$_GET['account_id']));
            $plus_content = '
			<div class="bs-callout bs-callout-danger">
      			<h4>'.get_lang('Product Card').': <a href="'.site_url('account/get_account/'.$account['id']).'" target="_blank">'.$account['name'].'</a> <small>'.$account['county'].'/'.$account['city'].'</small></h4>
				
				<small><strong>'.get_lang('phone').'</strong>:'.$account['phone'].'  <strong>'.get_lang('gsm').'</strong>:'.$account['gsm'].'</small>
				<br />
      			<ul>
	  				<li>'.get_lang('Barcode Code').': <code>'.$account['code'].'</code></li>
					<li>'.get_lang('Balance').': <code>'.get_account_balance($account['balance']).'</code></li>
				</ul>
			</div>
			<br />';
			
			$custom_title = get_lang('Account Card').': '.$account['name'];
		}
		?>
        
    
    	<?php
		if(isset($_POST['new_task']) and is_log())
		{
			$continue = true;
			$this->form_validation->set_rules('receiver_id', get_lang('Receiver'), 'required');
			$this->form_validation->set_rules('title', get_lang('Title'), 'required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('content', get_lang('Message'), 'required|min_length[3]|max_length[5000]');
		
			if($this->form_validation->run() == FALSE)
			{
				alertbox('alert-danger', '', validation_errors());
			}
			else
			{
				$data['receiver_id'] = $this->input->post('receiver_id');
				$data['start_date'] = $this->input->post('start_date');
				$data['finish_date'] = $this->input->post('finish_date');
				$data['title'] = $this->input->post('title');
				$data['content'] = $plus_content.$this->input->post('content');
				$task_id = add_task($data);
				if($task_id > 0)
				{
					add_log(array('date'=>$_POST['log_time'], 'type'=>'task', 'title'=>get_lang('New Task'), 'description'=>get_lang('Posted a new task').' ['.$_POST['display_name'].']'));
					alertbox('alert-success', get_lang('The new task has been created.'));
				}
				else
				{
					alertbox('alert-danger', get_lang('Error!'));
				}
			}
		}
		
		
        if(isset($_GET['invoice_id']))
		{
			$invoice = get_invoice($_GET['invoice_id']);
			$account = get_account(array('id'=>$invoice['account_id']));
            $plus_content = '
			<div class="bs-callout bs-callout-danger">
      			<h4>'.get_lang('Invoice').': <a href="'.site_url('invoice/view/'.$invoice['id']).'" target="_blank">#'.$invoice['id'].'</a> / <small>'.$account['name'].'</small></h4>
				<br />
      			<ul>
					<li>'.get_lang('Invoice').': <code><a href="'.site_url('invoice/view/'.$invoice['id']).'" target="_blank">#'.$invoice['id'].'</a></code></li>
	  				<li>'.get_lang('Account Card').': <code><a href="'.site_url('account/get_account/'.$account['id']).'" target="_blank">'.$account['code'].'</a></code></li>
					<li>'.get_lang('Grand Total').': <code>'.get_account_balance($invoice['grand_total']).'</code></li>
				</ul>
			';
			
			$this->db->where('status', 1);
			$this->db->where('invoice_id', $invoice['id']);
			$items = $this->db->get('fiche_items')->result_array();
			
			$plus_content =  $plus_content.'
			<br />
			<table class="table table-bordered table-condensed table-hover" style="background-color:#fff;">
				<thead>
					<tr>
						<th>'.get_lang('Product Name').'</th>
						<th>'.get_lang('Quantity').'</th>
						<th>'.get_lang('Total').'</th>
						<th>'.get_lang('Tax').'</th>
						<th>'.get_lang('Sub Total').'</th>
					</tr>
				</thead>
				<tbody>';
				foreach($items as $item):
					
					$product = get_product($item['product_id']);
					
					$plus_content =  $plus_content.'
					<tr>
						<td><a href="'.site_url('product/get_product/'.$product['id']).'" target="_blank">'.$product['code'].'</a></td>
						<td class="text-center">'.$item['quantity'].' * '.get_money($item['quantity_price']).'</td>
						<td class="text-right">'.get_money($item['total']).'</td>
						<td class="text-center">% ('.$item['tax_rate'].') '.get_money($item['tax']).'</td>
						<td class="text-right">'.get_money($item['sub_total']).'</td>
					</tr>';
				endforeach; 
				
				$plus_content =  $plus_content.'</tbody>
				<tfoot>
					<tr class="fs-14 no-strong">
						<th class="text-center no-strong">'.get_lang('Grand Total').'</th>
						<th class="text-center no-strong text-danger">'.$invoice['quantity'].'</th>
						<th colspan="1" class="text-right no-strong text-danger">'.get_money($invoice['total']).'</th>
						<th colspan="1" class="text-center no-strong text-danger">'.get_money($invoice['tax']).'</th>
						<th class="text-right fs-16 no-strong text-danger">'.get_money($invoice['grand_total']).'</th>
					</tr>
				</tfoot>
			</table>
			</div>
			<br />';

			$custom_title = get_lang('Invoice').': #'.$invoice['id'].' ['.$account['name'].']';
		}
		?>
    
    
     	<?php
		$user_data['id'] = '';
		$user_data['display_name'] = '';
		if(isset($_GET['user_id']))
		{
			$user_data['id'] = $_GET['user_id'];
			$user_data = get_user($user_data);
		}
		?>
    
        <form name="form_new" id="form_new" action="" method="POST" class="validation">
            <div class="form-group openModal-user_list">
                <input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $user_data['id']; ?>" />
                <label for="display_name" class="control-label ff-1 fs-16"><?php lang('Receiver'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon pointer"><span class="glyphicon glyphicon-user"></span></span>
                    <input type="text" id="display_name" name="display_name" class="form-control input-lg ff-1 required pointer" placeholder="<?php lang('Receiver'); ?>" minlength="3" maxlength="50" value="<?php echo $user_data['display_name']; ?>" readonly="readonly">
                </div>
            </div> <!-- /.form-group -->
            
            	<div class="row">
                	<div class="col-md-6">
                    	<div class="form-group">
                            <label for="start_date" class="control-label ff-1 fs-16"><?php lang('Start Date'); ?></label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input type="text" id="start_date" name="start_date" class="form-control input-lg ff-1 required datepicker pointer" placeholder="<?php lang('Start Date'); ?>" minlength="3" maxlength="50" value="" readonly>
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                    	<div class="form-group">
                            <label for="finish_date" class="control-label ff-1 fs-16"><?php lang('Date of Completion'); ?></label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input type="text" id="finish_date" name="finish_date" class="form-control input-lg ff-1 required datepicker pointer" placeholder="<?php lang('Date of Completion'); ?>" minlength="3" maxlength="50" value="" readonly>
                             </div>
                         </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->
                
               
            
            <div class="form-group">
                <label for="title" class="control-label ff-1 fs-16"><?php lang('Title'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                    <input type="text" id="title" name="title" class="form-control input-lg ff-1 required" placeholder="<?php lang('Title'); ?>" minlength="3" maxlength="50" value="<?php echo $custom_title; ?>">
                </div>
            </div> <!-- /.form-group -->
            
            <?php echo $plus_content; ?>
            
            <div class="form-group">
                <label for="content" class="control-label ff-1 fs-16"><?php lang('Message'); ?></label>
                <textarea style="width:100%; height:160px;" class="form-control required" name="content" id="content" minlength="3"></textarea>
            </div> <!-- /.form-group -->
            
             <div class="text-right">
             	<input type="hidden" name="log_time" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                <input type="hidden" name="new_task" />
                <button class="btn btn-default btn-lg"><?php lang('Send'); ?> &raquo;</button>
            </div> <!-- /.text-right -->
        </form>
       
    </div> <!-- /.col-md-8 -->
    <div class="col-md-4">
    	<div class="box_title turq"><span class="glyphicon glyphicon-globe mr9"></span><?php lang('Task Manager'); ?></div>
        <?php
		$this->db->where('status', 1);
		$this->db->where_in('type', array('task','reply_task'));
		$this->db->where('inbox_view', '1');
		$this->db->where('receiver_id', get_the_current_user('id'));		
		$this->db->order_by('recent_activity', 'DESC');
		$this->db->limit(10);
		$query = $this->db->get('user_mess')->result_array();
		?>
        <?php if($query) : ?>
        <table class="table table-hover table-bordered table-condensed">
            <thead>
                <tr>
                    <th><?php lang('Sender'); ?></th>
                    <th><?php lang('Title'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($query as $q): ?>
               <tr class="<?php if(strstr($q['read'], '['.get_the_current_user('id').']')){ echo 'active strong';} ?>">
                    <td><?php echo $users[$q['sender_id']]['surname']; ?></td>
                    <td><a href="<?php echo site_url('user/inbox/'.$q['id']); ?>"><?php echo $q['title']; ?></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        	<?php alertbox('alert-info', get_lang('No task.'), '', false); ?>
        <?php endif; ?>
    </div> <!-- /.col-md-4 -->
</div> <!-- /.row -->


<script>
    $('.openModal-user_list').click(function() {
		$('#modal-user_list').click();
	});
</script>