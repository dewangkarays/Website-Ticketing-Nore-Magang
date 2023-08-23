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
				<h4><span class="font-weight-semibold">Home</span> - Data Karyawan</h4>
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
			@if (Auth::user()->role==1)
			<a href="{{ route('users.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
			@endif
		</div>

			<table class="table datatable-basic table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Username</th>
						<th>Role</th>
						<th>Status User</th>
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
	 <!-- Nonaktif User -->
	 <div id="User_Update" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="Nonaktif">
				    @csrf
				    @method('PUT')
					<div class="modal-body" align="center">
						<h2> Nonaktif User? </h2>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn bg-danger">Nonaktif</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Aktif User -->
	<div id="Aktif_User" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-success" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="Aktif">
				    @csrf
				    @method('PUT')
					<div class="modal-body" align="center">
						<h2> Aktif User? </h2>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn bg-success">Aktif</button>
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
			 $("#Nonaktif").attr("action", url);
			 $("#Aktif").attr("action", url);
			
			});

		var DatatableBasic = function() {

			const status_user = {
				'0': 'Nonaktif',
				'1': 'Aktif',
									
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
					columnDefs: [
						{ 
							orderable: false,
							// width: 100,
							targets: [ 5 ]
						},
						{
							width: 50,
							targets: [0, 5]
						}
					],
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
					processing: true,
					serverSide: true,
					// "order": true,
					ajax: {
						'type': 'GET',
						'url': `{{url('getkaryawans')}}`,
					},
					columns: [
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return row.DT_RowIndex;
							}
						},
						{
							data: 'nama',
							name: 'nama',
						},
						{
							data: 'username',
							name: 'username',
						},
						{
							data: null,
							name: 'role',
							render: (data, type, row) => {
								const role = {
									'1': 'Super Admin',
									'10': 'Karyawan',
									'20': 'Keuangan',
        							'30': 'Frontend',
        							'35': 'QA',
        							'40': 'Backend',
        							'50': 'Marketing',
        							'95': 'Klien',
								}
								return role[data?.role];
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let nonaktif = ''
                                if (data?.nonaktif == 0)
                                    nonaktif = `<span style="font-size: 100%;" class="badge badge-pill badge-danger">${status_user[data?.nonaktif]}</span>`
                                else 
                                    nonaktif = `<span style="font-size: 100%;" class="badge badge-pill badge-success">${status_user[data?.nonaktif]}</span>` 

                                  
								return nonaktif
							}
						},
						{
							data: null,
							name: 'actions',
							render: (data, type, row) => {
								let showRef = "{{route('users.show', ':id')}}";
								showRef = showRef.replace(':id', data?.id);

								let telpRef = "https://wa.me/{{':telp'}}";
								telpRef = telpRef.replace(':telp', data?.telp);

								let editRef = "{{route('users.edit', ':id')}}";
								editRef = editRef.replace(':id', data?.id);

								let delUri = "{{route('users.destroy', ':id')}}";
								delUri = delUri.replace(':id', data?.id);
									
								let UserUpdate = "{{route('users.UpdateUser', ':id')}}";
								UserUpdate = UserUpdate.replace(':id', data?.id);
									
								let AktifUser = "{{route('users.UserAktif', ':id')}}";
								AktifUser = AktifUser.replace(':id', data?.id);
									
									@if(\Auth::user()->role==1) 
									if (data.nonaktif==0) {
										
										var actionButtons =
									`
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right" style="z-index:5">
												<a href="${showRef}" class="dropdown-item"><i class="icon-search4"></i> Show</a> 
												<a href="${telpRef}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>
												
												
												<a href="${editRef}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
						            			<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"><i class="icon-x"></i> Delete</a>
												

												<a class="dropdown-item delbutton" data-toggle="modal" data-target="#Aktif_User" data-uri="${AktifUser}"><i class="fa fa-eye" aria-hidden="true"></i> Aktif</a>

									`
									} else { 
										var actionButtons =
									
										`
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right" style="z-index:5">
												<a href="${showRef}" class="dropdown-item"><i class="icon-search4"></i> Show</a> 
												<a href="${telpRef}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>
												
												
												<a href="${editRef}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
						            			<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"><i class="icon-x"></i> Delete</a>
												
												<a class="dropdown-item delbutton" data-toggle="modal" data-target="#User_Update" data-uri="${UserUpdate}"><i class="fa fa-eye-slash"></i> Nonaktif</a>
												
										`
									}
										
									@else
									var actionButtons =
									`
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right" style="z-index:5">
												<a href="${showRef}" class="dropdown-item"><i class="icon-search4"></i> Show</a> 
												<a href="${telpRef}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>
												
												
											</div>
										</div>
									`
									@endif
									
								

								return actionButtons;
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