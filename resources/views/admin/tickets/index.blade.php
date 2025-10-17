@extends('admin.layouts.app')

@section('title', 'Ticket Management')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Tickets</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Support</li>
                        <li class="breadcrumb-item active" aria-current="page">Tickets</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <div class="mb-2">
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-circle-plus me-2"></i>Create Ticket
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex-fill">
                                    <div class="border border-dashed border-primary rounded-circle d-inline-flex align-items-center justify-content-center p-1 mb-3">
                                        <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                            <i class="ti ti-ticket fs-20"></i>
                                        </span>
                                    </div>
                                    <p class="fw-medium fs-12 mb-1">New Tickets</p>
                                    <h4>{{ $tickets->total() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex-fill">
                                    <div class="border border-dashed border-purple rounded-circle d-inline-flex align-items-center justify-content-center p-1 mb-3">
                                        <span class="avatar avatar-lg avatar-rounded bg-transparent-purple">
                                            <i class="ti ti-folder-open fs-20"></i>
                                        </span>
                                    </div>
                                    <p class="fw-medium fs-12 mb-1">Open Tickets</p>
                                    <h4>{{ $tickets->where('status', 'open')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex-fill">
                                    <div class="border border-dashed border-success rounded-circle d-inline-flex align-items-center justify-content-center p-1 mb-3">
                                        <span class="avatar avatar-lg avatar-rounded bg-success-transparent">
                                            <i class="ti ti-checks fs-20"></i>
                                        </span>
                                    </div>
                                    <p class="fw-medium fs-12 mb-1">Solved Tickets</p>
                                    <h4>{{ $tickets->where('status', 'resolved')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex-fill">
                                    <div class="border border-dashed border-info rounded-circle d-inline-flex align-items-center justify-content-center p-1 mb-3">
                                        <span class="avatar avatar-lg avatar-rounded bg-info-transparent">
                                            <i class="ti ti-progress-alert fs-20"></i>
                                        </span>
                                    </div>
                                    <p class="fw-medium fs-12 mb-1">Pending Tickets</p>
                                    <h4>{{ $tickets->where('status', 'in_progress')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5>Ticket List</h5>
                    <div class="d-flex align-items-center flex-wrap row-gap-3">
                        <form method="GET" action="{{ route('admin.tickets.index') }}" class="d-flex align-items-center flex-wrap row-gap-3">
                            <div class="dropdown me-2">
                                <select name="priority" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="">Priority</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </div>
                            <div class="dropdown me-2">
                                <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="">Select Status</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <div class="dropdown">
                                <select name="category" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets Grid -->
        <div class="row">
            <div class="col-xl-9 col-md-8">
                @if($tickets->count() > 0)
                    @foreach($tickets as $ticket)
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <h5 class="text-info fw-medium">{{ $ticket->category->name }}</h5>
                            <div class="d-flex align-items-center">
                                @if($ticket->priority === 'low')
                                    <span class="badge badge-success d-inline-flex align-items-center">
                                        <i class="ti ti-circle-filled fs-5 me-1"></i>Low
                                    </span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="badge badge-warning d-inline-flex align-items-center">
                                        <i class="ti ti-circle-filled fs-5 me-1"></i>Medium
                                    </span>
                                @elseif($ticket->priority === 'high')
                                    <span class="badge badge-orange d-inline-flex align-items-center">
                                        <i class="ti ti-circle-filled fs-5 me-1"></i>High
                                    </span>
                                @else
                                    <span class="badge badge-danger d-inline-flex align-items-center">
                                        <i class="ti ti-circle-filled fs-5 me-1"></i>Urgent
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <span class="badge badge-info rounded-pill mb-2">{{ $ticket->ticket_number }}</span>
                                <div class="d-flex align-items-center mb-2">
                                    <h5 class="fw-semibold me-2">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}">{{ $ticket->subject }}</a>
                                    </h5>
                                    @if($ticket->status === 'open')
                                        <span class="badge bg-outline-pink d-flex align-items-center ms-1">
                                            <i class="ti ti-circle-filled fs-5 me-1"></i>Open
                                        </span>
                                    @elseif($ticket->status === 'in_progress')
                                        <span class="badge bg-outline-warning d-flex align-items-center ms-1">
                                            <i class="ti ti-circle-filled fs-5 me-1"></i>In Progress
                                        </span>
                                    @elseif($ticket->status === 'resolved')
                                        <span class="badge bg-outline-purple d-flex align-items-center ms-1">
                                            <i class="ti ti-circle-filled fs-5 me-1"></i>Resolved
                                        </span>
                                    @else
                                        <span class="badge bg-outline-secondary d-flex align-items-center ms-1">
                                            <i class="ti ti-circle-filled fs-5 me-1"></i>Closed
                                        </span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center flex-wrap row-gap-2">
                                    @if($ticket->assignedTo)
                                    <p class="d-flex align-items-center mb-0 me-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->assignedTo->name) }}&size=32&background=667eea&color=fff" 
                                             class="avatar avatar-xs rounded-circle me-2" 
                                             alt="{{ $ticket->assignedTo->name }}">
                                        Assigned to <span class="text-dark ms-1">{{ $ticket->assignedTo->name }}</span>
                                    </p>
                                    @else
                                    <p class="d-flex align-items-center mb-0 me-2">
                                        <i class="ti ti-user-x me-1"></i>Unassigned
                                    </p>
                                    @endif
                                    <p class="d-flex align-items-center mb-0 me-2">
                                        <i class="ti ti-calendar-bolt me-1"></i>Updated {{ $ticket->updated_at->diffForHumans() }}
                                    </p>
                                    <p class="d-flex align-items-center mb-0">
                                        <i class="ti ti-message-share me-1"></i>{{ $ticket->replies->count() }} Comments
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="text-center mb-4">
                        @if($tickets->hasMorePages())
                            <a href="{{ $tickets->nextPageUrl() }}" class="btn btn-primary">
                                <i class="ti ti-loader-3 me-1"></i>Load More
                            </a>
                        @endif
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="ti ti-inbox fs-1 text-muted mb-3"></i>
                            <h3>No Tickets Found</h3>
                            <p class="text-muted">
                                @if(request()->hasAny(['search', 'status', 'priority', 'category']))
                                    No tickets match your current filters.
                                @else
                                    There are no support tickets yet.
                                @endif
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-xl-3 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Ticket Categories</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            @foreach($categories as $category)
                            <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                                <a href="{{ route('admin.tickets.index', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-xs bg-dark rounded-circle">
                                        {{ $category->tickets->count() }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
