<?php
	include "configuration/path.php";

    include "configuration/path.php";
	
	date_default_timezone_set("Asia/Bangkok");
    $date = date('Y-m-d H:i:s');
    
    $date1 = date('Y-m-d');
	
	$slug 		= antiinjection($_GET['slug']);
	
	$search 	= preg_replace('/-/', " ", $slug);
	
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list">
					
					<li>
						<div class="language-menu">
							<a href="<?php echo "$nama_folder";?>" class="language-btn active">INA</a>
							<a href="<?php echo "$nama_folder/en";?>" class="language-btn">ENG</a>
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
            <!--<img src="<?php echo "$nama_folder";?>/assets/images/backgrounds/bg-header.png" alt="" style="width: 100%;">-->
            <img src="<?php echo "$nama_folder/";?>/assets/images/backgrounds/background-min.jpg" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3>Search : <?php echo $search;?></h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header End-->

    <section class="cart-page-one">
        <div class="container">

            <div class="table-responsive-box">
                <table class="wishlist-table">
                    <tbody>
                    <?php
                    $artikel = mysql_query("SELECT title, content, gambar, id_berita, slug, created FROM tabel_berita where status = '2' AND (title LIKE '%$search%' OR content LIKE '%$search%')");                                         
                    while ($list_berita = mysql_fetch_array($artikel))
                    {
                    ?>
                        <tr>
                            <td>
                                <div class="product-name-select-box">
                                    <div class="product-name">
                                        <h4><?php echo $list_berita['title'];?></h4>
                                        <p>Berita & Kegiatan</p>
                                    </div>
                                    <div class="product-select">
                                        <a href="<?php echo "$nama_folder/read/$list_berita[id_berita]/$list_berita[slug]";?>" class="thm-btn wishlist-page__btn"> <span></span> Selengkapnya</a>
                                    </div>
                                </div>
                            </td>
                            
                        </tr>
                    <?php
                    }
                    ?>

                    <?php
                    $keberlanjutan = mysql_query("SELECT sub_title, slug FROM tabel_berkelanjutan where description LIKE '%$search%'");                                         
                    while ($list_keberlanjutan = mysql_fetch_array($keberlanjutan))
                    {
                    ?>
                        <tr>
                            <td>
                                <div class="product-name-select-box">
                                    <div class="product-name">
                                        <h4><?php echo $list_keberlanjutan['sub_title'];?></h4>
                                        <p>Keberlanjutan</p>
                                    </div>
                                    <div class="product-select">
                                        <a href="<?php echo "$nama_folder/keberlanjutan/$list_keberlanjutan[slug]";?>" class="thm-btn wishlist-page__btn"> <span></span> Selengkapnya</a>
                                    </div>
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
    </section>