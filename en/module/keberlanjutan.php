<?php
	include "configuration/path.php";

    $slug = antiinjection($_GET['slug']);

    $profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, tipe, id_berkelanjutan, kategori, child, banner, slug, banner_mobile FROM tabel_berkelanjutan WHERE slug_english = '$slug'");
    $list_profile = mysql_fetch_array($profile);
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<!--<li>-->
					<!--	<div class="language-menu">-->
					<!--		<a href="<?php echo "$nama_folder/keberlanjutan/$list_profile[slug]";?>" class="language-btn">INA</a>-->
					<!--		<a href="<?php echo "$nama_folder/en/keberlanjutan/$slug";?>" class="language-btn active">ENG</a>-->
					<!--	</div>-->
					<!--</li>-->
					
					<li>
						<div class="language-menu">
							<a href="<?php echo "$nama_folder/keberlanjutan/$list_profile[slug]";?>" class="language-btn text-12">INDONESIA</a>
							<div class="text-white set-line">|</div>
							<a href="<?php echo "$nama_folder/en/keberlanjutan/$slug";?>" class="language-btn text-12 active">ENGLISH</a>
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
            <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_profile[banner]";?>" class="d-none d-xl-block" style="width: 100%;">
            <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_profile[banner_mobile]";?>" class="d-block d-sm-none" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3><?php echo "$list_profile[sub_title_english]";?></h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder/en";?>">Home</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li><?php echo "$list_profile[sub_title_english]";?></li>
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
                        <h3 class="service-details__services-title">Sustainability</h3>
                        <ul class="service-details__services-list list-unstyled">
                        <?php
                        if($list_profile['kategori'] != 'child'){
                            $menu_keberlanjutan = mysql_query("SELECT
                                tabel_berkelanjutan.kategori, 
                                tabel_berkelanjutan.title, 
                                tabel_berkelanjutan.sub_title_english, 
                                tabel_berkelanjutan.slug, 
                                tabel_berkelanjutan.slug_english, 
                                tabel_berkelanjutan.id_berkelanjutan
                            FROM
                                tabel_berkelanjutan
                            WHERE
                                tabel_berkelanjutan.kategori != 'child'  AND status = '2'");
                            while ($list_menu_keberlanjutan = mysql_fetch_array($menu_keberlanjutan))
                            {
                                if($slug == $list_menu_keberlanjutan['slug_english']){
                                    $aktif = "class='active'";
                                }else{
                                    $aktif = "";
                                }

                                if($list_menu_keberlanjutan['kategori'] == "parent"){
                                    $span = "<span class='icon-angle-right'></span>";
                                }else{
                                    $span = "";
                                }
                            ?>
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_website/keberlanjutan/$list_menu_keberlanjutan[slug_english]";?>"><?php echo "$list_menu_keberlanjutan[sub_title_english]";?> <?php echo $span;?></a></li>
                            <?php
                             if($list_menu_keberlanjutan['id_berkelanjutan'] == $list_profile['id_berkelanjutan']){
                                 $menu_keberlanjutan_child = mysql_query("SELECT
                                     tabel_berkelanjutan.kategori, 
                                     tabel_berkelanjutan.title, 
                                     tabel_berkelanjutan.sub_title, 
                                     tabel_berkelanjutan.description, 
                                     tabel_berkelanjutan.sub_title_english, 
                                     tabel_berkelanjutan.description_english, 
                                     tabel_berkelanjutan.slug, 
                                     tabel_berkelanjutan.slug_english, 
                                     tabel_berkelanjutan.id_berkelanjutan
                                 FROM
                                     tabel_berkelanjutan
                                 WHERE
                                     tabel_berkelanjutan.child = '$list_profile[id_berkelanjutan]'  AND status = '2'");
                                 while ($list_menu_keberlanjutan_child = mysql_fetch_array($menu_keberlanjutan_child))
                                 {
                                 ?>  
                                 <li><a href="<?php echo "$nama_website/keberlanjutan/$list_menu_keberlanjutan_child[slug_english]";?>"><?php echo $list_menu_keberlanjutan_child['sub_title_english'];?></a></li>
                             <?php
                                 }
                             }
                             ?>
                            
                            <?php
                            }
                        }else{

                            $menu_keberlanjutan_parent2 = mysql_fetch_array(mysql_query("SELECT
                                     tabel_berkelanjutan.kategori, 
                                     tabel_berkelanjutan.title, 
                                     tabel_berkelanjutan.sub_title_english, 
                                     tabel_berkelanjutan.slug, 
                                     tabel_berkelanjutan.slug_english, 
                                     tabel_berkelanjutan.id_berkelanjutan
                                 FROM
                                     tabel_berkelanjutan
                                 WHERE
                                     tabel_berkelanjutan.id_berkelanjutan = '$list_profile[child]'  AND status = '2'"));
                        ?>
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_website/keberlanjutan/$menu_keberlanjutan_parent2[slug_english]";?>"><?php echo "$menu_keberlanjutan_parent2[sub_title_english]";?> <span class='icon-angle-right'></span></a></li>
                            
                        <?php
                       
                            $menu_keberlanjutan = mysql_query("SELECT
                                tabel_berkelanjutan.kategori, 
                                tabel_berkelanjutan.title, 
                                tabel_berkelanjutan.sub_title_english, 
                                tabel_berkelanjutan.slug, 
                                tabel_berkelanjutan.slug_english, 
                                tabel_berkelanjutan.id_berkelanjutan
                            FROM
                                tabel_berkelanjutan
                            WHERE
                                tabel_berkelanjutan.child = '$list_profile[child]'  AND status = '2'");
                            while ($list_menu_keberlanjutan = mysql_fetch_array($menu_keberlanjutan))
                            {
                                if($slug == $list_menu_keberlanjutan['slug_english']){
                                    $aktif = "class='active'";
                                }else{
                                    $aktif = "";
                                }

                                if($list_menu_keberlanjutan['kategori'] == "parent"){
                                    $span = "<span class='icon-angle-right'></span>";
                                }else{
                                    $span = "";
                                }
                            ?>
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_website/keberlanjutan/$list_menu_keberlanjutan[slug_english]";?>"><?php echo "$list_menu_keberlanjutan[sub_title_english]";?> <?php echo $span;?></a></li>
                            

                        <?php
                            }
                        }
                        ?>
                            
                        </ul>
                    </div>
                </div>

                
                <?php
                if($list_profile['tipe'] == "text"){
                ?>
    
                <div class="col-xl-8">
                    <div class="shop-details-page1__img">
                        <div class="shop-details-page1__img-inner mb-5">
                            <img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_profile[gambar]";?>" alt="image" id="item-main-image">
                        </div>
                        <div>
                            <div class="shop-details-page1__title">
                                <h2 id="item-title"><?php echo "$list_profile[sub_title_english]";?></h2>
                            </div>
                            <div class="shop-details-page1__text">
                                <?php echo "$list_profile[description_english]";?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                }else{

                    if($list_profile['id_berkelanjutan'] == '3'){
                ?>
                    
                        <div class="col-xl-8">
                        <div class="shop-details-page1__img">
                            <div class="shop-details-page1__img-inner mb-5">
                                <img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_profile[gambar]";?>" alt="image" id="item-main-image">
                            </div>
                            <div>
                                <div class="shop-details-page1__title">
                                    <h2 id="item-title"><?php echo "$list_profile[sub_title_english]";?></h2>
                                </div>
                                <div class="shop-details-page1__text">
                                    <?php echo "$list_profile[description_english]";?>
                                </div>
                            </div>
                        </div>
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_kebijakan, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_kebijakan WHERE status = '2'");
                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                            {
                                            ?>    
                                                <div class="row border-top border-bottom align-content-center">
                                                    <div class="col-lg-10 mt-3 mb-3 align-content-center">
                                                        <div><?php echo "$list_keanggotaan[title_english]";?></div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3 text-right">
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Download</div>
                                                            </a>
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
                            </div>
                        </section>
                    </div>

                    <?php
                    }else if($list_profile['id_berkelanjutan'] == '15'){
                    ?>

                    <div class="col-xl-8">
                        
                        <div class="shop-details-page1__img">
                            <div class="shop-details-page1__img-inner mb-5">
                                <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_profile[banner]";?>" alt="image" id="item-main-image">
                            </div>
                            <div>
                                <div class="shop-details-page1__title">
                                    <h2 id="item-title"><?php echo "$list_profile[sub_title_english]";?></h2>
                                </div>
                                <div class="shop-details-page1__text">
                                    <?php echo "$list_profile[description_english]";?>
                                </div>
                            </div>
                        </div>

                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_plan, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_plan WHERE status = '2'");
                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                            {
                                            ?>   
                                                <div class="row border-top border-bottom align-content-center">
                                                    <div class="col-lg-10 mt-3 mb-3 align-content-center">
                                                        <div><?php echo "$list_keanggotaan[title_english]";?></div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3 text-right">
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Download</div>
                                                            </a>
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
                            </div>
                        </section>
                    </div>

                    <?php
                    }else if($list_profile['id_berkelanjutan'] == '17'){
                    ?>

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                                Biodiversity Richness Assessment
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_kekayaan, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_kekayaan WHERE status = '2'");
                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                            {
                                            ?>  
                                                <div class="row border-top border-bottom align-content-center">
                                                    <div class="col-lg-10 mt-3 mb-3 align-content-center">
                                                        <div><?php echo "$list_keanggotaan[title_english]";?></div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3 text-right">
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Download</div>
                                                            </a>
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
                            </div>
                        </section>
                    </div>

                    <?php
                    }else if($list_profile['id_berkelanjutan'] == '37'){
                    ?>  

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                                Certification Announcement
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_setifikasi, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_setifikasi WHERE status = '2'");
                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                            {
                                            ?>
                                                <div class="row border-top border-bottom align-content-center">
                                                    <div class="col-lg-10 mt-3 mb-3 align-content-center">
                                                        <div><?php echo "$list_keanggotaan[title_english]";?></div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3 text-right">
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Download</div>
                                                            </a>
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
                            </div>
                        </section>
                    </div>

                    <?php
                    }else if($list_profile['id_berkelanjutan'] == '38'){
                    ?>  

                    <div class="col-xl-8">
                        
                        <div class="shop-details-page1__img">
                            <div class="shop-details-page1__img-inner mb-5">
                                <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_profile[banner]";?>" alt="image" id="item-main-image">
                            </div>
                            <div>
                                <div class="shop-details-page1__title">
                                    <h2 id="item-title"><?php echo "$list_profile[sub_title_english]";?></h2>
                                </div>
                                <div class="shop-details-page1__text">
                                    <?php echo "$list_profile[description_english]";?>
                                </div>
                            </div>
                        </div>

                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <div class="blog-details__img">
                                            <table class="table">
                                                <tr>
                                                    <td class="bold black font-20 text-left">Company</td>
                                                    <td class="bold black font-20 text-center">Year</td>
                                                    <td class="bold black font-20 text-center">RSPO Audit Report</td>
                                                </tr>

                                                <?php
                                                $keanggotaan = mysql_query("SELECT id_laporan_rspo, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_rspo WHERE status = '2'");
                                                while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                                {

                                                    $year_report=  substr($list_keanggotaan['laporan_date'],0,4);
                                                ?>

                                                <tr>
                                                    <td class="align-content-center"><?php echo "$list_keanggotaan[title_english]";?></td>
                                                    <td class="text-center align-content-center"><?php echo "$year_report";?></td>
                                                    <td>
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Download</div>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                                <?php
                                                }
                                                ?>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <?php
                    }else if($list_profile['id_berkelanjutan'] == '42'){
                    ?>  

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                            Sustainability Report
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_keberlanjutan, gambar, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_keberlanjutan WHERE status = '2'");
                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                            {
                                            ?>
                                                <div class="row border-top border-bottom align-content-center">
                                                    <div class="col-lg-10 mt-3 mb-3 align-content-center">
                                                        <div><?php echo "$list_keanggotaan[title_english]";?></div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3 text-right">
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Download</div>
                                                            </a>
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
                            </div>
                        </section>
                    </div>

                    <?php
                    }else if($list_profile['id_berkelanjutan'] == '34'){
                    ?>  

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="d-flex flex-row-reverse mb-5">
                                                        <div class="padding-10"><a href="<?php echo "$nama_folder/form_grievance";?>" class="ijo">Form  Grievance</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <h3 class="blog-details__title">List Grievance
                                                    </h3>
                                                </div>
                                            </div>

                                            <div class="blog-details__img">
                                                <div class="col-xl-12">
                                                    <div class="cart-page-one-table">

                                                        <div class="table-outer">

                                                            <table class="cart-table">
                                                                <thead class="cart-header clearfix">
                                                                    <tr>
                                                                        <th class="prod-column">Received</th>
                                                                        <th>Informant</th>
                                                                        <th>Company</th>
                                                                        <th>Subject</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $no = 1;
                                                                $banner = mysql_query("SELECT * FROM tabel_laporan_keluhan WHERE status = '2' AND status_laporan != 'laporan' ORDER BY created DESC");
                                                                while ($list = mysql_fetch_array($banner)){

                                                                    if($list['status_laporan'] == "monitoring"){
                                                                        $status = "bg-blue";
                                                                        $status_name = "Monitoring";
                                                                    }else if($list['status_laporan'] == "dropped"){
                                                                        $status = "bg-red";
                                                                        $status_name = "Dropped";
                                                                    }else if($list['status_laporan'] == "closed"){
                                                                        $status = "bg-green";
                                                                        $status_name = "Closed";
                                                                    }
                                                                ?>
                                                                    <tr class="align-center">
                                                                        <td><?php echo $list['laporan_date'];?></td>
                                                                        <td><?php echo $list['communication'];?></td>
                                                                        <td><?php echo $list['organization'];?></td>
                                                                        <td><?php echo $list['name'];?></td>
                                                                        <td>
                                                                            <div class="status"><?php echo $status_name;?></div>
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
                                            
                                            <div class="blog-details__content">
                                                <table class="table align-middle" align="center">
                                                    <thead>
                                                        <tr>
                                                            <th class="bg-grey-100" style="width: 20%;">Status</th>
                                                            <th>Description</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-25">
                                                                <span class="status w-25 status-dropped">Dropped</span>
                                                            </td>
                                                            <td> Complaints are not supported by valid evidence and information,
                                                                and/or are inaccurate in the operational area. </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="status w-25 status-onprogress">OnProgress</span>
                                                            </td>
                                                            <td>The process of verification and understanding of the
                                                                reporter/complaint deliverer and the complaint management
                                                                team/business unit/related section to the preparation of the
                                                                action plan </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <span class="status w-25 status-monitoring">Monitoring</span>
                                                            </td>
                                                            <td> Action factories have been developed and/or implementation is
                                                                underway in the field </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <span class="status w-25 status-closed">Closed</span> </td>
                                                            <td> The action plan has been fully implemented </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <script>
                        document.querySelectorAll('.status').forEach(el => {
                            const statusText = el.textContent.trim().toLowerCase();

                            switch (statusText) {
                                case 'dropped':
                                    el.classList.add('status-dropped');
                                    break;
                                case 'onprogress':
                                case 'on progress':
                                    el.classList.add('status-onprogress');
                                    break;
                                case 'monitoring':
                                    el.classList.add('status-monitoring');
                                    break;
                                case 'closed':
                                    el.classList.add('status-closed');
                                    break;
                            }
                        });
                    </script>

                <?php
                    }
                }
                ?>

            </div>

        </div>

    </section>