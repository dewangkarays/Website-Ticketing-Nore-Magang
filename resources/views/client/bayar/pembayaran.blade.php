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

        /* .row{
            padding: 1em 0 !important
        } */

        /* .tagihan{
            padding: 2em 0!important;
        } */

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

        #nominal{
          font-weight: bold;
        }

        #jumlah{
          margin : 0 12px;
        }

        .split{
        padding-top: 5em;
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

      .sidebar{
        display: none;
      }

      .copyright{
        display: none;
      }

      .bayar-head{
        padding-top: 5rem;
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
        font-size:24px !important;
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

    </style>
    <title>OP Ticketing</title>
  </head>
  <body>
    @section('title','Bayar')
    <div class="header">
      @include('client.navbar')
    </div>
    <div class="wrapper">
      @include('client.sidebar')
    <div class="container">
      <div class="headerdesktop">
        @include('client.headerdesktop')
      </div>
      <div class="form-pembayaran" style="padding-top:1em;">
        <div class="bayar-head">
          <h3 style="padding-top:1em;">Form Pembayaran</h3>      
        </div>
        <form>
          <div class="form-group row">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Nama</label>
            <div class="col-sm-8">
              <input type="name" class="form-control form-control-sm-8" id="colFormLabelSm" placeholder="Input Nama">
            </div>
          </div>
          <div class="form-group row">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Tanggal Pembayaran</label>
            <div class="col-sm-8">
              <input type="date" class="form-control form-control-sm" id="datepicker" name="date" placeholder="">
            </div>
          </div>
          <div class="form-group row">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Keterangan</label>
          </div>
          <div class="form-group row">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Rincian Tagihan</label>
            <table class="table table-hover col-sm-8" style="align-items:center;">
              <thead>
                <tr>
                  <th scope="col">Langganan</th>
                  <th scope="col">Ads</th>
                  <th scope="col">Lainnya</th>
                  <th scope="col">Terbayar</th>
                  <th scope="col">Total Tagihan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">Rp. </th>
                  <td>Rp. </td>
                  <td>Rp. </td>
                  <td>Rp. </td>
                  <td>Rp. </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="form-group row">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm" id="nominal">Nominal Pembayaran</label>
            <input type="name" class="form-control form-control-sm-8" id="jumlah" placeholder="Input Nominal">
          </div>
        </form>
        <div class="col text-center">
          <button type="button" class="btn btn-success btn-lg btn-block">Bayar</button>
        </div>
      </div>
      <div class="split"></div>
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
    <script>

    </script>
  </body>
</html>