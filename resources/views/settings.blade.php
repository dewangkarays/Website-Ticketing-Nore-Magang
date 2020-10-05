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
							<textarea class="form-control click2edit border-teal border-1 p-2 mb-2" name="alamat" id="alamat" cols="30" rows="5" readonly>
								{{$setting ? $setting->alamat : ""}}
							</textarea>
							<button type="button" id="edit" class="btn btn-primary"><i class="icon-pencil3 mr-2"></i> Edit</button>
							<button type="button" id="save" class="btn btn-success"><i class="icon-checkmark3 mr-2"></i> Save</button>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Nomor Telpon</label>
						<div class="col-lg-8">
							<input type="text" name="no_telp" class="form-control border-teal border-1" required
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
							<textarea class=" form-control click2edit2 border-teal border-1 p-2 mb-2" name="catatan_tagihan" id="catatan_tagihan" cols="30" rows="5" readonly>
								{{$setting ? $setting->catatan_tagihan : ""}}
							</textarea>
							<button type="button" id="edit2" class="btn btn-primary"><i class="icon-pencil3 mr-2"></i> Edit</button>
							<button type="button" id="save2" class="btn btn-success"><i class="icon-checkmark3 mr-2"></i> Save</button>
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
	
	<script>
		var Summernote = function() {
			
			
			//
			// Setup module components
			//
			
			// Summernote
			var _componentSummernote = function() {
				if (!$().summernote) {
					console.warn('Warning - summernote.min.js is not loaded.');
					return;
				}
				
				// Basic examples
				// ------------------------------
				
				// Default initialization
				$('.summernote').summernote();
				
				// Control editor height
				$('.summernote-height').summernote({
					height: 400
				});
				
				// Air mode
				$('.summernote-airmode').summernote({
					airMode: true
				});
				
				
				// Click to edit
				// ------------------------------
				
				// Edit
				$('#edit').on('click', function() {
					$('.click2edit').summernote({focus: true});
				})
				
				// Save
				$('#save').on('click', function() {
					var aHTML = $('.click2edit').summernote('code');
					$('.click2edit').summernote('destroy');
				});
			};
			
			// Uniform
			var _componentUniform = function() {
				if (!$().uniform) {
					console.warn('Warning - uniform.min.js is not loaded.');
					return;
				}
				
				// Styled file input
				$('.note-image-input').uniform({
					fileButtonClass: 'action btn bg-warning-400'
				});
			};
			
			
			//
			// Return objects assigned to module
			//
			
			return {
				init: function() {
					_componentSummernote();
					_componentUniform();
				}
			}
		}();
		
		
		// Initialize module
		// ------------------------------
		
		document.addEventListener('DOMContentLoaded', function() {
			Summernote.init();
		});
	</script>

<script>
	var Summernote2 = function() {
		
		
		//
		// Setup module components
		//
		
		// Summernote
		var _componentSummernote2 = function() {
			if (!$().summernote) {
				console.warn('Warning - summernote.min.js is not loaded.');
				return;
			}
			
			// Basic examples
			// ------------------------------
			
			// Default initialization
			$('.summernote').summernote();
			
			// Control editor height
			$('.summernote-height').summernote({
				height: 400
			});
			
			// Air mode
			$('.summernote-airmode').summernote({
				airMode: true
			});
			
			
			// Click to edit
			// ------------------------------
			
			// Edit
			$('#edit2').on('click', function() {
				$('.click2edit2').summernote({focus: true});
			})
			
			// Save
			$('#save2').on('click', function() {
				var aHTML = $('.click2edit2').summernote('code');
				$('.click2edit2').summernote('destroy');
			});
		};
		
		// Uniform
		var _componentUniform2 = function() {
			if (!$().uniform) {
				console.warn('Warning - uniform.min.js is not loaded.');
				return;
			}
			
			// Styled file input
			$('.note-image-input').uniform({
				fileButtonClass: 'action btn bg-warning-400'
			});
		};
		
		
		//
		// Return objects assigned to module
		//
		
		return {
			init: function() {
				_componentSummernote2();
				_componentUniform2();
			}
		}
	}();
	
	
	// Initialize module
	// ------------------------------
	
	document.addEventListener('DOMContentLoaded', function() {
		Summernote2.init();
	});
</script>
	@endsection