<style>

ul{
	list-style-type: none;
}

</style>


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
				<!-- <li class="nav-item">
					<a href="{{ url('/setting') }}" class="nav-link {{ (request()->is('setting*')) ? 'active' : '' }}">
						<i class="icon-gear"></i>
						<span>
							Setting Print
						</span>
					</a>
				</li> -->
				<li class="nav-item">
					<a href="{{ url('/users') }}" class="nav-link {{ (request()->is('users*')) ? 'active' : '' }}">
						<i class="icon-users"></i>
						<span>
							User &nbsp;
							@if($expired>0)
							<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $expired}} expired</span>
							@endif
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
				
				@else
				<li class="nav-item">
					<a href="{{ url('/customer') }}" class="nav-link {{ (request()->is('customer*')) ? 'active' : '' }}">
						<i class="icon-home4"></i>
						<span>
							Dashboard
						</span>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="{{ url('/tagihanuser') }}" class="nav-link {{ (request()->is('tagihanuser*')) ? 'active' : '' }}">
						<i class="icon-file-text"></i>
						<span>
							Daftar Tagihan
							@if ($userunpaid)
							<br><span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{$userunpaid}} Tagihan belum terbayar lunas</span>
							@endif
						</span>
					</a>
				</li>
				
				@endif

				@if (Auth::user()->role==1||Auth::user()->role==10)

				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="icon-stack-text"></i><span>Pengoperasian</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('statistik*')) ? 'block' : 'none' }};">
						<li class="nav-item">
							<a href="{{ url('/tasks') }}" class="nav-link {{ (request()->is('tasks*')) ? 'active' : '' }}">
								<i class="icon-stack-text"></i>
								<span>
									Task
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/history') }}" class="nav-link {{ (request()->is('history')) ? 'active' : '' }}">
								<i class="icon-history"></i>
								<span>
									History Task
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/antrian') }}" class="nav-link {{ (request()->is('antrian')) ? 'active' : '' }}">
								<i class="icon-list-ordered"></i>
								<span>
									Antrian
								</span>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="icon-coin-dollar"></i><span>Keuangan</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms">
					@if (Auth::user()->role==1||Auth::user()->role==10)
					<li class="nav-item">
						<a href="{{ url('/tagihans') }}" class="nav-link {{ (request()->is('tagihans*')) ? 'active' : '' }}">
							<i class="icon-file-text"></i>
							<span>
								Tagihan 
								@if ($admunpaid)
								<br><span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{$admunpaid}} Tagihan belum terbayar lunas</span>
								@endif
							</span>
						</a>
					</li>
					@endif
					<li class="nav-item">
						<a href="{{ url('/payments') }}" class="nav-link {{ (request()->is('payments*')) ? 'active' : '' }}">
							<i class="icon-coin-dollar"></i>
							<span>
								Pembayaran
							</span>
						</a>
					</li>
					@if(Auth::user()->role==1)
					<li class="nav-item">
					<a href="{{ url('/pengeluarans') }}" class="nav-link {{ (request()->is('pengeluarans*')) ? 'active' : '' }}">
						<i class="icon-rotate-cw"></i>
						<span>
							Pengeluaran
						</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('/laporankeuangan') }}" class="nav-link {{ (request()->is('laporankeuangan')) ? 'active' : '' }}">
						<i class="icon-balance"></i>
						<span>
							Laporan Keuangan
						</span>
					</a>
				</li>
					</ul>
				</li>
				@endif
				@endif

				@if (Auth::user()->role!=1 && Auth::user()->role!=10)

				<li class="nav-item">
					<a href="{{ url('/tasks') }}" class="nav-link {{ (request()->is('tasks*')) ? 'active' : '' }}">
						<i class="icon-stack-text"></i>
						<span>
							Task
						</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="{{ url('/history') }}" class="nav-link {{ (request()->is('history')) ? 'active' : '' }}">
						<i class="icon-history"></i>
						<span>
							History Task
						</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="{{ url('/antrian') }}" class="nav-link {{ (request()->is('antrian')) ? 'active' : '' }}">
						<i class="icon-list-ordered"></i>
						<span>
							Antrian
						</span>
					</a>
				</li>
				@endif

				@if(Auth::user()->role==1)
				<li class="nav-item nav-item-submenu {{ (request()->is('statistik*')) ? 'nav-item-open' : '' }}">
					<a href="#" class="nav-link"><i class="icon-stats-dots"></i> <span>Statistik</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('statistik*')) ? 'block' : 'none' }};">
						<li class="nav-item">
							<a href="{{ url('/statistiktask') }}" class="nav-link {{ (request()->is('statistiktask*')) ? 'active' : '' }}">
								<span>
									Task
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/statistikpayment') }}" class="nav-link {{ (request()->is('statistikpayment*')) ? 'active' : '' }}">
								<span>
									Pembayaran
								</span>
							</a>
						</li>
						
					</ul>
				</li>
				<li class="nav-item">
					<a href="{{ url('/setting') }}" class="nav-link {{ (request()->is('setting*')) ? 'active' : '' }}">
						<i class="icon-gear"></i>
						<span>
							Setting Print
						</span>
					</a>
				</li>
				@endif
				
				<!-- ALL ROLE -->

				<!-- <li class="nav-item">
					<a href="{{ url('/tasks') }}" class="nav-link {{ (request()->is('tasks*')) ? 'active' : '' }}">
						<i class="icon-stack-text"></i>
						<span>
							Task
						</span>
					</a>
				</li> -->
				
				<!-- <li class="nav-item">
					<a href="{{ url('/history') }}" class="nav-link {{ (request()->is('history')) ? 'active' : '' }}">
						<i class="icon-history"></i>
						<span>
							History Task
						</span>
					</a>
				</li> -->
				
				<!-- <li class="nav-item">
					<a href="{{ url('/antrian') }}" class="nav-link {{ (request()->is('antrian')) ? 'active' : '' }}">
						<i class="icon-list-ordered"></i>
						<span>
							Antrian
						</span>
					</a>
				</li> -->
				
				
