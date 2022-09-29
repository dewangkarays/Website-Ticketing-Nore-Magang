@extends('layout')

@section('css')
<style type="text/css">
	.datatable-column-width{
		overflow: hidden; text-overflow: ellipsis; max-width: 100px;
	}
	.datatable-column-width-large{
		overflow: hidden; text-overflow: ellipsis; width: 150px;
	}
</style>
@endsection

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><span class="font-weight-semibold">Home</span> - Data Pembayaran</h4>
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
			<a href="{{ route('payments.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
			@if (Auth::user()->role==1)
			<a href={{ url('export_excel')}} target="_blank"><button class="btn btn-success rounded-round"><i class="icon-file-excel mr-2"></i> Export Excel</button></a>
			@endif

		</div>

		<table class="table datatable-basic table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Nama Proyek</th>
					<th>No. Receipt</th>
					<th>Nominal (Rp)</th>
					<th>Status</th>
					<th>Keterangan</th>
					<th>Tanggal Pembayaran</th>
					@if(\Auth::user()->role<=50)
					<th class="text-center">Actions</th>
					@endif
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	<!-- /hover rows -->

</div>

<div id="modal_terima" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-success" align="center">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div  class="modal-body" align="center">
				<input class="form-control" type="hidden" name="payment_id" id="payment_id" value=""/>
				<input class="form-control" type="hidden" name="payment_status" id="payment_status" value=""/>

				<h2>Terima Pembayaran?</h2>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
				<button type="button" id="btn-terima" class="btn btn-success">Ya, terima pembayaran</button>
			</div>
		</div>
	</div>
</div>

<div id="modal_tolak" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-danger" align="center">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div  class="modal-body" align="center">
				<input class="form-control" type="hidden" name="payment_id2" id="payment_id2" value=""/>
				<input class="form-control" type="hidden" name="payment_status2" id="payment_status2" value=""/>
				<input class="form-control" type="hidden" name="payment_nominal" id="payment_nominal" value=""/>
				<h2>Tolak pembayaran?</h2>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
				<button type="button" id="btn-tolak" class="btn btn-danger">Ya, Tolak pembayaran</button>
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
<script src="{{ URL::asset('global_assets/js/plugins/notifications/bootbox.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/buttons/spin.min.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/plugins/buttons/ladda.min.js') }}"></script>

