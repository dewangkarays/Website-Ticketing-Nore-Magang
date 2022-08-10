@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Tambah Pengeluaran</h4>
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
				<form class="form-validate-jquery" action="{{ route('pengeluarans.store')}}" method="post">
					@csrf
					<fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Tagihan</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal</label>
							<div class="col-lg-10">
								<input name="tanggal" type="text" class="form-control pickadate-accessibility" placeholder="Tanggal Pengeluaran" value="{{  date('Y-m-d') }}" required>
                                <span class="form-text text-muted">Ubah tanggal jika pengeluaran tidak dilakukan HARI INI</span>
							</div>
                        </div>

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Penanggung Jawab</label>
							<div class="col-lg-10">
								<select id="user_id" name="user_id" class="form-control select-search" required>
									<option value="">-- Pilih Penanggung Jawab --</option>
									@foreach ($users as $user)
									<option value="{{$user->id}}">{{$user->nama}}</option>
									@endforeach
								</select>
							</div>
						</div>

                        {{-- <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama Pengeluaran</label>
							<div class="col-lg-10">
								<input name="pengeluaran" type="text" class="form-control" placeholder="Nama Pengeluaran" required>
							</div>
						</div> --}}

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Kategori Pengeluaran</label>
							<div class="col-lg-10">
								<select name="jenis_pengeluaran" class="form-control select-search border-teal border-1" required>
									<option value="">-- Pilih Kategori Pengeluaran --</option>
									@foreach (config("custom.kat_pengeluaran") as $key => $value)
										<option value="{{ $key }}">{{ $value }}</option>
									@endforeach
                                    {{-- <option value="0">Gaji</option>
                                    <option value="1">Aset</option>
                                    <option value="2">Non-Aset</option>
                                    <option value="3">Konsumsi</option>
                                    <option value="6">Modal</option>
                                    <option value="4">Bonus</option>
                                    <option value="5">Lain - Lain</option> --}}
                                </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nominal</label>
							<div class="col-lg-10">
								<input id="tertulis" type="text" name="tampilNominal" onkeyup="ribuan()" class="form-control" placeholder="Nominal" required>
								<input id="nominal" type="hidden" name="nominal" value="{{old('nominal')}}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Keterangan</label>
							<div class="col-lg-10">
								{{-- <input type="text" name="keterangan" class="form-control border-teal border-1" placeholder="Keterangan"> --}}
								<span class="form-text text-muted">Contoh: Pengeluaran untuk bonus bulan April</span>
                                <textarea name="keterangan" id="" cols="30" rows="10" class="summernote form-control border-teal border-1" required>{{ old('keterangan') }}</textarea>
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
		                tanggal: {
		                    required: 'Mohon diisi.'
		                },
						user_id:{
							required : 'Mohon diisi.'
						},
		                // pengeluaran: {
		                //     required: 'Mohon diisi.'
		                // },
		                jenis_pengeluaran: {
		                    required: 'Mohon diisi.'
		                },
		                tampilNominal: {
		                    required: 'Mohon diisi.'
		                },
		                keterangan: {
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
                    toolbar: false,
				    height: 100,
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

		function ribuan(){
			var val = $('#tertulis').val();
			$('#nominal').val(val.replace(new RegExp(/\./, 'g'), ''));
			val = val.replace(/[^0-9,]/g,'');

			if(val != "") {
				valArr = val.split('.');
				valArr[0] = (parseInt(valArr[0],10)).toLocaleString('id-ID');
				val = valArr.join('.');
			}
			$('#tertulis').val(val);
		}
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
