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
	.picker {
		top:auto;
	}
	hr{
		margin: 0rem;
	}
</style>
@endsection

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Data Leads</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>

	<div class="content">

	<!-- /page header -->
	@if (Auth::user()->role==1 || Auth::user()->role==20)
	<div class="card">
		<div class="card-body">
			<div class="row justify-content-between">
				<div class="col">
					<select style="width:200px; height:36px" onchange="potensi()" id="potensi" name="potensi" 
					class="form-control select-search" data-user_id="0" required>
						<option value="">-- Potensi --</option>
						@foreach (config('custom.jenis_proyek') as $key => $value)
							<option value="{{ $key }}">{{ $value }}</option>
						@endforeach
					</select>
				</div>
				<div class="col">
					<select style="width:200px; height:36px" onchange="source()" id="source" name="source" 
					class="form-control select-search" data-user_id="0" required>
						<option value="">-- Source --</option>
						@foreach (config('custom.source') as $key => $value)
							<option value="{{ $key }}">{{ $value }}</option>
						@endforeach
					</select>
				</div>
				<div class="col">
					<select style="width:200px; height:36px" onchange="leads()" id="leads" name="leads" 
					class="form-control select-search" data-user_id="0" required>
						<option value="">-- Status Lead --</option>
						@foreach (config('custom.status_klien') as $key => $value)
							<option value="{{ $key }}">{{ $value }}</option>
						@endforeach
					</select>
				</div>
				<div class="col">
					<select style="width:200px; height:36px" onchange="marketing()" id="marketing_id" name="marketing_id" class="form-control select-search" data-user_id="0" required>
						<option value="">-- Pilih Marketing --</option>
						@foreach($marketings as $marketing)
							<option value="{{$marketing->id}}">{{$marketing->nama}} </option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
		@elseif (Auth::user()->role==50)
		<div class="card">
		<div class="card-body">
				<div class="row">
					<div class="col">
						<select style="width:200px; height:36px" onchange="potensi()" id="potensi" name="potensi" 
						class="form-control select-search" data-user_id="0" required>
							<option value="">-- Potensi --</option>
							@foreach (config('custom.jenis_proyek') as $key => $value)
								<option value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
					<div class="col">
						<select style="width:200px; height:36px" onchange="source()" id="source" name="source" 
						class="form-control select-search" data-user_id="0" required>
							<option value="">-- Source --</option>
							@foreach (config('custom.source') as $key => $value)
								<option value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
					<div class="col">
						<select style="width:200px; height:36px" onchange="leads()" id="leads" name="leads" 
						class="form-control select-search" data-user_id="0" required>
							<option value="">-- Status Lead --</option>
							@foreach (config('custom.status_klien') as $key => $value)
								<option value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
