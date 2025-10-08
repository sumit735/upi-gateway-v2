<!-- Reusable Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <span class="avatar avatar-xl bg-transparent-danger text-danger mb-3" id="confirmModalIcon">
                    <i class="ti ti-trash-x fs-36"></i>
                </span>
                <h4 class="mb-1" id="confirmModalTitle">Confirm Action</h4>
                <p class="mb-3" id="confirmModalMessage">Are you sure you want to perform this action?</p>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmModalBtn">
                        <i class="ti ti-check me-1"></i>Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
