@extends('layout')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - History Task</h4>
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
					@method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Task</legend>
						
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
								<a href="{{ route('history')}}"><button type="button" class="btn btn-primary">Kembali <i class="icon-undo2 ml-2"></i></button></a>
							</div>

				</form>
			</div>

		</div>
		<!-- /hover rows -->

	</div>
	<!-- /content area -->

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