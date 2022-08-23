@extends('layout')

@section('css')
<style type="text/css">
	.datatable-column-width{
		overflow: hidden; text-overflow: ellipsis; max-width: 200px;
	}
</style>
@endsection

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">Home</span> - Create Rekap Uang Muka</h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form method="GET">
                    @csrf
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Klien :</label>
                        <div class="col-lg-10">
                            <select id="user_id" name="user_id" class="form-control select-search">
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($users as $user)
                                <option data-pnama="{{$user->nama}}" data-pproyek="{{$user->website}}" value="{{$user->id}}" {{$user->id == $requestUser ? 'selected' : ''}}>{{$user->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                <div class="text-right">
                    <a id="btn_reset" href="{{ route('rekapdptagihans.create') }}" class="btn bg-slate text-uppercase">Reset  <i class="icon-rotate-ccw2 ml-2"></i></a>
                    <a id="btn_submit" href="{{ route('rekapdptagihans.create').'?c='.app('request')->input('c')}}" data-uri="{{ route('rekapdptagihans.create') }}" class="btn btn-success text-uppercase">Submit  <i class="icon-paperplane ml-2"></i></a>
                </div>
            </div>
        </div>
        <div class="card" id="card-rekap">
            <div class="card-body">
                <form id="form_rekap" class="form-validate-jquery" method="POST" action="{{ route('rekapdptagihans.store') }}">
                    @csrf
                    <table class="table datatable-basic table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th><input type="checkbox" class="checked-all"></th>
                                <th>Nama</th>
                                <th>Nama Proyek</th>
                                <th>Tagihan (Uang Muka)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!$tagihans->isEmpty())
                            @php ($i = 1)
                            @foreach($tagihans as $tagihan)
                            <tr>
                                <td>{{$i}}</td>
                                <td><input type="checkbox" name="tagihan_id[]" id="chk" value="{{ @$tagihan->id }}" required></td>
                                <td><div class="datatable-column-width">{{@$tagihan->user->nama}}</div></td>
                                <td><div class="datatable-column-width">{{@$tagihan->proyek->nama_proyek}}</div></td>
                                <td><div class="datatable-column-width">Rp @angka(@$tagihan->uang_muka)</div></td>
                                <td><div class="datatable-column-width">{!! @$tagihan->keterangan !!}</div></td>
                            </tr>
                            @php ($i++)
                            @endforeach
                        @else
                              <tr><td align="center" colspan="9">Data Kosong</td></tr>
                        @endif

                        </tbody>
                    </table>

                    <hr>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <input type="hidden" name="user_id" value="{{ @$tagihans[0]->user_id }}">
                        </div>
                    </div>
                    @if (!$tagihans->isEmpty())
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Rekap Uang Muka</legend>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 font-weight-bold">Nomor Invoice
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-1">
                                <input type="text" id="noinv" name="noinv" class="form-control border-info border-1" value="INV" readonly>
                            </div>
                            <div class="col-lg-2">
                                @if ($lastno)
                                @if (isset($lastno->ninv))
                                <input type="text" id="ninv" name="ninv" class="form-control border-info border-1" value="{{$lastno->ninv+1}}" required>
                                @endif
                                @else
                                <input type="text" id="ninv" name="ninv" class="form-control border-info border-1" value="1" required>
                                @endif
                            </div>
                            <div class="col-lg-2">
                                <input type="text" id="noakhir" name="noakhir" class="form-control border-info border-1" value="{{date('Ymd')}}" readonly>
                            </div>
                            {{-- <div class="col-lg-2">
                                <input type="text" id="nouser" name="nouser" class="form-control border-info border-1" value="{{\Auth::user()->id}}" readonly>
                            </div> --}}
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nama Tertagih
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-10">
                                <input id="nama_tertagih" type="text" name="nama_tertagih" class="form-control border-teal border-1" placeholder="Contoh: Noer Prajitno" value="{{@$tagihans[0]->user->nama}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Alamat
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-10">
                                <input id="alamat" type="text" name="alamat" class="form-control border-teal border-1" placeholder="Contoh: Jl. Inspeksi Gajahmada Semarang 50133" value="{{@$tagihans[0]->user->alamat}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Jatuh Tempo
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-10">
                                <input id="jatuh_tempo" name="jatuh_tempo" type="text" class="form-control pickadate-accessibility" value="{{  date('Y-m-d') }}" placeholder="Contoh: 2022-04-08" required>
                                {{-- <input type="text" id="kadaluarsa" name="kadaluarsa" class="form-control border-teal border-1"> --}}
                            </div>
                            {{-- <span id="kadaluarsa" name="kadaluarsa" class="col-form-label col-lg-10 font-weight-bold">{{@$}}</span> --}}
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Keterangan</label>
                            <div class="col-lg-10">
                                {{-- <input id="keterangan" type="text" name="keterangan" class="form-control border-teal border-1" placeholder="Contoh: " value="{{old('keterangan')}}"> --}}
                                <span class="form-text text-muted">Contoh: Rekap uang muka untuk pembayaran klien Noer Prajitno</span>
                                <textarea name="keterangan" id="" cols="30" rows="10" class="summernote form-control border-teal border-1">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>

                        <div class="text-right">
                            <a href="{{ route('rekaptagihans.index') }}" class="btn bg-slate">Kembali <i class="icon-undo2 ml-2"></i></a>
                            <button type="submit" class="btn btn-success">Submit <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    @else

                    @endif
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

        // Trigger value change when selection is made
        $('#user_id').ready(function() {
            $(this).trigger('blur');
            var dropdown=$('#user_id option:selected').val()
            console.log(dropdown)
            if (dropdown!=0) {
                $('#card-rekap').show()
            } else {
                $('#card-rekap').hide()
            }
        });

        //modal delete
        $(document).on("click", ".delbutton", function () {
            var url = $(this).data('uri');
            $("#delform").attr("action", url);
        });

        //datatable
        var DatatableBasic = function() {

            // Basic Datatable examples
            var _componentDatatableBasic = function() {
                if (!$().DataTable) {
                    console.warn('Warning - datatables.min.js is not loaded.');
                    return;
                }

                // Setting datatable defaults
                $.extend( $.fn.dataTable.defaults, {
                    autoWidth: false,
                    columnDefs: [{
                        orderable: false,
                        // width: 100,
                        targets: [ 1,2,3,4,5 ],
                    }],
                    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                    language: {
                        search: '<span>Filter:</span> _INPUT_',
                        searchPlaceholder: 'Type to filter...',
                        lengthMenu: '<span>Show:</span> _MENU_',
                        paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                    }
                });

                // Basic datatable
                $('.datatable-basic').DataTable();

                // Alternative pagination
                $('.datatable-pagination').DataTable({
                    pagingType: "simple",
                    language: {
                        paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
                    }
                });

                // Datatable with saving state
                $('.datatable-save-state').DataTable({
                    stateSave: true
                });

                // Scrollable datatable
                var table = $('.datatable-scroll-y').DataTable({
                    autoWidth: true,
                    scrollY: 300
                });

                // Resize scrollable table when sidebar width changes
                $('.sidebar-control').on('click', function() {
                    table.columns.adjust().draw();
                });
            };

            // Select2 for length menu styling
            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }

                // Initialize
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: Infinity,
                    dropdownAutoWidth: true,
                    width: 'auto'
                });
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentDatatableBasic();
                    _componentSelect2();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            DatatableBasic.init();
        });

        $('.checked-all').on('click', function(e){
            //e.preventDefault()
            $('input[id=chk]').prop('checked', this.checked)
        });
    </script>

    <script type="text/javascript">
        $('#user_id').change(function(){
            let uri = $('#btn_submit').data('uri');
            let val = $(this).val();
            let href = `${uri}?c=${val}`;

            $('#btn_submit').attr('href', href);

            // if($('#btn_submit').click(function (){
            //     $('#form-datatable').show();
            // }));
            // if($('#btn_reset').click(function (){
            //     $('#form-datatable').hide();
            // }));
        });

        let getToken = function() {
            return $('meta[name=csrf-token]').attr('content')
        }
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
    </script>

    <script type="text/javascript">
        //form validation
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
                        jatuh_tempo:{
                            required : true
                        },
                        nama_tertagih:{
                            required : true
                        },
                        alamat:{
                            required : true
                        },
                    },
                    messages: {
                        jatuh_tempo:{
                            required : 'Mohon diisi'
                        },
                        nama_tertagih:{
                            required : 'Mohon diisi'
                        },
                        alamat:{
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
        //error notification
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
