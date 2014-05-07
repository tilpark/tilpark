<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>"><?php lang('Dashboard'); ?></a></li>
  <li><a href="<?php echo site_url('plugins'); ?>"><?php lang('Plugins'); ?></a></li>
  <li><a href="<?php echo site_url('general/sms'); ?>">SMS</a></li>
  <li class="active">Yeni SMS Gönder</li>
</ol>


<?php



		
// sms kullanıcı adı ve şifre bilgilerini çekiyoruz
$sms_connect = get_option(array('group'=>'sms', 'key'=>'sms_connect')); 

if(isset($_POST['send_sms']) and is_log())
{
	if($_FILES['file']['size'] > 0)
	{	
		move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/yenidosya.txt');
		$dosya = fopen('uploads/yenidosya.txt', 'r');
		$content = fread($dosya, filesize('uploads/yenidosya.txt'));
		
		$content = str_replace(' ', '', $content);
		$content = str_replace('(', '', $content);
		$content = str_replace(')', '', $content);
		$gsm = explode(',', $content);
		
		$numbers = array();
		foreach($gsm as $g)
		{
			if($g > 0)
			{
				if(!isset($numbers[$g]))
				{
					$numbers[$g] = $g;	
				}
			}
		}
		$gsm = $numbers;
		
		
		
		fclose($dosya);
	}

	
	// gönderilecek sms mesajınının özel alanlarını değiştiriyoruz.
	$message = replace_turkish_letters($_POST['sms_text']);
	
	// sms mesajını oluşturuyoruz.
	$sms[0]['gsm'] = $_POST['gsm'];
	$sms[0]['sms'] = $message;
	
	// curl ile post ediliği için add_log() fonksiyonundaki log_time çalışmıyacaktır. Tarih değerini elle giriyoruz.
	$data['date'] = $_POST['log_time'];
	
	
	if(@$gsm)
	{
		foreach($gsm as $number)
		{
			$sms[0]['gsm'] = $number;
			if($sms[0]['gsm'] > 0)
			{
				if(send_sms($sms_connect['val_1'], $sms_connect['val_2'], $sms))
				{
					notifyBox('success', $sms[0]['gsm'].' SMS Gönderildi');
					$data['type'] = 'sms';
					$data['title'] = 'SMS';
					$data['description'] = $message;
					add_log($data);
				}
			}
		}
	}
	else
	{
		// sms gönder
		if(send_sms($sms_connect['val_1'], $sms_connect['val_2'], $sms))
		{
			notifyBox('success', $sms[0]['gsm'].' SMS Gönderildi');
			$data['type'] = 'sms';
			$data['title'] = 'SMS';
			$data['description'] = $message;
			add_log($data);
		}
	}
}

// açıkta kalan işlemno'ları sorgulatıp sistemin daha düzenli çalışmasını sağlıyoruz.
sms_curl(array('all_checks'=>''));

// bu fonkisiyon ile genel bilgileri sistemimiz ile güncelliyoruz.
update_sms_info($sms_connect['val_1'], $sms_connect['val_2']); 
?>




<div class="row">
	<div class="col-md-6">
        <div class="widget">
            <div class="header">Yeni SMS Gönder</div>
            <div class="content">
            	
                <form name="form_custom_sms" id="form_custom_sms" action="" method="POST" class="validation_3" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="gsm" class="control-label">Cep Telefonu Numarası</label>
                        <input type="text" name="gsm" id="gsm" class="form-control" />
                    </div>
                    
                    <div class="form-group">
                    	<label for="sms_text" class="control-label">SMS Mesajı</label>
                    	<textarea name="sms_text" id="sms_text" class="form-control" style="height:100px;" onkeyup="smsWordCount()"></textarea>
                    </div>
                    
                    <div class="form-group">
                    	<label for="file" class="control-label">Toplu SMS</label>
                    	<input type="file" name="file" id="file" class="form-control" />
                    </div>
                    
                    <div class="h20"></div>
                    <div class="row">
                    	<div class="col-md-6">
                        	<span class="wordCount">0</span> harf
                            <br />
                            <span class="smsCount">0</span> mesaj
                        </div> <!-- /.col-md-6 -->
                        <div class="col-md-6">
                        	<div class="text-right">    
                                <input type="hidden" name="send_sms" /> 
                                <input type="hidden" name="log_time" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                                <button class="btn btn-default">SMS Gönder</button> 
                            </div> <!-- /.text-right -->
                        </div> <!-- /.col-md-6 -->
                    </div> <!-- /.row -->
                </form>
                
                <script>
					function smsWordCount()
					{
						var textWordCount =$('#sms_text').val().length;
						$('.wordCount').html(textWordCount);
						
						if(parseInt(textWordCount) < 161){ $('.smsCount').html('1'); }
						if(parseInt(textWordCount) > 161 & parseInt(textWordCount) < 321){ $('.smsCount').html('2'); }
						if(parseInt(textWordCount) > 321 & parseInt(textWordCount) < 481){ $('.smsCount').html('3'); }
						if(parseInt(textWordCount) > 481 & parseInt(textWordCount) < 641){ $('.smsCount').html('4'); }
						if(parseInt(textWordCount) > 641){ $('.smsCount').html('<strong>5 ></strong>'); }
					}
					</script>
                
        	</div> <!-- /.content -->
		</div> <!-- /.widget -->
	</div> <!-- /.col-md-6 -->
    <div class="col-md-6">
    	
    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->