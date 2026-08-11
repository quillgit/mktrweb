<?php
	include "configuration/path.php";
	
	?>

        <header class="main-header">
            <div class="main-menu__top">
                <div class="main-menu__top-inner">
                    <ul class="list-unstyled main-menu__contact-list set-m10">
                        <li>
    						<div class="language-menu">
                                <a href="<?php echo "$nama_folder/berita";?>" class="language-btn active text-12">INDONESIA</a>
                                <div class="text-white set-line">|</div>
                                <a href="<?php echo "$nama_folder/en/news";?>" class="language-btn text-12">ENGLISH</a>
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
                <!--<img src="<?php echo "$nama_folder/images/post/$list_berita[gambar]";?>" alt="" style="width: 100%;">-->
                <img src="https://mktr.co.id/assets/images/backgrounds/background-min.jpg" alt="" style="width: 100%;">
            </div>
            <div class="container">
                <div class="page-header__inner">
                    <h3>Berita & Kegiatan</h3>
                    <div class="thm-breadcrumb__inner">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                            <li><span class="icon-angle-right"></span></li>
                            <li>Berita & Kegiatan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <section class="blog-page">
            <div class="container">
                <div class="row">
                    <?php
                    $dataPerPage = 9;
                    
                    if(isset($_GET['page']))
                    {
                        $noPage = $_GET['page'];
                    } 
                    else $noPage = 1;
    
                    // perhitungan offset
    
                    $offset = ($noPage - 1) * $dataPerPage;
                    
                    $berita = mysql_query("SELECT * FROM tabel_berita where status = '2' ORDER BY created DESC LIMIT $offset, $dataPerPage");
                    while ($list_berita = mysql_fetch_array($berita))
                    {
                        
                        $judul = limitWord($list_berita['title'],8);
                        $konten = limitWord($list_berita['content'],10);
                    ?>
                        <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                            <div class="blog-one__single">
                                <div class="blog-one__img-box">
                                    <div class="blog-one__img">
                                        <img src="<?php echo "$nama_folder/images/post/$list_berita[gambar]";?>" alt="<?php echo "$list_berita[title]";?>">
                                        <img src="<?php echo "$nama_folder/images/post/$list_berita[gambar]";?>" alt="<?php echo "$list_berita[title]";?>">
                                        <a href="<?php echo "$nama_folder/read/$list_berita[id_berita]/$list_berita[slug]";?>" class="blog-one__link"><span class="sr-only"></span></a>
                                    </div>
                                    <div class="blog-one__date">
                                        <p><?php echo TanggalBulan($list_berita['created']);?></p>
                                    </div>
                                </div>
                                <div class="blog-one__content">
                                    <!--
                                    <div class="blog-one__user">
                                        <p><span class="icon-user"></span>By MKTR</p>
                                    </div>
                                    -->
                                    <h3 class="blog-one__title"><a href="<?php echo "$nama_folder/read/$list_berita[id_berita]/$list_berita[slug]";?>"><?php echo "$list_berita[title]";?></a></h3>
                                    <a href="<?php echo "$nama_folder/read/$list_berita[id_berita]/$list_berita[slug]";?>" class="blog-one__learn-more">Selengkapnya<span class="icon-arrow-right"></span></a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
                
                
                <!--<div class="row flex-center text-center">-->
                <!--    <div class="col-lg-6">-->
                <!--        <nav aria-label="Page navigation example">-->
                <!--            <ul class="pagination flex-center">-->
                <!--                <li class="page-item">-->
                <!--                    <a class="page-link" href="#" aria-label="Previous">-->
                <!--                        <span aria-hidden="true">&laquo;</span>-->
                <!--                    </a>-->
                <!--                </li>-->
                <!--                <li class="page-item"><a class="page-link" href="#">1</a></li>-->
                <!--                <li class="page-item"><a class="page-link" href="#">2</a></li>-->
                <!--                <li class="page-item"><a class="page-link" href="#">3</a></li>-->
                <!--                <li class="page-item">-->
                <!--                    <a class="page-link" href="#" aria-label="Next">-->
                <!--                        <span aria-hidden="true">&raquo;</span>-->
                <!--                    </a>-->
                <!--                </li>-->
                <!--            </ul>-->
                <!--        </nav>-->
                <!--    </div>-->
                <!--</div>-->
                
                    
            </div>
        </section>

    
