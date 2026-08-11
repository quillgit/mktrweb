<?php
    session_start(); //untuk memulai session
	include "parser-php-version.php"; //Konversi dan migrasi PHP version
	include "configuration/connection.php"; 
	include "configuration/function.php";
    include "configuration/path.php";
?>

	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <!-- SEO -->
        <?php
    	if (empty($_GET['sct'])){
    	?>
    	
        <title>PT MENTHOBI KARYATAMA RAYA Tbk</title>
    
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur.">
        <meta property="og:description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur."/>
        <meta name="keywords" content="PT. Menthobi Karyatama Raya Tbk, MKTR, Maktour Group" itemprop="keywords">
    
        <meta property="og:image" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>" itemprop="thumbnailUrl" />
    	
    	<meta name="robots" content="index, follow">
    	
    	<?php
    	}else if ($_GET['sct']=='profil_kami'){
    
		$profile = mysql_query("SELECT sub_title, sub_title_english, gambar FROM tabel_about_us WHERE id_about_us = '1'");
		$list_profile = mysql_fetch_array($profile);

        $news_judul = $list_profile['sub_title_english'];
        $deskripsionon = $artikel_detail_seo['description'];
        $keywordd = $artikel_detail_seo['sub_title'];
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/profil_kami"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur.">
        <meta property="og:description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur."/>
        <meta name="keywords" content="PT. Menthobi Karyatama Raya Tbk, MKTR, Maktour Group" itemprop="keywords">
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='logo_kami'){
    
		$profile = mysql_query("SELECT sub_title, sub_title_english, gambar FROM tabel_about_us WHERE id_about_us = '2'");
		$list_profile = mysql_fetch_array($profile);

        $news_judul = $list_profile['sub_title_english'];
        $deskripsionon = $artikel_detail_seo['description'];
        $keywordd = $artikel_detail_seo['sub_title'];
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/logo_kami"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur.">
        <meta property="og:description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur."/>
        <meta name="keywords" content="PT. Menthobi Karyatama Raya Tbk, MKTR, Maktour Group" itemprop="keywords">
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='visi_misi'){
    
		$profile = mysql_query("SELECT sub_title, sub_title_english, gambar FROM tabel_about_us WHERE id_about_us = '3'");
		$list_profile = mysql_fetch_array($profile);

        $news_judul = $list_profile['sub_title_english'];
        $deskripsionon = $artikel_detail_seo['description'];
        $keywordd = $artikel_detail_seo['sub_title'];
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/visi_misi"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="Membangun Agrobisnis dengan Inovasi Best Practice Agronomi yang berkelanjutan serta ramah lingkungan untuk menghasilkan Nilai Tambah Optimal kepada seluruh pemangku kepentingan.">
        <meta property="og:description" content="Membangun Agrobisnis dengan Inovasi Best Practice Agronomi yang berkelanjutan serta ramah lingkungan untuk menghasilkan Nilai Tambah Optimal kepada seluruh pemangku kepentingan."/>
        <meta name="keywords" content="PT. Menthobi Karyatama Raya Tbk, MKTR, Maktour Group" itemprop="keywords">
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='peristiwa_penting'){
    
    	?>	
    	
    	<title>Milestones - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="Milestones"/>
    	<meta property="og:url" content="<?php echo "$nama_website/peristiwa_penting"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur.">
        <meta property="og:description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur."/>
        <meta name="keywords" content="PT. Menthobi Karyatama Raya Tbk, MKTR, Maktour Group" itemprop="keywords">
    
        <meta property="og:image" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>" itemprop="thumbnailUrl" />
    	
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='struktur_kepemilikan'){
    
		$profile = mysql_query("SELECT sub_title, sub_title_english, gambar FROM tabel_about_us WHERE id_about_us = '4'");
		$list_profile = mysql_fetch_array($profile);

        $news_judul = $list_profile['sub_title_english'];
        $deskripsionon = $artikel_detail_seo['description'];
        $keywordd = $artikel_detail_seo['sub_title_english'];
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/struktur_kepemilikan"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="Setiap anggota Dewan Komisaris dan Direksi wajib untuk melaporkan kepada Sekretaris Perusahaan Perseroan tentang kepemilikan dan setiap perubahan kepemilikan saham Perseroan selambat-lambatnya 3 (tiga) hari kerja setelah kepemilikan atau setiap perubahan kepemilikan saham Perseroan untuk dilaporkan ke OJK dan BEI">
        <meta property="og:description" content="Setiap anggota Dewan Komisaris dan Direksi wajib untuk melaporkan kepada Sekretaris Perusahaan Perseroan tentang kepemilikan dan setiap perubahan kepemilikan saham Perseroan selambat-lambatnya 3 (tiga) hari kerja setelah kepemilikan atau setiap perubahan kepemilikan saham Perseroan untuk dilaporkan ke OJK dan BEI"/>
        <meta name="keywords" content="PT. Menthobi Karyatama Raya Tbk, MKTR, Maktour Group" itemprop="keywords">
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='struktur_organisasi'){
    
		$profile = mysql_query("SELECT sub_title, sub_title_english, gambar FROM tabel_about_us WHERE id_about_us = '6'");
		$list_profile = mysql_fetch_array($profile);

        $news_judul = $list_profile['sub_title_english'];
        $deskripsionon = $artikel_detail_seo['description'];
        $keywordd = $artikel_detail_seo['sub_title_english'];
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/struktur_organisasi"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="Setiap anggota Dewan Komisaris dan Direksi wajib untuk melaporkan kepada Sekretaris Perusahaan Perseroan tentang kepemilikan dan setiap perubahan kepemilikan saham Perseroan selambat-lambatnya 3 (tiga) hari kerja setelah kepemilikan atau setiap perubahan kepemilikan saham Perseroan untuk dilaporkan ke OJK dan BEI">
        <meta property="og:description" content="Setiap anggota Dewan Komisaris dan Direksi wajib untuk melaporkan kepada Sekretaris Perusahaan Perseroan tentang kepemilikan dan setiap perubahan kepemilikan saham Perseroan selambat-lambatnya 3 (tiga) hari kerja setelah kepemilikan atau setiap perubahan kepemilikan saham Perseroan untuk dilaporkan ke OJK dan BEI"/>
        <meta name="keywords" content="PT. Menthobi Karyatama Raya Tbk, MKTR, Maktour Group" itemprop="keywords">
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='struktur_group'){
    
		$profile = mysql_query("SELECT sub_title, sub_title_english, gambar FROM tabel_about_us WHERE id_about_us = '5'");
		$list_profile = mysql_fetch_array($profile);

        $news_judul = $list_profile['sub_title_english'];
        $deskripsionon = $artikel_detail_seo['description'];
        $keywordd = $artikel_detail_seo['sub_title_english'];
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/struktur_organisasi"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="Setiap anggota Dewan Komisaris dan Direksi wajib untuk melaporkan kepada Sekretaris Perusahaan Perseroan tentang kepemilikan dan setiap perubahan kepemilikan saham Perseroan selambat-lambatnya 3 (tiga) hari kerja setelah kepemilikan atau setiap perubahan kepemilikan saham Perseroan untuk dilaporkan ke OJK dan BEI">
        <meta property="og:description" content="Setiap anggota Dewan Komisaris dan Direksi wajib untuk melaporkan kepada Sekretaris Perusahaan Perseroan tentang kepemilikan dan setiap perubahan kepemilikan saham Perseroan selambat-lambatnya 3 (tiga) hari kerja setelah kepemilikan atau setiap perubahan kepemilikan saham Perseroan untuk dilaporkan ke OJK dan BEI"/>
        <meta name="keywords" content="PT. Menthobi Karyatama Raya Tbk, MKTR, Maktour Group" itemprop="keywords">
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/about/$list_profile[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='dewan_komisaris'){
    
    	?>	
    	
    	<title>Board of Commissioners - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="Board of Commissioners"/>
    	<meta property="og:url" content="<?php echo "$nama_website/dewan_komisaris"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur.">
        <meta property="og:description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur."/>
        <meta name="keywords" content="PT. Menthobi Karyatama Raya Tbk, MKTR, Maktour Group" itemprop="keywords">
    
        <meta property="og:image" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>" itemprop="thumbnailUrl" />
    	
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='direksi'){
    
    	?>	
    	
    	<title>Board of Directors - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="Board of Directors"/>
    	<meta property="og:url" content="<?php echo "$nama_website/direksi"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur.">
        <meta property="og:description" content="PT. Menthobi Karyatama Raya Tbk ( MKTR ) merupakan perusahaan perkebunan yang berpusat di Jakarta. MKTR adalah bagian dari Maktour Group, perusahaan biro haji dan umroh terkemuka di Indonesia yang dipimpin oleh Fuad Hasan Masyhur."/>
        <meta name="keywords" content="PT. Menthobi Karyatama Raya Tbk, MKTR, Maktour Group" itemprop="keywords">
    
        <meta property="og:image" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>" itemprop="thumbnailUrl" />
    	
    	<meta name="robots" content="index, follow">

		
        <?php
    	}else if ($_GET['sct']=='mktr_so'){
        
        $slug_seo 	= $_GET['slug'];
    
        $artikel_detail_seo = mysql_fetch_array(mysql_query("SELECT * FROM tabel_struktur_organisasi where status = '2' AND slug = '$slug_seo'"));
    
        $news_judul = $artikel_detail_seo['title'];
        $deskripsionon = $artikel_detail_seo['description'];
        $keywordd = $artikel_detail_seo['sub_title_english'];
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/mktr_so/$slug_seo"; ?>"/>
    	   
        <meta content="<?php echo "$news_judul, $keywordd"; ?>" itemprop="headline"/>
        <meta name="keywords" content="<?php echo "$keywordd, $news_judul, PT. Menthobi Karyatama Raya Tbk (MKTR)"; ?>" itemprop="keywords"/>
        
        <meta name="description" content="<?php echo "$deskripsionon"; ?>" itemprop="description"/>
    	<meta property="og:description" content="<?php echo "$deskripsionon"; ?>"/>
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/manajemen/$artikel_detail_seo[gambar_detail]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/manajemen/$artikel_detail_seo[gambar_detail]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/manajemen/$artikel_detail_seo[gambar_detail]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/manajemen/$artikel_detail_seo[gambar_detail]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='anak_perusahaan_kami'){
    
    	?>	
    	
    	<title>Our Subsidiaries - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="Our Subsidiaries - PT. Menthobi Karyatama Raya Tbk (MKTR) "/>
    	<meta property="og:url" content="<?php echo "$nama_website/anak_perusahaan_kami"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="PT. Menthobi Agro Raya, PT. Menthobi Transitian Raya, PT Menthobi Makmur Lestari, PT. Menthobi Hijau Lestari">
        <meta property="og:description" content="PT. Menthobi Agro Raya, PT. Menthobi Transitian Raya, PT Menthobi Makmur Lestari, PT. Menthobi Hijau Lestar"/>
        <meta name="keywords" content="PT. Menthobi Agro Raya, PT. Menthobi Transitian Raya, PT Menthobi Makmur Lestari, PT. Menthobi Hijau Lestari" itemprop="keywords">
    
        <meta property="og:image" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>" itemprop="thumbnailUrl" />
    	
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='penghargaan'){
    
    	?>	
    	
    	<title>Awards & Recognition - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="Awards & Recognition - PT. Menthobi Karyatama Raya Tbk (MKTR) "/>
    	<meta property="og:url" content="<?php echo "$nama_website/anak_perusahaan_kami"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="Awards & Recognition PROPER EMAS 2024 &GREEN LEADERSHIP UTAMA, TrenAsia ESG Award - Agribusiness Sustainability">
        <meta property="og:description" content="Awards & Recognition PROPER EMAS 2024 &GREEN LEADERSHIP UTAMA, TrenAsia ESG Award - Agribusiness Sustainability"/>
        <meta name="keywords" content="Awards & Recognition MKTR, PROPER EMAS 2024 &GREEN LEADERSHIP UTAMA, TrenAsia ESG Award - Agribusiness Sustainability" itemprop="keywords">
    
        <meta property="og:image" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>" itemprop="thumbnailUrl" />
    	
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='keanggotaan'){
    
    	?>	
    	
    	<title>Membership - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="Membership - PT. Menthobi Karyatama Raya Tbk (MKTR) "/>
    	<meta property="og:url" content="<?php echo "$nama_website/keanggotaan"; ?>"/>
    	   
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
        <meta name="description" content="PT. Menthobi Karyatama Raya Tbk (MKTR) Membership : Gabungan Pengusaha Kelapa Sawit Indonesia (GAPKI), Kamar Dagang dan Industri Indonesia (KADIN), Indonesia Corporate Secretary Association (ICSA)">
        <meta property="og:description" content="PT. Menthobi Karyatama Raya Tbk (MKTR) Membership : Gabungan Pengusaha Kelapa Sawit Indonesia (GAPKI), Kamar Dagang dan Industri Indonesia (KADIN), Indonesia Corporate Secretary Association (ICSA)"/>
        <meta name="keywords" content="Gabungan Pengusaha Kelapa Sawit Indonesia (GAPKI), Kamar Dagang dan Industri Indonesia (KADIN), Indonesia Corporate Secretary Association (ICSA)" itemprop="keywords">
    
        <meta property="og:image" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>" itemprop="thumbnailUrl" />
    	
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='bisnis_inti'){
        
        $slug_seo 	= $_GET['slug'];
    
        $artikel_detail_seo = mysql_fetch_array(mysql_query("SELECT title, sub_title, sub_title_english, gambar FROM tabel_bisnis_inti WHERE slug_english = '$slug_seo'"));
    
        $news_judul = $artikel_detail_seo['sub_title_english'];
        $deskripsionon = "PT Menthobi Karyatama Raya Tbk memiliki bisnis inti : Sawit, Logistik & Alat Berat, Konsultan Agri Binsnis, Pengelolaan Limbah";
        $keywordd = "Sawit, Logistik & Alat Berat, Konsultan Agri Binsnis, Pengelolaan Limbah";
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/bisnis/$slug_seo"; ?>"/>
    	   
        <meta content="<?php echo "$news_judul, $deskripsionon"; ?>" itemprop="headline"/>
        <meta name="keywords" content="<?php echo "$keywordd"; ?>" itemprop="keywords"/>
        
        <meta name="description" content="<?php echo "$deskripsionon"; ?>" itemprop="description"/>
    	<meta property="og:description" content="<?php echo "$deskripsionon"; ?>"/>
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='keberlanjutan'){
        
        $slug_seo 	= $_GET['slug'];
    
        $artikel_detail_seo = mysql_fetch_array(mysql_query("SELECT title, sub_title, sub_title_english, description_english, description, gambar FROM tabel_berkelanjutan WHERE slug_english = '$slug_seo'"));
    
        $news_judul = $artikel_detail_seo['sub_title_english'];
		$deskripsionon1 = limitWord($artikel_detail_seo['description'],50);
		$deskripsionon = strip_tags($deskripsionon1);
        $keywordd = "$news_judul PT. Menthobi Karyatama Raya Tbk (MKTR)";
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/keberlanjutan/$slug_seo"; ?>"/>
    	   
        <meta content="<?php echo "$news_judul, $deskripsionon ..."; ?>" itemprop="headline"/>
        <meta name="keywords" content="<?php echo "$keywordd"; ?>" itemprop="keywords"/>
        
        <meta name="description" content="<?php echo "$deskripsionon"; ?>" itemprop="description"/>
    	<meta property="og:description" content="<?php echo "$deskripsionon"; ?>"/>
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='tatakelola_perusahaan'){
        
        $slug_seo 	= $_GET['slug'];
    
        $artikel_detail_seo = mysql_fetch_array(mysql_query("SELECT title, sub_title, sub_title_english, description_english, description, gambar FROM tabel_tatakelola_perusahaan WHERE slug_english = '$slug_seo'"));
    
        $news_judul = $artikel_detail_seo['sub_title_english'];
		$deskripsionon1 = limitWord($artikel_detail_seo['description_english'],50);
		$deskripsionon = strip_tags($deskripsionon1);
        $keywordd = "$news_judul PT. Menthobi Karyatama Raya Tbk (MKTR)";
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/tatakelola_perusahaan/$slug_seo"; ?>"/>
    	   
        <meta content="<?php echo "$news_judul, $deskripsionon ..."; ?>" itemprop="headline"/>
        <meta name="keywords" content="<?php echo "$keywordd"; ?>" itemprop="keywords"/>
        
        <meta name="description" content="<?php echo "$deskripsionon"; ?>" itemprop="description"/>
    	<meta property="og:description" content="<?php echo "$deskripsionon"; ?>"/>
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='hubungan_investor'){
        
        $slug_seo 	= $_GET['slug'];
    
        $artikel_detail_seo = mysql_fetch_array(mysql_query("SELECT title, sub_title, sub_title_english, description_english, description, gambar FROM tabel_tentang_kami WHERE slug_english = '$slug_seo'"));
    
        $news_judul = $artikel_detail_seo['sub_title_english'];
		$deskripsionon1 = limitWord($artikel_detail_seo['description_english'],50);
		$deskripsionon = strip_tags($deskripsionon1);
        $keywordd = "$news_judul PT. Menthobi Karyatama Raya Tbk (MKTR)";
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/hubungan_investor/$slug_seo"; ?>"/>
    	   
        <meta content="<?php echo "$news_judul, $deskripsionon ..."; ?>" itemprop="headline"/>
        <meta name="keywords" content="<?php echo "$keywordd"; ?>" itemprop="keywords"/>
        
        <meta name="description" content="<?php echo "$deskripsionon"; ?>" itemprop="description"/>
    	<meta property="og:description" content="<?php echo "$deskripsionon"; ?>"/>
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/about/$artikel_detail_seo[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">

		<?php
    	}else if ($_GET['sct']=='sdm'){
        
        $slug_seo 	= $_GET['slug'];
    
        $artikel_detail_seo = mysql_fetch_array(mysql_query("SELECT title, sub_title, sub_title_english, description_english, description FROM tabel_sumber_daya WHERE slug_english = '$slug_seo'"));
    
        $news_judul = $artikel_detail_seo['sub_title_english'];
		$deskripsionon1 = limitWord($artikel_detail_seo['description_english'],50);
		$deskripsionon = strip_tags($deskripsionon1);
        $keywordd = "$news_judul PT. Menthobi Karyatama Raya Tbk (MKTR)";
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/sdm/$slug_seo"; ?>"/>
    	   
        <meta content="<?php echo "$news_judul, $deskripsionon ..."; ?>" itemprop="headline"/>
        <meta name="keywords" content="<?php echo "$keywordd"; ?>" itemprop="keywords"/>
        
        <meta name="description" content="<?php echo "$deskripsionon"; ?>" itemprop="description"/>
    	<meta property="og:description" content="<?php echo "$deskripsionon"; ?>"/>
        
    	<meta property="og:image" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/assets/images/resources/3d MKTR.png"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">
    	
    	<?php
    	}else if ($_GET['sct']=='berita_detail'){
        
        $id_seo 	= $_GET['id_berita'];
            
        $slug_seo 	= $_GET['slug'];
    
        $artikel_detail_seo = mysql_fetch_array(mysql_query("SELECT title_english, meta_keyword, meta_description, gambar FROM tabel_berita where id_berita = '$id_seo' AND slug_english = '$slug_seo'"));
    
        $news_judul = $artikel_detail_seo['title_english'];
        $deskripsionon = $artikel_detail_seo['meta_description'];
        $keywordd = $artikel_detail_seo['meta_keyword'];
    
    	?>	
    	
    	<title><?php echo "$news_judul"; ?> - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="companyprofile "/>
    	<meta property="og:site_name" content="mktr.co.id"/>
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>"/>
    	<meta property="og:url" content="<?php echo "$nama_website/read/$id_seo/$slug_seo"; ?>"/>
    	   
        <meta content="<?php echo "$news_judul, $deskripsionon"; ?>" itemprop="headline"/>
        <meta name="keywords" content="<?php echo "$keywordd"; ?>" itemprop="keywords"/>
        
        <meta name="description" content="<?php echo "$deskripsionon"; ?>" itemprop="description"/>
    	<meta property="og:description" content="<?php echo "$deskripsionon"; ?>"/>
        
    	<meta property="og:image" content="<?php echo "$nama_folder/images/post/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/post/$artikel_detail_seo[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/post/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/post/$artikel_detail_seo[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">
    		
    	<?php
        }else if ($_GET['sct']=='berita'){

		$artikel_detail_seo = mysql_fetch_array(mysql_query("SELECT title, meta_keyword, meta_description, gambar FROM tabel_berita ORDER BY  RAND() limit 1"));
    
		$news_judul = "News & Activities";
        $deskripsionon = "News & Activities - PT. Menthobi Karyatama Raya Tbk (MKTR)";
        $keywordd = "Berita Sawit, Berita Logistik dan Alat Berat, Berita MKTR, Berita Maktour";
        ?>
    
        <title>News & Activities - PT. Menthobi Karyatama Raya Tbk (MKTR) </title>
        <meta name="author" content="PT. Menthobi Karyatama Raya Tbk (MKTR) ">
    	
    	<meta property="og:type" content="artikel "/>
    	<meta property="og:site_name" content="mktr.co.id" />
    	<meta property="og:title" content="<?php echo "$news_judul"; ?>" />
    	   
        <meta content="<?php echo "$deskripsionon"; ?>" itemprop="headline" />
        <meta name="keywords" content="<?php echo "$keywordd"; ?>" itemprop="keywords" />
        
        <meta name="description" content="<?php echo "$deskripsionon"; ?>" itemprop="description" />
        <meta property="og:description" content="<?php echo "$deskripsionon"; ?>" />

		<meta property="og:image" content="<?php echo "$nama_folder/images/post/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta property="og:image:url"  content="<?php echo "$nama_folder/images/post/$artikel_detail_seo[gambar]"; ?>"/>
        <meta property="og:image:secure_url" content="<?php echo "$nama_folder/images/post/$artikel_detail_seo[gambar]"; ?>"/>
    	<meta name="thumbnailUrl" content="<?php echo "$nama_folder/images/post/$artikel_detail_seo[gambar]"; ?>" itemprop="thumbnailUrl" />
    	<meta name="robots" content="index, follow">
        
        <?php
        }
        ?>
        
        <link rel="shortcut icon" href="<?php echo "$nama_folder";?>/assets/images/resources/3d MKTR.png" width="30px"
        height="30px">

        <!-- fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&amp;display=swap" rel="stylesheet">


        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/animate.min.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/custom-animate.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/swiper.min.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/font-awesome-all.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/jarallax.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/jquery.magnific-popup.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/odometer.min.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/flaticon.css">
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/owl.carousel.min.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/owl.theme.default.min.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/nice-select.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/jquery-ui.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/twentytwenty.css" />


        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/slider.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/footer.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/service.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/about.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/testimonial.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/brand.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/shop.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/video.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/counter.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/project.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/pricing.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/blog.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/cta.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/contact.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/team.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/faq.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/page-header.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/error-page.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/process.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/module-css/skill.css" />

        <!-- template styles -->
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/style.css" />
        <link rel="stylesheet" href="<?php echo "$nama_folder";?>/assets/css/responsive.css" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
		<script src="<?php echo "$nama_folder";?>/assets/js/sweetalert.min.js"></script>
		
		<!-- recaptcha google  -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
		
		<!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-MRS8P2VRNC"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-MRS8P2VRNC');
        </script>
        
	</head>
	
	<body>
  
	<body>

		<div class="preloader">
			<div class="preloader__image"></div>
		</div>
		<!-- /.preloader -->

		<div class="page-wrapper">
			
			<?php
			konten();
			?>
			
			
			<a href="<?php echo "$nama_folder/keberlanjutan/daftar-pengaduan";?>">
        		<img src="<?php echo "$nama_folder";?>/assets/images/resources/toa1a.png" class="posisi-bicara">
        	</a>

			<!--Site Footer Start-->
			<footer class="site-footer">
				<div class="site-footer__shape-1 float-bob-x">
				</div>
				<!--
				<div class="container">
					<div class="site-footer__top">
						<div class="row">
							<div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
								<div class="footer-widget__column footer-widget__usefull-link">
									<div class="footer-widget__title-box">
										<h3 class="footer-widget__title">About Us</h3>
									</div>
									<div class="footer-widget__link-box">
										<ul class="footer-widget__link list-unstyled">
											<li><a href="<?php echo "$nama_website/profil_kami";?>">About Us</a></li>
											<li><a href="<?php echo "$nama_website/logo_kami";?>">Our Logo</a></li>
											<li><a href="<?php echo "$nama_website/visi_misi";?>">Vision, Mission and Values</a></li>
											<li><a href="<?php echo "$nama_website/peristiwa_penting";?>">Milestones</a></li>
											<li><a href="<?php echo "$nama_website/struktur_kepemilikan";?>">Ownership Structure</a></li>
											<li><a href="<?php echo "$nama_website/struktur_organisasi";?>">Organization Structure</a></li>
											<li><a href="<?php echo "$nama_website/dewan_komisaris";?>">Board of Commissioners</a></li>
											<li><a href="<?php echo "$nama_website/direksi";?>">Board of Directors</a></li>
											<li><a href="<?php echo "$nama_website/struktur_group";?>">Group Structure</a></li>
											<li><a href="<?php echo "$nama_website/anak_perusahaan_kami";?>">Our Subsidiaries</a></li>
											<li><a href="<?php echo "$nama_website/penghargaan";?>">Awards & Recognition</a></li>
											<li><a href="<?php echo "$nama_website/keanggotaan";?>">Membership</a></li>
										</ul>
									</div>
								</div>
								<div class="footer-widget__column footer-widget__usefull-link mt-5">
									<div class="footer-widget__title-box">
										<h3 class="footer-widget__title">Investor Relations</h3>
									</div>
									<div class="footer-widget__link-box">
										<ul class="footer-widget__link list-unstyled">
										<?php
                                        $menu_hi_footer = mysql_query("SELECT
                                        tabel_tentang_kami.kategori, 
                                        tabel_tentang_kami.title, 
                                        tabel_tentang_kami.sub_title, 
                                        tabel_tentang_kami.child,
                                        tabel_tentang_kami.description, 
                                        tabel_tentang_kami.sub_title_english, 
                                        tabel_tentang_kami.description_english, 
                                        tabel_tentang_kami.slug, 
                                        tabel_tentang_kami.slug_english, 
                                        tabel_tentang_kami.id_tentang_kami
                                        FROM
                                        tabel_tentang_kami
                                        WHERE
                                        tabel_tentang_kami.kategori != 'child' AND status = '2'");
                                        while ($list_menu_hi_footer = mysql_fetch_array($menu_hi_footer))
                                        {
                                        ?> 
											<li><a href="<?php echo "$nama_website/hubungan_investor/$list_menu_hi_footer[slug_english]";?>"><?php echo $list_menu_hi_footer['sub_title_english'];?></a></li>
										<?php
										}
										?>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
								<div class="footer-widget__column footer-widget__services">
									<div class="footer-widget__title-box">
										<h3 class="footer-widget__title">Core Business</h3>
									</div>
									<ul class="footer-widget__link list-unstyled">
										<?php
                                        $menu_footer_bisnis_int = mysql_query("SELECT id_bisnis_inti, sub_title_english, sub_title, slug, slug_english FROM tabel_bisnis_inti");
                                        while ($list_footer_menu_bisnis_int = mysql_fetch_array($menu_footer_bisnis_int))
                                        {
                                        ?>
                                        <li><a href="<?php echo "$nama_website/bisnis/$list_footer_menu_bisnis_int[slug_english]";?>"><?php echo $list_footer_menu_bisnis_int['sub_title_english'];?></a></li>
                                        <?php
                                        }
                                        ?>
									</ul>
								</div>
								<div class="footer-widget__column footer-widget__services mt-5">
									<div class="footer-widget__title-box">
										<h3 class="footer-widget__title">Human Resources</h3>
									</div>
									<ul class="footer-widget__link list-unstyled">
										<?php
                                        $menu_sdm_footer = mysql_query("SELECT
											tabel_sumber_daya.kategori, 
											tabel_sumber_daya.sub_title, 
											tabel_sumber_daya.child,
											tabel_sumber_daya.sub_title_english, 
											tabel_sumber_daya.slug, 
											tabel_sumber_daya.slug_english, 
											tabel_sumber_daya.id_sumber_daya
										FROM
											tabel_sumber_daya 
										WHERE status = '2'");
										while ($list_menu_sdm_footer = mysql_fetch_array($menu_sdm_footer))
										{
                                        ?> 
											<li><a href="<?php echo "$nama_website/sdm/$list_menu_sdm_footer[slug_english]";?>"><?php echo $list_menu_sdm_footer['sub_title_english'];?></a></li>
										<?php
										}
										?>
									</ul>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp " data-wow-delay="400ms">
								<div class="footer-widget__column footer-widget__contact">
									<div class="footer-widget__title-box">
										<h3 class="footer-widget__title">Sustainability</h3>
									</div>
									<ul class="footer-widget__link list-unstyled mb-3">
										<?php
                                        $menu_keberlanjutan_footer = mysql_query("SELECT
											tabel_berkelanjutan.kategori, 
											tabel_berkelanjutan.title, 
											tabel_berkelanjutan.sub_title, 
											tabel_berkelanjutan.child,
											tabel_berkelanjutan.sub_title_english, 
											tabel_berkelanjutan.slug, 
											tabel_berkelanjutan.slug_english, 
											tabel_berkelanjutan.id_berkelanjutan
										FROM
											tabel_berkelanjutan
										WHERE
											tabel_berkelanjutan.kategori != 'child' AND status = '2'");
										while ($list_menu_keberlanjutan_footer = mysql_fetch_array($menu_keberlanjutan_footer))
										{
                                        ?> 
										<li><a href="<?php echo "$nama_website/keberlanjutan/$list_menu_keberlanjutan_footer[slug_english]";?>"><?php echo $list_menu_keberlanjutan_footer['sub_title_english'];?></a></li>
										<?php
										}
										?>
									</ul>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
								<div class="footer-widget__column footer-widget__contact mt-1m">
									<div class="footer-widget__title-box">
										<h3 class="footer-widget__title">Corporate governance</h3>
									</div>
									<ul class="footer-widget__link list-unstyled">
										<?php
                                        $menu_keberlanjutan1_footer = mysql_query("SELECT
                                            tabel_tatakelola_perusahaan.kategori, 
                                            tabel_tatakelola_perusahaan.title, 
                                            tabel_tatakelola_perusahaan.sub_title, 
                                            tabel_tatakelola_perusahaan.child,
                                            tabel_tatakelola_perusahaan.description, 
                                            tabel_tatakelola_perusahaan.sub_title_english, 
                                            tabel_tatakelola_perusahaan.description_english, 
                                            tabel_tatakelola_perusahaan.slug, 
                                            tabel_tatakelola_perusahaan.slug_english, 
                                            tabel_tatakelola_perusahaan.id_tatakelola_perusahaan
                                        FROM
                                            tabel_tatakelola_perusahaan
                                        WHERE
                                            tabel_tatakelola_perusahaan.kategori != 'child' AND status = '2'");
                                        while ($list_menu_keberlanjutan1_footer = mysql_fetch_array($menu_keberlanjutan1_footer))
                                        {
                                        ?> 
										<li><a href="<?php echo "$nama_website/tatakelola_perusahaan/$list_menu_keberlanjutan1_footer[slug_english]";?>"><?php echo $list_menu_keberlanjutan1_footer['sub_title_english'];?></a></li>
										<?php
										}
										?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				-->
				<div class="site-footer__bottom">
					<div class="container">
						<!--<div class="site-footer__bottom-inner">-->
						<!--	<div class="site-footer__social">-->
						<!--		<a href="https://m.facebook.com/p/PT-Menthobi-Karyatama-Raya-Tbk-100081064625604" target="_blank"><i class="icon-facebook"></i></a>-->
						<!--		<a href="https://instagram.com/mktr.id?igshid=MzRlODBiNWFlZA==" target="_blank"><i class="icon-instagram"></i></a>-->
						<!--		<a href="https://www.linkedin.com/company/pt-menthobi-karyatama-raya/" target="_blank"><i class="icon-link-in"></i></a>-->
						<!--		<a href="https://www.youtube.com/@mktr5433" target="_blank"><i class="fab fa-youtube"></i></a>-->
						<!--	</div>-->
						<!--	<p class="site-footer__bottom-text">Copyright 2025. All rights reserved</p>-->
						<!--</div>-->
						
						<div class="site-footer__bottom-inner">
                            <div class="main-menu__top-right">
                                <div class="site-footer__social">
                                    <a href="https://m.facebook.com/p/PT-Menthobi-Karyatama-Raya-Tbk-100081064625604"
                                        target="_blank"><i class="icon-facebook"></i></a>
                                    <a href="https://instagram.com/mktr.id?igshid=MzRlODBiNWFlZA==" target="_blank"><i
                                            class="icon-instagram"></i></a>
                                    <a href="https://www.linkedin.com/company/pt-menthobi-karyatama-raya/"
                                        target="_blank"><i class="icon-link-in"></i></a>
                                    <a href="https://www.youtube.com/@mktr5433" target="_blank"><i
                                            class="fab fa-youtube"></i></a>
                                </div>
                                <div class="set-m20">
                                    <a href="<?php echo "$nama_folder/pelaporan_pelanggaran"; ?>" class="text-white">Whistleblowing System</a>
                                </div>
                            </div>
                            <p class="site-footer__bottom-text">Copyright <?php echo date("Y"); ?>. All rights reserved
                            </p>
                        </div>
						
					</div>
				</div>
			</footer>
			<!--Site Footer End-->
		</div><!-- /.page-wrapper -->


	<div class="mobile-nav__wrapper">
		<div class="mobile-nav__overlay mobile-nav__toggler"></div>
		<!-- /.mobile-nav__overlay -->
		<div class="mobile-nav__content">
			<span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

			<div class="logo-box">
				<a href="<?php echo "$nama_website";?>" aria-label="logo image">
					<img src="<?php echo "$nama_folder";?>/assets/images/resources/3d MKTR.png" width="100" alt="" />
				</a>
			</div>
			<!-- /.logo-box -->
			<div class="mobile-nav__container"></div>
			<!-- /.mobile-nav__container -->

			<ul class="mobile-nav__contact list-unstyled">
				<li>
					<i class="fa fa-envelope"></i>
					<a href="#">info@mktr.co.id</a>
				</li>
				<li>
					<i class="fas fa-phone"></i>
					<a href="tel:021-5020-1035">021 5020 1035</a>
				</li>
			</ul><!-- /.mobile-nav__contact -->
			<div class="mobile-nav__top">
				<div class="mobile-nav__social">
					
					<a href="https://m.facebook.com/p/PT-Menthobi-Karyatama-Raya-Tbk-100081064625604" target="_blank" class="fab fa-facebook-square"></a>
					<a href="https://instagram.com/mktr.id?igshid=MzRlODBiNWFlZA==" target="_blank" class="fab fa-instagram"></a>
					<a href="https://www.linkedin.com/company/pt-menthobi-karyatama-raya/" target="_blank" class="fab fa-linkedin"></a>
					<a href="https://www.youtube.com/@mktr5433" target="_blank" class="fab fa-youtube"></a>
				</div><!-- /.mobile-nav__social -->
			</div><!-- /.mobile-nav__top -->

		</div>
		<!-- /.mobile-nav__content -->
	</div>
	<!-- /.mobile-nav__wrapper -->

	<div class="search-popup">
		<div class="search-popup__overlay search-toggler"></div>
		<!-- /.search-popup__overlay -->
		<div class="search-popup__content">
			<form method="post" action="<?php echo "$nama_folder"; ?>/pencarian">
				<label for="search" class="sr-only">search</label><!-- /.sr-only -->
				<input type="text" name="search" placeholder="Search..." />
				<button type="submit" aria-label="search submit" class="thm-btn">
					<i class="fas fa-search"></i>
				</button>
			</form>
		</div>
		<!-- /.search-popup__content -->
	</div>
	<!-- /.search-popup -->
	
	<a href="#" class="scroll-to-top">
      <i class="fa-solid fa-chevron-up"></i>
    </a>

	<script src="<?php echo "$nama_folder";?>/assets/js/jquery-3.7.1.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/jarallax.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/jquery.ajaxchimp.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/jquery.appear.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/swiper.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/jquery.circle-progress.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/jquery.magnific-popup.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/jquery.validate.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/odometer.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/wNumb.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/wow.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/isotope.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/owl.carousel.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/jquery-ui.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/jquery.nice-select.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/jquery.bootstrap-touchspin.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/countdown.min.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/gsap/gsap.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/gsap/ScrollTrigger.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/gsap/SplitText.js"></script>
	<script src="<?php echo "$nama_folder";?>/assets/js/marquee.min.js"></script>




	<!-- template js -->
	<script src="<?php echo "$nama_folder";?>/assets/js/script.js"></script>
</body>
