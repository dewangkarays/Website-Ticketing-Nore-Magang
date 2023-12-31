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
						@if(\Auth::user()->role==10 || \Auth::user()->role==20 || \Auth::user()->role>=30 && \Auth::user()->role<=50)
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nama</label>
							<div class="col-lg-10">
								<input type="text" id="name" name="name" class="form-control border border-1" placeholder="Nama" value="{{ $cuti->karyawan->nama }}" data-user_id="{{ $cuti->karyawan->id }}" required readonly>
							</div>
						</div>
						@else
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nama</label>
							<div class="col-lg-10">
								<input type="text" id="name" name="name" class="form-control border border-1" placeholder="Nama" value="{{ $cuti->karyawan->nama }}" data-user_id="{{ $cuti->karyawan->id }}" required readonly>
							</div>
						</div>
						@endif
						<div class="form-group row">
							<label class="col-form-label col-lg-2">NIP</label>
							<div class="col-lg-10">
								<input type="text" name="nip" class="form-control border border-1" value="{{ $cuti->karyawan->nip }}" placeholder="NIP" required readonly>
							</div>
						</div>
						
                        {{-- @endforeach --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tanggal Mulai</label>
                            <div class="col-lg-10">
                                <input id="tanggal_mulai" name="tanggal_mulai" type="text" class="form-control pickadate-accessibility" placeholder="Pilih Tanggal" value="{{  $cuti->tanggal_mulai }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tanggal Berakhir</label>
                            <div class="col-lg-10">
                                <input id="tanggal_akhir" name="tanggal_akhir" type="text" class="form-control pickadate-accessibility" placeholder="Pilih Tanggal" value="{{  $cuti->tanggal_akhir }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Verifikator 2</label>
							<div class="col-lg-10">
								{{-- <select id="old_verifikator_2" name="old_verifikator_2" class="form-control select-search" required> --}}
                                    {{-- <option value="">-- Pilih Proyek --</option> --}}
									<input type="text" id="old_verifikator_2" name="old_verifikator_2" class="form-control border border-1" value="{{$verifikator2->nama}}"readonly>
									{{-- <option id="old_ver2" value="{{$verifikator2->id}}" data-old_id2="">{{$verifikator2->nama}}</option> --}}
									{{-- @foreach($users as $user)
										<option data-verif="{{$user->nama}}" value="{{$user->nama}}">{{$user->nama}} </option>
				    				@endforeach --}}
								{{-- </select> --}}
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">ganti Verifikator 2</label>
							<div class="col-lg-10">
								<select id="verifikator_2" name="verifikator_2" class="form-control select-search" required>
                                    {{-- <option value="">-- Pilih Proyek --</option> --}}
									<option id="ver2" value="{{$verifikator2->id}}" data-id2="">-- Pilih Verifikator --</option>
									{{-- @foreach($users as $user)
										<option data-verif="{{$user->nama}}" value="{{$user->nama}}">{{$user->nama}} </option>
				    				@endforeach --}}
								</select>
							</div>
						</div>
						@if($verifikator1 != null)
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Verifikator 1</label>
							<div class="col-lg-10">
								<input type="text" id="old_verifikator_1" name="old_verifikator_1" class="form-control border border-1" value="{{$verifikator1->nama}}"readonly>
								{{-- <select id="old_verifikator_1" name="old_verifikator_1" class="form-control select-search">
									<option value="{{$verifikator1->id}}" data-old_id1="">{{$verifikator1->nama}}</option> --}}
									{{-- @foreach($users as $user)
										<option data-pnama="{{$user->nama}}" value="{{$user->id}}">{{$user->nama}} </option>
				    				@endforeach --}}
								{{-- </select> --}}
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Ganti Verifikator 1</label>
							<div class="col-lg-10">
								<select id="verifikator_1" name="verifikator_1" class="form-control select-search">
									<option value="{{$verifikator1->id}}" data-id1="">-- Pilih Verifikator --</option>
									{{-- @foreach($users as $user)
										<option data-pnama="{{$user->nama}}" value="{{$user->id}}">{{$user->nama}} </option>
				    				@endforeach --}}
								</select>
							</div>
						</div>
						@else
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Verifikator 1</label>
							<div class="col-lg-10">
								<input type="text" id="old_verifikator_1" name="old_verifikator_1" class="form-control border border-1" value=""readonly>
								{{-- <select id="old_verifikator_1" name="old_verifikator_1" class="form-control select-search">
									<option value="{{$verifikator1->id}}" data-old_id1="">{{$verifikator1->nama}}</option> --}}
									{{-- @foreach($users as $user)
										<option data-pnama="{{$user->nama}}" value="{{$user->id}}">{{$user->nama}} </option>
				    				@endforeach --}}
								{{-- </select> --}}
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Ganti Verifikator 1</label>
							<div class="col-lg-10">
								<select id="verifikator_1" name="verifikator_1" class="form-control select-search">
									<option value="" data-id1="">-- Pilih Verifikator --</option>
									{{-- @foreach($users as $user)
										<option data-pnama="{{$user->nama}}" value="{{$user->id}}">{{$user->nama}} </option>
				    				@endforeach --}}
								</select>
							</div>
						</div>
						@endif
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Alasan</label>
							<div class="col-lg-10">
								<textarea id="alasan" name="alasan" rows="4" cols="3" class="form-control" placeholder="Alasan Cuti" required>{{ $cuti->alasan }}</textarea>
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

	<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
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
			min: new Date(),
			disable: [1,7],
        });
    </script>
