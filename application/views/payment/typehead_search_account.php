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
                    data-balance="<?php echo get_money($account['balance']); ?>"
                >
                	<h4 style="margin:5px 0px; padding:0px;"><?php echo $account['name']; ?> <small class="pull-right text-success"><?php echo get_money($account['balance']); ?> <i class="fa fa-try"></i></small></h4>
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
	account_click(this); 
});
</script>