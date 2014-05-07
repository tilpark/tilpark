<legend class="ff-1"><span class="glyphicon glyphicon-log-in mr9"></span><?php lang('The Tasks'); ?></legend>
<?php $users = get_user_array(); ?>


<?php if(@$task_id != ''): ?>

<?php
// task information
$this->db->where('id', $task_id);
$task = $this->db->get('user_mess')->row_array();

// task redirect
if($task['top_id'] > 0){redirect(site_url('user/task/'.$task['top_id']));}

// task status change
if(isset($_GET['task_status']))
{
	$this->db->where('id', $task_id);
	$this->db->update('user_mess', array('task_status'=>$_GET['task_status']));	
	
	if($task['receiver_id'] == get_the_current_user('id'))
	{
		$data['receiver_id'] 	= $task['sender_id'];
		$data['sender_id'] 		= $task['receiver_id'];
		$data['read']			= '['.$task['sender_id'].']';
	}
	elseif($task['sender_id'] == get_the_current_user('id'))
	{
		$data['receiver_id'] 	= $task['receiver_id'];
		$data['sender_id'] 		= $task['sender_id'];
		$data['read']			= '['.$task['receiver_id'].']';
	}
	
	$data['title'] = $task['title'];
	$data['top_id'] = $task['id'];
	$data['type'] = 'reply_task';
	$data['start_date'] = $task['start_date'];
	$data['finish_date'] = $task['finish_date'];
	if($_GET['task_status']=='close'){$data['content'] = get_lang('This task was closed by me.');}
	else if($_GET['task_status']=='open'){$data['content'] = get_lang('This task is re-opened by me.');}
	add_task($data);
	
	// all task and children task status updated
	$this->db->where('top_id', $task_id);
	$this->db->update('user_mess', array('task_status'=>$_GET['task_status']));	
}

// task information
$this->db->where('id', $task_id);
$task = $this->db->get('user_mess')->row_array();







// task status info
if(isset($_GET['status']))
{
	if($task['sender_id'] == get_the_current_user('id'))
	{
		$this->db->where('id', $task['id']);
		$this->db->update('user_mess', array('status'=>$_GET['status']));
		
		// reload information
		$this->db->where('id', $task_id);
		$task = $this->db->get('user_mess')->row_array();
		
		$log['type'] = 'task';
		$log['other_id'] = 'task:'.$task['id'];
		$log['title'] = get_lang('Task Manager');
		$log['description'] = get_lang('Status Changed').' ['.$_GET['status'].']';
		add_log($log);
	}
	else
	{
		alertbox('alert-warning', get_lang('Change the status of the task of the task started.'), '', false);	
	}
}
if($task['status'] == '0')
{
	alertbox('alert-warning', get_lang('This task has been deleted.'), '', false);
}



// read message
if($task['read']=='['.get_the_current_user('id').']')
{
	if($task['receiver_id'] == get_the_current_user('id'))
	{
		$this->db->where('id', $task['id']);
		$this->db->update('user_mess', array('read'=>'0', 'read_date'=>date("Y-m-d H:i:s")));
	}
}

if($task['receiver_id'] == get_the_current_user('id'))
{
	$this->db->where('id', $task['id']);
	$this->db->update('user_mess', array('inbox_view'=>'1'));	
}
?>

<?php $show_message = true; ?>
<?php if($task['sender_id'] == get_the_current_user('id')): ?>
<?php elseif($task['receiver_id'] == get_the_current_user('id')): ?>
<?php elseif(get_the_current_user('role') <= 2): ?>
<?php else: ?>
	<?php alertbox('alert-danger', get_lang('Error!')); ?>
    <?php $show_message = false; ?>
<?php endif; ?>

