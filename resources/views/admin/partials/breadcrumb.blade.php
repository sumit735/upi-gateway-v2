<!-- Breadcrumb Component -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
    <div class="my-auto mb-2">
        <h2 class="mb-1">{{ $title ?? 'Page Title' }}</h2>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}"><i class="ti ti-smart-home"></i></a>
                </li>
                @isset($breadcrumbs)
                    @foreach($breadcrumbs as $breadcrumb)
                        @if($loop->last)
                            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                        @else
                            <li class="breadcrumb-item">
                                @if(isset($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                @else
                                    {{ $breadcrumb['title'] }}
                                @endif
                            </li>
                        @endif
                    @endforeach
                @endisset
            </ol>
        </nav>
    </div>
    
    @if(trim($slot) !== '')
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
            {{ $slot }}
        </div>
    @endif
</div>
<!-- /Breadcrumb -->
