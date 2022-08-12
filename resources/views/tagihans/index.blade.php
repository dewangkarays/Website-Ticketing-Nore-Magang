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
				<h4><span class="font-weight-semibold">Home</span> - Data Tagihan</h4>
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
				<a href="{{ route('tagihans.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
				<a href="{{ url('exporttagihan')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-file-excel mr-2"></i> Export Excel</button></a>
			</div>

			<table class="table datatable-basic table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						{{-- <th>Username</th> --}}
						{{-- <th>Invoice</th> --}}
						<th>Nama Proyek</th>
                        <th>Masa Berlaku</th>
						<th>Uang Muka (Rp)</th>
						<th>Tagihan (Rp)</th>
						<th>Keterangan</th>
						{{-- <th>Terbayar</th>
						<th>Sisa Tagihan</th>
						<th class="text-center">Status</th> --}}
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
				@if(!$tagihans->isEmpty())
					@php ($i = 1)
					@foreach($tagihans as $tagihan)
				    <tr>
				        <td>{{$i}}</td>
				        <td><div class="datatable-column-width">{{$tagihan->user->nama}}</div></td>
				        {{-- <td><div class="datatable-column-width">{{@$tagihan->user->username}}</div></td> --}}
				        {{-- <td><div class="datatable-column-width">{{$tagihan->invoice}}</div></td> --}}
				        <td><div class="datatable-column-width">{{$tagihan->proyek->nama_proyek}}</div></td>
                        <td><div class="datatable-column-width">{{$tagihan->masa_berlaku}}</div></td>
						<td><div class="datatable-column-width">{{ number_format($tagihan->uang_muka, 0, ',', ',') }}</div></td>
						<td><div class="datatable-column-width">{{ number_format($tagihan->jml_tagih, 0, ',', ',') }}</div></td>
				        {{-- <td><div class="datatable-column-width">Rp @angka(($tagihan->langganan)+($tagihan->ads)+($tagihan->lainnya))</div></td> --}}
						{{-- <td><div class="datatable-column-width">Rp @angka($tagihan->payment->sum('nominal'))</div></td>
						<td><div class="datatable-column-width">Rp @angka($tagihan->jml_bayar)</div></td>
						<td><div class="datatable-column-width">Rp @angka($tagihan->jml_tagih)</div></td>
						<td align="center">
							@if ($tagihan->status == 2)
							<span style="font-size:100%;" class="badge badge-pill bg-success-400 ml-auto ml-md-0">{{config('custom.tagihan_status.'.$tagihan->status)}}</span>
							@elseif ($tagihan->status == 1)
							<span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">{{config('custom.tagihan_status.'.$tagihan->status)}}</span>
							@else
							<span style="font-size:100%;" class="badge badge-pill bg-info-400 ml-auto ml-md-0">{{config('custom.tagihan_status.'.$tagihan->status)}}</span>
							@endif
						</td> --}}
						<td><div class="datatable-column-width">{!! $tagihan->keterangan !!}</div></td>
				        <td align="center">
							<div class="list-icons">
								<div class="dropdown">
									<a href="#" class="list-icons-item" data-toggle="dropdown">
										<i class="icon-menu9"></i>
									</a>

									<div class="dropdown-menu dropdown-menu-right">
										<a href="{{ route('tagihans.edit',$tagihan->id)}}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
										<a href="{{url('/tagihans/cetak/'.$tagihan->id)}}" class="dropdown-item" target="_blank"><i class="icon-printer2"></i> Print</a>
										<a href="{{url('/tagihans/lampiran/'.$tagihan->id)}}" class="dropdown-item"><i class="icon-images3"></i> Lampiran</a>
										@if (Auth::user()->role==1)
							            <a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="{{ route('tagihans.destroy', $tagihan->id)}}"><i class="icon-x"></i> Delete</a>
										@endif
									</div>
								</div>
							</div>
				        </td>
				    </tr>
				    @php ($i++)
				    @endforeach
				@else
				  	<tr><td align="center" colspan="9">Data Kosong</td></tr>
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
	<script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/components_modals.js')}}"></script>
	<script>
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
		                width: 100,
		                targets: [ 7 ]
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
