<script>
/**
 * Toast Notification System
 * Displays temporary notification messages with different types
 */
function showToast(type, message) {
    const toastContainer = getOrCreateToastContainer();

    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;

    // Map type to Bootstrap classes and icons
    let bgClass = 'success';
    let icon = 'check-circle';

    if (type === 'error' || type === 'danger') {
        bgClass = 'danger';
        icon = 'alert-circle';
    } else if (type === 'info') {
        bgClass = 'info';
        icon = 'info-circle';
    } else if (type === 'warning') {
        bgClass = 'warning';
        icon = 'alert-triangle';
    }

    toast.className = `toast align-items-center text-bg-${bgClass} border-0 show`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="ti ti-${icon} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="removeToast('${toastId}')"></button>
        </div>
    `;

    toastContainer.appendChild(toast);

    // Auto remove after 5 seconds
    setTimeout(() => removeToast(toastId), 5000);
}

function removeToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
        toast.classList.add('fade');
        setTimeout(() => toast.remove(), 150);
    }
}

function getOrCreateToastContainer() {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    return container;
}

/**
 * Reusable Confirmation Modal System
 * Displays a customizable confirmation dialog
 * 
 * @param {Object} options - Configuration options
 * @param {string} options.title - Modal title
 * @param {string} options.message - Modal message (supports HTML)
 * @param {string} options.type - Type: 'danger', 'warning', 'success', 'info' (default: 'danger')
 * @param {string} options.icon - Tabler icon class (default: 'ti-trash-x')
 * @param {string} options.confirmText - Confirm button text (default: 'Confirm')
 * @param {string} options.confirmIcon - Confirm button icon (default: 'ti-check')
 * @param {function} options.onConfirm - Callback function when confirmed
 */
function showConfirmModal(options) {
    const defaults = {
        title: 'Confirm Action',
        message: 'Are you sure you want to perform this action?',
        type: 'danger',
        icon: 'ti ti-trash-x',
        confirmText: 'Confirm',
        confirmIcon: 'ti ti-check',
        onConfirm: null
    };

    const config = { ...defaults, ...options };

    // Get modal elements
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const iconElement = document.getElementById('confirmModalIcon');
    const titleElement = document.getElementById('confirmModalTitle');
    const messageElement = document.getElementById('confirmModalMessage');
    const confirmBtn = document.getElementById('confirmModalBtn');

    // Color mapping
    const colorMap = {
        'danger': { bg: 'bg-transparent-danger', text: 'text-danger', btn: 'btn-danger' },
        'warning': { bg: 'bg-transparent-warning', text: 'text-warning', btn: 'btn-warning' },
        'success': { bg: 'bg-transparent-success', text: 'text-success', btn: 'btn-success' },
        'info': { bg: 'bg-transparent-info', text: 'text-info', btn: 'btn-info' }
    };

    const colors = colorMap[config.type] || colorMap['danger'];

    // Update modal appearance
    iconElement.className = `avatar avatar-xl ${colors.bg} ${colors.text} mb-3`;
    iconElement.querySelector('i').className = `${config.icon} fs-36`;
    titleElement.textContent = config.title;
    messageElement.innerHTML = config.message;
    confirmBtn.className = `btn ${colors.btn}`;
    confirmBtn.innerHTML = `<i class="ti ${config.confirmIcon} me-1"></i>${config.confirmText}`;

    // Remove any existing click handlers by cloning
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

    // Add new click handler
    document.getElementById('confirmModalBtn').addEventListener('click', function() {
        modal.hide();
        if (config.onConfirm && typeof config.onConfirm === 'function') {
            config.onConfirm();
        }
    });

    // Show the modal
    modal.show();
}
</script>
