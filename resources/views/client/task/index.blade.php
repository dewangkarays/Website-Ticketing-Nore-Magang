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

        
        #sorting{
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
            align-items: center;
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

        #detail{
          margin-top: 0.5em !important;
        }

        
        .divider{
          padding-top: 1em;
        }

        .card-body{
          padding: 1rem !important;
        }

        .split{
          padding-top: 5em;
        }

        /* .rounded-circle{
        size: 50px 50px !important;
        } */

    .wrapper {
      display: flex;
      align-items: 100%;
      /* width: 80%; */
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
      .hide-mobile{
        display: none;
      }
      .data-task{
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

      .hide-desktop{
        display:none;
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

.container{
  padding-left:15px !important;
  padding-right:15px !important;
} 
    </style>
    <title>OP Ticketing</title>
  </head>
  <body>
    @section('title','Task')
    <div class="header">
      @include('client.headermobile')
    </div>
    <div class="wrapper">
    @include('client.sidebar')
    <div class="container">
      <div class="headerdesktop">
        @include('client.headerdesktop')
      </div>
        <div class="data-task" style="padding-bottom:0.5em;">
          <div class="task-head">
            <div class="row">
              <div class="col">
                {{-- <button class="btn btn-success rounded-pill" style="font-weight: bold">TAMBAH</button> --}}
                {{-- <a href="/taskcreate">
                  <button type="button" class="btn btn-success btn-circle btn-xl" style="text-align: center">+</button> 
                </a> --}}
                <a href="/taskcreate">
                  <button class="btn btn-success" style="font-weight: bold; border:none; padding:12px 20px;">
                    Tambah
                  </button>
                </a>
              </div>
            </div>
            <div class="row">
              <div class="col" id="task"><h3 style="padding-top: 1em;">Data Task</h3></div>
              {{-- <div class="col" style="text-align: right">
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
          {{-- <div class="hide-mobile"> --}}
            <p>Sisa Task : <span style="font-weight:bold; font-size:26px !important;"> {{@$users->first()->task_count - count($tasks)}} </span></p>
            @foreach ($tasks as $task)
            {{-- <p>{{$tasks->user->get(0)->count_task}}</p> --}}
            {{-- <p>{{$tasks->count_task}}</p> --}}
              <div class="card" style="background-color:#fafafa;">
                <div class="card-header">
                  <div class="row">
                    <div class="col">
                      <h5 style="font-weight:bold;">{{$task->proyek->website}}</h5>
                    </div>
                    <div class="col text-right">
                      @if ($task->status==1)
                      <a style="background-color:#4A708B; color:#fff; padding:5px 24px; border-radius:20px; font-weight:bold; ">Baru</a>
                      @elseif($task->status==2)
                      <a style="background-color:rgb(255, 196, 0); color:#fff; padding:5px 24px; border-radius:20px; font-weight:bold;">Dikerjakan</a>
                      @elseif($task->status==3)
                      <a style="background-color:grey; color:#fff; padding:5px 24px; border-radius:20px; font-weight:bold;">Selesai</a>
                      @else
                      <p>Tidak diketahui</p>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  {{-- <p class="card-text">{{date("d-m-Y", strtotime($task->created_at))}}</p> --}}
                  <div class="row">
                    <div class="col">
                      <p class="card-text">Kebutuhan :</p>
                    </div>
                    <div class="col">
                      <p>{{$task->kebutuhan}}</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      {{-- <p class="card-text">{{$task->created_at->format('j F Y')}}</p> --}}
                      <p class="card-text">
                      @if ($task->handler==null)
                        Belum ada handler
                      @else
                        Handler : {{@$task->assign->nama}}
                      @endif
                      </p>
                    </div>
                  </div>
                  <div class="row" style="padding-top:1rem;">
                    <div class="col">
                      @if ($task->handler==null)
                        <form action="{{route('taskclients.destroy',$task->id)}}" method="post" class="d-inline">
                          @csrf
                          @method('delete')
                            <button type="submit" class="btn btn-danger" style="font-weight: bold;">Batalkan</button>
                        </form>
                      @endif
                    </div>
                  </div>
                  {{-- @if ($task->status!=3)
                  <button type="button" id="btn-update" class="btn btn-secondary">Selesai</button>
                  @else
                  <input class="form-control" type="hidden" name="task_id" id="task_id" value=""/>
                  <button type="button" id="btn-update" class="btn btn-primary">Selesai</button>
                  @endif
                  <form action="{{route('taskclients.destroy',$task->id)}}" method="post" class="d-inline">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger d-inline">
                      Hapus
                    </button>
                  </form> --}}
                </div>
              </div>
              <div class="divider"></div>
              {{-- @endfor --}}
              @endforeach
          {{-- </div> --}}
          {{-- <div class="hide-desktop">
            <div class="cardContainer">
              @for($i=0;$i<3;$i++)
              <div class="card" style="background-color:#fafafa;">
                <div class="card-header" style="font-weight: bold; font-size:24px;">
                  Task 
                </div>
                <div class="card-body">
                  <p class="card-text">Tanggal input: </p>
                  <p class="card-text">Kebutuhan : </p>
                  <p class="card-text">Handler : </p>
                  <a href="#" class="btn btn-primary">Selesai</a>
                  <a href="#" class="btn btn-danger">Hapus</a>
                </div>
              </div>
              <div class="divider"></div>
              @endfor
            </div>
          </div> --}}
          {{-- <div class="row">
              <div class="col"></div>
              <div class="col text-center">
                <a href="/taskcreate">
                  <button type="button" class="btn btn-success btn-circle btn-xl" style="text-align: center">+</button> 
                </a>
              </div>
              <div class="col"></div>
          </div> --}}
      </div>
      <div class="divider"></div>
      <div class="copyright">
        <p style="text-align: center">2020. Nore Inovasi.</p>
      </div>
      <div class="footer">
        <div class="split"></div>
        @include('client.footer')
      </div>
    </div>
  </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> --}}
    {{-- tambahan --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://unpkg.com/@popperjs/core@2"></script> --}}
     {{-- Option 2: jQuery, Popper.js, and Bootstrap JS --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
    <script>

    $("#btn-update").click(function(){ 
		var token = getToken();
		var id = $('#task_id').val();
		var status = 3; 
		
		$.ajax({
			type: "POST",
			url: '/updatestatus',
			// 'url': '/updatestatus',
			// 'method': 'POST',
			data: {'status': status, 'id': id, _token : token },
			success: function(data){
					// Sticky buttons
					// alert('Data changed!')
					
					location.reload();
				}
		});
	});	
    </script>
  </body>
</html>