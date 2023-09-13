<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="{{asset('global_assets/images/Nore_Iklan_Nore.png') }}" rel="shortcut icon" type="image/x-icon">
	<title>OP Ticketing</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="global_assets/js/main/jquery.min.js"></script>
	<script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="global_assets/js/plugins/forms/validation/validate.min.js"></script>

	<script src="assets/js/app.js"></script>
	<script src="global_assets/js/demo_pages/form_validation.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center" style="background:#3EB772;">
				<!-- Login form -->
			<div class="login-container">
				<form class="form-validate-jquery" method="POST" action="{{ url('/login') }}">
					{{ csrf_field() }}
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								{{-- <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i> --}}
								<i>
									<img src="{{ URL::asset('global_assets/images/logo_nore_1000px.png') }}" alt="" style="width:200px; height:100px">
								</i>
								{{-- <img src="{{ URL::asset('global_assets/images/nore_w_1000px.png') }}" alt="" style="width:100px; height:50px"> --}}
								<h5 class="mb-0">Login ke akun Anda</h5>
								<span class="d-block text-muted">Masukkan info login anda</span>
							</div>
							
							@if ( session('error'))
								<div class="alert alert-danger border-0 alert-dismissible">
									<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
									{{ session('error') }}.
								</div>
						    @endif

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text" name="username" class="form-control" placeholder="Username" required>
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" name="password" class="form-control" placeholder="Password" required>
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-success btn-block">Masuk<i class="icon-circle-right2 ml-2"></i></button>
							</div>

							<!-- <div class="text-center">
								<a href="login_password_recover.html">Forgot password?</a>
							</div> -->
							
						</div>
						
						
					</div>
				</div>
				<!-- /login container -->
  
				</form>
				<!-- /login form -->
				<div class="qrcode-container">
					{{ QrCode::size(309)->generate($uuid) }}
				</div>
			
			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
	<style>
		.content-wrapper {
		justify-content: center;
        display: flex;
        flex-wrap: wrap;
    }
        .login-container {
        flex-shrink: 0;
        width: 100%;
        max-width: 400px;
		padding: 34px;
        /* margin: 0 auto; */
    }

		.qrcode-container {
		flex-shrink: 0;
        width: 100%;
        max-width: 400px;
        /* margin: 20px auto; */
		padding: 34px;
		border-radius: 4px; 
		display: flex;
		/* align-items: center; */
		justify-content: center;
		/* margin-left: 20px; */
		background-color: white; Add some spacing between the containerss
	}

	 @media screen and (max-width: 768px) {
        .content {
            flex-direction: column;
            align-items: center;
        }

        .qrcode-container {
			/* display: none; */
            margin-top: 20px;
        	max-width: 330px;
        }
    }
    </style>

</body>
</html>
