@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Tambah Member</h4>
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
				<form class="form-validate-jquery" action="{{ route('members.store')}}" method="post">
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Member</legend>

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nama</label>
							<div class="col-lg-10">
								<input type="text" name="nama" class="form-control border-teal border-1" placeholder="Nama">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Email</label>
							<div class="col-lg-10">
								<input type="email" name="email" class="form-control border-teal border-1" placeholder="Email">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Telp</label>
							<div class="col-lg-10">
								<input type="text" name="telp" class="form-control border-teal border-1" placeholder="Telp/WA">
								<span class="form-text text-muted">Contoh : 628123456678 (gunakan kode negara tanpa tanda + dan spasi)</span>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Jumlah Update Task</label>
							<div class="col-lg-10">
								<input type="number" name="task_count" class="form-control border-teal border-1" placeholder="jumlah update task">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Username</label>
							<div class="col-lg-10">
								<input type="text" name="username" class="form-control border-teal border-1" placeholder="Username">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Password</label>
							<div class="col-lg-10">
								<input type="password" name="password" class="form-control border-teal border-1" placeholder="Password">
							</div>
                        </div>
                        
					</fieldset>
					<div class="text-right">
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
				
		// Validation config
		var FormValidation = function() {


		//
		// Setup module components
		//

		// Uniform
		var _componentUniform = function() {
			if (!$().uniform) {
				console.warn('Warning - uniform.min.js is not loaded.');
				return;
			}

			// Initialize
			$('.form-input-styled').uniform({
				fileButtonClass: 'action btn bg-blue'
			});
		};

		// Switchery
		var _componentSwitchery = function() {
			if (typeof Switchery == 'undefined') {
				console.warn('Warning - switchery.min.js is not loaded.');
				return;
			}

			// Initialize single switch
			var elems = Array.prototype.slice.call(document.querySelectorAll('.form-input-switchery'));
			elems.forEach(function(html) {
				var switchery = new Switchery(html);
			});
		};

		// Bootstrap switch
		var _componentBootstrapSwitch = function() {
			if (!$().bootstrapSwitch) {
				console.warn('Warning - bootstrap_switch.min.js is not loaded.');
				return;
			}

			// Initialize
			$('.form-input-switch').bootstrapSwitch({
				onSwitchChange: function(state) {
					if(state) {
						$(this).valid(true);
					}
					else {
						$(this).valid(false);
					}
				}
			});
		};

		// Touchspin
		var _componentTouchspin = function() {
			if (!$().TouchSpin) {
				console.warn('Warning - touchspin.min.js is not loaded.');
				return;
			}

			// Define variables
			var $touchspinContainer = $('.touchspin-postfix');

			// Initialize
			$touchspinContainer.TouchSpin({
				min: 0,
				max: 100,
				step: 0.1,
				decimals: 2,
				postfix: '%'
			});

			// Trigger value change when +/- buttons are clicked
			$touchspinContainer.on('touchspin.on.startspin', function() {
				$(this).trigger('blur');
			});
		};

		// Select2 select
		var _componentSelect2 = function() {
			if (!$().select2) {
				console.warn('Warning - select2.min.js is not loaded.');
				return;
			}

			// Initialize
			var $select = $('.form-control-select2').select2({
				minimumResultsForSearch: Infinity
			});

			// Trigger value change when selection is made
			$select.on('change', function() {
				$(this).trigger('blur');
			});
		};

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
				successClass: 'validation-valid-label',
				validClass: 'validation-valid-label',
				highlight: function(element, errorClass) {
					$(element).removeClass(errorClass);
				},
				unhighlight: function(element, errorClass) {
					$(element).removeClass(errorClass);
				},
				success: function(label) {
					label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
				},

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
					},
					repeat_password: {
						equalTo: '#password'
					},
					email: {
						email: true
					},
					repeat_email: {
						equalTo: '#email'
					},
					minimum_characters: {
						minlength: 10
					},
					maximum_characters: {
						maxlength: 10
					},
					minimum_number: {
						min: 10
					},
					maximum_number: {
						max: 10
					},
					number_range: {
						range: [10, 20]
					},
					url: {
						url: true
					},
					date: {
						date: true
					},
					date_iso: {
						dateISO: true
					},
					numbers: {
						number: true
					},
					digits: {
						digits: true
					},
					creditcard: {
						creditcard: true
					},
					basic_checkbox: {
						minlength: 2
					},
					styled_checkbox: {
						minlength: 2
					},
					switchery_group: {
						minlength: 2
					},
					switch_group: {
						minlength: 2
					}
				},
				messages: {
					custom: {
						required: 'This is a custom error message'
					},
					basic_checkbox: {
						minlength: 'Please select at least {0} checkboxes'
					},
					styled_checkbox: {
						minlength: 'Please select at least {0} checkboxes'
					},
					switchery_group: {
						minlength: 'Please select at least {0} switches'
					},
					switch_group: {
						minlength: 'Please select at least {0} switches'
					},
					agree: 'Please accept our policy'
				}
			});

			// Reset form
			$('#reset').on('click', function() {
				validator.resetForm();
			});
		};


		//
		// Return objects assigned to module
		//

		return {
			init: function() {
				_componentUniform();
				_componentSwitchery();
				_componentBootstrapSwitch();
				_componentTouchspin();
				_componentSelect2();
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