<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function add_user($data)
{
	$ci =& get_instance();
	
	// Have user email?
	$ci->db->where('status', '1');
	$ci->db->where('email', $data['email']);
	$query = $ci->db->get('users')->result_array();
	if($query)
	{
		return get_lang('E-mail address is registered.');
		return false;
	}
	
	
	// add user card
	$ci->db->insert('users', array(
		'email'=>$data['email'],
		'name'=>$data['name'],
		'surname'=>$data['surname'],
		'password'=>md5($data['password']),
		'role'=>$data['role']
	));
	return $ci->db->insert_id();
}

function update_user($user_id, $data)
{
	$ci =& get_instance();
	$array = array();
	
	$ci->db->where('id', $user_id);
	$ci->db->update('users', $data);
	return true;
}




function get_user($data)
{
	$ci =& get_instance();
	if(is_array($data))
	{
		if(isset($data['password'])) {unset($data['password']);}
		$ci->db->where($data);
	}
	else
	{
		$ci->db->where('id', $data);
	}
	$query = $ci->db->get('users')->row_array();
	if($query)
	{
		$query['display_name'] = $query['name'].' '.$query['surname'];
		$query['barcode'] = $query['id'];
		return $query;
	}
	else{return false;}
}


function get_role_name($role)
{
	if($role == 5){ $user['role_name'] = 'Personel'; }
	else if($role == 4){ $user['role_name'] = 'Kıdemli Personel'; }
	else if($role == 3){ $user['role_name'] = 'Birim Amiri'; }
	else if($role == 2){ $user['role_name'] = 'Admin'; }
	else if($role == 1){ $user['role_name'] = 'Super Admin'; }
	return $user['role_name'];
}




function get_the_current_user($data)
{
	$ci =& get_instance();
	$user = $ci->session->userdata('user');
	return $user[$data];
}

function the_current_user($data)
{
	echo get_the_current_user($data);
}





/* ========================================================================
 * MESSAGEBOX

	@author : Mustafa TANRIVERDI
	@E-mail : thetanriverdi@gmail.com

buradaki fonksiyonlar ile mesaj gönderebilirsiniz.

 * ===================================================================== */

function add_message($data)
{
	$ci =& get_instance();
	$ci->db->insert('messagebox', $data);
}




function add_log($data)
{
	$ci =& get_instance();
	$data['user_id'] = get_the_current_user('id'); 
	if(isset($_POST['log_time']))
	{
		$data['microtime'] = $_POST['log_time'];
	}
	elseif(isset($_GET['log_time']))
	{
		$data['microtime'] = str_replace('%20', ' ', $_GET['log_time']);
	}
	
	if(isset($_POST['microtime']))
	{
		$data['microtime'] = $_POST['microtime'];
	}
	elseif(isset($_GET['microtime']))
	{
		$data['microtime'] = str_replace('%20', ' ', $_GET['microtime']);
	}
	
	$data['date'] = date('Y-m-d H:i:s');
	$data['ip'] = $ci->input->ip_address();
	$data['browser'] = $ci->agent->browser();
	$data['platform'] = $ci->agent->platform();
	
	$ci->db->insert('user_logs', $data);
}

function is_log()
{
	$ci =& get_instance();
	
	if(isset($_POST['log_time']))
	{
		$data['microtime'] = $_POST['log_time'];
	}
	elseif(isset($_GET['log_time']))
	{
		$data['microtime'] = str_replace('%20', ' ', $_GET['log_time']);
	}
	
	if(isset($_POST['microtime']))
	{
		$data['microtime'] = $_POST['microtime'];
	}
	elseif(isset($_GET['microtime']))
	{
		$data['microtime'] = str_replace('%20', ' ', $_GET['microtime']);
	}
	
	$ci->db->where('microtime', $data['microtime']);
	$ci->db->where('user_id', get_the_current_user('id'));
	$query = $ci->db->get('user_logs')->result_array();
	if($query){ return false; } else {return true; }
}


