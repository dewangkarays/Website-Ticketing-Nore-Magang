@extends('layout')
@section('css')
    <style>
        table tbody {
            width: 100%;
        }
        .center {
            text-align: center;
        }
    </style>
@endsection
@section('content')
     <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> -  Presensi</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->
    @if(\Auth::user()->role == 1)
    <!-- Content area -->
    <div class="content">
        <!-- Hover rows -->
		<div id="card-presensi" class="card">
            <div class="card-header header-elements-inline">
				<a href="{{ route('presensi.create') }}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Presensi</button></a>
			</div>

            <div class="card-body">

                    <table id="table" class="table datatable-basic table-hover" style="display: block;overflow-x: auto">
                        <thead>
                            <tr> 
                                <th>No</th>
                                <th>Nama</th>
                                @for($i=0;$i<count($dates);$i++)
                                <th class="tanggal">{{ $dates[$i] }}</th>
                                @endfor
                                {{-- @foreach ($presensi_all as $pres)
                                <th class="center">{{ $pres->tanggal }}</th>
                                @endforeach --}}
                                
                                {{-- <th class="text-center">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @for($k=0;$k<count($karyawans_all);$k++)
                            <tr> 
                                <td>{{ $k + 1 }}</td>
                                @php($j = 0)
                                <td>{{ $karyawans_all[$k]['nama'] }}</td>
                                @for($i=0;$i<count($dates);$i++)
                                    @if(count($karyawans_all[$k]['presensi']) != 0)
                                        @if($dates[$i]==$karyawans_all[$k]['presensi'][$j]['tanggal'])
                                            @if($karyawans_all[$k]['presensi'][$j]['status'] == 1)
                                                <td class="center"> v </td>
                                                    @if($j < count($karyawans_all[$j]['presensi']))
                                                    @php($j++)
                                                    @endif
                                                @elseif($karyawans_all[$k]['presensi'][$j]['status'] == 2)
                                                <td class="center"> i </td>
                                                    @if($j < count($karyawans_all[$j]['presensi']))
                                                    @php($j++)
                                                    @endif
                                                @else
                                                <td class="center"> s </td>
                                                    @if($j < count($karyawans_all[$j]['presensi']))
                                                    @php($j++)
                                                    @endif
                                            @endif
                                        @else
                                            <td class="center"> . </td>
                                        @endif
                                    @else
                                        <td class="center"> . </td>
                                    @endif
                                @endfor
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                    <table id="table" class="mt-3 border table datatable-basic table-hover col-xl-4">
                        <tr>
                            <th>Sakit</th>
                            <td>{{ $sakit_all }}</td>
                        </tr>
                        <tr>
                            <th>Izin</th>
                            <td>{{ $izin_all }}</td>
                        </tr>
                        {{-- <tr>
                            <th>Sisa Cuti</th>
                            <td>{{ $sisa_cuti }}</td>
                        </tr> --}}
                </table>
            </div>
		</div>
		<!-- /hover rows -->
    </div>

    <div class="col-xl-4">
        <!-- Basic Table -->
        <div class="card m-2">
            <div class="card-body">
                <div class="chart-container">
                    <table class="table datatable-basic table-hover">
                            <tr>
                                <th>Sakit</th>
                                <td>{{ $sakit_all }}</td>
                            </tr>
                            <tr>
                                <th>Izin</th>
                                <td>{{ $izin_all }}</td>
                            </tr>
                            {{-- <tr>
                                <th>Sisa Cuti</th>
                                <td>{{ $sisa_cuti }}</td>
                            </tr> --}}
                    </table>
                </div>
            </div>
        </div>
        <!-- /basic donut -->
    </div>
    @else
    <!-- Content area -->
    <div class="content">
        <!-- Hover rows -->
		<div id="card-presensi" class="card">
            <div class="card-header header-elements-inline">
				<a href="{{ route('presensi.create') }}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Presensi</button></a>
			</div>

            <div class="card-body">

                    <table id="table" class="table datatable-basic table-hover" style="display: block;overflow-x: auto">
                        <thead>
                            <tr> 
                                <th>No</th>
                                <th>Nama</th>
                                @for($i=0;$i<count($dates);$i++)
                                <th class="tanggal">{{ $dates[$i] }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            <tr> 
                                <td>1</td>
                                @php($j = 0)
                                <td>{{ \Auth::user()->nama }}</td>
                                @for($i=0;$i<count($dates);$i++)
                                    @if($dates[$i]==$karyawans[0]['presensi'][$j]['tanggal'])
                                        @if($karyawans[0]['presensi'][$j]['status'] == 1)
                                            <td class="center"> v </td>
                                                @if($j < count($karyawans[0]['presensi']))
                                                @php($j++)
                                                @endif
                                            @elseif($karyawans[0]['presensi'][$j]['status'] == 2)
                                            <td class="center"> i </td>
                                                @if($j < count($karyawans[0]['presensi']))
                                                @php($j++)
                                                @endif
                                            @else
                                            <td class="center"> s </td>
                                                @if($j < count($karyawans[0]['presensi']))
                                                @php($j++)
                                                @endif
                                        @endif
                                    @else
                                        <td class="center"> . </td>
                                    @endif
                                @endfor
                            </tr>
                        </tbody>
                    </table>
            </div>
		</div>
		<!-- /hover rows -->
    </div>

    <div class="col-xl-4">
        <!-- Basic Table -->
        <div class="card m-2">
            <div class="card-body">
                <div class="chart-container">
                    <table id="table" class="table datatable-basic table-hover">
                            <tr>
                                <th>Sakit</th>
                                <td>{{ $sakit }}</td>
                            </tr>
                            <tr>
                                <th>Izin</th>
                                <td>{{ $izin }}</td>
                            </tr>
                            <tr>
                                <th>Sisa Cuti</th>
                                <td>{{ $sisa_cuti }}</td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- /basic donut -->
    </div>
    @endif

    <!-- Danger Modal -->
	<div id="modal_theme_danger" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="delform">
				    @csrf
				    {{-- @method('DELETE') --}}
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
    <script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/components_modals.js')}}"></script>

    {{-- <script type="text/javascript">
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
            targets: [ 8 ],
            },
        ],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
        }
    });

    // Resize scrollable table when sidebar width changes
    $('.sidebar-control').on('click', function() {
        table.columns.adjust().draw();
    });
};



//
// Return objects assigned to module
//

return {
    init: function() {
        _componentDatatableBasic();
    }
}
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
DatatableBasic.init();
});
    </script> --}}
@endsection