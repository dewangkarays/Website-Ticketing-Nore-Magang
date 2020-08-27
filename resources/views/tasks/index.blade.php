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
			<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Data Task</h4>
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
			
			@if (\Auth::user()->role > 20 && \Auth::user()->task_count == 0)
			<a href="{{ route('tasks.create')}}"><button type="button" class="btn btn-danger rounded-round" disabled><i class="icon-cancel-circle2 mr-2"></i> Tambah</button></a>
			<span class="text-danger font-weight-semibold">Jumlah pengoperasian anda 0.</span> 
			
			@else
			<a href="{{ route('tasks.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
			
			@endif
		</div>
		
		<table class="table datatable-basic table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Username</th>
					<th>Kebutuhan</th>
					<th>Handler</th>
					<th class="text-center">Status</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				@if(!$tasks->isEmpty())
				@php ($i = 1)
				@foreach($tasks as $task)
				
				<tr>
					<td>{{$i}}</td>
					<td><div class="datatable-column-width">{{date("Y-m-d", strtotime($task->created_at))}}</div></td>
					<td><div class="datatable-column-width">{{$task->user->username}}</div></td>
					<td><div class="datatable-column-width">{{$task->kebutuhan}}</div></td>
					<td><div class="datatable-column-width">
						@if (\Auth::user()->role == 10)
						<input data-id="{{$task->id}}" class="form-check-input toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $task->handler == \Auth::user()->id ? 'checked' : '' }}>
						@endif
						{{@$task->assign->nama}}</div>
					</td>
					
					<td align="center">@if($task->status == 2 )
						<span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">{{config('custom.status.'.$task->status)}}</span>
						@else
						{{config('custom.status.'.$task->status)}}
						@endif
					</td>
					<td align="center">
						<div class="list-icons">
							<div class="dropdown">
								<a href="#" class="list-icons-item" data-toggle="dropdown">
									<i class="icon-menu9"></i>
								</a>
								
								<div class="dropdown-menu dropdown-menu-right">
									@if(\Auth::user()->role<=20)
									<a href="https://wa.me/{{$task->user->telp}}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>
									@endif
									@if (\Auth::user()->role==1 || \Auth::user()->id == $task->handler )
									<a href="{{ route('tasks.edit',$task->id)}}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
									@endif
									@if (\Auth::user()->role==1 || \Auth::user()->id == $task->user_id )
									<button type="button" class="btn dropdown-item" id="statusbtn" onclick="updatestatus( {{$task->id}} )"><i class="icon-check"></i> Selesai</button>
									@endif
									
									@if($task->status==1 || \Auth::user()->role==1)
									<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="{{ route('tasks.destroy', $task->id)}}"><i class="icon-x"></i> Delete</a>
									@endif
								</div>
							</div>
						</div>
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
<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js') }}"></script>
<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js') }}"></script>
<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js') }}"></script>

<script src="{{asset('assets/js/app.js') }}"></script>
<script src="{{asset('global_assets/js/demo_pages/components_modals.js') }}"></script>
<script>
	// get token
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
					targets: [ 0, 1, 2, 3, 4, 5, 6 ]
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

<script>
	$(function() {
		$('.toggle-class').change(function() {
			var status = $(this).prop('checked') == true ? 2 : 1; 
			var token = getToken();
			var task_id = $(this).data('id'); 
			var user_id = $(this).prop('checked') == true ? {{ \Auth::user()->id }} : '';
			
			$.ajax({
				type: "POST",
				dataType: "json",
				url: '/changehandler',
				data: {'status': status, 'user_id': user_id, 'id': task_id, _token : token },
				success: function(data){
					// Sticky buttons
						alert('Data changed!')
					
					location.reload();
				}
			});
		})
	})
	
	
	function updatestatus(id){
		var token = getToken();
		var id = id;
		var status = 3; 
		
		$.ajax({
			type: "POST",
			url: '/updatestatus',
			// 'url': '/updatestatus',
			// 'method': 'POST',
			data: {'status': status, 'id': id, _token : token },
		});
		
	}
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