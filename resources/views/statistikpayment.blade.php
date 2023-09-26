@extends('layout')

@section('css')
	<style type="text/css">
		@media only screen and (min-width: 768px) {
		  /* For mobile phones: */
		  [class*="btnstat"] {
		    position: absolute; 
		  }
		}
		td{
            text-transform: capitalize;
        }
	</style>
@endsection

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Statistik Pembayaran</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">

		<!-- Zoom option -->
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">Pembayaran Pertahun</h5>
			</div>

			<div class="card-body">
				<div class="chart-container">
					<form action="{{route('stat_payment')}}" method="post">
						@csrf
						<div class="form-group row">
							<div class="col-lg-3">
								<label>Tahun :</label>
								<select name="tahun" class="form-control select-search" data-fouc>
									<option value="{{date('Y')}}">{{date('Y')}}</option>
									@foreach($years as $year)
										@if($year->tahun != date('Y'))
										<option value="{{$year->tahun}}" {{ $filter == $year->tahun ? 'selected' : '' }}>{{$year->tahun}}</option>
										@endif
				    				@endforeach
								</select>
							</div>
							<div class="col-lg-3">
								<button type="submit" class="btn btn-outline-primary active btnstat" style="bottom:0;">Pilih</button>
							</div>
						</div>
					</form>
					<hr>
					<div class="chart has-fixed-height" id="columns_basic"></div>
				</div>
			</div>
		</div>
		<!-- /zoom option -->

		<!-- Pie and donut -->
		<div class="row">
			<div class="col-xl-6">

				<!-- Basic pie -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Pembayaran layanan</h5>
					</div>

					<div class="card-body">
						<div class="chart-container">
						<div class="chart has-fixed-height" id="pie_layanan"></div>
						</div>
					</div>
				</div>
				<!-- /basic pie -->

			</div>

			<div class="col-xl-6">

				<!-- Basic Table -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Pembayaran Terakhir</h5>
					</div>

					<div class="card-body">
						<div class="chart-container">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>No</th>
										<th>Pelanggan</th>
										<th style="width:23%">Tanggal</th>
										<th>Jumlah</th>
									</tr>
								</thead>
								<tbody>
								@if(!$clients->isEmpty())
									@php ($i = 1)
									@foreach($clients as $client)
								    <tr>
								        <td>{{$i}}</td>
								        <td><div class="datatable-column-width">{{@$client->user->username? $client->user->username : "-"}}</div></td>
								        <td><div class="datatable-column-width">{{$client->tanggal}}
								        </div></td>
								        <td><div class="datatable-column-width">Rp {{number_format($client->nominal,0,',','.')}}
								        </div></td>
								    </tr>
								    @php ($i++)
								    @endforeach
								@else
								  	<tr><td align="center" colspan="4">Data Kosong</td></tr>
								@endif 
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- /basic donut -->

			</div>
		</div>	
		<!-- /pie and donut -->
		<div class="card">
		<div class="card-body">
			<div class="row justify-content-between">
				<div class="col-md-3">
					<div class="input-group">
						<span class="input-group-prepend">
							<span class="input-group-text"><i class="icon-calendar"></i></span>
						</span>
						<input id="tglawal" type="text" class="form-control pickadate-year" placeholder="Masukkan Tanggal" name="tglawal" value="{{ isset($tglawal) ? date('j F, Y', strtotime($tglawal)) : (request()->filled('tglawal') ? date('j F, Y', strtotime(str_replace(',', '', request()->get('tglawal')))) : date('j F, Y')) }}">
					</div>
				</div>
				<div class="col-md-1 align-self-center text-center">
					<span class="text-center">Sampai</span>
				</div>
				 <div class="col-md-3">
					<div class="input-group">
						<span class="input-group-prepend">
							<span class="input-group-text"><i class="icon-calendar"></i></span>
						</span>
						<input id="tglakhir" type="text" class="form-control pickadate-year" placeholder="Masukkan Tanggal" name="tanggalakhir" value="{{ isset($tglakhir) ? date('j F, Y', strtotime($tglakhir)) : (request()->filled('tglakhir') ? date('j F, Y', strtotime(str_replace(',', '', request()->get('tglakhir')))) : date('j F, Y')) }}">
					</div>
				</div>
				<div class="text-right">
					<button id="filterButton" type="submit" class="btn btn-primary text-uppercase submitBtn">Filter <i class="icon-checkmark"></i></button>
					<a id="btn_reset" href="" class="btn bg-teal text-uppercase">Reset<i class="icon-rotate-ccw2 ml-2"></i></a>
				</div>
			</div>
		</div>
	</div>
	<!-- Pie and donut -->
		<div class="row">
			<div class="col-xl-12">

				<!-- Basic pie -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Statistik - Pendapatan marketing</h5>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload"></a>
								<a class="list-icons-item" data-action="remove"></a>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div class="chart-container">
						<div class="chart has-fixed-height" id="pie_pMarketing"></div>
						</div>
					</div>
				</div>
				<!-- /basic pie -->

			</div>
		</div>
		<div class="row">
			<div class="col-xl-12">

				<!-- Basic pie -->
				<div class="card">
					<div class="card-header header-elements-inline">
		          	<h5 class="card-title">Total Pembayaran per Perlanggan</h5> 
					</div>

					<div class="card-body">
						<div class="chart-container">
							<table class="table datatable-basic table-hover">
								<thead>
									<tr>
										<th>No</th>
										<th>Pelanggan</th>
										<th>Jumlah</th>
									</tr>
								</thead>
								<tbody>
								@if(!$totals->isEmpty())
									@php ($i = 1)
									@foreach($totals as $total)
								    <tr>
								        <td>{{$i}}</td>
								        <td><div class="datatable-column-width">{{@$total->user->username ? $total->user->username : "-"}}</div></td>
								        <td><div class="datatable-column-width">Rp.{{number_format($total->total,0,',','.')}}</div></td>
								    </tr>
								    @php ($i++)
								    @endforeach
								@else
								  	<tr><td align="center" colspan="3">Data Kosong</td></tr>
								@endif 
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- /basic pie -->
				<!-- </div>
			
			<div class="col-xl-6"> -->
				<!-- Pie and donut -->
		
				<!-- Basic pie -->
				<!-- <div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Pembayaran per layanan</h5>
						</div>

					<div class="card-body">
						<div class="chart-container">
							<div class="chart has-fixed-height" id="pie_basic"></div>
						</div>
					</div>
				</div> -->
				<!-- /basic pie -->

			</div>
		</div>
			<div class="modal fade" id="myModal" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header bg-success">
					<h4 class="modal-title" style="border-bottom: 1px solid #000">
					<span class="text-danger">*</span>Detail Data Proyek</h4>
					 &nbsp&nbsp
					<h4>(<span id="jenisProyekModal"></span></h4>&nbsp<h4><span id="jumlahdata"></span>)</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover tabledata" id="tableData">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Klien</th>
								<th>Nama Proyek</th>
								<th>Payment</th>
							</tr>
						</thead>
						<tbody id="dataProyek">
					</tbody>
					</table>
				</div>
				<br>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>

				</div>
			</div>
			</div>
				</div>
		</div>
	<!-- /content area -->
