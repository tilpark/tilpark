<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('user/messagebox'); ?>">Mesaj Kutusu</a></li>
  <li class="active"><?php echo @$receiver_user['name']; ?> <?php echo @$receiver_user['surname']; ?> YENİ MESAJ GÖNDER</li>
</ol>






<form name="form_profile" id="form_profile" action="" method="POST" class="validation">
	<div class="widget-blank"><h4>Yeni mesaj gönderme</h4></div>
	<div class="widget-body">
	    <div class="row">
	        <div class="col-md-6">
	            <div class="form-group">
	                <label for="sender_user" class="control-label ff-1 fss-16">Gönderen</label>
	                <div class="input-prepend input-group">
	                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
	                    <input type="text" id="sender_user" name="sender_user" class="form-control" minlength="2" maxlength="32" value="<?php echo get_the_current_user('name'); ?> <?php echo get_the_current_user('surname'); ?>" readonly>
	                </div>
	            </div> <!-- /.form-group -->
	        </div> <!-- /.col-md-6 -->
	        <div class="col-md-6">
	            <div class="form-group">
	                <label for="receiver_user" class="control-label ff-1 fss-16">Alıcı</label>
	                <div class="input-prepend input-group">
	                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
	                    <input type="text" id="receiver_user" name="receiver_user" class="form-control" placeholder="Alıcı" minlength="2" maxlength="32" value="">
	                </div>
	                <script>
	                function search_user(search_text)
	                {
	                	alert(search_text);
	                }

	            
                	$('.receiver_user').keyup(function() {
                		search_user('merhaba');
                	});
	                	
	            
	                </script>
	            </div> <!-- /.form-group -->
	        </div> <!-- /.col-md-6 -->
	    </div> <!-- /.row -->
	</div> <!-- /.widget-body -->
</form>