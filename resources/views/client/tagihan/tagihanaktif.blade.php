<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    {{-- font --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;400;700&display=swap" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    {{-- fixed --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <style>
        .bg-light {
        background-color: #3EB772 !important;
        }

        body{
        font-family: 'Raleway', sans-serif !important;
        }


        h2{
            font-weight: bold !important;
            line-height: 14px !important;
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

        .invoice h5{
          font-weight: bold;
        }

        #tombol{
          padding: 0 !important;

        }

        #detail{
          margin-top: 0.5em !important;
        }

      .wrapper {
      display: flex;
      align-items: 100%;
      /* width: 80%; */
    }

    .divider{
      padding-bottom: 1em;
    }

    .split{
      padding-top: 5em;
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

      .tagihan-aktif{
        padding-top: 2rem;
      }

      .headerdesktop{
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

    .container{
        padding-left:15px !important;
        padding-right:15px !important;
      }


    </style>
    <title>OP Ticketing</title>
  </head>
  <body>
    @section('title','Tagihan')
    <div class="header">
      @include('client.headermobile')
    </div>
    <div class="wrapper">
      @include('client.sidebar')
    <div class="container">
      <div class="headerdesktop">
        @include('client.headerdesktop')
      </div>
      <div class="tagihan-aktif">
        <div class="tagihan-head">
          <h3 style="font-weight:bold; padding-top:1em;">Tagihan Aktif</h3>      
        </div>
        <div class="cardContainer">
          {{-- diganti jumlah aktif --}}
          @foreach ($tagihans as $tagihans)
          @if (\Auth::user()->id == $tagihans->user_id && $tagihans->status!=2)
          {{-- @for($i=0;$i<5;$i++) --}}
          <div class="card w-100">
            <div class="card-body">
              <div class="invoice">
                <h5 class="card-title">Invoice {{$tagihans->invoice}}</h5>
                <p class="card-text">{{$tagihans->keterangan}}</p>
                <div class="row">
                  <div class="col">
                    <p class="card-text" style="font-weight:bold;">Tagihan</p>
                    <h5 class="card-text">Rp. {{$tagihans->jml_tagih}}</h5>
                  </div>
                  <div class="col">
                    <p class="card-text"  style="font-weight:bold;">Harus dibayar</p>
                    <h5 class="card-text">Rp. {{$tagihans->jml_bayar}}</h5>
                  </div>
                  <div class="col text-center" id="tombol">
                    <a href="/purchase" class="btn btn-success" style="font-weight: bold; padding:6px 18px; border-radius:5px;">Bayar</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="divider"></div>
          {{-- @endfor --}}
          @endif
          @endforeach
        </div>
        <div class="copyright">
          <p style="text-align: center">2020. Nore Inovasi.</p>
        </div>
      </div>
      </div>
    </div>
  </div>
  <div class="split"></div>
  <div class="footer">
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