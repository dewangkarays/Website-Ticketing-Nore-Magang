@extends('layout')

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Home</span> - Detail User</h4>
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
            
            
            @method('PATCH')
            @csrf
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Data User</legend>
                
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Nama</label>
                    <div class="col-lg-10">
                        <span class="form-text"> {{ $user->nama }} </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Email</label>
                    <div class="col-lg-10">
                        <span class="form-text"> {{ $user->email }} </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Telp</label>
                    <div class="col-lg-10">
                        <span class="form-text"> {{ $user->telp }} </span>
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-form-label col-lg-2">Masa Aktif</label>
                    <div class="col-lg-10">
                        <span class="form-text"> {{ $user->kadaluarsa }} </span>
                    </div>
                </div> --}}
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Jumlah Update Task</label>
                    <div class="col-lg-10">
                        <span class="form-text"> {{ @$user->task_count ? $user->task_count : '-' }} </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Username</label>
                    <div class="col-lg-10">
                        <span class="form-text"> {{ $user->username }} </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Role</label>
                    <div class="col-lg-10">
                            <span class="form-text">
                                {{ config('custom.role.'.$user->role) }}
                        </span>
                    </div>
                </div>
                @if ($user->role>70)
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Tagihan yang belum dibayar</label>
                    <div class="col-lg-10">
                            <span class="form-text">
                                Rp @angka($user->tagihan->sum('jml_tagih')-$user->tagihan->sum('jml_bayar'))
                            </span>
                    </div>
                </div>
                @endif
                </fieldset>
                <div class="text-right">
                    <a href="{{ route('users.index') }}">
                        <button type="submit" class="btn bg-slate"><i class="icon-undo2 mr-2"></i> Kembali</button>
                    </a>
                </div>
                
                
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
    <script type="text/javascript">
        
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
                            // password: {
                                //     required: 'Mohon diisi.'
                                // },
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