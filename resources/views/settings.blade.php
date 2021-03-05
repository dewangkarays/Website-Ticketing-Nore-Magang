<head>
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
</head>
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
					<legend class="text-uppercase font-size-sm font-weight-bold">General</legend>
					
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
							<textarea class="form-control click2edit border-teal border-1 p-2 mb-2 summernote" name="alamat" id="alamat" cols="30" rows="5" readonly>
								{{$setting ? $setting->alamat : ""}}
							</textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Nomor Telpon</label>
						<div class="col-lg-8">
							<input type="text" id="no_telp" name="no_telp" class="form-control border-teal border-1" required
							value="{{$setting ? $setting->no_telp : ""}}">
							<label class="col-form-label">Gunakan format kode negara 62. Contoh: 6281335625529</label>
						</div>
					</div>
					<br>
					<h4><b>Payment Receipt</b></h4>
					<hr>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Penerima</label>
						<div class="col-lg-8">
							<input type="text" id="penerima" name="penerima" class="form-control border-teal border-1" required value="{{$setting ? $setting->penerima : ""}}">
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
					<br>
					
					<h4><b>Invoice</b></h4>
					<hr>
					
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Penagih</label>
						<div class="col-lg-8">
							<input type="text" class="form-control border-teal border-1" name="penagih" id="penagih" required value="{{$setting ? $setting->penagih : ""}}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Posisi Penagih</label>
						<div class="col-lg-8">
							<input type="text" class="form-control border-teal border-1" name="pospenagih" id="pospenagih" required value="{{$setting ? $setting->pospenagih : ""}}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Catatan Tagihan</label>
						<div class="col-lg-8">
							<textarea class=" form-control click2edit2 border-teal border-1 p-2 mb-2 summernote" name="catatan_tagihan" id="catatan_tagihan" cols="30" rows="5" readonly>
								{{ ( @$setting ? $setting->catatan_tagihan : "")}}
							</textarea>
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
	<script src="{{asset('global_assets/js/plugins/editors/summernote/summernote.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_checkboxes_radios.js')}}"></script>
	<script>
		$(document).ready(function() {
			$('.summernote').summernote();
		});
	</script>
	@endsection