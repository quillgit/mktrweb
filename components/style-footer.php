      footer {
        background-color: #024e0c;
        color: white;
      }
      footer .wrapper {
        width: 70%;
        margin: auto;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
      }
      footer .wrapper img {
        width: 60px;
        height: 60px;
        display: flex;
        margin-right: 100px;
        margin-block: 25px;
      }
      footer .wrapper ul {
        display: flex;
      }
      footer .wrapper ul li {
        width: 25%;
        display: flex;
        flex-direction: column;
        gap: 10px;
      }
      footer .wrapper ul li h3 {
        font-size: 15px;
        margin-bottom: 15px;
      }
      footer .wrapper ul li a {
        color: white;
        text-decoration: none;
      }
      footer .wrapper ul li .sosmed {
        margin: auto;
        display: flex;
        gap: 10px;
      }
      footer .wrapper ul li .sosmed a {
        width: 35px;
        height: 35px;
        background-color: white;
        border-radius: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      footer .copyright {
        background-color: #073a0b;
        height: 70px;
        padding-inline: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
      }

        /*waves*/
        .waves {
          background-color: #fff;
          position:relative;
          width: 100%;
          height:15vh;
          margin-bottom:-7px; /*Fix for safari gap*/
          min-height:10px;
          max-height:50px;
        }
        .waves-bawah{
          transform: rotate(180deg);
        }
        /*bg wavenya sesuaikan dengan bg page*/
        .waves-footer{
          background-color: white;
        }
        
        /* Animation */
        
        .parallax > use {
          animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }
        .parallax > use:nth-child(1) {
          animation-delay: -2s;
          animation-duration: 8s;
        }
        .parallax > use:nth-child(2) {
          animation-delay: -3s;
          animation-duration: 11s;
        }
        .parallax > use:nth-child(3) {
          animation-delay: -4s;
          animation-duration: 15s;
        }
        .parallax > use:nth-child(4) {
          animation-delay: -5s;
          animation-duration: 19s;
        }
        @keyframes move-forever {
          0% {
           transform: translate3d(-90px,0,0);
          }
          100% { 
            transform: translate3d(85px,0,0);
          }
        }
        
        /*Responsive mobile*/
        @media (max-width: 768px) {
        /*Shrinking for mobile*/
          .waves {
            height:40px;
            min-height:40px;
          }
          
        }
        
        /* tablet */
          @media (max-width: 1000px) {
            footer .wrapper {
              width: 60%;
              align-items: center;
            }
            footer .wrapper img {
              margin-right: 0px;
              margin-block: 30px;
            }
            footer .wrapper ul {
              flex-direction: column;
              gap: 25px;
            }
            footer .wrapper ul li {
              width: 100%;
            }
          }