@extends('admin.layouts.app')
@section('content')
	<!-- Two Col Sidebar -->
		<div class="two-col-sidebar" id="two-col-sidebar">
			<div class="sidebar sidebar-twocol">
				<div class="twocol-mini">
					<a href="index.html" class="logo-small">
						<img src="assets/img/logo-small.svg" alt="Logo">
					</a>
					<div class="sidebar-left slimscroll">
						<div class="nav flex-column align-items-center nav-pills" id="sidebar-tabs" role="tablist" aria-orientation="vertical">
							<a href="#" class="nav-link active" title="Dashboard" data-bs-toggle="tab" data-bs-target="#dashboard">
								<i class="ti ti-smart-home"></i>
							</a>
							<a href="#" class="nav-link" title="Apps" data-bs-toggle="tab" data-bs-target="#application">
								<i class="ti ti-layout-grid-add"></i>
							</a>
							<a href="#" class="nav-link" title="Super Admin" data-bs-toggle="tab" data-bs-target="#super-admin">
								<i class="ti ti-user-star"></i>
							</a>
							<a href="#" class="nav-link" title="Layout" data-bs-toggle="tab" data-bs-target="#layout">
								<i class="ti ti-layout-board-split"></i>
							</a>
							<a href="#" class="nav-link" title="Projects" data-bs-toggle="tab" data-bs-target="#projects">
								<i class="ti ti-users-group"></i>
							</a>
							<a href="#" class="nav-link" title="Crm" data-bs-toggle="tab" data-bs-target="#crm">
								<i class="ti ti-user-shield"></i>
							</a>
							<a href="#" class="nav-link" title="Hrm" data-bs-toggle="tab" data-bs-target="#hrm">
								<i class="ti ti-user"></i>
							</a>
							<a href="#" class="nav-link" title="Finance" data-bs-toggle="tab" data-bs-target="#finance">
								<i class="ti ti-shopping-cart-dollar"></i>
							</a>
							<a href="#" class="nav-link" title="Administration" data-bs-toggle="tab" data-bs-target="#administration">
								<i class="ti ti-cash"></i>
							</a>
							<a href="#" class="nav-link" title="Content" data-bs-toggle="tab" data-bs-target="#content">
								<i class="ti ti-license"></i>
							</a>
							<a href="#" class="nav-link" title="Pages" data-bs-toggle="tab" data-bs-target="#pages">
								<i class="ti ti-page-break"></i>
							</a>
							<a href="#" class="nav-link" title="Authentication" data-bs-toggle="tab"
								data-bs-target="#authentication">
								<i class="ti ti-lock-check"></i>
							</a>
							<a href="#" class="nav-link " title="UI Elements" data-bs-toggle="tab"
								data-bs-target="#ui-elements">
								<i class="ti ti-ux-circle"></i>
							</a>
							<a href="#" class="nav-link" title="Extras" data-bs-toggle="tab" data-bs-target="#extras">
								<i class="ti ti-vector-triangle"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="sidebar-right">
					<div class="sidebar-logo mb-4">
						<a href="index.html" class="logo logo-normal">
							<img src="assets/img/logo.svg" alt="Logo">
						</a>
						<a href="index.html" class="dark-logo">
							<img src="assets/img/logo-white.svg" alt="Logo">
						</a>
					</div>
					<div class="sidebar-scroll">
						<h6 class="mb-3">Welcome to SmartHR</h6>
						<div class="text-center rounded bg-light p-3 mb-4">
							<div class="avatar avatar-lg online mb-3">
								<img src="assets/img/profiles/avatar-02.jpg" alt="Img" class="img-fluid rounded-circle">
							</div>
							<h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
							<p class="fs-10">System Admin</p>
						</div>
						<div class="tab-content" id="v-pills-tabContent">
							<div class="tab-pane fade show active" id="dashboard">
								<ul>
									<li class="menu-title"><span>MAIN MENU</span></li>
									<li><a href="index.html" class="active">Admin Dashboard</a></li>
									<li><a href="employee-dashboard.html">Employee Dashboard</a></li>
									<li><a href="deals-dashboard.html">Deals Dashboard</a></li>
									<li><a href="leads-dashboard.html">Leads Dashboard</a></li>
								</ul>
							</div>
							<div class="tab-pane fade" id="application">
								<ul>
									<li class="menu-title"><span>APPLICATION</span></li>
									<li><a href="voice-call.html">Voice Call</a></li>
									<li><a href="video-call.html">Video Call</a></li>
									<li><a href="outgoing-call.html">Outgoing Call</a></li>
									<li><a href="incoming-call.html">Incoming Call</a></li>
									<li><a href="call-history.html">Call History</a></li>
									<li><a href="calendar.html">Calendar</a></li>
									<li><a href="email.html">Email</a></li>
									<li><a href="todo.html">To Do</a></li>
									<li><a href="notes.html">Notes</a></li>
									<li><a href="file-manager.html">File Manager</a></li>
									<li><a href="kanban-view.html">Kanban</a></li>
									<li><a href="invoices.html">Invoices</a></li>
								</ul>
							</div>
							<div class="tab-pane fade" id="super-admin">
								<ul>
									<li class="menu-title"><span>SUPER ADMIN</span></li>
									<li><a href="dashboard.html">Dashboard</a></li>
									<li><a href="companies.html">Companies</a></li>
									<li><a href="subscription.html">Subscriptions</a></li>
									<li><a href="packages.html">Packages</a></li>
									<li><a href="domain.html">Domain</a></li>
									<li><a href="purchase-transaction.html">Purchase Transaction</a></li>
								</ul>
							</div>
							<div class="tab-pane fade" id="layout">
								<ul>
									<li class="menu-title"><span>LAYOUT</span></li>
									<li><a href="layout-horizontal.html"><span>Horizontal</span></a></li>
									<li><a href="layout-detached.html"><span>Detached</span></a></li>
									<li><a href="layout-modern.html"><span>Modern</span></a></li>
									<li><a href="layout-two-column.html"><span>Two Column </span></a></li>
									<li><a href="layout-hovered.html"><span>Hovered</span></a></li>
									<li><a href="layout-box.html"><span>Boxed</span></a></li>
									<li><a href="layout-horizontal-single.html"><span>Horizontal Single</span></a></li>
									<li><a href="layout-horizontal-overlay.html"><span>Horizontal Overlay</span></a></li>
									<li><a href="layout-horizontal-box.html"><span>Horizontal Box</span></a></li>
									<li><a href="layout-horizontal-sidemenu.html"><span>Menu Aside</span></a></li>
									<li><a href="layout-vertical-transparent.html"><span>Transparent</span></a></li>
									<li><a href="layout-without-header.html"><span>Without Header</span></a></li>
									<li><a href="layout-rtl.html"><span>RTL</span></a></li>
									<li><a href="layout-dark.html"><span>Dark</span></a></li>
								</ul>
							</div>
							<div class="tab-pane fade" id="projects">
								<ul>
									<li class="menu-title"><span>PROJECTS</span></li>
									<li><a href="clients-grid.html">Clients</a></li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Projects</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="projects-grid.html">Projects</a></li>
											<li><a href="tasks.html">Tasks</a></li>
											<li><a href="task-board.html">Task Board</a></li>
										</ul>
									</li>	
								</ul>
							</div>
							<div class="tab-pane fade" id="crm">
								<ul>
									<li class="menu-title"><span>CRM</span></li>
									<li><a href="contacts-grid.html"><span>Contacts</span></a></li>
									<li><a href="companies-grid.html"><span>Companies</span></a></li>
									<li><a href="deals-grid.html"><span>Deals</span></a></li>
									<li><a href="leads-grid.html"><span>Leads</span></a></li>
									<li><a href="pipeline.html"><span>Pipeline</span></a></li>
									<li><a href="analytics.html"><span>Analytics</span></a></li>
									<li><a href="activity.html"><span>Activities</span></a></li>
								</ul>
							</div>
							<div class="tab-pane fade" id="hrm">
								<ul>
									<li class="menu-title"><span>HRM</span></li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Employees</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="employees.html">Employee Lists</a></li>
											<li><a href="employees-grid.html">Employee Grid</a></li>
											<li><a href="employee-details.html">Employee Details</a></li>
											<li><a href="departments.html">Departments</a></li>
											<li><a href="designations.html">Designations</a></li>
											<li><a href="policy.html">Policies</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Tickets</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="tickets.html">Tickets</a></li>
											<li><a href="ticket-details.html">Ticket Details</a></li>
										</ul>
									</li>
									<li><a href="holidays.html"><span>Holidays</span></a></li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Attendance</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Leaves<span
														class="menu-arrow inside-submenu"></span></a>
												<ul>
													<li><a href="leaves.html">Leaves (Admin)</a></li>
													<li><a href="leaves-employee.html">Leave (Employee)</a></li>
													<li><a href="leave-settings.html">Leave Settings</a></li>												
												</ul>												
											</li>
											<li><a href="attendance-admin.html">Attendance (Admin)</a></li>
											<li><a href="attendance-employee.html">Attendance (Employee)</a></li>
											<li><a href="timesheets.html">Timesheets</a></li>
											<li><a href="schedule-timing.html">Shift & Schedule</a></li>
											<li><a href="overtime.html">Overtime</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Performance</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="performance-indicator.html">Performance Indicator</a></li>
											<li><a href="performance-review.html">Performance Review</a></li>
											<li><a href="performance-appraisal.html">Performance Appraisal</a></li>
											<li><a href="goal-tracking.html">Goal List</a></li>
											<li><a href="goal-type.html">Goal Type</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Training</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="training.html">Training List</a></li>
											<li><a href="trainers.html">Trainers</a></li>
											<li><a href="training-type.html">Training Type</a></li>
										</ul>
									</li>
									<li><a href="promotion.html"><span>Promotion</span></a></li>
									<li><a href="resignation.html"><span>Resignation</span></a></li>
									<li><a href="termination.html"><span>Termination</span></a></li>
								</ul>
							</div>
							<div class="tab-pane fade" id="finance">
								<ul>
									<li class="menu-title"><span>FINANCE & ACCOUNTS</span></li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Sales</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="estimates.html">Estimates</a></li>
											<li><a href="invoices.html">Invoices</a></li>
											<li><a href="payments.html">Payments</a></li>
											<li><a href="expenses.html">Expenses</a></li>
											<li><a href="provident-fund.html">Provident Fund</a></li>
											<li><a href="taxes.html">Taxes</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Accounting</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="categories.html">Categories</a></li>
											<li><a href="budgets.html">Budgets</a></li>
											<li><a href="budget-expenses.html">Budget Expenses</a></li>
											<li><a href="budget-revenues.html">Budget Revenues</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Payroll</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="employee-salary.html">Employee Salary</a></li>
											<li><a href="payslip.html">Payslip</a></li>
											<li><a href="payroll.html">Payroll Items</a></li>
										</ul>
									</li>									
								</ul>
							</div>
							<div class="tab-pane fade" id="administration">
								<ul>
									<li class="menu-title"><span>ADMINISTRATION</span></li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Assets</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="assets.html">Assets</a></li>
											<li><a href="asset-categories.html">Asset Categories</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Help & Supports</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="knowledgebase.html">Knowledge Base</a></li>
											<li><a href="activity.html">Activities</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>User Management</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="users.html">Users</a></li>
											<li><a href="roles-permissions.html">Roles & Permissions</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Reports</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="expenses-report.html">Expense Report</a></li>
											<li><a href="invoice-report.html">Invoice Report</a></li>
											<li><a href="payment-report.html">Payment Report</a></li>
											<li><a href="project-report.html">Project Report</a></li>
											<li><a href="task-report.html">Task Report</a></li>
											<li><a href="user-report.html">User Report</a></li>
											<li><a href="employee-report.html">Employee Report</a></li>
											<li><a href="payslip-report.html">Payslip Report</a></li>
											<li><a href="attendance-report.html">Attendance Report</a></li>
											<li><a href="leave-report.html">Leave Report</a></li>
											<li><a href="daily-report.html">Daily Report</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											General Settings
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="profile-settings.html">Profile</a></li>
											<li><a href="security-settings.html">Security</a></li>
											<li><a href="notification-settings.html">Notifications</a></li>
											<li><a href="connected-apps.html">Connected Apps</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											Website Settings
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="bussiness-settings.html">Business Settings</a></li>
											<li><a href="seo-settings.html">SEO Settings</a></li>
											<li><a href="localization-settings.html">Localization</a></li>
											<li><a href="prefixes.html">Prefixes</a></li>
											<li><a href="preferences.html">Preferences</a></li>
											<li><a href="performance-appraisal.html">Appearance</a></li>
											<li><a href="language.html">Language</a></li>
											<li><a href="authentication-settings.html">Authentication</a></li>
											<li><a href="ai-settings.html">AI Settings</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">App Settings<span class="menu-arrow"></span></a>
										<ul>
											<li><a href="salary-settings.html">Salary Settings</a></li>
											<li><a href="approval-settings.html">Approval Settings</a></li>
											<li><a href="invoice-settings.html">Invoice Settings</a></li>
											<li><a href="leave-type.html">Leave Type</a></li>
											<li><a href="custom-fields.html">Custom Fields</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											System Settings
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="email-settings.html">Email Settings</a></li>
											<li><a href="email-template.html">Email Templates</a></li>
											<li><a href="sms-settings.html">SMS Settings</a></li>
											<li><a href="sms-template.html">SMS Templates</a></li>
											<li><a href="otp-settings.html">OTP</a></li>
											<li><a href="gdpr.html">GDPR Cookies</a></li>
											<li><a href="maintenance-mode.html">Maintenance Mode</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											Financial Settings
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="payment-gateways.html">Payment Gateways</a></li>
											<li><a href="tax-rates.html">Tax Rate</a></li>
											<li><a href="currencies.html">Currencies</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">Other Settings<span class="menu-arrow"></span></a>
										<ul>
											<li><a href="custom-css.html">Custom CSS</a></li>
											<li><a href="custom-js.html">Custom JS</a></li>
											<li><a href="cronjob.html">Cronjob</a></li>
											<li><a href="storage-settings.html">Storage</a></li>
											<li><a href="ban-ip-address.html">Ban IP Address</a></li>
											<li><a href="backup.html">Backup</a></li>
											<li><a href="clear-cache.html">Clear Cache</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="tab-pane fade" id="content">
								<ul>
									<li class="menu-title"><span>CONTENT</span></li>
									<li><a href="pages.html">Pages</a></li>
									<li class="submenu">
										<a href="javascript:void(0);">
											Blogs
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="blogs.html">All Blogs</a></li>
											<li><a href="blog-categories.html">Categories</a></li>
											<li><a href="blog-comments.html">Comments</a></li>
											<li><a href="blog-tags.html">Blog Tags</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											Locations
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="countries.html">Countries</a></li>
											<li><a href="states.html">States</a></li>
											<li><a href="cities.html">Cities</a></li>
										</ul>
									</li>
									<li><a href="testimonials.html">Testimonials</a></li>
									<li><a href="faq.html">FAQ’S</a></li>
								</ul>
							</div>
							<div class="tab-pane fade" id="pages">
								<ul>
									<li class="menu-title"><span>PAGES</span></li>
									<li><a href="starter.html"><span>Starter</span></a></li>
									<li><a href="profile.html"><span>Profile</span></a></li>
									<li><a href="gallery.html"><span>Gallery</span></a></li>
									<li><a href="search-result.html"><span>Search Results</span></a></li>
									<li><a href="timeline.html"><span>Timeline</span></a></li>
									<li><a href="pricing.html"><span>Pricing</span></a></li>
									<li><a href="coming-soon.html"><span>Coming Soon</span></a></li>
									<li><a href="under-maintenance.html"><span>Under Maintenance</span></a></li>
									<li><a href="under-construction.html"><span>Under Construction</span></a></li>
									<li><a href="api-keys.html"><span>API Keys</span></a></li>
									<li><a href="privacy-policy.html"><span>Privacy Policy</span></a></li>
									<li><a href="terms-condition.html"><span>Terms & Conditions</span></a></li>
								</ul>
							</div>
							<div class="tab-pane fade" id="authentication">
								<ul>
									<li class="menu-title"><span>AUTHENTICATION</span></li>
									<li class="submenu">
										<a href="javascript:void(0);">
											Login<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="login.html">Cover</a></li>
											<li><a href="login-2.html">Illustration</a></li>
											<li><a href="login-3.html">Basic</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											Register<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="register.html">Cover</a></li>
											<li><a href="register-2.html">Illustration</a></li>
											<li><a href="register-3.html">Basic</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											Forgot Password<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="forgot-password.html">Cover</a></li>
											<li><a href="forgot-password-2.html">Illustration</a></li>
											<li><a href="forgot-password-3.html">Basic</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											Reset Password<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="reset-password.html">Cover</a></li>
											<li><a href="reset-password-2.html">Illustration</a></li>
											<li><a href="reset-password-3.html">Basic</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											Email Verification<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="email-verification.html">Cover</a></li>
											<li><a href="email-verification-2.html">Illustration</a></li>
											<li><a href="email-verification-3.html">Basic</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											2 Step Verification<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="two-step-verification.html">Cover</a></li>
											<li><a href="two-step-verification-2.html">Illustration</a></li>
											<li><a href="two-step-verification-3.html">Basic</a></li>
										</ul>
									</li>
									<li><a href="lock-screen.html">Lock Screen</a></li>
									<li><a href="error-404.html">404 Error</a></li>
									<li><a href="error-500.html">500 Error</a></li>
								</ul>
							</div>
							<div class="tab-pane fade" id="ui-elements">
								<ul>
									<li class="menu-title"><span>UI INTERFACE</span></li>
									<li class="submenu">
										<a href="javascript:void(0);">Base UI<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="ui-alerts.html">Alerts</a></li>
											<li><a href="ui-accordion.html">Accordion</a></li>
											<li><a href="ui-avatar.html">Avatar</a></li>
											<li><a href="ui-badges.html">Badges</a></li>
											<li><a href="ui-borders.html">Border</a></li>
											<li><a href="ui-buttons.html">Buttons</a></li>
											<li><a href="ui-buttons-group.html">Button Group</a></li>
											<li><a href="ui-breadcrumb.html">Breadcrumb</a></li>
											<li><a href="ui-cards.html">Card</a></li>
											<li><a href="ui-carousel.html">Carousel</a></li>
											<li><a href="ui-colors.html">Colors</a></li>
											<li><a href="ui-dropdowns.html">Dropdowns</a></li>
											<li><a href="ui-grid.html">Grid</a></li>
											<li><a href="ui-images.html">Images</a></li>
											<li><a href="ui-lightbox.html">Lightbox</a></li>
											<li><a href="ui-media.html">Media</a></li>
											<li><a href="ui-modals.html">Modals</a></li>
											<li><a href="ui-offcanvas.html">Offcanvas</a></li>
											<li><a href="ui-pagination.html">Pagination</a></li>
											<li><a href="ui-popovers.html">Popovers</a></li>
											<li><a href="ui-progress.html">Progress</a></li>
											<li><a href="ui-placeholders.html">Placeholders</a></li>
											<li><a href="ui-spinner.html">Spinner</a></li>
											<li><a href="ui-sweetalerts.html">Sweet Alerts</a></li>
											<li><a href="ui-nav-tabs.html">Tabs</a></li>
											<li><a href="ui-toasts.html">Toasts</a></li>
											<li><a href="ui-tooltips.html">Tooltips</a></li>
											<li><a href="ui-typography.html">Typography</a></li>
											<li><a href="ui-video.html">Video</a></li>
											<li><a href="ui-sortable.html">Sortable</a></li>
											<li><a href="ui-swiperjs.html">Swiperjs</a></li>						
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"> Advanced UI <span class="menu-arrow"></span> </a>
										<ul>
											<li><a href="ui-ribbon.html">Ribbon</a></li>
											<li><a href="ui-clipboard.html">Clipboard</a></li>
											<li><a href="ui-drag-drop.html">Drag & Drop</a></li>
											<li><a href="ui-rangeslider.html">Range Slider</a></li>
											<li><a href="ui-rating.html">Rating</a></li>
											<li><a href="ui-text-editor.html">Text Editor</a></li>
											<li><a href="ui-counter.html">Counter</a></li>
											<li><a href="ui-scrollbar.html">Scrollbar</a></li>
											<li><a href="ui-stickynote.html">Sticky Note</a></li>
											<li><a href="ui-timeline.html">Timeline</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"> Forms <span class="menu-arrow"></span>
										</a>
										<ul>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Form Elements<span class="menu-arrow inside-submenu"></span></a>
												<ul>
													<li><a href="form-basic-inputs.html">Basic Inputs</a></li>
													<li><a href="form-checkbox-radios.html">Checkbox & Radios</a></li>
													<li><a href="form-input-groups.html">Input Groups</a></li>
													<li><a href="form-grid-gutters.html">Grid & Gutters</a></li>
													<li><a href="form-select.html">Form Select</a></li>
													<li><a href="form-mask.html">Input Masks</a></li>
													<li><a href="form-fileupload.html">File Uploads</a></li>
												</ul>
											</li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Layouts<span class="menu-arrow inside-submenu"></span></a>
												<ul>
													<li><a href="form-horizontal.html">Horizontal Form</a></li>
													<li><a href="form-vertical.html">Vertical Form</a></li>
													<li><a href="form-floating-labels.html">Floating Labels</a></li>
												</ul>
											</li>
											<li><a href="form-validation.html">Form Validation</a></li>
											<li><a href="form-select2.html">Select2</a></li>
											<li><a href="form-wizard.html">Form Wizard</a></li>
											<li><a href="form-pickers.html">Form Picker</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">Tables <span class="menu-arrow"></span></a>
										<ul>
											<li><a href="tables-basic.html">Basic Tables </a></li>
											<li><a href="data-tables.html">Data Table </a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">Charts<span class="menu-arrow"></span> </a>
										<ul>
											<li><a href="chart-apex.html">Apex Charts</a></li>
											<li><a href="chart-c3.html">Chart C3</a></li>
											<li><a href="chart-js.html">Chart Js</a></li>
											<li><a href="chart-morris.html">Morris Charts</a></li>
											<li><a href="chart-flot.html">Flot Charts</a></li>
											<li><a href="chart-peity.html">Peity Charts</a></li>
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">Icons<span class="menu-arrow"></span> </a>
										<ul>
											<li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
											<li><a href="icon-tabler.html">Tabler Icons</a></li>
											<li><a href="icon-bootstrap.html">Bootstrap Icons</a></li>
											<li><a href="icon-remix.html">Remix Icons</a></li>
											<li><a href="icon-feather.html">Feather Icons</a></li>
											<li><a href="icon-ionic.html">Ionic Icons</a></li>
											<li><a href="icon-material.html">Material Icons</a></li>
											<li><a href="icon-pe7.html">Pe7 Icons</a></li>
											<li><a href="icon-simpleline.html">Simpleline Icons</a></li>
											<li><a href="icon-themify.html">Themify Icons</a></li>
											<li><a href="icon-weather.html">Weather Icons</a></li>
											<li><a href="icon-typicon.html">Typicon Icons</a></li>
											<li><a href="icon-flag.html">Flag Icons</a></li>
											
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											<i class="ti ti-table-plus"></i>
											<span>Maps</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li>
												<a href="maps-vector.html">Vector</a>
											</li>
											<li>
												<a href="maps-leaflet.html">Leaflet</a>
											</li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="tab-pane fade" id="extras">
								<ul>
									<li class="menu-title"><span>EXTRAS</span></li>
									<li><a href="#">Documentation</a></li>
									<li><a href="#">Change Log</a></li>
									<li class="submenu">
										<a href="javascript:void(0);"><span>Multi Level</span><span class="menu-arrow"></span></a>
										<ul>
											<li><a href="javascript:void(0);">Multilevel 1</a></li>
											<li class="submenu submenu-two">
												<a href="javascript:void(0);">Multilevel 2<span class="menu-arrow inside-submenu"></span></a>
												<ul>
													<li><a href="javascript:void(0);">Multilevel 2.1</a></li>
													<li class="submenu submenu-two submenu-three">
														<a href="javascript:void(0);">Multilevel 2.2<span class="menu-arrow inside-submenu inside-submenu-two"></span></a>
														<ul>
															<li><a href="javascript:void(0);">Multilevel 2.2.1</a></li>
															<li><a href="javascript:void(0);">Multilevel 2.2.2</a></li>
														</ul>
													</li>
												</ul>
											</li>
											<li><a href="javascript:void(0);">Multilevel 3</a></li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Two Col Sidebar -->

		<!-- Stacked Sidebar -->
		<div class="stacked-sidebar" id="stacked-sidebar">
			<div class="sidebar sidebar-stacked" style="display: flex !important;">
				<div class="stacked-mini">
					<a href="index.html" class="logo-small">
						<img src="assets/img/logo-small.svg" alt="Logo">
					</a>
					<div class="sidebar-left slimscroll">
						<div class="d-flex align-items-center flex-column">
							<div class="mb-1 notification-item">
								<a href="#" class="btn btn-menubar position-relative">
									<i class="ti ti-bell"></i>
									<span class="notification-status-dot"></span>
								</a>
							</div>
							<div class="mb-1">
								<a href="#" class="btn btn-menubar btnFullscreen">
									<i class="ti ti-maximize"></i>
								</a>
							</div>
							<div class="mb-1">
								<a href="calendar.html" class="btn btn-menubar">
									<i class="ti ti-layout-grid-remove"></i>
								</a>
							</div>
							<div class="mb-1">
								<a href="chat.html" class="btn btn-menubar position-relative">
									<i class="ti ti-brand-hipchat"></i>
									<span class="badge bg-info rounded-pill d-flex align-items-center justify-content-center header-badge">5</span>
								</a>
							</div>
							<div class="mb-1">
								<a href="email.html" class="btn btn-menubar">
									<i class="ti ti-mail"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="sidebar-right d-flex justify-content-between flex-column">
					<div class="sidebar-scroll">
						<h6 class="mb-3">Welcome to SmartHR</h6>
						<div class="sidebar-profile text-center rounded bg-light p-3 mb-4">
							<div class="avatar avatar-lg online mb-3">
								<img src="assets/img/profiles/avatar-02.jpg" alt="Img" class="img-fluid rounded-circle">
							</div>
							<h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
							<p class="fs-10">System Admin</p>
						</div>
						<div class="stack-menu">
							<div class="nav flex-column align-items-center nav-pills" role="tablist" aria-orientation="vertical">
								<div class="row g-2">
									<div class="col-6">
										<a href="#menu-dashboard" role="tab" class="nav-link active" title="Dashboard" data-bs-toggle="tab" data-bs-target="#menu-dashboard" aria-selected="true">
											<span><i class="ti ti-smart-home"></i></span>
											<p>Dashboard</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-application" role="tab" class="nav-link" title="Apps" data-bs-toggle="tab" data-bs-target="#menu-application" aria-selected="false">
											<span><i class="ti ti-layout-grid-add"></i></span>
											<p>Applications</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-superadmin" role="tab" class="nav-link" title="Apps" data-bs-toggle="tab" data-bs-target="#menu-superadmin" aria-selected="false">
											<span><i class="ti ti-user-star"></i></span>
											<p>Super Admin</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-layout" role="tab" class="nav-link" title="Layout" data-bs-toggle="tab" data-bs-target="#menu-layout" aria-selected="false">
											<span><i class="ti ti-layout-board-split"></i></span>
											<p>Layouts</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-project" role="tab" class="nav-link" title="Projects" data-bs-toggle="tab" data-bs-target="#menu-project" aria-selected="false">
											<span><i class="ti ti-folder"></i></span>
											<p>Projects</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-crm" role="tab" class="nav-link" title="CRM" data-bs-toggle="tab" data-bs-target="#menu-crm" aria-selected="false">
											<span><i class="ti ti-user-shield"></i></span>
											<p>Crm</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-hrm" role="tab" class="nav-link" title="HRM" data-bs-toggle="tab" data-bs-target="#menu-hrm" aria-selected="false">
											<span><i class="ti ti-users"></i></span>
											<p>Hrm</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-finance" role="tab" class="nav-link" title="Finance & Accounts" data-bs-toggle="tab" data-bs-target="#menu-finance" aria-selected="false">
											<span><i class="ti ti-shopping-cart-dollar"></i></span>
											<p>Finance & Accounts</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-administration" role="tab" class="nav-link" title="Administration" data-bs-toggle="tab" data-bs-target="#menu-administration" aria-selected="false">
											<span><i class="ti ti-cash"></i></span>
											<p>Administration</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-content" role="tab" class="nav-link" title="Content" data-bs-toggle="tab" data-bs-target="#menu-content" aria-selected="false">
											<span><i class="ti ti-license"></i></span>
											<p>Contents</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-pages" role="tab" class="nav-link" title="Pages"
											data-bs-toggle="tab" data-bs-target="#menu-pages" aria-selected="false">
											<span><i class="ti ti-page-break"></i></span>
											<p>Pages</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-authentication" role="tab" class="nav-link" title="Authentication" data-bs-toggle="tab" data-bs-target="#menu-authentication" aria-selected="false">
											<span><i class="ti ti-lock-check"></i></span>
											<p>Authentication</p>
										</a>
									</div>
									<div class="col-6">
										<a href="#menu-ui-elements" role="tab" class="nav-link" title="UI Elements" data-bs-toggle="tab" data-bs-target="#menu-ui-elements" aria-selected="false">
											<span><i class="ti ti-ux-circle"></i></span>
											<p>Basic UI</p>
										</a>
									</div>
								</div>
							</div>
							<div class="tab-content">
								<div class="tab-pane fade show active" id="menu-dashboard">
									<ul class="stack-submenu">
										<li><a href="index.html" class="active">Admin Dashboard</a></li>
										<li><a href="employee-dashboard.html">Employee Dashboard</a></li>
										<li><a href="deals-dashboard.html">Deals Dashboard</a></li>
										<li><a href="leads-dashboard.html">Leads Dashboard</a></li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-superadmin">
									<ul class="stack-submenu">
										<li><a href="dashboard.html">Dashboard</a></li>
										<li><a href="companies.html">Companies</a></li>
										<li><a href="subscription.html">Subscriptions</a></li>
										<li><a href="packages.html">Packages</a></li>
										<li><a href="domain.html">Domain</a></li>
										<li><a href="purchase-transaction.html">Purchase Transaction</a></li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-application">
									<ul class="stack-submenu">
										<li><a href="chat.html">Chat</a></li>
										<li class="submenu submenu-two">
											<a href="call.html">Calls<span
													class="menu-arrow inside-submenu"></span></a>
											<ul>
												<li><a href="voice-call.html">Voice Call</a></li>
												<li><a href="video-call.html">Video Call</a></li>
												<li><a href="outgoing-call.html">Outgoing Call</a></li>
												<li><a href="incoming-call.html">Incoming Call</a></li>
												<li><a href="call-history.html">Call History</a></li>
											</ul>
										</li>
										<li><a href="calendar.html">Calendar</a></li>
										<li><a href="email.html">Email</a></li>
										<li><a href="todo.html">To Do</a></li>
										<li><a href="notes.html">Notes</a></li>
										<li><a href="social-feed.html">Social Feed</a></li>
										<li><a href="file-manager.html">File Manager</a></li>
										<li><a href="kanban-view.html">Kanban</a></li>
										<li><a href="invoices.html">Invoices</a></li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-layout">
									<ul class="stack-submenu">
										<li><a href="layout-horizontal.html">Horizontal</a></li>
										<li><a href="layout-detached.html">Detached</a></li>
										<li><a href="layout-modern.html">Modern</a></li>
										<li><a href="layout-two-column.html">Two Column</a></li>
										<li><a href="layout-hovered.html">Hovered</a></li>
										<li><a href="layout-box.html">Boxed</a></li>
										<li><a href="layout-horizontal-single.html">Horizontal Single</a></li>
										<li><a href="layout-horizontal-overlay.html">Horizontal Overlay</a></li>
										<li><a href="layout-horizontal-box.html">Horizontal Box</a></li>
										<li><a href="layout-horizontal-sidemenu.html">Menu Aside</a></li>
										<li><a href="layout-vertical-transparent.html">Transparent</a></li>
										<li><a href="layout-without-header.html">Without Header</a></li>
										<li><a href="layout-rtl.html">RTL</a></li>
										<li><a href="layout-dark.html">Dark</a></li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-project">
									<ul class="stack-submenu">
										<li><a href="clients-grid.html"><span>Clients</span></a></li>
										<li class="submenu">
											<a href="javascript:void(0);"><span>Projects</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="projects-grid.html">Projects</a></li>
												<li><a href="tasks.html">Tasks</a></li>
												<li><a href="task-board.html">Task Board</a></li>
											</ul>
										</li>	
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-crm">
									<ul class="stack-submenu">
										<li><a href="contacts-grid.html"><span>Contacts</span></a></li>
										<li><a href="companies-grid.html"><span>Companies</span></a></li>
										<li><a href="deals-grid.html"><span>Deals</span></a></li>
										<li><a href="leads-grid.html"><span>Leads</span></a></li>
										<li><a href="pipeline.html"><span>Pipeline</span></a></li>
										<li><a href="analytics.html"><span>Analytics</span></a></li>
										<li><a href="activity.html"><span>Activities</span></a></li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-hrm">
									<ul class="stack-submenu">
										<li class="submenu">
											<a href="javascript:void(0);"><span>Employees</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="employees.html">Employee Lists</a></li>
												<li><a href="employees-grid.html">Employee Grid</a></li>
												<li><a href="employee-details.html">Employee Details</a></li>
												<li><a href="departments.html">Departments</a></li>
												<li><a href="designations.html">Designations</a></li>
												<li><a href="policy.html">Policies</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);"><span>Tickets</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="tickets.html">Tickets</a></li>
												<li><a href="ticket-details.html">Ticket Details</a></li>
											</ul>
										</li>
										<li><a href="holidays.html"><span>Holidays</span></a></li>
										<li class="submenu">
											<a href="javascript:void(0);"><span>Attendance</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li class="submenu submenu-two">
													<a href="javascript:void(0);">Leaves<span class="menu-arrow inside-submenu"></span></a>
													<ul>
														<li><a href="leaves.html">Leaves (Admin)</a></li>
														<li><a href="leaves-employee.html">Leave (Employee)</a></li>
														<li><a href="leave-settings.html">Leave Settings</a></li>												
													</ul>												
												</li>
												<li><a href="attendance-admin.html">Attendance (Admin)</a></li>
												<li><a href="attendance-employee.html">Attendance (Employee)</a></li>
												<li><a href="timesheets.html">Timesheets</a></li>
												<li><a href="schedule-timing.html">Shift & Schedule</a></li>
												<li><a href="overtime.html">Overtime</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);"><span>Performance</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="performance-indicator.html">Performance Indicator</a></li>
												<li><a href="performance-review.html">Performance Review</a></li>
												<li><a href="performance-appraisal.html">Performance Appraisal</a></li>
												<li><a href="goal-tracking.html">Goal List</a></li>
												<li><a href="goal-type.html">Goal Type</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);"><span>Training</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="training.html">Training List</a></li>
												<li><a href="trainers.html">Trainers</a></li>
												<li><a href="training-type.html">Training Type</a></li>
											</ul>
										</li>
										<li><a href="promotion.html"><span>Promotion</span></a></li>
										<li><a href="resignation.html"><span>Resignation</span></a></li>
										<li><a href="termination.html"><span>Termination</span></a></li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-finance">
									<ul class="stack-submenu">
										<li class="submenu">
											<a href="javascript:void(0);"><span>Sales</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="estimates.html">Estimates</a></li>
												<li><a href="invoices.html">Invoices</a></li>
												<li><a href="payments.html">Payments</a></li>
												<li><a href="expenses.html">Expenses</a></li>
												<li><a href="provident-fund.html">Provident Fund</a></li>
												<li><a href="taxes.html">Taxes</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);"><span>Accounting</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="categories.html">Categories</a></li>
												<li><a href="budgets.html">Budgets</a></li>
												<li><a href="budget-expenses.html">Budget Expenses</a></li>
												<li><a href="budget-revenues.html">Budget Revenues</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);"><span>Payroll</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="employee-salary.html">Employee Salary</a></li>
												<li><a href="payslip.html">Payslip</a></li>
												<li><a href="payroll.html">Payroll Items</a></li>
											</ul>
										</li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-administration">
									<ul class="stack-submenu">
										<li class="submenu">
											<a href="javascript:void(0);"><span>Assets</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="assets.html">Assets</a></li>
												<li><a href="asset-categories.html">Asset Categories</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);"><span>Help & Supports</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="knowledgebase.html">Knowledge Base</a></li>
												<li><a href="activity.html">Activities</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);"><span>User Management</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="users.html">Users</a></li>
												<li><a href="roles-permissions.html">Roles & Permissions</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);"><span>Reports</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="expenses-report.html">Expense Report</a></li>
												<li><a href="invoice-report.html">Invoice Report</a></li>
												<li><a href="payment-report.html">Payment Report</a></li>
												<li><a href="project-report.html">Project Report</a></li>
												<li><a href="task-report.html">Task Report</a></li>
												<li><a href="user-report.html">User Report</a></li>
												<li><a href="employee-report.html">Employee Report</a></li>
												<li><a href="payslip-report.html">Payslip Report</a></li>
												<li><a href="attendance-report.html">Attendance Report</a></li>
												<li><a href="leave-report.html">Leave Report</a></li>
												<li><a href="daily-report.html">Daily Report</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">
												General Settings
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="profile-settings.html">Profile</a></li>
												<li><a href="security-settings.html">Security</a></li>
												<li><a href="notification-settings.html">Notifications</a></li>
												<li><a href="connected-apps.html">Connected Apps</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">
												Website Settings
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="bussiness-settings.html">Business Settings</a></li>
												<li><a href="seo-settings.html">SEO Settings</a></li>
												<li><a href="localization-settings.html">Localization</a></li>
												<li><a href="prefixes.html">Prefixes</a></li>
												<li><a href="preferences.html">Preferences</a></li>
												<li><a href="performance-appraisal.html">Appearance</a></li>
												<li><a href="language.html">Language</a></li>
												<li><a href="authentication-settings.html">Authentication</a></li>
												<li><a href="ai-settings.html">AI Settings</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">App Settings<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="salary-settings.html">Salary Settings</a></li>
												<li><a href="approval-settings.html">Approval Settings</a></li>
												<li><a href="invoice-settings.html">Invoice Settings</a></li>
												<li><a href="leave-type.html">Leave Type</a></li>
												<li><a href="custom-fields.html">Custom Fields</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">
												System Settings
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="email-settings.html">Email Settings</a></li>
												<li><a href="email-template.html">Email Templates</a></li>
												<li><a href="sms-settings.html">SMS Settings</a></li>
												<li><a href="sms-template.html">SMS Templates</a></li>
												<li><a href="otp-settings.html">OTP</a></li>
												<li><a href="gdpr.html">GDPR Cookies</a></li>
												<li><a href="maintenance-mode.html">Maintenance Mode</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">
												Financial Settings
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li><a href="payment-gateways.html">Payment Gateways</a></li>
												<li><a href="tax-rates.html">Tax Rate</a></li>
												<li><a href="currencies.html">Currencies</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">Other Settings<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="custom-css.html">Custom CSS</a></li>
												<li><a href="custom-js.html">Custom JS</a></li>
												<li><a href="cronjob.html">Cronjob</a></li>
												<li><a href="storage-settings.html">Storage</a></li>
												<li><a href="ban-ip-address.html">Ban IP Address</a></li>
												<li><a href="backup.html">Backup</a></li>
												<li><a href="clear-cache.html">Clear Cache</a></li>
											</ul>
										</li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-content">
									<ul class="stack-submenu">
										<li class="submenu">
											<a href="javascript:void(0);">Blogs<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="blogs.html">All Blogs</a></li>
												<li><a href="blog-categories.html">Categories</a></li>
												<li><a href="blog-comments.html">Comments</a></li>
												<li><a href="blog-tags.html">Tags</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">Locations<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="countries.html">Countries</a></li>
												<li><a href="states.html">States</a></li>
												<li><a href="cities.html">Cities</a></li>
											</ul>
										</li>
										<li><a href="testimonials.html">Testimonials</a></li>
										<li><a href="faq.html">FAQ’S</a></li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-pages">
									<ul class="stack-submenu">
										<li><a href="starter.html">Starter</a></li>
										<li><a href="profile.html">Profile</a></li>
										<li><a href="profile-settings.html">Profile Settings</a></li>
										<li><a href="gallery.html">Gallery</a></li>
										<li><a href="search-result.html">Search Results</a></li>
										<li><a href="timeline.html">Timeline</a></li>
										<li><a href="pricing.html">Pricing</a></li>
										<li><a href="coming-soon.html">Coming Soon</a></li>
										<li><a href="under-maintenance.html">Under Maintenance</a></li>
										<li><a href="under-construction.html">Under Construction</a></li>
										<li><a href="api-keys.html">API Keys</a></li>
										<li><a href="privacy-policy.html">Privacy Policy</a></li>
										<li><a href="terms-condition.html">Terms & Conditions</a></li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-authentication">
									<ul class="stack-submenu">
										<li class="submenu">
											<a href="javascript:void(0);" class="">Login<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="login.html">Cover</a></li>
												<li><a href="login-2.html">Illustration</a></li>
												<li><a href="login-3.html">Basic</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);" class="">Register<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="register.html">Cover</a></li>
												<li><a href="register-2.html">Illustration</a></li>
												<li><a href="register-3.html">Basic</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">Reset Password<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="reset-password.html">Cover</a></li>
												<li><a href="reset-password-2.html">Illustration</a></li>
												<li><a href="reset-password-3.html">Basic</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">Email Verification<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="email-verification.html">Cover</a></li>
												<li><a href="email-verification-2.html">Illustration</a></li>
												<li><a href="email-verification-3.html">Basic</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">2 Step Verification<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="two-step-verification.html">Cover</a></li>
												<li><a href="two-step-verification-2.html">Illustration</a></li>
												<li><a href="two-step-verification-3.html">Basic</a></li>
											</ul>
										</li>
										<li><a href="lock-screen.html">Lock Screen</a></li>
										<li><a href="error-404.html">404 Error</a></li>
										<li><a href="error-500.html">500 Error</a></li>
									</ul>
								</div>
								<div class="tab-pane fade" id="menu-ui-elements">
									<ul class="stack-submenu">
										<li class="submenu">
											<a href="javascript:void(0);">Base UI<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="ui-alerts.html">Alerts</a></li>
												<li><a href="ui-accordion.html">Accordion</a></li>
												<li><a href="ui-avatar.html">Avatar</a></li>
												<li><a href="ui-badges.html">Badges</a></li>
												<li><a href="ui-borders.html">Border</a></li>
												<li><a href="ui-buttons.html">Buttons</a></li>
												<li><a href="ui-buttons-group.html">Button Group</a></li>
												<li><a href="ui-breadcrumb.html">Breadcrumb</a></li>
												<li><a href="ui-cards.html">Card</a></li>
												<li><a href="ui-carousel.html">Carousel</a></li>
												<li><a href="ui-colors.html">Colors</a></li>
												<li><a href="ui-dropdowns.html">Dropdowns</a></li>
												<li><a href="ui-grid.html">Grid</a></li>
												<li><a href="ui-images.html">Images</a></li>
												<li><a href="ui-lightbox.html">Lightbox</a></li>
												<li><a href="ui-media.html">Media</a></li>
												<li><a href="ui-modals.html">Modals</a></li>
												<li><a href="ui-offcanvas.html">Offcanvas</a></li>
												<li><a href="ui-pagination.html">Pagination</a></li>
												<li><a href="ui-popovers.html">Popovers</a></li>
												<li><a href="ui-progress.html">Progress</a></li>
												<li><a href="ui-placeholders.html">Placeholders</a></li>
												<li><a href="ui-spinner.html">Spinner</a></li>
												<li><a href="ui-sweetalerts.html">Sweet Alerts</a></li>
												<li><a href="ui-nav-tabs.html">Tabs</a></li>
												<li><a href="ui-toasts.html">Toasts</a></li>
												<li><a href="ui-tooltips.html">Tooltips</a></li>
												<li><a href="ui-typography.html">Typography</a></li>
												<li><a href="ui-video.html">Video</a></li>
											<li><a href="ui-sortable.html">Sortable</a></li>
											<li><a href="ui-swiperjs.html">Swiperjs</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);"> Advanced UI<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="ui-ribbon.html">Ribbon</a></li>
												<li><a href="ui-clipboard.html">Clipboard</a></li>
												<li><a href="ui-drag-drop.html">Drag & Drop</a></li>
												<li><a href="ui-rangeslider.html">Range Slider</a></li>
												<li><a href="ui-rating.html">Rating</a></li>
												<li><a href="ui-text-editor.html">Text Editor</a></li>
												<li><a href="ui-counter.html">Counter</a></li>
												<li><a href="ui-scrollbar.html">Scrollbar</a></li>
												<li><a href="ui-stickynote.html">Sticky Note</a></li>
												<li><a href="ui-timeline.html">Timeline</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">Forms<span class="menu-arrow"></span> </a>
											<ul>
												<li class="submenu submenu-two">
													<a href="javascript:void(0);">Form Elements<span class="menu-arrow inside-submenu"></span></a>
													<ul>
														<li><a href="form-basic-inputs.html">Basic Inputs</a></li>
														<li><a href="form-checkbox-radios.html">Checkbox & Radios</a> </li>
														<li><a href="form-input-groups.html">Input Groups</a></li>
														<li><a href="form-grid-gutters.html">Grid & Gutters</a></li>
														<li><a href="form-select.html">Form Select</a></li>
														<li><a href="form-mask.html">Input Masks</a></li>
														<li><a href="form-fileupload.html">File Uploads</a></li>
														
													</ul>
												</li>
												<li class="submenu submenu-two">
													<a href="javascript:void(0);">Layouts<span class="menu-arrow inside-submenu"></span></a>
													<ul>
														<li><a href="form-horizontal.html">Horizontal Form</a></li>
														<li><a href="form-vertical.html">Vertical Form</a></li>
														<li><a href="form-floating-labels.html">Floating Labels</a></li>
													</ul>
												</li>
												<li><a href="form-validation.html">Form Validation</a></li>
												<li><a href="form-select2.html">Select2</a></li>
												<li><a href="form-wizard.html">Form Wizard</a></li>
												<li><a href="form-pickers.html">Form Picker</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">Tables<span class="menu-arrow"></span></a>
											<ul>
												<li><a href="tables-basic.html">Basic Tables </a></li>
												<li><a href="data-tables.html">Data Table </a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">Charts<span class="menu-arrow"></span> </a>
											<ul>
												<li><a href="chart-apex.html">Apex Charts</a></li>
												<li><a href="chart-c3.html">Chart C3</a></li>
												<li><a href="chart-js.html">Chart Js</a></li>
												<li><a href="chart-morris.html">Morris Charts</a></li>
												<li><a href="chart-flot.html">Flot Charts</a></li>
												<li><a href="chart-peity.html">Peity Charts</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">Icons<span class="menu-arrow"></span> </a>
											<ul>
												<li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
												<li><a href="icon-tabler.html">Tabler Icons</a></li>
												<li><a href="icon-bootstrap.html">Bootstrap Icons</a></li>
												<li><a href="icon-remix.html">Remix Icons</a></li>
												<li><a href="icon-feather.html">Feather Icons</a></li>
												<li><a href="icon-ionic.html">Ionic Icons</a></li>
												<li><a href="icon-material.html">Material Icons</a></li>
												<li><a href="icon-pe7.html">Pe7 Icons</a></li>
												<li><a href="icon-simpleline.html">Simpleline Icons</a></li>
												<li><a href="icon-themify.html">Themify Icons</a></li>
												<li><a href="icon-weather.html">Weather Icons</a></li>
												<li><a href="icon-typicon.html">Typicon Icons</a></li>
												<li><a href="icon-flag.html">Flag Icons</a></li>
											</ul>
										</li>
										<li class="submenu">
											<a href="javascript:void(0);">
												<i class="ti ti-table-plus"></i>
												<span>Maps</span>
												<span class="menu-arrow"></span>
											</a>
											<ul>
												<li>
													<a href="maps-vector.html">Vector</a>
												</li>
												<li>
													<a href="maps-leaflet.html">Leaflet</a>
												</li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="p-3">
						<a href="javascript:void(0);" class="d-flex align-items-center fs-12 mb-3">Documentation</a>
						<a href="javascript:void(0);" class="d-flex align-items-center fs-12">Change Log<span class="badge bg-pink badge-xs text-white fs-10 ms-2">v4.0.9</span></a>
					</div>
				</div>
			</div>
		</div>
		<!-- /Stacked Sidebar -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">

				<!-- Breadcrumb -->
				<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
					<div class="my-auto mb-2">
						<h2 class="mb-1">Admin Dashboard</h2>
						<nav>
							<ol class="breadcrumb mb-0">
								<li class="breadcrumb-item">
									<a href="index.html"><i class="ti ti-smart-home"></i></a>
								</li>
								<li class="breadcrumb-item">
									Dashboard
								</li>
								<li class="breadcrumb-item active" aria-current="page">Admin Dashboard</li>
							</ol>
						</nav>
					</div>
					<div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
						<div class="me-2 mb-2">
							<div class="dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
									<i class="ti ti-file-export me-1"></i>Export
								</a>
								<ul class="dropdown-menu  dropdown-menu-end p-3">
									<li>
										<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-pdf me-1"></i>Export as PDF</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-xls me-1"></i>Export as Excel </a>
									</li>
								</ul>
							</div>
						</div>
						<div class="mb-2">
							<div class="input-icon w-120 position-relative">
								<span class="input-icon-addon">
									<i class="ti ti-calendar text-gray-9"></i>
								</span>
								<input type="text" class="form-control yearpicker" value="2025">
							</div>
						</div>
						<div class="ms-2 head-icons">
							<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
								<i class="ti ti-chevrons-up"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- /Breadcrumb -->

				<!-- Welcome Wrap -->
				<div class="card border-0">
					<div class="card-body d-flex align-items-center justify-content-between flex-wrap pb-1">
						<div class="d-flex align-items-center mb-3">
							<span class="avatar avatar-xl flex-shrink-0">
								<img src="assets/img/profiles/avatar-31.jpg" class="rounded-circle" alt="img">
							</span>
							<div class="ms-3">
								<h3 class="mb-2">Welcome Back, Adrian <a href="javascript:void(0);" class="edit-icon"><i class="ti ti-edit fs-14"></i></a></h3>
								<p>You have <span class="text-primary text-decoration-underline">21</span> Pending Approvals & <span class="text-primary text-decoration-underline">14</span> Leave Requests</p>
							</div>
						</div>
						<div class="d-flex align-items-center flex-wrap mb-1">
							<a href="#" class="btn btn-secondary btn-md me-2 mb-2" data-bs-toggle="modal" data-bs-target="#add_project"><i class="ti ti-square-rounded-plus me-1"></i>Add Project</a>
							<a href="#" class="btn btn-primary btn-md mb-2" data-bs-toggle="modal" data-bs-target="#add_leaves"><i class="ti ti-square-rounded-plus me-1"></i>Add Requests</a>
						</div>
					</div>
				</div>
				<!-- /Welcome Wrap -->

				<div class="row">

					<!-- Widget Info -->
					<div class="col-xxl-8 d-flex">
						<div class="row flex-fill">
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-primary mb-2">
											<i class="ti ti-calendar-share fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Attendance Overview</h6>
										<h3 class="mb-3">120/154 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
										<a href="attendance-employee.html" class="link-default">View Details</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-secondary mb-2">
											<i class="ti ti-browser fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total No of Project's</h6>
										<h3 class="mb-3">90/125 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-2.1%</span></h3>
										<a href="projects.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-info mb-2">
											<i class="ti ti-users-group fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total No of Clients</h6>
										<h3 class="mb-3">69/86 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-11.2%</span></h3>
										<a href="clients.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-pink mb-2">
											<i class="ti ti-checklist fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total No of Tasks</h6>
										<h3 class="mb-3">225/28 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-down me-1"></i>+11.2%</span></h3>
										<a href="tasks.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-purple mb-2">
											<i class="ti ti-moneybag fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Earnings</h6>
										<h3 class="mb-3">$21445 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+10.2%</span></h3>
										<a href="expenses.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-danger mb-2">
											<i class="ti ti-browser fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Profit This Week</h6>
										<h3 class="mb-3">$5,544 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
										<a href="purchase-transaction.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-success mb-2">
											<i class="ti ti-users-group fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Job Applicants</h6>
										<h3 class="mb-3">98 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
										<a href="job-list.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-dark mb-2">
											<i class="ti ti-user-star fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">New Hire</h6>
										<h3 class="mb-3">45/48 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-11.2%</span></h3>
										<a href="candidates.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Widget Info -->

					<!-- Employees By Department -->
					<div class="col-xxl-4 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Employees By Department</h5>
								<div class="dropdown mb-2">
									<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
										<i class="ti ti-calendar me-1"></i>This Week
									</a>
									<ul class="dropdown-menu  dropdown-menu-end p-3">
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Last Week</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="card-body">
								<div id="emp-department"></div>
								<p class="fs-13"><i class="ti ti-circle-filled me-2 fs-8 text-primary"></i>No of
									Employees increased by <span class="text-success fw-bold">+20%</span> from last Week
								</p>
							</div>
						</div>
					</div>
					<!-- /Employees By Department -->

				</div>

				<div class="row">

					<!-- Total Employee -->
					<div class="col-xxl-4 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Employee Status</h5>
								<div class="dropdown mb-2">
									<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
										<i class="ti ti-calendar me-1"></i>This Week
									</a>
									<ul class="dropdown-menu  dropdown-menu-end p-3">
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between mb-1">
									<p class="fs-13 mb-3">Total Employee</p>
									<h3 class="mb-3">154</h3>
								</div>
								<div class="progress-stacked emp-stack mb-3">
									<div class="progress" role="progressbar" aria-label="Segment one" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
										<div class="progress-bar bg-warning"></div>
									</div>
									<div class="progress" role="progressbar" aria-label="Segment two" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
										<div class="progress-bar bg-secondary"></div>
									</div>
									<div class="progress" role="progressbar" aria-label="Segment three" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
										<div class="progress-bar bg-danger"></div>
									</div>
									<div class="progress" role="progressbar" aria-label="Segment four" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
										<div class="progress-bar bg-pink"></div>
									</div>
								</div>
								<div class="border mb-3">
									<div class="row gx-0">
										<div class="col-6">
											<div class="p-2 flex-fill border-end border-bottom">
												<p class="fs-13 mb-2"><i class="ti ti-square-filled text-primary fs-12 me-2"></i>Fulltime <span class="text-gray-9">(48%)</span></p>
												<h2 class="display-1">112</h2>
											</div>
										</div>
										<div class="col-6">
											<div class="p-2 flex-fill border-bottom text-end">
												<p class="fs-13 mb-2"><i class="ti ti-square-filled me-2 text-secondary fs-12"></i>Contract <span class="text-gray-9">(20%)</span></p>
												<h2 class="display-1">112</h2>
											</div>
										</div>
										<div class="col-6">
											<div class="p-2 flex-fill border-end">
												<p class="fs-13 mb-2"><i class="ti ti-square-filled me-2 text-danger fs-12"></i>Probation <span class="text-gray-9">(22%)</span></p>
												<h2 class="display-1">12</h2>
											</div>
										</div>
										<div class="col-6">
											<div class="p-2 flex-fill text-end">
												<p class="fs-13 mb-2"><i class="ti ti-square-filled text-pink me-2 fs-12"></i>WFH <span class="text-gray-9">(20%)</span></p>
												<h2 class="display-1">04</h2>
											</div>
										</div>
									</div>
								</div>
								<h6 class="mb-2">Top Performer</h6>
								<div class="p-2 d-flex align-items-center justify-content-between border border-primary bg-primary-100 br-5 mb-4">
									<div class="d-flex align-items-center overflow-hidden">
										<span class="me-2">
											<i class="ti ti-award-filled text-primary fs-24"></i>
										</span>
										<a href="employee-details.html" class="avatar avatar-md me-2">
											<img src="assets/img/profiles/avatar-24.jpg" class="rounded-circle border border-white" alt="img">
										</a>
										<div>
											<h6 class="text-truncate mb-1 fs-14 fw-medium"><a href="employee-details.html">Daniel Esbella</a></h6>
											<p class="fs-13">IOS Developer</p>
										</div>
									</div>
									<div class="text-end">
										<p class="fs-13 mb-1">Performance</p>
										<h5 class="text-primary">99%</h5>
									</div>
								</div>
								<a href="employees.html" class="btn btn-light btn-md w-100">View All Employees</a>
							</div>
						</div>
					</div>
					<!-- /Total Employee -->

					<!-- Attendance Overview -->
					<div class="col-xxl-4 col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Attendance Overview</h5>
								<div class="dropdown mb-2">
									<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
										<i class="ti ti-calendar me-1"></i>Today
									</a>
									<ul class="dropdown-menu  dropdown-menu-end p-3">
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="card-body">
								<div class="chartjs-wrapper-demo position-relative mb-4">
									<canvas id="attendance" height="200"></canvas>
									<div class="position-absolute text-center attendance-canvas">
										<p class="fs-13 mb-1">Total Attendance</p>
										<h3>120</h3>
									</div>
								</div>
								<h6 class="mb-3">Status</h6>
								<div class="d-flex align-items-center justify-content-between">
									<p class="f-13 mb-2"><i class="ti ti-circle-filled text-success me-1"></i>Present</p>
									<p class="f-13 fw-medium text-gray-9 mb-2">59%</p>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<p class="f-13 mb-2"><i class="ti ti-circle-filled text-secondary me-1"></i>Late</p>
									<p class="f-13 fw-medium text-gray-9 mb-2">21%</p>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<p class="f-13 mb-2"><i class="ti ti-circle-filled text-warning me-1"></i>Permission</p>
									<p class="f-13 fw-medium text-gray-9 mb-2">2%</p>
								</div>
								<div class="d-flex align-items-center justify-content-between mb-2">
									<p class="f-13 mb-2"><i class="ti ti-circle-filled text-danger me-1"></i>Absent</p>
									<p class="f-13 fw-medium text-gray-9 mb-2">15%</p>
								</div>
								<div class="bg-light br-5 box-shadow-xs p-2 pb-0 d-flex align-items-center justify-content-between flex-wrap">
									<div class="d-flex align-items-center">
										<p class="mb-2 me-2">Total Absenties</p>
										<div class="avatar-list-stacked avatar-group-sm mb-2">
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/profiles/avatar-27.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/profiles/avatar-30.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img src="assets/img/profiles/avatar-14.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img src="assets/img/profiles/avatar-29.jpg" alt="img">
											</span>
											<a class="avatar bg-primary avatar-rounded text-fixed-white fs-10" href="javascript:void(0);">
												+1
											</a>
										</div>
									</div>
									<a href="leaves.html" class="fs-13 link-primary text-decoration-underline mb-2">View Details</a>
								</div>
							</div>
						</div>
					</div>
					<!-- /Attendance Overview -->

					<!-- Clock-In/Out -->
					<div class="col-xxl-4 col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Clock-In/Out</h5>
								<div class="d-flex align-items-center">
									<div class="dropdown mb-2">
										<a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-sm d-inline-flex align-items-center border-0 fs-13 me-2" data-bs-toggle="dropdown">
											All Departments
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Finance</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Development</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Marketing</a>
											</li>
										</ul>
									</div>
									<div class="dropdown mb-2">
										<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
											<i class="ti ti-calendar me-1"></i>Today
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div>
									<div
										class="d-flex align-items-center justify-content-between mb-3 p-2 border border-dashed br-5">
										<div class="d-flex align-items-center">
											<a href="javascript:void(0);" class="avatar flex-shrink-0">
												<img src="assets/img/profiles/avatar-24.jpg" class="rounded-circle border border-2" alt="img">
											</a>
											<div class="ms-2">
												<h6 class="fs-14 fw-medium text-truncate">Daniel Esbella</h6>
												<p class="fs-13">UI/UX Designer</p>
											</div>
										</div>
										<div class="d-flex align-items-center">
											<a href="javascript:void(0);" class="link-default me-2"><i class="ti ti-clock-share"></i></a>
											<span class="fs-10 fw-medium d-inline-flex align-items-center badge badge-success"><i class="ti ti-circle-filled fs-5 me-1"></i>09:15</span>
										</div>
									</div>
									<div class="d-flex align-items-center justify-content-between mb-3 p-2 border br-5">
										<div class="d-flex align-items-center">
											<a href="javascript:void(0);" class="avatar flex-shrink-0">
												<img src="assets/img/profiles/avatar-23.jpg" class="rounded-circle border border-2" alt="img">
											</a>
											<div class="ms-2">
												<h6 class="fs-14 fw-medium">Doglas Martini</h6>
												<p class="fs-13">Project Manager</p>
											</div>
										</div>
										<div class="d-flex align-items-center">
											<a href="javascript:void(0);" class="link-default me-2"><i class="ti ti-clock-share"></i></a>
											<span class="fs-10 fw-medium d-inline-flex align-items-center badge badge-success"><i class="ti ti-circle-filled fs-5 me-1"></i>09:36</span>
										</div>
									</div>
									<div class="mb-3 p-2 border br-5">
										<div class="d-flex align-items-center justify-content-between">
											<div class="d-flex align-items-center">
												<a href="javascript:void(0);" class="avatar flex-shrink-0">
													<img src="assets/img/profiles/avatar-27.jpg" class="rounded-circle border border-2" alt="img">
												</a>
												<div class="ms-2">
													<h6 class="fs-14 fw-medium text-truncate">Brian Villalobos</h6>
													<p class="fs-13">PHP Developer</p>
												</div>
											</div>
											<div class="d-flex align-items-center">
												<a href="javascript:void(0);" class="link-default me-2"><i class="ti ti-clock-share"></i></a>
												<span class="fs-10 fw-medium d-inline-flex align-items-center badge badge-success"><i class="ti ti-circle-filled fs-5 me-1"></i>09:15</span>
											</div>
										</div>
										<div
											class="d-flex align-items-center justify-content-between flex-wrap mt-2 border br-5 p-2 pb-0">
											<div>
												<p class="mb-1 d-inline-flex align-items-center"><i class="ti ti-circle-filled text-success fs-5 me-1"></i>Clock In</p>
												<h6 class="fs-13 fw-normal mb-2">10:30 AM</h6>
											</div>
											<div>
												<p class="mb-1 d-inline-flex align-items-center"><i class="ti ti-circle-filled text-danger fs-5 me-1"></i>Clock Out</p>
												<h6 class="fs-13 fw-normal mb-2">09:45 AM</h6>
											</div>
											<div>
												<p class="mb-1 d-inline-flex align-items-center"><i class="ti ti-circle-filled text-warning fs-5 me-1"></i>Production</p>
												<h6 class="fs-13 fw-normal mb-2">09:21 Hrs</h6>
											</div>
										</div>
									</div>
								</div>
								<h6 class="mb-2">Late</h6>
								<div class="d-flex align-items-center justify-content-between mb-3 p-2 border border-dashed br-5">
									<div class="d-flex align-items-center">
										<span class="avatar flex-shrink-0">
											<img src="assets/img/profiles/avatar-29.jpg" class="rounded-circle border border-2" alt="img">
										</span>
										<div class="ms-2">
											<h6 class="fs-14 fw-medium text-truncate">Anthony Lewis <span class="fs-10 fw-medium d-inline-flex align-items-center badge badge-success"><i class="ti ti-clock-hour-11 me-1"></i>30 Min</span></h6>
											<p class="fs-13">Marketing Head</p>
										</div>
									</div>
									<div class="d-flex align-items-center">
										<a href="javascript:void(0);" class="link-default me-2"><i class="ti ti-clock-share"></i></a>
										<span class="fs-10 fw-medium d-inline-flex align-items-center badge badge-danger"><i class="ti ti-circle-filled fs-5 me-1"></i>08:35</span>
									</div>
								</div>
								<a href="attendance-report.html" class="btn btn-light btn-md w-100">View All Attendance</a>
							</div>
						</div>
					</div>
					<!-- /Clock-In/Out -->

				</div>

				<div class="row">

					<!-- Jobs Applicants -->
					<div class="col-xxl-4 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Jobs Applicants</h5>
								<a href="job-list.html" class="btn btn-light btn-md mb-2">View All</a>
							</div>
							<div class="card-body">
								<ul class="nav nav-tabs tab-style-1 nav-justified d-sm-flex d-block p-0 mb-4" role="tablist">
									<li class="nav-item" role="presentation">
										<a class="nav-link fw-medium" data-bs-toggle="tab" data-bs-target="#openings" aria-current="page" href="#openings" aria-selected="true" role="tab">Openings</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link fw-medium active" data-bs-toggle="tab" data-bs-target="#applicants" href="#applicants" aria-selected="false" tabindex="-1" role="tab">Applicants</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade" id="openings">
										<div class="d-flex align-items-center justify-content-between mb-4">
											<div class="d-flex align-items-center">
												<a href="#" class="avatar overflow-hidden flex-shrink-0 bg-gray-100">
													<img src="assets/img/icons/apple.svg" class="img-fluid rounded-circle w-auto h-auto" alt="img">
												</a>
												<div class="ms-2 overflow-hidden">
													<p class="text-dark fw-medium text-truncate mb-0"><a href="javascript:void(0);">Senior IOS Developer</a></p>
													<span class="fs-12">No of Openings : 25 </span>
												</div>
											</div>
											<a href="javascript:void(0);" class="btn btn-light btn-sm p-0 btn-icon d-flex align-items-center justify-content-center"><i class="ti ti-edit"></i></a>
										</div>
										<div class="d-flex align-items-center justify-content-between mb-4">
											<div class="d-flex align-items-center">
												<a href="#" class="avatar overflow-hidden flex-shrink-0 bg-gray-100">
													<img src="assets/img/icons/php.svg" class="img-fluid w-auto h-auto" alt="img">
												</a>
												<div class="ms-2 overflow-hidden">
													<p class="text-dark fw-medium text-truncate mb-0"><a href="javascript:void(0);">Junior PHP Developer</a></p>
													<span class="fs-12">No of Openings : 20 </span>
												</div>
											</div>
											<a href="javascript:void(0);" class="btn btn-light btn-sm p-0 btn-icon d-flex align-items-center justify-content-center"><i class="ti ti-edit"></i></a>
										</div>
										<div class="d-flex align-items-center justify-content-between mb-4">
											<div class="d-flex align-items-center">
												<a href="#" class="avatar overflow-hidden flex-shrink-0 bg-gray-100">
													<img src="assets/img/icons/react.svg" class="img-fluid w-auto h-auto" alt="img">
												</a>
												<div class="ms-2 overflow-hidden">
													<p class="text-dark fw-medium text-truncate mb-0"><a href="javascript:void(0);">Junior React Developer </a></p>
													<span class="fs-12">No of Openings : 30 </span>
												</div>
											</div>
											<a href="javascript:void(0);" class="btn btn-light btn-sm p-0 btn-icon d-flex align-items-center justify-content-center"><i class="ti ti-edit"></i></a>
										</div>
										<div class="d-flex align-items-center justify-content-between mb-0">
											<div class="d-flex align-items-center">
												<a href="#" class="avatar overflow-hidden flex-shrink-0 bg-gray-100">
													<img src="assets/img/icons/laravel-icon.svg" class="img-fluid w-auto h-auto" alt="img">
												</a>
												<div class="ms-2 overflow-hidden">
													<p class="text-dark fw-medium text-truncate mb-0"><a href="javascript:void(0);">Senior Laravel Developer</a></p>
													<span class="fs-12">No of Openings : 40 </span>
												</div>
											</div>
											<a href="javascript:void(0);" class="btn btn-light btn-sm p-0 btn-icon d-flex align-items-center justify-content-center"><i class="ti ti-edit"></i></a>
										</div>
									</div>
									<div class="tab-pane fade show active" id="applicants">
										<div class="d-flex align-items-center justify-content-between mb-4">
											<div class="d-flex align-items-center">
												<a href="#" class="avatar overflow-hidden flex-shrink-0">
													<img src="assets/img/users/user-09.jpg" class="img-fluid rounded-circle" alt="img">
												</a>
												<div class="ms-2 overflow-hidden">
													<p class="text-dark fw-medium text-truncate mb-0"><a href="#">Brian Villalobos</a></p>
													<span class="fs-13 d-inline-flex align-items-center">Exp : 5+ Years<i class="ti ti-circle-filled fs-4 mx-2 text-primary"></i>USA</span>
												</div>
											</div>
											<span class="badge badge-secondary badge-xs">UI/UX Designer</span>
										</div>
										<div class="d-flex align-items-center justify-content-between mb-4">
											<div class="d-flex align-items-center">
												<a href="#" class="avatar overflow-hidden flex-shrink-0">
													<img src="assets/img/users/user-32.jpg" class="img-fluid rounded-circle" alt="img">
												</a>
												<div class="ms-2 overflow-hidden">
													<p class="text-dark fw-medium text-truncate mb-0"><a href="#">Anthony Lewis</a></p>
													<span class="fs-13 d-inline-flex align-items-center">Exp : 4+ Years<i class="ti ti-circle-filled fs-4 mx-2 text-primary"></i>USA</span>
												</div>
											</div>
											<span class="badge badge-info badge-xs">Python Developer</span>
										</div>
										<div class="d-flex align-items-center justify-content-between mb-4">
											<div class="d-flex align-items-center">
												<a href="#" class="avatar overflow-hidden flex-shrink-0">
													<img src="assets/img/users/user-32.jpg" class="img-fluid rounded-circle" alt="img">
												</a>
												<div class="ms-2 overflow-hidden">
													<p class="text-dark fw-medium text-truncate mb-0"><a href="#">Stephan Peralt</a></p>
													<span class="fs-13 d-inline-flex align-items-center">Exp : 6+ Years<i class="ti ti-circle-filled fs-4 mx-2 text-primary"></i>USA</span>
												</div>
											</div>
											<span class="badge badge-pink badge-xs">Android Developer</span>
										</div>
										<div class="d-flex align-items-center justify-content-between mb-0">
											<div class="d-flex align-items-center">
												<a href="javascript:void(0);" class="avatar overflow-hidden flex-shrink-0">
													<img src="assets/img/users/user-34.jpg" class="img-fluid rounded-circle" alt="img">
												</a>
												<div class="ms-2 overflow-hidden">
													<p class="text-dark fw-medium text-truncate mb-0"><a href="javascript:void(0);">Doglas Martini</a></p>
													<span class="fs-13 d-inline-flex align-items-center">Exp : 2+ Years<i class="ti ti-circle-filled fs-4 mx-2 text-primary"></i>USA</span>
												</div>
											</div>
											<span class="badge badge-purple badge-xs">React Developer</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Jobs Applicants -->
					
					<!-- Employees -->
					<div class="col-xxl-4 col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Employees</h5>
								<a href="employees.html" class="btn btn-light btn-md mb-2">View All</a>
							</div>
							<div class="card-body p-0">
								<div class="table-responsive">	
									<table class="table table-nowrap mb-0">
										<thead>
											<tr>
												<th>Name</th>
												<th>Department</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<div class="d-flex align-items-center">
														<a href="javascript:void(0);" class="avatar">
															<img src="assets/img/users/user-32.jpg" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-medium"><a href="javascript:void(0);">Anthony Lewis</a></h6>
															<span class="fs-12">Finance</span>
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-secondary-transparent badge-xs">
														Finance
													</span>
												</td>
											</tr>
											<tr>
												<td>
													<div class="d-flex align-items-center">
														<a href="#" class="avatar">
															<img src="assets/img/users/user-09.jpg" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-medium"><a href="#">Brian Villalobos</a></h6>
															<span class="fs-12">PHP Developer</span>
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-danger-transparent badge-xs">Development</span>
												</td>
											</tr>
											<tr>
												<td>
													<div class="d-flex align-items-center">
														<a href="#" class="avatar">
															<img src="assets/img/users/user-01.jpg" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-medium"><a href="#">Stephan Peralt</a></h6>
															<span class="fs-12">Executive</span>
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-info-transparent badge-xs">Marketing</span>
												</td>
											</tr>
											<tr>
												<td>
													<div class="d-flex align-items-center">
														<a href="javascript:void(0);" class="avatar">
															<img src="assets/img/users/user-34.jpg" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-medium"><a href="javascript:void(0);">Doglas Martini</a></h6>
															<span class="fs-12">Project Manager</span>
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-purple-transparent badge-xs">Manager</span>
												</td>
											</tr>
											<tr>
												<td class="border-0">
													<div class="d-flex align-items-center">
														<a href="javascript:void(0);" class="avatar">
															<img src="assets/img/users/user-37.jpg" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-medium"><a href="javascript:void(0);">Anthony Lewis</a></h6>
															<span class="fs-12">UI/UX Designer</span>
														</div>
													</div>
												</td>
												<td class="border-0">
													<span class="badge badge-pink-transparent badge-xs">UI/UX Design</span>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- /Employees -->
					
					<!-- Todo -->
					<div class="col-xxl-4 col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Todo</h5>
								<div class="d-flex align-items-center">
									<div class="dropdown mb-2 me-2">
										<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
											<i class="ti ti-calendar me-1"></i>Today
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
											</li>
										</ul>
									</div>
									<a href="#" class="btn btn-primary btn-icon btn-xs rounded-circle d-flex align-items-center justify-content-center p-0 mb-2"  data-bs-toggle="modal" data-bs-target="#add_todo"><i class="ti ti-plus fs-16"></i></a>
								</div>
							</div>
							<div class="card-body">
								<div class="d-flex align-items-center todo-item border p-2 br-5 mb-2">
									<i class="ti ti-grid-dots me-2"></i>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="todo1">
										<label class="form-check-label fw-medium" for="todo1">Add Holidays</label>
									</div>
								</div>
								<div class="d-flex align-items-center todo-item border p-2 br-5 mb-2">
									<i class="ti ti-grid-dots me-2"></i>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="todo2">
										<label class="form-check-label fw-medium" for="todo2">Add Meeting  to Client</label>
									</div>
								</div>
								<div class="d-flex align-items-center todo-item border p-2 br-5 mb-2">
									<i class="ti ti-grid-dots me-2"></i>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="todo3">
										<label class="form-check-label fw-medium" for="todo3">Chat with Adrian</label>
									</div>
								</div>
								<div class="d-flex align-items-center todo-item border p-2 br-5 mb-2">
									<i class="ti ti-grid-dots me-2"></i>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="todo4">
										<label class="form-check-label fw-medium" for="todo4">Management Call</label>
									</div>
								</div>
								<div class="d-flex align-items-center todo-item border p-2 br-5 mb-2">
									<i class="ti ti-grid-dots me-2"></i>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="todo5">
										<label class="form-check-label fw-medium" for="todo5">Add Payroll</label>
									</div>
								</div>
								<div class="d-flex align-items-center todo-item border p-2 br-5 mb-0">
									<i class="ti ti-grid-dots me-2"></i>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="todo6">
										<label class="form-check-label fw-medium" for="todo6">Add Policy for Increment </label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Todo -->

				</div>

				<div class="row">
					
					<!-- Sales Overview -->
					<div class="col-xl-7 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Sales Overview</h5>
								<div class="d-flex align-items-center">
									<div class="dropdown mb-2">
										<a href="javascript:void(0);" class="dropdown-toggle btn btn-white border-0 btn-sm d-inline-flex align-items-center fs-13 me-2" data-bs-toggle="dropdown">
											All Departments
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">UI/UX Designer</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">HR Manager</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Junior Tester</a>
											</li>
										</ul>
									</div>	
								</div>
							</div>
							<div class="card-body pb-0">
								<div class="d-flex align-items-center justify-content-between flex-wrap">
									<div class="d-flex align-items-center mb-1">
										<p class="fs-13 text-gray-9 me-3 mb-0"><i class="ti ti-square-filled me-2 text-primary"></i>Income</p>
										<p class="fs-13 text-gray-9 mb-0"><i class="ti ti-square-filled me-2 text-gray-2"></i>Expenses</p>
									</div>
									<p class="fs-13 mb-1">Last Updated at 11:30PM</p>
								</div>
								<div id="sales-income"></div>
							</div>
						</div>
					</div>
					<!-- /Sales Overview -->
					
					<!-- Invoices -->
					<div class="col-xl-5 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Invoices</h5>
								<div class="d-flex align-items-center">
									<div class="dropdown mb-2">
										<a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-sm d-inline-flex align-items-center fs-13 me-2 border-0" data-bs-toggle="dropdown">
											Invoices
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Invoices</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Paid</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Unpaid</a>
											</li>
										</ul>
									</div>
									<div class="dropdown mb-2">
										<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center"  data-bs-toggle="dropdown">
											<i class="ti ti-calendar me-1"></i>This Week
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body pt-2">
								<div class="table-responsive pt-1">	
									<table class="table table-nowrap table-borderless mb-0">
										<tbody>
											<tr>
												<td class="px-0">
													<div class="d-flex align-items-center">
														<a href="invoice-details.html" class="avatar">
															<img src="assets/img/users/user-39.jpg" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-medium"><a href="invoice-details.html">Redesign Website</a></h6>
															<span class="fs-13 d-inline-flex align-items-center">#INVOO2<i class="ti ti-circle-filled fs-4 mx-1 text-primary"></i>Logistics</span>
														</div>
													</div>
												</td>
												<td>
													<p class="fs-13 mb-1">Payment</p>
													<h6 class="fw-medium">$3560</h6>
												</td>
												<td class="px-0 text-end">
													<span class="badge badge-danger-transparent badge-xs d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Unpaid</span>
												</td>
											</tr>
											<tr>
												<td class="px-0">
													<div class="d-flex align-items-center">
														<a href="invoice-details.html" class="avatar">
															<img src="assets/img/users/user-40.jpg" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-medium"><a href="invoice-details.html">Module Completion</a></h6>
															<span class="fs-13 d-inline-flex align-items-center">#INVOO5<i class="ti ti-circle-filled fs-4 mx-1 text-primary"></i>Yip Corp</span>
														</div>
													</div>
												</td>
												<td>
													<p class="fs-13 mb-1">Payment</p>
													<h6 class="fw-medium">$4175</h6>
												</td>
												<td class="px-0 text-end">
													<span class="badge badge-danger-transparent badge-xs d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Unpaid</span>
												</td>
											</tr>
											<tr>
												<td class="px-0">
													<div class="d-flex align-items-center">
														<a href="invoice-details.html" class="avatar">
															<img src="assets/img/users/user-55.jpg" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-medium"><a href="invoice-details.html">Change on Emp Module</a></h6>
															<span class="fs-13 d-inline-flex align-items-center">#INVOO3<i class="ti ti-circle-filled fs-4 mx-1 text-primary"></i>Ignis LLP</span>
														</div>
													</div>
												</td>
												<td>
													<p class="fs-13 mb-1">Payment</p>
													<h6 class="fw-medium">$6985</h6>
												</td>
												<td class="px-0 text-end">
													<span class="badge badge-danger-transparent badge-xs d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Unpaid</span>
												</td>
											</tr>
											<tr>
												<td class="px-0">
													<div class="d-flex align-items-center">
														<a href="invoice-details.html" class="avatar">
															<img src="assets/img/users/user-42.jpg" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-medium"><a href="invoice-details.html">Changes on the Board</a></h6>
															<span class="fs-13 d-inline-flex align-items-center">#INVOO2<i class="ti ti-circle-filled fs-4 mx-1 text-primary"></i>Ignis LLP</span>
														</div>
													</div>
												</td>
												<td>
													<p class="fs-13 mb-1">Payment</p>
													<h6 class="fw-medium">$1457</h6>
												</td>
												<td class="px-0 text-end">
													<span class="badge badge-danger-transparent badge-xs d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Unpaid</span>
												</td>
											</tr>
											<tr>
												<td class="px-0">
													<div class="d-flex align-items-center">
														<a href="invoice-details.html" class="avatar">
															<img src="assets/img/users/user-44.jpg" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-medium"><a href="invoice-details.html">Hospital Management</a></h6>
															<span class="fs-13 d-inline-flex align-items-center">#INVOO6<i class="ti ti-circle-filled fs-4 mx-1 text-primary"></i>HCL Corp</span>
														</div>
													</div>
												</td>
												<td>
													<p class="fs-13 mb-1">Payment</p>
													<h6 class="fw-medium">$6458</h6>
												</td>
												<td class="px-0 text-end">
													<span class="badge badge-success-transparent badge-xs d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Paid</span>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<a href="invoice.html" class="btn btn-light btn-md w-100 mt-2">View All</a>
							</div>
						</div>
					</div>
					<!-- /Invoices -->

				</div>

				<div class="row">
					
					<!-- Projects -->
					<div class="col-xxl-8 col-xl-7 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Projects</h5>
								<div class="d-flex align-items-center">
									<div class="dropdown mb-2">
										<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center"  data-bs-toggle="dropdown">
											<i class="ti ti-calendar me-1"></i>This Week
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body p-0">
								<div class="table-responsive">	
									<table class="table table-nowrap mb-0">
										<thead>
											<tr>
												<th>ID</th>
												<th>Name</th>
												<th>Team</th>
												<th>Hours</th>
												<th>Deadline</th>
												<th>Priority</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><a href="project-details.html" class="link-default">PRO-001</a></td>
												<td><h6 class="fw-medium"><a href="project-details.html">Office Management App</a></h6></td>
												<td>
													<div class="avatar-list-stacked avatar-group-sm">
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-02.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-03.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-05.jpg" alt="img">
														</span>
													</div>
												</td>
												<td>
													<p class="mb-1">15/255 Hrs</p>
													<div class="progress progress-xs w-100" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
														<div class="progress-bar bg-primary" style="width: 40%"></div>
													</div>
												</td>
												<td>12 Sep 2024</td>
												<td>
													<span class="badge badge-danger d-inline-flex align-items-center badge-xs">
														<i class="ti ti-point-filled me-1"></i>High
													</span>
												</td>
											</tr>
											<tr>
												<td><a href="project-details.html" class="link-default">PRO-002</a></td>
												<td><h6 class="fw-medium"><a href="project-details.html">Clinic Management </a></h6></td>
												<td>
													<div class="avatar-list-stacked avatar-group-sm">
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-06.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-07.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-08.jpg" alt="img">
														</span>
														<a class="avatar bg-primary avatar-rounded text-fixed-white fs-10 fw-medium" href="javascript:void(0);">
															+1
														</a>
													</div>
												</td>
												<td>
													<p class="mb-1">15/255 Hrs</p>
													<div class="progress progress-xs w-100" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
														<div class="progress-bar bg-primary" style="width: 40%"></div>
													</div>
												</td>
												<td>24 Oct 2024</td>
												<td>
													<span class="badge badge-success d-inline-flex align-items-center badge-xs">
														<i class="ti ti-point-filled me-1"></i>Low
													</span>
												</td>
											</tr>
											<tr>
												<td><a href="project-details.html" class="link-default">PRO-003</a></td>
												<td><h6 class="fw-medium"><a href="project-details.html">Educational Platform</a></h6></td>
												<td>
													<div class="avatar-list-stacked avatar-group-sm">
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-06.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-08.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-09.jpg" alt="img">
														</span>
													</div>
												</td>
												<td>
													<p class="mb-1">40/255 Hrs</p>
													<div class="progress progress-xs w-100" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
														<div class="progress-bar bg-primary" style="width: 50%"></div>
													</div>
												</td>
												<td>18 Feb 2024</td>
												<td>
													<span class="badge badge-pink d-inline-flex align-items-center badge-xs">
														<i class="ti ti-point-filled me-1"></i>Medium
													</span>
												</td>
											</tr>
											<tr>
												<td><a href="project-details.html" class="link-default">PRO-004</a></td>
												<td><h6 class="fw-medium"><a href="project-details.html">Chat & Call Mobile App</a></h6></td>
												<td>
													<div class="avatar-list-stacked avatar-group-sm">
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-11.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-12.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-13.jpg" alt="img">
														</span>
													</div>
												</td>
												<td>
													<p class="mb-1">35/155 Hrs</p>
													<div class="progress progress-xs w-100" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
														<div class="progress-bar bg-primary" style="width: 50%"></div>
													</div>
												</td>
												<td>19 Feb 2024</td>
												<td>
													<span class="badge badge-danger d-inline-flex align-items-center badge-xs">
														<i class="ti ti-point-filled me-1"></i>High
													</span>
												</td>
											</tr>
											<tr>
												<td><a href="project-details.html" class="link-default">PRO-005</a></td>
												<td><h6 class="fw-medium"><a href="project-details.html">Travel Planning Website</a></h6></td>
												<td>
													<div class="avatar-list-stacked avatar-group-sm">
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-17.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-18.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-19.jpg" alt="img">
														</span>
													</div>
												</td>
												<td>
													<p class="mb-1">50/235 Hrs</p>
													<div class="progress progress-xs w-100" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
														<div class="progress-bar bg-primary" style="width: 50%"></div>
													</div>
												</td>
												<td>18 Feb 2024</td>
												<td>
													<span class="badge badge-pink d-inline-flex align-items-center badge-xs">
														<i class="ti ti-point-filled me-1"></i>Medium
													</span>
												</td>
											</tr>
											<tr>
												<td><a href="project-details.html" class="link-default">PRO-006</a></td>
												<td><h6 class="fw-medium"><a href="project-details.html">Service Booking Software</a></h6></td>
												<td>
													<div class="avatar-list-stacked avatar-group-sm">
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-06.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-08.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-09.jpg" alt="img">
														</span>
													</div>
												</td>
												<td>
													<p class="mb-1">40/255 Hrs</p>
													<div class="progress progress-xs w-100" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
														<div class="progress-bar bg-primary" style="width: 50%"></div>
													</div>
												</td>
												<td>20 Feb 2024</td>
												<td>
													<span class="badge badge-success d-inline-flex align-items-center badge-xs">
														<i class="ti ti-point-filled me-1"></i>Low
													</span>
												</td>
											</tr>
											<tr>
												<td class="border-0"><a href="project-details.html" class="link-default">PRO-008</a></td>
												<td class="border-0"><h6 class="fw-medium"><a href="project-details.html">Travel Planning Website</a></h6></td>
												<td class="border-0">
													<div class="avatar-list-stacked avatar-group-sm">
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-15.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-16.jpg" alt="img">
														</span>
														<span class="avatar avatar-rounded">
															<img class="border border-white" src="assets/img/profiles/avatar-17.jpg" alt="img">
														</span>
														<a class="avatar bg-primary avatar-rounded text-fixed-white fs-10 fw-medium" href="javascript:void(0);">
															+2
														</a>
													</div>
												</td>
												<td class="border-0">
													<p class="mb-1">15/255 Hrs</p>
													<div class="progress progress-xs w-100" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
														<div class="progress-bar bg-primary" style="width: 45%"></div>
													</div>
												</td>
												<td class="border-0">17 Oct 2024</td>
												<td class="border-0">
													<span class="badge badge-pink d-inline-flex align-items-center badge-xs">
														<i class="ti ti-point-filled me-1"></i>Medium
													</span>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- /Projects -->

					<!-- Tasks Statistics -->
					<div class="col-xxl-4 col-xl-5 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Tasks Statistics</h5>
								<div class="d-flex align-items-center">
									<div class="dropdown mb-2">
										<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center"  data-bs-toggle="dropdown">
											<i class="ti ti-calendar me-1"></i>This Week
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="chartjs-wrapper-demo position-relative mb-4">
									<canvas id="mySemiDonutChart" height="190"></canvas>
									<div class="position-absolute text-center attendance-canvas">
										<p class="fs-13 mb-1">Total Tasks</p>
										<h3>124/165</h3>
									</div>
								</div>
								<div class="d-flex align-items-center flex-wrap">
									<div class="border-end text-center me-2 pe-2 mb-3">
										<p class="fs-13 d-inline-flex align-items-center mb-1"><i class="ti ti-circle-filled fs-10 me-1 text-warning"></i>Ongoing</p>
										<h5>24%</h5>
									</div>
									<div class="border-end text-center me-2 pe-2 mb-3">
										<p class="fs-13 d-inline-flex align-items-center mb-1"><i class="ti ti-circle-filled fs-10 me-1 text-info"></i>On Hold </p>
										<h5>10%</h5>
									</div>
									<div class="border-end text-center me-2 pe-2 mb-3">
										<p class="fs-13 d-inline-flex align-items-center mb-1"><i class="ti ti-circle-filled fs-10 me-1 text-danger"></i>Overdue</p>
										<h5>16%</h5>
									</div>
									<div class="text-center me-2 pe-2 mb-3">
										<p class="fs-13 d-inline-flex align-items-center mb-1"><i class="ti ti-circle-filled fs-10 me-1 text-success"></i>Ongoing</p>
										<h5>40%</h5>
									</div>
								</div>
								<div class="bg-dark br-5 p-3 pb-0 d-flex align-items-center justify-content-between">
									<div class="mb-2">
										<h4 class="text-success">389/689 hrs</h4>
										<p class="fs-13 mb-0">Spent on Overall Tasks This Week</p>
									</div>
									<a href="tasks.html" class="btn btn-sm btn-light mb-2 text-nowrap">View All</a>
								</div>
							</div>
						</div>
					</div>
					<!-- /Tasks Statistics -->

				</div>

				<div class="row">

					<!-- Schedules -->
					<div class="col-xxl-4 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Schedules</h5>
								<a href="candidates.html" class="btn btn-light btn-md mb-2">View All</a>
							</div>
							<div class="card-body">
								<div class="bg-light p-3 br-5 mb-4">
									<span class="badge badge-secondary badge-xs mb-1">UI/ UX Designer</span>
									<h6 class="mb-2 text-truncate">Interview Candidates - UI/UX Designer</h6>
									<div class="d-flex align-items-center flex-wrap">
										<p class="fs-13 mb-1 me-2"><i class="ti ti-calendar-event me-2"></i>Thu, 15 Feb 2025</p>
										<p class="fs-13 mb-1"><i class="ti ti-clock-hour-11 me-2"></i>01:00 PM - 02:20 PM</p>
									</div>
									<div class="d-flex align-items-center justify-content-between border-top mt-2 pt-3">
										<div class="avatar-list-stacked avatar-group-sm">
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/users/user-49.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/users/user-13.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/users/user-11.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/users/user-22.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/users/user-58.jpg" alt="img">
											</span>
											<a class="avatar bg-primary avatar-rounded text-fixed-white fs-10 fw-medium" href="javascript:void(0);">
												+3
											</a>
										</div>
										<a href="#" class="btn btn-primary btn-xs">Join Meeting</a>
									</div>
								</div>
								<div class="bg-light p-3 br-5 mb-0">
									<span class="badge badge-dark badge-xs mb-1">IOS Developer</span>
									<h6 class="mb-2 text-truncate">Interview Candidates - IOS Developer</h6>
									<div class="d-flex align-items-center flex-wrap">
										<p class="fs-13 mb-1 me-2"><i class="ti ti-calendar-event me-2"></i>Thu, 15 Feb 2025</p>
										<p class="fs-13 mb-1"><i class="ti ti-clock-hour-11 me-2"></i>02:00 PM - 04:20 PM</p>
									</div>
									<div class="d-flex align-items-center justify-content-between border-top mt-2 pt-3">
										<div class="avatar-list-stacked avatar-group-sm">
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/users/user-49.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/users/user-13.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/users/user-11.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/users/user-22.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/users/user-58.jpg" alt="img">
											</span>
											<a class="avatar bg-primary avatar-rounded text-fixed-white fs-10 fw-medium" href="javascript:void(0);">
												+3
											</a>
										</div>
										<a href="#" class="btn btn-primary btn-xs">Join Meeting</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Schedules -->

					<!-- Recent Activities -->
					<div class="col-xxl-4 col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Recent Activities</h5>
								<a href="activity.html" class="btn btn-light btn-md mb-2">View All</a>
							</div>
							<div class="card-body">
								<div class="recent-item">
									<div class="d-flex justify-content-between">
										<div class="d-flex align-items-center w-100">
											<a href="javscript:void(0);" class="avatar  flex-shrink-0">
												<img src="assets/img/users/user-38.jpg" class="rounded-circle" alt="img">
											</a>
											<div class="ms-2 flex-fill">
												<div class="d-flex align-items-center justify-content-between">
													<h6 class="fs-medium text-truncate"><a href="javscript:void(0);">Matt Morgan</a></h6>
													<p class="fs-13">05:30 PM</p>
												</div>
												<p class="fs-13">Added New Project <span class="text-primary">HRMS Dashboard</span></p>
											</div>
										</div>
									</div>
								</div>
								<div class="recent-item">
									<div class="d-flex justify-content-between">
										<div class="d-flex align-items-center w-100">
											<a href="javscript:void(0);" class="avatar  flex-shrink-0">
												<img src="assets/img/users/user-01.jpg" class="rounded-circle" alt="img">
											</a>
											<div class="ms-2 flex-fill">
												<div class="d-flex align-items-center justify-content-between">
													<h6 class="fs-medium text-truncate"><a href="javscript:void(0);">Jay Ze</a></h6>
													<p class="fs-13">05:00 PM</p>
												</div>
												<p class="fs-13">Commented on Uploaded Document</p>
											</div>
										</div>
									</div>
								</div>
								<div class="recent-item">
									<div class="d-flex justify-content-between">
										<div class="d-flex align-items-center w-100">
											<a href="javscript:void(0);" class="avatar  flex-shrink-0">
												<img src="assets/img/users/user-19.jpg" class="rounded-circle" alt="img">
											</a>
											<div class="ms-2 flex-fill">
												<div class="d-flex align-items-center justify-content-between">
													<h6 class="fs-medium text-truncate"><a href="javscript:void(0);">Mary Donald</a></h6>
													<p class="fs-13">05:30 PM</p>
												</div>
												<p class="fs-13">Approved Task Projects</p>
											</div>
										</div>
									</div>
								</div>
								<div class="recent-item">
									<div class="d-flex justify-content-between">
										<div class="d-flex align-items-center w-100">
											<a href="javscript:void(0);" class="avatar  flex-shrink-0">
												<img src="assets/img/users/user-11.jpg" class="rounded-circle" alt="img">
											</a>
											<div class="ms-2 flex-fill">
												<div class="d-flex align-items-center justify-content-between">
													<h6 class="fs-medium text-truncate"><a href="javscript:void(0);">George David</a></h6>
													<p class="fs-13">06:00 PM</p>
												</div>
												<p class="fs-13">Requesting Access to Module Tickets</p>
											</div>
										</div>
									</div>
								</div>
								<div class="recent-item">
									<div class="d-flex justify-content-between">
										<div class="d-flex align-items-center w-100">
											<a href="javscript:void(0);" class="avatar  flex-shrink-0">
												<img src="assets/img/users/user-20.jpg" class="rounded-circle" alt="img">
											</a>
											<div class="ms-2 flex-fill">
												<div class="d-flex align-items-center justify-content-between">
													<h6 class="fs-medium text-truncate"><a href="javscript:void(0);">Aaron Zeen</a></h6>
													<p class="fs-13">06:30 PM</p>
												</div>
												<p class="fs-13">Downloaded App Reportss</p>
											</div>
										</div>
									</div>
								</div>
								<div class="recent-item">
									<div class="d-flex justify-content-between">
										<div class="d-flex align-items-center w-100">
											<a href="javscript:void(0);" class="avatar  flex-shrink-0">
												<img src="assets/img/users/user-08.jpg" class="rounded-circle" alt="img">
											</a>
											<div class="ms-2 flex-fill">
												<div class="d-flex align-items-center justify-content-between">
													<h6 class="fs-medium text-truncate"><a href="javscript:void(0);">Hendry Daniel</a></h6>
													<p class="fs-13">05:30 PM</p>
												</div>
												<p class="fs-13">Completed New Project <span>HMS</span></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Recent Activities -->

					<!-- Birthdays -->
					<div class="col-xxl-4 col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Birthdays</h5>
								<a href="javascript:void(0);" class="btn btn-light btn-md mb-2">View All</a>
							</div>
							<div class="card-body pb-1">
								<h6 class="mb-2">Today</h6>
								<div class="bg-light p-2 border border-dashed rounded-top mb-3">
									<div class="d-flex align-items-center justify-content-between">
										<div class="d-flex align-items-center">
											<a href="javascript:void(0);" class="avatar">
												<img src="assets/img/users/user-38.jpg" class="rounded-circle" alt="img">
											</a>
											<div class="ms-2 overflow-hidden">
												<h6 class="fs-medium ">Andrew Jermia</h6>
												<p class="fs-13">IOS Developer</p>
											</div>
										</div>
										<a href="javascript:void(0);" class="btn btn-secondary btn-xs"><i class="ti ti-cake me-1"></i>Send</a>
									</div>
								</div>
								<h6 class="mb-2">Tomorow</h6>
								<div class="bg-light p-2 border border-dashed rounded-top mb-3">
									<div class="d-flex align-items-center justify-content-between">
										<div class="d-flex align-items-center">
											<a href="javascript:void(0);" class="avatar">
												<img src="assets/img/users/user-10.jpg" class="rounded-circle" alt="img">
											</a>
											<div class="ms-2 overflow-hidden">
												<h6 class="fs-medium"><a href="javascript:void(0);">Mary Zeen</a></h6>
												<p class="fs-13">UI/UX Designer</p>
											</div>
										</div>
										<a href="javascript:void(0);" class="btn btn-secondary btn-xs"><i class="ti ti-cake me-1"></i>Send</a>
									</div>
								</div>
								<div class="bg-light p-2 border border-dashed rounded-top mb-3">
									<div class="d-flex align-items-center justify-content-between">
										<div class="d-flex align-items-center">
											<a href="javascript:void(0);" class="avatar">
												<img src="assets/img/users/user-09.jpg" class="rounded-circle" alt="img">
											</a>
											<div class="ms-2 overflow-hidden">
												<h6 class="fs-medium "><a href="javascript:void(0);">Antony Lewis</a></h6>
												<p class="fs-13">Android Developer</p>
											</div>
										</div>
										<a href="javascript:void(0);" class="btn btn-secondary btn-xs"><i class="ti ti-cake me-1"></i>Send</a>
									</div>
								</div>
								<h6 class="mb-2">25 Jan 2025</h6>
								<div class="bg-light p-2 border border-dashed rounded-top mb-3">
									<div class="d-flex align-items-center justify-content-between">
										<div class="d-flex align-items-center">
											<span class="avatar">
												<img src="assets/img/users/user-12.jpg" class="rounded-circle" alt="img">
											</span>
											<div class="ms-2 overflow-hidden">
												<h6 class="fs-medium ">Doglas Martini</h6>
												<p class="fs-13">.Net Developer</p>
											</div>
										</div>
										<a href="javascript:void(0);" class="btn btn-secondary btn-xs"><i class="ti ti-cake me-1"></i>Send</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Birthdays -->

				</div>

			</div>

			<div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
				<p class="mb-0">2014 - 2025 &copy; SmartHR.</p>
				<p>Designed &amp; Developed By <a href="javascript:void(0);" class="text-primary">Dreams</a></p>
			</div>

		</div>
		<!-- /Page Wrapper -->

		<!-- Add Todo -->
		<div class="modal fade" id="add_todo">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add New Todo</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<form action="index.html">
						<div class="modal-body">
							<div class="row">
								<div class="col-12">
									<div class="mb-3">
										<label class="form-label">Todo Title</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-6">
									<div class="mb-3">
										<label class="form-label">Tag</label>
										<select class="select">
											<option>Select</option>
											<option>Internal</option>
											<option>Projects</option>
											<option>Meetings</option>
											<option>Reminder</option> 	 
										</select>
									</div>
								</div>
								<div class="col-6">
									<div class="mb-3">
										<label class="form-label">Priority</label>
										<select class="select">
											<option>Select</option>
											<option>Medium</option>
											<option>High</option>
											<option>Low</option>
										</select>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label">Descriptions</label>
										<div class="summernote"></div>
									</div>
								</div>
								<div class="col-12">
									<div class="mb-3">
										<label class="form-label">Add Assignee</label>
										<select class="select">
											<option>Select</option>
											<option>Sophie</option>
											<option>Cameron</option>
											<option>Doris</option>
											<option>Rufana</option>
										</select>
									</div>
								</div>
								<div class="col-12">
									<div class="mb-0">
										<label class="form-label">Status</label>
										<select class="select">
											<option>Select</option>
											<option>Completed</option>
											<option>Pending</option>
											<option>Onhold</option>
											<option>Inprogress</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Add New Todo</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Add Todo -->

		<!-- Add Project -->
		<div class="modal fade" id="add_project" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header header-border align-items-center justify-content-between">
						<div class="d-flex align-items-center">
							<h5 class="modal-title me-2">Add Project </h5>
							<p class="text-dark">Project ID : PRO-0004</p>
						</div>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<div class="add-info-fieldset">
						<div class="add-details-wizard p-3 pb-0">
							<ul class="progress-bar-wizard d-flex align-items-center border-bottom">
								<li class="active p-2 pt-0">
									<h6 class="fw-medium">Basic Information</h6>
								</li>
								<li class="p-2 pt-0">									
									<h6 class="fw-medium">Members</h6>
								</li>
							</ul>
						</div>
						<fieldset id="first-field-file">
							<form action="projects.html">
								<div class="modal-body">
									<div class="row">
										<div class="col-md-12">
											<div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">                                                
												<div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
													<i class="ti ti-photo text-gray-2 fs-16"></i>
												</div>                                              
												<div class="profile-upload">
													<div class="mb-2">
														<h6 class="mb-1">Upload Project Logo</h6>
														<p class="fs-12">Image should be below 4 mb</p>
													</div>
													<div class="profile-uploader d-flex align-items-center">
														<div class="drag-upload-btn btn btn-sm btn-primary me-2">
															Upload
															<input type="file" class="form-control image-sign" multiple="">
														</div>
														<a href="javascript:void(0);" class="btn btn-light btn-sm">Cancel</a>
													</div>
													
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label class="form-label">Project Name</label>
												<input type="text" class="form-control">
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label class="form-label">Client</label>
												<select class="select">
													<option>Select</option>
													<option>Anthony Lewis</option>
													<option>Brian Villalobos</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">Start Date</label>
														<div class="input-icon-end position-relative">
															<input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy" value="02-05-2024">
															<span class="input-icon-addon">
																<i class="ti ti-calendar text-gray-7"></i>
															</span>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">End Date</label>
														<div class="input-icon-end position-relative">
															<input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy" value="02-05-2024">
															<span class="input-icon-addon">
																<i class="ti ti-calendar text-gray-7"></i>
															</span>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">Priority</label>
														<select class="select">
															<option>Select</option>
															<option>High</option>
															<option>Medium</option>
															<option>Low</option>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">Project Value</label>
														<input type="text" class="form-control" value="$">
													</div>
												</div>
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">Total Working Hours</label>
														<div class="input-icon-end position-relative">
															<input type="text" class="form-control timepicker" placeholder="-- : -- : --" value="02-05-2024">
															<span class="input-icon-addon">
																<i class="ti ti-clock-hour-3 text-gray-7"></i>
															</span>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">Extra Time</label>
														<input type="text" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-0">
												<label class="form-label">Description</label>
												<div class="summernote"></div>
											</div>
										</div>
									</div>								
								</div>
								<div class="modal-footer">
									<div class="d-flex align-items-center justify-content-end">
										<button type="button" class="btn btn-outline-light border me-2" data-bs-dismiss="modal">Cancel</button>
										<button class="btn btn-primary wizard-next-btn" type="button">Add Team Member</button>
									</div>
								</div>
							</form>
						</fieldset>
						<fieldset>
							<form action="projects.html">
								<div class="modal-body">
									<div class="row">
										<div class="col-md-12">
											<div class="mb-3">
												<label class="form-label me-2">Team Members</label>
												<input class="input-tags form-control" placeholder="Add new" type="text" data-role="tagsinput"  name="Label" value="Jerald,Andrew,Philip,Davis">
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label class="form-label me-2">Team Leader</label>
												<input class="input-tags form-control" placeholder="Add new" type="text" data-role="tagsinput"  name="Label" value="Hendry,James">
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label class="form-label me-2">Project Manager</label>
												<input class="input-tags form-control" placeholder="Add new" type="text" data-role="tagsinput"  name="Label" value="Dwight">
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label class="form-label">Status</label>
												<select class="select">
													<option>Select</option>
													<option>Active</option>
													<option>Inactive</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div>
												<label class="form-label">Tags</label>
												<select class="select">
													<option>Select</option>
													<option>High</option>
													<option>Low</option>
													<option>Medium</option>
												</select>
											</div>
										</div>
									</div>								
								</div>
								<div class="modal-footer">
									<div class="d-flex align-items-center justify-content-end">
										<button type="button" class="btn btn-outline-light border me-2" data-bs-dismiss="modal">Cancel</button>
										<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#success_modal">Save</button>
									</div>
								</div>
							</form>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
		<!-- /Add Project -->

		<!-- Add Leaves -->
		<div class="modal fade" id="add_leaves">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add Leave Request</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<form action="index.html">
						<div class="modal-body pb-0">
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">Employee Name</label>
										<select class="select">
											<option>Select</option>
											<option>Anthony Lewis</option>
											<option>Brian Villalobos</option>
											<option>Harvey Smith</option>
										</select>
									</div>	
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">Leave Type</label>
										<select class="select">
											<option>Select</option>
											<option>Medical Leave</option>
											<option>Casual Leave</option>
											<option>Annual Leave</option>
										</select>
									</div>	
								</div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">From </label>
                                        <div class="input-icon-end position-relative">
                                            <input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                            <span class="input-icon-addon">
                                                <i class="ti ti-calendar text-gray-7"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">To </label>
                                        <div class="input-icon-end position-relative">
                                            <input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                            <span class="input-icon-addon">
                                                <i class="ti ti-calendar text-gray-7"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>   
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">No of Days</label>
										<input type="text" class="form-control" disabled>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Remaining Days</label>
										<input type="text" class="form-control" disabled>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">Reason</label>
										<textarea class="form-control" rows="3"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Add Leaves</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Add Leaves -->
    
@endsection