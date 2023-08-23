@extends('layout')

@section('content')

<style>
	.qrcode{
		display: flex;
		justify-content: center;
		
	}
	.tanggal{
		font-size: 28px;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
	
	}
	.format {
		font-size: 28px;
        font-weight: normal;
        text-align: center;
        margin-top: 5px;
		
	}
	.card-footer{
		display: flex;
		justify-content: center;
	}
	.body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background-color: #f2f2f2;
        }
		.card-footer {
			margin-top: 40px;
		}

	.description{
		display: flex;
		justify-content: center;
	}
	.button{
		display: flex;
		justify-content: center;
		margin-top: 40px;
		
	}
</style>
<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><span class="font-weight-semibold">Home</span> - Cetak Kode QR</h4>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
	</div>
</div>
<div class="content">
<div class="card">
	<div class="card-body">
	
			<body>
	
				<div class="wrapper">
					<h2 class="tanggal">Barcode pada tanggal : </h2>
					<h2 class="format">{{  date("Y-m-d")}}</h2>
					  {{-- <h2 class="format" id="current-date"></h2> --}}
				</div>
			{{-- @php
				$qrCodeDate = date("Y-m-d");
				$currentDate = date("Y-m-d");
			@endphp
		
			@if ($currentDate == $qrCodeDate)
				<p class="description">Scan Kode QR dibawah ini untuk melakukan absensi.</p>
			@else
				<p class="description">Kode QR kadaluwarsa.</p>
			@endif --}}
		
			<div class="qrcode">
				{{ QrCode::size(500)->generate($uuid) }}
				 
				</div>
				{{-- <div class="button"> --}}
				 <div class="card-footer">
				 {{-- <a href="/exportpdf" class="btn btn-info" >Export PDF</a> --}}
				 <a href="/exportpdf"><button class="btn btn-danger rounded-round"><i class="icon-file-pdf mr-2"></i> Export PDF</button></a>
				{{-- </div> --}}
				</div>
				
				
			</body>
		
	</div>
</div>
</div>

@endsection

@section('js')
	<!-- Theme JS files -->
	<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
	<script type="text/javascript">

	</script>
@endsection