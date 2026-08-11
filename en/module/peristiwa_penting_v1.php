<?php
	include "configuration/path.php";
	
    $profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, banner FROM tabel_about_us WHERE id_about_us = '4'");
    $list_profile = mysql_fetch_array($profile);
    ?>
    
    <style>
        .timeline-wrapper {
          position: relative;
          max-width: 1100px;
          margin: 0 auto;
          padding: 60px 0;
        }
        
        .timeline-line {
          position: absolute;
          top: 0;
          left: 50%;
          transform: translateX(-50%);
          width: 4px;
          height: 100%;
          background: #3b7c3b;
          z-index: 1;
        }
        
        .timeline-item {
          position: relative;
          width: 50%;
          padding: 20px 40px;
          box-sizing: border-box;
        }
        
        .timeline-item.left {
          left: 0;
          text-align: right;
        }
        
        .timeline-item.right {
          left: 50%;
          text-align: left;
        }
        
        .timeline-item .content {
          background: #307c54;
          color: #fff;
          padding: 15px 20px;
          border-radius: 12px 0 0 12px;
          display: inline-block;
          max-width: 90%;
          position: relative;
          z-index: 2;
          box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .content, h4{
            color: #fff !important;
        }
        
        .timeline-item.right .content {
          border-radius: 0 12px 12px 0;
        }
        
        .timeline-item .circle {
          position: absolute;
          top: 30px;
          width: 16px;
          height: 16px;
          background: #fff;
          border: 4px solid #3b7c3b;
          border-radius: 50%;
          z-index: 3;
        }
        
        .timeline-item.left .circle {
          right: -8px;
        }
        
        .timeline-item.right .circle {
          left: -8px;
        }
        
        .timeline-item .date {
          position: absolute;
          top: 28px;
          font-size: 13px;
          color: #555;
        }
        
        .timeline-item.left .date {
          right: -90px;
        }
        
        .timeline-item.right .date {
          left: -90px;
        }
        
        @media screen and (max-width: 768px) {
          .timeline-item {
            width: 100%;
            padding-left: 60px;
            padding-right: 60px;
          }
        
          .timeline-item.left,
          .timeline-item.right {
            left: 0;
            text-align: left;
          }
        
          .timeline-item .date {
            left: 50px;
            right: auto;
          }
        
          .timeline-item .circle {
            left: 32px;
            right: auto;
          }
        
          .timeline-item .content {
            border-radius: 12px;
          }
        }
        
        .timeline-container {
          position: relative;
          padding: 50px 0;
          width: 100%;
        }
        
        .timeline-line {
          position: absolute;
          left: 50%;
          top: 0;
          bottom: 0;
          width: 4px;
          background-color: #964B00;
          transform: translateX(-50%);
          z-index: 1;
        }
        
        .timeline-item {
          position: relative;
          margin: 40px 0;
          width: 50%;
          padding: 10px 20px;
          box-sizing: border-box;
        }
        
        .timeline-item.left {
          left: 0;
          text-align: right;
        }
        
        .timeline-item.right {
          left: 50%;
          text-align: left;
        }
        
        .timeline-item .root-branch {
          content: '';
          position: absolute;
          top: 20px;
          width: 30px;
          height: 4px;
          background-color: #964B00;
          z-index: 2;
        }
        
        .timeline-item.left .root-branch {
          right: -30px;
          border-top-left-radius: 20px;
          border-bottom-left-radius: 20px;
        }
        
        .timeline-item.right .root-branch {
          left: -30px;
          border-top-right-radius: 20px;
          border-bottom-right-radius: 20px;
        }
        
        .timeline-item .content-box {
          background-color: #307c54;
          padding: 15px;
          border-radius: 8px;
          z-index: 2;
          position: relative;
          color: #fff;
        }

    </style>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list">
					
					<li>
						<div class="language-menu">
							<a href="<?php echo "$nama_folder/peristiwa_penting";?>" class="language-btn">INA</a>
							<a href="<?php echo "$nama_folder/en/peristiwa_penting";?>" class="language-btn active">ENG</a>
						</div>
					</li>
				</ul>
				<div class="main-menu__top-right">
					<div class="main-menu__social">
					    <a href="https://m.facebook.com/p/PT-Menthobi-Karyatama-Raya-Tbk-100081064625604" target="_blank"><i class="icon-facebook"></i></a>
                        <a href="https://instagram.com/mktr.id?igshid=MzRlODBiNWFlZA==" target="_blank"><i class="icon-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/pt-menthobi-karyatama-raya/" target="_blank"><i class="icon-link-in"></i></a>
                        <a href="https://www.youtube.com/@mktr5433" target="_blank"><i class="fab fa-youtube"></i></a>
					</div>
				</div>
			</div>
		</div>
		
		<?php
		header_menu();
		?>
	</header>

    <!--Page Header Start-->
    <section class="page-header" style="width: 100%; overflow: hidden;">
        <div class="page-header__shape-1" style="width: 100%;">
            <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_profile[banner]";?>" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3>Milestones</h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder";?>">Home</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li>Milestones</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header End-->

    <section class="blog-one">
        <div class="container">
            <div class="row mb-5">
                <div class="col-xl-4">
                    <div class="service-details__services-box">
                        <h3 class="service-details__services-title">About Us</h3>
                        <ul class="service-details__services-list list-unstyled">

                            <li><a href="<?php echo "$nama_website/profil_kami";?>">About Us</a></li>
                            <li><a href="<?php echo "$nama_website/logo_kami";?>">Our Logo</a></li>
                            <li><a href="<?php echo "$nama_website/visi_misi";?>">Vision, Mission and Values</a></li>
                            <li class="active"><a href="<?php echo "$nama_website/peristiwa_penting";?>">Milestones</a></li>
                            <li><a href="<?php echo "$nama_website/struktur_kepemilikan";?>">Ownership Structure</a></li>
                            <li><a href="<?php echo "$nama_website/struktur_organisasi";?>">Organization Structure</a></li>
                            <li><a href="<?php echo "$nama_website/dewan_komisaris";?>">Board of Commissioners</a></li>
                            <li><a href="<?php echo "$nama_website/direksi";?>">Board of Directors</a></li>
                            <li><a href="<?php echo "$nama_website/struktur_group";?>">Group Structure</a></li>
                            <li><a href="<?php echo "$nama_website/anak_perusahaan_kami";?>">Our Subsidiaries</a></li>
                            <li><a href="<?php echo "$nama_website/penghargaan";?>">Awards & Recognition</a></li>
                            <li><a href="<?php echo "$nama_website/keanggotaan";?>">Membership</a></li>
                        </ul>
                    </div>
                </div>


                <div class="col-xl-8">
                    <div class="timeline-container">
                      <div class="timeline-line"></div>
                    
                      <?php
                      $perusahaan = mysql_query("SELECT title, description FROM tabel_jejak_perusahaan ORDER BY title ASC");
                      $i = 0;
                      while ($list = mysql_fetch_array($perusahaan)) {
                        $side = $i % 2 == 0 ? 'left' : 'right';
                      ?>
                        <div class="timeline-item <?= $side ?>">
                          <div class="root-branch"></div>
                          <div class="content-box">
                            <h4><?= $list['title'] ?></h4>
                            <p><?= $list['description'] ?></p>
                          </div>
                        </div>
                      <?php $i++; } ?>
                    </div>
                </div>



                
                <script>
                    function toggleTooltip(index) {
                      document.querySelectorAll('.tooltip').forEach(t => t.classList.remove('show'));
                      const tooltip = document.getElementById('tooltip-' + index);
                      if (tooltip) tooltip.classList.toggle('show');
                    }
                    
                    document.addEventListener('click', function(e) {
                      if (!e.target.classList.contains('dot')) {
                        document.querySelectorAll('.tooltip').forEach(t => t.classList.remove('show'));
                      }
                    });
                </script>

            </div>

        </div>

    </section>

