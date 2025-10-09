<form id="ratesForm" onsubmit="event.preventDefault(); submitSettingsForm(this, 'rates');">
    @csrf
    
    <div class="border-bottom mb-4 pb-3">
        <h5>Default Fees & Charges</h5>
        <p class="text-muted">Configure the default registration and subscription fees for new users</p>
    </div>

    <div class="row">
        @foreach($settings as $setting)
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>
                    <input type="hidden" name="settings[{{ $setting->id }}][id]" value="{{ $setting->id }}">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-currency-rupee"></i></span>
                        <input type="number" 
                               step="0.01" 
                               class="form-control" 
                               name="settings[{{ $setting->id }}][value]" 
                               value="{{ $setting->value }}" 
                               placeholder="Enter amount"
                               min="0">
                    </div>
                    @if($setting->description)
                        <small class="form-text text-muted">{{ $setting->description }}</small>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex align-items-center justify-content-end mt-4">
        <button type="button" class="btn btn-outline-light border me-3" onclick="document.getElementById('ratesForm').reset();">
            <i class="ti ti-rotate me-2"></i>Reset
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-2"></i>Save Changes
        </button>
    </div>
</form>
