@extends('layouts/contentNavbarLayout')

@section('title', __('categories.sub_title'))

@section('content')

{{-- الإحصائيات الملونة --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: #dbdee0">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold">{{ __('categories.total_sub') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['total'] }}</h4>
                    </div>
                    <span class="badge bg-info rounded-circle p-2"><i class="bx bx-subdirectory-right fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: #dbdee0">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold">{{ __('categories.active_sub') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['active'] }}</h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2"><i class="bx bx-check-double fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: #dbdee0">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold">{{ __('categories.inactive_sub') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['inactive'] }}</h4>
                    </div>
                    <span class="badge bg-secondary rounded-circle p-2"><i class="bx bx-hide fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- جدول البيانات مع الفلترة --}}
<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title mb-0">{{ __('categories.sub_title') }}</h5>
            <a href="{{ route('categories.sub.create') }}" class="btn btn-primary rounded-pill">
                <i class="bx bx-plus me-1"></i> {{ __('categories.add_sub') }}
            </a>
        </div>

        <form action="{{ route('categories.sub.index') }}" method="GET" id="sub-categories-filter-form">
            <div class="row g-3">
                {{-- حقل البحث يستحوذ على نصف مساحة السطر كاملاً --}}
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" id="search-sub-category-input" value="{{ request('search') }}" class="form-control" placeholder="{{ __('categories.search_placeholder') }}" autocomplete="off">
                    </div>
                </div>
                {{-- قائمة الأقسام الأب تأخذ الربع --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <select name="parent_id" class="form-select immediate-sub-select">
                        <option value="">{{ __('categories.all_parents') }}</option>
                        @foreach($mainCategories as $main)
                            <option value="{{ $main->id }}" {{ request('parent_id') == $main->id ? 'selected' : '' }}>
                                {{ $main->getTranslation('name', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- قائمة الحالة تأخذ الربع المتبقي ليقفل السطر تماماً --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <select name="status" class="form-select immediate-sub-select">
                        <option value="">{{ __('categories.all_statuses') }}</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>{{ __('categories.active_only') }}</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>{{ __('categories.inactive_only') }}</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase small fw-bold">
                <tr>
                    <th style="width: 30%">{{ __('categories.column_sub') }}</th>
                    <th>{{ __('categories.column_parent') }}</th>
                    <th>{{ __('categories.column_fields') }}</th>
                    <th>{{ __('categories.status_label') }}</th>
                    <th>{{ __('categories.th_date') }}</th>
                    @if(auth()->user()->can('edit-categories') || auth()->user()->can('delete-categories') || auth()->user()->can('view-dynamic-fields'))
                        <th class="text-center">{{ __('categories.th_actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($category->getFirstMediaUrl('Categories'))
                                <img src="{{ $category->getFirstMediaUrl('Categories') }}" alt="icon" width="38" height="38" class="rounded-circle me-3 border" style="object-fit: cover;">
                            @else
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-subdirectory-right fs-4"></i></span>
                                </div>
                            @endif
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-heading">{{ $category->getTranslation('name', 'en') }}</span>
                                <small class="text-muted small">{{ $category->getTranslation('name', 'ar') }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-label-primary rounded-pill">
                            <i class="bx bx-layer me-1"></i> {{ $category->parent->getTranslation('name', app()->getLocale()) ?? 'N/A' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-label-info rounded-pill">
                            <i class="bx bx-list-check me-1"></i> {{ __('categories.fields_count', ['count' => $category->dynamic_fields_count]) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $category->isActive ? 'bg-label-success' : 'bg-label-danger' }} rounded-pill">
                            {{ $category->isActive ? __('categories.status_active') : __('categories.status_inactive') }}
                        </span>
                    </td>
                    <td><span class="text-muted small">{{ $category->created_at->format('M d, Y') }}</span></td>

                    @if(auth()->user()->can('edit-categories') || auth()->user()->can('delete-categories') || auth()->user()->can('view-dynamic-fields'))
                    <td class="text-center">
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded fs-4"></i></button>
                            <div class="dropdown-menu dropdown-menu-end">
                                @can('view-dynamic-fields')
                                    <a class="dropdown-item" href="{{ route('categories.fields.index', $category->id) }}"><i class="bx bx-cog me-2 text-info"></i> {{ __('categories.manage_fields') }}</a>
                                @endcan
                                @can('edit-categories')
                                    <a class="dropdown-item" href="{{ route('categories.edit', $category->id) }}"><i class="bx bx-edit-alt me-2"></i> {{ __('categories.edit') }}</a>
                                @endcan
                                @can('delete-categories')
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="delete-sub-category-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="bx bx-trash me-2"></i> {{ __('categories.delete') }}</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bx bx-search-alt-2 display-6 mb-2"></i>
                        <p>{{ __('categories.no_sub_found') }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages() || $categories->total() > 0)
    <div class="card-footer border-top d-flex align-items-center justify-content-between py-3">
        <span class="text-muted small">
            {{ __('categories.showing_count', ['first' => $categories->firstItem() ?? 0, 'last' => $categories->lastItem() ?? 0, 'total' => $categories->total()]) }}
        </span>
        <div>
            {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                const $form = $('#sub-categories-filter-form');
                let searchSubCategoriesTimeout;

                // 1. الفلترة الفورية بمجرد تغيير خيارات الـ Select
                $(document).on('change', '.immediate-sub-select', function() {
                    $form.submit();
                });

                // 2. البحث التلقائي الفوري أثناء الكتابة بخاصية الـ Debounce (500ms)
                $(document).on('input', '#search-sub-category-input', function() {
                    clearTimeout(searchSubCategoriesTimeout);
                    
                    searchSubCategoriesTimeout = setTimeout(function() {
                        $form.submit();
                    }, 500);
                });

                // 3. تأكيد الحذف
                $(document).on('submit', '.delete-sub-category-form', function(e) {
                    if(!confirm("{{ __('categories.confirm_delete') }}")) {
                        e.preventDefault();
                    }
                });
            });
        }
    };
</script>
@endsection