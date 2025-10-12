
	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="{{ asset('admin/assets/js/jquery-3.7.1.min.js') }}"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

	<!-- Feather Icon JS -->
	<script src="{{ asset('admin/assets/js/feather.min.js') }}"></script>

	<!-- Slimscroll JS -->
	<script src="{{ asset('admin/assets/js/jquery.slimscroll.min.js') }}"></script>

	<!-- Chart JS -->
	<script src="{{ asset('admin/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/apexchart/chart-data.js') }}"></script>

	<!-- Chart JS -->
	<script src="{{ asset('admin/assets/plugins/chartjs/chart.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/chartjs/chart-data.js') }}"></script>

	<!-- Datetimepicker JS -->
	<script src="{{ asset('admin/assets/js/moment.min.js') }}"></script>
	<script src="{{ asset('admin/assets/js/bootstrap-datetimepicker.min.js') }}"></script>

	<!-- Daterangepikcer JS -->
	<script src="{{ asset('admin/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

	<!-- Summernote JS -->
	<script src="{{ asset('admin/assets/plugins/summernote/summernote-lite.min.js') }}"></script>

	<!-- Bootstrap Tagsinput JS -->
	<script src="{{ asset('admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

	<!-- Select2 JS -->
	<script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>

	<!-- Color Picker JS -->
	<script src="{{ asset('admin/assets/plugins/@simonwep/pickr/pickr.es5.min.js') }}"></script>

	<!-- Custom JS -->
	<script src="{{ asset('admin/assets/js/todo.js') }}"></script>
	<script src="{{ asset('admin/assets/js/theme-colorpicker.js') }}"></script>
	
	<!-- Session Timeout Warning Modal -->
	<div class="modal fade" id="sessionTimeoutModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body text-center">
					<span class="avatar avatar-xl bg-transparent-warning text-warning mb-3">
						<i class="ti ti-clock-exclamation fs-36"></i>
					</span>
					<h4 class="mb-2">Session Expiring Soon</h4>
					<p class="mb-1">You will be logged out in <strong class="text-danger" id="sessionTimeoutCountdown">60</strong> seconds due to inactivity.</p>
					<p class="text-muted mb-3">Click "Stay Logged In" to continue your session.</p>
					<div class="d-flex justify-content-center">
						<button type="button" class="btn btn-light me-3" onclick="handleSessionLogout()">
							<i class="ti ti-logout me-1"></i>Logout Now
						</button>
						<button type="button" class="btn btn-primary" onclick="handleSessionExtend()">
							<i class="ti ti-refresh me-1"></i>Stay Logged In
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Session Timeout Script -->
	<script>
		// Session timeout configuration (in milliseconds)
		const SESSION_TIMEOUT = {{ config('session.lifetime') * 60 * 1000 }}; // 10 minutes
		const WARNING_TIME = 60 * 1000; // Show warning 1 minute before timeout
		const COUNTDOWN_INTERVAL = 1000; // Update countdown every minute
		const PING_DEBOUNCE = 30000; // Only ping server once every 30 seconds

		let sessionTimer;
		let warningTimer;
		let countdownTimer;
		let countdownSeconds;
		let warningModal;
		let lastPingTime = 0;
		let activityResetTimer;

		function initSessionTimeout() {
			// Initialize modal
			warningModal = new bootstrap.Modal(document.getElementById('sessionTimeoutModal'));
			
			// Start session timeout
			resetSessionTimeout();

			// Reset timeout on user activity with debounce
			['mousedown', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
				document.addEventListener(event, debouncedResetSessionTimeout, true);
			});
		}

		function debouncedResetSessionTimeout() {
			// Clear existing activity reset timer
			clearTimeout(activityResetTimer);
			
			// Set new timer to reset session after brief delay
			// This prevents multiple rapid calls from the same activity
			activityResetTimer = setTimeout(() => {
				resetSessionTimeout(false); // Don't ping on every activity
			}, 300); // 300ms debounce
		}

		function resetSessionTimeout(shouldPing = true) {
			// Clear existing timers
			clearTimeout(sessionTimer);
			clearTimeout(warningTimer);
			clearInterval(countdownTimer);

			// Hide warning modal if shown
			if (warningModal && bootstrap.Modal.getInstance(document.getElementById('sessionTimeoutModal'))) {
				warningModal.hide();
			}

			// Set timer to show warning
			warningTimer = setTimeout(showSessionWarning, SESSION_TIMEOUT - WARNING_TIME);

			// Set timer to logout
			sessionTimer = setTimeout(handleSessionExpire, SESSION_TIMEOUT);

			// Ping server only if enough time has passed since last ping
			if (shouldPing) {
				const now = Date.now();
				if (now - lastPingTime > PING_DEBOUNCE) {
					lastPingTime = now;
					pingServer();
				}
			}
		}

		function showSessionWarning() {
			// Show warning modal
			warningModal.show();

			// Start countdown
			countdownSeconds = WARNING_TIME / 1000;
			updateCountdown();
			
			countdownTimer = setInterval(() => {
				countdownSeconds--;
				updateCountdown();

				if (countdownSeconds <= 0) {
					clearInterval(countdownTimer);
				}
			}, COUNTDOWN_INTERVAL);
		}

		function updateCountdown() {
			const countdownElement = document.getElementById('sessionTimeoutCountdown');
			if (countdownElement) {
				countdownElement.textContent = countdownSeconds;
			}
		}

		function handleSessionExtend() {
			// User wants to stay logged in
			clearInterval(countdownTimer);
			warningModal.hide();
			
			// Call server to extend session
			fetch('{{ route('session.extend') }}', {
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}',
					'Content-Type': 'application/json',
					'X-Requested-With': 'XMLHttpRequest'
				}
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Update last ping time to current
					lastPingTime = Date.now();
					// Reset timers without pinging again
					resetSessionTimeout(false);
					
					// Show success toast
					if (typeof showToast === 'function') {
						showToast('success', 'Session extended successfully!');
					}
				} else {
					// Session invalid, redirect to login
					window.location.href = '{{ route('logout') }}';
				}
			})
			.catch(error => {
				console.error('Error extending session:', error);
				// Reset on client side even if server call fails
				resetSessionTimeout(false);
			});
		}

		function handleSessionLogout() {
			// User wants to logout now
			clearTimeout(sessionTimer);
			clearTimeout(warningTimer);
			clearInterval(countdownTimer);
			warningModal.hide();
			
			// Redirect to logout
			window.location.href = '{{ route('logout') }}';
		}

		function handleSessionExpire() {
			// Session has expired
			clearInterval(countdownTimer);
			warningModal.hide();
			
			// Show expiry message
			if (typeof showToast === 'function') {
				showToast('error', 'Your session has expired. Redirecting to login...');
			}
			
			// Redirect to logout after a short delay
			setTimeout(() => {
				window.location.href = '{{ route('logout') }}';
			}, 2000);
		}

		function pingServer() {
			// Send a lightweight request to extend session on server
			// This is called on user activity to keep session alive
			fetch('{{ route('session.extend') }}', {
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}',
					'Content-Type': 'application/json',
					'X-Requested-With': 'XMLHttpRequest'
				}
			}).catch(() => {
				// Ignore errors - user might be offline
			});
		}

		// Initialize on page load
		@auth
		document.addEventListener('DOMContentLoaded', initSessionTimeout);
		@endauth
	</script>
	
	<!-- DataTables JS (Optional - Include in specific pages) -->
	@stack('scripts')
	<script src="{{ asset('admin/assets/js/script.js') }}"></script>

</body>

</html>