@extends('layout')

@section('css')
<style type="text/css">
	.datatable-column-width{
		overflow: hidden; text-overflow: ellipsis; max-width: 200px;
	}
</style>
@endsection

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Notifikasi</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">

		<!-- Hover rows -->
		<div class="card">

			<table class="table">
				<tbody>
				@if(!$notif->isEmpty())
					@foreach($notif as $data)
				    <tr>
				        <td>
				        	<!-- <a href="{{route('clicknotif',$data->id)}}">{{$data->title}}<br>
				        	{{$data->message}}</a> -->
				        	<a href="{{route('clicknotif',$data->id)}}">
                                <div class="media-body">
                                    <div class="media-title">
                                            <span class="font-weight-semibold">{{$data->title}}</span>
                                    </div>
                
                                    <span class="text-muted" style="float: left;">{{$data->message}}</span>
                                    <span class="text-muted" style="float: right;">{{ date('M, jS. H:i', strtotime($data->created_at))}}</span>
                                </div>
                            </a>
				        </td>
				    </tr>
				    @endforeach
				@else
				  	<tr><td align="center">Data Kosong</td></tr>
				@endif 
				</tbody>
			</table>
		</div>
		<!-- /hover rows -->

	</div>
	<!-- /content area -->


@endsection

@section('js')
	<!-- Theme JS files -->
	<script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js') }}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js') }}"></script>

	<script src="{{asset('assets/js/app.js') }}"></script>
	<script src="{{asset('global_assets/js/demo_pages/components_modals.js') }}"></script>
	
@endsection