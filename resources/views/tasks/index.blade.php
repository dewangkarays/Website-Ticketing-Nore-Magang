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
		<div class="d-flex">
			<a href="{{ route('tasks.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
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
				{{-- <a href="{{ route('tasks.create', 'premium')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a> --}}
		</div>
		<table class="table datatable-p table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Username</th>
					<th>Nama Proyek</th>
					<th>Kebutuhan</th>
					<th>Severity</th>
					<th>Handler</th>
					@if (\Auth::user()->role == 10)
					<th>Assign</th>
					@endif
					<th class="text-center">Status</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
	{{-- Prioritas and simple list table --}}
	<div class="card">
		<div class="card-header">
				<h4 style="font-weight:bold;">Task Prioritas dan Simple</h4>
				{{-- <a href="{{ route('tasks.create', 'simple_prioritas')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a> --}}
		</div>
		<table class="table datatable-sp table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Username</th>
					<th>Nama Proyek</th>
					<th>Kebutuhan</th>
					<th>Severity</th>
					<th>Handler</th>
					@if (\Auth::user()->role == 10)
					<th>Assign</th>
					@endif
					<th class="text-center">Status</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
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
<script src="{{asset('assets/js/custom.js') }}"></script>
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
		// const data?.current_user = Auth::user()->id

		// const data?.current_user = @php Auth::user()->id @endphp

		const severity = {
			'1': 'Low',
			'2': 'Normal',
			'3': 'High',
		}

		const status = {
			'1': 'Baru',
			'2': 'Sedang Dikerjakan',
			'3': 'Selesai',
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
					// width: 100,
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
			
			function shorten(str, maxLen, separator = ' ') {
				if (str.length <= maxLen) return str;
				return str.substr(0, str.lastIndexOf(separator, maxLen)) + '...';
			};
			// Premium datatable
			@if(Auth::user()->role == 10)
				$('.datatable-p').DataTable({
					// "scrollX": true,
					processing: true,
					serverSide: true,
					ajax: {
						"type": "GET",
						"url": "/gettasks/premium",
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
								let date = new Date(data?.created_at)
								let dd = date.getDate()
								let mm = date.getMonth()
								let yyyy = date.getFullYear()

								if (dd < 10) dd = '0' + dd
								if (mm < 10) mm = '0' + mm
								if (yyyy < 10) yyyy = '0' + yyyy

								return `${yyyy}-${mm}-${dd}`
							}
						},
						{
							data: "username",
							name: "username"
						},
						{
							data: "nama_proyek",
							name: "nama_proyek"
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return data?.kebutuhan ? shorten(data?.kebutuhan, 100) : "-"
							}
						},
						{
							data: null,
							name: "severity",
							render: (data, type, row) => {
								return data?.severity ? severity[data?.severity] : '-'
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let formCheck = 
									`<div class="form-check">
										<label class="form-check-label">`
								if (data?.assign?.nama == null) {
									formCheck += `<p style="color:#ff0f0f;">Belum ada handler</p>`
								} else {
									formCheck += data?.assign?.nama
								}
								formCheck += 
										`</label>
									</div>`
								
								return formCheck
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let checkbox = ''
								if (data?.assign?.nama) {
										checkbox = `<input data-id="${data?.id}" class="form-check-input-styled-success toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" checked>`
								} else {
										checkbox = `<input data-id="${data?.id}" class="form-check-input-styled-success toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive">`										
								}
								return checkbox
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let spanStatus = ''

								if (data?.status == 2) {
									spanStatus = `<span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">${status[data?.status]}</span>`
								} else {
									spanStatus = status[data?.status]
								}
								return spanStatus
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let dataId = data?.id
								let telpRef = "https://wa.me/{{':telp'}}"
								telpRef = telpRef.replace(':telp', data?.user?.telp)
								let editRef = "{{ route('tasks.edit', ':id')}}"
								editRef = editRef.replace(':id', dataId)
								let delUri = "{{ route('tasks.destroy', ':id')}}"
								delUri = delUri.replace(':id', dataId)
								
								let actionsButton =
									`<div class="dropdown">
										<a href="#" class="list-icons-item" data-toggle="dropdown">
											<i class="icon-menu9"></i>
										</a>
										
										<div class="dropdown-menu dropdown-menu-right">`
								@if(\Auth::user()->role<=20)
											actionsButton += `<a href="${telpRef}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>`
								@endif
								@if (\Auth::user()->role==1 )
											actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>`
								@elseif (\Auth::user()->role==10)
											actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-search4"></i> Lihat Detail</a>`
								@else
											if (data?.current_user == data?.handler) {
												actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-search4"></i> Lihat Detail</a>`
											}
								@endif
								@if (\Auth::user()->role==1)
										actionsButton += `<button type="button" class="btn dropdown-item open-modal-task" id="statusbtn" data-id="${dataId}" data-toggle="modal" data-target="#modal_task"><i class="icon-check"></i> Selesai</button>`
								@else
											if (data?.current_user == data?.user_id) {
												actionsButton += `<button type="button" class="btn dropdown-item open-modal-task" id="statusbtn" data-id="${dataId}" data-toggle="modal" data-target="#modal_task"><i class="icon-check"></i> Selesai</button>`
											}
								@endif
								@if(\Auth::user()->role==1)
										actionsButton += `<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"><i class="icon-x"></i> Delete</a>`
								@endif
									actionsButton += `</div>
								</div>`

								return actionsButton
							}
						}
					]
				});
			@else
				$('.datatable-p').DataTable({
					// "scrollX": true,
					processing: true,
					serverSide: true,
					ajax: {
						"type": "GET",
						"url": "/gettasks/premium",
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
								let date = new Date(data?.created_at)
								let dd = date.getDate()
								let mm = date.getMonth()
								let yyyy = date.getFullYear()

								if (dd < 10) dd = '0' + dd
								if (mm < 10) mm = '0' + mm
								if (yyyy < 10) yyyy = '0' + yyyy

								return `${yyyy}-${mm}-${dd}`
							}
						},
						{
							data: "username",
							name: "username"
						},
						{
							data: "nama_proyek",
							name: "nama_proyek"
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return data?.kebutuhan ? shorten(data?.kebutuhan, 100) : "-"
							}
						},
						{
							data: null,
							name: "severity",
							render: (data, type, row) => {
								return data?.severity ? severity[data?.severity] : '-'
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let formCheck = 
									`<div class="form-check">
										<label class="form-check-label">`
								if (data?.assign?.nama == null) {
									formCheck += `<p style="color:#ff0f0f;">Belum ada handler</p>`
								} else {
									formCheck += data?.assign?.nama
								}
								formCheck += 
										`</label>
									</div>`
								
								return formCheck
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let spanStatus = ''

								if (data?.status == 2) {
									spanStatus = `<span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">${status[data?.status]}</span>`
								} else {
									spanStatus = status[data?.status]
								}
								return spanStatus
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let dataId = data?.id
								let telpRef = "https://wa.me/{{':telp'}}"
								telpRef = telpRef.replace(':telp', data?.user?.telp)
								let editRef = "{{ route('tasks.edit', ':id')}}"
								editRef = editRef.replace(':id', dataId)
								let delUri = "{{ route('tasks.destroy', ':id')}}"
								delUri = delUri.replace(':id', dataId)
								
								let actionsButton =
									`<div class="dropdown">
										<a href="#" class="list-icons-item" data-toggle="dropdown">
											<i class="icon-menu9"></i>
										</a>
										
										<div class="dropdown-menu dropdown-menu-right">`
								@if(\Auth::user()->role<=20)
											actionsButton += `<a href="${telpRef}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>`
								@endif
								@if (\Auth::user()->role==1 )
											actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>`
								@elseif (\Auth::user()->role==10)
											actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-search4"></i> Lihat Detail</a>`
								@else
											if (data?.current_user == data?.handler) {
												actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-search4"></i> Lihat Detail</a>`
											}
								@endif
								@if (\Auth::user()->role==1)
										actionsButton += `<button type="button" class="btn dropdown-item open-modal-task" id="statusbtn" data-id="${dataId}" data-toggle="modal" data-target="#modal_task"><i class="icon-check"></i> Selesai</button>`
								@else
											if (data?.current_user == data?.user_id) {
												actionsButton += `<button type="button" class="btn dropdown-item open-modal-task" id="statusbtn" data-id="${dataId}" data-toggle="modal" data-target="#modal_task"><i class="icon-check"></i> Selesai</button>`
											}
								@endif
								@if(\Auth::user()->role==1)
										actionsButton += `<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"><i class="icon-x"></i> Delete</a>`
								@endif
									actionsButton += `</div>
								</div>`

								return actionsButton
							}
						}
					]
				});
			@endif
			
			// Simple Priorites datatable
			@if(Auth::user()->role == 10)
				$('.datatable-sp').DataTable({
					// "scrollX": true,
					processing: true,
					serverSide: true,
					ajax: {
						"type": "GET",
						"url": "/gettasks/simpleprioritas",
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
								let date = new Date(data?.created_at)
								let dd = date.getDate()
								let mm = date.getMonth()
								let yyyy = date.getFullYear()

								if (dd < 10) dd = '0' + dd
								if (mm < 10) mm = '0' + mm
								if (yyyy < 10) yyyy = '0' + yyyy

								return `${yyyy}-${mm}-${dd}`
							}
						},
						{
							data: "username",
							name: "username"
						},
						{
							data: "nama_proyek",
							name: "nama_proyek"
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return data?.kebutuhan ? shorten(data?.kebutuhan, 100) : '-'
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return data?.severity ? severity[data?.severity] : '-'
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let formCheck = 
									`<div class="form-check">
										<label class="form-check-label">`
								if (data?.assign?.nama == null) {
									formCheck += `<p style="color:#ff0f0f;">Belum ada handler</p>`
								} else {
									formCheck += data?.assign?.nama
								}
								formCheck += 
										`</label>
									</div>`
								
								return formCheck
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let checkbox = ''
								if (data?.assign?.nama) {
										checkbox = `<input data-id="${data?.id}" class="form-check-input-styled-success toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" checked>`
								} else {
										checkbox = `<input data-id="${data?.id}" class="form-check-input-styled-success toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive">`										
								}
								return checkbox
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let spanStatus = ''

								if (data?.status == 2) {
									spanStatus = `<span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">${status[data?.status]}</span>`
								} else {
									spanStatus = status[data?.status]
								}
								return spanStatus
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let dataId = data?.id
								let telpRef = "https://wa.me/:id"
								telpRef = telpRef.replace(':id', data?.user?.telp)
								let editRef = "{{ route('tasks.edit', ':id')}}"
								editRef = editRef.replace(':id', dataId)
								let delUri = "{{ route('tasks.destroy', ':id')}}"
								delUri = delUri.replace(':id', dataId)
								
								let actionsButton =
									`<div class="dropdown">
										<a href="#" class="list-icons-item" data-toggle="dropdown">
											<i class="icon-menu9"></i>
										</a>
										
										<div class="dropdown-menu dropdown-menu-right">`
								@if(\Auth::user()->role<=20)
											actionsButton += `<a href="${telpRef}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>`
								@endif
								@if (\Auth::user()->role==1 )
											actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>`
								@elseif (\Auth::user()->role==10)
											actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-search4"></i> Lihat Detail</a>`
								@else
											if (data?.current_user == data?.handler) {
												actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-search4"></i> Lihat Detail</a>`
											}
								@endif
								@if (\Auth::user()->role==1)
										actionsButton += `<button type="button" class="btn dropdown-item open-modal-task" id="statusbtn" data-id="${dataId}" data-toggle="modal" data-target="#modal_task"><i class="icon-check"></i> Selesai</button>`
								@else
											if (data?.current_user ==data?.user_id) {
												actionsButton += `<button type="button" class="btn dropdown-item open-modal-task" id="statusbtn" data-id="${dataId}" data-toggle="modal" data-target="#modal_task"><i class="icon-check"></i> Selesai</button>`											
											}
								@endif
								@if(\Auth::user()->role==1)
										actionsButton += `<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"><i class="icon-x"></i> Delete</a>`
								@endif
									actionsButton += `</div>
								</div>`

								return actionsButton
							}
						}
					]
				});
			@else
				$('.datatable-sp').DataTable({
					// "scrollX": true,
					processing: true,
					serverSide: true,
					ajax: {
						"type": "GET",
						"url": "/gettasks/simpleprioritas",
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
								let date = new Date(data?.created_at)
								let dd = date.getDate()
								let mm = date.getMonth()
								let yyyy = date.getFullYear()

								if (dd < 10) dd = '0' + dd
								if (mm < 10) mm = '0' + mm
								if (yyyy < 10) yyyy = '0' + yyyy

								return `${yyyy}-${mm}-${dd}`
							}
						},
						{
							data: "username",
							name: "username"
						},
						{
							data: "nama_proyek",
							name: "nama_proyek"
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return data?.kebutuhan ? shorten(data?.kebutuhan, 100) : '-'
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return data?.severity ? severity[data?.severity] : '-'
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let formCheck = 
									`<div class="form-check">
										<label class="form-check-label">`
								if (data?.assign?.nama == null) {
									formCheck += `<p style="color:#ff0f0f;">Belum ada handler</p>`
								} else {
									formCheck += data?.assign?.nama
								}
								formCheck += 
										`</label>
									</div>`
								
								return formCheck
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let spanStatus = ''

								if (data?.status == 2) {
									spanStatus = `<span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">${status[data?.status]}</span>`
								} else {
									spanStatus = status[data?.status]
								}
								return spanStatus
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let dataId = data?.id
								let telpRef = "https://wa.me/:id"
								telpRef = telpRef.replace(':id', data?.user?.telp)
								let editRef = "{{ route('tasks.edit', ':id')}}"
								editRef = editRef.replace(':id', dataId)
								let delUri = "{{ route('tasks.destroy', ':id')}}"
								delUri = delUri.replace(':id', dataId)
								
								let actionsButton =
									`<div class="dropdown">
										<a href="#" class="list-icons-item" data-toggle="dropdown">
											<i class="icon-menu9"></i>
										</a>
										
										<div class="dropdown-menu dropdown-menu-right">`
								@if(\Auth::user()->role<=20)
											actionsButton += `<a href="${telpRef}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>`
								@endif
								@if (\Auth::user()->role==1 )
											actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>`
								@elseif (\Auth::user()->role==10)
											actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-search4"></i> Lihat Detail</a>`
								@else
											if (data?.current_user == data?.handler) {
												actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-search4"></i> Lihat Detail</a>`
											}
								@endif
								@if (\Auth::user()->role==1)
										actionsButton += `<button type="button" class="btn dropdown-item open-modal-task" id="statusbtn" data-id="${dataId}" data-toggle="modal" data-target="#modal_task"><i class="icon-check"></i> Selesai</button>`
								@else
											if (data?.current_user ==data?.user_id) {
												actionsButton += `<button type="button" class="btn dropdown-item open-modal-task" id="statusbtn" data-id="${dataId}" data-toggle="modal" data-target="#modal_task"><i class="icon-check"></i> Selesai</button>`											
											}
								@endif
								@if(\Auth::user()->role==1)
										actionsButton += `<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"><i class="icon-x"></i> Delete</a>`
								@endif
									actionsButton += `</div>
								</div>`

								return actionsButton
							}
						}
					]
				});
			@endif
			
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