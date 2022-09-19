@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Pengajuan Cuti</span></h4>
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
				<form class="form-validate-jquery" action="{{ route('cuti.update',$cuti->id)}}" method="post" enctype="multipart/form-data">
					@csrf
                    {{-- @foreach ($cutis as $cuti) --}}
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Form Pengajuan</legend>
						@if(\Auth::user()->role==1 || \Auth::user()->role==10 || \Auth::user()->role==20)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nama</label>
							<div class="col-lg-10">
								<input type="text" id="name" name="name" class="form-control border border-1" placeholder="Nama" value="{{ $cuti->karyawan->nama }}" data-atasan_user="{{ $cuti->karyawan->atasan_id }}" required readonly>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">NIP</label>
							<div class="col-lg-10">
								<input type="text" name="nip" class="form-control border border-1" value="{{ $cuti->karyawan->nip }}" placeholder="NIP" required readonly>
							</div>
						</div>
						@endif
                        {{-- @endforeach --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tanggal Mulai</label>
                            <div class="col-lg-10">
                                <input name="tanggal_mulai" type="text" class="form-control pickadate-accessibility" placeholder="Contoh: 2022-04-16" value="{{  $cuti->tanggal_mulai }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tanggal Berakhir</label>
                            <div class="col-lg-10">
                                <input name="tanggal_akhir" type="text" class="form-control pickadate-accessibility" placeholder="Contoh: 2022-04-16" value="{{  $cuti->tanggal_akhir }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Verifikator 2</label>
							<div class="col-lg-10">
								<select id="verifikator_2" name="verifikator_2" class="form-control select-search" required>
                                    <option value="">-- Pilih Proyek --</option>
									<option id="test2" value="{{ $verifikator2->id }}" data-id2="{{ $verifikator2->atasan_id }}" selected>{{ $verifikator2->nama }}</option>
									{{-- @foreach($users as $user)
										<option data-verif="{{$user->nama}}" value="{{$user->nama}}">{{$user->nama}} </option>
				    				@endforeach --}}
								</select>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Verifikator 1</label>
							<div class="col-lg-10">
								<select id="verifikator_1" name="verifikator_1" class="form-control select-search">
									<option value="{{$verifikator1->id}}" data-id1="">{{$verifikator1->nama}}</option>
									{{-- @foreach($users as $user)
										<option data-pnama="{{$user->nama}}" value="{{$user->id}}">{{$user->nama}} </option>
				    				@endforeach --}}
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Alasan</label>
							<div class="col-lg-10">
								<textarea name="alasan" rows="4" cols="3" class="form-control" placeholder="Alasan Cuti" required>{{ $cuti->alasan }}</textarea>
							</div>
						</div>
					</fieldset>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">Simpan <i class="icon-paperplane ml-2"></i></button>
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
    </script>
    <script>
		// karyawan
        var atasan_user = $('#name').data('atasan_user');
        // console.log(atasan_user);
        var test2 = $('#test2').data('id2');
        atasan_user = test2
		console.log(atasan_user);
        $.ajax({
            url : '{{ url("getverifikator") }}',
            type: 'get',
            dataType: 'json',
            success : function(verifs){
				var len = 0;
				len = verifs['data'].length;
				// console.log(atasan_user);
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