@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Ubah User</h4>
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
							<label class="col-form-label col-lg-2">NIP</label>
							<div class="col-lg-10">
								<input type="text" name="nip" class="form-control border-teal border-1" placeholder="NIP" required value="{{ $user->nip }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Jabatan</label>
							<div class="col-lg-10">
								<input type="text" name="jabatan" class="form-control border-teal border-1" placeholder="Jabatan" required value="{{ $user->jabatan }}">
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
								<input type="text" name="telp" class="form-control border-teal border-1 phone-number" placeholder="Telp/WA" required value="{{ $user->telp }}">
								<span class="form-text text-muted">Contoh : 628123456678 (gunakan kode negara tanpa tanda + dan spasi)</span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat</label>
							<div class="col-lg-10">
								<input type="text" name="alamat" class="form-control border-teal border-1" placeholder="Alamat" value="{{ $user->alamat }} ">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Jumlah Update Task</label>
							<div class="col-lg-10">
								<input type="number" name="task_count" class="form-control border-teal border-1" placeholder="jumlah update task" value="{{ $user->task_count }}">
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
								<select name="role" class="form-control form-control-select2 border-teal border-1" required>
									@foreach (config('custom.role') as $key => $value)
										{{-- <option {{ $user->role == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option> --}}
										@if ($key <= 50)
										<option {{ $user->role == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
										@endif
									@endforeach
                                </select>
							</div>
						</div>
						@if($def_atasan != null)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Atasan</label>
							<div class="col-lg-10">
								<input type="text" name="atasan" class="form-control border-teal border-1" placeholder="Atasan" value="{{ $def_atasan->nama }}" readonly >
							</div>
						</div>
						@else
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Atasan</label>
							<div class="col-lg-10">
								<input type="text" name="atasan" class="form-control border-teal border-1" placeholder="Atasan" value="-" readonly >
							</div>
						</div>
						@endif
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Ganti Atasan</label>
							<div class="col-lg-10">
								<select name="atasan_id" class="form-control form-control-select2 border-teal-1 border-teal">
									<option value="">-- Pilih Atasan --</option>
									@foreach ($atasans as $atasan)
									<option value="{{ $atasan->id }}" >{{ $atasan->nama }}</option>
									@endforeach
                                </select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Jatah Cuti</label>
							<div class="col-lg-10">
								<input type="text" name="jatah_cuti" class="form-control border-teal border-1 phone-number" required value="{{ $user->jatah_cuti }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Sisa Cuti</label>
							<div class="col-lg-10">
								<input type="text" name="sisa_cuti" class="form-control border-teal border-1 phone-number" value="{{ $user->sisa_cuti }}">
							</div>
						</div>
					</fieldset>
					<div class="text-right">
						<a href="{{ url('/users') }}" class="btn bg-slate">Kembali <i class="icon-undo2 ml-2"></i></a>
						<button type="submit" class="btn btn-primary">Simpan <i class="icon-paperplane ml-2"></i></button>
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
	<script src="{{asset('global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/anytime.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
	<script type="text/javascript">
		// Initialize
		$('.select-search').select2();

		// Initialize
		var $select = $('.form-control-select2').select2({
			minimumResultsForSearch: Infinity
		});
		
        // Accessibility labels
        $('.pickadate-accessibility').pickadate({
            labelMonthNext: 'Go to the next month',
            labelMonthPrev: 'Go to the previous month',
            labelMonthSelect: 'Pick a month from the dropdown',
            labelYearSelect: 'Pick a year from the dropdown',
            selectMonths: true,
            selectYears: true,
            format: 'yyyy-mm-dd',
        });
				
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
						password: {
							minlength: 5
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

		// Regex for validating phone number
		$(function() {
			$(".phone-number").on("keyup", function(event) {
				$(this).val($(this).val().replace(/[^0-9]/g, ""));
			})
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