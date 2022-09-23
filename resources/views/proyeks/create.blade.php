@extends('layout')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">Home</span> - Tambah Proyek</h4>
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
                <form id="form_proyek" class="form-validate-jquery" action="{{ route('proyeks.store')}}" method="post">
                    @csrf
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Proyek</legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Klien</label>
                            <div class="col-lg-10">
                                <select name="user_id" class="form-control select-search" >
                                    <option value="">-- Pilih Klien --</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nama Proyek</label>
                            <div class="col-lg-10">
                                <input type="text" name="nama_proyek" class="form-control border-teal border-1" placeholder="Contoh : Pembuatan Website" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Website</label>
                            <div class="col-lg-10">
                                <input type="text" id="website" name="website" class="form-control border-teal border-1" placeholder="Contoh : nore.web.id" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Jenis Proyek</label>
                            <div class="col-lg-10">
                                <select id="jenis_proyek" name="jenis_proyek" class="form-control select-search border-teal border-1" >
                                    <option value="">-- Pilih Jenis Proyek --</option>
                                    @foreach (config('custom.jenis_proyek') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="div-tipe" class="form-group row" style="display:none">
                            <label class="col-form-label col-lg-2">Kelas Layanan</label>
                            <div class="col-lg-10">
                                {{-- <select id="tipe" name="tipe" class="form-control border-teal border-1" >
                                    <option value="0">-- Pilih Kelas Layanan --</option>
                                    @foreach (config('custom.kelas_layanan') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select> --}}
                                <select id="tipe_web" name="tipe_web" class="form-control border-teal border-1" style="display:none">
                                    <option value="">-- Pilih Kelas Layanan --</option>
                                    <option value="99">Simple</option>
                                    <option value="90">Prioritas</option>
                                </select>
                                <select id="tipe_app" name="tipe_app" class="form-control border-teal border-1" style="display:none">
                                    <option value="80">Premium</option>
                                </select>
                            </div>
                        </div>

                        <div id="div-jl" class="form-group row" style="display:none">
                            <label class="col-form-label col-lg-2">Jenis Layanan</label>
                            <div class="col-lg-10">
                                {{-- <select id="jenis_layanan" name="jenis_layanan" class="form-control border-teal border-1" >
                                    <option value="0">-- Pilih Jenis Layanan --</option>
                                    @foreach (config('custom.jenis_layanan') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select> --}}
                                <select id="jl_web" name="jl_web" class="form-control border-teal border-1" style="display:none">
                                    <option value="">-- Pilih Jenis Layanan --</option>
                                    <option value="1">Nore</option>
                                    <option value="2">Mini</option>
                                    <option value="4">Beli/Lepas</option>
                                </select>
                                <select id="jl_app" name="jl_app" class="form-control border-teal border-1" style="display:none">
                                    <option value="">-- Pilih Jenis Layanan --</option>
                                    <option value="3">Berlangganan</option>
                                    <option value="4">Beli/Lepas</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Jumlah Task</label>
                            <div class="col-lg-10">
                                <input name="task_count" type="number" class="form-control border-teal border-1" placeholder="Tentukan Jumlah Task">
                            </div>
                        </div>

                        <div id="div-masa" class="form-group row" style="display:none">
                            <label class="col-form-label col-lg-2">Masa Berlaku</label>
                            <div class="col-lg-10">
                                <input id="masa_berlaku" name="masa_berlaku" type="text" class="form-control border-teal pickadate-accessibility" placeholder="Tanggal Masa Berlaku">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Keterangan</label>
                            <div class="col-lg-10">
                                <span class="form-text text-muted">Contoh: Website blogspot Noer Prajitno</span>
                                <textarea name="keterangan" id="" cols="30" rows="10" class="summernote form-control border-teal border-1" required>{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Marketing</label>
							<div class="col-lg-10">
								{{-- <input type="text" id="name" name="name" class="form-control border border-1" placeholder="Nama" data-user_id="0" required > --}}
								<select id="name" name="name" class="form-control select-search" data-user_id="0" required>
									<option value="">-- Pilih Karyawan --</option>
									@foreach($karyawans as $karyawan)
										<option marketing_id="{{ $karyawan->marketing_id }}" data-nip="{{ $karyawan->nip }}" value="{{$karyawan->id}}">{{$karyawan->nama}} </option>
				    				@endforeach
								</select>
							</div>
						</div>

                    </fieldset>
                    <div class="text-right">
                        <a href="{{ url('/proyeks') }}" class="btn bg-slate"><i class="icon-undo2 mr-2"></i>Kembali</a>
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

    //select search
    // $(document).ready(function() {
    //     $('.form-control').materialSelect();
    // });


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

            var $select = $('.select-search').select2();

			// Initialize
			//var $select = $('.form-control-select2').select2({
				//minimumResultsForSearch: Infinity
			//});

			// Trigger value change when selection is made
			$select.on('change', function() {
				$(this).trigger('blur');
			});

            $('#jenis_proyek').on('change', function() {
                var dropdown = $('#jenis_proyek option:selected').val()
                console.log(dropdown)
                if (dropdown=="" || dropdown==0 || dropdown==5 || dropdown==2) {
                    $('#div-tipe, #div-jl').hide()
                    // $('#tipe_web, #tipe_app, #jl_web, #jl_app, #website').val("").attr("required", false)
                    $('#tipe_web, #tipe_app, #jl_web, #jl_app').val("").attr("required", false)
                    if (dropdown==5) {
                        $('#div-masa').show()
                    } else {
                        $('#div-masa').hide()
                    }
                } else {
                    $('#div-tipe, #div-jl').show()
                    $('#div-masa').show()
                    // $('#masa_berlaku').val("").attr("required", false)
                    if (dropdown==1) {
                        $('#tipe_web, #jl_web').show().attr("required", true)
                        $('#tipe_app, #jl_app').hide().val("").attr("required", false)
                        $('#website').attr("required", true)
                    } else {
                        $('#tipe_web, #jl_web').hide().val("").attr("required", false)
                        $('#tipe_app, #jl_app').show().attr("required", true)
                        $('#tipe_app').val(80)
                        $('#website').attr("required", false)
                    }
                }
            });

            $('#jl_app, #jl_web').on('change', function() {
                var dropdown_app = $('#jl_app option:selected').val()
                var dropdown_web = $('#jl_web option:selected').val()
                console.log([dropdown_app, dropdown_web])
                if (dropdown_app==4 || dropdown_web==4) {
                    $('#div-masa').hide()
                    // $('#masa_berlaku').val("").attr("required", false)
                } else {
                    $('#div-masa').show()
                    // $('#masa_berlaku').attr("required", true)
                }
            });

		};

        // Validation config
        var _componentValidation = function() {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }

            // Initialize
            var validator = $('#form_proyek').validate({
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
                //success: function(label) {
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
                rules: {
					user_id:{
						required : true
					},
                    nama_proyek:{
						required : true
					},
					jenis_proyek:{
						required : true
					},
                    task_count:{
						required : true
					},
                    keterangan:{
						required : true
					},
				},
                messages: {
                    user_id: {
                        required: 'Mohon diisi.'
                    },
                    nama_proyek: {
                        required: 'Mohon diisi.'
                    },
                    website: {
                        required: 'Mohon diisi.'
                    },
                    jenis_proyek: {
                        required: 'Mohon pilih satu jenis proyek!'
                    },
                    jl_web: {
                        required: 'Mohon pilih satu jenis layanan!'
                    },
                    jl_app: {
                        required: 'Mohon pilih satu jenis layanan!'
                    },
                    tipe_web: {
                        required: 'Mohon pilih satu kelas layanan!'
                    },
                    tipe_app: {
                        required: 'Mohon pilih satu kelas layanan!'
                    },
                    task_count:{
                        required: 'Min : 0',
						min : 0
					},
                    masa_berlaku: {
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
				_componentUniform();
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
