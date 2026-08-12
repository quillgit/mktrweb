<?php
	include "configuration/path.php";
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
                            <a href="<?php echo "$nama_folder";?>" class="language-btn active text-12">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en";?>" class="language-btn text-12">ENGLISH</a>
                        </div>
					</li>
				</ul>
				<div class="main-menu__top-right">
				    <a href="<?php echo "$nama_folder";?>/kontak_kami" class="text-white text-14">Kontak Kami</a>
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
            <img src="assets/images/backgrounds/background-min.jpg" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3>Halaman Tidak Ditemukan</h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li>404</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header End-->

    <!--Error Page Start-->
    <section class="error-page">
        <div class="container">
            <div class="error-page__inner">
                <div class="error-page__title-box">
                    <h2 class="error-page__title">404</h2>
                </div>
                <h3 class="error-page__tagline">Halaman Tidak Ditemukan</h3>
                <p class="error-page__text">Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.<br>
                Silakan kembali ke beranda atau gunakan tautan di bawah ini.</p>

                <div class="error-page__btn-box mt-4">
                    <a href="<?php echo "$nama_folder";?>" class="thm-btn">Kembali ke Beranda<span class="icon-arrow-right"></span></a>
                    <a href="<?php echo "$nama_folder/kontak_kami";?>" class="thm-btn">Hubungi Kami</a>
                </div>

                <div class="row mt-5 justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="service-details__services-box">
                            <h3 class="service-details__services-title">Halaman Populer</h3>
                            <ul class="service-details__services-list list-unstyled">
                                <li><a href="<?php echo "$nama_folder/profil_kami";?>">Profil Kami <span class="icon-angle-right"></span></a></li>
                                <li><a href="<?php echo "$nama_folder/berita";?>">Berita &amp; Kegiatan <span class="icon-angle-right"></span></a></li>
                                <li><a href="<?php echo "$nama_folder/karir";?>">Karir <span class="icon-angle-right"></span></a></li>
                                <li><a href="<?php echo "$nama_folder/penghargaan";?>">Penghargaan &amp; Pengakuan <span class="icon-angle-right"></span></a></li>
                                <li><a href="<?php echo "$nama_folder/kontak_kami";?>">Kontak Kami <span class="icon-angle-right"></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Error Page End-->
