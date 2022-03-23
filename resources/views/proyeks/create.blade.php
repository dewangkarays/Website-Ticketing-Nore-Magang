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
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong>
                Silakan pilih klien dahulu, ya!
            </div>
        @endif
        <div class="card-header header-elements-inline">
        </div>
        <div class="card-body">
            <form class="form-validate-jquery" action="{{ route('proyeks.store')}}" method="post">
                @csrf
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Proyek</legend>

                    {{-- <div class="form-group row">
                        <label class="col-form-label col-lg-2">User / Klien</label>
                        <div class="col-lg-10">
                            <select class="form-control border-teal" name="user_id" id="user_id">
                                @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Klien</label>
                        <div class="col-lg-10">
                            <select name="user_id" class="form-control select-search" data-vouc>
                                <option value="">-- Pilih Klien --</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Website</label>
                        <div class="col-lg-10">
                            <input type="text" name="website" class="form-control border-teal border-1" placeholder="Website" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Jenis Proyek</label>
                        <div class="col-lg-10">
                            <select name="jenis_proyek" class="form-control bg-teal-400 border-teal-400" required>
                                <option value="">-- Pilih Jenis Proyek --</option>
                                @foreach (config('custom.jenis_proyek') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Jenis Layanan</label>
                        <div class="col-lg-10">
                            <select name="jenis_layanan" class="form-control bg-teal-400 border-teal-400" required>
                                <option value="">-- Pilih Jenis Layanan --</option>
                                @foreach (config('custom.jenis_layanan') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Kelas Layanan</label>
                        <div class="col-lg-10">
                            <select name="tipe" class="form-control bg-teal-400 border-teal-400" required>
                                <option value="">-- Pilih Kelas Layanan --</option>
                                @foreach (config('custom.kelas_layanan') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Jumlah Task</label>
                        <div class="col-lg-10">
                            <input name="task_count" type="number" class="form-control border-teal border-1" placeholder="Tentukan Jumlah Task">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Masa Berlaku</label>
                        <div class="col-lg-10">
                            <input name="masa_berlaku" type="text" class="form-control border-teal pickadate-accessibility" placeholder="Tanggal Masa Berlaku" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Keterangan</label>
                        <div class="col-lg-10">
                            <textarea class="form-control border-teal" name="keterangan" id="keterangan" cols="30" rows="5"></textarea>
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

<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>
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
                        nama: {
                            required: 'Mohon diisi.'
                        },
                        email: {
                            required: 'Mohon diisi.'
                        },
                        telp: {
                            required: 'Mohon diisi.'
                        },
                        username: {
                            required: 'Mohon diisi.'
                        },
                        password: {
                            required: 'Mohon diisi.'
                        },
                        role: {
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
