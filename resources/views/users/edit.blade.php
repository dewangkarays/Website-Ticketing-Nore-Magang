@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Ubah User</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">

		<!-- Hover rows -->
		<div class="card">
			<div class="card-header header-elements-inline">
			</div>
			<div class="card-body">
				<form class="form-validate-jquery" action="{{ route('users.update', $user->id)}}" method="post">
					@method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data User</legend>

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nama</label>
							<div class="col-lg-10">
								<input type="text" name="nama" class="form-control border-teal border-1" placeholder="Nama" required value="{{ $user->nama }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Email</label>
							<div class="col-lg-10">
								<input type="email" name="email" class="form-control border-teal border-1" placeholder="Email" required value="{{ $user->email }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Telp</label>
							<div class="col-lg-10">
								<input type="text" name="telp" class="form-control border-teal border-1" placeholder="Telp/WA" required value="{{ $user->telp }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Username</label>
							<div class="col-lg-10">
								<input type="text" name="username" class="form-control border-teal border-1" placeholder="Username" required value="{{ $user->username }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Password</label>
							<div class="col-lg-10">
								<input type="password" name="password" class="form-control border-teal border-1" placeholder="Password">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Role</label>
							<div class="col-lg-10">
								<select name="role" class="form-control bg-teal-400 border-teal-400" required>
                                    <option value="1" {{ $user->role == '1' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="10" {{ $user->role == '10' ? 'selected' : '' }}>Karyawan</option>
                                    <option value="80" {{ $user->role == '80' ? 'selected' : '' }}>Premium</option>
                                    <option value="90" {{ $user->role == '90' ? 'selected' : '' }}>Prioritas</option>
                                    <option value="99" {{ $user->role == '99' ? 'selected' : '' }}>Simpel</option>
                                </select>
							</div>
						</div>
					</fieldset>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
					</div>
				</form>
			</div>

		</div>
		<!-- /hover rows -->

	</div>
	<!-- /content area -->
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
		            messages: {
		                nama: {
		                    required: 'Mohon diisi.'
		                },
		                email: {
		                    required: 'Mohon diisi.'
		                },
		                telp: {
		                    required: 'Mohon diisi.'
		                },
		                username: {
		                    required: 'Mohon diisi.'
		                },
		                // password: {
		                //     required: 'Mohon diisi.'
		                // },
		                role: {
		                    required: 'Mohon diisi.'
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