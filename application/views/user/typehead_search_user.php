<meta charset="utf-8" />

<div class="ajax_search_box">
<table class="table table-bordered table-hover table-condensed">
    <tbody>
    <?php foreach($users as $user): ?>
    	<tr class="tr_click">
        	<td class="">
            	<div class="pointer select" style="height:40px;"
                	data-id="<?php echo $user['id']; ?>"
                	data-email="<?php echo $user['email']; ?>"
                    data-name="<?php echo $user['name']; ?>"
                    data-surname="<?php echo $user['surname']; ?>"
                    data-role="<?php echo $user['role']; ?>"
                    data-avatar="<?php echo $user['avatar']; ?>"
                    data-gsm="<?php echo $user['gsm']; ?>"
                >
                	<h4 style="margin:5px 0px; padding:0px;"><?php echo $user['name']; ?></h4>
                    <small class="pull-left"><?php echo $user['surname']; ?></small>
                    <small class="pull-right"><?php echo $user['gsm']; ?></small>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if(!$users): ?>
        <tr>
            <td>
                <span class="fs-18 text-danger">Hesap kartı bulunamadı.</span>
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</div> <!-- /.ajax_search_box -->

<script>
$('.tr_click').click(function() {
    //$('#receiver_user').val($(this).find('.select_account').attr('data-name')); 
    getUser(this);
});

</script>