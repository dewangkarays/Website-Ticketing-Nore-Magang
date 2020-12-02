<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OP Ticketing</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    {{-- font --}}
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;400&display=swap" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      {{-- carousel --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <style>
        body{
        font-family: 'Raleway', sans-serif !important;
        /* adition */
        /* display: grid; */
        }

        p{
            font-size: 9px !important;
            margin-bottom: 2px !important;
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
            font-size: 11px;
            font-weight: bold !important;
        }

        h5{
          font-size:14px;
          font-weight: bold !important;
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
          font-size: 48px !important;
        }

        #detail{
          margin-top: 0.5em !important;
          font-size: 9px !important;
        }

        #bayar{
          font-size: 9px !important;
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

        
        /* footer {
        background-color: #3EB772;
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: white;
        text-align: center;
        } */
        
    </style>
</head>
<body>
    @extends('client.navbar')
    @section('title','Dashboard')
      <div class="container">
          <div class="greeting">
              <p>Selamat Datang</p>
              {{-- username ganti nama --}}
              <h1>Username</h1>
          </div>
          <div class="wrap">
            <div class="website">
                <h2>Website Langganan</h2>
                {{-- total langganan dimasukkan --}}
                <p>Total Langganan : </p>
            </div>
            {{-- <div class="slider">
            </div> --}}
            <div class="row">
              {{-- 2 diganti count website --}}
              <div class="slider owl-carousel">
                @for ($i=0; $i<3; $i++)
                <div class="col">
                    <div class="card bg-light" >
                      <div class="card-body">
                        <div class="row">
                          <div class="col">
                            {{-- diisi nama website --}}
                            <h3 id="namawebsite" class="card-title">Nama Website</h3>
                            <p>Status</p>
                          </div>
                          <div class="col text-right">
                            <p>Jumlah</p>
                            <p>Pengoperasian</p>
                            {{-- diisi count website --}}
                            <h1 id="countwebsite">3</h1>
                          </div>
                        </div>
                        <div id="date-bottom" class="row">
                          <div class="col">
                            <div class="tanggal">
                              <p>Hingga</p>
                              {{-- diisi tanggal --}}
                              <h2 id="date">15 Oktober 2020</h2>
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
                    {{-- Diganti jumlah --}}
                    <h1 id="task" class="card-text text-right">1</h1>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card bg-light">
                  <div class="card-body">
                    <h5 class="card-title">Dikerjakan</h5>
                    {{-- Diganti jumlah --}}
                    <h1 id="task" class="card-text text-right">1</h1>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card bg-light">
                  <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    {{-- Diganti jumlah --}}
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
                {{-- jml diganti count tagihan --}}
                @for($i=0; $i<3; $i++)
                <div class="card">
                  <h5 class="card-header">Invoice</h5>
                  <div class="card-body">
                    <p class="card-text">Rp 111111</p>
                    <a href="#" id="bayar" class="btn btn-success rounded-pill">Bayar</a>
                  </div>
                </div>
                @endfor
                <a href="#" id="detail" class="btn btn-warning rounded-pill">Detail</a>
            </div>
          </div>
          <div class="wrap">
              <div class="history">
                {{-- jml diganti count tagihan --}}
                <h2>Riwayat Tagihan</h2>
              </div>
              <div class="cardContainer">
                @for($i=0; $i<3; $i++)
                <div class="card">
                  <h5 class="card-header">Invoice</h5>
                  <div class="card-body">
                    <p class="card-text rounded-pill">Rp 111111</p>
                  </div>
                </div>
                @endfor
                <a href="#" id="detail" class="btn btn-warning rounded-pill">Detail</a>
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
          <div class="split"></div>
          @extends('client.footer')
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
        // autoplay: true,
        // autoplayTimeout: 2000, //2000ms = 2s;
        // autoplayHoverPause: true,
      });
    </script>
</body>
</html>