<script src="{{ URL::asset('assets/js/app.js') }}"></script>
<script src="{{ URL::asset('global_assets/js/demo_pages/components_modals.js') }}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
	let getToken = function() {
		return $('meta[name=csrf-token]').attr('content')
	}
	// modal terima
	$(document).on("click", ".open-modal-accept", function () {
		var id_payment = $(this).data('id');
		var status_payment = 1;
		$(".modal-body #payment_id").val( id_payment );
		$(".modal-body #payment_status").val( status_payment );

		// As pointed out in comments,
		// it is unnecessary to have to manually call the modal.
		// $('#addBookDialog').modal('show');
	});

	// modal tolak
	$(document).on("click", ".open-modal-reject", function () {
		var id_payment2 = $(this).data('id');
		var status_payment2 = 2;
		var nominal_payment = $(this).data('payment');
		$(".modal-body #payment_id2").val( id_payment2 );
		$(".modal-body #payment_status2").val( status_payment2 );
		$(".modal-body #payment_nominal").val( nominal_payment );
		// As pointed out in comments,
		// it is unnecessary to have to manually call the modal.
		// $('#addBookDialog').modal('show');
	});

	//modal delete
	$(document).on("click", ".delbutton", function () {
		var url = $(this).data('uri');
		$("#delform").attr("action", url);
	});

	$("#btn-terima").click(function(){
		var token = getToken();
		var id = $('#payment_id').val();
		var status = $('#payment_status').val();
		var payment = $('#payment_nominal').val();
		// var status = 3;

		$.ajax({
			type: "POST",
			url: '/terimapayment',
			// 'url': '/updatestatus',
			// 'method': 'POST',
			data: {'status': status, 'id': id, 'payment': payment, _token : token },
			success: function(data){
				// Sticky buttons
				// alert('Data changed!')

				location.reload();
			}
		});
	});

	$("#btn-tolak").click(function(){
		var token = getToken();
		var id = $('#payment_id2').val();
		var status = $('#payment_status2').val();
		// var status = 3;

		$.ajax({
			type: "POST",
			url: '/tolakpayment',
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


	var DatatableBasic = function() {

		const payment = {
			'0': 'Belum Dikonfirmasi',
			'1': 'Sudah Dikonfirmasi',
			'2': 'Ditolak',
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
			$('.datatable-basic').DataTable({
				scrollX: true,
				processing: true,
				serverSide: true,
				ajax: {
					'type': 'GET',
					'url': `{{url('getpayments')}}`,
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
						data: null,
						name: null,
						render: (data, type, row) => {
							return stripHtml(data?.nama_proyek);
						}
					},
					{
						data: 'receipt_no',
						name: 'receipt_no',
					},
					{
						data: null,
						name: null,
						render: (data, type, row) => {
							return number_format(data?.nominal, 0, '.', '.');
						}
					},
					{
						data: null,
						name: null,
						render: (data, type, row) => {
							let paymentStyle = '';

							if(data?.status == 0 )
								paymentStyle = `<span style="font-size:100%;" class="badge badge-pill bg-orange-400 ml-auto ml-md-0">${payment[data?.status]}</span>`
							else if(data?.status == 1)
								paymentStyle = `<span style="font-size:100%;" class="badge badge-pill bg-success-400 ml-auto ml-md-0">${payment[data?.status]}</span>`
							else
								paymentStyle = `<span style="font-size:100%;" class="badge badge-pill bg-danger-400 ml-auto ml-md-0">${payment[data?.status]}</span>`

							return paymentStyle;
						}
					},
					{
						data: null,
						name: 'keterangan',
						render: (data, type, row) => {
							return stripHtml(data?.keterangan);
							}
					},
					{
						data: 'tanggal',
						name: 'tanggal',
					},
					{
						data: null,
						name: null,
						render: (data, type, row) => {
							let id = data?.id;
							console.log(id)
							let paymentData = data?.nominal;
							let telpRef = data?.telp;
							let showRef = "{{route('payments.show', ':id')}}";
                            showRef = showRef.replace(':id', id);
							let editRef = "{{route('payments.edit', ':id')}}";
							editRef = editRef.replace(':id', id);
							let printRef = "{{route('cetak', ':id')}}";
							printRef = printRef.replace(':id', id);
							let delUri = "{{ route('payments.destroy', ':id')}}";
							delUri = delUri.replace(':id', id);

							let actionButtons = `
								<div class="dropdown">
									<a href="#" class="list-icons-item" data-toggle="dropdown">
										<i class="icon-menu9"></i>
									</a>

									<div class="dropdown-menu dropdown-menu-right">`
										
								@if(Auth::user()->role<=50)
									if (data?.status == 0) {
										actionButtons += `<a href="${showRef}" class="dropdown-item"><i class="icon-search4"></i> Show</a>`
										// actionButtons +=
										// 	`<button type="button" class="btn dropdown-item bg-success open-modal-accept" id="statusbtn" data-id="${id}" data-toggle="modal" data-target="#modal_terima"><i class="icon-checkmark-circle"></i> Terima</button>
										// 	<button type="button" class="btn dropdown-item bg-danger open-modal-reject" id="statusbtn" data-id="${id}" data-payment="${paymentData}" data-toggle="modal" data-target="#modal_tolak"><i class="icon-cancel-circle2"></i> Tolak</button>`
									}
								@endif
								@if(Auth::user()->role<=50)
										actionButtons += `<a href="https://wa.me/${telpRef}" target="_blank" class="dropdown-item"><i class="fab fa-whatsapp"></i> Kontak User</a>`
								@endif
								@if(Auth::user()->role==1)
									actionButtons += `<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"><i class="icon-x"></i> Delete</a>`
								@endif
									actionButtons +=
												`</div>
											</div>
										`;

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
