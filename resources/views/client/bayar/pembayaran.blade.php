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
    {{-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css"> --}}
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

        /* #jumlah{
          margin : 0 12px;
        } */

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
        font-size:24px !important;
        padding-bottom: 1em;
      }

      .container{
        margin-left:250px;
        transition: all 0.3s;
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
      <div class="form-pembayaran" style="padding-top:1em;">
        <div class="bayar-head">
          <h3 style="padding-top:1em;">Form Pembayaran</h3>      
        </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <p>Nama</p>
          </div>
          <div class="col-sm-8">
            <p>{{\Auth::user()->nama}}</p>
          </div>
        </div>
        <form method="POST" action="{{route('paymentclients.store')}}">
          @csrf
          {{-- <div class="form-group row">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Invoice</label>
            <div class="col-sm-8">
              @if ($tagihanuser2 != null)	
							<label class="col-form-label">{{$tagihanuser2->invoice}} - Rp. {{number_format($tagihanuser2->jml_tagih,0,',','.')}}</label>
							<input class="form-control" type="hidden" name="tagihan_id" id="tagihan_id" value="{{$tagihanuser2->id}}">
							@else
							<select name="tagihan_id" id="tagihan_id" class="form-control select-search" data-fouc onchange="changeTagihan(this)" required>
								<option value="">-- Pilih Tagihan --</option>
								@foreach ($tagihanuser as $tagihan)
								<option value="{{$tagihan->id}}" data-tagihan="{{$tagihan->jml_tagih}}" >{{$tagihan->invoice}} {{number_format($tagihan->jml_tagih,0,',','.')}}</option>'
								@endforeach
							</select>
							@endif
            </div>
          </div> --}}
          <div class="form-group row">
						<label class="col-sm-4 col-form-label col-form-label-sm">Tagihan</label>
						<div class="col-sm-8">
							@if ($tagihanuser2 != null)	
							<label class="col-form-label">{{@$tagihanuser2->invoice}} - Rp. {{number_format(@$tagihanuser2->jml_tagih,0,',','.')}}</label>
							<input class="form-control" type="hidden" name="tagihan_id" id="tagihan_id" value="{{@$tagihanuser2->id}}">
							@else
							<select name="tagihan_id" id="tagihan_id" class="form-control select-search" data-fouc onchange="changeTagihan(this)" required>
								<option value="">-- Pilih Tagihan --</option>
								@foreach ($tagihanuser as $tagihan)
                  @if ($tagihan->rekapdptagihan != null && $tagihan->rekapdptagihan->total != 0)
                    <option value="{{@$tagihan->id}}" data-dp="{{@$tagihan->rekapdptagihan->id}}" >{{@$tagihan->rekapdptagihan->invoice}} {{number_format(@$tagihan->rekapdptagihan->total,0,',','.')}}</option>
                  @endif
                  @if ($tagihan->rekaptagihan != null && $tagihan->rekaptagihan->total != 0)
                    <option value="{{@$tagihan->id}}" data-tagihan="{{@$tagihan->rekaptagihan->id}}" >{{@$tagihan->rekaptagihan->invoice}} {{number_format(@$tagihan->rekaptagihan->total,0,',','.')}}</option>
                  @endif
								@endforeach
							</select>
							@endif
						</div>
          </div>
          <input type="hidden" name="jenis_rekap">
          <div class="form-group row">
						<label class="col-form-label col-lg-4">&nbsp;</label>
						<div class="col-lg-8" id="detailTagihan">
							<table class="table table-striped">
                <thead>
								<tr>
									<td>Langganan</td>
									<td>Ads</td>
									<td>Lainnya</td>
									<td>Sudah Dibayar</td>
									<td>Total Tagihan</td>
								</tr>
              </thead>
								{{-- @if ($tagihanuser2 != null)	
								<tr>
									<td>{{number_format(@$tagihanuser2->langganan,0,',','.')}}</td>
									<td>{{number_format(@$tagihanuser2->ads,0,',','.')}}</td>
									<td>{{number_format(@$tagihanuser2->lainnya,0,',','.')}}</td>
									<td>{{number_format(@$tagihanuser2->jml_bayar,0,',','.')}}</td>
									<td>{{number_format(@$tagihanuser2->jml_tagih,0,',','.')}}</td>
								</tr>
								@else --}}
								<tr>	
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
								{{-- @endif --}}
							</table>
						</div>
					</div>
          <div class="form-group row">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Tanggal Pembayaran</label>
            <div class="col-sm-8">
              <input name="tgl_bayar" type="date" class="form-control pickadate-accessibility" placeholder="Tanggal Masa Aktif">
            </div>
          </div>
          <div class="form-group row">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Keterangan</label>
            <div class="col-sm-8">
              <textarea name="keterangan" rows="4" cols="3" class="form-control" placeholder="Keterangan" required></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm" id="nominal">Nominal Pembayaran</label>
            <div class="col">
              <input name="nominal" type="number" class="form-control form-control-sm-8" id="jumlah" placeholder="Input Nominal">
            </div>
          </div>
          <div class="col text-center">
            <button type="submit" class="btn btn-success btn-lg btn-block" href="/payment">Bayar</button>
          </div>
        </form>
        <div class="split"></div>
        <div class="copyright">
          <p style="text-align: center">2021. Nore Inovasi.</p>
        </div>
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
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
    <script type="text/javascript">
      window.onload=function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementsByName("tgl_bayar")[0].setAttribute('max', today);
      }
    </script> 
    <script>
      // $.ajax({
			// 	type: 'GET',
			// 	url: "{{ url('/gettagihan')}}/"+id,
			// 	success: function (data) {
			// 		$('#tagihan_id').html(data);
			// 	}
			// });
        
      function changeTagihan(select){
        var id = $(select).find(':selected').val();
        var tagih = $(select).find(':selected').data('tagihan');
        var dp = $(select).find(':selected').data('dp');
        var jenis = "";

        // console.log(tagih);
        // console.log(dp);

        if(tagih)
        {
          jenis = "tagihan";
        }
        else
        {
          jenis = "dptagihan";
        }
        // console.log(jenis);

        $("input[name='jenis_rekap']").val(jenis);

        $("#tertulis").prop('max',tagih);
        
        
        $.ajax({
          type: 'GET',
          url: "{{ url('/detailtagihan')}}/"+id,
          success: function (data) {
            $('#detailTagihan').html(data);
            // var markup = data;
            // $("table tbody").append(markup);
          }
        });
      }

      


    </script>
  </body>
</html>