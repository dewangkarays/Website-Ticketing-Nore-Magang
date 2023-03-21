@extends('layout')

@section('css')
<style type="text/css">
	.datatable-column-width{
		overflow: hidden; text-overflow: ellipsis; max-width: 200px;
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
				<h4><span class="font-weight-semibold">Home</span> - Data Klien</h4>
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
			<a href="{{ route('klien.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
			@endif
		</div>

			<table class="table datatable-basic table-hover">
				<thead>
					<tr>
						  <th>No</th>
                          <th>Nama Calon Klien</th>
                          <th>Nama Perusahaan</th>
                          <th>Jenis Perusahaan</th>
                          <th>Potensi</th>
                          <th>Status</th>
                          <th>Source</th>
                          <th>Alamat</th>
                          <th>Marketing</th>
						  <th>Keterangan</th>
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
	<script src="{{asset('assets/js/custom.js')}}"></script>
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
						targets: [ 9 ]
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
                    "scrollX": true,
                    order: [[0, "desc"]],
					processing: true,
					serverSide: true,
					// "order": true,
					ajax: {
						"url"   :"{{ route("klien.data") }}",
                        "type"  :"POST",
                        "data"  :function ( d ) {
                            d._token= "{{ csrf_token() }}";
                        }
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
							data: 'nama_calonklien',
							name: 'nama_calonklien',
						},
                        {
							data: 'nama_perusahaan',
							name: 'nama_perusahaan',
						},
                        {
							data: 'jenis_perusahaan',
							name: 'jenis_perusahaan',
						},
                        {
							data: null,
							name: null,
                            render: (data, type, row) => {
								let ProdukNore = ''
                                // if (data?.ProdukNore == 1)
                                //     ProdukNore = `<span style="font-size: 100%;" class="badge badge-pill badge-primary">${potensi[data?.ProdukNore]}</span>`
                                // if (data?.ProdukNore == 2)
                                //     ProdukNore = `<span style="font-size: 100%;" class="badge badge-pill badge-secondary">${potensi[data?.ProdukNore]}</span>`
                                // if (data?.ProdukNore == 3)
                                //     ProdukNore = `<span style="font-size: 100%;" class="badge badge-pill badge-info">${potensi[data?.ProdukNore]}</span>`
                                // if (data?.ProdukNore == 4)
                                //     ProdukNore = `<span style="font-size: 100%;" class="badge badge-pill badge-dark">${potensi[data?.ProdukNore]}</span>`
                                // if (data?.ProdukNore == 5)
                                //     ProdukNore = `<span style="font-size: 100%;" class="badge badge-pill badge-warning">${potensi[data?.ProdukNore]}</span>`
                                // if (data?.ProdukNore == 6)
                                //     ProdukNore = `<span style="font-size: 100%;" class="badge badge-pill badge-success">${potensi[data?.ProdukNore]}</span>`
									const potensi = {
										'1': 'Website',
										'2': 'Iklan/Ads',
										'3': 'Sistem Informasi',
										'4': 'Mobile App',
										'6': 'Ulo',
										'5': 'Custom/Lainnya',
															
									}
								return potensi[data?.potensi];
							}
						},
                        {
							data: null,
							name: null,
							render: (data, type, row) => {
								const status_klien = {
                                    '1' : 'Visit',
                                    '2' : 'Kenal',
                                    '3' : 'Negosiasi',
                                    '4' : 'Deal',
                                    '5' : 'Pending',
                                    '6' : 'Bayar',
								}
								return status_klien[data?.status];
							}
						},
						{
							data: null,
							name: 'source',
							render: (data, type, row) => {
								const source = {
                                    '1' : 'Facebook',
									'2' : 'Goggle',
									'3' : 'Iklan',
									'4' : 'Walkin',
									'5' : 'Web',
									'6' : 'Relasi',
									'7' : 'Referal',
								}
								return source[data?.source];
							}
						},
                        {
							data: 'alamat',
							name: 'alamat',
						},
						{
							data: null,
							name: 'marketing_id',
							render: (data, type, row) => {
								return  data?.marketing?.nama
							}
						},
						{
                        data: null,
                        name: "keterangan_lain",
                        render: (data, type, row) => {
                            return data?.keterangan_lain ? stripHtml(data?.keterangan_lain) : '-'
                        }
                    	},
						{
							data: null,
							name: 'actions',
							render: (data, type, row) => {
								let showRef = "{{route('klien.show', ':id')}}";
								showRef = showRef.replace(':id', data?.id);

								let telpRef = "https://wa.me/{{':telp'}}";
								telpRef = telpRef.replace(':telp', data?.telp);

								let editRef = "{{route('klien.edit', ':id')}}";
								editRef = editRef.replace(':id', data?.id);

								let delUri = "{{route('klien.delete', ':id')}}";
								delUri = delUri.replace(':id', data?.id);
										
									
									@if(\Auth::user()->role==1) 
										
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
												

									`
									{ 
										var actionButtons =
									
										`
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right" style="z-index:5">
												<a href="${showRef}" class="dropdown-item"><i class="icon-search4"></i> Show</a>
												<a href="${editRef}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
						            			<a href="${telpRef}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>
												<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"><i class="icon-x"></i> Delete</a>
												
												
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