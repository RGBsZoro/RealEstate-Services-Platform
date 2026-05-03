@extends('layouts/contentNavbarLayout')

@section('title', __('sliders.title'))

@section('content')

{{-- إحصائيات السلايدر --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4 bg-label-primary">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold">{{ __('sliders.total_reports') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['total'] }}</h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2"><i class="bx bx-images fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4 bg-label-success">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold">{{ __('sliders.live_now') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['live'] }}</h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2"><i class="bx bx-broadcast fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4 bg-label-danger">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold">{{ __('sliders.expired_reports') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['expired'] }}</h4>
                    </div>
                    <span class="badge bg-danger rounded-circle p-2"><i class="bx bx-time-five fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- الفلترة والبحث --}}
<div class="card mb-4 rounded-4 overflow-hidden shadow-sm">
    <div class="card-header border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <h5 class="mb-0 fw-bold">{{ __('sliders.management_card') }}</h5>
        <div class="d-flex flex-column flex-sm-row gap-3 w-100 w-md-auto">
            <form action="{{ route('sliders.index') }}" method="GET" class="d-flex gap-2 flex-grow-1">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('sliders.search_placeholder') }}">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">{{ __('sliders.all_statuses') }}</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('sliders.live_now') }}</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>{{ __('sliders.scheduled') }}</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ __('sliders.expired') }}</option>
                </select>
            </form>
            
            {{-- فحص صلاحية الإنشاء --}}
            @can('create-sliders')
            <a href="{{ route('sliders.create') }}" class="btn btn-primary text-nowrap">
                <i class="bx bx-plus me-1"></i> {{ __('sliders.add_new') }}
            </a>
            @endcan
        </div>
    </div>
</div>

{{-- عرض الكاردات --}}
<div class="row g-4">
    @forelse($sliders as $slider)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative hover-shadow-lg transition">
            <div class="position-absolute top-0 start-0 m-3 z-index-2">
                @php
                    // نوحد التاريخ للصيغة YYYY-MM-DD لتجنب أي مشاكل متعلقة بالساعات
                    $todayDate = now()->toDateString();
                    $startDate = $slider->start_date ? $slider->start_date->toDateString() : null;
                    $endDate   = $slider->end_date ? $slider->end_date->toDateString() : null;
                @endphp

                @if($endDate && $endDate < $todayDate)
                    <span class="badge bg-danger rounded-pill shadow-sm">{{ __('sliders.expired') }}</span>
                    
                @elseif($startDate && $startDate > $todayDate)
                    <span class="badge bg-warning rounded-pill shadow-sm">{{ __('sliders.scheduled') }}</span>
                    
                @elseif($slider->is_active)
                    <span class="badge bg-success rounded-pill shadow-sm">{{ __('sliders.active') }}</span>
                    
                @else
                    <span class="badge bg-secondary rounded-pill shadow-sm">{{ __('sliders.not_active') }}</span>
                @endif
            </div>

            <div class="card-img-wrapper" style="height: 200px; overflow: hidden;">
                <img class="card-img-top w-100 h-100" 
                     src="{{ $slider->getFirstMediaUrl('slider_images') ?: asset('assets/img/elements/18.jpg') }}" 
                     style="object-fit: cover;"
                     alt="{{ $slider->title }}">
            </div>
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title text-primary fw-bold mb-0 text-truncate" style="max-width: 80%;">
                        {{ $slider->title ?: __('sliders.no_title')}}
                    </h5>
                    
                    {{-- فحص صلاحية التعديل لتغيير الحالة --}}
                    @can('edit-sliders')
                    <div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox" 
                               data-id="{{ $slider->id }}" {{ $slider->is_active ? 'checked' : '' }}>
                    </div>
                    @endcan
                </div>
                <p class="card-text text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 38px;">
                    {{ $slider->description ?: __('sliders.no_description')}}
                </p>
                
                <div class="bg-light p-2 rounded-3 mb-3 d-flex justify-content-around text-center">
                    <div class="small">
                        <span class="d-block text-muted" style="font-size: 0.7rem;">{{ __('sliders.start_date') }}</span>
                        <span class="fw-bold">{{ $slider->start_date?->format('Y-m-d') ?? '---' }}</span>
                    </div>
                    <div class="vr mx-2"></div>
                    <div class="small">
                        <span class="d-block text-muted" style="font-size: 0.7rem;">{{ __('sliders.end_date') }}</span>
                        <span class="fw-bold">{{ $slider->end_date?->format('Y-m-d') ?? '---' }}</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="badge bg-label-secondary small px-2">
                        <i class="bx bx-link-alt me-1"></i>
                        @if($slider->sliderable_type)
                            {{ class_basename($slider->sliderable_type) == 'Category' ? __('sliders.category') : __('sliders.service') }}
                        @else
                            {{ __('sliders.no_link') }}
                        @endif
                    </span>

                    {{-- فحص صلاحيات التعديل أو الحذف لإظهار القائمة --}}
                    @if(auth()->user()->can('edit-sliders') || auth()->user()->can('delete-sliders'))
                    <div class="dropdown">
                        <button class="btn p-0" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded fs-4"></i></button>
                        <div class="dropdown-menu dropdown-menu-end">
                            @can('edit-sliders')
                            <a class="dropdown-item" href="{{ route('sliders.edit', $slider->id) }}">
                                <i class="bx bx-edit me-1 text-info"></i> {{ __('sliders.edit') }}
                            </a>
                            @endcan

                            @if(auth()->user()->can('edit-sliders') && auth()->user()->can('delete-sliders'))
                                <div class="dropdown-divider"></div>
                            @endif

                            @can('delete-sliders')
                            <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" class="d-inline delete-form">
                                @csrf @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bx bx-trash me-1"></i> {{ __('sliders.delete') }}
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="mb-3">
            <i class="bx bx-image-add text-muted" style="font-size: 5rem;"></i>
        </div>
        <h5 class="text-muted">{{ __('sliders.no_results') }}</h5>
        
        @can('create-sliders')
        <a href="{{ route('sliders.create') }}" class="btn btn-primary mt-2">
            {{ __('sliders.add_new') }}
        </a>
        @endcan
    </div>
    @endforelse
</div>

{{-- الباجينيشن --}}
<div class="card shadow-sm border-0 rounded-4 overflow-hidden mt-4">
    @if($sliders->total() > 0)
    <div class="card-footer bg-white border-0 d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small">
            {{ __('sliders.showing_count', [
                'first' => $sliders->firstItem() ?? 0,
                'last' => $sliders->lastItem() ?? 0,
                'total' => $sliders->total()
            ]) }}
        </div>
        <div class="pagination-wrapper mt-3 mt-md-0">
            {{ $sliders->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>

@endsection

@section('page-script')
<script>
    window.onload = function() {
        if (window.jQuery) {
            $(function() {
                // تحديث الحالة AJAX (فقط إذا كان للمستخدم صلاحية التعديل، والـ HTML يضمن ذلك بعدم وجود الـ Checkbox أصلاً)
                $(document).on('change', '.status-toggle', function() {
                    const checkbox = $(this);
                    const id = checkbox.data('id');
                    const isActive = checkbox.is(':checked');
                    const url = "{{ url('sliders') }}/" + id + "/toggle-status";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}' },
                    });
                });

                // تأكيد الحذف
                $(document).on('submit', '.delete-form', function(e) {
                    if(!confirm("{{ __('sliders.confirm_delete') }}")) {
                        e.preventDefault();
                    }
                });
            });
        }
    };
</script>

<style>
    .hover-shadow-lg:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .transition {
        transition: all 0.3s ease-in-out;
    }
</style>
@endsection