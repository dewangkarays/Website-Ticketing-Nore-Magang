<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;400&display=swap" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <style>
         .bg-light {
        background-color: #3EB772 !important;
        }

        body{
        font-family: 'Raleway', sans-serif !important;
        }

        p{
            font-size: 9px !important;
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
            font-weight: bold;
        }

        .greeting, .tagihan-aktif, .data-pembayaran, .data-task{
            padding-top: 5em ;
        }

        .greeting h1{
                font-weight: bold !important;
        }

        .row{
            padding: 1em 0 !important
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

        
        #sorting{
            font-size: 9px !important;
            font-weight: bold;
        }

        #dropdown{
            align-items: center !important;
        }

        .card-body{
            padding:20px !important;
        }

        #task{
            margin:0;
        }

        #date{
            font-weight: bold;
        }

        #need{
            margin: 0;
        }

        #handler{
            margin: 0;
        }

        #task{
          align-items: center;
        }

        #detail{
          margin-top: 0.5em !important;
          font-size: 9px !important;
        }

        #selesai, #hapus, #sorting{
          font-size: 9px !important;
        }
        
        .split{
          padding-top: 5em;
        }

        .card-body{
          padding: 1rem !important;
        }

        .separate{
          padding-bottom: 4px;
        }

        .row{
          padding-top: 0 !important;
          padding-bottom: 4px!important;
        }

        .rounded-circle{
        size: 50px 50px !important;
        }

  
    </style>
    <title>OP Ticketing</title>
  </head>
  <body>
    @extends('client.navbar')
    @section('title','Task')
        <div class="container">
          <div class="data-task">
            <div class="task-head">
              <div class="row">
                <div class="col" id="task"><h2>Data Task</h2></div>
                <div class="col text-right"><button type="button" class="btn btn-primary rounded-pill" id="sorting">Terbaru</button>
                    <span class="material-icons" id="dropdown">
                        arrow_drop_down
                        </span>
                </div>
            </div>
            </div>
            <div class="cardContainer">
              {{-- diganti jumlah aktif --}}
              @for($i=0;$i<3;$i++)
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col"><h2 class="card-title text-left" id="task">Task</h2></div>
                    <div class="col"></div>
                    <div class="col"><p class="card-text text-right">Status</p></div>
                  </div>
                    <p class="card-text" id="date">Tanggal Input : </p>
                    <p class="card-text bold" id="need">Kebutuhan : </p>
                    <p class="card-text">Deskripsi</p>
                  <div class="row">
                      <div class="col">
                          <p class="card-text" id="handler">Handler : </p>   
                      </div>
                      <div class="col">
                        <a href="#" class="btn btn-success rounded-pill" id="selesai">Selesai</a>
                      </div>
                      <div class="col">
                        <a href="#" class="btn btn-danger rounded-pill" id="hapus">Hapus</a>
                      </div>
                  </div>
                </div>
              </div>
              <div class="separate"></div>
              @endfor
            </div>
                  <div class="row">
                      <div class="col"></div>
                      <div class="col text-center">
                        <a href="/taskcreate" class="btn btn-success rounded-circle">+</a>
                      </div>
                      <div class="col"></div>
                  </div>
          </div>
          <div class="split"></div>
              @extends('client.footer')
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