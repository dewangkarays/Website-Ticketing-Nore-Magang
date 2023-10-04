@extends('layout')

@section('css')
<style>
    .summernote ol, ul {
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
            <h4><span class="font-weight-semibold">Home</span> - Tambah Patchlist</h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<!-- Content area -->
<div class="content">
    <!-- Hover rows -->
    <div class="card">
        <div class="card-header header-elements-inline">
        </div>
        <div class="card-body">
            <form id="form_patchlist" class="form-validate-jquery" action="{{ route('patchlist.store')}}" method="post">
                @csrf
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Patchlist</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Klien</label>
                        <div class="col-lg-10">
                            <select name="klien" id="klien" class="form-control select-search">
                                <option value="">-- Pilih Klien --</option>
                                @foreach($klienList as $id => $nama)
                                    <option value="{{ $id }}">{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Nama Proyek</label>
                        <div class="col-lg-10">
                            <select id="nama_proyek" name="nama_proyek" class="form-control select-search">
                                <option value="">-- Pilih Proyek --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Nama Patchlist</label>
                        <div class="col-lg-10">
                            <input type="text" name="patchlist" class="form-control border-teal border-1"
                                placeholder="Contoh : Nama Patchlist">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Prioritas</label>
                        <div class="col-lg-10">
                            <select name="prioritas" class="form-control">
                                @foreach(config('custom.prioritas') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Kesulitan</label>
                        <div class="col-lg-10">
                            <select name="kesulitan" class="form-control">
                                @foreach(config('custom.kesulitan') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Status</label>
                        <div class="col-lg-10">
                            <select name="status" class="form-control">
                                @foreach(config('custom.status') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Keterangan</label>
                        <div class="col-lg-10">
                            <span class="form-text text-muted">Contoh: Deskripsi Patchlist</span>
                            <textarea name="keterangan" cols="30" rows="10"
                                class="summernote form-control border-teal border-1"
                                required>{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <a href="{{ url('/patchlist') }}" class="btn bg-slate"><i class="icon-undo2 mr-2"></i>Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan <i class="icon-paperplane ml-2"></i></button>
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
<script src="{{ asset('global_assets/js/plugins/editors/summernote/summernote.min.js') }}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
<script src="{{ asset('global_assets/js/demo_pages/editor_summernote.js') }}"></script>
<script type="text/javascript">

</script>

<script type="text/javascript">
    $(document).ready(function() {
    });
</script>

<script>
    $(document).ready(function() {
        $('#klien').select2();
        $('#nama_proyek').select2();
        $('#klien').change(function() {
            var user_id = $(this).val();
            if (user_id !== '') {
                $.ajax({
                    url: '{{ route('getNamaProyekByUserId') }}',
                    type: 'GET',
                    data: { user_id: user_id },
                    success: function(data) {
                        console.log(data);
                        var namaProyekDropdown = $('#nama_proyek');
                        namaProyekDropdown.empty();
                        namaProyekDropdown.append($('<option>', {
                            value: '',
                            text: '-- Pilih Proyek --'
                        }));
                        $.each(data, function(key, value) {
                            namaProyekDropdown.append($('<option>', {
                                value: key,
                                text: value
                            }));
                        });
                    }
                });
            } else {
                $('#nama_proyek').empty().append($('<option>', {
                    value: '',
                    text: '-- Pilih Proyek --'
                }));
            }
        });
    });

    //sumernote wysiwyg
    var Summernote = function() {
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

@endsection
