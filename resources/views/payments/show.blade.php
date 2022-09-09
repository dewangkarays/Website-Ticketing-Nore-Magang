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
                <h4><span class="font-weight-semibold">Home</span> - Detail Pembayaran</h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('payments.changestatus') }}" method="post">
                    {{-- @method('PATCH') --}}
                    @csrf
                    <input type="hidden" name="id" value="{{$payment->id}}">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Pembayaran</legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Invoice</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$invoice->invoice}}</label>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Pelanggan</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$member->nama}}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nama Tertagih</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$payment->nama}}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Alamat</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$member->alamat}}</label>
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
                                        @foreach ($tagihans as $tagihan)
                                            <tr>
                                                <td>{{ $tagihan->proyek->nama_proyek }}</td>
                                                <td>{{ date('d-m-Y', strtotime(@$tagihan->proyek->masa_berlaku)) }}</td>
                                                <td>Rp @angka($tagihan->jml_tagih)</td>
                                                <td>{!! $tagihan->keterangan !!}</td>
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
                            <label class="col-form-label col-lg-2">Jumlah Bayar</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">Rp @angka($payment->nominal)</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tanggal Bayar</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{date('d F Y', strtotime($payment->tanggal))}}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Bukti Pembayaran</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">
                                    <img src="" alt="Bukti Pembayaran">
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Keterangan</label>
                            <div class="col-lg-10">
                                <textarea name="keterangan" id="" cols="30" rows="10" class="summernote form-control border-teal border-1">{!! $payment->keterangan !!}</textarea>
                            </div>
                        </div>

                        @if ($payment->status == 0)
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Status</label>
                                <div class="col-lg-10">
                                    <select name="status" id="" class="form-control form-control-select2">
                                        <option value="1">Terima</option>
                                        <option value="2">Tolak</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                    </fieldset>
                    <div class="text-right">
                            <a href="{{ route('payments.index') }}" class="btn bg-slate">Kembali <i class="icon-undo2 ml-2"></i></a>
                            <button type="submit" class="btn btn-success">Submit <i class="icon-paperplane ml-2"></i></button>
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
