@extends('layout')

@section('content')
    
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><i class="icon-arrow-left52 mr-2"></i>Setting</h4>
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
			<form class="form-validate-jquery" action="{{route('setting.store')}}" method="post" enctype="multipart/form-data">
				@csrf
				<fieldset class="mb-3">
					{{-- <legend class="text-uppercase font-size-sm font-weight-bold">Setting</legend> --}}

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Logo</label>
							<div class="col-lg-8">
                                <img class="card-img img-fluid" src="{{url($setting ? $setting->logo : "global_assets/images/image.png")}}" alt="" style="height:150px;width:150px;object-fit: contain;">
								<input id="logo" name="logo" type="file" class="form-control border-teal border-1">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat</label>
							<div class="col-lg-8">
								<input type="text" name="alamat" class="form-control border-teal border-1" required value="{{$setting ? $setting->alamat : ""}}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Nomor Telpon</label>
							<div class="col-lg-8">
								<input type="number" name="no_telp" class="form-control border-teal border-1" required
									value="{{$setting ? $setting->no_telp : ""}}">
								<label class="col-form-label">Gunakan format kode negara 62. Contoh: 6281335625529</label>
							</div>
                        </div>
                        <hr>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Penerima</label>
							<div class="col-lg-8">
								<input type="text" name="penerima" class="form-control border-teal border-1" required value="{{$setting ? $setting->penerima : ""}}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Ttd Penerima</label>
							<div class="col-lg-8">
								<input type="text" class="form-control border-teal border-1" name="ttd_penerima" id="ttd_penerima" required value="{{$setting ? $setting->ttd_penerima : ""}}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Jabatan Ttd Penerima</label>
							<div class="col-lg-8">
								<input type="text" class="form-control border-teal border-1" name="ttd_pospenerima" id="ttd_pospenerima" required value="{{$setting ? $setting->ttd_pospenerima : ""}}">
							</div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Penagih</label>
							<div class="col-lg-8">
								<input type="text" class="form-control border-teal border-1" name="penagih" id="penagih" required value="{{$setting ? $setting->penagih : ""}}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Jabatan Penagih</label>
							<div class="col-lg-8">
								<input type="text" class="form-control border-teal border-1" name="pospenagih" id="pospenagih" required value="{{$setting ? $setting->pospenagih : ""}}">
							</div>
						</div>
					
				</fieldset>
				<div class="text-right">
					<button type="submit" class="btn btn-success">Simpan<i
							class="icon-paperplane ml-2"></i></button>
				</div>
			</form>
		</div>

	</div>
	<!-- /hover rows -->

</div>

@endsection

@section('js')
<!-- Theme JS files -->
<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_checkboxes_radios.js')}}"></script>

<script type="text/javascript">
	$( document ).ready(function() {

			var $select = $('.form-control-select2').select2();
	        
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
			@if ($errors->any())
				@foreach ($errors->all() as $error)
					new PNotify({
						title: 'Error',
						text: '{{ $error }}.',
						icon: 'icon-blocked',
						type: 'error'
					});
				@endforeach
			@endif

		});
</script>
@endsection