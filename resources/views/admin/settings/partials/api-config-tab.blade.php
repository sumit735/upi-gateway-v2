<form id="apiConfigForm" onsubmit="event.preventDefault(); submitSettingsForm(this, 'api_config');">
    @csrf
    
    <div class="border-bottom mb-4 pb-3">
        <h5>API Integration Settings</h5>
        <p class="text-muted">Configure third-party API endpoints for WhatsApp and Email services</p>
    </div>

    <div class="row">
        @foreach($settings as $setting)
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">
                        @if($setting->key == 'whatsapp_api')
                            <i class="ti ti-brand-whatsapp me-2 text-success"></i>
                        @elseif($setting->key == 'email_api')
                            <i class="ti ti-mail me-2 text-primary"></i>
                        @endif
                        {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                    </label>
                    <input type="hidden" name="settings[{{ $setting->id }}][id]" value="{{ $setting->id }}">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-link"></i></span>
                        <input type="text" 
                               class="form-control" 
                               name="settings[{{ $setting->id }}][value]" 
                               value="{{ $setting->value }}" 
                               placeholder="Enter API endpoint or token (e.g., https://api.example.com/v1)">
                    </div>
                    @if($setting->description)
                        <small class="form-text text-muted">{{ $setting->description }}</small>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="alert alert-info d-flex align-items-start mt-3">
        <i class="ti ti-info-circle me-2 mt-1"></i>
        <div>
            <strong>Note:</strong> These API endpoints will be used for sending automated notifications to users. 
            Ensure the endpoints are valid and accessible.
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-end mt-4">
        <button type="button" class="btn btn-outline-light border me-3" onclick="document.getElementById('apiConfigForm').reset();">
            <i class="ti ti-rotate me-2"></i>Reset
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-2"></i>Save Changes
        </button>
    </div>
</form>