<script>
	// karyawan
	var user_id = $('#name').data('user_id');
	// console.log(user_id);
	$.ajax({
		url : '{{ url("getverifikator") }}/'+user_id,
		type: 'get',
		dataType: 'json',
		success : function(verifs2){
			var len2 = 0;
			len2 = verifs2.length;
			console.log(user_id);
			if (user_id != 0) {
			for(var i=0; i<len2; i++){
				var id2 = verifs2[i].id;
				var atasan_id2 = verifs2[i].atasan_id;
				var nama2 = verifs2[i].nama;

				var option2 = "<option value='"+id2+"' data-id2='"+atasan_id2+"'>"+nama2+"</option>";

				$("#verifikator_2").append(option2);
			}
		} else {
			for(var i=0; i<len2; i++){
				var id2 = verifs2[i].id;
				var atasan_id2 = verifs2[i].atasan_id;
				var nama2 = verifs2[i].nama;

				var option2 = "<option value='"+id2+"' data-id2='"+atasan_id2+"'>"+nama2+"</option>";

				$("#verifikator_2").append(option2);
			}
		}
		}
	});
</script>
<script>
	$('#verifikator_2').on('change', function(){
	var id_verif2 = $(this). children("option:selected").val();
	// console.log(atasan_user2);

	$.ajax({
		url : '{{ url("getverifikator") }}/'+id_verif2,
		type: 'get',
		dataType: 'json',
		success : function(verifs){
			$("#verifikator_1").empty();

			var dval = "-- Pilih Verifikator --"
			var defval = "<option value=''>"+dval+"</option>";

			$("#verifikator_1").append(defval);
			var len = 0;
			len = verifs.length;
			
			for(var j=0; j<len; j++){
				var id = verifs[j].id;
				var atasan_id = verifs[j].atasan_id;
				var nama = verifs[j].nama;

				var option = "<option value='"+id+"' data-id1='"+atasan_id+"'>"+nama+"</option>";
				
				$("#verifikator_1").append(option);
			}
		}
	});
});
</script>
<script>
	$('#tanggal_akhir').on('change', function(){
	var tgl_mulai = $('#tanggal_mulai').val();
	var tgl_akhir = $('#tanggal_akhir').val();
	new_tgl_mulai = new Date(tgl_mulai).toLocaleDateString('id')
	new_tgl_akhir = new Date(tgl_akhir).toLocaleDateString('id')
	
	var start = new Date(tgl_mulai);
	var end = new Date(tgl_akhir);
	
	var totalBusinessDays = 1;
	var current = new Date(start);
	current.setDate(current.getDate()+1);
	var day;
	while (current <= end) {
	day = current.getDay();
	if (day >= 1 && day <= 5) {
		++totalBusinessDays;
	}
	current.setDate(current.getDate() + 1);
	}
	$('#alasan').empty();
	$('#alasan').append('Dengan ini saya mengajukan permohonan izin cuti selama '+totalBusinessDays+' hari kerja pada tanggal '+new_tgl_mulai+' - '+new_tgl_akhir+' dikarenakan (tulis alasan cuti)');
	})
	
	$('#tanggal_mulai').on('change', function(){
	var tgl_mulai = $('#tanggal_mulai').val();
	var tgl_akhir = $('#tanggal_akhir').val();
	new_tgl_mulai = new Date(tgl_mulai).toLocaleDateString('id')
	new_tgl_akhir = new Date(tgl_akhir).toLocaleDateString('id')
	
	var start = new Date(tgl_mulai);
	var end = new Date(tgl_akhir);
	
	var totalBusinessDays = 1;
	var current = new Date(start);
	current.setDate(current.getDate()+1);
	var day;
	while (current <= end) {
	day = current.getDay();
	if (day >= 1 && day <= 5) {
		++totalBusinessDays;
	}
	current.setDate(current.getDate() + 1);
	}
	$('#alasan').empty();
	$('#alasan').append('Dengan ini saya mengajukan permohonan izin cuti selama '+totalBusinessDays+' hari kerja pada tanggal '+new_tgl_mulai+' - '+new_tgl_akhir+' dikarenakan (tulis alasan cuti)');
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