<?php if($show_message): ?>
<div class="row">
	<div class="col-md-8">
        
        <?php
		if(isset($_POST['reply']) and is_log())
		{
			$continue = true;
			$this->form_validation->set_rules('content', get_lang('Message'), 'required|min_length[3]|max_length[1000]');
		
			if($this->form_validation->run() == FALSE)
			{
				alertbox('alert-danger', '', validation_errors());
			}
			else
			{
				if($task['receiver_id'] == get_the_current_user('id'))
				{
					$data['receiver_id'] 	= $task['sender_id'];
					$data['sender_id'] 		= $task['receiver_id'];
					$data['read']			= '['.$task['sender_id'].']';
				}
				elseif($task['sender_id'] == get_the_current_user('id'))
				{
					$data['receiver_id'] 	= $task['receiver_id'];
					$data['sender_id'] 		= $task['sender_id'];
					$data['read']			= '['.$task['receiver_id'].']';
				}
				
				$data['title'] = $task['title'];
				$data['top_id'] = $task['id'];
				$data['type'] = 'reply_task';
				$data['start_date'] = $task['start_date'];
				$data['finish_date'] = $task['finish_date'];
				$data['content'] = $this->input->post('content');
				$task_id = add_task($data);
				if($task_id > 0)
				{
					add_log(array('date'=>$_POST['log_time'], 'type'=>'message', 'title'=>'New Message', 'description'=>'posted a new message reply['.$task['id'].']'));
					alertbox('alert-success', get_lang('Message has been sent.'));
					
				}
				else
				{
					alertbox('alert-danger', get_lang('Error!'));
				}
			}
		}
		?>
        
        
        <ul class="nav nav-tabs">
        	<li class="active"><a href="#"><?php lang('Task'); ?></a></li>
        	<li class="dropdown">
          		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
            		<?php lang('Options'); ?> <span class="caret"></span>
          		</a>
          		<ul class="dropdown-menu" role="menu">
                	<?php if($task['task_status'] == 'open'): ?>
                    	<li><a href="<?php echo site_url('user/task/'.$task['id'].'/?task_status=close'); ?>"><?php lang('Close this task'); ?></a></li>
                    <?php else: ?>
                    	<li><a href="<?php echo site_url('user/task/'.$task['id'].'/?task_status=open'); ?>"><?php lang('Open this task'); ?></a></li>
                    <?php endif; ?>
                    <li class="divider"></li>
                    <?php if($task['status'] == '1'): ?>
                    	<li><a href="<?php echo site_url('user/task/'.$task['id'].'/?status=0'); ?>"><?php lang('Delete'); ?></a></li>
                    <?php else: ?>
                    	<li><a href="<?php echo site_url('user/task/'.$task['id'].'/?status=1'); ?>"><?php lang('Reopen'); ?></a></li>
                    <?php endif; ?>
          		</ul>
        	</li>
      	</ul>
		
        <div class="tab-content">
        <div class="h20"></div>
        <div class="row">
            <div class="col-md-12">
            	<div class="bs-callout bs-callout-<?php if($task['task_status'] == 'open'): ?>info<?php else: ?>warning<?php endif; ?>">
                  <h4 class="ff-2">
				  <?php if($task['task_status'] == 'open'): ?>
                  	[<?php lang('Open'); ?>]
                  <?php else: ?>
                  	[<?php lang('Close'); ?>]
                  <?php endif; ?>
				  <?php echo $task['title']; ?></h4>
                  <p></p>
                  <code><?php lang('start date'); ?>: <?php echo substr($task['start_date'],0,16); ?></code> / <code><?php lang('date of completion'); ?>: <?php echo substr($task['finish_date'],0,16); ?></code>
                </div>
            </div> <!-- /.col-md-12 -->
        </div> <!-- /.row -->
        <div class="h20"></div>
        
        <div class="row">
        	<div class="col-md-2">
            	<a href="<?php echo site_url('user/profile/'.$task['sender_id']); ?>" class="img-thumbnail">
                	<?php if($users[$task['sender_id']]['avatar'] == ''): ?>
                		<span class="glyphicon glyphicon-user" style="font-size:72px;"></span>
                    <?php else: ?>
                    	<img src="<?php echo base_url($users[$task['sender_id']]['avatar']); ?>" width="150" height="100" class="img-responsive" />
                    <?php endif; ?> 
                    <small><span class="glyphicon glyphicon-user mr2"></span> <?php echo $users[$task['sender_id']]['surname']; ?></small>
                </a>
            </div> <!-- /.col-md-4 -->
            <div class="col-md-10">
            	<blockquote>
                    <div class="messageContent">
                    	<a href="<?php echo site_url('user/profile/'.$task['sender_id']); ?>"><h4><?php echo $users[$task['sender_id']]['name']; ?> <?php echo $users[$task['sender_id']]['surname']; ?></h4></a>
                    	<?php echo $task['content']; ?>
                    </div>
                   
                    <small><?php lang('Written on'); ?>: <span class="text-success"><?php echo substr($task['date'],0,16); ?></span>, <?php lang('Read on'); ?>: <span class="text-warning"><?php echo substr($task['read_date'],0,16); ?></span> 
                    <?php if(get_the_current_user('role') <= 2): ?><span class="pull-right"><a href="<?php echo site_url('user/inbox/'.$task['id'].'/?delete='.$task['id'].''); ?>" class="text-danger strong"><span class="glyphicon glyphicon-remove-circle"></span> <?php lang('Delete'); ?></a>  </span><?php endif; ?>
                    </small>
            	</blockquote>
                <div class="hr"></div>
            </div> <!-- /.col-md-8 -->
        </div> <!-- /.row -->
        
        <div class="h20"></div>
        
        <?php
		$this->db->where('status', '1');
		$this->db->where('top_id', $task['id']);
		$this->db->order_by('date', 'ASC');
		$replys = $this->db->get('user_mess')->result_array();
		?>
        <?php foreach($replys as $reply): ?>
        <?php
		// read message
		if($reply['read']=='['.get_the_current_user('id').']')
		{
			if($reply['receiver_id'] == get_the_current_user('id'))
			{
				$this->db->where('id', $reply['id']);
				$this->db->update('user_mess', array('read'=>'0', 'read_date'=>date("Y-m-d H:i:s")));
			}
		}
		
		// read message
		if($reply['read']=='['.get_the_current_user('id').']')
		{
			if($task['receiver_id'] == get_the_current_user('id'))
			{
				$this->db->where('id', $reply['id']);
				$this->db->update('user_mess', array('read'=>'0', 'inbox_view'=>'0', 'read_date'=>date("Y-m-d H:i:s")));
			}
		}
		?>
        <div class="row">

        	<div class="col-md-2">
            	<a href="<?php echo site_url('user/profile/'.$reply['sender_id']); ?>" class="img-thumbnail">
                	<?php if($users[$reply['sender_id']]['avatar'] == ''): ?>
                		<span class="glyphicon glyphicon-user" style="font-size:72px;"></span>
                    <?php else: ?>
                    	<img src="<?php echo base_url($users[$reply['sender_id']]['avatar']); ?>" width="150" height="100" class="img-responsive" />
                    <?php endif; ?>
                    <small><span class="glyphicon glyphicon-user mr2"></span> <?php echo $users[$reply['sender_id']]['surname']; ?></small>
                </a>
            </div> <!-- /.col-md-4 -->
            <div class="col-md-10">
            	<blockquote>
                    <div class="messageContent">
                    	<a href="<?php echo site_url('user/profile/'.$reply['sender_id']); ?>"><h4><?php echo $users[$reply['sender_id']]['name']; ?> <?php echo $users[$reply['sender_id']]['surname']; ?></h4></a>
                    	<?php echo $reply['content']; ?>
                    </div>
                    <small><?php lang('Written on'); ?>: <span class="text-success"><?php echo substr($reply['date'],0,16); ?></span>, <?php lang('Read on'); ?>: <span class="text-warning"><?php echo substr($reply['read_date'],0,16); ?></span> </small>
            	</blockquote>
                <div class="hr"></div>
            </div> <!-- /.col-md-8 -->
        </div> <!-- /.row -->
        <div class="h20"></div>
        <?php endforeach; ?>
        
        
        <div class="h20"></div>
        <div class="h20"></div>
        
        <form name="form_reply" id="form_reply" action="" method="POST" class="validation">
        	<div class="form-group">
                <label for="content" class="control-label ff-1 fs-16"><?php lang('Reply'); ?></label>
                <textarea style="width:100%; height:100px;" class="form-control required" name="content" id="content" minlength="3"></textarea>
            </div> <!-- /.form-group -->
            
             <div class="text-right">
             	<input type="hidden" name="log_time" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                <input type="hidden" name="reply" />
                <button class="btn btn-default btn-lg"><?php lang('Send'); ?> &raquo;</button>
            </div> <!-- /.text-right -->
        </form>
        </div> <!-- /.tab-content -->
        
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
                    <td><a href="<?php echo site_url('user/task/'.$q['id']); ?>"><?php echo mb_substr($q['title'],0,30,'utf-8'); ?></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        	<?php alertbox('alert-info', get_lang('No task.'), '', false); ?>
        <?php endif; ?>
    </div> <!-- /.col-md-4 -->
