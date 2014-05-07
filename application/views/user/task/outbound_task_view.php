<legend class="ff-1"><span class="glyphicon glyphicon-log-out mr9"></span><?php lang('Outbound Tasks'); ?></legend>
<?php $users = get_user_array(); ?>

<div class="row">
	<div class="col-md-12">
    	<table class="table table-hover table-bordered table-condensed table-striped dataTable">
        	<thead>
            	<tr>
                	<th></th>
                    <th><?php lang('Date'); ?></th>
                    <th><?php lang('Status'); ?></th>
                    <th><?php lang('Receiver'); ?></th>
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
			$this->db->where('sender_id', get_the_current_user('id'));		
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
                    <td><?php echo $users[$q['receiver_id']]['name'].' '.$users[$q['receiver_id']]['surname']; ?></a></td>
                    <td><a href="<?php echo site_url('user/task/'.$q['id']); ?>"><?php echo $q['title']; ?></a></td>
                    <td><?php echo substr($q['start_date'],0,16); ?></td>
                    <td><?php echo substr($q['finish_date'],0,16); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    
    </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->