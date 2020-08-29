@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Tambah Pembayaran</h4>
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
				<form class="form-validate-jquery" action="{{ route('payments.store')}}" method="post">
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Payment</legend>
						@if(\Auth::user()->role==1 || \Auth::user()->role==10)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">User</label>
							<div class="col-lg-10">
								<select name="user_id" class="form-control select-search" data-fouc onchange="changeDate(this)" required>
									<option value="">-- Pilih Pelanggan --</option>
									@foreach($users as $user)
										<option value="{{$user->id}}" data-kadaluarsa="{{$user->kadaluarsa}}" data-role="{{$user->role}}">{{$user->username}}</option>
				    				@endforeach
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
						@endif
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Tagihan</label>
							<div class="col-lg-10">
								<select name="tagihan_id" id="tagihan_id" class="form-control select-search" data-fouc onchange="changeTagihan(this)" required>
									<option value="">-- Pilih Tagihan --</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">&nbsp;</label>
							<div class="col-lg-10" id="detailTagihan">
								<table class="table table-striped">
									<tr>
										<td>Langganan</td>
										<td>Ads</td>
										<td>Lainnya</td>
										<td>Sudah Dibayar</td>
										<td>Total Tagihan</td>
									</tr>
									<tr>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Pembayaran</label>
							<div class="col-lg-10">
								<input name="tgl_bayar" type="text" class="form-control pickadate-accessibility" placeholder="Tanggal Pembayaran" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Keterangan</label>
							<div class="col-lg-10">
								<textarea name="keterangan" rows="4" cols="3" class="form-control" placeholder="Keterangan" required></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nominal</label>
							<div class="col-lg-10">
								<input type="text" min="1" max="1" id="tertulis" class="form-control border-teal border-1 numeric" placeholder="Nominal" style="font-size: 15px;" required>
								<input type="hidden" name="nominal" id="nominal" class="form-control border-teal border-1">
							</div>
						</div>
						@if(\Auth::user()->role==1 || \Auth::user()->role==10)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Masa Aktif</label>
							<div class="col-lg-10">
								<!-- <span class="input-group-prepend">
									<span class="input-group-text"><i class="icon-calendar3"></i></span>
								</span> -->
								<input name="kadaluarsa" type="text" class="form-control pickadate-accessibility kadaluarsa" placeholder="Tanggal Masa Aktif">
								<span class="form-text text-muted">Biarkan kosong jika tidak ada update masa aktif</span>
							</div>
						</div>
						{{-- <div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
							<div class="col-lg-10">
								<select name="status" class="form-control">
                                    <option value="0">Belum Dikonfirmasi</option>
                                    <option value="1">Sudah Dikonfirmasi</option>
                                    <option value="2">Ditolak</option>
                                </select>
							</div>
						</div> --}}
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Jumlah Update Task</label>
							<div class="col-lg-10">
								<input type="number" id="updtask" name="task_count" class="form-control border-teal border-1" placeholder="jumlah update task">
							</div>
						</div>
						@endif
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
        });

		function changeDate(select){
			var id = $(select).find(':selected').val();
			var str = $(select).find(':selected').data('kadaluarsa');
			var tgl = str.split("-");
			var picker = $(".kadaluarsa").pickadate('picker');
			
			picker.set('min', new Date(tgl[0],tgl[1],tgl[2]));
			picker.set('select', '');
			picker.set('select', null);
	        picker.render();
			
			// var role = $(select).find(':selected').data('role');
			// if(role==99){
			// 	$('#updtask').val('3');
			// } else if(role==90){
			// 	$('#updtask').val('15');
			// } else {
			// 	$('#updtask').val('0');
			// }

			$.ajax({
				type: 'GET',
				url: "{{ url('/gettagihan')}}/"+id,
				success: function (data) {
					$('#tagihan_id').html(data);
				}
			});
		}

		function changeTagihan(select){
			var id = $(select).find(':selected').val();
			var tagih = $(select).find(':selected').data('tagihan');

			$("#tertulis").prop('max',tagih);

			$.ajax({
				type: 'GET',
				url: "{{ url('/detailtagihan')}}/"+id,
				success: function (data) {
					$('#detailTagihan').html(data);
				}
			});
		}

		$(document).on("input", ".numeric", function() {
		    this.value = this.value.replace(/\D/g,'');
		});

		$('#tertulis').focus(function() {
			var angka = $('#nominal').val();
			$('#tertulis').val(angka);
		});

		$('#tertulis').focusout(function() {
			var angka = $('#tertulis').val();
			$('#nominal').val(angka);
			var harga = angka.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
			$('#tertulis').val(harga);

		});

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