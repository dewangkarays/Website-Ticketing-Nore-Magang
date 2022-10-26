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
			<h4><span class="font-weight-semibold">Home</span> - Tambah Pemasukan Lainnya</h4>
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
            <form id="form_payment" class="form-validate-jquery" action="{{ route('pemasukans.store') }}" method="post">
                @csrf
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Pemasukan</legend>

                    <div class="form-group row">
						<label class="col-form-label col-lg-2">Tanggal Pembayaran</label>
						<div class="col-lg-10">
							<input name="tanggal" type="text" class="form-control pickadate-accessibility" placeholder="Contoh: 2022-04-16" value="{{  date('Y-m-d') }}" required>
							<span class="form-text text-muted">Ubah tanggal jika pembayaran tidak dilakukan HARI INI</span>
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-form-label col-lg-2">Nominal</label>
						<div class="col-lg-10">
							<input type="text" id="tertulis" name="tertulis" onkeyup="ribuan()" class="form-control border-teal border-1 numeric" placeholder="Contoh: 2.000.000" required>
							<input type="hidden" id="nominal" name="nominal" class="form-control border-teal border-1">
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-form-label col-lg-2">Keterangan</label>
						<div class="col-lg-10">
							<textarea name="keterangan" id="" cols="30" rows="10" class="summernote form-control border-teal border-1"></textarea>
						</div>
					</div>
                </fieldset>
                <div class="text-right">
                    <a href="{{ url('/pemasukans') }}" class="btn bg-slate"><i class="icon-undo2 mr-2"></i>Kembali</a>
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
    <script src="{{asset('global_assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
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
                // $('.summernote-height').summernote({
                //     height: 400
                // });

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
                        nominal:{
                            required : true,
                            min : 1
                        },
                        keterangan:{
                            required : true
                        },
                    },
                    messages: {
                        nominal:{
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