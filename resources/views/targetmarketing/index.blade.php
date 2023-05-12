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
				<h4><span class="font-weight-semibold">Home</span> - Data Target Marketing</h4>
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
                <a data-toggle="modal" data-target="#modal_theme_create">
                    <button type="button" class="btn btn-success rounded-round">
                        <i class="icon-add mr-2"></i> Tambah
                    </button>
                </a>
            @endif
		</div>
        
		<div class="card">

			<table class="table datatable-basic table-hover">
				<thead>
					<tr>
						<th rowspan="2">No</th>
						<th rowspan="2">Marketing</th>
						<th rowspan="2">Periode</th>
						<th colspan="2" class="text-center bg-warning">Leads</th>
						<th colspan="2" class="text-center bg-primary">Deals</th>
						<th colspan="2" class="text-center bg-success">Nominal</th>
					</tr>
					<tr>
						<th>Target</th>
						<th>Actual</th>
						<th>Target</th>
						<th>Actual</th>
						<th>Target</th>
						<th>Actual</th>
					</tr>
				</thead>
				<tbody>
				
				</tbody>
			</table>
		</div>
		<!-- /hover rows -->

	</div>
	<!-- /content area -->

    <!-- Tambah modal -->
	<div id="modal_theme_create" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-success" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="{{ route('targetmarketing.store')}}" method="post" id="tambahform">
				    @csrf
					<div class="modal-body">
						<div class="form-group">
							<label>Marketing</label>
							<select id="marketing_id" name="marketing_id" class="form-control-select2 select-icons" data-fouc>
								@foreach($marketings as $marketing)
									<option value="{{ $marketing->id }}">{{ $marketing->nama }}</option>
								@endforeach
							</select>
						</div>

						<div class="row" >
							<div class="form-group col-6" >
								<label>Dari Bulan</label>
								<select name="bulan_dari" class="form-control-select2 select-icons" data-fouc>
									@foreach(config('custom.bulan') as $key => $value)
										<option value="{{ $key }}">{{ $value }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-6" >
								<label>Tahun</label>
								<input type="number" name="tahun_dari" class="form-control border-teal border-1" placeholder="2022" required>
							</div>
						</div>

						<div class="row" >
							<div class="form-group col-6" >
								<label>Sampai Bulan</label>
								<select name="bulan_sampai" class="form-control-select2 select-icons" data-fouc>
									@foreach(config('custom.bulan') as $key => $value)
										<option value="{{ $key }}">{{ $value }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-6" >
								<label>Tahun</label>
								<input type="number" name="tahun_sampai" class="form-control border-teal border-1" placeholder="2022" required>
							</div>
						</div>

						<div class="form-group" >
							<label>Target Leads</label>
							<input type="text" id="target_leads" name="target_leads" class="form-control border-teal border-1" oninput="formatAngka(this)" placeholder="0" required>
						</div>

						<div class="form-group" >
							<label>Target Deals</label>
							<input type="text" id="target_deal" name="target_deal" class="form-control border-teal border-1" oninput="formatAngka(this)" placeholder="0" required>
						</div>

						<div class="form-group" >
							<label>Target Nominal</label>
							<input type="text" id="target_nominal" name="target_nominal" class="form-control border-teal border-1" oninput="formatAngka(this)" placeholder="0" required>
						</div>

					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn bg-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

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

		    // Basic Datatable examples
		    var _componentDatatableBasic = function() {
		        if (!$().DataTable) {
		            console.warn('Warning - datatables.min.js is not loaded.');
		            return;
		        }

		        // Setting datatable defaults
		        $.extend( $.fn.dataTable.defaults, {
		            autoWidth: false,
					order: [[2, 'asc']],
		            columnDefs: [{ 
		                orderable: false,
		                width: 100,
		                // targets: [ 0 ]
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
					ajax: "/targetmarketingdatatable",
					columns: [
                        {data:'DT_RowIndex', name:'no'},
						{data:null, name:'marketing.nama', render: function( data, type, row ){
                            return `${data.marketing.nama}`;
                        }},
						{data:null, name:'periode', render: function( data, type, row ){
                            return `${data.periode}`;
                        }},
						{data:null, name:'target_leads', render: function( data, type, row ){
                            return `${data.target_leads}`;
                        }},
						{data:null, name:'actual_lead', render: function( data, type, row ){
                            return `<span class='font-weight-semibold'>${data.actual_lead}</span>`;
                        }},
						{data:null, name:'target_deal', render: function( data, type, row ){
                            return `${data.target_deal}`;
                        }},
						{data:null, name:'target_deal', render: function( data, type, row ){
                            return `<span class='font-weight-semibold'>${data.actual_deal}</span>`;
                        }},
						{data:null, name:'target_nominal', render: function( data, type, row ){
                            var nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.target_nominal)
                            return `${nominal}`;
                        }},
						{data:null, name:'actual_nominal', render: function( data, type, row ){
                            var actual_nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.actual_nominal)
                            return `<span class='font-weight-semibold'>${actual_nominal}</span>`;
                        }}
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

		//JS Angka
		function formatAngka(element){
			console.log(element)
			let element_value = $(element).val()
			let start = element_value.slice(0,1)
			let check_negative_symbol = element_value.indexOf('-', 1)
			if (check_negative_symbol > -1) {
				$(element).val(start+element_value.slice(1, element_value.length).replace('-','').replace('-',''))
			}

			$(element).val(function(index, value) {
				return value
				.replace(/[^0-9-]/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
				;
			});
		}
		$( document ).ready(function() {

			$('.form-control-select2').select2();

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