function get_log_table($data, $order_by='ASC', $array=array())
{
	$ci =& get_instance();
	
	if(!isset($array['user'])){$array['user'] = true;}
	if(!isset($array['form_id'])){$array['form_id'] = true;}
	?>
    
    <script>
	$(document).ready(function(e) {
        $("#form_log_1").validate();
    });
	</script>
    
    <?php
	if(isset($_POST['add_log_user_reviews']) and is_log())
	{
		$log['date'] = $ci->input->post('log_time');
		$log['type'] = 'user_reviews';
		$log['title']	= get_lang('User Reviews');
		$log['description'] = $ci->input->post('description');
		$log['user_id'] = get_the_current_user('id');
		
		if(isset($data['other_id'])) { $log['other_id'] = $data['other_id']; }
		if(isset($data['form_id'])) { $log['form_id'] = $data['form_id']; }
		if(isset($data['product_id'])) { $log['product_id'] = $data['product_id']; }
		if(isset($data['account_id'])) { $log['account_id'] = $data['account_id']; }
		
		add_log($log);
	}
	
	if(isset($_POST['add_log_user_reviews']))
	{
		?>
        <script>
		$(document).ready(function(e) {
			$("#tab_log").click();
		});
		</script>
        <?php
	}
	
	?>
    
    <form name="form_log_1" id="form_log_1" action="?" method="POST">
    	<div class="row">
        	<div class="col-md-10">
                <div class="form-group">
                    <label for="log_user_description" class="control-label ff-1 fs-16"><?php lang('User Reviews'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <input type="text" id="log_user_description" name="description" class="form-control input-lg ff-1 required" minlength="3" maxlength="2000">
                    </div>
                </div> <!-- /.form-group -->
    		</div> <!-- /.col-md-10 -->
            <div class="col-md-2">
            	<div class="form-group">
                	<input type="hidden" name="log_time" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                    <input type="hidden" name="log_type" value="user_reviews" />
        			<input type="hidden" name="add_log_user_reviews" />
                    <label for="log_user_description" class="control-label ff-1 fs-16">&nbsp;</label>
                    <br />
                    <button class="btn btn-default2 btn-lg btn-block"><?php lang('Add'); ?></button>
                </div> <!-- /.form-group -->
            </div>
    	</div> <!-- /.row -->
    </form>
    
    
	<table class="table table-hover table-bordered table-condensed table-striped dataTable_noExcel_noLength">
            <thead>
                <tr>
                	<th class="hide"></th>
                    <th width="130"><?php lang('Date'); ?></th>
                    <?php if($array['user']==true):?><th width="200"><?php lang('User'); ?></th><?php endif; ?>
                    <?php if($array['form_id']==true):?><th width="100">Form ID</th><?php endif; ?>
                    <th><?php lang('Title'); ?></th>
                    <th><?php lang('Description'); ?></th>
                </tr>
            </thead>
            <tbody>
        <?php
		$users = get_user_array();	
		$ci->db->where($data);
		$ci->db->order_by('id', $order_by);
		$query = $ci->db->get('user_logs')->result_array();
		foreach($query as $log):
		?>
        <tr>
        	<td class="hide"></td>
        	<td><?php echo substr($log['date'],0,16); ?></td>
            <?php if($array['user']==true):?><td><a href="<?php echo site_url('user/profile/'.$log['user_id']); ?>" target="_blank"><?php echo $users[$log['user_id']]['name'].' '.$users[$log['user_id']]['surname']; ?></a></td><?php endif; ?>
            <?php if($array['form_id']==true):?><td><?php if($log['form_id'] > 0):?><a href="<?php echo site_url('form/view/'.$log['form_id']); ?>" target="_blank">#<?php echo $log['form_id']; ?></a><?php endif; ?></td><?php endif; ?>
            <td><?php echo $log['title']; ?></td>
            <td><?php echo $log['description']; ?></td>
        </tr>
        <?php endforeach; ?>
        	</tbody>
        </table>	
        <?php
}





function get_user_list($data='')
{
	$ci =& get_instance();
	
	$ci->db->where('status', 1);
	$query = $ci->db->get('users')->result_array();	
	
	?>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered table-condensed dataTable_noExcel_noLength_noInformation">
    	<thead>
        	<tr>
            	<th class="hide"></th>
            	<th width="1"></th>
                <th><?php lang('Display Name'); ?></th>
                <th><?php lang('Role'); ?></th>
            </tr>
        </thead>
        <tbody>
    <?php
	foreach($query as $user)
	{
	?>
    	<tr>
        	<td class="hide"></td>
        	<td width="1">
            	<a href="javascript:;" class="btn btn-xs btn-default btnSelected" 
            		data-user_id='<?php echo $user['id']; ?>' 
                	data-display_name='<?php echo $user['name'].' '.$user['surname']; ?>'>
				<?php lang('Choose'); ?></a>
            </td>
            <td><?php echo $user['name']; ?> <?php echo $user['surname']; ?></td>
            <td><?php echo get_role_name($user['role']); ?></td>
        </tr>
    <?php
	}
	?>
    	</tbody>
    </table>
    
    <script>
        $('.btnSelected').click(function() {
			<?php if(isset($data['user_id'])): ?>$('#<?php echo $data['user_id']; ?>').val($(this).attr('data-user_id'));<?php endif; ?>
			<?php if(isset($data['display_name'])): ?>$('#<?php echo $data['display_name']; ?>').val($(this).attr('data-display_name'));<?php endif; ?>
			$('.close').click();
		});
	</script>
    <?php
}



function calc_inbox()
{
	$ci =& get_instance();
	$ci->db->where('status', 1);
	$ci->db->where_in('type', array('message','reply_message'));
	$ci->db->where('inbox_view', '1');
	$ci->db->where('receiver_id', get_the_current_user('id'));		
	$ci->db->where('read', '['.get_the_current_user('id').']');
	$query = $ci->db->get('user_mess')->num_rows();
	
	return $query;
}


function get_user_array()
{
	$i=0;
	$ci =& get_instance();
	$query = $ci->db->get('users')->result_array();	
	while($i < 10000)
	{
		if(isset($query[$i]))
		{
			if($query[$i]['avatar'] == ''){$query[$i]['avatar'] = 'theme/img/avatar.png';}
			$data[$query[$i]['id']] = $query[$i];
		}
		else
		{
			return $data;
			$i = 10000;	
		}
		$i++;
	}
}




function add_task($data)
{
	$ci =& get_instance();
	$data['recent_activity'] = date("Y-m-d H:i:s");
	if(!isset($data['date'])){$data['date'] = date("Y-m-d H:i:s");}
	if(!isset($data['type'])){$data['type'] = 'task';}
	if(!isset($data['sender_id'])){$data['sender_id'] = get_the_current_user('id');}
	if(!isset($data['read'])){$data['read'] = '['.$data['receiver_id'].']';}
	
	if($data['type'] == 'reply_task')
	{	
		$data['title'] = 'RE: '.$data['title'];
		
		$ci->db->where('top_id', $data['top_id']);
		$ci->db->update('user_mess', array('inbox_view'=>'0'));
		
		$ci->db->where('id', $data['top_id']);
		$query = $ci->db->get('user_mess')->row_array();
		
		// top_id recent activty date updated
		$ci->db->where('id', $data['top_id']);
		$ci->db->update('user_mess', array('recent_activity'=>$data['recent_activity']));

		
		if($query['sender_id'] == get_the_current_user('id'))
		{
			// top_id recent activty date updated
			$ci->db->where('id', $data['top_id']);
			$ci->db->update('user_mess', array('inbox_view'=>'0', 'recent_activity'=>$data['recent_activity']));
		}
	}
	
	$data['recent_activity'] = date("Y-m-d H:i:s");
	$ci->db->insert('user_mess', $data);
	return $ci->db->insert_id();
}


function calc_task()
{
	$ci =& get_instance();
	$ci->db->where('status', 1);
	$ci->db->where_in('type', array('task','reply_task'));
	$ci->db->where('inbox_view', '1');
	$ci->db->where('receiver_id', get_the_current_user('id'));		
	$ci->db->where('read', '['.get_the_current_user('id').']');
	$query = $ci->db->get('user_mess')->num_rows();
	
	return $query;
}





?>