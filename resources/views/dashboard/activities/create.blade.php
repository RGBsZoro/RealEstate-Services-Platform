@extends('layouts/contentNavbarLayout')

@section('title', __('activities.add_title'))

@section('page-style')
<style>
    /* تحسين توافقية المدخلات مع الاتجاهات */
    .input-group-merge[dir="rtl"] .form-control { border-left: 0; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 15px; }
    .input-group-merge[dir="rtl"] .input-group-text { border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ __('activities.add_title') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- حقل الاسم بالإنكليزية --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_en">{{ __('activities.label_name_en') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" 
                                    id="name_en" placeholder="{{ __('activities.placeholder_en') }}" value="{{ old('name.en') }}" required />
                            </div>
                            @error('name.en') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- حقل الاسم بالعربية --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_ar">{{ __('activities.label_name_ar') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="name[ar]" id="name_ar" 
                                    class="form-control @error('name.ar') is-invalid @enderror" 
                                    placeholder="{{ __('activities.placeholder_ar') }}" value="{{ old('name.ar') }}" required />
                                <span class="input-group-text"><i class="bx bx-edit"></i></span>
                            </div>
                            @error('name.ar') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- رفع الصورة --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="activity_image">{{ __('activities.label_image') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="activity_image" accept="image/*" />
                            </div>
                            <small class="text-muted">{{ __('activities.image_help') }}</small>
                            @error('image') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- حالة التفعيل --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="is_active">{{ __('activities.label_status') }}</label>
                        <div class="col-sm-10 d-flex align-items-center">
                            <div class="form-check form-switch mb-0">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">{{ __('activities.status_active') }}</label>
                            </div>
                            @error('is_active') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-check-circle me-1"></i> {{ __('activities.save_button') }}
                            </button>
                            <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary btn-lg ms-2">
                                {{ __('activities.cancel_button') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection