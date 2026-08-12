<?php
	include "configuration/path.php";
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
							<a href="<?php echo "$nama_folder";?>" class="language-btn text-12">INDONESIA</a>
							<div class="text-white set-line">|</div>
							<a href="<?php echo "$nama_folder/en";?>" class="language-btn text-12 active">ENGLISH</a>
						</div>
					</li>
				</ul>
				<div class="main-menu__top-right">
				    <a href="<?php echo "$nama_folder/en";?>/kontak_kami" class="text-white text-14">Contact Us</a>
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
            <img src="../assets/images/backgrounds/background-min.jpg" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3>Page Not Found</h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder/en";?>">Home</a></li>
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
                <h3 class="error-page__tagline">Page Not Found</h3>
                <p class="error-page__text">Sorry, the page you are looking for is unavailable or has been moved.<br>
                Please return to the homepage or use one of the links below.</p>

                <div class="error-page__btn-box mt-4">
                    <a href="<?php echo "$nama_folder/en";?>" class="thm-btn">Back to Homepage<span class="icon-arrow-right"></span></a>
                    <a href="<?php echo "$nama_folder/en/kontak_kami";?>" class="thm-btn">Contact Us</a>
                </div>

                <div class="row mt-5 justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="service-details__services-box">
                            <h3 class="service-details__services-title">Popular Pages</h3>
                            <ul class="service-details__services-list list-unstyled">
                                <li><a href="<?php echo "$nama_folder/en/profil_kami";?>">About Us <span class="icon-angle-right"></span></a></li>
                                <li><a href="<?php echo "$nama_folder/en/berita";?>">News &amp; Events <span class="icon-angle-right"></span></a></li>
                                <li><a href="<?php echo "$nama_folder/en/karir";?>">Career <span class="icon-angle-right"></span></a></li>
                                <li><a href="<?php echo "$nama_folder/en/penghargaan";?>">Awards &amp; Recognition <span class="icon-angle-right"></span></a></li>
                                <li><a href="<?php echo "$nama_folder/en/kontak_kami";?>">Contact Us <span class="icon-angle-right"></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Error Page End-->
