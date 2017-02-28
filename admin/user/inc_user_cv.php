


		<form name="form_contact" id="form_contact" action="?id=<?php echo $user->id; ?>#cv" method="POST" class="validate_1">

			<h3 class="content-title title-line">Kimlik Bilgileri</h3>

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="meta_name">Ad</label>
						<input type="text" name="meta_name" id="meta_name" class="form-control" readonly="" value="<?php echo $user->name; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="meta_surname">Soyad</label>
						<input type="text" name="meta_surname" id="meta_surname" class="form-control" readonly="" value="<?php echo $user->surname; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="meta_citizenship_no">T.C. Kimlik No</label>
						<input type="text" name="meta_citizenship_no" id="meta_citizenship_no" class="form-control digits" minlength="11" maxlength="11" value="<?php echo $user->citizenship_no; ?>" readonly="">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
			</div> <!-- /.row -->

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="father_name">Baba Adı</label>
						<input type="text" name="father_name" id="father_name" class="form-control" value="<?php echo @$user_meta['father_name']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="mother_name">Anne Adı</label>
						<input type="text" name="mother_name" id="mother_name" class="form-control" value="<?php echo @$user_meta['mother_name']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="date_birth">Doğum Tarihi</label>
						<input type="text" name="date_birth" id="date_birth" class="form-control date" value="<?php echo @$user_meta['date_birth']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="birthplace">Doğum Yeri</label>
						<input type="text" name="birthplace" id="birthplace" class="form-control" maxlength="20" value="<?php echo @$user_meta['birthplace']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
			</div> <!-- /.row -->

			<h3 class="content-title title-line">Adres Bilgileri</h3>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="address">Adres</label>
						<input type="text" name="address" id="address" class="form-control" value="<?php echo @$user_meta['address']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="district">İlçe</label>
						<input type="text" name="district" id="district" class="form-control" value="<?php echo @$user_meta['district']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
				<div class="col-md-3">
					<div class="form-group">
						<label for="city">İl/Şehir</label>
						<input type="text" name="city" id="city" class="form-control" value="<?php echo @$user_meta['city']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-3 -->
			</div> <!-- /.row -->


			<div class="h-20"></div>

			<div class="row">
				<div class="col-md-6">

					<div class="panel panel-default panel-border-top">
						<div class="panel-heading">
							<h4 class="panel-title">Eğitim bilgileri</h4>

							<div class="panel-menu">
								<div class="btn-group btn-group-xs" role="group">
								  	<a href="#" onclick="return false;" class="btn btn-default" data-function="add_div_item" data-div=".div_school" data-max_element="5"><i class="fa fa-plus-square"></i> Ekle</a>
								</div>
							</div> <!-- /.panel-menu -->

						</div>
						<div class="panel-body">
							
							<div class="div_school">
								<?php 
								$schools = @$user_meta['school'];
								if(empty($schools)) { @$schools[0]->primary_education = ''; } 
								?>
								<?php foreach($schools as $school): ?>
									<div class="clone_item">
										<div class="row space-5">
											<div class="col-md-2">
												<div class="form-group">
													<label for="school_level">Seviye</label>
													<select name="school_level[]" id="school_level" class="form-control input-sm">
														<option <?php selected(@$school->school_level, 'primary_education'); ?> value="primary_education">İlköğretim</option>
														<option <?php selected(@$school->school_level, 'high_school'); ?> value="high_school">Lise</option>
														<option <?php selected(@$school->school_level, 'college'); ?> value="college">Yüksekokul</option>
														<option <?php selected(@$school->school_level, 'university'); ?> value="university">Üniversite</option>
														<option <?php selected(@$school->school_level, 'other'); ?> value="other">Diğer</option>
													</select>
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-2 -->
											<div class="col-md-3">
												<div class="form-gorup">
													<label for="school_name">Kurum Adı</label>
													<input type="text" name="school_name[]" id="school_name" class="form-control input-sm" value="<?php echo @$school->school_name; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-3 -->
											<div class="col-md-3">
												<div class="form-gorup">
													<label for="school_department">Bölümü</label>
													<input type="text" name="school_department[]" id="school_department" class="form-control input-sm" value="<?php echo @$school->school_department; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-3 -->
											<div class="col-md-2">
												<div class="form-gorup">
													<label for="school_graduation_year">Mezuniyet Yılı</label>
													<input type="text" name="school_graduation_year[]" id="school_graduation_year" class="form-control input-sm digits" minlength="4" maxlength="4" value="<?php echo @$school->school_graduation_year; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-2 -->
											<div class="col-md-1">
												<div class="form-gorup">
													<label for="school_grade">Not</label>
													<input type="text" name="school_grade[]" id="school_grade" class="form-control input-sm digits" minlength="1" maxlength="3" value="<?php echo @$school->school_grade; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-1 -->
											<div class="col-md-1 text-right">
												<div class="form-group">
													<label>&nbsp;</label>
													<br />
													<a href="#" onclick="return false;" class="btn btn-default btn-outline btn-block btn-xs" data-function="remove_div_item" data-div=".div_school"><i class="fa fa-trash text-danger"></i></a>
												</div>
											</div> <!-- /.col-md-1 -->
										</div> <!-- /.row -->
									</div> <!-- /.clone_item -->
								<?php endforeach; ?>

							</div>


						</div> <!-- /.panel-body -->
					</div> <!-- /.panel -->





					<div class="panel panel-default panel-border-top">
						<div class="panel-heading">
							<h4 class="panel-title">Yabancı diller</h4>

							<div class="panel-menu">
								<div class="btn-group btn-group-xs" role="group">
								  	<a href="#" onclick="return false;" class="btn btn-default" data-function="add_div_item" data-div=".div_language" data-max_element="3"><i class="fa fa-plus-square"></i> Ekle</a>
								</div>
							</div> <!-- /.panel-menu -->

						</div>
						<div class="panel-body">
							
							<div class="div_language">
								<?php 
								$languages = @$user_meta['language'];
								if(empty($languages)) { @$languages[0]->lang_lang = ''; } 
								?>
								<?php foreach($languages as $language): ?>
									<div class="clone_item">
										<div class="row space-5">
											<div class="col-md-5">
												<div class="form-group">
													<label for="work_level">Dil</label>
													<select name="lang_lang[]" id="lang_lang" class="form-control input-sm">
														<option value="" <?php selected(@$language->lang_lang, ''); ?>>Seçiniz...</option>
														<option value="Türkçe" <?php selected(@$language->lang_lang, 'Türkçe'); ?>>Türkçe</option>
														<option value="İngilizce" <?php selected(@$language->lang_lang, 'İngilizce'); ?>>İngilizce</option>
														<option value="Almanca" <?php selected(@$language->lang_lang, 'Almanca'); ?>>Almanca</option>
														<option value="Fransızca" <?php selected(@$language->lang_lang, 'Fransızca'); ?>>Fransızca</option>
														<option value="İtalyanca" <?php selected(@$language->lang_lang, 'İtalyanca'); ?>>İtalyanca</option>
														<option value="Arapça" <?php selected(@$language->lang_lang, 'Arapça'); ?>>Arapça</option>
														<option value="Kürtçe" <?php selected(@$language->lang_lang, 'Kürtçe'); ?>>Kürtçe</option>
														<option value="Zazaca" <?php selected(@$language->lang_lang, 'Zazaca'); ?>>Zazaca</option>
														<option value="Azerice" <?php selected(@$language->lang_lang, 'Azerice'); ?>>Azerice</option>
														<option value="Boşnakça" <?php selected(@$language->lang_lang, 'Boşnakça'); ?>>Boşnakça</option>
														<option value="Bulgarca" <?php selected(@$language->lang_lang, 'Bulgarca'); ?>>Bulgarca</option>
														<option value="Çekçe" <?php selected(@$language->lang_lang, 'Çekçe'); ?>>Çekçe</option>
														<option value="Çince" <?php selected(@$language->lang_lang, 'Çince'); ?>>Çince</option>
														<option value="Danca" <?php selected(@$language->lang_lang, 'Danca'); ?>>Danca</option>
														<option value="Ermenice" <?php selected(@$language->lang_lang, 'Ermenice'); ?>>Ermenice</option>
														<option value="Eskiçağ Dilleri" <?php selected(@$language->lang_lang, 'Eskiçağ Dilleri'); ?>>Eskiçağ Dilleri</option>
														<option value="Farsça" <?php selected(@$language->lang_lang, 'Farsça'); ?>>Farsça</option>
														<option value="Faroece" <?php selected(@$language->lang_lang, 'Faroece'); ?>>Faroece</option>
														<option value="Fince" <?php selected(@$language->lang_lang, 'Fince'); ?>>Fince</option>
														<option value="Hırvatça" <?php selected(@$language->lang_lang, 'Hırvatça'); ?>>Hırvatça</option>
														<option value="İbranice" <?php selected(@$language->lang_lang, 'İbranice'); ?>>İbranice</option>
														<option value="İspanyolca" <?php selected(@$language->lang_lang, 'İspanyolca'); ?>>İspanyolca</option>
														<option value="İsveççe" <?php selected(@$language->lang_lang, 'İsveççe'); ?>>İsveççe</option>
														<option value="İzlandaca" <?php selected(@$language->lang_lang, 'İzlandaca'); ?>>İzlandaca</option>
														<option value="Japonca" <?php selected(@$language->lang_lang, 'Japonca'); ?>>Japonca</option>
														<option value="Korece" <?php selected(@$language->lang_lang, 'Korece'); ?>>Korece</option>
														<option value="Latince" <?php selected(@$language->lang_lang, 'Latince'); ?>>Latince</option>
														<option value="Lehçe" <?php selected(@$language->lang_lang, 'Lehçe'); ?>>Lehçe</option>
														<option value="Norveççe" <?php selected(@$language->lang_lang, 'Norveççe'); ?>>Norveççe</option>
														<option value="Portekizce" <?php selected(@$language->lang_lang, 'Portekizce'); ?>>Portekizce</option>
														<option value="Romence" <?php selected(@$language->lang_lang, 'Romence'); ?>>Romence</option>
														<option value="Rusça" <?php selected(@$language->lang_lang, 'Rusça'); ?>>Rusça</option>
														<option value="Yunanca" <?php selected(@$language->lang_lang, 'Yunanca'); ?>>Yunanca</option>
														<option value="Flamanca" <?php selected(@$language->lang_lang, 'Flamanca'); ?>>Flamanca</option>
														<option value="Slav dilleri" <?php selected(@$language->lang_lang, 'Slav dilleri'); ?>>Slav dilleri</option>
														<option value="Kazakça" <?php selected(@$language->lang_lang, 'Kazakça'); ?>>Kazakça</option>
														<option value="Kırgızca" <?php selected(@$language->lang_lang, 'Kırgızca'); ?>>Kırgızca</option>
														<option value="Özbekçe" <?php selected(@$language->lang_lang, 'Özbekçe'); ?>>Özbekçe</option>
														<option value="Sırpça" <?php selected(@$language->lang_lang, 'Sırpça'); ?>>Sırpça</option>
														<option value="Slovakça" <?php selected(@$language->lang_lang, 'Slovakça'); ?>>Slovakça</option>
														<option value="Slovence" <?php selected(@$language->lang_lang, 'Slovence'); ?>>Slovence</option>
														<option value="Tatarca" <?php selected(@$language->lang_lang, 'Tatarca'); ?>>Tatarca</option>
														<option value="Urduca" <?php selected(@$language->lang_lang, 'Urduca'); ?>>Urduca</option>
														<option value="İskandinav Dilleri" <?php selected(@$language->lang_lang, 'İskandinav Dilleri'); ?>>İskandinav Dilleri</option>
														<option value="Macarca" <?php selected(@$language->lang_lang, 'Macarca'); ?>>Macarca</option>
														<option value="Gürcüce" <?php selected(@$language->lang_lang, 'Gürcüce'); ?>>Gürcüce</option>
														<option value="Ukraynaca" <?php selected(@$language->lang_lang, 'Ukraynaca'); ?>>Ukraynaca</option>
														<option value="Letonca" <?php selected(@$language->lang_lang, 'Letonca'); ?>>Letonca</option>
														<option value="Makedonca" <?php selected(@$language->lang_lang, 'Makedonca'); ?>>Makedonca</option>
													</select>
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-2 -->
											<div class="col-md-2">
												<div class="form-gorup">
													<label for="lang_reaing">Okuma</label>
													<select name="lang_reading[]" id="lang_reaing" class="form-control input-sm">
														<option value="1" <?php selected(@$language->lang_reading, '1'); ?>>Az</option>
														<option value="2" <?php selected(@$language->lang_reading, '2'); ?>>Orta</option>
														<option value="3" <?php selected(@$language->lang_reading, '3'); ?>>İyi</option>
														<option value="4" <?php selected(@$language->lang_reading, '4'); ?>>Çok İyi</option>
													</select>
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-2 -->
											<div class="col-md-2">
												<div class="form-gorup">
													<label for="lang_writing">Yazma</label>
													<select name="lang_writing[]" id="lang_writing" class="form-control input-sm">
														<option value="1" <?php selected(@$language->lang_writing, '1'); ?>>Az</option>
														<option value="2" <?php selected(@$language->lang_writing, '2'); ?>>Orta</option>
														<option value="3" <?php selected(@$language->lang_writing, '3'); ?>>İyi</option>
														<option value="4" <?php selected(@$language->lang_writing, '4'); ?>>Çok İyi</option>
													</select>
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-2 -->
											<div class="col-md-2">
												<div class="form-gorup">
													<label for="lang_talk">Konuşma</label>
													<select name="lang_talk[]" id="lang_talk" class="form-control input-sm">
														<option value="1" <?php selected(@$language->lang_talk, '1'); ?>>Az</option>
														<option value="2" <?php selected(@$language->lang_talk, '2'); ?>>Orta</option>
														<option value="3" <?php selected(@$language->lang_talk, '3'); ?>>İyi</option>
														<option value="4" <?php selected(@$language->lang_talk, '4'); ?>>Çok İyi</option>
													</select>
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-2 -->
											<div class="col-md-1 text-right">
												<div class="form-group">
													<label>&nbsp;</label>
													<br />
													<a href="#" onclick="return false;" class="btn btn-default btn-outline btn-block btn-xs" data-function="remove_div_item" data-div=".div_language"><i class="fa fa-trash text-danger"></i></a>
												</div>
											</div> <!-- /.col-md-1 -->
										</div> <!-- /.row -->
									</div> <!-- /.clone_item -->
								<?php endforeach; ?>

							</div> <!-- /.div_language -->

							<div class="pull-right">
								<a href="#" onclick="return false;" class="btn btn-default btn-xs" data-function="add_div_item" data-div=".div_language" data-max_element="5"><i class="fa fa-plus-square"></i> Ekle</a>
							</div>

						</div> <!-- /.panel-body -->
					</div> <!-- /.panel -->


					<div class="h-20"></div>


					<div class="panel panel-default panel-border-top">
						<div class="panel-heading">
							<h4 class="panel-title">Referanslar</h4>

							<div class="panel-menu">
								<div class="btn-group btn-group-xs" role="group">
								  	<a href="#" onclick="return false;" class="btn btn-default" data-function="add_div_item" data-div=".div_ref" data-max_element="5"><i class="fa fa-plus-square"></i> Ekle</a>
								</div>
							</div> <!-- /.panel-menu -->

						</div>
						<div class="panel-body">
							
							<div class="div_ref">
								<?php 
								$references = @$user_meta['reference'];
								if(empty($references)) { @$references[0]->ref_name_surname = ''; } 
								?>
								<?php foreach($references as $reference): ?>
									<div class="clone_item">
										<div class="row space-5">
											<div class="col-md-4">
												<div class="form-group">
													<label for="ref_name_surname">Ad Soyad</label>
													<input type="text" name="ref_name_surname[]" id="ref_name_surname" class="form-control" maxlength="32" value="<?php echo @$reference->ref_name_surname; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-* -->
											<div class="col-md-4">
												<div class="form-group">
													<label for="ref_company">Firma adı</label>
													<input type="text" name="ref_company[]" id="ref_company" class="form-control" maxlength="32" value="<?php echo @$reference->ref_company; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-* -->
											<div class="col-md-3">
												<div class="form-group">
													<label for="ref_phone">Telefon</label>
													<input type="text" name="ref_phone[]" id="ref_phone" class="form-control number" minlength="10" maxlength="11" value="<?php echo @$reference->ref_phone; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-* -->
											<div class="col-md-1 text-right">
												<div class="form-group">
													<label>&nbsp;</label>
													<br />
													<a href="#" onclick="return false;" class="btn btn-default btn-outline btn-block btn-xs" data-function="remove_div_item" data-div=".div_ref"><i class="fa fa-trash text-danger"></i></a>
												</div>
											</div> <!-- /.col-md-1 -->
										</div> <!-- /.row -->
									</div> <!-- /.clone_item -->
								<?php endforeach; ?>

							</div> <!-- /.div_language -->


						</div> <!-- /.panel-body -->
					</div> <!-- /.panel -->

				</div> <!-- /.col-md-6 -->
				<div class="col-md-6">

					<div class="panel panel-default panel-border-top">
						<div class="panel-heading">
							<h4 class="panel-title">İş deneyimleri</h4>

							<div class="panel-menu">
								<div class="btn-group btn-group-xs" role="group">
								  	<a href="#" onclick="return false;" class="btn btn-default" data-function="add_div_item" data-div=".div_work" data-max_element="5"><i class="fa fa-plus-square"></i> Ekle</a>
								</div>
							</div> <!-- /.panel-menu -->

						</div>
						<div class="panel-body">
							
							<div class="div_work">
								<?php 
								$works = @$user_meta['work'];
								if(empty($works)) { @$works[0]->work_level = ''; } 
								?>
								<?php foreach($works as $work): ?>
									<div class="clone_item">
										<div class="row space-5">
											<div class="col-md-2">
												<div class="form-group">
													<label for="work_level">Seviye</label>
													<select name="work_level[]" id="work_level" class="form-control input-sm">
														<option <?php selected(@$work->work_level, 'full_time'); ?> value="full_time">Tam zamanlı</option>
														<option <?php selected(@$work->work_level, 'part_time'); ?> value="part_time">Yarı zamanlı</option>
														<option <?php selected(@$work->work_level, 'seasonal'); ?> value="seasonal">Dönemsel</option>
														<option <?php selected(@$work->work_level, 'contractual'); ?> value="contractual">Sözleşmeli</option>
														<option <?php selected(@$work->work_level, 'student'); ?> value="student">Stajyer</option>
													</select>
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-2 -->
											<div class="col-md-2">
												<div class="form-gorup">
													<label for="work_position">Pozisyon</label>
													<input type="text" name="work_position[]" id="work_position" class="form-control input-sm" maxlength="20" value="<?php echo @$work->work_position; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-2 -->
											<div class="col-md-2">
												<div class="form-gorup">
													<label for="work_company_name">Firma Adı</label>
													<input type="text" name="work_company_name[]" id="work_company_name" class="form-control input-sm" maxlength="30" value="<?php echo @$work->work_company_name; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-2 -->
											<div class="col-md-1">
												<div class="form-gorup">
													<label for="work_start_date" data-toggle="tooltip" title="Başlama Tarihi">Başla.</label>
													<input type="text" name="work_start_date[]" id="work_start_date" class="form-control input-sm digits p-8" minlength="4" maxlength="4" value="<?php echo @$work->work_start_date; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-1 -->
											<div class="col-md-1">
												<div class="form-gorup">
													<label for="work_end_date" data-toggle="tooltip" title="Ayrılma Tarihi">Ayrıl.</label>
													<input type="text" name="work_end_date[]" id="work_end_date" class="form-control input-sm digits p-8" minlength="4" maxlength="4" value="<?php echo @$work->work_end_date; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-1 -->
											<div class="col-md-3">
												<div class="form-gorup">
													<label for="work_description">Açıklama/İş Tanımı</label>
													<input type="text" name="work_description[]" id="work_description" class="form-control input-sm" maxlength="100" value="<?php echo @$work->work_description; ?>">
												</div> <!-- /.form-group -->
											</div> <!-- /.col-md-3 -->
											<div class="col-md-1 text-right">
												<div class="form-group">
													<label>&nbsp;</label>
													<br />
													<a href="#" onclick="return false;" class="btn btn-default btn-outline btn-block btn-xs" data-function="remove_div_item" data-div=".div_work"><i class="fa fa-trash text-danger"></i></a>
												</div>
											</div> <!-- /.col-md-1 -->
										</div> <!-- /.row -->
									</div> <!-- /.clone_item -->
								<?php endforeach; ?>

							</div>


						</div> <!-- /.panel-body -->
					</div> <!-- /.panel -->





					<div class="panel panel-default panel-border-top">
						<div class="panel-heading">
							<h4 class="panel-title">Ek bilgiler</h4>
						</div>
						<div class="panel-body">

							<h4 class="content-title title-line">Ehliyet</h4>
							<div class="row space-5">
								<div class="col-md-1">
									<div class="form-gorup">
										<label><input type="checkbox" name="driving_license[]" id="dl_A1" value="A1" <?php checked('A1', @$user_meta['driving_license']); ?>> A1</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-1">
									<div class="form-gorup">
										<label><input type="checkbox" name="driving_license[]" id="dl_A2" value="A2" <?php checked('A2', @$user_meta['driving_license']); ?>> A2</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-1">
									<div class="form-gorup">
										<label><input type="checkbox" name="driving_license[]" id="dl_B" value="B" <?php checked('B', @$user_meta['driving_license']); ?>> B</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-1">
									<div class="form-gorup">
										<label><input type="checkbox" name="driving_license[]" id="dl_C" value="C" <?php checked('C', @$user_meta['driving_license']); ?>> C</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-1">
									<div class="form-gorup">
										<label><input type="checkbox" name="driving_license[]" id="dl_D" value="D" <?php checked('D', @$user_meta['driving_license']); ?>> D</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-1">
									<div class="form-gorup">
										<label><input type="checkbox" name="driving_license[]" id="dl_E" value="E" <?php checked('E', @$user_meta['driving_license']); ?>> E</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-1">
									<div class="form-gorup">
										<label><input type="checkbox" name="driving_license[]" id="dl_F" value="F" <?php checked('F', @$user_meta['driving_license']); ?>> F</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-1">
									<div class="form-gorup">
										<label><input type="checkbox" name="driving_license[]" id="dl_H" value="H" <?php checked('H', @$user_meta['driving_license']); ?>> H</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
							</div> <!-- /.row -->

							<div class="h-20"></div>

							<h4 class="content-title title-line">SRC belgeleri</h4>
							<div class="row space-5">
								<div class="col-md-2">
									<div class="form-gorup">
										<label><input type="checkbox" name="src[]" id="src_SRC1" value="SRC1" <?php checked('SRC1', @$user_meta['src']); ?>> SRC 1</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-2">
									<div class="form-gorup">
										<label><input type="checkbox" name="src[]" id="src_SRC2" value="SRC2" <?php checked('SRC2', @$user_meta['src']); ?>> SRC 2</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-2">
									<div class="form-gorup">
										<label><input type="checkbox" name="src[]" id="src_SRC3" value="SRC3" <?php checked('SRC3', @$user_meta['src']); ?>> SRC 3</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-2">
									<div class="form-gorup">
										<label><input type="checkbox" name="src[]" id="src_SRC4" value="SRC4" <?php checked('SRC4', @$user_meta['src']); ?>> SRC 4</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
								<div class="col-md-2">
									<div class="form-gorup">
										<label><input type="checkbox" name="src[]" id="src_SRC5" value="SRC5" <?php checked('SRC5', @$user_meta['src']); ?>> SRC 5</label>
									</div> <!-- /.form-gorup -->
								</div> <!-- /.col-md-* -->
							</div> <!-- /.row -->

							<div class="h-20"></div>
							<h4 class="content-title title-line">Diğer bilgiler</h4>

							<div class="form-group">
								<label for="smoking">Sigara içiyor mu?</label>
								<input type="checkbox" name="smoking" id="smoking" value="true" <?php checked('true', @$user_meta['smoking']); ?>>
							</div> <!-- /.form-group -->

							<div class="form-group">
								<label for="travel_ban">Seyehat engeli var mı?</label>
								<input type="checkbox" name="travel_ban" id="travel_ban" value="true" <?php checked('true', @$user_meta['travel_ban']); ?>>
							</div> <!-- /.form-group -->

							<div class="form-group">
								<label for="work_overtime">Mesai yapabilir mi?</label>
								<input type="checkbox" name="work_overtime" id="work_overtime" value="true" <?php checked('true', @$user_meta['work_overtime']); ?>>
							</div> <!-- /.form-group -->

							<div class="form-group">
								<label for="work_night">Gece vardiyasında çalışabilir mi?</label>
								<input type="checkbox" name="work_night" id="work_night" value="true" <?php checked('true', @$user_meta['work_night']); ?>>
							</div> <!-- ,/.form-group -->

							<div class="form-group">
								<label for="unhealthy">Engelli mi?</label>
								<input type="checkbox" name="unhealthy" id="unhealthy" value="true" data-checked_show=".div_unhealthy" <?php checked(true, @$user_meta['unhealthy']); ?>>
							</div> <!-- /.form-group -->

							<div class="div_unhealthy">
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="unhealthy_type" class="text-muted">Engel tipi</label>
											<select name="unhealthy_type" id="unhealthy_type" class="form-control input-sm">
												<option value="" <?php selected('', @$user_meta['unhealthy_type']); ?>>Seçiniz...</option>
												<option value="Damar Hastalıkları" <?php selected('Damar Hastalıkları', @$user_meta['unhealthy_type']); ?>>Damar Hastalıkları</option>
												<option value="Deri Hastalıkları" <?php selected('Deri Hastalıkları', @$user_meta['unhealthy_type']); ?>>Deri Hastalıkları</option>
												<option value="Göğüs Hastalıkları" <?php selected('Göğüs Hastalıkları', @$user_meta['unhealthy_type']); ?>>Göğüs Hastalıkları</option>
												<option value="Göz Arızaları" <?php selected('Göz Arızaları', @$user_meta['unhealthy_type']); ?>>Göz Arızaları</option>
												<option value="Hematolojik Hastalıklar" <?php selected('Hematolojik Hastalıklar', @$user_meta['unhealthy_type']); ?>>Hematolojik Hastalıklar</option>
												<option value="İç Hastalıklar" <?php selected('İç Hastalıklar', @$user_meta['unhealthy_type']); ?>>İç Hastalıkları</option>
												<option value="Karın Hastalıkları" <?php selected('Karın Hastalıkları', @$user_meta['unhealthy_type']); ?>>Karın Hastalık</option>
												<option value="Kulak Burun Boğaz" <?php selected('Kulak Burun Boğaz', @$user_meta['unhealthy_type']); ?>>Kulak Burun Boğaz</option>
												<option value="Nörolojik Hastalıklar" <?php selected('Nörolojik Hastalıklar', @$user_meta['unhealthy_type']); ?>>Nörolojik Hastalıklar</option>
												<option value="Onkoloji" <?php selected('Onkoloji', @$user_meta['unhealthy_type']); ?>>Onkoloji</option>
												<option value="Ortopedik ve Travmatolojik" <?php selected('Ortopedik ve Travmatolojik', @$user_meta['unhealthy_type']); ?>>Ortopedik ve Travmatolojik</option>
												<option value="Ruh Hastalıkları" <?php selected('Ruh Hastalıkları', @$user_meta['unhealthy_type']); ?>>Ruh Hastalıkları</option>
												<option value="Sindirim Sistemi" <?php selected('Sindirim Sistemi', @$user_meta['unhealthy_type']); ?>>Sindirim Sistemi</option>
												<option value="Üroloji" <?php selected('Üroloji', @$user_meta['unhealthy_type']); ?>>Üroloji</option>
												<option value="Yanıklar" <?php selected('Yanıklar', @$user_meta['unhealthy_type']); ?>>Yanıklar</option>
											</select> <!-- /.form-control -->
										</div>
									</div> <!-- /.col-md-* -->
									<div class="col-md-3">
										<div class="form-group">
											<label for="unhealthy_degree" class="text-muted">Engel derecesi</label>
											<select name="unhealthy_degree" id="unhealthy_degree" class="form-control input-sm">
												<option value="" <?php selected('', @$user_meta['unhealthy_degree']); ?>>Seçiniz...</option>
												<option value="%40" <?php selected('%40', @$user_meta['unhealthy_degree']); ?>>%40</option>
												<option value="%50" <?php selected('%50', @$user_meta['unhealthy_degree']); ?>>%50</option>
												<option value="%60" <?php selected('%60', @$user_meta['unhealthy_degree']); ?>>%60</option>
												<option value="%70" <?php selected('%70', @$user_meta['unhealthy_degree']); ?>>%70</option>
												<option value="%80" <?php selected('%80', @$user_meta['unhealthy_degree']); ?>>%80</option>
												<option value="%90" <?php selected('%90', @$user_meta['unhealthy_degree']); ?>>%90</option>
												<option value="%100"<?php selected('%100', @$user_meta['unhealthy_degree']); ?>>%100</option>
											</select> <!-- /.form-control -->
										</div>
									</div> <!-- /.col-md-* -->
								</div> <!-- /.row -->
							</div> <!-- /.div_unhealthy -->



							<div class="form-group">
								<label for="prison">Daha önce cezaevine girmiş mi?</label>
								<input type="checkbox" name="prison" id="prison" value="true" data-checked_show=".div_prison" <?php checked(true, @$user_meta['prison']); ?>>
							</div> <!-- /.form-group -->

							<div class="div_prison">
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="prison_year" class="text-muted">Kaç Yıl</label>
											<select name="prison_year" id="prison_year" class="form-control input-sm">
												<option value="0" <?php selected('0', @$user_meta['prison_year']); ?>>0</option>
												<option value="1" <?php selected('1', @$user_meta['prison_year']); ?>>1</option>
												<option value="2" <?php selected('2', @$user_meta['prison_year']); ?>>2</option>
												<option value="3" <?php selected('3', @$user_meta['prison_year']); ?>>3</option>
												<option value="4" <?php selected('4', @$user_meta['prison_year']); ?>>4</option>
												<option value="5" <?php selected('5', @$user_meta['prison_year']); ?>>5</option>
												<option value="6" <?php selected('6', @$user_meta['prison_year']); ?>>6</option>
												<option value="7" <?php selected('7', @$user_meta['prison_year']); ?>>7</option>
												<option value="8" <?php selected('8', @$user_meta['prison_year']); ?>>8</option>
												<option value="9" <?php selected('9', @$user_meta['prison_year']); ?>>9</option>
												<option value="10+" <?php selected('10+', @$user_meta['prison_year']); ?>>10+</option>
											</select> <!-- /.form-control -->
										</div>
									</div> <!-- /.col-md-* -->
									<div class="col-md-2">
										<div class="form-group">
											<label for="prison_month" class="text-muted">Kaç Ay</label>
											<select name="prison_month" id="prison_month" class="form-control input-sm">
												<option value="0" <?php selected('0', @$user_meta['prison_month']); ?>>0</option>
												<option value="1" <?php selected('1', @$user_meta['prison_month']); ?>>1</option>
												<option value="2" <?php selected('2', @$user_meta['prison_month']); ?>>2</option>
												<option value="3" <?php selected('3', @$user_meta['prison_month']); ?>>3</option>
												<option value="4" <?php selected('4', @$user_meta['prison_month']); ?>>4</option>
												<option value="5" <?php selected('5', @$user_meta['prison_month']); ?>>5</option>
												<option value="6" <?php selected('6', @$user_meta['prison_month']); ?>>6</option>
												<option value="7" <?php selected('7', @$user_meta['prison_month']); ?>>7</option>
												<option value="8" <?php selected('8', @$user_meta['prison_month']); ?>>8</option>
												<option value="9" <?php selected('9', @$user_meta['prison_month']); ?>>9</option>
												<option value="10" <?php selected('10', @$user_meta['prison_month']); ?>>10</option>
												<option value="11" <?php selected('11', @$user_meta['prison_month']); ?>>11</option>
												<option value="12" <?php selected('12', @$user_meta['prison_month']); ?>>12</option>
											</select> <!-- /.form-control -->
										</div>
									</div> <!-- /.col-md-* -->
									<div class="col-md-7">
										<div class="form-group">
											<label for="prison_desc" class="text-muted">Açıklama</label>
											<input type="text" name="prison_desc" id="prison_desc" class="form-control input-sm" value="<?php echo @$user_meta['prison_desc']; ?>" maxlength="255">
										</div>
									</div> <!-- /.col-md-* -->
								</div> <!-- /.row -->
							</div> <!-- /.div_unhealthy -->




							<div class="form-group">
								<label for="terror">Terör mağduru mu?</label>
								<input type="checkbox" name="terror" id="terror" value="true" data-checked_show=".div_terror" <?php checked(true, @$user_meta['terror']); ?>>
							</div> <!-- /.form-group -->

							<div class="div_terror">
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="terror_type" class="text-muted">Yakınlık derecesi</label>
											<select name="terror_type" id="terror_type" class="form-control input-sm">
												<option value="" <?php selected('', @$user_meta['terror_type']); ?>>Seçiniz...</option>
												<option value="Şehit Eşi" <?php selected('Şehit Eşi', @$user_meta['terror_type']); ?>>Şehit Eşi</option>
												<option value="Şehit Çocuğu" <?php selected('Şehit Çocuğu', @$user_meta['terror_type']); ?>>Şehit Çocuğu</option>
												<option value="Şehit Kardeşi" <?php selected('Şehit Kardeşi', @$user_meta['terror_type']); ?>>Şehit Kardeşi</option>
												<option value="Kendisi" <?php selected('Kendisi', @$user_meta['terror_type']); ?>>Kendisi</option>
											</select> <!-- /.form-control -->
										</div>
									</div> <!-- /.col-md-* -->
									<div class="col-md-7">
										<div class="form-group">
											<label for="terror_desc" class="text-muted">Açıklama</label>
											<input type="text" name="terror_desc" id="terror_desc" class="form-control input-sm" value="<?php echo @$user_meta['terror_desc']; ?>" maxlength="255">
										</div>
									</div> <!-- /.col-md-* -->
								</div> <!-- /.row -->
							</div> <!-- /.div_unhealthy -->

							







						</div> <!-- /.panel-body -->
					</div> <!-- /.panel -->


				</div> <!-- /.col-md-6 -->

			</div> <!-- /.row -->

			<div class="h-20"></div>

			<div class="row">
				<div class="col-md-6">
					
					<div class="panel panel-warning panel-heading-0 panel-border-top">
						<div class="panel-body">

							<div class="row">
								<div class="col-md-6">

									<h4 class="content-title title-line">Acil durum 1 .kişi</h4>
									<div class="form-group">
										<label for="emergency_name_1">Ad Soyad</label>
										<input type="text" name="emergency_name[]" id="emergency_name_1" class="form-control" maxlength="30" value="<?php echo @$user_meta['emergency'][0]->emergency_name; ?>">
									</div> <!-- /.form-group -->

									<div class="form-group">
										<label for="emergency_relative_1">Yakınlık Derecesi/Açıklaması</label>
										<input type="text" name="emergency_relative[]" id="emergency_relative_1" class="form-control" maxlength="10" value="<?php echo @$user_meta['emergency'][0]->emergency_relative; ?>">
									</div> <!-- /.form-group -->

									<div class="form-group">
										<label for="emergency_phone_1">Telefon Numarası</label>
										<input type="text" name="emergency_phone[]" id="emergency_phone_1" class="form-control digits" minlength="10" maxlength="11" value="<?php echo @$user_meta['emergency'][0]->emergency_phone; ?>">
									</div> <!-- /.form-group -->

								</div> <!-- /.col-md-6 -->
								<div class="col-md-6">

									<h4 class="content-title title-line">Acil durum 2 .kişi</h4>

									<div class="form-group">
										<label for="emergency_name_2">Ad Soyad</label>
										<input type="text" name="emergency_name[]" id="emergency_name_2" class="form-control" maxlength="30" value="<?php echo @$user_meta['emergency'][1]->emergency_name; ?>">
									</div> <!-- /.form-group -->

									<div class="form-group">
										<label for="emergency_relative_2">Yakınlık Derecesi/Açıklaması</label>
										<input type="text" name="emergency_relative[]" id="emergency_relative_2" class="form-control" maxlength="10" value="<?php echo @$user_meta['emergency'][1]->emergency_relative; ?>">
									</div> <!-- /.form-group -->

									<div class="form-group">
										<label for="emergency_phone_2">Telefon Numarası</label>
										<input type="text" name="emergency_phone[]" id="emergency_phone_2" class="form-control digits" minlength="10" maxlength="11" value="<?php echo @$user_meta['emergency'][1]->emergency_phone; ?>">
									</div> <!-- /.form-group -->

								</div>
							</div>

						</div> <!-- /.panel-body -->
					</div> <!-- /.panel -->

					<div class="panel panel-primary panel-heading-0 panel-border-top">
						<div class="panel-body">
							<h4 class="content-title title-line">Sosyal medya bilgileri</h4>

							<div class="row">
								<div class="col-md-6">

									
									<div class="form-group">
										<label for="url_website">Website</label>
										<input type="text" name="url_website" id="url_website" class="form-control url" maxlength="255" value="<?php echo @$user_meta['url_website']; ?>" placeholder="www.siteadi.com">
									</div> <!-- /.form-group -->

									<div class="form-group">
										<label for="url_facebook">Facebook</label>
										<input type="text" name="url_facebook" id="url_facebook" class="form-control url" maxlength="255" value="<?php echo @$user_meta['url_facebook']; ?>" placeholder="www.facebook.com/kullaniciadi">
									</div> <!-- /.form-group -->

									

								</div> <!-- /.col-md-6 -->
								<div class="col-md-6">

									<div class="form-group">
										<label for="url_linkedin">Linkedin</label>
										<input type="text" name="url_linkedin" id="url_linkedin" class="form-control url" maxlength="255" value="<?php echo @$user_meta['url_linkedin']; ?>" placeholder="www.linkedin.com/kullaniciadi">
									</div> <!-- /.form-group -->

									<div class="form-group">
										<label for="url_twitter">Twitter</label>
										<input type="text" name="url_twitter" id="url_twitter" class="form-control url" maxlength="255" value="<?php echo @$user_meta['url_twitter']; ?>" placeholder="www.twitter.com/kullaniciadi">
									</div> <!-- /.form-group -->

								</div>
							</div>

						</div> <!-- /.panel-body -->
					</div> <!-- /.panel -->

					
					
				</div> <!-- /.col-md-6 -->
				<div class="col-md-6">
					<div class="panel panel-warning panel-heading-0 panel-border-top">
						<div class="panel-body">
							<h4 class="content-title title-line">Kişisel bilgileri</h4>


							<div class="row">
								<div class="col-md-6">

									<div class="form-group">
										<label for="is_married">Evli/Bekar</label>
										<select name="is_married" id="is_married" class="select form-control js_til_select_div" data-div=".div_is_married">
											<option value="" <?php selected(@$user_meta['is_married'], ''); ?>>Bilinmiyor</option>
											<option value="not_married" <?php selected(@$user_meta['is_married'], 'not_married'); ?>>Bekar</option>
											<option value="married" <?php selected(@$user_meta['is_married'], 'married'); ?>>Evli</option>
											<option value="widow" <?php selected(@$user_meta['is_married'], 'widow'); ?>>Dul</option>
										</select>
									</div> <!-- /.form-group -->

									<div class="form-group">
										<label for="humble_person_count">Bakmakla yükümlü olduğunuz kişi sayısı?</label>
										<input type="text" name="humble_person_count" id="humble_person_count" class="form-control digits" maxlength="2" value="<?php echo @$user_meta['humble_person_count']; ?>">
									</div> <!-- /.form-group -->

								</div> <!-- /.col-md-6 -->
								<div class="col-md-6">

									<div class="form-group div_is_married div_is_married_married">
										<label for="spouses_name">Eşinin adı?</label>
										<input type="text" name="spouses_name" id="spouses_name" class="form-control" maxlength="10" value="<?php echo @$user_meta['spouses_name']; ?>">
									</div> <!-- /.form-group -->

									<div class="form-group div_is_married div_is_married_married div_is_married_widow">
										<label for="children_count">Var ise çocuk sayısı?</label>
										<input type="text" name="children_count" id="children_count" class="form-control digits" maxlength="2" value="<?php echo @$user_meta['children_count']; ?>">
									</div> <!-- /.form-group -->

								</div> <!-- /.col-md-6 -->
							</div> <!-- /.row -->


							<h4 class="content-title title-line">Askerlik bilgileri</h4>
							<div class="row">
								<div class="col-md-6">

									<div class="form-group">
										<label for="military_status">Askerlik Durumu</label>
										<select name="military_status" id="military_status" class="select form-control js_til_select_div" data-div=".div_military">
											<option value="" <?php selected(@$user_meta['military_status'], ''); ?>>Bilinmiyor</option>
											<option value="done" <?php selected(@$user_meta['military_status'], 'done'); ?>>Yapıldı</option>
											<option value="postponed" <?php selected(@$user_meta['military_status'], 'postponed'); ?>>Tescilli</option>
											<option value="exempt" <?php selected(@$user_meta['military_status'], 'exempt'); ?>>Muaf</option>
										</select>
									</div> <!-- /.form-group -->

								</div> <!-- /.col-md-6 -->
								<div class="col-md-6">

									<div class="form-group div_military div_military_done">
										<label for="military_end_date">Terhis Tarihi</label>
										<input type="text" name="military_end_date" id="military_end_date" class="form-control date" value="<?php echo @$user_meta['military_end_date']; ?>">
									</div> <!-- /.form-group -->

									<div class="form-group div_military div_military_postponed">
										<label for="military_postponed">Tescil Tarihi</label>
										<input type="text" name="military_postponed" id="military_postponed" class="form-control date" value="<?php echo @$user_meta['military_postponed']; ?>">
									</div> <!-- /.form-group -->

									<div class="form-group div_military div_military_exempt">
										<label for="military_exempt">Muaf ise Nedeni?</label>
										<input type="text" name="military_exempt" id="military_exempt" class="form-control" maxlength="32" value="<?php echo @$user_meta['military_exempt']; ?>">
									</div> <!-- /.form-group -->

								</div> <!-- /.col-md-6 -->
							</div> <!-- /.row -->


							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="blood_group">Kan Grubu</label>
										<select name="blood_group" id="blood_group" class="select form-control">
											<option value="" <?php selected(@$user_meta['blood_group'], ''); ?>>Bilinmiyor</option>
											<option value="arh+" <?php selected(@$user_meta['blood_group'], 'arh+'); ?>>A Rh +</option>
											<option value="arh-" <?php selected(@$user_meta['blood_group'], 'arh-'); ?>>A Rh -</option>
											<option value="brh+" <?php selected(@$user_meta['blood_group'], 'brh+'); ?>>B Rh +</option>
											<option value="brh-" <?php selected(@$user_meta['blood_group'], 'brh-'); ?>>B Rh -</option>
											<option value="abrh+" <?php selected(@$user_meta['blood_group'], 'abrh+'); ?>>AB Rh +</option>
											<option value="abrh-" <?php selected(@$user_meta['blood_group'], 'abrh-'); ?>>AB Rh -</option>
											<option value="0rh+" <?php selected(@$user_meta['blood_group'], '0rh+'); ?>>0 Rh +</option>
											<option value="0rh-" <?php selected(@$user_meta['blood_group'], '0rh-'); ?>>0 Rh -</option>
										</select>
									</div> <!-- /.form-group -->
								</div> <!-- /.col-md-6 -->
								<div class="col-md-6">
									<div class="row space-5">
										<div class="col-md-3">
											<label for="human_size">Boy</label>
											<input type="text" name="human_size" id="human_size" class="form-control" value="<?php echo @$user_meta['human_size']; ?>">
										</div> <!-- /.col-md-3 -->
										<div class="col-md-3">
											<label for="human_weight">Kilo</label>
											<input type="text" name="human_weight" id="human_weight" class="form-control" value="<?php echo @$user_meta['human_weight']; ?>">
										</div> <!-- /.col-md-3 -->
									</div> <!-- /.row -->
								</div> <!-- /.col-md-6 -->
							</div> <!-- /.row -->

							
						</div> <!-- /.panel-body -->
					</div> <!-- /.panel -->

					

				</div> <!-- /.col-md-6 -->

			</div> <!-- /.row -->

			<div class="pull-right">
				<input type="hidden" name="update_cv">
				<input type="hidden" name="uniquetime" id="uniquetime" value="<?php uniquetime(); ?>">
				<button class="btn btn-default"><i class="fa fa-save"></i> Kaydet</button>
			</div> <!-- /.pull-right -->
		</form>