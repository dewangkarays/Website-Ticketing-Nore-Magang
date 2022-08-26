@extends('layout')

@section('css')
<style type="text/css">
    .main-table{
        width: 100%;
        table-layout: fixed;
    }
    .main-table td, .main-table th{
        border: 2px solid white;
        padding: 5px 10px;
    }
    .main-table tbody td{
        background-color: white;
    }
    .main-table th{
        overflow-wrap: break-word;
        word-wrap: break-word;
        hyphens: auto;
        /* background-color: #1C2555; */
        /* color: #39b873 */
    }
    .main-table th {
        border: 1px solid #f3f3f3;
        background-color: #f3f3f3;
    }
</style>
@endsection

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">Home</span> - Detail Rekap Tagihan</h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('rekaptagihans.update', $rekaptagihan->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Rekap Tagihan</legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Invoice</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$rekaptagihan->invoice}}</label>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Pelanggan</label>
                            <div class="col-lg-10">
                                @if ($rekaptagihan->nama == null)
                                    <select name="user_id" id="user_id" class="form-control select-search" required disabled>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($users as $user)
                                        <option data-pnama="{{$user->nama}}" data-pproyek="{{$user->website}}" {{ $tagihan->user_id == $user->id ? 'selected' : '' }} value="{{$user->id}}">{{$user->nama}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <label class="col-form-label col-lg-10">{{$rekaptagihan->nama}}</label>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nama Tertagih</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$rekaptagihan->nama_tertagih}}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Alamat</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$rekaptagihan->alamat}}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">&nbsp;</label>
                            <div class="col-lg-10">
                                <table class="main-table" style="line-height: 1">
                                    @if (!$tagihans->isEmpty())
                                    <tr>
                                        <th>Nama Proyek</th>
                                        <th>Masa Berlaku</th>
                                        <th>Tagihan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    <tbody>
                                        @foreach ($tagihans as $invoice)
                                            <tr>
                                                <td>{{ $invoice->proyek->nama_proyek }}</td>
                                                <td>{{ date('d-m-Y', strtotime(@$invoice->proyek->masa_berlaku)) }}</td>
                                                <td>Rp @angka($invoice->jml_tagih)</td>
                                                <td>{!! $invoice->keterangan !!}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <th align="center">&nbsp;</th>
                                    </tr>
                                        <tr>
                                            <td align="center">Data Kosong</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Total Tagihan</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">Rp @angka($rekaptagihan->total)</label>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Jumlah Terbayar</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">Rp @angka($rekaptagihan->jml_terbayar)</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Jatuh Tempo</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{date('d F Y', strtotime($rekaptagihan->jatuh_tempo))}}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Keterangan</label>
                            <div class="col-lg-10">
                                @if ($rekaptagihan->status == 4)
                                    <label class="col-form-label col-lg-10">{!! $rekaptagihan->keterangan !!}</label>
                                @else
                                    <textarea name="keterangan" id="" cols="30" rows="10" class="summernote form-control border-teal border-1">{!! $rekaptagihan->keterangan !!}</textarea>
                                @endif
                            </div>
                        </div>

                        @if (in_array($rekaptagihan->status, [1,2]))
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Status</label>
                                <div class="col-lg-10">
                                    <select name="status" id="" class="form-control form-control-select2">
                                        @foreach (config('custom.rekap_status') as $key => $value)
                                        @if (in_array($key,[1,2]))
                                            <option {{ $rekaptagihan->status == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </fieldset>
                    <div class="text-right">
                        @if ($rekaptagihan->status == 4)
                            <a href="{{ route('historytagihan') }}" class="btn bg-slate">Kembali <i class="icon-undo2 ml-2"></i></a>
                        @else
                            <a href="{{ route('rekaptagihans.index') }}" class="btn bg-slate">Kembali <i class="icon-undo2 ml-2"></i></a>
                            <button type="submit" class="btn btn-success">Submit <i class="icon-paperplane ml-2"></i></button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection

@section('js')
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
<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
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
</script>

<script type="text/javascript">
    var FormValidation = function() {

        // Validation config
        var _componentValidation = function() {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }

            // Initialize
            var validator = $('#form_rekap').validate({
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
                    status:{
                        required : true
                    },
                },
                messages: {
                    status:{
                        required : 'Mohon diisi'
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
                toolbar: false,
                height: 100
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
		@if (session('success'))
		new PNotify({
			title: 'Success',
			text: '{{ session('success') }}.',
			icon: 'icon-checkmark3',
			type: 'success'
		});
		@endif
		@if ($errors->any())
		new PNotify({
			title: 'Error',
			text: 'Nomor Invoice Sudah Terambil, input kembali.',
			icon: 'icon-blocked',
			type: 'error'
		});
		@elseif ($errors->has('ninv'))
		@foreach ($errors->all() as $error)
		new PNotify({
			title: 'Error',
			text: '{{ $error }}.',
			icon: 'icon-blocked',
			type: 'error'
		});
		@endforeach

		@endif
	});
</script>
@endsection
