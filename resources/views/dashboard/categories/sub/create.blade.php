@extends('layouts/contentNavbarLayout')

@section('title', __('categories.add_sub'))

@section('page-style')
<style>
    .input-group-merge[dir="rtl"] .form-control { border-left: 0; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 15px; }
    .input-group-merge[dir="rtl"] .input-group-text { border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                <h5 class="mb-0">{{ __('categories.add_sub') }}</h5>
            </div>
            <div class="card-body pt-5">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- توجيه المستخدم بعد الحفظ إلى جدول الفئات الفرعية --}}
                    <input type="hidden" name="return_url" value="{{ route('categories.sub.index') }}">
                    
                    {{-- اختيار الفئة الأساسية (Parent Category Selection) --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="parent_id">{{ __('categories.column_parent') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-layer"></i></span>
                                <select name="parent_id" id="parent_id" class="form-select @error('parent_id') is-invalid @enderror" required>
                                    <option value="">{{ __('categories.choose_main') }}</option>
                                    @foreach($mainCategories as $main)
                                        <option value="{{ $main->id }}" {{ old('parent_id') == $main->id ? 'selected' : '' }}>
                                            {{ $main->getTranslation('name', app()->getLocale()) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('parent_id') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Name EN --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_en">{{ __('categories.sub_name_en') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-subdirectory-right"></i></span>
                                <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" 
                                    id="name_en" placeholder="e.g. For Rent" value="{{ old('name.en') }}" required />
                            </div>
                            @error('name.en') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Name AR --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_ar">{{ __('categories.sub_name_ar') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="name[ar]" id="name_ar" 
                                    class="form-control @error('name.ar') is-invalid @enderror" 
                                    placeholder="مثلاً: للإيجار" value="{{ old('name.ar') }}" required />
                                <span class="input-group-text"><i class="bx bx-edit"></i></span>
                            </div>
                            @error('name.ar') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Icon --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="category_icon">{{ __('categories.icon_label') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="file" name="icon" class="form-control @error('icon') is-invalid @enderror" id="category_icon" accept="image/*" />
                            </div>
                            <small class="text-muted">{{ __('categories.icon_help') }}</small>
                            @error('icon') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Status Switch --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="isActive">{{ __('categories.status_label') }}</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="isActive" name="isActive" value="1" checked>
                                <label class="form-check-label" for="isActive">{{ __('categories.active_help') }}</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-check-circle me-1"></i> {{ __('categories.save_category') }}
                            </button>
                            <a href="{{ route('categories.sub.index') }}" class="btn btn-outline-secondary btn-lg ms-2">
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