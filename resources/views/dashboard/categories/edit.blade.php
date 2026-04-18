@extends('layouts/contentNavbarLayout')

{{-- العنوان يظهر اسم الفئة المترجم في التاب الخاص بالمتصفح --}}
@section('title', __('categories.edit_title') . ' - ' . $category->getTranslation('name', app()->getLocale()))

@section('page-style')
<style>
    .input-group-merge[dir="rtl"] .form-control { border-left: 0; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 15px; }
    .input-group-merge[dir="rtl"] .input-group-text { border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; }
    .current-icon-preview { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; padding: 5px; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                {{-- تحديد العنوان بناءً على نوع الفئة --}}
                <h5 class="mb-0">
                    {{ $category->parent_id ? __('categories.edit_sub') : __('categories.edit_main') }}
                </h5>
                <small class="text-muted float-end">
                    {{ __('categories.last_updated') }} {{ $category->updated_at->diffForHumans() }}
                </small>
            </div>
            <div class="card-body pt-5">
                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- اختيار الفئة الأب: يظهر فقط للفئات الفرعية --}}
                    @if($category->parent_id)
                        <input type="hidden" name="return_url" value="{{ route('categories.sub.index') }}">
                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label" for="parent_id">{{ __('categories.main_category_select') }}</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-layer"></i></span>
                                    <select name="parent_id" id="parent_id" class="form-select @error('parent_id') is-invalid @enderror" required>
                                        @foreach($mainCategories as $main)
                                            <option value="{{ $main->id }}" {{ (old('parent_id', $category->parent_id) == $main->id) ? 'selected' : '' }}>
                                                {{ $main->getTranslation('name', app()->getLocale()) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('parent_id') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="return_url" value="{{ route('categories.main.index') }}">
                    @endif

                    {{-- Name EN --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_en">{{ __('categories.name_en') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-edit"></i></span>
                                <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" 
                                    id="name_en" value="{{ old('name.en', $category->getTranslation('name', 'en')) }}" required />
                            </div>
                            @error('name.en') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Name AR --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_ar">{{ __('categories.name_ar') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="name[ar]" id="name_ar" 
                                    class="form-control @error('name.ar') is-invalid @enderror" 
                                    value="{{ old('name.ar', $category->getTranslation('name', 'ar')) }}" required />
                                <span class="input-group-text"><i class="bx bx-edit"></i></span>
                            </div>
                            @error('name.ar') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Icon & Preview --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">{{ __('categories.icon_label') }}</label>
                        <div class="col-sm-10">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                @if($category->getFirstMediaUrl('Categories'))
                                    <img src="{{ $category->getFirstMediaUrl('Categories') }}" alt="current-icon" class="current-icon-preview" id="uploadedAvatar">
                                @else
                                    <div class="current-icon-preview d-flex align-items-center justify-content-center bg-label-secondary">
                                        <i class="bx bx-image-alt fs-2"></i>
                                    </div>
                                @endif
                                
                                <div class="button-wrapper">
                                    <input type="file" name="icon" class="form-control @error('icon') is-invalid @enderror" id="category_icon" accept="image/*" />
                                    <div class="text-muted small mt-2">{{ __('categories.allowed_types') }}</div>
                                    @error('icon') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Switch --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="isActive">{{ __('categories.status_label') }}</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="isActive" name="isActive" value="1" {{ old('isActive', $category->isActive) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">{{ __('categories.active_help') }}</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-save me-1"></i> {{ __('categories.update_category') }}
                            </button>
                            {{-- العودة الذكية --}}
                            <a href="{{ $category->parent_id ? route('categories.sub.index') : route('categories.main.index') }}" class="btn btn-outline-secondary btn-lg ms-2">
                                {{ __('categories.cancel') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection