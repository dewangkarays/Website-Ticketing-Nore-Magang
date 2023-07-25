@extends('layout')

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><span class="font-weight-semibold">Home</span> - Dashboard</h4>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
	</div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
	
	<!-- Quick stats boxes -->
	<div class="row">
		<h4><span class="font-weight-semibold">Info penting</span></h4>
	</div>
	@if (Auth::user()->role > 1 && Auth::user()->role < 80)
	@if(count($cuti) == 0)
	@if ($karyawanabsensi < 1)
	<div style="">

	<a href="{{ route('presensi.create')}}"><button type="button" class="btn rounded-round" style="background-color:#FCE700;color:#000000"><i class="fa fa-bullhorn" aria-hidden="true"style="color:#FF1700"></i><b><span style="color:#FF1700"> Anda belum Presensi !!</span></b></button></a>
	
	
		</div>
		@endif
		@endif
		@endif
	<div class="row">
		<h5><span class="font-weight">Info Karyawan</span></h5>
	</div>
	<div class="row">
		<div class="col-lg-4">
		<div class="card"style="background-color:#229c59;">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-users2 icon-4x"style="color:white"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0"style="color:white";>Hadir</h3>
						</div>
						<div style="color:white">
							{{$karyawanhadir}}
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			@if (Auth::user()->role == 1 || Auth::user()->role ==20 || Auth::user()->role == 50 || Auth::user()->role == 60)
			<div class="card"style="background-color:#EDEDED;">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-users2 icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">Belum Presensi</h3>
						</div>
						<a href="{{route('belumpresensi')}}" style="color:black">
							<div>
								{{$belumpresensi}}
							</div>
						</a>
					</div>
				</blockquote>
			</div>
			
			@else
			<div class="card"style="background-color:#EDEDED;">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-users2 icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">Belum Presensi</h3>
						</div>
						<div>
							{{$belumpresensi}}
						</div>
					</div>
				</blockquote>
			</div>
			@endif
		</div>
		<div class="col-lg-4">
		<div class="card"style="background-color:#7e8082;">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-users2 icon-4x"style="color:white"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0"style="color:white">Cuti: {{ $karyawancutis->count() }}</h3>
						</div>
						<div style="color:white">
							@foreach ($karyawancutis as $karyawancuti)
								{{$karyawancuti->karyawan->nama}} 
								@if ($karyawancuti->karyawan->role)
								({{config('custom.role.'.$karyawancuti->karyawan->role)}})
								@endif
								<br>
							@endforeach
						</div>
					</div>
				</blockquote>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4">
		<div class="card"style="background-color:#4284f5;">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-users2 icon-4x"style="color:white"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0"style="color:white">WFH: {{ $karyawanwfh->count() }}</h3>
						</div>
						<div style="color:white">
							@foreach ($karyawanwfh as $wfh)
								{{$wfh->karyawan->nama}}
								@if ($wfh->karyawan->role)
								({{config('custom.role.'.$wfh->karyawan->role)}})
								@endif
								<br>
							@endforeach
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
		<div class="card"style="background-color:#610C63;">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-users2 icon-4x"style="color:white"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0"style="color:white;">Izin: {{ $karyawanizin->count() }}</h3>
						</div>
						<div style="color:white">
							@foreach ($karyawanizin as $izin)
								{{$izin->karyawan->nama}}
								@if ($izin->karyawan->role)
								({{config('custom.role.'.$izin->karyawan->role)}})
								@endif
								<br>
							@endforeach
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
		<div class="card"style="background-color:#FF1E1E;">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-users2 icon-4x"style="color:white"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0"style="color:white">Sakit: {{ $karyawansakit->count() }}</h3>
						</div>
						<div style="color:white">
							@foreach ($karyawansakit as $sakit)
								{{$sakit->karyawan->nama}}
								@if ($sakit->karyawan->role)
								({{config('custom.role.'.$sakit->karyawan->role)}})
								@endif
								<br>
							@endforeach
						</div>
					</div>
				</blockquote>
			</div>
		</div>
	</div>
	{{-- <div class="row"> --}}
		<!-- <h5><span class="font-weight">Info Klien</span></h5>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<div class="card bg-blue-600">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-users icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $member }}</h3>
						</div>
						<div>
							Jumlah Klien
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card bg-blue-600">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-user icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $memberthis }}</h3>
						</div>
						<div>
							Jumlah Klien Bulan Ini
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card bg-blue-600">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-user icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $memberlast }}</h3>
						</div>
						<div>
							Jumlah Klien Bulan Lalu
						</div>
					</div>
				</blockquote>
			</div>
		</div>
	</div>
	<div class="row">
		<h5><span>Info Website</span></h5>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<div class="card bg-green-600">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-display icon-4x"></i>
					</div>
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ count($proyek) }}</h3>
						</div>
						<div>
							Total Website (All Layanan)
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card bg-green-600">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-display icon-4x"></i>
					</div>
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $proyekthis }}</h3>
						</div>
						<div>
							Total Website Bulan Ini
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card bg-green-600">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-display icon-4x"></i>
					</div>
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $proyeklast }}</h3>
						</div>
						<div>
							Total Website Bulan Lalu
						</div>
					</div>
				</blockquote>
			</div>
		</div>
	</div>
	<div class="row">
		<h5>Info Layanan Website</h5>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<div class="card bg-orange-600">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-sphere icon-4x"></i>
					</div>
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $simple }}</h3>
						</div>
						<div>
							Total Website Simple
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card bg-orange-600">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-sphere icon-4x"></i>
					</div>
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $prioritas }}</h3>
						</div>
						<div>
							Total Website Prioritas
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card bg-orange-600">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-sphere icon-4x"></i>
					</div>
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $premium }}</h3>
						</div>
						<div>
							Total Website Premium
						</div>
					</div>
				</blockquote>
			</div>
		</div>
	</div>
	@if (\Auth::user()->role==1)
		<div class="row"> -->
			<!-- <h5>Info pendapatan</h5>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class="card bg-slate-600">
					<blockquote class="blockquote d-flex py-2 mb-0">
						<div class="mr-4" style="padding-left: 1.875rem;">
							<i class="icon-download icon-4x"></i>
						</div>
						<div>
							<div class="d-flex">
							{{-- @php($gross=0)
							@foreach ($pendapatans as $pendapatan)
							@php($gross = $pendapatan->sum('nominal'))
							@endforeach --}}
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$pendapatans),0,',','.')}}, -</h3>
							</div>
							<div>
								Total Pendapatan
							</div>
						</div>
					</blockquote>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card bg-slate-600">
					<blockquote class="blockquote d-flex py-2 mb-0">
						<div class="mr-4" style="padding-left: 1.875rem;">
							<i class="icon-download icon-4x"></i>
						</div>
						<div>
							<div class="d-flex">
								{{-- @php($grossthis=0)
									@foreach ($pendapatanthis as $pendapatanthis)
										@php($grossthis = $pendapatanthis->sum('nominal'))
									@endforeach --}}
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$pendapatanthis),0,',','.')}}, -</h3>
							</div>
							<div>
								Total pendapatan bulan ini
							</div>
						</div>
					</blockquote>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card bg-slate-600">
					<blockquote class="blockquote d-flex py-2 mb-0">
						<div class="mr-4" style="padding-left: 1.875rem;">
							<i class="icon-download icon-4x"></i>
						</div>
						<div>
							<div class="d-flex">
								{{-- @php($grosslast=0)
									@foreach ($pendapatanlast as $pendapatanlast)
										@php($grosslast = $pendapatanlast->sum('nominal'))
									@endforeach --}}
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$pendapatanlast),0,',','.')}}, -</h3>
							</div>
							<div>
								Total pendapatan bulan lalu
							</div>
						</div>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="row"> -->
			<!-- <h5>Info pengeluaran</h5>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class="card bg-grey-600">
					<blockquote class="blockquote d-flex py-2 mb-0">
						<div class="mr-4" style="padding-left: 1.875rem;">
							<i class="icon-upload icon-4x"></i>
						</div>
						<div>
							<div class="d-flex">
								{{-- @php($total=0)
								@foreach ($pengeluarans as $pengeluaran)
								@php($total = $pengeluaran->sum('nominal'))
								@endforeach --}}
								<h3 class="font-weight-semibold mb-0">
									Rp {{number_format((@$pengeluarans),0,',','.')}}, -
								</h3>
							</div>
							<div>
								Total pengeluaran
							</div>
						</div>
					</blockquote>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card bg-grey-600">
					<blockquote class="blockquote d-flex py-2 mb-0">
						<div class="mr-4" style="padding-left: 1.875rem;">
							<i class="icon-upload icon-4x"></i>
						</div>
						<div>
							<div class="d-flex">
								{{-- @php($expendthis=0)
								@foreach ($pengeluaranthis as $pengeluaranthis)
								@php($expendthis = $pengeluaranthis->sum('nominal'))
								@endforeach --}}
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$pengeluaranthis),0,',','.')}}, -</h3>
							</div>
							<div>
								Total pengeluaran bulan ini
							</div>
						</div>
					</blockquote>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card bg-grey-600">
					<blockquote class="blockquote d-flex py-2 mb-0">
						<div class="mr-4" style="padding-left: 1.875rem;">
							<i class="icon-upload icon-4x"></i>
						</div>
						<div>
							<div class="d-flex">
								{{-- @php($expendlast=0)
								@foreach ($pengeluaranlast as $pengeluaranlast)
									@php($expendlast = $pengeluaranlast->sum('nominal'))
								@endforeach --}}
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$pengeluaranlast),0,',','.')}}, -</h3>
							</div>
							<div>
								Total pengeluaran bulan lalu
							</div>
						</div>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="row"> -->
			<!-- <h5>Info net/profit</h5>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class="card bg-brown-600">
					<blockquote class="blockquote d-flex py-2 mb-0">
						<div class="mr-4" style="padding-left: 1.875rem;">
							<i class="icon-coin-dollar icon-4x"></i>
						</div>
						<div>
							<div class="d-flex">
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$gross - @$total),0,',','.')}}, -</h3>
							</div>
							<div>
								Total nett/profit
							</div>
						</div>
					</blockquote>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card bg-brown-600">
					<blockquote class="blockquote d-flex py-2 mb-0">
						<div class="mr-4" style="padding-left: 1.875rem;">
							<i class="icon-coin-dollar icon-4x"></i>
						</div>
						<div>
							<div class="d-flex">
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$grossthis - @$expendthis),0,',','.')}}, -</h3>
							</div>
							<div>
								Total nett/profit bulan ini
							</div>
						</div>
					</blockquote>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card bg-brown-600">
					<blockquote class="blockquote d-flex py-2 mb-0">
						<div class="mr-4" style="padding-left: 1.875rem;">
							<i class="icon-coin-dollar icon-4x"></i>
						</div>
						<div>
							<div class="d-flex">
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$grosslast - @$expendlast),0,',','.')}}, - </h3>
							</div>
							<div>
								Total nett/profit bulan lalu
							</div>
						</div>
					</blockquote>
				</div>
			</div>
		</div>
	@endif
	<div class="row">
		<hr><hr>
	</div>
	<div class="row">
		<hr><hr>
	</div>
	<div class="row">
		<h4><span class="font-weight-semibold">Total Task</span></h4>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<div class="card bg-green-400">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-stack-plus icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $new }}</h3>
						</div>
						<div>
							Task Baru
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card bg-orange-400">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-forward icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $ongoing }}</h3>
						</div>
						<div>
							Task Sedang Dikerjakan
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card bg-success-400">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-clipboard2 icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $done }}</h3>
						</div>
						<div>
							Task Selesai
						</div>
					</div>
				</blockquote>
			</div>
		</div>
	</div> -->
	<!-- /quick stats boxes -->
	 <!-- TODAY -->
	<!-- Quick stats boxes -->
	<!-- <div class="row">
		<hr><hr>
	</div>
	<div class="row">
		<hr><hr>
	</div>
	<div class="row">
		<h4><span class="font-weight-semibold">Task hari ini</span></h4>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<div class="card bg-green-400">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-stack-plus icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $todaynew }}</h3>
						</div>
						<div>
							Task Baru
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card bg-orange-400">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-forward icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $todayongoing }}</h3>
						</div>
						<div>
							Task Sedang Dikerjakan
						</div>
					</div>
				</blockquote>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card bg-success-400">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-clipboard2 icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $todaydone }}</h3>
						</div>
						<div>
							Task Selesai
						</div>
					</div>
				</blockquote>
			</div>
		</div>
	</div> -->
	<!-- /quick stats boxes -->
	<!-- TODAY -->
	<!-- Quick stats boxes -->
	<!-- <div class="row">
		<hr><hr>
	</div> -->
	<!-- /quick stats boxes -->
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

		var FormValidation = function() {

		    // Validation config
		    var _componentValidation = function() {
		        if (!$().validate) {
		            console.warn('Warning - validate.min.js is not loaded.');
		            return;
		        }

		        // Initialize
		        var validator = $('.form-validate-jquery').validate({
		            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
		            errorClass: 'validation-invalid-label',
		            //successClass: 'validation-valid-label',
		            validClass: 'validation-valid-label',
		            highlight: function(element, errorClass) {
		                $(element).removeClass(errorClass);
		            },
		            unhighlight: function(element, errorClass) {
		                $(element).removeClass(errorClass);
		            },
		            // success: function(label) {
		            //    label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
		            //},

		            // Different components require proper error label placement
		            errorPlacement: function(error, element) {

		                // Unstyled checkboxes, radios
		                if (element.parents().hasClass('form-check')) {
		                    error.appendTo( element.parents('.form-check').parent() );
		                }

		                // Input with icons and Select2
		                else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
		                    error.appendTo( element.parent() );
		                }

		                // Input group, styled file input
		                else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
		                    error.appendTo( element.parent().parent() );
		                }

		                // Other elements
		                else {
		                    error.insertAfter(element);
		                }
		            },
		            rules: {
		                // old_pass: {
		                //     minlength: 8
		                // },
		                new_pass: {
		                    minlength: 5
		                },
		                con_pass: {
		                    equalTo: '#new_pass'
		                },
		            },
		        });

		        // Reset form
		        $('#reset').on('click', function() {
		            validator.resetForm();
		        });
		    };

		    // Return objects assigned to module
		    return {
		        init: function() {
		            _componentValidation();
		        }
		    }
		}();

		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		    FormValidation.init();
		});
	</script>
	<script type="text/javascript">
		$( document ).ready(function() {
	        // Default style
	        @if(session('error'))
	            new PNotify({
	                title: 'Error',
	                text: '{{ session('error') }}.',
	                icon: 'icon-blocked',
	                type: 'error'
	            });
            @endif
            @if ( session('success'))
	            new PNotify({
	                title: 'Success',
	                text: '{{ session('success') }}.',
	                icon: 'icon-checkmark3',
	                type: 'success'
	            });
            @endif

		});
	</script>
@endsection