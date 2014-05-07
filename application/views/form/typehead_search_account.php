<meta charset="utf-8" />

<div class="ajax_search_box">
<table class="table table-bordered table-hover table-condensed">
    <tbody>
    <?php foreach($accounts as $account): ?>
    	<tr class="tr_click">
        	<td class="">
            	<div class="pointer select_account" style="height:40px;"
                	data-id="<?php echo $account['id']; ?>"
                	data-code="<?php echo $account['code']; ?>"
                    data-name="<?php echo $account['name']; ?>"
                    data-nameSurname="<?php echo $account['name_surname']; ?>"
                    data-gsm="<?php echo $account['gsm']; ?>"
                    data-email="<?php echo $account['email']; ?>"
                    data-address="<?php echo $account['address']; ?>"
                    data-county="<?php echo $account['county']; ?>"
                    data-city="<?php echo $account['city']; ?>"
                >
                	<h4 style="margin:5px 0px; padding:0px;"><?php echo $account['name']; ?></h4>
                    <small class="pull-left"><?php echo $account['code']; ?></small>
                    <small class="pull-right"><?php echo $account['gsm']; ?></small>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if(!$accounts): ?>
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
    $('#account_id').val($(this).find('.select_account').attr('data-id'));
    $('#name').val($(this).find('.select_account').attr('data-name'));
    $('#name_surname').val($(this).find('.select_account').attr('data-nameSurname'));
    $('#phone').val($(this).find('.select_account').attr('data-gsm'));
    $('#email').val($(this).find('.select_account').attr('data-email'));
	$('#gsm').val($(this).find('.select_account').attr('data-gsm'));
	$('#address').val($(this).find('.select_account').attr('data-address'));
	$('#county').val($(this).find('.select_account').attr('data-county'));
	$('#city').val($(this).find('.select_account').attr('data-city'));
	$('#account_name').attr('readonly', 'readonly');
});

</script>