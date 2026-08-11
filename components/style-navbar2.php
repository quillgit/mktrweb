    nav {
        position: sticky;
        top: 0px;
        z-index: 99;
        background-color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0px 0px 3px rgb(206, 206, 206);
      }
      nav .logo {
        width: 255px;
        box-sizing: border-box;
        font-size: 12px;
        font-weight: 600;
        color: #01440a;
        display: flex;
        align-items: center;
        gap: 5px;
      }
      nav .logo img {
        width: 47px;
      }
      nav .logo details {
        text-align: center;
      }
      nav .logo details summary {
        list-style: none;
      }
      nav .logo details summary div {
        width: 23px;
        height: 4px;
        background-color: goldenrod;
        border-radius: 50px;
        margin-block: 3px;
      }
      nav .logo details[open] summary div:nth-child(1) {
        transform: rotate(45deg);
      }
      nav .logo details[open] summary div:nth-child(2) {
        display: none;
      }
      nav .logo details[open] summary div:nth-child(3) {
        transform: rotate(135deg);
        margin-top: -7px;
      }
      nav .logo details .hamburger-menu {
        position: absolute;
        left: 0px;
        right: 0px;
        margin-top: 15px;
        padding-block: 15px;
        background-color: white;
        font-size: 14px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
      }
      nav .logo details .hamburger-menu a {
        text-decoration: none;
        color: black;
      }
      nav .logo details .hamburger-menu a:hover {
        color: goldenrod;
      }
      nav .logo details .hamburger-menu details[open] > summary {
        color: goldenrod;
      }
      nav .logo .hamburger-menu ul li {
        list-style: none;
      }
      .hamburger-menu details ul > details {
        margin-bottom: 10px;
      }
      .hamburger-menu details ul {
        display: flex;
        margin-top: 10px;
        flex-direction: column;
        gap: 15px;
      }
      nav .logo .language > div {
        display: flex;
      }
      nav .logo .language > div > a > img {
        width: 25px;
        height: fit-content;
        border-radius: 3px;
        border: 1px solid #01440a;
      }
      /* navbar desktop */
      nav .nav-desktop {
        height: 68px;
        font-size: 11px;
        display: none;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-left: 40px;
      }
      .nav-desktop a {
        text-decoration: none;
        color: black;
      }
      .nav-desktop a:hover {
        color: goldenrod;
      }
      .nav-desktop ul li {
        list-style: none;
        font-size: 14px;
        font-weight: 600;
        padding-block: 10px;
      }
      .nav-desktop ul li:hover {
        display: flex;
      }
      .nav-desktop .drop-wrap {
        position: relative;
      }
      .nav-desktop .drop-wrap:hover > span {
        color: #ffc050;
        display: block;
        width: 100%;
      }
      .nav-desktop .drop-wrap:hover > ul {
        display: flex;
      }
      .nav-desktop .drop-wrap ul {
        z-index: 999;
        position: absolute;
        width: 220px;
        background-color: white;
        border-radius: 4px;
        display: none;
        flex-direction: column;
        padding-left: 25px;
        padding-top: 17px;
      }
      .nav-desktop .drop-wrap ul:hover {
        display: flex;
      }
      .nav-desktop .drop-wrap ul li:hover span {
        color: #ffc050;
      }
      .nav-desktop .drop-wrap ul li ul {
        width: 250px;
      }
      .nav-desktop .drop-wrap ul li:hover ul {
        display: flex;
        padding-top: 0;
        margin-top: -10px;
        left: 245px;
      }
      nav .saham {
        width: 100px;
        margin-left: 60px;
      }
      nav > .language {
        margin-left: 15px;
        display: none;
      }
      nav > .language > div {
        display: flex;
      }
      nav > .language > div > a > img {
        width: 25px;
        height: fit-content;
        border-radius: 3px;
        border: 1px solid #01440a;
      }
      
      @media (max-width: 767px) {
        nav .logo {
          width: 95%;
          justify-content: space-between;
          padding-block: 10px;
        }
      }
      
      @media (min-width: 768px) {
        nav .logo {
          width: 100%;
          justify-content: center;
          padding-block: 10px;
        }
      }
      /* desktop */
      @media (min-width: 1000px) {
        nav .nav-desktop {
          display: flex;
        }
        nav .logo details {
          display: none;
        }
        
        nav .logo {
          width: 275px;
          gap: 20px;
        }
        nav .logo details {
          display: none;
        }
        nav .logo .language > div {
          display: none;
        }
        nav > .language {
          display: flex;
        }
      }