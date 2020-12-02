<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;400&display=swap" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"> --}}
      <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    {{-- font --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;400;700&display=swap" rel="stylesheet">
    {{-- icon --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    {{-- script --}}
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <style>
        /* .bg-light {
        background-color: #3EB772 !important;
        } */

        body{
        font-family: 'Raleway', sans-serif !important;
        }


        h1{
            font-size: 24px !important ;
        }

        h2{
            font-weight: bold !important;
            font-size: 12px !important;
            line-height: 14px !important;
        }

        h3{
            font-weight: bold;
        }

        .tagihan-aktif{
            padding-top: 5em ;
        }

        /* .greeting h1{
                font-weight: bold !important;
        } */

        .row{
            padding: 1em 0 !important
        }

        .tagihan{
            padding: 2em 0!important;
        }

        .cardContainer{
            padding: 0 0 2em 0 !important;
        }

        /* .tanggal{
            padding-top:2em;
        } */

        .btn-warning{
          color:#ffff;
        }

        /* footer {
        background-color: #3EB772;
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: white;
        text-align: center;
        } */

        .invoice h5{
          font-weight: bold;
        }

       
        
        #tombol{
          padding: 0 !important;

        }

        .split{
          padding-top: 4em;
        }

        #detail{
          margin-top: 0.5em !important;
        }

        .card-body{
          padding: 1rem !important;
        }

        .separate{
          padding-bottom: 4px;
        }

      /* sidebar */
      .wrapper {
      display: flex;
      align-items: stretch;
      /* width: 80%; */
    }

    #sidebar {
      min-width: 250px;
      max-width: 250px;
      /* min-width: 20%;
      max-width: 20%; */
      min-height: 100vh;
    }

    #sidebar.active {
      margin-left: -250px;
    }

    a, a:hover, a:focus {
      color: inherit;
      text-decoration: none;
      transition: all 0.3s;
    }

    #sidebar {
      background: #3EB772;
      color: #fff;
      transition: all 0.3s;
    }

    #sidebar .sidebar-header {
      padding: 20px;
      background: #3EB772;
    }

    #sidebar ul.components {
      padding: 20px 0;
    }

    #sidebar ul p {
      color: #fff;
      padding: 10px;
    }

    #sidebar ul li a {
      padding: 10px;
      font-size: 1.1em;
      display: block;
    }
    #sidebar ul li a:hover {
      color: #3EB772;
      font-weight: bold;
      background: #fff;
    }

    ul ul a {
      font-size: 0.9em !important;
      padding-left: 30px !important;
      background: #3EB772;
    }

    .divider{
      padding-bottom: 1em;
    }

    @media (max-width: 768px) {
      /* #sidebar {
          margin-left: -250px;
      }
      #sidebar.active {
          margin-left: 0;
      } */

      .sidebar{
        display: none;
      }
    }

    @media (min-width: 768px) {
      .contact, .header, .greeting, .footer{
        display: none;
      }

      /* .website h2, .task h2, .tagihan h2, .history h2{
        font-size:24px !important;
        padding-bottom: 1em;
      } */
    }

    .navbar{
            padding: .5rem 0 !important;
        }

    .container-fluid{
        padding: 0 !important;
    }

    </style>
    <title>OP Ticketing</title>
  </head>
  <body>
    @section('title','Tagihan')
    <div class="header">
      @include('client.navbar')
    </div>
    <div class="wrapper">
      <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <h3 style="font-size: 24px">Nore</h3>
        </div>
        <ul class="list-unstyled components" style="padding-left:10px">
         <li>
            <a href="/dashboard">Dashboard</a>
         </li>
         <li>
            <a href="/tagihanclient">Tagihan</a>
         </li>
         <li>
            <a href="/payment">Bayar</a>
         </li>
         <li>
            <a href="/taskclient">Task</a>
         </li>
         <li>
            <a href="/antrian">Antrian</a>
         </li>
        </ul>
          <div class="row text-center">
            <div class="col">
              <button type="button" class="btn btn-success btn-sm">
                <img src="" alt="" class="rounded">
                <span class="material-icons" id="wa">
                  sms
                  </span>
                <p>Whatsapp</p>
              </button>
            </div>
            <div class="col">
              <button type="button" class="btn btn-primary btn-sm" id="btnmail" style="padding:4px 23px;">
                <img src="" alt="" class="rounded">
                <span class="material-icons" id="mail">
                  mail
                  </span>
                <p>Email</p>
              </button>
            </div>
          </div>
      </nav>
        <div class="container">
          <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                </button>
            </div>
          </nav>
          <div class="tagihan-aktif">
            <div class="tagihan-head">
              <h3>Tagihan Aktif</h3>      
            </div>
            <div class="cardContainer">
              {{-- diganti jumlah aktif --}}
              @for($i=0;$i<3;$i++)
              <div class="card">
                <div class="card-body">
                  <div class="invoice">
                    <h5 class="card-title">Invoice</h5>
                    <p class="card-text">Keterangan</p>
                    <div class="row">
                      <div class="col">
                        <p class="card-text">Tagihan</p>
                        <h5 class="card-text">Rp. </h5>
                      </div>
                      <div class="col">
                        <p class="card-text">Harus dibayar</p>
                        <h5 class="card-text">Rp. </h5>
                      </div>
                      <div class="col text-center" id="tombol">
                        <a href="/purchase" class="btn btn-success rounded-pill" id="bayar" style="padding-left:12px; padding-bottom:5px;">Bayar</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="separate"></div>
              @endfor
              <div class="row">
                <div class="col">
                </div>
                <div class="col">
                </div>
                <div class="col text-center">
                  <a href="/tagihanaktif" class="btn btn-warning rounded-pill" id="detail">Detail</a>
                </div>
              </div>
            </div>
          </div>
          <div class="tagihan-riwayat">
            <div class="tagihan-head">
              <h3>Riwayat Tagihan</h3>      
            </div>
            <div class="cardContainer">
              {{-- diganti jumlah aktif --}}
              @for($i=0;$i<3;$i++)
              <div class="card">
                <div class="card-body">
                  <div class="invoice">
                    <h5 class="card-title">Invoice</h5>
                    <p class="card-text">Keterangan</p>
                    <div class="row">
                      <div class="col">
                        <p class="card-text">Tagihan</p>
                        <h5 class="card-text">Rp. </h5>
                      </div>
                      <div class="col">
                        <p class="card-text">Harus dibayar</p>
                        <h5 class="card-text">Rp. </h5>
                      </div>
                      <div class="col text-center" id="tombol">
                        <a href="#" class="btn btn-secondary rounded-pill" id="lunas">Lunas</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="separate"></div>
              @endfor
              <div class="row">
                <div class="col">
                </div>
                <div class="col">
                </div>
                <div class="col  text-center">
                  <a href="/tagihanriwayat" class="btn btn-warning rounded-pill" id="detail">Detail</a>
                </div>
              </div>
            </div>
          </div>
          <div class="footer">
            <div class="split"></div>
                @include('client.footer')
          </div>
        </div>
    </div>
        
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    {{-- tambahan --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
    <script>
      $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

      });
    </script>
  </body>
</html>