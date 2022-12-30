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
			text-transform:capitalize;
		}
	</style>
@endsection

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Statistik Task</h4>
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
				<h5 class="card-title">Task Per{{$filter}}</h5>
			</div>

			<div class="card-body">
				<div class="chart-container">
				<form action="{{route('stat_task')}}" method="post">
					@csrf
					<div class="form-group row">
						<div class="col-lg-3">
								<label>Tahun :</label>
							<select name="tahun" class="form-control select-search" data-fouc>
								<option value="{{date('Y')}}">{{date('Y')}}</option>
								@foreach($years as $year)
									@if($year->tahun != date('Y'))
									<option value="{{$year->tahun}}" {{ $tahun == $year->tahun ? 'selected' : '' }}>{{$year->tahun}}</option>
									@endif
			    				@endforeach
							</select>
						</div>
						<div class="col-lg-3">
							<label>Filter :</label>
							<select name="filter" class="form-control select-search" data-fouc>
									<option value="bulan" {{ ($filter == 'bulan') ? 'selected' : '' }}>bulan</option>
									<option value="minggu" {{ ($filter == 'minggu') ? 'selected' : '' }}>minggu</option>
							</select>
						</div>
						<div class="col-lg-3">
							<button type="submit" class="btn btn-outline-primary active btnstat" style="bottom:0;">Pilih</button>
						</div>
					</div>
				</form>
				<hr>
					<div class="chart has-fixed-height" id="line_zoom"></div>
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
						<h5 class="card-title">Task per Karyawan</h5>
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

				<!-- Basic Table -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Task per Pelanggan</h5>
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
								@if(!$clients->isEmpty())
									@php ($i = 1)
									@foreach($clients as $client)
								    <tr>
								        <td>{{$i}}</td>
								        <td><div class="datatable-column-width">{{$client->username}}</div></td>
								        <td><div class="datatable-column-width">{{$client->total}}
								        </div></td>
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
				<!-- /basic donut -->

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
		                    	@foreach($chart as $name => $data)
		                    	'{{$name}}',
		                    	@endforeach
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
		                    @if($filter=='minggu')
		                    	name: 'Minggu ke-',
		                    @else
		                    	name: 'Bulan ke-',
		                    @endif
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
		                    @if($filter=='minggu')
		                    	data: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53]
		                    @else
		                    	data: [1,2,3,4,5,6,7,8,9,10,11,12]
		                    @endif
		                }],

		                // Vertical axis
		                yAxis: [{
		                    type: 'value',
		                    name: 'Jumlah Task',
					        nameLocation: 'middle',
					        nameGap: 35,
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
		                        name: '{{$name}}',
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
		                color: [
		                    '#b6a2de','#5ab1ef','#ffb980','#d87a80',
		                    '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
		                    '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
		                    '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
		                ],

		                // Global text styles
		                textStyle: {
		                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
		                    fontSize: 13
		                },

		                // Add title
		                title: {
		                    text: 'Persentase task diselesaikan',
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
		                    name: 'Jumlah Task Diselesaikan',
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
		                        {value: {{$val}}, name: '{{$key}}'},
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
		                targets: [ 0, 1, 2]
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