
<div class="navbar navbar-expand-md navbar-dark" style="background-color: #39b772">
	<div class="navbar-brand" style="padding-top: 0px;padding-bottom: 0px;min-width:100px">
		<a href="index.html" class="d-inline-block">
			<img src="{{ URL::asset('global_assets/images/nore_w_1000px.png') }}" alt="" style="height:48px">
		</a>
	</div>

	<div class="d-md-none">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
			<i class="icon-tree5"></i>
		</button>
		<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
			<i class="icon-paragraph-justify3"></i>
		</button>
	</div>

	<div class="collapse navbar-collapse" id="navbar-mobile">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
					<i class="icon-paragraph-justify3"></i>
				</a>
			</li>
		</ul>

		<span class="ml-md-3 mr-md-auto">&nbsp;</span>

		<ul class="navbar-nav">


			<li class="nav-item dropdown">
				<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown" id="notifButton">
					<i class="icon-bell3"></i>
					<span class="d-md-none ml-2">Notification</span>
					<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0" id="countNotif">{{ $count }}</span>
				</a>
				
				<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
					<div class="dropdown-content-header">
						<span class="font-weight-semibold">Notifikasi</span>
					</div>

					<div class="dropdown-content-body dropdown-scrollable">
						<ul class="media-list">
							@foreach($notif as $data)
							<li class="media" style="border-top: solid;border-width: 1px;border-color: #39b772;padding-top: 15px;">
								<!-- <div class="mr-3 position-relative">
									<img src="{{ URL::asset('global_assets/images/placeholders/placeholder.jpg') }}" width="36" height="36" class="rounded-circle" alt="">
								</div> -->

								<div class="media-body">
									<div class="media-title">
										<a href="#">
											<span class="font-weight-semibold">{{ $data->title }}</span>
											<!-- <span class="text-muted float-right font-size-sm">04:58</span> -->
										</a>
									</div>

									<span class="text-muted">{{ $data->message }}</span>
								</div>
								<hr>
							</li>
							@endforeach
						</ul>
					</div>

					<div class="dropdown-content-footer justify-content-center p-0">
						<a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Show All"><i class="icon-menu7 d-block top-0"></i></a>
					</div>
				</div>
			</li>

			<li class="nav-item dropdown dropdown-user">
				<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
					<img src="{{ URL::asset('global_assets/images/user-default.png') }}" class="rounded-circle mr-2" height="34" alt="">
					<span>{{\Auth::user()->nama}}</span>
				</a>

				<div class="dropdown-menu dropdown-menu-right">
					<!-- <a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a> -->
					<a href="{{ url('/changepass') }}" class="dropdown-item"><i class="icon-cog5"></i> Ganti Password</a>
					<a href="{{ url('/logout') }}" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
				</div>
			</li>
		</ul>
	</div>
</div>
