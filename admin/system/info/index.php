<?php include('../../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Hakımızda' );
add_page_info( 'nav', array('name'=>'Seçenekler', 'url'=>get_site_url('admin/system/')) );
add_page_info( 'nav', array('name'=>'Hakkımızda') );
?>
  <style media="screen">
    .breadcrumb-header{
      display: none;
    }
  </style>

  <h1 style="font-weight: 300;">TilPark 1.0'a Hoş Geldiniz!</h1>
  <div class="h-20 hidden-lg"></div>

  <ul class="nav nav-tabs til-nav-page" role="tablist">
    <li role="presentation" class="active"><a href="#team" onclick="document.title='Emeği geneçler | Tilpark'" id="team-tab" aria-controls="team" role="tab" data-toggle="tab" aria-expanded="false">Emeği Geçenler</a></li>
    <li role="presentation" class=""><a href="#terms-of-use" onclick="document.title='Kullanım şartları | Tilpark'" id="terms-of-use-tab" aria-controls="terms-of-use" role="tab" data-toggle="tab" aria-expanded="false">Kullanım Şartları</a></li>
  </ul>


  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="team" aria-labelledby="team-tab">

      <style media="screen">
        .team-area{
          max-width: 1150px;
          padding: 20px 0;
        }

        .sociail-nav{
          margin-left: -5px;
          position: absolute;
          bottom: 10px;
        }

        .sociail-nav>li>a{
          padding: 5px 10px;
        }

        .developer-area{
          border: 1px solid #ccc;
          border-radius: 3px;
          padding: 10px;
          min-height: 105px;
        }

        .developer-area .avatar-area{
          width: 100px;
          display: inline-block;
          float: left;
          margin-right: 0px;
        }

        .developer-area .info-area{
          width: auto;
          display: inline-block;
        }


        @media(max-width: 767px) {
          .sociail-nav{
            margin-left: -5px;
            margin-right: -5px;
          }

          .sociail-nav>li{
            display: inline-block;
          }

          .sociail-nav>li>a{
            padding: 5px !important;
          }

          .team-area{
            width: 100%;
          }

          .developer-area .avatar-area{
            width: 25%;
            margin-right: 10px;
          }
        }

        .twitter{ color:    #00aced }
        .facebook{ color:   #3b5998 }
        .googleplus{ color: #dd4b39 }
        .pinterest{ color:  #cb2027 }
        .linkedin{ color:   #007bb6 }
        .youtube{ color:    #bb0000 }
        .instagram{ color:  #bc2a8d }
        .dribbble{ color:   #ea4c89 }
        .wordpress{ color:  #21759b }
      </style>

      <div style="team-area">
        <div class="row">
          <div class="col-md-4">
            <div class="developer-area">
              <div class="avatar-area">
                <img src="https://www.gravatar.com/avatar/<?php echo md5('mustafa@tilpark.com') ?>" alt="" class="img-responsive">
              </div><!--/ .avatar-area /-->

              <div class="info-area">
                <strong>Mustafa Tanrıverdi</strong>
                <p><i>Kurucu & Lider Geliştirici</i></p>

                <ul class="nav navbar-nav sociail-nav">
                  <li><a href="#" class="facebook" data-wenk="facebook"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="#" class="twitter" data-wenk="twitter"><i class="fa fa-twitter"></i></a></li>
                  <li><a href="#" class=google"" data-wenk="google"><i class="fa fa-google-plus"></i></a></li>
                  <li><a href="#" class="instagram" data-wenk="instagram"><i class="fa fa-instagram"></i></a></li>
                  <li><a href="#" class="pinterest" data-wenk="pinterest"><i class="fa fa-pinterest"></i></a></li>
                  <li><a href="#" class="linkedin" data-wenk="linkedin"><i class="fa fa-linkedin"></i></a></li>
                  <li><a href="#" class="" data-wenk="0 (532) 265 03 82"><i class="fa fa-phone"></i></a></li>
                </ul>
              </div><!--/ .info-area /-->
            </div><!--/ .developer-area /-->
          </div><!--/ .col-md-4 /-->

          <div class="clearfix hidden-md"></div>
          <div class="h-20 hidden-md"></div>

          <div class="col-md-4">
            <div class="developer-area">
              <div class="avatar-area">
                <img src="https://www.gravatar.com/avatar/<?php echo md5('muhammet@tilpark.com') ?>" alt="" class="img-responsive">
              </div><!--/ .avatar-area /-->

              <div class="info-area">
                <strong>Muhammet İnan</strong>
                <p><i>Kurucu & Lider Geliştirici</i></p>

                <ul class="nav navbar-nav sociail-nav">
                  <li><a href="#" class="facebook" data-wenk="facebook"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="#" class="twitter" data-wenk="twitter"><i class="fa fa-twitter"></i></a></li>
                  <li><a href="#" class=google"" data-wenk="google"><i class="fa fa-google-plus"></i></a></li>
                  <li><a href="#" class="instagram" data-wenk="instagram"><i class="fa fa-instagram"></i></a></li>
                  <li><a href="#" class="pinterest" data-wenk="pinterest"><i class="fa fa-pinterest"></i></a></li>
                  <li><a href="#" class="linkedin" data-wenk="linkedin"><i class="fa fa-linkedin"></i></a></li>
                  <li><a href="#" class="" data-wenk="0 (535) 014 95 63"><i class="fa fa-phone"></i></a></li>
                </ul>
              </div><!--/ .info-area /-->
            </div><!--/ .developer-area /-->
          </div><!--/ .col-md-4 /-->

          <div class="clearfix hidden-md"></div>
          <div class="h-20 hidden-md"></div>

          <div class="col-md-4">
            <div class="developer-area">
              <div class="avatar-area">
                <img src="https://www.gravatar.com/avatar/<?php echo md5('orhangurbuz@tilpark.com') ?>" alt="" class="img-responsive">
              </div><!--/ .avatar-area /-->

              <div class="info-area">
                <strong>Orhan Gürbüz</strong>
                <p><i>Editorhan</i></p>

                <ul class="nav navbar-nav sociail-nav">
                  <li><a href="#" class="facebook" data-wenk="facebook"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="#" class="twitter" data-wenk="twitter"><i class="fa fa-twitter"></i></a></li>
                  <li><a href="#" class=google"" data-wenk="google"><i class="fa fa-google-plus"></i></a></li>
                  <li><a href="#" class="instagram" data-wenk="instagram"><i class="fa fa-instagram"></i></a></li>
                  <li><a href="#" class="pinterest" data-wenk="pinterest"><i class="fa fa-pinterest"></i></a></li>
                  <li><a href="#" class="linkedin" data-wenk="linkedin"><i class="fa fa-linkedin"></i></a></li>
                </ul>
              </div><!--/ .info-area /-->
            </div><!--/ .developer-area /-->
          </div><!--/ .col-md-4 /-->
        </div><!--/ .row /-->
      </div><!--/ .team-area /-->
    </div><!--/ .tab-panel /-->


    <div role="tabpanel" class="tab-pane" id="terms-of-use" aria-labelledby="terms-of-use-tab">

        <!--/ Terms Of Use /-->

    </div><!--/ .tab-panel /-->
  </div>
<?php get_footer(); ?>
