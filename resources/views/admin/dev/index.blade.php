@extends('admin.layouts.app')

@section('title', 'Developer Tools')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('admin.partials.breadcrumb', [
                'title' => 'Developer Tools',
                'breadcrumbs' => [
                    ['title' => 'Internal', 'url' => '#'],
                    ['title' => 'Dev Tools']
                ]
            ])
            @endcomponent
            <!-- Warning Banner -->
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Internal Tool:</strong> This page is only accessible in development/local environment. Use with
                caution.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-lightning-fill me-2"></i>Quick Sync Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-3 flex-wrap">
                                <button type="button" class="btn btn-success" onclick="syncAll()">
                                    <i class="bi bi-arrow-repeat me-2"></i>Sync All (Pages + Actions)
                                </button>
                                <button type="button" class="btn btn-info" onclick="syncPages()">
                                    <i class="bi bi-file-earmark-text me-2"></i>Sync Pages Only
                                </button>
                                <button type="button" class="btn btn-info" onclick="syncActions()">
                                    <i class="bi bi-gear me-2"></i>Sync Actions Only
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="refreshState()">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Refresh State
                                </button>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Syncs PageEnum and ActionEnum cases to the database. Safe to run multiple times
                                    (uses updateOrCreate).
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current State Overview -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-database me-2"></i>Database Pages</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dbPagesTable">
                                        @forelse($pages as $page)
                                            <tr>
                                                <td>
                                                    <strong>{{ $page->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $page->route_pattern }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $page->actions_count }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted">No pages in database</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-code-square me-2"></i>PageEnum Cases</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Label</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($enumPages as $page)
                                            <tr>
                                                <td><strong>{{ $page->label() }}</strong></td>
                                                <td><code class="small">{{ $page->value }}</code></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-code-square me-2"></i>ActionEnum Cases</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Label</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($enumActions as $action)
                                            <tr>
                                                <td>
                                                    <strong>{{ $action->label() }}</strong>
                                                    <br>
                                                    <code class="small">{{ $action->value }}</code>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $action->isGlobal() ? 'bg-success' : 'bg-info' }}">
                                                        {{ $action->category() }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sync Results -->
            <div class="row mt-4" id="syncResultsContainer" style="display: none;">
                <div class="col-12">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="bi bi-check-circle me-2"></i>Sync Results</h6>
                        </div>
                        <div class="card-body">
                            <pre id="syncResults" class="mb-0" style="max-height: 400px; overflow-y: auto;"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('admin.partials.toastAndModal')

@endsection

@push('scripts')
    <script>
        function syncAll() {
            if (!confirm('This will sync all PageEnum and ActionEnum cases to the database. Continue?')) {
                return;
            }

            showLoading('Syncing all...');

            fetch('{{ route('dev.sync-all') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        showSyncResults(data);
                        showToast('success', data.message);
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        showToast('error', data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    showToast('error', 'An error occurred: ' + error.message);
                });
        }

        function syncPages() {
            if (!confirm('This will sync all PageEnum cases to the database. Continue?')) {
                return;
            }

            showLoading('Syncing pages...');

            fetch('{{ route('dev.sync-pages') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        showSyncResults(data);
                        showToast('success', data.message);
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        showToast('error', data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    showToast('error', 'An error occurred: ' + error.message);
                });
        }

        function syncActions() {
            if (!confirm('This will sync all ActionEnum cases to the database. Continue?')) {
                return;
            }

            showLoading('Syncing actions...');

            fetch('{{ route('dev.sync-actions') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        showSyncResults(data);
                        showToast('success', data.message);
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        showToast('error', data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    showToast('error', 'An error occurred: ' + error.message);
                });
        }

        function refreshState() {
            showLoading('Refreshing...');
            window.location.reload();
        }

        function showSyncResults(data) {
            const container = document.getElementById('syncResultsContainer');
            const results = document.getElementById('syncResults');

            results.textContent = JSON.stringify(data, null, 2);
            container.style.display = 'block';

            // Scroll to results
            container.scrollIntoView({ behavior: 'smooth' });
        }

        function showLoading(message = 'Processing...') {
            // You can implement a loading spinner here
            console.log(message);
        }

        function hideLoading() {
            // Hide loading spinner
            console.log('Loading complete');
        }
    </script>
@endpush