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
				<h4><span class="font-weight-semibold">Home</span> - Edit Data Pengeluaran</h4>
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
                <form class="form-validate-jquery" action="{{ route('pengeluarans.update', $epengeluaran->id)}}" method="post">
                    @method('PATCH')
					@csrf
					<fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Tagihan</legend>
                        
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal</label>
							<div class="col-lg-10">
								<input name="tanggal" type="text" class="form-control pickadate-accessibility" value="{{ $epengeluaran->tanggal }}" placeholder="Tanggal Pengeluaran" required>
							</div>
                        </div>

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Penanggung Jawab</label>
							<div class="col-lg-10">
								<input type="hidden" name="nama_pj" value="{{ @$epengeluaran->user->nama }}">
								<select id="user_id" name="user_id" class="form-control select-search">
									<option value="">-- Pilih Penanggung Jawab --</option>
									@foreach ($users as $user)
										<option {{ $epengeluaran->user_id == $user->id ? 'selected' : '' }} value="{{$user->id}}">{{ $user->nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
                        
                        {{-- <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama Pengeluaran</label>
							<div class="col-lg-10">
								<input name="pengeluaran" type="text" class="form-control" value="{{ $epengeluaran->pengeluaran }}" placeholder="Nama Pengeluaran" required>
							</div>
						</div> --}}

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Jenis Pengeluaran</label>
							<div class="col-lg-10">
								<select name="jenis_pengeluaran" class="form-control select-search border-teal border-1" required>
									@foreach (config("custom.kat_pengeluaran") as $key => $value)
										<option {{ $epengeluaran->jenis_pengeluaran == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
									@endforeach
                                    {{-- <option value="0" {{ $epengeluaran->jenis_pengeluaran == '0' ? 'selected' : '' }}>Gaji</option>
                                    <option value="1" {{ $epengeluaran->jenis_pengeluaran == '1' ? 'selected' : '' }}>Aset</option>
                                    <option value="2" {{ $epengeluaran->jenis_pengeluaran == '2' ? 'selected' : '' }}>Non-Aset</option>
                                    <option value="3" {{ $epengeluaran->jenis_pengeluaran == '3' ? 'selected' : '' }}>Konsumsi</option>
                                    <option value="6" {{ $epengeluaran->jenis_pengeluaran == '6' ? 'selected' : '' }}>Modal</option>
                                    <option value="4" {{ $epengeluaran->jenis_pengeluaran == '4' ? 'selected' : '' }}>Bonus</option>
                                    <option value="5" {{ $epengeluaran->jenis_pengeluaran == '5' ? 'selected' : '' }}>Lain - Lain</option> --}}
                                </select>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nominal</label>
							<div class="col-lg-10">
								<input type="number" min="0" name="nominal" class="form-control border-teal border-1" value="{{ $epengeluaran->nominal }}" placeholder="Nominal" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Keterangan</label>
							<div class="col-lg-10">
								{{-- <input type="text" name="keterangan" class="form-control border-teal border-1" value="{{ $epengeluaran->keterangan }}" placeholder="Keterangan"> --}}
								<span class="form-text text-muted">Contoh: Pengeluaran untuk bonus bulan April</span>
                                <textarea name="keterangan" id="" cols="30" rows="10" class="summernote form-control border-teal border-1">{{ $epengeluaran->keterangan }}</textarea>
							</div>
						</div>
					</fieldset>
					<div class="text-right">
						<a href="{{ url('/pengeluarans') }}" class="btn bg-slate">Kembali <i class="icon-undo2 ml-2"></i></a>
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
	<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>
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
		                tgl_pengeluaran: {
		                    required: 'Mohon diisi.'
		                },
		                nama_pengeluaran: {
		                    required: 'Mohon diisi.'
		                },
		                // jenis_pengeluaran: {
		                //     required: 'Mohon diisi.'
		                // },
		                nominalp: {
		                    required: 'Mohon diisi.'
		                },
		                // keterangan: {
		                //     required: 'Mohon diisi.'
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


		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		    FormValidation.init();
		});

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


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            Summernote.init();
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