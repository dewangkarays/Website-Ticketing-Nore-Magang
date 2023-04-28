@extends('layout')

@section('css')
    <style type="text/css">
        .datatable-column-width {
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
    </style>
@endsection

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">Home</span> - Rekap Uang Muka</h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <!-- Hover rows -->
        <div id="card-rekap" class="card">
            <div class="card-header header-elements-inline">
                <a href="{{ route('rekapdptagihans.create') }}"><button type="button"
                        class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
            </div>

            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table datatable-basic table-hover">
                        <form method="GET" action="{{ url('cetakrekap') }}">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No</th>
                                {{-- <th><input type="checkbox" class="checked-all"></th> --}}
                                <th>Nama</th>
                                <th>Nama Proyek</th>
                                <th>Invoice</th>
                                <th>Uang Muka Tagihan (Rp)</th>
                                <th>Jumlah Terbayar (Rp)</th>
                                <th>Sisa Uang Muka Tagihan (Rp)</th>
                                {{-- <th>Keterangan</th> --}}
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        </div>
        <!-- /hover rows -->
    </div>
    <!-- /content area -->

    <!-- Danger Modal -->
    <div id="modal_theme_danger" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger" align="center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" method="post" id="delform">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body" align="center">
                        <h2> Hapus Data? </h2>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /danger modal -->
@endsection

@section('js')
    <script src="{{ asset('global_assets/js/plugins/notifications/pnotify.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/notifications/bootbox.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/buttons/spin.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/buttons/ladda.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/components_modals.js') }}"></script>

    <script type="text/javascript">
        //modal delete
        $(document).on("click", ".delbutton", function() {
            var url = $(this).data('uri');
            $("#delform").attr("action", url);
        });
        var DatatableBasic = function() {

            const rekapStatus = {
                '1': 'Baru',
                '2': 'Sudah Ditagih',
                '3': 'Terbayar Sebagian',
                '4': 'Lunas',
                '5': 'Invalid',
            }

            // Basic Datatable examples
            var _componentDatatableBasic = function() {
                if (!$().DataTable) {
                    console.warn('Warning - datatables.min.js is not loaded.');
                    return;
                }

                // Setting datatable defaults
                $.extend($.fn.dataTable.defaults, {
                    autoWidth: false,
                    columnDefs: [{
                            orderable: false,
                            // width: 100,
                            targets: [9],
                        },
                        {
                            visible: false,
                            searchable: true,
                            targets: [0],
                        }
                    ],
                    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                    language: {
                        search: '<span>Filter:</span> _INPUT_',
                        searchPlaceholder: 'Type to filter...',
                        lengthMenu: '<span>Show:</span> _MENU_',
                        paginate: {
                            'first': 'First',
                            'last': 'Last',
                            'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                            'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                        }
                    }
                });

                // Basic datatable
                $('.datatable-basic').DataTable({
                    // "scrollX": true,
                    order: [
                        [0, "desc"]
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: {
                        'type': 'GET',
                        'url': "/getrekapdp/aktif",
                    },
                    columns: [
                        {
                            data: "id",
                            name: "id",
                        },
                        {
                            data: null,
                            name: null,
                            render: (data, type, row) => {
                                return row.DT_RowIndex
                            }
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                        },
                        {
                            data: null,
                            name: null,
                            render: (data, type, name) => {
                                return stripHtml(data?.nama_proyek)
                            }
                        },
                        {
                            data: 'invoice',
                            name: 'invoice',
                        },
                        {
                            data: null,
                            name: null,
                            render: (data, type, row) => {
                                return number_format(data?.total, 0, '.', '.')
                            }
                        },
                        {
                            data: null,
                            name: null,
                            render: (data, type, row) => {
                                return number_format(data?.jml_terbayar, 0, '.', '.')
                            }
                        },
                        {
                            data: null,
                            name: null,
                            render: (data, type, row) => {
                                return number_format(data?.total - data?.jml_terbayar, 0, '.', '.')
                            }
                        },
                        {
                            data: null,
                            name: null,
                            render: (data, type, row) => {
                                let status = ''
                                if (data?.status == 1)
                                    status =
                                    `<span style="font-size: 100%;" class="badge badge-pill badge-info">${rekapStatus[data?.status]}</span>`
                                else if (data?.status == 2)
                                    status =
                                    `<span style="font-size: 100%;" class="badge badge-pill badge-danger">${rekapStatus[data?.status]}</span>`
                                else if (data?.status == 3)
                                    status =
                                    `<span style="font-size: 100%;" class="badge badge-pill badge-warning">${rekapStatus[data?.status]}</span>`
                                else
                                    status =
                                    `<span style="font-size: 100%;" class="badge badge-pill badge-success">${rekapStatus[data?.status]}</span>`

                                return status
                            }
                        },
                        {
                            data: null,
                            name: null,
                            render: (data, type, row) => {
                                let showRef = "{{ route('rekapdptagihans.show', ':id') }}"
                                showRef = showRef.replace(':id', data?.id)

                                let lampiranRef = "{{ route('lampiran_rdp', ':id') }}"
                                lampiranRef = lampiranRef.replace(':id', data?.id)

                                let cetakRef = "{{ route('cetakrekapdp', ':id') }}"
                                cetakRef = cetakRef.replace(':id', data?.id)

                                let delUri = "{{ route('rekapdptagihans.destroy', ':id') }}"
                                delUri = delUri.replace(':id', data?.id)

                                let invalidUri = "{{ route('rekapdpinvalid', ':id') }}"
                                invalidUri = invalidUri.replace(':id', data?.id)

                                let actionButtons =
                                    `
                                        <dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="${showRef}" class="dropdown-item"><i class="icon-search4"></i> Show</a>
                                                <a href="${lampiranRef}" class="dropdown-item"><i class="icon-images3"></i> Lampiran</a>
                                                <a href="${cetakRef}" class="dropdown-item" target="_blank"><i class="icon-printer2"></i> Print</a>`
                                if (data?.status == 1)
                                    actionButtons +=
                                    `<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"><i class="icon-x"></i> Delete</a>`
                                else if (data?.status < 5)
                                    actionButtons +=
                                    `<a href="${invalidUri}" class="dropdown-item"><i class="icon-x"></i> Invalid</a>`
                                actionButtons += `</div>
                                        </div>
                                    `

                                return actionButtons
                            }
                        }
                    ]
                });

                // Alternative pagination
                $('.datatable-pagination').DataTable({
                    pagingType: "simple",
                    language: {
                        paginate: {
                            'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;',
                            'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'
                        }
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
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Default style
            @if (session('error'))
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
        });
    </script>
@endsection
