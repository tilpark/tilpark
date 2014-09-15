<div class="row">
<div class="col-md-12">

<script>
function ajax_search_table(item)
{
	$(item).keyup(function() {
		$(".account_list").html('<?php ajax_search_gif(); ?>');
		$.get( "lists_ajax/"+$(this).val(), function( data ) {
			$(".account_list").html(data);
		});
	});
}
</script>

<div class="form-group">
    <div class="input-group">
      <div class="input-group-btn">
        <button type="button" class="btn btn-default btn-lg" tabindex="-1"><span class="fa fa-search"></span></button>
        <button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" tabindex="-1">
          <span class="caret"></span>
          <span class="sr-only">Karışık</span>
        </button>
        <ul class="dropdown-menu ajax_search" role="menu">
          <li data-key="T:"><a href="#"><i class="fa fa-phone"></i>telefon</a></li>
          <li data-key="E:"><a href="#"><i class="fa fa-envelope"></i> e-posta</a></li>
          <li class="divider"></li>
          <li><a href="#" data-key="">varsayılan arama</a></li>
        </ul>
      </div> <!-- /.dropdown-menu ajax_search -->
      <input type="text" id="q" name="q" class="form-control input-lg" placeholder="Hesap Kartı Arama..." autocomplete="off">
    </div> <!-- /.input-group -->
</div> <!-- /.form-group -->
<script>
ajax_search_table('#q');

$('.ajax_search li').click(function() {
	$('#q').val($(this).attr('data-key'));
});

$(document).ready(function(e) {
    $('#q').focus();
});
</script>
<div class="account_list">
    <table class="table table-bordered table-hover table-condensed">
        <thead>
            <tr>
                <th width="140" class="hidden-xs hidden-sm">Kodu</th>
                <th width="200">Hesap Kartı</th>
                <th width="160" class="hidden-xs">Yetkili Adı Soyadı</th>
                <th width="80" class="hidden-xs hidden-sm">Şehir</th>
                <th width="80" class="hidden-xs hidden-sm" width="100">Telefon</th>
                <th width="80"><a href="<?php echo $order_by['balance']; ?>" class="order_by">Bakiye <i class="fa <?php echo $order_by['balance_icon']; ?>"></i></a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($accounts as $account): ?>
            <tr>
                <td class="fs-10 hidden-xs hidden-sm"><a href="<?php echo site_url('account/view/'.$account['id']); ?>"><?php echo text_crop($account['code'],0,20); ?></a></td>
                <td title="<?php echo $account['name']; ?>"><a href="<?php echo site_url('account/view/'.$account['id']); ?>"><?php echo text_crop($account['name'],0,30); ?></a></td>
                <td class="fs-10 hidden-xs"><?php echo text_crop($account['name_surname'],0,20); ?></td>
                <td class="fs-10 hidden-xs hidden-sm"><?php echo text_crop($account['city'],0,15); ?></td>
                <td class="hidden-xs hidden-sm"><?php echo text_crop($account['phone'],0,11); ?></td>
                <td class="text-right"><?php echo get_money($account['balance']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="text-center">
	   <?php echo $pagination; ?>
    </div> <!-- /.text-center -->


	
    
</div> <!-- /.account_list -->





</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->

<div class="h20"></div>