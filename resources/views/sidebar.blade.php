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

				{{-- Super admin --}}
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
					<a href="{{ url('/klien') }}" class="nav-link {{ (request()->is('klien*')) ? 'active' : '' }}">
						<i class="icon-people"></i>
						<span>
							Leads
						</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('/targetmarketing') }}" class="nav-link {{ (request()->is('targetmarketing*')) ? 'active' : '' }}">
						<i class="icon-clipboard3"></i>
						<span>
							Target Marketing
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
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link {{ (request()->is('users*','members*','proyeks*')) ? 'active' : '' }}"><i class="icon-users"></i>
						<span>Users
						</span>
					</a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('users*','members*','proyeks*')) ? 'block' : 'none' }};">
						<li class="nav-item">
							<a href="{{ url('/users') }}" class="nav-link {{ (request()->is('users*')) ? 'active' : '' }}">
								<i class="icon-vcard"></i>
								<span>
									Karyawan
								</span>
							</a>
						</li>
						<li class="nav-item nav-item-submenu">
							<a href="{{ url('/members') }}" class="nav-link {{ (request()->is('members*','proyeks*')) ? 'active' : '' }}">
								<i class="icon-briefcase"></i>
								<span>
									Member & Proyek
								</span>
							</a>
							<ul class="nav nav-group-sub" style="display: {{ (request()->is('members*','proyeks*')) ? 'block' : 'none' }};">
								<li class="nav-item"><a href="{{ url('/members') }}" class="nav-link {{ (request()->is('members*')) ? 'active' : '' }}">
									<i class="icon-user"></i>
									<span>
										Daftar Member
									</span>
								</a></li>
								<li class="nav-item"><a href="{{url('proyeks')}}" class="nav-link {{ (request()->is('proyeks*')) ? 'active' : '' }}">
									<i class="icon-traffic-cone"></i>
									<span>
										Data Proyek
									</span>
								</a></li>
							</ul>
						</li>
					</ul>
				</li>

				{{-- Karyawan non keuangan --}}
				@elseif(Auth::user()->role>20 && \Auth::user()->role< 40)
				<li class="nav-item">
					<a href="{{ url('/karyawan') }}" class="nav-link {{ (request()->is('karyawan*')) ? 'active' : '' }}">
						<i class="icon-home4"></i>
						<span>
							Dashboard
						</span>
					</a>
				</li>
				<!-- <li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="icon-users4"></i>
						<span>Users &nbsp;
							@if($expired>0)
							<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $expired}}</span>
							@endif -->
						</span>
					</a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('users*','member')) ? 'block' : 'none' }};">
						@if (Auth::user()->role == 60)
						<li class="nav-item">
							<a href="{{ url('/users') }}" class="nav-link {{ (request()->is('users*')) ? 'active' : '' }}">
								<i class="icon-vcard"></i>
								<span>
									Karyawan
								</span>
							</a>
						</li>
						@endif
						<li class="nav-item">
							<a href="{{ url('/members') }}" class="nav-link {{ (request()->is('members')) ? 'active' : '' }}">
								<i class="icon-user-tie"></i>
								<span>
									Member &nbsp;
									@if($expired>0)
									<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $expired}} expired</span>
									@endif
								</span>
							</a>
						</li>
					</ul>
				</li>
				{{-- marketing --}}
				@elseif(Auth::user()->role==50)
				<li class="nav-item">
					<a href="{{ url('/marketing') }}" class="nav-link {{ (request()->is('marketing*')) ? 'active' : '' }}">
						<i class="icon-home4"></i>
						<span>
							Dashboard
						</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('/klien') }}" class="nav-link {{ (request()->is('klien*')) ? 'active' : '' }}">
						<i class="icon-people"></i>
						<span>
							Leads
						</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('/targetmarketing') }}" class="nav-link {{ (request()->is('targetmarketing*')) ? 'active' : '' }}">
						<i class="icon-clipboard3"></i>
						<span>
							Target Marketing
						</span>
					</a>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="{{ url('/members') }}" class="nav-link {{ (request()->is('members*','proyeks*')) ? 'active' : '' }}">
						<i class="icon-briefcase"></i>
						<span>
							Member & Proyek
						</span>
					</a>
					<ul class="nav nav-group-sub" style="display: {{ (request()->is('members*','proyeks*')) ? 'block' : 'none' }};">
						<li class="nav-item"><a href="{{ url('/members') }}" class="nav-link {{ (request()->is('members*')) ? 'active' : '' }}">
							<i class="icon-user"></i>
							<span>
								Daftar Member
							</span>
						</a></li>
						<li class="nav-item"><a href="{{url('proyeks')}}" class="nav-link {{ (request()->is('proyeks*')) ? 'active' : '' }}">
							<i class="icon-traffic-cone"></i>
							<span>
								Data Proyek
							</span>
						</a></li>
					</ul>
				</li>
				{{-- Keuangan --}}
				@elseif(Auth::user()->role==20)
				<li class="nav-item">
					<a href="{{ url('/keuangan') }}" class="nav-link {{ (request()->is('keuangan*')) ? 'active' : '' }}">
						<i class="icon-home4"></i>
						<span>
							Dashboard
						</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('/klien') }}" class="nav-link {{ (request()->is('klien*')) ? 'active' : '' }}">
						<i class="icon-people"></i>
						<span>
							Leads
						</span>
					</a>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="icon-users4"></i>
						<span>Users &nbsp;
							@if($expired>0)
							<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $expired}}</span>
							@endif
						</span>
					</a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('users*','member')) ? 'block' : 'none' }};">
						<li class="nav-item">
							<a href="{{ url('/users') }}" class="nav-link {{ (request()->is('users')) ? 'active' : '' }}">
								<i class="icon-briefcase"></i>
								<span>
									Karyawan
								</span>
							</a>
						</li>
						<li class="nav-item nav-item-submenu">
							<a href="{{ url('/members') }}" class="nav-link {{ (request()->is('members*','proyeks*')) ? 'active' : '' }}">
								<i class="icon-briefcase"></i>
								<span>
									Member & Proyek
								</span>
							</a>
							<ul class="nav nav-group-sub" style="display: {{ (request()->is('members*','proyeks*')) ? 'block' : 'none' }};">
								<li class="nav-item"><a href="{{ url('/members') }}" class="nav-link {{ (request()->is('members*')) ? 'active' : '' }}">
									<i class="icon-user"></i>
									<span>
										Daftar Member
									</span>
								</a></li>
								<li class="nav-item"><a href="{{url('proyeks')}}" class="nav-link {{ (request()->is('proyeks*')) ? 'active' : '' }}">
									<i class="icon-traffic-cone"></i>
									<span>
										Data Proyek
									</span>
								</a></li>
							</ul>
						</li>
					</ul>
				</li>

				{{-- Client --}}
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

				{{-- Kantor --}}
				@if (Auth::user()->role< 80)
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link {{ (request()->is('calendar*','presensi*','cuti*', 'history-cuti*')) ? 'active' : '' }}"><i class="icon-cabinet"></i>
						<span>
							Presensi
							@if ($unverifiedcuti > 0)
							<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $unverifiedcuti}}</span>
							@endif
						</span>
					</a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('kalender*','presensi*','cuti*', 'verifikasi-cuti*', 'history-cuti*', 'generateqr*')) ? 'block' : 'none' }};">
						<li class="nav-item">
							<a href="/kalender" class="nav-link {{ (request()->is('kalender*')) ? 'active' : '' }}">
								<i class="icon-calendar2"></i>
								<span>
									Kalender
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="/presensi" class="nav-link {{ (request()->is('presensi*')) ? 'active' : '' }}">
								<i class="icon-magazine"></i>
								<span>
									Presensi Harian
								</span>
							</a>
						</li>
						@if (Auth::user()->role==1)
						<li class="nav-item">
							<a href="/generateqr" class="nav-link {{ (request()->is('generateqr*')) ? 'active' : '' }}">
								<i class="icon-qrcode"></i>
								<span>
									Cetak Kode QR
								</span>
							</a>
						</li>
						@endif
						<li class="nav-item nav-item-submenu">
							<a href="{{ url('/cuti') }}" class="nav-link {{ (request()->is('cuti*', 'verifikasi-cuti*', 'history-cuti*')) ? 'active' : '' }}">
								<i class="icon-drawer3"></i>
								<span>
									Cuti
									@if ($unverifiedcuti > 0)
									<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $unverifiedcuti}}</span>
									@endif
								</span>
							</a>
							<ul class="nav nav-group-sub" style="display: {{ (request()->is('cuti*', 'verifikasi-cuti*', 'history-cuti*')) ? 'block' : 'none' }};">
								<li class="nav-item"><a href="{{ url('/cuti') }}" class="nav-link {{ (request()->is('cuti*')) ? 'active' : '' }}">
									<i class="icon-file-text3"></i>
									<span>
										Pengajuan Cuti
									</span>
								</a></li>
								<li class="nav-item"><a href="{{ url('/verifikasi-cuti') }}" class="nav-link {{ (request()->is('verifikasi-cuti*')) ? 'active' : '' }}">
									<i class="icon-file-eye2"></i>
									<span>
										Verifikasi Cuti
										@if ($unverifiedcuti > 0)
										<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $unverifiedcuti}} permohonan</span>
										@endif
									</span>
								</a></li>
								<li class="nav-item"><a href="{{url('/history-cuti')}}" class="nav-link {{ (request()->is('history-cuti*')) ? 'active' : '' }}">
									<i class="icon-file-check2"></i>
									<span>
										History Cuti
									</span>
								</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link {{ (request()->is('task*','history','antrian')) ? 'active' : 'none' }}"><i class="icon-stack-text"></i><span>Pengoperasian</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('task*','history','antrian')) ? 'block' : 'none' }};">
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
					</ul>
				</li>
				@endif

				{{-- Super admin dan keuangan --}}
				@if (Auth::user()->role==1||Auth::user()->role==20)
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link {{ (request()->is('tagihans*','rekaptagihans*','rekapdptagihans*','payments*','pemasukans*','pengeluarans*','laporankeuangan', 'historydp', 'historytagihan','setting*')) ? 'active' : 'none' }}"><i class="icon-coin-dollar"></i>
							<span>
								Keuangan
								@if($confirmpayments>0)
									<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $confirmpayments}}</span>
								@endif
							</span>
					</a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('tagihans*','rekaptagihans*','rekapdptagihans*','payments*','pemasukans*','pengeluarans*','laporankeuangan', 'historydp', 'historytagihan', 'setting*')) ? 'block' : 'none' }};">
						<li class="nav-item">
							<li class="nav-item nav-item-submenu">
								<a href="#" class="nav-link {{ (request()->is('tagihans*','rekapdptagihans*', 'rekaptagihans*', 'historydp', 'historytagihan')) ? 'active' : '' }}">
									<i class="icon-paste"></i>
									<span>
										Tagihan & Rekap
									</span>
								</a>
								<ul class="nav nav-group-sub" style="display: {{ (request()->is('tagihans*','rekapdptagihans*', 'rekaptagihans*', 'historydp', 'historytagihan')) ? 'block' : 'none' }};">
									<li class="nav-item">
										<a href="{{ url('/tagihans') }}" class="nav-link {{ (request()->is('tagihans*')) ? 'active' : '' }}">
											<i class="icon-file-text"></i>
											<span>
												Tagihan Client
												{{-- @if ($admunpaid)
												<br><span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{$admunpaid}} Tagihan belum terbayar lunas</span>
												@endif --}}
											</span>
										</a>
									</li>
									<li class="nav-item nav-item-submenu">
										<a href="#" class="nav-link {{ (request()->is('rekapdptagihans*', 'rekaptagihans*', 'historydp', 'historytagihan')) ? 'active' : '' }}">
											<i class="icon-file-check"></i>
											<span>
												Rekap & History
											</span>
										</a>
										<ul class="nav nav-group-sub" style="display: {{ (request()->is('rekapdptagihans*', 'rekaptagihans*', 'historydp', 'historytagihan')) ? 'block' : 'none' }};">
											<li class="nav-item">
												<a href="{{ url('/rekapdptagihans') }}" class="nav-link {{ (request()->is('rekapdptagihans*')) ? 'active' : '' }}">
													<i class="icon-clipboard"></i>
													<span>
														Rekap Uang Muka
													</span>
												</a>
											</li>
											<li class="nav-item">
												<a href="{{ url('/historydp') }}" class="nav-link {{ (request()->is('historydp')) ? 'active' : '' }}">
													<i class="icon-clipboard icon-clipboard2"></i>
													<span>
														History Uang Muka
													</span>
												</a>
											</li>
											<li class="nav-item">
												<a href="{{ url('/rekaptagihans') }}" class="nav-link {{ (request()->is('rekaptagihans*')) ? 'active' : '' }}">
													<i class="icon-clipboard"></i>
													<span>
														Rekap Tagihan
													</span>
												</a>
											</li>
											<li class="nav-item">
												<a href="{{ url('/historytagihan') }}" class="nav-link {{ (request()->is('historytagihan')) ? 'active' : '' }}">
													<i class="icon-clipboard icon-clipboard2"></i>
													<span>
														History Tagihan
													</span>
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</li>
						</li>
						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link {{ (request()->is('payments*','pemasukans*')) ? 'active' : '' }}"><i class="icon-coins"></i>
								<span>
									Pembayaran
									@if($confirmpayments>0)
										<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $confirmpayments}}</span>
									@endif
								</span>
							</a>
							<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('payments*','pemasukans*')) ? 'block' : 'none' }};">
								<li class="nav-item">
									<a href="{{ url('/payments') }}" class="nav-link {{ (request()->is('payments*')) ? 'active' : '' }}">
										<i class="icon-coin-dollar"></i>
										<span>
											Pembayaran Tagihan
											@if($confirmpayments>0)
												<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $confirmpayments}} konfirmasi</span>
											@endif
										</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ url('/pemasukans') }}" class="nav-link {{ (request()->is('pemasukans*')) ? 'active' : '' }}">
										<i class="icon-cash"></i>
										<span>
											Pembayaran Lain - Lain
										</span>
									</a>
								</li>
							</ul>
						</li>
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
						<li class="nav-item">
							<a href="{{ url('/setting') }}" class="nav-link {{ (request()->is('setting*')) ? 'active' : '' }}">
								<i class="icon-gear"></i>
								<span>
									Setting Print
								</span>
							</a>
						</li>
					</ul>
				</li>
				@endif
				@if(Auth::user()->role==1 || Auth::user()->role==20)
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link  {{ (request()->is('statistik*')) ? 'active' : '' }}"><i class="icon-stats-dots"></i> <span>Statistik</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="JSON forms" style="display: {{ (request()->is('statistik*')) ? 'block' : 'none' }};">
						<li class="nav-item">
							<a href="{{ url('/statistiktask') }}" class="nav-link {{ (request()->is('statistiktask*')) ? 'active' : '' }}">
								<i class="icon-stack-text"></i>
								<span>
									Task
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/statistikpayment') }}" class="nav-link {{ (request()->is('statistikpayment*')) ? 'active' : '' }}">
								<i class="icon-coins"></i>
								<span>
									Pembayaran
								</span>
							</a>
						</li>
					</ul>
				</li>
				
				@endif
			</ul>
		</div>
		<!-- /main navigation -->

	</div>
	<!-- /sidebar content -->

</div>
