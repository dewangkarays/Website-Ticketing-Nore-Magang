@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Ubah Task</h4>
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
				<form class="form-validate-jquery" action="{{ route('tasks.update', $task->id)}}" method="post" enctype="multipart/form-data">
					{{-- @method('PATCH') --}}
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Task</legend>
						@if($task->status==1 || \Auth::user()->role<20)
							@if(\Auth::user()->role==1)
								<div class="form-group row">
									<label class="col-form-label col-lg-2">User</label>
									<div class="col-lg-10">
										<select name="user_id" class="form-control select-search" data-fouc>
											@foreach($users as $user)
												<option value="{{$user->id}}" {{ $task->user_id == $user->id ? 'selected' : '' }}>{{$user->username}}</option>
						    				@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Kebutuhan</label>
									<div class="col-lg-10">
										<textarea name="kebutuhan" rows="4" cols="3" class="form-control" placeholder="Kebutuhan User" required>{{ $task->kebutuhan }}</textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label font-weight-semibold">Attachment:</label>
									<div class="col-lg-10">
										<input type="file" name="file[]" class="file-input" multiple="multiple" data-fouc>
										<span class="form-text text-muted">Jumlah max ukuran file : 32MB</span><hr>
										<div id="attachdiv">
											@foreach($attachment as $attach)
												<span class="form-text text-muted"><a href="{{ asset('storage/attachment/'.$attach->file)}}">{{$attach->file}}</a> <a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="{{ route('attachments.destroy', $attach->id)}}" style="display: inline;"><i class="icon-x"></i></a></span>
											@endforeach
										</div>
									</div>
								</div>

							@elseif(\Auth::user()->role==10)
								<div class="form-group row">
									<label class="col-form-label col-lg-2">User</label>
									<div class="col-lg-10">
										<label class="col-form-label col-lg-2">{{$task->user->username}}</label>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Kebutuhan</label>
									<div class="col-lg-10">
										<label class="col-form-label col-lg-2">{{$task->kebutuhan}}</label>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label font-weight-semibold">Attachment: <br><p><i class="text-muted">Opsional</i></p></label>
									<div class="col-lg-10">
										<div id="attachdiv">
											@foreach($attachment as $attach)
												<span class="form-text text-muted"><a href="{{ asset('storage/attachment/'.$attach->file)}}">{{$attach->file}}</a> </span>
											@endforeach
										</div>
									</div>
								</div>
							
							@else
								<div class="form-group row">
									<label class="col-form-label col-lg-2">User</label>
									<div class="col-lg-10">
										<label class="col-form-label col-lg-2">{{\Auth::user()->username}}</label>
										<input type="hidden" name="user_id" value="{{\Auth::user()->id}}">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Kebutuhan</label>
									<div class="col-lg-10">
										<textarea name="kebutuhan" rows="4" cols="3" class="form-control" placeholder="Kebutuhan User" required>{{ $task->kebutuhan }}</textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label font-weight-semibold">Attachment:</label>
									<div class="col-lg-10">
										<input type="file" name="file[]" class="file-input" multiple="multiple" data-fouc>
										<span class="form-text text-muted">Jumlah max ukuran file : 32MB</span><hr>
										<div id="attachdiv">
											@foreach($attachment as $attach)
												<span class="form-text text-muted"><a href="{{ asset('storage/attachment/'.$attach->file)}}">{{$attach->file}}</a> <a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="{{ route('attachments.destroy', $attach->id)}}" style="display: inline;"><i class="icon-x"></i></a></span>
											@endforeach
										</div>
									</div>
								</div>
							@endif

							@if(\Auth::user()->role==1)
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Severity</label>
									<div class="col-lg-10">
										<select name="severity" class="form-control select-search" data-fouc>
											<option value="">-- Pilih Severity --</option>
											@foreach(config('custom.severity') as $key => $value)
												<option value="{{$key}}" {{ $task->severity == $key ? 'selected' : '' }}>{{$value}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Assign</label>
									<div class="col-lg-10">
										<select name="handler" class="form-control select-search" data-fouc>
		                                    <option value="">-- Pilih User --</option>
											@foreach($handlers as $handler)
												<option value="{{$handler->id}}" {{ $task->handler == $handler->id ? 'selected' : '' }}>{{$handler->username}}</option>
						    				@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Status</label>
									<div class="col-lg-10">
										<select name="status" class="form-control">
		                                    <option value="1" {{ $task->status == '1' ? 'selected' : '' }}>Baru</option>
		                                    <option value="2"{{ $task->status == '2' ? 'selected' : '' }}>Sedang Dikerjakan</option>
		                                    <option value="3"{{ $task->status == '3' ? 'selected' : '' }}>Selesai</option>
		                                </select>
									</div>
								</div>
							@elseif(\Auth::user()->role==10)
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Severity</label>
									<div class="col-lg-10">
										<select name="handler" class="form-control select-search" data-fouc>
											<option value="">-- Pilih Severity --</option>
											@foreach(config('custom.severity') as $key => $value)
												<option value="{{$key}}" {{ $task->severity == $key ? 'selected' : '' }}>{{$value}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Assign</label>
									<div class="col-lg-10">
										@if ($task->handler)
											@if (isset($task->assign->nama))
											<label class="col-form-label col-lg-2">{{$task->assign->nama}}</label>
											@else
											<label class="col-form-label col-lg-2">-</label>
											@endif
										@else
										<label class="col-form-label col-lg-2">-</label>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Status</label>
									<div class="col-lg-10">
										<label class="col-form-label col-lg-2">{{config('custom.status.'.$task->status)}}</label>
									</div>
								</div>
							@endif
							</fieldset>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">Simpan <i class="icon-paperplane ml-2"></i></button>
							</div>

						@else
							<div class="form-group row">
								<label class="col-form-label col-lg-2">User</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{$task->user->username}}</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Kebutuhan</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{$task->kebutuhan}}</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label font-weight-semibold">Attachment:</label>
								<div class="col-lg-10">
									<div id="attachdiv">
										@foreach($attachment as $attach)
											<span class="form-text text-muted"><a href="{{ asset('storage/attachment/'.$attach->file)}}">{{$attach->file}}</a></span>
										@endforeach
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-lg-2">Status</label>
								<div class="col-lg-10">
									<label class="col-form-label col-lg-2">{{config('custom.status.'.$task->status)}}</label>
								</div>
							</div>
							</fieldset>
							<div class="text-right">
								<a href="{{ route('tasks.index')}}"><button type="button" class="btn btn-primary">Kembali <i class="icon-undo2 ml-2"></i></button></a>
							</div>

						@endif
				</form>
			</div>

		</div>
		<!-- /hover rows -->

	</div>
	<!-- /content area -->

    <!-- Danger modal -->
	<div id="modal_theme_danger" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="delform">
				    @csrf
				    @method('DELETE')
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
	<!-- /default modal -->
