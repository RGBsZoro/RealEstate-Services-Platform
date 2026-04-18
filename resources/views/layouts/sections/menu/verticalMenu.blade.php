@php
use Illuminate\Support\Facades\Route;
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{url('/')}}" class="app-brand-link">
            <span class="app-brand-logo demo">@include('_partials.macros')</span>
            <span class="app-brand-text demo menu-text fw-bold ms-2" style="font-size: 1.8rem; white-space: nowrap;">{{ __('sidebar.app_name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="icon-base bx bx-chevron-left icon-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)

            {{-- فحص الصلاحية قبل عرض العنصر --}}
            @php
                $hasPermission = true;
                if (isset($menu->permission)) {
                    $hasPermission = auth()->user()->can($menu->permission);
                }
            @endphp

            @if ($hasPermission)
                {{-- menu headers --}}
                @if (isset($menu->menuHeader))
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">{{ __('sidebar.' . $menu->menuHeader) }}</span>
                    </li>
                @else

                    {{-- active menu method --}}
                    @php
                    $activeClass = '';
                    $currentRouteName = Route::currentRouteName() ?? '';

                    // المنطق الجديد: نتحقق إذا كان الراوت الحالي يبدأ بالـ slug
                    // هذا يضمن أن الراوتات مثل admins.index أو admins.create ستفعل التبويبة الرئيسية admins
                    if (is_array($menu->slug)) {
                        foreach($menu->slug as $slug){
                            if (str_starts_with($currentRouteName, $slug)) {
                                $activeClass = isset($menu->submenu) ? 'active open' : 'active';
                                break;
                            }
                        }
                    } else {
                        if (str_starts_with($currentRouteName, $menu->slug)) {
                            $activeClass = isset($menu->submenu) ? 'active open' : 'active';
                        }
                    }
                    @endphp

                    {{-- main menu --}}
                    <li class="menu-item {{$activeClass}}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}">
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            
                            <div>{{ isset($menu->name) ? __('sidebar.' . $menu->name) : '' }}</div>
                            
                            @isset($menu->badge)
                                <div class="badge rounded-pill bg-{{ $menu->badge[0] }} text-uppercase ms-auto">{{ $menu->badge[1] }}</div>
                            @endisset
                        </a>
                        
                        {{-- submenu --}}
                        @isset($menu->submenu)
                            @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
                        @endisset
                    </li>
                @endif
            @endif
        @endforeach
    </ul>

</aside>