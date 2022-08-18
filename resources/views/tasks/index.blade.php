@extends('layout')

@section('css')
<style type="text/css">
	.datatable-column-width{
		overflow: hidden; text-overflow: ellipsis; max-width: 200px;
	}

	.form-check{
		padding-left: 0px ;
	}
</style>
@endsection

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><span class="font-weight-semibold">Home</span> - Data Task</h4>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
	</div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
	
	<!-- Hover rows -->
	{{-- Premium list table --}}
	<div class="card">
		<div class="card-header">
				<h4 style="font-weight:bold;">Task Premium</h4>
				<a href="{{ route('tasks.create', 'premium')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
		</div>
		<table class="table datatable-basic table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Username</th>
					<th>Nama Proyek</th>
					<th>Kebutuhan</th>
					<th>Severity</th>
					<th>Handler</th>
					<th class="text-center">Status</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				@if(!$taskpremiums->isEmpty())
				@php ($i = 1)
				@foreach($taskpremiums as $task)
				
				<tr>
					<td>{{$i}}</td>
					<td><div class="datatable-column-width">{{date("Y-m-d", strtotime($task->created_at))}}</div></td>
					<td><div class="datatable-column-width">{{$task->username}}</div></td>
					<td><div class="datatable-column-width">{{$task->nama_proyek}}</div></td>
					<td><div class="datatable-column-width">{{$task->kebutuhan}}</div></td>
					<td><div class="datatable-column-width">{{config('custom.severity.'.$task->severity)}}</div></td>
					<td><div class="datatable-column-width form-check">
						<label class="form-check-label">
							@if (\Auth::user()->role == 10)
							<input data-id="{{$task->id}}" class="form-check-input-styled-success toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $task->handler == \Auth::user()->id ? 'checked' : '' }}>
							@endif
							@if (@$task->assign->nama == NULL)
								<p style="color:#ff0f0f;">Belum ada handler</p>
							@else
								{{@$task->assign->nama}}
							@endif
						</label>
						</div>
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
									@if (\Auth::user()->role==1 )
									<a href="{{ route('tasks.edit',$task->id)}}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
									@elseif (\Auth::user()->role==10 || \Auth::user()->id == $task->handler )
									<a href="{{ route('tasks.edit',$task->id)}}" class="dropdown-item"><i class="icon-search4"></i> Lihat Detail</a>
									@endif
									@if (\Auth::user()->role==1 || \Auth::user()->id == $task->user_id )
									<button type="button" class="btn dropdown-item open-modal-task" id="statusbtn" data-id=" {{ $task->id }} " data-toggle="modal" data-target="#modal_task"><i class="icon-check"></i> Selesai</button>
									@endif
									
									{{-- @if($task->status==1 || \Auth::user()->role==1) --}}
									@if(\Auth::user()->role==1)
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
				<tr><td align="center" colspan="8">Data Kosong</td></tr>
				@endif
			</tbody>
		</table>
	</div>
	{{-- Prioritas and simple list table --}}
	<div class="card">
		<div class="card-header">
				<h4 style="font-weight:bold;">Task Prioritas dan Simple</h4>
				<a href="{{ route('tasks.create', 'simple_prioritas')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
		</div>
		<table class="table datatable-basic table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Username</th>
					<th>Nama Proyek</th>
					<th>Kebutuhan</th>
					<th>Severity</th>
					<th>Handler</th>
					<th class="text-center">Status</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				@if(!$tasksp->isEmpty())
				@php ($i = 1)
				@foreach($tasksp as $task)
				
				<tr>
					<td>{{$i}}</td>
					<td><div class="datatable-column-width">{{date("Y-m-d", strtotime($task->created_at))}}</div></td>
					<td><div class="datatable-column-width">{{$task->username}}</div></td>
					<td><div class="datatable-column-width">{{$task->nama_proyek}}</div></td>
					<td><div class="datatable-column-width">{{$task->kebutuhan}}</div></td>
					<td><div class="datatable-column-width">{{config('custom.severity.'.$task->severity)}}</div></td>
					<td><div class="datatable-column-width form-check">
						<label class="form-check-label">
							@if (\Auth::user()->role == 10)
							<input data-id="{{$task->id}}" class="form-check-input-styled-success toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $task->handler == \Auth::user()->id ? 'checked' : '' }}>
							@endif
							@if (@$task->assign->nama == NULL)
								<p style="color:#ff0f0f;">Belum ada handler</p>
							@else
								{{@$task->assign->nama}}
							@endif
						</label>
						</div>
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
									@if (\Auth::user()->role==1 )
									<a href="{{ route('tasks.edit',$task->id)}}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
									@elseif (\Auth::user()->role==10 || \Auth::user()->id == $task->handler )
									<a href="{{ route('tasks.edit',$task->id)}}" class="dropdown-item"><i class="icon-search4"></i> Lihat Detail</a>
									@endif
									@if (\Auth::user()->role==1 || \Auth::user()->id == $task->user_id )
									<button type="button" class="btn dropdown-item open-modal-task" id="statusbtn" data-id=" {{ $task->id }} " data-toggle="modal" data-target="#modal_task"><i class="icon-check"></i> Selesai</button>
									@endif
									
									{{-- @if($task->status==1 || \Auth::user()->role==1) --}}
									@if(\Auth::user()->role==1)
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
				<tr><td align="center" colspan="8">Data Kosong</td></tr>
				@endif 
			</tbody>
		</table>
		
	</div>
	<!-- /hover rows -->
	{{-- <button type="button" class="btn btn-info open-modal" >Show </button> --}}
	
</div>
<div id="modal_task" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-success" align="center">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<div  class="modal-body" align="center">
				<input class="form-control" type="hidden" name="task_id" id="task_id" value=""/>
				<h2>Yakin task selesai?</h2>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Belum</button>
				<button type="button" id="btn-update" class="btn btn-success">Ya, sudah selesai</button>
			</div>
		</div>
	</div>
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

<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/forms/styling/switch.min.js')}}"></script>

<script src="{{asset('assets/js/app.js') }}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_checkboxes_radios.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/components_modals.js') }}"></script>
<script>
	// get token
	let getToken = function() {
		return $('meta[name=csrf-token]').attr('content')
	}
	
	// modal task
	$(document).on("click", ".open-modal-task", function () {
		var id_task = $(this).data('id');
		$(".modal-body #task_id").val( id_task );
		// As pointed out in comments, 
		// it is unnecessary to have to manually call the modal.
		// $('#addBookDialog').modal('show');
	});
	
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
	
	$("#btn-update").click(function(){ 
		var token = getToken();
		var id = $('#task_id').val();
		var status = 3; 
		
		$.ajax({
			type: "POST",
			url: '/updatestatus',
			// 'url': '/updatestatus',
			// 'method': 'POST',
			data: {'status': status, 'id': id, _token : token },
			success: function(data){
				// Sticky buttons
				// alert('Data changed!')
				
				location.reload();
			}
		});
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