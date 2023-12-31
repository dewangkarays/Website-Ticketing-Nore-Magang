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
				<h4><span class="font-weight-semibold">Home</span> - Data Antrian</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">

		<!-- Hover rows -->
		<div class="card">

			<table class="table datatable-basic table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Pelanggan</th>
						<th>Layanan</th>
						<th class="text-center">Status</th>
					</tr>
				</thead>
				<tbody>
				@if(!$tasks->isEmpty())
					@php ($i = 1)
					@foreach($tasks as $task)
				    <tr>
				        <td>{{$i}}</td>
				        <td><div class="datatable-column-width">{{date("Y-m-d", strtotime($task->created_at))}}</div></td>
							@if (\Auth::user()->role<20 || \Auth::user()->role=20)
							<td><div class="datatable-column-width"> {{$task->user->username}} </div></td>
							@elseif (\Auth::user()->id == $task->user_id || \Auth::user()->role<20 || \Auth::user()->role=20)
							{{-- karyawan --}}
							<td><div class="datatable-column-width"> <span style="font-size:100%;" class="badge badge-pill bg-success ml-auto ml-md-0"> {{$task->user->username}}</span></div></td>
							@else
							<td><div class="datatable-column-width"> Pelanggan Lain </div></td>
							@endif

				        <td><div class="datatable-column-width">{{config('custom.role.'.$task->user->role)}}</div></td>
				        <td align="center">@if($task->status == 2 )
								<span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">{{config('custom.status.'.$task->status)}}</span>
							@else
								{{config('custom.status.'.$task->status)}}
							@endif
						</td>
				    </tr>
				    @php ($i++)
				    @endforeach
				@else
				  	<tr><td align="center" colspan="5">Data Kosong</td></tr>
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
	<script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js') }}"></script>

	<script src="{{asset('assets/js/app.js') }}"></script>
	<script src="{{asset('global_assets/js/demo_pages/components_modals.js') }}"></script>
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
		                //width: 200,
		                targets: [ 0, 1, 2, 3, 4]
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