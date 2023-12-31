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
    {{-- <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css"> --}}
    {{-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet"> --}}
    {{-- carousel --}}
    <link rel="stylesheet" href="{{asset('global_assets/owlcarousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{asset('global_assets/owlcarousel/dist/assets/owl.theme.default.min.css') }}">
    {{-- fixed --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    {{-- script --}}
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <style>
      body{
      font-family: 'Raleway', sans-serif !important;
      margin:0;
      padding:0;
      }

      h2{
          font-weight: bold !important;
          line-height: 14px !important;
      }

      h3{
          font-weight: bold;
      }

      p{
        font-size:14px;
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

      #btnmail{
        padding-right:14px;
        padding-left:14px;
      }

    .wrapper {
      display: flex;
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

      .dekstop-tagihan{
        display:none;
      }

      #task-baru{
        padding-bottom:1.5rem;
      }

      .grid-repeat{
        
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

      .mobile-tagihan{
        display: none;
      }

      /* .cardket{
        flex:1 0 auto;
      } */

    }

    @media (min-width: 1200px){
      .container {
      max-width: 100%;
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

    /* grid repeat */

    .grid-repeat{
      display: grid;
      grid-column-gap: 1rem;
      grid-row-gap: 1rem;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }

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
        <div class="wrap">
          <div class="greeting">
            <div class="row">
              <div class="col">
                <p style="margin: 0 0;">Selamat Datang</p>
                <h1 style="font-weight:bold;">{{\Auth::user()->nama}}</h1>
              </div>
              <div class="col text-right" style="font-size:16px;">
                @if (@$highproyek->tipe=='80')
                <a style="background-color: #D4AF37; color:#fff; padding:5px 10px; border-radius:10px;">
                  Pelanggan Premium
                </a>
                @elseif(@$highproyek->tipe=='90')
                <a style="background-color: grey; color:#fff; padding:4px 6px; border-radius:10px;">Pelanggan Prioritas</a>
                @else
                <a style="background-color: #fff; color:#242424; padding:4px 6px; border-radius:10px;">Pelanggan Simple</a>
                @endif
              </div>
            </div>
          </div>
          <div class="website">
            <h3 style="padding-top: 1em;">Website Langganan</h3>
              <p style="padding-bottom:0.3em;">Total Langganan : <span style="font-weight: bold; font-size:24px;">{{@$website}}</span></p>
            </div>
              <div class="dekstop-tagihan">
                @if (count($proyeks)>3)
                  <div class="owl-carousel owl-theme owl-loaded">
                    <div class="row">
                    @foreach ($proyeks as $proyek)
                        <div class="col" style="display:flex;">
                          <div class="card" style="display:flex; align-items:stretch; border:none; border-radius:10px; background-color:#eeee; padding:10px;">
                            <div class="card-body cardket">
                              <div class="row">
                                <div class="col">
                                  <h6 id="namawebsite" class="card-title" style="margin-bottom: 0; padding: 0 0 2px 0; font-weight:bold; ">{{$proyek->website}}</h6>
                                </div>
                                <div class="col text-right">
                                  @if (@$proyek->tagihan->status=='0')
                                  <a style="color:#fff; font-weight:bold; background-color: #BE1600; padding:5px 12px; border-radius:20px; text-align:center; font-size:10px;">Belum dibayar</a>
                                  @elseif(@$proyek->tagihan->status=='1')
                                  <a style="color:#fff; font-weight:bold; background-color: #ffaf42; padding:5px 12px; border-radius:20px; text-align:center; font-size:10px;">Terbayar Sebagian</a>
                                  @elseif(@$proyek->tagihan->status=='2')
                                  <a style="color:#fff; font-weight:bold; background-color: #3EB772; padding:5px 12px; border-radius:20px; text-align:center; font-size:10px;">Sudah dibayar</a>
                                  @else
                                  <a style="color:#fff; font-weight:bold; background-color: grey; border:black; padding:5px 12px; border-radius:20px; text-align:center; font-size:10px;">Belum Ada Tagihan</a>
                                  @endif
                                </div>
                              </div>
                            </div>
                            <div class="row cardket" style="padding-top:1rem;">
                              <div class="col">
                                @if (@$proyek->tipe==80)
                                  <a style="background-color: #D4AF37; color:#fff; padding:4px 6px; border-radius:10px;">
                                    Premium
                                  </a>
                                @elseif(@$proyek->tipe==90)
                                  <a style="background-color: grey; color:#fff; padding:4px 6px; border-radius:10px;">Prioritas</a>
                                @elseif(@$proyek->tipe==99)
                                  <a style="background-color: #fff; color:#242424; padding:4px 6px; border-radius:10px;">Simple</a>
                                @else
                                  <p>Tidak ada</p>
                                @endif
                              </div>
                            </div>
                            <div class="row cardket" style="padding-top:1rem;">
                              <div class="col">
                                <p>Hingga : <span style="font-weight: bold;">{{date('j F Y',strtotime(@$proyek->masa_berlaku))}}</span></p>
                              </div>
                            </div>
                            <div class="row cardket" style="padding-top:2rem;">
                              <div class="col text-left">
                                @if (@$proyek->tagihan->status!='2')
                                <p>Tagihan :</p>
                                <h5 style="font-weight: bold;">Rp. {{number_format(@$proyek->tagihan->jml_tagih,0,',','.')}},- </h5>  
                                @endif
                              </div>
                              <div class="col text-right">
                                @if (@$proyek->tagihan->status!='2')
                                <div class="buttondetail" style="padding-left:12px; padding-bottom:5px;">
                                  <a href="/payment" class="btn btn-success" style="border-radius:5px; padding:10px 20px; font-weight:bold;">Bayar</a>
                                </div>
                                @endif 
                              </div>
                            </div>
                          </div>
                        </div>
                        @endforeach
                      </div>
                  </div>
                  <div class="owl-dots"></div>
                @elseif(count($proyeks)<1)
                  <div class="row">
                    <div class="col">
                      <p style="text-align: center; padding-top:1rem;">Belum Ada Website Langganan</p>
                    </div>
                  </div>
                @else
                  <div class="row">
                    @foreach ($proyeks as $proyek)
                      <div class="col">
                        <div class="card" style="padding:10px;border:none; border-radius:10px; background-color:#eeee;">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-sm-6">
                                <h6 id="namawebsite" class="card-title" style="margin-bottom: 0; padding: 0 0 2px 0; font-weight:bold; ">{{@$proyek->website}}</h6>
                              </div>
                              <div class="col-sm-6 text-right">
                                @if (@$proyek->tagihan->status=='0')
                                <a  style="color:#fff; font-weight:bold; background-color: #BE1600; padding:5px 12px; border-radius:20px; text-align:center; font-size:9px">Belum dibayar</a>
                                @elseif(@$proyek->tagihan->status=='1')
                                <a  style="color:#fff; font-weight:bold; background-color:#ffaf42; padding:5px 12px; border-radius:20px; text-align:center; font-size:9px">Terbayar Sebagian</a>
                                @elseif(@$proyek->tagihan->status=='2')
                                <a style="color:#fff; font-weight:bold; background-color: #3EB772; padding:5px 12px; border-radius:20px; text-align:center; font-size:9px;">Sudah dibayar</a>
                                @else
                                <a style="color:#fff; font-weight:bold; background-color: grey; border:black; padding:5px 12px; border-radius:20px; text-align:center; font-size:9px;">Belum Ada Tagihan</a>
                                @endif  
                              </div>
                          </div>
                          <div class="row" style="padding-top:1rem;">
                            <div class="col">
                              @if (@$proyek->tipe==80)
                              <a style="background-color: #D4AF37; color:#fff; padding:4px 6px; border-radius:10px;">
                                Premium
                              </a>
                              @elseif(@$proyek->tipe==90)
                                <a style="background-color: grey; color:#fff; padding:4px 6px; border-radius:10px;">Prioritas</a>
                              @elseif(@$proyek->tipe==99)
                                <a style="background-color: #fff; color:#242424; padding:4px 6px; border-radius:10px;">Simple</a>
                              @else
                                <p>Tidak ada</p>
                              @endif
                            </div>
                          </div>
                          <div class="row" style="padding-top:1rem">
                            <div class="col">
                              <p>Hingga : <span style="font-weight: bold;">{{date('j F Y',strtotime(@$proyek->masa_berlaku))}}</span></p>
                            </div>
                          </div>
                          <div class="row" style="padding-top:1rem;">
                            <div class="col text-left">
                              @if (@$proyek->tagihan->status!='2')
                              <p>Tagihan :</p>
                              <h5 style="font-weight: bold;">Rp. {{number_format(@$proyek->tagihan->jml_tagih,0,',','.')}},- </h5>  
                              @endif
                            </div>
                            <div class="col text-right">
                              @if (@$proyek->tagihan->status!='2')
                              <div class="buttondetail" style="padding-left:12px; padding-bottom:5px;">
                                <a href="/payment" class="btn btn-success" style="border-radius:5px; padding:10px 20px; font-weight:bold;">Bayar</a>
                              </div>
                              @endif 
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                @endif
          </div>
          <div class="mobile-tagihan">
            @if (count($proyeks)>3)
            <div class="owl-carousel owl-theme owl-loaded">
              @foreach ($proyeks as $proyek)
                <div class="col" style="display:flex; flex:1 0 auto; height:100%;">
                  <div class="card" style="padding:10px;border:none; border-radius:10px; background-color:#eeee; position:relative; over-flow:hidden; display:flex; flex-direction:column; align-item:stretch;">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                            <p id="namawebsite" class="card-title" style="margin-bottom: 0; padding: 0 0 2px 0; font-weight:bold; ">{{@$proyek->website}}</p>    
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            @if (@$proyek->tagihan->status=='0')
                            <a style="color:#fff; font-weight:bold; background-color: #BE1600; padding:5px 12px; border-radius:20px; text-align:center; font-size:12px;">Belum dibayar</a>
                            @elseif(@$proyek->tagihan->status=='1')
                            <a style="color:#fff; font-weight:bold; background-color: #ffaf42; padding:5px 12px; border-radius:20px; text-align:center; font-size:12px;">Terbayar Sebagian</a>
                            @elseif(@$proyek->tagihan->status=='2')
                            <a style="color:#fff; font-weight:bold; background-color: #3EB772; padding:5px 12px; border-radius:20px; text-align:center; font-size:12px;">Sudah dibayar</a>
                            @else
                            <a style="color:#fff; font-weight:bold; background-color: grey; border:black; padding:5px 12px; border-radius:20px; text-align:center; font-size:12px;">Belum Ada Tagihan</a>
                            @endif
                          </div>
                      </div>
                      <div class="row" style="padding-top:1rem;">
                        <div class="col">
                          @if (@$proyek->tipe==80)
                          <a style="background-color: #D4AF37; color:#fff; padding:4px 6px; border-radius:10px;">
                            Premium
                          </a>
                          @elseif(@$proyek->tipe==90)
                            <a style="background-color: grey; color:#fff; padding:4px 6px; border-radius:10px;">Prioritas</a>
                          @elseif(@$proyek->tipe==99)
                            <a style="background-color: #fff; color:#242424; padding:4px 6px; border-radius:10px;">Simple</a>
                          @else
                            <p>Tidak ada</p>
                          @endif
                        </div>
                      </div>
                      <div class="row" style="padding-top:1rem">
                        <div class="col">
                          <p>Hingga : <span style="font-weight: bold;">{{date('j F Y',strtotime(@$proyek->masa_berlaku))}}</span></p>
                        </div>
                      </div>
                      <div class="row" style="padding-top:1rem;">
                        <div class="col">
                          @if (@$proyek->tagihan->status!='2')
                          <p>Tagihan :</p>
                          <p style="font-weight: bold;">Rp.{{number_format(@$proyek->tagihan->jml_tagih,0,',','.')}},- </p>  
                          @endif
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          @if (@$proyek->tagihan->status!='2')
                          <div class="buttondetail" style="padding-bottom:5px;">
                            <a href="/payment" class="btn btn-success" style="border-radius:5px; padding:10px 20px; font-weight:bold;">Bayar</a>
                          </div>
                          @endif 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
            </div>
            <div class="owl-dots"></div>
            @elseif(count($proyeks)<1)
            <div class="row">
              <div class="col">
                <p style="text-align: center; padding-top:1rem;">Belum Ada Website Langganan</p>
              </div>
            </div>
            @else
            <div class="row">
              @foreach ($proyeks as $proyek)
                <div class="col">
                  <div class="card" style="padding:10px;border:none; border-radius:10px; background-color:#eeee;">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h6 id="namawebsite" class="card-title" style="margin-bottom: 0; padding: 0 0 2px 0; font-weight:bold; ">{{@$proyek->website}}</h6>
                        </div>
                      <div class="col text-right">
                        @if (@$proyek->tagihan->status=='0')
                        <a  style="color:#fff; font-weight:bold; background-color: #BE1600; padding:5px 12px; border-radius:20px; text-align:center; font-size:12px">Belum dibayar</a>
                        @elseif(@$proyek->tagihan->status=='1')
                        <a  style="color:#fff; font-weight:bold; background-color:#ffaf42; padding:5px 12px; border-radius:20px; text-align:center; font-size:12px">Terbayar Sebagian</a>
                        @elseif(@$proyek->tagihan->status=='2')
                        <a style="color:#fff; font-weight:bold; background-color: #3EB772; padding:5px 12px; border-radius:20px; text-align:center; font-size:12px;">Sudah dibayar</a>
                        @else
                        <a style="color:#fff; font-weight:bold; background-color: grey; border:black; padding:5px 12px; border-radius:20px; text-align:center; font-size:12px;">Belum Ada Tagihan</a>
                        @endif  
                      </div>
                    </div>
                    <div class="row" style="padding-top:1rem;">
                      <div class="col">
                        @if (@$proyek->tipe==80)
                        <a style="background-color: #D4AF37; color:#fff; padding:4px 6px; border-radius:10px;">
                          Premium
                        </a>
                        @elseif(@$proyek->tipe==90)
                          <a style="background-color: grey; color:#fff; padding:4px 6px; border-radius:10px;">Prioritas</a>
                        @elseif(@$proyek->tipe==99)
                          <a style="background-color: #fff; color:#242424; padding:4px 6px; border-radius:10px;">Simple</a>
                        @else
                          <p>Tidak ada</p>
                        @endif
                      </div>
                    </div>
                    <div class="row" style="padding-top:1rem">
                      <div class="col">
                        <p>Hingga : <span style="font-weight: bold;">{{@$proyek->masa_berlaku}}</span></p>
                      </div>
                    </div>
                    <div class="row" style="padding-top:1rem;">
                      <div class="col text-left">
                        @if (@$proyek->tagihan->status!='2')
                        <p>Tagihan :</p>
                        <h5 style="font-weight: bold;">Rp. {{number_format(@$proyek->tagihan->jml_tagih,0,',','.')}},- </h5>  
                        @endif
                      </div>
                      <div class="col text-right">
                        @if (@$proyek->tagihan->status!='2')
                        <div class="buttondetail" style="padding-left:12px; padding-bottom:5px;">
                          <a href="/payment" class="btn btn-success" style="border-radius:5px; padding:10px 20px; font-weight:bold;">Bayar</a>
                        </div>
                        @endif 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @endif
          </div>
        </div>
        <div class="wrap">
          <div class="task">
            <h2>Task</h2>
            <p style="padding-bottom:1rem;">Sisa Pengoperasian : <span style="font-weight: bold; font-size:24px;">{{@$taskall - @$taskcounts}}</span></p>
          </div>
          <div class="grid-repeat">
            <div class="task-baru">
              <h5 style="font-weight: bold; text-align:center;" id="task-baru">Task Baru</h5>
              @if ($new==0)
              <p style="text-align: center; padding-top:1rem;">Belum ada task baru</p>
              @else
              <?php $count = 0; ?>
              @foreach ($tasks as $task)
              @if (@$task->status=='1')
             
              @if ($count == 2)
              @break
              @endif
                  <div class="card" style="background-color:#fff; border:none;">
                    <div class="card-header" style="background-color:#4A708B">
                      <p style="font-weight: bold; color:#fff;">{{@$task->proyek->website}}</p>
                    </div>
                    <div class="card-body" style="background-color:#fafafa;">
                      <div class="row">
                        <div class="col">
                          <p style="">Handler</p>
                        </div>
                        <div class="col">
                          @if ($task->handler==null)
                            <p>Belum ada handler</p>
                          @else
                            <p>{{$task->assign->nama}}</p>
                          @endif
                        </div>
                      </div>
                      <div class="row" style="padding-top:1rem;">
                        <div class="col"><p>Tanggal input</p></div>
                        {{-- <div class="col">:</div> --}}
                        
                        <div class="col"><p>{{date('j F Y', strtotime(@$task->created_at))}}</p></div>
                      </div>
                      <div class="row" style="padding-top:1rem;">
                        <div class="col"><p>Keterangan</p></div>
                        {{-- <div class="col">:</div> --}}
                        <div class="col"><p>{{@$task->kebutuhan}}</p></div>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="padding-top:1em;"></div>
                  <?php $count++; ?>
                  @endif
                  @endforeach
                @endif
              </div>
              <div class="task-dikerjakan">
                <h5 style="font-weight: bold; text-align:center;">Task Sedang Dikerjakan</h5>
                @if ($ongoing==0)
                <div class="card" style="margin-top:1rem; background-color:#fafafa; border:none; padding-top:1rem; padding-bottom:1rem; border-radius:10px;">
                  <p style="text-align: center; font-size:14px;">Belum ada task yang dikerjakan</p>
                </div>
                @else
                <?php $count = 0; ?>
                @foreach ($tasks as $task)
                  @if (@$task->status=='2')
               
                  @if ($count == 2)
              @break
              @endif
                  <div class="card" style="background-color: #fff; border:none;">
                    <div class="card-header" style="background-color:rgb(255, 196, 0)">
                      <p style="font-weight: bold;">{{@$task->proyek->website}}</p>
                    </div>
                    <div class="card-body" style="background-color: #fafafa">
                      <div class="row">
                        <div class="col">
                          <p style="">Handler</p>
                        </div>
                        <div class="col">
                          @if (@$task->handler==null)
                            <p>Belum ada handler</p>
                          @else
                            <p>{{@$task->assign->nama}}</p>
                          @endif
                        </div>
                      </div>
                      <div class="row" style="padding-top:1rem;">
                        <div class="col"><p>Tanggal input</p></div>
                        <div class="col"><p>{{date('j F Y', strtotime(@$task->created_at))}}</p></div>
                      </div>
                      <div class="row" style="padding-top:1rem;">
                        <div class="col"><p>Keterangan</p></div>
                        {{-- <div class="col">:</div> --}}
                        <div class="col"><p>{{@$task->kebutuhan}}</p></div>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="padding-top:1em;"></div>
                  <?php $count++; ?>
                  @endif
                @endforeach
                @endif
              </div>
              <div class="task-selesai">
                <h5 style="font-weight: bold; text-align:center;">Task Selesai</h5>
                @if ($done==0)
                <div class="card" style="margin-top:1rem; background-color:#fafafa; border:none; padding-top:1rem; padding-bottom:1rem; border-radius:10px;">
                  <p style="text-align: center; font-size:14px;">Belum ada task selesai</p>
                </div>
                @else
                <?php $count = 0; ?>
                @foreach ($tasks as $task)
                  @if (@$task->status=='3')
             
                    @if ($count == 2)
              @break
              @endif
                  <div class="card" style="background-color: #fff; border:none">
                    <div class="card-header" style="background-color:	grey">
                      <p style="font-weight: bold; color:#ffff;">{{@$task->proyek->website}}</p>
                    </div>
                    <div class="card-body" style="background-color: #fafafa">
                      <div class="row">
                        <div class="col">
                          <p>Handler</p>
                        </div>
                        <div class="col">
                          @if ($task->handler==null)
                            <p>Belum ada handler</p>
                          @else
                            <p>{{@$task->assign->nama}}</p>
                          @endif
                        </div>
                      </div>
                      <div class="row" style="padding-top:1rem;">
                        <div class="col"><p>Tanggal input</p></div>
                        {{-- <div class="col">:</div> --}}
                        
                        <div class="col"><p>{{date('j F Y', strtotime(@$task->created_at))}}</p></div>
                      </div>
                      <div class="row" style="padding-top:1rem;">
                        <div class="col"><p>Keterangan</p></div>
                        {{-- <div class="col">:</div> --}}
                        <div class="col"><p>{{@$task->kebutuhan}}</p></div>
                      </div>
                    </div>
                  </div>
                  <?php $count++; ?>
                  @endif 
                @endforeach  
                @endif
              </div>
          </div>
          @if ($taskcounts>0)
          <div class="col text-right" style="padding-top:1rem;">
            <a href="/taskclients" id="detail" class="btn btn-warning" style="padding:6px 18px; justify-content:right; align-items:right; border-radius:5px;">Detail</a>
          </div>
          @endif
        </div>
                <div class="hide-mobile">
                  <div class="wrap">
                    <div class="row">
                      <div class="col w-50">
                        <div class="tagihan">
                          <h2>Tagihan Aktif</h2>
                        </div>
                        <div class="cardContainer">
                          @if ($tagihanactives==0)
                          <h6 style="text-align: center; padding-top:1rem;">Tidak tagihan aktif</h6>
                          @else
                          <?php $count = 0; ?>
                          @foreach ($tagihans as $tagihan)
                          @if (\Auth::user()->id == @$tagihan->user_id && @$tagihan->status!=2)
                          @php
                              $dptagihan_terbayar = 0;
                              if ($tagihan->rekapdptagihan) {
                                $dptagihan_terbayar = $tagihan->rekapdptagihan->jml_terbayar;
                              }

                              $tagihan_terbayar = 0;
                              if ($tagihan->rekaptagihan) {
                                $tagihan_terbayar = $tagihan->rekaptagihan->jml_terbayar;
                              }

                              $terbayar = $dptagihan_terbayar + $tagihan_terbayar;
                              $total = $tagihan->nominal - $tagihan->diskon;
                          @endphp
                          @if ($count == 2)
                        @break
                        @endif
                          <div class="card">
                            <div class="card-header">
                              <div class="row">
                                <div class="col">
                                  <h5 style="font-weight:bold;">{{@$tagihan->nama_proyek}}</h5>
                                  <p style="font-weight:bold;">{{@$tagihan->invoice}}</p>
                                </div>
                                <div class="col text-right">
                                    @if ($tagihan->status==0)
                                    <a style="color:#fff; font-weight:bold; background-color: #BE1600; padding:5px 12px; border-radius:20px; text-align:center; font-size:12px;">Belum dibayar</a>
                                    @else
                                    <a style="color:#fff; font-weight:bold; background-color: #ffaf42; padding:5px 12px; border-radius:20px; text-align:center; font-size:12px;">Terbayar sebagian</a>
                                    @endif
                                </div>
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="col">
                                  <p class="card-text" style="padding: 5px 0 10px 12px; font-size:16px;">Total Tagihan : </p>
                                  <p style="padding: 0 0 10px 12px; font-size:16px;">Rp {{number_format(($total),0,',','.')}},-</p>
                                </div>
                                <div class="col">
                                  <p class="card-text" style="padding: 5px 0 10px 12px; font-size:16px;">Sudah terbayar : </p>
                                  <p style="padding: 0 0 10px 12px; font-size:16px;">Rp {{number_format(($terbayar),0,',','.')}},-</p>
                                </div>
                                <div class="col">
                                  <p class="card-text" style="padding: 5px 0 10px 12px; font-size:16px;">Harus dibayar : </p>
                                  <p style="padding: 0 0 10px 12px; font-size:16px; font-weight:bold;">Rp {{number_format(($total - $terbayar),0,',','.')}},-</p>
                                </div>
                              </div>
                              <div class="buttondetail" style="padding-left:12px; padding-bottom:5px;">
                                {{-- <a href="{{url('purchase',$tagihan->id)}}" class="btn btn-success" id="bayar" style="border-radius:5px; padding:10px 20px; font-weight:bold;">Bayar</a> --}}
                                <a href="/payment" class="btn btn-success" style="border-radius:5px; padding:10px 20px; font-weight:bold;">Bayar</a>
                              </div>  
                            </div>
                          </div>
                          <div class="divider"></div>
                          <?php $count++; ?>
                          @endif
                          @endforeach
                          <div class="col text-right">
                            <a href="/tagihanaktif" id="detail" class="btn btn-warning" style="padding:6px 18px; justify-content:right; align-items:right;">Detail</a>
                          </div>
                          @endif
                        </div>
                      </div>
                      <div class="col w-50">
                        <div class="history">
                          <h2>Riwayat Tagihan</h2>
                        </div>
                        <div class="cardContainer">
                          @if (count($tagihanhistories)==0)
                            <h6 style="text-align: center; padding-top:1rem;">Tidak ada history</h6>
                          @else
                          <?php $count = 0; ?>
                            @foreach ($tagihans as $tagihan)
                              @if (\Auth::user()->id == @$tagihan->user_id && @$tagihan->status==2)
                              
                              @if ($count == 2)
              @break
              @endif
                              <div class="card">
                                <div class="card-header">
                                  <div class="row">
                                    <div class="col">
                                      <h5 style="font-weight:bold;">{{@$tagihan->nama_proyek}}</h5>
                                      <p style="font-weight:bold;">{{@$tagihan->invoice}}</p>
                                    </div>
                                    <div class="col text-right">
                                      <a style="color:#fff; font-weight:bold; background-color: gray; padding:5px 12px; border-radius:20px; text-align:center; font-size:14px;">Lunas</a>
                                    </div>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col">
                                      <p style="padding: 5px 0 10px 12px; font-size:16px;">Total Tagihan</p>
                                      <p style="padding: 5px 0 10px 12px; font-size:16px;">Rp {{number_format((@$tagihan->jml_tagih),0,',','.')}},-</p>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <p style="padding: 5px 0 10px 12px; font-size:16px; font-style:italic;">Dibayar pada {{date("j F Y", strtotime(@$tagihan->updated_at))}}</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="divider"></div>
                              <?php $count++; ?>
                            @endif
                            @endforeach
                            <div class="col text-right">
                              <a href="/tagihanriwayat" id="detail" class="btn btn-warning" style="padding:6px 18px; justify-content:right; align-items:right; border-radius:5px;">Detail</a>
                            </div>
                          @endif
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
                        @if ($tagihanactives==0)
                        <h6 style="text-align: center; padding-top:1rem;">Tidak tagihan aktif</h6>
                        @else
                        <?php $count = 0; ?>
                        @foreach ($tagihans as $tagihan)
                        @if (\Auth::user()->id == @$tagihan->user_id && @$tagihan->status!=2)
                        @php
                              $dptagihan_terbayar = 0;
                              if ($tagihan->rekapdptagihan) {
                                $dptagihan_terbayar = $tagihan->rekapdptagihan->jml_terbayar;
                              }

                              $tagihan_terbayar = 0;
                              if ($tagihan->rekaptagihan) {
                                $tagihan_terbayar = $tagihan->rekaptagihan->jml_terbayar;
                              }

                              $terbayar = $dptagihan_terbayar + $tagihan_terbayar;
                              $total = $tagihan->nominal - $tagihan->diskon;
                          @endphp
                        @if ($count == 2)
              @break
              @endif
                        <div class="card">
                          <div class="card-header">
                            <h5 style="font-weight:bold;">{{@$tagihan->nama_proyek}}</h5>
                            <p style="font-weight:bold;">{{@$tagihan->invoice}}</p>
                          </div>
                          <div class="card-body">
                            <p class="card-text" style="padding: 5px 0 10px 12px; font-size:16px;">Rp {{number_format((@$tagihan->jml_tagih),0,',','.')}},-</p>
                            <div class="buttondetail" style="padding-left:12px; padding-bottom:5px;">
                              <a href="/payment" class="btn btn-success" style="border-radius:5px; padding:10px 20px; font-weight:bold;">Bayar</a>
                            </div>  
                          </div>
                        </div>
                        <div class="divider"></div>
                        <?php $count++; ?>
                        @endif
                        @endforeach
                      </div>
                      <div class="col text-right">
                          <a href="/tagihanaktif" id="detail" class="btn btn-warning" style="padding:6px 18px; justify-content:right; align-items:right; border-radius:10px;">Detail</a>
                      </div>
                        @endif
                  </div>
                  <div class="wrap">
                      <div class="history">
                        <h2 style="padding-bottom:1rem;">Riwayat Tagihan</h2>
                      </div>
                    <div class="cardContainer">
                      @if (count($tagihanhistories)==0)
                      <h6 style="text-align: center; padding-top:1rem;">Tidak ada history</h6>
                      @else
                      <?php $count = 0; ?>
                      @foreach ($tagihans as $tagihan)
                      @if (\Auth::user()->id == @$tagihan->user_id && @$tagihan->status==2)
                     
                      @if ($count == 2)
              @break
              @endif
                      <div class="card">
                        <div class="card-header">
                          <div class="row">
                            <div class="col">
                              <h5 style="font-weight:bold;">{{@$tagihan->nama_proyek}}</h5>
                              <p style="font-weight:bold;">{{@$tagihan->invoice}}</p>
                            </div>
                            <div class="col text-right">
                              <a style="color:#fff; font-weight:bold; background-color: gray; padding:5px 12px; border-radius:20px; text-align:center; font-size:14px;">Lunas</a>
                            </div>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <p style="padding: 5px 0 10px 12px; font-size:16px;">Total Tagihan</p>
                              <p style="padding: 5px 0 10px 12px; font-size:16px;">Rp {{number_format((@$tagihan->jml_tagih),0,',','.')}},-</p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <p style="padding: 5px 0 10px 12px; font-size:16px; font-style:italic;">Dibayar pada {{date("j F Y", strtotime(@$tagihan->updated_at))}}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="divider"></div>
                      <?php $count++; ?>
                      @endif
                      @endforeach
                      <div class="col text-right">
                        <a href="/tagihanriwayat" id="detail" class="btn btn-warning" style="padding:6px 18px; justify-content:right; align-items:right; border-radius:10px;">Detail</a>
                      </div>
                    @endif
                    </div>
                  </div>
                </div>
                <div class="wrap">
                  <div class="contact">
                    <h2>Pusat Bantuan</h2>
                    <div class="row">
                      <div class="col text-right">
                        <button type="button" style="background-color: #3EB772; border:none; border-radius:10px; padding:10px 20px;">
                          <a href="https://wa.me/628112772788/?text=Halo%20nama%20saya%20{{\Auth::user()->nama}}%20ingin%20bertanya" target="_blank" rel="noopener noreferrer">
                            <img src="{{ URL::asset('global_assets/images/wanew.png') }}" height="34px">
                          </a>
                        </button>
                      </div>
                      <div class="col text-left">
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
                  <p style="text-align: center">2021. Nore Inovasi.</p>
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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    {{-- owlcarousel --}}
    <script src=" {{asset('global_assets/owlcarousel/dist/owl.carousel.min.js') }}"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> --}}
    <script>
      $(".owl-carousel").owlCarousel({
        items : 3,
        loop: true,
        stagePadding: 0
      });

    </script>
</body>
</html>