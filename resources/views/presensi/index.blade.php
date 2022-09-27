@extends('layout')
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
				<a href="{{ route('presensi.create') }}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Ajukan</button></a>
			</div>

            <div class="card-body">

                    <table class="table datatable-basic table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                
                                {{-- <th class="text-center">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nore</td>
                                <td>20-12-2022</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
		</div>
		<!-- /hover rows -->
    </div>
    <!-- /content area -->

    <!-- Danger Modal -->
	{{-- <div id="modal_theme_danger" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="delform">
				    @csrf --}}
				    {{-- @method('DELETE') --}}
					{{-- <div class="modal-body" align="center">
						<h2> Hapus Data? </h2>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn bg-danger">Hapus</button>
					</div>
				</form>
			</div>
		</div>
	</div> --}}
	<!-- /danger modal -->
@endsection