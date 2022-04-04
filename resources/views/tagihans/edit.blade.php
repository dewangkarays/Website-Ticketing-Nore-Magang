@extends('layout')

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><span class="font-weight-semibold">Home</span> - Ubah Tagihan</h4>
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
			<form class="form-validate-jquery" enctype="multipart/form-data" action="{{ route('tagihans.update', $tagihan->id)}}" method="post">
				@method('PATCH')
				@csrf
				<fieldset class="mb-3">
					<legend class="text-uppercase font-size-sm font-weight-bold">Data Tagihan</legend>

					<div class="form-group row">
						<label class="col-form-label col-lg-2">Pelanggan</label>
						<div class="col-lg-10">
							<select id="user_id" name="user_id" class="form-control select-search" required disabled>
								<option value="">-- Pilih Pelanggan --</option>
								@foreach ($users as $user)
								<option data-pnama="{{$user->nama}}" data-pproyek="{{$user->website}}" {{ $tagihan->user_id == $user->id ? 'selected' : '' }} value="{{$user->id}}">{{$user->nama}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Proyek</label>
						<div class="col-lg-10">
                            @if ($tagihan->id_proyek == null)
                                <select id="select_proyek" name="select_proyek" class="form-control select-search">
                                    <option value="">-- Pilih Proyek --</option>
                                </select>
                            @else
                                <select name="select_proyek" class="form-control select-search" required disabled>
                                    <option value="">{{ $tagihan->nama_proyek }}</option>
                                </select>
                            @endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Nama Proyek</label>
						<div class="col-lg-10">
                            @if ($tagihan->id_proyek == null)
                                <input type="hidden" id="id_proyek" name="id_proyek" class="form-control border-teal border-1" value="{{old('id_proyek')}}">
							    <input type="text" id="nama_proyek" name="nama_proyek" class="form-control border-teal border-1" placeholder="Nama Proyek" value="{{old('nama_proyek')}}" readonly>
                            @else
                                <input type="text" name="nama_proyek" class="form-control border-teal border-1" placeholder="Nama Proyek" value="{{ $tagihan->nama_proyek }}" readonly>
                            @endif
						</div>
					</div>
					@if ($tagihan->proyek->jenis_layanan == 3)
						<div class="form-group row" style="display: none;">
							<label class="col-form-label col-lg-2">Update Masa Berlaku</label>
							<div class="col-lg-10">
								@if ($tagihan->id_proyek == null)
									<input id="masa_berlaku" name="masa_berlaku" type="text" class="form-control pickadate-accessibility"  value="{{old('masa_berlaku')}}" placeholder="Tanggal Masa Berlaku">
								@else
									<input type="text" name="masa_berlaku" class="form-control pickadate-accessibility" placeholder="Tanggal Masa Berlaku" value="{{ $tagihan->masa_berlaku }}">
								@endif
								<span class="form-text text-muted">Ubah jika ingin perpanjang masa berlaku</span>
								{{-- <input type="text" id="kadaluarsa" name="kadaluarsa" class="form-control border-teal border-1"> --}}
							</div>
							{{-- <span id="kadaluarsa" name="kadaluarsa" class="col-form-label col-lg-10 font-weight-bold">{{@$}}</span> --}}
						</div>
					@else
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Update Masa Berlaku</label>
							<div class="col-lg-10">
								@if ($tagihan->id_proyek == null)
									<input id="masa_berlaku" name="masa_berlaku" type="text" class="form-control pickadate-accessibility"  value="{{old('masa_berlaku')}}" placeholder="Tanggal Masa Berlaku">
								@else
									<input type="text" name="masa_berlaku" class="form-control pickadate-accessibility" placeholder="Tanggal Masa Berlaku" value="{{ $tagihan->masa_berlaku }}">
								@endif
								<span class="form-text text-muted">Ubah jika ingin perpanjang masa berlaku</span>
								{{-- <input type="text" id="kadaluarsa" name="kadaluarsa" class="form-control border-teal border-1"> --}}
							</div>
							{{-- <span id="kadaluarsa" name="kadaluarsa" class="col-form-label col-lg-10 font-weight-bold">{{@$}}</span> --}}
						</div>
					@endif
                    <div class="form-group row">
						<label class="col-form-label col-lg-2">Nominal</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="nominal" class="form-control border-teal border-1" placeholder="Nominal" value="{{ $tagihan->nominal }}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Uang Muka</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="uang_muka" class="form-control border-teal border-1" placeholder="Uang Muka" value="{{ $tagihan->uang_muka }}">
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-form-label col-lg-2">Keterangan</label>
						<div class="col-lg-10">
							<input type="text" name="keterangan" value="{{ $tagihan->keterangan }}" class="form-control border-teal border-1" placeholder="Keterangan">
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
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Langganan</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="langganan" value="{{ $tagihan->langganan }}" class="form-control border-teal border-1" placeholder="Nominal">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Ads</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="ads" value="{{ $tagihan->ads }}" class="form-control border-teal border-1" placeholder="Nominal">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Lainnya</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="lainnya" value="{{ $tagihan->lainnya }}" class="form-control border-teal border-1" placeholder="Nominal">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Jml Bayar</label>
						<div class="col-lg-10">
							<input type="text" name="jml_bayar" value="{{ $tagihan->jml_bayar }}" class="form-control border-teal border-1" placeholder="Nominal">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Status</label>
						<div class="col-lg-10">
							<select name="status" class="form-control select-search" required>
								@foreach (config('custom.tagihan_status') as $key => $val)
								<option {{ $tagihan->status == $key ? 'selected' : '' }} value="{{$key}}">{{$val}}</option>
								@endforeach

							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-lg-2">Nama Proyek</label>
						<div class="col-lg-10">
							<input type="text" id="nama_proyek" name="nama_proyek" class="form-control border-teal border-1" placeholder="Nama Proyek" value="{{$tagihan->nama_proyek}}" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Nama Penagih</label>
						<div class="col-lg-10">
							<input type="text" id="penagih" name="penagih" class="form-control border-teal border-1" placeholder="Nama Penagih" value="{{$tagihan->penagih}} ">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Posisi Penagih</label>
						<div class="col-lg-10">
							<input type="text" id="pospenagih" name="pospenagih" class="form-control border-teal border-1" placeholder="Nama Penagih" value="{{$tagihan->pospenagih}}">
						</div>
					</div>  --}}


				</fieldset>
				<div class="text-right">
                    <a href="{{ url('/tagihans') }}" class="btn bg-slate"><i class="icon-undo2 mr-2"></i>Kembali</a>
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

	$('#user_id').ready(function(){
		var id_proyek = $('#user_id option:selected').val();
		var pnama = $('#user_id option:selected').data('pnama');
		$('#nama').val(pnama);
		$('#select_proyek').find('option').not(':first').remove();
		$('#nama_proyek').val('');

		$.ajax({
			type: 'get',
			url : '{{url("getkadaluarsa")}}/'+id_proyek,
			success : function(data){
				// $('#kadaluarsa').val(data);
				$('#kadaluarsa').text(data);
				console.log('Success');
			},
			error:function(data){
				console.log('Error',data);
			}
		});

		$.ajax({
			url : '{{url("getproyek")}}/'+id_proyek,
			type: 'get',
			dataType: 'json',
			success : function(res){
				var len = 0;
				if(res['data'] != null){
					len = res['data'].length;
				}
				// alert(len);
				if(len > 0){
					// Read data and create <option >
						for(var i=0; i<len; i++){

							var id = res['data'][i].id;
							var website = res['data'][i].website;

							var option = "<option value='"+id+"'>"+website+"</option>";

							$("#select_proyek").append(option);
						}
					}
					console.log('Success2');
				},
				error:function(data){
					console.log('Error2',data);
				}
			});

		});

		$('#select_proyek').on('change',function() {
			var proyek = $('#select_proyek option:selected').text();
			$('#nama_proyek').val(proyek);
            var id_proyek = $('#select_proyek option:selected').val();
			$('#id_proyek').val(id_proyek);
            $.ajax({
                type: 'get',
                url : '{{url("getmasa_berlaku")}}/'+id_proyek,
                success : function(data){
                    // $('#kadaluarsa').val(data);
                    $('#masa_berlaku').val(data);
                    $('#masa_berlaku').text(data);
                    console.log('Success');
                },
                error:function(data){
                    console.log('Error',data);
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
