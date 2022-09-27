@extends('layout')
@section('css')
    <style>
        table tbody {
            width: 100%;
        }
        .tanggal {
            width: 100px;
        }
    </style>
@endsection
@section('content')
     <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> -  Presensi</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <!-- Hover rows -->
		<div id="card-rekap" class="card">
            <div class="card-header header-elements-inline">
				<a href="{{ route('presensi.create') }}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Presensi</button></a>
			</div>

            <div class="card-body">

                    <table class="table datatable-basic table-hover" style="display: block;overflow-x: auto">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                @for($i=0;$i<count($dates);$i++)
                                <th class="tanggal">{{ $dates[$i] }}</th>
                                @endfor
                                
                                {{-- <th class="text-center">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nore</td>
                                @for($i=1;$i<=count($dates);$i++)
                                <th class="tanggal">{{ $i }}</th>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
            </div>
		</div>
		<!-- /hover rows -->
    </div>
    <!-- /content area -->

    <!-- Danger Modal -->
	<div id="modal_theme_danger" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="delform">
				    @csrf
				    {{-- @method('DELETE') --}}
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
	<!-- /danger modal -->
@endsection

@section('js')
    <script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/components_modals.js')}}"></script>
@endsection