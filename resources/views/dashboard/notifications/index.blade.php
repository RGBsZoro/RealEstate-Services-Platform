@extends('layouts.contentNavbarLayout')

@section('title', __('notifications.center_title'))

<style>
    /* تحسين شكل العناصر غير المقروءة مع مراعاة الاتجاه */
    .notification-card {
        transition: all 0.3s ease;
        border-inline-start: 4px solid transparent; /* دعم تلقائي للـ RTL/LTR */
        margin-bottom: 2px;
    }
    
    .notification-card.unread {
        background-color: rgba(105, 108, 255, 0.04);
        border-inline-start-color: #696cff;
    }

    .notification-card:hover {
        background-color: #fcfcfd !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        z-index: 1;
    }

    .unread-indicator {
        width: 10px;
        height: 10px;
        background: #696cff;
        border-radius: 50%;
        display: inline-block;
    }

    .btn-delete-hover:hover i {
        color: #ff3e1d !important;
    }
</style>

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">{{ __('notifications.breadcrumb_dashboard') }} /</span> {{ __('notifications.breadcrumb_notifications') }}
            </h4>
            <p class="text-muted mb-0 small">{{ __('notifications.manage_alerts_desc') }}</p>
        </div>
        
        <div class="d-flex gap-2">
            @if(auth('web')->user()->unreadNotifications()->count() > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-label-primary">
                    <i class="bx bx-check-double me-1"></i> {{ __('notifications.mark_all_read') }}
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills gap-2 p-1 bg-label-secondary rounded-3 d-inline-flex">
                <li class="nav-item">
                    <a class="nav-link {{ request()->query('filter') !== 'unread' ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                        <i class="bx bx-list-ul me-1"></i> {{ __('notifications.filter_all') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->query('filter') === 'unread' ? 'active' : '' }}" href="{{ route('notifications.index', ['filter' => 'unread']) }}">
                        <i class="bx bx-envelope me-1"></i> {{ __('notifications.filter_unread') }}
                        @if(auth('web')->user()->unreadNotifications()->count() > 0)
                            <span class="badge badge-center rounded-pill bg-danger ms-1" style="width: 18px; height: 18px; font-size: 10px;">
                                {{ auth('web')->user()->unreadNotifications()->count() }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="card-title mb-0">{{ __('notifications.recent_activity') }}</h5>
        </div>

        <div class="list-group list-group-flush">
            @forelse($notifications as $notification)
                @php
                    $data = is_array($notification->data) ? $notification->data : json_decode($notification->data, true);
                    
                    // محرك الترجمة الديناميكي
                    $title = isset($data['title_key']) ? __($data['title_key']) : ($data['title'] ?? __('notifications.system_notice'));
                    $bodyArgs = $data['body_args'] ?? [];
                    $body = isset($data['body_key']) ? __($data['body_key'], $bodyArgs) : ($data['body'] ?? '');
                @endphp
                <div class="list-group-item notification-card p-4 {{ $notification->read_at ? '' : 'unread' }}">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-4">
                            <div class="avatar avatar-md">
                                <span class="avatar-initial rounded-circle {{ $notification->read_at ? 'bg-label-secondary' : 'bg-label-primary' }}">
                                    <i class="bx {{ $data['icon'] ?? 'bx-bell' }} fs-4"></i>
                                </span>
                            </div>
                        </div>

                        <div class="flex-grow-1">
                            <a href="{{ route('notifications.readAndRedirect', $notification->id) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="mb-0 me-2 {{ $notification->read_at ? 'text-secondary' : 'fw-bold text-dark' }}">
                                        {{ $title }}
                                    </h6>
                                    @if(!$notification->read_at)
                                        <span class="unread-indicator"></span>
                                    @endif
                                </div>
                                <p class="mb-2 text-muted lh-base">
                                    {{ $body }}
                                </p>
                                <div class="d-flex align-items-center gap-3">
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="bx bx-calendar-alt me-1"></i> {{ $notification->created_at->translatedFormat('M d, Y') }}
                                    </small>
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="bx bx-time-five me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </a>
                        </div>

                        <div class="flex-shrink-0 ms-3 d-flex flex-column align-items-center gap-2">
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('{{ __('notifications.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-icon btn-outline-label-secondary btn-sm border-0 btn-delete-hover" title="{{ __('notifications.delete') }}">
                                    <i class="bx bx-trash fs-5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card-body p-5 text-center">
                    <div class="avatar avatar-xl bg-label-secondary mb-4 mx-auto" style="width: 100px; height: 100px;">
                        <span class="avatar-initial rounded-circle"><i class="bx bx-bell-off fs-1"></i></span>
                    </div>
                    <h5 class="text-dark fw-bold">{{ __('notifications.empty_state_title') }}</h5>
                    <p class="text-muted mx-auto" style="max-width: 300px;">
                        {{ __('notifications.empty_state_desc') }}
                    </p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3">{{ __('notifications.go_to_dashboard') }}</a>
                </div>
            @endforelse
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 px-2">
        <small class="text-muted">
            {{ __('notifications.pagination_showing') }} {{ $notifications->firstItem() ?? 0 }} 
            {{ __('notifications.pagination_to') }} {{ $notifications->lastItem() ?? 0 }} 
            {{ __('notifications.pagination_of') }} {{ $notifications->total() }}
        </small>
        <div class="pagination-wrapper">
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
@endsection