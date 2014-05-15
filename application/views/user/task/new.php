<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('user/messagebox'); ?>">Mesaj Kutusu</a></li>
  <li class="active"><?php echo @$receiver_user['name']; ?> <?php echo @$receiver_user['surname']; ?> YENİ GÖREV GÖNDER</li>
</ol>




<form name="form_profile" id="form_profile" action="" method="POST" class="validation">
	<div class="widget-blank"><h4>Yeni görev gönder</h4></div>
	<div class="widget-body">
	    <div class="row">
	        <div class="col-md-4">
	            <div class="form-group">
	                <label for="sender_user" class="control-label ff-1 fss-16">Gönderen</label>
	                <div class="input-prepend input-group">
	                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
	                    <input type="text" id="sender_user" name="sender_user" class="form-control" minlength="2" maxlength="32" value="<?php echo get_the_current_user('name'); ?> <?php echo get_the_current_user('surname'); ?>" readonly>
	                </div>
	            </div> <!-- /.form-group -->
	        </div> <!-- /.col-md-4 -->
	        <div class="col-md-4">
	            <div class="form-group">
	                <label for="receiver_user" class="control-label ff-1 fss-16">Alıcı</label>
	                <div class="input-prepend input-group">
	                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
	                    <input type="hidden" id="receiver_user_id" name="receiver_user_id" value="<?php echo $receiver_user['id']; ?>" class="required" />
	                    <input type="text" id="receiver_user" name="receiver_user" class="form-control required" placeholder="Alıcı" maxlength="32" value="<?php echo $receiver_user['name_surname']; ?>" autocomplete="off" />
	                </div>
	                <div id="search_user_div" class="typeHead"></div>
	                <script>
	                function search_user(search_item, html_item)
	                {
	                	$(search_item).keyup(function() {
	                		$('.typeHead').show();
	                		var search_string = $(search_item).val();

	                		$.get("../ajax_search/"+search_string+"", function( data ) {
								$(html_item).html(data);
							});
                		});
	                }
	                function getUser(click_item)
               		{
               			$('#receiver_user_id').val($(click_item).find('.select').attr('data-id')); 
               			$('#receiver_user').val($(click_item).find('.select').attr('data-name') + ' ' + $(click_item).find('.select').attr('data-surname')); 
               		}
	                search_user('#receiver_user', '#search_user_div');         
	                </script>
	            </div> <!-- /.form-group -->
	        </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
            </div> <!-- /.col-md-4 -->
		</div> <!-- /.row -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="importance" class="control-label ff-1 fss-16">Önem Düzeyi</label>
                    <select class="form-control valid" name="importance" id="importance">
                        <optgroup label="önem düzeyi seçin">
                                <option value="1">Düşük</option>
                                <option value="2" selected>Normal</option>
                                <option value="3">Yüksek</option>
                    	</optgroup>
                    </select>
                </div>
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
	            <div class="form-group">
	                <label for="date_start" class="control-label ff-1 fss-16">Görev Başlama Tarihi</label>
	                <div class="input-prepend input-group">
	                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
	                    <input type="text" id="date_start" name="date_start" class="form-control datepicker required" value="<?php echo date('Y-m-d'); ?>" readonly>
	                </div>
	            </div> <!-- /.form-group -->
	        </div> <!-- /.col-md-6 -->
	        <div class="col-md-4">
	            <div class="form-group">
	                <label for="date_end" class="control-label ff-1 fss-16">Görev Bitirme Tarihi</label>
	                <div class="input-prepend input-group">
	                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
	                    <input type="hidden" id="receiver_user_id" name="receiver_user_id" value="<?php echo $receiver_user['id']; ?>" class="required" />
	                    <input type="text" id="date_end" name="date_end" class="form-control datepicker required" value="<?php echo date('Y-m-d'); ?>" readonly />
	                </div>
            	</div> <!-- /.form-group -->
	        </div> <!-- /.col-md-4 -->
	        <div class="col-md-12">
	        	<div class="form-group">
	                <label for="title" class="control-label ff-1 fss-16">Mesaj Başlığı</label>
	                <div class="input-prepend input-group">
	                    <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
	                    <input type="text" id="title" name="title" class="form-control required" minlength="3" maxlength="100">
	                </div>
	            </div> <!-- /.form-group -->
	        </div> <!-- /.col-md-12 -->
	        <div class="col-md-12">
	            <textarea id="summernote" name="content" class="dede"></textarea>
	            <script>
					  $(document).ready(function() {
						  $('#summernote').summernote({
						  	height: 200, 
						  	theme: 'monokai',
						});
						
						$('.denenbuton').click(function() {
							var content = $('textarea[name="content"]').html($('#summernote').code());
						});
					});
	            </script>
	        </div> <!-- /.col-md-12 -->


	        <div class="col-md-12">
	        	<div class="h20"></div>
	        	<input type="hidden" name="microtime" value="<?php echo logTime(); ?>" />
	        	<input type="hidden" name="new">
	        	<button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Gönder</a>
	        </div> <!-- /.col-md-12 -->
	    </div> <!-- /.row -->
	</div> <!-- /.widget-body -->
</form>