


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('product'); ?>">Profilim</a></li>
  <li class="active"><?php echo @$user['name']; ?> <?php echo @$user['surname']; ?></li>
</ol>


<?php if($user['status'] == '0'): ?>
    <?php alertbox('alert-danger', 'Kullanıcı hesabı silinmiş.', 'Bu kullanıcı hesabı silinmiş.', false); ?>
    <?php if(is_admin()): ?>
        <div class="text-right">
            <a href="?status=1" class="btn btn-success">hesabı aktif yap</a>
        </div>
    <?php endif; ?>
<?php endif; ?>


<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#profile" data-toggle="tab"><i class="fa fa-folder-o"></i> Profilim</a></li>
    <li><a href="#log" data-toggle="tab"><i class="fa fa-keyboard-o"></i> Log</a></li>
    <li class="dropdown">
        <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown">Seçenekler <b class="caret"></b></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
			<li><a href="<?php echo site_url('user/new_message/'.$user['id']); ?>"><i class="fa fa-envelope-o"></i> Yeni Mesaj Gönder</a></li>
            <li><a href="<?php echo site_url('user/new_task/'.$user['id']); ?>"><i class="fa fa-tasks"></i> Yeni Görev Ata</a></li>
			<?php if(is_admin()) : ?>
				<li role="presentation" class="divider"></li>
                <?php if($user['status'] == '1'): ?>
					<li><a href="<?php echo site_url('user/profile/'.$user['id'].'?status=0'); ?>"><i class="fa fa-trash-o"></i> Kullanıcıyı Sil</a></li>
                <?php else: ?>
                	<li><a href="<?php echo site_url('user/profile/'.$user['id'].'?status=1'); ?>"><i class="fa fa-trash-o"></i> Kullanıcı Aktif Yap</a></li>
                <?php endif; ?>
            <?php endif; ?>
		</ul>
	</li>
</ul> <!-- /.nav .nav-tabs -->

