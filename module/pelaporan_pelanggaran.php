<?php
	include "configuration/path.php";

    $slug = antiinjection($_GET['slug']);

    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list">
					
					<li>
						<div class="language-menu">
							<a href="<?php echo "$nama_folder/pelaporan_pelanggaran";?>" class="language-btn active">INA</a>
							<a href="<?php echo "$nama_folder/en/pelaporan_pelanggaran";?>" class="language-btn">ENG</a>
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
            <img src="<?php echo "$nama_folder";?>/images/banner/76178keterbukaan-info1.jpg" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3>Formulir Pelaporan Whistleblowing System</h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li>Formulir Pelaporan Whistleblowing System</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header End-->

    <section class="blog-one">
        <div class="container">
            <div class="row mb-5">
                <div class="col-xl-12">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12 col-lg-7">

                                <div class="blog-details__left">

                                    <div class="blog-details__img">
                                        <div class="col-xl-12">



                                            <h3 class="blog-details__title">Formulir Pelaporan Whistleblowing System</h3>
                                            <form method="POST" enctype="multipart/form-data">

                                                <div class="mb-5 text-left">
                                                    <label class="form-label text-left fw-bold">NAMA PELAPOR</label>
                                                    <input type="text" name="nama_pelapor" class="form-control p-3" placeholder="MASUKKAN NAMA PELAPOR">
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-lg-6">
                                                        <div class="mb-5 text-left">
                                                            <label class="form-label text-left fw-bold">TELPON PELAPOR
                                                                <span class="red">*</span>
                                                            </label>
                                                            <input type="number" name="telepon_pelapor" required="required" class="form-control p-3" placeholder="MASUKKAN TELPON PELAPOR">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-5 text-left">
                                                            <label class="form-label text-left fw-bold">EMAIL PELAPOR
                                                                <span class="red">*</span>
                                                            </label>
                                                            <input type="email" name="email_pelapor" required="required" class="form-control p-3" placeholder="MASUKKAN EMAIL PELAPOR">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-5 text-left">
                                                    <label class="form-label text-left fw-bold">TINDAKAN/PERBUATAN YANG DILAPORKAN</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="tindakan[]" type="checkbox" value="Fraud & Keuangan" id="checkDefault1">
                                                        <label class="form-check-label" for="checkDefault1">
                                                            Fraud & Keuangan (Korupsi, gratifikasi, penyuapan, manipulasi, penyalahgunaan dana/aset)
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="tindakan[]" type="checkbox" value="Etika & Perilaku" id="checkDefault2">
                                                        <label class="form-check-label" for="checkDefault2">
                                                            Etika & Perilaku (Pelanggaran kode etik, perilaku tidak etis, merusak nama baik)

                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="tindakan[]" type="checkbox" value="Penyalahgunaan Wewenang" id="checkDefault3">
                                                        <label class="form-check-label" for="checkDefault3">
                                                            Penyalahgunaan Wewenang (Penyalahgunaan jabatan, benturan kepentingan)

                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="tindakan[]" type="checkbox" value="Pelanggaran Hukum & Kebijakan" id="checkDefault4">
                                                        <label class="form-check-label" for="checkDefault4">
                                                            Pelanggaran Hukum & Kebijakan (Pelanggaran hukum, peraturan, atau ketentuan internal)

                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="tindakan[]" type="checkbox" value=" Keamanan & Lingkungan Kerja" id="checkDefault5">
                                                        <label class="form-check-label" for="checkDefault5">
                                                            Keamanan & Lingkungan Kerja (Kebocoran data, keselamatan kerja, lingkungan kerja)

                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="tindakan[]" type="checkbox" value="Lainnya" id="checkDefault6">
                                                        <label class="form-check-label" for="checkDefault6">
                                                            Lainnya (Jelaskan pada kolom kronologi)
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-lg-6">
                                                        <div class="mb-5 text-left">
                                                            <label class="form-label text-left fw-bold">NAMA TERLAPOR
                                                                <span class="red">*</span>
                                                            </label>
                                                            <input type="text" name="nama_terlapor" class="form-control p-3" placeholder="MASUKKAN NAMA TERLAPOR" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-5 text-left">
                                                            <label class="form-label text-left fw-bold">JABATAN TERLAPOR
                                                                <span class="red">*</span>
                                                            </label>
                                                            <input type="text" name="jabatan_terlapor" class="form-control p-3"
                                                                placeholder="MASUKKAN JABATAN TERLAPOR" required="required">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-lg-6">
                                                        <div class="mb-5 text-left">
                                                            <label class="form-label text-left fw-bold">WAKTU KEJADIAN
                                                                <span class="red">*</span>
                                                            </label>
                                                            <input type="date" name="waktu_kejadian" class="form-control p-3" id="datepicker" placeholder="MASUKKAN WAKTU KEJADIAN" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-5 text-left">
                                                            <label class="form-label text-left fw-bold">LOKASI KEJADIAN
                                                                <span class="red">*</span>
                                                            </label>
                                                            <input type="text" name="lokasi_kejadian" class="form-control p-3" placeholder="MASUKKAN LOKASI KEJADIAN" required="required">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-5 text-left">
                                                    <label class="form-label text-left fw-bold">KRONOLOGIS KEJADIAN
                                                        <span class="red">*</span>
                                                    </label>
                                                    <textarea rows="5" name="kronologis_kejadian" class="form-control p-3" placeholder="MASUKKAN KRONOLOGIS KEJADIAN"></textarea>
                                                </div>

                                                <!--
                                                <div class="mb-3 text-left">
                                                    <label class="form-label text-left fw-bold">NOMINAL</label>
                                                    <input type="number" name="nominal" class="form-control p-3" placeholder="MASUKKAN NOMINAL" required="required">
                                                </div>
