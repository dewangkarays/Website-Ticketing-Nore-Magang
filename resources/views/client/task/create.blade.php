<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    {{-- font --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;400;700&display=swap" rel="stylesheet">
    {{-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css"> --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    {{-- fixed --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    {{-- wysiwig --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="{{asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        .bg-light {
        background-color: #3EB772 !important;
        }

        body{
        font-family: 'Raleway', sans-serif !important;
        }

        h2{
            font-weight: bold;
            line-height: 14px !important;
        }

        .greeting h1{
                font-weight: bold !important;
        }

        /* .row{
            padding: 1em 0 !important
        } */

        .tagihan{
            padding: 2em 0!important;
        }

        .cardContainer{
            padding: 0 0 2em 0 !important;
        }

        .tanggal{
            padding-top:2em;
        }

        .btn-warning{
          color:#ffff;
        }

        .split{
          padding-top: 6rem;
        }
        
      /* sidebar */
      .wrapper {
      display: flex;
      align-items: 100%;
      /* width: 80%; */
    }

    .divider{
      padding-bottom: 1em;
    }

    .container{
        padding-left:15px !important;
        padding-right:15px !important;
    }

    @media (max-width: 768px) {

      .sidebar{
        display: none;
      }

      .copyright{
        display: none;
      }

      .headerdesktop{
        display:none;
      }
    }

    @media (min-width: 768px) {
      .contact, .header, .greeting, .footer{
        display: none;
      }

      .website h2, .task h2, .tagihan h2, .history h2{
        padding-bottom: 1em;
        opacity: 1;
      }

      .container{
        margin-left:250px;
        transition: all 0.3s;
      }
    }

    @media (min-width: 1200px){
      .container {
      max-width: 100%;
      }
    }

    .navbar{
      padding: .5rem 0 !important;
    }

    .container-fluid{
        padding: 0 !important;
    }

    .container{
      padding-left:15px !important;
      padding-right:15px !important;
    }
    #website{
      opacity: 1;
    }

    </style>
    <title>OP Ticketing</title>
  </head>
  <body>
  @section('title','Task')
  <div class="header">
    @include('client.headermobile')
  </div>
  <div class="wrapper">
  @include('client.sidebar')
  <div class="container">
    <div class="headerdesktop">
      @include('client.headerdesktop')
    </div>
    <div class="data-task">
      <div class="task-head">
        <h3 style="padding-top: 2rem; font-weight:bold;">Form Tambah Task</h3>      
      </div>
      <div class="row">
        <div class="col-sm-6">
          <p>Nama</p>
        </div>
        <div class="col-sm-6">
          <p>{{\Auth::user()->nama}}</p>
        </div>
      </div>
      <form class="form-validate-jquery" method="POST" action="{{route('taskclients.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
          <label class="col-sm-6 col-form-label">Website</label>
          <div class="col-sm-6">
            <select id="website" name="website" class="form-control select-search" data-fouc>
              @foreach($proyeks as $proyek)
                <option value="{{@$proyek->id}}">{{@$proyek->website}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-6 col-form-label">Kebutuhan</label>
          <div class="col-sm-6">
            <textarea name="kebutuhan" class="form-control summernote"  required></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="lampiran" class="col-sm-6 col-form-label">Lampiran<br><p style="font-style:italic; font-size:12px;">*opsional, maksimal ukuran file 10mb</p></label>
          <div class="col-sm-6">
            <input id="lampiran" type="file" name="lampiran" class="form-control">
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-success btn-lg btn-block" href="/taskclient">Tambah</button>
      </form>
    </div>
    {{-- <div class="copyright" style="margin-left:250px; text-align: center">
      <p>2020. Nore Inovasi.</p>
    </div> --}}
  </div>
</div>
<div class="footer">
  <div class="split"></div>
  @include('client.footer')
</div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    {{-- tambahan --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    {{-- Option 2: jQuery, Popper.js, and Bootstrap JS --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script> --}}
    {{-- Summernote --}}
    <script src="{{asset('global_assets/js/plugins/editors/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
	  <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    

    
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
    
                        // // Unstyled checkboxes, radios
                        // if (element.parents().hasClass('form-check')) {
                        //     error.appendTo( element.parents('.form-check').parent() );
                        // }
    
                        // // Input with icons and Select2
                        // else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                        //     error.appendTo( element.parent() );
                        // }
    
                        // // Input group, styled file input
                        // else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                        //     error.appendTo( element.parent().parent() );
                        // }
    
                        // Other elements
                        // else {
                            error.insertAfter(element);
                        // }
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
      <script>
        $(document).ready(function() {
          $('.summernote').summernote();
        });
      </script>
  </body>
</html>