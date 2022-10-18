@extends('layout')

@section('css')
@endsection

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Home</span> - Data Karyawan</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">

		<!-- Basic view -->
		<div class="card">
			<div class="card-header header-elements-inline">
				{{-- <h5 class="card-title">Basic view</h5> --}}
				<div class="header-elements">
					{{-- <div class="list-icons">
						<a class="list-icons-item" data-action="collapse"></a>
						<a class="list-icons-item" data-action="reload"></a>
						<a class="list-icons-item" data-action="remove"></a>
					</div> --}}
				</div>
			</div>
			
			<div class="card-body">
				{{-- <p class="mb-3">FullCalendar is a jQuery plugin that provides a full-sized, drag &amp; drop event calendar like the one below. It uses AJAX to fetch events on-the-fly and is easily configured to use your own feed format. It is visually customizable with a rich API. Example below demonstrates a default view of the calendar with a basic setup: draggable and editable events, and starting date.</p> --}}

				<div class="fullcalendar-basic"></div>
			</div>
		</div>

	</div>
	<!-- /content area -->

@endsection

@section('js')
	<!-- Theme JS files -->
	<script src="global_assets/js/plugins/ui/fullcalendar/core/main.min.js"></script>
	<script src="global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js"></script>
	<script src="global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.js"></script>
	<script src="global_assets/js/plugins/ui/fullcalendar/list/main.min.js"></script>
	<script src="global_assets/js/plugins/ui/fullcalendar/interaction/main.min.js"></script>

	<script src="assets/js/app.js"></script>
	{{-- <script src="global_assets/js/demo_pages/fullcalendar_basic.js"></script> --}}
	<script>
		/* ------------------------------------------------------------------------------
		*
		*  # Fullcalendar basic options
		*
		*  Demo JS code for extra_fullcalendar_views.html and extra_fullcalendar_styling.html pages
		*
		* ---------------------------------------------------------------------------- */

		// Setup module
		// ------------------------------

		var FullCalendarBasic = function() {


		//
		// Setup module components
		//

		// Basic calendar
		var _componentFullCalendarBasic = function() {
			if (typeof FullCalendar == 'undefined') {
				console.warn('Warning - Fullcalendar files are not loaded.');
				return;
			}

			// Add demo events
			// ------------------------------
			$.ajax({
                url : '/getkalender',
                type: 'get',
                dataType: 'json',
                success : function(presensi){
					console.log(presensi);
					let newPresensi = presensi.map(obj => {
						let paint = ''
						switch (obj.status) {
							case 2:
								paint = '#f5da42';
								break;
							case 3:
								paint = '#f55142';
								break;
							case 4:
								paint = '#42bff5';
								break;
						}

					return {
						title: obj.nama,
						start: obj.tanggal,
						color: paint
					}
				})

				// Default events
			var events = [
			];


			// Initialization
			// ------------------------------

			//
			// Basic view
			//

			// Define element
			var calendarBasicViewElement = document.querySelector('.fullcalendar-basic');

			// Initialize
			if(calendarBasicViewElement) {
				var calendarBasicViewInit = new FullCalendar.Calendar(calendarBasicViewElement, {
					plugins: [ 'dayGrid', 'interaction' ],
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'dayGridMonth,dayGridWeek,dayGridDay'
					},
					defaultDate: new Date,
					editable: false,
					events: newPresensi,
					eventLimit: true
				}).render();
			}


			//
			// Agenda view
			//

			// Define element
			var calendarAgendaViewElement = document.querySelector('.fullcalendar-agenda');

			// Initialize
			if(calendarAgendaViewElement) {
				var calendarAgendaViewInit = new FullCalendar.Calendar(calendarAgendaViewElement, {
					plugins: [ 'dayGrid', 'timeGrid', 'interaction' ],
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'dayGridMonth,timeGridWeek,timeGridDay'
					},
					defaultDate: new Date,
					defaultView: 'timeGridWeek',
					editable: true,
					businessHours: true,
					events: events
				}).render();
			}


			//
			// List view
			//

			// Define element
			var calendarListViewElement = document.querySelector('.fullcalendar-list');

			// Initialize
			if(calendarListViewElement) {
				var calendarListViewInit = new FullCalendar.Calendar(calendarListViewElement, {
					plugins: [ 'list', 'interaction' ],
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'listDay,listWeek,listMonth'
					},
					views: {
						listDay: { buttonText: 'Day' },
						listWeek: { buttonText: 'Week' },
						listMonth: { buttonText: 'Month' }
					},
					defaultView: 'listMonth',
					defaultDate: new Date,
					navLinks: true, // can click day/week names to navigate views
					editable: true,
					eventLimit: true, // allow "more" link when too many events
					events: events
				}).render();
			}

		}
			})
		};


		//
		// Return objects assigned to module
		//

		return {
			init: function() {
				_componentFullCalendarBasic();
			}
		}
		}();


		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		FullCalendarBasic.init();
		});
	</script>
@endsection