-->

                                                <button class="blog-one__btn thm-btn" name="register" name="register" type="submit">Submit</button>

                                            </form>

                                            <?php
                                            if (isset($_POST['register'])) {
                                                
                                                date_default_timezone_set("Asia/Bangkok");
                                                $date = date('Y-m-d H:i:s');
                                                $dateNow = date('Y-m-d');
                                                
                                                $nama_pelapor   		= antiinjection(str_replace("'", "&#39;", $_POST['nama_pelapor']));
                                                $telepon_pelapor   	    = antiinjection(str_replace("'", "&#39;", $_POST['telepon_pelapor']));
                                                $email_pelapor 	 		= antiinjection(str_replace("'", "&#39;", $_POST['email_pelapor']));
                                                $nama_terlapor 	        = antiinjection(str_replace("'", "&#39;", $_POST['nama_terlapor']));
                                                $jabatan_terlapor 	    = antiinjection(str_replace("'", "&#39;", $_POST['jabatan_terlapor']));	

                                                $waktu_kejadian         = mysql_real_escape_string($_POST['waktu_kejadian']);

                                                $lokasi_kejadian 	    = antiinjection(str_replace("'", "&#39;", $_POST['lokasi_kejadian']));

                                                $kronologis_kejadian    = antiinjection(str_replace("'", "&#39;", $_POST['kronologis_kejadian']));

                                                $nominal 	            = "0";

                                                $tindakan               = $_POST['tindakan'];

	                                            $banyak_tindakan		= count($tindakan);

                                                if(empty($kronologis_kejadian)){

                                                    echo "<script>
                                                                    swal({
                                                                        title: 'Error !',
                                                                        text: 'Anda belum menulis Kronologis Kejadian',
                                                                        icon: 'error'
                                                                        }).then(function() {
                                                                            window.location = '$nama_folder/pelaporan_pelanggaran';
                                                                        });
                                                        </script>";

                                                }elseif($banyak_tindakan < 1){

                                                    echo "<script>
                                                                    swal({
                                                                        title: 'Error !',
                                                                        text: 'Anda belum memilih tindakan',
                                                                        icon: 'error'
                                                                        }).then(function() {
                                                                            window.location = '$nama_folder/pelaporan_pelanggaran';
                                                                        });
                                                        </script>";

                                                }else{

                                                    $add = "INSERT INTO `tabel_pelaporan_pelanggaran` (`nama_pelapor`, `telepon_pelapor`, `email_pelapor`, `nama_terlapor`, `jabatan_terlapor`, `waktu_kejadian`, `lokasi_kejadian`, `kronologis_kejadian`, `nominal`, `created`, `author`, `status`) VALUES ('$nama_pelapor', '$telepon_pelapor', '$email_pelapor', '$nama_terlapor', '$jabatan_terlapor', '$waktu_kejadian', '$lokasi_kejadian', '$kronologis_kejadian', '$nominal',  '$date', '$email_pelapor', '1')";
                                                                
                                                    $insert = mysql_query($add);
                                                    
                                                    $id_pelaporan_pelanggara = mysql_insert_id();

                                                    if($insert){
                                                        
                                                        for($i=0; $i<$banyak_tindakan; $i++){
                                                            mysql_query("INSERT INTO `trs_pelaporan_pelanggaran_tindakan` (`id_pelaporan_pelanggaran`, `tindakan`, `created`, `author`, `status`) VALUES ('$id_pelaporan_pelanggara', '$tindakan[$i]', '$date', '$email_pelapor', '1');");
                                                        }

                                                    
                                                        echo "<script>
                                                                    swal({
                                                                        title: 'Terima Kasih!',
                                                                        text: 'Kami akan Prosess Laporan Anda',
                                                                        icon: 'success'
                                                                        }).then(function() {
                                                                            window.location = '$nama_folder/pelaporan_pelanggaran';
                                                                        });
                                                        </script>";

                                                    }else{

                                                        echo "<script>
                                                                    swal({
                                                                        title: 'Error !',
                                                                        text: 'Silahkan Ulangi Kembali',
                                                                        icon: 'error'
                                                                        }).then(function() {
                                                                            window.location = '$nama_folder/pelaporan_pelanggaran';
                                                                        });
                                                        </script>";
                                                        
                                                    }

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