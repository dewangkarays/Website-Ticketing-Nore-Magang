@extends('layout')

@section('css')
<style type="text/css">
	.input-error {
		outline: 1px solid red;
	}
	.summernote ol, ul{
		list-style: disc !important;
		list-style-position: inside;
	}
</style>
@endsection

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><span class="font-weight-semibold">Home</span> - Tambah Tagihan</h4>
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
			<form id="form_tagihan" class="form-validate-jquery" action="{{ route('tagihans.store')}}" method="post">
				@csrf
				<fieldset class="mb-3">
					<legend class="text-uppercase font-size-sm font-weight-bold">Data Tagihan</legend>
					{{-- <div class="form-group row">
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
					</div> --}}

					<div class="form-group row">
						<label class="col-form-label col-lg-2">Pelanggan</label>
                        @if(!$proyeks)
						    <div class="col-lg-10">
                                <select id="user_id" name="user_id" class="form-control select-search">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($users as $user)
                                    <option name="nama" data-pnama="{{$user->nama}}" data-pproyek="{{$user->website}}" value="{{$user->id}}" {{$user->id == old('user_id') ? 'selected' : ''}}>{{$user->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="user_id" value={{@$proyeks->user_id}}>
                            <label class="col-form-label col-lg-10">{{@$proyeks->user->nama}}</label>
                        @endif
					</div>
					{{-- <div class="form-group row">
						<label class="col-form-label col-lg-2">Nama</label>
						<div class="col-lg-10">
							<input type="text" id="nama" name="nama" class="form-control border-teal border-1" value="{{old('nama')}}" readonly>
						</div>
					</div> --}}
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Nama Proyek</label>
                        @if(!$proyeks)
                            <div class="col-lg-10">
                                <select id="select_proyek" name="select_proyek" class="form-control select-search">
                                    <option value="">-- Pilih Proyek --</option>
                                </select>
                                <input type="hidden" id="id_proyek" name="id_proyek" class="form-control border-teal border-1" value="{{old('id_proyek')}}">
                                <input type="hidden" id="nama_proyek" name="nama_proyek" class="form-control border-teal border-1" placeholder="Nama Proyek" value="{{old('nama_proyek')}}" readonly>
                            </div>
                        @else
                            <input type="hidden" name="id_proyek" value="{{@$proyeks->id}}">
                            <input type="hidden" name="nama_proyek"  value="{{@$proyeks->nama_proyek}}">
                            <label class="col-form-label col-lg-10">{{@$proyeks->nama_proyek}}</label>
                        @endif
					</div>
					{{--div class="form-group row">
						<label class="col-form-label col-lg-2">Nama Proyek</label>
						<div class="col-lg-10">
                            <input type="hidden" id="id_proyek" name="id_proyek" class="form-control border-teal border-1" value="{{old('id_proyek')}}">
							<input type="text" id="nama_proyek" name="nama_proyek" class="form-control border-teal border-1" placeholder="Nama Proyek" value="{{old('nama_proyek')}}" readonly>
						</div>
					</div> --}}
                    <div class="form-group row" id="div-masaberlaku">
						<label class="col-form-label col-lg-2">Masa Berlaku</label>
						<div class="col-lg-10">
							<input id="masa_berlaku" name="masa_berlaku" type="text" class="form-control"  readonly value="{{!@$proyeks ? old('masa_berlaku') : $proyeks->masa_berlaku}}" placeholder="Tanggal Masa Berlaku">
							{{-- <input type="text" id="kadaluarsa" name="kadaluarsa" class="form-control border-teal border-1"> --}}
						</div>
						{{-- <span id="kadaluarsa" name="kadaluarsa" class="col-form-label col-lg-10 font-weight-bold">{{@$}}</span> --}}
					</div>

                    @if (@$tagihan->proyek->jenis_layanan==4 || @$tagihan->proyek->jenis_proyek==2 || @$proyeks->jenis_layanan==4 || @$proyeks->jenis_proyek==2)

                    @else
                        <div id="new-masa" class="form-group row">
                            <label class="col-form-label col-lg-2">Update Masa Berlaku</label>
                            <div class="col-lg-10">
                                <input id="new_mb" name="new_mb" type="text" class="form-control border-teal border-1 pickadate-accessibility" placeholder="Ubah jika ingin perpanjang masa berlaku">
                            </div>
                        </div>
                    @endif

					<div class="form-group row">
						<label class="col-form-label col-lg-2">Nominal</label>
						<div class="col-lg-10">
							<input id="datanominal" type="hidden" name="nominal" value="{{old('nominal')}}" class="form-control border-teal border-1">
							<input id="nilainominal" type="text" class="form-control border-teal border-1" placeholder="Nominal" onkeyup="ribuan()" onchange="updateFitValue()" value="{{old('nominal')}}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Uang Muka</label>
						<div class="col-lg-10">
							<input id="datauang_muka" type="hidden" name="uang_muka" value="{{old('uang_muka')}}" class="form-control border-teal border-1">
							<input id="nilaiuang_muka" type="text" class="form-control border-teal border-1" placeholder="Uang Muka" onkeyup="ribuan()" onchange="updateFitValue()" value="{{old('uang_muka')}}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Cicilan Tenor</label>
						<div class="col-lg-2">
							<input id="datacicilan" type="hidden" value="{{old('cicilan')}}" class="form-control border-teal border-1">
							<input type="number" name="cicilan" id="jumlahKolom" class="form-control border-teal border-1" placeholder="Tenor" onkeyup="rupiah()"  oninput="updateFitValue()" value="{{old('cicilan')}}">
						</div>
					</div>
					<div id="cicilan"></div>
					<script>

					function formatNumberWithDotSeparator(number) {
						return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
					}

					// Function to update the fit value in each column
					function updateFitValue() {
						const nominalValue = parseFloat(document.getElementById("nilainominal").value.replace(/[^\d.-]/g, "")); // Extract numeric value from "Nominal" field
						const uangMukaValue = parseFloat(document.getElementById("nilaiuang_muka").value.replace(/[^\d.-]/g, "")); // Extract numeric value from "Uang Muka" field
						const jumlahKolom = parseInt(document.getElementById("jumlahKolom").value);
						const fitValue = (nominalValue - uangMukaValue) / jumlahKolom;

						// Update fit value in each column
						const cicilanInputs = document.querySelectorAll("#cicilan input");
						cicilanInputs.forEach((input, index) => {
							input.value = formatNumberWithDotSeparator(fitValue.toFixed(6)); // Display the fit value with 2 decimal places and dot as thousands separator
						});
					}

					document.getElementById("jumlahKolom").addEventListener("input", (event) => {
						const jumlahCicilan = event.target.valueAsNumber;
						const cicilanDiv = document.getElementById("cicilan");
						cicilanDiv.innerHTML = "";
						for (let i = 1; i <= jumlahCicilan; i++) {
							$('#cicilan').append(`
								<div class="col-lg-2 offset-lg-2">
									Cicilan ${i}
									<input type="text" name="jml_cicilan[]" id="nilaicicilan${i}" class="form-control border-teal border-1" placeholder="Tenor" onkeyup="rupiah(this)" value="{{old('cicilan')}}"><br>
								</div>
							`);

							// Add the onkeyup event listener to each dynamically generated input field
							const dynamicInput = document.getElementById(`nilaicicilan${i}`);
							dynamicInput.addEventListener("keyup", (event) => rupiah(event.target));
						}

						// Update fit value when the number of columns changes
						updateFitValue();
					});

					// Update fit value when "Nominal" or "Uang Muka" fields change
					document.getElementById("nilainominal").addEventListener("input", updateFitValue);
					document.getElementById("nilaiuang_muka").addEventListener("input", updateFitValue);
					</script>

					<div class="form-group row">
						<label class="col-form-label col-lg-2">Potongan Harga</label>
						<div class="col-lg-10">
							<select name="jenis_diskon" class="form-control select" id="jenis_diskon">
								<option value="">-- Berikan Potongan Harga --</option>
								<option value="persen_diskon">Persentase</option>
								<option value="nominal_diskon">Nominal</option>
							</select>
						</div>
					</div>
					<div id="div-persen-diskon" class="form-group row" style="display: none">
						<label class="col-form-label col-lg-2">Persentase Potongan</label>
						<div class="col-lg-10">
							<input id="persentase_diskon" type="number" name="persen_diskon" class="form-control border-teal border-1" placeholder="Persentase potongan, contoh: 10 untuk 10%">
						</div>
					</div>
					<div id="div-nominal-diskon" class="form-group row" style="display: none">
						<label class="col-form-label col-lg-2">Nominal Potongan</label>
						<div class="col-lg-10">
							<input id="datadiskon" type="hidden" name="nominal_diskon">
							<input id="nilaidiskon" type="text" name="nominal_diskon_alter" class="form-control border-teal border-1" placeholder="Nominal Diskon, contoh: 100000" onkeyup="ribuan()" value="{{old('nominal_diskon')}}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Status Rekap</label>
						<div class="col-lg-10">
							<select name="buat_rekap" class="form-control select" id="status_rekap">
								<option value="0">Buatkan nanti</option>
								<option value="1">Buatkan sekarang</option>
							</select>
						</div>
					</div>
					<div id="div-status-invoice" class="form-group row" style="display: none">
						<label class="col-form-label col-lg-2">Status Invoice</label>
						<div class="col-lg-10">
							<select name="buat_invoice" class="form-control select">
								<option value="0">Tanpa invoice</option>
								<option value="1">Buatkan invoice</option>
							</select>
						</div>
					</div>
					<div class="form-group row" style="display: none">
						<input type="hidden" name="diskon">
					</div>
					{{-- <div class="form-group row">
						<label class="col-form-label col-lg-2">Langganan</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="langganan" class="form-control border-teal border-1" placeholder="Nominal" value="{{old('langganan')}}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Ads</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="ads" class="form-control border-teal border-1" placeholder="Nominal" value="{{old('nominal')}}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Lainnya</label>
						<div class="col-lg-10">
							<input type="number" min="0" name="lainnya" class="form-control border-teal border-1" placeholder="Nominal" value="{{old('lainnya')}}">
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-form-label col-lg-2">Nama Penagih</label>
						<div class="col-lg-10">
							<input type="text" id="penagih" name="penagih" class="form-control border-teal border-1" placeholder="Nama Penagih" value="{{@$penagih->penagih}}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Posisi Penagih</label>
						<div class="col-lg-10">
							<input type="text" id="pospenagih" name="pospenagih" class="form-control border-teal border-1" placeholder="Nama Penagih" value="{{@$penagih->pospenagih}}">
						</div>
					</div> --}}
					<div class="form-group row">
						<label class="col-form-label col-lg-2">Keterangan</label>
						<div class="col-lg-10">
							{{-- <div class="summernote form-control border-teal border-1" name="keterangan" placeholder="Keterangan" value="{{old('keterangan')}}"></div> --}}
							{{-- <input type="text" name="keterangan" class="summernote form-control border-teal border-1" placeholder="Keterangan" value="{{old('keterangan')}}"> --}}
							<span class="form-text text-muted">Contoh: Pembayaran berlangganan proyek website klien Noer Prajitno</span>
							<textarea name="keterangan" id="" cols="30" rows="10" class="summernote form-control border-teal border-1"></textarea>
						</div>
					</div>
					{{-- <div class="form-group row">
						<label class="col-form-label col-lg-2">Keterangan Tambahan</label>
						<div class="col-lg-10">
							<select name="tambah_keterangan" class="form-control select" id="keterangan_tambahan">
								<option value="0">Tidak Ada</option>
								<option value="1">Ada</option>
							</select>
						</div>
					</div> --}}
					<div class="form-group row" id="div-keterangan-tambahan">
						<label class="col-form-label col-lg-2">Keterangan Tambahan</label>
						<div class="col-lg-10">
							<span class="form-text text-muted">Contoh: Berlangganan 1 tahun</span>
							<textarea name="keterangan_tambahan" id="" cols="30" rows="10" class="summernote form-control border-teal border-1"></textarea>
						</div>
					</div>
				</fieldset>
				<div class="text-right">
                    <a href="{{ url('/tagihans') }}" class="btn bg-slate"><i class="icon-undo2 mr-2"></i>Kembali</a>
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
<script src="{{ asset('global_assets/js/plugins/editors/summernote/summernote.min.js') }}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>
<script src="{{ asset('global_assets/js/demo_pages/editor_summernote.js') }}"></script>
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
							var nama_proyek = res['data'][i].nama_proyek;
							var jenis = res['data'][i].jenis_layanan;

							var option = "<option value='"+id+"' data-jenis='"+jenis+"'>"+nama_proyek+"</option>";

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
				$('#masa-berlaku').prop('disabled', 'disabled');
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

		$('#jenis_diskon').on('change', function() {
            var dropdown = $('#jenis_diskon option:selected').val()
            if (dropdown=="persen_diskon" ) {
                $('#div-persen-diskon').show()
				$('#div-nominal-diskon').hide()
			} else if (dropdown=='nominal_diskon') {
				$('#div-persen-diskon').hide()
				$('#div-nominal-diskon').show()
			}
        });

		$('#status_rekap').on('change', function() {
            var dropdown = $('#status_rekap option:selected').val()
            if (dropdown=="1" ) {
                $('#div-status-invoice').show()
			} else {
				$('#div-status-invoice').hide()
			}
        });

		// $('#keterangan_tambahan').on('change', function() {
		// 	if ($('#keterangan_tambahan option:selected').val() == "1") {
		// 		$('#div-keterangan-tambahan').show()
		// 	} else {
		// 		$('#div-keterangan-tambahan').hide()
		// 	}
		// })

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
						nominal:{
							required : true
						},
						user_id:{
							required : true
						},
					},
					messages: {
						select_proyek:{
							required : 'Mohon diisi'
						},
						nominal:{
							required : 'Mohon diisi'
						},
						user_id:{
							required : 'Mohon diisi'
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
				$('.summernote').summernote({
					toolbar: [
					['para', ['ul', 'ol', 'paragraph']],
					],
					height: 100,
					callbacks: {
						onPaste: function (e) {
						var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

						e.preventDefault();

						setTimeout( function(){
							document.execCommand( 'insertText', false, bufferText );
						}, 10 );
						}
					}
				});

				// Control editor height
				$('.summernote-height').summernote({
					height: 400
				});

				// // Air mode
				// $('.summernote-airmode').summernote({
				// 	airMode: true
				// });


				// // // Click to edit
				// // // ------------------------------

				// // // Edit
				// // $('#edit').on('click', function() {
				// // 	$('.click2edit').summernote({focus: true});
				// // })

				// // // Save
				// // $('#save').on('click', function() {
				// // 	var aHTML = $('.click2edit').summernote('code');
				// // 	$('.click2edit').summernote('destroy');
				// // });
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

		function ribuan(){
			var val = $('#nilainominal').val();
			var val1 = $('#nilaiuang_muka').val();
			var val2 = $('#nilaidiskon').val();
			$('#datanominal').val(val.replace(new RegExp(/\./, 'g'), ''));
			$('#datauang_muka').val(val1.replace(new RegExp(/\./, 'g'), ''));
			$('#datadiskon').val(val2.replace(new RegExp(/\./, 'g'), ''));
			val = val.replace(/[^0-9,]/g,'');
			val1 = val1.replace(/[^0-9,]/g,'');
			val2 = val2.replace(/[^0-9,]/g,'');

			if(val != "") {
				valArr = val.split('.');
				valArr[0] = (parseInt(valArr[0],10)).toLocaleString('id-ID');
				val = valArr.join('.');
			}
			if(val1 != "") {
				valArr = val1.split('.');
				valArr[0] = (parseInt(valArr[0],10)).toLocaleString('id-ID');
				val1 = valArr.join('.');
			}
			if(val2 != "") {
				valArr = val2.split('.');
				valArr[0] = (parseInt(valArr[0],10)).toLocaleString('id-ID');
				val2 = valArr.join('.');
			}
			$('#nilainominal').val(val);
			$('#nilaiuang_muka').val(val1);
			$('#nilaidiskon').val(val2);
		}

		function rupiah(inputElement) {
			var val = inputElement.value;

			// Remove all dots from the input value and store it in the hidden input
			$('#datacicilan').val(val.replace(/\./g, ''));

			// Remove all non-numeric and non-comma characters
			val = val.replace(/[^0-9,]/g, '');

			if (val !== "") {
				// Split the value by comma
				var valArr = val.split(',');

				// Format the integer part with thousands separator
				valArr[0] = parseInt(valArr[0], 10).toLocaleString('id-ID');

				// Combine integer and decimal parts with a comma
				val = valArr.join(',');
			}

			inputElement.value = val; // Update the input value
		}
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
				// new PNotify({
				// 	title: 'Error',
				// 	text: 'Nomor Invoice Sudah Terambil, input kembali.',
				// 	icon: 'icon-blocked',
				// 	type: 'error'
				// });

				// @elseif ($errors->has('ninv'))
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
