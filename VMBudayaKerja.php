<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Visi Misi - Menthobi Karyatama Raya Tbk</title>
    <meta name="keywords" content="Menthobi, perusahaan, perkebunan, sawit, Maktour Group">
    <meta name="author" content="mktr.co.id">
    <meta name="description" content="Menjadi perusahaan yang menghasilkan produk perkebunan terbaik dengan menjalankan Best Practice Agronomi perkebunan yang berkelanjutan dan ramah lingkungan.">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Visi Misi PT. Menthobi Karyatama Raya Tbk" />
    <meta property="og:description" content="Menjadi perusahaan yang menghasilkan produk perkebunan terbaik dengan menjalankan Best Practice Agronomi perkebunan yang berkelanjutan dan ramah lingkungan." />
    <meta property="og:image" content="https://mktr.co.id/img/bdy.jpg" />
    <meta property="og:url" content="https://mktr.co.id/VMBudayaKerja.php" />
    <link rel="preconnect" href="https://mktr.co.id" />
    <script
      src="https://kit.fontawesome.com/ba965b16bb.js"
      crossorigin="anonymous"
    ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&family=Nunito:wght@300;400&family=Roboto&display=swap"
      rel="stylesheet"
    />
    <link
      rel="shortcut icon"
      href="./img/cropped-logo_mktr.png"
      type="image/x-icon"
    />
    <style>
      * {
        padding: 0px;
        margin: 0px;
        font-family: "Roboto", sans-serif;
      }
      header {
        width: 100%;
        height: 50px;
        background-color: #01440a;
        display: none;
        justify-content: flex-end;
      }
      header .header {
        width: 30%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 25px;
      }
      .header form {
        display: flex;
      }
      .header form button {
        background: transparent;
        border: none;
        font-size: 16px;
        color: white;
        cursor: pointer;
      }
      header form input {
        width: 150px;
        padding: 5px 20px;
        box-sizing: border-box;
        background: transparent;
        border: none;
        color: #49bb49;
        font-size: 100%;
        font-weight: 600;
      }
      header form input::placeholder {
        color: rgba(255, 255, 255, 0.219);
      }
      header form input:focus {
        outline: none;
      }
      header .language {
        width: 50%;
        height: 20px;
        display: flex;
        gap: 10px;
      }
      .language a img {
        width: 100%;
        height: 100%;
      }

      /* navbar */
      <?php include "./components/style-navbar2.php";?>
      .VMBK {
        color: #ffc050;
      }

      /* container */
      .bungkusCon {
        width: 100%;
        background-color: rgb(255, 255, 255);
        padding-bottom: 20px;
      }
      .container {
        margin: auto;
        width: 100%;
        padding-top: 8%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-evenly;
      }
      .container > div {
        width: 80%;
      }
      .VM {
        font-size: 14px;
        font-weight: 600;
        color: #f1f1f1;
        margin: 10px 10px;
        padding: 19px;
        border: 1px solid;
        width: 50%;
        border: none;
        background-color: #3b6641;
        border-radius: 8px;
        box-shadow: 11px -8px 19px -11px rgba(0, 0, 0, 0.72);
        -webkit-box-shadow: 11px -8px 19px -11px rgba(0, 0, 0, 0.72);
        -moz-box-shadow: 11px -8px 19px -11px rgba(0, 0, 0, 0.72);
      }
      .VM h1 {
        text-align: center;
      }
      .T {
        padding: 20px;
      }
      .Bdy-krj {
        background-color: #f1f1f1;
        padding-bottom: 60px;
      }
      .bdy-tp {
        display: flex;
        justify-content: center;
        padding: 20px;
      }
      .bdy-card {
        padding: 30px;
        box-sizing: border-box;
        width: 100%;
        border: 1px solid #f1f1f1;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
      }
      .bdy-desk {
        padding: 50px;
      }
      .bdy-desk h1 {
        margin-bottom: 30px;
      }
      .bdy-img img {
        width: 100%;
        border-radius: 10px;
      }
      .pmn-cards {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 25px;
      }
      .card-pdmn {
        width: 90%;
        height: 350px;
        border: none;
        border-radius: 8px;
        box-shadow: 11px -8px 19px -11px rgba(0, 0, 0, 0.72);
        -webkit-box-shadow: 11px -8px 19px -11px rgba(0, 0, 0, 0.72);
        -moz-box-shadow: 11px -8px 19px -11px rgba(0, 0, 0, 0.72);
        color: white;
        background-color: #3b6641;
        padding: 20px;
        box-sizing: border-box;
      }
      .card-pdmn h4 {
        text-align: center;
        margin: 40px 0 50px 0;
      }
      .card-pdmn p {
        padding: 10px;
      }

      /* footer */
      <?php include "./components/style-footer.php";?>
      .waves-footer {
          background-color: #f1f1f1;
      }

      /* Responsif */
      /* mobile */
      @media (max-width: 767px) {
        header .header {
          width: 75%;
        }
        
        .bdy-desk {
          padding: 0px;
          padding-block: 25px;
        }
      }
      
      /* tablet */
      @media (min-width: 768px) {
      }
      
      /* desktop */
      @media (min-width: 1000px) {
        .container {
          flex-direction: row;
        }
        .container > div {
          width: 40%;
          height: 300px;
          display: flex;
          flex-direction: column;
          /*justify-content: center;*/
          padding-block: 50px;
          font-size: 20px;
        }
        .bdy-desk h4 {
          font-size: 21px;
        }
        .card-pdmn {
          font-size: 21px;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          padding-bottom: 35px;
        }
        .card-pdmn p {
          font-size: 19px;
        }
        .pmn-cards {
          flex-direction: row;
          padding-inline: 25px;
          box-sizing: border-box;
        }
      }
    </style>
  </head>
  <body>
    <header>
      <div class="header">
        <form action="" method="get">
          <input type="text" class="searchbar" placeholder="Search..." />
          <button><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
        <div class="language">
          <a href="" class="lang-IDN"
            ><img
              src="https://mktr.co.id/wp-content/plugins/gtranslate/flags/svg/id.svg"
              alt="idn"
          /></a>
          <a href="" class="lang-ENG"
            ><img
              src="https://mktr.co.id/wp-content/plugins/gtranslate/flags/svg/en.svg"
              alt="eng"
          /></a>
        </div>
      </div>
    </header>
    <?php include "./components/navbar.php";?>
    <div class="wrapper">
      <div class="bungkusCon">
        <div class="container">
          <div class="visi VM">
            <h1>VISI</h1>
            <div class="visiText T">
              <p>
                Menjadi perusahaan yang menghasilkan produk perkebunan terbaik
                dengan menjalankan Best Practice Agronomi perkebunan yang
                berkelanjutan dan ramah lingkungan.
              </p>
            </div>
          </div>
          <div class="misi VM">
            <h1>MISI</h1>
            <div class="misiList T">
              <ul>
                <p>
                  <li>Mengembangkan bisnis perkebunan yang efisien</li>
                  <li>
                    Meningkatkan nilai tambah bagi seluruh pemangku kepentingan
                  </li>
                  <li>Menerapkan prinsip tata kelola perusahaan yang baik</li>
                  <li>Memanfaatkan teknologi ramah lingkungan</li>
                  <li>
                    Memperkuat serta mengembangkan kemitraan sumber daya manusia
                    dan potensi lokal
                  </li>
                </p>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="Bdy-krj">
        <div class="bdy-tp">
          <div class="bdy-card">
            <div class="bdy-img"><img src="./img/bdy.jpg" alt="" /></div>
            <div class="bdy-desk">
              <h1>BUDAYA KERJA</h1>
              <h4>
                Budaya Perusahaan PT MKTR memiliki nilai-nilai budaya kerja yang
                dijunjung tinggi seluruh insan perusahaan. Ada empat budaya yang
                menjadi pedoman:
              </h4>
            </div>
          </div>
        </div>
        <div class="bdy-pdmn">
          <div class="pmn-cards">
            <div class="card-pdmn">
              <h4>1. MOTIVATION & INTEGRITY</h4>
              <p>
                Memiliki semangat kerja dengan kinerja terbaik dan semangat
                mengembangkan kompetensi secara mandiri untuk menjadi pribadi
                yang unggul.
              </p>
            </div>
            <div class="card-pdmn">
              <h4>2. COMMITMENT & PROFESSIONAL</h4>
              <p>
                Mendedikasikan diri seutuhnyauntuk tumbuh dan maju bersama
                perusahaan. Selalu bersikap dan bertindak yang terbaik untuk
                perusahaan.
              </p>
            </div>
            <div class="card-pdmn">
              <h4>3. TRUST & TRANSPARENT</h4>
              <p>
                Keterbukaan dan ketersediaan informasi yang dibutuhkan.
                Membangun kepercayaan dan berprasangka baik di antara
                stakeholders dan seluruh insan perusahaan. Responsif
              </p>
            </div>
            <div class="card-pdmn">
              <h4>4. RESPONSIF</h4>
              <p>
                Memiliki perilaku kerja proaktif, kooperatif, kritis, suportif
                serta peka terhadap situasi dan kebutuhan lingkungan kerja.
                Memiliki kemampuan memanfaatkan peluang dan tantangan yang ada
                untuk pencapaian kinerja terbaik
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "./components/footer.php";?>
    <script>
      window.gtranslateSettings = {
        default_language: "",
        languages: ["id", "en"],
        wrapper_selector: ".gtranslate_wrapper",
      };
    </script>
    <script
      src="https://cdn.gtranslate.net/widgets/latest/flags.js"
      defer
    ></script>
  </body>
</html>
