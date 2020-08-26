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

		<!-- Zoom option -->
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">Laporan Keuangan Bulanan</h5>
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
		</div>	
        <!-- /pie and donut -->
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

                        @foreach($chart2 as $name => $data)
		                    {
		                        name: '{{config("custom.pengeluaran.".$name)}}',
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
		                    text: 'Persentase Pemasukan',
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

		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsPiesDonuts.init();
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
		        var pie_basic_element = document.getElementById('pie_basic2');

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
		                    text: 'Persentase Pemasukan',
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

		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		    EchartsPiesDonuts.init();
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