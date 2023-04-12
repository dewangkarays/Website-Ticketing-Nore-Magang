@extends('layout')
@section('css')
<style>
	.summernote ol, ul{
		list-style: disc !important;
		list-style-position: inside;
	}
</style>
@endsection
@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Tambah Klien</h4>
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
				<form class="form-validate-jquery" id="form" action="{{ route('klien.savecreate')}}" method="post">
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Klien</legend>

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nama Klien</label>
							<div class="col-lg-10">
                                <input type="text" name="nama_calonklien" class="form-control border-teal border-1" placeholder="Nama klien" required>
                            </div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nama Perusahaan</label>
							<div class="col-lg-10">
								<input type="text" name="nama_perusahaan" class="form-control border-teal border-1" placeholder="Nama Perusahaan" required>
                        </div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Jenis Perusahaan</label>
							<div class="col-lg-10">
                                <input type="text" id="jenis_perusahaan" name="jenis_perusahaan" class="form-control border-teal border-1" placeholder="Jenis Perusahaan" required>
                            </div>
						</div>
						<div class="form-group row">
                            <label class="col-form-label col-lg-2">Potensi</label>
                            <div class="col-lg-10">
                                <select id="potensi" name="potensi" class="form-control select-search border-teal border-1" >
                                    <option value="">-- Pilih Produk Nore --</option>
                                    @foreach (config('custom.jenis_proyek') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tanggal Kontak Pertama</label>
                            <div class="col-lg-10">
                                <input id="tanggal_kontakpertama" name="tanggal_kontakpertama" type="date" class="form-control pickadate-accessibility" placeholder="Pilih Tanggal"  required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tanggal Kontak Terakhir</label>
                            <div class="col-lg-10">
                                <input id="tanggal_kontakterakhir" name="tanggal_kontakterakhir" type="date" class="form-control pickadate-accessibility" placeholder="Pilih Tanggal" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Status Lead</label>
                            <div class="col-lg-10">
                                <select id="status_nore" name="status" class="form-control select-search border-teal border-1" >
                                    <option value="">-- Lead --</option>
                                    @foreach (config('custom.status_klien') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Telp</label>
							<div class="col-lg-10">
                                <input type="text" name="telp" class="form-control border-teal border-1 phone-number" placeholder="Telp/WA">
								<span class="form-text text-muted">Contoh : 628123456678 (gunakan kode negara tanpa tanda + dan spasi)</span>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat</label>
							<div class="col-lg-10">
                                <input type="text" name="alamat" class="form-control border-teal border-1" placeholder="Alamat">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Marketing</label>
							<div class="col-lg-10">
								<select id="marketing_id" name="marketing_id" class="form-control select-search" data-user_id="0" required>
									<option value="">-- Pilih Marketing --</option>
									@foreach($marketings as $marketing)
										<option value="{{$marketing->id}}">{{$marketing->nama}} </option>
				    				@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
                            <label class="col-form-label col-lg-2">Source</label>
                            <div class="col-lg-10">
                                <select id="source" name="source" class="form-control select-search border-teal border-1">
                                    <option value="">-- Source --</option>
                                    @foreach (config('custom.source') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
						<div class="form-group row">
                            <label class="col-form-label col-lg-2">Keterangan lain</label>
                            <div class="col-lg-10">
                                <span class="form-text text-muted">Contoh: Website blogspot Noer Prajitno</span>
                                <textarea name="keterangan_lain" id="" cols="30" rows="10" class="summernote form-control border-teal border-1" required>{{ old('keterangan_lain') }}</textarea>
                            </div>
                        </div>
					</fieldset>
					<div class="text-right">
						<a href="{{ url('/klien') }}" class="btn bg-slate">Kembali <i class="icon-undo2 ml-2"></i></a>
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
	<script src="{{ asset('global_assets/js/plugins/editors/summernote/summernote.min.js') }}"></script>

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
	<script src="{{ asset('global_assets/js/demo_pages/editor_summernote.js') }}"></script>
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
			var validator = $('#form').validate({
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
					nama_calon_klien:{
						required : true
					}, 
					nama_perusahaan:{
						required : true,
						nama_perusahaan: true
					},
					telp:{
						required : true,
						number : true,
					},
					
					
				},
				messages: {
					nama_calon_klien:{
						required : 'Mohon diisi.'
					},
					nama_perusahaan:{
						required : 'Mohon diisi.',
						nama_perusahaan : 'Masukan nama perusahaan dengan benar'
					},
					telp:{
						required : 'Mohon diisi.',
						number : 'Hanya mengandung angka'
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

		 //sumernote wysiwyg
		 var Summernote = function() {
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