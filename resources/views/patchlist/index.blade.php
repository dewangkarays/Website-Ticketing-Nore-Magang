@extends('layout')

@section('css')
<style type="text/css">
    .datatable-column-width{
        overflow: hidden; text-overflow: ellipsis; max-width: 100px;
    }
    .summernote ol, ul{
		list-style: disc !important;
		list-style-position: inside;
		padding-left: 15px;
	}
	ol {
		padding-left: 15px;
	}
</style>
@endsection

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Home</span> - Patchlist</h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<!-- Content area -->
<div class="content">
    <div class="card">
		<div class="card-body">
			<div class="row justify-content-between">
                <div class="col">
                    <select style="width: 200px; height: 36px" id="filter_klien" name="filterKlien" class="form-control select-search">
                        <option value="">-- Nama Klien --</option>
                        @foreach ($klienList as $klien_id => $klien_nama)
                        <option value="{{ $klien_id }}">{{ $klien_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select style="width: 200px; height: 36px" id="filter_proyek" name="filterProyek" class="form-control select-search">
                        <option value="">-- Nama Proyek --</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="filterData()">Filter</button>
                <button type="button" class="btn btn-secondary ml-2" onclick="resetFilter()">Reset Filter</button>
			</div>
		</div>
	</div>
    <!-- Hover rows -->
    <div class="card">
        <div class="card-body header-elements-inline">
            <a href="{{ route('patchlist.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-add mr-2"></i> Tambah</button></a>
            <button id="export-excel-button" class="btn btn-success rounded-round" data-export-url="{{ route('patchlist.exportExcel') }}">
                <i class="icon-file-excel mr-2"></i> Export Excel
            </button>
        </div>
        <div class="card-body">
            <div class="row">
				<div class="col text-center">
					<span class="font-weight-semibold" style="font-size: 15px">
						Total Status
					</span>
				</div>
			</div>
			<br>
			<div class="row justify-content-center">
				<div class="col-md-2 text-center">
					<span class="font-weight-semibold" style="font-size: 100%" id="status-0">
						Hold: {{$totalPerStatus['0'] ?? 0 }}
					</span>
				</div>
				<div class="col-md-2 text-center">
					<span class="font-weight-semibold" style="font-size: 100%" id="status-1">
						Queue: {{$totalPerStatus['1'] ?? 0 }}
					</span>
				</div>
				<div class="col-md-2 text-center">
					<span class="font-weight-semibold" style="font-size: 100%" id="status-2">
						In Progress: {{$totalPerStatus['2'] ?? 0 }} 
					</span>
				</div>
				<div class="col-md-3 text-center">
					<span class="font-weight-semibold" style="font-size: 100%" id="status-3">
						Done Test Server: {{$totalPerStatus['3'] ?? 0 }} 
					</span>
				</div>
				<div class="col-md-2 text-center">
					<span class="font-weight-semibold" style="font-size: 100%" id="status-4">
						Production: {{$totalPerStatus['4'] ?? 0 }} 
					</span>
				</div>
			</div>
        </div>
        <div class="table-responsive">
            <table class="table datatable-basic table-hover">
                <thead>
                    <tr>
                        <th data-orderable="false">No</th>
                        <th data-orderable="false">Nama Patch</th>
                        <th>Prioritas</th>
                        <th>Tanggal Request</th>
                        <th data-orderable="false">Kesulitan</th>
                        <th data-orderable="false">Status</th>
                        <th>Tanggal Patch</th>
                        <th data-orderable="false">Keterangan</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
<script src="{{asset('assets/js/custom.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    function filterData() {
        var filterKlien = $('#filter_klien').val();
        var filterProyek = $('#filter_proyek').val();

        var dataTable = $('.datatable-basic').DataTable();
        dataTable.ajax.url('{{ route('patchlist.getpatchlist') }}?filterKlien=' + filterKlien + '&filterProyek=' + filterProyek).load();
    }

    function resetFilter() {
        $('#filter_klien').val('').trigger('change'); 
        $('#filter_proyek').val('').trigger('change');
        $('.datatable-basic').DataTable().ajax.reload();
    }

    function updateProyekDropdown(filterKlien) {
        $.ajax({
            url: '/get-nama-proyek-filter',
            type: 'GET',
            data: { user_id: filterKlien },
            success: function(data) {
                var proyekDropdown = $('#filter_proyek');
                proyekDropdown.empty();
                proyekDropdown.append('<option value="">-- Nama Proyek --</option>');
                $.each(data, function(key, value) {
                    proyekDropdown.append('<option value="' + key + '">' + value + '</option>');
                });
                proyekDropdown.trigger('change');
            }
        });
    }

    $('#filter_klien').on('change', function() {
        var selectedKlienId = $(this).val();
        updateProyekDropdown(selectedKlienId);
    });

    // Initialize
    $('.select-search').select2();

    // Initialize
    var $select = $('.form-control-select2').select2({
        minimumResultsForSearch: Infinity
    });

    $(document).ready(function() {
        $('#export-excel-button').click(function() {
            var filterKlien = $('#filter_klien').val();
            var filterProyek = $('#filter_proyek').val();

            var exportExcelUrl = $(this).data('export-url');

            if (filterKlien || filterProyek) {
                exportExcelUrl += "?";
            }

            if (filterKlien) {
                exportExcelUrl += "filterKlien=" + filterKlien;
            }

            if (filterProyek) {
                if (filterKlien) {
                    exportExcelUrl += "&";
                }
                exportExcelUrl += "filterProyek=" + filterProyek;
            }

            window.location.href = exportExcelUrl;
        });
    });

    //modal delete
    $(document).on("click", ".delbutton", function () {
        var url = $(this).data('uri');
        $("#delform").attr("action", url);
    });

    var DatatableBasic = function() {
        const prioritas = {
            '-2': '-2',
            '-1': '-1',
            '0': '0',
            '1': '1',
            '2': '2',
            '3': '3',
        }

        const status = {
            '0': 'Hold',
            '1': 'Queue',
            '2': 'In Progress',
            '3': 'Done Test Server',
            '4': 'Production',
        }

        const kesulitan = {
            '0': 'Sangat Tinggi',
            '1': 'Tinggi',
            '2': 'Sedang',
            '3': 'Rendah',
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
                    targets: [ 7 ]
                }],
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                searching: false,
                language: {
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                }
            });

            // Basic datatable
            $('.datatable-basic').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('patchlist.getpatchlist') }}',
                    data: function (d) {
                        d.filterKlien = $('#filter_klien').val();
                        d.filterProyek = $('#filter_proyek').val();
                    },
                },
                columns: [
                    {
                        data: null,
                        name: null,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "patchlist",
                        name: "patchlist",
                    },
                    {
                        data: "prioritas",
                        name: "prioritas",
                    },
                    {
                        data: null,
                        name: "created_at",
                        render: (data, type, row) => {
                            if (data?.created_at) {
                                const dateParts = data.created_at.split('-');
                                const formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                                return formattedDate;
                            }
                            return '-';
                        }
                    },
                    {
                        data: "kesulitan",
                        name: "kesulitan",
                        render: function(data, type, row, meta) {
                            return kesulitan[data] || '';
                        }
                    },
                    {
						data: null,
						name: null,
						render: (data, type, row) => {
							let statusStyle = '';

							if(data?.status == 0 )
								statusStyle = `<span style="font-size:100%;" class="badge badge-pill bg-danger-400 ml-auto ml-md-0">${status[data?.status]}</span>`
							else if(data?.status == 1)
								statusStyle = `<span style="font-size:100%;" class="badge badge-pill bg-warning-400 ml-auto ml-md-0">${status[data?.status]}</span>`
                            else if(data?.status == 2)
								statusStyle = `<span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">${status[data?.status]}</span>`
                            else if(data?.status == 3)
								statusStyle = `<span style="font-size:100%;" class="badge badge-pill bg-primary-400 ml-auto ml-md-0">${status[data?.status]}</span>`
                            else if(data?.status == 4)
								statusStyle = `<span style="font-size:100%;" class="badge badge-pill bg-success-400 ml-auto ml-md-0">${status[data?.status]}</span>`
                            
							return statusStyle;
						}
					},
                    {
                        data: "tanggal_patch",
                        name: "tanggal_patch",
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan',
                        render: function (data, type, row) {
                            return data ? stripHtml(data) : '-';
                        },
                        width: '200px'
                    },
                    {
                        data: null,
                        name: null,
                        render: (data, type, row) => {
                            let editRef = "{{ route('patchlist.edit', ':id') }}".replace(':id', data?.id);
                            let delUri = "{{ route('patchlist.destroy', ':id') }}".replace(':id', data?.id);

                            let actionsButton = `
                                <div class="btn-group">
                                    <a href="${editRef}" class="btn bg-purple btn-icon mr-1" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="icon-pencil7"></i>
                                    </a>
                            `;

                            @if (Auth::user())
                                actionsButton += `
                                    <a href="#" class="btn bg-danger btn-icon delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="icon-x"></i>
                                    </a>
                                `;
                            @endif

                            actionsButton += `</div>`;

                            return actionsButton;
                        }
                    }
                ],
                order: [[3, 'desc']],
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
