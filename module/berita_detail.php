<?php
	include "configuration/path.php";
	
    $id 		= antiinjection($_GET['id_berita']);
	
	$slug 		= antiinjection($_GET['slug']);
	
	$berita = mysql_query("SELECT * FROM tabel_berita where status = '2' AND id_berita = '$id' AND slug = '$slug'");
	
	$rowberita = mysql_num_rows($berita);
	
	if($rowberita > 0){
        $list_berita = mysql_fetch_array($berita);
	?>

        <header class="main-header">
            <div class="main-menu__top">
                <div class="main-menu__top-inner">
                    <ul class="list-unstyled main-menu__contact-list set-m10">
                        <!--<li>-->
                        <!--    <div class="language-menu">-->
                        <!--    <a href="<?php echo "$nama_folder/read/$id/$slug";?>" class="language-btn active">INA</a>-->
                        <!--    <a href="<?php echo "$nama_folder/en/read/$id/$list_berita[slug_english]";?>" class="language-btn">ENG</a>-->
                        <!--    </div>-->
                        <!--</li>-->
                        
                        <li>
    						<div class="language-menu">
                                <a href="<?php echo "$nama_folder/read/$id/$slug";?>" class="language-btn active text-12">INDONESIA</a>
                                <div class="text-white set-line">|</div>
                                <a href="<?php echo "$nama_folder/en/read/$id/$list_berita[slug_english]";?>" class="language-btn text-12">ENGLISH</a>
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
                <img src="<?php echo "$nama_folder/images/post/$list_berita[gambar]";?>" alt="" style="width: 100%;">
            </div>
            <div class="container">
                <div class="page-header__inner">
                    <h3><?php echo "$list_berita[title]";?></h3>
                    <div class="thm-breadcrumb__inner">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                            <li><span class="icon-angle-right"></span></li>
                            <li><a href="<?php echo "$nama_folder/berita";?>">Berita & Kegiatan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <!--Blog Details Start-->
        <section class="blog-details">
            <div class="container">
                <div class="row">

                    <div class="col-xl-8 col-lg-7">
                        <div class="blog-details__left">
                            <div class="blog-details__img">
                                <img src="<?php echo "$nama_folder/images/post/$list_berita[gambar]";?>" alt="">
                                <div class="blog-details__date">
                                    <p><?php echo TanggalBulan($list_berita['created']);?></p>
                                </div>
                            </div>
                            <div class="blog-details__content">

                                <h3 class="blog-details__title">
                                    <?php echo "$list_berita[title]";?>
                                </h3>
                                <?php echo "$list_berita[content]";?><br>

                                <a href="<?php echo "$list_berita[sumber_artikel]";?>" target="_blank"><p>Sumber :   <?php echo "$list_berita[sumber_artikel]";?></p></a>
                                
                                <div class="blog-details__tag-and-share">
                                   
                                    <div class="blog-details__share-box">
                                        <h3 class="blog-details__share-title">Share :</h3>
                                        <div class="blog-details__share">
                                            <a href="#"><span class="icon-facebook"></span></a>
                                            <a href="#"><span class="icon-xpa"></span></a>
                                            <a href="#">
                                                <img src="<?php echo "$nama_folder/assets/images/icon/icon-wa.png";?>" style="width:25px;">
                                            </a>
                                            <!--<a href="#"><span class="icon-whatsapp"></span></a>-->
                                            <!-- <a href="#"><span class="icon-link-in"></span></a>
                                            <a href="#"><span class="icon-instagram"></span></a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-5">
                        <div class="sidebar">
                            <div class="sidebar__single sidebar__search">
                                <form method="post" action="<?php echo "$nama_folder"; ?>/pencarian" class="sidebar__search-form">
                                    <input type="text" class="input-search" name="search" placeholder="Search here">
                                    <button type="submit"><i class="icon-search-interface-symbol"></i></button>
                                </form>
                            </div>
                            <div class="sidebar__single sidebar__post">
                                <h3 class="sidebar__title">Berita & Kegiatan Lainnya</h3>
                                <ul class="sidebar__post-list list-unstyled">
                                <?php
                                $berita_other = mysql_query("SELECT * FROM tabel_berita where status = '2' AND id_berita != '$id' ORDER BY RAND() limit 5");
                                while ($list_berita_other = mysql_fetch_array($berita_other))
                                {
                                    
                                    $judul = limitWord($list_berita_other['title'],8);
                                    $konten = limitWord($list_berita_other['content'],10);
                                ?>
                                    <li>
                                        <div class="sidebar__post-image">
                                            <img src="<?php echo "$nama_folder/images/post/$list_berita_other[gambar]";?>" alt="">
                                        </div>
                                        <div class="sidebar__post-content">
                                            <p class="sidebar__post-date"><?php echo TanggalIndo($list_berita_other['created']);?></p>
                                            <h3>
                                                <a href="<?php echo "$nama_folder/read/$list_berita_other[id_berita]/$list_berita_other[slug]";?>"><?php echo "$judul...";?></a>
                                            </h3>
                                        </div>
                                    </li>
                                <?php
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    
    <?php
	}else{
		echo "<script>window.location = '$nama_folder'</script>";
	}
	?>