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

      .wrap{
        padding:1em 0;
      }

      .greeting{
          padding-top: 2rem ;
      }

      #task{
        font-weight: bolder;
      }

      .card-body{
        padding: 0.5em ;
      }

      .btn-warning{
        color:#ffff;
      }

      .split{
        padding-top: 6em;
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

    .wrapper {
      display: flex;
      /* align-items: stretch; */
      width: 100%;
    }

    p{
      margin: 0 0 !important;
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

      .hide-mobile{
        display: none;
      }

      .copyright{
        display: none;
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
        padding-bottom: 0.5em;
      }

      .container{
        margin-left:250px;
      }

      .hide-desktop{
        display: none;
      }

      .wrap{
        padding-bottom:4em;
      }

      p{
        margin:0 0 !important;
      }

      .container{
        transition: all 0.3s;
      }
    }

    .navbar{
        padding: .5rem 0 !important;
    }

    .container-fluid{
        padding: 0 !important;
    }

    .btn-circle.btn-xl { 
    width: 50px; 
    height: 50px; 
    border-radius: 35px; 
    font-weight: bold;
    padding:0px 0px;
    text-align: center; 
    }

    /* --dropdown setting-- */
    .dropdown{
      position: relative;
      display: inline-block;
    }

    .setting{
      display: none;
      position: absolute;
      overflow: auto;
      background-color: #eee;
      padding: 10px 10px;
      z-index: 1;
      border-radius: 5px;
      border: none;
      margin-top:0.4rem;
    }

    .setting a{
      font-size: 14px;
      text-decoration: none;
      display: block;
      line-height: 26px;
    }

    .setting a:hover{
      font-weight: bold;
    }

    .show{
      display: block;
    } 
    /* --- */

    </style>
</head>
<body>
  @section('title','Dashboard')
  <div class="header">
    @include('client.headermobile')
  </div>
  <div class="wrapper">
    @include('client.sidebar')
      <div class="container">
        <div class="headerdesktop">
          @include('client.headerdesktop')
        </div>
                <div class="greeting">
                    <p style="margin: 0 0;">Selamat Datang</p>
                    <h1 style="font-weight:bold;">{{\Auth::user()->nama}}</h1>
                </div>
                <div class="wrap">
                  <div class="website">
                      <h3 style="padding-top: 1em;">Website Langganan</h3>
                  <p style="padding-bottom:0.3em;">Total Langganan : {{@$website}}</p>
                  </div>
                  <div class="row" style="">
                    <div class="slider owl-carousel">
                      @foreach ($users as $user)
                      {{-- @for ($i=0; $i<3; $i++) --}}
                      <div class="col">
                        <div class="card" style="padding:10px;border:none; border-radius:10px; background-color:#eeee;">
                            <div class="card-body">
                              <div class="row">
                                <div class="col">
                                  <h6 id="namawebsite" class="card-title" style="margin-bottom: 0;
                                  padding: 0 0 2px 0; font-weight:bold; ">{{$user->website}}</h6>
                                  <p style="color:#ffff; font-weight:bold; background-color: #3EB772; padding:5px 10px; border-radius:20px; text-align:center;">Beroperasi</p>
                                </div>
                                <div class="col text-right">
                                  <p>Jumlah</p>
                                  <p>Pengoperasian</p>
                                  <h1 style="font-weight: bold;">{{$user->task_count}}</h1>
                                </div>
                              </div>
                              <div id="date-bottom" class="row" style="padding-bottom:0">
                                <div class="col">
                                  <div class="tanggal">
                                    <p style="margin-bottom: 0 !important;">Hingga</p>
                                    <h5 style="font-weight: bold; margin:0;" id="date">{{$user->kadaluarsa->format('j F Y')}}</h5>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- @endfor --}}
                        @endforeach
                    </div>
                      </div>
                  </div>
                <div class="wrap">
                  <div class="task">
                      <h2 style="padding-bottom:1rem;">Task</h2>
                  </div>
                    <div class="row">
                      <div class="col-sm-3" style="padding-bottom:0.5em;">
                        <div class="card" style="border:none; border-radius:10px; background-color:#eeee;padding: 10px;">
                          <div class="card-body">
                            <h5 class="card-title" style="padding-bottom: 3em">Baru</h5>
                            <h1 id="task" class="card-text text-right">{{@$new}}</h1>    
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3" style="padding-bottom:0.5em;">
                        <div class="card" style="border:none; border-radius:10px; background-color:#eeee;  padding: 10px;">
                          <div class="card-body">
                            <h5 class="card-title" style="padding-bottom: 3em">Dikerjakan</h5>
                            <h1 id="task" class="card-text text-right">{{@$ongoing}}</h1>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3" style="padding-bottom:0.5em;">
                        <div class="card" style="border:none; border-radius:10px; background-color:#eeee;  padding: 10px;">
                          <div class="card-body">
                            <h5 class="card-title" style="padding-bottom: 3em">Selesai</h5>
                            <h1 id="task" class="card-text text-right">{{@$done}}</h1>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="hide-mobile">
                  <div class="wrap">
                    <div class="row">
                      <div class="col w-50">
                        <div class="tagihan">
                          <h2>Tagihan Aktif</h2>
                        </div>
                        <div class="cardContainer">
                          {{-- @for($i=0; $i<3; $i++) --}}
                          @foreach ($tagihans as $tagihan)
                          @if (\Auth::user()->id == $tagihan->user_id && $tagihan->status!=2)
                          <div class="card">
                            <h5 class="card-header" style="font-weight:bold;">{{@$tagihan->invoice}}</h5>
                            <div class="card-body">
                              <p class="card-text" style="padding: 5px 0 10px 12px; font-size:16px;">Rp {{@$tagihan->jml_bayar}}</p>
                              <div class="buttondetail" style="padding-left:12px; padding-bottom:5px;">
                                <a href="/purchase" id="bayar" class="btn btn-success" style="padding:6px 18px; border-radius:5px;">Bayar</a>
                              </div>
                            </div>
                          </div>
                          <div class="divider"></div>
                          @endif
                          @endforeach
                          {{-- @endfor --}}
                        </div>
                        <div class="col text-right">
                        <a href="/tagihanaktif" id="detail" class="btn btn-warning" style="padding:6px 18px; justify-content:right; align-items:right;">Detail</a>
                        </div>
                      </div>
                      <div class="col w-50">
                        <div class="history">
                          <h2>Riwayat Tagihan</h2>
                        </div>
                        <div class="cardContainer">
                          @foreach ($tagihans as $tagihan)
                          {{-- @for($i=0; $i<4; $i++) --}}
                          @if (\Auth::user()->id == $tagihan->user_id && $tagihan->status==2)
                          <div class="card">
                            <h5 class="card-header" style="font-weight:bold;">Invoice {{$tagihan->invoice}}</h5>
                            <div class="card-body">
                              <p class="card-text rounded-pill" style="padding: 5px 0 10px 12px; font-size:16px;">Rp {{$tagihan->jml_tagih}}</p>
                            </div>
                          </div>
                          <div class="divider"></div>
                          @endif
                          {{-- @endfor --}}
                          @endforeach
                      </div>
                      <div class="col text-right">
                        <a href="/tagihanriwayat" id="detail" class="btn btn-warning" style="padding:6px 18px; border-radius:5px;">Detail</a>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="hide-desktop">
                  <div class="wrap">
                      <div class="tagihan">
                          <h2 style="padding-bottom:1rem;">Tagihan Aktif</h2>
                      </div>
                      <div class="cardContainer">
                        @foreach ($tagihans as $tagihan)
                        {{-- @for($i=0; $i<3; $i++) --}}
                        @if (\Auth::user()->id == $tagihan->user_id && $tagihan->status!=2)
                        <div class="card">
                          <h5 class="card-header" style="font-weight:bold;">Invoice {{$tagihan->invoice}}</h5>
                          <div class="card-body">
                            <p class="card-text" style="padding: 5px 0 10px 12px; font-size:24px;">Rp {{$tagihan->jml_bayar}}</p>
                            <div class="buttondetail" style="padding-left:12px; padding-bottom:5px;">
                              <a href="/payment" id="bayar" class="btn btn-success rounded-pill" style="padding:6px 18px;">Bayar</a>
                            </div>
                          </div>
                        </div>
                        <div class="divider"></div>
                        @endif
                        {{-- @endfor --}}
                        @endforeach
                      </div>
                      <div class="col text-right">
                          <a href="/tagihanaktif" id="detail" class="btn btn-warning rounded-pill" style="padding:6px 18px; justify-content:right; align-items:right;">Detail</a>
                      </div>
                  </div>
                  <div class="wrap">
                      <div class="history">
                        <h2 style="padding-bottom:1rem;">Riwayat Tagihan</h2>
                      </div>
                    <div class="cardContainer">
                      @foreach ($tagihans as $tagihan)
                      @if (\Auth::user()->id == $tagihan->user_id && $tagihan->status==2)
                      {{-- @for($i=0; $i<3; $i++) --}}
                      <div class="card">
                        <h5 class="card-header" style="font-weight:bold;">Invoice {{$tagihan->invoice}}</h5>
                        <div class="card-body">
                          <p class="card-text rounded-pill" style="padding: 5px 0 10px 12px; font-size:24px;">Rp {{$tagihan->jml_tagih}}</p>
                        </div>
                      </div>
                      <div class="divider"></div>
                      {{-- @endfor --}}
                      @endif
                      @endforeach
                    </div>
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
                        {{-- <button type="button" class="btn btn-success btn-sm">
                          <img src="" alt="" class="rounded">
                          <span class="material-icons" id="wa">
                            sms
                            </span>
                          <p>Whatsapp</p>
                        </button> --}}
                        <button type="button" style="background-color: #3EB772; border:none; border-radius:10px; padding:10px 20px;">
                          <a href="https://wa.me/6281335625529" target="_blank" rel="noopener noreferrer">
                            <img src="{{ URL::asset('global_assets/images/wanew.png') }}" height="34px">
                          </a>
                        </button>
                      </div>
                      <div class="col text-left">
                        {{-- <button type="button" class="btn btn-primary btn-sm" id="btnmail">
                          <img src="" alt="" class="rounded">
                          <span class="material-icons" id="mail">
                            mail
                            </span>
                          <p>Email</p>
                        </button> --}}
                        <button type="button" style="background-color: #3EB772; border:none; border-radius:10px; padding:10px 20px;">
                          <a href="mailto:cs@nore.web.id">
                            <img src="{{ URL::asset('global_assets/images/mailnew.png') }}" height="34px">
                          </a>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="copyright">
                  <p style="text-align: center">2020. Nore Inovasi.</p>
                </div>
                <div class="footer">
                <div class="split"></div>
                  @include('client.footer')
                </div>
      </div>
  </div>
    <!-- Bootstrap JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> --}}
    <script  src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> --}}
    <script>
      $(".slider").owlCarousel({
        loop: true,
      });

      $('#user_id').ready(function(){
        var id_proyek = $('#user_id option:selected').val();
        var pnama = $('#user_id option:selected').data('pnama');
        
        $('#nama').val(pnama);
        $('#select_proyek').find('option').not(':first').remove();
        $('#nama_proyek').val('');
        
        $.ajax({
          type: 'get',
          url : '{{url("getkadaluarsa")}}/'+id_proyek,
          success : function(data){
            // $('#kadaluarsa').val(data);
            $('#kadaluarsa').text(data);
            console.log('Success');
          },
          error:function(data){
            console.log('Error',data);
			}
		});
		
		$.ajax({
			url : '{{url("getproyek")}}/'+id_proyek,
			type: 'get',
			dataType: 'json',
			success : function(res){
				var len = 0;
				if(res['data'] != null){
					len = res['data'].length;
				}
				// alert(len);
				if(len > 0){
					// Read data and create <option >
						for(var i=0; i<len; i++){
							
							var id = res['data'][i].id;
							var website = res['data'][i].website;
							
							var option = "<option value='"+id+"'>"+website+"</option>"; 
							
							$("#select_proyek").append(option); 
						}
					}
					console.log('Success2');
				},
				error:function(data){
					console.log('Error2',data);
				}
			});
			
		});

    </script>
</body>
</html>