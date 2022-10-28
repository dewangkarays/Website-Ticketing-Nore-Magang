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
            <form id="form_proyek" class="form-validate-jquery" action="{{ route('proyeks.update',$proyek->id)}}" method="post">
                @method('PATCH')
                @csrf
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Proyek</legend>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Klien</label>
                        @if(@$proyek->user->nama == null)
                            <div class="col-lg-10">
                                <select name="user_id" class="form-control select-search" >
                                    <option value="">-- Pilih Klien --</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="user_id" value={{$proyek->user_id}}>
                            <label class="col-form-label col-lg-10">{{$proyek->user->nama}}</label>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Nama Proyek</label>
                        <div class="col-lg-10">
                            <input type="text" name="nama_proyek" class="form-control border-teal border-1" placeholder="Contoh : Pembuatan Website" value="{{$proyek->nama_proyek}}" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Website</label>
                        <div class="col-lg-10">
                        <input type="text" id="website" name="website" class="form-control border-teal border-1" placeholder="Contoh : nore.web.id" value="{{$proyek->website}}" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Jenis Proyek</label>
                        <div class="col-lg-10">
                            <select id="jenis_proyek" name="jenis_proyek" class="form-control select-search border-teal border-1" >
                                @if ($proyek->jenis_proyek == null)
                                    <option value="">-- Pilih Jenis Proyek --</option>
                                @endif
                                @foreach (config('custom.jenis_proyek') as $key => $value)
                                    <option {{ $proyek->jenis_proyek == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="div-tipe" class="form-group row" style="display:none">
                        <label class="col-form-label col-lg-2">Kelas Layanan</label>
                        <div class="col-lg-10">
                            {{-- <select name="tipe" class="form-control border-teal border-1" >
                                @if ($proyek->jenis_proyek == null)
                                    <option value="">-- Pilih Kelas Layanan --</option>
                                @endif
                                @foreach (config('custom.kelas_layanan') as $key => $value)
                                    <option {{ $proyek->tipe == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select> --}}
                            <select id="tipe_web" name="tipe_web" class="form-control border-teal border-1" style="display:none">
                                <option value="">-- Pilih Kelas Layanan --</option>
                                <option {{ $proyek->tipe == 99 ? 'selected' : '' }} value="99">Simple</option>
                                <option {{ $proyek->tipe == 90 ? 'selected' : '' }} value="90">Prioritas</option>
                            </select>
                            <select id="tipe_app" name="tipe_app" class="form-control border-teal border-1" style="display:none">
                                <option {{ $proyek->tipe == 80 ? 'selected' : '' }} value="80">Premium</option>
                            </select>
                            <select id="tipe_ulo" name="tipe_ulo" class="form-control border-teal border-1" style="display:none">
                                <option value="">-- Pilih Kelas Layanan --</option>
                                <option {{ $proyek->tipe == 70 ? 'selected' : '' }} value="70">Free</option>
                                <option {{ $proyek->tipe == 74 ? 'selected' : '' }} value="74">Pro</option>
                                <option {{ $proyek->tipe == 78 ? 'selected' : '' }} value="78">Custom</option>
                            </select>
                        </div>
                    </div>

                    <div id="div-jl" class="form-group row" style="display:none">
                        <label class="col-form-label col-lg-2">Jenis Layanan</label>
                        <div class="col-lg-10">
                            {{-- <select name="jenis_layanan" class="form-control select-search border-teal border-1" >
                                @if ($proyek->jenis_proyek == null)
                                    <option value="">-- Pilih Jenis Layanan --</option>
                                @endif
                                @foreach (config('custom.jenis_layanan') as $key => $value)
                                    <option {{ $proyek->jenis_layanan == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select> --}}
                            <select id="jl_web" name="jl_web" class="form-control border-teal border-1" style="display:none">
                                <option value="">-- Pilih Jenis Layanan --</option>
                                <option {{ $proyek->jenis_layanan == 1 ? 'selected' : '' }} value="1">Nore</option>
                                <option {{ $proyek->jenis_layanan == 2 ? 'selected' : '' }} value="2">Mini</option>
                                <option {{ $proyek->jenis_layanan == 4 ? 'selected' : '' }} value="4">Beli/Lepas</option>
                            </select>
                            <select id="jl_app" name="jl_app" class="form-control border-teal border-1" style="display:none">
                                <option value="">-- Pilih Jenis Layanan --</option>
                                <option {{ $proyek->jenis_layanan == 3 ? 'selected' : '' }} value="3">Berlangganan</option>
                                <option {{ $proyek->jenis_layanan == 4 ? 'selected' : '' }} value="4">Beli/Lepas</option>
                            </select>
                            <select id="jl_ulo" name="jl_ulo" class="form-control border-teal border-1" style="display:none">
                                {{-- <option value="">-- Pilih Jenis Layanan --</option> --}}
                                <option {{ $proyek->jenis_layanan == 3 ? 'selected' : '' }} value="3">Berlangganan</option>
                                {{-- <option {{ $proyek->jenis_layanan == 4 ? 'selected' : '' }} value="4">Beli/Lepas</option> --}}
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Jumlah Task</label>
                        <div class="col-lg-10">
                            <input name="task_count" type="number" class="form-control border-teal border-1" value="{{$proyek->task_count}}" placeholder="Tentukan Jumlah Task">
                        </div>
                    </div>

                    <div id="div-masa" class="form-group row">
                        <label class="col-form-label col-lg-2">Masa Berlaku</label>
                        <div class="col-lg-10">
                            <input id="masa_berlaku" name="masa_berlaku" type="text" class="form-control pickadate-accessibility" value="{{$proyek->masa_berlaku}}">
                        </div>
                    </div>

                    {{-- <div id="new-masa" class="form-group row" style="display:none">
                        <label class="col-form-label col-lg-2">Update Masa Berlaku</label>
                        <div class="col-lg-10">
                            <input id="new_mb" name="new_mb" type="text" class="form-control border-teal border-1 pickadate-accessibility">
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Keterangan</label>
                        <div class="col-lg-10">
                            <span class="form-text text-muted">Contoh: Website blogspot Noer Prajitno</span>
                            <textarea class="summernote form-control border-teal" name="keterangan" id="keterangan" cols="30" rows="10">{{$proyek->keterangan}}</textarea>
                        </div>
                    </div>
                    @if ($proyek->marketing_id)
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Marketing</label>
                        <div class="col-lg-10">
                            <input id="marketing" name="marketing" type="text" class="form-control" readonly value="{{$proyek->marketing->nama}}">
                            <input id="marketing_id" name="marketing_id" type="hidden" class="form-control" value="{{$proyek->marketing_id}}">
                        </div>
                    </div>
                    <div class="form-group row">
						<label class="col-form-label col-lg-2"></label>
						<div class="col-lg-10">
							{{-- <input type="text" id="name" name="name" class="form-control border border-1" placeholder="Nama" data-user_id="0" required > --}}
							<select id="marketing_id_baru" name="marketing_id_baru" class="form-control select-search" data-user_id="0">
								<option value="">-- Ganti Marketing --</option>
								@foreach($marketings as $marketing)
									<option value="{{$marketing->id}}">{{$marketing->nama}} </option>
				    			@endforeach
							</select>
						</div>
					</div>
                    @else
                    <div class="form-group row">
						<label class="col-form-label col-lg-2">Marketing</label>
						<div class="col-lg-10">
							{{-- <input type="text" id="name" name="name" class="form-control border border-1" placeholder="Nama" data-user_id="0" required > --}}
							<select id="marketing_id" name="marketing_id" class="form-control select-search" data-user_id="0" required>
								<option value="">-- Pilih Marketing --</option>
								@foreach($marketings as $marketing)
									<option value="{{$marketing->id}}">{{$marketing->nama}} </option>
				    			@endforeach
							</select>
						</div>
					</div>
                    @endif
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

            $('#jenis_proyek').ready(function() {
                var dropdown = $('#jenis_proyek option:selected').val()
                // console.log(dropdown)
                if (dropdown==null || dropdown==0 || dropdown==5 || dropdown==2) {
                    //$('#div-tipe, #div-jl').hide()
                    $('#tipe_web, #tipe_app, #tipe_ulo, #jl_web, #jl_app, #jl_ulo').val("").attr("required", false)
                    if (dropdown==5) {
                        $('#new-masa').show()
                        $('#masa_berlaku').attr("placeholder", "Belum ada masa berlaku")
                        $('#new_mb').attr("placeholder", "Update masa berlaku")
                    } else {
                        //$('#new-masa').hide()
                        $('#masa_berlaku').val("").attr("placeholder", "Tidak ada masa berlaku")
                    }
                } else {
                    $('#div-tipe, #div-jl, #new-masa').show()
                    //$('#div-masa').hide()
                    //$('#masa_berlaku').attr("required", false).val("")
                    if (dropdown==1) {
                        $('#tipe_web, #jl_web').show().attr("required", true)
                        $('#tipe_app, #jl_app').hide().val("").attr("required", false)
                        $('#tipe_ulo, #jl_ulo').hide().val("").attr("required", false)
                        $('#website').attr("required", true)
                    } else if (dropdown==6) {
                        $('#tipe_web, #jl_web').hide().val("").attr("required", false)
                        $('#tipe_app, #jl_app').hide().val("").attr("required", false)
                        $('#tipe_ulo, #jl_ulo').show().attr("required", true)
                        $('#website').attr("required", false)
                    } else {
                        $('#tipe_web, #jl_web').hide().val("").attr("required", false)
                        $('#tipe_app, #jl_app').show().attr("required", true)
                        $('#tipe_ulo, #jl_ulo').hide().val("").attr("required", false)
                        $('#tipe_app').val(80)
                        $('#website').attr("required", false)
                    }
                }
            }).on('change', function() {
                var dropdown = $('#jenis_proyek option:selected').val()
                console.log(dropdown)
                if (dropdown==null || dropdown==0 || dropdown==5 || dropdown==2) {
                    $('#div-tipe, #div-jl').hide()
                    $('#tipe_web, #tipe_app, #tipe_ulo, #jl_web, #jl_app, #jl_ulo').val("").attr("required", false)
                    $('#masa_berlaku, #new_mb').attr("required", false)
                    if (dropdown==5) {
                        $('#new-masa').show()
                        $('#masa_berlaku').attr("placeholder", "Belum ada masa berlaku")
                        $('#new_mb').attr("placeholder", "Update masa berlaku")
                    } else {
                        $('#new-masa').hide()
                        $('#masa_berlaku, #new_mb').val("").attr("placeholder", "Tidak ada masa berlaku")
                    }
                } else {
                    $('#div-tipe, #div-jl, #new-masa').show()
                    $('#masa_berlaku').attr({"required": false,"placeholder": "Belum ada masa berlaku"})
                    $('#new_mb').attr({"required": false,"placeholder": "Tentukan masa berlaku"})
                    if (dropdown==1) {
                        $('#tipe_web, #jl_web').show().attr("required", true)
                        $('#tipe_app, #jl_app').hide().val("").attr("required", false)
                        $('#tipe_ulo, #jl_ulo').hide().val("").attr("required", false)
                        $('#website').attr("required", true)
                    } else if (dropdown==6) {
                        $('#tipe_web, #jl_web').hide().val("").attr("required", false)
                        $('#tipe_app, #jl_app').hide().val("").attr("required", false)
                        $('#tipe_ulo, #jl_ulo').show().attr("required", true)
                        $('#jl_ulo').val(3)
                        $('#website').attr("required", false)
                    } else {
                        $('#tipe_web, #jl_web').hide().val("").attr("required", false)
                        $('#tipe_app, #jl_app').show().attr("required", true)
                        $('#tipe_ulo, #jl_ulo').hide().val("").attr("required", false)
                        $('#tipe_app').val(80)
                        $('#website').attr("required", false)
                    }
                }
            });

            $('#jl_app, #jl_web').ready(function(){
                var dropdown_app = $('#jl_app option:selected').val()
                var dropdown_web = $('#jl_web option:selected').val()
                console.log([dropdown_app, dropdown_web])
                if (dropdown_app==4 || dropdown_web==4) {
                    $('#new-masa').hide()
                    $('#masa_berlaku, #new_mb').val("").attr("placeholder", "Tidak ada masa berlaku")
                } else if (dropdown_app==3 || dropdown_web==3 || dropdown_app==2 || dropdown_web==2 || dropdown_app==1 || dropdown_web==1 ) {
                    if ($('#masa_berlaku').val()==""){
                        $('#masa_berlaku').attr({"required": false,"placeholder": "Belum ada masa berlaku"})
                        $('#new_mb').attr({"required": false,"placeholder": "Tentukan masa berlaku"})
                    } else {
                        $('#masa_berlaku').attr("required", false)
                        $('#new_mb').attr({"required": false,"placeholder": "Update masa berlaku"})
                    }
                }
            }).on('change', function() {
                var dropdown_app = $('#jl_app option:selected').val()
                var dropdown_web = $('#jl_web option:selected').val()
                console.log([dropdown_app, dropdown_web])
                if (dropdown_app==4 || dropdown_web==4) {
                    $('#new-masa').hide()
                    $('#masa_berlaku, #new_mb').val("").attr({"required": false,"placeholder": "Tidak ada masa berlaku"})
                } else {
                    $('#new-masa').show()
                    if ($('#masa_berlaku').val()==""){
                        $('#masa_berlaku').attr({"required": false,"placeholder": "Belum ada masa berlaku"})
                        $('#new_mb').attr({"required": false,"placeholder": "Tentukan masa berlaku"})
                    } else {
                        $('#masa_berlaku').attr("required", false)
                        $('#new_mb').attr({"required": false,"placeholder": "Update masa berlaku"})
                    }
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

                // Different components require attrer error label placement
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
                    jl_ulo: {
                        required: 'Mohon pilih satu jenis layanan!'
                    },
                    tipe_web: {
                        required: 'Mohon pilih satu kelas layanan!'
                    },
                    tipe_app: {
                        required: 'Mohon pilih satu kelas layanan!'
                    },
                    tipe_ulo: {
                        required: 'Mohon pilih satu kelas layanan!'
                    },
                    task_count:{
                        required: 'Min : 0',
						min : 0
					},
                    new_mb: {
                        required: 'Mohon diisi.'
                    },
                    marketing_id: {
                        required: 'Mohon pilih salah satu.'
                    }
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
