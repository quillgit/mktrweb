<?php
	include "configuration/path.php";
	
    $slug 		= antiinjection($_GET['slug']);
	
	$berita = mysql_query("SELECT * FROM tabel_struktur_organisasi where status = '2' AND slug = '$slug'");
	$list_berita = mysql_fetch_array($berita);
	$rowberita = mysql_num_rows($berita);

	if($rowberita > 0){

        if($list_berita['kategori'] == "dewan_komisaris"){
            $titlenya = "Dewan Komisaris";
            $linknya = "dewan_komisaris";
        }else{
            $titlenya = "Direksi";
            $linknya = "direksi";
        }
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
                        <div class="language-menu">
                            <a href="<?php echo "$nama_folder/mktr_so/$slug";?>" class="language-btn text-12 active">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en/mktr_so/$slug";?>" class="language-btn text-12 ">ENGLISH</a>
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
            <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_berita[banner]";?>" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3><?php echo "$list_berita[title]";?></h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li><a href="<?php echo "$nama_folder/struktur_organisasi";?>">Stuktur Organisasi</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li><a href="<?php echo "$nama_folder/$linknya";?>"><?php echo $titlenya;?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header End-->

    <section class="team-details">
        <div class="container">
            <div class="team-details__inner">
                <div class="row">
                    <div class="col-xl-4 col-lg-4">
                        <div class="team-details__left">
                            <div class="team-details__img">
                                <img src="<?php echo "$nama_folder";?>/images/manajemen/<?php echo "$list_berita[gambar_detail]";?>" alt="" id="team-photo">
                            </div>
                         </div>
                    </div>
                    <div class="col-xl-7 col-lg-7">
                        <div class="team-details__right mt-5">
                            <h3 class="team-details__title-1"><?php echo "$list_berita[title]";?></h3>
                            <p class="team-details__sub-title" id="team-role"><?php echo "$list_berita[sub_title]";?></p>
                            <?php echo "$list_berita[description]";?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="team-page">
        
        <div class="container">
            
            <div class="row">
                <?php
                $manajemen = mysql_query("SELECT * FROM tabel_struktur_organisasi WHERE id_struktur_organisasi != '$list_berita[id_struktur_organisasi]' AND kategori = '$list_berita[kategori]' ORDER BY urutan ASC");
                while ($list_manajemen = mysql_fetch_array($manajemen))
                {
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInLeft" data-wow-delay="100ms">
                    <div class="team-one__single">
                        <a href="<?php echo "$nama_folder/mktr_so/$list_manajemen[slug]";?>">
                            <div class="team-one__img-box">
                                <div class="team-one__img">
                                    <img src="<?php echo "$nama_folder";?>/images/manajemen/<?php echo "$list_manajemen[gambar]";?>" alt="">
                                </div>
                                <div class="team-one__content">
                                    <h3 class="team-one__title"><?php echo "$list_manajemen[title]";?></h3>
                                    <p class="team-one__sub-title"><?php echo "$list_manajemen[sub_title]";?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <?php
	}else{
		echo "<script>window.location = '$nama_folder'</script>";
	}
	?>
