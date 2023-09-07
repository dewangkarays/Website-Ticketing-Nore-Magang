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
            <h4><span class="font-weight-semibold">List Lampiran - {{$rekap->invoice}} </h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
            <div class="d-flex">
                <a href="{{route('cetakrekap', $rekap->id)}}" target="blank"><button type="button" class="btn btn-success rounded-round"><i class="icon-printer2 mr-2"></i>Print</button></a>
            </div>
        </div>
    </div>
    <!-- /page header -->
    
    <!-- Content area -->
    <div class="content">

        <div class="card">
            <div class="card-head">
                <div class="card-header">
                    <h3>Upload Lampiran</h3>
                </div>
            </div>
            <form class="form-validate-jquery" action="{{url('/rekaptagihan/lampiran/'.$rekap->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Jenis Lampiran</label>
                        <div class="col-lg-10">
                            <select id="jenis_lampiran" name="jenis_lampiran" class="form-control select-search" required>
                                <option value="">-- Jenis Lampiran --</option>
                                @foreach(config('custom.jenis_lampiran') as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="div-judul" class="form-group row" style="display: none">
                        <label class="col-form-label col-lg-2">Judul</label>
                        <div class="col-lg-10">
                            <input id="judul" name="judul" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Gambar</label>
                        <div class="col-lg-10">
                            <input id="gambar" name="gambar" type="file" class="form-control" onchange="upload_check()" required>
                            <span class="form-text text-muted">Jumlah max ukuran file : 5MB</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Keterangan<p><i class="text-muted">Opsional</i></p></label>
                        <div class="col-lg-10">
                            <input id="keterangan" name="keterangan" type="text" class="form-control">
                        </div>
                    </div>
                     <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <a href="{{ url('/rekaptagihans') }}" class="btn bg-slate"><i class="icon-undo2 mr-2"></i>Kembali</a>
                        </div>
                        <div>
                            <button class="btn bg-success" type="submit"><i class="icon-paperplane mr-2"></i>Submit</button>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
        
        <!-- Hover rows -->
        <div class="card">
            
            
            <table class="table datatable-basic table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Jenis Lampiran</th>
                        <th class="text-center">Judul</th>
                        <th class="text-center">Gambar</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$lampirans == null)
                    @php ($i = 1)
                    @foreach($lampirans as $lampiran)
                    <tr> 
                        <td>{{$i}}</td>
                        <td align="center">
                            <div class="datatable-column-width">
                                {{ config('custom.jenis_lampiran.'.$lampiran->jenis_lampiran) }}
                            </div>
                        </td>
                        <td align="center">
                            <div class="datatable-column-width">
                                {{ $lampiran->judul }}
                            </div>
                        </td>
                        <td align="center">
                            <div class="card-img-actions m-1">
                                <img class="card-img img-fluid" src="{{url($lampiran->gambar)}}" alt="" style="height:150px;width:150px;object-fit: cover;">
                                <div class="card-img-actions-overlay card-img">
                                    <a href="{{url($lampiran->gambar)}}" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round" data-popup="lightbox" rel="group">
                                        <i class="icon-zoomin3"></i>
                                    </a>
                                </div>
                            </div></td>
                        </td>
                        <td align="center">{{$lampiran->keterangan}}</td>
                        <td align="center">
                            <button class="btn btn-danger btn-lg delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="{{url('/rekaptagihan/lampirandestroy/'. $lampiran->id,$rekap->id)}}"><i class="icon-x"></i> Delete</button>
                        </td>
                    </tr>
                    @php ($i++)
                    @endforeach
                    @else
                    <tr><td align="center" colspan="7">Data Kosong</td></tr>
                    @endif 
                    
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
                    <div class="modal-body" align="center">
                        <h2> Hapus Data? </h2>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn bg-success-400" data-dismiss="modal">Batal</button>
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
    <script src="{{asset('global_assets/js/plugins/media/fancybox.min.js')}}"></script>
    
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/components_modals.js')}}"></script>
    <script type="text/javascript">
        // Initialize
		$('.select-search').select2();

		// Initialize
		var $select = $('.form-control-select2').select2({
			minimumResultsForSearch: Infinity
		});
        //max file size
        function upload_check()
    {
        var upl = document.getElementById("gambar");
        var maxAllowedSize = 5 * 1024 * 1024; //5mb

        if(upl.files[0].size > maxAllowedSize)
        {
        alert("Ukuran File Terlalu Besar!");
        upl.value = "";
        }
    };
    </script>
    <script>
            //validate file extension

        var upl = document.getElementById("gambar");
        $("#gambar").change(function () {
       var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'svg', 'pdf'];
       if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
           alert("Only formats are allowed : "+fileExtension.join(', '));
        upl.value = "";
       }
   });
   </script>
    <script>
        //modal delete
        $(document).on("click", ".delbutton", function () {
            var url = $(this).data('uri');
            $("#delform").attr("action", url);
        });
        
        // Lightbox
        var _componentFancybox = function() {
            if (!$().fancybox) {
                console.warn('Warning - fancybox.min.js is not loaded.');
                return;
            }
            
            // Image lightbox
            $('[data-popup="lightbox"]').fancybox({
                padding: 3
            });
        };

            // Menampilkan field judul
        $('#jenis_lampiran').on('change', function() {
            var dropdown = $('#jenis_lampiran option:selected').val()
            if (dropdown=="1" ) {
                $('#div-judul').show()
			} else {
				$('#div-judul').hide()
			}
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
                        targets: [ 1, 2, 3, 4 ]
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