<!-- 				
				@if(Auth::user()->role>=1)
				
				@if (Auth::user()->role==1||Auth::user()->role==10)
				<li class="nav-item">
					<a href="{{ url('/tagihans') }}" class="nav-link {{ (request()->is('tagihans*')) ? 'active' : '' }}">
						<i class="icon-file-text"></i>
						<span>
							Tagihan 
							@if ($admunpaid)
							<br><span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{$admunpaid}} Tagihan belum terbayar lunas</span>
							@endif
							
						</span>
					</a>
				</li>
				@endif

				<li class="nav-item">
					<a href="{{ url('/payments') }}" class="nav-link {{ (request()->is('payments*')) ? 'active' : '' }}">
						<i class="icon-coin-dollar"></i>
						<span>
							Pembayaran
						</span>
					</a>
				</li>
				
				@if (Auth::user()->role==1)
				<li class="nav-item">
					<a href="{{ url('/pengeluarans') }}" class="nav-link {{ (request()->is('pengeluarans*')) ? 'active' : '' }}">
						<i class="icon-rotate-cw"></i>
						<span>
							Pengeluaran
						</span>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="{{ url('/laporankeuangan') }}" class="nav-link {{ (request()->is('laporankeuangan')) ? 'active' : '' }}">
						<i class="icon-balance"></i>
						<span>
							Laporan Keuangan
						</span>
					</a>
				</li>
				
				<li class="nav-item nav-item-submenu {{ (request()->is('statistik*')) ? 'nav-item-open' : '' }}">
					<a href="#" class="nav-link"><i class="icon-stats-dots"></i> <span>Statistik</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('statistik*')) ? 'block' : 'none' }};">
						<li class="nav-item">
							<a href="{{ url('/statistiktask') }}" class="nav-link {{ (request()->is('statistiktask*')) ? 'active' : '' }}">
								<span>
									Task
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/statistikpayment') }}" class="nav-link {{ (request()->is('statistikpayment*')) ? 'active' : '' }}">
								<span>
									Pembayaran
								</span>
							</a>
						</li>
						
					</ul>
				</li>
				@endif
				
				@endif
				 -->
			</ul>
		</div>
		<!-- /main navigation -->
		
	</div>
	<!-- /sidebar content -->
	
</div>