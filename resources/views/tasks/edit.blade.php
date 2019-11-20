@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Tambah User</h4>
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
				<form action="{{ route('tasks.update', $task->id)}}" method="post" enctype="multipart/form-data">
					@method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Task</legend>

						<div class="form-group row">
							<label class="col-form-label col-lg-2">User</label>
							<div class="col-lg-10">
								<select name="user_id" class="form-control select-search" data-fouc>
									@foreach($users as $user)
										<option value="{{$user->id}}" {{ $task->user_id == $user->id ? 'selected' : '' }}>{{$user->nama}}</option>
				    				@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Kebutuhan</label>
							<div class="col-lg-10">
								<textarea name="kebutuhan" rows="4" cols="3" class="form-control" placeholder="Kebutuhan User">{{ $task->kebutuhan }}</textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-2 col-form-label font-weight-semibold">Attachment:</label>
							<div class="col-lg-10">
								<input type="file" name="file[]" class="file-input" multiple="multiple" data-fouc>
								<div id="attachdiv">
									@foreach($attachment as $attach)
										<span class="form-text text-muted"><a href="{{ asset('storage/attachment/'.$attach->file)}}">{{$attach->file}}</a> <a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="{{ route('attachments.destroy', $attach->id)}}" style="display: inline;"><i class="icon-x"></i></a></span>
									@endforeach
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Assign</label>
							<div class="col-lg-10">
								<select name="handler" class="form-control select-search" data-fouc>
                                    <option value="">-- Pilih User --</option>
									@foreach($users as $user)
										<option value="{{$user->id}}" {{ $task->handler == $user->id ? 'selected' : '' }}>{{$user->nama}}</option>
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
					</fieldset>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
					</div>
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
	<script src="{{asset('global_assets/js/demo_pages/uploader_bootstrap.js')}}"></script>
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
@endsection