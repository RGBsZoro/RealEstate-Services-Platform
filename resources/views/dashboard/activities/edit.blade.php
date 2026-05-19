@extends('layouts/contentNavbarLayout')

{{-- العنوان يظهر اسم النشاط باللغة الحالية للمتصفح --}}
@section('title', __('activities.edit_title') . ' - ' . $activity->getTranslation('name', app()->getLocale()))

@section('page-style')
<style>
    /* تنسيق الحقول لتدعم الـ RTL في العربي */
    .input-group-merge[dir="rtl"] .form-control { border-left: 0; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 15px; }
    .input-group-merge[dir="rtl"] .input-group-text { border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; }
    
    /* تنسيق معاينة الصورة */
    .current-image-preview { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; padding: 5px; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                <h5 class="mb-0">{{ __('activities.edit_title') }}</h5>
                {{-- diffForHumans سيتم تعريبها تلقائياً لأننا ضبطنا الـ Locale في المشروع --}}
                <small class="text-muted float-end">{{ __('activities.last_updated') }}: {{ $activity->updated_at->diffForHumans() }}</small>
            </div>
            
            <div class="card-body pt-5">
                <form action="{{ route('activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    {{-- Activity Name (EN) --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_en">{{ __('activities.label_name_en') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" 
                                    id="name_en" value="{{ old('name.en', $activity->getTranslation('name', 'en')) }}" required />
                            </div>
                            @error('name.en') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Activity Name (AR) --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_ar">{{ __('activities.label_name_ar') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="name[ar]" id="name_ar" 
                                    class="form-control @error('name.ar') is-invalid @enderror" 
                                    value="{{ old('name.ar', $activity->getTranslation('name', 'ar')) }}" required />
                                <span class="input-group-text"><i class="bx bx-edit"></i></span>
                            </div>
                            @error('name.ar') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Activity Image & Preview --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">{{ __('activities.label_image') }}</label>
                        <div class="col-sm-10">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                @if($activity->hasMedia('Activities'))
                                    <img src="{{ $activity->getFirstMediaUrl('Activities') }}" alt="current-image" class="current-image-preview" id="uploadedAvatar">
                                @else
                                    <div class="current-image-preview d-flex align-items-center justify-content-center bg-label-secondary">
                                        <i class="bx bx-image-alt fs-2"></i>
                                    </div>
                                @endif
                                
                                <div class="button-wrapper">
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="activity_image" accept="image/*" />
                                    <div class="text-muted small mt-2">{{ __('activities.image_constraints') }}</div>
                                    @error('image') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Activation Status --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="is_active">{{ __('activities.label_status') }}</label>
                        <div class="col-sm-10 d-flex align-items-center">
                            <div class="form-check form-switch mb-0">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $activity->is_active) == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">{{ __('activities.status_active') }}</label>
                            </div>
                            @error('is_active') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-6">
                    
                    {{-- Buttons --}}
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-save me-1"></i> {{ __('activities.update_button') }}
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