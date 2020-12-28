<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
    {{-- fixed --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    {{-- script --}}
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <style>
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

        .divider{
        padding-top: 1em;
      }

      .container{
        padding-left: 15px !important;
        padding-right: 15px !important;
      }


    .page-item.active .page-link{
      background-color:#3EB772;
      border-color: #3EB772;
    }

    .page-link{
      color:#3EB772;
    }

    .split{
      padding-top: 6rem;
    }

        /* tambahan */
      .wrapper {
      display: flex;
      align-items: 100%;
      /* width: 80%; */
      }

      @media (max-width: 768px) {
      .sidebar{
        display: none;
      }

      .copyright{
        display: none;
      }

      .data-antrian{
        padding-top: 2rem;
      }

      .headerdesktop{
        display: none;
      }
    }

      @media (min-width: 768px) {
      .footer, .header{
        display: none;
      }

      h2{
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
  </head>
  <body>
    @section('title','Antrian')
    <div class="header">
      @include('client.headermobile')
    </div>
    <div class="wrapper">
        @include('client.sidebar')
      <div class="container">
        <div class="headerdesktop">
          @include('client.headerdesktop')
        </div>
        <div class="data-antrian">
          <div class="antrian-head">
            <h3 style="padding-top:1em; padding-bottom:0.5em;">Data Antrian</h3>      
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="table-success">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Pelanggan</th>
                  <th scope="col">Layanan</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                @php($i=1)
                @foreach ($antrians as $antrians)
                <tr>
                  <th scope="row">{{$i}}</th>
                <td>{{date("Y-m-d", strtotime($antrians->created_at))}}</td>
                <td>{{(\Auth::user()->id == $antrians->user_id || \Auth::user()->role<20) ? $antrians->user->username : 'Pelanggan Lain'}}</td>
                <td>{{config('custom.role.'.$antrians->user->role)}}</td>
                <td>@if($antrians->status == 2 )
                  {{config('custom.status.'.$antrians->status)}}
                @else
                  {{config('custom.status.'.$antrians->status)}}
                @endif</td>
                </tr>
                @php($i++)
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col"></div>
            <div class="col"></div>
          <div class="col text-right">
            {{-- <nav aria-label="...">
              <ul class="pagination">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active">
                  <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav> --}}
          </div>
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