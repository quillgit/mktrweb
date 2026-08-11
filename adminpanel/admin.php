<?php
include "parser-php-version.php"; //Konversi dan migrasi PHP version

session_start();
include "configuration/connection.php";
include "configuration/function.php";
include "configuration/process_message.php";

$user   = mysql_num_rows(mysql_query("SELECT * FROM pw_users where username = '$_SESSION[namauser]' AND password = '$_SESSION[passuser]'"));

if($user > 0){
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
		
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="author" content="Dompet Dhuafa">
        <title>CMS | MENTHOBI KARYATAMA RAYA</title>
        <link rel="apple-touch-icon" href="images/logo/logo_santa_p.png">
        <link rel="shortcut icon" type="image/x-icon" href="images/logo/logo_mktr.png">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

        <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
        <!--<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/file-uploaders/dropzone.min.css">-->
        <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
        <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css">
        <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/extensions/buttons.dataTables.min.css">
        <!-- END: Vendor CSS-->

        <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
        <link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
        <link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
        <link rel="stylesheet" type="text/css" href="app-assets/css/pages/app-ecommerce-shop.css">
        <!-- BEGIN: Page CSS-->
        <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
        <!-- <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">-->
        <!-- <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/file-uploaders/dropzone.css">-->
        <link rel="stylesheet" type="text/css" href="app-assets/css/pages/data-list-view.css">
        <!-- END: Page CSS-->

        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <!-- END: Custom CSS-->
		<link href="assets/css/select2.min.css" rel="stylesheet" />
        <link href="assets/css/jquery-ui.css" rel="stylesheet" />
        <style>
            .move-stok {
                width: 28.57rem;
                max-width: 90vw;
                height: 100vh;
                height: calc(var(--vh, 1vh) * 100);
                background: #FFFFFF;
                position: fixed;
                left: auto;
                right: 0;
                top: 0;
                z-index: 1033;
                box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.05);
                -webkit-transform: translateX(100%);
                -ms-transform: translateX(100%);
                transform: translateX(100%);
                -webkit-transition: all 0.25s ease;
                transition: all 0.25s ease;overflow: hidden;
            }
            .move-stok.show {
                transform: translateX(0%);
            }
        </style>
		
    </head>
    <body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static ecommerce-application " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
        
		<!-- BEGIN: Vendor JS-->
        <script src="app-assets/vendors/js/vendors.min.js"></script>
        <!-- BEGIN Vendor JS-->

        <!-- BEGIN: Page Vendor JS-->
        <script src="app-assets/vendors/js/extensions/dropzone.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/dataTables.select.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/buttons.colVis.min.js"></script>
        <script src="app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
        <!-- END: Page Vendor JS-->

        <!-- BEGIN: Theme JS-->
        <script src="app-assets/js/core/app-menu.js"></script>
        <script src="app-assets/js/core/app.js"></script>
        <script src="app-assets/js/scripts/components.js"></script>
        <!-- END: Theme JS-->

        <!-- BEGIN: Page JS-->
		
        <!-- END: Page JS-->
		
		<!-- BEGIN: Page Vendor JS-->
		<script src="app-assets/vendors/js/charts/apexcharts.min.js"></script>
		<!-- END: Page JS-->
		
        <!-- <script src="assets/js/sweetalert.min.js"></script> -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script src="assets/js/select2.min.js"></script>
        <script src="assets/js/jquery-ui.js"></script>
		
		<script type="text/javascript" src="tiny_mce/tiny_mce_src.js"></script>
        <script type="text/javascript">
         
        //http://cariprogram.blogspot.com
        //nuramijaya@gmail.com

        tinyMCE.init({
         
          mode : "textareas",
          force_br_newlines : false,
		  force_p_newlines : false,
		  relative_urls: false,
		  remove_script_host : false,
            
          // ===========================================
          // Set THEME to ADVANCED
          // ===========================================
            
          theme : "advanced",
            
          // ===========================================
          // INCLUDE the PLUGIN
          // ===========================================
         
          plugins : "jbimages,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
            
          // ===========================================
          // Set LANGUAGE to EN (Otherwise, you have to use plugin's translation file)
          // ===========================================
         
          language : "en",
             
          theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
          theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
          theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
         
          // ===========================================
          // Put PLUGIN'S BUTTON on the toolbar
          // ===========================================
         
          theme_advanced_buttons4 : "jbimages,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
            
          theme_advanced_toolbar_location : "top",
          theme_advanced_toolbar_align : "left",
          theme_advanced_statusbar_location : "bottom",
          theme_advanced_resizing : true,
            
          // ===========================================
          // Set RELATIVE_URLS to FALSE (This is required for images to display properly)
          // ===========================================
         
          relative_urls : false
            
        });
         
        </script>
		
        <!-- BEGIN: Header-->
        <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
            <div class="navbar-wrapper">
                <div class="navbar-container content">
                    <div class="navbar-collapse" id="navbar-mobile">
                        <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                            <ul class="nav navbar-nav">
                                <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                            </ul>
                            
                        </div>
                        <ul class="nav navbar-nav float-right">
                            
                            
                            <?php
							$ambil_user = mysql_fetch_array(mysql_query("SELECT nama_lengkap, tipe, gambar FROM pw_users where username = '$_SESSION[namauser]' AND password = '$_SESSION[passuser]'"));
							?>
							
                            <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                    <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600"><?php echo $ambil_user['nama_lengkap'];?></span><span class="user-status"><?php echo $ambil_user['tipe'];?></span></div><span><img class="round" src="images/user/<?php echo $ambil_user['gambar'];?>" alt="avatar" height="40" width="40"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="feather icon-power"></i> Logout</a>
                                </div>
                            </li>
							
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
       
        <!-- END: Header-->


        <!-- BEGIN: Main Menu-->
        <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
            <?php include "adm_menu.php"; ?>
        </div>
        <!-- END: Main Menu-->

        <!-- BEGIN: Content-->
        <div class="app-content content">

            <div class="content-overlay"></div>

            <div class="header-navbar-shadow"></div>

            <div class="content-wrapper">
                
                <?php konten(); ?>                

            </div>
        </div>
        <!-- END: Content-->
		

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <!-- BEGIN: Footer-->
        <footer class="footer footer-static footer-light">
            <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2025, All rights Reserved</span><span class="float-md-right d-none d-md-block">PT MENTHOBI KARYATAMA RAYA</span>
                <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
            </p>
        </footer>
        <!-- END: Footer-->

        <script>
			// CONFIRM DATA DIALOG
			$(document).on('click', ':not(form)[data-confirm]', function(e){
				if(!confirm($(this).data('confirm'))){
					e.stopImmediatePropagation();
					e.preventDefault();
				}
			});
		</script>


    </body>
</html>

<?php
}else{
	
	echo "<script>alert('Anda Belum Login');window.location=('index.php')</script>";
	
}
?>