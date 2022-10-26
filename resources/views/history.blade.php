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
				<h4><span class="font-weight-semibold">Home</span> - Data History Task</h4>
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
						<th>Tanggal Selesai</th>
						<th>Username</th>
						<th>Kebutuhan</th>
						<th>Handler</th>
						<th class="text-center">Status</th>
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
	<script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js') }}"></script>

	<script src="{{asset('assets/js/app.js') }}"></script>
	<script src="{{asset('assets/js/custom.js') }}"></script>
	<script src="{{asset('global_assets/js/demo_pages/components_modals.js') }}"></script>
	<script>
		//modal delete
		$(document).on("click", ".delbutton", function () {
		     var url = $(this).data('uri');
		     $("#delform").attr("action", url);
		});

		var DatatableBasic = function() {

			const status = {
				'1': 'Baru',
				'2': 'Sedang Dikerjakan',
				'3': 'Selesai',
			}

			function shorten(str, maxLen, separator = ' ') {
				if (str.length <= maxLen) return str;
				return str.substr(0, str.lastIndexOf(separator, maxLen)) + '...';
			};

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
					processing: true,
					serverSide: true,
					ajax: "/gettaskshistory",
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
								let date = new Date(data?.updated_at)
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
							data: null,
							name: null,
							render: (data, type, row) => {
								return data?.user?.nama ? data?.user.nama : "-"
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return data?.kebutuhan ? shorten(stripHtml(data?.kebutuhan), 100) : "-"
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return data?.assign?.nama ? data?.assign?.nama : "-"
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								return status[data?.status]
							}
						},
						{
							data: null,
							name: null,
							render: (data, type, row) => {
								let id = data?.id
								let showRef = "{{ route('tasks.show', ':id')}}"
								showRef = showRef.replace(':id', id)
								let editRef = "{{ route('tasks.edit', ':id')}}"
								editRef = editRef.replace(':id', id)

								let actionsButton =
									`<div class="dropdown">
										<a href="#" class="list-icons-item" data-toggle="dropdown">
											<i class="icon-menu9"></i>
										</a>

										<div class="dropdown-menu dropdown-menu-right">
											<a href="${showRef}" class="dropdown-item"><i class="icon-search4"></i> Show</a>`
								@if (\Auth::user()->role==1 )
											actionsButton += `<a href="${editRef}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>`
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