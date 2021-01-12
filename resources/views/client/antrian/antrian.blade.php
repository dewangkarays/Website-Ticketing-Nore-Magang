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

    table {
    border-collapse: collapse;
    width: 100%;
  }

  td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
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
            <div class="row">
                <div class="col">
                  <p>Ingin upgrade ke versi Premium?</p>
                    <a class="btn btn-success" href="https://wa.me/6281335625529" target="_blank" rel="noopener noreferrer">
                      Klik Disini
                    </a>
                </div>
            </div>
            <div class="row" style="padding-top:1rem;;">
              <div class="col">
              <p>Sisa Task : <span style="font-size:24px;">{{$task->task_count - $taskcount}}</span></p>
            </div>
          </div>
          </div>
          <input type="text" id="myInput" placeholder="Cari">
          <br><br>
          <div class="table-responsive">
          <table>
            <thead class="table-success">
            <tr>
              <th scope="col">No</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Pelanggan</th>
                  <th scope="col">Proyek</th>
                  <th scope="col">Layanan</th>
                  <th scope="col">Status</th>
                  <th scoper="col">Handler</th>
                  <th scoper="col">Aksi</th>
            </tr>
            </thead>
            <tbody id="myTable">
            @php($i=1)
            @foreach ($antrians as $antrian)
            <tr>
              <th scope="row">{{$i}}</th>
                  <td>{{date("Y-m-d", strtotime($antrian->created_at))}}</td>
                  <td>{{(\Auth::user()->id == $antrian->user_id || \Auth::user()->role<20) ? $antrian->user->username : 'Pelanggan Lain'}}</td>
                  <td>
                    @if (Auth::user()->id == $antrian->user_id)
                      <p>{{$antrian->proyek->website}}</p>
                    @else
                      <p>Proyek Lain</p>
                    @endif
                  </td>
                  <td>@if ($antrian->proyek->tipe==80)
                    <a style="background-color: #D4AF37; color:#fff; padding:4px 6px; border-radius:10px;">
                      Premium
                    </a>
                    @elseif($antrian->proyek->tipe==90)
                    <a style="background-color: grey; color:#fff; padding:4px 6px; border-radius:10px;">
                      Prioritas
                    </a>
                    @elseif($antrian->proyek->tipe==99)
                    <a style="background-color: #fff; color:#242424; padding:4px 6px; border-radius:10px;">
                      Simple
                    </a>
                    @else
                    Tidak ada
                  @endif
                  </td>
                  <td>@if($antrian->status == 2 )
                    {{config('custom.status.'.$antrian->status)}}
                  @else
                    {{config('custom.status.'.$antrian->status)}}
                  @endif</td>
                  <td>
                    @if ($antrian->handler==null)
                      <p>Belum ada handler</p>
                    @else
                    <p>{{$antrian->assign->nama}}</p> 
                    @endif
                  </td>
                  <td>
                    <p>
                      @if ($antrian->handler==null && \Auth::user()->id == $antrian->user_id)
                      <form action="{{route('taskclients.destroy',$antrian->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('delete')
                          <button type="submit" class="btn btn-danger" style="font-weight: bold;">Batalkan</button>
                      </form>
                      @else
                      <p>Tidak ada aksi</p>
                      @endif
                    </p>
                  </td>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    </script>

  </body>
</html>