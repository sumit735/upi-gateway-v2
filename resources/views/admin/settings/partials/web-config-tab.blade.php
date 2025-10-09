<form id="webConfigForm" onsubmit="event.preventDefault(); submitSettingsForm(this, 'web_config');" enctype="multipart/form-data">
    @csrf
    
    <div class="border-bottom mb-4 pb-3">
        <h5>Basic Information</h5>
    </div>

    <div class="row">
        @foreach($settings->where('key', '!=', 'logo')->where('key', '!=', 'favicon') as $setting)
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>
                    <input type="hidden" name="settings[{{ $setting->id }}][id]" value="{{ $setting->id }}">
                    
                    @if($setting->key == 'trial_period')
                        <div class="input-group">
                            <input type="number" class="form-control" name="settings[{{ $setting->id }}][value]" value="{{ $setting->value }}" placeholder="Enter {{ strtolower(str_replace('_', ' ', $setting->key)) }}">
                            <span class="input-group-text">days</span>
                        </div>
                    @else
                        <input type="text" class="form-control" name="settings[{{ $setting->id }}][value]" value="{{ $setting->value }}" placeholder="Enter {{ strtolower(str_replace('_', ' ', $setting->key)) }}">
                    @endif
                    
                    @if($setting->description)
                        <small class="form-text text-muted">{{ $setting->description }}</small>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="border-bottom mb-4 pb-3 mt-4">
        <h5>Branding Images</h5>
    </div>

    <div class="row">
        @php
            $logo = $settings->where('key', 'logo')->first();
            $favicon = $settings->where('key', 'favicon')->first();
        @endphp

        <!-- Logo Upload -->
        @if($logo)
            <div class="col-md-6">
                <div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">                                                
                    <div class="d-flex align-items-center justify-content-center avatar avatar-xxl bg-white rounded border border-dashed me-2 flex-shrink-0 text-dark frames px-2">
                        <img src="{{ asset('admin/assets/img/' . ($logo->value ?: 'logo.svg')) }}" 
                             class="img-fluid" 
                             alt="logo"
                             data-setting="logo"
                             id="logoPreview">
                    </div>                                              
                    <div class="profile-upload">
                        <div class="mb-2">
                            <h6 class="mb-1">Website Logo</h6>
                            <p class="fs-12 mb-0">Recommended image size is 160px x 50px</p>
                        </div>
                        <div class="profile-uploader d-flex align-items-center">
                            <div class="drag-upload-btn btn btn-sm btn-primary me-2">
                                Change Logo
                                <input type="file" 
                                       class="form-control image-sign" 
                                       name="logo_file" 
                                       accept="image/*"
                                       onchange="previewImage(this, document.getElementById('logoPreview'))">
                            </div>
                            <button type="button" class="btn btn-light btn-sm" onclick="document.querySelector('input[name=logo_file]').value = ''; document.getElementById('logoPreview').src = '{{ asset('admin/assets/img/logo.svg') }}';">Cancel</button>
                        </div>
                    </div>
                </div>
                {{-- <input type="hidden" name="settings[{{ $logo->id }}][id]" value="{{ $logo->id }}">
                <input type="hidden" name="settings[{{ $logo->id }}][value]" value="{{ $logo->value }}"> --}}
            </div>
        @endif

        <!-- Favicon Upload -->
        @if($favicon)
            <div class="col-md-6">
                <div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">                                                
                    <div class="d-flex align-items-center justify-content-center avatar avatar-xxl bg-white rounded border border-dashed me-2 flex-shrink-0 text-dark frames px-2">
                        <img src="{{ asset('admin/assets/img/' . ($favicon->value ?: 'favicon.ico')) }}" 
                             class="img-fluid" 
                             alt="favicon"
                             data-setting="favicon"
                             id="faviconPreview"
                             style="max-height: 64px;">
                    </div>                                              
                    <div class="profile-upload">
                        <div class="mb-2">
                            <h6 class="mb-1">Website Favicon</h6>
                            <p class="fs-12 mb-0">Recommended size is 32px x 32px (.ico format)</p>
                        </div>
                        <div class="profile-uploader d-flex align-items-center">
                            <div class="drag-upload-btn btn btn-sm btn-primary me-2">
                                Change Favicon
                                <input type="file" 
                                       class="form-control image-sign" 
                                       name="favicon_file" 
                                       accept="image/*,.ico"
                                       onchange="previewImage(this, document.getElementById('faviconPreview'))">
                            </div>
                            <button type="button" class="btn btn-light btn-sm" onclick="document.querySelector('input[name=favicon_file]').value = ''; document.getElementById('faviconPreview').src = '{{ asset('admin/assets/img/favicon.ico') }}';">Cancel</button>
                        </div>
                    </div>
                </div>
                {{-- <input type="hidden" name="settings[{{ $favicon->id }}][id]" value="{{ $favicon->id }}">
                <input type="hidden" name="settings[{{ $favicon->id }}][value]" value="{{ $favicon->value }}"> --}}
            </div>
        @endif
    </div>

    <div class="d-flex align-items-center justify-content-end mt-4">
        <button type="button" class="btn btn-outline-light border me-3" onclick="document.getElementById('webConfigForm').reset();">
            <i class="ti ti-rotate me-2"></i>Reset
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-2"></i>Save Changes
        </button>
    </div>
</form>
