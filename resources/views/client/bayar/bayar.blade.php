<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
    {{-- fixed --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
   {{-- script --}}
   <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
   <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
   
    <style>
        .bg-light {
        background-color: #3EB772 !important;
        }

        body{
        font-family: 'Raleway', sans-serif !important;
        }

        h1{
            /* font-size: 24px !important ; */
        }

        h2{
            font-weight: bold !important;
            line-height: 14px !important;
        }

        h3{
            font-weight: bold;
        }

        .greeting h1{
                font-weight: bold !important;
        }

        .tagihan{
            padding: 2em 0!important;
        }

        .cardContainer{
            padding: 0 0 2em 0 !important;
        }

        .tanggal{
            padding-top:2em;
        }

        .btn-warning{
          color:#ffff;
        }

        footer {
        background-color: #3EB772;
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: white;
        text-align: center;
        }

        #detail{
          margin-top: 0.5em !important;
          /* font-size: 9px !important; */
        }

        .split{
          padding-top: 5em;
        }


        .nominal{
          padding-bottom:0px !important;
        }

        #nominal{
          font-weight: bold;
          margin-bottom: 0 !important;
        }

        .card-body{
          padding: 1rem !important;
        }

        #status{
          padding-bottom: 4px !important;
        }

        .divider{
          padding-bottom: 1 em;
        }

        
      .wrapper {
      display: flex;
      align-items: 100%;
      /* width: 80%; */
    }

    .divider{
      padding-bottom: 1em;
    }

    .container{
      padding-left:15px !important;
      padding-right:15px !important;
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

      .copyright{
        display: none;
      }

      .hide-mobile{
        display: none;
      }

      .bayar-head{
        padding-top: 2rem;
      }

      .headerdesktop{
        display: none;
      }

    }

    @media (min-width: 768px) {
     .header, .footer{
        display: none;
      }

      .website h2, .task h2, .tagihan h2, .history h2{
        padding-bottom: 1em;
      }

      .hide-desktop{
        display: none;
      }

      .container{
        margin-left:250px;
        transition: all 0.3s;
      }
    }

    .navbar{
            padding: .5rem 0 !important;
        }

    .container-fluid{
        padding: 0 !important;
    }

    .dropbtn {
  background-color:#007bff;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius:25px;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
  
    </style>
    <title>OP Ticketing</title>
  </head>
  <body>
    @section('title','Bayar')
    <div class="header">
      @include('client.headermobile')
    </div>
    <div class="wrapper">
      @include('client.sidebar')
      <div class="container">
        <div class="headerdesktop">
          @include('client.headerdesktop')
        </div>
        <div class="data-pembayaran" style="padding-bottom:0.5em;">
          <div class="bayar-head">
            <div class="row">
              <div class="col" id="task"><h3 style="padding-top:1em; ">History Pembayaran</h3></div>
              {{-- <div class="col text-right"  id="status">
                <div class="dropdown" style="padding-top:1em;">
                  <button class="dropbtn">Sorting</button>
                  <div class="dropdown-content" style="text-align: left !important;">
                    <a href="#">Terbaru</a>
                    <a href="#">Selesai</a>
                    <a href="#">Sedang dikerjakan</a>
                  </div>
                </div>
              </div> --}}
            </div>
          </div>
          </div>
          <div class="hide-mobile">
            @foreach ($payments as $payment)
            {{-- @for($i=0;$i<3;$i++) --}}
            <div class="card" style="background-color:#fafafa;">
              <div class="card-header" style="font-weight: bold; font-size:24px;">
                <div class="row">
                  <div class="col">
                    {{$payment->receipt_no}} 
                  </div>
                  <div class="col text-right">
                    <a href="" class="btn btn-success rounded-pill">Terbayar</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                {{-- <h5 class="card-title">Special title treatment</h5> --}}
                <p class="card-text">Tanggal pembayaran: {{$payment->tgl_bayar}}</p>
                <p class="card-text">Keterangan : {{$payment->keterangan}}</p>
                <p class="card-text">Nominal : {{$payment->nominal}} </p>
                {{-- <a href="/purchase" class="btn btn-success" style="font-weight: bold; padding:6px 18px; border-radius:5px;">Bayar</a> --}}
              </div>
            </div>
            <div class="divider"></div>
            {{-- @endfor --}}
            @endforeach
          </div> 
          <div class="hide-desktop">
            <div class="cardContainer">
              @foreach ($payments as $payment)
              {{-- @for($i=0;$i<3;$i++) --}}
              <div class="card" style="background-color:#fafafa;">
                <div class="card-header" style="font-weight: bold; font-size:24px;">
                  <div class="row">
                    <div class="col">
                    {{$payment->receipt_no}} 
                  </div>
                  <div class="col text-right">
                    <a href="" class="btn btn-success rounded-pill">Terbayar</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                {{-- <h5 class="card-title">Special title treatment</h5> --}}
                <p class="card-text">Tanggal pembayaran: {{$payment->tgl_bayar}}</p>
                <p class="card-text">Keterangan : {{$payment->keterangan}}</p>
                <p class="card-text">Nominal : {{$payment->nominal}} </p>
                {{-- <a href="/purchase" class="btn btn-success" style="font-weight: bold; padding:6px 18px; border-radius:5px;">Bayar</a> --}}
              </div>
            </div>
            <div class="divider"></div>  
            @endforeach
            {{-- @endfor --}}
            </div>
          </div>
        <div class="copyright">
          <p style="text-align: center">2020. Nore Inovasi.</p>
        </div>
      </div>
    </div>
    <div class="footer">
        <div class="split"></div>
          @include('client.footer')
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
  </body>
</html>