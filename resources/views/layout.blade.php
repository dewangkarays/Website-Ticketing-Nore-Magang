<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Nore - Pengoperasian Website</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{asset('global_assets/css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
	<style>
		/* .nav-item{
			padding
		} */
	</style>
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
			<div class="navbar navbar-expand-lg navbar-sucess">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2020. Nore
					</span>

				</div>
			</div>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


<!-- Core JS files -->
<script src="{{asset('global_assets/js/main/jquery.min.js') }}"></script>
<script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>


<!-- /core JS files -->

<script>
	$(document).ready(function(){
		// on page load
        $.ajax({
            type:'get',
            url:'{{ route("getnotif") }}',
            success:function(data) {
            	var msg = JSON.parse(data);
                $("#countNotif").html(msg.count);
                $("#bodyNotif").html(msg.body);
            }
        });

        // cek tiap 30 detik
	   	setInterval(function () {
	        $.ajax({
	            type:'get',
	            url:'{{ route("getnotif") }}',
	            success:function(data) {
	                $("#countNotif").html(data['count']);
	                $("#bodyNotif").html(data['body']);
	            }
	        });
    	}, 30000); 
 
	});
		
	$(document).on("click", "#clearbutton", function () {
        $.ajax({
            type:'get',
            url:'{{ route("clearnotif") }}',
            success:function(data) {
            	var msg = JSON.parse(data);
                $("#countNotif").html(msg.count);
                $("#bodyNotif").html(msg.body);
            }
        });
    }); 

	function ribuan(){
		var val = $('#tertulis').val();
		$('#nominal').val(val.replace(new RegExp(/\./, 'g'), ''));
		val = val.replace(/[^0-9,]/g,'');

		if(val != "") {
			valArr = val.split('.');
			valArr[0] = (parseInt(valArr[0],10)).toLocaleString('id-ID');
			val = valArr.join('.');
		}
		$('#tertulis').val(val);
	}	
</script>

@yield('js')

</body>
</html>
