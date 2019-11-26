
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md" style="background-color: #229c59">

	<!-- Sidebar mobile toggler -->
	<div class="sidebar-mobile-toggler text-center">
		<a href="#" class="sidebar-mobile-main-toggle">
			<i class="icon-arrow-left8"></i>
		</a>
		Navigation
		<a href="#" class="sidebar-mobile-expand">
			<i class="icon-screen-full"></i>
			<i class="icon-screen-normal"></i>
		</a>
	</div>
	<!-- /sidebar mobile toggler -->


	<!-- Sidebar content -->
	<div class="sidebar-content">

		<!-- Main navigation -->
		<div class="card card-sidebar-mobile">
			<ul class="nav nav-sidebar" data-nav-type="accordion">

				<!-- Main -->
				<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Menu</div> <i class="icon-menu" title="Main"></i></li>

				@if(Auth::user()->role==1)
					<li class="nav-item">
						<a href="{{ url('/admin') }}" class="nav-link {{ (request()->is('admin*')) ? 'active' : '' }}">
							<i class="icon-home4"></i>
							<span>
								Dashboard
							</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('/users') }}" class="nav-link {{ (request()->is('users*')) ? 'active' : '' }}">
							<i class="icon-users"></i>
							<span>
								User
							</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('/tasks') }}" class="nav-link {{ (request()->is('tasks*')) ? 'active' : '' }}">
							<i class="icon-stack-text"></i>
							<span>
								Task
							</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('/payments') }}" class="nav-link {{ (request()->is('payments*')) ? 'active' : '' }}">
							<i class="icon-coin-dollar"></i>
							<span>
								Pembayaran
							</span>
						</a>
					</li>

				@elseif(Auth::user()->role==10)
					<li class="nav-item">
						<a href="{{ url('/karyawan') }}" class="nav-link {{ (request()->is('karyawan*')) ? 'active' : '' }}">
							<i class="icon-home4"></i>
							<span>
								Dashboard
							</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('/tasks') }}" class="nav-link {{ (request()->is('tasks*')) ? 'active' : '' }}">
							<i class="icon-stack-text"></i>
							<span>
								Task
							</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('/payments') }}" class="nav-link {{ (request()->is('payments*')) ? 'active' : '' }}">
							<i class="icon-coin-dollar"></i>
							<span>
								Pembayaran
							</span>
						</a>
					</li>


				@elseif(Auth::user()->role==99)
					<li class="nav-item">
						<a href="{{ url('/customer') }}" class="nav-link {{ (request()->is('customer*')) ? 'active' : '' }}">
							<i class="icon-home4"></i>
							<span>
								Dashboard
							</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('/tasks') }}" class="nav-link {{ (request()->is('tasks*')) ? 'active' : '' }}">
							<i class="icon-stack-text"></i>
							<span>
								Task
							</span>
						</a>
					</li>

				@endif

			</ul>
		</div>
		<!-- /main navigation -->

	</div>
	<!-- /sidebar content -->
	
</div>