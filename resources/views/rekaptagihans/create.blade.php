@extends('layout')

@section('css')
<style type="text/css">
	.datatable-column-width{
		overflow: hidden; text-overflow: ellipsis; max-width: 200px;
	}
</style>
@endsection

@section('content')
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Home</span> - Create Rekap Tagihan</h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <div class="card">
        {{--<div class="card-header header-elements-inline">
            <h5 class="card-title">Rekap Tagihan Klien</h5>
        </div>--}}
        <div class="card-body">
            <form method="GET">
                @csrf
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Klien :</label>
                    <div class="col-lg-10">
                        <select id="user_id" name="user_id" class="form-control select-search">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($users as $user)
                            <option data-pnama="{{$user->nama}}" data-pproyek="{{$user->website}}" value="{{$user->id}}" {{$user->id == $requestUser ? 'selected' : ''}}>{{$user->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            <div class="text-right">
                <a id="btn_reset" href="{{ route('rekaptagihans.create') }}" class="btn bg-slate text-uppercase">Reset  <i class="icon-rotate-ccw2 ml-2"></i></a>
                <a id="btn_submit" href="{{ route('rekaptagihans.create').'?c='.app('request')->input('c')}}" data-uri="{{ route('rekaptagihans.create') }}" class="btn btn-success text-uppercase">Submit  <i class="icon-paperplane ml-2"></i></a>
            </div>
        </div>
    </div>
    
    <div class="card" id="card-rekap">
        <div class="card-body">
            <form method="POST" action="{{ route('rekaptagihans.store') }}">
                @csrf
                <table class="table datatable-basic table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><input type="checkbox" class="checked-all"></th>
                            <th>Nama</th>
                            {{-- <th>Invoice</th> --}}
                            <th>Nama Proyek</th>
                            <th>Tagihan</th>
                            <th>Keterangan</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!$tagihans->isEmpty())
                        @php ($i = 1)
                        @foreach($tagihans as $tagihan)
                        <tr>
                            <td>{{$i}}</td>
                            <td><input type="checkbox" name="tagihan_id[]" id="chk" value="{{ $tagihan->id }}"></td>
                            <td><div class="datatable-column-width">{{@$tagihan->nama}}</div></td>
                            {{-- <td><div class="datatable-column-width">{{$tagihan->invoice}}</div></td> --}}
                            <td><div class="datatable-column-width">{{$tagihan->nama_proyek}}</div></td>
                            <td><div class="datatable-column-width">Rp @angka($tagihan->nominal)</div></td>
                            <td><div class="datatable-column-width">{{$tagihan->keterangan}}</div></td>
                            <td align="center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>
    
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('tagihans.edit',$tagihan->id)}}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
                                            <a href="{{url('/tagihans/cetak/'.$tagihan->id)}}" class="dropdown-item" target="_blank"><i class="icon-printer2"></i> Print</a>
                                            <a href="{{url('/tagihans/lampiran/'.$tagihan->id)}}" class="dropdown-item"><i class="icon-images3"></i> Lampiran</a>
                                            <a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="{{ route('tagihans.destroy', $tagihan->id)}}"><i class="icon-x"></i> Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @php ($i++)
                        @endforeach
                    @else
                          <tr><td align="center" colspan="9">Data Kosong</td></tr>
                    @endif

                    </tbody>
                </table>

                <hr>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Pelanggan</label>
						<div class="col-lg-10">
                            <input type="hidden" name="user_id" value="{{ $tagihans[0]->user_id }}">
                        </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 font-weight-bold">Nomor Invoice</label>
                    <div class="col-lg-1">
                        <input type="text" id="noinv" name="noinv" class="form-control border-info border-1" value="INV" readonly>
                    </div>
                    <div class="col-lg-2">
                        @if ($lastno)
                        @if (isset($lastno->ninv))
                        <input type="text" id="ninv" name="ninv" class="form-control border-info border-1" value="{{$lastno->ninv+1}}" required>
                        @endif
                        @else
                        <input type="text" id="ninv" name="ninv" class="form-control border-info border-1" value="1" required>
                        @endif
                    </div>
                    <div class="col-lg-2">
                        <input type="text" id="noakhir" name="noakhir" class="form-control border-info border-1" value="{{date('Ymd')}}" readonly>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" id="nouser" name="nouser" class="form-control border-info border-1" value="{{\Auth::user()->id}}" readonly>
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Jatuh Tempo</label>
                    <div class="col-lg-10">
                        <input id="jatuh_tempo" name="jatuh_tempo" type="text" class="form-control pickadate-accessibility"  value="{{old('jatuh_tempo')}}" placeholder="Tanggal Jatuh Tempo">
                        {{-- <input type="text" id="kadaluarsa" name="kadaluarsa" class="form-control border-teal border-1"> --}}
                    </div>
                    {{-- <span id="kadaluarsa" name="kadaluarsa" class="col-form-label col-lg-10 font-weight-bold">{{@$}}</span> --}}
                </div>

                <div class="text-right">
                    <a href="{{ route('rekaptagihans.index') }}" class="btn bg-slate">Kembali <i class="icon-undo2 ml-2"></i></a>
                    <button type="submit" class="btn btn-success">Submit <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Theme JS files -->
