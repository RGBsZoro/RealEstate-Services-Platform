@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
@endphp

<style>
    /* تأثير النبض للجرس في حال وجود إشعارات */
    .bell-shake { animation: bell-ring 2s infinite; }
    @keyframes bell-ring {
        0%, 100% { transform: rotate(0); }
        10%, 30%, 50%, 70%, 90% { transform: rotate(10deg); }
        20%, 40%, 60%, 80% { transform: rotate(-10deg); }
    }
    
    .unread-dot {
        width: 8px;
        height: 8px;
        background-color: #ff3e1d;
        border-radius: 50%;
        display: inline-block;
        margin-left: 5px;
    }

    .notification-item {
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .notification-item:hover {
        background-color: #f8f9fa !important;
        border-left-color: #696cff;
    }

    .notification-item.unread {
        background-color: rgba(105, 108, 255, 0.05);
    }
</style>

@if(isset($navbarFull))
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
    <a href="{{url('/')}}" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">@include('_partials.macros')</span>
        <span class="app-brand-text demo menu-text fw-bold text-heading">{{config('variables.templateName')}}</span>
    </a>
</div>
@endif

@if(!isset($navbarHideToggle))
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="icon-base bx bx-menu icon-md"></i>
    </a>
</div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="icon-base bx bx-search icon-md text-muted"></i>
            <input type="text" class="form-control border-0 shadow-none ps-2" placeholder="Search (Ctrl+/)" aria-label="Search...">
        </div>
    </div>

    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3">
            <a class="nav-link dropdown-toggle hide-arrow position-relative p-2" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <i class="bx bx-bell {{ (isset($unreadNotificationsCount) && $unreadNotificationsCount > 0) ? 'bell-shake' : '' }}" style="font-size: 1.6rem;"></i>
                @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                    <span class="badge bg-danger badge-dot badge-notifications position-absolute top-0 start-100 translate-middle mt-2 ms-n2 border border-2 border-white"></span>
                @endif
            </a>
            
            <ul class="dropdown-menu dropdown-menu-end py-0 shadow-lg border-0" style="width: 360px;">
                <li class="dropdown-menu-header border-bottom">
                    <div class="dropdown-header d-flex align-items-center py-3">
                        <h6 class="text-body mb-0 me-auto fw-bold">Notifications</h6>
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                            <span class="badge bg-label-primary fs-tiny me-2">{{ $unreadNotificationsCount }} New</span>
                        @endif
                        <form action="{{ route('notifications.readAll') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-icon btn-sm btn-label-secondary" data-bs-toggle="tooltip" title="Mark all as read">
                                <i class="bx bx-envelope-open"></i>
                            </button>
                        </form>
                    </div>
                </li>
                
                <li class="dropdown-notifications-list scrollable-container">
                    <ul class="list-group list-group-flush">
                        @forelse($latestNotifications ?? [] as $notification)
                            <li class="list-group-item list-group-item-action notification-item p-3 {{ $notification->read_at ? '' : 'unread' }}">
                                <a href="{{ route('notifications.readAndRedirect', $notification->id) }}" class="d-flex text-decoration-none">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-md">
                                            <span class="avatar-initial rounded-circle {{ $notification->read_at ? 'bg-label-secondary' : 'bg-label-primary' }}">
                                                <i class="bx {{ $notification->data['icon'] ?? 'bx-bell' }}"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-0 small fw-bold text-dark">{{ $notification->data['title'] ?? 'System Update' }}</h6>
                                            @if(!$notification->read_at) <span class="unread-dot"></span> @endif
                                        </div>
                                        <p class="mb-1 text-muted small lh-sm">{{ Str::limit($notification->data['body'] ?? '', 60) }}</p>
                                        <small class="text-muted d-block mt-1">
                                            <i class="bx bx-time-five me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item text-center p-5">
                                <div class="avatar avatar-xl bg-label-secondary mb-3 mx-auto">
                                    <span class="avatar-initial rounded-circle"><i class="bx bx-bell-off fs-1"></i></span>
                                </div>
                                <h6 class="text-muted">No notifications yet</h6>
                                <small class="text-light">We'll let you know when something happens</small>
                            </li>
                        @endforelse
                    </ul>
                </li>
                
                <li class="dropdown-menu-footer border-top">
                    <a href="{{ route('notifications.index') }}" class="dropdown-item d-flex justify-content-center p-3 text-primary fw-semibold">
                        View all activity
                        <i class="bx bx-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online avatar-md">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="rounded-circle border border-2 border-primary p-1">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                <li>
                    <a class="dropdown-item py-3" href="javascript:void(0);">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online avatar-md">
                                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="rounded-circle">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">{{ Auth::user()->name ?? 'Administrator' }}</h6>
                                <small class="text-muted">System Manager</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li><div class="dropdown-divider my-1"></div></li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i> <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i> <span>Settings</span>
                    </a>
                </li>
                <li><div class="dropdown-divider my-1"></div></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bx bx-power-off me-2"></i> <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div>