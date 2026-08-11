<?php
	include "configuration/path.php";

?>


<header class="main-header">
    <div class="main-menu__top">
        <div class="main-menu__top-inner">
            <ul class="list-unstyled main-menu__contact-list set-m10">
                <li>
					<div class="language-menu">
						<a href="<?php echo "$nama_folder/kontak_kami";?>" class="language-btn text-12 active">INDONESIA</a>
						<div class="text-white set-line">|</div>
						<a href="<?php echo "$nama_folder/en/kontak_kami";?>" class="language-btn text-12 ">ENGLISH</a>
					</div>
				</li>
            </ul>
            <div class="main-menu__top-right">
                <a href="<?php echo "$nama_folder";?>/kontak_kami" class="text-white text-14">Kontak Kami</a>
                <div class="main-menu__social">
                    <a href="https://m.facebook.com/p/PT-Menthobi-Karyatama-Raya-Tbk-100081064625604" target="_blank"><i
                            class="icon-facebook"></i></a>
                    <a href="https://instagram.com/mktr.id?igshid=MzRlODBiNWFlZA==" target="_blank"><i
                            class="icon-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/pt-menthobi-karyatama-raya/" target="_blank"><i
                            class="icon-link-in"></i></a>
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
        <img src="<?php echo "$nama_folder";?>/images/banner/26840banner-1a.jpg" alt="" style="width: 100%;">
    </div>
    <div class="container">
        <div class="page-header__inner">
            <h3>Kontak Kami</h3>
            <div class="thm-breadcrumb__inner">
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                    <li><span class="icon-angle-right"></span></li>
                    <li>Kontak Kami</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--Page Header End-->

<!-- KONTEN  -->
<section class="blog-one">
    <div class="container">
        <div class="row mb-10">

            <div class="col-xl-3">
                <h6 class="mb-3 bold black mt-1">PT Menthobi Karyatama Raya, Tbk</h6>
                <div class="mb-3 text-xs">
                    Jl. Otista Raya No.80 2, RT.2/RW.5, Bidara Cina, Kecamatan Jatinegara, Kota Jakarta Timur, Daerah
                    Khusus Ibukota Jakarta 13330
                </div>

                <h6 class="mb-3 bold black">E-mail:</h6>
                <div class="mb-3"></div>

                <h6 class="mb-3 bold black">Sekretaris Perusahaan:</h6>
                <div class="mb-3"></div>

                <h6 class="mb-3 bold black">Komunikasi Perusahaan:</h6>
                <div class="mb-3"></div>

                <h6 class="mb-3 bold black">Hubungan Investor & Pengembangan Bisnis:</h6>
                <div class="mb-3"></div>

                <h6 class="mb-3 bold black">Sosial Media</h6>
                <div class="mb-3 ">
                    <div class="d-flex">
                        <img class="width-8p " src="<?php echo "$nama_folder";?>/assets/images/icon/icon-ig1.png">
                        <div class="margin-l-10 text-medsos align-content-center">instagram : <a
                                href="https://instagram.com/mktr.id?igshid=MzRlODBiNWFlZA==" target="_blank">
                                MKTR.id</a>
                        </div>
                    </div>
                </div>
                <div class="mb-3 ">
                    <div class="d-flex">
                        <img class="width-8p " src="<?php echo "$nama_folder";?>/assets/images/icon/icon-yt1.png">
                        <div class="margin-l-10 text-medsos align-content-center">Youtube : <a
                                href="https://www.youtube.com/@mktr5433" target="_blank">
                                MKTR</a>
                        </div>
                    </div>
                </div>
                <div class="mb-3 ">
                    <div class="d-flex">
                        <img class="width-8p " src="<?php echo "$nama_folder";?>/assets/images/icon/icon-fb1.png">
                        <div class="margin-l-10 text-medsos align-content-center">Facebook : <a
                                href="https://www.youtube.com/@mktr5433" target="_blank">
                                MKTR.id</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-1">&nbsp;</div>
            <div class="col-xl-8">
                <h1 class="mb-3 bold black">Kontak Kami</h1>
                <p class="mb-3">
                    Untuk informasi lebih lanjut, jangan ragu untuk menghubungi kami. Kami akan menjawab pertanyaan Anda
                    sesegera mungkin.
                </p>

                <div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Subjek </label>
                        <div class="col-sm-10">
                            <select class="form-control">
                                <option>Komunikasi Perusahaan</option>
                                <option>Sekretaris Perusahaan</option>
                                <option>Hubungan Investor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Nama Anda </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Perusahaan </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Telepon </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Email </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Pesan </label>
                        <div class="col-sm-10">
                            <textarea rows="5" class="form-control mb-3"></textarea>
                            <div class="g-recaptcha mb-3" data-sitekey="your_site_key"></div>

                            <a href="#" class="about-one__btn thm-btn">
                                Kirim Pesan
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            <hr class="mt-3 mb-5">
            </hr>

            <div class="row">
                <div class="col-lg-4 col-12 border-right mb-5">
                    <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-location1.png"
                        class="width-20p mb-3">
                    <h3 class="bold black">Lokasi</h3>
                    <div>
                        Jl. Otista Raya No.80 2, RT.2/RW.5, Bidara Cina, Kecamatan Jatinegara, Kota Jakarta Timur,
                        Daerah
                        Khusus Ibukota Jakarta 13330 (Lantai 4)
                    </div>
                </div>
                <div class="col-lg-4 col-12 border-right mb-5">
                    <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-phone1.png" class="width-20p mb-3">
                    <h3 class="bold black">No Telpon</h3>
                    <div class="mb-2">
                        021-50201035
                    </div>
                    <p>
                        senin hingga jumat (08.00 – 17.00)
                    <p>
                </div>
                <div class="col-lg-4 col-12 border-right mb-3">
                    <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-email1.png" class="width-20p mb-3">
                    <h3 class="bold black">Email</h3>
                    <div class="mb-2">
                        menthobi@info.com
                    </div>
                    <p style="line-height: 20px;">
                        Hubungi tim kami dengan mengirimkan email kepada kami
                    </p>
                </div>
            </div>
</section>

<!--  -->
<div class="w-100">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.195145315453!2d106.86622567589905!3d-6.237990661087078!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f30b108c3a6d%3A0x8d93bb199df13598!2sWisma%20Maktour!5e0!3m2!1sid!2sid!4v1750094166318!5m2!1sid!2sid"
        style="border:0; height:700px; width:100%;" allowfullscreen loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>