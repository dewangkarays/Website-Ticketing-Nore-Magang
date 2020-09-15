@extends('layout')

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
	</div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
	
	<!-- Quick stats boxes -->
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
			<div class="card bg-blue-400">
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
	
	@if(\Auth::user()->role<20)
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
			<div class="card bg-teal-400">
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
			<div class="card bg-blue-400">
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
	
	@else
	<!-- TODAY -->
	<!-- Quick stats boxes -->
	<div class="row">
		<hr><hr>
	</div>
	
	<div class="row">
		
		<div class="col-lg-4">
			<div class="card bg-warning">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-file-stats icon-4x"></i>
					</div>
					
					<div class="col">
							<div class="row">
								Tagihan Belum Terbayar
							</div>
							<div class="row">
								<h3 class="font-weight-semibold mb-0">Rp @angka($tagihan->sum('jml_tagih')-$totalbayar)
								</h3>
							</div>
							
							<br>
							
							<div class="row">
								Pembayaran Terakhir
							</div>
							<div class="row">
								<h3 class="font-weight-semibold mb-0">{{ empty($lastpayment->tgl_bayar) ? '-' : $lastpayment->tgl_bayar }}</h3>
							</div>
							<div class="row">
								Nominal 
							</div>
							<div class="row">
								<h3 class="font-weight-semibold mb-0">Rp {{ empty($lastpayment->nominal) ? '0' : number_format($lastpayment->nominal,0,',','.') }} </h3>
							</div>
							<div class="row" style="float: right;">
							<a href="{{ url('/payments') }}">
								<button type="button" class="btn btn-sm bg-danger rounded-round mr-2"><b><i class="icon-coin-dollar mr-2"></i></b> Ke Pembayaran</button>
							</a>
							</div>
					</div>
					
				</blockquote>
			</div>
		</div>
		
		<div class="col-lg-4">
			@if(\Auth::user()->kadaluarsa < date("Y-m-d") && \Auth::user()->kadaluarsa != '')
			<div class="card bg-danger-400">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-calendar3 icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ \Auth::user()->kadaluarsa }}</h3>
						</div>
						<div>
							Masa Aktif
						</div>
					</div>
				</blockquote>
				<span style="padding:10px;">
					Masa Aktif habis. Website akan dihapus dari internet. 
				</span>
			</div>
			
			@elseif(\Auth::user()->kadaluarsa <= date("Y-m-d", strtotime("+1 week")) && \Auth::user()->kadaluarsa != '')
			<div class="card bg-orange-400">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-calendar3 icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ \Auth::user()->kadaluarsa }}</h3>
						</div>
						<div>
							Masa Aktif
						</div>
					</div>
				</blockquote>
				<span style="padding:10px;">
					Masa Aktif kurang dari seminggu, segera lakukan pembayaran untuk memperpanjang masa aktif. 
				</span>
			</div>
			
			@else
			<div class="card" style="background-color:#229c59; color:white;">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-calendar3 icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ \Auth::user()->kadaluarsa }}</h3>
						</div>
						<div>
							Masa Aktif
						</div>
					</div>
				</blockquote>
			</div>
			@endif
		</div>
		<div class="col-lg-4">
			@if(\Auth::user()->task_count < 0)
			<div class="card bg-danger-400">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-pencil7 icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ \Auth::user()->task_count }}</h3>
						</div>
						<div>
							Jumlah Pengoperasian
						</div>
					</div>
				</blockquote>
			</div>
			
			@elseif(\Auth::user()->task_count == 0)
			<div class="card bg-orange-400">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-pencil7 icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ \Auth::user()->task_count }}</h3>
						</div>
						<div>
							Jumlah Pengoperasian
						</div>
					</div>
				</blockquote>
			</div>
			
			@else
			<div class="card" style="background-color:#229c59; color:white;">
				<blockquote class="blockquote d-flex py-2 mb-0">
					<div class="mr-4" style="padding-left: 1.875rem;">
						<i class="icon-pencil7 icon-4x"></i>
					</div>
					
					<div>
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ \Auth::user()->task_count }}</h3>
						</div>
						<div>
							Jumlah Pengoperasian
						</div>
					</div>
				</blockquote>
			</div>
			@endif
		</div>
	</div>
	<!-- /quick stats boxes -->
	@endif
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