@extends('layout')

@section('css')
<style type="text/css">
	.datatable-column-width{
		overflow: hidden; text-overflow: ellipsis; width: 150px; 
	}
	.datatable-column-width-small{
		overflow: hidden; text-overflow: ellipsis; width: 100px; 
	}
</style>
@endsection

@section('content')
@if ((Auth::user()->role==1) || (Auth::user()->role==20) || (Auth::user()->role==10) || \Auth::user()->role>=30 && \Auth::user()->role<=50)
	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Data Member</h4>
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
				<a href="{{ route('members.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
			</div>

			<table class="table datatable-basic table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Username</th>
						<th>Email</th>
						<th>Alamat</th>
						<th class="text-center"><span>Total Task</span></th>
						<th class="text-center"><span>Actions</span></th>
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
	<div id="modal_1_danger" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="delform">
				    @csrf
				    @method('DELETE')
					<div class="modal-body" align="center">
                        <h2> Hapus Data </h2>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn bg-danger">Hapus</button>
					</div>
				</form>
			</div>
		</div>
	</div>
    <div id="modal_2_danger" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="delform">
				    @csrf
				    @method('DELETE')
					<div class="modal-body" align="center">
                        <h2> Hapus Data </h2>
                        <h5> Member ini memiliki data proyek, yakin ingin menghapusnya? </h5>
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
	@endif

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
	<script src="{{asset('assets/js/custom.js')}}"></script>
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
		                targets: [ 6 ]
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
					'order':true,
					processing: true,
					serverSide: true,
					ajax: "/getmembers",
					columns: [
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return row.DT_RowIndex;
							}
						},
						{
							data: "nama",
							name: "nama",
						},
						{
							data: "username",
							name: "username",
						},
						{
							data: "email",
							name: "email",
						},
						{
							data: null,
							name: "alamat",
							render: (data, type, row) => {
								return data?.alamat ? stripHtml(data?.alamat) : "-"
							}
						},
						{
							data: null,
							name: "total_task",
							render: (data, type, row) => {
								let totalTask = 0
								if (data?.proyek != null) {
									data?.proyek?.map(proyek => {
										totalTask += proyek.task_count
									})
								}
								return totalTask
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let createRef = "{{route('createtagihan', ':id')}}"
								createRef = createRef.replace(':id', data?.id)
								let showRef = "{{route('members.show', ':id')}}"
								showRef = showRef.replace(':id', data?.id)
								let telpRef = "https://wa.me/{{':telp'}}"
								telpRef = telpRef.replace(':telp', data?.telp)
								let editRef = "{{route('members.edit', ':id')}}"
								editRef = editRef.replace(':id', data?.id)
								let deleteUri = "{{route('members.destroy', ':id')}}"
								deleteUri = deleteUri.replace(':id', data?.id)

								let actionsButton = 
									`<div class="dropdown">
										<a href="#" class="list-icons-item" data-toggle="dropdown">
											<i class="icon-menu9"></i>
										</a>

										<div class="dropdown-menu dropdown-menu-right">
											<a href="${createRef}" class="dropdown-item"><i class="icon-file-text"></i> Buat Tagihan</a>
											<a href="${showRef}" class="dropdown-item"><i class="icon-search4"></i> Show</a>
											<a href="${telpRef}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>`
											@if (Auth::user()->role==1)
												actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>`
											if (data?.proyek?.length <= 0) {
												actionsButton += `<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_1_danger" data-uri="${deleteUri}"><i class="icon-x"></i> Delete</a>`	
											} else {
												actionsButton += `<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_2_danger" data-uri="${deleteUri}"><i class="icon-x"></i> Delete</a>`
											}
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
