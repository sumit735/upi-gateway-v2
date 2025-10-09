<form id="pgConfigForm" onsubmit="event.preventDefault(); submitSettingsForm(this, 'pg_config');">
    @csrf
    
    <div class="border-bottom mb-4 pb-3">
        <h5>Payment Gateway Settings</h5>
        <p class="text-muted">Configure your payment gateway credentials and operational mode</p>
    </div>

    <div class="row">
        @foreach($settings as $setting)
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>
                    <input type="hidden" name="settings[{{ $setting->id }}][id]" value="{{ $setting->id }}">
                    
                    @if($setting->key == 'pg_switcher')
                        <select class="form-select" name="settings[{{ $setting->id }}][value]">
                            <option value="test" {{ $setting->value == 'test' ? 'selected' : '' }}>
                                <i class="ti ti-flask"></i> Test Mode
                            </option>
                            <option value="live" {{ $setting->value == 'live' ? 'selected' : '' }}>
                                <i class="ti ti-bolt"></i> Live Mode
                            </option>
                        </select>
                        <small class="text-warning">
                            <i class="ti ti-alert-triangle me-1"></i>
                            Switching to Live mode will process real transactions
                        </small>
                    @elseif($setting->key == 'pg_api_token')
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="pg_api_token_input"
                                   name="settings[{{ $setting->id }}][value]" 
                                   value="{{ $setting->value }}" 
                                   placeholder="Enter API token">
                            <button class="btn btn-outline-secondary" 
                                    type="button" 
                                    onclick="togglePasswordVisibility('pg_api_token_input', this)">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                    @else
                        <input type="text" 
                               class="form-control" 
                               name="settings[{{ $setting->id }}][value]" 
                               value="{{ $setting->value }}" 
                               placeholder="Enter {{ strtolower(str_replace('_', ' ', $setting->key)) }}">
                    @endif
                    
                    @if($setting->description)
                        <small class="form-text text-muted">{{ $setting->description }}</small>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex align-items-center justify-content-end mt-4">
        <button type="button" class="btn btn-outline-light border me-3" onclick="document.getElementById('pgConfigForm').reset();">
            <i class="ti ti-rotate me-2"></i>Reset
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-2"></i>Save Changes
        </button>
    </div>
</form>

<script>
    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('ti-eye');
            icon.classList.add('ti-eye-off');
        } else {
            input.type = 'password';
            icon.classList.remove('ti-eye-off');
            icon.classList.add('ti-eye');
        }
    }
</script>
