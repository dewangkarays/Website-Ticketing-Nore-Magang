<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OP Ticketing</title>
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
    {{-- carousel --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    {{-- script --}}
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <style>
      body{
      font-family: 'Raleway', sans-serif !important;
      /* adition */
      /* display: grid; */
      }

      p{
        
          margin-bottom: 2px !important;
      }

      h2{
          font-weight: bold !important;
          line-height: 14px !important;
      }

      h3{
          font-weight: bold;
      }

      .wrap{
        padding:1em 0;
      }

      .greeting{
          padding-top: 5em ;
      }

      .greeting h1{
          font-weight: bold !important;
          padding-bottom: 5px !important;
  
      }

      .website h2{
        margin-bottom: 3px !important; 
      }

      .task h2{
        margin-bottom: 3px !important; 
      }

      #namawebsite{
        margin-bottom: 0;
        padding: 0 0 2px 0 ;
      }

      #countwebsite{
        font-weight: bold;
      }

      #date{
        font-weight: bold;
        margin:0;
      }

      #date-bottom{
        padding-bottom:0 !important;
      }

      #task{
        font-weight: bolder;
      }

      #bayar{
      
      }

      .row{
          padding: 3px 0 1em 0 !important
      }


      .card-body{
        padding: 0.5em ;
      }

      .btn-warning{
        color:#ffff;
      }

      .split{
        padding-top: 4em;
      }

      .slider{
        display: flex;
      }

      .slider, .col{
        flex: 1 !important;
      }

      #btnmail{
        padding-right:14px;
        padding-left:14px;
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

      .website h2, .task h2, .tagihan h2, .history h2{
        padding-bottom: 1em;
      }
    }

    .navbar{
        padding: .5rem 0 !important;
    }

    .container-fluid{
        padding: 0 !important;
    }

    </style>
</head>
<body>
  @section('title','Dashboard')
  <div class="header">
    @include('client.navbar')
  </div>
  <div class="wrapper">
    {{-- <div class="sidebar">
      @include('client.sidebar')
    </div> --}}
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
                <div class="greeting">
                    <p>Selamat Datang</p>
                    <h1>{{\Auth::user()->nama}}</h1>
                </div>
                <div class="wrap">
                  <div class="website">
                      <h3>Website Langganan</h3>
                      <p style="font-size:14px">Total Langganan : </p>
                  </div>
            
                  <div class="row">
                    <div class="slider owl-carousel">
                      @for ($i=0; $i<3; $i++)
                      <div class="col">
                          <div class="card bg-light" style="padding:10px">
                            <div class="card-body">
                              <div class="row">
                                <div class="col">
                                  <h5 id="namawebsite" class="card-title" style="margin-bottom: 0;
                                  padding: 0 0 2px 0; ">Nama Website</h5>
                                  <p>Status</p>
                                </div>
                                <div class="col text-right">
                                  <p>Jumlah</p>
                                  <p>Pengoperasian</p>
                                  <h1 id="countwebsite">3</h1>
                                </div>
                              </div>
                              <div id="date-bottom" class="row">
                                <div class="col">
                                  <div class="tanggal">
                                    <p>Hingga</p>
                                    <h5 id="date">15 Oktober 2020</h5>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endfor
                    </div>
                      </div>
                  </div>
                <div class="wrap">
                  <div class="task">
                      <h2>Task</h2>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="card bg-light">
                        <div class="card-body">
                          <h5 class="card-title">Baru</h5>
                          <h1 id="task" class="card-text text-right">1</h1>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card bg-light">
                        <div class="card-body">
                          <h5 class="card-title">Dikerjakan</h5>
                          <h1 id="task" class="card-text text-right">1</h1>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card bg-light">
                        <div class="card-body">
                          <h5 class="card-title">Selesai</h5>
                          <h1 id="task" class="card-text text-right">1</h1>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="wrap">
                  <div class="tagihan">
                      <h2>Tagihan Aktif</h2>
                  </div>
                  <div class="cardContainer">
                      @for($i=0; $i<3; $i++)
                      <div class="card">
                        <h5 class="card-header" style="font-weight:bold;">Invoice</h5>
                        <div class="card-body">
                          <p class="card-text" style="padding: 5px 0 10px 12px; font-size:24px;">Rp 111111</p>
                          <div class="buttondetail" style="padding-left:12px; padding-bottom:5px;">
                            <a href="/payment" id="bayar" class="btn btn-success rounded-pill" style="padding:6px 18px;">Bayar</a>
                          </div>
                        </div>
                      </div>
                      <div class="divider"></div>
                      @endfor
                        <div class="col text-right">
                            <a href="/tagihanaktif" id="detail" class="btn btn-warning rounded-pill" style="padding:6px 18px; justify-content:right; align-items:right;">Detail</a>
                        </div>
                  </div>
                </div>
                <div class="wrap">
                    <div class="history">
                      <h2>Riwayat Tagihan</h2>
                    </div>
                    <div class="cardContainer">
                      @for($i=0; $i<3; $i++)
                      <div class="card">
                        <h5 class="card-header" style="font-weight:bold;">Invoice</h5>
                        <div class="card-body">
                          <p class="card-text rounded-pill" style="padding: 5px 0 10px 12px; font-size:24px;">Rp 111111</p>
                      </div>
                    </div>
                    <div class="divider"></div>
                      @endfor
                      <div class="col text-right">
                        <a href="/tagihanriwayat" id="detail" class="btn btn-warning rounded-pill" style="padding:6px 18px;">Detail</a>
                      </div>
                </div>
                </div>
                <div class="wrap">
                  <div class="contact">
                    <h2>Pusat Bantuan</h2>
                    <div class="row">
                      <div class="col text-right">
                        <button type="button" class="btn btn-success btn-sm">
                          <img src="" alt="" class="rounded">
                          <span class="material-icons" id="wa">
                            sms
                            </span>
                          <p>Whatsapp</p>
                        </button>
                      </div>
                      <div class="col text-left">
                        <button type="button" class="btn btn-primary btn-sm" id="btnmail">
                          <img src="" alt="" class="rounded">
                          <span class="material-icons" id="mail">
                            mail
                            </span>
                          <p>Email</p>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="footer">
                <div class="split"></div>
                  @include('client.footer')
                </div>
            {{-- </div> --}}
        </div>
  </div>
    <!-- Bootstrap JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> --}}
    <script  src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> --}}
    <script>
      $(".slider").owlCarousel({
        loop: true,
      });

      $(document).ready(function () {

           $('#sidebarCollapse').on('click', function () {
               $('#sidebar').toggleClass('active');
           });

       });
    </script>
</body>
</html>