<?php
	include "configuration/path.php";

    $slug = antiinjection($_GET['slug']);

    $profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, tipe, id_berkelanjutan, kategori, child, banner, slug FROM tabel_berkelanjutan WHERE id_berkelanjutan = '34'");
    $list_profile = mysql_fetch_array($profile);
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
                            <a href="<?php echo "$nama_folder/form_grievance";?>" class="language-btn text-12">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en/form_grievance";?>" class="language-btn text-12 active">ENGLISH</a>
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
            <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_profile[banner]";?>" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3>Form <?php echo "$list_profile[sub_title]";?></h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li><a href="<?php echo "$nama_folder/$list_profile[slug]";?>">Form<?php echo "$list_profile[sub_title]";?></a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li>Form Grievance</li>
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
                        <h3 class="service-details__services-title">Keberlanjutan</h3>
                        <ul class="service-details__services-list list-unstyled">

                        <?php

                            $menu_keberlanjutan_parent2 = mysql_fetch_array(mysql_query("SELECT
                                     tabel_berkelanjutan.kategori, 
                                     tabel_berkelanjutan.title, 
                                     tabel_berkelanjutan.sub_title, 
                                     tabel_berkelanjutan.slug, 
                                     tabel_berkelanjutan.slug_english, 
                                     tabel_berkelanjutan.id_berkelanjutan
                                 FROM
                                     tabel_berkelanjutan
                                 WHERE
                                     tabel_berkelanjutan.id_berkelanjutan = '$list_profile[child]'"));
                        ?>
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_folder/keberlanjutan/$menu_keberlanjutan_parent2[slug]";?>"><?php echo "$menu_keberlanjutan_parent2[sub_title]";?> <span class='icon-angle-right'></span></a></li>
                            
                        <?php
                       
                            $menu_keberlanjutan = mysql_query("SELECT
                                tabel_berkelanjutan.kategori, 
                                tabel_berkelanjutan.title, 
                                tabel_berkelanjutan.sub_title, 
                                tabel_berkelanjutan.slug, 
                                tabel_berkelanjutan.slug_english, 
                                tabel_berkelanjutan.id_berkelanjutan
                            FROM
                                tabel_berkelanjutan
                            WHERE
                                tabel_berkelanjutan.child = '$list_profile[child]'");
                            while ($list_menu_keberlanjutan = mysql_fetch_array($menu_keberlanjutan))
                            {
                                if($list_profile['slug'] == $list_menu_keberlanjutan['slug']){
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
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_folder/keberlanjutan/$list_menu_keberlanjutan[slug]";?>"><?php echo "$list_menu_keberlanjutan[sub_title]";?> <?php echo $span;?></a></li>
                            

                        <?php
                            }
                        ?>
                            
                        </ul>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12 col-lg-7">
                                <div class="blog-details__left">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="d-flex flex-row-reverse mb-5">
                                                <div class="padding-10"><a href="<?php echo "$nama_folder/keberlanjutan/daftar-pengaduan";?>" class="ijo">Grievance List</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="blog-details__img">
                                        <div class="col-xl-12">

                                            <h3 class="blog-details__title">Form Grievance</h3>
                                            <form method="POST" enctype="multipart/form-data">

                                                <div class="mb-3">
                                                    <label>Name<span class="red">*</span></label>
                                                    <input type="text" name="name" class="form-control padding-10" required="required">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Occupation/Organization<span class="red">*</span></label>
                                                    <input type="text" name="organization" class="form-control padding-10"
                                                        required="required">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Address<span class="red">*</span></label>
                                                    <textarea rows="5" name="address" type="text"
                                                        class="form-control padding-10" required="required"></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Email<span class="red">*</span></label>
                                                    <input type="email" name="email" class="form-control padding-10"
                                                        required="required">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Phone/Fax<span class="red">*</span></label>
                                                    <input type="number" name="phone" class="form-control padding-10"
                                                        required="required">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Preferred Language of Communication<span
                                                            class="red">*</span></label>
                                                    <input type="text" name="communication" class="form-control padding-10"
                                                        required="required">
                                                </div>

                                                <button class="blog-one__btn thm-btn" name="register" name="register" type="submit">Submit</button>

                                            </form>

                                            <?php
                                            if (isset($_POST['register'])) {
                                                
                                                date_default_timezone_set("Asia/Bangkok");
                                                $date = date('Y-m-d H:i:s');
                                                $dateNow = date('Y-m-d');
                                                
                                                $name   			= antiinjection(str_replace("'", "&#39;", $_POST['name']));
                                                $organization   	= antiinjection(str_replace("'", "&#39;", $_POST['organization']));
                                                $address 	 		= antiinjection(str_replace("'", "&#39;", $_POST['address']));
                                                $email 	            = antiinjection(str_replace("'", "&#39;", $_POST['email']));
                                                $phone 	            = antiinjection(str_replace("'", "&#39;", $_POST['phone']));	
                                                $communication 	    = antiinjection(str_replace("'", "&#39;", $_POST['communication']));
                                            
                                                $insert	= mysql_query("INSERT INTO tabel_laporan_keluhan (laporan_date, name, organization, address, email, phone, communication, status_laporan, created, author, status) VALUES   ('$dateNow', '$name', '$organization', '$address', '$email', '$phone', '$communication', 'laporan', '$date', '$email', '1')");

                                                if($insert){
                                                
                                                    echo "<script>
                                                                swal({
                                                                    title: 'Thank You!',
                                                                    text: 'Kami akan Prosess Laporan Anda',
                                                                    icon: 'success'
                                                                    }).then(function() {
                                                                        window.location = '$nama_folder/form_grievance';
                                                                    });
                                                    </script>";

                                                }else{

                                                    echo "<script>
                                                                swal({
                                                                    title: 'Error !',
                                                                    text: 'Silahkan Ulangi Kembali',
                                                                    icon: 'error'
                                                                    }).then(function() {
                                                                        window.location = '$nama_folder/form_grievance';
                                                                    });
                                                    </script>";
                                                    
                                                }
                                                            
                                                            
                                            }
                                            ?>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>