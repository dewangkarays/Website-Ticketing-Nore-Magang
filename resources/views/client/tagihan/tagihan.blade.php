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
    {{-- <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css"> --}}
    {{-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet"> --}}
    {{-- fixed --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    {{-- script --}}
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <style>
        body{
        font-family: 'Raleway', sans-serif !important;
        }


        h1{
            font-size: 24px !important ;
        }

        h2{
            font-weight: bold !important;
            padding-bottom: 1em;
            /* line-height: 14px !important; */
        }

        h3{
            font-weight: bold;
        }

        .tagihan-aktif h3, .tagihan-riwayat h3{
            padding-top:1em;
        }

        #tombol{
        padding: 0 !important;
        }

        .cardContainer{
            padding: 0 0 2em 0 !important;
        }

        /* .tanggal{
            padding-top:2em;
        } */

        .btn-warning{
          color:#ffff;
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

        h5{
          font-weight: bold;
        }

        .split{
          padding-top: 5em;
        }

        #detail{
          margin-top: 0.5em !important;
        }

        .card-body{
          padding: 0.8rem !important;
        }

        .divider{
          padding-bottom: 1 em;
        }

      /* sidebar */
      .wrapper {
      display: flex;
      width: 100%;
      /* align-items: stretch; */
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

      h5{
        font-size:16px;
      }

      .sidebar{
        display: none;
      }

      .copyright{
        display: none;
      }

      .hide-desktop{
        display: none;
      }

      .hide-mobile{
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

    .hide-mobile{
      display:none;
    }

    .container{
      margin-left: 250px;
      transition: all 0.3s;
    }

    #tombol{
      padding: 0 15px 0 !important;
    }

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
          <div class="hide-desktop">
            <div class="row">
              <div class="col-sm-8">
                <div class="tagihan-aktif" style="padding-top:1em;">
                  <div class="tagihan-head">
                    <h3>Tagihan Aktif</h3>      
                  </div>
                  <div class="cardContainer">
                    @if ($tagihanactives==0)
                      <p style="text-align:center;">Tidak ada tagihan aktif</p>
                    @else
                    @foreach ($tagihans as $tagihan)
                    @if (\Auth::user()->id == @$tagihan->user_id && @$tagihan->status!=2)
                      <div class="card" style="width:100%;">
                        <div class="card-body">
                          {{-- <div class="invoice"> --}}
                            <div class="row">
                              <div class="col">
                                <h5 class="card-title">{{@$tagihan->proyek->website}}</h5>
                                <p class="card-title" style="font-weight: bold;">Invoice {{@$tagihan->invoice}}</p>
                              </div>
                              <div class="col text-right">
                                @if (@$tagihan->status==0)
                                <a style="color:#fff; font-weight:bold; background-color: #BE1600; padding:5px 12px; border-radius:20px; text-align:center; font-size:14px;">Belum dibayar</a>
                                @else
                                <a style="color:#fff; font-weight:bold; background-color:#ffaf42; padding:5px 12px; border-radius:20px; text-align:center;">Terbayar sebagian</a>
                                @endif
                              </div>
                            </div>
                            <div class="row" style="padding-bottom:1rem;">
                              <div class="col">
                                <p class="card-text" style="font-style:italic;">{!!$tagihan->keterangan!!}</p>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">
                                <p class="card-text">Total Tagihan</p>
                                <p class="card-text" style="font-weight:bold;">Rp. {{number_format(((int)$tagihan['jml_tagih'] + (int)$tagihan['jml_bayar']),0,',','.')}}</p>
                              </div>
                              <div class="col">
                                <p class="card-text">Sudah Dibayar</p>
                                <p class="card-text" style="font-weight:bold;">Rp. {{number_format(@$tagihan->jml_bayar,0,',','.')}}</p>
                              </div>
                              <div class="col">
                                <p class="card-text">Harus dibayar</p>
                                <p class="card-text" style="font-weight:bold;">Rp. {{number_format(@$tagihan->jml_tagih,0,',','.')}}</p>
                              </div>
                              <div class="col text-right" id="tombol">
                                <a href="/payment" class="btn btn-success" id="bayar" style="border-radius:5px; padding:10px 20px; font-weight:bold;">Bayar</a>
                              </div>
                            </div>
                          {{-- </div> --}}
                        </div>
                      </div>
                    <div class="divider"></div>
                    @endif
                    @endforeach
                    <div class="row">
                      <div class="col">
                      </div>
                      <div class="col">
                      </div>
                      <div class="col text-right">
                        <a href="/tagihanaktif" class="btn btn-warning" id="detail" style="border-radius:5px; padding:10px 20px; font-weight:bold">Detail</a>
                      </div>
                    </div>    
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="tagihan-riwayat" style="padding-top:1em;">
                  <div class="tagihan-head">
                    <h3>Riwayat Tagihan</h3>      
                  </div>
                  <div class="cardContainer">
                    @if ($tagihanhistories==0)
                      <p style="text-align:center;">Tidak ada riwayat tagihan</p>
                    @else
                    @foreach ($tagihans as $tagihan)
                    @if (\Auth::user()->id == @$tagihan->user_id && @$tagihan->status==2)
                    <div class="col">
                      <div class="card" style="border:none; border-radius:5px; background-color:#eeee;">
                        <div class="card-body">
                          <div class="invoice" style="padding:1em;">
                            <div class="row">
                              <div class="col">
                                  <h5 class="card-title">{{@$tagihan->proyek->website}}</h5>
                                  <p class="card-title" style="font-weight: bold;">Invoice {{@$tagihan->invoice}}</p>
                                  <p class="card-text">Total tagihan Rp. {{number_format(((int)$tagihan['jml_tagih'] + (int)$tagihan['jml_bayar']),0,',','.')}}</p>
                                  <p class="card-text" style="font-style: italic;">Terbayar pada {{date("Y-m-d", strtotime(@$tagihan->updated_at))}}</p>
                              </div>
                              <div class="col">
                                <div class="col text-right" id="tombol">
                                  <a id="lunas" style="padding:5px 10px; background-color:#6c757d; border-radius:20px; color:#fff;">Lunas</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="divider"></div>
                    @endif
                    @endforeach
                    <div class="row">
                      <div class="col">
                      </div>
                      <div class="col">
                      </div>
                      <div class="col  text-right">
                        <a href="/tagihanriwayat" class="btn btn-warning" style="border-radius:5px; padding:10px 20px; font-weight:bold"id="detail">Detail</a>
                      </div>
                    </div>  
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="hide-mobile">
            <div class="tagihan-aktif">
              <div class="tagihan-head">
                <h3>Tagihan Aktif</h3>      
              </div>
              <div class="cardContainer">
                @foreach ($tagihans as $tagihan)
                @if (\Auth::user()->id == $tagihan->user_id && $tagihan->status!=2)
                <div class="card">
                  <div class="card-body">
                    <div class="invoice">
                      <div class="row">
                        <div class="col">
                          <h5 class="card-title">{{@$tagihan->proyek->website}}</h5>
                          <p class="card-title" style="font-weight: bold;">Invoice {{$tagihan->invoice}}</p>
                        </div>
                        <div class="col text-right" style="font-size:12px;">
                          @if ($tagihan->status==0)
                          <a style="color:#fff; font-weight:bold; background-color: #BE1600; padding:5px 12px; border-radius:20px; text-align:center;">Belum dibayar</a>
                          @else
                          <a style="color:#fff; font-weight:bold;background-color:#ffaf42; padding:5px 12px; border-radius:20px; text-align:center;">Terbayar sebagian</a>
                          @endif
                        </div>
                      </div>
                      <div class="row" style="padding-right:10px;">
                        <div class="col">
                          <p class="card-text" style="font-size:14px;">Total Tagihan</p>
                          <p class="card-text" style="font-weight: bold; font-size:14px;">Rp.<br> {{number_format(((int)$tagihan['jml_tagih'] + (int)$tagihan['jml_bayar']),0,',','.')}}</p>
                        </div>
                        <div class="col">
                          <p class="card-text" style="font-size:14px;">Sudah Dibayar</p>
                          <p class="card-text" style="font-weight: bold; font-size:14px;">Rp.<br> {{number_format($tagihan->jml_bayar,0,',','.')}}</p>
                        </div>
                        <div class="col">
                          <p class="card-text" style="font-size:14px;">Harus dibayar</p>
                          <p class="card-text" style="font-weight: bold; font-size:14px;">Rp.<br> {{number_format($tagihan->jml_tagih,0,',','.')}}</p>
                        </div>
                        <div class="col text-center" id="tombol">
                          <a href="{{url('purchase',$tagihan->id)}}" class="btn btn-success" id="bayar" style=" font-size:14px; border-radius:5px; padding:5px 10px; font-weight:bold;">Bayar</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="divider"></div>
                @endif
                @endforeach
                <div class="row">
                  <div class="col">
                  </div>
                  <div class="col">
                  </div>
                  <div class="col text-right">
                    <a href="/tagihanaktif" class="btn btn-warning" id="detail" style="border-radius:5px; padding:5px 10px; font-weight:bold; font-size:14px;">Detail</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="tagihan-riwayat">
              <div class="tagihan-head">
                <h3>Riwayat Tagihan</h3>      
              </div>
              <div class="cardContainer">
                @foreach ($tagihans as $tagihan)
                @if (\Auth::user()->id == $tagihan->user_id && $tagihan->status==2)
                  <div class="card" style="border:none; border-radius:5px; background-color:#eeee;">
                    <div class="card-body">
                      <div class="invoice" style="padding:1em;">
                        <div class="row">
                          <div class="col">
                            <h5 class="card-title">{{@$tagihan->proyek->website}}</h5>
                            <p class="card-title" style="font-weight: bold;">Invoice {{$tagihan->invoice}}</p>
                            <p class="card-text">Total tagihan Rp.  {{number_format(((int)$tagihan['jml_tagih'] + (int)$tagihan['jml_bayar']),0,',','.')}},-</p>
                            <p class="card-text" style="font-style: italic;">Terbayar pada {{date("Y-m-d", strtotime($tagihan->updated_at))}}</p>
                        </div>
                          <div class="col">
                            <div class="col text-right" id="tombol">
                              <a id="lunas" style="padding:5px 10px; background-color:#6c757d; border-radius:20px; color:#fff;">Lunas</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="divider"></div>
                @endif
                @endforeach
                {{-- @endfor --}}
                <div class="row">
                  <div class="col">
                  </div>
                  <div class="col">
                  </div>
                  <div class="col  text-right">
                    <a href="/tagihanriwayat" class="btn btn-warning"  style="border-radius:5px; padding:5px 10px; font-weight:bold; font-size:14px;" id="detail" id="detail">Detail</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="copyright">
            <p style="text-align: center">2021. Nore Inovasi.</p>
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