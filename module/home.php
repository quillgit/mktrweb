<?php
	include "configuration/path.php";
	
	?>
	<header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<!--<div class="language-menu">-->
						<!--	<a href="<?php echo "$nama_folder";?>" class="language-btn active">INA</a>-->
						<!--	<a href="<?php echo "$nama_folder/en";?>" class="language-btn">ENG</a>-->
						<!--</div>-->
						
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

	<div class="stricky-header stricked-menu main-menu">
		<div class="sticky-header__content"></div><!-- /.sticky-header__content -->
	</div><!-- /.stricky-header -->

	<section class="main-slider-three">
		<div class="main-slider-three__carousel owl-carousel owl-theme">

			<?php
            $menu_banner = mysql_query("SELECT
                tabel_banner.title, 
                tabel_banner.id_banner, 
                tabel_banner.konten, 
                tabel_banner.link, 
                tabel_banner.gambar, 
                tabel_banner.gambar_mobile
            FROM
                tabel_banner
            WHERE status = '2'");
            while ($list_menu_banner = mysql_fetch_array($menu_banner))
            {
            ?>
			<div class="item">
				<div class="main-slider-three__bg d-none d-xl-block" style="background-image: url(<?php echo "$nama_folder/images/banner/$list_menu_banner[gambar]";?>);">
				</div>

				<div class="main-slider-three__bg d-block d-sm-none" style="background-image: url(<?php echo "$nama_folder/images/banner/$list_menu_banner[gambar_mobile]";?>);">
				</div>

				<div class="container">
					<div class="main-slider-three__content">
						<div class="main-slider-three__sub-title-box">
							<p class="main-slider-three__sub-title">PT Menthobi Karyatama Raya Tbk</p>
						</div>
						<h2 class="main-slider-three__title"><?php echo $list_menu_banner['title'];?></h2>
						<p class="main-slider-three__text"><?php echo $list_menu_banner['konten'];?></p>
						<!--<div class="main-slider-three__btn-box">-->
						<!--	<a href="<?php echo $list_menu_banner['link'];?>" class="main-slider-three__btn thm-btn">Selengkapnya</a>-->
						<!--</div>-->
					</div>
				</div>
				
			</div>
			<?php
			}
			?>
			
		</div>
	</section>
	<!--Main Slider Start --><!--About Three Start -->

	<!-- SECTION TENTANG KAMI about-one -->
	<section class="shop-details-page1">
		<div class="container">
			<div class="row">
				<?php
 				$setup_home = mysql_fetch_array(mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, gambar_2 FROM tabel_home WHERE id_home = '1'"));
				?>
				<div class="col-xl-6">
					<div class="about-one__left wow slideInLeft" data-wow-delay="100ms"
						data-wow-duration="2500ms">
						<div class="row">
							<div class="col-xl-6">
								<div class="about-one__img-box-1">
									<div class="about-one__img-1">
										<img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$setup_home[gambar]";?>" alt="">
									</div>
								</div>
							</div>
							<div class="col-xl-6">
								<!--<div class="about-one__cirtified">-->
								<!--	<h3><?php echo "$setup_home[sub_title]";?></h3>-->
								<!--</div>-->
								<div class="about-one__img-box-2">
									<div class="about-one__img-2">
										<img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$setup_home[gambar_2]";?>" alt="">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="about-one__right wow fadeInRight" data-wow-delay="300ms">
						<div class="section-title text-left">
							<!--<div class="section-title__tagline-box">-->
							<!--	<span class="section-title__tagline">PT MENTHOBI KARYATAMA RAYA TBK</span>-->
							<!--</div>-->
							<div class="section-title__title-box sec-title-animation animation-style2">
								<h2 class="section-title__title title-animation">Tentang Kami</h2>
							</div>
						</div>
						<p class="about-one__text-1 mb-4"><?php echo "$setup_home[description]";?>
						</p>
						<div class="about-one__btn-box mt-4">
							<a href="<?php echo "$nama_folder/profil_kami";?>" class="about-one__btn thm-btn">Lihat Selengkapnya</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- BISNIS INTI  -->
	<section class="shop-details-page1">
		<div class="services-four">
			<div class="container">
				<div class="section-title-three text-center sec-title-animation animation-style1">
					<!--<div class="section-title-three__tagline-box justify-content-center">-->
					<!--	<div class="section-title-three__tagline-shape"></div>-->
					<!--	<span class="section-title-three__tagline">PT MENTHOBI KARYATAMA RAYA</span>-->
					<!--	<div class="section-title-three__tagline-shape"></div>-->
					<!--</div>-->
					<h2 class="section-title-three__title title-animation">Bisnis Inti</h2>
				</div>
				<div class="row">
					<?php
                   $home_bisnis_int = mysql_query("SELECT id_bisnis_inti, sub_title_english, sub_title, slug, slug_english, gambar, konten FROM tabel_bisnis_inti");
                   while ($list_home_bisnis_int = mysql_fetch_array($home_bisnis_int))
                   {
						$konten = limitWord($list_home_bisnis_int['description'],10);
                   ?>
					<div class="col-xl-3 col-lg-3 wow fadeInUp" data-wow-delay="100ms">
						<div class="services-four__single">
							<div class="services-four__img">
								<img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_home_bisnis_int[gambar]";?>" alt="">
							</div>
							<div class="services-four__content">
								<h3 class="services-four__title"><a href="<?php echo "$nama_folder/bisnis/$list_home_bisnis_int[slug]";?>"><?php echo "$list_home_bisnis_int[sub_title]";?></a></h3>
								<p class="services-four__text"><?php echo "$list_home_bisnis_int[konten]";?> 
								</p>

							</div>
						</div>
					</div>
					<?php
				   }
				   ?>
					
				</div>
			</div>
	</section>


	<!-- SECTION INISIATIF BERKELANJUTAN project-one -->
	<section class="shop-details-page1">
		<div class="project-one__shape-1 img-bounce">
			<img src="assets/images/shapes/project-one-shape-1.png" alt="">
		</div>
		<div class="container">
			<div class="project-one__top">
				<div class="section-title text-left">
					<!--<div class="section-title__tagline-box">-->
					<!--	<span class="section-title__tagline">PT Menthobi Karyatama Raya Tbk</span>-->
					<!--</div>-->
					<div class="section-title__title-box sec-title-animation animation-style2">
						<h2 class="section-title__title title-animation">Inisiatif Berkelanjutan</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-4 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="100ms">

				   <?php
                   $home_berkelanjutan_1 = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, slug FROM tabel_berkelanjutan WHERE kategori != 'child' AND tipe = 'text' AND id_berkelanjutan != '1' ORDER BY id_berkelanjutan ASC limit 2");
                   while ($list_home_berkelanjutan_1 = mysql_fetch_array($home_berkelanjutan_1))
                   {
						$konten = limitWord($list_home_berkelanjutan_1['description'],15);
                   ?>

					<div class="project-one__single">
						<div class="project-one__img-box">
							<div class="project-one__img">
								<img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_home_berkelanjutan_1[gambar]";?>" alt="">
								<div class="project-one__arrow">
									<a href="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_home_berkelanjutan_1[gambar]";?>" class="img-popup"><span class="icon-arrow-right"></span></a>
								</div>
							</div>
							<div class="project-one__content">
								<h2 class="project-one__sub-title"><?php echo "$list_home_berkelanjutan_1[sub_title]";?></h2>
								<p class="project-one__sub-title"><?php echo "$konten";?>... <a href="<?php echo "$nama_folder/keberlanjutan/$list_home_berkelanjutan_1[slug]";?>">Selengkapnya</a></p>
							</div>
						</div>
					</div>

					<?php
				   }
				   ?>

				</div>

				<div class="col-xl-8 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">

					<?php
                   	$home_berkelanjutan_2 = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, slug FROM tabel_berkelanjutan WHERE kategori != 'child' AND tipe = 'text' AND id_berkelanjutan = '1'");
                   while ($list_home_berkelanjutan_2 = mysql_fetch_array($home_berkelanjutan_2))
                   	{
						$konten = limitWord($list_home_berkelanjutan_2['description'],50);
                   	?>

					<div class="project-one__single">
						<div class="project-one__img-box">
							<div class="project-one__img">
								<img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_home_berkelanjutan_2[gambar]";?>" alt="">
								<div class="project-one__arrow">
									<a href="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_home_berkelanjutan_2[gambar]";?>" class="img-popup"><span class="icon-arrow-right"></span></a>
								</div>
							</div>
							<div class="project-one__content">
								<p class="project-one__sub-title"><?php echo "$list_home_berkelanjutan_2[sub_title]";?></p>
								<p class="project-one__sub-title" style="text-transform: none;"><?php echo "$konten";?>... <a href="<?php echo "$nama_folder/keberlanjutan/$list_home_berkelanjutan_2[slug]";?>">Selengkapnya</a></p>
							</div>
						</div>
					</div>

					<?php
					}
					?>

					<div class="row">

					<?php
                   	$home_berkelanjutan_3 = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, slug FROM tabel_berkelanjutan WHERE id_berkelanjutan = '43'");
                   	while ($list_home_berkelanjutan_3 = mysql_fetch_array($home_berkelanjutan_3))
                   	{
						$konten = limitWord($list_home_berkelanjutan_3['description'],10);
                   	?>
						<div class="col-xl-6 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="900ms">
							<div class="project-one__single">
								<div class="project-one__img-box">
									<div class="project-one__img">
										<img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_home_berkelanjutan_3[gambar]";?>" alt="">
										<div class="project-one__arrow">
											<a href="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_home_berkelanjutan_3[gambar]";?>"
												class="img-popup"><span class="icon-arrow-right"></span></a>
										</div>
									</div>
									<div class="project-one__content">
										<h2 class="project-one__sub-title"><?php echo "$list_home_berkelanjutan_3[sub_title]";?></h2>
										<p class="project-one__sub-title" style="text-transform: none;"><?php echo "$konten";?>... <a href="<?php echo "$nama_folder/keberlanjutan/$list_home_berkelanjutan_3[slug]";?>">Selengkapnya</a></p>
									</div>
								</div>
							</div>
						</div>
					<?php
					}
					?>

					<?php
                   	$home_berkelanjutan_4 = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, slug FROM tabel_berkelanjutan WHERE id_berkelanjutan = '35'");
                   	while ($list_home_berkelanjutan_4 = mysql_fetch_array($home_berkelanjutan_4))
                   	{
						$konten = limitWord($list_home_berkelanjutan_4['description'],10);
                   	?>
						<div class="col-xl-6 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="900ms">
							<div class="project-one__single">
								<div class="project-one__img-box">
									<div class="project-one__img">
										<img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_home_berkelanjutan_4[gambar]";?>" alt="">
										<div class="project-one__arrow">
											<a href="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_home_berkelanjutan_4[gambar]";?>"
												class="img-popup"><span class="icon-arrow-right"></span></a>
										</div>
									</div>
									<div class="project-one__content">
										<h2 class="project-one__sub-title"><?php echo "$list_home_berkelanjutan_4[sub_title]";?></h2>
										<p class="project-one__sub-title" style="text-transform: none;"><?php echo "$konten";?>... <a href="<?php echo "$nama_folder/keberlanjutan/$list_home_berkelanjutan_4[slug]";?>">Selengkapnya</a></p>
									</div>
								</div>
							</div>
						</div>
					<?php
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- SECTION HUBUNGAN INVESTOR  -->
	<section class="shop-details-page1">
		<div class="container">
			<!--<div class="text-center">-->
			<!--	<span class="section-title__tagline">Hubungan Investor</span>-->
			<!--</div>-->
			<div
				class="section-title__title-box section-title text-center sec-title-animation animation-style2">
				<h2 class="section-title__title title-animation">Hubungan Investor</h2>
			</div>

			<iframe title="advanced chart TradingView widget" lang="en" id="tradingview_ae249" frameborder="0"
				allowtransparency="true" scrolling="no" allowfullscreen="true"
				src="https://s.tradingview.com/widgetembed/?hideideas=1&amp;overrides=%7B%7D&amp;enabled_features=%5B%5D&amp;disabled_features=%5B%5D&amp;locale=en#%7B%22symbol%22%3A%22MKTR%22%2C%22frameElementId%22%3A%22tradingview_ae249%22%2C%22interval%22%3A%22D%22%2C%22hide_top_toolbar%22%3A%221%22%2C%22hide_side_toolbar%22%3A%221%22%2C%22allow_symbol_change%22%3A%221%22%2C%22save_image%22%3A%221%22%2C%22studies%22%3A%22%5B%5D%22%2C%22theme%22%3A%22Grey%22%2C%22style%22%3A%222%22%2C%22timezone%22%3A%22Asia%2FBangkok%22%2C%22hideideasbutton%22%3A%221%22%2C%22studies_overrides%22%3A%22%7B%7D%22%2C%22no_referral_id%22%3A%221%22%2C%22utm_source%22%3A%22mktr.co.id%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22chart%22%2C%22utm_term%22%3A%22MKTR%22%2C%22page-uri%22%3A%22mktr.co.id%2F%22%7D"
				style="
									width: 100%;
									height: 500px;
									margin: 0px !important;
									box-sizing: border-box;
								">
			</iframe>
		</div>
	</section>

	<section class="blog-one">
		<div class="container">
			<div class="blog-one__top">
				<div class="section-title text-left">
					<div class="section-title__tagline-box">
						<span class="section-title__tagline">PT Menthobi Karyatama Raya tbk</span>
					</div>
					<div class="section-title__title-box sec-title-animation animation-style2">
						<h2 class="section-title__title title-animation">Berita & Kegiatan</h2>
					</div>
				</div>
				<div class="blog-one__btn-box">
					<a href="<?php echo "$nama_folder/berita";?>" class="blog-one__btn thm-btn">Lihat Semua</a>
				</div>
			</div>
			<div class="row">
				<?php
				$berita_other = mysql_query("SELECT title, content, gambar, id_berita, slug, created FROM tabel_berita where status = '2' AND id_berita != '$id' ORDER BY created DESC limit 3");
				while ($list_berita_other = mysql_fetch_array($berita_other))
				{
					
					$judul = limitWord($list_berita_other['title'],8);
					$konten = limitWord($list_berita_other['content'],10);
				?>
				<div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
					<div class="blog-one__single">
						<div class="blog-one__img-box">
							<div class="blog-one__img">
								<img src="<?php echo "$nama_folder/images/post/$list_berita_other[gambar]";?>" alt="<?php echo "$list_berita_other[title]";?>" class="height-img">
								<img src="<?php echo "$nama_folder/images/post/$list_berita_other[gambar]";?>" alt="<?php echo "$list_berita_other[title]";?>" class="height-img">
								<a href="<?php echo "$nama_folder/read/$list_berita_other[id_berita]/$list_berita_other[slug]";?>" class="blog-one__link"><span class="sr-only"></span></a>
							</div>
							<div class="blog-one__date">
								<p><?php echo TanggalBulan($list_berita_other['created']);?></p>
							</div>
						</div>
						<div class="blog-one__content">
							<!--<div class="blog-one__user">-->
							<!--	<p><span class="icon-user"></span>By MKTR</p>-->
							<!--</div>-->
							<h3 class="blog-one__title"><a href="<?php echo "$nama_folder/read/$list_berita_other[id_berita]/$list_berita_other[slug]";?>"><?php echo "$list_berita_other[title]";?> </a></h3>
							<a href="<?php echo "$nama_folder/read/$list_berita_other[id_berita]/$list_berita_other[slug]";?>" class="blog-one__learn-more">Lihat Selengkapnya<span class="icon-arrow-right"></span></a>
						</div>
					</div>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	</section>
	
	<!--<a href="<?php echo "$nama_folder/keberlanjutan/daftar-pengaduan";?>">-->
	<!--	<img src="assets/images/resources/toa1a.png" class="posisi-bicara">-->
	<!--</a>-->

	<!--<a href="<?php echo "$nama_folder/keberlanjutan/daftar-pengaduan";?>">-->
	<!--	<img src="assets/images/resources/bicara2.png" class="posisi-bicara">-->
	<!--</a>-->