@endsection

@section('js')
	<!-- Theme JS files -->
	<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/visualization/echarts/echarts.min.js')}}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.time.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/pickadate/legacy.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
	

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>
	<!-- <script src="{{asset('global_assets/js/demo_pages/charts/echarts/lines.js')}}"></script> -->
	<script type="text/javascript">

		var EchartsColumnsWaterfalls = function() {

		    // Column and waterfall charts
		    var _columnsWaterfallsExamples = function() {
		        if (typeof echarts == 'undefined') {
		            console.warn('Warning - echarts.min.js is not loaded.');
		            return;
		        }

		        // Define elements
		        var columns_basic_element = document.getElementById('columns_basic');

		        // Basic columns chart
		        if (columns_basic_element) {

		            // Initialize chart
		            var columns_basic = echarts.init(columns_basic_element);

		            // Options
		            columns_basic.setOption({

		                // Define colors
		                color: ['#39b772','#26a69a','#dde833','#ffb980','#d87a80'],

		                // Global text styles
		                textStyle: {
		                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
		                    fontSize: 13
		                },

		                // Chart animation duration
		                animationDuration: 750,

		                // Setup grid
		                grid: {
		                    left: 40,
		                    right: 40,
		                    top: 35,
		                    bottom: 85,
		                    containLabel: true
		                },

		                // Add legend
		                legend: {
		                    data: ['Evaporation', 'Precipitation'],
		                    itemHeight: 8,
		                    itemGap: 20,
		                    textStyle: {
		                        padding: [0, 5]
		                    }
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'axis',
		                    backgroundColor: 'rgba(0,0,0,0.75)',
		                    padding: [10, 15],
		                    textStyle: {
		                        fontSize: 13,
		                        fontFamily: 'Roboto, sans-serif'
		                    }
		                },

		                // Horizontal axis
		                xAxis: [{
		                    type: 'category',
		                    data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		                    axisLabel: {
		                        color: '#333'
		                    },
		                    axisLine: {
		                        lineStyle: {
		                            color: '#999'
		                        }
		                    },
		                    splitLine: {
		                        show: true,
		                        lineStyle: {
		                            color: '#eee',
		                            type: 'dashed'
		                        }
		                    }
		                }],

		                // Vertical axis
		                yAxis: [{
		                    type: 'value',
		                    axisLabel: {
		                        color: '#333'
		                    },
		                    axisLine: {
		                        lineStyle: {
		                            color: '#999'
		                        }
		                    },
		                    splitLine: {
		                        lineStyle: {
		                            color: ['#eee']
		                        }
		                    },
		                    splitArea: {
		                        show: true,
		                        areaStyle: {
		                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
		                        }
		                    }
		                }],

		                // Add series
		                series: [
		                @foreach($chart as $name => $data)
		                    {
		                        name: '{{config("custom.role.".$name)}}',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                        // itemStyle: {
		                        //     normal: {
		                        //         label: {
		                        //             show: true,
		                        //             position: 'top',
		                        //             textStyle: {
		                        //                 fontWeight: 500
		                        //             }
		                        //         }
		                        //     }
		                        // },
		                        // markLine: {
		                        //     data: [{type: 'average', name: 'Average'}]
		                        // }
		                    },
		                @endforeach
		                    
		                ]
		            });
		        }

		        // Resize function
		        var triggerChartResize = function() {
		            columns_basic_element && columns_basic.resize();
		        };

		        // On sidebar width change
		        $(document).on('click', '.sidebar-control', function() {
		            setTimeout(function () {
		                triggerChartResize();
		            }, 0);
		        });

		        // On window resize
		        var resizeCharts;
		        window.onresize = function () {
		            clearTimeout(resizeCharts);
		            resizeCharts = setTimeout(function () {
		                triggerChartResize();
		            }, 200);
		        };
		    };

		    return {
		        init: function() {
		            _columnsWaterfallsExamples();
		        }
		    }
		}();

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsColumnsWaterfalls.init();
		});

	</script>
	<script type="text/javascript">
		
		var EchartsPiesDonuts = function() {

		    // Pie and donut charts
		    var _piesDonutsExamples = function() {
		        if (typeof echarts == 'undefined') {
		            console.warn('Warning - echarts.min.js is not loaded.');
		            return;
		        }

		        // Define elements
		        var pie_basic_element = document.getElementById('pie_basic');

		        // Basic pie chart
		        if (pie_basic_element) {

		            // Initialize chart
		            var pie_basic = echarts.init(pie_basic_element);

		            // Options
		            pie_basic.setOption({

		                // Colors
		                color: ['#39b772','#26a69a','#dde833','#ffb980','#d87a80'],

		                // Global text styles
		                textStyle: {
		                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
		                    fontSize: 13
		                },

		                // Add title
		                title: {
		                    text: 'Persentase Pembayaran',
		                    left: 'center',
		                    textStyle: {
		                        fontSize: 17,
		                        fontWeight: 500
		                    },
		                    subtextStyle: {
		                        fontSize: 12
		                    }
		                },

		                // Add tooltip
		                tooltip: {
		                    trigger: 'item',
		                    backgroundColor: 'rgba(0,0,0,0.75)',
		                    padding: [10, 15],
		                    textStyle: {
		                        fontSize: 13,
		                        fontFamily: 'Roboto, sans-serif'
		                    },
		                    formatter: "{a} <br/>{b}: {c} ({d}%)"
		                },

		                // Add series
		                series: [{
		                    name: 'Jumlah Pembayaran',
		                    type: 'pie',
		                    radius: '70%',
		                    center: ['50%', '57.5%'],
		                    itemStyle: {
			                normal : {
			                    label : {
			                        show: true, position: 'inside',
			                        formatter : '{b}\n{d}%',
			                    },
			                    labelLine : {
			                        show : true
			                    }
		                	},
		                    },
		                    data: [
		                    @foreach($pie as $key => $val)
		                    	@if($val>0)
		                        {value: {{$val}}, name: '{{config("custom.role.".$key)}}'},
		                        @endif
		                    @endforeach
		                    ]
		                }]
		            });
		        }

		        // Resize function
		        var triggerChartResize = function() {
		            pie_basic_element && pie_basic.resize();
		        };

		        // On sidebar width change
		        $(document).on('click', '.sidebar-control', function() {
		            setTimeout(function () {
		                triggerChartResize();
		            }, 0);
		        });

		        // On window resize
		        var resizeCharts;
		        window.onresize = function () {
		            clearTimeout(resizeCharts);
		            resizeCharts = setTimeout(function () {
		                triggerChartResize();
		            }, 200);
		        };
		    };

		    return {
		        init: function() {
		            _piesDonutsExamples();
		        }
		    }
		}();

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsPiesDonuts.init();
		});

