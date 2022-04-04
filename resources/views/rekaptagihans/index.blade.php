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
				<h4><span class="font-weight-semibold">Home</span> - Rekap Tagihan</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <!-- Hover rows -->
		<div id="card-rekap" class="card" style="display:none">
            <div class="card-header header-elements-inline">
				<a href="{{ route('rekaptagihans.create') }}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Tambah</button></a>
			</div>

            <div class="card-body">
                <form method="GET" action="{{ url('cetakrekap') }}">

                    <table class="table datatable-basic table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                {{-- <th><input type="checkbox" class="checked-all"></th> --}}
                                <th>Nama</th>
                                <th>Invoice</th>
                                <th>Nama Proyek</th>
                                <th>Tagihan</th>
                                <th>Keterangan</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!$tagihans->isEmpty())
                            @php ($i = 1)
                            @foreach($tagihans as $tagihan)
                            <tr>
                                <td>{{$i}}</td>
                                {{-- <td><input type="checkbox" name="invoice[]" id="chk" value="{{ $tagihan->id }}"></td> --}}
                                <td><div class="datatable-column-width">{{@$tagihan->user->nama}}</div></td>
                                <td><div class="datatable-column-width">{{$tagihan->invoice}}</div></td>
                                <td><div class="datatable-column-width">{{$tagihan->nama_proyek}}</div></td>
                                <td><div class="datatable-column-width">Rp @angka($tagihan->nominal)</div></td>
                                <td><div class="datatable-column-width">{{$tagihan->keterangan}}</div></td>
                                <td align="center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>
        
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('tagihans.edit',$tagihan->id)}}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
                                                <a href="{{url('/tagihans/cetak/'.$tagihan->id)}}" class="dropdown-item" target="_blank"><i class="icon-printer2"></i> Print</a>
                                                <a href="{{url('/tagihans/lampiran/'.$tagihan->id)}}" class="dropdown-item"><i class="icon-images3"></i> Lampiran</a>
                                                <a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="{{ route('tagihans.destroy', $tagihan->id)}}"><i class="icon-x"></i> Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php ($i++)
                            @endforeach
                        @else
                              <tr><td align="center" colspan="9">Data Kosong</td></tr>
                        @endif

                        </tbody>
                    </table>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Print <i class="icon-printer4 ml-2"></i></button>
                    </div>
                </form>
            </div>
		</div>
		<!-- /hover rows -->
    </div>
    <!-- Content Area -->
@endsection

@section('js')
	<!-- Theme JS files -->
	<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/components_modals.js')}}"></script>
    <script type="text/javascript">

        // Initialize
        $('.select-search').select2();

        // Initialize
        var $select = $('.form-control-select2').select2({
            minimumResultsForSearch: Infinity
        });

        // Trigger value change when selection is made
        $('#user_id').ready(function() {
            $(this).trigger('blur');
            var dropdown=$('#user_id option:selected').val()
            console.log(dropdown)
            if (dropdown!=0) {
                $('#card-rekap').show()
            } else {
                $('#card-rekap').hide()
            }
        });
    </script>
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
		                targets: [ 1,2,3,4,5,6 ]
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


		    //
		    // Return objects assigned to module
		    //

		    return {
		        init: function() {
		            _componentDatatableBasic();
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
        $('.checked-all').on('change', function(e){
            e.preventDefault()
            $('input[id=chk]').prop('checked', this.checked)
        });
    </script>

    <script type="text/javascript">
        $('#user_id').change(function(){
            let uri = $('#btn_submit').data('uri');
            let val = $(this).val();
            let href = `${uri}?c=${val}`;

            // $('#btn_submit').attr('href', href);

            // if($('#btn_submit').click(function (){
            //     $('#form-datatable').show();
            // }));
            // if($('#btn_reset').click(function (){
            //     $('#form-datatable').hide();
            // }));
        })
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
