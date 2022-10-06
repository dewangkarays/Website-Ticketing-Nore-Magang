@extends('layout')
@section('css')
    <style>
        table tbody {
            width: 100%;
        }
        .center {
            text-align: center;
        }
        .left-sticky {
            position: sticky;
            left: 0;
            background: white;
        }
        table thead th {
            position: sticky;
            top: 0;
            background: white;
            z-index:1;
        }
        .top-sticky {
            position: sticky;
            left: 0;
            z-index: 2;
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
    @if(\Auth::user()->role == 1 || \Auth::user()->role == 20)
    <!-- Content area for superadmin and Finance-->
    <div class="content">
        <!-- Hover rows -->
		<div id="card-presensi" class="card">
            <div class="card-header header-elements-inline">
				<a href="{{ route('presensi.create') }}"><button type="button" class="btn btn-success rounded-round"><i class="icon-help mr-2"></i> Presensi</button></a>
                <div class="col-lg-3 d-flex">
                    <select id="tahun" name="tahun" class="form-control select-search">
                            <option value="">--Tahun--</option>
                            @foreach ($years as $year)
                            <option value={{ $year->tahun }}>{{ $year->tahun }}</option>
                            @endforeach
                    </select>
                    <select id="bulan" name="bulan" class="form-control select-search">
                        <option value="">--Bulan--</option>
                        @foreach(config('custom.bulan') as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    {{-- <a href=""><button id="filter" class="ml-2 btn btn-primary">Filter</button></a> --}}

                </div>
            </div>

            <div class="card-body">
                    <table id="table" class="table datatable-basic table-hover" style="display: block;overflow-x: auto;table-layout: auto;width: 100%;max-height:500px;">
                        <thead id="head">
                            <tr> 
                                <th>No</th>
                                <th id="nama" data-role="{{ \Auth::user()->role }}" data-user_id="{{\Auth::user()->id }}">Nama</th>
                                @for($i=0;$i<count($tanggal);$i++)
                                <th class="tanggal">{{ $tanggal[$i] }}</th>
                                @endfor
                                {{-- @foreach ($presensi_all as $pres)
                                <th class="center">{{ $pres->tanggal }}</th>
                                @endforeach --}}
                                
                                {{-- <th class="text-center">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody id="presensi">
                            {{-- <tr>

                            </tr> --}}
                            {{-- @for($k=0;$k<count($karyawans_all);$k++)
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
                            @endfor --}}
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
                                <th>Hadir</th>
                                <td id="hadir"></td>
                            </tr>
                            <tr>
                                <th>Sakit</th>
                                <td id="sakit"></td>
                            </tr>
                            <tr>
                                <th>Izin</th>
                                <td id="izin"></td>
                            </tr>
                            <tr>
                                <th>WFH</th>
                                <td id="wfh"></td>
                            </tr>
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
                        @foreach ($years as $year)
                        <option value={{ $year->tahun }}>{{ $year->tahun }}</option>
                        @endforeach
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
                        <thead  id="head">
                            <tr> 
                                <th>Nama</th>
                                @for($i=0;$i<count($tanggal);$i++)
                                <th class="tanggal">{{ $tanggal[$i] }}</th>
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
                                    <th>Hadir</th>
                                    <td id="hadir"></td>
                                </tr>
                                <tr>
                                    <th>Sakit</th>
                                    <td id="sakit"></td>
                                </tr>
                                <tr>
                                    <th>Izin</th>
                                    <td id="izin"></td>
                                </tr>
                                <tr>
                                    <th>WFH</th>
                                    <td id="wfh"></td>
                                </tr>
                                <tr>
                                    <th>Sisa Cuti</th>
                                    <td id="sisa_cuti"></td>
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
    <script src="{{ asset('global_assets\js\main\bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script> --}}
    <script>
        $(function(){
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

        $('#tahun').val(tahun).trigger('change');
        $('#bulan').val(bulan).trigger('change');

        // $('[data-toggle="popover"]').popover() 
    });
    </script>
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
        if (role == 20) {
            user_id = 1;
        }
        // console.log(user_id);
        // console.log(role);
        if(role != 1 && role != 20){
            $.ajax({
                url : '/getpresensi/'+tahun+'/'+bulan+'/'+user_id+'',
                type: 'get',
                dataType: 'json',
                success : function(karyawans){
                    console.log("if success");
                $('#head').empty();
                $('#head').append('<th>Nama</th>');
                for(var m=0;m<new_all_days.length;m++) {
                $('#head').append('<th>'+new_all_days[m].substr(8)+'</th>');
                }
                var presensi = [];
                var j = 0;
                var hadir = [];
                var h = 0;
                var sakit = [];
                var s = 0;
                var izin = [];
                var z = 0;
                var wfh = [];
                var w = 0;
                $('#presensi').empty();
                $('#presensi').append('<td id="nama" data-user_id="{{\Auth::user()->id }}">{{\Auth::user()->nama }}</td>');
                // console.log(karyawans);
                // console.log(karyawans[0].presensi.length);
                for(var i=0;i<new_all_days.length;i++) {
                    if (karyawans[0].presensi[j] != undefined){
                    if(new_all_days[i]==karyawans[0].presensi[j]['tanggal']) {
                        if(karyawans[0].presensi[j]['status'] == 1) {
                            presensi[i] = '<td class="center"> v </td>';
                            hadir[h] = karyawans[0].presensi[j];
                            h ++;
                            $('#presensi').append(presensi[i]);
                            // presensi[i] = 'v';
                                if(j < karyawans[0].presensi.length){
                                j++;
                            }
                            }else if(karyawans[0].presensi[j]['status'] == 2) {
                            var detail_izin = karyawans[0].presensi[j]['id'];
                            presensi[i] = '<td id="'+karyawans[0].presensi[j]['id']+'" class="center"><a style="text-decoration: none;color: inherit;" href="presensi/'+detail_izin+'"> i </a></td>';
                            izin[z] = karyawans[0].presensi[j];
                            z ++;
                            $('#presensi').append(presensi[i]);
                            $('#'+karyawans[0].presensi[j]['id']+'').popover({offset: 10});
                            // presensi[i] = 'i';
                                if(j < karyawans[0].presensi.length) {
                                j++;
                            }
                            }else if(karyawans[0].presensi[j]['status'] == 3){
                            var detail_sakit = karyawans[0].presensi[j]['id'];
                            presensi[i] = '<td id="'+karyawans[0].presensi[j]['id']+'" class="center"><a style="text-decoration: none;color: inherit;" href="presensi/'+detail_sakit+'"> s </a></td>';
                            sakit[s] = karyawans[0].presensi[j];
                            s ++;
                            $('#presensi').append(presensi[i]);
                            $('#'+karyawans[0].presensi[j]['id']+'').popover({offset: 10});
                            // presensi[i] = 's';
                                if(j < karyawans[0].presensi.length) {
                                j++;
                            }
                            }else{
                            var detail_wfh = karyawans[0].presensi[j]['id'];
                            presensi[i] = '<td id="'+karyawans[0].presensi[j]['id']+'" class="center"><a style="text-decoration: none;color: inherit;" href="presensi/'+detail_wfh+'"> WFH </a></td>';
                            wfh[w] = karyawans[0].presensi[j];
                            w ++;
                            $('#presensi').append(presensi[i]);
                            $('#'+karyawans[0].presensi[j]['id']+'').popover({offset: 10});
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
                $('#hadir').empty();
                $('#izin').empty();
                $('#sakit').empty();
                $('#wfh').empty();
                $('#hadir').append(hadir.length);
                $('#izin').append(izin.length);
                $('#sakit').append(sakit.length);
                $('#wfh').append(wfh.length);
                }
            });
        } else {
            $.ajax({
                url : '/getpresensi/'+tahun+'/'+bulan+'/'+user_id+'',
                type: 'get',
                dataType: 'json',
                success : function(karyawans){
                    console.log("else success");
                $('#head').empty();
                $('#head').append('<th>No</th>');
                $('#head').append('<th id="nama" data-role="{{ \Auth::user()->role }}" class="top-sticky" data-user_id="{{\Auth::user()->id }}">Nama</th>');
                for(var n=0;n<new_all_days.length;n++) {
                $('#head').append('<th>'+new_all_days[n].substr(8)+'</th>');
                }
                var presensi = [];
                var hadir = [];
                var h = 0;
                var sakit = [];
                var s = 0;
                var izin = [];
                var z = 0;
                var wfh = [];
                var w = 0;
                $('#presensi').empty();
                // $('#presensi').append('<td id="nama" data-user_id="{{\Auth::user()->id }}">{{\Auth::user()->nama }}</td>');
                // console.log(karyawans);
                // console.log(karyawans[0].presensi.length);
                for (var k=0;k<karyawans.length;k++) {
                // $('#presensi').empty();
                var j = 0;
                $('#presensi').append('<tr id="row'+k+'"></tr>')
                $('#row'+k+'').append('<td>'+(k + 1)+'</td>')
                $('#row'+k+'').append('<td class="left-sticky">'+karyawans[k].nama+'</td>')
                for(var i=0;i<new_all_days.length;i++) {
                    if (karyawans[k].presensi[j] != undefined){
                    if(new_all_days[i]==karyawans[k].presensi[j]['tanggal']) {
                        if(karyawans[k].presensi[j]['status'] == 1) {
                            presensi[i] = '<td class="center"> v </td>';
                            hadir[h] = karyawans[k].presensi[j];
                            h ++;
                            $('#row'+k+'').append(presensi[i]);
                            // presensi[i] = 'v';
                                if(j < karyawans[k].presensi.length){
                                j++;
                            }
                            }else if(karyawans[k].presensi[j]['status'] == 2) {
                            var detail_izin = karyawans[k].presensi[j]['id'];
                            // console.log(link);
                            presensi[i] = '<td id="'+karyawans[k].presensi[j]['id']+'" class="center"><a style="text-decoration: none;color: inherit;" href="presensi/'+detail_izin+'"> i </a></td>';
                            izin[z] = karyawans[k].presensi[j];
                            z ++;
                            $('#row'+k+'').append(presensi[i]);
                            $('#'+karyawans[k].presensi[j]['id']+'').popover({offset: 10});
                            // presensi[i] = 'i';
                                if(j < karyawans[k].presensi.length) {
                                j++;
                            }
                            }else if(karyawans[k].presensi[j]['status'] == 3){
                            var detail_sakit = karyawans[k].presensi[j]['id'];
                            presensi[i] = '<td id="'+karyawans[k].presensi[j]['id']+'" class="center"><a style="text-decoration: none;color: inherit;" href="presensi/'+detail_sakit+'"> s </a></td>';
                            sakit[s] = karyawans[k].presensi[j];
                            s ++;
                            $('#row'+k+'').append(presensi[i]);
                            $('#'+karyawans[k].presensi[j]['id']+'').popover({offset: 10});
                            // presensi[i] = 's';
                                if(j < karyawans[k].presensi.length) {
                                j++;
                            }
                            }else{
                            var detail_wfh = karyawans[k].presensi[j]['id'];
                            presensi[i] = '<td id="'+karyawans[k].presensi[j]['id']+'" class="center"><a style="text-decoration: none;color: inherit;" href="presensi/'+detail_wfh+'"> WFH </a></td>';
                            wfh[w] = karyawans[k].presensi[j];
                            w ++;
                            $('#row'+k+'').append(presensi[i]);
                            $('#'+karyawans[k].presensi[j]['id']+'').popover({offset: 10});
                            // presensi[i] = 's';
                                if(j < karyawans[k].presensi.length) {
                                j++;
                            }
                            }
                    }else {
                        presensi[i] = '<td class="center"> . </td>';
                        $('#row'+k+'').append(presensi[i]);
                        // presensi[i] = '.';
                    }
                }else {
                        presensi[i] = '<td class="center"> . </td>';
                        $('#row'+k+'').append(presensi[i]);
                        // presensi[i] = '.';
                    }
                    // console.log(presensi);
                }
            }
            $('#hadir').empty();
            $('#izin').empty();
            $('#sakit').empty();
            $('#wfh').empty();
            $('#hadir').append(hadir.length);
            $('#izin').append(izin.length);
            $('#sakit').append(sakit.length);
            $('#wfh').append(wfh.length);
                }
            });
        }
    })
    })
        
    </script>
    <script>
        // menghitung sisa cuti karyawan
        var user_id = $('#nama').data('user_id');
        var role = $('#nama').data('role');
        var tahun = new Date().getFullYear();
        // console.log(user_id);
        if(role != 1){
        $('#tahun').on('change', function(){
            tahun = $(this). children("option:selected").val();

        $.ajax({
                url : '{{ url("gettotalizin")}}/'+tahun+user_id,
                type: 'get',
                dataType: 'json',
                success : function(izin){
                var total_izin = izin[0].presensi.length;
                $('#sisa_cuti').empty();
                $('#sisa_cuti').append(12 - total_izin);
                }
        })
    })
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
		});
	</script>
@endsection