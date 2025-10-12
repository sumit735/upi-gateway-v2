@extends('admin.layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            @include('admin.settings.partials.settings-topbar')

            <div class="row">
                <div class="col-xl-3 theiaStickySidebar">
                    @include('admin.settings.partials.settings-sidebar')
                </div>

                <div class="col-xl-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="web-config" role="tabpanel">
                                    @include('admin.settings.partials.web-config-tab', ['settings' => $webConfigSettings])
                                </div>

                                <div class="tab-pane fade" id="rates" role="tabpanel">
                                    @include('admin.settings.partials.rates-tab', ['settings' => $ratesSettings])
                                </div>

                                <div class="tab-pane fade" id="pg-config" role="tabpanel">
                                    @include('admin.settings.partials.pg-config-tab', ['settings' => $pgConfigSettings])
                                </div>

                                <div class="tab-pane fade" id="api-config" role="tabpanel">
                                    @include('admin.settings.partials.api-config-tab', ['settings' => $apiConfigSettings])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('admin.partials.toastAndModal')
@endsection

@push('scripts')

    <script src="{{asset('admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js')}}"></script>
    <script>

        function submitSettingsForm(formElement, category) {
            const formData = new FormData(formElement);
            formData.append('category', category);

            $.ajax({
                url: '{{ route("admin.settings.update") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    showToast('success', response.message || 'Settings updated successfully');

                    if (response.uploads) {
                        Object.keys(response.uploads).forEach(function (key) {
                            const previewElement = document.querySelector(`[data-setting="${key}"]`);
                            if (previewElement) {
                                previewElement.src = response.uploads[key];
                            }
                        });
                    }
                },
                error: function (xhr) {
                    const errorMsg = xhr.responseJSON?.message || 'Failed to update settings';
                    showToast('error', errorMsg);

                    if (xhr.responseJSON?.errors) {
                        Object.values(xhr.responseJSON.errors).forEach(function (errors) {
                            errors.forEach(function (error) {
                                showToast('error', error);
                            });
                        });
                    }
                }
            });
        }

        function previewImage(input, previewElement) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewElement.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
            tabButtons.forEach(function (button) {
                button.addEventListener('shown.bs.tab', function (e) {
                    const sidebarLinks = document.querySelectorAll('.settings-list a');

                    // Remove active class and arrow icon from all sidebar links
                    sidebarLinks.forEach(function (link) {
                        link.classList.remove('active');
                        const existingArrow = link.querySelector('.ti-arrow-badge-right');
                        if (existingArrow) {
                            existingArrow.remove();
                        }
                    });

                    // Add active class and arrow icon to the corresponding sidebar link
                    const targetId = e.target.getAttribute('id');
                    const correspondingSidebarLink = document.querySelector(`.settings-list a[data-tab="${targetId}"]`);
                    if (correspondingSidebarLink) {
                        correspondingSidebarLink.classList.add('active');
                        // Add arrow icon at the beginning
                        const arrowIcon = document.createElement('i');
                        arrowIcon.className = 'ti ti-arrow-badge-right me-2';
                        correspondingSidebarLink.insertBefore(arrowIcon, correspondingSidebarLink.firstChild);
                    }
                });
            });
        });
    </script>
@endpush