<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/pickers/anytime.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>
<script type="text/javascript">
	// get token
	let getToken = function() {
		return $('meta[name=csrf-token]').attr('content')
	}

	// Accessibility labels
	$('.pickadate-accessibility').pickadate({
		labelMonthNext: 'Go to the next month',
		labelMonthPrev: 'Go to the previous month',
		labelMonthSelect: 'Pick a month from the dropdown',
		labelYearSelect: 'Pick a year from the dropdown',
		selectMonths: true,
		selectYears: true,
		format: 'yyyy-mm-dd',
	});

	$('#user_id').on('change', function(){
		var id_proyek = $('#user_id option:selected').val();
		var pnama = $('#user_id option:selected').data('pnama');

		$('#nama').val(pnama);
		$('#select_proyek').find('option').not(':first').remove();
		$('#nama_proyek').val('');

		$.ajax({
			type: 'get',
			url : '{{url("getkadaluarsa")}}/'+id_proyek,
			success : function(data){
				// $('#kadaluarsa').val(data);
				$('#kadaluarsa').text(data);
				console.log('Success');
			},
			error:function(data){
				console.log('Error',data);
			}
		});

		$.ajax({
			url : '{{url("getproyek")}}/'+id_proyek,
			type: 'get',
			dataType: 'json',
			success : function(res){
				var len = 0;
				if(res['data'] != null){
					len = res['data'].length;
				}
				// alert(len);
				if(len > 0){
					// Read data and create <option >
						for(var i=0; i<len; i++){

							var id = res['data'][i].id;
							var website = res['data'][i].website;
							var jenis = res['data'][i].jenis_layanan;

							var option = "<option value='"+id+"' data-jenis='"+jenis+"'>"+website+"</option>";

							$("#select_proyek").append(option);
						}
					}
					console.log('Success2');
				},
				error:function(data){
					console.log('Error2',data);
				}
			});

		});

		$('#select_proyek').on('change',function() {
			var proyek = $('#select_proyek option:selected').text();
			var jenis = $('#select_proyek option:selected').data('jenis');
			$('#nama_proyek').val(proyek);
            var id_proyek = $('#select_proyek option:selected').val();
			$('#id_proyek').val(id_proyek);
			if (jenis==3) {
				$('#div-masaberlaku').hide();
				$('#masa-berlaku').prop('disabled', true);
			}
			else{
				$('#div-masaberlaku').show();
				$.ajax({
					type: 'get',
					url : '{{url("getmasa_berlaku")}}/'+id_proyek,
					success : function(data){
						// $('#kadaluarsa').val(data);
						$('#masa_berlaku').val(data);
						$('#masa_berlaku').text(data);
						console.log('Success');
					},
					error:function(data){
						console.log('Error',data);
					}
				});
			}
		});

		var FormValidation = function() {

			// Validation config
			var _componentValidation = function() {
				if (!$().validate) {
					console.warn('Warning - validate.min.js is not loaded.');
					return;
				}

				// Initialize
				var validator = $('#form_tagihan').validate({
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
						rules: {
							select_proyek:{
								required : true
							},
							langganan:{
								required : true
							},
							ads:{
								required : true
							},
							lainnya:{
								required : true
							}
						},
						messages: {
							select_proyek:{
								required : 'Mohon diisi'
							},
							langganan:{
								required : 'Mohon diisi'
							},
							ads:{
								required : 'Mohon diisi'
							},
							lainnya:{
								required : 'Mohon diisi'
							}
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
				@if ($errors->any())
				new PNotify({
					title: 'Error',
					text: 'Nomor Invoice Sudah Terambil, input kembali.',
					icon: 'icon-blocked',
					type: 'error'
				});

				@elseif ($errors->has('ninv'))
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