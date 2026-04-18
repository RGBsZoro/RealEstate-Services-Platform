@php
use Illuminate\Support\Facades\Route;
@endphp

<ul class="menu-sub">
  @if (isset($menu))
    @foreach ($menu as $submenu)

    {{-- 1. فحص الصلاحية للـ Submenu --}}
    @php
        $hasPermission = true;
        if (isset($submenu->permission)) {
            $hasPermission = auth()->user()->can($submenu->permission);
        }
    @endphp

    @if($hasPermission)
        {{-- active menu method --}}
        @php
          $activeClass = '';
          $currentRouteName = Route::currentRouteName() ?? '';

          // المنطق الجديد: الابن يأخذ كلاس active فقط وليس active open (إلا لو كان هو نفسه لديه أبناء)
          if (is_array($submenu->slug)) {
              foreach($submenu->slug as $slug){
                  if (str_starts_with($currentRouteName, $slug)) {
                      $activeClass = isset($submenu->submenu) ? 'active open' : 'active';
                      break;
                  }
              }
          } else {
              if (str_starts_with($currentRouteName, $submenu->slug)) {
                  $activeClass = isset($submenu->submenu) ? 'active open' : 'active';
              }
          }
        @endphp

        <li class="menu-item {{$activeClass}}">
            <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}" class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
              @if (isset($submenu->icon))
              <i class="{{ $submenu->icon }}"></i>
              @endif
              <div>
                  @php
                      $translationKey = 'sidebar.' . $submenu->name;
                      $translatedName = __($translationKey);
                  @endphp
                  
                  {{ $translatedName !== $translationKey ? $translatedName : $submenu->name }}
              </div>
              @isset($submenu->badge)
                <div class="badge rounded-pill bg-{{ $submenu->badge[0] }} text-uppercase ms-auto">{{ $submenu->badge[1] }}</div>
              @endisset
            </a>

            {{-- استدعاء ملف الـ submenu بشكل تكراري في حال وجود مستويات أعمق --}}
            @if (isset($submenu->submenu))
              @include('layouts.sections.menu.submenu',['menu' => $submenu->submenu])
            @endif
        </li>
    @endif

    @endforeach
  @endif
</ul>