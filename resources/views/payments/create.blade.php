@extends('layout')

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><span class="font-weight-semibold">Home</span> - Tambah Pembayaran</h4>
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
			<form id="form_payment" class="form-validate-jquery" action="{{ route('payments.store')}}" method="post">
				@csrf
				<fieldset class="mb-3">
					<legend class="text-uppercase font-size-sm font-weight-bold">Data Payment</legend>
					@if(\Auth::user()->role==1 || \Auth::user()->role==10)

					<div class="form-group row">
						<label class="col-form-label col-lg-2">User</label>
						<div class="col-lg-10">
							<select id="user_id" name="user_id" class="form-control select-search" data-fouc {{-- onchange="changeDate(this)" --}} required>
								<option value="">-- Pilih Pelanggan --</option>
								@foreach($users as $user)
								<option data-name="{{$user->nama}}" data-kadaluarsa="{{$user->kadaluarsa}}" data-role="{{$user->role}}" value="{{$user->id}}">{{$user->nama}}</option>
								{{-- <option data-name="{{$user->nama}}" value="{{$user->id}}" data-kadaluarsa="{{$user->kadaluarsa}}" data-role="{{$user->role}}">{{$user->nama}}</option> --}}
								@endforeach
							</select>
						</div>
					</div>

					{{-- <div class="form-group row">
						<label class="col-form-label col-lg-2">Nama</label>
						<div class="col-lg-10">
							<input id="nama" name="nama" type="text" class="form-control" placeholder="Nama User" required>
						</div>
					</div> --}}
					@else
					<div class="form-group row">
						<label class="col-form-label col-lg-2">User</label>
						<div class="col-lg-10">
							<label class="col-form-label col-lg-2">{{\Auth::user()->name}}</label>
							<input type="hidden" name="user_id" value="{{\Auth::user()->id}}">
						</div>
					</div>
					{{-- <div class="form-group row">
						<label class="col-form-label col-lg-2">Nama</label>
						<div class="col-lg-10">
							<input id="nama" name="nama" type="text" class="form-control" placeholder="Nama User" required value="{{\Auth::user()->nama}}">
						</div>
					</div> --}}
					@endif
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Jenis (Tagihan/Uang Muka)</label>
						<div class="col-lg-10">
							<div class="form-check form-check-inline">
								<label class="form-check-label col-lg-10">
									<input id="rad1" type="radio" class="form-check-input-styled cek" value="1" name="rdtagihan" data-fouc>
									Tagihan
								</label>
								<label class="form-check-label col-lg-10">
									<input id="rad2" type="radio" class="form-check-input-styled cek" value="2" name="rdtagihan" data-fouc>
									Uang Muka
								</label>
							</div>
						</div>
					</div>
					@if (\Auth::user()->role==1)
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Tagihan</label>
						<div class="col-lg-10">
							<select name="tagihan_id" id="tagihan_id" class="form-control select-search" data-fouc onchange="changeTagihan(this)" required>
								<option value="">-- Pilih Tagihan --</option>
							</select>
						</div>
					</div>
					@else
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Tagihan</label>
						<div class="col-lg-10">
							@if ($tagihanuser2 != null)
							<label class="col-form-label">{{$tagihanuser2->invoice}} - Rp. {{number_format($tagihanuser2->total,0,',','.')}}</label>
							<input class="form-control" type="hidden" name="tagihan_id" id="tagihan_id" value="{{$tagihanuser2->id}}">
							@else
							<select name="tagihan_id" id="tagihan_id" class="form-control select-search" data-fouc onchange="changeTagihan(this)" required>
								<option value="">-- Pilih Tagihan --</option>
								@foreach ($tagihanuser as $tagihan)
								<option value="{{$tagihan->id}}" data-jmlbayar="{{ $tagihan->jml_terbayar }}" data-tagihan="{{$tagihan->total}}" >{{$tagihan->invoice}} {{number_format($tagihan->total,0,',','.')}}</option>'
								@endforeach
							</select>
							@endif
						</div>
					</div>
					@endif
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Total Tertagih</label>
						<div class="col-lg-10">
							<input type="text" min="1" id="total" class="form-control border-teal border-1 numeric" placeholder="Total tagihan user, contoh: 2.000.000" readonly>
							<input type="hidden" id="nomtotal" class="form-control border-teal border-1">
							<span class="form-text text-muted">Total tagihan yang dimiliki user</span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Total Terbayar</label>
						<div class="col-lg-10">
							<input type="text" min="1" id="bayar" class="form-control border-teal border-1 numeric" placeholder="Total pembayaran user, contoh: 2.000.000" readonly>
							<input type="hidden" id="nombayar" class="form-control border-teal border-1">
							<span class="form-text text-muted">Total pembayaran yang dilakukan user</span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Sisa Tagihan</label>
						<div class="col-lg-10">
							<input type="text" min="1" id="sisa" class="form-control border-teal border-1 numeric" placeholder="Sisa tagihan user, contoh: 2.000.000" readonly>
							<input type="hidden" id="nomsisa" class="form-control border-teal border-1">
							<span class="form-text text-muted">Sisa tagihan yang dimiliki user</span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Total Bayar</label>
						<div class="col-lg-10">
							<input type="text" min="1" id="tertulis" name="tertulis" class="form-control border-teal border-1 numeric" placeholder="Contoh: 2.000.000" required>
							<input type="hidden" id="nominal" name="nominal" class="form-control border-teal border-1">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Tanggal Pembayaran</label>
						<div class="col-lg-10">
							<input name="tgl_bayar" type="text" class="form-control pickadate-accessibility" placeholder="Contoh: 2022-04-16" value="{{  date('Y-m-d') }}" required>
							<span class="form-text text-muted">Ubah tanggal jika pembayaran tidak dilakukan HARI INI</span>
						</div>
					</div>
					{{-- @if(\Auth::user()->role==1 || \Auth::user()->role==10)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Masa Aktif</label>
							<div class="col-lg-10">
								<!-- <span class="input-group-prepend">
									<span class="input-group-text"><i class="icon-calendar3"></i></span>
								</span> -->
								<input name="kadaluarsa" type="text" class="form-control pickadate-accessibility kadaluarsa" placeholder="Contoh: 2025-04-16">
								<span class="form-text text-muted">Biarkan kosong jika tidak ada update masa aktif</span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
							<div class="col-lg-10">
								<select name="status" class="form-control">
									<option value="0">Belum Dikonfirmasi</option>
									<option value="1">Sudah Dikonfirmasi</option>
									<option value="2">Ditolak</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Jumlah Update Task</label>
							<div class="col-lg-10">
								<input type="number" id="updtask" name="task_count" class="form-control border-teal border-1" placeholder="Contoh: 10">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Penerima</label>
							<div class="col-lg-10">
								<input id="penerima" name="penerima" type="text" class="form-control" placeholder="Penerima" required value="{{$setting? $setting->penerima : ''}}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">TTD Penerima</label>
							<div class="col-lg-10">
								<input id="ttd_penerima" name="ttd_penerima" type="text" class="form-control" placeholder="Ttd Penerima" required value="{{$setting? $setting->ttd_penerima : ''}}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Posisi TTD Penerima</label>
							<div class="col-lg-10">
								<input id="ttd_pospenerima" name="ttd_pospenerima" type="text" class="form-control" placeholder="Posisi TTd Penerima" required value="{{$setting? $setting->ttd_pospenerima : ''}}">
							</div>
						</div>
					@elseif (\Auth::user()->role > 10)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Penerima</label>
							<div class="col-lg-10">
								<input id="penerima" name="penerima" type="text" class="form-control" placeholder="Penerima" required value="{{$setting? $setting->penerima : ''}}" readonly>
								<input id="ttd_penerima" name="ttd_penerima" type="hidden" class="form-control" placeholder="Ttd Penerima" required value="{{$setting? $setting->ttd_penerima : ''}}" readonly>
								<input id="ttd_pospenerima" name="ttd_pospenerima" type="hidden" class="form-control" placeholder="Posisi TTd Penerima" required value="{{$setting? $setting->ttd_pospenerima : ''}}" readonly>
							</div>
						</div>
					@endif --}}
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Keterangan</label>
						<div class="col-lg-10">
							<textarea name="keterangan" id="" cols="30" rows="10" class="summernote form-control border-teal border-1"></textarea>
						</div>
					</div>
				</fieldset>
				<div class="text-right">
                    <a href="{{ url('/payments') }}" class="btn bg-slate"><i class="icon-undo2 mr-2"></i>Kembali</a>
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
<script src="{{asset('global_assets/js/plugins/forms/styling/switch.min.js')}}"></script>
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
<script src="{{asset('global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
<script src="{{ asset('global_assets/js/plugins/editors/summernote/summernote.min.js') }}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/uploader_bootstrap.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_checkboxes_radios.js')}}"></script>
<script src="{{ asset('global_assets/js/demo_pages/editor_summernote.js') }}"></script>
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

	$('#user_id').on('change', function(){
		var nama = $('#user_id option:selected').data('name');
		$('#nama').val(nama);
		$('#nama').text(nama);
		$('#total').val('');

	});

	//function changeDate(select){
	//	var id = $(select).find(':selected').val();
	//	var str = $(select).find(':selected').data('kadaluarsa');
	//	var tgl = str.split("-");
	//	var picker = $(".kadaluarsa").pickadate('picker');
	//	$(".uniform-choice").find("span").removeClass("checked");

	//	picker.set('min', new Date(tgl[0],tgl[1],tgl[2]));
	//	picker.set('select', '');
	//	picker.set('select', null);
	//	picker.render();

		// var role = $(select).find(':selected').data('role');
		// if(role==99){
			// 	$('#updtask').val('3');
			// } else if(role==90){
				// 	$('#updtask').val('15');
				// } else {
					// 	$('#updtask').val('0');
					// }
		// $.ajax({
		// 	type: 'GET',
		// 	url: "{{ url('/getrekaptagihan')}}/"+id,
		// 	success: function (data) {
		// 		$('#tagihan_id').html(data);
		// 	}
		// });
	//}

	function changeTagihan(select){
		var id = $(select).find(':selected').val();
		var tagih = $(select).find(':selected').data('tagihan');
		var bayar = $(select).find(':selected').data('jmlbayar');
		var sisa = (tagih - bayar);
		// console.log(sisa);
		$("#total").prop('value',tagih);
		$("#bayar").prop('value',bayar);
		$("#sisa").prop('value',sisa);

		var val = $('#total').val();
		var val1 = $('#sisa').val();
		var val2 = $('#bayar').val();
		$('#nomtotal').val(val.replace(new RegExp(/\./, 'g'), ''));
		$('#nomsisa').val(val1.replace(new RegExp(/\./, 'g'), ''));
		$('#nombayar').val(val2.replace(new RegExp(/\./, 'g'), ''));
		if(val != "") {
			valArr = val.split('.');
			valArr[0] = (parseInt(valArr[0],10)).toLocaleString('id-ID');
			val = valArr.join('.');
		}
		if(val1 != "") {
			valArr = val1.split('.');
			valArr[0] = (parseInt(valArr[0],10)).toLocaleString('id-ID');
			val1 = valArr.join('.');
		}
		if(val2 != "") {
			valArr = val2.split('.');
			valArr[0] = (parseInt(valArr[0],10)).toLocaleString('id-ID');
			val2 = valArr.join('.');
		}
		$('#total').val(val);
		$('#sisa').val(val1);
		$('#bayar').val(val2);

		// $.ajax({
		// 	type: 'GET',
		// 	url: "{{ url('/detailrekaptagihan')}}/"+id,
		// 	success: function (data) {
		// 		$('#detailTagihan').html(data);
		// 	}
		// });
	}

	$(document).on("input", ".numeric", function() {
		this.value = this.value.replace(/\D/g,'');
	});

	$('#tertulis').focus(function() {
		var angka = $('#nominal').val();
		$('#tertulis').val(angka);
	});

	$('#tertulis').keyup(function() {
		var angka = $('#tertulis').val();
		$('#nominal').val(angka);
		var harga = angka.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
		$('#tertulis').val(harga);
		var total = $("#tagihan_id option:selected").data('tagihan');
		var nominal = $("#nominal").val();
		// console.log(nominal);

		if(nominal > total){
			new PNotify({
				title: 'Error',
				text: 'Melebihi nominal tagihan',
				icon: 'icon-blocked',
				type: 'error'
			});
			$("#tertulis").val(null);
			$("#nominal").val(null);
		}
	});

	function ribuan(){
		var val = $('#total').val();
		$('#nomtotal').val(val.replace(new RegExp(/\./, 'g'), ''));
		val = val.replace(/[^0-9,]/g,'');

		if(val != "") {
			valArr = val.split('.');
			valArr[0] = (parseInt(valArr[0],10)).toLocaleString('id-ID');
			val = valArr.join('.');
		}
		$('#total').val(val);
	}

	$(".cek").click(function() {
		var user_id = $("#user_id option:selected").val();
		// console.log(user_id)
		var rad = $("input[type='radio']:checked").val();
		if(rad){
			// console.log('test');
			$.ajax({
				type: 'GET',
				data: {rad:rad, user_id:user_id},
				url: "{{ url('/getradbox')}}",
				success: function (data) {
					console.log(data)
					$('#tagihan_id').empty();
					$('#tagihan_id').html(data);
				}
			});
		}
		else{
			$('#tagihan_id').empty();
		}
	});

	$('.cek').change(function() {
		$('#total').val('');
	})
