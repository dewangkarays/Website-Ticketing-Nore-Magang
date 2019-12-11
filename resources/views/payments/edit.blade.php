@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Ubah Payment</h4>
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
				<form class="form-validate-jquery" action="{{ route('payments.update', $payment->id)}}" method="post">
					@method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Payment</legend>
						@if($payment->status==0)
							@if(\Auth::user()->role==1 || \Auth::user()->role==10)
							<div class="form-group row">
								<label class="col-form-label col-lg-2">User</label>
								<div class="col-lg-10">
									<select name="user_id" class="form-control select-search" data-fouc onchange="changeDate(this)" required>
										@foreach($users as $user)
											<option value="{{$user->id}}" data-kadaluarsa="{{$user->kadaluarsa}}" {{ $payment->user_id == $user->id ? 'selected' : '' }}>{{$user->username}}</option>
					    				@endforeach
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Tanggal Pembayaran</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{ $payment->tgl_bayar }}</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Keterangan</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{ $payment->keterangan }}</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Nominal</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{ $payment->nominal }}</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Kadaluarsa</label>
								<div class="col-lg-10">
									<input name="kadaluarsa" type="text" class="form-control pickadate-accessibility" placeholder="Tanggal Kadaluarsa" required value="{{ $payment->kadaluarsa }}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Status</label>
								<div class="col-lg-10">
									<select name="status" class="form-control">
	                                    <option value="0" {{ $payment->status == "0" ? 'selected' : '' }}>Belum Dikonfirmasi</option>
	                                    <option value="1" {{ $payment->status == "1" ? 'selected' : '' }}>Sudah Dikonfirmasi</option>
	                                    <option value="2" {{ $payment->status == "2" ? 'selected' : '' }}>Ditolak</option>
	                                </select>
								</div>
							</div>

							@else
							<div class="form-group row">
								<label class="col-form-label col-lg-2">User</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{\Auth::user()->username}}</label>
									<input type="hidden" name="user_id" value="{{\Auth::user()->id}}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Tanggal Pembayaran</label>
								<div class="col-lg-10" required>
									<input name="tgl_bayar" type="text" class="form-control pickadate-accessibility" placeholder="Tanggal Pembayaran" value="{{ $payment->tgl_bayar }}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Keterangan</label>
								<div class="col-lg-10">
									<textarea name="keterangan" rows="4" cols="3" class="form-control" placeholder="Keterangan" required>{{ $payment->keterangan }}</textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Nominal</label>
								<div class="col-lg-10">
									<input type="number" name="nominal" class="form-control border-teal border-1" placeholder="Nominal" required value="{{ $payment->nominal }}">
								</div>
							</div>
							@endif
						@else
							<div class="form-group row">
								<label class="col-form-label col-lg-2">User</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{\Auth::user()->username}}</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Tanggal Pembayaran</label>
								<div class="col-lg-10" required>
									<label class="col-form-label col-lg-2">{{payment->tgl_bayar}}</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Keterangan</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{payment->keterangan}}</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Nominal</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{payment->nominal}}</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Status</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{config('custom.status.'.$payment->status)}}</label>
								</div>
							</div>

						@endif
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
	<script src="{{asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/anytime.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/notifications/jgrowl.min.js')}}"></script>

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/uploader_bootstrap.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>
	<script>
		

        // Accessibility labels
        $('.pickadate-accessibility').pickadate({
            labelMonthNext: 'Go to the next month',
            labelMonthPrev: 'Go to the previous month',
            labelMonthSelect: 'Pick a month from the dropdown',
            labelYearSelect: 'Pick a year from the dropdown',
            selectMonths: true,
            selectYears: true,
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy-mm-dd',
        });

		function changeDate(select){
			var str = $(select).find(':selected').data('kadaluarsa')
			console.log(str);
			var tgl = str.split("-");
			var picker = $(".pickadate-accessibility").pickadate('picker');
			picker.set('min', new Date(tgl[0],tgl[1],tgl[2]));
			picker.set('select', new Date(tgl[0],tgl[1],tgl[2]));
	        picker.render();
		}
	</script>
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
		                user_id: {
		                    required: 'Mohon diisi.'
		                },
		                keterangan: {
		                    required: 'Mohon diisi.'
		                },
		                nominal: {
		                    required: 'Mohon diisi.'
		                },
		                kadaluarsa: {
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