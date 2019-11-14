<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	@yield('css')

</head>

<body>

	<!-- Main navbar -->
	@include('navbar')
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		@include('sidebar')
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			@yield('content')

			<!-- Footer -->
			<div class="navbar navbar-expand-lg navbar-light">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2019. Nore
					</span>

				</div>
			</div>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


<!-- Core JS files -->
<script src="{{ URL::asset('global_assets/js/main/jquery.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
<!-- /core JS files -->

<!-- Theme JS files 
<script src="{{ URL::asset('') }}global_assets/js/plugins/visualization/d3/d3.min.js"></script>
<script src="{{ URL::asset('') }}global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
<script src="{{ URL::asset('') }}global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="{{ URL::asset('') }}global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
<script src="{{ URL::asset('') }}global_assets/js/plugins/ui/moment/moment.min.js"></script>
<script src="{{ URL::asset('') }}global_assets/js/plugins/pickers/daterangepicker.js"></script>

<script src="{{ URL::asset('') }}assets/js/app.js"></script>
<script src="{{ URL::asset('') }}global_assets/js/demo_pages/dashboard.js"></script>
 /theme JS files -->

@yield('js')

</body>
</html>
