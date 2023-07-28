@extends('layout')

@section('content')

<style>
	.qrcode{
		display: flex;
		justify-content: center;
	}
	.tanggal{
		display: flex;
		justify-content: center;
	}
	.format {
		display: flex;
		justify-content: center;
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
					<h1 class="tanggal">Barcode pada tanggal : </h1>
					<h2 class="format">{{  date("Y-m-d")}}</h2>
					  {{-- <h2 class="format" id="current-date"></h2> --}}
				</div>
				<div class="qrcode">
					{{ QrCode::size(500)->generate(date("Y-m-d")) }}
				 
				</div>

				 <div class="card-footer">
				 <a href="/exportpdf" class="btn btn-info" >Export PDF</a>
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