</div> <!-- /.row -->
<?php endif; ?>

<?php else: ?>
<div class="row">
	<div class="col-md-12">
    	<table class="table table-hover table-bordered table-condensed table-striped dataTable">
        	<thead>
            	<tr>
                	<th></th>
                    <th><?php lang('Date'); ?></th>
                    <th><?php lang('Status'); ?></th>
                    <th><?php lang('Sender'); ?></th>
                    <th><?php lang('Title'); ?></th>
                    <th><?php lang('Start Date'); ?></th>
                    <th><?php lang('Date of Completion'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
			$this->db->where('status', 1);
			$this->db->where_in('type', array('task','reply_task'));
			$this->db->where('inbox_view', '1');
			$this->db->where('receiver_id', get_the_current_user('id'));		
			$this->db->order_by('recent_activity', 'DESC');
			$query = $this->db->get('user_mess')->result_array();
			
			foreach($query as $q):	
			
			$q['task_status_text'] = '';
			if($q['task_status'] == 'open'){$q['task_status_text'] = get_lang('Open');}else{$q['task_status_text'] = get_lang('Close');}
			?>
                <tr class="<?php if(strstr($q['read'], '['.get_the_current_user('id').']')){ echo 'active strong';} ?>">
                    <td></td>
                    <td><?php echo substr($q['date'],0,16); ?></td>
                    <td><?php echo $q['task_status_text']; ?></td>
                    <td><?php echo $users[$q['sender_id']]['name'].' '.$users[$q['sender_id']]['surname']; ?></a></td>
                    <td><a href="<?php echo site_url('user/task/'.$q['id']); ?>"><?php echo $q['title']; ?></a></td>
                    <td><?php echo substr($q['start_date'],0,16); ?></td>
                    <td><?php echo substr($q['finish_date'],0,16); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    
    </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<?php endif; ?>