</script>
<script>

/* ------------------------------------------------------------------------------
 *
 *  # Form validation
 *
 *  Demo JS code for form_validation.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

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
		// var _componentSwitchery = function() {
		// 	if (typeof Switchery == 'undefined') {
		// 		console.warn('Warning - switchery.min.js is not loaded.');
		// 		return;
		// 	}

		// 	// Initialize single switch
		// 	var elems = Array.prototype.slice.call(document.querySelectorAll('.form-input-switchery'));
		// 	elems.forEach(function(html) {
		// 		var switchery = new Switchery(html);
		// 	});
		// };

		// Bootstrap switch
		// var _componentBootstrapSwitch = function() {
		// 	if (!$().bootstrapSwitch) {
		// 		console.warn('Warning - bootstrap_switch.min.js is not loaded.');
		// 		return;
		// 	}

		// 	// Initialize
		// 	$('.form-input-switch').bootstrapSwitch({
		// 		onSwitchChange: function(state) {
		// 			if(state) {
		// 				$(this).valid(true);
		// 			}
		// 			else {
		// 				$(this).valid(false);
		// 			}
		// 		}
		// 	});
		// };

		// Touchspin
		// var _componentTouchspin = function() {
		// 	if (!$().TouchSpin) {
		// 		console.warn('Warning - touchspin.min.js is not loaded.');
		// 		return;
		// 	}

		// 	// Define variables
		// 	var $touchspinContainer = $('.touchspin-postfix');

		// 	// Initialize
		// 	$touchspinContainer.TouchSpin({
		// 		min: 0,
		// 		max: 100,
		// 		step: 0.1,
		// 		decimals: 2,
		// 		postfix: '%'
		// 	});

		// 	// Trigger value change when +/- buttons are clicked
		// 	$touchspinContainer.on('touchspin.on.startspin', function() {
		// 		$(this).trigger('blur');
		// 	});
		// };

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
			var validator = $('#form_payment').validate({
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
				// success: function(label) {
				// 	label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
				// },

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
					//nominal:{
					//	min : 1,
					//	maxlength : 9
					//},
					//user_id:{
					//	required : true
                    //},
                    //tagihan_id:{
					//	required : true
                    //},
					tertulis:{
						required : true,
						min : 1
					},
					keterangan:{
						required : true
					},
				},
				messages: {
					//nominal:{
					//	min : 'Minimal 1 rupiah',
					//	maxlength: 'Melewati batas inputan'
					//},
                    user_id:{
                        required : 'Mohon pilih user'
                    },
                    tagihan_id:{
                        required : 'Mohon pilih tagihan'
                    },
					tertulis:{
                        required : 'Mohon diisi',
						min : 'Minimal 1 rupiah'
                    },
                    keterangan:{
                        required : 'Mohon diisi'
                    },
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
				// _componentSwitchery();
				// _componentBootstrapSwitch();
				// _componentTouchspin();
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
<script>
	var InputsCheckboxesRadios = function () {
		var _componentUniform = function() {
			if (!$().uniform) {
				console.warn('Warning - uniform.min.js is not loaded.');
				return;
			}

			// Default initialization
			$('.form-check-input-styled').uniform();

			//
			// Contextual colors
			//

			// Primary
			$('.form-check-input-styled-primary').uniform({
				wrapperClass: 'border-primary text-primary'
			});

			// Danger
			$('.form-check-input-styled-danger').uniform({
				wrapperClass: 'border-danger text-danger'
			});

			// Success
			$('.form-check-input-styled-success').uniform({
				wrapperClass: 'border-success text-success'
			});

			// Warning
			$('.form-check-input-styled-warning').uniform({
				wrapperClass: 'border-warning text-warning'
			});

			// Info
			$('.form-check-input-styled-info').uniform({
				wrapperClass: 'border-info text-info'
			});

			// Custom color
			$('.form-check-input-styled-custom').uniform({
				wrapperClass: 'border-indigo-400 text-indigo-400'
			});
		};

		// Switchery
		// var _componentSwitchery = function() {
		// 	if (typeof Switchery == 'undefined') {
		// 		console.warn('Warning - switchery.min.js is not loaded.');
		// 		return;
		// 	}

		// 	// Initialize multiple switches
		// 	var elems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery'));
		// 	elems.forEach(function(html) {
		// 	var switchery = new Switchery(html);
		// 	});

		// 	// Colored switches
		// 	var primary = document.querySelector('.form-check-input-switchery-primary');
		// 	var switchery = new Switchery(primary, { color: '#2196F3' });

		// 	var danger = document.querySelector('.form-check-input-switchery-danger');
		// 	var switchery = new Switchery(danger, { color: '#EF5350' });

		// 	var warning = document.querySelector('.form-check-input-switchery-warning');
		// 	var switchery = new Switchery(warning, { color: '#FF7043' });

		// 	var info = document.querySelector('.form-check-input-switchery-info');
		// 	var switchery = new Switchery(info, { color: '#00BCD4'});
		// };

		// Bootstrap switch
		// var _componentBootstrapSwitch = function() {
		// 	if (!$().bootstrapSwitch) {
		// 		console.warn('Warning - switch.min.js is not loaded.');
		// 		return;
		// 	}

		// 	// Initialize
		// 	$('.form-check-input-switch').bootstrapSwitch();
		// };


		//
		// Return objects assigned to module
		//

		return {
			initComponents: function() {
				_componentUniform();
				// _componentSwitchery();
				// _componentBootstrapSwitch();
			}
		}
	}();


	// Initialize module
	// ------------------------------

	document.addEventListener('DOMContentLoaded', function() {
		InputsCheckboxesRadios.initComponents();
	});

    var Summernote = function() {

        //
        // Setup module components
        //

        // Summernote
        var _componentSummernote = function() {
            if (!$().summernote) {
                console.warn('Warning - summernote.min.js is not loaded.');
                return;
            }

            // Basic examples
            // ------------------------------

            // Default initialization
            $('.summernote').summernote();

            // Control editor height
            $('.summernote-height').summernote({
                height: 400
            });

            // // Air mode
            // $('.summernote-airmode').summernote({
            // 	airMode: true
            // });


            // // // Click to edit
            // // // ------------------------------

            // // // Edit
            // // $('#edit').on('click', function() {
            // // 	$('.click2edit').summernote({focus: true});
            // // })

            // // // Save
            // // $('#save').on('click', function() {
            // // 	var aHTML = $('.click2edit').summernote('code');
            // // 	$('.click2edit').summernote('destroy');
            // // });
        };

        // Uniform
        var _componentUniform = function() {
            if (!$().uniform) {
                console.warn('Warning - uniform.min.js is not loaded.');
                return;
            }

            // Styled file input
            $('.note-image-input').uniform({
                fileButtonClass: 'action btn bg-warning-400'
            });
        };


        //
        // Return objects assigned to module
        //

        return {
            init: function() {
                _componentSummernote();
                _componentUniform();
            }
        }
    }();


    // Initialize module
    // ------------------------------

    document.addEventListener('DOMContentLoaded', function() {
        Summernote.init();
    });
</script>
@endsection


