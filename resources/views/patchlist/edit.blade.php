@extends('layout')
@section('css')
<style>
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
            <h4><span class="font-weight-semibold">Home</span> - Edit Patchlist</h4>
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
        <form id="form_patchlist" class="form-validate-jquery" action="{{ route('patchlist.update', $patchlist->id) }}" method="post">
                @csrf
                @method('PUT')
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Edit Patchlist</legend>

                    

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Nama Patchlist</label>
                        <div class="col-lg-10">
                            <input type="text" name="patchlist" class="form-control border-teal border-1"
                                value="{{ old('patchlist', $patchlist->patchlist) }}" placeholder="Contoh : Nama Patchlist">
                            @error('patchlist')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Prioritas</label>
                        <div class="col-lg-10">
                            <select name="prioritas" class="form-control">
                                @foreach(config('custom.prioritas') as $key => $value)
                                    <option value="{{ $key }}" {{ $patchlist->prioritas == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Kesulitan</label>
                        <div class="col-lg-10">
                            <select name="kesulitan" class="form-control">
                                @foreach(config('custom.kesulitan') as $key => $value)
                                    <option value="{{ $key }}" {{ $patchlist->kesulitan == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Status</label>
                        <div class="col-lg-10">
                            <select name="status" class="form-control">
                                @foreach(config('custom.status') as $key => $value)
                                    <option value="{{ $key }}" {{ $patchlist->status == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Keterangan</label>
                        <div class="col-lg-10">
                            <span class="form-text text-muted">Contoh: Deskripsi Patchlist</span>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="summernote form-control border-teal border-1" required>{{ $patchlist->keterangan }}</textarea>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <a href="{{ route('patchlist.index') }}" class="btn bg-slate"><i class="icon-undo2 mr-2"></i>Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan <i class="icon-floppy-disk ml-2"></i></button>
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
<script src="{{ asset('global_assets/js/demo_pages/editor_summernote.js') }}"></script>

<script>

    $('.form-control-uniform').uniform({
        radioClass: 'choice',
        wrapperClass: 'border-teal-300 text-teal-800'
    });

    $(document).ready(function () {
        // Initialize with options
        $('.select').select2();
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

</script>
@endsection
