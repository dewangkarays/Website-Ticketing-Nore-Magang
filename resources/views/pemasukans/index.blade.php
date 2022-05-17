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
			<h4><span class="font-weight-semibold">Home</span> - Data Pemasukan Lainnya</h4>
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
			<a href="{{ route('pemasukans.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
			{{-- @if (Auth::user()->role==1)
			<a href={{ url('export_excel')}} target="_blank"><button class="btn btn-success rounded-round"><i class="icon-file-excel mr-2"></i> Export Excel</button></a>
			@endif --}}
        </div>

        <table class="table datatable-basic table-hover">
            <thead>
                <tr>
                    <th style="width: 50px">No</th>
                    <th style="width: 100px">Tanggal Pemasukan</th>
                    <th style="width: 200px">Nominal (Rp)</th>
                    {{-- <th>Status</th> --}}
                    <th style="width: 250px">Keterangan</th>
                    @if(\Auth::user()->role<=20)
                    <th class="text-center" style="width: 50px">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if(!$payments->isEmpty())
                @php ($i = 1)
                @foreach($payments as $payment)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$payment->tanggal}}</td>
                    <td style="font-size: 15px;">{{ number_format($payment->nominal, 0, ',', ',') }}</td>
                    {{-- <td align="center">
                        @if($payment->status == 0 )
                        <span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">{{config('custom.payment.'.$payment->status)}}</span>
                        @elseif($payment->status == 1)
                        <span style="font-size:100%;" class="badge badge-pill bg-success-400 ml-auto ml-md-0">{{config('custom.payment.'.$payment->status)}}</span>
                        @else
                        <span style="font-size:100%;" class="badge badge-pill bg-danger-400 ml-auto ml-md-0">{{config('custom.payment.'.$payment->status)}}</span>
                        @endif
                    </td> --}}
                    <td><div class="datatable-column-width">{!! $payment->keterangan !!}</div></td>
                    @if(\Auth::user()->role<=20)
                    <td align="center">
                        <div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    @if(\Auth::user()->role<=20 && $payment->status == 0)
                                    <button type="button" class="btn dropdown-item bg-success open-modal-accept" id="statusbtn" data-id=" {{ $payment->id }} " data-toggle="modal" data-target="#modal_terima"><i class="icon-checkmark-circle"></i> Terima</button>
                                    <button type="button" class="btn dropdown-item bg-danger open-modal-reject" id="statusbtn" data-id=" {{ $payment->id }} " data-payment=" {{ $payment->nominal }} " data-toggle="modal" data-target="#modal_tolak"><i class="icon-cancel-circle2"></i> Tolak</button>
                                    @endif
                                    {{-- @if(\Auth::user()->role<=20)
                                    <a href="https://wa.me/{{@$payment->user->telp}}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>
                                    @endif --}}
                                    {{-- <a href="{{ route('payments.edit',$payment->id)}}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a> --}}
                                    {{-- <a href="{{url('/payments/cetak/'.$payment->id)}}" class="dropdown-item" target="_blank"><i class="icon-printer2"></i> Print</a> --}}
                                    @if(Auth::user()->role==1)
                                    <a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="{{ route('pemasukans.destroy', $payment->id)}}"><i class="icon-x"></i> Delete</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
                @php ($i++)
                @endforeach
                @else
                <tr><td align="center" colspan="6">Data Kosong</td></tr>
                @endif

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
<script src="{{ URL::asset('global_assets/js/plugins/notifications/bootbox.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/buttons/spin.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/buttons/ladda.min.js') }}"></script>

<script src="{{ URL::asset('assets/js/app.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/demo_pages/components_modals.js') }}"></script>

<script>
    let getToken = function() {
		return $('meta[name=csrf-token]').attr('content')
	}
    //modal delete
	$(document).on("click", ".delbutton", function () {
		var url = $(this).data('uri');
		$("#delform").attr("action", url);
	});

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
                    targets: [ 3,4 ]
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
            $('.datatable-basic').DataTable()

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

        return {
            init: function() {
                _componentDatatableBasic();
                _componentSelect2();
            }
        }
    }();

    document.addEventListener('DOMContentLoaded', function() {
        DatatableBasic.init();
    });

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