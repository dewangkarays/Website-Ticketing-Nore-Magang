@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Detail Pengajuan Cuti</h4>
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
				<form class="form-validate-jquery" action="{{ route('cuti.upload',$cuti->id)}}" method="post" enctype="multipart/form-data">
					@csrf
                    
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Detail Pengajuan Cuti</legend>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nama</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$cuti->karyawan->nama}}</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">NIP</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$cuti->karyawan->nip}}</label>
							</div>
						</div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tanggal Mulai</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$cuti->tanggal_mulai}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tanggal Berakhir</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$cuti->tanggal_akhir}}</label>
                            </div>
                        </div>
						@if ($cuti->karyawan->sisa_cuti - $cuti->jumlah_hari < 0)
						<div class="form-group row">
                            <label class="col-form-label col-lg-2"></label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10" style="color: red"><em>Pengajuan melewati batas jumlah hari cuti! {{$cuti->karyawan->sisa_cuti - $cuti->jumlah_hari}} hari</em></label>
                            </div>
                        </div>
						@endif
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Verifikator 2</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$cuti->verifikator_2}}</label>
							</div>
						</div>
                        @if (Auth::user()->role == 1 || Auth::id() == $cuti->verifikator2->id)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
							<div class="col-lg-10">
								<select name="status2" id="status2" class="form-control select-search" data-fouc>
									@foreach(config('custom.verifikasi_cuti') as $key => $value)
										<option value="{{$key}}" {{ $cuti->verifikasi_2 == $key ? 'selected' : '' }}>{{$value}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Catatan</label>
							<div class="col-lg-10">
								<textarea name="catatan2" id="catatan2-edit" rows="4" cols="3" class="form-control" placeholder="Catatan">{!! $cuti->catatan_ver_2 !!}</textarea>
							</div>
						</div>
						@else
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
							<div class="col-lg-10">
								<label class="col-form-label col-lg-10">{{config('custom.status_cuti.'.$cuti->verifikasi_2)}}</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Catatan</label>
							<div class="col-lg-10">
								<textarea name="catatan2" id="catatan2" rows="4" cols="3" class="form-control" placeholder="Catatan" disabled>{!! $cuti->catatan_ver_2 !!}</textarea>
							</div>
						</div>
						@endif
						@if ($cuti->verifikator1 != null)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Verifikator 1</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$cuti->verifikator_1}}</label>
							</div>
						</div>
						@if (Auth::user()->role == 1 || Auth::id() == $cuti->verifikator1->id  && $cuti->verifikasi_2 == 2)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
							<div class="col-lg-10">
								<select name="status1" id="status1" class="form-control select-search" data-fouc>
									@foreach(config('custom.verifikasi_cuti') as $key => $value)
										<option value="{{$key}}" {{ $cuti->verifikasi_1 == $key ? 'selected' : '' }}>{{$value}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Catatan</label>
							<div class="col-lg-10">
								<textarea name="catatan1" id="catatan1-edit" rows="4" cols="3" class="form-control" placeholder="Catatan">{!! $cuti->catatan_ver_1 !!}</textarea>
							</div>
						</div>
						@else
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
							<div class="col-lg-10">
								<label class="col-form-label col-lg-10">{{config('custom.status_cuti.'.$cuti->verifikasi_1)}}</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Catatan</label>
							<div class="col-lg-10">
								<textarea name="catatan1" id="catatan1" rows="4" cols="3" class="form-control" placeholder="Catatan" disabled>{!! $cuti->catatan_ver_1 !!}</textarea>
							</div>
						</div>
						@endif
						@endif
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Alasan</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$cuti->alasan}}</label>
							</div>
						</div>
						@if (Auth::user()->role == 1 || Auth::id() == $cuti->karyawan->id)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Surat Permohonan Cuti</label>
							<div class="col-lg-10">
								<input id="surat_cuti" name="surat_cuti" type="file" class="form-control">
							</div>
						</div>
						@endif
					</fieldset>
					<div class="text-right">
                        @if ($cuti->status == 4)
                            <a href="{{ route('cuti.history') }}" class="btn bg-slate">Kembali <i class="icon-undo2 ml-2"></i></a>
                        @else
                            <a href="{{ route('cuti') }}" class="btn bg-slate">Kembali <i class="icon-undo2 ml-2"></i></a>
                            <button type="submit" class="btn btn-success">Simpan <i class="icon-paperplane ml-2"></i></button>
                        @endif
					</div>
				</form>
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
    {{-- <script>
		$(() => {
			var catatan2 = $('#catatan2').val();
			var catatan2Edit = $('#catatan2-edit').val();
			var catatan1 = $('#catatan1').val();
			var catatan1Edit = $('#catatan1-edit').val();
			$('#catatan2').val(stripHtml(catatan2));
			$('#catatan2-edit').val(stripHtml(catatan2Edit));
			$('#catatan1').val(stripHtml(catatan1));
			$('#catatan1-edit').val(stripHtml(catatan1Edit));
		})
    </script> --}}
<script>
	@if (Auth::user()->role == 1)
	if($('#status2').val() != 2) {
		$('#status1').prop('disabled', true);
		$('#catatan1-edit').prop('disabled', true);
	}
	
	$('#status2').on('change', function() {
		if ($('#status2').val() != 2) {
			$('#status1').prop("disabled",true);
			$('#catatan1-edit').prop("disabled",true);
		} else {
			$('#status1').prop("disabled",false);
			$('#catatan1-edit').prop("disabled",false);
		}
	})
	@endif
</script>
@endsection