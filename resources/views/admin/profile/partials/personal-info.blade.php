<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Personal Information</h5>
    </div>
    <div class="card-body">
        <form id="personalInfoForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone" value="{{ $user->phone }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" value="{{ $user->userDetail->company_name ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">District</label>
                        <input type="text" class="form-control" name="district" value="{{ $user->userDetail->district ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="state" value="{{ $user->userDetail->state ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Pincode</label>
                        <input type="text" class="form-control" name="pincode" value="{{ $user->userDetail->pincode ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="button" class="btn btn-light me-2" onclick="$('#personalInfoForm')[0].reset()">
                    <i class="ti ti-refresh me-1"></i>Reset
                </button>
                <button type="submit" class="btn btn-primary" id="updateProfileBtn">
                    <i class="ti ti-check me-1"></i>Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