@endif

	<!-- Content area -->
	
		<!-- Hover rows -->
		<div class="card">
			<div class="card-header header-elements-inline">
				@if (Auth::user()->role==1 || Auth::user()->role==20 || Auth::user()->role==50)
				<a href="{{ route('klien.create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-add mr-2"></i> Tambah</button></a>
				<a href={{ url('leads_excel')}} target="_blank"><button class="btn btn-success rounded-round"><i class="icon-file-excel mr-2"></i> Export Excel</button></a>
				@endif
			</div>
			<hr>
			<div class="card-body">
				<div class="row">
					<div class="col text-center">
						<span class="font-weight-semibold" style="font-size: 15px">
							Total Leads
						</span>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-1 offset-1 text-center">
						<span class="font-weight-semibold" style="font-size: 100%" id="status-1">
							Visit: {{$totalPerStatus['1'] ?? 0 }}
						</span>
					</div>
					<div class="col-md-1 text-center">
						<span class="font-weight-semibold" style="font-size: 100%" id="status-2">
							Kenal:{{$totalPerStatus['2'] ?? 0 }} 
						</span>
					</div>
					<div class="col-md-2 text-center">
						<span class="font-weight-semibold" style="font-size: 100%" id="status-3">
							Negosiasi:{{$totalPerStatus['3'] ?? 0 }} 
						</span>
					</div>
					<div class="col-md-1 text-center">
						<span class="font-weight-semibold" style="font-size: 100%" id="status-4">
							Deal:{{$totalPerStatus['4'] ?? 0 }} 
						</span>
					</div>
					<div class="col-md-2 text-center">
						<span class="font-weight-semibold" style="font-size: 100%" id="status-5">
							Pending:{{$totalPerStatus['5'] ?? 0 }} 
						</span>
					</div>
					<div class="col-md-1 text-center">
						<span class="font-weight-semibold" style="font-size: 100%" id="status-6">
							Bayar:{{$totalPerStatus['6'] ?? 0 }} 
						</span>
					</div>
					<div class="col-md-1 text-center">
						<span class="font-weight-semibold" style="font-size: 100%" id="status-7">
							Ended:{{$totalPerStatus['7'] ?? 0 }} 
						</span>
					</div>
					<div class="col-md-1 text-center">
						<span class="font-weight-semibold" style="font-size: 100%" id="status-8">
							Live:{{$totalPerStatus['8'] ?? 0 }} 
						</span>
					</div>
				</div>
				<hr>
					<table class="table datatable-basic table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Calon Klien</th>
								<th>Nama Perusahaan</th>
								{{-- <th>Jenis Perusahaan</th> --}}
								<th>Potensi</th>
								<th>Status Lead</th>
								<th>Source</th>
								{{-- <th>Alamat</th> --}}
								<th>Marketing</th>
								<th>Tanggal kontak terakhir</th>
								<th>Tanggal awal</th>
								{{-- <th>Keterangan</th> --}}
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>	
			</div>
			
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
	 
	 <!-- History modal -->
	 <div id="modal_theme_history" class="modal fade" tabindex="-1">
		{{-- <div class="modal-fade" id="myModal"> --}}
		<div class="modal-dialog">
			<div class="modal-content">

				{{-- Modal Header --}}
				<div class="modal-header bg-warning" align="center">
					<h4><span>History Status</span></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="historyform">
				    @csrf
					@method('PUT')

				{{-- Modal Body --}}
					<div class="modal-body">
						<table class="table" id="tableData">
							<thead>
							<tr>
								<th>Tanggal</th>
								<th>Status Lead</th>
								<th>Keterangan</th>
							</tr>
							</thead>
							<tbody id="dataProyek">
							</tbody>
						</table>
						
					</div>
					<hr>
					<div class="modal-body">
						 <div class="mb-3">
							<label class="col-form-label col-lg-2">Tanggal</label>
							<input type="date" name="updated_at" class="form-control border-teal pickadate-accessibility" value="{{date('Y-m-d')}}" required>
						</div>
						 <div class="mb-3">
							<label class="col-form-label col-lg-2">Status Lead</label>
							<select id="status" name="status" class="form-control select-search" required>
									<option value="">-- Lead --</option>
								@foreach (config('custom.status_klien') as $key => $value)
									<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
						</div>
						<div class="mb-3">
							<label class="col-form-label col-lg-2">Keterangan</label>
							<input type="text" name="keterangan_lain" class="form-control border-teal border-1"> 
						</div> 
					</div>

				{{-- Modal Footer --}}
					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn bg-success">Save</button>
					</div>
				</form>
			</div>
			</div>
		{{-- </div> --}}
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
	<script src="{{asset('global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/anytime.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>

	<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/utc.js"></script>
	<script>dayjs.extend(window.dayjs_plugin_utc)</script>

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/components_modals.js')}}"></script>
	<script src="{{asset('assets/js/custom.js')}}"></script>
	<script>

		$('.select-search').select2();

		//modal delete
		$(document).on("click", ".delbutton", function () {
		     var url = $(this).data('uri');
		     $("#delform").attr("action", url);
			
			});

		//modal history	
		$(document).on("click", ".historybutton", function () {
		     var url = $(this).data('uri');
		     var ref = $(this).data('id');
			 var token= '{{ csrf_token() }}';
				$.ajax({
					type :'GET',
					url  :'{{route("getdatahistory",[null])}}/'+ref,
					headers  :{
					'X-CSRF-TOKEN' : token
					},
					dataType :'json',
					success  : function(data){
						// console.log(data);
						// $('#myModal').modal('show');
						var dataproyek = '';
						$('.tabledata').DataTable();
						$('#dataProyek').html("");
		
                        // ITERATING THROUGH OBJECTS
                        $.each(data, function (key, value) {
                             var no = key+1;
                            //CONSTRUCTION OF ROWS HAVING
                            // DATA FROM JSON OBJECT
                            dataproyek += '<tr>';
                           	
								dataproyek += '<td>' + 
                                dayjs(value.created_at).format('YYYY-MM-DD') + '</td>';
								
								let textStatus;
								switch(value.status){
									case 1:
										textStatus='Visit';
										break;
									case 2:
										textStatus='Kenal';
										break;
									case 3:
										textStatus='Negosiasi';
										break;
									case 4:
										textStatus='Deal';
										break;
									case 5:
										textStatus='Pending';
										break;
									case 6:
										textStatus='Bayar';
										break;
									case 7:
										textStatus='Ended';
										break;
									case 8:
										textStatus='Live';
										break;
									default:
										textStatus='';
								}
								dataproyek += '<td>' + 
                                textStatus  + '</td>';
  
								dataproyek += '<td>' + 
                                (value.keterangan ? value.keterangan : "-") + '</td>';
								dataproyek += '</tr>';
                        });
                          
                        //INSERTING ROWS INTO TABLE 
                        $('#dataProyek').append(dataproyek);
						$('.tabledata').DataTable();
					
					},
					error:function(){
						alert('eror');
					}
				});
		     $("#historyform").attr("action", url);
			
			});

		var DatatableBasic = function() {

			const status_klien = {
				'1' : 'Visit',
				'2' : 'Kenal',
				'3' : 'Negosiasi',
				'4' : 'Deal',
				'5' : 'Pending',
				'6' : 'Bayar',
				'7' : 'Ended',
				'8' : 'Live',
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
                        "data"  : {
                            "_token" : "{{ csrf_token() }}",
							"marketing" : $('#marketing_id').val(),
							"source" 	: $('#source').val(),
							"leads" 	: $('#leads').val(),
							"potensi" 	: $('#potensi').val(),
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
										'7': 'Hotely',
										'5': 'Custom/Lainnya',
															
									}
								return potensi[data?.potensi] || '';
							}
						},
                        {
							data: null,
							name: null,
							render: (data, type, row) => {
								let status= ''
								if (data?.status == 1)
									status = `<span style="font-size: 100%;" class="badge badge-pill badge-info">${status_klien[data?.status]}</span>`
								else if (data?.status == 2)
									status = `<span style="font-size: 100%;" class="badge bg-warning badge-pill badge-warning">${status_klien[data?.status]}</span>`
								else if (data?.status == 3)
									status = `<span style="font-size: 100%;" class="badge bg-orange badge-pill badge-orange">${status_klien[data?.status]}</span>`
								else if (data?.status == 4)
									status = `<span style="font-size: 100%;" class="badge badge-pill badge-primary">${status_klien[data?.status]}</span>`
								else if (data?.status == 5)
									status = `<span style="font-size: 100%;" class="badge badge-pill badge-secondary">${status_klien[data?.status]}</span>`
								else if (data?.status == 6)
									status = `<span style="font-size: 100%;" class="badge badge-pill badge-success">${status_klien[data?.status]}</span>`
								else if (data?.status == 7)
									status = `<span style="font-size: 100%;" class="badge badge-pill badge-dark">${status_klien[data?.status]}</span>`
								else if (data?.status == 8)
									status = `<span style="font-size: 100%;" class="badge bg-teal badge-pill badge-teal">${status_klien[data?.status]}</span>`
								else
									status = `<span style="font-size: 100%;" class="badge badge-pill badge-danger">${status_klien[data?.status]}</span>`
								
								return status
							}
						},
						{
							data: null,
							name: 'source',
							render: (data, type, row) => {
								const source = {
                                    '1' : 'Social Media',
									'2' : 'Google',
									'3' : 'Iklan',
									'4' : 'Walkin',
									'5' : 'Repeat/Teman Klien',
									'6' : 'Relasi',
									'7' : 'Referral',
									'8' : 'Visit',
								}
								return source[data?.source] || '';
							}
						},
                        // {
						// 	data: 'alamat',
						// 	name: 'alamat',
						// },
						{
							data: null,
							name: 'marketing_id',
							render: (data, type, row) => {
								return data?.marketing?.nama || '';
							}
						},
						{
							data: 'tanggal_kontakterakhir',
							name: 'tanggal_kontakterakhir',
						 	render: (data, type, row) => {
								if (type === 'display') {
								return data ? `<div style="text-align: center;">${data}</div>` : '<div style="text-align: center;">-</div>';
								}
								return data;
							}
						},
						{
							data: 'created_at',
							name: 'created_at',
							render: (data, type, row) => {
								if (type === 'display' && data !== null && data !== undefined) {
								const date = new Date(data);
								const year = date.getFullYear();
								const month = String(date.getMonth() + 1).padStart(2, '0');
								const day = String(date.getDate()).padStart(2, '0'); 
								return `${year}-${month}-${day}`;
								}
								return data;
							}
						},
						// {
                        // data: null,
                        // name: "keterangan_lain",
                        // render: (data, type, row) => {
                        //     return data?.keterangan_lain ? stripHtml(data?.keterangan_lain) : '-'
                        // }
                    	// },
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

								let HistoryRef = "{{route('klien.KlienHistory', ':id')}}";
								HistoryRef = HistoryRef.replace(':id', data?.id);

								let createRef = "{{route('klien.createMember', ':id')}}";
								createRef = createRef.replace(':id', data?.id);
								
									
								@if(\Auth::user()->role==1 || Auth::user()->role==20|| \Auth::user()->role==50) 
									if (data.status == 4 && data.member_created == 0) {
									
										var actionButtons =
									`
										<div style="text-align: right">
												<a href="${createRef}" class="btn btn-dark btn-icon" data-toggle="tooltip" data-placement="top" title="Create Member"><i class="icon-file-text"></i></a>

												<a href="#" class="btn bg-orange-600 historybutton btn-icon" data-id="${data?.id}" data-toggle="modal" data-target="#modal_theme_history" data-uri="${HistoryRef}" data-toggle="tooltip" data-placement="top" title="History"><i class="icon-history"></i></a>

												<a href="${showRef}" class="btn bg-blue btn-icon showbutton btn-icon" data-toggle="tooltip" data-placement="top" title="Show"><i class="icon-search4"></i></a>

												<a href="${editRef}" class="btn bg-purple btn-icon" data-toggle="tooltip" data-placement="top" title="Edit"><i class="icon-pencil7"></i></a>

												<a href="${telpRef}" target="_blank" class="btn bg-success btn-icon" data-toggle="tooltip" data-placement="top" title="Telp"><i class="fab fa-whatsapp"></i></a>
												
												<a href="#" class="btn btn-danger btn-icon delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"data-toggle="tooltip" data-placement="top" title="Delete"><i class="icon-bin"></i></a>
												
										</div>
									`
								} else { 
										var actionButtons =
									
										`
										<div style="text-align: right">
												<a href="#" class="btn bg-orange-600 historybutton btn-icon" data-id="${data?.id}" data-toggle="modal" data-target="#modal_theme_history" data-uri="${HistoryRef}" data-toggle="tooltip" data-placement="top" title="History"><i class="icon-history"></i></a>

												<a href="${showRef}" class="btn bg-blue btn-icon showbutton btn-icon" data-toggle="tooltip" data-placement="top" title="Show"><i class="icon-search4"></i></a>

												<a href="${editRef}" class="btn bg-purple btn-icon" data-toggle="tooltip" data-placement="top" title="Edit"><i class="icon-pencil7"></i></a>

												<a href="${telpRef}" target="_blank" class="btn bg-success btn-icon" data-toggle="tooltip" data-placement="top" title="Telp"><i class="fab fa-whatsapp"></i></a>
												
												<a href="#" class="btn btn-danger btn-icon delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="${delUri}"data-toggle="tooltip" data-placement="top" title="Delete"><i class="icon-bin"></i></a>
												
											
											</div>	
												
												
												
										`
									}
										
									@else
									var actionButtons =
									`
									
											<a href="${showRef}" class="list-icons-item text-blue"><i class="icon-search4"></i></a>
											
											<a href="${telpRef}" target="_blank" class="list-icons-item text-green"><i class="fab fa-whatsapp"></i></a>
												
												
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

				var $select = $('.select-search').select2();

		        // Initialize
		        $('.dataTables_length select').select2({
		            minimumResultsForSearch: Infinity,
		            dropdownAutoWidth: true,
		            width: 'auto'
		        });

				 // Accessibility labels
				 $('.pickadate-accessibility').pickadate({
					labelMonthNext: 'Go to the next month',
					labelMonthPrev: 'Go to the previous month',
					labelMonthSelect: 'Pick a month from the dropdown',
					labelYearSelect: 'Pick a year from the dropdown',
					selectMonths: true,
					selectYears: true,
					format: 'yyyy-mm-dd',
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

		function potensi(){
        $('.datatable-basic').DataTable().destroy();
        DatatableBasic.init();
        
        // alert('Halodek')
    }
		function source(){
			$('.datatable-basic').DataTable().destroy();
			DatatableBasic.init();
			
		// alert('Halodek')
    }
		function leads(){
			$('.datatable-basic').DataTable().destroy();
			DatatableBasic.init();
			
		// alert('Halodek')
    }
		function marketing(){
			$('.datatable-basic').DataTable().destroy();
			DatatableBasic.init();
				
			// alert('Halodek')
    }
	
		 function updateStatistics() {
			var selectedMarketingId = $('#marketing_id').val();
			var statusNames = {
				'1': 'Visit',
				'2': 'Kenal',
				'3': 'Negosiasi',
				'4': 'Deal',
				'5': 'Pending',
				'6': 'Bayar',
				'7': 'Ended',
				'8': 'Live'
			};

			$.ajax({
				url: '/get-statistics', 
				type: 'GET',
				data: { marketing_id: selectedMarketingId },
				success: function(data) {
					console.log(data);
					
					// Reset counts for all statuses to 0
					var counts = {};
					for (var statusId in statusNames) {
						counts[statusId] = 0;
					}
					
					// Update counts based on data received
					for (var statusId in data) {
						counts[statusId] = data[statusId][selectedMarketingId] || 0;
					}
					
					// Update UI elements with counts
					for (var statusId in statusNames) {
						var count = counts[statusId];
						var statusName = statusNames[statusId];
						var selector = '#status-' + statusId;
						var element = $(selector);
						var newText = statusName + ': ' + count;
						element.text(newText);
					}
				}
			});
		}


		$('#marketing_id').on('change', function() {
			updateStatistics();
		});

		// Panggil updateStatistics saat halaman dimuat
		$(document).ready(function() {
			updateStatistics();
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