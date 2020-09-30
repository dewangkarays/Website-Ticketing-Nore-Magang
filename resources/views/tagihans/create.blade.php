@extends('layout')

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Tambah Tagihan</h4>
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
			<form class="form-validate-jquery" action="{{ route('tagihans.store')}}" method="post">
				@csrf
				<fieldset class="mb-3">
					<legend class="text-uppercase font-size-sm font-weight-bold">Data Tagihan</legend>
					
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Pelanggan</label>
						<div class="col-lg-10">
							<select id="user_id" name="user_id" class="form-control select-search" required>
								<option value="">-- Pilih Pelanggan --</option>
								@foreach ($users as $user)
								{{-- <option data-name="{{$user->nama}}" value="{{$user->id}}">{{$user->nama.' ('.$user->username.')'}}</option> --}}
								<option data-name="{{$user->nama}}" value="{{$user->id}}">{{$user->username}}</option>
								@endforeach
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Nama</label>
						<div class="col-lg-10">
							<input type="text" id="nama" name="nama" class="form-control border-teal border-1" value="">
						</div>
					</div>
					{{-- <div class="form-group row">
						<label class="col-form-label col-lg-2">Tipe</label>
						<div class="col-lg-10">
							<select name="tipe" class="form-control select-search" required>
								<option>Langganan</option>
								<option>Ads</option>
								<option>Lainnya</option>
							</select>
						</div>
					</div> --}}
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Langganan</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="langganan" class="form-control border-teal border-1" placeholder="Nominal">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Ads</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="ads" class="form-control border-teal border-1" placeholder="Nominal">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Lainnya</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="lainnya" class="form-control border-teal border-1" placeholder="Nominal">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Nama Proyek</label>
						<div class="col-lg-10">
							<input type="text" id="nama_proyek" name="nama_proyek" class="form-control border-teal border-1" placeholder="Nama Proyek" value="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Nama Penagih</label>
						<div class="col-lg-10">
							<input type="text" id="penagih" name="penagih" class="form-control border-teal border-1" placeholder="Nama Penagih" value=" {{$penagih->penagih}} ">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Keterangan</label>
						<div class="col-lg-10">
							<input type="text" name="keterangan" class="form-control border-teal border-1" placeholder="Keterangan">
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
<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>
<script type="text/javascript">
	// get token
	let getToken = function() {
		return $('meta[name=csrf-token]').attr('content')
	}
	
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
		var id_proyek = $('#user_id option:selected').val();
		var token = getToken();
		$('#nama').val(nama);
		$('#nama').text(nama);
		// alert(id_proyek);
		$.ajax({
			type: "get",
			url : '{{url("getweb")}}/'+id_proyek,
			// jika data string langsung tanpa datatype
			success : function(data){
				$('#nama_proyek').val(data);
				console.log('Success');
			}, error: function (data) {
				console.log('Error:', data);
			}
		});
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
						tagihanname: {
							required: 'Mohon diisi.'
						},
						password: {
							required: 'Mohon diisi.'
						},
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