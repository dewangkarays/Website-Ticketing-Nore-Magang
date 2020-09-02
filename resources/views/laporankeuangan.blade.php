@extends('layout')

@section('css')
	<style type="text/css">
		@media only screen and (min-width: 768px) {
		  /* For mobile phones: */
		  [class*="btnstat"] {
		    position: absolute; 
		  }
		}
	</style>
@endsection

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Laporan Keuangan</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">

		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">Filter Tahun</h5>
			</div>
			<div class="card-body">
				<form action="{{route('filterKeuangan')}}" method="post">
					@csrf
					<div class="form-group row">
						<div class="col-lg-3">
							<label>Tahun :</label>
							<select name="tahun" class="form-control select-search" data-fouc>
								{{-- <option value="{{date('Y')}}">{{date('Y')}}</option>
								@foreach($years as $year)
									@if($year->tahun != date('Y'))
									<option value="{{$year->tahun}}" {{ $filter == $year->tahun ? 'selected' : '' }}>{{$year->tahun}}</option>
									@endif
								@endforeach --}}
								@for ($date = 2019; $date <= date('2050'); $date++)
									@if ($filter == '')
										<option value=" {{ $date }} "> {{$date}} </option>
									@else
									<option value=" {{ $date }} " {{ $filter == $date ? 'selected' : '' }} > {{$date}} </option>
									@endif
								@endfor

							</select>
						</div>
						<div class="col-lg-3">
							<button type="submit" class="btn btn-outline-primary active btnstat" style="bottom:0;">Pilih</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="card">
			<div class="card-header header-elements-inline">
			<h5 class="card-title">Laporan Bulanan / {{date('F')}} </h5>
			
			</div>

			<div class="card-body">
				<div class="chart-container">
					{{-- <form action="{{route('filterbulan')}}" method="post">
						@csrf
						<div class="form-group row">
							<div class="col-lg-3">
								<label>Filter :</label>
								<select name="bulan" class="form-control select-search" data-fouc>
									@for ($datemonth = 1; $datemonth <= date('12'); $datemonth++)
									
									<option value=" {{ $datemonth }} "  {{ $filterbulan == $datemonth ? 'selected' : '' }}> {{config('custom.bulan.'.$datemonth)}} </option>
									
								@endfor
								</select>
							</div>
							<div class="col-lg-3">
								<button type="submit" class="btn btn-outline-primary active btnstat" style="bottom:0;">Pilih</button>
							</div>
						</div>
					</form> --}}
					<hr>
					<div class="chart has-fixed-height" id="columns_monthly"></div>
				</div>
				
			</div>
		</div>

		<!-- Zoom option -->
		<div class="card">
			<div class="card-header header-elements-inline">
			<h5 class="card-title">Laporan Per Q</h5>
			</div>

			<div class="card-body">
				<div class="chart-container">
					<hr>
					<h6>Quarter 1</h6>
					<div class="chart has-fixed-height" id="columns_quarter1"></div>
				</div>
				<div class="chart-container">
					<hr>
					<h6>Quarter 2</h6>
					<div class="chart has-fixed-height" id="columns_quarter2"></div>
				</div>
				<div class="chart-container">
					<hr>
					<h6>Quarter 3</h6>
					<div class="chart has-fixed-height" id="columns_quarter3"></div>
				</div>
				<div class="chart-container">
					<hr>
					<h6>Quarter 4</h6>
					<div class="chart has-fixed-height" id="columns_quarter4"></div>
				</div>
				
			</div>
		</div>
		<!-- /zoom option -->

		<!-- Zoom option -->
		<div class="card">
			<div class="card-header header-elements-inline">
			<h5 class="card-title">Laporan Tahunan</h5>
			</div>

			<div class="card-body">
				<div class="chart-container">
					
					<hr>
					<div class="chart has-fixed-height" id="columns_yearly"></div>
				</div>
				
			</div>
		</div>
		<!-- /zoom option -->
		
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">Tabel Bruto</h5>
			</div>

			<div class="card-body">
				<div class="chart-container">
					<table class="table datatable-basic table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Pelanggan</th>
								<th>Tanggal</th>
								<th>Jumlah</th>
							</tr>
						</thead>
						<tbody>
							@if(!$tblbruto->isEmpty())
							@php ($i = 1)
							@foreach($tblbruto as $bruto)
							<tr>
								<td>{{$i}}</td>
								<td><div class="datatable-column-width">{{$bruto->user->username}}</div></td>
								<td><div class="datatable-column-width">{{$bruto->tgl_bayar}}
								</div></td>
								<td><div class="datatable-column-width">Rp {{number_format($bruto->nominal,0,',','.')}}
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

		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">Tabel Pengeluaran</h5>
			</div>

			<div class="card-body">
				<div class="chart-container">
					<table class="table datatable-basic table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Jenis Pengeluaran</th>
								<th>Nominal</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							@if(!$tblpengeluaran->isEmpty())
							@php ($i = 1)
							@foreach($tblpengeluaran as $pengeluaran)
							<tr>
								<td>{{$i}}</td>
								<td><div class="datatable-column-width">{{$pengeluaran->tanggal}}
								</div></td>
								<td><div class="datatable-column-width">{{config('custom.pengeluaran.'.$pengeluaran->jenis_pengeluaran)}}</div></td>
								<td><div class="datatable-column-width">Rp {{number_format($pengeluaran->nominal,0,',','.')}}
								</div></td>
								<td><div class="datatable-column-width">{{$pengeluaran->keterangan}}
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

		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">Tabel Pemasukan Neto</h5>
			</div>

			<div class="card-body">
				<div class="chart-container">
					<table class="table datatable-basic table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Bulan</th>
								<th class="text-warning">Pemasukan / Bruto</th>
								<th class="text-danger">Pengeluaran</th>
								<th class="text-success">Pemasukan / Neto</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($netotbl))
							@php ($i = 1)
							@foreach($netotbl as $key => $value)
							<tr>
								<td>{{$i}}</td>
								<td><div class="datatable-column-width">{{config("custom.bulan.".$key)}} </div></td>
								<td><div class="datatable-column-width">Rp @angka($brtbl[$key]) </div></td>
								<td><div class="datatable-column-width">Rp {{ empty($pgtbl[$key]) ? '0' : number_format($pgtbl[$key],0,',','.') }} </div></td>
								<td><div class="datatable-column-width">Rp @angka($value) </div></td>
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

		<div class="card">

				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Grafik Keuangan</h5>
					</div>

					<div class="card-body">
						<div class="chart-container">
							<div class="chart has-fixed-height" id="line_zoom"></div>
						</div>
					</div>
				</div>

		</div>


		<!-- Pie and donut -->
		<div class="row">
			<div class="col-xl-6">

				<!-- Basic pie -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Total Pemasukan</h5>
					</div>

					<div class="card-body">
						<div class="chart-container">
							<div class="chart has-fixed-height" id="pie_basic"></div>
						</div>
					</div>
				</div>
				<!-- /basic pie -->

			</div>

			<div class="col-xl-6">

				<!-- Basic pie -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Total Pengeluaran</h5>
					</div>

					<div class="card-body">
						<div class="chart-container">
							<div class="chart has-fixed-height" id="pie_basic2"></div>
						</div>
					</div>
				</div>
				<!-- /basic pie -->

			</div>
		</div>	
		<!-- /pie and donut -->
		


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
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/visualization/echarts/echarts.min.js')}}"></script>

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_inputs.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/form_select2.js')}}"></script>
    <!-- <script src="{{asset('global_assets/js/demo_pages/charts/echarts/lines.js')}}"></script> -->
    

	<script type="text/javascript">
	// yearly
		var EchartsColumnsWaterfalls = function() {

		    // Column and waterfall charts
		    var _columnsWaterfallsExamples = function() {
		        if (typeof echarts == 'undefined') {
		            console.warn('Warning - echarts.min.js is not loaded.');
		            return;
		        }

		        // Define elements
		        var columns_basic_element = document.getElementById('columns_yearly');

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
		                    data: ['Total Pemasukan Bruto', 'Total Pengeluaran', 'Total Pemasukan Neto'],
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
		                        name: 'Total Pemasukan Bruto',
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

                        @foreach($chart2 as $name => $data)
		                    {
		                        name: 'Total Pengeluaran',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
                        @endforeach
                        
                        @foreach($neto as $name => $data)
		                    {
		                        name: 'Total Pemasukan Neto',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
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
	// per quarter 1
		var EchartsColumnsWaterfallsq1 = function() {

		    // Column and waterfall charts
		    var _columnsWaterfallsExamplesq1 = function() {
		        if (typeof echarts == 'undefined') {
		            console.warn('Warning - echarts.min.js is not loaded.');
		            return;
		        }

		        // Define elements
		        var columns_basic_elementq1 = document.getElementById('columns_quarter1');

		        // Basic columns chart
		        if (columns_basic_elementq1) {

		            // Initialize chart
		            var columns_basicq1 = echarts.init(columns_basic_elementq1);

		            // Options
		            columns_basicq1.setOption({

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
		                    data: ['Total Pemasukan Bruto', 'Total Pengeluaran', 'Total Pemasukan Neto'],
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
		                    data: ['Jan', 'Feb', 'Mar'],
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
		                @foreach($chartq1 as $name => $data)
		                    {
		                        name: 'Total Pemasukan Bruto',
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

                        @foreach($chartq12 as $name => $data)
		                    {
		                        name: 'Total Pengeluaran',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
                        @endforeach
                        
                        @foreach($netoq13 as $name => $data)
		                    {
		                        name: 'Total Pemasukan Neto',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
		                @endforeach
		                    
		                ]
		            });
		        }

		        // Resize function
		        var triggerChartResizeq1 = function() {
		            columns_basic_elementq1 && columns_basicq1.resize();
		        };

		        // On sidebar width change
		        $(document).on('click', '.sidebar-control', function() {
		            setTimeout(function () {
		                triggerChartResize();
		            }, 0);
		        });

		        // On window resize
		        var resizeChartsq1;
		        window.onresize = function () {
		            clearTimeout(resizeChartsq1);
		            resizeChartsq1 = setTimeout(function () {
		                triggerChartResize();
		            }, 200);
		        };
		    };

		    return {
		        init: function() {
		            _columnsWaterfallsExamplesq1();
		        }
		    }
		}();

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsColumnsWaterfallsq1.init();
		});

	</script>


<script type="text/javascript">
	// perquarter 2
	
		var EchartsColumnsWaterfallsq2 = function() {

		    // Column and waterfall charts
		    var _columnsWaterfallsExamplesq2 = function() {
		        if (typeof echarts == 'undefined') {
		            console.warn('Warning - echarts.min.js is not loaded.');
		            return;
		        }

		        // Define elements
		        var columns_basic_elementq2 = document.getElementById('columns_quarter2');

		        // Basic columns chart
		        if (columns_basic_elementq2) {

		            // Initialize chart
		            var columns_basicq2 = echarts.init(columns_basic_elementq2);

		            // Options
		            columns_basicq2.setOption({

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
		                    data: ['Total Pemasukan Bruto', 'Total Pengeluaran', 'Total Pemasukan Neto'],
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
		                    data: ['Apr', 'Mei', 'Jun'],
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
		                @foreach($chartq2 as $name => $data)
		                    {
		                        name: 'Total Pemasukan Bruto',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
						@endforeach
						
						@foreach($chartq22 as $name => $data)
		                    {
		                        name: 'Total Pengeluaran',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
						@endforeach
						
						@foreach($chartq23 as $name => $data)
		                    {
		                        name: 'Total Pemasukan Neto',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
                        @endforeach

		                    
		                ]
		            });
		        }

		        // Resize function
		        var triggerChartResizeq2 = function() {
		            columns_basic_elementq2 && columns_basicq2.resize();
		        };

		        // On sidebar width change
		        $(document).on('click', '.sidebar-control', function() {
		            setTimeout(function () {
		                triggerChartResize();
		            }, 0);
		        });

		        // On window resize
		        var resizeChartsq2;
		        window.onresize = function () {
		            clearTimeout(resizeChartsq2);
		            resizeChartsq2 = setTimeout(function () {
		                triggerChartResize();
		            }, 200);
		        };
		    };

		    return {
		        init: function() {
		            _columnsWaterfallsExamplesq2();
		        }
		    }
		}();

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsColumnsWaterfallsq2.init();
		});

</script>


<script type="text/javascript">
	// perquarter 3
	
		var EchartsColumnsWaterfallsq3 = function() {

		    // Column and waterfall charts
		    var _columnsWaterfallsExamplesq3 = function() {
		        if (typeof echarts == 'undefined') {
		            console.warn('Warning - echarts.min.js is not loaded.');
		            return;
		        }

		        // Define elements
		        var columns_basic_elementq3 = document.getElementById('columns_quarter3');

		        // Basic columns chart
		        if (columns_basic_elementq3) {

		            // Initialize chart
		            var columns_basicq3 = echarts.init(columns_basic_elementq3);

		            // Options
		            columns_basicq3.setOption({

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
		                    data: ['Total Pemasukan Bruto', 'Total Pengeluaran', 'Total Pemasukan Neto'],
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
		                    data: ['Jul', 'Aug', 'Sept'],
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
		                @foreach($chartq3 as $name => $data)
		                    {
		                        name: 'Total Pemasukan Bruto',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
						@endforeach
						
						@foreach($chartq32 as $name => $data)
		                    {
		                        name: 'Total Pengeluaran',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
						@endforeach
						
						@foreach($chartq33 as $name => $data)
		                    {
		                        name: 'Total Pemasukan Neto',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
                        @endforeach

		                    
		                ]
		            });
		        }

		        // Resize function
		        var triggerChartResizeq3 = function() {
		            columns_basic_elementq3 && columns_basicq3.resize();
		        };

		        // On sidebar width change
		        $(document).on('click', '.sidebar-control', function() {
		            setTimeout(function () {
		                triggerChartResize();
		            }, 0);
		        });

		        // On window resize
		        var resizeChartsq3;
		        window.onresize = function () {
		            clearTimeout(resizeChartsq3);
		            resizeChartsq3 = setTimeout(function () {
		                triggerChartResize();
		            }, 200);
		        };
		    };

		    return {
		        init: function() {
		            _columnsWaterfallsExamplesq3();
		        }
		    }
		}();

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsColumnsWaterfallsq3.init();
		});

</script>


<script type="text/javascript">
	// perquarter 4
	
		var EchartsColumnsWaterfallsq4 = function() {

		    // Column and waterfall charts
		    var _columnsWaterfallsExamplesq4 = function() {
		        if (typeof echarts == 'undefined') {
		            console.warn('Warning - echarts.min.js is not loaded.');
		            return;
		        }

		        // Define elements
		        var columns_basic_elementq4 = document.getElementById('columns_quarter4');

		        // Basic columns chart
		        if (columns_basic_elementq4) {

		            // Initialize chart
		            var columns_basicq4 = echarts.init(columns_basic_elementq4);

		            // Options
		            columns_basicq4.setOption({

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
		                    data: ['Total Pemasukan Bruto', 'Total Pengeluaran', 'Total Pemasukan Neto'],
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
		                    data: ['Oct', 'Nov', 'Dec'],
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
		                @foreach($chartq4 as $name => $data)
		                    {
		                        name: 'Total Pemasukan Bruto',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
						@endforeach
						
						@foreach($chartq42 as $name => $data)
		                    {
		                        name: 'Total Pengeluaran',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
						@endforeach
						
						@foreach($chartq43 as $name => $data)
		                    {
		                        name: 'Total Pemasukan Neto',
		                        type: 'bar',
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ],
		                    },
                        @endforeach

		                    
		                ]
		            });
		        }

		        // Resize function
		        var triggerChartResizeq4 = function() {
		            columns_basic_elementq4 && columns_basicq4.resize();
		        };

		        // On sidebar width change
		        $(document).on('click', '.sidebar-control', function() {
		            setTimeout(function () {
		                triggerChartResize();
		            }, 0);
		        });

		        // On window resize
		        var resizeChartsq4;
		        window.onresize = function () {
		            clearTimeout(resizeChartsq4);
		            resizeChartsq4 = setTimeout(function () {
		                triggerChartResize();
		            }, 200);
		        };
		    };

		    return {
		        init: function() {
		            _columnsWaterfallsExamplesq4();
		        }
		    }
		}();

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsColumnsWaterfallsq4.init();
		});

</script>


<script type="text/javascript">

// Laporan bulanan
	var EchartsColumnsWaterfalls2 = function() {

		// Column and waterfall charts
		var _columnsWaterfallsExamples2 = function() {
			if (typeof echarts == 'undefined') {
				console.warn('Warning - echarts.min.js is not loaded.');
				return;
			}

			// Define elements
			var columns_basic_element2 = document.getElementById('columns_monthly');

			// Basic columns chart
			if (columns_basic_element2) {

				// Initialize chart
				var columns_basic2 = echarts.init(columns_basic_element2);

				// Options
				columns_basic2.setOption({

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
						data: ['Total Pemasukan Bruto', 'Total Pengeluaran', 'Total Pemasukan Neto'],
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
						data: [
						'1'
						@for($i=2; $i <= $dateina_month; $i++)	
							,{{ $i }}
						@endfor
						],
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
						{
							name: 'Total Pemasukan Bruto',
							type: 'bar',
							data: [
								@foreach($chartmonth as $hari => $val)
									{{$val}},
								@endforeach
							],
						},
						{
							name: 'Total Pengeluaran',
							type: 'bar',
							data: [
								@foreach($chartmonth2 as $hari => $val)
									{{$val}},
								@endforeach
							],
						},
						{
							name: 'Total Pemasukan Neto',
							type: 'bar',
							data: [
								@foreach($chartmonth3 as $hari => $val)
									{{$val}},
								@endforeach
							],
						},
						
					]
				});
			}

			// Resize function
			var triggerChartResize2 = function() {
				columns_basic_element2 && columns_basic2.resize();
			};

			// On sidebar width change
			$(document).on('click', '.sidebar-control', function() {
				setTimeout(function () {
					triggerChartResize2();
				}, 0);
			});

			// On window resize
			var resizeCharts2;
			window.onresize = function () {
				clearTimeout(resizeCharts2);
				resizeCharts2 = setTimeout(function () {
					triggerChartResize2();
				}, 200);
			};
		};

		return {
			init: function() {
				_columnsWaterfallsExamples2();
			}
		}
	}();

	document.addEventListener('DOMContentLoaded', function() {
		EchartsColumnsWaterfalls2.init();
	});

</script>

	
	<script type="text/javascript">

		var EchartsLines = function() {

		    // Line charts
		    var _lineChartExamples = function() {
		        if (typeof echarts == 'undefined') {
		            console.warn('Warning - echarts.min.js is not loaded.');
		            return;
		        }

		        // Define elements
		        var line_zoom_element = document.getElementById('line_zoom');

		        // Zoom option
		        if (line_zoom_element) {

		            // Initialize chart
		            var line_zoom = echarts.init(line_zoom_element);

		            // Options
		            line_zoom.setOption({

		                // Define colors
		                color: [
		                    '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
		                    '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
		                    '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
		                    '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
		                ],

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
		                    data: [
		                    	'Total Pemasukan Bruto', 'Total Pengeluaran', 'Total Pemasukan Neto'
		                    ],
		                    itemHeight: 8,
		                    itemGap: 20
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
		                    
		                    	name: 'Bulan ke-',
		                    
					        nameLocation: 'middle',
					        nameGap: 35,
		                    boundaryGap: false,
		                    axisLabel: {
		                        color: '#333'
		                    },
		                    axisLine: {
		                        lineStyle: {
		                            color: '#999'
		                        }
		                    },
		                    
		                    	data: [1,2,3,4,5,6,7,8,9,10,11,12]
							
		                }],

		                // Vertical axis
		                yAxis: [{
		                    type: 'value',
		                    
		                    axisLabel: {
		                        formatter: '{value} ',
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

		                // Zoom control
		                dataZoom: [
		                    // {
		                    //     type: 'inside',
		                    //     // start: 30,
		                    //     // end: 70
		                    // },
		                    {
		                        show: true,
		                        type: 'slider',
		                        // start: 30,
		                        // end: 70,
		                        height: 40,
		                        bottom: 0,
		                        borderColor: '#ccc',
		                        fillerColor: 'rgba(0,0,0,0.05)',
		                        handleStyle: {
		                            color: '#585f63'
		                        }
		                    }
		                ],

		                // Add series
		                series: [
		                @foreach($chart as $name => $data)
		                    {
		                        name: 'Total Pemasukan Bruto',
		                        type: 'line',
		                        smooth: true,
		                        symbolSize: 6,
		                        itemStyle: {
		                            normal: {
		                                borderWidth: 2
		                            }
		                        },
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ]
		                    },
						@endforeach

						@foreach($chart2 as $name => $data)
		                    {
		                        name: 'Total Pengeluaran',
		                        type: 'line',
		                        smooth: true,
		                        symbolSize: 6,
		                        itemStyle: {
		                            normal: {
		                                borderWidth: 2
		                            }
		                        },
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ]
		                    },
						@endforeach
						
						@foreach($neto as $name => $data)
		                    {
		                        name: 'Total Pemasukan Neto',
		                        type: 'line',
		                        smooth: true,
		                        symbolSize: 6,
		                        itemStyle: {
		                            normal: {
		                                borderWidth: 2
		                            }
		                        },
		                        data: [
		                        	@foreach($data as $val)
		                        		{{$val}},
		                        	@endforeach
		                        ]
		                    }
		                @endforeach
		                ]
		            });
		        }

		        // Resize function
		        var triggerChartResize = function() {
		            line_zoom_element && line_zoom.resize();
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
		            _lineChartExamples();
		        }
		    }
		}();


		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsLines.init();
		});
	</script>
    
    
	<script type="text/javascript">
	// Pie Total Pemasukan Tagihan
		
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
		                    text: 'Persentase Pemasukan Tagihan',
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
							data: [
							@foreach($pie as $key => $val)
							'{{$key}}',
							@endforeach],
							itemHeight: 8,
							itemWidth: 8
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
								{value: {{$val}}, name: '{{$key}}' },
								@else
								{value: 0, name:'{{$key}}' },
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

		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsPiesDonuts.init();
		});
	</script>
	
	<script type="text/javascript">
		// Total Pengeluaran
		var EchartsPiesDonuts2 = function() {

		    // Pie and donut charts
		    var _piesDonutsExamples = function() {
		        if (typeof echarts == 'undefined') {
		            console.warn('Warning - echarts.min.js is not loaded.');
		            return;
		        }

		        // Define elements
		        var pie_basic_element2 = document.getElementById('pie_basic2');

		        // Basic pie chart
		        if (pie_basic_element2) {

		            // Initialize chart
		            var pie_basic2 = echarts.init(pie_basic_element2);

		            // Options
		            pie_basic2.setOption({

		                // Colors
		                color: ['#39b772','#26a69a','#dde833','#ffb980','#d87a80'],

		                // Global text styles
		                textStyle: {
		                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
		                    fontSize: 13
		                },

		                // Add title
		                title: {
		                    text: 'Persentase Pengeluaran',
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
						
						legend: {
							orient: 'vertical',
							top: 'center',
							left: 0,
							data: [
							@foreach($pie2 as $key => $val)
							'{{config("custom.pengeluaran.".$key)}}',
							@endforeach],
							itemHeight: 8,
							itemWidth: 8
						},

		                // Add series
		                series: [{
		                    name: 'Jumlah Pengeluaran',
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
		                    @foreach($pie2 as $key => $val)
		                    	@if($val>0)
		                        {value: {{$val}}, name: '{{config("custom.pengeluaran.".$key)}}' },
		                        @endif
		                    @endforeach
		                    ]
		                }]
		            });
		        }

		        // Resize function
		        var triggerChartResize2 = function() {
		            pie_basic_element2 && pie_basic2.resize();
		        };

		        // On sidebar width change
		        $(document).on('click', '.sidebar-control', function() {
		            setTimeout(function () {
		                triggerChartResize2();
		            }, 0);
		        });

		        // On window resize
		        var resizeCharts2;
		        window.onresize = function () {
		            clearTimeout(resizeCharts2);
		            resizeCharts2 = setTimeout(function () {
		                triggerChartResize2();
		            }, 200);
		        };
		    };

		    return {
		        init: function() {
		            _piesDonutsExamples();
		        }
		    }
		}();

		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsPiesDonuts2.init();
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