<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade active in" id="profile">
        <div class="row">
            <div class="col-md-4">
                <div class="widget-blank"><h4>Kullanıcı avatarı</h4></div>
                <div class="widget-body">

                    <?php if($user['avatar'] != ''): ?>
                        <div class="text-center">
                            <img src="<?php echo base_url('uploads/avatar/'); ?>/<?php echo $user['avatar']; ?>" alt="kullanıcı profil fotoğrafı" class="img-responsive img-thumbnail" />
                        </div> <!-- /.text-center -->
                    <?php else: ?>
                        <div class="text-center"><i class="fa fa-user" style="font-size:200px"></i></div>
                    <?php endif; ?>


                    <?php if($user_id == get_the_current_user('id') or get_the_current_user('role') < 3): ?>
                        <div class="h20"></div>
                        <div class="bodyLine"></div>
                        <div class="h20"></div>

                        <div class="widget-blank"><h4>Yeni bir fotoğraf yükle!</h4></div>
                        <form name="form_image" id="form_image" action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-picture-o"></span></span>
                                    <input type="file" id="avatar" name="avatar" class="form-control">
                                </div>
                            </div> <!-- /.form-group -->
                            <button class="btn btn-default"><i class="fa fa-upload"></i> Yükle</button>
                        </form>
                    <?php endif; ?>

                </div> <!-- /.widget-body -->
            </div> <!-- /.col-md-4 -->
            <div class="col-md-8">
                <div class="widget-blank"><h4>Profil bilgileri</h4></div>
                <div class="widget-body">

                    <form name="form_profile" id="form_profile" action="" method="POST" class="validation">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="control-label ff-1 fss-16">Ad</label>
                                    <div class="input-prepend input-group">
                                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Ad" minlength="2" maxlength="32" value="<?php echo $user['name']; ?>">
                                    </div>
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="surname" class="control-label ff-1 fss-16">Soyad</label>
                                    <div class="input-prepend input-group">
                                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                        <input type="text" id="surname" name="surname" class="form-control" placeholder="Ad" minlength="2" maxlength="32" value="<?php echo $user['surname']; ?>">
                                    </div>
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="control-label ff-1 fss-16">Yetki</label>
                                    <select class="form-control" name="role" id="role">
                                        <optgroup>
                                            <?php if($user_id == get_the_current_user('id') or get_the_current_user('role') < 3): ?>
                                                <option value="1" <?php selected($user['role'], 1);?>>Süper Yönetici</option>
                                                <option value="2" <?php selected($user['role'], 2);?>>Yönetici</option>
                                                <option value="3" <?php selected($user['role'], 3);?>>Birim Amiri</option>
                                                <option value="4" <?php selected($user['role'], 4);?>>Yetkili Personel</option>
                                                <option value="5" <?php selected($user['role'], 5);?>>Personel</option>
                                            <?php else: ?>
                                                <option value="<?php $user['role']; ?>"><?php echo get_role_name($user['role']); ?></option>
                                            <?php endif; ?>
                                        </optgroup>
                                    </select>
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gsm" class="control-label ff-1 fss-16">Telefon</label>
                                    <div class="input-prepend input-group">
                                        <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                                        <input type="text" id="gsm" name="gsm" class="form-control" placeholder="xxx" minlength="10" maxlength="11" value="<?php echo $user['gsm']; ?>">
                                    </div>
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-6 -->
                            <?php if($user_id == get_the_current_user('id') or get_the_current_user('role') < 3): ?>
                                <div class="col-md-12">
                                    <input type="hidden" name="update_profile">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Güncelle</button>
                                </div> <!-- /.col-md-12 -->
                            <?php endif; ?>
                        </div> <!-- /.row -->
                    </form> <!-- /.form_profile -->


                </div> <!-- /.widget-body -->





                <div class="h20"></div>
                <div class="widget-blank"><h4>Giriş bilgileri</h4></div>
                <div class="widget-body">

                    <form name="form_profile" id="form_profile" action="" method="POST" class="validation_2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="control-label ff-1 fss-16">E-posta</label>
                                    <div class="input-prepend input-group">
                                        <span class="input-group-addon"><span class="fa fa-envelope-o"></span></span>
                                        <input type="text" id="email" name="email" class="form-control required email" minlength="3" placeholder="Eposta" minlength="50" value="<?php echo $user['email']; ?>">
                                    </div>
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-12 -->
                            <?php if($user_id == get_the_current_user('id') or get_the_current_user('role') < 3): ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_pass" class="control-label ff-1 fss-16">Yeni şifre</label>
                                        <div class="input-prepend input-group">
                                            <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                            <input type="password" id="new_pass" name="new_pass" class="form-control" minlength="6" maxlength="32" value="">
                                        </div>
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col-md-6 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_pass_repair" class="control-label ff-1 fss-16">Yeni şifre <small class="text-muted">tekrar</small></label>
                                        <div class="input-prepend input-group">
                                            <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                            <input type="password" id="new_pass_repair" name="new_pass_repair" class="form-control" minlength="6" maxlength="32" value="">
                                        </div>
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col-md-6 -->
                                <?php if($user_id == get_the_current_user('id')): ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="old_pass" class="control-label ff-1 fss-16">Şifre <small class="text-muted">güncel şifren?</small></label>
                                            <div class="input-prepend input-group">
                                                <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                                <input type="password" id="old_pass" name="old_pass" class="form-control required" minlength="6" maxlength="32" value="">
                                            </div>
                                        </div> <!-- /.form-group -->
                                    </div> <!-- /.col-md-6 -->
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($user_id == get_the_current_user('id') or get_the_current_user('role') < 3): ?>
                                <div class="col-md-12">
                                    <input type="hidden" name="update_login_information">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-key"></i> Şifre değiştir</button>
                                </div> <!-- /.col-md-12 -->
                            <?php endif; ?>
                        </div> <!-- /.row -->
                    </form> <!-- /.form_profile -->


                </div> <!-- /.widget-body -->


            </div> <!-- /.col-md-8 -->
        </div> <!-- /.row -->
    </div> <!-- /.tab-pane -->
    <div class="tab-pane fade" id="log">
        Log
    </div> <!-- /.tab-pane -->
</div> <!-- /.tab-content -->