@endsection

@section('js')
	<!-- Theme JS files -->
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
	<script>
		//modal delete
		$(document).on("click", ".delbutton", function () {
		     var url = $(this).data('uri');
		     $("#delform").attr("action", url);
		});


		$("#delform").submit(function(e) {

		    e.preventDefault(); // avoid to execute the actual submit of the form.

		    var form = $(this);
		    var url = form.attr('action');
		    
		    $.ajax({
	           	type: "DELETE",
	           	// method: "DELETE",
	           	url: url,
	           	data: form.serialize(), // serializes the form's elements.
	           	success: function(data)
	           	{
	               	$("#attachdiv").html(data);
	               	$('.modal').modal('hide');
	           	}	
		    });
		});
	</script>
	<script type="text/javascript">
				
		var FormValidation = function() {

		    // Validation config
		    var _componentValidation = function() {
		        if (!$().validate) {
		            console.warn('Warning - validate.min.js is not loaded.');
		            return;
		        }

		        // Initialize
		        var validator = $('.form-validate-jquery').validate({
		            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
		            errorClass: 'validation-invalid-label',
		            //successClass: 'validation-valid-label',
		            validClass: 'validation-valid-label',
		            highlight: function(element, errorClass) {
		                $(element).removeClass(errorClass);
		            },
		            unhighlight: function(element, errorClass) {
		                $(element).removeClass(errorClass);
		            },
		            // success: function(label) {
		            //    label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
		            //},

		            // Different components require proper error label placement
		            errorPlacement: function(error, element) {

		                // Unstyled checkboxes, radios
		                if (element.parents().hasClass('form-check')) {
		                    error.appendTo( element.parents('.form-check').parent() );
		                }

		                // Input with icons and Select2
		                else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
		                    error.appendTo( element.parent() );
		                }

		                // Input group, styled file input
		                else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
		                    error.appendTo( element.parent().parent() );
		                }

		                // Other elements
		                else {
		                    error.insertAfter(element);
		                }
		            },
		            messages: {
		                kebutuhan: {
		                    required: 'Mohon diisi.'
		                },
		            },
		        });

		        // Reset form
		        $('#reset').on('click', function() {
		            validator.resetForm();
		        });
		    };

		    // Return objects assigned to module
		    return {
		        init: function() {
		            _componentValidation();
		        }
		    }
		}();


		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		    FormValidation.init();
		});
	</script>
	<script type="text/javascript">
		
		var FileUpload = function() {

		    // Bootstrap file upload
		    var _componentFileUpload = function() {
		        if (!$().fileinput) {
		            console.warn('Warning - fileinput.min.js is not loaded.');
		            return;
		        }

		        // Modal template
		        var modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
		            '  <div class="modal-content">\n' +
		            '    <div class="modal-header align-items-center">\n' +
		            '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
		            '      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
		            '    </div>\n' +
		            '    <div class="modal-body">\n' +
		            '      <div class="floating-buttons btn-group"></div>\n' +
		            '      <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
		            '    </div>\n' +
		            '  </div>\n' +
		            '</div>\n';

		        // Buttons inside zoom modal
		        var previewZoomButtonClasses = {
		            toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
		            fullscreen: 'btn btn-light btn-icon btn-sm',
		            borderless: 'btn btn-light btn-icon btn-sm',
		            close: 'btn btn-light btn-icon btn-sm'
		        };

		        // Icons inside zoom modal classes
		        var previewZoomButtonIcons = {
		            prev: '<i class="icon-arrow-left32"></i>',
		            next: '<i class="icon-arrow-right32"></i>',
		            toggleheader: '<i class="icon-menu-open"></i>',
		            fullscreen: '<i class="icon-screen-full"></i>',
		            borderless: '<i class="icon-alignment-unalign"></i>',
		            close: '<i class="icon-cross2 font-size-base"></i>'
		        };

		        // File actions
		        var fileActionSettings = {
		            zoomClass: '',
		            zoomIcon: '<i class="icon-zoomin3"></i>',
		            dragClass: 'p-2',
		            dragIcon: '<i class="icon-three-bars"></i>',
		            removeClass: '',
		            removeErrorClass: 'text-danger',
		            removeIcon: '<i class="icon-bin"></i>',
		            indicatorNew: '<i class="icon-file-plus text-success"></i>',
		            indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
		            indicatorError: '<i class="icon-cross2 text-danger"></i>',
		            indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>'
		        };

		        $('.file-input').fileinput({
		            browseLabel: 'Browse',
					maxFileSize: 32000,
					maxFilePreviewSize: 32000,
		            browseIcon: '<i class="icon-file-plus mr-2"></i>',
		            showUpload: false,
		            removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
		            layoutTemplates: {
		                icon: '<i class="icon-file-check"></i>',
		                modal: modalTemplate
		            },
		            initialCaption: "No file selected",
		            previewZoomButtonClasses: previewZoomButtonClasses,
		            previewZoomButtonIcons: previewZoomButtonIcons,
		            fileActionSettings: fileActionSettings
		        });

		    };

		    return {
		        init: function() {
		            _componentFileUpload();
		        }
		    }
		}();


		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		    FileUpload.init();
		});
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