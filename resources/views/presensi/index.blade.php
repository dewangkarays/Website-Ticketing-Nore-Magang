@extends('layout')
@section('css')
    <style>
        table tbody {
            width: 100%;
        }
        .center {
            text-align: center;
        }
    </style>
@endsection
@section('content')
     <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> -  Presensi</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->
    @if(\Auth::user()->role == 1)
    <!-- Content area for superadmin-->
    <div class="content">
        <!-- Hover rows -->
		<div id="card-presensi" class="card">
            <div class="card-header header-elements-inline">
				<a href="{{ route('presensi.create') }}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Presensi</button></a>
                <div class="col-lg-3 d-flex">
                    <select id="tahun" name="tahun" class="form-control select-search">
                            <option value="">--Tahun--</option>
                            <option value=2019>2019</option>
                            <option value=2020>2020</option>
                            <option value=2021>2021</option>
                            <option value=2022>2022</option>
                    </select>
                    <select id="bulan" name="bulan" class="form-control select-search">
                        <option value="">--bulan--</option>
                        @foreach(config('custom.bulan') as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    {{-- <a href=""><button id="filter" class="ml-2 btn btn-primary">Filter</button></a> --}}

                </div>
            </div>
            

            <div class="card-body">
                    <table id="table" class="table datatable-basic table-hover" style="display: block;overflow-x: auto">
                        <thead>
                            <tr> 
                                <th>No</th>
                                <th id="nama" data-role="{{ \Auth::user()->role }}">Nama</th>
                                @for($i=0;$i<count($tanggal);$i++)
                                <th class="tanggal">{{ $tanggal[$i] }}</th>
                                @endfor
                                {{-- @foreach ($presensi_all as $pres)
                                <th class="center">{{ $pres->tanggal }}</th>
                                @endforeach --}}
                                
                                {{-- <th class="text-center">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @for($k=0;$k<count($karyawans_all);$k++)
                            <tr> 
                                <td>{{ $k + 1 }}</td>
                                @php($j = 0)
                                <td>{{ $karyawans_all[$k]['nama'] }}</td>
                                @for($i=0;$i<count($dates);$i++)
                                    @if(count($karyawans_all[$k]['presensi']) != 0)
                                        @if($dates[$i]==@$karyawans_all[$k]['presensi'][$j]['tanggal'])
                                            @if($karyawans_all[$k]['presensi'][$j]['status'] == 1)
                                                <td class="center"> v </td>
                                                    @if($j < count($karyawans_all[$k]['presensi']))
                                                    @php($j++)
                                                    @endif
                                                @elseif($karyawans_all[$k]['presensi'][$j]['status'] == 2)
                                                <td class="center"> i </td>
                                                    @if($j < count($karyawans_all[$k]['presensi']))
                                                    @php($j++)
                                                    @endif
                                                @else
                                                <td class="center"> s </td>
                                                    @if($j < count($karyawans_all[$k]['presensi']))
                                                    @php($j++)
                                                    @endif
                                            @endif
                                        @else
                                            <td class="center"> . </td>
                                        @endif
                                    @else
                                        <td class="center"> kosong </td>
                                    @endif
                                @endfor
                            </tr>
                            @endfor
                            {{-- <tr id="presensi"> 

                            </tr> --}}
                        </tbody>
                    </table>
            </div>
		</div>
        <div class="col-xl-4 p-0">
            <!-- Basic Table -->
            <div class="card">
                <div class="card-body">
                    <div class="chart-container">
                        <table class="table datatable-basic table-hover">
                                <tr>
                                    <th>Sakit</th>
                                    <td>{{ $sakit_all }}</td>
                                </tr>
                                <tr>
                                    <th>Izin</th>
                                    <td>{{ $izin_all }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Sisa Cuti</th>
                                    <td>{{ $sisa_cuti }}</td>
                                </tr> --}}
                        </table>
                    </div>
                </div>
            </div>
            <!-- /basic donut -->
        </div>
		<!-- /hover rows -->
    </div>
    @else
    <!-- Content area for karyawans-->
    <div class="content">
        <!-- Hover rows -->
		<div id="card-presensi" class="card">
            <div class="card-header header-elements-inline">
				<a href="{{ route('presensi.create') }}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Presensi</button></a>
                <div class="col-lg-3 d-flex">
                    <select id="tahun" name="tahun" class="form-control select-search">
                            <option value="">--Tahun--</option>
                            <option value=2019>2019</option>
                            <option value=2020>2020</option>
                            <option value=2021>2021</option>
                            <option value=2022>2022</option>
                    </select>
                    <select id="bulan" name="bulan" class="form-control select-search">
                        <option value="">--bulan--</option>
                        @foreach(config('custom.bulan') as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    {{-- <a href=""><button id="filter" class="ml-2 btn btn-primary">Filter</button></a> --}}

                </div>
			</div>

            <div class="card-body">

                    <table id="table" class="table datatable-basic table-hover" style="display: block;overflow-x: auto">
                        <thead>
                            <tr> 
                                <th>Nama</th>
                                @for($i=0;$i<count($dates);$i++)
                                <th class="tanggal">{{ $dates[$i] }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr> 
                                <td>1</td>
                                @php($j = 0)
                                <td id="nama" data-user_id=" {{ \Auth::user()->id }}">{{ \Auth::user()->nama }}</td>
                                @for($i=0;$i<count($dates);$i++)
                                    @if($dates[$i]==$karyawans[0]['presensi'][$j]['tanggal'])
                                        @if($karyawans[0]['presensi'][$j]['status'] == 1)
                                            <td class="center"> v </td>
                                                @if($j < count($karyawans[0]['presensi']))
                                                @php($j++)
                                                @endif
                                            @elseif($karyawans[0]['presensi'][$j]['status'] == 2)
                                            <td class="center"> i </td>
                                                @if($j < count($karyawans[0]['presensi']))
                                                @php($j++)
                                                @endif
                                            @else
                                            <td class="center"> s </td>
                                                @if($j < count($karyawans[0]['presensi']))
                                                @php($j++)
                                                @endif
                                        @endif
                                    @else
                                        <td class="center"> . </td>
                                    @endif
                                @endfor
                            </tr> --}}
                            <tr id="presensi">
                                <td id="nama" data-user_id="{{\Auth::user()->id }}">{{\Auth::user()->nama }}</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
		</div>
		<!-- /hover rows -->
        <div class="col-xl-4 p-0">
            <!-- Basic Table -->
            <div class="card m-2">
                <div class="card-body">
                    <div class="chart-container">
                        <table id="table" class="table datatable-basic table-hover">
                                <tr>
                                    <th>Sakit</th>
                                    <td>{{ $sakit }}</td>
                                </tr>
                                <tr>
                                    <th>Izin</th>
                                    <td>{{ $izin }}</td>
                                </tr>
                                <tr>
                                    <th>Sisa Cuti</th>
                                    <td>{{ $sisa_cuti }}</td>
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /basic donut -->
        </div>
    </div>    
    @endif

    <!-- Danger Modal -->
	<div id="modal_theme_danger" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="delform">
				    @csrf
				    {{-- @method('DELETE') --}}
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
	<!-- /danger modal -->
@endsection

@section('js')
    <script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/components_modals.js')}}"></script>
    {{-- <script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script> --}}
    <script>
        // change date to local timezone
        function toIsoString(date) {
            var tzo = -date.getTimezoneOffset(),
                dif = tzo >= 0 ? '+' : '-',
                pad = function(num) {
                    return (num < 10 ? '0' : '') + num;
                };

            return date.getFullYear() +
                '-' + pad(date.getMonth() + 1) +
                '-' + pad(date.getDate()) +
                'T' + pad(date.getHours()) +
                ':' + pad(date.getMinutes()) +
                ':' + pad(date.getSeconds()) +
                dif + pad(Math.floor(Math.abs(tzo) / 60)) +
                ':' + pad(Math.abs(tzo) % 60);
            }

        var tahun = new Date().getFullYear();
        var bulan = new Date().getMonth() + 1;

        $('#tahun').on('change', function(){
            tahun = $(this). children("option:selected").val();
        
        $('#bulan').on('change', function(){
            bulan = $(this). children("option:selected").val();
            // console.log(tahun);
            // console.log(bulan);
        
        var filter = tahun + "/" + bulan + "/ 01";
        
        function getAllDaysInMonth(year, month) {
            const date = new Date(filter);
            const dates = [];

            while (date.getMonth() === month) {
                dates.push(new Date(date));
                date.setDate(date.getDate() + 1);
            }
            return dates;
            }
        
        var tanggal = new Date(filter);
        var all_days = getAllDaysInMonth(tanggal.getFullYear(), tanggal.getMonth());

        const new_all_days = [];
        for (var i = 0;i<all_days.length;i++){
            new_all_days[i] = toIsoString(all_days[i]).replace(/T.+/, '')
        }
        // console.log(new_all_days.length);
    
        // console.log(('0'+bulan).length)
        if (bulan.length == 1) {
            bulan = '0'+bulan;
        }
        var user_id = $('#nama').data('user_id');
        var role = $('#nama').data('role');
        // console.log(user_id);
        // if(role != 1){
            $.ajax({
                url : '{{ url("getpresensi")}}/'+tahun+bulan+user_id,
                type: 'get',
                dataType: 'json',
                success : function(karyawans){
                var presensi = [];
                var j = 0;
                $('#presensi').empty();
                $('#presensi').append('<td id="nama" data-user_id="{{\Auth::user()->id }}">{{\Auth::user()->nama }}</td>');
                // console.log(karyawans);
                // console.log(karyawans[0].presensi.length);
                for(var i=0;i<new_all_days.length;i++) {
                    if (karyawans[0].presensi[j] != undefined){
                    if(new_all_days[i]==karyawans[0].presensi[j]['tanggal']) {
                        if(karyawans[0].presensi[j]['status'] == 1) {
                            presensi[i] = '<td class="center"> v </td>';
                            $('#presensi').append(presensi[i]);
                            // presensi[i] = 'v';
                                if(j < karyawans[0].presensi.length){
                                j++;
                            }
                            }else if(karyawans[0].presensi[j]['status'] == 2) {
                            presensi[i] = '<td class="center"> i </td>';
                            $('#presensi').append(presensi[i]);
                            // presensi[i] = 'i';
                                if(j < karyawans[0].presensi.length) {
                                j++;
                            }
                            }else{
                            presensi[i] = '<td class="center"> s </td>';
                            $('#presensi').append(presensi[i]);
                            // presensi[i] = 's';
                                if(j < karyawans[0].presensi.length) {
                                j++;
                            }
                            }
                    }else {
                        presensi[i] = '<td class="center"> . </td>';
                        $('#presensi').append(presensi[i]);
                        // presensi[i] = '.';
                    }
                }else {
                        presensi[i] = '<td class="center"> . </td>';
                        $('#presensi').append(presensi[i]);
                        // presensi[i] = '.';
                    }
                    // console.log(presensi);
                }
                }
            });
        // } 
    })
    })
        // else {
        //     $.ajax({
        //         url : '{{ url("getpresensi") }}/'+1,
        //         type: 'get',
        //         dataType: 'json',
        //         success : function(presensi){
        //             // console.log(presensi.length);
        //             for(var k = 0;k<presensi.length;k++){
        //                 $('#presensi').append('<tr id='+k+'></tr>')
        //                 for(var i = 0;i<presensi[k].length;i++){
        //                 $('#presensi').append('<td class="center">'+presensi[k][i]+'</td>');
        //                 }
        //             }
        //         }
        //     });
        // }
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