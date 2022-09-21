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
								<select name="status2" class="form-control select-search" data-fouc>
									@foreach(config('custom.verifikasi_cuti') as $key => $value)
										<option value="{{$key}}" {{ $cuti->verifikasi_2 == $key ? 'selected' : '' }}>{{$value}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Catatan</label>
							<div class="col-lg-10">
								<textarea name="catatan2" rows="4" cols="3" class="form-control" placeholder="Catatan"></textarea>
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
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Verifikator 1</label>
							<div class="col-lg-10">
                                <label class="col-form-label col-lg-10">{{$cuti->verifikator_1}}</label>
							</div>
						</div>
						@if (Auth::user()->role == 1 || Auth::id() == $cuti->verifikator1->id)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
							<div class="col-lg-10">
								<select name="status1" class="form-control select-search" data-fouc>
									@foreach(config('custom.verifikasi_cuti') as $key => $value)
										<option value="{{$key}}" {{ $cuti->verifikasi_1 == $key ? 'selected' : '' }}>{{$value}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Catatan</label>
							<div class="col-lg-10">
								<textarea name="catatan1" rows="4" cols="3" class="form-control" placeholder="Catatan"></textarea>
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
								<input id="surat_cuti" name="surat_cuti" type="file" class="form-control" onchange="upload_check()">
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
    <script>
         $('.pickadate-accessibility').pickadate({
            labelMonthNext: 'Go to the next month',
            labelMonthPrev: 'Go to the previous month',
            labelMonthSelect: 'Pick a month from the dropdown',
            labelYearSelect: 'Pick a year from the dropdown',
            selectMonths: true,
            selectYears: true,
            format: 'yyyy-mm-dd',
        });
		$(() => {
			var catatan2 = $('#catatan2').val();
			var catatan1 = $('#catatan1').val();
			$('#catatan2').val(stripHtml(catatan2));
			$('#catatan1').val(stripHtml(catatan1));
		})
    </script>
    <script>
		// karyawan
        var atasan_user = $('#name').data('atasan_user');
		console.log(atasan_user);
        $.ajax({
            url : '{{ url("getverifikator") }}',
            type: 'get',
            dataType: 'json',
            success : function(verifs){
				var len = 0;
				len = verifs['data'].length;
				console.log(atasan_user);
				if (atasan_user != 0) {
                for(var i=0; i<len; i++){
                    if (atasan_user == verifs['data'][i].id){
					// var id = 3;
					var id = verifs['data'][i].id;
					var atasan_id = verifs['data'][i].atasan_id;
                    var nama = verifs['data'][i].nama;

					var option = "<option value='"+id+"' data-id2='"+atasan_id+"'>"+nama+"</option>";

					$("#verifikator_2").append(option);
					atasan_user = verifs['data'][i].atasan_id;
					}
                }
			} else {
				for(var i=0; i<len; i++){
					var id = verifs['data'][i].id;
					var atasan_id = verifs['data'][i].atasan_id;
                    var nama = verifs['data'][i].nama;

					var option = "<option value='"+id+"' data-id2='"+atasan_id+"'>"+nama+"</option>";

					$("#verifikator_2").append(option);
                }
			}
            }
        });
    </script>
    <script>
		$('#verifikator_2').on('change', function(){
		var atasan_user2 = $(this). children("option:selected").data('id2');
		// console.log(atasan_user2);

        $.ajax({
            url : '{{ url("getverifikator") }}',
            type: 'get',
            dataType: 'json',
            success : function(verifs2){
				$("#verifikator_1").empty();

				var test2 = "-- Pilih Verifikator --"
				var test = "<option value=''>"+test2+"</option>";

				$("#verifikator_1").append(test);
				var len2 = 0;
				len2 = verifs2['data'].length;
				
                for(var j=0; j<len2; j++){
                    if (atasan_user2 == verifs2['data'][j].id){
					var id2 = verifs2['data'][j].id;
					var atasan_id2 = verifs2['data'][j].atasan_id;
                    var nama2 = verifs2['data'][j].nama;

					var option2 = "<option value='"+id2+"' data-id1='"+atasan_id2+"'>"+nama2+"</option>";
					
					$("#verifikator_1").append(option2);
					atasan_user2 = verifs2['data'][j].atasan_id;
					}
                }
            }
        });
	});
    </script>

@endsection