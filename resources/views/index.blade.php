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
	<div class="row">
		<h5><span class="font-weight">Info Klien</span></h5>
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
		<div class="row">
			<h5>Info pendapatan</h5>
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
							@php($gross=0)
							@foreach ($pendapatans as $pendapatan)
							@php($gross = $pendapatan->sum('nominal'))
							@endforeach
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$gross),0,',','.')}}, -</h3>
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
								@php($grossthis=0)
									@foreach ($pendapatanthis as $pendapatanthis)
										@php($grossthis = $pendapatanthis->sum('nominal'))
									@endforeach
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$grossthis),0,',','.')}}, -</h3>
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
								@php($grosslast=0)
									@foreach ($pendapatanlast as $pendapatanlast)
										@php($grosslast = $pendapatanlast->sum('nominal'))
									@endforeach
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$grosslast),0,',','.')}}, -</h3>
							</div>
							<div>
								Total pendapatan bulan lalu
							</div>
						</div>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="row">
			<h5>Info pengeluaran</h5>
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
								@php($total=0)
								@foreach ($pengeluarans as $pengeluaran)
								@php($total = $pengeluaran->sum('nominal'))
								@endforeach
								<h3 class="font-weight-semibold mb-0">
									Rp {{number_format((@$total),0,',','.')}}, -
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
								@php($expendthis=0)
								@foreach ($pengeluaranthis as $pengeluaranthis)
								@php($expendthis = $pengeluaranthis->sum('nominal'))
								@endforeach
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$expendthis),0,',','.')}}, -</h3>
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
								@php($expendlast=0)
								@foreach ($pengeluaranlast as $pengeluaranlast)
									@php($expendlast = $pengeluaranlast->sum('nominal'))
								@endforeach
								<h3 class="font-weight-semibold mb-0">Rp {{number_format((@$expendlast),0,',','.')}}, -</h3>
							</div>
							<div>
								Total pengeluaran bulan lalu
							</div>
						</div>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="row">
			<h5>Info net/profit</h5>
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
	</div>
	<!-- /quick stats boxes -->
	 <!-- TODAY -->
	<!-- Quick stats boxes -->
	<div class="row">
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
	</div>
	<!-- /quick stats boxes -->
	<!-- TODAY -->
	<!-- Quick stats boxes -->
	<div class="row">
		<hr><hr>
	</div>
	<!-- /quick stats boxes -->
</div>

@endsection

@section('js')

<!-- Theme JS files -->
<script src="{{asset('global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
<script src="{{asset('global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
<script src="{{asset('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
<script src="{{asset('global_assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
<script src="{{asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
<script src="{{asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>

<script src="{{asset('assets/js/app.js') }}"></script>
<script src="{{asset('global_assets/js/demo_pages/dashboard.js') }}"></script>
<!-- /theme JS files -->
@endsection