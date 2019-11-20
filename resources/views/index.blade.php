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
				<div class="card bg-danger-400">
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
				<div class="card bg-teal-400">
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
	</div>

@endsection

@section('js')

<!-- Theme JS files -->
<script src="{{ URL::asset('global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>

<script src="{{ URL::asset('assets/js/app.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/demo_pages/dashboard.js') }}"></script>
<!-- /theme JS files -->

@endsection