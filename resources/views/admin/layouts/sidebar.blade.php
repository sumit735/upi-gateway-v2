<!-- Horizontal Menu -->
<div class="sidebar sidebar-horizontal" id="horizontal-menu">
	<div class="sidebar-menu">
		<div class="main-menu">
			<ul class="nav-menu">
				<li class="menu-title">
					<span>Main</span>
				</li>
				
				<!-- Dashboard -->
				<li>
					<a href="{{ route('dashboard') }}">
						<i class="ti ti-smart-home"></i><span>Dashboard</span>
					</a>
				</li>
				
				<!-- User Management -->
				@if(can_page(\App\Enums\PageEnum::USER_MANAGEMENT, \App\Enums\ActionEnum::VIEW))
				<li class="submenu">
					<a href="#">
						<i class="ti ti-users"></i><span>User Management</span>
						<span class="menu-arrow"></span>
					</a>
					<ul>
						<li><a href="{{ route('admin.users.index') }}">Users</a></li>
						<li><a href="{{ route('admin.roles.index') }}">Roles & Permissions</a></li>
					</ul>
				</li>
				@endif
				
				<!-- Profile -->
				@if(can_page(\App\Enums\PageEnum::PROFILE, \App\Enums\ActionEnum::VIEW))
				<li>
					<a href="{{ route('profile.show') }}">
						<i class="ti ti-user"></i><span>My Profile</span>
					</a>
				</li>
				@endif
			</ul>
			<div class="d-xl-flex align-items-center d-none">
				<a href="#" class="me-3 avatar avatar-sm">
					<img src="{{ asset('admin/assets/img/profiles/avatar-07.jpg') }}" alt="profile" class="rounded-circle">
				</a>
				<a href="#" class="btn btn-icon btn-sm rounded-circle mode-toggle">
					<i class="ti ti-sun"></i>
				</a>
			</div>
		</div>
	</div>
</div>
<!-- /Horizontal Menu -->