var EchartsPieBasicLight = function() {


// Basic pie chart
var _scatterPieBasicLightExample = function() {
	if (typeof echarts == 'undefined') {
		console.warn('Warning - echarts.min.js is not loaded.');
		return;
	}

	// Define element
	var pie_basic_element = document.getElementById('pie_layanan');

	
	//
	// Charts configuration
	//
	var pie_basic;
	if (pie_basic_element) {

		// Initialize chart
		pie_basic = echarts.init(pie_basic_element);


		//
		// Chart config
		//

		// Options
		pie_basic.setOption({

			// Colors
			color: [
				'#d87a80','#b6a2de','#7eb00a','#39b772','#ffb980',
				'#2ec7c9','#e5cf0d','#97b552','#95706d','#dc69aa',
				'#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
				'#59678c','#c9ab00','#5ab1ef','#6f5553','#c14089'
			],

			// Global text styles
			textStyle: {
				fontFamily: 'Roboto, Arial, Verdana, sans-serif',
				fontSize: 13
			},

			// Add title
			title: {
				text: 'Nore Payment popularity',
				subtext: 'Open source information',
				left: 'center',
				textStyle: {
					fontSize: 17,
					fontWeight: 500
				},
				subtextStyle: {
					fontSize: 12
				}
			},

			// Add tooltip
			tooltip: {
				trigger: 'item',
				backgroundColor: 'rgba(0,0,0,0.75)',
				padding: [10, 15],
				textStyle: {
					fontSize: 13,
					fontFamily: 'Roboto, sans-serif'
				},
				formatter: "{a} <br/>{b}: {c} ({d}%)"
			},

			// Add legend
			legend: {
				orient: 'vertical',
				top: 'center',
				left: 0,
				data: ['Website', 'Iklan/Ads', 'Sistem Informasi', 'Mobile App', 'ULo','Custom/Lainnya'],
				itemHeight: 8,
				itemWidth: 8
			},

			// Add series
			series: [{
				name: 'Proyek',
				type: 'pie',
				radius: '70%',
				center: ['50%', '57.5%'],
				itemStyle: {
					normal: {
						borderWidth: 1,
						borderColor: '#fff'
					}
				},
				data: [
					@foreach($proyeks as $key => $val)
				
					{value: {{$val->total}},id:{{$val->jenis_proyek}},name: '{{config("custom.jenis_proyek.".$val->jenis_proyek)}}'},
					@endforeach

					]
			}]
		});
		
	}
			pie_basic.on('click', function(params) {
				
		    //ini sudah dapat value dan name 
				var token= '{{ csrf_token() }}';
				$.ajax({
					type :'GET',
					url  :'{{route("getstatistikpayment",[null])}}/'+params.data.id,
					headers  :{
					'X-CSRF-TOKEN' : token
					},
					dataType :'json',
					success  : function(data){
						// console.log(data);
						$('#myModal').modal('show');
						var dataproyek = '';
						$('.tabledata').DataTable().destroy();
						$('#dataProyek').html("");
						$('#jenisProyekModal').html(params.name);
						$('#jumlahdata').html(params.value);

                        // ITERATING THROUGH OBJECTS
                        $.each(data, function (key, value) {
                             var no = key+1;
                            //CONSTRUCTION OF ROWS HAVING
                            // DATA FROM JSON OBJECT
                            dataproyek += '<tr>';
                            dataproyek += '<td>' + 
							    no + '</td>';
								
								dataproyek += '<td>' + 
                                value.user.nama + '</td>';
								
								dataproyek += '<td>' + 
                                value.nama_proyek + '</td>';
  
								dataproyek += '<td>' + 
                                (value.tagihan ? (new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value.tagihan.nominal )) : 'Rp -')+ '</td>';
  
								dataproyek += '</tr>';
                        });
                          
                        //INSERTING ROWS INTO TABLE 
                        $('#dataProyek').append(dataproyek);
						$('.tabledata').DataTable();
						

					},
					error:function(){
						alert('eror');
					}
				});
				
				// Print name in console
				console.log(params);
			});
	//
	// Resize charts
	//

	// Resize function
	var triggerChartResize = function() {
		pie_basic_element && pie_basic.resize();
	};

	// On sidebar width change
	var sidebarToggle = document.querySelector('.sidebar-control');
	sidebarToggle && sidebarToggle.addEventListener('click', triggerChartResize);

	// On window resize
	var resizeCharts;
	window.addEventListener('resize', function() {
		clearTimeout(resizeCharts);
		resizeCharts = setTimeout(function () {
			triggerChartResize();
		}, 200);
	});
};


