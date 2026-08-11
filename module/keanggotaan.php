<?php
	include "configuration/path.php";
    $profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, banner FROM tabel_about_us WHERE id_about_us = '7'");
    $list_profile = mysql_fetch_array($profile);
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
                            <a href="<?php echo "$nama_folder/keanggotaan";?>" class="language-btn active text-12">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en/keanggotaan";?>" class="language-btn text-12">ENGLISH</a>
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
            <img src="assets/images/backgrounds/banner-1a.jpg" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3>Keanggotaan</h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li>Keanggotaan</li>
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
                        <h3 class="service-details__services-title">Tentang Kami</h3>
                        <ul class="service-details__services-list list-unstyled">
                            <li><a href="<?php echo "$nama_folder/profil_kami";?>">Profil Kami</a></li>
                            <li><a href="<?php echo "$nama_folder/logo_kami";?>">Logo Kami </a></li>
                            <li><a href="<?php echo "$nama_folder/visi_misi";?>">Visi Misi & Nilai-nilai </a></li>
                            <li><a href="<?php echo "$nama_folder/peristiwa_penting";?>">Peristiwa Penting </a></li>
                            <li><a href="<?php echo "$nama_folder/struktur_kepemilikan";?>">Struktur Kepemilikan </a></li>
                            <li><a href="<?php echo "$nama_folder/struktur_organisasi";?>">Struktur Organisasi </a></li>
                            <li><a href="<?php echo "$nama_folder/dewan_komisaris";?>">Dewan Komisaris </a></li>
                            <li><a href="<?php echo "$nama_folder/direksi";?>">Direksi </a></li>
                            <li><a href="<?php echo "$nama_folder/struktur_group";?>">Struktur Group </a></li>
                            <li><a href="<?php echo "$nama_folder/anak_perusahaan_kami";?>">Anak Perusahaan Kami </a></li>
                            <li><a href="<?php echo "$nama_folder/penghargaan";?>">Penghargaan & Pengakuan</a></li>
                            <li  class="active"><a href="<?php echo "$nama_folder/keanggotaan";?>">Keanggotaan</a></li>
                        </ul>
                    </div>
                </div>

                <!--Start Shop Details Page1 Img class="blog-details"-->
                <div class="col-xl-8">
                    <section>
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12 col-lg-7">
                                    <div class="blog-details__left">
                                        <h3 class="blog-details__title"><?php echo "$list_profile[sub_title]";?>
                                        </h3>
                                        <div class="blog-details__content mb-4">
                                        <?php echo "$list_profile[description]";?>
                                        </div>
                                        <div class="blog-details__img">
                                            <div class="col-xl-12">
                                                <div class="cart-page-one-table">

                                                    <div class="table-outer">

                                                        <table class="cart-table">
                                                            <thead class="cart-header clearfix">
                                                                <!--<tr>-->
                                                                <!--    <th class="prod-column">Asosiasi</th>-->
                                                                <!--    <th>Peran</th>-->
                                                                <!--    <th class="price">Tautan</th>-->
                                                                <!--</tr>-->
                                                                
                                                                <tr>
                                                                    <th class="prod-column">Asosiasi</th>
                                                                    <th>Status Asosiasi</th>
                                                                    <th class="price">Tautan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $keanggotaan = mysql_query("SELECT title, title_english, content, content_english, gambar, link FROM tabel_keanggotaan");
                                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                                            {
                                                            ?>
                                                                <tr>
                                                                    <td class="prod-column text-center">
                                                                        <div class="column-box text-center">
                                                                            <div class="prod-thumb text-center">
                                                                                <img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_keanggotaan[gambar]";?>" alt="<?php echo "$list_keanggotaan[title]";?>">
                                                                                <br>
                                                                                <br>
                                                                                <?php echo "$list_keanggotaan[title]";?>
                                                                            </div>

                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="title text-center">
                                                                        <?php echo "$list_keanggotaan[content]";?>
                                                                        </div>
                                                                    </td>
                                                                    <td class="qty">
                                                                        <div class="input-box">
                                                                            <a href="<?php echo "$list_keanggotaan[link]";?>" target="_blank"><?php echo "$list_keanggotaan[link]";?>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>

        </div>

    </section>

