@extends('admin.layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">My Profile</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- /Breadcrumb -->

            <div class="row">
                <!-- Profile Sidebar -->
                <div class="col-xl-3 theiaStickySidebar">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="avatar avatar-xxl mx-auto mb-3 position-relative">
                                    @if($user->profile_photo)
                                        <img src="{{ Storage::url($user->profile_photo) }}" alt="Profile" class="rounded-circle" id="profilePhotoPreview">
                                    @else
                                        <span class="avatar-title rounded-circle bg-primary text-white fs-32">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </span>
                                    @endif
                                </div>
                                <h5 class="mb-1">{{ $user->name }}</h5>
                                <p class="text-muted mb-3">{{ $user->email }}</p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="$('#uploadPhotoInput').click()">
                                        <i class="ti ti-camera me-1"></i>Upload Photo
                                    </button>
                                    @if($user->profile_photo)
                                        <button type="button" class="btn btn-sm btn-light" onclick="deleteProfilePhoto()">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    @endif
                                </div>
                                <input type="file" id="uploadPhotoInput" accept="image/*" class="d-none" onchange="uploadProfilePhoto(this)">
                            </div>

                            <hr class="my-4">

                            <!-- Navigation Menu -->
                            <ul class="nav nav-pills flex-column" id="profileTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personal-info" role="tab">
                                        <i class="ti ti-user me-2"></i>Personal Information
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#change-password" role="tab">
                                        <i class="ti ti-lock me-2"></i>Change Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#two-factor" role="tab">
                                        <i class="ti ti-shield-check me-2"></i>Two-Factor Auth
                                        @if($user->two_factor_enabled)
                                            <span class="badge badge-sm bg-success ms-auto">Enabled</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#passkeys" role="tab">
                                        <i class="ti ti-key me-2"></i>Passkeys
                                        @if($user->passkeys->count() > 0)
                                            <span class="badge badge-sm bg-primary ms-auto">{{ $user->passkeys->count() }}</span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Profile Sidebar -->

                <!-- Profile Content -->
                <div class="col-xl-9">
                    <div class="tab-content">
                        <!-- Personal Information Tab -->
                        <div class="tab-pane fade show active" id="personal-info" role="tabpanel">
                            @include('admin.profile.partials.personal-info')
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="change-password" role="tabpanel">
                            @include('admin.profile.partials.change-password')
                        </div>

                        <!-- Two-Factor Authentication Tab -->
                        <div class="tab-pane fade" id="two-factor" role="tabpanel">
                            @include('admin.profile.partials.two-factor')
                        </div>

                        <!-- Passkeys Tab -->
                        <div class="tab-pane fade" id="passkeys" role="tabpanel">
                            @include('admin.profile.partials.passkeys')
                        </div>
                    </div>
                </div>
                <!-- /Profile Content -->
            </div>
        </div>
    </div>

    @include('admin.partials.toastAndModal')
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/profile.js') }}"></script>
@endpush