//
// Return objects assigned to module
//

return {
	init: function() {
		_scatterPieBasicLightExample();
	}
}
}();


	document.addEventListener('DOMContentLoaded', function() {
	EchartsPieBasicLight.init();
	});

		$(document).ready(function() {
			// Inisialisasi elemen input ID tglawal

			$('#filterButton').click(function() {
				filterData();
			});

			$('#tglawal').pickadate({
				format: 'dd mmmm, yyyy', // atur format
				selectYears: true,
				selectMonths: true,
			});

			// Inisialisasi elemen input ID tglakhir
			$('#tglakhir').pickadate({
				format: 'dd mmmm, yyyy', 
				selectYears: true,
				selectMonths: true,
			});

			$('#btn_reset').click(function() {

        var today = new Date();
        var formattedDate = today.getDate() + ' ' + getMonthName(today.getMonth()) + ', ' + today.getFullYear();
        $('#tglawal').val(formattedDate);
        $('#tglakhir').val(formattedDate);
		});

		// Fungsi untuk mendapatkan nama bulan
		function getMonthName(month) {
			var monthNames = [
				"January", "February", "March", "April", "May", "June",
				"July", "August", "September", "October", "November", "December"
			];
			return monthNames[month];
		}

	});

	function filterData() {
    var tglawal = document.getElementById("tglawal").value;
    var tglakhir = document.getElementById("tglakhir").value;

    
		var token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			type: 'GET',
			url: '{{ route("filter-data") }}',
			headers: {
				'X-CSRF-TOKEN': token
			},
			data: {
				tglawal: tglawal,
				tglakhir: tglakhir
			},
			dataType: 'json',
			success: function (data) {
            	EchartsPieBasicPendapatanMarketing.updatePieChart(data);
				console.log('success:',data);
        	},
			error: function (error) {
				console.error('Error:', error);
			}
		});
	}

	var legendData = [
			 @foreach($marketingIdArray as $key => $val)
				{
					name: '{{ $val['nama'] }} ({{ $val['total'] }})',
					value: {{ $val['total_nominal'] }}
				},
			@endforeach
		];

	var EchartsPieBasicPendapatanMarketing = function() {

	
    //
    // Setup module components
    //

    // Basic pie chart
    var _scatterPieBasicPendapatanMarketing = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var pie_basic_element = document.getElementById('pie_pMarketing');


        //
        // Charts configuration
        //

        if (pie_basic_element) {

            // Initialize chart
            var pie_basic = echarts.init(pie_basic_element);


            // Options
            pie_basic.setOption({

                // Colors
                color: [
					'#1d7678', '#8a68c6', '#4687ae', '#e57970', '#b9666b',
					'#757f97', '#b4a90a', '#6c813e', '#705b56', '#bb4a8f',
					'#066c6f', '#7b68b9', '#3e77b9', '#d9823c', '#a13d3d',
					'#4a536c', '#a78b00', '#647c08', '#5c4e4b', '#9b117a'
				],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Add title
                title: {
                    text: 'Browser popularity',
                    subtext: 'Open source information',
                    left: 'center',
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 500
                    },
                    subtextStyle: {
                        fontSize: 12
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    top: 'center',
                    left: 0,
                    data: legendData,
                    itemHeight: 8,
                    itemWidth: 8
                },

                // Add series
                series: [{
                    name: 'Browsers',
                    type: 'pie',
                    radius: '70%',
                    center: ['50%', '57.5%'],
                    itemStyle: {
                        normal: {
                            borderWidth: 1,
                            borderColor: '#fff'
                        }
                    },
                    data: [
						   @foreach($marketingIdArray as $key => $val)
							{
								// id: {{ $val['marketing_id'] }}, 
								name: '{{ $val['nama'] }} ({{ $val['total'] }})',
								value: {{ $val['total_nominal'] }}
							},
						@endforeach
					]
                }]
            });
        }

        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            pie_basic_element && pie_basic.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelector('.sidebar-control');
        sidebarToggle && sidebarToggle.addEventListener('click', triggerChartResize);

        // On window resize
        var resizeCharts;
        window.addEventListener('resize', function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        });
    };


     function updatePieChart(data) {
        var pieChart = echarts.init(document.getElementById('pie_pMarketing'));
        
        // Update legendData here
        legendData = data.map(function(item) {
            return {
                name: item.name + ' (' + item.value + ')',
                value: item.value
            };
        });

		console.log('Updated legendData:', legendData);
        pieChart.setOption({
            series: [{
                data: data,
            }],
            // Update legend data
            legend: {
                data: data,
            }
        });

		console.log('Pie chart data updated:', data); 
        pieChart.resize();
    }

		return {
			init: function() {
				_scatterPieBasicPendapatanMarketing();
			},
			updatePieChart: updatePieChart
		}
	}();

	document.addEventListener('DOMContentLoaded', function() {
		EchartsPieBasicPendapatanMarketing.init();
	});




	</script>
	<script type="text/javascript">
		var DatatableBasic = function() {

		    // Basic Datatable examples
		    var _componentDatatableBasic = function() {
		        if (!$().DataTable) {
		            console.warn('Warning - datatables.min.js is not loaded.');
		            return;
		        }

		        // Setting datatable defaults
		        $.extend( $.fn.dataTable.defaults, {
		            autoWidth: false,
		            columnDefs: [{ 
		                orderable: false,
		                //width: 200,
		                targets: [ 0, 1, 2, 3]
		            }],
		            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
		            language: {
		                search: '<span>Filter:</span> _INPUT_',
		                searchPlaceholder: 'Type to filter...',
		                lengthMenu: '<span>Show:</span> _MENU_',
		                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
		            }
		        });

		        // Basic datatable
		        $('.datatable-basic').DataTable();

		    };

		    // Select2 for length menu styling
		    var _componentSelect2 = function() {
		        if (!$().select2) {
		            console.warn('Warning - select2.min.js is not loaded.');
		            return;
		        }

		        // Initialize
		        $('.dataTables_length select').select2({
		            minimumResultsForSearch: Infinity,
		            dropdownAutoWidth: true,
		            width: 'auto'
		        });
		    };

		    return {
		        init: function() {
		            _componentDatatableBasic();
		            _componentSelect2();
		        }
		    }
		}();

		document.addEventListener('DOMContentLoaded', function() {
		    DatatableBasic.init();
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

		});
	</script>
@endsection