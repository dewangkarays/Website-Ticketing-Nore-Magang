@extends('layout')
@section('css')
<style>
	/* .summernote ol, ul{
		list-style: disc !important;
		list-style-position: inside;
	} */
</style>
@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Presensi Harian</span></h4>
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
				<form class="form-validate-jquery" action="{{ route('presensi.store')}}" method="post" enctype="multipart/form-data">
					@csrf
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Form Presensi Harian</legend>
                        @if(\Auth::user()->role==10 || \Auth::user()->role==20 || \Auth::user()->role>=30 && \Auth::user()->role<=50)
						<div class="form-group row">
						<label class="col-form-label col-lg-2">Nama</label>
							<div class="col-lg-10">
                                <input type="text" name="nama" id="nama" class="form-control border border-1" value="{{\Auth::user()->nama}}" readonly>
								<input type="hidden" name="user_id" value="{{\Auth::user()->id}}">
                        	</div>
						</div>
						@else
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nama</label>
							<div class="col-lg-10">
								@if ($role != 1)
                                <input type="text" id="nama" name="nama" class="form-control border border-1" value="{{$users->nama}}" readonly>
                                <input type="hidden" name="user_id" value="{{$users->id}}">
                                @else
                                <select name="user_id" id="user_id" class="form-control select-search">
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}"
                                            data-nip="{{$user->nip}}"
                                            data-divisi="{{config('custom.role.'.$user->role)}}"
                                            data-jabatan="{{$user->jabatan}}">
                                            {{$user->nama}}
                                        </option>
                                    @endforeach
                                </select>
                                @endif
							</div>
						</div>
						@endif
						<div class="form-group row">
							<label class="col-form-label col-lg-2">NIP</label>
							<div class="col-lg-10">
								@if ($role != 1)
                                <input type="text" name="nip" id="nip" class="form-control border border-1" value="{{$users->nip}}" readonly>
                                @else
                                <input type="text" name="nip" id="nip" class="form-control border border-1" readonly>
                                @endif
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Divisi</label>
							<div class="col-lg-10">
								@if ($role != 1)
                                <input type="text" name="divisi" id="divisi" class="form-control border border-1" value="{{config('custom.role.'.$users->role)}}" readonly>
                                @else
                                <input type="text" name="divisi" id="divisi" class="form-control border border-1" readonly>
                                @endif
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Jabatan</label>
							<div class="col-lg-10">
								@if ($role != 1)
                                <input type="text" name="jabatan" id="jabatan" class="form-control border border-1" value="{{$users->jabatan}}" readonly>
                                @else
                                <input type="text" name="jabatan" id="jabatan" class="form-control border border-1" readonly>
                                @endif
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal</label>
							<div class="col-lg-10">
								@if ($role != 1)
                                <input type="text" name="tanggal_show" id="tanggal_show" class="form-control border border-1" value="{{date('d F Y')}}" readonly>
                                <input type="hidden" name="tanggal" id="tanggal" value="{{date('Y-m-d')}}">
                                @else
                                <input type="date" name="tanggal" id="tanggal" value="{{date('Y-m-d')}}" class="form-control pickadate-accessibility">
                                @endif
							</div>
						</div>
                        <div id="div-verif1" class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
							<div class="col-lg-10">
								<select id="status" name="status" class="form-control select-search">
									{{-- <option value="">-- Pilih Verifikator --</option> --}}
                                    @foreach(config('custom.status_presensi') as $key => $value)
										<option value="{{$key}}">{{$value}}</option>
									@endforeach
								</select>
							</div>
						</div>
                    </fieldset>
					<div class="form-group row" id="div-keterangan" style="display: none">
						<label class="col-form-label col-lg-2">Keterangan</label>
						<div class="col-lg-10">
							{{-- <div class="summernote form-control border-teal border-1" name="keterangan" placeholder="Keterangan" value="{{old('keterangan')}}"required></div> --}}
							{{-- <input type="text" name="keterangan" class="summernote form-control border-teal border-1" placeholder="Keterangan" value="{{old('keterangan')}}"> --}}
							<textarea name="keterangan" id="keterangan" cols="30" rows="10" class="summernote form-control border-teal border-1"></textarea>
						</div>
					</div>
					<div class="form-group row" id="div-bukti" style="display: none">
                        <label class="col-form-label col-lg-2">Bukti</label>
                        <div class="col-lg-10">
                            <input id="bukti" name="bukti" type="file" class="form-control" onchange="upload_check()">
                            <span class="form-text text-muted">Lampirkan bukti izin</span>
                        </div>
                    </div>
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

	<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	{{-- <script src="{{asset('global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script> --}}

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>
	<script src="{{ asset('global_assets/js/demo_pages/editor_summernote.js') }}"></script>

    <script src="{{asset('global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/anytime.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/editors/summernote/summernote.min.js') }}"></script>
	<script>
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
			// tanggal_mulai: {
			// 	required: 'Mohon diisi.'
			// },
			// tanggal_akhir: {
			// 	required: 'Mohon diisi.'
			// },
			// verifikator_2: {
			// 	required: 'Pilih salah satu.'
			// },
			// verifikator_1: {
			// 	required: 'Pilih salah satu.'
			// },
			// alasan: {
			// 	required: 'Mohon diisi.'
			// },
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
	$('.summernote').summernote({
		toolbar: [
		['para', ['ul', 'ol', 'paragraph']],
		],
		height: 100,
		callbacks: {
			onPaste: function (e) {
			var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

			e.preventDefault();

			setTimeout( function(){
				document.execCommand( 'insertText', false, bufferText );
			}, 10 );
			}
		}
	});

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

document.addEventListener('DOMContentLoaded', function() {
		    FormValidation.init();
			Summernote.init();
		});
	</script>
	<script>
		

		$('.pickadate-accessibility').pickadate({
		   labelMonthNext: 'Go to the next month',
		   labelMonthPrev: 'Go to the previous month',
		   labelMonthSelect: 'Pick a month from the dropdown',
		   labelYearSelect: 'Pick a year from the dropdown',
		   selectMonths: true,
		   selectYears: true,
		   format: 'yyyy-mm-dd',
		   max: new Date(),
		   disable: [1,7],
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
    $('#user_id').on('change', function() {
        // var nip = $(this).children("option:selected").data('nip')
        $('#nip').val($(this).children("option:selected").data('nip'))
        $('#divisi').val($(this).children("option:selected").data('divisi'))
        $('#jabatan').val($(this).children("option:selected").data('jabatan'))
    })

	$('#status').on('change', function() {
		if ($('#status').val() != 1) {
			$('#div-keterangan').show();
			$('#keterangan').prop('required', true);
			$('#div-bukti').show();
		} else {
			$('#div-keterangan').hide();
			$('#keterangan').prop('required', false);
			$('#div-bukti').hide();
		}
	})
</script>

@endsection