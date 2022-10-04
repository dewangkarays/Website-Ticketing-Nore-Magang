@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Detail Presensi Harian</h4>
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
			</div>
			<div class="card-body">
				{{-- <form class="form-validate-jquery" action="#" method="post" enctype="multipart/form-data">
					@csrf --}}
                    
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Detail Presensi Harian</legend>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nama</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$presensi->karyawan->nama}}</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">NIP</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$presensi->karyawan->nip}}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Divisi</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{config('custom.role.'.$presensi->karyawan->role)}}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Jabatan</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$presensi->karyawan->jabatan}}</label>
							</div>
						</div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tanggal</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$presensi->tanggal}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Status</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{config('custom.status_presensi.'.$presensi->status)}}</label>
                            </div>
                        </div>
                        @if ($presensi->status != 1)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Keterangan</label>
							<div class="col-lg-10">
								<textarea name="keterangan" id="keterangan" rows="4" cols="3" class="form-control" readonly style="background-color: transparent; border:none">{!! $presensi->keterangan !!}</textarea>
							</div>
						</div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Bukti Ketidakhadiran</label>
                            <div class="col-lg-10">
                                <label class="col-form-label col-lg-10">
                                    @if ($presensi->bukti != null)
                                        <img src="{{url($presensi->bukti)}}" alt="Bukti Ketidakhadiran" class="img-fluid">
                                    @else
                                        <em>Not Found</em>
                                    @endif
                                </label>
                            </div>
                        </div>
                        @endif
				{{-- </form> --}}
			</div>

		</div>
		<!-- /hover rows -->

	</div>
	<!-- /content area -->
@endsection

@section('js')

{{-- <script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script> --}}
	<script src="{{asset('global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('assets/js/custom.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>

    <script src="{{asset('global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/anytime.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>
@endsection