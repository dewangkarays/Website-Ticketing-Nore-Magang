@extends('layout')

@section('css')
<style type="text/css">
    .datatable-column-width{
        overflow: hidden; text-overflow: ellipsis; max-width: 100px;
    }
</style>
@endsection

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Home</span> - Data Proyek</h4>
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
            <a href="{{ route('proyeks.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
        </div>

        <table class="table datatable-basic table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Klien</th>
                    <th>Nama Proyek</th>
                    <th>Website</th>
                    <th>Detail Proyek</th>
                    {{-- <th>Kelas Layanan</th>
                    <th>Jenis Layanan</th> --}}
                    <th>Jumlah Task</th>
                    <th>Masa Berlaku</th>
                    <th>Keterangan</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
<!-- /hover rows -->

</div>
<!-- /content area -->

<!-- Danger modal -->
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
<!-- /default modal -->

@endsection

@section('js')
<!-- Theme JS files -->
<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/components_modals.js')}}"></script>
{{-- <script src="{{asset('assets/js/custom.js')}}"></script> --}}
<script>
    //modal delete
    $(document).on("click", ".delbutton", function () {
        var url = $(this).data('uri');
        $("#delform").attr("action", url);
    });

    function stripHtml(html)
    {
        let tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || "";
    }

    var DatatableBasic = function() {
        const jenisProyek = {
            '1': 'Website',
            '2': 'Iklan/Ads',
            '3': 'Sistem Informasi',
            '4': 'Mobile App',
            '5': 'Custom/Lainnya',
        }

        const jenisLayanan = {
            '1': 'Nore',
            '2': 'Mini',
            '3': 'Berlangganan',
            '4': 'Beli/Lepas',
        }

        const kelasLayanan = {
            '99': 'Simple',
            '90': 'Prioritas',
            '80': 'Premium',
        }

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
                    width: 100,
                    targets: "_all"
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
            $('.datatable-basic').DataTable({
                "order": true,
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: {
                    "type": "GET",
                    "url": "/getproyeks",
                },
                columns: [
                    {
                        data: null,
                        name: null,
                        render: (data, type, row) => {
                            return row.DT_RowIndex
                        }
                    },
                    {
                        data: null,
                        name: null,
                        render: (data, type, row) => {
                            return data?.user ? data?.user?.nama : '-'
                        }
                    },
                    {
                        data: "nama_proyek",
                        name: "nama_proyek",
                    },
                    {
                        data: "website",
                        name: "website",
                    },
                    {
                        data: null,
                        name: null,
                        render: (data, type, row) => {
                            let detailProyek = 
                                `<div>
                                    ${data?.jenis_proyek ? jenisProyek[data?.jenis_proyek] : '-'} <br>
                                    ${data?.tipe ? kelasLayanan[data?.tipe] : '-'} <br>
                                    ${data?.jenis_layanan ? jenisLayanan[data?.jenis_layanan] : '-'} <br>
                                </div>`

                            return detailProyek
                        }
                    },
                    {
                        data: null,
                        name: null,
                        render: (data, type, row) => {
                            let taskCount = ''
                            if (data?.task_count < 1) {
                                taskCount = `<span style="font-size:100%;" class="badge badge-pill bg-danger-400 ml-auto ml-md-0">0</span>`
                            } else {
                                taskCount = `<span style="font-size:100%;" class="badge badge-pill bg-success-400 ml-auto ml-md-0">${data?.task_count}</span>`
                            }

                            return taskCount
                        }
                    },
                    {
                        data: null,
                        name: null,
                        render: (data, type, row) => {
                            let masaBerlaku = ''
                            if (data?.masa_berlaku == null) {
                                masaBerlaku = `<div class="datatable-column-width text-center">-</div>`
                            } else {
                                if (data?.masa_berlaku > data?.dateline) {
                                    masaBerlaku = `<span style="font-size:100%;" class="badge badge-pill bg-success-400 ml-auto ml-md-0">${data?.masa_berlaku}</span>`
                                } else if (data?.masa_berlaku < data?.expired) {
                                    masaBerlaku = `<span style="font-size:100%;" class="badge badge-pill bg-danger-400 ml-auto ml-md-0">${data?.masa_berlaku}</span>`
                                } else {
                                    masaBerlaku = `<span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">${data?.masa_berlaku}</span>`
                                }
                            }

                            console.log(masaBerlaku)

                            return masaBerlaku
                        }
                    },
                    {
                        data: null,
                        name: "keterangan",
                        render: (data, type, row) => {
                            return data?.keterangan ? stripHtml(data?.keterangan) : '-'
                        }
                    },
                    {
                        data: null,
                        name: null,
                        render: (data, type, row) => {
                            let createRef = `/tagihans/create?c=${data?.id}`
                            // createRef = createRef.replace(':id', data?.id)
                            let editRef = "{{route('proyeks.edit', ':id')}}"
                            editRef = editRef.replace(':id', data?.id)
                            let delUri = "{{route('proyeks.destroy', ':id')}}"
                            delUri = delUri.replace(':id', data?.id)

                            let actionsButton = 
                                `<div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">`
                            if ((data?.masa_berlaku < data?.dateline) && (data?.masa_berlaku > data?.expired)) {
                                actionsButton += `<a href="${createRef}" class="dropdown-item"><i class="icon-file-text"></i> Create Tagihan</a>`
                            }
                                actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>`
                            @if (Auth::user()->role==1)
                                actionsButton += `<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"><i class="icon-x"></i> Delete</a>`
                            @endif
                                actionsButton += `</div>
                                    </div>`

                            return actionsButton
                        }
                    }
                ]
            });

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
