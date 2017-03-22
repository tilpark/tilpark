<?php include('../../tilpark.php'); ?>

<link href="<?php echo template_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/tilpark.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/app.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">

<?php

// aktif olan kullanıcın tüm bilgilerini cekelim
$user = get_user($_GET['id']);
@$user_meta = get_user_meta($user->id);

?>

example
<title>CV - <?php echo $user->display_name; ?></title>

<div class="print-page" size="A4">



	<div class="print-tilpark-logo">
		<img src="<?php site_url('content/themes/default/img/logo_blank.png'); ?>" class="img-responsive">
	</div>

	<div class="row">
		<div class="col-xs-4">
			<img src="<?php echo $user->avatar; ?>" class="img-responsive" style="width:100%;">

			<div class="h-20"></div>

			<table class="table table-condensed table-condensed">
				<tr><td class="bold">T.C. No</td><td><?php echo $user->citizenship_no; ?></td></tr>
				<tr><td class="bold">Cinsiyet</td><td><?php echo $user->gender ? 'Bay' : 'Bayan'; ?></td></tr>
				<tr><td class="bold" width="100">Adı</td><td><?php echo $user->name; ?></td></tr>
				<tr><td class="bold">Soyadı</td><td><?php echo $user->surname; ?></td></tr>
				<tr><td class="bold">Doğum Tarihi</td><td><?php echo @$user_meta['date_birth']; ?></td></tr>
				<tr><td class="bold">Doğum Yeri</td><td><?php echo @$user_meta['birthplace']; ?></td></tr>
				<?php if(@$user_meta['blood_group']): ?><tr><td class="bold">Kan Grubu</td><td><?php echo @$user_meta['blood_group']; ?></td></tr><?php endif; ?>
				<tr><td class="bold">Gsm</td><td><?php echo $user->gsm; ?></td></tr>
				<?php if(!empty(@$user_meta['driving_license'])): ?>
					<tr><td class="bold">Ehliyet</td><td><?php echo implode(", ", @$user_meta['driving_license']); ?></td></tr>
				<?php endif; ?>
				<?php if(!empty(@$user_meta['src'])): ?>
					<tr><td class="bold">SRC</td><td><?php echo implode(", ", @$user_meta['src']); ?></td></tr>
				<?php endif; ?>
			</table>

			<h4 class="content-title title-line text-danger">Aile Bilgileri</h4>
			<table class="table table-condensed table-condensed">
				<tr><td class="bold">Baba Adı</td><td><?php echo @$user_meta['father_name']; ?></td></tr>
				<tr><td class="bold">Anne Adı</td><td><?php echo @$user_meta['mother_name']; ?></td></tr>
				<?php if(@$user_meta['is_married']): ?>
					<tr><td class="bold" width="100">Medeni Hali</td><td><?php echo _get_usermeta_is_married(@$user_meta['is_married']); ?></td></tr>
				<?php endif; ?>
				<?php if(@$user_meta['spouses_name']): ?>
					<tr><td class="bold">Eşinin Adı</td><td><?php echo @$user_meta['spouses_name']; ?></td></tr>
				<?php endif; ?>
				<?php if(@$user_meta['children_count']): ?>
					<tr><td class="bold">Çocuk Sayısı</td><td><?php echo @$user_meta['children_count']; ?></td></tr>
				<?php endif; ?>
				<?php if(@$user_meta['humble_person_count']): ?>
					<tr><td colspan="2">Ailesi dışında <b><?php echo @$user_meta['humble_person_count']; ?></b> kişiye bakmakla yükümlü.</td></tr>
				<?php endif; ?>
			</table>


			<?php if(@$user_meta['unhealthy']): ?>
				<h4 class="content-title title-line text-danger">Engelli</h4>
				<table class="table table-condensed table-condensed">
					<tr><td class="bold" width="100">Engel Tipi</td><td><?php echo @$user_meta['unhealthy_type']; ?></td></tr>
					<tr><td class="bold">Derecesi</td><td><?php echo @$user_meta['unhealthy_degree']; ?></td></tr>
				</table>
			<?php endif; ?>


			<?php if(@$user_meta['prison']): ?>
				<h4 class="content-title title-line text-danger">Hükümlü</h4>
				<table class="table table-condensed table-condensed">
					<tr><td class="bold" width="100">Süre</td><td><?php echo @$user_meta['prison_year']; ?> Yıl <?php echo @$user_meta['prison_month']; ?> Ay</td></tr>
					<tr><td class="bold">Açıklama</td><td><?php echo @$user_meta['prison_desc']; ?></td></tr>
				</table>
			<?php endif; ?>

			<?php if(@$user_meta['terror']): ?>
				<h4 class="content-title title-line text-danger">Terör Mağduru</h4>
				<table class="table table-condensed table-condensed">
					<tr><td class="bold" width="100">Yakınlık</td><td><?php echo @$user_meta['terror_type']; ?></td></tr>
					<tr><td class="bold">Açıklama</td><td><?php echo @$user_meta['terror_desc']; ?></td></tr>
				</table>
			<?php endif; ?>

			
			



		</div> <!-- /.col-md-4 -->
		<div class="col-xs-8">

			<div class="pull-right">
				<img src="<?php barcode_url('TILU-'.$user->id); ?>" />
				<br />
				<span class="pull-right mr-15"><?php echo 'TILU-'.$user->id; ?></span>
			</div>

			<h4 class="content-title"><?php echo $user->name; ?> <?php echo $user->surname; ?> <small class="pull"><?php echo $user->username; ?></small></h4>
			<?php echo @$user_meta['address']; ?> <?php echo @$user_meta['district']; ?>/<?php echo @$user_meta['city']; ?>

			<div class="h-20"></div>

			<?php if(isset($user_meta['school']) and !empty(@$user_meta['school'])): ?>
				<h4 class="content-title">Eğitim bilgileri</h4>
				<table class="table table-condensed">
				<tr>
					<tr>
						<th>Seviye</th>
						<th>Kurum Adı</th>
						<th>Bölüm</th>
						<th>Mez. Tarihi</th>
						<th>Puan</th>
					</tr>
				</tr>
				<?php foreach(@$user_meta['school'] as $school): ?>
					<tr>
						<td><?php echo _get_usermeta_school_text($school->school_level); ?></td>
						<td><?php echo $school->school_name; ?></td>
						<td><?php echo $school->school_department; ?></td>
						<td><?php echo $school->school_graduation_year; ?></td>
						<td><?php echo $school->school_grade; ?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php endif; ?>


			<?php if(isset($user_meta['language']) and !empty(@$user_meta['language'])): ?>
				<h4 class="content-title">Yabancı Diller</h4>
				<table class="table table-condensed">
				<tr>
					<tr>
						<th>Dil</th>
						<th>Okuma</th>
						<th>Yazma</th>
						<th>Konuşma</th>
					</tr>
				</tr>
				<?php foreach(@$user_meta['language'] as $lang): ?>
					<tr>
						<td><?php echo $lang->lang_lang; ?></td>
						<td><?php echo _get_usermeta_lang_text($lang->lang_reading); ?></td>
						<td><?php echo _get_usermeta_lang_text($lang->lang_writing); ?></td>
						<td><?php echo _get_usermeta_lang_text($lang->lang_talk); ?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php endif; ?>


			<?php if(isset($user_meta['work']) and !empty(@$user_meta['work'])): ?>
				<h4 class="content-title">İş deneyimleri</h4>
				<table class="table table-condensed">
				<tr>
					<tr>
						<th width="80">Zaman</th>
						<th width="80">Pozisyon</th>
						<th width="120">Firma Adı</th>
						<th>Açıklama</th>
					</tr>
				</tr>
				<?php foreach(@$user_meta['work'] as $work): ?>
					<tr>
						<td>
							<small><?php echo _get_usermeta_work_level_text($work->work_level); ?></small>
							<br />
							<small><?php echo $work->work_end_date; ?> - <?php echo $work->work_start_date; ?></small>
						</td>
						<td><?php echo $work->work_position; ?></td>
						<td><?php echo $work->work_company_name; ?></td>
						<td><?php echo $work->work_description; ?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php endif; ?>


			<?php if(isset($user_meta['reference']) and !empty(@$user_meta['reference'])): ?>
				<h4 class="content-title">Referanslar</h4>
				<table class="table table-condensed">
				<tr>
					<tr>
						<th width="120">Ad Soyad</th>
						<th width="">Firma Adı</th>
						<th width="100">Telefon</th>
					</tr>
				</tr>
				<?php foreach(@$user_meta['reference'] as $reference): ?>
					<tr>
						<td><?php echo $reference->ref_name_surname; ?></td>
						<td><?php echo $reference->ref_company; ?></td>
						<td><?php echo $reference->ref_phone; ?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php endif; ?>


			<h4 class="content-title">Ek Bilgiler</h4>
			<table class="table table-condensed">
				<tr>
					<td width="85%">Sigara içiyor mu?</td>
					<td width="15%"><?php echo @$user_meta['smoking'] ? 'Evet' : 'Hayır'; ?></td>
				</tr>
				<tr>
					<td width="85%">Seyehat engeli var mı?</td>
					<td width="15%"><?php echo @$user_meta['travel_ban'] ? 'Evet' : 'Hayır'; ?></td>
				</tr>
				<tr>
					<td width="85%">Fazla mesai yapabilir mi?</td>
					<td width="15%"><?php echo @$user_meta['work_overtime'] ? 'Evet' : 'Hayır'; ?></td>
				</tr>
				<tr>
					<td width="85%">Gece çalışabilir mi?</td>
					<td width="15%"><?php echo @$user_meta['work_night'] ? 'Evet' : 'Hayır'; ?></td>
				</tr>
			</table>


			<?php if(@$user_meta['military_status']): ?>
				<h4 class="content-title">Askerlik Durumu</h4>
				<table class="table table-condensed">
					<tr>
						<td width="85%">Askerlik durumu</td>
						<td width="15%"><?php echo _get_usermeta_military_status(@$user_meta['military_status']); ?></td>
					</tr>
					<?php if(@$user_meta['military_end_date']): ?>
						<tr>
							<td>Terhis tarihi</td>
							<td><?php echo @$user_meta['military_end_date']; ?></td>
						</tr>
					<?php endif; ?>
					<?php if(@$user_meta['military_postponed']): ?>
						<tr>
							<td>Tecil tarihi</td>
							<td><?php echo @$user_meta['military_postponed']; ?></td>
						</tr>
					<?php endif; ?>
					<?php if(@$user_meta['military_exempt']): ?>
						<tr>
							<td colspan="2"><?php echo @$user_meta['military_exempt']; ?></td>
						</tr>
					<?php endif; ?>
				</table>
			<?php endif; ?>


			<?php if(@$user_meta['emergency']): ?>
				<h4 class="content-title">Acil Durumlarda</h4>
				<table class="table table-condensed">
					<?php foreach(@$user_meta['emergency'] as $emergency): ?>
						<tr>
							<td width="50%"><?php echo $emergency->emergency_name; ?></td>
							<td width="25%"><?php echo $emergency->emergency_relative; ?></td>
							<td width="25%"><?php echo $emergency->emergency_phone; ?></td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php endif; ?>



		</div> <!-- /.col-md-8 -->
	</div> <!-- /.row -->


	<div class="print-footer print-footer-right text-center">
		<small class="text-muted">Yukarıdaki yazılan bilgilerin doğruluğunu onaylıyorum.</small>
		<br />
		<small><?php echo $user->name; ?> <?php echo $user->surname; ?></small>
		<br /> 
		<small class="text-muted">İmza</small>
	</div>


	<div class="print-footer print-footer-left">
		<small class="text-muted"><img src="<?php site_url('content/themes/default/img/logo_header.png'); ?>" class="img-responsive pull-left" width="64"> açık kaynak yazılımlar.</small>
	</div>



</div> <!-- /.print-page -->


