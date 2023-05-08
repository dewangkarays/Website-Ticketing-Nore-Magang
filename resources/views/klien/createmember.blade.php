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
				<h4><span class="font-weight-semibold">Home</span> - member</h4>
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
		<form class="form-validate-jquery" action="{{ route('klien.savecreateMember', $klien->id)}}" method="post">
			{{-- @method('POST') --}}
			@csrf
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">Data Klien</legend>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">Nama Klien</label>
					<div class="col-lg-10">
						<input type="text" name="nama_calonklien" class="form-control border-teal border-1" placeholder="Nama" required value="{{ $klien->nama_calonklien }}">
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
				{{-- <div class="form-group row">
					<label class="col-form-label col-lg-2">Nama Perusahaan</label>
					<div class="col-lg-10">
						<input type="text" name="nama_perusahaan" class="form-control border-teal border-1" placeholder="Nama Perusahaan" required value="{{ $klien->nama_perusahaan}}">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-2">Jenis Perusahaan</label>
					<div class="col-lg-10">
						<input type="text" name="jenis_perusahaan" class="form-control border-teal border-1" required value="{{$klien->jenis_perusahaan}}">
					</div>
				</div> --}}
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Email</label>
                    <div class="col-lg-10">
                        <input type="text" name="email" class="form-control border-teal border-1" placeholder="Email" required>
                        @error('email')
                            <div style="margin-top:1rem;" class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
				{{-- <div class="form-group row">
					<label class="col-form-label col-lg-2">Potensi</label>
					<div class="col-lg-10">
						<select id="potensi" name="potensi" class="form-control select-search border-teal border-1" >
							@if ($klien->potensi == null)
								<option value="">-- Pilih Produk Nore --</option>
							@endif
							@foreach (config('custom.jenis_proyek') as $key => $value)
								<option {{ $klien->potensi == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
				</div> --}}
				<div class="form-group row">
					<label class="col-form-label col-lg-2">Telp</label>
					<div class="col-lg-10">
						<input type="text" name="telp" class="form-control border-teal border-1 phone-number" placeholder="Telp/WA" required value="{{ $klien->telp }}">
						<span class="form-text text-muted">Contoh : 628123456678 (gunakan kode negara tanpa tanda + dan spasi)</span>
					</div>
				</div>
				{{-- <div class="form-group row">
					<label class="col-form-label col-lg-2">Status</label>
					<div class="col-lg-10">
						<select id="status_klien" name="status" class="form-control select-search border-teal border-1" >
							@if ($klien->status == null)
								<option value="">-- Pilih Status--</option>
							@endif
							@foreach (config('custom.status_klien') as $key => $value)
								<option {{ $klien->status == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-2">Source</label>
					<div class="col-lg-10">
						<select id="source" name="source" class="form-control select-search border-teal border-1" >
							@if ($klien->source == null)
								<option value="">-- Source --</option>
							@endif
							@foreach (config('custom.source') as $key => $value)
								<option {{ $klien->source == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-2">Tanggal Kontak Pertama</label>
					<div class="col-lg-10">
						<input type="date" name="tanggal_kontakpertama" class="form-control border-teal pickadate-accessibility" value="{{ $klien->tanggal_kontakpertama}}">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-lg-2">Tanggal Kontak Terakhir</label>
					<div class="col-lg-10">
						<input type="date" name="tanggal_kontakterakhir" class="form-control border-teal pickadate-accessibility" value="{{ $klien->tanggal_kontakterakhir}}">
					</div>
				</div> --}}
				<div class="form-group row">
					<label class="col-form-label col-lg-2">Alamat</label>
					<div class="col-lg-10">
						<input type="text" name="alamat" class="form-control border-teal border-1" placeholder="Alamat" value="{{ $klien->alamat }} ">
					</div>
				</div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Username</label>
                    <div class="col-lg-10">
                        <input type="text" name="username" class="form-control border-teal border-1" placeholder="Username" required>
                        @error('username')
                        <div style="margin-top:1rem;" class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Password</label>
                    <div class="col-lg-10">
                        <input type="password" name="password" class="form-control border-teal border-1" placeholder="Password" required>
                    </div>
                </div>
				<div class="form-group row">
					<label class="col-form-label col-lg-2">Jenis Proyek</label>
					<div class="col-lg-10">
						<select id="jenis_proyek" name="jenis_proyek" class="form-control select-search border-teal border-1">
							@if ($klien->potensi == null)
								<option value="">-- Pilih Jenis Proyek --</option>
							@endif
							@foreach (config('custom.jenis_proyek') as $key => $value)
								<option {{ $klien->potensi == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
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
						<select id="tipe_ulo" name="tipe_ulo" class="form-control border-teal border-1" style="display:none">
							<option value="">-- Pilih Kelas Layanan --</option>
							<option value="70">Free</option>
							<option value="74">Pro</option>
							<option value="78">Custom</option>
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
						<select id="jl_ulo" name="jl_ulo" class="form-control border-teal border-1" style="display:none">
							{{-- <option value="">-- Pilih Jenis Layanan --</option> --}}
							<option value="3">Berlangganan</option>
							{{-- <option value="4">Beli/Lepas</option> --}}
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
				{{-- <div class="form-group row">
					<label class="col-form-label col-lg-2">Keterangan lain</label>
					<div class="col-lg-10">
						<span class="form-text text-muted">Contoh: Website blogspot Noer Prajitno</span>
						<textarea class="summernote form-control border-teal" name="keterangan_lain" id="keterangan_lain" cols="30" rows="10">{{$klien->keterangan_lain}}</textarea>
					</div>
				</div> --}}
				<div class="form-group row">
					<label class="col-form-label col-lg-2">Marketing</label>
					<div class="col-lg-10">
						<select id="marketing_id" name="marketing_id" class="form-control select-search" data-user_id="0" required>
							<option value="">-- Pilih Marketing --</option>
							@foreach($marketings as $marketing)
								<option @if($klien->marketing_id == $marketing->id)selected @endif value="{{$marketing->id}}">{{$marketing->nama}} </option>	
							@endforeach
						</select>
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
						$('#tipe_web, #tipe_app, #tipe_ulo, #jl_web, #jl_app, #jl_ulo').val("").attr("required", false)
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
							$('#tipe_ulo, #jl_ulo').hide().val("").attr('required', false)
							$('#website').attr("required", true)
						} else if (dropdown==6) {
							$('#tipe_web, #jl_web').hide().val("").attr("required", false)
							$('#tipe_app, #jl_app').hide().val("").attr("required", false)
							$('#tipe_ulo, #jl_ulo').show().attr('required', true)
							$('#jl_ulo').val(3)
							$('#website').attr("required", false)
						} else {
							$('#tipe_web, #jl_web').hide().val("").attr("required", false)
							$('#tipe_app, #jl_app').show().attr("required", true)
							$('#tipe_ulo, #jl_ulo').hide().val("").attr('required', false)
							$('#tipe_app').val(80)
							$('#website').attr("required", false)
						}
					}
				});

				$('#jl_app, #jl_web, #jl_ulo').on('change', function() {
					var dropdown_app = $('#jl_app option:selected').val()
					var dropdown_web = $('#jl_web option:selected').val()
					var dropdown_ulo = $('#jl_ulo option:selected').val()
					console.log([dropdown_app, dropdown_web])
					if (dropdown_app==4 || dropdown_web==4 || dropdown_ulo==4) {
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
		        var validator = $('.form-validate-jquery').validate({
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
						password: {
							minlength: 5
						}
					},
                    messages: {
                            nama_calon_klien: {
                                required: 'Mohon diisi.'
                            },
                            nama_perusahaan: {
                                required: 'Mohon diisi.'
                            },
                            jenis_perusahaan: {
                                required: 'Mohon diisi.'
                            },
                            telp: {
                                required: 'Mohon diisi.'
                            },
                            alamat: {
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
			setTimeout(()=>{
				var dropdown = $('#jenis_proyek option:selected').val()
					console.log(dropdown)
					if (dropdown=="" || dropdown==0 || dropdown==5 || dropdown==2) {
						$('#div-tipe, #div-jl').hide()
						// $('#tipe_web, #tipe_app, #jl_web, #jl_app, #website').val("").attr("required", false)
						$('#tipe_web, #tipe_app, #tipe_ulo, #jl_web, #jl_app, #jl_ulo').val("").attr("required", false)
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
							$('#tipe_ulo, #jl_ulo').hide().val("").attr('required', false)
							$('#website').attr("required", true)
						} else if (dropdown==6) {
							$('#tipe_web, #jl_web').hide().val("").attr("required", false)
							$('#tipe_app, #jl_app').hide().val("").attr("required", false)
							$('#tipe_ulo, #jl_ulo').show().attr('required', true)
							$('#jl_ulo').val(3)
							$('#website').attr("required", false)
						} else {
							$('#tipe_web, #jl_web').hide().val("").attr("required", false)
							$('#tipe_app, #jl_app').show().attr("required", true)
							$('#tipe_ulo, #jl_ulo').hide().val("").attr('required', false)
							$('#tipe_app').val(80)
							$('#website').attr("required", false)
						}
					}
					
			},1000);

			setTimeout(()=>{
				$('#jl_app, #jl_web, #jl_ulo').on('change', function() {
					var dropdown_app = $('#jl_app option:selected').val()
					var dropdown_web = $('#jl_web option:selected').val()
					var dropdown_ulo = $('#jl_ulo option:selected').val()
					console.log([dropdown_app, dropdown_web])
					if (dropdown_app==4 || dropdown_web==4 || dropdown_ulo==4) {
						$('#div-masa').hide()
						// $('#masa_berlaku').val("").attr("required", false)
					} else {
						$('#div-masa').show()
						// $('#masa_berlaku').attr("required", true)
					}
				});
			},1000);
			

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